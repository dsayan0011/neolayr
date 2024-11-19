<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Orders extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('SendMail');
        $this->load->model(array('Orders_model', 'Home_admin_model', 'Vendor_model'));
    }

    public function index($page = 0)
    {
		$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Orders';
        $head['description'] = '!';
        $head['keywords'] = '';
		$perimission = $this->session->userdata('adminPermission');
		$display_order_perimission = explode(",",$perimission['display_order']);
		
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
		$start_date = null;
        if ($this->input->get('start_date') !== NULL) {
            $start_date = $this->input->get('start_date');
        }
		$end_date = null;
        if ($this->input->get('end_date') !== NULL) {
            $end_date = $this->input->get('end_date');
        }
		$order_number = null;
        if ($this->input->get('order_number') !== NULL) {
            $order_number = $this->input->get('order_number');
        }
		
        $rowscount = $this->Orders_model->ordersCountWithSorting($sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission);
		if($rowscount<$page)
		$page = 0;
		
        $data['orders'] = $this->Orders_model->ordersDetailsAdmin($this->num_rows, $page, $sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission);
        $data['links_pagination'] = pagination('admin/orders', $rowscount, $this->num_rows, 3);
        // echo "<pre>";
        // print_r( $data['orders']); exit;
        if (isset($_POST['freecharge_payment'])) {
            $this->Home_admin_model->setValueStore('freecharge_payment', $_POST['freecharge_payment']);
            if ($_POST['freecharge_payment'] == 1) {
                $msg = 'Freecharge payment gateway activated';
            } else {
                $msg = 'Freecharge payment gateway disabled';
            }
            $this->session->set_flashdata('freecharge_payment', $msg);
            $this->saveHistory($msg);
            redirect('admin/orders?settings');
        }
		if (isset($_POST['razorpay_payment'])) {
            $this->Home_admin_model->setValueStore('razorpay_payment', $_POST['razorpay_payment']);
            if ($_POST['razorpay_payment'] == 1) {
                $msg = 'Razorpay payment gateway activated';
            } else {
                $msg = 'Razorpay payment gateway disabled';
            }
            $this->session->set_flashdata('razorpay_payment', $msg);
            $this->saveHistory($msg);
            redirect('admin/orders?settings');
        }
		if (isset($_POST['dollar_value'])) {
            $this->Home_admin_model->setValueStore('dollar_value', $_POST['dollar_value']);
            $msg = 'Dollar value updated';
            $this->session->set_flashdata('dollar_value', $msg);
            $this->saveHistory($msg);
            redirect('admin/orders?settings');
        }
        if (isset($_POST['paypal_email'])) {
            $this->Home_admin_model->setValueStore('paypal_email', $_POST['paypal_email']);
            $this->session->set_flashdata('paypal_email', 'Public quantity visibility changed');
            $this->saveHistory('Change paypal business email to: ' . $_POST['paypal_email']);
            redirect('admin/orders?settings');
        }
        if (isset($_POST['cashondelivery_visibility'])) {
            $this->Home_admin_model->setValueStore('cashondelivery_visibility', $_POST['cashondelivery_visibility']);
            $this->session->set_flashdata('cashondelivery_visibility', 'Cash On Delivery Visibility Changed');
            $this->saveHistory('Change Cash On Delivery Visibility - ' . $_POST['cashondelivery_visibility']);
            redirect('admin/orders?settings');
        }
        if (isset($_POST['iban'])) {
            $this->Orders_model->setBankAccountSettings($_POST);
            $this->session->set_flashdata('bank_account', 'Bank account settings saved');
            $this->saveHistory('Bank account settings saved for : ' . $_POST['name']);
            redirect('admin/orders?settings');
        }
		if (isset($_POST['edit_order'])) {
			$pdfFilePath = 'Order_Invoice_'.$_POST['order_id'].time().'.pdf';
			$orders_info = $this->Public_model->getUserOrderDetails($_POST['order_id']);
			$orderId = $this->Public_model->updateOrderData($orders_info['orderID'],$_POST,$pdfFilePath);	
			$this->Public_model->updateOrderInvoice($_POST['order_id'],$pdfFilePath);	
			
			$orders_info = $this->Public_model->getUserOrderDetails($_POST['order_id']);
			$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
						 //load mPDF library
						$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
						$footerContactPhone = htmlentities($this->Home_admin_model->getValueStore('footerContactPhone'));
						$footerContactEmail = htmlentities($this->Home_admin_model->getValueStore('footerContactEmail'));
						$this->load->library('m_pdf');
						$headerhtml = '<table style="text-align:center;width:100%;border-top:1px solid #ddd;" cellspacing="0" cellpadding="1"><tr><td style="width:100%;"><b><img width="150px" src="'.base_url('attachments/site_logo/' . $sitelogo).'" alt="myindiantoy"></b></td></tr><tr><td><i>PHONE- '.$footerContactPhone.'; E-mail: '.$footerContactEmail.'</i></td></tr><tr><td style="width:100%; margin-left:10px;border-top:1px solid #ddd; text-align:center;border-bottom:1px solid #ddd;">TAX INVOICE</td></tr></table>';
						
						
						$footerhtml = '<table style="text-align:center;width:100%" cellspacing="0" cellpadding="1"><tr><td style="width:100%;">Thank you for shopping. We hope you will come back soon.</td></tr></table>';
						$m_pdf = new mPDF('utf-8', 'A4','10', '', '', 0, 0, 10, 10, 0, 0); 
						$m_pdf->setAutoTopMargin = 'stretch';
						$m_pdf->allow_charset_conversion = true;
						$m_pdf->setAutoBottomMargin = 'stretch';
						$m_pdf->autoPageBreak = true;
						$m_pdf->SetHTMLHeader($headerhtml);
						$m_pdf->SetHTMLFooter($footerhtml);
						
						$html_content = "<table width='100%' style='padding:0 20px;'>
										  <tr>
											<td width='50%'>
												<h4>SUMMARY</h4><br>
												 Order Ref #(".$orders_info['order_id'].")
												 <br>Order Date : ".date('F d,Y', $orders_info['date'])."
												  <br>Payment Method : ".$orders_info['payment_type']."
												  <br>GST : 27ABCCS4270Q1ZR
											</td>
										 <td width='50%'>
											<h4>DELIVERY ADDRESS</h4><br>
												".$orders_info['first_name']." ".$orders_info['last_name'] ."
												<br>".$orders_info['address'] ."
												<br>State : ".$orders_info['thana'] ."
												<br>".$orders_info['city'].". Pincode : ".$orders_info['post_code'] ."
												<br>Contact No. ".$orders_info['phone'] ."
												<br>".$orders_info['notes'] ."
										 </td></tr>
										 </table>";
						$arr_products = unserialize($orders_info['products']);
						$total = 0;
						$html_content .= '<table width="100%" style="border:1px solid #ddd; margin-top: 10px; padding:0 10px"><tr><td style="border-bottom:1px solid #ddd;">SL.</td><td style="border-bottom:1px solid #ddd;">TITLE</td><td style="border-bottom:1px solid #ddd;">QTY</td><td style="border-bottom:1px solid #ddd;">PRICE</td></tr>';
						$counter = 1;
						$invoice_product = "";
						foreach ($arr_products as $product) {	
							$productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
							$total +=$product['product_info']['price']*$product['product_quantity'];
							$html_content .= '<tr><td>'.$counter.'.</td><td>'.$productInfo['title'].'</td><td>'.$product['product_quantity'].'</td><td>'.number_format($product['product_info']['price']*$product['product_quantity'],2).'INR</td></tr>';
							$counter++;
						}
						$html_content .= '<tr><td colspan="3" style="border-top:1px solid #ddd;text-align: right">SUB TOTAL :</td><td style="border-top:1px solid #ddd;"> '.number_format($total,2).'INR</td></tr>';
						$html_content .= '<tr><td colspan="3" style="border-top:1px solid #ddd;text-align: right">SHIPPING :</td><td style="border-top:1px solid #ddd;"> '.number_format($orders_info['shipping_cost'],2).'INR</td></tr>';
						$html_content .= '<tr><td colspan="3" style="border-top:1px solid #ddd;text-align: right">TOTAL AMOUNT :<br>(GST included)</td><td style="border-top:1px solid #ddd;"> '.number_format($orders_info['total_order_price'],2).'INR</td></tr>';
						$html_content .= '</table>';
						
						$m_pdf->WriteHTML($html_content);
						
						$m_pdf->Output('./invoice/'.$pdfFilePath, "F");	
					
						
						redirect('admin/orders');
			
		}
		$data['district_list'] = $this->Public_model->getdistrictlist();
        $data['freecharge_payment'] = $this->Home_admin_model->getValueStore('freecharge_payment');
		$data['razorpay_payment'] = $this->Home_admin_model->getValueStore('razorpay_payment');
		$data['dollar_value'] = $this->Home_admin_model->getValueStore('dollar_value');
		
		
        $data['paypal_email'] = $this->Home_admin_model->getValueStore('paypal_email'); 
        $data['cashondelivery_visibility'] = $this->Home_admin_model->getValueStore('cashondelivery_visibility');
        $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
		$data['locations'] = $this->Public_model->getActivePickupLocation();
		//print_r($data['orders']); exit;
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/orders', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to orders page');
        }
    }

    public function changeOrdersOrderStatus()
    {
    	//print_r($_POST); exit;
        $this->login_check();
        // echo $_POST['the_id']."<br>";
        // echo $_POST['to_status'];
        // exit;
        $result = false;
        $sendedVirtualProducts = true;
        $virtualProducts = $this->Home_admin_model->getValueStore('virtualProducts');
        /*
         * If we want to use Virtual Products
         * Lets send email with download links to user email
         * In error logs will be saved if cant send email from PhpMailer
         */
        if ($virtualProducts == 1) {
            if ($_POST['to_status'] == 1) {
                $sendedVirtualProducts = $this->sendVirtualProducts();
            }
        }
		//Create Unicommerce Shipment
		if($_POST['to_status'] == 1){
				$token = $this->Public_model->getUnicommerceToken();
				$orders_info = $this->Orders_model->getOrderDetailsAdmin($_POST['the_id']);
				$lineItem_info = $this->Orders_model->getLineItemOrderDetailsAdmin($orders_info['id']);
				
				//print_r($lineItem_info); exit;
				$saleOrderItems = [];	
				

				foreach ($lineItem_info as $orders) {
					$arr_products = unserialize($orders['order_products']);
					$count = 0;
					$sales_order_code = array();
					for($i=0;$i<$arr_products['product_quantity'];$i++){
						//print_r($arr_products); exit;
						array_push($sales_order_code,$orders['order_product_id'].$count);
					 	$saleOrderItems[] = (object) [
					     "code" => $orders['order_product_id'].$count,
					     "itemSku" => $arr_products['product_info']['sku'],
					     "totalPrice" => ($orders['unit_price'] - $orders['shipping_cost'])/$arr_products['product_quantity'],
					     "sellingPrice" => ($orders['unit_price']  - $orders['shipping_cost'])/$arr_products['product_quantity'],
					     "discount" => ($orders['coupon'] + $orders['gift_discount'])/$arr_products['product_quantity'],
        				 "shippingCharges" => $orders['shipping_cost']/$arr_products['product_quantity'],
					     "packetNumber" => $arr_products['product_quantity'],
					     "shippingMethodCode" => "STD"
					   ];
					   $count++;
					   $sdata = implode("," , $sales_order_code);
					   $this->Orders_model->updateSalesOrderCode($orders_info['id'], $orders['order_product_id'],$sdata);
					}
					
				}
				//print_r($saleOrderItems); exit;
				
				if($orders_info['payment_type'] == 'cashOnDelivery'){
				$payment_mode = 'true';
				}
				else{
				$payment_mode = 'false';
				}
				$total_discount = ($orders_info['discount_amount']+$orders_info['gift_amount']);
				//echo $total_discount; exit;
				$saleData = '{
						  	"saleOrder": {
							    "code": "'.$orders_info['order_id'].'",
							    "displayOrderCode": "'.$orders_info['order_id'].'",
							    "channel": "CUSTOM",
							    "displayOrderDateTime": "'.date("Y-m-d", strtotime($orders_info['created_at'])).'",
							    "fulfillmentTat": "'.date("Y-m-d", strtotime($orders_info['created_at'])).'",
							    "notificationEmail": "'.$orders_info['email'].'",
	        					"notificationMobile": "'.$orders_info['phone'].'",
							    "customerGSTIN": "",
							    "customerName": "'.$orders_info['first_name']." ".$orders_info['last_name'].'",
							    "cashOnDelivery": '.$payment_mode.',
							    "addresses": [
							      {
							        "id": "'.$orders_info['user_id'].'",
							        "name": "'.$orders_info['first_name']." ".$orders_info['last_name'].'",
							        "addressLine1": "'.$orders_info['address'].'",
							        "addressLine2": "",
							        "city": "'.$orders_info['city'].'",
							        "state": "'.$orders_info['thana'].'",
							        "country": "India",
							        "pincode": "'.$orders_info['post_code'].'",
							        "phone": "'.$orders_info['phone'].'",
							        "email": "'.$orders_info['email'].'"
							      }
							    ],
							    "billingAddress": {
							      "referenceId": "'.$orders_info['user_id'].'"
							    },
							    "shippingAddress": {
							      "referenceId": "'.$orders_info['user_id'].'"
							    },
							     
							    "saleOrderItems": '.json_encode($saleOrderItems).',
							    "currencyCode": "INR",
						        
						        "totalGiftWrapCharges": "0",
						        "totalPrepaidAmount": 0,
						        "useVerifiedListings": false
							  }


								
							}';
						$curl = curl_init();

						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://palsonsderma.unicommerce.com/services/rest/v1/oms/saleOrder/create',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_SSL_VERIFYHOST => 0,
			  			  CURLOPT_SSL_VERIFYPEER => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS => $saleData,
						  CURLOPT_HTTPHEADER => array(
						    'Authorization: Bearer '.$token['access_token'],
						    'Content-Type: application/json'
						  ),
						));

						$this->Orders_model->updateOrderPushLog($_POST['the_id'], $saleData);

						$response = curl_exec($curl);
						$err = curl_error($ch);
						curl_close($curl);
						if ($err) {
						  //echo "cURL Error #:" . $err;
						} else {
						  //echo ($response);
						}
						$response = json_decode($response);
				
				if($response->successful){
					$this->Orders_model->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
					
					 $result = $this->Orders_model->changeBulkOrderStatusLineItem($_POST['the_id'], $_POST['to_status'], 'created');
					 $this->Orders_model->changemainOrderStatus($_POST['the_id'], $_POST['to_status']);
					 foreach ($lineItem_info as $orders) {
			 		 $this->Orders_model->changeOrderStatus($orders['order_product_id'], $_POST['to_status']);
			 		}

					
					 //$this->Orders_model->updateOrderTracking($_POST['the_id'], $data->packages[0]->waybill);
				}else{
					 $this->session->set_flashdata('orderstatusError', $data->rmk);
				}
		}else{
			 
		}
		
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change status of Order Id ' . $_POST['the_id'] . ' to status ' . $_POST['to_status']);
    }
	public function changeOrdersOrderStatusByShiprocket()
    {
		if($_POST['to_status'] == 2){
				
				$orders_info = $this->Orders_model->getUserOrderDetails($_POST['the_id']);
				$vendor_details = $this->Public_model->getPickupLocation($_POST['locationId']);
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
					  "pickup_location"=> $vendor_details['name'],
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
				//echo json_encode($post);
				//die();
				
				$create_order = json_decode($this->cUrlGetData(shiprocket_api_url.'orders/create/adhoc', json_encode($post), $headers));
				
				//print_r($create_order);
				
				if($create_order->status_code == '1'){
					$result = $this->Orders_model->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
					$this->session->set_flashdata('orderstatusError', "Order Status Updated");
				}
				else{
					 $this->session->set_flashdata('orderstatusError', $create_order->message);
				}
				
				redirect('admin/orders');
				
		}
		
	}
    private function sendVirtualProducts()
    {
        if(isset($_POST['products']) && $_POST['products'] != '') {
            $products = unserialize(html_entity_decode($_POST['products']));
            foreach ($products as $product_id => $product_quantity) {
                $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product_id);
                /*
                 * If is virtual product, lets send email to user
                 */
                if ($productInfo['virtual_products'] != null) {
                    if (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
                        log_message('error', 'Ivalid customer email address! Cant send him virtual products!');
                        return false;
                    }
                    $result = $this->sendmail->sendTo($_POST['userEmail'], 'Dear Customer', 'Virtual products', $productInfo['virtual_products']);
                    return $result;
                }
            }
            return true;
        }
    }
	public function tracking_details(){
		if(isset($_POST['order_id'])) {
			$orders_info = $this->Public_model->getUserOrderDetails($_POST['order_id']);
			$shiprocket_auth_key = $this->Home_admin_model->getValueStore('shiprocket_api_key');
			$headers = array(
						"Content-Type: application/json",
						"Authorization: Bearer ".$shiprocket_auth_key
			);
			$tracking_details = json_decode($this->cUrlGetData(shiprocket_api_url.'courier/track?order_id='.$_POST['order_id'], "", $headers));
			$tracking_details  = $tracking_details[0];
			//print_r($tracking_details);
			$html = "<ul>";
			if($tracking_details->tracking_data->track_status == '1' && isset($tracking_details->tracking_data->track_status)){
				$tracking_status = $tracking_details->tracking_data->shipment_track_activities;
				foreach($tracking_status as $scan){
					$html .= '<li><div class="tracking_info">'.date('d.M.Y / H:i:s', strtotime($scan->date)).'</div><div class="tracking_date">'.$scan->activity.' at '.$scan->location.'</div></li>';
				}
			}else{
				$html .= '<li>No Tracking data available</li>';
			}
			$html .= "<ul>";
			echo $html;
		}
	}
	public function cancelOrder()
    {
		 $this->login_check();
		 $cancel_reason = $_POST['cancel_reason'];
		 if($cancel_reason == "")
		 $cancel_reason = "Admin Cancel from Backend";
		 
		 $result = $this->Orders_model->cancelOrderStatus($_POST['the_id'], $_POST['to_status'], $cancel_reason);
		 if ($result == true) {
           	redirect('admin/orders');
        } else {
            redirect('admin/orders');
        }
        $this->saveHistory('Change status of Order Id ' . $_POST['the_id'] . ' to status ' . $_POST['to_status']);
	}
	public function syncOrder()
    {
		$final_order_status = "";		
		$order_list_for_sync = $this->Orders_model->getOrderlistForSync();
		foreach($order_list_for_sync as $order){
				
				$url = delhivery_url."api/v1/packages/json/?waybill=".$order['tracking_number']."&verbose=2&token=".delhivery_token;
				$headers = array(
						"Authorization: Token ".delhivery_token
					  );
				$data = json_decode($this->cUrlGetData($url, '', $headers));
				$status = $data->ShipmentData[0]->Shipment->Status->StatusType;
				if($status == 'UD')
				$final_order_status = "2";
				else if($status == 'DL')
				$final_order_status = "3";
				else if($status == 'PP')
				$final_order_status = "6";
				
				$this->Orders_model->changeOrderStatus($order['order_product_id'], $final_order_status);
				
		}
    }
	public function updateReturnStatus()
    {
		
		$order_list_for_sync = $this->Orders_model->getOrderlistForReturnUpdate();
		foreach($order_list_for_sync as $order){
       			$post = [
					"ReferenceNumber" => $order['order_id']
				];
				$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => logistic_url."/api/v1/invoice-details/",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => json_encode($post),
				  CURLOPT_HTTPHEADER => array(
					"authorization: Basic ".auth_key,
					"cache-control: no-cache",
					"content-type: application/json",
					"paperflykey: ".paperflykey
				  ),
				));
				
				$response = json_decode(curl_exec($curl));
				$err = curl_error($curl);
				curl_close($curl);
				if($response->response_code == '200'){
					if($response->success->invoiceStatus[0]->ReturnToMerchant!=""){
						if(strtolower($response->success->invoiceStatus[0]->ReturnToMerchant) == 'yes'){
							$return_status = "returned_accepted";
							$this->Orders_model->updateReturnStatus($order['return_update_id'], $return_status, $response->success->invoiceStatus[0]->ReturnToMerchantDate);
						}else if(strtolower($response->success->invoiceStatus[0]->ReturnToMerchant) == 'no'){
							$return_status = "returned_decline";
							$this->Orders_model->updateReturnStatus($order['return_update_id'], $return_status, $response->success->invoiceStatus[0]->ReturnToMerchantDate);
						}
					}	
				}
		}
	   
    }
	function cUrlGetData($url, $post_fields = null, $headers = null) {
		$ch = curl_init();
		$timeout = 100;
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
	public function process_order()
	{
		if (isset($_POST['process_order'])) {
			$order_id = $_POST['order_id'];
			$orders_info = $this->Public_model->getOrderDetails($_POST['order_id']);
			if($orders_info){
				if($orders_info['payment_status']!='completed' && $orders_info['processed'] == '0'){
					$this->session->set_flashdata('order_message', 'Order Status Updated'); 
					 $this->Public_model->changePaymentStatus($order_id,'completed');
					 $this->generatePDF_EmailNotification($order_id);
				}else{
					 $this->session->set_flashdata('order_message', 'This order already processed.');
				}
				 
			}else{
				 $this->session->set_flashdata('order_message', 'Invalid Order ID');
			}
			
			
		}
		$this->load->view('_parts/header', $head);
		$this->load->view('ecommerce/process_order', $data);
		$this->load->view('_parts/footer');
	}
	private function generatePDF_EmailNotification($orderId){
			$orders_info = $this->Public_model->getOrderDetails($orderId);
			$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
			$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
		$footerContactPhone = htmlentities($this->Home_admin_model->getValueStore('footerContactPhone'));
		$footerContactEmail = htmlentities($this->Home_admin_model->getValueStore('footerContactEmail'));

		$this->load->library('m_pdf');
			$headerhtml = '<table style="text-align:center;width:100%;border-top:1px solid #ddd;" cellspacing="0" cellpadding="1"><tr><td style="width:100%;"><b><img width="150px" src="'.base_url('attachments/site_logo/' . $sitelogo).'" alt="myindiantoy"></b></td></tr><tr><td><i>PHONE- '.$footerContactPhone.'; E-mail: '.$footerContactEmail.'</i></td></tr><tr><td style="width:100%; margin-left:10px;border-top:1px solid #ddd; text-align:center;border-bottom:1px solid #ddd;">TAX INVOICE</td></tr></table>';
			
			
			$footerhtml = '<table style="text-align:center;width:100%" cellspacing="0" cellpadding="1"><tr><td style="width:100%;">Thank you for shopping. We hope you will come back soon.</td></tr></table>';
			$m_pdf = new mPDF('utf-8', 'A4','10', '', '', 0, 0, 10, 10, 0, 0); 
			$m_pdf->setAutoTopMargin = 'stretch';
			$m_pdf->allow_charset_conversion = true;
			$m_pdf->setAutoBottomMargin = 'stretch';
			$m_pdf->autoPageBreak = true;
			$m_pdf->SetHTMLHeader($headerhtml);
			$m_pdf->SetHTMLFooter($footerhtml);
			$discount = "";
			if($orders_info['discount_amount']>0){
                $discount_html = '<tr class="pad-left-right-space ">
													<td class="m-t-5" colspan="2" align="left">
														<p style="font-size: 14px;">Coupon Discount : </p>
													</td>
													<td class="m-t-5" colspan="2" align="right">
														<b style="">INR'.number_format($orders_info['discount_amount'],2).'</b>
													</td>
												</tr>';
			 $discount_pdf = '<tr><td colspan="3" style="border-top:1px solid #ddd;text-align: right">DSICOUNT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info['discount_amount'],2).'</td></tr>';
             } 
			
			
			$html_content = "<table width='100%' style='padding:0 20px;'>
							  <tr>
								<td width='50%'>
									<h4>SUMMARY</h4><br>
									 Order Ref #(".$orders_info['order_id'].")
									 <br>Order Date : ".date('F d,Y', $orders_info['date'])."
									 <br>Payment Method : ".$orders_info['payment_type']."
									 <br>GST : 27ABCCS4270Q1ZR
								</td>
							 <td width='50%'>
								<h4>DELIVERY ADDRESS</h4><br>
									".$orders_info['first_name']." ".$orders_info['last_name'] ."
									<br>".$orders_info['address'] ."
									<br>State : ".$orders_info['thana'] ."
									<br>".$orders_info['city'].". Pincode : ".$orders_info['post_code'] ."
									<br>Contact No. ".$orders_info['phone'] ."
									<br>".$orders_info['notes'] ."
							 </td></tr>
							 </table>";
			$arr_products = unserialize($orders_info['products']);
			$total = 0;
			$html_content .= '<table width="100%" style="border:1px solid #ddd; margin-top: 10px; padding:0 10px"><tr><td style="border-bottom:1px solid #ddd;">SL.</td><td style="border-bottom:1px solid #ddd;">TITLE</td><td style="border-bottom:1px solid #ddd;">QTY</td><td style="border-bottom:1px solid #ddd;">PRICE</td></tr>';
			$counter = 1;
			$invoice_product = "";
			foreach ($arr_products as $product) {	
				$productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
				$total +=$product['product_info']['price']*$product['product_quantity'];
				$html_content .= '<tr><td>'.$counter.'.</td><td>'.$productInfo['title'].'</td><td>'.$product['product_quantity'].'</td><td>'.number_format($product['product_info']['price']*$product['product_quantity'],2).'INR</td></tr>';
				$counter++;
				
				$invoice_product .= '<tr>
													<td>
														<img src="'.base_url('attachments/shop_images/' . $product['product_info']['image']).'" alt="" width="80">
													</td>
													<td valign="top" style="padding-left: 15px;">
														<h5 style="margin-top: 15px;">'.$productInfo['title'].'</h5>
													</td>
													<td valign="top" style="padding-left: 15px;">
														<h5 style="font-size: 14px; color:#444;margin-top: 10px;">QTY : <span>'.$product['product_quantity'].'</span></h5>
													</td>
													<td valign="top" style="padding-left: 15px;">
														<h5 style="font-size: 14px; color:#444;margin-top:15px"><b>INR'.number_format($product['product_info']['price']*$product['product_quantity'],2).'</b></h5>
													</td>
												</tr>';
																
							}
	$html_content .= '<tr><td colspan="3" style="border-top:1px solid #ddd;text-align: right">SUB TOTAL :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($total,2).'</td></tr>'.$discount_pdf;
	$html_content .= '<tr><td colspan="3" style="border-top:1px solid #ddd;text-align: right">SHIPPING :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info['shipping_cost'],2).'</td></tr>';
	$html_content .= '<tr><td colspan="3" style="border-top:1px solid #ddd;text-align: right">TOTAL AMOUNT :<br>(GST included)</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info['total_order_price'],2).'</td></tr>';
	$html_content .= '</table>';
	
	$m_pdf->WriteHTML($html_content);
	$pdfFilePath = 'Order_Invoice_'.$orderId.'.pdf';
	$m_pdf->Output('./invoice/'.$pdfFilePath, "F");	
							
							//Send Email
	$invoice_mail = '<table align="center" border="0" cellpadding="0" cellspacing="0" style="padding: 0 30px;background-color: #fff; -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);width: 100%;">
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
												<p style="font-size: 14px;">Transaction ID : '.$userInfo['order_id'].',</p>
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
										'.$invoice_product.'
										<tr class="pad-left-right-space ">
											<td class="m-t-5" colspan="2" align="left">
												<p style="font-size: 14px;">Subtotal : </p>
											</td>
											<td class="m-t-5" colspan="2" align="right">
												<b style="">INR'.number_format($total,2).'</b>
											</td>
										</tr>'.$discount_html.'
										<tr class="pad-left-right-space">
											<td colspan="2" align="left">
												<p style="font-size: 14px;">SHIPPING Charge :</p>
											</td>
											<td colspan="2" align="right">
												<b> INR'.number_format($orders_info['shipping_cost'],2).'</b>
											</td>
										</tr>
										<tr class="pad-left-right-space ">
											<td class="m-b-5" colspan="2" align="left">
												<p style="font-size: 14px;">Total :</p>
											</td>
											<td class="m-b-5" colspan="2" align="right">
												<b>INR'.number_format($orders_info['total_order_price'],2).'</b>
											</td>
										</tr>
				
									</tbody></table>
				
								</td>
							</tr>
						</tbody>
					</table>';
							$this->load->library('email');
							$this->email->set_mailtype("html");
							$this->email->from('info@myindiantoy.com', 'My Indian Toy');
							$this->email->to($userInfo['email'], $userInfo['name']);
							$this->email->subject('Thank you for your order');
							
							
							$this->email->message($invoice_mail);
							
							$this->email->set_newline("\r\n");
							$this->email->send();	
	}


}
