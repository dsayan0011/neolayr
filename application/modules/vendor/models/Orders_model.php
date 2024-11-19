<?php

class Orders_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ordersCount($vendor_id, $sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission)
    {
		if ($sort_by != null) {
            $ord = explode('_', $sort_by);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->where('order_product.' . $ord[0], $ord[1]);
            }
        }
		if ($seller_name != null) {
			$this->db->like('LOWER(users_public.name)', strtolower($seller_name));
        }
		
		if ($seller_number != null) {
			$this->db->like('LOWER(users_public.phone)', strtolower($seller_number));
        }
		
		if ($start_date != null) {
			$startDate = strtotime($start_date." 00:00:00");
			$this->db->where('orders.date >=', $startDate);
        }
		
		if ($end_date != null) {
			$endDate = strtotime($end_date." 23:59:59");
			$this->db->where('orders.date <=', $endDate);
        }
		
		if ($order_number != null) {
			$this->db->like('LOWER(orders.order_id)', strtolower($order_number));
        }
		
        $this->db->where('order_product.vendor_id', $vendor_id);
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
		//$this->db->join('order_product', 'order_product.main_order_id = orders.id', 'inner');
		
		$this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
		$this->db->where_in('orders.processed', $display_order_perimission );
        return $this->db->count_all_results('order_product');
    }
	public function orders($limit, $page, $vendor_id, $sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission)
    {
        if ($sort_by != null) {
            $ord = explode('_', $sort_by);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->where('order_product.' . $ord[0], $ord[1]);
            }
        }
		if ($seller_name != null) {
			$this->db->like('LOWER(users_public.name)', strtolower($seller_name));
        }
		
		if ($seller_number != null) {
			$this->db->like('LOWER(users_public.phone)', strtolower($seller_number));
        }
		
		if ($start_date != null) {
			$startDate = strtotime($start_date." 00:00:00");
			$this->db->where('orders.date >=', $startDate);
        }
		
		if ($end_date != null) {
			$endDate = strtotime($end_date." 23:59:59");
			$this->db->where('orders.date <=', $endDate);
        }
		
		if ($order_number != null) {
			$this->db->like('LOWER(orders.order_id)', strtolower($order_number));
        }
        $this->db->select('orders.*, orders_clients.first_name,users_public.phone as user_phone,users_public.name as user_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes,  orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_amount,'
				. 'order_product.id as suborder_id, order_product.order_products, order_product.order_product_id, order_product.orderstatus, order_product.order_viewed');
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
		$this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
		$this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
		
		$this->db->where('order_product.vendor_id', $vendor_id);
		$this->db->where_in('order_product.orderstatus', $display_order_perimission );
		
		$this->db->order_by('orders.id', 'DESC');
        $result = $this->db->get('order_product', $limit, $page);
		
		$this->db->where('vendor_id', $vendor_id);
        return $result->result_array();
    }

    public function changeOrderStatus($id, $to_status)
    {
        $this->db->where('order_product_id', $id);
        $this->db->select('orderstatus');
        $result1 = $this->db->get('order_product');
        $res = $result1->row_array();

        $result = true;
        if ($res['orderstatus'] != $to_status) {
            $this->db->where('order_product_id', $id);
            $result = $this->db->update('order_product', array('orderstatus' => $to_status, 'order_viewed' => '1','order_update_date' => date('Y-m-d H:i:s')));
            if ($result == true) {
                $this->manageQuantitiesAndProcurement($id, $to_status, $res['orderstatus']);
            }
			//Insert into return update table
			if($to_status == 6 || $to_status == 8){
				$this->db->where('order_product_id', $id);
				$this->db->select('*');
				$result1 = $this->db->get('order_product');
				$order_details = $result1->row_array();
				
				$data = array(
				'order_id' => $id,
				'return_date' => date('Y-m-d H:i:s'),
				'return_status' => 'return_processing'
				);  
				$this->db->insert('order_return_update', $data);
			}
        }
        return $result;
    }
	private function manageQuantitiesAndProcurement($id, $to_status, $current)
    {
        if ($to_status == 1) {
            $operator = '-';
            $operator_pro = '+';
        }
		if ($to_status == 0 || $to_status == 'approved') {
            $operator = '+';
            $operator_pro = '-';
        }
		
        $this->db->select('order_products');
        $this->db->where('order_product_id', $id);
        $result = $this->db->get('order_product');
        $arr = $result->row_array();
        $products = unserialize($arr['order_products']);
        foreach ($products as $product) {
                if (isset($operator)) {
                    if (!$this->db->query('UPDATE products SET quantity=quantity' . $operator . $product['product_quantity'] . ' WHERE id = ' . $product['product_info']['id'])) {
                        log_message('error', print_r($this->db->error(), true));
                        show_error(lang('database_error'));
                    }
                }
                if (isset($operator_pro)) {
                    if (!$this->db->query('UPDATE products SET procurement=procurement' . $operator_pro . $product['product_quantity'] . ' WHERE id = ' . $product['product_info']['id'])) {
                        log_message('error', print_r($this->db->error(), true));
                        show_error(lang('database_error'));
                    }
                } 
        }
    }
	 public function getUserOrderDetails($order_id)
    {
        $this->db->where('orders.id', $order_id);
        $this->db->select('orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('orders');
        return $result->row_array();
    }
	public function get_order_by_date($start_date, $end_date, $vendor_id)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date)." 00:00:00");
		$endDate = strtotime(str_replace('.', '-', $end_date)." 23:59:59");

        $this->db->order_by('order_product.id', 'DESC');
        $this->db->select('orders.*,order_product.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_amount');
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
		$this->db->where('orders.date >=', $startDate);
		$this->db->where('orders.date <=', $endDate);
		$this->db->where('order_product.vendor_id', $vendor_id);
        $result = $this->db->get('order_product');
        return $result->result_array();
    }
	public function get_order_update($start_date, $end_date, $vendor_id)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date));
		$endDate = strtotime(str_replace('.', '-', $end_date));
      
        $this->db->order_by('order_updates.id', 'DESC');
        $this->db->select('*');
		$this->db->join('order_product', 'order_updates.order_id = vendors_orders.order_id');
		$this->db->where('order_updates.deliveredTime BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        $this->db->or_where('order_updates.returnedTime BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        $this->db->where('vendors_orders.vendor_id', $vendor_id);
		$result = $this->db->get('order_updates');
        return $result->result_array();
    }
	public function get_return_order($start_date, $end_date, $vendor_id)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date));
		$endDate = strtotime(str_replace('.', '-', $end_date));
      
        $this->db->order_by('order_return_update.return_update_id', 'DESC');
        $this->db->select('*');
		$this->db->where('order_return_update.return_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
		$this->db->join('orders', 'orders.id = order_return_update.order_id', 'inner');
		$this->db->join('vendors_orders', 'orders.order_id = vendors_orders.order_id', 'inner');
		$this->db->where('vendors_orders.vendor_id', $vendor_id);
        $result = $this->db->get('order_return_update');
        return $result->result_array();
    }
	public function returnCount($start_date, $end_date, $order_number, $vendor_id)
    {
		$startDate = date("Y-m-d",strtotime(str_replace('.', '-', $start_date)));
		$endDate = date("Y-m-d",strtotime(str_replace('.', '-', $end_date)));
		if ($start_date != null) {
			$this->db->where("order_return_update.return_date >= '{$startDate}'");
        }
		
		if ($end_date != null) {
			$this->db->where("order_return_update.return_date <= '{$endDate}'");
        }
		
		if ($order_number != null) {
			$this->db->like('LOWER(orders.order_id)', strtolower($order_number));
        }
		
		 $this->db->join('orders', 'orders.id = order_return_update.order_id', 'inner');
		 $this->db->join('vendors_orders', 'orders.order_id = vendors_orders.order_id');
		 $this->db->where('vendors_orders.vendor_id', $vendor_id);
         return $this->db->count_all_results('order_return_update');
    }
	 public function getReturn($limit=NULL, $page=NULL, $start_date, $end_date, $order_number, $vendor_id)
    {
		$startDate = date("Y-m-d",strtotime(str_replace('.', '-', $start_date)));
		$endDate = date("Y-m-d",strtotime(str_replace('.', '-', $end_date)));
		
	
		if ($start_date != null) {
			$this->db->where("order_return_update.return_date >= '{$startDate}'");
        }
		
		if ($end_date != null) {
			$this->db->where("order_return_update.return_date <= '{$endDate}'");
        }
		if ($order_number != null) {
			$this->db->like('LOWER(orders.order_id)', strtolower($order_number));
        }
		
        $this->db->select('order_return_update.*, orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes,  orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_amount,users_public.name as seller_name,users_public.email as seller_email,users_public.phone as seller_phone');
		$this->db->join('orders', 'orders.id = order_return_update.order_id', 'inner');
		$this->db->join('vendors_orders', 'orders.order_id = vendors_orders.order_id');
		$this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
		$this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
		$this->db->order_by('order_return_update.return_update_id', 'DESC');
		$this->db->where('vendors_orders.vendor_id', $vendor_id);
		if($limit!=NULL)
		$this->db->limit($limit, $page);
		
        $result = $this->db->get('order_return_update');
        return $result->result_array();
    }
	public function get_vendor_earning($start_date, $end_date,$vendor_id)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date));
		$endDate = strtotime(str_replace('.', '-', $end_date));
      
        $this->db->order_by('id', 'DESC');
        $this->db->select('order_product.*,vendors.name,vendors.warehouse_name');
		$this->db->join('vendors', 'order_product.vendor_id = vendors.id', 'inner');
		$this->db->where('((order_product.order_update_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'") OR (order_product.order_update_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"))', NULL, FALSE);
		//$this->db->where('order_product.order_update_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        //$this->db->or_where('order_product.order_update_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        $this->db->where('order_product.vendor_id', $vendor_id);
		$result = $this->db->get('order_product');
        return $result->result_array();
    }
   	public function getVendorDetailsByOrderID($orderID)
    {
        $this->db->where('order_product.order_product_id', $orderID);
		$this->db->join('vendors', 'order_product.vendor_id = vendors.id');
		$this->db->join('upazilas', 'vendors.city = upazilas.id');
        $this->db->join('district_list', 'vendors.state = district_list.district_id');
		$query = $this->db->select('vendors.*, upazilas.name as city_name, district_list.district_name')->get('order_product');
        if ($query != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }
}
