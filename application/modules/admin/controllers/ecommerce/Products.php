<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Products_model', 'Languages_model', 'Categories_model', 'Vendor_model'));
        $this->load->library("excel");
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Products_model->deleteProduct($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'product is deleted!');
            $this->saveHistory('Delete product id - ' . $_GET['delete']);
            redirect('admin/products');
        }

        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for product title - ' . $search_title);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
            $this->saveHistory('Search for product code - ' . $category);
        }
        $vendor = null;
        if ($this->input->get('show_vendor') !== NULL) {
            $vendor = $this->input->get('show_vendor');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Products_model->productsCount($search_title, $category, $vendor);
        $data['products'] = $this->Products_model->getproducts($this->num_rows, $page, $search_title, $orderby, $category, $vendor);
        $data['links_pagination'] = pagination('admin/products', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Products_model->numShopproducts();
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories(null, null, 2);
		$data['vendor_list'] = $this->Vendor_model->getVendorUsers();
		
        $this->saveHistory('Go to products');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/products', $data);
        $this->load->view('_parts/footer');
    }

    public function getProductInfo($id, $noLoginCheck = false)
    {
        /* 
         * if method is called from public(template) page
         */
        if ($noLoginCheck == false) {
            $this->login_check();
        }
        return $this->Products_model->getOneProduct($id);
    }

    /*
     * called from ajax
     */

    public function productStatusChange()
    {
        $this->login_check();
        $result = $this->Products_model->productStatusChange($_POST['id'], $_POST['to_status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change product id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }
    function productSync(){
        $t = $_POST['value'];       
        $product_info = $this->Products_model->getNotSyncProduct($t);
        // echo "<pre>";
        // print_r($product_info);
        // exit;
        $token = $this->Public_model->getUnicommerceToken();
        foreach ($product_info as $value) {
            $category = explode(',', $value['shop_categorie']);
            // echo "<pre>";
            // print_r($category);
            // exit;
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://palsonsderma.unicommerce.com/services/rest/v1/catalog/itemType/createOrEdit',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
               "itemType": {
                  "categoryCode": "DEFAULT",
                  "skuCode": "'.$value['sku'].'",
                  "name": "'.$value['title'].'",
                  "type": "SIMPLE",
                  "minOrderSize": 1,
                  "basePrice": '.$value['price'].',
                  "costPrice": '.$value['price'].',
                  "maxRetailPrice": '.$value['price'].',
                  "imageUrl": "'.base_url('/attachments/shop_images/' .$value['folder'].'/'.$value['image']).'",
                  "productPageUrl": "'.$value['url'].'",
                  "componentItemTypes": [
                     {
                        "itemSku": "'.$value['sku'].'",
                        "quantity": '.$value['productQuantity'].',
                        "price": '.$value['price'].'
                     }
                   ]
               }
            }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token['access_token'],
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($ch);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
                //echo $response;
                $result = $this->Products_model->updateProductTable($value['id']);
            }
        }
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        //print_r($result);
    }

    public function products_bulk_upload(){
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About us';
        $head['description'] = '!';
        $head['keywords'] = '';
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/products_bulk_upload', $data);
        $this->load->view('_parts/footer');
    }

    public function importProductData() {
        $path = $_FILES["file"]["tmp_name"];
        $spreadsheet = PHPExcel_IOFactory::load($path);

        $spreadsheet->getActiveSheet()->setTitle(pathinfo($path, PATHINFO_BASENAME));
        $loadedSheetNames = $spreadsheet->getSheetNames();
        foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
            $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
            // print_r($spreadsheet);die;
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, false, false, true);
            foreach ($sheetData as $key => $value) {
                if($key==1){
                    continue;
                }
                if($value['A'] == '' || $value['B'] == '' || $value['C'] == '' || $value['D'] == '' || $value['F'] == '' || $value['Q'] == '' || $value['R'] == '' || $value['Y'] == '' || $value['Z'] == '' || $value['AA'] == ''){
                    $this->session->set_userdata('unsuccessfully', 'Please fill all mandatory fields');
                    redirect("admin/products_bulk_upload");
                    //exit;
                }
                // else if($value['S'] == '' && $value['T'] == '' && $value['V'] == '' && $value['W'] == '' ){
                //     $this->session->set_userdata('unsuccessfully', 'Please fill all mandatory fields');
                //     redirect("admin/products_bulk_upload");
                // }
                else{
                $cArray = array();
                $category = explode(",", $value['C']);
                foreach ($category as $categorys) {
                    $list = $this->Products_model->findCategory($categorys);
                    array_push($cArray, $list['id']);
                }
                $category_implode = implode(",", $cArray);
                // $tArray = array();
                // $tags= explode(",", $value['E']);
                // foreach ($tags as $tag) {
                //     $list = $this->Products_model->findTags($tag);
                //     array_push($tArray, $list['ingredientsID']);
                // }
                

                $tArray = array();
                $tags= explode(",", $value['E']);
                foreach ($tags as $tag) {
                    $list = $this->Products_model->findTags($tag);
                    array_push($tArray, $list['ingredientsID']);
                }
                $tag_implode = implode(",", $tArray);
                
                $exist = $this->Products_model->existSKU($value['A']);
                
                //print_r($exist); exit;
                if(!$exist){
                    if (preg_match('/\d/', $value['D'], $matches)) {
                        $index = strpos($value['D'], $matches[0]);
                        $product_title = substr($value['D'], 0, $index);
                        //echo "Resulting string: " . $result;
                    }
                    $insertArray = array(
                        'sku'  => $value['A'],
                        'folder'  => $value['A'],   
                        'image'  => $value['B'],
                        'shop_categorie'   => $category_implode,
                        //'product_title' => $product_title,
                        'product_title' => $value['D'],
                        'search_key' => except_search(strtolower($value['D'])),
                        // 'url'   => $value['D'], 
                        //'url' => except_letters($value['D']),
                        'tag'   => $tag_implode,
                        'product_type'   => $value['F'],
                        'is_trending_product'   => $value['G'],
                        'related_products'   => $value['H'],
                        'frequently_bought'   => $value['I'],
                        'is_featured_products'   => $value['J'],
                        'what_is_it'   => $value['K'], 
                        'why_do_you_ned_it'   => $value['L'],
                        'how_dose_it_help'   => $value['M'],
                        'when_to_use'   => $value['N'],                         
                        'where_to_apply'   => $value['O'],
                        'who_is_it_for'   => $value['P'],
                        'category_name' => $value['C'],
                        'tag_name' => $value['E'],
                        'hsn_code' => $value['AC'],
                        'is_best_seller' => $value['AD'],
                        'is_newly_launch' => $value['AE'],
                        'is_giftset' => $value['AF'],
                        'image_alt' => $value['AG'],
                        'product_video' => $value['AH'],
                        'time' => time(),
                        'time_update' => time()
                    );
                    // echo "<pre>";
                    // $data[] = $insertArray;
                    // print_r($insertArray);die;
                    $productID = $this->Products_model->insert_bulkProduct($insertArray);
                    $this->Products_model->update_UrlProduct($productID,except_product($value['D']));
                    $insertProductsTranslations = array(
                        'title'  => $value['D'],
                        'description'  => $value['Q'],   
                        'default_price'  => $value['R'],
                        'default_old_price'   => $value['R'],
                        'abbr' => "en",
                        'for_id'   => $productID
                    );
                    $ProductsTranslationsID = $this->Products_model->insert_ProductsTranslations($insertProductsTranslations);
                    $insertProductAttributes = array(
                        'product_id' => $productID,
                        'face'  => $value['S'],
                        'body'  => $value['T'],   
                        'lip'   => $value['U'],
                        'hair'  => $value['V'],
                        'kits'  => $value['W'],
                        'skin_concern'   => $value['X']
                        // 'face'  => preg_replace('/[ ,]+/', '-', strtolower($value['S'])),
                        // 'body'  => preg_replace('/[ ,]+/', '-', strtolower($value['T'])),   
                        // 'lip'   => preg_replace('/[ ,]+/', '-', strtolower($value['U'])),
                        // 'hair'  => preg_replace('/[ ,]+/', '-', strtolower($value['V'])),
                        // 'kits'  => preg_replace('/[ ,]+/', '-', strtolower($value['W'])),
                        // 'skin_concern'   => preg_replace('/[ ,]+/', '-', strtolower($value['X']))
                    );
                     $ProductsTranslationsID = $this->Products_model->insert_ProductAttributes($insertProductAttributes);

                     $insertProductsVariants = array(
                        'product_id' => $productID,
                        'quantity'  => $value['Y'],
                        'weight'  => $value['Z'],   
                        'weight_unit'  => $value['AA'],
                        'vendor_price' => $value['R'],
                        'price'   => $value['R'],
                        'old_price' => $value['R'],
                        'status'   => 'show'
                    );
                     $insertData[] = $insertProductsVariants;
                     $ProductsTranslationsID = $this->Products_model->insert_ProductVariants($insertProductsVariants);
                    
                }
                else{
                    if (preg_match('/\d/', $value['D'], $matches)) {
                        $index = strpos($value['D'], $matches[0]);
                        $product_title = substr($value['D'], 0, $index);
                        //echo "Resulting string: " . $result;
                    }
                    $updateArray = array(   
                        'image'  => $value['B'],
                        'shop_categorie'   => $category_implode,
                        //'product_title' => $product_title,
                        'product_title' => $value['D'],
                        'url' => except_product($value['D']).'-'.$exist['id'],
                        'search_key' => except_search(strtolower($value['D'])),
                        'tag'   => $tag_implode,
                        'product_type'   => $value['F'],
                        'is_trending_product'   => $value['G'],
                        'related_products'   => $value['H'],
                        'frequently_bought'   => $value['I'],
                        'is_featured_products'   => $value['J'],
                        'what_is_it'   => $value['K'], 
                        'why_do_you_ned_it'   => $value['L'],
                        'how_dose_it_help'   => $value['M'],
                        'when_to_use'   => $value['N'],                         
                        'where_to_apply'   => $value['O'],
                        'who_is_it_for'   => $value['P'],
                        'category_name' => $value['C'],
                        'tag_name' => $value['E'],
                        'hsn_code' => $value['AC'],
                        'is_best_seller' => $value['AD'],
                        'is_newly_launch' => $value['AE'],
                        'is_giftset' => $value['AF'],
                        'image_alt' => $value['AG'],
                        'product_video' => $value['AH'],
                        'time' => time(),
                        'time_update' => time()
                    );
                    // echo "<pre>";
                    // $data[] = $updateArray;
                    // print_r($updateArray);die;
                    $this->Products_model->update_bulkProduct($updateArray, $value['A']);

                    $updateProductsTranslations = array(
                        'title'  => $value['D'],
                        'description'  => $value['Q'],   
                        'default_price'  => $value['R'],
                        'default_old_price'   => $value['R']
                    );
                    $this->Products_model->update_ProductsTranslations($updateProductsTranslations, $exist['id']);

                     $updateProductAttributes = array(
                        'face'  => $value['S'],
                        'body'  => $value['T'],   
                        'lip'   => $value['U'],
                        'hair'  => $value['V'],
                        'kits'  => $value['W'],
                        'skin_concern'   => $value['X']
                        // 'face'  => preg_replace('/[ ,]+/', '-', strtolower($value['S'])),
                        // 'body'  => preg_replace('/[ ,]+/', '-', strtolower($value['T'])),   
                        // 'lip'   => preg_replace('/[ ,]+/', '-', strtolower($value['U'])),
                        // 'hair'  => preg_replace('/[ ,]+/', '-', strtolower($value['V'])),
                        // 'kits'  => preg_replace('/[ ,]+/', '-', strtolower($value['W'])),
                        // 'skin_concern'   => preg_replace('/[ ,]+/', '-', strtolower($value['X']))
                    );
                     $this->Products_model->update_ProductAttributes($updateProductAttributes,$exist['id']);

                     $updateProductsVariants = array(
                        'quantity'  => $value['Y'],
                        'weight'  => $value['Z'],   
                        'weight_unit'  => $value['AA'],
                        'vendor_price' => $value['R'],
                        'price'   => $value['R'],
                        'old_price' => $value['R']
                    );
                     $updateData[] = $updateProductsVariants;
                     $this->Products_model->update_ProductVariants($updateProductsVariants,$exist['id']);
                }
            }
        }
        if(count($insertData)>0){
            $this->session->set_userdata('successfully', 'Product Uploaded successfully.');
            redirect("admin/products_bulk_upload");    
        }else{
            $this->session->set_userdata('successfully', 'Product Uploaded successfully.');
            redirect("admin/products_bulk_upload"); 
        }
    }
    }
    public function shop_category_export()
    {
      $this->load->model("Products_model");
      $this->load->library("excel");
      $object = new PHPExcel();

      $object->setActiveSheetIndex(0);

      $table_columns = array("Shop Category");

      $column = 0;

      foreach($table_columns as $field)
      {
       $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
       $column++;
      }

      $employee_data = $this->Products_model->fetch_Shopcategory_export();

      $excel_row = 2;

      foreach($employee_data as $row)
      {
       
       $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->category_slug);
       
       $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      $filename = "Shop Category  ".date("Y-m-d").".xls";
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      $object_writer->save('php://output');
    }

    public function category_export()
    {
      $this->load->model("Products_model");
      $this->load->library("excel");
      $object = new PHPExcel();

      $object->setActiveSheetIndex(0);

      $table_columns = array("Category");

      $column = 0;

      foreach($table_columns as $field)
      {
       $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
       $column++;
      }

      $employee_data = $this->Products_model->fetch_category_export();
      // print_r($employee_data);
      // exit;
      $excel_row = 2;

      foreach($employee_data as $row)
      {
       
       $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->attribute_slug);
       
       $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      $filename = "Category  ".date("Y-m-d").".xls";
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      $object_writer->save('php://output');
    }


    public function product_export()
    {
      
      //$this->load->model("Products_model");
      $this->load->library("excel");
      $object = new PHPExcel();

      $object->setActiveSheetIndex(0);

      $table_columns = array("SKU","Image","Shop Categorie","Tags","Product Type","Related Products","Frequently Bought","Featured products","What Is It","Why Do You Need It","How Dose It Help","When To Use","Where To Apply","Who Is It For","Title","Description","Face","Body","Hair","Skin Concern","Quantity","Price","Weight","Weight Unit","HSN Code","Best Seller","Newly Launch","Giftset");

      $column = 0;

      foreach($table_columns as $field)
      {
       $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
       $column++;
      }

      $employee_data = $this->Products_model->fetch_product_export();
      // echo "<pre>";
      // print_r($employee_data);
      // exit;
      $excel_row = 2;

      foreach($employee_data as $row)
      {
       
       $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->sku);
       $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->image);
       $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->category_name);
       $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->tag_name);
       $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->product_type);

       $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->related_products);
       $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->frequently_bought);
       $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->is_featured_products);
      
       $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->what_is_it);

       $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->why_do_you_ned_it);
       $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->how_dose_it_help);
       $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->when_to_use);
       $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->where_to_apply);
       $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->who_is_it_for);

       $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->title);
       $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->description);
       $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $row->face);
       $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $row->body);
       $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $row->hair);

       $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $row->skin_concern);
       $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $row->product_quantity);
       $object->getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, $row->price);
       $object->getActiveSheet()->setCellValueByColumnAndRow(22, $excel_row, $row->weight);
       $object->getActiveSheet()->setCellValueByColumnAndRow(23, $excel_row, $row->weight_unit);

       $object->getActiveSheet()->setCellValueByColumnAndRow(24, $excel_row, $row->hsn_code);
       $object->getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row, $row->is_best_seller);
       $object->getActiveSheet()->setCellValueByColumnAndRow(26, $excel_row, $row->is_newly_launch);
       $object->getActiveSheet()->setCellValueByColumnAndRow(27, $excel_row, $row->is_giftset);
      
       
       $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      $filename = "Product  ".date("Y-m-d h:i:s a").".xls";
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      $object_writer->save('php://output');
    }

}
