<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('assets/razorpay_php/razorpay.php');
use Razorpay\Api\Api as RazorpayApi;

class Users extends MY_Controller
{

    private $registerErrors = array();
    private $user_id;
    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
		//$this->load->library('facebook');
        //$this->load->library('google');
    }

    public function index()
    {
        show_404();
    }

    public function login()
    {
		if(isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
		
		$redirect = $this->input->get('redirect', TRUE);
		
        if (isset($_POST['login'])) {
            $result = $this->Public_model->checkPublicUserIsValid($_POST);
            //print_r($result); exit;
            if ($result !== false) {
                $_SESSION['logged_user'] = $result['id']; //id of user
				$_SESSION['logged_email'] = $result['email'];
				$name = explode(" ",$result['name']);
				$_SESSION['logged_user_name'] = $name[0];
				$_SESSION['guest_user_id'] = $result['id']; 
				$_SESSION['logged_phone'] = $result['phone'];
                
				if($redirect!="")
				redirect(LANG_URL . '/'.$redirect);
				else
				redirect(LANG_URL . '/home');
				
            } else {
                $this->session->set_flashdata('userError', lang('wrong_user'));
            }
        }
        $head = array();
        $data = array();
        $head['title'] = lang('user_login');
        $head['description'] = lang('user_login');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$data['redirect'] = $redirect;
		$data['facebook_login'] = $this->Home_admin_model->getValueStore('facebook_login');
		$data['google_login'] = $this->Home_admin_model->getValueStore('google_login');
		
		//$data['loginURL'] = $this->google->loginURL();
		//$data['authUrl'] =  $this->facebook->login_url();
        $this->render('login', $head, $data);
    }

    public function register()
    {
		if(isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
		$redirect = "";
		$redirect = $this->input->get('redirect', TRUE);	
        if (isset($_POST['signup'])) {
			$redirect = $_POST['redirect'];
			
            $result = $this->registerValidate();
            if ($result == false) {
                $this->session->set_flashdata('userError', $this->registerErrors);
                redirect(LANG_URL . '/login?redirect='.$redirect);
            } else {
                $_SESSION['logged_user'] = $this->user_id; //id of user
				$_SESSION['guest_user_id'] = $this->user_id; 
				$name = explode(" ",$_POST['name']);
				$_SESSION['logged_user_name'] = $name[0];
				$_SESSION['logged_email'] = trim($_POST['email']);
				
                if($redirect!="")
				redirect(LANG_URL . '/'.$redirect);
				else
				redirect(LANG_URL . '/home');
            }
        }
        $head = array();
        $data = array();
        $head['title'] = lang('user_register');
        $head['description'] = lang('user_register');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$data['redirect'] = $redirect;
        $this->render('signup', $head, $data);
    }

    public function myaccount($page = 0)
    {
		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
        $head = array();
        $data = array();
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
        $rowscount = $this->Public_model->getUserOrdersHistoryCount($_SESSION['logged_user']);
        $data['orders_history'] = $this->Public_model->getUserOrdersHistory($_SESSION['logged_user'], $this->num_rows, $page);
        $data['links_pagination'] = pagination('myaccount', $rowscount, $this->num_rows, 2);
        $this->render('user', $head, $data);
    }
	public function orders($page = 0)
    {
		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
		
        $head = array();
        $data = array();
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $rowscount = $this->Public_model->getUserOrdersHistoryCountTwo($_SESSION['logged_user']);
        //echo $rowscount; exit;
        $data['getOrder'] = $this->Public_model->getUserOrdersTwo($_SESSION['logged_user'], $this->num_rows, $page, $_GET);
        // $data['orders_history'] = $this->Public_model->getUserOrdersHistoryTwo($_SESSION['logged_user'], $this->num_rows, $page, $_GET);
        $data['links_pagination'] = pagination('users/orders', $rowscount, $this->num_rows, 3);
        if(isset($_GET['sortby']))
		$data['sort_by'] = $_GET['sortby'];
		// echo "<pre>";
        // print_r($data['getOrder']); exit;
        $this->render('user_order', $head, $data);
    }
	public function order($order_id)
    {
    	//echo ($order_id); exit;
		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
        $head = array();
        $data = array();
		$orders_info = $this->Public_model->getUserOrderDetailsTwo($order_id);
		// echo "<pre>";
		// print_r($orders_info); exit;
		// if($user_id != $_SESSION['logged_user'])
		// redirect(LANG_URL . '/home');
		
        $head['title'] = lang('my_order');
        $head['description'] = lang('my_order');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$data['orders_info'] = $orders_info;
		$data['return_reason'] = $this->Public_model->getReturnReason();
		// echo "<pre>";
		// print_r($data['orders_info']); exit;
        $this->render('user_order_details', $head, $data);
    }
	public function update_order_status($order_id=0,$status=NULL)
    {
		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
        $head = array();
        $data = array();
		$orders_info = $this->Public_model->getUserOrderDetails($order_id);
        
		if($orders_info['user_id'] != $_SESSION['logged_user'])
		redirect(LANG_URL . '/home');
		
		if($status == 'cancel'){
			$this->Public_model->updateOrderStatus($order_id,'cancel');
			$success[] = lang('order_cancel');
			$this->session->set_flashdata('userSuccess', $success);
			redirect(LANG_URL . '/users/order/'.$order_id);
		}
        $head['title'] = lang('my_order');
        $head['description'] = lang('my_order');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$data['orders_info'] = $orders_info;
		
		
        $this->render('user_order_details', $head, $data);
    }
    public function cancelOrder($order_id=0,$status=NULL){
    	//echo $_SESSION['logged_user']; exit;
    	if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
        $head = array();
        $data = array();
        $orders_info = $this->Public_model->getLineItemOrderDetails($order_id);
        $productID = $this->Public_model->findMainOrderID($order_id);
        //$this->Public_model->changeOrderStatus($order_id, 0);
        //exit;
	       // $userPointRollups = $this->Public_model->userPointRollups($_SESSION['logged_user']);
	       // // echo "<pre>";
	       // // print_r($userPointRollups); exit;
		// 	$ballancePointAdd = (($userPointRollups['balancePont'] + $orders_info['reward']) - $orders_info['unit_price']);

		// 	$totalTotalPurchasedValueMinus = $userPointRollups['total_purchased_value'] - $orders_info['unit_price'];

	       //  print_r($totalTotalPurchasedValueMinus); exit;

	        $this->Public_model->updateCancelProductOrderStatus($order_id,'cancel');
	        
	        $this->Public_model->updateCancelOrderStatus($productID['main_order_id'],'cancel');
	        $arr_products = unserialize($productID['order_products']);
			 if($orders_info['payment_type'] == 'Razorpay'){
			// $items = $this->Public_model->getUserOrderDetailsTwo($orders_info['orderID']);
			// echo "<pre>";
			// print_r($items);
			// exit;
			$userPointRollups = $this->Public_model->userPointRollups($_SESSION['logged_user']);
			$ballancePointAdd = ($userPointRollups['balancePont'] + $orders_info['reward'] - $orders_info['unit_price']);

			$totalEarnPointMinus = ($userPointRollups['totalEarnPoint'] - $orders_info['unit_price']);

			$totalTotalPurchasedValueMinus = ($userPointRollups['total_purchased_value'] - $orders_info['unit_price']);


			$rollupsUpdaetData = $this->Public_model->update_user_point_rollups($_SESSION['logged_user'],$totalEarnPointMinus, $ballancePointAdd, $totalTotalPurchasedValueMinus);
			$userPointRollupsTwo = $this->Public_model->userPointRollups($_SESSION['logged_user']);

			$tier = $this->Public_model->getTier($userPointRollupsTwo['total_purchased_value']);

			$this->Public_model->updateTier($_SESSION['logged_user'],$tier['tierMasterID']);

			$customerPoint = $this->Public_model->findCustomarPointCancelreturn($orders_info['user_id'],$orders_info['order_id']);
			$this->Public_model->updateCustomarPoint($orders_info['order_id'], $customerPoint['point_canceled'] + $orders_info['unit_price']);

			$items = $this->Public_model->getUserOrderDetailsTwo($orders_info['orderID']);
			$all_item_cancelled = "1";
			foreach ($items as $item) {
				if($item['status'] != 'cancelled'){
					$all_item_cancelled = "0";
				}
			}



			if($all_item_cancelled == "1"){
				$this->Public_model->updateFullOrderStatus($items[0]['orderID']);
			}
			//print_r($result);

			// print_r($tier);
	        //exit;
	        
	        $this->amoundRefundRazorpay($order_id);
	        $massageID = 160337;
			$this->sendSMS($massageID,$orders_info['phone'],$order['order_id']);
	    	}

	    	$order = $this->Public_model->findOrder($productID['main_order_id']);
	    	if($productID['orderstatus'] != 0){
	    	$this->unicommerceCancelOrder($order_id,$order['order_id'], $productID['sales_order_code']);
    		}
    		
    		
		$this->Public_model->trackingOrderInsert($order['order_id'],$productID['order_product_id'], $arr_products['product_info']['sku'],'cancelled');
		$massageID = 160335;
		$this->sendSMS($massageID,$orders_info['phone'],$order['order_id']);
		$this->sendWhatsAppCancelSMS($orders_info['phone'],'order_modification');
		//for bonus point refund
		//$refundReferral = $this->Public_model->findCustomerPointFrReferral($orders_info['order_id']);
        // if($refundReferral != ''){
        // 	$userPointBonus = $this->Public_model->userPointRollups($refundReferral['customerID']);
        // 	$minusBonusPoint = $userPointBonus['bonusPoint'] - $refundReferral['pointBalance'];
        // 	echo $minusBonusPoint."<br>";

        // 	//$this->Public_model->bonusPointReturn($refundReferral['customerID']);
        // }
        // echo "<pre>";
        // print_r($refundReferral);
        // exit;    	

		if($orders_info['user_id'] != $_SESSION['logged_user'])
		redirect(LANG_URL . '/home');

		
		$success[] = lang('order_cancel');

		$this->session->set_flashdata('orderCancel', 'Order Cancelled!');
		redirect(LANG_URL . '/users/order/'.$orders_info['main_order_id']);
		
		//$this->session->set_flashdata('userSuccess', $success);
		//redirect(LANG_URL . '/users/order/'.$order_id);
		//redirect(LANG_URL . '/users/orders');
    }
    public function returnOrder($order_id=0,$status=NULL){
    	if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
        $head = array();
        $data = array();
        $userPointRollups = $this->Public_model->userPointRollups($_SESSION['logged_user']);
        $productID = $this->Public_model->findMainOrderID($order_id);
        $order = $this->Public_model->findOrder($productID['main_order_id']);
    	$this->unicommerceReturnOrder($order_id,$order['order_id'],$productID['sales_order_code']);
        $this->Public_model->updateReturnProductOrderStatus($order_id,'returned');
        
        //$this->Public_model->changeOrderStatus($productID['main_order_id'], '0');
        $this->Public_model->updateReturnOrderStatus($productID['main_order_id'],'returned');
        
        $arr_products = unserialize($productID['order_products']);
		$orders_info = $this->Public_model->getLineItemOrderDetails($order_id);
		
		$ballancePointMinus = ($userPointRollups['balancePont'] - $orders_info['unit_price']);

		$totalEarnPointMinus = ($userPointRollups['totalEarnPoint'] - $orders_info['unit_price']);

		$totalTotalPurchasedValueMinus = ($userPointRollups['total_purchased_value'] - $orders_info['unit_price']);


		$rollupsUpdaetData = $this->Public_model->update_return_user_point_rollups($_SESSION['logged_user'],$totalEarnPointMinus, $ballancePointMinus,$totalTotalPurchasedValueMinus);

		$userPointRollupsTwo = $this->Public_model->userPointRollups($_SESSION['logged_user']);

		$tier = $this->Public_model->getTier($userPointRollupsTwo['total_purchased_value']);

		$this->Public_model->updateTier($_SESSION['logged_user'],$tier['tierMasterID']);

		if($orders_info['payment_type'] == 'Razorpay'){
			$customerPoint = $this->Public_model->findCustomarPointCancelreturn($orders_info['user_id'],$orders_info['order_id']);

		$this->Public_model->updateCustomarPoint($orders_info['order_id'], $customerPoint['point_canceled']+$orders_info['unit_price']);
		}
		else{
			$customerPoint = $this->Public_model->findCustomarPointCod($order_id,$orders_info['user_id'],$orders_info['order_id']);

			$this->Public_model->updateCustomarPoint($orders_info['order_id'], $customerPoint['point_canceled']+$orders_info['unit_price']);
			
		}

		$items = $this->Public_model->getUserOrderDetailsTwo($orders_info['orderID']);
		$all_item_returned = "1";
		foreach ($items as $item) {
			if($item['status'] != 'returned'){
				$all_item_returned = "0";
			}
		}
		if($all_item_returned == "1"){
			$this->Public_model->updateFullOrderForStatus($items[0]['orderID']);
		}
        if($orders_info['payment_type'] == 'Razorpay'){
        $this->amoundRefundRazorpay($order_id);
        $massageIDs = 160337;
		$this->sendSMS($massageIDs,$orders_info['phone'],$order['order_id']);
    	}
		

    	// $order = $this->Public_model->findOrder($productID['main_order_id']);
    	// // if($productID['orderstatus'] != 0){
    	// $this->unicommerceReturnOrder($order_id,$order['order_id'],$productID['sales_order_code']);
    	// // }

		$this->Public_model->trackingOrderInsert($order['order_id'],$productID['order_product_id'], $arr_products['product_info']['sku'],'returned');  
		$massageID = 160336;
		$this->sendSMS($massageID,$orders_info['phone'],$order['order_id']);  	

		if($orders_info['user_id'] != $_SESSION['logged_user'])
		redirect(LANG_URL . '/home');

		
		$success[] = lang('order_cancel');
		$this->session->set_flashdata('userSuccess', $success);
		//redirect(LANG_URL . '/users/order/'.$order_id);
		redirect(LANG_URL . '/users/orders');
    }
    public function unicommerceReturnOrder($lineItemid,$order_id,$sales_order_code){
    	//echo "lineItemid".$lineItemid;
    	$token = $this->Public_model->getUnicommerceToken();
			$orders_product = $this->Public_model->getOrderLineitem($lineItemid);
				
				$getOrders = $this->Public_model->getOrders($order_id);
				$arr_products = unserialize($orders_product['order_products']);
				// $lineItem_info = $this->Orders_model->getLineItemOrderDetailsAdmin($orders_info['id']);	
				// echo "<pre>";	
				// print_r($orders_product);
				// exit;
				$sales_order_code = explode(",",$sales_order_code);
				$reversePickItems = [];

				$reversePickupAlternate = new stdClass;
				$reversePickupAlternate->itemSku = $arr_products['product_info']['sku'];
				$reversePickupAlternate->totalPrice = ($orders_product['unit_price'] - $orders_product['shipping_cost'])/$arr_products['product_quantity'];
				$reversePickupAlternate->sellingPrice = ($orders_product['unit_price'] - $orders_product['shipping_cost'])/$arr_products['product_quantity'];
				$reversePickupAlternate->discount = ($orders_product['coupon'] + $orders_product['gift_discount'])/$arr_products['product_quantity'];
				$reversePickupAlternate->shippingCharges = $orders_product['shipping_cost']/$arr_products['product_quantity'];
				$reversePickupAlternate->prepaidAmount = $orders_product['unit_price']/$arr_products['product_quantity'];
					// echo "<pre>";
					// print_r(json_encode($reversePickupAlternate));
					// exit;
				
				foreach ($sales_order_code as  $value) {
						
					 	$reversePickItems[] = (object) [
					     "saleOrderItemCode" => $value,
					     "reason" => "Not Good Item",
					     "reversePickupAlternate" => $reversePickupAlternate
					   ];
					};
					// echo "<pre>";
					// print_r(($reversePickItems));
					// exit;

				$returnData = '{
							    "saleOrderCode" : "'.$order_id.'",
							    "reversePickItems": '.json_encode($reversePickItems).',
							    						    
							    "shippingAddress": 
							      {
							        "id": "'.$getOrders['user_id'].'",
							        "name": "'.$getOrders['first_name']." ".$getOrders['last_name'].'",
							        "addressLine1": "'.$getOrders['address'].'",
							        "addressLine2": "",
							        "city": "'.$getOrders['city'].'",
							        "state": "'.$getOrders['thana'].'",
							        "country": "India",
							        "pincode": "'.$getOrders['post_code'].'",
							        "phone": "'.$getOrders['phone'].'",
							        "email": "'.$getOrders['email'].'"
							      }
							    ,
							    "pickupAddress": {
							      "id": "'.$getOrders['user_id'].'",
							        "name": "'.$getOrders['first_name']." ".$getOrders['last_name'].'",
							        "addressLine1": "'.$getOrders['address'].'",
							        "addressLine2": "",
							        "city": "'.$getOrders['city'].'",
							        "state": "'.$getOrders['thana'].'",
							        "country": "India",
							        "pincode": "'.$getOrders['post_code'].'",
							        "phone": "'.$getOrders['phone'].'",
							        "email": "'.$getOrders['email'].'"
							    },
							    "actionCode": "WAC"
							}';

							
						$curl = curl_init();

						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://palsonsderma.unicommerce.com/services/rest/v1/oms/reversePickup/create',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_SSL_VERIFYHOST => 0,
			  			  CURLOPT_SSL_VERIFYPEER => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS => $returnData,
						  CURLOPT_HTTPHEADER => array(
						    'Authorization: Bearer '.$token['access_token'],
						    'Facility: palsonsderma',
						    'Content-Type: application/json'
						  ),
						));


						//$data = fopen("return_request.txt", "w");
 
						// writing content to a file using fwrite() function
						//fwrite($data, $returnData);
						 
						// closing the file
						//fclose($data);
						//$this->Orders_model->updateOrderPushLog($lineItemid, $returnData);

						$response = curl_exec($curl);
						$err = curl_error($ch);
						curl_close($curl);
						if ($err) {
						  //echo "cURL Error #:" . $err;
						} else {
						  //echo ($response);
						}
						
						$response = json_decode($response);

						//$data_response = fopen("return_response.txt", "w");
 
						// writing content to a file using fwrite() function
						//fwrite($data_response, $response);
						 
						// closing the file
						//fclose($data_response);

				
				if($response->successful){
					
					 // $result = $this->Orders_model->changeBulkOrderStatusLineItem($_POST['the_id'], $_POST['to_status'], 'CREATED');
					 // $this->Orders_model->changemainOrderStatus($_POST['the_id'], $_POST['to_status']);
					
					 //$this->Orders_model->updateOrderTracking($_POST['the_id'], $data->packages[0]->waybill);
				}else{
					 //$this->session->set_flashdata('orderstatusError', $data->rmk);
				}
    }
    public function unicommerceCancelOrder($lineItemId,$orderID, $sales_order_code){

    	$sales_order_code = explode(",",$sales_order_code);
    	// $saleOrderItemCodes = [];
    	// foreach ($sales_order_code as  $value) {
    	// 	//echo $value;
    	// 	$saleOrderItemCodes[] = (object) [
    	// 							$value
		// 			   ];
    	// }
    	// echo "<pre>";
    	// print_r($saleOrderItemCodes); exit;
    	$token = $this->Public_model->getUnicommerceToken();
    	$curl = curl_init();

    	$order_cancel_data = array(
		  "saleOrderCode"=>$orderID,
		  "saleOrderItemCodes"=>$sales_order_code,
		  "cancelPartially"=>true,
		  "cancelOnChannel"=>true,
		  "cancellationReason"=>"string"
		);


		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://palsonsderma.unicommerce.com/services/rest/v1/oms/saleOrder/cancel',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>json_encode($order_cancel_data),
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Bearer '.$token['access_token'],
		    'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($ch);
		curl_close($curl);
		if ($err) {
		  //echo "cURL Error #:" . $err;
		} else {
		  //echo ($response);
		}
		// if ($err) {
		//   echo "cURL Error #:" . $err;
		// } else {
		// 	$response_array = json_decode($response);
		// 					if($response_array->successful){
		// 						// $this->Public_model->changeOrderStatusCancelLineItem($lineItemId, 'cancel');

		// 						// $this->Public_model->updateCancelOrderStatus($orderID, 'cancel');
		// 					}
		// 	}
    }
	public function amoundRefundRazorpay($order_id){
		//echo $order_id; exit;
				//$razorpayOrderId = $razorpayOrder['id'];
				//$orders_info = $this->Public_model->getUserOrderDetails($order_id);
				$orders_info = $this->Public_model->getLineItemOrderDetails($order_id);
				$refundAmount = $orders_info['unit_price'];
				$data = $this->Public_model->getpayID($orders_info['order_id']);
				$pay_id = $data['razorpay_payment_id'];

				$api = new RazorpayApi(razorpay_key, razorpay_secret);
				//echo $orders_info['id']; die();
				$api->payment->fetch($pay_id)->refund(array(
					"amount"=> $refundAmount * 100,
					'currency'        => "INR",
					"speed"=>"normal",
					"notes"=>array(
						"notes_key_1"=> "",
						"notes_key_2"=> ""
						),
						 "receipt"=> $orders_info['order_product_id'].$orders_info['id']
						)

					);
				
	}
	public function dashboard($page=0)
    {
		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
        $head = array();
        $data = array();
        $head['title'] = lang('vendor_dashboard');
        $head['description'] = lang('vendor_dashboard');
		$data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
		$data['orders_history'] = $this->Public_model->getUserOrdersHistory($_SESSION['logged_user'], $this->num_rows, $page);
        $head['keywords'] = str_replace(" ", ",", $head['title']);
      
        $this->render('user_dashboard', $head, $data);
    }
	public function profile()
    {
		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
		if (isset($_POST['update'])) {
			//print_r($_POST); exit;
            $_POST['id'] = $_SESSION['logged_user'];
			$errors = array();
			if (mb_strlen(trim($_POST['name'])) == 0) {
				$errors[] = lang('please_enter_name');
			}
			if (mb_strlen(trim($_POST['phone'])) == 0) {
            $errors[] = lang('please_enter_phone');
			}
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$errors[] = lang('invalid_email');
			}
			$count_emails = $this->Public_model->countPublicUsersWithEmail($_POST['email'], $_POST['id']);
			if ($count_emails > 0) {
				$errors[] = lang('user_email_is_taken');
			}
			
			if(mb_strlen(trim($_POST['pass'])) != 0){
				if (mb_strlen(trim($_POST['pass_repeat'])) == 0) {
					$errors[] = lang('repeat_password');
				}
				if ($_POST['pass'] != $_POST['pass_repeat']) {
					$errors[] = lang('passwords_dont_match');
				}
			}
		
			if (sizeof($errors)>0) {
                $this->session->set_flashdata('userError', $errors);
                redirect(LANG_URL . '/users/profile');
            } else {
				$name = explode(" ",$_POST['name']);
				$_SESSION['logged_user_name'] = $name[0];
				
				$success[] = lang('profile_update');
				$this->session->set_flashdata('userSuccess', $success);
                $this->Public_model->updateProfile($_POST);
                redirect(LANG_URL . '/users/profile');
            }
        }
        $head = array();
        $data = array();
		$data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
		$data['addressInfo'] = $this->Public_model->getUserAddressInfo($_SESSION['logged_user']);
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
      
        $this->render('profile', $head, $data);
    }
    public function logout()
    {
        unset($_SESSION['logged_user']);
		unset($_SESSION['guest_user_id']);
		unset($_SESSION['logged_email']);
		unset($_SESSION['logged_mobile']); 
		$this->shoppingcart->clearShoppingCart();
		//$this->facebook->destroy_session();
		
        redirect(LANG_URL);
    }

    private function registerValidate()
    {
        $errors = array();
        if (mb_strlen(trim($_POST['name'])) == 0) {
            $errors[] = lang('please_enter_name');
        }
        if (mb_strlen(trim($_POST['phone'])) == 0) {
            $errors[] = lang('please_enter_phone');
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = lang('invalid_email');
        }
        if (mb_strlen(trim($_POST['pass'])) == 0) {
            $errors[] = lang('enter_password');
        }
        if (mb_strlen(trim($_POST['pass_repeat'])) == 0) {
            $errors[] = lang('repeat_password');
        }
        if ($_POST['pass'] != $_POST['pass_repeat']) {
            $errors[] = lang('passwords_dont_match');
        }

        $count_emails = $this->Public_model->countPublicUsersWithEmail($_POST['email']);
		$guest_user = false;
        if ($count_emails > 0) {
			$getUserDetailsByEmail = $this->Public_model->publicUsersWithEmail($_POST['email']);
			if($getUserDetailsByEmail['name']=='Guest User'){
				$guest_user = true;
				$this->user_id = $getUserDetailsByEmail['id'];
			}
			else{
            $errors[] = lang('user_email_is_taken');
			}
        }
        if (!empty($errors)) {
            $this->registerErrors = $errors;
            return false;
        }
		if($guest_user){
			$_POST['id'] = $this->user_id;
			$this->Public_model->updateProfile($_POST);
		}else{
        	$this->user_id = $this->Public_model->registerUser($_POST);
		}
        return true;
    }
	public function getStateList(){
		$thana_list = $this->Public_model->getStatelist($_POST['country_id']);
		$str = "";
		foreach($thana_list as $thana){
			$str .= "<option value='".$thana['id']."'>".$thana['state_name']."</option>";
		}
		echo $str;
	}
	public function getThanaList(){
		$thana_list = $this->Public_model->getThanalist($_POST['district']);
		$str = "";
		foreach($thana_list as $thana){
			$str .= "<option value='".$thana['id']."'>".$thana['name']."</option>";
		}
		echo $str;
	}
	public function getThanaListForDoctor(){
		$thana_list = $this->Public_model->getThanalist($_POST['district']);
		$str = "";
		foreach($thana_list as $thana){
			$str .= "<option value='".$thana['id']."'>".$thana['name']."</option>";
		}
		echo $str;
	}
	public function subscribe_newsletter()
    {
		if (isset($_POST)) {
			$count_emails = $this->Public_model->countSubscriberEmail($_POST['email']);
			if ($count_emails > 0) {
				echo "0";
			}else{
			$this->Public_model->insertSubscription($_POST['email']);
				echo "1";
			}
		}
	}
	public function forgot_password(){
		 if (isset($_POST['forgot_pass'])) {
            $data = $this->Public_model->checkEmailexist(trim($_POST['email']));
            if ($data) {
						$token = md5(time() . rand());
						$this->Public_model->insertToken(trim($_POST['email']),$token);
						$this->session->set_flashdata('userSuccess', "You should soon receive an email allowing you to reset your password. Please make sure to check your spam and trash if you can not find the email.");
						
						$this->load->library('email');
						$this->email->set_mailtype("html");
						$this->email->from('info@myindiantoy.com', 'My Indian Toy');
						$this->email->to(trim($_POST['email']), trim($_POST['email']));
						$this->email->subject('Reset password instructions');
						$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
						
						$message = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
									  <tbody>
										<tr>
										  <td align="center" style="padding:20px 0 20px 0" valign="top"><table bgcolor="#FFFFFF" border="0" cellpadding="10" cellspacing="0" style="border:1px solid #E0E0E0;" width="650">
											  <tbody>
												<tr>
												  <td style="border-bottom:1px solid #eaeaea;" align="center"><img alt="My Indian Toy" src="'.base_url('attachments/site_logo/' . $sitelogo).'"></td>
												</tr>
												<tr>
												  <td valign="top"><h1 style="font-size:16px; font-weight:normal; line-height:22px; margin:0 0 11px 0;">Hello, '.$data["name"].'!</h1>
													<p style="font-size:16px; line-height:22px; margin:0 0 11px 0;">Someone has requested a link to change your password. You can do this through the link below.</p>
													<p style="font-size:16px; line-height:22px; margin:0 0 11px 0;"><a href="'.LANG_URL ."/resetpassword/".$token.'" target="_blank">Change my password</a></p>
													<p style="font-size:16px; line-height:22px; margin:0 0 11px 0;">If you did not request this, please ignore this email.</p>
													<p style="font-size:16px; line-height:22px; margin:0 0 11px 0;">Your password would not change until you access the link above and create a new one.</p>
													
													</td>
												</tr>
												
												<tr>
												  <td align="center" bgcolor="#EAEAEA" style="background:#EAEAEA; text-align:center;"><center>
													  <p style="font-size:16px; line-height:22px; margin:0 0 11px 0;">Thank you, <strong>My Indian Toy</strong> Team</p>
													</center></td>
												</tr>
											  </tbody>
											</table></td>
										</tr>
									  </tbody>
									</table>';
		
						$this->email->message($message);
						
						$this->email->set_newline("\r\n");
						$this->email->send();
						
				
            } else {
                $this->session->set_flashdata('userError', "Account does not exists.");
            }
        }
        $head = array();
        $data = array();
        $head['title'] = "Retrieve your account password";
        $head['description'] = "Retrieve your account password";
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('forgot_password', $head, $data);
	}
	public function resetpassword($accessToken)
	{
		if($accessToken == ""){
			redirect(LANG_URL . '/users/login');
		}
		
		if (isset($_POST['update'])) {
			$result = $this->changePasswordValidate();
            if ($result == false) {
                $this->session->set_flashdata('userError', $this->registerErrors);
                //redirect(LANG_URL . '/resetpassword/'.$accessToken);
            } else {
                $tonekDetails = $this->Public_model->checktokenExist($accessToken);
				if($tonekDetails)
				{
					$this->Public_model->updateUserPassword($tonekDetails['email'],$this->input->post('pass'));
					$this->Public_model->deleteToken($accessToken);
					$this->session->set_flashdata('userSuccess', "Your password changed successfully. Please login to access your profile.");
					
					redirect(LANG_URL . '/users/login');
					
				}
            }
		}
		
		$tonekDetails = $this->Public_model->checktokenExist($accessToken);
		$head['title'] = "Change your account password";
        $head['description'] = "Change your account password";
		$head['keywords'] = str_replace(" ", ",", $head['title']);
		if($tonekDetails)
		{
			
			$head['title'] = "Change your password";
			$data['token'] = $accessToken;
			$this->render('change_password', $head, $data);
			
		}
		else
		{
			redirect(LANG_URL . '/home');
		}
	}
	private function changePasswordValidate()
    {
        $errors = array();
        
        if (mb_strlen(trim($_POST['pass'])) == 0) {
            $errors[] = lang('enter_password');
        }
        if (mb_strlen(trim($_POST['pass_repeat'])) == 0) {
            $errors[] = lang('repeat_password');
        }
        if ($_POST['pass'] != $_POST['pass_repeat']) {
            $errors[] = lang('passwords_dont_match');
        }
        if (!empty($errors)) {
            $this->registerErrors = $errors;
            return false;
        }
        return true;
    }
	public function authenticate()
	{	
		if($this->facebook->is_authenticated()){
			$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
			
			if($this->Public_model->checkSocialUser($userProfile["id"]))
			{
				$result = $this->Public_model->checkSocialUser($userProfile["id"]);
				$_SESSION['logged_user'] = $result['id']; //id of user
						$_SESSION['logged_email'] = $result['email'];
						$name = explode(" ",$result['name']);
						$_SESSION['logged_user_name'] = $name[0];
						$_SESSION['guest_user_id'] = $result['id']; 
							
						if($redirect!="")
						redirect(LANG_URL . '/'.$redirect);
						else
						redirect(LANG_URL . '/home');
						
			}
			else
			{
				$userID = $this->Public_model->createSocialMember($userProfile['first_name']." ".$userProfile['last_name'],$userProfile['email'],$userProfile['picture']['data']['url'],$userProfile['id'],'facebook');
				$_SESSION['logged_user'] = $userID; //id of user
				$_SESSION['guest_user_id'] = $userID; 
				$_SESSION['logged_user_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
				$_SESSION['logged_email'] = $userProfile['email'];
				
                if($redirect!="")
				redirect(LANG_URL . '/'.$redirect);
				else
				redirect(LANG_URL . '/home');
				
			}
		}
	}
	public function authenticate_google_user()
	{	
		if(isset($_GET['code'])){
            //authenticate user
            $this->google->getAuthenticate();
            $gpInfo = $this->google->getUserInfo();
			if($this->Public_model->checkSocialUser($gpInfo['id']))
			{
						$result = $this->Public_model->checkSocialUser($gpInfo['id']);
						$_SESSION['logged_user'] = $result['id']; //id of user
						$_SESSION['logged_email'] = $result['email'];
						$name = explode(" ",$result['name']);
						$_SESSION['logged_user_name'] = $name[0];
						$_SESSION['guest_user_id'] = $result['id'];
							
						if($redirect!="")
						redirect(LANG_URL . '/'.$redirect);
						else
						redirect(LANG_URL . '/home');
								
			}
			else
			{
				$userID = $this->Public_model->createSocialMember($gpInfo['given_name']." ".$gpInfo['family_name'],$gpInfo['email'],$gpInfo['picture'],$gpInfo['id'],'google');
				$_SESSION['logged_user'] = $userID; //id of user
				$_SESSION['logged_user_name'] = $gpInfo['given_name'];
				$_SESSION['logged_email'] = $gpInfo['email'];
				$_SESSION['guest_user_id'] = $userID; 
					
                if($redirect!="")
				redirect(LANG_URL . '/'.$redirect);
				else
				redirect(LANG_URL . '/home');
			}
        } 
	}
	public function wishlist($page=0)
    {
		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
        $head = array();
        $data = array();
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $rowscount = $this->Public_model->getUserWishlistCount($_SESSION['logged_user']);
        $data['products'] = $this->Public_model->getUserWishlist($_SESSION['logged_user'], $this->num_rows, $page);
        $data['links_pagination'] = pagination('users/wishlist', $rowscount, $this->num_rows, 3);
        //print_r($data['products']); exit;
        $this->render('user_wislist', $head, $data);
    }
   public function manage_address(){
   		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
        $head = array();
        $data = array();
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
        $data['user_address'] = $this->Public_model->getUserAddress($_SESSION['logged_user']);
        //print_r($data['user_address']); exit;
        $this->render('manage_address', $head, $data);
   }
   public function aboutus(){   		
        $head = array();
        $data = array();
        $head['title'] = lang('aboutus');
        $head['description'] = lang('aboutus');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$data['redirect'] = $redirect;
		$head['pageactive'] = "aboutus";
		$data['aboutUs'] = $this->Public_model->getaboutUs();
		$data['aboutUsBanner'] = $this->Public_model->getaboutUsBanner();
		// echo "<pre>";
		// print_r($data['aboutUsBanner']);
		// die();
        $this->render('aboutus', $head, $data);
   }
   public function gift(){   		
        $head = array();
        $data = array();
        $head['title'] = lang('gift');
        $head['description'] = lang('gift');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$data['redirect'] = $redirect;
		$data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
        $data['user_address'] = $this->Public_model->getUserAddress($_SESSION['logged_user']);
		if (isset($_POST['buy_gift'])) {
			
			//echo "ok";
		 	//print_r($_POST); die;
            //$result = $this->Public_model->updatePersonalInfo($id, $_POST);
            //print_r($result); exit;
            //if ($result != "") {
           //$this->session->set_flashdata('userSuccess', 'Successfully Updated!!');
               // redirect(LANG_URL . '/edit_personal_info'.'/'.$id);
				
            //}
        }
        //print_r($data['userInfo']); exit;
        $this->render('gift', $head, $data);
   }
   public function gift_card_details(){   		
        $head = array();
        $data = array();
        $head['title'] = lang('gift_card_details');
        $head['description'] = lang('gift_card_details');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$data['redirect'] = $redirect;
		$userInfo = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
		$data['userInfo'] = $userInfo;
        $data['giftdetails'] = $this->Public_model->getGiftDetails($userInfo['id']);
        // echo "<pre>";
        // print_r($data['giftdetails']); exit;
		
        $this->render('gift_card_details', $head, $data);
   }
    function create_gift(){
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $price = $_POST['price'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
	   	$mobile = $_POST['mobile'];
	   	//print_r($_POST); exit;
	   	
	   		
   			$order_id =  time().$mobile;
   			$giftId = $this->Public_model->setGiftCoupon($price,$name,$email,$message,$mobile,$_SESSION['logged_user'], $order_id);
   			$_SESSION['gift_id'] =  $giftId;
			$api = new RazorpayApi(razorpay_key, razorpay_secret);
			$orderData = [
				'receipt'         => $order_id,
				'amount'          => $_POST['price'] * 100, // 2000 rupees in paise
				'currency'        => "INR",
				'payment_capture' => 1 // auto capture
			];
			//print_r($orderData); exit;
			$razorpayOrder = $api->order->create($orderData);
			//print_r($razorpayOrder); exit;
			$razorpayOrderId = $razorpayOrder['id'];
			
			$_SESSION['razorpay_order_id'] = $razorpayOrderId;
			
			//$displayAmount = $amount = $orderData['amount'];
			
			$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
			
			$data = [
				"key"               => razorpay_key,
				"amount"            => $_POST['price'],
				"name"              => "Neolayr",
				"description"       => "Gift card",
				"image"             => base_url('attachments/site_logo/' . $sitelogo),
				"prefill"           => [
					"name"              => $_POST['name'],
					"email"             => $_POST['email'],
					"contact"           => "+".$_POST['email'].$_POST['mobile'],
					],
				"theme"             => [
					"color"             => "#F37254"
				],
				"order_id"          => $razorpayOrderId,
			];
			//print_r($data); exit;
			file_put_contents('./payment_log/razorpay/rz_payment_request_'.$orders_info['order_id'].'.txt', "Order Data:".json_encode($orderData)."<br>Request Dat:".json_encode($data));
			echo json_encode($data);
   }
   public function giftcard_razorpay_payment(){
		$success = true;
		file_put_contents('./payment_log/razorpay/rz_payment_response_'.$_SESSION['order_id'].'.txt', json_encode($_POST));
		if(!empty($_POST['razorpay_payment_id']) === false)
		{
			$api = new RazorpayApi(razorpay_key, razorpay_secret);
		
			try
			{
				
				$attributes = array(
					'razorpay_order_id' => $_SESSION['razorpay_order_id'],
					'razorpay_payment_id' => $_POST['razorpay_payment_id'],
					'razorpay_signature' => $_POST['razorpay_signature']
				);
		
				$api->utility->verifyPaymentSignature($attributes);
			}
			catch(SignatureVerificationError $e)
			{
				$success = false;
				$error = 'Razorpay Error : ' . $e->getMessage();
			}
		}
		if ($success === true)
		{
			$length_of_string = 6;
	        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	         
	        $text =  substr(str_shuffle($str_result),0, $length_of_string);
	        
			$giftCartData = $this->Public_model->updaetGiftCardDetails($_SESSION['gift_id'],$text);
			redirect(LANG_URL . '/users/gift');
		}
		else
		{
			// $this->Public_model->changePaymentStatus($_SESSION['order_id'],'failed');
			// $_SESSION['success_order'] = 'false';
			// unset($_SESSION['order_id']);
			// redirect(LANG_URL . '/shopping-cart');
			
		}
	}
   public function add_address(){
   		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
		 if (isset($_POST['add_address'])) {
		 	$state = $this->Public_model->searchState($_POST['add_state']);
    		$city = $this->Public_model->searchCity($_POST['add_city']);
    		if(sizeof($city)>0){
	    	$result = $this->Public_model->addNewAddress($_POST,$state['id'],$city['id']);
	    	}
	    	else{
	    		$cityID = $this->Public_model->insertCity($_POST['add_city'],$state['id']);
	    		$result = $this->Public_model->addNewAddress($_POST,$state['id'],$cityID);
	    	}

            // $result = $this->Public_model->addNewAddress($_POST,$state['id'],$city['id']);
            //print_r($result); exit;
            if ($result != "") {
                redirect(LANG_URL . '/manage-address');
				
            }
        }
        $head = array();
        $data = array();
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
        $data['user_address'] = $this->Public_model->getUserAddress($_SESSION['logged_user']);
        $data['country_list'] = $this->Public_model->getcountrylist();
        $data['state_list'] = $this->Public_model->getStatelist("101");
        $this->render('add_address', $head, $data);
   }
   public function edit_address($id){
   	if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
		 if (isset($_POST['edit_address'])) {
		 	//print_r($_POST); die;
		 	$state = $this->Public_model->searchState($_POST['add_state']);
    		$city = $this->Public_model->searchCity($_POST['add_city']);
    		if(sizeof($city)>0){
	    	$result = $this->Public_model->updateNewAddress($id, $_POST,$state['id'],$city['id']);
	    	}
	    	else{
	    		$cityID = $this->Public_model->insertCity($_POST['add_city'],$state['id']);
	    		$result = $this->Public_model->updateNewAddress($id, $_POST,$state['id'],$cityID);
	    	}
            //$result = $this->Public_model->updateNewAddress($id, $_POST,$state['id'],$city['id']);
            //print_r($result); exit;
            //if ($result != "") {
           $this->session->set_flashdata('userSuccess', 'Successfully Updated!!');
                redirect(LANG_URL . '/manage-address');
				
            //}
        }
        $head = array();
        $data = array();
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
        $items = $this->Public_model->fetch_singleDeliveryAddress($id);
        $data['user_address'] = $items;
        $data['country_list'] = $this->Public_model->getcountrylist();
        $data['state_list'] = $this->Public_model->getStatelist("101");
        $data['city_list'] = $this->Public_model->getCitylist($items['state']);
        $this->render('edit_address', $head, $data);
   }
   public function edit_personal_info($id){
   		if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/home');
		}
		 if (isset($_POST['edit_personal_info'])) {
		 	//print_r($_POST); die;
            $result = $this->Public_model->updatePersonalInfo($id, $_POST);
            //print_r($result); exit;
            //if ($result != "") {
           $this->session->set_flashdata('userSuccess', 'Successfully Updated!!');
                // redirect(LANG_URL . '/edit_personal_info'.'/'.$id);
            redirect(LANG_URL . '/users/profile');
				
            //}
        }
        $head = array();
        $data = array();
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
        $items = $this->Public_model->fetch_singleDeliveryAddress($id);
        // $fullName = $items['name'];
		// $names = explode('  ', $fullName);
		
        $data['user_address'] = $items;
        //print_r($data['user_address']); die();
        $data['country_list'] = $this->Public_model->getcountrylist();
        $data['state_list'] = $this->Public_model->getStatelist("101");
        $data['city_list'] = $this->Public_model->getCitylist($items['state']);
        $this->render('edit_personal_info', $head, $data);
   }
    public function reward(){   		
        $head = array();
        $data = array();
        $head['title'] = lang('reward');
        $head['description'] = lang('reward');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $reward_details = $this->Public_model->reward_details($_SESSION['logged_user']);
        $tier = $this->Public_model->find_tier($reward_details['tier']);
        $data['reward_details'] = $reward_details;
        if($reward_details['total_purchased_value'] < 10000){
        $data['percent_reward'] = (70*$reward_details['total_purchased_value']/10000);
    	}else{
    		$data['percent_reward'] = 100;
    	}
    	$data['tier'] = $tier;
        //print_r($data['tier']); die();
		$data['redirect'] = $redirect;
        $this->render('reward', $head, $data);
   }
   public function refer_friend(){
   		$head = array();
        $data = array();
        $head['title'] = lang('reward');
        $head['description'] = lang('reward');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
		$data['addressInfo'] = $this->Public_model->getUserAddressInfo($_SESSION['logged_user']);
        $this->render('refer_friend', $head, $data);
   }
   
}
