<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Order_return extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Orders_model', 'Home_admin_model', 'Vendor_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Manage Return';
        $head['description'] = '!';
        $head['keywords'] = '';
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
        if (isset($_GET['delete'])) {
            $this->Products_model->deleteProduct($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'product is deleted!');
            $this->saveHistory('Delete product id - ' . $_GET['delete']);
            redirect('admin/products');
        }
		
		$data['get'] = $_SERVER['QUERY_STRING'];
		
        unset($_SESSION['filter']);
        $search_title = null;
        $rowscount = $this->Orders_model->returnCount($start_date, $end_date, $order_number);
        $data['orders'] = $this->Orders_model->getReturn($this->num_rows, $page, $start_date, $end_date, $order_number);
        $data['links_pagination'] = pagination('admin/return', $rowscount, $this->num_rows, 3);
        $this->saveHistory('Go to Return');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/return', $data);
        $this->load->view('_parts/footer');
    }
	public function change_return_status()
    {
		 $this->login_check();
		 $cancel_reason = $_POST['cancel_reason'];
		 if($cancel_reason == "")
		 $cancel_reason = "";
		 
		 $result = $this->Orders_model->changeReturnStatus($_POST['the_id'],$_POST['order_id'], $_POST['to_status'], $_POST['return_status'], $cancel_reason);
		 if ($result == true) {
           	redirect('admin/return');
        } else {
            redirect('admin/return');
        }
	}
	public function process_return_order($order_id,$return_id,$product_id,$variant_id){
				$orders_info = $this->Public_model->getUserOrderDetails($order_id);
		
				$vendor_details = $this->Vendor_model->getVendorDetailsByOrderID($order_id);
				$arr_products = unserialize($orders_info['order_products']);
				$total_amount = 0;
				$product_weight = 0;
				$order_item = array();
                foreach ($arr_products as $product) {
					if($product['product_info']['id'] == $product_id && $product['product_info']['variant_id'] == $variant_id)
					{
						
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
														 
														 
				 }
				$shiprocket_auth_key = $this->Home_admin_model->getValueStore('shiprocket_api_key');
				$headers = array(
						"Content-Type: application/json",
						"Authorization: Bearer ".$shiprocket_auth_key
				);
				//Get length and height
				$weight_details = $this->Orders_model->getWeightDetails($product_weight);
				
				
				
				
				/*$post = array(
					  "order_id"=>$orders_info['order_product_id'],
					  "order_date"=>$orders_info['order_update_date'],
					  "channel_id"=> "",
					  "pickup_customer_name"=> $orders_info['first_name']." ".$orders_info['last_name'],
					  "pickup_last_name"=>  $orders_info['last_name'],
					  "pickup_address"=> trim(preg_replace('/\s\s+/', ' ', $orders_info['address'])),
					  "pickup_address_2"=> "",
					  "pickup_city"=> $orders_info['city'],
					  "pickup_state"=> $orders_info['thana'],
					  "pickup_country"=> $orders_info['city'],
					  "pickup_pincode"=> $orders_info['post_code'],
					  "pickup_email"=> $orders_info['email'],
					  "pickup_phone"=> substr($orders_info['phone'], -10),
					  "pickup_location_id"=> "",
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
				
				
				$create_order = json_decode($this->cUrlGetData(shiprocket_api_url.'orders/create/return', json_encode($post), $headers));*/
				
				//print_r($create_order);
				$this->Orders_model->updateReturnProcessStatus($return_id);
				
				redirect('admin/return');
	}
}
