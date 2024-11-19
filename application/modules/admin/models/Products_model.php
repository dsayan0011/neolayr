<?php

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteProduct($id)
    {
        $this->db->trans_begin();
        $this->db->where('for_id', $id);
        if (!$this->db->delete('products_translations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('id', $id);
        if (!$this->db->delete('products')) {
            log_message('error', print_r($this->db->error(), true));
        }
        $this->db->where('product_id', $id);
        if (!$this->db->delete('product_attributes')) {
            log_message('error', print_r($this->db->error(), true));
        }
        $this->db->where('product_id', $id);
        if (!$this->db->delete('product_variants')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function productsCount($search_title = null, $category = null, $vendor = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_translations.title LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
		if ($vendor != null) {
            $this->db->where('vendor_id', $vendor);
        }
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('products');
    }

    public function getProducts($limit, $page, $search_title = null, $orderby = null, $category = null, $vendor = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_translations.title LIKE '%$search_title%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('products.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('products.sku', 'asc');
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        if ($vendor != null) {
            $this->db->where('vendor_id', $vendor);
        }
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.*, products_translations.title, products_translations.description, products_translations.default_price, products_translations.default_old_price, products_translations.abbr, products.url, products_translations.for_id, products_translations.basic_description')->get('products', $limit, $page);
        return $query->result();
    }

    public function numShopProducts()
    {
        return $this->db->count_all_results('products');
    }

    public function getOneProduct($id)
    {
        $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.*, products_translations.default_price,products_translations.default_old_price, products_translations.title,product_attributes.*');
        $this->db->where('products.id', $id);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->join('product_attributes', 'product_attributes.product_id = products.id', 'inner');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function productStatusChange($id, $to_status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('products', array('visibility' => $to_status));
        return $result;
    }

    public function setProduct($post, $id = 0, $categoryName)
    {
        

        if (!isset($post['brand_id'])) {
            $post['brand_id'] = null;
        }
        if (!isset($post['virtual_products'])) {
            $post['virtual_products'] = null;
        }
        if (!isset($post['regime_product'])) {
            $post['regime_product'] = null;
        }
        else{
            $post['regime_product'] = implode(',', $post['regime_product']);
        }
        if (!isset($post['related_products'])) {
            $post['related_products'] = null;
        }
        else{
            $post['related_products'] = implode(',', $post['related_products']);
        }
        if (!isset($post['shop_categorie'])) {
            $post['shop_categorie'] = null;
        }
        else{
            $post['shop_categorie'] = implode(',', $post['shop_categorie']);
        }
        if (!isset($post['frequently_bought'])) {
            $post['frequently_bought'] = null;
        }
        else{
            $post['frequently_bought'] = implode(',', $post['frequently_bought']);
        }
        if($categoryName != ''){
            $categoryNames = implode(',', $categoryName);
        }
        else{
            $categoryNames = '';
        }
        if (!isset($post['tag'])) {
            $post['tag'] = null;
        }
        else{
            $post['tag'] = implode(',', $post['tag']);
        }
        if (!isset($post['body'])) {
            $post['body'] = null;
        }
        else{
            $post['body'] = implode(',', $post['body']);
        }
        if (!isset($post['face'])) {
            $post['face'] = null;
        }
        else{
            $post['face'] = implode(',', $post['face']);
        }
        if (!isset($post['hair'])) {
            $post['hair'] = null;
        }
        else{
            $post['hair'] = implode(',', $post['hair']);
        }
        if (!isset($post['skin_concern'])) {
            $post['skin_concern'] = null;
        }
        else{
            $post['skin_concern'] = implode(',', $post['skin_concern']);
        }
        // if (($post['product_type']) == 'single') {
        //     $post['regime_product'] = null;
        // }
        // else{
        //     $post['regime_product'] = implode(', ', $post['regime_product']);
        // }
        // print_r($post['tag']);
        // exit;

        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('products', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'sku' => $post['sku'],
                        'shop_categorie' => $post['shop_categorie'],
                        'in_slider' => $post['in_slider'],
                        'position' => $post['position'],
						'tag' => $post['tag'],
						'courier_charge' => $post['courier_charge'],
                        'virtual_products' => $post['virtual_products'],
                        'brand_id' => $post['brand_id'],
						// 'vendor_id' => $post['vendor_id'],
                        'vendor_id' => '1',
						'rating' => $post['rating'],
                        'time_update' => time(),
						'min_age' => $post['min_age'],
						'max_age' => $post['max_age'],
						'age_unit' => $post['age_unit'],
						'days_to_deliver' => $post['days_to_deliver'],
                        'product_type' => $post['product_type'],
                        'regime_product' => $post['regime_product'],
                        'related_products' => $post['related_products'],
                        'frequently_bought' => $post['frequently_bought'],
                        'is_trending_product' => $post['is_trending_product'],
                        'is_featured_products' => $post['is_featured_products'],
                        'what_is_it' => $post['what_is_it'],
                        'why_do_you_ned_it' => $post['why_do_you_ned_it'],
                        'how_dose_it_help' => $post['how_dose_it_help'],
                        'category_name' => $categoryNames,
                        'is_featured_products' => $post['is_featured_products'],
                        'when_to_use' => $post['when_to_use'],
                        'where_to_apply' => $post['where_to_apply'],
                        'who_is_it_for' => $post['who_is_it_for'],
                        'hsn_code' => $post['hsn_code'],
                        'is_best_seller' => $post['is_best_seller'],
                        'is_newly_launch' => $post['is_newly_launch'],
                        'is_giftset' => $post['is_giftset'],
                        'image_alt' => $post['image_alt'],
                        'product_video' => $post['product_video'],
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
             if (!$this->db->where('product_id', $id)->update('product_attributes', array(        'body' => $post['body'],
                         'face' => $post['face'],
                         'lip' => $post['lip'],
                         'hair' => $post['hair'],
                         'kits' => $post['kits'],
                         'skin_concern' => $post['skin_concern'],
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('products', array(
                        'image' => $post['image'],
                        'sku' => $post['sku'],
                        'shop_categorie' => $post['shop_categorie'],
                        'in_slider' => $post['in_slider'],
                        'position' => $post['position'],
						'tag' => $post['tag'],
						'courier_charge' => $post['courier_charge'],
                        'virtual_products' => $post['virtual_products'],
                        'folder' => $post['sku'],
                        'brand_id' => $post['brand_id'],
						'rating' => $post['rating'],
                        'time' => time(),
						'min_age' => $post['min_age'],
						'max_age' => $post['max_age'],
						'age_unit' => $post['age_unit'],
                        'product_type' => $post['product_type'],
                        'regime_product' => $post['regime_product'],
                        'related_products' => $post['related_products'],
                        'frequently_bought' => $post['frequently_bought'],
                        'is_trending_product' => $post['is_trending_product'],
                        'is_featured_products' => $post['is_featured_products'],
                        'what_is_it' => $post['what_is_it'],
                        'why_do_you_ned_it' => $post['why_do_you_ned_it'],
                        'how_dose_it_help' => $post['how_dose_it_help'],
                        'is_best_seller' => $post['is_best_seller'],
                        'is_newly_launch' => $post['is_newly_launch'],
                        'is_giftset' => $post['is_giftset'],
                        'image_alt' => $post['image_alt'],
                        'product_video' => $post['product_video'],
                        'category_name' => $categoryNames
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            $this->db->where('id', $id);
            if (!$this->db->update('products', array(
                        'url' => except_product($_POST['title'][$myTranslationNum]) . '-' . $id
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
             if (!$this->db->insert('product_attributes', array(
                        'product_id' => $id,
                        'body' => $post['body'],
                        'face' => $post['face'],
                        'lip' => $post['lip'],
                        'hair' => $post['hair'],
                        'kits' => $post['kits'],
                        'skin_concern' => $post['skin_concern'],

                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }

        }
        $this->setProductTranslation($post, $id, $is_update);
		//$this->setProductAttributes($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
	private function setProductAttributes($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->removeProductAttributes($id);
		$insert_data = array();
        foreach ($post['attributes'] as $value) {
			$value = explode('/',$value); 
			$insert_data[$value[0]] = $value[1];
            //$insert_data['attribute_value'] = $value[0];
        }
		$insert_data['product_id'] = $id;
		
		$this->db->insert('product_attributes',$insert_data);
    }
    private function setProductTranslation($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'basic_description' => $post['basic_description'][$i],
                'description' => $post['description'][$i],
                'default_price' => $post['old_price'][$i],
                'default_old_price' => $post['old_price'][$i],
                'abbr' => $abbr,
                'for_id' => $id
            );
            //Update Product Varients
            if(isset($post['weight'])){
                $weight = $post['weight'];
                $vendor_price = $post['old_price'];
                $price = $post['old_price'];
                $old_price = $post['old_price'];
                $quantity = $post['quantity'];
                $weight_unit = $post['weight_unit'];
                $status = $post['status'];
                $length = $post['length'];
                $width = $post['width'];
                $height = $post['height'];
            }
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
                if(isset($post['weight'])){
                    foreach( $weight as $key => $n ) {
                        $vandor_price_single = str_replace(' ', '', $old_price[$key]);
                        $vandor_price_single = str_replace(',', '.', $vandor_price_single); 
                        $vandor_price_single =  preg_replace("/[^0-9,.]/", "", $vandor_price_single);
                        
                        $price_single = str_replace(' ', '', $old_price[$key]);
                        $price_single = str_replace(',', '.', $price_single);   
                        $price_single =  preg_replace("/[^0-9,.]/", "", $price_single);
                        
                        $price_old_single = str_replace(' ', '', $old_price[$key]);
                        $price_old_single = str_replace(',', '.', $price_old_single);   
                        $price_old_single =  preg_replace("/[^0-9,.]/", "", $price_old_single);
                        if($status[$key] == 'default'){
                            $arr = array(
                                'product_id' => $id,
                                'quantity' => $quantity[$key],
                                'weight' => $weight[$key],
                                'weight_unit' => $weight_unit[$key],
                                'length' => $length[$key],
                                'width' => $width[$key],
                                'height' => $height[$key],
                                'vendor_price' => $vandor_price_single,
                                'price' => $price_single,
                                'old_price' => $price_old_single,
                                'status' => 'show'
                            );
                            $this->db->insert('product_variants',$arr);
                        }else{
                            $status_single = $status[$key];
                            $status_single = explode("_",$status_single);
                            if($status_single[1] == "remove"){
                                $this -> db -> where('variant_id', $status_single[0]);
                                $this -> db -> delete('product_variants');
                            }else{
                                $arr = array(
                                    'quantity' => $quantity[$key],
                                    'weight' => $weight[$key],
                                    'weight_unit' => $weight_unit[$key],
                                    'length' => $length[$key],
                                    'width' => $width[$key],
                                    'height' => $height[$key],
                                    'vendor_price' => $vandor_price_single,
                                    'price' => $price_single,
                                    'old_price' => $price_old_single,
                                    'status' => $status_single[1]
                                );
                                $this->db->where('variant_id', $status_single[0]);
                                $this->db->update('product_variants', $arr);
                            }
                        }
                    }
                }
            } else {
                if ($this->db->insert('products_translations', $arr)) {
                    if(isset($post['weight'])){
                        foreach( $weight as $key => $n ) {
                            $vandor_price_single = str_replace(' ', '', $vendor_price[$key]);
                            $vandor_price_single = str_replace(',', '.', $vandor_price_single); 
                            $vandor_price_single =  preg_replace("/[^0-9,.]/", "", $vandor_price_single);
                            
                            $price_single = str_replace(' ', '', $price[$key]);
                            $price_single = str_replace(',', '.', $price_single);   
                            $price_single =  preg_replace("/[^0-9,.]/", "", $price_single);
                            
                            $price_old_single = str_replace(' ', '', $old_price[$key]);
                            $price_old_single = str_replace(',', '.', $price_old_single);   
                            $price_old_single =  preg_replace("/[^0-9,.]/", "", $price_old_single);
                            
                            $arr = array(
                                'product_id' => $id,
                                'quantity' => $quantity[$key],
                                'weight' => $weight[$key],
                                'weight_unit' => $weight_unit[$key],
                                'length' => $length[$key],
                                'width' => $width[$key],
                                'height' => $height[$key],
                                'vendor_price' => $vandor_price_single,
                                'price' => $price_single,
                                'old_price' => $price_old_single,
                                'status' => 'show'
                            );
                            $this->db->insert('product_variants',$arr);
                        }
                    }
                }
            }
            $i++;
        }
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('products_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title;
            $arr[$row->abbr]['basic_description'] = $row->basic_description;
            $arr[$row->abbr]['description'] = $row->description;
			$arr[$row->abbr]['default_price'] = $row->default_price;
			$arr[$row->abbr]['default_old_price'] = $row->default_old_price;
        }
        return $arr;
    }
	 public function districtCount()
    {
        return $this->db->count_all_results('states');
    }
	 public function getdistrict($limit, $page)
    {
        $query = $this->db->select('*')->get('states', $limit, $page);
        return $query->result();
    }
	 public function getAlldistrict()
    {
        $query = $this->db->select('*')->get('states');
        return $query->result_array();
    }
	 public function update_delivery_chrage($district_id, $data)
    {
        $this->db->where('id', $district_id);
        $result = $this->db->update('states', $data);
        return $result;
    }
	public function getVendorProducts($vendor_id)
    {
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->select('*')->get('products');
        return $query->result_array();
    }
	public function updateProductlocation($id, $city, $state)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('products', array('city_name' => $city, 'state_name' => $state));
        return $result;
    }
	public function getVariants($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->select('*')->get('product_variants');
        return $query->result_array();
    }
	 public function getproducts_review($limit, $page)
    {
		$this->db->join('products', 'products.id = product_review.product_id');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
		$this->db->join('users_public', 'users_public.id = product_review.user_id');
		$this->db->order_by('product_review.review_id','DESC');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('*')->get('product_review', $limit, $page);
        return $query->result();
    }
	 public function productsReviewCount()
    {
        return $this->db->count_all_results('product_review');
    }
	public function updateReviewStatus($id, $status)
    {
        $this->db->where('review_id', $id);
        $result = $this->db->update('product_review', array('status' => $status));
        return $result;
    }
	 public function deleteReview($id)
    {
        $this->db->trans_begin();
        $this->db->where('review_id', $id);
        if (!$this->db->delete('product_review')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
	public function getAllAttribute()
    {
        $this->db->order_by('attributes_set.attribute_set_name','ASC');
        $this->db->where('attribute_status', 'active');
        $query = $this->db->select('*')->get('attributes_set');
        return $query->result();
    }
     public function getAllAttributeOption($attribite_set_id)
    {
        $this->db->where('attribite_set_id', $attribite_set_id);
        $this->db->order_by('attributes_set_option.attribute_title','ASC');
        $query = $this->db->select('*')->get('attributes_set_option');
        return $query->result();
    }
	public function getProductAttributes($id)
    {
        $this->db->where('product_id', $id);
        $query = $this->db->get('product_attributes');
        return $query->result();
    }
	public function removeProductAttributes($id)
    {
		$this -> db -> where('product_id', $id);
    	$this -> db -> delete('product_attributes');
    }
	public function getAllProductsInventory()
    {
        $this->db->join('product_variants', 'product_variants.product_id = products.id');
		$this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $query = $this->db->select('*')->get('products');
        return $query->result_array();
    }
    public function getRegimeProduct()
    {          

        $this->db->select('products_translations.id as productsTranslationsID, products.id as productID, products_translations.title as productTitle');
        $this->db->join('products_translations', 'products_translations.for_id = products.id');
        $this->db->where('products.product_type', 'single');
        $this->db->order_by('products.id','DESC');
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function getAllProducts()
    {
        $this->db->select('products.*, products_translations.title,products_translations.description, products_translations.default_price, products_translations.default_old_price, products.url, shop_categories_translations.name as categorie_name,products.min_age,products.max_age,products.age_unit');

        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);

        $this->db->join('shop_categories_translations', 'shop_categories_translations.for_id = products.shop_categorie', 'inner');
        $this->db->where('shop_categories_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        
        $this->db->where('visibility', 1);
        $this->db->order_by('products.sku', 'ASC');
        //$this->db->where('vendors.vendor_status', 1);
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function getProductsBySKU($sku){
        $this->db->select('products.*, products_translations.title,products_translations.description, products_translations.default_price, products_translations.default_old_price, products.url, shop_categories_translations.name as categorie_name,products.min_age,products.max_age,products.age_unit');
        $this->db->where('products.sku', $sku);
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);

        $this->db->join('shop_categories_translations', 'shop_categories_translations.for_id = products.shop_categorie', 'inner');
        $this->db->where('shop_categories_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        
        $this->db->where('visibility', 1);
        //$this->db->where('vendors.vendor_status', 1);
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function getCategoryName($id){
        $this->db->select('*');       
        $this->db->where('id', $id);
        $query = $this->db->get('shop_categories_translations');
        return $query->row_array();
    }
    public function getNotSyncProduct($sync){
        $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.*, products_translations.default_price,products_translations.default_old_price, products_translations.title,product_attributes.*,products_translations.description, product_variants.quantity as productQuantity, product_variants.price');
        $this->db->where('products.sync', $sync);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->join('product_attributes', 'product_attributes.product_id = products.id', 'inner');
         $this->db->join('product_variants', 'product_variants.product_id = products.id', 'inner');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->get('products');
        return $query->result_array();
       
    }
    public function updateProductTable($id){
         $array = array(
            'sync' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('products', $array);
        return true;
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
      function existSKU($sku=null)
    {
        if($sku){
            $query = $this->db->get_where('products', array('sku' => $sku));
            $data = $query->row_array();
            $count = $query->num_rows();
            
            if($count>0)
                return $data;
            else
                return false;
        }else{
            return false;
        }
    }

    public function findCategory($category){
        $this->db->select('*'); 
        //$this->db->like('category_slug', $category, 'both');
        //$this->db->where("(category_slug LIKE '%$category%')");
        $this->db->where('category_slug', $category);
        $query = $this->db->get('shop_categories_translations');
        return $query->row_array();
    }
    public function findTags($tag){
        $this->db->select('*'); 
        // $this->db->like('ingredientsTitle', $tags, 'both');
        $this->db->where('ingredientsTitle', $tag);
        $query = $this->db->get('ingredients');
        return $query->row_array();
    }
    public function insert_bulkProduct($data){
        $this->db->insert('products',$data);
        return $this->db->insert_id();
    }
    public function insert_ProductsTranslations($data){
        $this->db->insert('products_translations',$data);
        return $this->db->insert_id();
    }
    public function insert_ProductAttributes($data){
        $this->db->insert('product_attributes',$data);
        return $this->db->insert_id();
    }
    public function insert_ProductVariants($data){
        $this->db->insert('product_variants',$data);
        return $this->db->insert_id();
    }
    public function update_bulkProduct($data, $sku){
        $this->db->where('sku', $sku);
        $result = $this->db->update('products', $data);
        return $result;
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function update_ProductsTranslations($data, $id){
        $this->db->where('for_id', $id);
        $result = $this->db->update('products_translations', $data);
        return $result;
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function update_ProductAttributes($data, $id){
        $this->db->where('product_id', $id);
        $result = $this->db->update('product_attributes', $data);
        return $result;
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
     public function update_ProductVariants($data, $id){
        $this->db->where('product_id', $id);
        $result = $this->db->update('product_variants', $data);
        return $result;
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    function fetch_Shopcategory_export()
    {
       $this->db->select('*');
       $this->db->from('shop_categories_translations');
       $this->db->where('for_id !=', '1');
       $this->db->where('for_id !=', '2');
       $this->db->where('for_id !=', '3');
       $this->db->where('for_id !=', '4');
       $this->db->where('for_id !=', '7');
       $this->db->order_by('id', 'ASC');
        
       $query = $this->db->get();
       
       return $query->result(); 
    }
    function fetch_category_export()
    {
       $this->db->select('*');
       $this->db->from('attributes_set_option');
       $this->db->order_by('attribite_set_id', 'ASC');
        
       $query = $this->db->get();
       
       return $query->result(); 
    }
    function update_UrlProduct($productID, $url){
        $array = array(
            'url' => $url.'-'.$productID
        );
        $this->db->where('id', $productID);
        $this->db->update('products', $array);
        return true;
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function getTags(){
       $this->db->select('*');
       $this->db->from('ingredients');
       $this->db->order_by('ingredientsTitle', 'ASC');
       $this->db->where('status', 'active');
       $query = $this->db->get();
       
       return $query->result_array(); 
    } 
    public function getFace(){
       $this->db->select('*');
       $this->db->from('attributes_set_option');
       $this->db->order_by('attribute_title', 'ASC');
       $this->db->where('attribite_set_id', '6');
       $query = $this->db->get();
       
       return $query->result_array(); 
    } 
    public function getBody(){
       $this->db->select('*');
       $this->db->from('attributes_set_option');
       $this->db->order_by('attribute_title', 'ASC');
       $this->db->where('attribite_set_id', '7');
       $query = $this->db->get();
       
       return $query->result_array(); 
    }
    public function getHire(){
       $this->db->select('*');
       $this->db->from('attributes_set_option');
       $this->db->order_by('attribute_title', 'ASC');
       $this->db->where('attribite_set_id', '9');
       $query = $this->db->get();
       
       return $query->result_array(); 
    }
    public function getSkinConcern(){
       $this->db->select('*');
       $this->db->from('attributes_set_option');
       $this->db->order_by('attribute_title', 'ASC');
       $this->db->where('attribite_set_id', '11');
       $query = $this->db->get();
       
       return $query->result_array(); 
    }
    public function fetch_product_export(){
       $this->db->select('*,product_variants.quantity as product_quantity');
       $this->db->from('products');
       $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
       $this->db->join('product_attributes', 'product_attributes.product_id = products.id', 'left');
       //$this->db->join('ingredients', 'ingredients.ingredientsID = products.tag', 'left');
       $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');
       $query = $this->db->get();
       
       return $query->result();
    }
}
