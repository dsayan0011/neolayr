<?php

class Orders_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ordersCount($onlyNew = false)
    {
        if ($onlyNew == true) {
            $this->db->where('viewed', 0);
        }
        return $this->db->count_all_results('orders');
    }
	public function ordersCountWithSorting($sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission)
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
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
		$this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
		$this->db->where_in('order_product.orderstatus', $display_order_perimission );
        return $this->db->count_all_results('order_product');
    }
 	public function todaysOrdersCount()
    {
        $query = $this->db->query("SELECT id FROM orders WHERE FROM_UNIXTIME(date,'%Y-%m-%d') = CURDATE()");
        $result = $query->num_rows();
        return $result;
    }
    public function orders($limit, $page, $sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission)
    {
        $this->db->query('SET SESSION sql_mode = ""');

            // ONLY_FULL_GROUP_BY
            $this->db->query('SET SESSION sql_mode =
                  REPLACE(REPLACE(REPLACE(
                  @@sql_mode,
                  "ONLY_FULL_GROUP_BY,", ""),
                  ",ONLY_FULL_GROUP_BY", ""),
                  "ONLY_FULL_GROUP_BY", "")');
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
                . ' orders_clients.last_name, orders_clients.email, orders_clients.country, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes,  orders_clients.thana, discount_codes.type as discount_type,'
				. 'order_product.id as suborder_id, order_product.order_products, order_product.order_product_id, order_product.orderstatus, order_product.order_viewed,order_product.status as order_product_status');
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
		$this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
		
		$this->db->where_in('order_product.orderstatus', $display_order_perimission );
		$this->db->order_by('orders.id', 'DESC');
        $result = $this->db->get('order_product', $limit, $page);
        return $result->result_array();
    }
    public function ordersDetails($limit, $page, $sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission)
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
                . ' orders_clients.last_name, orders_clients.email, orders_clients.country, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes,  orders_clients.thana, discount_codes.type as discount_type,'
                . 'order_product.id as suborder_id, order_product.order_products, order_product.order_product_id, order_product.orderstatus, order_product.order_viewed,order_product.status as order_product_status, orders.id as orderID');
        $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        
        $this->db->where_in('order_product.orderstatus', $display_order_perimission );
        $this->db->group_by('order_product.main_order_id');
        $this->db->order_by('orders.id', 'DESC');
        $result = $this->db->get('order_product', $limit, $page);
        return $result->result_array();
    }
    public function ordersDetailsAdmin($limit, $page, $sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission)
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
                . ' orders_clients.last_name, orders_clients.email, orders_clients.country, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes,  orders_clients.thana, discount_codes.type as discount_type,'
                . 'order_product.id as suborder_id, order_product.order_products, order_product.order_product_id, order_product.orderstatus, order_product.order_viewed,order_product.status as order_product_status, orders.id as orderID');
        $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        
        $this->db->where_in('order_product.orderstatus', $display_order_perimission );
        $this->db->group_by('order_product.main_order_id');
        $this->db->order_by('orders.id', 'DESC');
        $result = $this->db->get('order_product', $limit, $page);
        return $result->result_array();
    }
	public function get_order_by_date($start_date, $end_date)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date)." 00:00:00");
		$endDate = strtotime(str_replace('.', '-', $end_date)." 23:59:59");

        $this->db->order_by('order_product.id', 'DESC');
        $this->db->select('orders.*,order_product.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, ');
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
		$this->db->where('orders.date >=', $startDate);
		$this->db->where('orders.date <=', $endDate);
        $result = $this->db->get('order_product');
        return $result->result_array();
    }
	public function get_income_by_date($start_date, $end_date)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date));
		$endDate = strtotime(str_replace('.', '-', $end_date));
        $this->db->order_by('income_id', 'DESC');
        $this->db->select('users_income.*,users_public.*,orders.order_id as order_ref');
		$this->db->join('users_public', 'users_public.id = users_income.user_id', 'inner');
		$this->db->join('orders', 'users_income.order_id = orders.id', 'inner');
		 $this->db->where('users_income.update_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        $result = $this->db->get('users_income');
        return $result->result_array();
    }
	public function get_user()
    {
		 $this->db->order_by('id', 'DESC');
        $this->db->select('*');
		 $result = $this->db->get('users_public');
        return $result->result_array();
    }
	public function get_subscriber_user()
    {
		 $this->db->order_by('subscriber_id', 'DESC');
        $this->db->select('*');
		 $result = $this->db->get('newsletter_subscriber');
        return $result->result_array();
    }
    public function changeOrderStatus($id, $to_status)
    {
        $this->db->where('id', $id);
        $this->db->select('processed,products');
        $result1 = $this->db->get('orders');
        $res = $result1->row_array();
        // echo $id."<br>";
        // echo $to_status."<br>";
        //print_r($res); exit;
        //$this->manageQuantitiesAndProcurement($id, $to_status, $res['orderstatus'], $res);
        $result = true;
        if ($res['processed'] != $to_status) {
            //$this->db->where('order_product_id', $id);
            //$result = $this->db->update('order_product', array('orderstatus' => $to_status, 'order_viewed' => '1','order_update_date' => date('Y-m-d H:i:s')));
            //if ($result == true) {
                $this->manageQuantitiesAndProcurement($id, $to_status, $res['processed'], $res);
            //}
			//Insert into return update table
			// if($to_status == 6 || $to_status == 8){
			// 	$this->db->where('order_product_id', $id);
			// 	$this->db->select('*');
			// 	$result1 = $this->db->get('order_product');
			// 	$order_details = $result1->row_array();
				
			// 	$data = array(
			// 	'order_id' => $id,
			// 	'return_date' => date('Y-m-d H:i:s'),
			// 	'return_status' => 'return_processing'
			// 	);  
			// 	$this->db->insert('order_return_update', $data);
			// }
        }
        return $result;
    }
    public function changemainOrderStatus($id, $to_status)
    {
        $this->db->where('id', $id);
        $this->db->update('orders', array('processed' => $to_status, 'viewed' => '1','updated_date' => date('Y-m-d H:i:s')));
        return true;
    }
    public function changeBulkOrderStatusLineItem($id, $to_status, $status)
    {
        $this->db->where('main_order_id', $id);
        $this->db->select('*');
        $allLineItem = $this->db->get('order_product')->result_array();
        foreach($allLineItem as $item){
            $this->db->where('id', $item['id']);
            $this->db->update('order_product', array('status'=>$status, 'orderstatus' => $to_status, 'order_viewed' => '1','order_update_date' => date('Y-m-d H:i:s')));
        }
        return true;

    }
	public function updateOrderTracking($id, $waybill)
    {
		$this->db->where('order_product_id', $id);
        $result = $this->db->update('order_product', array('tracking_number' => $waybill));
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
		$products = unserialize($res['products']);
		foreach($products as $product){
			 if (isset($operator)) {
                    if (!$this->db->query('UPDATE product_variants SET quantity=quantity' . $operator . $product['product_quantity'] . ' WHERE variant_id = ' . $product['product_info']['variant_id'])) {
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

    public function setBankAccountSettings($post)
    {
        $query = $this->db->query('SELECT id FROM bank_accounts');
        if ($query->num_rows() == 0) {
            $id = 1;
        } else {
            $result = $query->row_array();
            $id = $result['id'];
        }
        $post['id'] = $id;
        if (!$this->db->replace('bank_accounts', $post)) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function getBankAccountSettings()
    {
        $result = $this->db->query("SELECT * FROM bank_accounts LIMIT 1");
        return $result->row_array();
    }
	 public function getUserOrderDetails($order_id)
    {
        $this->db->where('order_product.order_product_id', $order_id);
        $this->db->select('orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana,orders_clients.id,  discount_codes.type as discount_type, '
				. 'order_product.id as suborder_id, order_product.order_update_date, order_product.order_products, order_product.order_product_id, order_product.orderstatus, order_product.order_viewed, order_product.tracking_number');
        $this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
		$this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('order_product');
        return $result->row_array();
    }
     public function getOrderDetailsAdmin($order_id)
    {
        $this->db->where('orders.id', $order_id);
        $this->db->select('orders.*,orders.id as orderID, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city,orders_clients.country, orders_clients.post_code,'
                . ' orders_clients.notes, orders_clients.thana, discount_codes.type as discount_type, discount_codes.amount as discount_value');
        //$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
        $result = $this->db->get('orders');
        return $result->row_array();
    }
   
    
    public function getLineItemOrderDetailsAdmin($orderID){
        $this->db->where('order_product.main_order_id', $orderID);
        $this->db->select('*');
        
        $result = $this->db->get('order_product');
        return $result->result_array();
    }

	 public function incomeCount($onlyNew = false)
    {
        if ($onlyNew == true) {
            //$this->db->where('viewed', 0);
        }
        return $this->db->count_all_results('users_income');
    }

    public function income_history($limit, $page, $sort_by, $seller_name, $seller_number)
    {
		if ($sort_by != null) {
              $this->db->where('users_income.payment_status', $sort_by);
        }
		
		if ($seller_name != null) {
			$this->db->like('LOWER(users_public.name)', strtolower($seller_name));
        }
		
		if ($seller_number != null) {
			$this->db->like('LOWER(users_public.phone)', strtolower($seller_number));
        }

		
        $this->db->select('*');
		$this->db->join('orders', 'users_income.order_id = orders.id', 'left');
        $this->db->join('users_public', 'users_public.id = users_income.user_id', 'inner');
		$this->db->order_by('users_income.income_id', 'DESC');
		
        $result = $this->db->get('users_income', $limit, $page);
        return $result->result_array();
    }
	public function changePaymentStatus($id, $to_status,$is_show = '')
    {
        $this->db->where('income_id', $id);
        $this->db->select('payment_status');
        $result1 = $this->db->get('users_income');
        $res = $result1->row_array();

        $result = true;
        if ($res['payment_status'] != $to_status) {
            $this->db->where('income_id', $id);
            $result = $this->db->update('users_income', array('payment_status' => $to_status,'update_date' => date('Y-m-d H:i:s')));
        }
        return $result;
    }
	public function cancelOrderStatus($id, $to_status, $cancel_reason)
    {
        $this->db->where('main_order_id', $id);
        $this->db->update('order_product', array('orderstatus' => $to_status, 'order_viewed' => '1','order_update_date' => date('Y-m-d H:i:s'), 'cancel_reason' => $cancel_reason));
    }
	public function getOrderlistForSync()
    {
        $this->db->select('main_order_id,order_product_id,tracking_number');
		$this->db->where_in('order_product.orderstatus', [2,6,8]);
        $query = $this->db->get('order_product');
        return $query->result_array();
    }
	 public function checkOrderExists($order_id)
    {
        $this->db->where('order_id', $order_id);
	    $query = $this->db->get('order_updates');
        $result = $query->row_array();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
	public function insert_order_status($post)
    {
        $this->db->insert('order_updates', $post);
        return $this->db->insert_id();
    }
	public function update_order_status($order_id,$post)
    {
        $this->db->where('order_id', $order_id);
        $this->db->update('order_updates', $post);
    }
	public function get_order_update($start_date, $end_date)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date));
		$endDate = strtotime(str_replace('.', '-', $end_date));
      
        $this->db->order_by('id', 'DESC');
        $this->db->select('*');
		$this->db->where('order_updates.deliveredTime BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        $this->db->or_where('order_updates.returnedTime BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        $result = $this->db->get('order_updates');
        return $result->result_array();
    }
	public function getOrderlistForReturnUpdate()
    {
        $this->db->select('order_return_update.return_update_id, orders.order_id');
		$this->db->where('order_return_update.return_status', 'return_processing');
		$this->db->join('orders', 'orders.id = order_return_update.order_id', 'inner');
        $query = $this->db->get('order_return_update');
        return $query->result_array();
    }
	public function updateReturnStatus($id, $return_status, $return_date)
    {
       $data = array(
					'return_status' => $return_status,
					'warehouse_return_date' => $return_date
		); 
		$this->db->where('return_update_id', $id);
		$this->db->update('order_return_update ', $data);
		
    }
	public function returnCount($start_date, $end_date, $order_number)
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
         return $this->db->count_all_results('order_return_update');
    }
	 public function getReturn($limit=NULL, $page=NULL, $start_date, $end_date, $order_number)
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
		
        $this->db->select('order_return_update.*, order_return_update.order_id as return_order_id, orders.*, orders_clients.first_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,order_return_update.viewed as return_viewed,'
                . ' orders_clients.notes,  orders_clients.thana, discount_codes.type as discount_type, users_public.name as seller_name,users_public.email as seller_email,users_public.phone as seller_phone');
		$this->db->join('order_product', 'order_product.order_product_id = order_return_update.order_id', 'inner');
		$this->db->join('orders', 'orders.id = order_product.main_order_id', 'inner');
		$this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
		$this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
		$this->db->order_by('order_return_update.return_update_id', 'DESC');
		if($limit!=NULL)
		$this->db->limit($limit, $page);
		
        $result = $this->db->get('order_return_update');
        return $result->result_array();
    }
	public function get_return_order($start_date, $end_date)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date));
		$endDate = strtotime(str_replace('.', '-', $end_date));
      
        $this->db->order_by('order_return_update.return_update_id', 'DESC');
        $this->db->select('*');
		$this->db->where('order_return_update.return_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
		$this->db->join('orders', 'orders.id = order_return_update.order_id', 'inner');
        $result = $this->db->get('order_return_update');
        return $result->result_array();
    }
	public function updateReturnProcessStatus($id)
    {
        $this->db->where('return_update_id', $id);
        $this->db->update('order_return_update', array('return_status' => 'processing','viewed' => '1'));
		
    }
	public function changeReturnStatus($id, $order_id, $to_status, $return_status, $remark)
    {
        $this->db->where('return_update_id', $id);
        $this->db->update('order_return_update', array('return_accepted_at_warehouse' => $to_status, 'remark' => $remark));
		
		if($to_status == 'approved' && $return_status == 'returned_accepted')
		$this->manageQuantitiesAndProcurement($order_id, $to_status, '', '');
		
    }
	public function getTotalOnlinePurchase()
    {
		$this->db->where('orders.payment_type=','cashOnDelivery' );
        return $this->db->count_all_results('orders');
    }
	 public function getOnlineOrders($limit, $page)
    {
        $this->db->select('orders.*, orders_clients.first_name,users_public.phone as user_phone,users_public.name as user_name,'
                . ' orders_clients.last_name, orders_clients.email, orders_clients.phone, '
                . 'orders_clients.address, orders_clients.city, orders_clients.post_code,'
                . ' orders_clients.notes,  orders_clients.thana, discount_codes.type as discount_type, ');
		$this->db->join('orders', 'order_product.main_order_id = orders.id', 'inner');
        $this->db->join('orders_clients', 'orders_clients.for_id = orders.id', 'inner');
		$this->db->join('users_public', 'orders.user_id = users_public.id', 'inner');
        $this->db->join('discount_codes', 'discount_codes.code = orders.discount_code', 'left');
		$this->db->where('orders.payment_type!=','cashOnDelivery' );
		$this->db->order_by('orders.id', 'DESC');
        $result = $this->db->get('order_product', $limit, $page);
        return $result->result_array();
    }
	public function get_vendor_earning($start_date, $end_date)
    {
		$startDate = strtotime(str_replace('.', '-', $start_date));
		$endDate = strtotime(str_replace('.', '-', $end_date));
      
        $this->db->order_by('id', 'DESC');
        $this->db->select('order_product.*,vendors.name,vendors.warehouse_name');
		$this->db->join('vendors', 'order_product.vendor_id = vendors.id', 'inner');
		$this->db->where('order_product.order_update_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        $this->db->or_where('order_product.order_update_date BETWEEN "'. date('Y-m-d 00:00:00', $startDate). '" and "'. date('Y-m-d 23:59:00', $endDate).'"');
        $result = $this->db->get('order_product');
        return $result->result_array();
    }
	 public function getWeightDetails($weight)
    {
        $this->db->where('weight>=', $weight);
        $query = $this->db->get('weight_data');
        return $query->row_array();
    }
    public function updateOrderPushLog($order_id, $pushData){
        $data = array(
                    'order_push_log' => $pushData
        ); 
        $this->db->where('id', $order_id);
        $this->db->update('orders ', $data);
    }
    public function updateSalesOrderCode($id, $order_product_id,$sales_order){
        $this->db->where('main_order_id', $id);
        $this->db->where('order_product_id', $order_product_id);
        $result = $this->db->update('order_product', array('sales_order_code' => $sales_order));
        return $result;
    }

}
