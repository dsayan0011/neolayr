<?php

class Discounts_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDiscountCodeInfo($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('discount_codes');
        return $result->row_array();
    }

    public function changeCodeDiscountStatus($codeId, $toStatus)
    {
        $this->db->where('id', $codeId);
        if (!$this->db->update('discount_codes', array(
                    'status' => $toStatus
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function discountCodesCount()
    {
        return $this->db->count_all_results('discount_codes');
    }

    public function getDiscountCodes($limit, $page)
    {
         $this->db->select('discount_codes.*,offer_type.type as offerType');
        $this->db->join('offer_type', 'offer_type.offer_typeID = discount_codes.offer_types', 'left');
        $result = $this->db->get('discount_codes', $limit, $page);
        return $result->result_array();
    }

    public function setDiscountCode($post)
    {
        if($post['categories'] != ''){
            $categories = implode(",",$post['categories']);
        }
        // else{
        //     $categories = implode(",",$post['categories']);
        // }
        // echo "<pre>";
        // print_r($post);
        // die();
        if (!$this->db->insert('discount_codes', array(
                    'type' => $post['type'],
                    'code' => trim($post['code']),
                    'amount' => $post['amount'],
                    'vendors' => 'all',
					// 'vendors' => implode(",",$post['vendors']),
                    'valid_from_date' => strtotime($post['valid_from_date']),
                    'valid_to_date' => strtotime($post['valid_to_date']),
                    'offer_types' => $post['offer_types'],
                    'numberOfFreeProduct' => $post['numberOfFreeProduct'],
                    'freeProductID' => implode(",",$post['freeProductID']),
                    // 'categories' => implode(",",$post['categories']),
                    'categories' => $post['categories'] ? $categories : 'all',
                    'description' => $post['description'],
                    'totalProductPrice' => $post['totalProductPrice'],
                    'product' => implode(",",$post['products'])
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function updateDiscountCode($post)
    {
        if($post['offer_types'] == '7'){
            $numberOfFreeProduct = $post['numberOfFreeProduct'];
            $freeProductID = implode(",",$post['freeProductID']);
        }
        else{
            $numberOfFreeProduct =  null;
            $freeProductID = null;
        }
        if($post['categories'] != ''){
            $categories = implode(",",$post['categories']);
        }
        $this->db->where('id', $post['update']);
        if (!$this->db->update('discount_codes', array(
                    'type' => $post['type'],
                    'code' => trim($post['code']),
                    'amount' => $post['amount'],
					//'code' => trim($post['code']),
					// 'vendors' => implode(",",$post['vendors']),
                    'vendors' => 'all',
                    'valid_from_date' => strtotime($post['valid_from_date']),
                    'valid_to_date' => strtotime($post['valid_to_date']),
                    'offer_types' => $post['offer_types'],
                    'numberOfFreeProduct' => $numberOfFreeProduct,
                    'freeProductID' => $freeProductID,
                    // 'categories' => implode(",",$post['categories']),
                    'categories' => $post['categories'] ? $categories : 'all',
                    'description' => $post['description'],
                    'totalProductPrice' => $post['totalProductPrice'],
                    'product' => implode(",",$post['products'])
                    
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function discountCodeTakenCheck($post)
    {
        if ($post['update'] > 0) {
            $this->db->where('id !=', $post['update']);
        }
        $this->db->where('code', $post['code']);
        $num_rows = $this->db->count_all_results('discount_codes');
        if ($num_rows == 0) {
            return true;
        }
        return false;
    }
    public function getCategories()
    {
        $this->db->select('*');
        //$this->db->join('shop_categories', 'shop_categories.sub_for = shop_categories_translations.id', 'right');
        //$this->db->where('code', $post['code']);
        $this->db->where('for_id !=', '1');
        $this->db->where('for_id !=', '2');
        $this->db->where('for_id !=', '3');
        $this->db->where('for_id !=', '4');
        $this->db->where('for_id !=', '7');
        $result = $this->db->get('shop_categories_translations');
        return $result->result_array();
        // if ($user != null && is_numeric($user)) {
        //     $this->db->where('vendors.id', $user);
        // } else if ($user != null && is_string($user)) {
        //     $this->db->where('vendors.name', $user);
        // }
        // $this->db->join('shop_categories', 'shop_categories.sub_for = shop_categories_translations.id');
        // $query = $this->db->select('*')->get('shop_categories_translations');
        // if ($user != null) {
        //     return $query->result_array();
        // } else {
        //     return $query;
        // }
    }
    public function getSelectedCategories($id){
        $this->db->select('*');
        $this->db->join('shop_categories', 'shop_categories.sub_for = shop_categories_translations.id', 'left');
        $this->db->where('shop_categories.sub_for !=', $id);
        $result = $this->db->get('shop_categories_translations');
        return $result->result_array();
        
    }

    public function starRatingCount()
    {
        return $this->db->count_all_results('product_review');
    }

    public function getStarRating($limit, $page)
    {
        $this->db->select('*, product_review.rating as product_review_rating, product_review.status as product_status');
        $this->db->join('products', 'products.id = product_review.product_id', 'left');
        $this->db->join('users_public', 'users_public.id = product_review.user_id', 'left');
        $result = $this->db->get('product_review', $limit, $page);
        return $result->result_array();
    }
    public function changeRatingStatus($codeId, $toStatus)
    {
        $this->db->where('review_id', $codeId);
        if (!$this->db->update('product_review', array(
                    'status' => $toStatus
                ))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
    public function allProductCount()
    {
        return $this->db->count_all_results('products');
    }
    public function getAllProduct($limit, $page)
    {
        $this->db->select('sku');
        $result = $this->db->get('products', $limit, $page);
        return $result->result_array();
    }
    public function getVideoReview($sku)
    {
        $this->db->select('*');
        $this->db->where('video_review_sku', $sku);
        $result = $this->db->get('video_review');
        return $result->row_array();
    }
    public function deleteVideoReview($sku)
    {
        $this->db->trans_begin();
        $this->db->where('video_review_sku', $sku);
        if (!$this->db->delete('video_review')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
    public function setVideoReview($post, $id = 0)
    {
        $this->db->insert('video_review', array(
                    'video_review_sku' => $id,
                    'productID' => $post['productID'],
                    'video_title' => $post['video_title'],
                    'video_review_link' => trim($post['video_review_link'])
                ));
    }
    public function getProductID($sku)
    {
        $this->db->select('*');
        $this->db->where('sku', $sku);
        $result = $this->db->get('products');
        return $result->row_array();
    }

}
