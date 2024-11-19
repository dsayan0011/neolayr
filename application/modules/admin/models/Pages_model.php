<?php

class Pages_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPages($active = null, $advanced = false)
    {
        if ($active != null) {
            $this->db->where('enabled', $active);
        }
        if ($advanced == false) {
            $this->db->select('name');
        } else {
            $this->db->select('*');
        }
        $result = $this->db->get('active_pages');
        if ($result != false) {
            $array = array();
            if ($advanced == false) {
                foreach ($result->result_array() as $arr)
                    $array[] = $arr['name'];
            } else {
                $array = $result->result_array();
            }
            return $array;
        }
    }

    public function setPage($name)
    {
        $this->load->model('Languages_model');
        $name = strtolower($name);
        $name = str_replace(' ', '-', $name);
        $this->db->trans_begin();
        if (!$this->db->insert('active_pages', array('name' => $name, 'enabled' => 1))) {
            log_message('error', print_r($this->db->error(), true));
        }
        $thisId = $this->db->insert_id();
        $languages = $this->Languages_model->getLanguages();
        foreach ($languages as $language) {
            if (!$this->db->insert('textual_pages_tanslations', array(
                        'for_id' => $thisId,
                        'abbr' => $language->abbr
                    ))) {
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

    public function deletePage($id)
    {
        $this->db->trans_begin();
        $this->db->where('id', $id);
        if (!$this->db->delete('active_pages')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('for_id', $id);
        if (!$this->db->delete('textual_pages_tanslations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
	public function bannerCount()
    {
        return $this->db->count_all_results('home_banner');
    }
    public function storeCount()
    {
        return $this->db->count_all_results('store_locator');
    }
	public function getBanner($limit, $page)
    {
        $this->db->select('*');
        $this->db->order_by('banner_id', "DESC");
        $query = $this->db->get('home_banner', $limit, $page);
        return $query->result();
    }
    public function getStore($limit, $page)
    {
        $query = $this->db->select('*')->get('store_locator', $limit, $page);
        return $query->result();
    }
	public function numShopBanner()
    {
        return $this->db->count_all_results('home_banner');
    }
	public function getOnebanner($id)
    {
        $this->db->select('*');
        $this->db->where('home_banner.banner_id', $id);
        $query = $this->db->get('home_banner');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
	public function setBanner($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('banner_id', $id)->update('home_banner', array(
                        'banner_image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],

                        'banner_image_mob' => $post['banner_image_mob'] != null ? $_POST['banner_image_mob'] : $_POST['old_mob_image'],
						'banner_title' => $post['banner_title'],
                        'status' => $post['status'],
                        'link_for' => $post['link_for'],
						'banner_link_pdp' => $post['banner_link_pdp'],
                        'banner_link_plp' => $post['banner_link_plp']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('home_banner', array(
                        'banner_title' => null,
                        'banner_image' => $post['image'],
                        'banner_image_mob' => $post['banner_image_mob'],
                        'status' => $post['status'],
                        'link_for' => $post['link_for'],
						'banner_link_pdp' => $post['banner_link_pdp'],
                        'banner_link_plp' => $post['banner_link_plp'],
                        'created_at' => date('Y-m-d H:i:s')
                    ))) {
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
	public function deleteBanner($id)
    {
        $this->db->trans_begin();
        $this->db->where('banner_id', $id);
        if (!$this->db->delete('home_banner')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
    public function getOneStore($id)
    {
        $this->db->select('*');
        $this->db->where('store_locator.storeLocatorID', $id);
        $query = $this->db->get('store_locator');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

        public function setStore($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('storeLocatorID', $id)->update('store_locator', array(
                        'store_name' => $post['store_name'],
                        'store_city' => $post['store_city'],
                        'store_state' => $post['store_state'],
                        'store_pincode' => $post['store_pincode'],
                        'store_address' => $post['store_address'],
                        'store_latitude' => $post['store_latitude'],
                        'store_longitude' => $post['store_longitude'],
                        'store_status' => $post['store_status'],
                        'updated_date' => date('Y-m-d H:i:s')
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('store_locator', array(
                        'store_name' => $post['store_name'],
                        'store_city' => $post['store_city'],
                        'store_state' => $post['store_state'],
                        'store_pincode' => $post['store_pincode'],
                        'store_status' => $post['store_status'],
                        'created_date' => date('Y-m-d H:i:s')
                    ))) {
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
    public function deleteStore($id)
    {
        $this->db->trans_begin();
        $this->db->where('storeLocatorID', $id);
        if (!$this->db->delete('store_locator')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
    public function concernCount()
    {
        return $this->db->count_all_results('concern_shop');
    }
    public function getConcern($limit, $page)
    {
        $query = $this->db->select('*')->get('concern_shop', $limit, $page);
        return $query->result();
    }
    public function getOneConcern($id)
    {
        $this->db->select('*');
        $this->db->where('concern_shop.concern_shopID', $id);
        $query = $this->db->get('concern_shop');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function setConcern($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('concern_shopID', $id)->update('concern_shop', array(
                        'concernImage' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'title' => $post['title'],
                        'category' => $post['category'],
                        'status' => $post['status']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('concern_shop', array(
                        'title' => $post['title'],
                        'concernImage' => $post['image'],
                        'status' => $post['status'],
                        'category' => $post['category'],
                        'created_at' => date('Y-m-d H:i:s')
                    ))) {
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
    public function deleteConcern($id)
    {
        $this->db->trans_begin();
        $this->db->where('concern_shopID', $id);
        if (!$this->db->delete('concern_shop')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

    public function testimonialCount()
    {
        return $this->db->count_all_results('testimonials');
    }
    public function getTestimonials($limit, $page)
    {
        $query = $this->db->select('*')->get('testimonials', $limit, $page);
        return $query->result();
    }
    public function getOneTestimonials($id)
    {
        $this->db->select('*');
        $this->db->where('testimonials.testimonialsId', $id);
        $query = $this->db->get('testimonials');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function setTestimonials($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('testimonialsId', $id)->update('testimonials', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'name' => $post['name'],
                        'link' => $post['link'],
                        'description' => $post['description'],
                        'designation' => $post['designation'],
                        'status' => $post['status']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('testimonials', array(
                        'name' => $post['name'],
                        'image' => $post['image'],
                        'link' => $post['link'],
                        'description' => $post['description'],
                        'designation' => $post['designation'],
                        'status' => $post['status'],
                        'created_at' => date('Y-m-d H:i:s')
                    ))) {
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
    public function deleteTestimonial($id)
    {
        $this->db->trans_begin();
        $this->db->where('testimonialsId', $id);
        if (!$this->db->delete('testimonials')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
     public function getAboutUs($id)
        {
            $this->db->select('*');
            $this->db->where('id', $id);
            $query = $this->db->get('about_us');
            if ($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return false;
            }
        }

     public function regimeCount()
    {
        return $this->db->count_all_results('regime_shop');
    }
    public function getRegime($limit, $page)
    {
        $query = $this->db->select('*')->get('regime_shop', $limit, $page);
        return $query->result();
    }
    public function getOneRegime($id)
    {
        $this->db->select('*');
        $this->db->where('regime_shop.regimeShopID', $id);
        $query = $this->db->get('regime_shop');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function ingredientCount()
    {
        return $this->db->count_all_results('ingredients');
    }
    public function ingredientProductCount()
    {
        return $this->db->count_all_results('ingredientsdetais');
    }
    public function getIngredient($limit, $page)
    {
        $query = $this->db->select('*')->get('ingredients', $limit, $page);
        return $query->result();
    }
    public function getIngredientDetails($limit, $page){
        $query = $this->db->select('*, ingredientsdetais.status as ingredientsdetaisStatus');
        $this->db->join('ingredients', 'ingredients.ingredientsID = ingredientsdetais.ingredients_id');

        $query = $this->db->get('ingredientsdetais', $limit, $page); 
        return $query->result_array();
    }
    public function getOneIngredient($id)
    {
        $this->db->select('*');
        $this->db->where('ingredients.ingredientsID', $id);
        $query = $this->db->get('ingredients');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
     public function getOneIngredientProduct($id)
    {
        $this->db->select('*');
        $this->db->where('ingredientsdetais.ingredientsDetaisID', $id);
        $query = $this->db->get('ingredientsdetais');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function setIngredient($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('ingredientsID', $id)->update('ingredients', array(        'ingredientsTitle' => $post['ingredientsTitle'],
                        'status' => $post['status']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('ingredients', array(
                        'ingredientsTitle' => $post['ingredientsTitle'],
                        'status' => $post['status'],
                        'created_at' => date('Y-m-d H:i:s')
                    ))) {
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
    public function deleteIngredient($id)
    {
        $this->db->trans_begin();
        $this->db->where('ingredientsID', $id);
        if (!$this->db->delete('ingredients')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
    public function deleteIngredientDetails($id)
    {
        $this->db->trans_begin();
        $this->db->where('ingredientsDetaisID', $id);
        if (!$this->db->delete('ingredientsdetais')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
    public function getAllIngredients()
    {
        $this->db->select('*');
        $query = $this->db->get('ingredients');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function setIngredientProduct($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if (!isset($post['product_sku'])) {
            $post['product_sku'] = null;
        }
        else{
            $post['product_sku'] = implode(',', $post['product_sku']);
        }
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('ingredientsDetaisID', $id)->update('ingredientsdetais', array(
                        'ingredients_id' => $post['ingredientsID'],
                        'ingredientImage' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'title' => $post['title'],
                        'product_sku' => $post['product_sku'],
                        'shortDescription' => $post['shortDescription'],
                        'longDescription' => $post['longDescription'],
                        'status' => $post['status']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('ingredientsdetais', array(
                        'ingredients_id' => $post['ingredientsID'],
                        'title' => $post['title'],
                        'ingredientImage' => $post['image'],
                        'shortDescription' => $post['shortDescription'],
                        'longDescription' => $post['longDescription'],
                        'product_sku' => $post['product_sku'],
                        'status' => $post['status'],
                    ))) {
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
     public function getIngredientPublic()
    {
        $query = $this->db->select('*');
        $this->db->where('ingredients.status', 'Active');
        $this->db->order_by("ingredientsTitle", "asc");
        $query = $this->db->get('ingredients'); 
        return $query->result_array();
    }
    
     public function getOneIngredientdetails($id)
    {
        $this->db->select('*');
        $this->db->where('ingredientsdetais.ingredients_id', $id);
        $this->db->join('ingredients', 'ingredients.ingredientsID = ingredientsdetais.ingredients_id');
        $query = $this->db->get('ingredientsdetais');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
        {
             log_message('error', print_r($this->db->error(), true));
        }
    }



    public function plistImagesCount()
    {
        return $this->db->count_all_results('product_list_banner');
    }
     public function getPlistImages($limit, $page)
    {
        $query = $this->db->select('*')->get('product_list_banner', $limit, $page);
        return $query->result();
    }
    public function getOnePlistImages($id)
    {
        $this->db->select('*');
        $this->db->where('product_list_banner.id', $id);
        $query = $this->db->get('product_list_banner');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function getQuizImages($id)
    {
        $this->db->select('*');
        $this->db->where('quiz.quizID', $id);
        $query = $this->db->get('quiz');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function setPlistImages($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('product_list_banner', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'title' => $post['title'],
                        'category' => $post['category']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('product_list_banner', array(
                        'category' => $post['category'],
                        'title' => $post['title'],
                        'image' => $post['image']
                    ))) {
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
    public function deletePlistImages($id)
    {
        $this->db->trans_begin();
        $this->db->where('id', $id);
        if (!$this->db->delete('product_list_banner')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
    public function categoryList(){
        $query = $this->db->select('*');
        $this->db->where('category_slug != ', 'shop');
        $this->db->where('category_slug != ', 'shop-by-concern');
        $this->db->where('category_slug != ', 'shop-by-ingredients');
        $this->db->where('category_slug != ', 'shop-by-product');
        //$this->db->join('shop_categories', 'shop_categories.sub_for = shop_categories_translations.id');
        //$this->db->group_by('shop_categories.sub_for');
        $query = $this->db->get('shop_categories_translations'); 
        return $query->result_array();
    }

    
    public function setAboutUs($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('about_us', array(
                        'banner_image' => $post['banner_image'] != null ? $_POST['banner_image'] : $_POST['old_banner_image'],
                        'origin_story' => $post['origin_story'],
                        'origin_image' => $post['origin_image'] != null ? $_POST['origin_image'] : $_POST['old_origin_image'],
                        'neo_pro_best' => $post['neo_pro_best'],
                        'expertise' => $post['expertise'],
                        'expertise_image' => $post['expertise_image'] != null ? $_POST['expertise_image'] : $_POST['old_expertise_image'],
                        'pro_way' => $post['pro_way'],
                        'dermatologically_tested' => $post['dermatologically_tested'],
                        'dermatologically_image' => $post['dermatologically_image'] != null ? $_POST['dermatologically_image'] : $_POST['old_dermatologically_image']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } 
        // else {
        //     if (!$this->db->insert('testimonials', array(
        //                 'name' => $post['name'],
        //                 'image' => $post['image'],
        //                 'description' => $post['description'],
        //                 'designation' => $post['designation'],
        //                 'status' => $post['status'],
        //                 'created_at' => date('Y-m-d H:i:s')
        //             ))) {
        //         log_message('error', print_r($this->db->error(), true));
        //     }
        // }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
    public function setQuizImages($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('quizID', $id)->update('quiz', array(
                        'quiz_image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('quiz', array(
                        'quiz_image' => $post['image']
                    ))) {
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
     public function getIngredientBanner($id)
    {
        $this->db->select('*');
        $this->db->where('ingredient_bannerID', $id);
        $query = $this->db->get('ingredient_banner');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function setIngredientBanner($post, $id = 0)
    {
        
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('ingredient_bannerID', $id)->update('ingredient_banner', array(
                        'ingredient_banner_image' => $post['ingredient_banner_image'] != null ? $_POST['ingredient_banner_image'] : $_POST['old_ingredient_banner_image'],
                        'banner_title' => $post['banner_title'],
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
    }
    public function getOneAboutUsBannerImages($id)
    {
        $this->db->select('*');
        $this->db->where('about_us_banner.id', $id);
        $query = $this->db->get('about_us_banner');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function setAboutUsBannerImages($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('about_us_banner', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'mob_image' => $post['mob_image'] != null ? $_POST['mob_image'] : $_POST['old_mob_image'],
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('about_us_banner', array(
                        'image' => $post['image'],
                        'mob_image' => $post['mob_image']
                    ))) {
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
    public function deleteAboutUsImages($id)
    {
        $this->db->trans_begin();
        $this->db->where('id', $id);
        if (!$this->db->delete('about_us_banner')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
    public function setRating($post, $id = 0)
    {
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('review_id', $id)->update('product_review', array(
                        'user_id' => $post['user_name'],
                        'product_id' => $post['product_id'],
                        'comment' => $post['comment'],
                        'rating' => $post['rating'],
                        'status' => 'active'
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            if (!$this->db->insert('product_review', array(
                        'user_id' => $post['user_name'],
                        'product_id' => $post['product_id'],
                        'comment' => $post['comment'],
                        'rating' => $post['rating'],
                        'status' => 'active',
                        'created_date' => date('Y-m-d H:i:s')
                    ))) {
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
    public function deleteRating($id)
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
    public function getProductID($id)
    {
        $this->db->select('*');
        $this->db->where('review_id', $id);
        $query = $this->db->get('product_review');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
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

}
