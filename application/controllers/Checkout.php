<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('assets/razorpay_php/razorpay.php');
use Razorpay\Api\Api as RazorpayApi;

class Checkout extends MY_Controller
{

    private $orderId;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Orders_model');
    }

    public function index()
    {
		/*if(!isset($_SESSION['logged_user'])){
			redirect(LANG_URL . '/users/login?redirect=checkout');
		}*/
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('checkout');
        $head['title'] = "Place Order";
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);

        if (isset($_POST['payment_type'])) {
					if($_POST['selected_address_id']==""){
						$errors[] = "Please select proper address.";
						$this->session->set_flashdata('submit_error', $errors);
						redirect(LANG_URL . '/checkout');
					}else{

						$address_details = $this->Public_model->getAddressDetails($_POST['selected_address_id']);
						
						$_POST['referrer'] = $this->session->userdata('referrer');
						$_POST['clean_referrer'] = cleanReferral($_POST['referrer']);
						$userInfo = $this->Public_model->getUserProfileInfo(isset($_SESSION['logged_user'])?$_SESSION['logged_user']:$_SESSION['guest_user_id']);
						$_POST['user_id'] = isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : $_SESSION['guest_user_id'];
						
						$_POST['email'] = isset($userInfo['email']) ? $userInfo['email'] : 0;
						
						$_POST['first_name'] = $address_details['first_name'];
						$_POST['last_name'] = $address_details['last_name'];
						$_POST['phone'] = $address_details['phone'];
						$_POST['address'] = $address_details['address'];
						$_POST['country'] = $address_details['country_name'];
						$_POST['city'] = $address_details['city_name'];
						$_POST['post_code'] = $address_details['post_code'];
						$_POST['thana'] = $address_details['state_name'];
						$_POST['notes'] = $address_details['notes'];
						
						

						$shipping_cost= $_POST['shpping_cost'];
						
						$delivery_time= $_POST['delivery_time'];
						$order_id =  date('YmdHis').$_POST['user_id'];
						$pdfFilePath = 'Order_Invoice_'.$order_id.'.pdf';
							
						$orderId = $this->Public_model->setOrder($order_id,$_POST,$shipping_cost,$delivery_time,$pdfFilePath);
						if ($orderId != false) {
							$orders_info = $this->Public_model->getOrderDetails($orderId);
							$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
								/* Start reward */
							// $totalTransactionBalance = $this->Public_model->totalTransactionBalance($orders_info['user_id']);

							// $tier = $this->Public_model->getTier($totalTransactionBalance);

							// $pointBalance = (int)(($orders_info['total_order_price'] * $tier['pointPercentage']) / 100);

							// $customerPoint = $this->Public_model->getCustomerPoint($orders_info['user_id']);
							// if($customerPoint){
							// 	$currentPointBalance = ($customerPoint['currentPointBalance'] + $pointBalance);
							// }
							// else{
							// 	$currentPointBalance = $pointBalance;
							// }
							
							// $customerPoint = $this->Public_model->setCustomerPoint($orders_info, $userInfo,$pointBalance,$currentPointBalance);

							// $totalPointBalance = $this->Public_model->totalPointBalance($orders_info['user_id']);
							

							// //print_r($tier); die();

							// $userPointSum = $this->Public_model->getUserPointSum($orders_info['user_id']);

							
							// if($userPointSum){
							// 	$this->Public_model->updateUserPointSum($orders_info, $totalPointBalance, $tier['tierMasterID'], $currentPointBalance);
							// }
							// else{
							// 	$this->Public_model->setUserPointSum($orders_info,$totalPointBalance, $tier['tierMasterID'], $currentPointBalance);
							// }
							
							/* End reward */

							$this->session->set_userdata('orderId', $orderId);
							if($_POST['payment_type'] == 'cashOnDelivery'){
								//$this->generatePDF_EmailNotification($orderId);
							}
							$this->orderId = $orderId;
							//	$this->setVendorOrders();
							  $this->sendNotifications();
							  $this->goToDestination();
							//	$this->orderByShiprocket($orderId);
							 	//$this->sendEmailNotifications($orderId);

						} else {
							log_message('error', 'Cant save order!! ' . implode('::', $_POST));
							$this->session->set_flashdata('order_error', true);
							redirect(LANG_URL . '/checkout/order-error');
						}
					}
					
					
				
        }
        $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
        $data['cashondelivery_visibility'] = $this->Home_admin_model->getValueStore('cashondelivery_visibility');
        $data['freecharge_payment'] = $this->Home_admin_model->getValueStore('freecharge_payment');
		$data['razorpay_payment'] = $this->Home_admin_model->getValueStore('razorpay_payment');
        $data['bestSellers'] = $this->Public_model->getbestSellers();
		$data['previous_address'] = array();
		//Get last order address
		$previous_address = array();;
		if(isset($_SESSION['logged_user'])){
			$previous_address = $this->Public_model->getPreviousAddress($_SESSION['logged_user']);
			$data['previous_address'] = $previous_address;
		}
		
		$district_list = $this->Public_model->getdistrictlist();
		/*foreach($district_list as $district){
			if($district['is_default'] == 'yes')
			$district_id = $district['district_id'];
		}*/
		$data['country_list'] = $this->Public_model->getcountrylist();
		$data['state_list'] = $this->Public_model->getStatelist("101");
		//$data['district_list'] = $this->Public_model->getdistrictlist();
		/*if(sizeof($previous_address)>0){
			$district = $this->Public_model->getDistrictByName($previous_address['city']);
			if($district['district_id']!="")
			$data['thana_list'] = $this->Public_model->getThanalist($district['district_id']);
			else
			$data['thana_list'] = $this->Public_model->getThanalist($district_id);
		}else{
			$data['thana_list'] = $this->Public_model->getThanalist($district_id);
		}*/
		$data['recentlyAdded'] = $this->Public_model->getRecentlyAddedProduct();
        $data['featuredProducts'] = $this->Public_model->getFeatured_products();
        $this->render('checkout', $head, $data);
    }
	public function freecharge_payment()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('checkout');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$orders_info = $this->Public_model->getOrderDetails($this->session->userdata('orderId'));
		$price = round($orders_info['total_order_price']);
		//$price = number_format($orders_info['total_order_price'],2);
		//$new_price = str_replace(',','',$price);
		$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
					
        			$payment_info = array(
							 "amount"=>$price.".00",
							 "channel"=>"WEB",
							 "currency"=>"INR",
							 "customerName"=>$userInfo['name'],
							 "email"=>$userInfo['email'],
							 "furl"=>LANG_URL . '/checkout/process_payment',
							 "merchantId"=>"EZpfh7yEVcWYt4",
							 "merchantTxnId"=>$orders_info['order_id'],
							 "mobile"=>$orders_info['phone'],
							 "productInfo"=>"auth",
							 "surl"=>LANG_URL . '/checkout/process_payment'
							);
						$string = "{";
						$counter = 1;
						foreach($payment_info as $key=>$value){
							$string.='"'.$key.'":"'.$value.'"';
							if($counter<sizeof($payment_info))
							$string.=',';
							
							$counter++;
						}
						$string.="}";
						
						//Sandbox Key - aeb679f5-d313-4fb0-bbe9-e7f8cd8b304d
						//Live Key: dfe4b51c-ebc8-4bec-a9c8-b77c0540b424
						
						$string .= freecharge_key;
						$hash = hash('sha256', $string);
						$data['hash'] = $hash;
						
						file_put_contents('./payment_log/freecharge/fr_payment_request_'.$orders_info['order_id'].'.txt', $string);
						//echo $responce;
						
						$data['payment_info'] = $payment_info;
        $this->render('checkout_parts/freecharge_payment', $head, $data);
    }
	public function process_payment(){
		ksort($_POST);
		
		file_put_contents('./payment_log/freecharge/fr_payment_response_'.$_SESSION['order_id'].'.txt', json_encode($_POST));
		
		$string = "{";
		$counter = 1;
		foreach($_POST as $key=>$value){
						if($key!='checksum'){
							if($value!=""){
								$string.='"'.$key.'":"'.$value.'"';
								if($counter<(sizeof($_POST)))
								$string.=',';
							}
						}
						$counter++;
		}
		$string.="}".freecharge_key;
		$generated_hash = hash('sha256', $string);
		if($generated_hash == $_POST['checksum'] && $_POST['status'] == 'COMPLETED')
		{
			$this->Public_model->changePaymentStatus($_SESSION['order_id'],strtolower($_POST['status']));
			$this->generatePDF_EmailNotification($_SESSION['order_id']);
			$this->session->set_flashdata('success_order', true);
			unset($_SESSION['order_id']);
			$this->shoppingcart->clearShoppingCart();
			redirect(LANG_URL . '/checkout/successcash');
							
		}else{
			$this->Public_model->changePaymentStatus($_SESSION['order_id'],'failed');
			$_SESSION['success_order'] = 'false';
			unset($_SESSION['order_id']);
			redirect(LANG_URL . '/checkout');
		}
	}
	public function razorpay_payment()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('checkout');
        $head['title'] = "Complete your purchase";
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		$orders_info = $this->Public_model->getOrderDetails($this->session->userdata('orderId'));
		$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
		
		$dollar_value = $this->Home_admin_model->getValueStore('dollar_value');
		
		if($orders_info['country'] == "India"){
			$currency = "INR";
			$price = $orders_info['total_order_price'] * 100;
		}
		else{
			$currency = "USD";
			$usd_value = $dollar_value;
			$price = (round(($orders_info['total_order_price']/$usd_value),2) * 100);
		}
		
		
		$api = new RazorpayApi(razorpay_key, razorpay_secret);
			$orderData = [
				'receipt'         => $orders_info['order_id'],
				'amount'          => $price, // 2000 rupees in paise
				'currency'        => $currency,
				'payment_capture' => 1 // auto capture
			];
			
			$razorpayOrder = $api->order->create($orderData);
			
			$razorpayOrderId = $razorpayOrder['id'];
			
			$_SESSION['razorpay_order_id'] = $razorpayOrderId;
			
			$displayAmount = $amount = $orderData['amount'];
			
			/*if ($displayCurrency !== 'INR')
			{
				$url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
				$exchange = json_decode(file_get_contents($url), true);
			
				$displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
				
				Sandbox Key - rzp_test_bOzqbe6QXppE4G
				Sandbox Key Secret:  YZugNxgKPiSvrnyE208WKVsG
				
				Live Key - rzp_live_35wAKDCp6xwJxl
				Live Key Secret:  lTwUJB9FitAMymcJJiRx6o9s
			}
			*/
			$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
			
			$data = [
				"key"               => razorpay_key,
				"amount"            => $amount,
				"name"              => "Neolayr",
				"description"       => "Made in India",
				"image"             => base_url('attachments/site_logo/' . $sitelogo),
				"prefill"           => [
					"name"              => $userInfo['name'],
					"email"             => $userInfo['email'],
					"contact"           => $userInfo['phone'],
					],
				"notes"             => [
					"address"           => $orders_info['address'],
					"merchant_order_id" => $orders_info['order_id'],
				],
				"theme"             => [
					"color"             => "#F37254"
				],
				"order_id"          => $razorpayOrderId,
			];
			
			
			
			$data['json'] = json_encode($data);
        $this->render('checkout_parts/razorpay_payment', $head, $data);
    }
    public function create_order(){
		if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        // print_r($_POST);
        // exit;
						$product_id = array();
                        $product_qunaitity = array();
                        $items = $this->shoppingcart->getCartItems();


                        foreach ($items['array'] as $cartItem) { 
                            array_push($product_id,$cartItem['id']);
                            array_push($product_qunaitity,$cartItem['num_added']);
                        }
                        $_POST['id'] = $product_id;
                        $_POST['quantity'] = $product_qunaitity;

                        $product_id_buynow = array();
                        $product_qunaitity_buynow = array();
                        if($_POST['productVariant'] != ''){
                            $data_cart = array();
                            foreach($items['array'] as $item){
                                if($_POST['productVariant'] == $item['product_id']){
                                    array_push($product_id_buynow,$item['id']);
                                    array_push($product_qunaitity_buynow,$item['num_added']);
                                    //array_push($_POST, $item);
                                }
                            }
                            $_POST['id'] = $product_id_buynow;
                            $_POST['quantity'] = $product_qunaitity_buynow;
                            $_SESSION['productVariant'] = $_POST['productVariant'];
                            // $items['array'] = $data_cart;

                        }

						$address_details = $this->Public_model->getAddressDetails($_POST['selected_address_id']);
						
						$_POST['referrer'] = $this->session->userdata('referrer');
						$_POST['clean_referrer'] = cleanReferral($_POST['referrer']);
						$userInfo = $this->Public_model->getUserProfileInfo(isset($_SESSION['logged_user'])?$_SESSION['logged_user']:$_SESSION['guest_user_id']);
						$_POST['user_id'] = isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : $_SESSION['guest_user_id'];
						
						$_POST['email'] = isset($userInfo['email']) ? $userInfo['email'] : 0;
						
						$_POST['first_name'] = $address_details['first_name'];
						$_POST['last_name'] = $address_details['last_name'];
						$_POST['phone'] = $address_details['phone'];
						$_POST['address'] = $address_details['address'];
						$_POST['country'] = $address_details['country_name'];
						$_POST['city'] = $address_details['city_name'];
						$_POST['post_code'] = $address_details['post_code'];
						$_POST['thana'] = $address_details['state_name'];
						$_POST['notes'] = $address_details['notes'];

						$_SESSION['birthday_amount'] = $_POST['birthday_amount'];
						
						$shipping_cost= $_POST['shpping_cost'];
						$delivery_time= $_POST['delivery_time'];
						$order_id =  date('YmdHis').$_POST['user_id'];
						$pdfFilePath = 'Order_Invoice_'.$order_id.'.pdf';
						//print_r($_POST); die();
						// if($_POST['paid_amount'] != ''){

						// }
						$productId = array();
						foreach ($_POST['id'] as $productID) {
                            array_push($productId, $productID);
                        }	
                        $productIds = implode(",", $productId);
                        $_SESSION['productIds'] =  $productIds;
						$orderId = $this->Public_model->setOrder($order_id,$_POST,$shipping_cost,$delivery_time,$pdfFilePath);
						$this->session->set_userdata('orderId', $orderId);
						
						$_SESSION['order_id'] =  $orderId;
						$this->orderId = $orderId;
							
						$orders_info = $this->Public_model->getOrderDetails($this->session->userdata('orderId'));
						$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);


						if($_POST['giftAmount'] > 0){
                            $_SESSION['giftCode'] =  $_POST['giftVoucher'];
                        }
							/* Start reward */
							// $totalTransactionBalance = $this->Public_model->totalTransactionBalance($orders_info['user_id']);

							// $tier = $this->Public_model->getTier($totalTransactionBalance);

							// $pointBalance = (int)(($orders_info['total_order_price'] * $tier['pointPercentage']) / 100);

							// $customerPoint = $this->Public_model->getCustomerPoint($orders_info['user_id']);
							// if($customerPoint){
							// 	$currentPointBalance = ($customerPoint['currentPointBalance'] + $pointBalance);
							// }
							// else{
							// 	$currentPointBalance = $pointBalance;
							// }
							
							// $customerPoint = $this->Public_model->setCustomerPoint($orders_info, $userInfo,$pointBalance,$currentPointBalance);

							// $totalPointBalance = $this->Public_model->totalPointBalance($orders_info['user_id']);
							

							//print_r($tier); die();

							// $userPointSum = $this->Public_model->getUserPointSum($orders_info['user_id']);
							
							// if($userPointSum){
                            //      $total_transactionAmount = $userPointSum['total_purchased_value'] + $orders_info['total_order_price'];
                            //     $this->Public_model->updateUserPointSum($orders_info, $point, $tier['tierMasterID'], $currentPointBalance, $total_transactionAmount);
                            // }
                            // else{
                            //     $this->Public_model->setUserPointSum($orders_info,$point, $tier['tierMasterID'], $currentPointBalance,$total_transactionAmount);
                            // }
							/* End reward */
							/* start referral reward */
						// 	if($this->session->userdata('referral_code') != ''){
                          //     $isReferralExist = $this->Public_model->checkIsReferralInOrder($_SESSION['logged_email'],$this->session->userdata('referral_code'));
                          //     $tot_bonus_point = 0;
                          //     if($isReferralExist == true){
                          //       $bonus_point = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);

                          //       $tot_bonus_point = ($bonus_point['bonusPoint'] + 500);
                          //       $this->Public_model->updateUserBonusPoint($orders_info, $tot_bonus_point);

                          //       $pointBalances = 500;
                          //       $customerPoints = $this->Public_model->getCustomerPoint($orders_info['user_id']);
                          //       if($customerPoints){
                          //           $currentPointBalance = ($customerPoints['currentPointBalance'] + $pointBalances);
                          //       }
                          //       else{
                          //           $currentPointBalance = $pointBalances;
                          //       }
                          //        $customerPoint = $this->Public_model->setCustomerPoint($orders_info, $userInfo,$pointBalances,$currentPointBalance);
                            
                          //     }
                          // }
                             /* stop referral reward */
                            //  if($_POST['paid_amount'] != 0){
                            // $paidPoin = ($_POST['paid_amount']);
                            // $reward_point = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);
                            // $balancePont = ($reward_point['balancePont'] - $paidPoin);
                            // $this->Public_model->updateRollups($_SESSION['logged_user'], $balancePont);
                            // }
						
		$dollar_value = $this->Home_admin_model->getValueStore('dollar_value');
		//$this->sendEmailNotifications($orderId);
		if($orders_info['country'] == "India"){
			$currency = "INR";
			$price = ($orders_info['total_order_price'] * 100);
		}
		else{
			$currency = "USD";
			$usd_value = $dollar_value;
			$price = (round(($orders_info['total_order_price']/$usd_value),2) * 100);
		}

		
		
		$api = new RazorpayApi(razorpay_key, razorpay_secret);
			$orderData = [
				'receipt'         => $orders_info['order_id'],
				'amount'          => $price, // 2000 rupees in paise
				'currency'        => $currency,
				'payment_capture' => 1 // auto capture
			];
			
			$razorpayOrder = $api->order->create($orderData);
			
			$razorpayOrderId = $razorpayOrder['id'];
			
			$_SESSION['razorpay_order_id'] = $razorpayOrderId;
			
			$displayAmount = $amount = $orderData['amount'];
			
			/*if ($displayCurrency !== 'INR')
			{
				$url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
				$exchange = json_decode(file_get_contents($url), true);
			
				$displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
				
				Sandbox Key - rzp_test_bOzqbe6QXppE4G
				Sandbox Key Secret:  YZugNxgKPiSvrnyE208WKVsG
				
				Live Key - rzp_live_35wAKDCp6xwJxl
				Live Key Secret:  lTwUJB9FitAMymcJJiRx6o9s
			}
			*/
			$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
			
			$data = [
				"key"               => razorpay_key,
				"amount"            => $amount,
				"name"              => "Neolayr",
				"description"       => "Made in India",
				"image"             => base_url('attachments/site_logo/' . $sitelogo),
				"prefill"           => [
					"name"              => $userInfo['name'],
					"email"             => $userInfo['email'],
					"contact"           => "+".$address_details['phonecode'].$userInfo['phone'],
					],
				"notes"             => [
					"address"           => $orders_info['address'],
					"merchant_order_id" => $orders_info['order_id'],
				],
				"theme"             => [
					"color"             => "#F37254"
				],
				"order_id"          => $razorpayOrderId,
			];
			file_put_contents('./payment_log/razorpay/rz_payment_request_'.$orders_info['order_id'].'.txt', "Order Data:".json_encode($orderData)."<br>Request Dat:".json_encode($data));
			echo json_encode($data);
	}
	public function process_razorpay_payment(){
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
			//print_r($_POST); die();
			// echo $_SESSION['productIds'];
			// die;
			$this->Public_model->changePaymentStatus($_SESSION['order_id'],strtolower('completed'),'0');
			$orders_info = $this->Public_model->getOrderDetails($_SESSION['order_id']);
			$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
			$userAddress = $this->Public_model->getUserAddressFrOrder($orders_info['orderID']);
			$lastID = $this->Public_model->insertRazorpay_transaction_data($_SESSION['order_id'],$_POST,$_SESSION['razorpay_order_id']);
			// echo $orders_info['user_id'];
			// exit;
			$this->Public_model->updateTeransactionPaymentID($_SESSION['order_id'],$_SESSION['razorpay_order_id']);

			$productIds = explode(",", $_SESSION['productIds']);
			foreach ($productIds as $productID) {
                $this->Public_model->removeFromCartTable($productID,$_SESSION['logged_user']);
            }
            $this->sendWhatsAppSMS($_SESSION['order_id'],'order_placed');  
			/* Start reward */
			// $totalTransactionBalance = $this->Public_model->totalTransactionBalance($orders_info['user_id']);
			$userPointSum = $this->Public_model->getUserPointSum($orders_info['user_id']);
			$totalSuccTransaction = $this->Public_model->totalSuccTransaction($orders_info['user_id']);
            $tot_trans_amount = ($userPointSum['total_purchased_value']+$orders_info['total_order_price']);

            // foreach ($totalSuccTransaction as $transaction) {
            //                 if($transaction['payment_status'] == 'completed'){
            //                      $tot_trans_amount += $transaction['total_order_price'];
            //                 }
            // } 

                            $tier = $this->Public_model->getTier($tot_trans_amount);
                            //print_r($tier); die();

                            //$pointBalance = (($orders_info['total_order_price'] * $tier['pointPercentage']) / 100);
                            $pointBalance = ($orders_info['total_order_price']);
                            $currentPointBalance = $userPointSum['balancePont']+$userPointSum['bonusPoint']+$pointBalance-$orders_info['paid_by_point'];


                            // $customerPoint = $this->Public_model->getCustomerPoint($orders_info['user_id']);

                            // if($customerPoint){
                            //     $currentPointBalance = ($customerPoint['currentPointBalance'] + $pointBalance);
                            // }
                            // else{
                            //     $currentPointBalance = $pointBalance;
                            // }
                            

                            $point_exp = date("Y-m-d",strtotime ( '+1 year' , strtotime ( $orders_info['updated_date'] ) )) ;
                            
                            $customerPoint = $this->Public_model->setCustomerPoint($orders_info, $userInfo,$pointBalance,$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);

                            $this->sendWhatsAppSMSPointsEarned($userInfo['phone'],$pointBalance,'points_earned', $point_exp);
                             

                            // $totalCurrentBalance = $this->Public_model->totalCurrentBalance($orders_info['user_id']);
                            
                            // $totalPointBalance = $this->Public_model->totalPointBalance($orders_info['user_id']);
                            // $point = 0;
                            // foreach ($totalPointBalance as $value) {
                            //     $point += $value['pointBalance'];
                            // }
                            //print_r($point); exit;

                            if($orders_info['paid_by_point'] != 0){
                            	$this->Public_model->setCustomerPointRedeem($orders_info, $userInfo,$orders_info['paid_by_point'],$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);
                            	$this->sendWhatsAppSMSPhaseOne($userInfo['phone'],$userAddress['first_name'],'redeem_points_near_expiry');
                            }

                            if($userPointSum){
                            	$this->Public_model->updateUserPointRollUps($orders_info['user_id'], $tier['tierMasterID'], $userPointSum['totalEarnPoint']+$pointBalance,$currentPointBalance,$userPointSum['bonusPoint'],$tot_trans_amount,$userPointSum['redeem_point']+$orders_info['paid_by_point']);


                         
                            }
                            $this->Public_model->updateOrderProductStatus($orders_info['id']);
                             /* insert_order_tracking */
                            $orders_product_info = $this->Public_model->getOrderProductDetails($orders_info['orderID']);
							foreach ($orders_product_info as $product_info) {
								$arr_products = unserialize($product_info['order_products']);
								$orderID = $_SESSION['order_id'];
								$order_product_id = $product_info['order_product_id'];
								$skuCode = $arr_products['product_info']['sku'];
								$status = $product_info['status'];
								$remarks = '';
								$insertID = $this->Public_model->insert_order_tracking($orderID,$order_product_id,$skuCode,$status,$remarks);
							}
                            /* End insert_order_tracking stop */
                            /* End reward */

                            /* End insert_order_tracking stop */
                            if($_SESSION['birthday_amount'] != ''){
                                $this->Public_model->updateDiscountCode($_SESSION['logged_mobile']);
                            }
                            if($_SESSION['giftCode'] != ''){
                                $this->Public_model->updateGiftDiscountCode($_SESSION['giftCode'],$_SESSION['order_id']);
                            }
                            unset($_SESSION['giftCode']);

                            
                if($orders_info['isReferral'] != ''){            
               $getReferral = $this->Public_model->getReferral($orders_info['user_id']);
                    if($getReferral['other_referral'] == $orders_info['isReferral']){
                            
                        $isReferralExist = $this->Public_model->checkIsReferralInOrder($orders_info['user_id'],$orders_info['isReferral']);

                              $tot_bonus_point = 0;
                            if($isReferralExist == false){
                              	$referralOwner = $this->Public_model->checkIsReferralOwner($orders_info['isReferral']);

                                $pointBalances = 500;
                                $owner_referralCode = $this->Public_model->ownerReferralCode($orders_info['isReferral']);

                                $ownerBounsPoint = $this->Public_model->ownerBonusPoint($referralOwner['id']);

                                $tot_bonus_point = $ownerBounsPoint['bonusPoint'] + 500;

                                $this->Public_model->updateOwnerBonusPoint($referralOwner['id'], $tot_bonus_point);
                                
                                // $customerPoints = $this->Public_model->getCustomerPoint($orders_info['user_id']);
                                $customerPoints = $this->Public_model->getCustomerPoint($referralOwner['id']);
                                if($customerPoints){
                                    $currentPointBalance = ($customerPoints['currentPointBalance'] + $pointBalances);
                                }
                                else{
                                    $currentPointBalance = $pointBalances;
                                }
                                 $customerPoint = $this->Public_model->setCustomerPointForReffaralReward($referralOwner['id'],$orders_info, $userInfo,$pointBalances,$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);
                            
                              }
                          }
                      }

            $massageID  = 160329;
            $this->sendSMS($massageID,$userAddress['phone']);
            $massageID  = 160330;
            $this->sendSMS($massageID,$userInfo['phone'],$pointBalance,$point_exp);   
			$this->generatePDF_EmailNotification($_SESSION['order_id']);
			$this->sendEmailNotifications($_SESSION['order_id']);
			$productVariant = $_SESSION['productVariant'];
			$this->session->set_flashdata('success_order', true);
			if($productVariant == ''){
				$this->shoppingcart->clearShoppingCart();
			
			}
			else{
				$this->removeFromCart($productVariant);
			}
			unset($_SESSION['order_id']);
			unset($_SESSION['productVariant']);
			unset($_SESSION['giftCode']);
			redirect(LANG_URL . '/checkout/successcash');
		}
		else
		{
			$this->Public_model->changePaymentStatus($_SESSION['order_id'],'failed','1');
			$_SESSION['success_order'] = 'false';
			unset($_SESSION['order_id']);			
			redirect(LANG_URL . '/shopping-cart');
			
		}
	}
	 public function removeFromCart($productVariant)
    {
        echo $productVariant;
        $count = count(array_keys($_SESSION['shopping_cart'], $productVariant));
        $i = 1;
        do {
            if (($key = array_search($productVariant, $_SESSION['shopping_cart'])) !== false) {
                unset($_SESSION['shopping_cart'][$key]);
            }
            $i++;
        } while ($i <= $count);
        @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->cookieExpTime);
    }
    private function setVendorOrders()
    {
        $this->Public_model->setVendorOrder($_POST,$this->orderId);
    }

    /*
     * Send notifications to users that have nofify=1 in /admin/adminusers
     */

    private function sendNotifications()
    {
        $users = $this->Public_model->getNotifyUsers();
        $myDomain = $this->config->item('base_url');
        if (!empty($users)) {
            foreach ($users as $user) {
                $this->sendmail->sendTo($user, 'Admin', 'New order in ' . $myDomain, 'Hello, you have new order. Can check it in /admin/orders');
            }
        }
    }
	private function generatePDF_EmailNotification($orderId)
            {
            //$orders_info = $this->Public_model->getOrderDetails($orderId);
            $orderdata = $this->Public_model->findOrderID($orderId);
            $orders_info = $this->Public_model->getUserOrderDetailsTwo($orderdata['id']);
            $orders_client_data = $this->Public_model->getOrderClientData($orderdata['id']);
            $userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
            // $sale_price = number_format($orders_info[0]['total_order_price_two'] - $orders_info[0]['discount_amount'] - $orders_info[0]['paid_amount'], 2);
            //$percentageArray = array();
            $cgst = '';
            $sgst = '';
            $igst = '';
            //$show_percentage = '';
            $percentage = 0;
            if($orders_client_data['thana'] == 'West Bengal'){
                $cgst = '9%';
                $sgst = '9%';
            }
            if($orders_client_data['thana'] != 'West Bengal'){
                $igst = '18%';
            }
            $sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
                        $footerContactPhone = htmlentities($this->Home_admin_model->getValueStore('footerContactPhone'));
                        $footerContactEmail = htmlentities($this->Home_admin_model->getValueStore('footerContactEmail'));
            
                        $this->load->library('m_pdf');
                            $headerhtml = '<table style="text-align:center;width:100%;border-top:1px solid #ddd;" cellspacing="0" cellpadding="1"><tr><td style="width:100%;"><b><img width="150px" src="data:image/jpg;base64,'.base64_encode(file_get_contents(base_url('attachments/site_logo/' . $sitelogo))).'" alt="neolayr"></b></td></tr><tr><td><i>PHONE- '.$footerContactPhone.'; E-mail: '.$footerContactEmail.'</i></td></tr><tr><td style="width:100%; margin-left:10px;border-top:1px solid #ddd; text-align:center;border-bottom:1px solid #ddd;">TAX INVOICE</td></tr></table>';
                            
                            
                            $footerhtml = '<table style="text-align:center;width:100%" cellspacing="0" cellpadding="1"><tr><td style="width:100%;">Thank you for shopping. We hope you will come back soon.</td></tr></table>';
                            $m_pdf = new mPDF('utf-8', 'A4','10', '', '', 0, 0, 10, 10, 0, 0); 
                            $m_pdf->setAutoTopMargin = 'stretch';
                            $m_pdf->allow_charset_conversion = true;
                            $m_pdf->setAutoBottomMargin = 'stretch';
                            $m_pdf->autoPageBreak = true;
                            $m_pdf->SetHTMLHeader($headerhtml);
                            $m_pdf->SetHTMLFooter($footerhtml);
                            $discount = "";
                if($orders_info[0]['discountTypes'] == 7){
                    $subTotal_html = number_format($orders_info[0]['total_order_price_two'] + $orders_info[0]['discount_amount'],2);

                    $subTotal_pdf = number_format($orders_info[0]['total_order_price_two'] + $orders_info[0]['discount_amount'],2);

                    $sale_price = number_format($orders_info[0]['total_order_price_two'] - $orders_info[0]['paid_amount'] - $orders_info[0]['gift_amount'], 2);
                    }
                else{
                    $subTotal_html = number_format($orders_info[0]['total_order_price_two'],2);

                    $subTotal_pdf = number_format($orders_info[0]['total_order_price_two'],2);

                    $sale_price = number_format($orders_info[0]['total_order_price_two'] - $orders_info[0]['discount_amount'] - $orders_info[0]['paid_amount'] - $orders_info[0]['gift_amount'], 2);
                }
                if($orders_info[0]['discount_code'] != ''){
                $discount_code_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">Discount Amount'.$orders_info[0]['discount_code'].': </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">   '.($orders_info[0]['coupon_discount_type']).'</b>
                                    </td>
                                </tr>';
                    $discount_code_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">COUPON DISCOUNT('.$orders_info[0]['discount_code'].'):</td><td style="border-top:1px solid #ddd;">     '.($orders_info[0]['coupon_discount_type']).'</td></tr>';
                    }
            if($orders_info[0]['discount_amount']>0){
                $discount_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">Discount Amount: </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">INR'.number_format($orders_info[0]['discount_amount'],2).'</b>
                                    </td>
                                </tr>';
                    $discount_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">DISCOUNT AMOUNT:</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['discount_amount'],2).'</td></tr>';
                    }
                    if($orders_info[0]['gift_amount']>0){
                    $gift_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">Gift Coupon Discount : </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">INR'.number_format($orders_info[0]['gift_amount'],2).'</b>
                                    </td>
                                </tr>';
                    $gift_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">GIFT COUPON DISCOUNT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['gift_amount'],2).'</td></tr>';
                    } 
                    if($orders_info[0]['paid_amount']>0){
                    $paid_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">PAID BY POINT : </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">INR'.number_format($orders_info[0]['paid_amount'],2).'</b>
                                    </td>
                                </tr>';
             $paid_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">PAID BY POINT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['paid_amount'],2).'</td></tr>';
             } 
            
            if($orders_info[0]['referral_amount']>0){
                    $referral_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">Referral Discount : </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">INR'.number_format($orders_info[0]['referral_amount'],2).'</b>
                                    </td>
                                </tr>';
                    $referral_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">REFERRAL DISCOUNT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['referral_amount'],2).'</td></tr>';
                    }
            $html_content = "<table width='100%' style='padding:0 20px;'>
                              <tr>
                                <td width='50%'>
                                        <h4>SENDER</h4><br>
                                        Palsonsderma<br>
                                        Palsons Derma Pvt. Ltd.<br>
                                        (CWH),Village: Alampur ,New<br>
                                        Kolorah ,PS: Sankrail<br>
                                        Howrah - 711302<br>
                                        West Bengal (19) ,India<br>
                                        Ph No: 8100105450<br>
                                        GST : 19AAECP5629D1ZD
                                </td>

                            <td width='50%' style='text-align: right;'>
                                    <h4>SUMMARY</h4><br>
                                     Order No. #(".$orders_info[0]['order_id'].")
                                     <br>Order Date : ".date('F d,Y', $orders_info[0]['date'])."
                                     <br>Payment Method : ".$orders_info[0]['payment_type']."
                                </td>
                             </tr>
                             <tr>
                             <td width='50%'>
                                <h4>DELIVERY ADDRESS</h4><br>
                                    ".$orders_info[0]['first_name']." ".$orders_info[0]['last_name'] ."
                                    <br>".$orders_info[0]['address'] ." ".$orders_info[0]['city']."
                                    <br>State : ".$orders_info[0]['thana'] ."
                                    <br>Pincode : ".$orders_info[0]['post_code'] ."
                                    <br>Contact No. ".$orders_info[0]['phone'] ."
                                    <br>".$orders_info[0]['notes'] ."
                             </td>
                             <td width='50%' style='text-align: right;'>
                                <h4>BILLING ADDRESS</h4><br>
                                    ".$orders_info[0]['first_name']." ".$orders_info[0]['last_name'] ."
                                    <br>".$orders_info[0]['address'] ." ".$orders_info[0]['city']."
                                    <br>State : ".$orders_info[0]['thana'] ."
                                    <br>Pincode : ".$orders_info[0]['post_code'] ."
                                    <br>Contact No. ".$orders_info[0]['phone'] ."
                                    <br>".$orders_info[0]['notes'] ."
                             </td></tr>
                             </table>";
                            
                            $total = 0;
                            $html_content .= '<table width="100%" style="border:1px solid #ddd; margin-top: 10px; padding:0 10px"><tr><td style="border-bottom:1px solid #ddd;" >SL.</td><td style="border-bottom:1px solid #ddd;" width="25px">CODE</td><td style="border-bottom:1px solid #ddd;" width="170px">PRODUCT TITLE</td><td style="border-bottom:1px solid #ddd;" >QUANTITY</td><td style="border-bottom:1px solid #ddd;" >MRP(INR)</td><td style="border-bottom:1px solid #ddd;" >RATE(INR)</td><td style="border-bottom:1px solid #ddd;" >CGST(9%)</td><td style="border-bottom:1px solid #ddd;" >SGST(9%)</td><td style="border-bottom:1px solid #ddd;" >IGST(18%)</td><td style="border-bottom:1px solid #ddd;" >AMOUNT(INR)</td></tr>';
                            $counter = 1;
                            $invoice_product = "";
                            //$percentage = ''; 
                            foreach ($orders_info as $product) { 

                            $rate =  (($product['unit_price']+ $product['reward_amount'] + $product['coupon'] + $product['gift_discount'] - $product['shipping_cost']));
                            $final_rate = (($rate * 100)/118);

                            //$percentage = (($final_rate * 18)/100);
                            
                            if($product['thana'] == 'West Bengal'){
                                $c_percentage = (($final_rate * 18)/100);
                            }
                            else{
                                $c_percentage = '';
                            }

                            if($product['thana'] != 'West Bengal'){
                                $i_percentage = (($final_rate * 18)/100);
                            }
                            else{
                                $i_percentage = '0';
                            }

                            //array_push($percentageArray, $percentage);

                            $arr_products = unserialize($product['order_products']); 
                                $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $arr_products['product_info']['id'], true);
                                $total =number_format($product['unit_price']+ $product['reward_amount'],2);
                                $html_content .= '<tr><td>'.$counter.'.</td><td>SKU:'.$arr_products['product_info']['sku'].'<br>HSN: '.$arr_products['product_info']['hsn_code'].'</td><td>'.$productInfo['title'].'</td><td style=text-align: center;>'.$arr_products['product_quantity'].'</td><td>'.number_format(($product['unit_price']+ $product['reward_amount'] - $product['shipping_cost']+ $product['coupon'] + $product['gift_discount'] * $arr_products['product_quantity']),2).'</td><td>'.number_format($final_rate,2).'</td><td style=text-align: center;>'.number_format(($c_percentage/2), 2).'</td><td style=text-align: center;>'.number_format(($c_percentage/2), 2).'</td><td style=text-align: center;>'.number_format($i_percentage, 2).'</td><td>'.number_format(($product['unit_price']+ $product['reward_amount'] - $product['shipping_cost']+ $product['coupon'] + $product['gift_discount'] * $arr_products['product_quantity']),2).'</td></tr>';
                                $counter++;
                                
                                $invoice_product .= '<tr>
                                <td>
                                    <img src="'.base_url('attachments/shop_images/' . $arr_products['product_info']['image']).'" alt="" width="80">
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">'.$arr_products['product_info']['hsn_code'].'</h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">'.$productInfo['title'].'</h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top: 10px;">QTY : <span>'.$arr_products['product_quantity'].'</span></h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top:15px"><b>INR'.number_format($product['unit_price']+ $product['reward_amount'],2).'</b></h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">'.$arr_products['product_quantity'].'</h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">'.$arr_products['product_quantity'].'</h5>
                                </td>
                            </tr>';
                                                                
                            }
                            $html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">SUB TOTAL :</td><td style="border-top:1px solid #ddd;"> INR'.$subTotal_pdf.'</td></tr>';

                            $html_content .= $discount_code_pdf.$discount_pdf.$paid_pdf.$gift_pdf.$referral_pdf;

                            $html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">SALE PRICE :</td><td style="border-top:1px solid #ddd;"> INR'.$sale_price.'</td></tr>';

                            $html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">SHIPPING :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['order_shipping_cost'],2).'</td></tr>';
                            
                            /*$html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">PAID BY POINT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['paid_amount'],2).'</td></tr>';*/

                            $html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">TOTAL AMOUNT :<br></td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['total_order_price'],2).'</td></tr>';
                            $html_content .= '</table>';
                            // print_r($html_content);
                            // exit;
                            
                            $m_pdf->WriteHTML($html_content);
                            $pdfFilePath = 'Order_Invoice_'.$orderId.'.pdf';
                            $m_pdf->Output('./invoice/'.$pdfFilePath, "F"); 
                            
                             
    }
    private function setActivationLink()
    {
        if ($this->config->item('send_confirm_link') === true) {
            $link = md5($this->orderId . time());
            $result = $this->Public_model->setActivationLink($link, $this->orderId);
            if ($result == true) {
                $url = parse_url(base_url());
                $msg = lang('please_confirm') . base_url('confirm/' . $link);
                $this->sendmail->sendTo($_POST['email'], $_POST['first_name'] . ' ' . $_POST['last_name'], lang('confirm_order_subj') . $url['host'], $msg);
            }
        }
    }

    private function goToDestination()
    {
        if ($_POST['payment_type'] == 'cashOnDelivery' || $_POST['payment_type'] == 'Bank' || $_POST['payment_type'] == 'Razorpay') {
            $this->shoppingcart->clearShoppingCart();
            $this->session->set_flashdata('success_order', true);
            redirect(LANG_URL . '/checkout/successcash');
        }
        if ($_POST['payment_type'] == 'Freecharge') {
            $_SESSION['order_id'] = $this->orderId;
            $_SESSION['final_amount'] = $_POST['final_amount'] . $_POST['amount_currency'];
            redirect(LANG_URL . '/checkout/freecharge_payment');
        }
		// if ($_POST['payment_type'] == 'Razorpay') {
        //     $_SESSION['order_id'] = $this->orderId;
        //     $_SESSION['final_amount'] = $_POST['final_amount'] . $_POST['amount_currency'];
        //     redirect(LANG_URL . '/checkout/razorpay_payment');
        // }
        if ($_POST['payment_type'] == 'cashOnDelivery') {
            redirect(LANG_URL . '/checkout/successcash');
        }
        if ($_POST['payment_type'] == 'PayPal') {
            @set_cookie('paypal', $this->orderId, 2678400);
            $_SESSION['discountAmount'] = $_POST['discountAmount'];
            redirect(LANG_URL . '/checkout/paypalpayment');
        }
    }

    private function userInfoValidate($post)
    {
        $errors = array();
        if (mb_strlen(trim($post['first_name'])) == 0) {
            $errors[] = 'You have not entered first name';
        }
        if (mb_strlen(trim($post['last_name'])) == 0) {
            $errors[] = 'You have not entered last name';
        }
		if (mb_strlen(trim($post['post_code'])) == 0) {
            $errors[] = lang('invalid_post_code');
        }
        $post['phone'] = preg_replace("/[^0-9]/", '', $post['phone']);
        if (mb_strlen(trim($post['phone'])) < 10 || mb_strlen(trim($post['phone'])) > 11) {
            $errors[] = lang('invalid_phone');
        }
        if (mb_strlen(trim($post['address'])) == 0) {
            $errors[] = lang('address_empty');
        }
        if (mb_strlen(trim($post['city'])) == 0) {
            $errors[] = lang('invalid_city');
        }
        return $errors;
    }

    public function orderError()
    {
        if ($this->session->flashdata('order_error')) {
            $data = array();
            $head = array();
            $arrSeo = $this->Public_model->getSeo('checkout');
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
            $head['keywords'] = str_replace(" ", ",", $head['title']);
            $this->render('checkout_parts/order_error', $head, $data);
        } else {
            redirect(LANG_URL . '/home');
        }
    }

    public function paypalPayment()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('checkout');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $data['paypal_sandbox'] = $this->Home_admin_model->getValueStore('paypal_sandbox');
        $data['paypal_email'] = $this->Home_admin_model->getValueStore('paypal_email');
        $this->render('checkout_parts/paypal_payment', $head, $data);
    }

    public function successPaymentCashOnD()
    {
    	//print_r("ok"); exit
        if ($this->session->flashdata('success_order')) {
        	//print_r("ok"); die();
            $data = array();
            $head = array();
            $arrSeo = $this->Public_model->getSeo('checkout');
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
			$data['orders_info'] = $this->Public_model->getOrderDetails($this->session->userdata('orderId'));
			$head['keywords'] = str_replace(" ", ",", $head['title']);
            $this->render('checkout_parts/payment_success_cash', $head, $data);
        } else {
            redirect(LANG_URL . '/home');
        }
    }

    public function successPaymentBank()
    {
        if ($this->session->flashdata('success_order')) {
            $data = array();
            $head = array();
            $arrSeo = $this->Public_model->getSeo('checkout');
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
            $head['keywords'] = str_replace(" ", ",", $head['title']);
            $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
            $this->render('checkout_parts/payment_success_bank', $head, $data);
        } else {
            redirect(LANG_URL . '/checkout');
        }
    }

    public function paypal_cancel()
    {
        if (get_cookie('paypal') == null) {
            redirect(base_url());
        }
        @delete_cookie('paypal');
        $orderId = get_cookie('paypal');
        $this->Public_model->changePaypalOrderStatus($orderId, 'canceled');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_cancel', $head, $data);
    }

    public function paypal_success()
    {
        if (get_cookie('paypal') == null) {
            redirect(base_url());
        }
        @delete_cookie('paypal');
        $this->shoppingcart->clearShoppingCart();
        $orderId = get_cookie('paypal');
        $this->Public_model->changePaypalOrderStatus($orderId, 'payed');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_success', $head, $data);
    }
	 public function add_paperfly_order()
    {
		$url = "http://173.82.130.162/OrderPlacement";
		$post_data = '{
					"merOrderRef":"911897",
					"pickMerchantName":"",
					"pickMerchantAddress":"",
					"pickMerchantThana":"",
					"pickMerchantDistrict":"",
					"pickupMerchantPhone":"",
					"productSizeWeight":"standard",
					"productBrief":"USB Fan",
					"packagePrice":"3400",
					"deliveryOption":"regular",
					"custname":"Md. Abdul Karim",
					"custaddress":"Road 27, Dhanmondi",
					"customerThana":"Agargaon",
					"customerDistrict":"Dhaka",
					"custPhone":"9876543210"
					}';
		$headers = ['username' => 'm10023', 'password' => 'abcd1234', 'paperflykey' => 'Paperfly_~La?Rj73FcLm'];
		$data = $this->cUrlGetData($url, $post_data, $headers);
		print_r($data);
		
	}
	function cUrlGetData($url, $post_fields = null, $headers = null) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		if ($post_fields && !empty($post_fields)) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		}
		if ($headers && !empty($headers)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $data;
	}
	function mail_test(){
		$orders_info = $this->Public_model->getOrderDetails('202004141048351');
					$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
					
					$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
				   
						$arr_products = unserialize($orders_info['products']);
						$total = 0;
						$counter = 1;
						$invoice_product = "";
						foreach ($arr_products as $product) {	
							$productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
							$total +=$product['product_info']['price']*$product['product_quantity'];
							$counter++;
							
							$invoice_product .= '<tr>
																<td>
																	<img src="'.base_url('attachments/shop_images/' . $product['product_info']['image']).'" alt="" width="80">
																</td>
																<td valign="top" style="padding-left: 15px;">
																	<h5 style="margin-top: 15px;"><a target="_blank" href="'.base_url($product['product_info']['url']).'">'.character_limiter($productInfo['title'],20).'</a></h5>
																</td>
																<td valign="top" style="padding-left: 15px;">
																	<h5 style="font-size: 14px; color:#444;margin-top: 10px;">QTY : <span>'.$product['product_quantity'].'</span></h5>
																</td>
																<td valign="top" style="padding-left: 15px;">
																	<h5 style="font-size: 14px; color:#444;margin-top:15px"><b>'.number_format($product['product_info']['price']*$product['product_quantity'],2).'INR</b></h5>
																</td>
															</tr>';
															
						}
						//Send Email
						$invoice_mail = '<table align="center" border="0" cellpadding="0" cellspacing="0" style="padding: 0 30px;background-color: #fff; -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);width: 650px;border: 1px solid #ddd">
											<tbody>
												<tr>
													<td>
														<table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left;" width="100%">
															<tbody><tr>
																<td style="text-align: center;">
																	<img width="150px" src="'.base_url('attachments/site_logo/' . $sitelogo).'" alt="" style=";margin-bottom: 30px;">
																</td>
															</tr>
															<tr>
																<td>
																	<p style="font-size: 14px;"><b>Hi '.$userInfo['name'].',</b></p>
																	<p style="font-size: 14px;">Order Is Successfully Processsed And Your Order Is On The
																		Way,</p>
																	<p style="font-size: 14px;">Transaction ID : '.$orders_info['order_id'].',</p>
																</td>
															</tr>
														</tbody></table>
									
														<table cellpadding="0" cellspacing="0" border="0" align="left" style="width: 100%;margin-top: 10px;    margin-bottom: 10px;">
															<tbody>
																<tr>
																	<td style="background-color: #fafafa;border: 1px solid #ddd;padding: 15px;letter-spacing: 0.3px;width: 100%;">
																		<h5 style="font-size: 16px; font-weight: 600;color: #000; line-height: 16px; padding-bottom: 13px; border-bottom: 1px solid #e6e8eb; letter-spacing: -0.65px; margin-top:0; margin-bottom: 13px;">
																			Your Delivery Address</h5>
																		<p style="text-align: left;font-weight: normal; font-size: 14px; color: #000000;line-height: 21px;    margin-top: 0;">
																		'.$orders_info['first_name']." ".$orders_info['last_name'].','.$orders_info['address'].','.$orders_info['city'].', Pincode - '.$orders_info['post_code'].',Contact No - '.$orders_info['phone'].'
																		</p>
																	</td>
																</tr>
															</tbody>
														</table>
														<table class="order-detail" border="0" cellpadding="0" cellspacing="0" align="left" style="width: 100%;    margin-bottom: 50px;">
															<tbody><tr align="left">
																<th>PRODUCT</th>
																<th style="padding-left: 15px;">DESCRIPTION</th>
																<th>QUANTITY</th>
																<th>PRICE </th>
															</tr>
															'.$invoice_product.'<tr align="left">
																<th>PRODUCT</th>
																<th style="padding-left: 15px;">DESCRIPTION</th>
																<th>QUANTITY</th>
																<th>PRICE </th>
															</tr><tr class="pad-left-right-space ">
																<td class="m-t-5" colspan="2" align="left">
																	<p style="font-size: 14px;">Subtotal : </p>
																</td>
																<td class="m-t-5" colspan="2" align="right">
																	<b style="">'.number_format($total,2).'INR</b>
																</td>
															</tr>
															<tr class="pad-left-right-space">
																<td colspan="2" align="left">
																	<p style="font-size: 14px;">SHIPPING Charge :</p>
																</td>
																<td colspan="2" align="right">
																	<b> '.number_format($orders_info['shipping_cost'],2).'INR</b>
																</td>
															</tr>
															<tr class="pad-left-right-space ">
																<td class="m-b-5" colspan="2" align="left">
																	<p style="font-size: 14px;">Total :</p>
																</td>
																<td class="m-b-5" colspan="2" align="right">
																	<b>'.number_format($orders_info['total_order_price'],2).'INR</b>
																</td>
															</tr>
														</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>';
										
						/*$this->load->library('email');
						$this->email->set_mailtype("html");
						$this->email->from('info@myindiantoy.com', 'My Indian Toy');
						$this->email->to($userInfo['email'], $userInfo['email']);
						$this->email->subject('Reset password instructions');
						
						
						$this->email->message($invoice_mail);
						
						$this->email->set_newline("\r\n");
						$this->email->send();*/	
						
						$api = '7a27fb51afcc9cc732b47c893b929148-713d4f73-a5fac691';
						$from = 'info@myindiantoy.com';
						$to = 'sanjaykrdey@gmail.com';
						$subject = 'Thank you for your order';
						
						$url = 'https://api:'.$api.'@api.mailgun.net/v3/mail.notionalsystems.in/messages';
						$postfields = 'from='.$from.'&to='.$to.'&subject='.$subject.'&html='.$invoice_mail;
						$data = $this->cUrlGetData($url,$postfields);
						var_dump($data);die;
	}
	public function generate_checksum(){
		$data = array('amount' => '1.00',
					  'checksum' => '865fb6dad775e36ac9afa37affd5194d1f8b139b124261f6801e1c3b07cc9f86',
					  'merchantLogo' =>'',
					  'merchantName' =>'',
					  'merchantTxnId' => '202006031147261',
					  'metadata' => '',
					  'status' => 'COMPLETED',
					  'txnId' => 'EZpfh7yEVcWYt4_202006031147261_1' );
	    /*$data = array('amount' => '1.00',
					  'checksum' => 'd19ca19ee1a4414a475faf7a14ee6444ab3f476ff16b53b1657c0ee6bf4ecc17',
					  'merchantTxnId' => '202006031156061',
					  'status' => 'COMPLETED',
					  'txnId' => 'EZpfh7yEVcWYt4_202006031156061_1');*/
		$string = "{";
		$counter = 1;
		foreach($data as $key=>$value){
						if($key!='checksum'){
							if($value!=""){
								$string.='"'.$key.'":"'.$value.'"';
								if($counter<(sizeof($data)))
								$string.=',';
							}
							
						}
						$counter++;
		}
		$string.="}".freecharge_key;
		$generated_hash = hash('sha256', $string);
		echo $generated_hash;
		echo "<br>".$data['checksum'];
	}
	
	public function orderByShiprocket($orderID)
    {
				
				$orders_info = $this->Public_model->getUserOrderDetailsForOrder($orderId);
				$arr_products = unserialize($orders_info['order_products']);
				$total_amount = 0;
				$product_weight = 0;
				$order_item = array();
                foreach ($arr_products as $product) {
					$productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
					 
					array_push($order_item,array(
								"name"=>$productInfo['title'],
								"sku"=>'myindiantoy'.$product['product_info']['id'],
								"units"=>$product['product_quantity'],
								"selling_price"=>$product['product_info']['price'],
								"tax"=>"",
								"hsn"=>""
								));
                                                        $total_amount += ($product['product_info']['price']*$product['product_quantity']);	
														
														if($product['product_info']['weight_unit'] == 'grams')
														$product_weight = $product_weight+(($product['product_info']['weight']/1000)*$product['product_quantity']);
														else
														$product_weight = $product_weight+($product['product_info']['weight']*$product['product_quantity']);
														 
														 
				 }
				$shiprocket_auth_key = $this->Home_admin_model->getValueStore('shiprocket_api_key');
				$headers = array(
						"Content-Type: application/json",
						"Authorization: Bearer ".$shiprocket_auth_key
				);
				//Get length and height
				$weight_details = $this->Orders_model->getWeightDetails($product_weight);
				
				
				
				
				$post = array(
					  "order_id"=>$orders_info['order_product_id'],
					  "order_date"=>$orders_info['order_update_date'],
					  "pickup_location"=> "",
					  "channel_id"=> "",
					  "comment"=> "",
					  "billing_customer_name"=> $orders_info['first_name']." ".$orders_info['last_name'],
					  "billing_last_name"=> $orders_info['last_name'],
					  "billing_address"=> trim(preg_replace('/\s\s+/', ' ', $orders_info['address'])),
					  "billing_address_2"=> "",
					  "billing_city"=> $orders_info['city'],
					  "billing_pincode"=> $orders_info['post_code'],
					  "billing_state"=> $orders_info['thana'],
					  "billing_country"=> $orders_info['country'],
					  "billing_email"=> $orders_info['email'],
					  "billing_phone"=> substr($orders_info['phone'], -10),
					  "shipping_is_billing"=> true,
					  "shipping_customer_name"=> "",
					  "shipping_last_name"=> "",
					  "shipping_address"=> "",
					  "shipping_address_2"=> "",
					  "shipping_city"=> "",
					  "shipping_pincode"=> "",
					  "shipping_country"=> "",
					  "shipping_state"=> "",
					  "shipping_email"=> "",
					  "shipping_phone"=> "",
					  "payment_method"=> "Prepaid",
					  "shipping_charges"=> 0,
					  "giftwrap_charges"=> 0,
					  "transaction_charges"=> 0,
					  "total_discount"=> 0,
					  "sub_total"=> $total_amount,
					  "order_items"=>$order_item,
					  "length"=> $weight_details['length'],
					  "breadth"=> $weight_details['breath'],
					  "height"=> $weight_details['height'],
					  "weight"=> $product_weight
				);
				// echo json_encode($post);
				// die();
				
				$create_order = json_decode($this->cUrlGetData(shiprocket_api_url.'orders/create/adhoc', json_encode($post), $headers));
				
				print_r($create_order);
				die();
				
				// if($create_order->status_code == '1'){
				// 	$result = $this->Orders_model->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
				// 	$this->session->set_flashdata('orderstatusError', "Order Status Updated");
				// }
				// else{
				// 	 $this->session->set_flashdata('orderstatusError', $create_order->message);
				// }
				
				//redirect('admin/orders');
		
	}
	  public function sendEmailNotifications($orderId){
        $orderdata = $this->Public_model->findOrderID($orderId);
        $orders_info = $this->Public_model->getUserOrderDetailsTwo($orderdata['id']);
        //$orders_info = $this->Public_model->getOrderDetails($orderId);
       $userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
                     
                     //echo $userInfo['email']; exit;
                    //print_r($orders_info); exit;
                    $sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
                   
                        
                        $total = 0;
                        $counter = 1;
                        $invoice_product = "";
                        foreach ($orders_info as $product) { 
                        $arr_products = unserialize($product['order_products']);  
                        //print_r($arr_products['product_info']);
                            $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $arr_products['product_info']['id'], true);
                            $total +=$product['product_info']['price']*$product['product_quantity'];
                            $counter++;
                            
                            $invoice_product .= '<table style="width:100%;padding:10px 20px;"><tr>
                            <td>
                                <img src="'.base_url('attachments/shop_images/' . $arr_products['product_info']['image']).'" alt="" width="80">
                            </td>
                            <td style="font-size:15px;color:#505050;font-weight:500; text-align:left;line-height:28px;">
                                <a target="_blank" href="'.base_url($product['product_info']['url']).'">'.character_limiter($productInfo['title'],20).'</a>
                            </td>
                            <td style="font-size:15px;color:#505050;font-weight:500; text-align:left;line-height:28px;">
                                QTY : '.$arr_products['product_quantity'].'
                            </td>
                            
                            <td style="color:#505050;font-size:15px;font-weight:600;text-align:right;">₹'.number_format($product['unit_price']+ $product['reward_amount'],2).'</td>
                        </tr>
                        </table>';
                                                            
                        }
                        
                        //Send Email
                        $invoice_mail = '<div style="max-width:570px;margin:0px auto;padding:30px 45px;">
                        <div style="text-align:center;margin-bottom:30px;">
                <img src="'.base_url('attachments/site_logo/' . $sitelogo).'" width="260" height="38" border="0" alt="">
            </div>
            <h1 style="text-align:center; font-weight:700;color:#505050;font-size:24px;margin-bottom:20px;">Order Confirmation</h1>
            <p style="font-size:15px;line-height:35px;color:#7b7b7b;font-weight:400; text-align:center;">Hi '.$orders_info[0]['first_name'].' '.$orders_info[0]['last_name'].',<br>Order is sucessfully processed and your order in on the way.</p>
            <h3 style="font-size:17px;color:#505050;font-weight:700; text-align:center;margin-bottom:50px;">Order ID : '.$orders_info[0]['order_id'].'</h3>
            <h4 style="font-size:15px;color:#7b7b7b;font-weight:700;text-transform:uppercase;">Item ordered</h4>
            <hr>
            '.$invoice_product.'
            <hr>
            <table style="width:100%;padding:10px 0px 0px;">
            <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Subtotal</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">₹'.number_format($orders_info[0]['total_order_price_two'],2).'</td>
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Discount</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">- ₹'.number_format($orders_info[0]['discount_amount'],2).'</td>
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Gift Voucher</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">- ₹'.number_format($orders_info[0]['gift_amount'],2).'</td>
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Shipping Cost</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">₹'.number_format($orders_info[0]['order_shipping_cost'],2).'</td>
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Paid By Point</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">₹'.number_format($orders_info[0]['paid_amount'],2).'</td>
                </tr>

            </table>
            <hr>
            <table style="width:100%;padding:0px 0px 0px;">
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Total</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">- ₹'.number_format($orders_info[0]['total_order_price'],2).'</td>
                </tr>
            </table>
            <table style="width:100%;padding:10px 0px 0px;">
                <tr>
                    <td>
                        <h3 style="font-size:18px;color:#7b7b7b;margin-bottom:20px;text-transform:uppercase;font-weight:500;">BIlling INFO</h3>
                        <p style="font-size:18px;color:#505050;font-weight:600; text-align:left;line-height:40px;">
                        '.$orders_info[0]['first_name']." ".$orders_info[0]['last_name'].'<br>
                        '.$orders_info[0]['address'].', <br>
                        '.$orders_info[0]['city'].', <br>
                        '.$orders_info[0]['post_code'].', <br>
                        '.$orders_info[0]['phone'].'
                        </p>
                    </td>
                    <td>
                        <h3 style="font-size:18px;color:#7b7b7b;margin-bottom:20px;text-transform:uppercase;font-weight:500;text-align:right;">Shipping INFO</h3>
                        <p style="font-size:18px;color:#505050;font-weight:600; text-align:right;line-height:40px;">
                        '.$orders_info[0]['first_name']." ".$orders_info[0]['last_name'].'<br>
                        '.$orders_info[0]['address'].', <br>
                        '.$orders_info[0]['city'].', <br>
                        '.$orders_info[0]['post_code'].', <br>
                        '.$orders_info[0]['phone'].'</p>
                    </td>
                </tr>
            </table>


                        </div>';
                        //print_r($invoice_mail); exit;
                $toName = $orders_info[0]['first_name'].' '.$orders_info[0]['last_name'];
                $toEmail = $orders_info[0]['email'];
                $fromName = 'NEOLAYR';
                $fromEmail = 'neolayrpro@palsonsderma.com';
                $subject = 'Thank you for your order';
                $htmlMessage = '<p>Hello '.$toName.',</p><p>This is my first transactional email sent from Sendinblue.</p>';

                $data = array(
                    "sender" => array(
                        "email" => $fromEmail,
                        "name" => $fromName         
                    ),
                    "to" => array(
                        array(
                            "email" => $toEmail,
                            "name" => $toName 
                            )
                    ), 
                    "subject" => $subject,
                    "htmlContent" => $invoice_mail
                ); 
                //echo json_encode($data);
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.sendinblue.com/v3/smtp/email',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_POSTFIELDS => json_encode($data),
                  CURLOPT_HTTPHEADER => array(
                'Api-Key: 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',
                'content-type: application/json'
              ),
            ));
                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                // if ($err) {
                //   echo "cURL Error #:" . $err;
                // } else {
                //   echo $response;
                // }
            }
		
	
}
