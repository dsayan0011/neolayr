<?php

class Vendor_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteAdminUser($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('users')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function getVendorUsers($user = null)
    {
        if ($user != null && is_numeric($user)) {
            $this->db->where('vendors.id', $user);
        } else if ($user != null && is_string($user)) {
            $this->db->where('vendors.name', $user);
        }
		$this->db->join('cities', 'vendors.city = cities.id');
        $this->db->join('states', 'vendors.state = states.id');
		$query = $this->db->select('vendors.*, cities.name as city_name, states.state_name')->get('vendors');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }
	
	public function getAdminUsersLevel($user = null)
    {
       
        $query = $this->db->get('user_levels');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }
	public function getStateList($user = null,$country = null)
    {
        $this->db->order_by('state_name','ASC');
		if ($country != null) {
			$this->db->where('country_id','101');
		 }
        $query = $this->db->get('states');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }

    public function setVendorUser($post)
    {
		 if ($post['edit'] > 0) {
            if (trim($post['password']) == '') {
                unset($post['password']);
            } else {
                $post['password'] = md5($post['password']);
            }
            $this->db->where('id', $post['edit']);
            unset($post['id'], $post['edit'],$post['submit']);
            if (!$this->db->update('vendors', $post)) {
				echo $this->db->error();
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        } else {
            unset($post['edit']);
			unset($post['submit']);
            $post['password'] = md5($post['password']);
            if (!$this->db->insert('vendors', $post)) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        }
    }
	public function countVendorUsersWithEmail($email, $id = 0)
    {
        if ($id > 0) {
            $this->db->where('id !=', $id);
        }
        $this->db->where('email', $email);
        return $this->db->count_all_results('vendors');
    }
	  public function deleteVendorUser($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('vendors')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
	public function getCityNameByID($cityID = null)
    {
        $this->db->where('id', $cityID);
        $query = $this->db->get('cities');
        return $query->row_array();
    }
	public function getStateNameByID($stateID = null)
    {
        $this->db->where('id', $stateID);
        $query = $this->db->get('states');
        return $query->row_array();
    }
	public function getVendorDetailsByOrderID($orderID)
    {
        $this->db->where('order_product.order_product_id', $orderID);
		$this->db->join('vendors', 'order_product.vendor_id = vendors.id');
		$this->db->join('cities', 'vendors.city = cities.id');
        $this->db->join('states', 'vendors.state = states.id');
		$query = $this->db->select('vendors.*, cities.name as city_name, states.state_name')->get('order_product');
        if ($query != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }
    public function getOfferType()
    {
        $this->db->select('*');
        $this->db->where('display', 'yes');
        $query = $this->db->get('offer_type');
        return $query->result_array();

    }
}
