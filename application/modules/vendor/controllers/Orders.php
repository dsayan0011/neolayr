<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Orders extends VENDOR_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Orders_model', 'Products_model'));
    }

    public function index($page = 0)
    {

        $data = array();
        $head = array();
        $head['title'] = lang('vendor_orders');
        $head['description'] = lang('vendor_orders');
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
					
						
						redirect('vendor/orders');
			
		}
		
        $rowscount = $this->Orders_model->ordersCount($this->vendor_id ,$sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission);
        if($rowscount<$page)
		$page = 0;
		$data['links_pagination'] = pagination('vendor/orders', $rowscount, $this->num_rows, 3);
		
		$data['orders'] = $this->Orders_model->orders($this->num_rows, $page, $this->vendor_id, $sort_by, $seller_name, $seller_number, $start_date, $end_date, $order_number, $display_order_perimission);
        $this->load->view('_parts/header', $head);
        $this->load->view('orders', $data);
        $this->load->view('_parts/footer');
    }

    public function getProductInfo($product_id, $vendor_id)
    {
        return $this->Products_model->getOneProduct($product_id, $vendor_id);
    }

    public function changeOrdersOrderStatus()
    {
        //Create Delhivery Shipment
		if($_POST['to_status'] == 2){
				$result = $this->Orders_model->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
				$orders_info = $this->Orders_model->getUserOrderDetails($_POST['the_id']);
				
				$vendor_details = $this->Orders_model->getVendorDetailsByOrderID($_POST['the_id']);
				if($orders_info['payment_type'] == 'cashOnDelivery')
				$payment_mode = "COD";
				else
				$payment_mode = "Prepaid";
				
				$post = 'format=json&data={
						  "pickup_location": {
							"pin": "'.$vendor_details['pincode'].'",
							"add": "'.$vendor_details['address'].'",
							"phone": "'.$vendor_details['phone'].'",
							"state": "'.$vendor_details['district_name'].'",
							"city": "'.$vendor_details['city_name'].'",
							"country": "India",
							"name": "'.$vendor_details['warehouse_name'].'"
						  },
						  "shipments": [{
							"return_name": "'.$vendor_details['warehouse_name'].'",
							"return_pin": "'.$vendor_details['pincode'].'",
							"return_city": "'.$vendor_details['city_name'].'",
							"return_phone": "'.$vendor_details['phone'].'",
							"return_add": "'.$vendor_details['address'].'",
							"return_state": "'.$vendor_details['district_name'].'",
							"return_country": "India",
							"order": "'.$orders_info['order_product_id'].'",
							"phone": "'.$orders_info['phone'].'",
							"products_desc": "myindiantoy Product",
							"cod_amount": "'.$orders_info['total_order_price'].'",
							"name": "'.$orders_info['first_name']." ".$orders_info['last_name'].'",
							"country": "India",
							"seller_inv_date": "",
							"order_date": "'.date('Y-m-d H:i:s', $orders_info['date']).'",
							"total_amount": "'.$orders_info['total_order_price'].'",
							"seller_add": "",
							"seller_cst": "",
							"add": "'.trim(preg_replace('/\s\s+/', ' ', $orders_info['address'])).'",
							"seller_name": "",
							"seller_inv": "",
							"seller_tin": "",
							"pin": "'.$orders_info['post_code'].'",
							"payment_mode": "'.$payment_mode.'",
							"state": "'.$orders_info['city'].'",
							"city": "'.$orders_info['thana'].'",
							"client": "SUVITEEGLOBAL SURFACE"
						  }]
						}';
			
				$url = delhivery_url."api/cmu/create.json";
				$headers = array(
					"Authorization: Token ".delhivery_token,
					"Content-Type application/json"
				  );
				$data = json_decode($this->cUrlGetData($url, $post, $headers));
				if($data->success){
					 $result = $this->Orders_model->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
					 $this->Orders_model->updateOrderTracking($_POST['the_id'], $data->packages[0]->waybill);
				}else{
					 $this->session->set_flashdata('orderstatusError', $data->rmk);
				}
		}else{
			 $result = $this->Orders_model->changeOrderStatus($_POST['the_id'], $_POST['to_status']);
		}
		
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
       
    }
	public function tracking_details(){
	if(isset($_POST['order_id'])) {
			$orders_info = $this->Public_model->getUserOrderDetails($_POST['order_id']);
			
			$url = delhivery_url."api/v1/packages/json/?waybill=".$orders_info['tracking_number']."&verbose=2&token=".delhivery_token;
				$headers = array(
					"Authorization: Token ".delhivery_token
				  );
			$data = json_decode($this->cUrlGetData($url, '', $headers));
		
			$tracking_status = $data->ShipmentData[0]->Shipment->Scans;
			$html = "<ul>";
				$value_found = false;
				foreach($tracking_status as $scan){
					$value_found = true;
					$html .= '<li><div class="tracking_info">'.date('d.M.Y / H:i:s', strtotime($scan->ScanDetail->ScanDateTime)).'</div><div class="tracking_date">'.$scan->ScanDetail->Instructions.' at '.$scan->ScanDetail->ScannedLocation.'</div></li>';
				}
				if(!$value_found)
				$html .= '<li>No Tracking Data Found</li>';
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
           	redirect('vendor/orders');
        } else {
            redirect('vendor/orders');
        }
        $this->saveHistory('Change status of Order Id ' . $_POST['the_id'] . ' to status ' . $_POST['to_status']);
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
}
