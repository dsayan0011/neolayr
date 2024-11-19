<?php

class Public_model extends CI_Model
{

    private $showOutOfStock;
    private $showInSliderProducts;
    private $multiVendor;

    public function __construct()
    {
        parent::__construct();
        $this->load->Model('Home_admin_model');
        $this->showOutOfStock = $this->Home_admin_model->getValueStore('outOfStock');
        $this->showInSliderProducts = $this->Home_admin_model->getValueStore('showInSlider');
        $this->multiVendor = $this->Home_admin_model->getValueStore('multiVendor');
    }

    public function productsCount($big_get)
    {
		$this->db->select('products.id');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
		$this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
		$this->db->join('product_attributes', 'products.id = product_attributes.product_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        if (!empty($big_get)) {
            $this->getFilter($big_get);
        }
        $this->db->where('visibility', 1);
		$this->db->where('vendors.vendor_status', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        
        if ($this->multiVendor == 0) {
            $this->db->where('vendor_id', 0);
        }
		$this->db->distinct();
		
        return $this->db->count_all_results('products');
    }

    public function getNewProducts()
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.default_old_price, products.rating, products.product_title');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('products.in_slider', 0);
        $this->db->where('visibility', 1);
		$this->db->where('vendors.vendor_status', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->order_by('products.id', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getLastBlogs()
    {
        //$this->db->limit(5);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->order_by('blog_posts.id', 'desc');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->select('blog_posts.id, blog_translations.title, blog_translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts');
        return $query->result_array();
    }

    public function getPosts($limit, $page, $search = null, $month = null)
    {
        if ($search !== null) {
            $search = $this->db->escape_like_str($search);
            $this->db->where("(blog_translations.title LIKE '%$search%' OR blog_translations.description LIKE '%$search%')");
        }
        if ($month !== null) {
            $from = intval($month['from']);
            $to = intval($month['to']);
            $this->db->where("time BETWEEN $from AND $to");
        }
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
		$this->db->order_by('blog_posts.time', 'desc');
        $query = $this->db->select('blog_posts.id, blog_translations.title, blog_translations.description, blog_posts.url, blog_posts.time, blog_posts.image')->get('blog_posts', $limit, $page);
        return $query->result_array();
    }

    public function getProducts($limit = null, $start = null, $big_get, $vendor_id = false)
    {
        //print_r($big_get['type']); exit;
        if ($limit !== null && $start !== null) {
            $this->db->limit($limit, $start);
        }
        if($big_get['type'] == 'shop-all'){
            if($big_get['orderby'] != []){
                unset($big_get['type']);
                unset($big_get['category']);
                $big_get['orderby'] = $big_get['orderby'];
            }else{
                $big_get = [];
            }
        }
        //print_r($big_get); exit;
        if (!empty($big_get)) {
            $this->getFilter($big_get);
        }
        $this->db->select('vendors.url as vendor_url, products.id,products.image, products.quantity, products_translations.title, products_translations.default_price, products_translations.default_old_price, products.url, products.vendor_id, products.city_name, products.state_name, products.rating, products.product_title');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
		$this->db->join('product_attributes', 'products.id = product_attributes.product_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
		$this->db->where('vendors.vendor_status', 1);
		//$this->db->distinct();
		
        // if ($vendor_id !== false) {
        //     $this->db->where('vendor_id', $vendor_id);
        // }
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        // if ($this->multiVendor == 0) {
        //     $this->db->where('vendor_id', 0);
        // }
        $this->db->order_by('products.id','DESC');
        $query = $this->db->get('products');
        //return $query->result_array();
        $return_data = array();
        if($query !== FALSE && $query->num_rows() > 0)
        {
            $return_data = $query->result_array();
        }
        return $return_data;

    }

    public function getOneLanguage($myLang)
    {
        $this->db->select('*');
        $this->db->where('abbr', $myLang);
        $result = $this->db->get('languages');
        return $result->row_array();
    }

    private function getFilter($big_get)
    {
        
        if($big_get['face'] != '' || $big_get['body'] != '' || $big_get['hair'] != '' || $big_get['skin_concern'] != '' || $big_get['kits'] != '' || $big_get['lip'] != ''){
            $big_get['category'] = '';
            unset($big_get['type']);
        }
        //print_r($big_get); exit;
        if (isset($big_get['category']) && $big_get['category'] != '') {
            $big_get['category'];
            $findInIds = array();
            $findInIds[] = $big_get['category'];

            // $query = $this->db->query('SELECT id FROM shop_categories WHERE sub_for = ' . $this->db->escape($big_get['category']));
            // foreach ($query->result() as $row) {
            //     $findInIds[] = $row->id;
            // }
            
            $this->db->where('find_in_set("'.$big_get['category'].'", products.shop_categorie) <>0');
            //print_r($findInIds); exit;
        }
        if (isset($big_get['ingredients']) && $big_get['ingredients'] != '') {
            $data = explode(",",$big_get['ingredients']);
            $this->db->where_in('products.sku', $data);
        }
		if (isset($big_get['tag']) && $big_get['tag'] != '') {
           $this->db->like('tag', $big_get['tag']);
        }
        if (isset($big_get['in_stock']) && $big_get['in_stock'] != '') {
            if ($big_get['in_stock'] == 1)
                $sign = '>';
            else
                $sign = '=';
            $this->db->where('products.quantity ' . $sign, '0');
        }
        if (isset($big_get['search_in_title']) && $big_get['search_in_title'] != '') {
			$search_title = $big_get['search_in_title'];
			//$where  = "(`products`.`product_title` LIKE '%".$search_title."' OR ";
            // $where  .= "`products`.`category_name` LIKE '%".$search_title."%' OR ";
            $where  = "(`products`.`search_key` LIKE '%".$search_title."%' OR ";
			$where  .= "`products_translations`.`title` LIKE '%".$search_title."%')";
			
			$this->db->where($where);
        }
         if (!empty($big_get) && isset($big_get['orderby'])) {
           if($big_get['orderby'] == 'price')
           $this->db->order_by('products_translations.default_price','ASC');
           else if($big_get['orderby'] == 'price-desc')
           $this->db->order_by('products_translations.default_price','DESC');
           else
           $this->db->order_by('products.position','ASC');
        }
		if (isset($big_get['suppliers']) && $big_get['suppliers'] != '') {
			$search_title = $big_get['suppliers'];
			$this->db->where('vendors.warehouse_name LIKE "%'.$search_title.'%"');
        }
		if (isset($big_get['state']) && $big_get['state'] != '') {
			$search_title = $big_get['state'];
			$this->db->where("products.state_name LIKE '%$search_title%'");
        }
        if (isset($big_get['search_in_body']) && $big_get['search_in_body'] != '') {
            $this->db->like('products_translations.description', $big_get['search_in_body']);
        }
        if (isset($big_get['order_price']) && $big_get['order_price'] != '') {
            $this->db->order_by('products_translations.default_price', $big_get['order_price']);
        }else{
			$this->db->order_by('products.position','ASC');
		}
        if (isset($big_get['order_procurement']) && $big_get['order_procurement'] != '') {
            $this->db->order_by('products.procurement', $big_get['order_procurement']);
        }
        
        if (isset($big_get['quantity_more']) && $big_get['quantity_more'] != '') {
            $this->db->where('products.quantity > ', $big_get['quantity_more']);
        }
        if (isset($big_get['quantity_more']) && $big_get['quantity_more'] != '') {
            $this->db->where('products.quantity > ', $big_get['quantity_more']);
        }
        if (isset($big_get['brand_id']) && $big_get['brand_id'] != '') {
            $this->db->where('products.brand_id = ', $big_get['brand_id']);
        }
        if (isset($big_get['added_after']) && $big_get['added_after'] != '') {
            $time = strtotime($big_get['added_after']);
            $this->db->where('products.time > ', $time);
        }
        if (isset($big_get['added_before']) && $big_get['added_before'] != '') {
            $time = strtotime($big_get['added_before']);
            $this->db->where('products.time < ', $time);
        }
        if (isset($big_get['price_from']) && $big_get['price_from'] != '') {
            $this->db->where('products_translations.default_price >= ', $big_get['price_from']);
        }
        if (isset($big_get['price_to']) && $big_get['price_to'] != '') {
            $this->db->where('products_translations.default_price <= ', $big_get['price_to']);
        }
		$attributes_filter = array();
		
		if (isset($big_get['material']) && $big_get['material'] != '') {
			//array_push($attributes_filter,$big_get['material']);
			$this->db->where(array('product_attributes.material' => $big_get['material']));
        }
		if (isset($big_get['color']) && $big_get['color'] != '') {
			//array_push($attributes_filter,$big_get['color']);
			$this->db->where(array('product_attributes.color' => $big_get['color']));
        }
		if (isset($big_get['gender']) && $big_get['gender'] != '') {
			//array_push($attributes_filter,$big_get['gender']);
			$this->db->where(array('product_attributes.gender' => $big_get['gender']));
        }
		if (isset($big_get['toy-type']) && $big_get['toy-type'] != '') {
			//array_push($attributes_filter,$big_get['toy-type']);
			$this->db->where(array('product_attributes.toy-type' => $big_get['toy-type']));
        }
            //print_r($big_get); exit;
            $custom_query = "";            
        if (isset($big_get['body']) && $big_get['body'] != '') {            
            $body_array = array();
            foreach($big_get['body'] as $item){
                //array_push($body_array,"'".$item."'");
                if($custom_query != ''){
                    $custom_query.=" OR ";
                }
                $custom_query.=" FIND_IN_SET ('".$item."',`product_attributes`.`body`)";
            }
            // $body_array = implode(",",$body_array);
            // $custom_query.=" `product_attributes`.`body` IN ($body_array)";
        }
        if (isset($big_get['face']) && $big_get['face'] != '') {
            $face_array = array();
            foreach($big_get['face'] as $item){
                if($custom_query != ''){
                    $custom_query.=" OR ";
                }
                 $custom_query.=" FIND_IN_SET ('".$item."',`product_attributes`.`face`)";
                //array_push($face_array,"'".$item."'");
            }

            //$face_array = implode(",",$face_array);
            
           
        }
        if (isset($big_get['hair']) && $big_get['hair'] != '') {
            $hair_array = array();
            foreach($big_get['hair'] as $item){
                if($custom_query != ''){
                $custom_query.=" OR ";
            }
             $custom_query.=" FIND_IN_SET ('".$item."',`product_attributes`.`hair`)";
                //array_push($hair_array,"'".$item."'");
            }
            //$hair_array = implode(",",$hair_array);
            
            //$custom_query.=" `product_attributes`.`hair` IN ($hair_array)";
        }
        if (isset($big_get['lip']) && $big_get['lip'] != '') {
            $lip_array = array();
            foreach($big_get['lip'] as $item){
                //array_push($lip_array,"'".$item."'");
                if($custom_query != ''){
                $custom_query.=" OR ";
            }
             $custom_query.=" FIND_IN_SET ('".$item."',`product_attributes`.`lip`)";
            }
           // $lip_array = implode(",",$lip_array);
            
            //$custom_query.=" `product_attributes`.`lip` IN ($lip_array)";
        }
        if (isset($big_get['kits']) && $big_get['kits'] != '') {
            $kits_array = array();
            foreach($big_get['kits'] as $item){
                //array_push($kits_array,"'".$item."'");
                if($custom_query != ''){
                $custom_query.=" OR ";
            }
                $custom_query.=" FIND_IN_SET ('".$item."',`product_attributes`.`kits`)";
            }
            //$kits_array = implode(",",$kits_array);
            
            //$custom_query.=" `product_attributes`.`kits` IN ($kits_array)";
        }
        if (isset($big_get['skin_concern']) && $big_get['skin_concern'] != '') {
             $skin_concern_array = array();
            foreach($big_get['skin_concern'] as $item){
                //array_push($skin_concern_array,"'".$item."'");
                if($custom_query != ''){
                $custom_query.=" OR ";
            }
            $custom_query.=" FIND_IN_SET ('".$item."',`product_attributes`.`skin_concern`)";
            }
            //print_r($skin_concern_array); exit;
            //$skin_concern_array = implode(",",$skin_concern_array);
            
            
            //$custom_query.=" `product_attributes`.`skin_concern` IN ($skin_concern_array)";
            //print_r($custom_query); exit;

        }
        
        if(($custom_query != '')){
            $custom_query="(".$custom_query.")";
         $this->db->where($custom_query, NULL, FALSE);  
        }




		if (isset($big_get['manufacturer']) && $big_get['manufacturer'] != '') {
			$this->db->where(array('product_attributes.manufacturer' => $big_get['manufacturer']));
        }
        
		/*if(sizeof($attributes_filter)>0){
			$this->db->where_in('product_attributes.attribute_value', $attributes_filter);
		}*/
		
    }

    public function getShopCategories()
    {
        $this->db->select('shop_categories.sub_for, shop_categories.id, shop_categories_translations.name, shop_categories_translations.category_slug, shop_categories.position');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->order_by('position', 'asc');
        $this->db->join('shop_categories', 'shop_categories.id = shop_categories_translations.for_id', 'INNER');
        $query = $this->db->get('shop_categories_translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[] = $row;
            }
        }
        return $arr;
    }

    public function getSeo($page)
    {
        $this->db->where('page_type', $page);
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->get('seo_pages_translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr['title'] = $row['title'];
                $arr['description'] = $row['description'];
            }
        }
        return $arr;
    }

    public function getOneProduct($id)
    {
        $this->db->where('products.id', $id);

        $this->db->select('vendors.url as vendor_url, products.*, products_translations.title,products_translations.description, products_translations.default_price, products_translations.default_old_price, products.url, shop_categories_translations.name as categorie_name,products.min_age,products.max_age,products.age_unit, products.product_title, products.rating,products.is_best_seller,products.is_newly_launch,products.is_giftset');

        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);

        $this->db->join('shop_categories_translations', 'shop_categories_translations.for_id = products.shop_categorie', 'inner');
        $this->db->where('shop_categories_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
		
        $this->db->where('visibility', 1);
		$this->db->where('vendors.vendor_status', 1);
        $query = $this->db->get('products');
        return $query->row_array();
    }
	public function getProductAttribute($id)
	{
		$this->db->select('*');
		$this->db->join('attributes_set', 'product_attributes.attribute = attributes_set.attribute_set_slug');
		$this->db->join('attributes_set_option', 'product_attributes.attribute_value = attributes_set_option.attribute_slug');
		$this->db->where('product_attributes.product_id', $id);
		$query = $this->db->get('product_attributes');
		return $query->result_array();
	}

    public function getCountQuantities()
    {
        $query = $this->db->query('SELECT SUM(IF(quantity<=0,1,0)) as out_of_stock, SUM(IF(quantity>0,1,0)) as in_stock FROM products WHERE visibility = 1');
        return $query->row_array();
    }

    public function getShopItems($array_items)
    {
        $this->db->select('product_variants.variant_id as id,product_variants.weight,product_variants.weight_unit,product_variants.length,product_variants.width,product_variants.height,products.id as product_id, products.image, products.url, product_variants.quantity, product_variants.price, products_translations.title,products.vendor_id, vendors.vendor_status, product_variants.status as variant_status, products.days_to_deliver, products.shop_categorie,products.sku, products.product_title');
		$this->db->join('products', 'product_variants.product_id = products.id', 'inner');
		$this->db->join('vendors', 'vendors.id = products.vendor_id', 'inner');
        $this->db->from('product_variants');
        if (count($array_items) > 1) {
            $i = 1;
            $where = '';
            foreach ($array_items as $id) {
                $i == 1 ? $open = '(' : $open = '';
                $i == count($array_items) ? $or = '' : $or = ' OR ';
                $where .= $open . 'product_variants.variant_id = ' . $id . $or;
                $i++;
            }
            $where .= ')';
            $this->db->where($where);
        } else {
            $this->db->where('product_variants.variant_id =', current($array_items));
        }
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * Users for notification by email
     */

    public function getNotifyUsers()
    {
        $result = $this->db->query('SELECT email FROM users WHERE notify = 1');
        $arr = array();
        foreach ($result->result_array() as $email) {
            $arr[] = $email['email'];
        }
        return $arr;
    }

    public function setOrder($order_id,$post,$shipping_cost,$delivery_time,$pdfFilePath)
    {
        /*$q = $this->db->query('SELECT MAX(order_id) as order_id FROM orders');
        $rr = $q->row_array();
        if ($rr['order_id'] == 0) {
            $rr['order_id'] = 1233;
        }*/
		$post['order_id'] =  $order_id;
		$i = 0;
        $post['products'] = array();

      
        foreach ($post['id'] as $product) {
            $post['products'][$product] = $post['quantity'][$i];
			$i++;
        }
        unset($post['id'], $post['quantity'], $post['price']);
        //print_r($post['products']); exit;
        $post['date'] = time();
        $products_to_order = [];
		$vendor_earning = array();
        if(!empty($post['products'])) {
            foreach($post['products'] as $pr_id => $pr_qua) {
				$pr = $this->getOneProductForSerialize($pr_id);
                //print_r($pr); exit;
                $products_to_order[] = [
                    'product_info' => $pr,
                    'product_quantity' => $pr_qua,
					'vendor_id' => $pr['vendor_id']
                    ];
				
				if (array_key_exists($pr['vendor_id'], $vendor_earning)) {
					$vendor_earning[$pr['vendor_id']] = $vendor_earning[$pr['vendor_id']]+($pr_qua*$pr['vendor_price']);
				}else
				$vendor_earning[$pr['vendor_id']] = $pr_qua*($pr['vendor_price']);
            }
        }

        if($_POST['final_amount_two'] == 0){
            $payment_type = "cashOnDelivery";
        }
        else{
            $payment_type = $post['payment_type'];
        }

		$post['products'] = serialize($products_to_order);
		$product_order = $products_to_order;
        //print_r($post['products']); exit;

        $this->db->trans_begin();
        if(strtolower($post['payment_type']) == 'cashondelivery'){
        $post['payment_status'] = 'pending';
        $is_show = '0';
        }
		if(strtolower($post['payment_type']) != 'cashondelivery'){
		$post['payment_status'] = 'pending';
        $is_show = '1';
        }
		$product_unserialize = unserialize($post['products']);
        //print_r($product_unserialize); exit;
        $totalAmount = $_POST['final_amount_two'];
        $referral_amount = "0";
        $gift_amount = 0;

        if($post['referralCode'] != ''){ 
            $referral_point = $post['referralCode'];
            $referral_amount = $post['other_referral_prices'];
        }
        if($post['giftAmount'] != ''){
            $gift_amount = $post['giftAmount'];
        }
        
        $finalAmount = ($totalAmount + $post['discountAmount'] + $post['paid_amount'] + $referral_amount + $gift_amount)-$shipping_cost;
        $paid_reward_pount = 0;
        $discount_amount = 0;
        $reward_paid_point = 0;
        
        //$referral_point = 0;
       
        if($post['paid_amount'] != ''){
            $paid_reward_pount = $post['paid_amount'];
        }
        if($post['discountAmount'] != ''){
            $discount_amount = $post['discountAmount'];
        }
        if($post['paid_by_point'] != ''){
            $reward_paid_point = $post['paid_by_point'];
        }
        
        //echo "paid_by_point".$post['paid_by_point'];
        //$unitPrice= $finalAmount - $paid_reward_pount - $discount_amount - $referral_point;
        // echo "paid_reward_pount".$paid_reward_pount;
        // echo "discountAmount".$discountAmount;
        // echo "referralPoint".$referralPoint;
        // // print_r($totalAmount);
        // exit;
        // $cc = (250 / 250 * 0);
        // print_r($cc);
        // exit;
        //$totalProductAmount = '';

        //  foreach ($product_unserialize as $product) {
        // $three_digitnumber = rand(100, 999);
        //     $three_digitnumber = rand(100, 999);
        //     $totalProductAmount= ($product['product_info']['price']*$product['product_quantity']);
        //     $reward = number_format((($totalProductAmount / $finalAmount) * $paid_reward_pount),2);
        //     $discountAmount = number_format((($totalProductAmount / $finalAmount) * $discount_amount),2);

        //     $referralPoint = number_format((($totalProductAmount / $finalAmount) * $referral_amount),2);
           
        //     $shipping_cost_line_item= number_format((($totalProductAmount / $finalAmount) * $shipping_cost),2);

        //     $reward_point= number_format((($totalProductAmount / $finalAmount) * $reward_paid_point),2);

        //      $unitPrice = ($product['product_info']['price']*$product['product_quantity']) - $reward - $discountAmount - $referralPoint + $shipping_cost_line_item;

        //      $giftAmount = number_format((($totalProductAmount / $finalAmount) * $gift_amount),2);
        // //      echo "referralPoint".$referralPoint;


        //   }
        //   echo "giftAmount".$giftAmount;
         
    
          
         
        //    exit;
        if (!$this->db->insert('orders', array(
                    'order_id' => $post['order_id'],
                    'products' => $post['products'],
					'total_order_price' => $_POST['final_amount_two'],
                    'total_order_price_two' => $post['grand_total'],
                    'date' => $post['date'],
					'expected_delivery_date' => $post['date']+ (24*$delivery_time)*60*60,
                    'referrer' => $post['referrer'],
                    'clean_referrer' => $post['clean_referrer'],
                    'payment_type' => $payment_type,
                    'payment_status' => @$post['payment_status'],
                    // 'discount_code' => @$post['discountCode'],
                    'discount_code' => $post['coupon_code'],
					'discount_amount' => $post['discountAmount'],
                    'paid_amount' => $post['paid_amount'],
                    'paid_by_point' => $post['paid_by_point'],
                    'request_id' => $post['request_id'],
                    'isReferral' => $post['referralCode'],
                    'referral_amount' => $referral_amount,
                    'user_email' => $post['user_email'],
					'shipping_cost' => $shipping_cost,
                    'gift_amount' =>  $post['giftAmount'],
                    'invoice_file' => $pdfFilePath,
					'is_show' => $is_show,
                    'discount_type' => $post['discountType'],
                    'coupon_discount_type' => $post['coupon_discount_type'],
                    'user_id' => $post['user_id'],
                    'order_year' => date('Y'),
					'updated_date' => date('Y-m-d H:i:s')
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
        $lastId = $this->db->insert_id();
        if (!$this->db->insert('orders_clients', array(
                    'for_id' => $lastId,
					'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'email' => $post['email'],
                    'phone' => $post['phone'],
					'country' => $post['country'],
                    'address' => $post['address'],
                    'city' => $post['city'],
                    'post_code' => $post['post_code'],
					'thana' => $post['thana'],
                    'notes' => $post['notes']
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
		//Insert into order product table
		$vendor_product_data = array();
		foreach($product_order as $val) {
			$vendor_product_data[$val['vendor_id']][] = $val;
		}
        if($post['payment_type'] == 'cashOnDelivery'){
            $payemntStatus = 'processing';
        }
        else{
            $payemntStatus = 'initiated';
        }
        foreach ($product_unserialize as $product) {
            $three_digitnumber = rand(100, 999);
            $totalProductAmount= ($product['product_info']['price']*$product['product_quantity']);
            $reward = number_format((($totalProductAmount / $finalAmount) * $paid_reward_pount),2);
            $discountAmount = number_format((($totalProductAmount / $finalAmount) * $discount_amount),2);

            $referralPoint = number_format((($totalProductAmount / $finalAmount) * $referral_amount),2);
           
            $shipping_cost_line_item= number_format((($totalProductAmount / $finalAmount) * $shipping_cost),2);

            $reward_point= number_format((($totalProductAmount / $finalAmount) * $reward_paid_point),2);

             $giftAmount = number_format((($totalProductAmount / $finalAmount) * $gift_amount),2);

             $unitPrice = ($product['product_info']['price']*$product['product_quantity']) - $reward - $giftAmount - $discountAmount - $referralPoint + $shipping_cost_line_item;

            

		foreach($vendor_product_data as $vendor=>$product_order){
			$this->db->insert('order_product', array(
                    'main_order_id' => $lastId,
                    'order_product_id' => $post['order_id'].$three_digitnumber,
                    'order_products' => serialize($product),
                    'orderstatus' => 0,
					'order_viewed' => 0,
					'order_update_date' => date('Y-m-d H:i:s'),
					'vendor_id' => $vendor,
					'vendor_earning' => $vendor_earning[$vendor],
					'vendor_payment_status' => 'processing',
                    'reward' => $reward_point,
                    'reward_amount' => $reward,
                    'coupon' => $discountAmount,
                    'referral_amount' => $referralPoint,
                    'unit_price' => $unitPrice,
                    'shipping_cost' => $shipping_cost_line_item,
                    'gift_discount' => $giftAmount,
                    'status' => $payemntStatus
                ));
			//$this->setVendorOrder($vendor,$lastId,$post['order_id'].$vendor);
		}
    }
		
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $post['order_id'];
        }
    }
    public function updateOrderProductStatus($id)
    {
        $this->db->where('main_order_id', $id);
        $result = $this->db->update('order_product', array('status' => 'processing'));
        return $result;
    }
    
    private function getOneProductForSerialize($id)
    {
        $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.*, product_variants.*');
        $this->db->where('product_variants.variant_id', $id);
		$this->db->join('products', 'products.id = product_variants.product_id', 'inner');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->get('product_variants');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function setVendorOrder($vendor_id,$main_order_id,$order_id)
    {
		  $this->db->trans_begin();
		  $this->db->insert('vendors_orders', array(
		  					'main_order_id' => $main_order_id,
                            'order_id' => $order_id,
                            'vendor_id' => $vendor_id
                        ));
		$this->db->trans_commit();
    }

    public function setActivationLink($link, $orderId)
    {
        $result = $this->db->insert('confirm_links', array('link' => $link, 'for_order' => $orderId));
        return $result;
    }

    public function getSliderProducts()
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.basic_description, products_translations.default_old_price, products.rating, products_translations.description');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('in_slider', 1);
		$this->db->order_by('products.position','ASC');
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getbestSellers($categorie = 0, $noId = 0)
    {
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.default_old_price, products.rating, products.folder, products.product_title');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        if ($noId > 0) {
            $this->db->where('products.id !=', $noId);
        }
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        if ($categorie != 0) {
            $this->db->where('products.shop_categorie !=', $categorie);
        }
        $this->db->where('visibility', 1);
		$this->db->where('vendors.vendor_status', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->where('products.is_best_seller', 'yes');
        $this->db->order_by('products.id', 'DESC');
        //$this->db->limit(5);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function sameCagegoryProducts($sku, $noId, $vendor_id = false)
    {
        //$array = array('shop_categorie' => $categorie);
        //print_r($array); exit;
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.default_old_price, products.city_name, products.state_name, products.rating, products.product_title');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products.id !=', $noId);
        if ($vendor_id !== false) {
            $this->db->where('vendor_id', $vendor_id);
        }
        //$this->db->where('FIND_IN_SET("'.$array['shop_categorie'].'", products.shop_categorie)',null,true);
        $this->db->where('FIND_IN_SET("'.$sku.'", products.related_products) <>0');
        //$this->db->where('products.shop_categorie =', $categorie);
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
		$this->db->where('vendors.vendor_status', 1);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $this->db->order_by('products.position', 'ASC');
        $this->db->limit(8);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function getOnePost($id)
    {
        $this->db->select('blog_translations.title, blog_translations.description, blog_posts.image, blog_posts.time');
        $this->db->where('blog_posts.id', $id);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->where('blog_translations.abbr', MY_LANGUAGE_ABBR);
        $query = $this->db->get('blog_posts');
        return $query->row_array();
    }

    public function getArchives()
    {
        $result = $this->db->query("SELECT DATE_FORMAT(FROM_UNIXTIME(time), '%M %Y') as month, MAX(time) as maxtime, MIN(time) as mintime FROM blog_posts GROUP BY DATE_FORMAT(FROM_UNIXTIME(time), '%M %Y')");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }

    public function getFooterCategories()
    {
        $this->db->select('shop_categories.id, shop_categories_translations.name');
        $this->db->where('abbr', MY_LANGUAGE_ABBR);
        $this->db->where('shop_categories.sub_for =', 0);
        $this->db->join('shop_categories', 'shop_categories.id = shop_categories_translations.for_id', 'INNER');
        $this->db->limit(10);
        $query = $this->db->get('shop_categories_translations');
        $arr = array();
        if ($query !== false) {
            foreach ($query->result_array() as $row) {
                $arr[$row['id']] = $row['name'];
            }
        }
        return $arr;
    }

    public function setSubscribe($array)
    {
        $num = $this->db->where('email', $arr['email'])->count_all_results('subscribed');
        if ($num == 0) {
            $this->db->insert('subscribed', $array);
        }
    }

    public function getDynPagesLangs($dynPages)
    {
        if (!empty($dynPages)) {
            $this->db->join('textual_pages_tanslations', 'textual_pages_tanslations.for_id = active_pages.id', 'left');
            $this->db->where_in('active_pages.name', $dynPages);
            $this->db->where('textual_pages_tanslations.abbr', MY_LANGUAGE_ABBR);
            $result = $this->db->select('textual_pages_tanslations.name as lname, active_pages.name as pname')->get('active_pages');
            $ar = array();
            $i = 0;
            foreach ($result->result_array() as $arr) {
                $ar[$i]['lname'] = $arr['lname'];
                $ar[$i]['pname'] = $arr['pname'];
                $i++;
            }
            return $ar;
        } else
            return $dynPages;
    }

    public function getOnePage($page)
    {
        $this->db->join('textual_pages_tanslations', 'textual_pages_tanslations.for_id = active_pages.id', 'left');
        $this->db->where('textual_pages_tanslations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('active_pages.name', $page);
        $result = $this->db->select('textual_pages_tanslations.description as content, textual_pages_tanslations.name')->get('active_pages');
        return $result->row_array();
    }

    public function changePaypalOrderStatus($order_id, $status)
    {
        $orderstatus = 0;
        if ($status == 'canceled') {
            $orderstatus = 2;
        }
        $this->db->where('order_id', $order_id);
        if (!$this->db->update('orders', array(
                    'paypal_status' => $status,
                    'orderstatus' => $orderstatus
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }

    public function getCookieLaw()
    {
        $this->db->join('cookie_law_translations', 'cookie_law_translations.for_id = cookie_law.id', 'inner');
        $this->db->where('cookie_law_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('cookie_law.visibility', '1');
        $query = $this->db->select('link, theme, message, button_text, learn_more')->get('cookie_law');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function confirmOrder($md5)
    {
        $this->db->limit(1);
        $this->db->where('link', $md5);
        $result = $this->db->get('confirm_links');
        $row = $result->row_array();
        if (!empty($row)) {
            $orderId = $row['for_order'];
            $this->db->limit(1);
            $this->db->where('order_id', $orderId);
            $result = $this->db->update('orders', array('confirmed' => '1'));
            return $result;
        }
        return false;
    }

    public function getValidDiscountCode($code)
    {
        $time = time();
        $this->db->select('*');
        $this->db->where('code', $code);
        $this->db->where($time . ' BETWEEN valid_from_date AND valid_to_date');
        $query = $this->db->get('discount_codes');
        return $query->row_array();
    }
    public function getValidVoucherCode($code)
    {
        $time = time();
        $this->db->select('*');
        $this->db->where('couponStatus', '1');
        $this->db->where('voucher', $code);
        $query = $this->db->get('giftcoupon');
        return $query->row_array();
    }

    public function countPublicUsersWithEmail($email, $id = 0)
    {
        if ($id > 0) {
            $this->db->where('id !=', $id);
        }
        $this->db->where('email', $email);
        return $this->db->count_all_results('users_public');
    }

    public function registerUser($post)
    {
        $this->db->insert('users_public', array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'password' => md5($post['pass'])
        ));
        return $this->db->insert_id();
    }

    public function updateProfile($post)
    {
        $array = array(
            'name' => $post['name'],
            'phone' => $post['phone'],
            'email' => $post['email']
        );
        if (trim($post['pass']) != '') {
            $array['password'] = md5($post['pass']);
        }
        $this->db->where('id', $post['id']);
        $this->db->update('users_public', $array);
    }

    public function checkPublicUserIsValid($post)
    {
        $this->db->where("(email='".$post['email']."' OR phone='".$post['email']."')", NULL, FALSE);
		
        $this->db->where('password', md5($post['pass']));
        $query = $this->db->get('users_public');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    public function checkReferralExist($referral_code, $userID)
    {
        $this->db->where("(referral_code='".$referral_code."' AND userID='".$userID."')", NULL, FALSE);
        $query = $this->db->get('coupon_referral_translations');
        $result = $query->row_array();
        if (empty($result)) {
            return true;
        } else {
            return false;
        }
    }
    public function createCoupon($code,$couponAmount,$mobile_no){
        $valid_from_date = date('Y-m-d');
        $valid_to_date = date('Y-m-d', strtotime("+30 days"));;
        $this->db->insert('discount_codes', array(
                    'type' => 'float',
                    'code' => $code,
                    'amount' => $couponAmount,
                    'vendors' => 'all',
                    'valid_from_date' => strtotime($valid_from_date),
                    'valid_to_date' => strtotime($valid_to_date),
                    'offer_types' => '10',
                    'categories' => 'all',
                    'description' => 'birthday_coupon',
                    'showForAll' => 'no',
                    'user_specific' => 'yes',
                    'user_phone_number' => $mobile_no
        ));
        return $this->db->insert_id();
        {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }      
    }
    public function couponReferralTranslations($referral_code, $orderId, $user_id){
        $this->db->insert('coupon_referral_translations', array(
                    'referral_code' => $referral_code,
                    'orderID' => $orderId,
                    'userID' => $user_id
        ));
        return $this->db->insert_id();
        {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }  
    }


    public function getUserProfileInfo($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }
    public function getUserAddressFrOrder($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('orders_clients');
        return $query->row_array();
    }
    public function getGiftDetails($id){
        $this->db->where('userID', $id);
        $query = $this->db->get('giftcoupon');
        return $query->result_array();
    }
    public function getUserAddressInfo($id){
        $this->db->where('user_id', $id);
        $this->db->order_by('user_id', 'ASC');
        $this->db->join('states', 'states.id = user_address.state', 'inner');
        $this->db->join('cities', 'cities.id = user_address.city', 'inner');
        $this->db->limit(1);
        $query = $this->db->get('user_address');
        return $query->row_array();
    }

    public function sitemap()
    {
        $query = $this->db->select('url')->get('products');
        return $query;
    }

    public function sitemapBlog()
    {
        $query = $this->db->select('url')->get('blog_posts');
        return $query;
    }

    public function getUserOrdersHistoryCount($userId)
    {
        $this->db->where('orders.user_id', $userId);
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        return $this->db->count_all_results('order_product');
    }
    public function getUserOrdersHistoryCountTwo($userId)
    {
        $this->db->where('orders.user_id', $userId);
        // $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        return $this->db->count_all_results('orders');
    }

    public function getUserOrdersHistory($userId, $limit, $page, $sort_get)
    {
        $this->db->where('orders.user_id', $userId);
        // $this->db->where('orders.payment_status', 'completed');
        // $this->db->or_where('orders.payment_status', null);
        $this->db->order_by('orders.id', 'DESC');
        $this->db->select('orders.*,order_product.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        if (!empty($sort_get) && isset($sort_get['sortby'])) {
            $start_date   = date('Y-m-d 00:00:00',strtotime("now"));            

           if($sort_get['sortby'] == '6month'){
            $end_date = date('Y-m-d 23:59:59',strtotime("-180 days"));
            $this->db->where('orders.updated_date BETWEEN "'. date('Y-m-d 00:00:00', strtotime($end_date)). '" and "'. date('Y-m-d 23:59:59', strtotime($start_date)).'"');
        }
        else if($sort_get['sortby'] == '12month'){
            $end_date = date('Y-m-d 23:59:59',strtotime("-365 days"));
            $this->db->where('orders.updated_date BETWEEN "'. date('Y-m-d 00:00:00', strtotime($end_date)). '" and "'. date('Y-m-d 23:59:59', strtotime($start_date)).'"');
        }
        else{
            $this->db->order_by('orders.id', 'DESC');
        }
        }
        $result = $this->db->get('order_product', $limit, $page);
        return $result->result_array();
    }
    public function getUserOrdersHistoryTwo($orderID)
    {
        $this->db->where('order_product.main_order_id', $orderID);
        //$this->db->where('order_product.status !=', 'initiated');
        // $this->db->or_where('orders.payment_status', null);
        $this->db->order_by('order_product.id', 'DESC');
        $this->db->select('order_product.*,orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
        $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        // if (!empty($sort_get) && isset($sort_get['sortby'])) {
        //     $start_date   = date('Y-m-d 00:00:00',strtotime("now"));            

        //    if($sort_get['sortby'] == '6month'){
        //     $end_date = date('Y-m-d 23:59:59',strtotime("-180 days"));
        //     $this->db->where('orders.updated_date BETWEEN "'. date('Y-m-d 00:00:00', strtotime($end_date)). '" and "'. date('Y-m-d 23:59:59', strtotime($start_date)).'"');
        // }
        // else if($sort_get['sortby'] == '12month'){
        //     $end_date = date('Y-m-d 23:59:59',strtotime("-365 days"));
        //     $this->db->where('orders.updated_date BETWEEN "'. date('Y-m-d 00:00:00', strtotime($end_date)). '" and "'. date('Y-m-d 23:59:59', strtotime($start_date)).'"');
        // }
        // else{
        //     $this->db->order_by('orders.id', 'DESC');
        // }
        // }
        $result = $this->db->get('order_product');
        return $result->result_array();
    }
    public function getUserOrdersTwo($userId, $limit, $page, $sort_get)
    {
        $this->db->where('orders.user_id', $userId);
        $this->db->where('orders.is_show', '0');
        $this->db->order_by('orders.id', 'DESC');
        $this->db->select('orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
        //$this->db->join('order_product', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        if (!empty($sort_get) && isset($sort_get['sortby'])) {
            $start_date   = date('Y-m-d 00:00:00',strtotime("now"));            

           if($sort_get['sortby'] == '6month'){
            $end_date = date('Y-m-d 23:59:59',strtotime("-180 days"));
            $this->db->where('orders.updated_date BETWEEN "'. date('Y-m-d 00:00:00', strtotime($end_date)). '" and "'. date('Y-m-d 23:59:59', strtotime($start_date)).'"');
        }
        else if($sort_get['sortby'] == '12month'){
            $end_date = date('Y-m-d 23:59:59',strtotime("-365 days"));
            $this->db->where('orders.updated_date BETWEEN "'. date('Y-m-d 00:00:00', strtotime($end_date)). '" and "'. date('Y-m-d 23:59:59', strtotime($start_date)).'"');
        }
        else{
            $this->db->order_by('orders.id', 'DESC');
        }
        }
        $result = $this->db->get('orders', $limit, $page);
        return $result->result_array();
    }
    public function getReferral($userID){
        $this->db->where('id', $userID);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }
	public function getOrderDetails($order_id)
    {
        $this->db->where('orders.order_id', $order_id);
        $this->db->select('orders.*,orders.id as orderID, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_value, orders.discount_type as discountTypes');
       $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('orders');
        return $result->row_array();
    }
    public function getOrderProductDetails($orderID){
        $this->db->where('order_product.main_order_id', $orderID);
        $this->db->select('orders.*,order_product.*,orders.id as orderID, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_value');
        $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('order_product');
        return $result->result_array();
    }
    public function insert_order_tracking($orderID,$order_product_id,$skuCode,$status,$remarks){
        $this->db->insert('order_tracking', array(
                'orderID' => $orderID,
                'order_product_id' => $order_product_id,
                'skuCode' => $skuCode,
                'status' => $status,
                'remarks' => $remarks
        ));
        return $this->db->insert_id();
    }

	 public function getUserOrderDetails($order_id)
    {
        $this->db->where('order_product.order_product_id', $order_id);
        $this->db->select('orders.*,order_product.*,orders.id as orderID, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_value');
        $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
		$this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('order_product');
        return $result->row_array();
    }
     public function getLineItemOrderDetails($order_id)
    {
        $this->db->where('order_product.id', $order_id);
        $this->db->select('orders.*,order_product.*,orders.id as orderID, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_value');
        $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('order_product');
        return $result->row_array();
    }
     public function getUserOrderDetailsTwo($order_id)
    {
        $this->db->where('order_product.main_order_id', $order_id);
        $this->db->select('orders.*,order_product.*,orders.id as orderID, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_value, orders.shipping_cost as order_shipping_cost, orders.id as orderID, order_product.id as order_productID,orders.discount_type as discountTypes');
        $this->db->order_by('order_product.id', 'DESC');
        $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('order_product');
        return $result->result_array();
    }
     public function updateCancelProductOrderStatus($order_id, $status)
    {
        if ($status == 'cancel') {
            $orderstatus = 4;
        }
        if ($status == 'delivered') {
            $orderstatus = 3;
        }
        $this->db->where('id', $order_id);
        if (!$this->db->update('order_product', array(
                    'orderstatus' => $orderstatus,
                    'cancel_reason' => 'User cancel from frontend',
                    'order_update_date' => date('Y-m-d H:i:s'),
                    'status' => 'cancelled',
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
     public function updateReturnProductOrderStatus($order_id, $status)
    {
        if ($status == 'cancel') {
            $orderstatus = 4;
        }
        if ($status == 'returned') {
            $orderstatus = 6;
        }
        $this->db->where('id', $order_id);
        if (!$this->db->update('order_product', array(
                    'orderstatus' => $orderstatus,
                    'refund_reason' => 'Not Good Item',
                    'order_update_date' => date('Y-m-d H:i:s'),
                    'status' => 'returned',
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
     public function updateCancelOrderStatus($order_id, $status)
    {
        if ($status == 'cancel') {
            $orderstatus = 4;
        }

        $this->db->where('id', $order_id);
        if (!$this->db->update('orders', array(
                    'processed' => $orderstatus,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'order_status' => 'cancel',
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
      public function updateReturnOrderStatus($order_id, $status)
    {
        if ($status == 'cancel') {
            $orderstatus = 4;
        }
        if ($status == 'returned') {
            $orderstatus = 6;
        }
        $this->db->where('id', $order_id);
        if (!$this->db->update('orders', array(
                    'processed' => $orderstatus,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'order_status' => 'returned',
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function findMainOrderID($id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('order_product');
        return $query->row_array();
    }
    public function userPointRollups($userID){
        $this->db->select('*');
        $this->db->where('customerID', $userID);
        //$this->db->order_by('customerID', $userID);
        $query = $this->db->get('user_point_rollups');
        return $query->row_array();
    }
    public function updateTier($customerID,$tierID){
        $this->db->where('customerID', $customerID);
        if (!$this->db->update('user_point_rollups', array(
                    'tier' => $tierID
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function updateCustomarPoint($orderID, $reward_amount){
        $this->db->where('orderID', $orderID);
        $this->db->where('pointType', '1');
        if (!$this->db->update('customer_point', array(
                    'point_canceled' => $reward_amount
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
     public function updateCustomarPointFrRefund($orderID, $reward_amount){
        $this->db->where('orderID', $orderID);
        $this->db->where('pointType', '1');
        if (!$this->db->update('customer_point', array(
                    'point_canceled' => $reward_amount
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }

    public function update_user_point_rollups($customerID,$totalEarnPointMinus,$bonusPointAdd,$totalTotalPurchasedValueMinus)
    {
        $data = array(
                    'totalEarnPoint' => $totalEarnPointMinus,
                    'balancePont' => $bonusPointAdd,
                    'total_purchased_value' => $totalTotalPurchasedValueMinus
            ); 
            
            $this->db->where('customerID', $customerID);
            $result = $this->db->update('user_point_rollups ', $data);

            {
            log_message('error', print_r($this->db->error(), true));
            }

        //  $this->db->where('customerID', $customerID);
        // if (!$this->db->update('user_point_rollups', array(
        //             'totalEarnPoint' => $totalEarnPointMinus,
        //             'balancePont' => $bonusPointAdd,
        //             'total_purchased_value' => $totalTotalPurchasedValueMinus
        //         ))) {
        //     log_message('error', print_r($this->db->error(), true));
        // }
    }

    public function update_user_point_rollups_return($customerID,$bonusPointAdd)
    {
        $data = array(
                    'balancePont' => $bonusPointAdd
            ); 
            
            $this->db->where('customerID', $customerID);
            $result = $this->db->update('user_point_rollups ', $data);

            {
            log_message('error', print_r($this->db->error(), true));
            }
    }

    public function update_return_user_point_rollups($customerID,$totalEarnPointMinus,$bonusPointMinus,$totalTotalPurchasedValueMinus)
    {
        $data = array(
                    'totalEarnPoint' => $totalEarnPointMinus,
                    'balancePont' => $bonusPointMinus,
                    'total_purchased_value' => $totalTotalPurchasedValueMinus
            ); 
            
            $this->db->where('customerID', $customerID);
            $result = $this->db->update('user_point_rollups ', $data);

            {
            log_message('error', print_r($this->db->error(), true));
            }
    }

	 public function updateOrderStatus($order_id, $status)
    {
        if ($status == 'cancel') {
            $orderstatus = 4;
        }
        $this->db->where('order_product_id', $order_id);
        if (!$this->db->update('order_product', array(
                    'orderstatus' => $orderstatus,
					'order_viewed' => '1',
					'cancel_reason' => 'User cancel from frontend'
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
	 public function updateProductOrder($order_id, $order_product)
    {
        $this->db->where('order_product_id', $order_id);
        if (!$this->db->update('order_product', array(
                    'order_products' => serialize($order_product)
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
	 public function getcountrylist()
    {
        $this->db->select('*');
		$this->db->order_by('country_name','ASC');
        $query = $this->db->get('countries');
        return $query->result_array();
    }
	 public function getdistrictlist()
    {
        $this->db->select('*');
		$this->db->order_by('state_name','ASC');
        $query = $this->db->get('states');
        return $query->result_array();
    }
	public function getThanalist($district_id)
    {
        $this->db->select('*');
		$this->db->where('state_id', $district_id);
		$this->db->order_by('name','ASC');
        $query = $this->db->get('cities');
        return $query->result_array();
    }
	public function getStatelist($country_id)
    {
        $this->db->select('*');
		$this->db->where('country_id', $country_id);
		$this->db->order_by('state_name','ASC');
        $query = $this->db->get('states');
        return $query->result_array();
    }
	public function insertSubscription($email)
    {
        $this->db->insert('newsletter_subscriber', array(
            'subscriber_email' => $email,
            'subscription_date' => date('Y-m-d H:i:s'),
			'status' => 'active'
        ));
        return $this->db->insert_id();
    }
	 public function countSubscriberEmail($email)
    {
        $this->db->where('subscriber_email', $email);
        return $this->db->count_all_results('newsletter_subscriber');
    }
	public function getHomeSlider()
    {
        $this->db->select('*');
        $this->db->where('home_banner.status', 'active');
        $this->db->order_by('home_banner.banner_id', 'desc');
        $query = $this->db->get('home_banner');
        return $query->result();
    }
	 public function categoryDetails($category)
    {
          $this->db->select('*');
		  $this->db->join('shop_categories_translations','shop_categories.id=shop_categories_translations.for_id');
		  $this->db->where(array('shop_categories.id' => $category));
		  
		  $data = $this->db->get('shop_categories');

		  $result_data = $data->row_array();
		  return $result_data;
    }
     public function fst_category_details($category)
    {
          $this->db->select('*');
          //$this->db->join('shop_categories_translations','shop_categories.id=shop_categories_translations.for_id');
          //$this->db->where(array('shop_categories.id' => $category));
          $this->db->where('shop_categories_translations.id', $category);
          $data = $this->db->get('shop_categories_translations');

          $result_data = $data->row_array();
          return $result_data;
    }
	function insertToken($email,$token)
	  {
			
			$data = array(
				'email' => $email,
				'token' => $token,
				'created_date' => date("y-m-d h:i:s")
			); 
			$this->db->insert('user_reset_password_token', $data);
			return $this->db->insert_id();
	}
	function checktokenExist($token)
	{		
		$query = $this->db->get_where('user_reset_password_token', array('token' => trim($token)));
		
		$data = $query->row_array();
		$count = $query->num_rows();
		
		if($count>0)
			return $data;
		else
			return false;
	}
	function updateUserPassword($email,$password)
	  {
			
			$data = array(
				'password' => md5($password)
			); 
			
			$this->db->where('email', $email);
			$this->db->update('users_public ', $data);
	}
	function deleteToken($id)
	{
	    $sql = "DELETE FROM  user_reset_password_token WHERE token ='".$id."'";
		return $this->db->query($sql);
	}
	function checkEmailexist($email)
	{		
		$query = $this->db->get_where('users_public', array('email' => trim($email)));
		
		$data = $query->row_array();
		$count = $query->num_rows();
		
		if($count>0)
			return $data;
		else
			return false;
	}
	public function updateOrderData($order_id,$post)
	  {
			
			$data = array(
				            'first_name' => $post['first_name'],
                            'last_name' => $post['last_name'],
                            'email' => $post['email'],
                            'phone' => $post['phone'],
                            'address' => $post['address'],
							'post_code' => $post['post_code'],
                            'notes' => $post['notes']
			); 
			
			$this->db->where('for_id', $order_id);
			$this->db->update('orders_clients ', $data);
	}
	public function updateOrderInvoice($order_id,$pdfFilePath)
	  {
			
			$data = array(
				            'invoice_file' => $pdfFilePath
			); 
			
			$this->db->where('order_id', $order_id);
			$this->db->update('orders ', $data);
	}
	public function getPreviousAddress($user_id)
    {
        $this->db->where('user_address.user_id', $user_id);
        $this->db->select('*,countries.country_name,cities.name as city_name');
        //$this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
		$this->db->join('countries', 'countries.id = user_address.country', 'inner');
		$this->db->join('states', 'states.id = user_address.state', 'inner');
		$this->db->join('cities', 'cities.id = user_address.city', 'inner');
	    $this->db->order_by('user_address.address_id','DESC');
        $result = $this->db->get('user_address');
        return $result->result_array();
    }
	public function getDistrictByName($city)
    {
        $this->db->like('state_name', $city);
        $this->db->select('*');
		$this->db->limit(1);
        $result = $this->db->get('states');
        return $result->row_array();
    }
	public function changePaymentStatus($order_id, $status,$is_show = '')
    {
		$query = $this->db->get_where('orders', array('order_id' => $order_id));
		$main_order = $query->row_array();
		
		if($status == 'completed'){
			$update_array = array(
								'payment_status' => $status,
                                'is_show' => $is_show
								 );
			//Update O4rder Product Table
			$update_product_array = array(
								'orderstatus' => '0',
								'vendor_payment_status' => 'unpaid'
								 ); 
			
			$this->db->where('main_order_id', $main_order['id']);
			$this->db->update('order_product ', $update_product_array);
			
		}else{
			$update_array = array(
								'payment_status' => $status,
                                'is_show' => $is_show
								 );
			
			//Update O4rder Product Table					 
			$update_product_array = array(
								'orderstatus' => '4',
								'order_viewed' => '1',
								'cancel_reason' => 'Payment failed',
								'vendor_payment_status' => 'invalid'
								 ); 
			
			$this->db->where('main_order_id', $main_order['id']);
			$this->db->update('order_product ', $update_product_array);
			
			
		}
		
        $this->db->where('order_id', $order_id);
		
		
		
        if (!$this->db->update('orders', $update_array)) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
	public function getVendorList()
    {
        $this->db->select('warehouse_name');
        $this->db->order_by('warehouse_name', 'asc');
		$this->db->where('vendors.vendor_status', 1);
        $query = $this->db->get('vendors');
        return $query->result_array();
    }
	public function getProductStateList()
    {
        $this->db->select('state_name');
		$this->db->distinct();
        $this->db->order_by('state_name', 'asc');
        $query = $this->db->get('products');
        return $query->result_array();
    }
	public function getUserMainOrderDetails($order_id)
    {
        $this->db->where('main_order_id', $order_id);
        $this->db->select('orders.*,orders.id as orderID, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('orders');
        return $result->result_array();
    }
	public function getVariants($product_id)
    {
        $this->db->where('product_id', $product_id);
		$this->db->where('product_variants.status', 'show');
		$this->db->where('product_variants.price>0');
		$this->db->where('product_variants.quantity>0');
        $query = $this->db->select('*')->get('product_variants');
        return $query->result_array();
    }
    public function getVariantsFrPDP($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('product_variants.status', 'show');
        // $this->db->where('product_variants.price>0');
        // $this->db->where('product_variants.quantity>0');
        $query = $this->db->select('*')->get('product_variants');
        return $query->result_array();
    }
	 public function publicUsersWithEmail($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }
	public function addAddress($post)
    {
        $this->db->insert('user_address', array(
            'user_id' => $post['guest'],
            'first_name' =>$post['firstNameInput'],
			'last_name' => $post['lastNameInput'],
			'phone' => $post['phoneInput'],
			'country' => $post['countryInput'],
			'state' => $post['stateInput'],
			'city' => $post['thana'],
			'post_code' => $post['postInput'],
			'address' => $post['addressInput'],
			'notes' => $post['notes'],
			'created_at' => date('Y-m-d H:i:s'),
        ));
        return $this->db->insert_id();
    }
	public function deleteAddress($post)
    {
		 $sql = "DELETE FROM  user_address WHERE user_id ='".$post['guest']."' AND address_id='".$post['address_id']."'";
		return $this->db->query($sql);
		
    }
    public function deleteManageAddress($post)
    {
         $sql = "DELETE FROM  user_address WHERE address_id='".$post['address_id']."'";
        return $this->db->query($sql);
        
    }
	public function getAddressDetails($address_id)
    {
		$this->db->select('*,countries.country_name,cities.name as city_name,countries.phonecode');
		$this->db->join('countries', 'countries.id = user_address.country', 'inner');
		$this->db->join('states', 'states.id = user_address.state', 'inner');
		$this->db->join('cities', 'cities.id = user_address.city', 'inner');
        $this->db->where('address_id', $address_id);
        $query = $this->db->get('user_address');
        return $query->row_array();
    }
	 public function checkcourier_charge($id)
    {
      	$this->db->where('id', $id);
        $query = $this->db->get('products');
        $result = $query->row_array();
        if ($result['courier_charge']=='yes') {
            return true;
        } else {
            return false;
        }
    }
	 public function getShippingCharge($country,$weight)
    {
       $this->db->where('country', $country);
	    $this->db->where('weight>=', $weight);
        $query = $this->db->get('shipping_charge');
        return $query->row_array();
    }
	 public function categoryDetailsByFind($category)
    {
          $this->db->select('*');
		  $this->db->join('shop_categories_translations','shop_categories.id=shop_categories_translations.for_id');
		  $this->db->where(array('shop_categories_translations.category_slug' => $category));
		  
		  $data = $this->db->get('shop_categories');

		  $result_data = $data->row_array();
		  return $result_data;
    }
	public function submitReview($user_name,$review,$rating,$product_id,$order_id)
    {
		//Update Product table
		// $this->db->where('products.id', $product_id);
        // $query = $this->db->get('products');
		// $product_details = $query->row_array();
		// if($rating>$product_details['rating']){
		// 	$update_product_array = array(
		// 						'rating' => $rating
		// 						 ); 
			
		// 	$this->db->where('id', $product_id);
		// 	$this->db->update('products ', $update_product_array);
		// }
		
        $this->db->insert('product_review', array(
            'product_id' => $product_id,
            'user_id' =>$user_name,
			'order_id' => $order_id,
			'comment' => $review,
			'rating' => $rating,
			'created_date' => date('Y-m-d H:i:s'),
			'status' => 'active'
        ));
        return $this->db->insert_id();
    }
	public function getProductReview($product_id)
    {
        $this->db->where('product_id', $product_id);
		//$this->db->where('product_review.status', 'active');
		//$this->db->join('users_public','product_review.user_id=users_public.id');
		$this->db->order_by('product_review.review_id', 'desc');
        $query = $this->db->select('*')->get('product_review');
        return $query->result_array();
    }
    public function countTotalReview($product_id)
    {
        $this->db->where('product_id', $product_id);
        //$this->db->where('product_review.status', 'active');
        return $this->db->count_all_results('product_review');
    }
	function checkSocialUser($social_id)
	{		
		$query = $this->db->get_where('users_public', array('social_id' => $social_id));
		
		$data = $query->row_array();
		$count = $query->num_rows();
		
		if($count>0)
			return $data;
		else
			return false;
	}
	function createSocialMember($name,$email,$image_url,$social_id,$login_from)
	  {
		
			$data = array(
			'name' => $name,
            'phone' => "",
            'email' => $email,
            'password' => "",
			'social_id' => $social_id,
			'social_image_url' => $image_url,
			'social_login_source' => $login_from
			); 
			
			 $this->db->insert('users_public', $data);
			 return $this->db->insert_id();
	}
	public function insertReturnRequest($order_id,$product_id,$variant_id,$return_reason,$return_reason2,$filename)
    {
        $this->db->insert('order_return_update', array(
            'order_id' => $order_id,
            'product_id' => $product_id,
			 'variant_id' => $variant_id,
            'return_date' => date('Y-m-d H:i:s'),
            'return_status' => 'initiated',
			'return_accepted_at_warehouse' => 'no',
			'warehouse_return_date' => "",
			'reason1' => $return_reason,
			'reason2' => $return_reason2,
			'image_name' => $filename,
			'viewed' => 0
        ));
        return $this->db->insert_id();
    }
	public function getReturnReason()
    {
        $this->db->where('status', 'active');
		$query = $this->db->select('*')->get('return_reason');
        return $query->result_array();
    }
	public function getReturnSubReason($return_id)
    {
        $this->db->where('status', 'active');
		$this->db->where('reason_id', $return_id);
		$query = $this->db->select('*')->get('return_sub_reason');
        return $query->result_array();
    }
	public function getReturnReasonByID($id)
    {
        $this->db->where('id', $id);
		$query = $this->db->select('*')->get('return_reason');
        return $query->row_array();
    }
	public function getSubReturnReasonByID($id)
    {
        $this->db->where('sub_id', $id);
		$query = $this->db->select('*')->get('return_sub_reason');
        return $query->row_array();
    }
	public function itemAddedWishlist($userid, $product_id)
    {
        $this->db->select('*');
        $this->db->where('user_id', $userid);
		$this->db->where('product_id', $product_id);
		$this->db->where('status', 'active');
        $query = $this->db->get('user_wishlist');
        return $query->num_rows();
    }
	public function addWishlist($userid, $product_id)
    {
        $this->db->insert('user_wishlist', array(
            'user_id' => $userid,
            'product_id' =>$product_id,
			'status' => 'active'
        ));
        return $this->db->insert_id();
    }
	 public function getUserWishlistCount($userId)
    {
        $this->db->where('user_id', $userId);
		$this->db->where('status', 'active');
        return $this->db->count_all_results('user_wishlist');
    }
	public function getUserWishlist($userId, $limit, $page)
    {
		$this->db->where('user_wishlist.user_id', $userId);
        $this->db->order_by('user_wishlist.wishlist_id', 'DESC');
        $this->db->select('*');
		$this->db->join('products', 'user_wishlist.product_id = products.id', 'inner');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('product_variants', 'product_variants.product_id = products.id', 'inner');
		$this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
		$this->db->where('user_wishlist.status', 'active');
        $result = $this->db->get('user_wishlist', $limit, $page);
        return $result->result_array();
    }
	public function removeWishlist($userid, $product_id)
    {
		 $array = array(
            'status' => 'inactive',
        );
        $this->db->where('user_id', $userid);
        //$this->db->where('status', 'active');
		$this->db->where('product_id', $product_id);
        $this->db->update('user_wishlist', $array);
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
		$this->db->where('status', 'active');
		$this->db->order_by('attributes_set_option.attribute_title','ASC');
        $query = $this->db->select('*')->get('attributes_set_option');
        return $query->result();
    }
	public function setPickupLocation($post)
    {
		 if ($post['edit'] > 0) {
            $this->db->where('id', $post['edit']);
            unset($post['id'], $post['edit'],$post['submit']);
            if (!$this->db->update('pickup_location', $post)) {
				echo $this->db->error();
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        } else {
            unset($post['edit']);
			unset($post['submit']);
            if (!$this->db->insert('pickup_location', $post)) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        }
    }
	 public function getPickupLocation($user = null)
    {
		if ($user != null && is_numeric($user)) {
            $this->db->where('pickup_location.id', $user);
        }
		$this->db->join('cities', 'pickup_location.city = cities.id');
        $this->db->join('states', 'pickup_location.state = states.id');
		$query = $this->db->select('pickup_location.*, cities.name as city_name, states.state_name')->get('pickup_location');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }
    public function getActivePickupLocation($user = null)
    {
		$this->db->where('pickup_location.location_status', '1');
		$this->db->join('cities', 'pickup_location.city = cities.id');
        $this->db->join('states', 'pickup_location.state = states.id');
		$query = $this->db->select('pickup_location.*, cities.name as city_name, states.state_name')->get('pickup_location');
        return $query;
    }

    /* Start reward */
    public function setCustomerPoint($orders_info,$userInfo,$pointBalance,$currentPointBalance,$current_tier,$previous_tier)
    {
        if($previous_tier == ''){
            $previous_tier = 1;
        }
        if($current_tier == ''){
            $current_tier == 1;
        }
        //print_r("current_tier",$current_tier);
        $this->db->insert('customer_point', array(
            'orderID' => $orders_info['order_id'],
            'customerID' => $userInfo['id'],
            'pointBalance' => $pointBalance,
            'currentPointBalance' => $currentPointBalance,
            'transactionAmount' => $orders_info['total_order_price'],
            'transactionDate' => $orders_info['date'],
            'pointType' => '1',
            'current_tier' => $current_tier,
            'previous_tier' => $previous_tier,
            'pointStartDate' => date('Y-m-d'),
            'pointEndDate' => date('Y-m-d', strtotime("+364 days"))
        ));
        return $this->db->insert_id();
    }

    public function setCustomerPointForReffaralReward($customerID,$orders_info,$userInfo,$pointBalance,$currentPointBalance,$current_tier,$previous_tier)
    {
        if($previous_tier == ''){
            $previous_tier = 1;
        }
        if($current_tier == ''){
            $current_tier == 1;
        }
        //print_r("current_tier",$current_tier);
        $this->db->insert('customer_point', array(
            'orderID' => $orders_info['order_id'],
            'customerID' => $customerID,
            'pointBalance' => $pointBalance,
            'currentPointBalance' => $currentPointBalance,
            'transactionAmount' => $orders_info['total_order_price'],
            'transactionDate' => $orders_info['date'],
            'pointType' => '3',
            'current_tier' => $current_tier,
            'previous_tier' => $previous_tier,
            'pointStartDate' => date('Y-m-d'),
            'pointEndDate' => date('Y-m-d', strtotime("+364 days"))
        ));
        return $this->db->insert_id();
    }

    public function setCustomerPointRedeem($orders_info,$userInfo,$pointBalance,$currentPointBalance,$current_tier,$previous_tier)
    {
        if($previous_tier == ''){
            $previous_tier = 1;
        }
        $this->db->insert('customer_point', array(
            'orderID' => $orders_info['order_id'],
            'customerID' => $orders_info['user_id'],
            'pointBalance' => $pointBalance,
            'currentPointBalance' => $currentPointBalance,
            'transactionAmount' => $orders_info['total_order_price'],
            'transactionDate' => $orders_info['date'],
            'pointType' => '2',
            'current_tier' => $current_tier,
            'previous_tier' => $previous_tier,
            'pointStartDate' => date('Y-m-d'),
            'pointEndDate' => date('Y-m-d', strtotime("+364 days"))
        ));
        return $this->db->insert_id();
    }
    public function getCustomerPoint($customerID)
    {
        $this->db->select('*'); 
        $this->db->where('customerID', $customerID);
        $this->db->order_by('coustomerPointID', 'DESC');
        $result = $this->db->get('customer_point');
        return $result->row_array();
    }
    public function totalCurrentBalance($user_id)
    {        
        $this->db->select_sum('currentPointBalance'); 
        $this->db->where('customerID', $user_id);
        $query  = $this->db->get('customer_point');
        return $query->row()->currentPointBalance;
    }
    public function totalPointBalance($user_id)
    {        
        $this->db->select('*'); 
        $this->db->where('customerID', $user_id);
        $result = $this->db->get('customer_point');
        return $result->result_array();
    }
    
    public function getUserPointSum($user_id)
    {
        $this->db->select('*'); 
        $this->db->where('customerID', $user_id);
        $result = $this->db->get('user_point_rollups');
        return $result->row_array();
    }
    public function updateUserPointSum($orders_info, $totalAmount, $tierMasterID, $currentPointBalance,$total_transactionAmount,$paid_amount='')
    {
        // if($paid_amount != ''){
        //     $paid_amount = $totalAmount - $paid_amount;
        // }
        // else{
        //     $paid_amount = $totalAmount;
        // }
        $array = array(
            'totalEarnPoint' => $totalAmount,
            'balancePont' => $totalAmount,
            'bonusPoint' => '',
            'total_purchased_value' => $totalAmount,
            'tier' => $tierMasterID
        );
        $this->db->where('customerID', $orders_info['user_id']);
        $this->db->update('user_point_rollups', $array);
    }
    public function updateUserPointRollUps($customerID, $tierMasterID, $totalEarnPoint,$totalbalancePoint,$totalbonusPoint,$total_transactionAmount,$redeem_point)
    {
        $array = array(
            'totalEarnPoint' => $totalEarnPoint,
            'balancePont' => $totalbalancePoint,
            'bonusPoint' => $totalbonusPoint,
            'tier' => $tierMasterID,
            'total_purchased_value' => $total_transactionAmount,
            'redeem_point'=>$redeem_point
        );
        $this->db->where('customerID', $customerID);
        $this->db->update('user_point_rollups', $array);
    }
    public function updateUserPointRollUpsFrPoint($customerID, $totalbalancePoint,$redeem_point)
    {
        $array = array(
            'balancePont' => $totalbalancePoint,
            'redeem_point'=>$redeem_point
        );
        $this->db->where('customerID', $customerID);
        $this->db->update('user_point_rollups', $array);
    }
    public function setUserPointSum($orders_info, $totalAmount, $tierMasterID, $currentPointBalance,$total_transactionAmount)
    {
        $this->db->insert('user_point_rollups', array(
            'customerID' => $orders_info['user_id'],
            'totalEarnPoint' => $totalAmount,
            'balancePont' => $totalAmount,
            'bonusPoint' => '',
            'total_purchased_value' => $orders_info['total_order_price'],
            'tier' => $tierMasterID
        ));
        return $this->db->insert_id();
    }
    public function totalTransactionBalance($userID)
    {
        $order_year = date('Y');
        $this->db->select_sum('total_order_price'); 
        $this->db->where("(orders.payment_status = 'completed') ");
        //$this->db->or_where('orders.payment_status', null);
        $this->db->where('user_id', $userID);
        //$this->db->where('order_year', $order_year);
        $query  = $this->db->get('orders');
        return $query->row()->total_order_price;
    }
    public function totalSuccTransaction($userID){
        $this->db->select('*'); 
        $this->db->where('user_id', $userID); 
        $result = $this->db->get('orders');
        return $result->result_array();
    }
    public function totalReward($totalAmount=''){
        $this->db->select('*'); 
        if($totalAmount != ''){
        $this->db->where('tier_startValue <= ', $totalAmount);
        $this->db->where('tier_endValue >= ', $totalAmount); 
        }
        $result = $this->db->get('tier_master');
        return $result->row_array();
    }
    public function getTier($totalAmount)
    {
        $this->db->select('*'); 
        if($totalAmount != ''){
        $this->db->where('tier_startValue <=', $totalAmount);
        $this->db->where('tier_endValue >=', $totalAmount); 
        }
        $result = $this->db->get('tier_master');
        return $result->row_array();

    }

    public function totalRewardPoint($userID){
        $this->db->select('*'); 
        $this->db->where('customerID ', $userID);
        $result = $this->db->get('user_point_rollups');
        return $result->row_array();
    }
     public function totalRewardPointForReward($userID){
        $this->db->select('*'); 
        $this->db->where('customerID ', $userID);
        $result = $this->db->get('user_point_rollups');
        return $result->row_array();
    }
    public function updatePoint_redeem_otp($request_id)
    {
        $this->db->set('is_active', 'inactive');
        $this->db->where('request_id', $request_id);
        $this->db->update('point_redeem_otp');

        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function find_tier($tier){
        $this->db->select('*'); 
        $this->db->where('tierMasterID ', $tier);
        $result = $this->db->get('tier_master');
        return $result->row_array();
    }

    /* End reward */


    /* FOR COUPONS */

    public function isValidNEOFIRST($id)
    {
        $this->db->select('*');
        $this->db->where('user_id', $id);
        $this->db->where('is_show', '0');
        // $this->db->where('payment_status', 'completed');
        $query = $this->db->get('orders');
        return $query->row_array();
    }
     public function getUserOrderDetailsForOrder($order_id)
    {
        
        echo $order_id;
        $this->db->where('orders.order_id', $order_id);
        $this->db->select('orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, '
                . 'order_product.id as suborder_id, order_product.order_update_date, order_product.order_products, order_product.order_product_id, order_product.orderstatus, order_product.order_viewed, order_product.tracking_number');
        $this->db->join('order_product', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('orders');
        return $result->row_array();
    }



    /*  END FOR COUPONS */

    public function getproductList($productID)
    {
        //echo $productID;
        $this->db->where('products.id', $productID);
        $this->db->join('products_translations', 'products_translations.for_id = products.id');
        $this->db->join('product_variants', 'product_variants.product_id = products.id');
        $query = $this->db->select('products_translations.id as productsTranslationsID, products.id as productID, products_translations.title as productTitle, product_variants.variant_id as variantID, product_variants.price as variantPrice, products.image')->get('products');
        return $query->row_array();
    }
    public function getConcern()
    {
        $this->db->select('*');
        $this->db->where('status', 'active');
        $this->db->order_by('concern_shopID ', 'DESC');
        $query = $this->db->get('concern_shop');
        return $query->result_array();
    }
    public function getTestimonial()
    {
        $this->db->select('*');
        $this->db->where('status', 'active');
        $this->db->order_by('testimonialsId', 'DESC');
        $query = $this->db->get('testimonials');
        return $query->result_array();
    }
    public function getRegime()
    {
        // if (!empty($big_get)) {
        //     $this->getFilter($big_get);
        // }
        $this->db->select('vendors.url as vendor_url, products.id,products.image, products.quantity, products_translations.title, products_translations.default_price, products_translations.default_old_price, products.url, products.vendor_id, products.city_name, products.state_name, products.rating, products.product_title, products.rating, products.folder');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('product_attributes', 'products.id = product_attributes.product_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('vendors.vendor_status', 1);
        $this->db->where('products.is_giftset', 'yes');
        $this->db->order_by('products.id', 'DESC');
        //$this->db->where('products.product_type', 'regime');
        //$this->db->distinct();
        //  if (!empty($big_get) && isset($big_get['orderby'])) {
        //    if($big_get['orderby'] == 'price')
        //    $this->db->order_by('products_translations.default_price','ASC');
        //    else if($big_get['orderby'] == 'price-desc')
        //    $this->db->order_by('products_translations.default_price','DESC');
        //    else
        //    $this->db->order_by('products.position','ASC');
        // }
        // if ($vendor_id !== false) {
        //     $this->db->where('vendor_id', $vendor_id);
        // }
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        if ($this->multiVendor == 0) {
            $this->db->where('vendor_id', 0);
        }
       
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function getStoreLocator()
    {
        $this->db->select('*');
        $this->db->where('store_status', 'Active');
        $this->db->where('store_pincode != ', '');
        $query = $this->db->get('store_locator');
        return $query->result_array();
    }
    public function getStore($pincode)
    {
        $this->db->select('*');
        if($pincode != ''){
        $this->db->where('store_pincode', $pincode);
        //$this->db->group_by('store_name');
        }
        $query = $this->db->get('store_locator');
        return $query->result_array();
    }
    public function getTrendingProduct(){

         $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.basic_description, products_translations.default_old_price, products.rating, products_translations.description, product_variants.weight, product_variants.weight_unit');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('products.is_trending_product', "yes");
        $this->db->order_by('products.position','ASC');
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $query = $this->db->get('products');
        return $query->result_array();

    }
    public function get_attributes_set_option(){
        $this->db->select('*');
        $query = $this->db->get('shop_categories_translations');
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
        //$this->db->where('vendors.vendor_status', 1);
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function getSinglefrequentlyBought($sku)
    {
        $this->db->select('products_translations.id as productsTranslationsID, products.id as productID, products_translations.title as productTitle, product_variants.variant_id as variantID, product_variants.price as variantPrice, products.image as image, products.product_title');
        $this->db->where('products.sku', $sku);
        //$this->db->where('product_variants.quantity > 0');
        $this->db->join('products_translations', 'products_translations.for_id = products.id');
        $this->db->join('product_variants', 'product_variants.product_id = products.id');
       
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function getRecentlyAddedProduct()
    {
        $this->db->select('products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.basic_description, products_translations.default_old_price, products.rating, products_translations.description, product_variants.weight, product_variants.weight_unit, product_variants.variant_id, products.product_title as p_title,products.folder');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        //$this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('products.is_newly_launch', 'yes');
        $this->db->order_by('products.id','DESC');
        //$this->db->limit(6);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function update_most_view($data, $id)
    {
        $this->db->set('most_view', $data);
        $this->db->where('id', $id);
        $this->db->update('products');
    }
    public function getMostViewProduct(){
        $this->db->select('products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.basic_description, products_translations.default_old_price, products.rating, products_translations.description, product_variants.weight, product_variants.weight_unit');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        //$this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->order_by('products.most_view','DESC');
        $this->db->limit(8);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function getRegimeProduct(){
        $this->db->select('products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.basic_description, products_translations.default_old_price, products.rating, products_translations.description, product_variants.weight, product_variants.weight_unit, products.folder');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        //$this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->order_by('products.product_type','regime');
        $this->db->limit(5);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $query = $this->db->get('products');
        return $query->result_array();
    }
      public function getFeatured_products()
    {
        $this->db->select('products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.basic_description, products_translations.default_old_price, products.rating, products_translations.description, product_variants.weight, product_variants.weight_unit, product_variants.variant_id,products.product_title as p_title');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        //$this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('product_variants', 'product_variants.product_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('visibility', 1);
        $this->db->where('products.is_featured_products', 'yes');
        $this->db->order_by('products.id','DESC');
        //$this->db->limit(6);
        if ($this->showOutOfStock == 0) {
            $this->db->where('quantity >', 0);
        }
        $query = $this->db->get('products');
        return $query->result_array();
    }
     public function checkUserIsValid($mobile)
    {
        $this->db->where('phone', $mobile);
        $query = $this->db->get('users_public');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    public function insertPointRedeemOTP($mobile, $request_id, $otp, $redeem_paid_point){
        $this->db->insert('point_redeem_otp', array(
            'request_id' => $request_id,
            'mobile' => $mobile,
            'otp_code' => $otp,
            'point' => $redeem_paid_point
        ));
        return $this->db->insert_id();
    }
    public function updateOtp($otp, $mobile){
        $this->db->set('otp',$otp);
        $this->db->where('phone', $mobile);
        $this->db->update('users_public');
    }
     public function checkOTPIsValid($otp, $mobile)
    {
        $this->db->where('otp', $otp);
        $this->db->where('phone', $mobile);
        $query = $this->db->get('users_public');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    public function checkRewardOTPIsValid($otp, $mobile){
        $this->db->where('otp_code', $otp);
        $this->db->where('mobile', $mobile);
        $this->db->where('is_active', 'active');
        $query = $this->db->get('point_redeem_otp');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }

     public function mobileExist($mobile)
    {
        $this->db->where('phone', $mobile);
        $query = $this->db->get('users_public');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    public function registration($post, $own_referral,$other_referral= '')
    {
        $this->db->insert('users_public', array(
            'name' => $post['first_name'],
            'last_name' => $post['last_name'],
            'phone' => $post['mobile'],
            'email' => $post['email'],
            'dob' =>  $post['dob'],
            'gender' =>  $post['gender'],
            'own_referral' =>  $own_referral,
            'other_referral' =>  $other_referral
        ));
        return $this->db->insert_id();
    }
    public function insertUserPointRollups($userid){
        $this->db->insert('user_point_rollups', array(
            'customerID' => $userid,
            'tier' => 1
        ));
        return $this->db->insert_id();
    }
    public function fetch_singleDeliveryAddress($id){
        $this->db->select('*');
        $this->db->where('address_id', $id);
        $query = $this->db->get('user_address');
        return $query->row_array();
    }
    public function fetch_singlePersonalProfile($id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }
     public function getUserAddress($id)
    {
        $this->db->where('user_id', $id);
        $query = $this->db->get('user_address');
        return $query->result_array();
    }
    public function getAllCoupons($mobile){
        $time = time();
        $this->db->select('*');
        $this->db->where($time . ' BETWEEN valid_from_date AND valid_to_date');
        $this->db->where('status', '1');
        //$this->db->where('showForAll', 'yes');
        $this->db->where("(showForAll ='yes' OR user_phone_number='".$mobile."')", NULL, FALSE);
        $query = $this->db->get('discount_codes');
        return $query->result_array();
    }
    public function getGiftVouchers($logged_user){
        $time = time();
        $this->db->select('*');
        $this->db->where('couponStatus', '1');
        $this->db->where('userID', $logged_user);
        //$this->db->where("(showForAll ='yes' OR user_phone_number='".$mobile."')", NULL, FALSE);
        $query = $this->db->get('giftcoupon');
        return $query->result_array();
    }
    public function addNewAddress($post, $stateID, $cityID){
      $this->db->insert('user_address', array(
            'user_id' => $_SESSION['logged_user'],
            'first_name' => $post['add_name'],
            'last_name' => $post['add_last_name'],
            'phone' => $post['add_mob'],
            'country' => '101',
            'state' => $stateID,
            'city' => $cityID,
            'post_code' => $post['add_pincode'],
            'address' => $post['add_build_name'],
            'road_name' => $post['add_road_name'],
            'landmark' => $post['landmark'],
            'notes' => $post['notes'],
            'city_name' => $post['add_city'],
            'state_name' => $post['add_state'],
            'created_at' => date('Y-m-d H:i:s')
        ));
        return $this->db->insert_id();   
    }
    public function addSkinQuiz($post){
      $this->db->insert('skin_quiz', array(
            'name' => $post['quiz_name'],
            'age' => $post['quiz_age'],
            'mobile' => $post['quiz_number'],
            'email' => $post['quiz_email'],
            'userID' => $_SESSION['logged_user'],
            'productID' => "",
            'concern' => "",
        ));
        return $this->db->insert_id();   
    }
    public function updateConcernName($concern_name,$last_insert_id){
        $array = array(
            'concern' => $concern_name
            
        );
        $this->db->where('skinQuizID', $last_insert_id);
        $this->db->update('skin_quiz', $array);
    }

    public function allCategory(){
        $this->db->select('shop_categories_translations.name, shop_categories_translations.category_slug, shop_categories_translations.id');
        $query = $this->db->get('shop_categories_translations');
        return $query->result_array();
    }
    public function updateUnicommerceToken($array){

        $this->db->where('tokenID', '1');
        $this->db->update('token', $array);
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function updateShiprocketToken($token){

        $array = array(
            'access_token' => $token
        );

        $this->db->where('tokenID', '2');
        $this->db->update('token', $array);
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    
    public function getUnicommerceToken(){
        $this->db->select('*');
        $this->db->where('tokenID', '1');
        $query = $this->db->get('token');
        return $query->row_array();
    }
    public function fetchShiprocketToken(){
        $this->db->select('*');
        $this->db->where('tokenID', '2');
        $query = $this->db->get('token');
        return $query->row_array();
    }
    public function insertContacts($post){
         $this->db->insert('contacts', array(
            'name' => $post['name'],
            'contact_number' => $post['contact_number'],
            'email' => $post['email'],
            'message' => $post['message'],
            'created_at' => date('Y-m-d H:i:s')
        ));
        return $this->db->insert_id();   
    }
    public function getBlogPosts($id){
        $this->db->select('*');
        $this->db->where('blog_posts.id !=', $id);
        $this->db->join('blog_translations', 'blog_translations.for_id = blog_posts.id', 'left');
        $this->db->order_by('blog_posts.id', 'desc');
        $this->db->limit(2);
        $query = $this->db->get('blog_posts');
        return $query->result_array();
    }
    public function getCitylist($stateID){
        $this->db->select('*');
        $this->db->where('state_id ', $stateID);
        $this->db->order_by('name','ASC');
        $query = $this->db->get('cities');
        return $query->result_array();
    }
    public function updateNewAddress($id, $post, $stateID, $cityID){
        $array = array(
            'first_name' => $post['add_name'],
            'last_name' => $post['add_last_name'],
            'phone' => $post['add_mob'],
            'country' => '101',
            'state' => $stateID,
            'city' => $cityID,
            'post_code' => $post['add_pincode'],
            'address' => $post['add_build_name'],
            'road_name' => $post['add_road_name'],
            'city_name' => $post['add_city'],
            'state_name' => $post['add_state'],
            'landmark' => $post['landmark']
        );
        $this->db->where('address_id', $id);
        $this->db->update('user_address', $array);
        
    }
    public function categoryBanner($category){
        $this->db->select('*');
        //$this->db->like('category', $category, 'both');
        $this->db->where('category', $category);
        $query = $this->db->get('product_list_banner');
        return $query->row_array();
    }
    public function updateRollups($userID, $balancePont, $paidPoin='')
    {
        //print_r($currentPointBalance); die();
        $array = array(
            'balancePont' => $balancePont,
            'redeem_point' => $paidPoin
        );
        $this->db->where('customerID', $userID);
        $this->db->update('user_point_rollups', $array);
    }
     public function updatePersonalInfo($id, $post){
        $array = array(
            'name' => $post['name'],
            'last_name' => $post['last_name'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'dob' => $post['dob'],
            'gender' => $post['gender'],
            'anniversary' => $post['anniversary'],
            'marital_status' => $post['marital_status']
        );
        $this->db->where('id', $id);
        $this->db->update('users_public', $array);
        
    }
     public function addNewDoctorConsultation($post, $stateID, $cityID){
      $this->db->insert('doctor_consultation', array(
            'name' => $post['name'],
            'mobile_number' => $post['mobile'],
            'state' => $stateID,
            'city' => $cityID
        ));
        return $this->db->insert_id();   
    }
    public function findProduct($id){
        $this->db->select('vendors.url as vendor_url, products.id, products.quantity, products.image, products.url, products_translations.default_price, products_translations.title, products_translations.default_old_price, products.rating');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products.id', $id);
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);
        $this->db->where('products.in_slider', 0);
        $this->db->where('visibility', 1);
        $this->db->where('vendors.vendor_status', 1);
        $query = $this->db->get('products');
        return $query->result_array();
    }
    public function checkIsreferral($userID){
        $this->db->select('*');
        $this->db->where('id', $userID);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }
    public function checkIsReferralInOrder($userID, $referralCode){
        $this->db->where("(user_id='".$userID."' AND isReferral='".$referralCode."' AND payment_status != 'pending')", NULL, FALSE);
        $query = $this->db->get('orders');
        $result = $query->row_array();
        if (empty($result)) {
            return true;
        } else {
            return false;
        }
    }
    public function checkIsReferralOwner($rCode){
        $this->db->select('*');
        $this->db->where('own_referral', $rCode);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }
    public function getOtherReferral($rCode){
        $this->db->select('*');
        $this->db->where('other_referral', $rCode);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }
    public function checkIsReferralInOrderTwo($userEmail, $referralCode){
        // $this->db->where("(user_email='".$userEmail."' AND isReferral='".$referralCode."')", NULL, FALSE);
        // $query = $this->db->get('orders');
        // $result = $query->result_array();

        $this->db->select('*');
        $this->db->where("(isReferral LIKE '%$referralCode%')");
        //$this->db->like('user_email', $userEmail, 'both');
        //$this->db->like('isReferral', $referralCode, 'both');
        $query = $this->db->get('orders');
        return $query->result_array();
        // if (empty($result)) {
        //     return true;
        // } else {
        //     return false;
        // }
    }
     public function updateOwnerBonusPoint($customerID, $tot_bonus_point)
    {
        //echo $tot_bonus_point;
        $data = array(
            'bonusPoint' => $tot_bonus_point
        );
        $this->db->where('customerID', $customerID);
        $this->db->update('user_point_rollups', $data);
        {
            log_message('error', print_r($this->db->error(), true));
        }
    }
     public function updateUserBonusPoint($user_id, $tot_bonus_point)
    {
        //print_r($currentPointBalance); die();
        $array = array(
            'bonusPoint' => $tot_bonus_point
        );
        $this->db->where('customerID', $user_id);
        $this->db->update('user_point_rollups', $array);
    }
    public function ownerReferralCode($referral_code){
        $this->db->select('*');
        //$this->db->like('own_referral', $referral_code, 'both'); 
        $this->db->where('own_referral', $referral_code);
        $query = $this->db->get('users_public');
        return $query->row_array();
    }
    public function ownerBonusPoint($id){
        $this->db->select('*');
        $this->db->where('customerID', $id);
        $query = $this->db->get('user_point_rollups');
        return $query->row_array();
    }
    public function reward_details($userID){
        $this->db->select('*');
        $this->db->where('customerID', $userID);
        $query = $this->db->get('user_point_rollups');
        return $query->row_array();
    }
    public function findOrderID($order_id){
        $this->db->select('*');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('orders');
        return $query->row_array();
    }
    public function insertRazorpay_transaction_data($orderID,$post,$razorpay_order_id){
        $this->db->insert('razorpay_transaction_data', array(
            'orderID' => $orderID,
            'razorpay_payment_id' => $post['razorpay_payment_id'],
            'razorpay_signature' => $post['razorpay_signature'],
            'razorpay_order_id' => $razorpay_order_id
        ));
        return $this->db->insert_id();
    }
    public function updateTeransactionPaymentID($orderID,$razorpay_order_id){
        $array = array(
            'payment_id' => $razorpay_order_id
        );
        $this->db->where('order_id', $orderID);
        $this->db->update('orders', $array);
    }
    public function getpayID($orderID){
        $this->db->select('*');
        $this->db->where('orderID', $orderID);
        $query = $this->db->get('razorpay_transaction_data');
        return $query->row_array();
    }
    public function updateFullOrderStatus($orderID){
        $array = array(
            'order_status' => 'cancel'
        );
        $this->db->where('id', $orderID);
        $this->db->update('orders', $array);
    }
    public function updateFullOrderForStatus($orderID){
        $array = array(
            'order_status' => 'returned'
        );
        $this->db->where('id', $orderID);
        $this->db->update('orders', $array);
    }
    public function getAllOrder(){
        $this->db->select('*'); 
        $this->db->where_not_in('processed', [0,4,9]);
        // $this->db->where(array('processed !=' => 0));
        // $this->db->where(array('processed !=' => 3));
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('orders');
        return $result->result_array();
    }
    public function changeOrderStatusLineItem($id, $productID, $status){
        $array = array(
            'status' => $status,
            'order_update_date' =>  date('Y-m-d H:i:s')
        );
        $this->db->where('order_product_id', $productID);
        $this->db->update('order_product', $array);
    }
    public function getAllTracking(){
        $this->db->select('*');     
        $result = $this->db->get('order_tracking');
        return $result->result_array();
    }
    public function trackingOrderInsert($orderID,$orderProductID,$skuCode,$status){
        $this->db->insert('order_tracking', array(
            'orderID' => $orderID,
            'order_product_id' => $orderProductID,
            'skuCode' => $skuCode,
            'status' => $status
        ));
        return $this->db->insert_id();
        
    }
    public function findStore($id){
        $this->db->select('*'); 
        $this->db->where('storeLocatorID', $id);
        $result = $this->db->get('store_locator');
        return $result->row_array();
    }
    public function findOrder($id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('orders');
        return $query->row_array();
    }
    public function changeOrderStatusCancelLineItem($id, $status){
        if ($status == 'cancel') {
            $orderstatus = 4;
        }
        $array = array(
            'orderstatus' => $orderstatus,
            'order_update_date' =>  date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        $this->db->update('order_product', $array);
    }    
    public function findCustomarPoint($order_product_id, $orderID, $userID){
        $this->db->select('*');
        $this->db->where('order_product_id', $order_product_id);
        $this->db->where('orderID', $orderID);
        $this->db->where('customerID', $userID);
        $query = $this->db->get('customer_point');
        return $query->row_array();
    }
    public function findCustomarPointCod($id,$userID, $orderID){
        $this->db->select('*');
        $this->db->where('order_product_id', $id);
        $this->db->where('customerID', $userID);
        $this->db->where('orderID', $orderID);
        $query = $this->db->get('customer_point');
        return $query->row_array();
    }
    public function findCustomarPointCancelreturn($userID,$orderID){
        $this->db->select('*');
        $this->db->where('orderID', $orderID);
        $this->db->where('customerID', $userID);
        $query = $this->db->get('customer_point');
        return $query->row_array();
    }
    public function insertCustomarPoint($orders_info,$currentBalance,$current_tier,$previous_tier){
        if($previous_tier == ''){
            $previous_tier = 1;
        }
        if($current_tier == ''){
            $current_tier == 1;
        }
        $this->db->insert('customer_point', array(
            'orderID' => $orders_info['order_id'],
            'customerID' => $orders_info['user_id'],
            'pointBalance' => $orders_info['unit_price'],
            'currentPointBalance' => $currentBalance,
            'transactionAmount' => $orders_info['unit_price'],
            'transactionDate' => $orders_info['date'],
            'pointType' => '1',
            'current_tier' => $current_tier,
            'previous_tier' => $previous_tier,
            'pointStartDate' => date('Y-m-d'),
            'pointEndDate' => date('Y-m-d', strtotime("+364 days")),
            'order_product_id' => $orders_info['id']
        ));
        return $this->db->insert_id();
    }
    public function getOrderLineitem($id){
        $this->db->select('*');
        $this->db->where('order_product.id', $id);
        //$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $result = $this->db->get('order_product');
        return $result->row_array();
    }
       public function getOrders($order_id)
    {
        $this->db->where('orders.order_id', $order_id);
        $this->db->select('orders.*,orders.id as orderID, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_value');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('orders');
        return $result->row_array();
    }
    public function getBirthdayTier(){
        $this->db->select('*');
        $this->db->where('MONTH(users_public.dob)', date('m'));
        $this->db->where_in('user_point_rollups.tier', [2,3]);
        $this->db->join('users_public', 'users_public.id = user_point_rollups.customerID', 'inner');
        $query = $this->db->get('user_point_rollups');
        return $query->result_array();
    }
    public function getBirthdayTierBydate(){
        $date = date('Y-m-d');
        //$curr_date = $date->format('Y-m-d');


        $this->db->select('*');
        //$this->db->where('DATE(Date)',$curr_date);
        $this->db->where('DATE(users_public.dob)', $date);
        $this->db->where_in('user_point_rollups.tier', [2,3]);
        $this->db->join('users_public', 'users_public.id = user_point_rollups.customerID', 'inner');
        $query = $this->db->get('user_point_rollups');
        return $query->result_array();
    }
    public function isValidUserSpecificCoupon($userMobile, $coupon){
        $this->db->where("(user_phone_number ='".$userMobile."' AND code='".$coupon."')", NULL, FALSE);
        $this->db->where_not_in('status', 2);
        $query = $this->db->get('discount_codes');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    public function updateDiscountCode($phone){
        $this->db->where('user_phone_number', $phone);
        if (!$this->db->update('discount_codes', array(
                    'status' => 2
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function updateGiftDiscountCode($voucher, $orderID){        
        $array = array(
            'couponStatus' => '2',
            'purchase_orderID' => $orderID,
        );
        $this->db->where('voucher', $voucher);
        $this->db->update('giftcoupon', $array);
    }
    public function setGiftCoupon($price,$name,$email,$message,$mobile, $userID,$order_id){
        $this->db->insert('giftcoupon', array(
            'giftCouponTo' => $name,
            'giftCouponEmail' => $email,
            'giftCouponMobile' => $mobile,
            'giftCouponMessage' => $message,
            'giftCouponAmount' => $price,
            'userID' => $userID,
            'transitionStatus' => 'pending',
            'transitionID' => $order_id,
            'couponStatus' => '1'
        ));
        return $this->db->insert_id();
         {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function updaetGiftCardDetails($giftCouponID,$coupon){
        $this->db->where('giftCouponID', $giftCouponID);
        if (!$this->db->update('giftcoupon', array(
                    'transitionStatus' => 'success',
                    'voucher' => $coupon,
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }
    public function findTrackingData($order_id, $sku){
        $this->db->select('*');
        $this->db->where('orderID', $order_id);
        //$this->db->where('order_product_id', $order_productID);
        $this->db->where('skuCode', $sku);
        $result = $this->db->get('order_tracking');
        return $result->result_array();
    }
    public function getIngredientData($ingredients_id){
        $this->db->select('*');
        $this->db->where('ingredients_id', $ingredients_id);
        $result = $this->db->get('ingredientsdetais');
        return $result->row_array();
    }
    public function findTrackingDataTrack($order_id, $order_productID, $sku){
        $this->db->select('*');
        $this->db->where('orderID', $order_id);
        //$this->db->where('order_product_id', $order_productID);
        $this->db->where('skuCode', $sku);
        $this->db->limit(1);
        $this->db->order_by('order_trackingID', 'DESC');
        $result = $this->db->get('order_tracking');
        return $result->row_array();
    }
    public function wishListSelectedData($productID,$userID){
        $this->db->select('*');
        $this->db->where('user_id', $userID);
        $this->db->where('product_id', $productID);
        $this->db->where('status', 'active');
        $result = $this->db->get('user_wishlist');
        return $result->row_array();
    }
    public function getaboutUs(){
        $this->db->select('*');
        $this->db->where('id', '1');
        $result = $this->db->get('about_us');
        return $result->row_array();
    }
    public function getaboutUsBanner(){
        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('about_us_banner');
        return $result->result();
    }
    public function updateProductsInventory($inventory, $id){
        $array = array(
            'quantity' => $inventory
        );
        $this->db->where('product_id', $id);
        $this->db->update('product_variants', $array);
    }
    public function get_ingredients(){
        $this->db->select('*');
        $this->db->where('status', 'Active');
        $result = $this->db->get('ingredients');
        return $result->result_array();
    }
    public function singleTag($id){
        $this->db->select('*');
        $this->db->where('ingredientsID', $id);
        $result = $this->db->get('ingredients');
        return $result->row_array();
    }
    public function changeOrderStatus($id, $to_status)
    {
        $this->db->where('id', $id);
        $this->db->select('orderstatus,order_products');
        $result1 = $this->db->get('order_product');
        $res = $result1->row_array();        
        $result = true;
        if ($res['orderstatus'] != $to_status) {
            
                $this->manageQuantitiesAndProcurement($id, $to_status, $res['orderstatus'], $res);
           
        }
        return $result;
    }
     private function manageQuantitiesAndProcurement($id, $to_status, $current, $res)
    {
        if ($to_status == 1) {
            $operator = '-';
            $operator_pro = '+';
        }
        if ($to_status == 0 || $to_status == 'approved') {
            $operator = '+';
            $operator_pro = '-';
        }
        $products = unserialize($res['order_products']);
        // echo "<pre>";
        // print_r($products['product_quantity']);
        //foreach($products as $product){

             if (isset($operator)) {
                    if (!$this->db->query('UPDATE product_variants SET quantity=quantity' . $operator . $products['product_quantity'] . ' WHERE variant_id = ' . $products['product_info']['variant_id'])) {
                        log_message('error', print_r($this->db->error(), true));
                        show_error(lang('database_error'));
                    }
                }
                if (isset($operator_pro)) {
                    if (!$this->db->query('UPDATE products SET procurement=procurement' . $operator_pro . $products['product_quantity'] . ' WHERE id = ' . $products['product_info']['id'])) {
                        log_message('error', print_r($this->db->error(), true));
                        show_error(lang('database_error'));
                    }
               }  
        //}
    }

    public function expiryPoint(){
        $curent_date   = date('Y-m-d');
        $this->db->select('*');
        $this->db->where('pointEndDate <', $curent_date);
        $this->db->where('pointType !=', '2');
        $result = $this->db->get('customer_point');
        return $result->result_array();
    }
    public function nxtSavenDays(){
        $nxtSavenDays   = date("Y-m-d", strtotime('+7 days'));
        $this->db->select('*');
        $this->db->where('pointEndDate', $nxtSavenDays);
        $this->db->where('pointType !=', '2');
        $result = $this->db->get('customer_point');
        return $result->result_array();
    }
    public function getTotCustomerPoint($customerID)
    {
        $this->db->select('*'); 
        $this->db->where('customerID', $customerID);
        $result = $this->db->get('user_point_rollups');
        return $result->row_array();
    }
    public function updateExpiryRollups($customerID, $balancePont){
        $array = array(
            'balancePont' => $balancePont
        );
        $this->db->where('customerID', $customerID);
        $this->db->update('user_point_rollups', $array);
        
    }
    public function updateCustomerPointExpFlag($id){
        $array = array(
            'point_exp_flag' => '2'
        );
        $this->db->where('coustomerPointID', $id);
        $this->db->update('customer_point', $array);
        
    }
     public function checkCartProductExist($productID, $userID)
    {
        $this->db->where("(product_id='".$productID."' AND user_id='".$userID."')", NULL, FALSE);
        
        $query = $this->db->get('cart');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    public function getProductPrice($productID)
    {
        $this->db->select('*'); 
        $this->db->where('product_id', $productID);
        $result = $this->db->get('product_variants');
        return $result->row_array();
    }
    public function insertCart($productID, $userID, $price){

        $this->db->insert('cart', array(
            'product_id' => $productID,
            'user_id' => $userID,
            'amount' => $price,
            'created_date' => date('Y-m-d H:i:s')
        ));
        return $this->db->insert_id();
    }

    public function insertCartQuiz($productID, $userID, $price,$qty,$category_type){

        $this->db->insert('cart', array(
            'product_id' => $productID,
            'user_id' => $userID,
            'amount' => $price,
            'isQuizProduct' => 'yes',
            'quizProductQty' => $qty,
            'category_type' => $category_type,
            'created_date' => date('Y-m-d H:i:s')
        ));
        return $this->db->insert_id();
    }
     public function updateCartQuiz($productID, $userID, $product_qunaitity, $price,$quiz_product_qty)
    {
        $array = array(
            'qty' => $product_qunaitity,
            'amount' => $price,
            'isQuizProduct' => 'yes',
            'quizProductQty' => $quiz_product_qty,
        );
        $this->db->where('product_id', $productID);
        $this->db->where('user_id', $userID);
        $this->db->update('cart', $array);
    }
    public function removeFromCartTable($productID, $userID){

        $sql = "DELETE FROM  cart WHERE product_id ='".$productID."' AND user_id='".$userID."'";
        return $this->db->query($sql);
    }
     public function updateCart($productID, $userID, $product_qunaitity)
    {
        $array = array(
            'qty' => $product_qunaitity,
            'send_push' => '0',
            'push_date' => NULL,
        );
        $this->db->where('product_id', $productID);
        $this->db->where('user_id', $userID);
        $this->db->update('cart', $array);
    }

    public function concernCategory($category){
        $this->db->select('*');
        $this->db->like('category_slug', $category, 'both'); 
        $query = $this->db->get('shop_categories_translations');
        return $query->row_array();
    }
    public function fetchQuizProduct($category,$specified_type,$skin_type,$your_skin_type){
        //$this->db->where('find_in_set("'.$category.'", shop_categorie) <>0');
        if($category == 27){
            $this->db->where_in('products.sku', [534,541,547,559]);
        }
        else if($category == 26){
            if($specified_type == 'Blackheads'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
            }
            if($specified_type == 'ExcessSebumOil'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
            }
            if($specified_type == 'Whiteheads'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [524,523,535,559]);
                }
            }
        }
        else if($category == 29){
            if($specified_type == 'TriggeredStress'){
                $this->db->where_in('products.sku', [536]);
            }
            if($specified_type == 'DueEnvironmentalFactors'){
                $this->db->where_in('products.sku', [536]);
            }
        }
        else if($category == 25){
            if($specified_type == 'Blemishes'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
            }
            if($specified_type == 'DarkSpots'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
            }
            if($specified_type == 'UnevenSkinTone'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [520,528,522,518,519,559]);
                }
            }
        }
        else if($category == 24){
            if($specified_type == 'DrynessOnFace')
            {
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [535,540]);
                }
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [542,540]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [532,540]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [542,540]);
                }
            }
            if($specified_type == 'DrynessOnBody')
            {
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [533,544,545,553,535]);
                }
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [533,544,545,553,532]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [533,544,545,532,553]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [533,544,545,542,553]);
                }
            }
        }
        else if($category == 23){
            if($specified_type == 'dullLacklustreSkin'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
            }
            if($specified_type == 'roughBumpySkin'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
            }
            if($specified_type == 'tiredDrabComplexion'){
                if($skin_type == 'Dry')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Combination')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Oily')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
                if($skin_type == 'Normal')
                {
                    $this->db->where_in('products.sku', [521,529,530,546,559]);
                }
            }            
        }
        else{
            $this->db->where('find_in_set("'.$category.'", shop_categorie) <>0');
        }
        //$this->db->limit(3);
        // $this->db->order_by('products.id', 'desc');
        $this->db->join('products_translations', 'products_translations.for_id = products.id');
        $this->db->join('product_variants', 'product_variants.product_id = products.id');
        $query = $this->db->select('*,product_variants.variant_id as variantID,product_variants.price as variantPrice, products.id as productsID')->get('products');
        //$this->db->distinct();
        return $query->result_array();

    }
    public function getQuizImages($id)
    {
        $this->db->select('*');
        $this->db->where('quizID', $id);
        $query = $this->db->get('quiz');
        return $query->row_array();
        
    }
    public function updateInvoice($invoice_code,$id){
        $array = array(
            'invoice' => $invoice_code
        );
        $this->db->where('id', $id);
        $this->db->update('order_product', $array);
    }
    public function findCustomerPointFrReferral($orderID){
        $this->db->select('*');
        $this->db->where('orderID', $orderID);
        $this->db->where('pointType', '3');
        $query = $this->db->get('customer_point');
        return $query->row_array();
    }
    public function countProductRating($id)
    {
        $this->db->where('product_id', $id);
        return $this->db->count_all_results('product_review');
    }
    public function productRatingSum($product_id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_review');
        return $query->result_array();
    }
     public function updateProductRating($productID, $totAverage)
    {
        $array = array(
            'rating' => $totAverage
        );
        $this->db->where('id', $productID);
        $this->db->update('products', $array);
    }
    public function isReview($orderID, $productID, $userID )
    {
        $this->db->where("(order_id='".$orderID."' AND product_id='".$productID."' AND user_id='".$userID."')", NULL, FALSE);
        $query = $this->db->get('product_review');
        $result = $query->row_array();
        if (empty($result)) {
            return 0;
        } else {
            return 1;
        }
    }
    public function searchState($state)
    {
        $this->db->select('*');
        $this->db->where("(states.state_name LIKE '%$state%')");
        $query = $this->db->get('states');
        return $query->row_array();
    }
    public function searchCity($city)
    {
        $this->db->select('*');
        $this->db->where("(cities.name LIKE '$city')");
        $query = $this->db->get('cities');
        return $query->row_array();
    }
    public function insertState($state)
    {
        $this->db->insert('states', array(
            'state_name' => $state,
            'country_id' => '101'
        ));
        return $this->db->insert_id();
    }
    public function insertCity($city, $sateID)
    {
        $this->db->insert('cities', array(
            'name' => $city,
            'state_id' => $sateID
        ));
        return $this->db->insert_id();
    }
    public function updateAddress($post, $stateID, $cityID, $addressId)
    {
        $array = array(
            'user_id' => $_SESSION['logged_user'],
            'first_name' => $post['add_name'],
            'last_name' => $post['add_last_name'],
            'phone' => $post['add_mob'],
            'country' => '101',
            'state' => $stateID,
            'city' => $cityID,
            'post_code' => $post['add_pincode'],
            'address' => $post['add_build_name'],
            'road_name' => $post['add_road_name'],
            'landmark' => $post['landmark'],
            'city_name' => $post['add_city'],
            'state_name' => $post['add_state']
        );
        $this->db->where('address_id', $addressId);
        $this->db->update('user_address', $array);
    }
    public function cartProduct($userID, $product_id)
    {
        $this->db->where('user_id', $userID);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('cart');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }

    public function insertCookiesCart($productID, $userID, $price, $qty){

        $this->db->insert('cart', array(
            'product_id' => $productID,
            'qty' => $qty,
            'user_id' => $userID,
            'amount' => $price,
            'created_date' => date('Y-m-d H:i:s')
        ));
        return $this->db->insert_id();
    }

    public function updateCookiesCart($productID, $userID, $price, $qty){

        $array = array(
            'product_id' => $productID,
            'qty' => $qty,
            'user_id' => $userID,
            'amount' => $price
        );
        $this->db->where("(user_id='".$userID."' AND product_id='".$productID."')", NULL, FALSE);
        //$this->db->where('cartID', $post['id']);
        $this->db->update('cart', $array);

    }

    public function preCartProduct($userID)
    {
        $this->db->select('*');
        $this->db->where('user_id', $userID);
        $query = $this->db->get('cart');
        return $query->result_array();
    }
    public function check_address_avail($userID)
    {
        $this->db->select('*');
        $this->db->where('user_id', $userID);
        $query = $this->db->get('user_address');
        return $query->result_array();
    }
    public function getOrderClientData($orderID)
    {
        $this->db->select('*');
        $this->db->where('for_id', $orderID);
        $query = $this->db->get('orders_clients');
        return $query->row_array();
    }
    public function countCartProduct($userID)
    {
        $this->db->where('user_id', $userID);
        return $this->db->count_all_results('cart');
    }
    public function totalProduct($userID)
    {
        $this->db->select('*');
        $this->db->where('user_id', $userID);
        $query = $this->db->get('cart');
        return $query->result_array();
    }
    public function getOrderTrackingData($orderID,$orderProductID)
    {
        $this->db->select('*');
        $this->db->where('orderID', $orderID);
        $this->db->where('order_product_id', $orderProductID);
        $this->db->where('status', 'delivered');
        $query = $this->db->get('order_tracking');
        return $query->row_array();
    }
    public function isUserAlreadyOrder($userID)
    {
        $this->db->select('*');
        $this->db->where('user_id', $userID);
        $query = $this->db->get('orders');
        return $query->result_array();
    }
    public function getCurentTier($userID)
    {
        $this->db->select('*');
        $this->db->where('customerID', $userID);
        $query = $this->db->get('user_point_rollups');
        return $query->row_array();   
    }
    public function quizProduct($userID){
        $this->db->select('*');
        $this->db->where('user_id', $userID);
        $this->db->where('isQuizProduct', 'yes');
        $query = $this->db->get('cart');
        return $query->result_array();
    }

    public function updateISQuizProduct($userid,$category_type)
    {
        $array = array(
                'isQuizProduct' => 'no',
                'quizProductQty' => null
            );
            $this->db->where('user_id', $userid);
            $this->db->where('isQuizProduct', 'yes');
            $this->db->where('category_type', $category_type);
            $this->db->update('cart', $array);
    }
    public function getCartDatafrQuiz($userID){
        $this->db->select('*');
        $this->db->where('user_id', $userID);
        $this->db->where('isQuizProduct', 'yes');
        $this->db->where('category_type !=', 24);
        $this->db->where('category_type !=', 29);
        $query = $this->db->get('cart');
        return $query->result_array();
    }
    public function checkISQuizProduct($productID,$userID)
    {
        //$this->db->where('isQuizProduct', 'yes');
        $this->db->where("(user_id='".$userID."' AND product_id='".$productID."' AND isQuizProduct='yes')", NULL, FALSE);
        $query = $this->db->get('cart');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    public function buyNowProductData($variant_id, $userID='')
    {
        $this->db->select('*');
        $this->db->where('product_variants.variant_id', $variant_id);
        $this->db->where('cart.user_id', $userID);
        $this->db->join('cart', 'cart.product_id = product_variants.product_id', 'left');
        $query = $this->db->get('product_variants');
        return $query->row_array();
    }
    public function get_category_pdp($id)
    {
        $this->db->select('*');
          $this->db->join('shop_categories_translations','shop_categories.id=shop_categories_translations.for_id');
          $this->db->where(array('shop_categories_translations.id' => $id));
          
          $data = $this->db->get('shop_categories');

          $result_data = $data->row_array();
          return $result_data;
    }
    public function related_product($sku)
    {
        
        $this->db->where('products.sku', $sku);
        $this->db->select('products.*, products_translations.title,products_translations.description, products_translations.default_price, products_translations.default_old_price, products.url, shop_categories_translations.name as categorie_name,products.min_age,products.max_age,products.age_unit, products.product_title, products.rating,products.is_best_seller,products.is_newly_launch,products.is_giftset,products.related_products');

        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_LANGUAGE_ABBR);

        $this->db->join('shop_categories_translations', 'shop_categories_translations.for_id = products.shop_categorie', 'inner');
        $this->db->where('shop_categories_translations.abbr', MY_LANGUAGE_ABBR);
        // $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        
        // $this->db->where('visibility', 1);
        // $this->db->where('vendors.vendor_status', 1);
        $query = $this->db->get('products');
        return $query->row_array();
    }
    public function getProductVideoReview($product_id)
    {
        $this->db->where('productID', $product_id);
        //$this->db->where('product_review.status', 'active');
        //$this->db->join('users_public','product_review.user_id=users_public.id');
        //$this->db->order_by('product_review.review_id', 'desc');
        $query = $this->db->select('*')->get('video_review');
        return $query->row_array();
    }
    public function getquantity($product_id)
    {
        $this->db->where('product_id', $product_id);        
        $query = $this->db->select('*')->get('product_variants');
        return $query->result_array();
    }
    
}
