<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Income extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('SendMail');
        $this->load->model(array('Orders_model', 'Home_admin_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Income';
        $head['description'] = '!';
        $head['keywords'] = '';

        $sort_by = null;
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
        }
		$seller_name = null;
        if ($this->input->get('seller_name') !== NULL) {
            $seller_name = $this->input->get('seller_name');
        }
		$seller_number = null;
        if ($this->input->get('seller_number') !== NULL) {
            $seller_number = $this->input->get('seller_number');
        }
		
        $rowscount = $this->Orders_model->incomeCount();
        $data['orders'] = $this->Orders_model->income_history($this->num_rows, $page, $sort_by, $seller_name, $seller_number);
        $data['links_pagination'] = pagination('admin/orders', $rowscount, $this->num_rows, 3);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/income', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to income page');
        }
    }
public function change_payment_status($payment_id,$status)
    {
        $this->login_check();

        $result = false;
		if($status == 1)
		$status = "paid";
		
        $result = $this->Orders_model->changePaymentStatus($payment_id, $status);
		
        $this->saveHistory('Change Payment status for Payment Id ' . $payment_id);
		redirect('admin/income');
    }
public function income_details(){
	$user_id = $_POST['user_id'];
	$undelivered_percel = $this->Public_model->getUserUndeliveredPercel($user_id);
	$updaid_amount = $this->Public_model->getUserUnpaidAmount($user_id);
	$paid_amount = $this->Public_model->getUserPaidAmount($user_id);
	$rowscount = $this->Public_model->getUserIncomeHistoryCount($user_id);
	$orders_history = $this->Public_model->getUserIncomeHistory($user_id, $this->num_rows, 0);
    $str = '<table class="table">
							<thead>
							  <tr>
								<th>Order Reference</th>
								<th>Date</th>
								<th>Income</th>
								<th>Status</th>
							  </tr>
							</thead>
							<tbody>';
	 $str_order = '';
	 foreach ($orders_history as $order) {
								if($order['processed'] == '0')
								$order_status = "Processing";
								elseif($order['processed'] == '1')
								$order_status = "Processed";
								elseif($order['processed'] == '2')
								$order_status = "Shipped";
								elseif($order['processed'] == '3')
								$order_status = "Delivered";
								elseif($order['processed'] == '4')
								$order_status = "Cancelled";
								$str_order .='<tr>
                                  <td>#'.$order['order_id'].'</td>
                                  <td>'.date('d F Y', $order['date']).'</td>
                                  <td>'.number_format($order['income_amount'],2) . CURRENCY.'</td>
                                  <td>'.strtoupper($order['payment_status']).'</td>
                                 </tr>';
                                 }
                                	
	$str .= $str_order.'</tbody></table>';
						  
	echo '<div class="dashboard-right">
                     <div class="service p-0 ">
							  <div class="col-lg-3 col-sm-6 service-block">
								<div class="media">
								  <div class="media-body">
									<h4>Undelivered Parcels</h4>
									<p>'.$undelivered_percel['total_percel'].'</p>
								  </div>
								</div>
							  </div>
							  <div class="col-lg-3 col-sm-6 service-block">
								<div class="media">
								  <div class="media-body">
									<h4>Payment Processing</h4>
									<p>'.$undelivered_percel['amount']. CURRENCY.'</p>
								  </div>
								</div>
							  </div>
							  <div class="col-lg-3 col-sm-6 service-block">
								<div class="media">
								  <div class="media-body">
									<h4>Unpaid Amount</h4>
									<p>'.$updaid_amount['amount']. CURRENCY.'</p>
								  </div>
								</div>
							  </div>
							  <div class="col-lg-3 col-sm-6 service-block">
								<div class="media">
								  <div class="media-body">
									<h4>Settled</h4>
									<p>'.$paid_amount['amount']. CURRENCY.'</p>
								  </div>
								</div>
							  </div>
							
						  </div>
						  <br><br>
						  '.$str.'
						</div>';
}
}
