<?php

class Products_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getOneProduct($id, $vendor_id)
    {
        $this->db->where('id', $id);
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function setProduct($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->where('vendor_id', $post['vendor_id'])->update('products', array(
                        'image' => $post['image'] != null ? $_POST['image'] : @$_POST['old_image'],
                        'shop_categorie' => $post['shop_categorie'],
                        'brand_id' => $post['brand_id'],
                        'time_update' => time(),
						'courier_charge' => $post['courier_charge'],
						'city_name' => $post['city_name'],
						'state_name' => $post['state_name']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('products', array(
                        'image' => $post['image'],
                        'shop_categorie' => $post['shop_categorie'],
                        'brand_id' => $post['brand_id'],
                        'folder' => $post['folder'],
                        'vendor_id' => $post['vendor_id'],
                        'time' => time(),
						'courier_charge' => $post['courier_charge'],
						'city_name' => $post['city_name'],
						'state_name' => $post['state_name']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            $this->db->where('id', $id);
            if (!$this->db->update('products', array(
                        'url' => except_letters($_POST['title'][$myTranslationNum]) . '_' . $id
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        $this->setProductTranslation($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    private function setProductTranslation($post, $id, $is_update = false)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id, 'product');
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $post['vendor_price'][$i] = str_replace(' ', '', $post['vendor_price'][$i]);
            $post['vendor_price'][$i] = str_replace(',', '', $post['vendor_price'][$i]);
			/*$post['price'][$i] = str_replace(' ', '', $post['price'][$i]);
            $post['price'][$i] = str_replace(',', '', $post['price'][$i]);*/
			
            $arr = array(
                'title' => $post['title'][$i],
                'description' => $post['description'][$i],
                'abbr' => $abbr,
                'for_id' => $id
            );
			//Update Product Varients
			if(isset($post['weight'])){
				$weight = $post['weight'];
				$vendor_price = $post['vendor_price'];
				$quantity = $post['quantity'];
				$weight_unit = $post['weight_unit'];
				$status = $post['status'];
			}
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
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
						if($status[$key] == 'default'){
							$arr = array(
								'product_id' => $id,
								'quantity' => $quantity[$key],
								'weight' => $weight[$key],
								'weight_unit' => $weight_unit[$key],
								'vendor_price' => $vandor_price_single,
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
									'status' => $status_single[1]
								);
								$this->db->where('variant_id', $status_single[0]);
								$this->db->update('product_variants', $arr);
							}
						}
					}
				}
            } else {
                if (!$this->db->insert('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
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
								'vendor_price' => $vandor_price_single,
								'status' => 'show'
							);
							$this->db->insert('product_variants',$arr);
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
            $arr[$row->abbr]['description'] = $row->description;
			$arr[$row->abbr]['vendor_price'] = $row->default_vendor_price;
            $arr[$row->abbr]['price'] = $row->default_price;
            $arr[$row->abbr]['old_price'] = $row->default_old_price;
        }
        return $arr;
    }

    public function getProducts($limit, $page, $vendor_id, $search_title, $orderby, $category)
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
            $this->db->order_by('products.position', 'asc');
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->select('products.*, products_translations.title, products_translations.description, products_translations.default_price')->get('products', $limit, $page);
        return $query->result();
    }

    public function productsCount($vendor_id,$search_title = null, $category = null)
    {
		 if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_translations.title LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
	    $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->where('vendor_id', $vendor_id);
        return $this->db->count_all_results('products');
    }

    public function deleteProduct($id,$vendor_id)
    {
        $this->db->trans_begin();

        $this->db->where('id', $id);
        $this->db->where('vendor_id', $vendor_id);
        if (!$this->db->delete('products')) {
            log_message('error', print_r($this->db->error(), true));
        } else {
            $this->db->where('for_id', $id);
            if (!$this->db->delete('products_translations')) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
	public function getVariants($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->select('*')->get('product_variants');
        return $query->result_array();
    }
}
