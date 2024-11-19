<?php

class Users_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function userCount($onlyNew = false)
    {
        if ($onlyNew == true) {
            $this->db->where('viewed', 0);
        }
        return $this->db->count_all_results('users_public');
    }

    public function users($limit, $page, $order_by)
    {
        if ($order_by != null) {
            $this->db->order_by($order_by, 'DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $this->db->select('*');
        $result = $this->db->get('users_public', $limit, $page);
        return $result->result_array();
    }
	public function get_order_by_date($start_date, $end_date)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date));
		$endDate = strtotime(str_replace('.', '-', $end_date));

        $this->db->order_by('id', 'DESC');
        $this->db->select('orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
		$this->db->where('orders.date >=', $startDate);
		$this->db->where('orders.date <=', $endDate);
        $result = $this->db->get('orders');
        return $result->result_array();
    }
    public function changeUserStatus($id, $to_status)
    {
			if($to_status == "0")
			$status = "inactive";
			else if($to_status == "1")
			$status = "active";
			
			$data = array(
							'status' => $status,
							'viewed' => '1'
						 ); 
			$this->db->where('id', $id);
			$this->db->update('users_public', $data);
    }
    public function doctorConsultationCount()
    {
        return $this->db->count_all_results('doctor_consultation');
    }
     public function doctorConsultation($limit, $page, $order_by)
    {
        if ($order_by != null) {
            $this->db->order_by($order_by, 'DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $this->db->select('*');
        $result = $this->db->get('doctor_consultation', $limit, $page);
        // $this->db->join('users_public', 'users_public.id = cart.user_id', 'inner');
        // $this->db->join('users_public', 'users_public.id = cart.user_id', 'inner');
        return $result->result();
    }
     public function aboutUsBanner($limit, $page, $order_by)
    {
        if ($order_by != null) {
            $this->db->order_by($order_by, 'DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $this->db->select('*');
        $result = $this->db->get('about_us_banner', $limit, $page);
        return $result->result();
    }
    public function aboutUsBannerCount()
    {
        return $this->db->count_all_results('about_us_banner');
    }
    public function cartCount()
    {        
        return $this->db->count_all_results('cart');
    }
    public function cart($limit, $page)
    {       
        $this->db->select('cart.*,users_public.id,users_public.name,users_public.last_name');
        $this->db->join('users_public', 'users_public.id = cart.user_id', 'inner');
        //$this->db->join('products_translations', 'products_translations.for_id = cart.product_id', 'inner');
        $result = $this->db->get('cart', $limit, $page);
        return $result->result_array();
    }
    public function pushData()
    {
        $this->db->select('*');
        $this->db->where('send_push', '0');
        $result = $this->db->get('cart');
        return $result->result_array();
    }
    public function getUserDetails($id){
        $this->db->select('*');
        $this->db->where('id', $id);
        $result = $this->db->get('users_public');
        return $result->row_array();
    }
    public function updatePushData($id){
        $data = array(
                            'send_push' => '1',
                            'push_date' => date('Y-m-d H:i:s')
                         ); 
            $this->db->where('cartID', $id);
            $this->db->update('cart', $data);
    }
    public function getProductName($id){
        $this->db->select('*');
        $this->db->where('for_id', $id);
        $result = $this->db->get('products_translations');
        return $result->row_array();
    }
    public function getState($id){
        $this->db->select('states.state_name');
        $this->db->where('states.id', $id);
        $this->db->where('country_id','101');
        $result = $this->db->get('states');
        return $result->row_array();
    }
    public function getCity($id){
        $this->db->select('cities.name');
        $this->db->where('id', $id);
        $result = $this->db->get('cities');
        return $result->row_array();
    }
    public function contactUsCount()
    {        
        return $this->db->count_all_results('contacts');
    }
    public function contacts($limit, $page)
    {       
        $this->db->select('*');
        $result = $this->db->get('contacts', $limit, $page);
        return $result->result_array();
    }
}
