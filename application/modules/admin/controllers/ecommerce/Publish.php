<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Publish extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Products_model',
            'Languages_model',
            'Brands_model',
            'Categories_model',
			'Vendor_model'
        ));
    }

    public function index($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
		$variants = array();
		$product_attribute = array();
        //$regimeProduct = array();
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Products_model->getOneProduct($id);
            $trans_load = $this->Products_model->getTranslations($id);
			$variants = $this->Products_model->getVariants($id);
			$product_attribute = $this->Products_model->getProductAttributes($id);            
            $regimeProduct = (explode(",", $_POST['regime_product']));
            $relatedProduct = (explode(",", $_POST['related_products']));
            $shopCategorie = (explode(",", $_POST['shop_categorie']));
            $frequentlyBought = (explode(",", $_POST['frequently_bought']));
            $tags = (explode(",", $_POST['tag']));
            $faces = (explode(",", $_POST['face']));
            $bodys = (explode(",", $_POST['body']));
            $hairs = (explode(",", $_POST['hair']));
            $skin_concerns = (explode(",", $_POST['skin_concern']));
             // print_r ($frequentlyBought);
             // exit;
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            // $regime_product = (implode(', ', $_POST['regime_product']));
            // print_r($regime_product); exit;
            //print_r($_POST); exit;
            
            $categoryName = array();
            $shop_categorie = $_POST['shop_categorie'];
            foreach ($shop_categorie as $categoriess) {
                $items = $this->Products_model->getCategoryName($categoriess);
                array_push($categoryName, $items['category_slug']);
            }
            $_POST['image'] = $this->uploadImage();
            //print_r($_POST); die();
            // if($_POST['good_to_images'] != ''){
            //      $_POST['good_to_images'] = $this->uploadGoogToKnow();
            // }
            $this->Products_model->setProduct($_POST, $id, $categoryName);
            

            $this->session->set_flashdata('result_publish', 'Product is published!');
            if ($id == 0) {
                $this->saveHistory('Success published product');
            } else {
                $this->saveHistory('Success updated product');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/products?' . $get));
            } else {
                redirect('admin/products');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
		$data['variants'] = $variants;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['brands'] = $this->Brands_model->getBrands();
        $data['otherImgs'] = $this->loadOthersImages();
        $data['plusImgs'] = $this->loadImages();
        $data['tagImgs'] = $this->loadTagImages();
		$data['attributes_set'] = $this->Products_model->getAllAttribute();
		$data['product_attribute'] = $product_attribute; 
        $data['regimeProduct'] = $regimeProduct;
        $data['relatedProduct'] = $relatedProduct;
        $data['shopCategorie'] = $shopCategorie; 
        $data['frequentlyBought'] = $frequentlyBought;
        $data['tags'] = $tags;
        $data['facas'] = $faces;
        $data['bodys'] = $bodys;
        $data['hairs'] = $hairs;
        $data['skin_concerns'] = $skin_concerns;
        $data['getRegimeProduct'] = $this->Products_model->getRegimeProduct();
		$data['vendors'] = $this->Vendor_model->getVendorUsers();
        $data['allProduct'] = $this->Products_model->getAllProducts();
        $data['getTags'] = $this->Products_model->getTags();
        $data['faca'] = $this->Products_model->getFace();
        $data['body'] = $this->Products_model->getBody();
        $data['hair'] = $this->Products_model->getHire();
        $data['skin_concern'] = $this->Products_model->getSkinConcern();
        // echo "<pre>";
        // print_r($data['shop_categories']); exit;	
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }

    public function uploadTagImages(){
        $ImageCount = count($_FILES['good_to_images']['name']);
            print_r($ImageCount); die();
    }
    private function uploadImage()
    {
        $config['upload_path'] = './attachments/shop_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	 public function update_status($id,$status)
    {
        $this->login_check();
        $this->Products_model->productStatusChange($id, $status);
        $this->session->set_flashdata('result_publish', 'Product status Updated!');
		redirect('admin/products');
    }

    /*
     * called from ajax
     */

    public function do_upload_others_images()
    {
        if ($this->input->is_ajax_request()) {
            $upath = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . $_POST['sku_no'] . DIRECTORY_SEPARATOR;
            if (!file_exists($upath)) {
                mkdir($upath, 0777);
            }

            $this->load->library('upload');

            $files = $_FILES;
            $cpt = count($_FILES['others']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                unset($_FILES);
                $_FILES['others']['name'] = $files['others']['name'][$i];
                $_FILES['others']['type'] = $files['others']['type'][$i];
                $_FILES['others']['tmp_name'] = $files['others']['tmp_name'][$i];
                $_FILES['others']['error'] = $files['others']['error'][$i];
                $_FILES['others']['size'] = $files['others']['size'][$i];

                $this->upload->initialize(array(
                    'upload_path' => $upath,
                    'allowed_types' => $this->allowed_img_types
                ));
                $this->upload->do_upload('others');
            }
        }
    }
    public function loadOthersImages()
    {
        $output = '';
        if (isset($_POST['folder']) && $_POST['folder'] != null) {
            $dir = 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    $i = 0;
                    while (($file = readdir($dh)) !== false) {
                        if (is_file($dir . $file)) {
                            $output .= '
                                <div class="other-img" id="image-container-' . $i . '">
                                    <img src="' . base_url('attachments/shop_images/' . $_POST['folder'] . '/' . $file) . '" style="width:100px; height: 100px;">
                                    <a href="javascript:void(0);" onclick="removeSecondaryProductImage(\'' . $file . '\', \'' . $_POST['folder'] . '\', ' . $i . ')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                               ';
                        }
                        $i++;
                    }
                    closedir($dh);
                }
            }
        }
        if ($this->input->is_ajax_request()) {
            echo $output;
        } else {
            return $output;
        }
    }
    public function aPlusContent_upload(){
        if ($this->input->is_ajax_request()) {
            
            $upath = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'plus_content_images' . DIRECTORY_SEPARATOR . $_POST['sku_nos'] . DIRECTORY_SEPARATOR;
            if (!file_exists($upath)) {
                mkdir($upath, 0777);
            }

            $this->load->library('upload');

            $files = $_FILES;
            $cpt = count($_FILES['others_more']['name']);
            //echo $cpt;
            for ($i = 0; $i < $cpt; $i++) {
                unset($_FILES);
                $_FILES['others_more']['name'] = $files['others_more']['name'][$i];
                $_FILES['others_more']['type'] = $files['others_more']['type'][$i];
                $_FILES['others_more']['tmp_name'] = $files['others_more']['tmp_name'][$i];
                $_FILES['others_more']['error'] = $files['others_more']['error'][$i];
                $_FILES['others_more']['size'] = $files['others_more']['size'][$i];

                $this->upload->initialize(array(
                    'upload_path' => $upath,
                    'allowed_types' => $this->allowed_img_types
                ));
                $this->upload->do_upload('others_more');
            }
        }
    }
    public function loadImages(){
       // $_POST['folders'];
    $output = '';
        if (isset($_POST['folder']) && $_POST['folder'] != null) {
            $dir = 'attachments' . DIRECTORY_SEPARATOR . 'plus_content_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    $i = 0;
                    while (($file = readdir($dh)) !== false) {
                        if (is_file($dir . $file)) {
                            $output .= '
                                <div class="other-img" id="image-container-plus-' . $i . '">
                                    <img src="' . base_url('attachments/plus_content_images/' . $_POST['folder'] . '/' . $file) . '" style="width:100px; height: 100px;">
                                    <a href="javascript:void(0);" onclick="removeaPlusImages(\'' . $file . '\', \'' . $_POST['folder'] . '\', ' . $i . ')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                               ';
                        }
                        $i++;
                    }
                    closedir($dh);
                }
            }
        }
        if ($this->input->is_ajax_request()) {
            echo $output;
        } else {
            return $output;
        }
    }
    public function tag_images_upload(){
        if ($this->input->is_ajax_request()) {
            
            $upath = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'tag_images' . DIRECTORY_SEPARATOR . $_POST['sku_tag'] . DIRECTORY_SEPARATOR;
            if (!file_exists($upath)) {
                mkdir($upath, 0777);
            }

            $this->load->library('upload');

            $files = $_FILES;
            $cpt = count($_FILES['tag_images']['name']);
            //echo $cpt;
            for ($i = 0; $i < $cpt; $i++) {
                unset($_FILES);
                $_FILES['tag_images']['name'] = $files['tag_images']['name'][$i];
                $_FILES['tag_images']['type'] = $files['tag_images']['type'][$i];
                $_FILES['tag_images']['tmp_name'] = $files['tag_images']['tmp_name'][$i];
                $_FILES['tag_images']['error'] = $files['tag_images']['error'][$i];
                $_FILES['tag_images']['size'] = $files['tag_images']['size'][$i];

                $this->upload->initialize(array(
                    'upload_path' => $upath,
                    'allowed_types' => $this->allowed_img_types
                ));
                $this->upload->do_upload('tag_images');
            }
        }
    }
    public function loadTagImages(){
    $output = '';
        if (isset($_POST['folder']) && $_POST['folder'] != null) {
            $dir = 'attachments' . DIRECTORY_SEPARATOR . 'tag_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    $i = 0;
                    while (($file = readdir($dh)) !== false) {
                        if (is_file($dir . $file)) {
                            $output .= '
                                <div class="other-img" id="image-container-tag-' . $i . '">
                                    <img src="' . base_url('attachments/tag_images/' . $_POST['folder'] . '/' . $file) . '" style="width:100px; height: 100px;">
                                    <a href="javascript:void(0);" onclick="removeTagImages(\'' . $file . '\', \'' . $_POST['folder'] . '\', ' . $i . ')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                               ';
                        }
                        $i++;
                    }
                    closedir($dh);
                }
            }
        }
        if ($this->input->is_ajax_request()) {
            echo $output;
        } else {
            return $output;
        }
    }
    /*
     * called from ajax
     */

    public function removeSecondaryImage()
    {
        if ($this->input->is_ajax_request()) {
            $img = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . '' . $_POST['folder'] . DIRECTORY_SEPARATOR . $_POST['image'];
            unlink($img);
        }
    }
    public function removeTagImages()
    {
        if ($this->input->is_ajax_request()) {
            $img = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'tag_images' . DIRECTORY_SEPARATOR . '' . $_POST['folder'] . DIRECTORY_SEPARATOR . $_POST['image'];
            unlink($img);
        }
    }
    public function removeaPlusImages()
    {
        if ($this->input->is_ajax_request()) {
            $img = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'plus_content_images' . DIRECTORY_SEPARATOR . '' . $_POST['folder'] . DIRECTORY_SEPARATOR . $_POST['image'];
            unlink($img);
        }
    }

}
