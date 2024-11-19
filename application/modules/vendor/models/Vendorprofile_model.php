<?php

class Vendorprofile_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getVendorInfoFromEmail($email)
    {
        $this->db->where('email', $email);
        $result = $this->db->get('vendors');
        return $result->row_array();
    }

    public function getVendorByUrlAddress($urlAddr)
    {
        $this->db->where('url', $urlAddr);
        $result = $this->db->get('vendors');
        return $result->row_array();
    }

    public function saveNewVendorDetails($post, $vendor_id)
    {
        if (!$this->db->where('id', $vendor_id)->update('vendors', array(
                    'name' => $post['vendor_name'],
                    'url' => $post['vendor_url']
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }

    public function isVendorUrlFree($vendorUrl)
    {
        $this->db->where('url', $vendorUrl);
        $num = $this->db->count_all_results('vendors');
        if ($num > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getOrdersByMonth($vendor_id)
    {
        $result = $this->db->query("SELECT YEAR(FROM_UNIXTIME(orders.date)) as year, MONTH(FROM_UNIXTIME(orders.date)) as month, COUNT(vendors_orders.id) as num FROM orders INNER JOIN vendors_orders ON orders.order_id=vendors_orders.order_id GROUP BY YEAR(FROM_UNIXTIME(orders.date)), MONTH(FROM_UNIXTIME(orders.date)) ASC");
        $result = $result->result_array();
		 $orders = array();
        $years = array();
        foreach ($result as $res) {
            if (!isset($orders[$res['year']])) {
                for ($i = 1; $i <= 12; $i++) {
                    $orders[$res['year']][$i] = 0;
                }
            }
            $years[] = $res['year'];
            $orders[$res['year']][$res['month']] = $res['num'];
        }
        return array(
            'years' => array_unique($years),
            'orders' => $orders
        );
    }
	 public function getVendorUsers($user = null)
    {
        if ($user != null && is_numeric($user)) {
            $this->db->where('vendors.id', $user);
        } else if ($user != null && is_string($user)) {
            $this->db->where('vendors.name', $user);
        }
		$this->db->join('upazilas', 'vendors.city = upazilas.id');
        $this->db->join('states', 'vendors.state = states.id');
		$query = $this->db->select('vendors.*, upazilas.name as city_name, states.state_name')->get('vendors');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query;
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
	public function setVendorUser($post)
    {
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
    }
}
