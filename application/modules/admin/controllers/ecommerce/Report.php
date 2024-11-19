<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Report extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Orders_model', 'Products_model', 'Home_admin_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Orders Report';
        $head['description'] = '!';
        $head['keywords'] = '';

        $order_by = null;
        if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
			$data_order = array();
			$order_data = $this->Orders_model->get_order_by_date($_POST['start_date'],$_POST['end_date']);
			if(sizeof($order_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("Sl.","Order ID", "Date", "Name", "Phone", "Status", "Payment Type", "Payment Status");
			  $column = 0;
			  foreach($table_columns as $field)
			  {
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			  }
			  $excel_row = 2;
		      $counter=1;	  
				foreach($order_data as $tr)
				{
					    if ($tr['orderstatus'] == 0) {
                            $type = 'Processing';
                        }
                        if ($tr['orderstatus'] == 1) {
                            $type = 'Processed';
                        }
                        if ($tr['orderstatus'] == 2) {
                            $type = 'Shipped';
                        }
						if ($tr['orderstatus'] == 3) {
                            $type = 'Delivered';
                        }
						if ($tr['orderstatus'] == 4) {
                            $type = 'Cancelled';
                        }
						if ($tr['orderstatus'] == 5) {
                            $type = 'Settled';
                        }
						if ($tr['orderstatus'] == 6) {
                            $type = 'Returned';
                        }
						if ($tr['orderstatus'] == 7) {
                            $class = 'bg-success';
                            $type = 'Delivered Returned Sattled';
                        }
						if ($tr['orderstatus'] == 8) {
                            $class = 'bg-success';
                            $type = 'Shipped Return';
                        }
						if ($tr['orderstatus'] == 9) {
                            $class = 'bg-success';
                            $type = 'Returned Sattled';
                        }
					   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $counter);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, "#".$tr['order_product_id']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, date('d.M.Y / H:i:s', $tr['date']));
					   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $tr['first_name'] . ' ' . $tr['last_name']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $tr['phone']);	
					   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $type);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $tr['payment_type']);
					    $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $tr['payment_status']);
					   $excel_row++;
					   $counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "Order Report ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
			}
			else{
				$this->session->set_userdata("report_message","No Data Found");
				redirect('admin/report');
			}
			
		}
		else{
			$this->load->view('_parts/header', $head);
			$this->load->view('ecommerce/orders_report', $data);
			$this->load->view('_parts/footer');
		}
    }
	public function advance_order($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Advance Orders Report';
		$data['title'] = 'Advance Orders Report';
        $head['description'] = '!';
        $head['keywords'] = '';

        $order_by = null;
        if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
			$data_order = array();
			$order_data = $this->Orders_model->get_order_by_date($_POST['start_date'],$_POST['end_date']);
			if(sizeof($order_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("Sl.", "Main Order ID", "Order ID", "Order Date", "Product Name", "Quantity", "Price", "Vendor Price", "Weight", "Vendor Name", "Order Product Price", "Shipping Cost", "Discount Code", "Discount", "Main Order Price","Customer Name", "Customer Phone", "Delivery Details", "Order Status", "Payment Type", "Payment Status");
			  $column = 0;
			  foreach($table_columns as $field)
			  {
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			  }
			  $excel_row = 2;
		      $counter=1;
			 
				foreach($order_data as $tr)
				{
					    if ($tr['orderstatus'] == 0) {
                            $type = 'Processing';
                        }
                        if ($tr['orderstatus'] == 1) {
                            $type = 'Processed';
                        }
                        if ($tr['orderstatus'] == 2) {
                            $type = 'Shipped';
                        }
						if ($tr['orderstatus'] == 3) {
                            $type = 'Delivered';
                        }
						if ($tr['orderstatus'] == 4) {
                            $type = 'Cancelled';
                        }
						if ($tr['orderstatus'] == 5) {
                            $type = 'Settled';
                        }
						if ($tr['orderstatus'] == 6) {
                            $class = 'bg-success';
                            $type = 'Returned';
                        }
						if ($tr['orderstatus'] == 7) {
                            $class = 'bg-success';
                            $type = 'Delivered Returned Sattled';
                        }
						if ($tr['orderstatus'] == 8) {
                            $class = 'bg-success';
                            $type = 'Shipped Return';
                        }
						if ($tr['orderstatus'] == 9) {
                            $class = 'bg-success';
                            $type = 'Returned Sattled';
                        }
					   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $counter);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, "#".$tr['order_id']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, "#".$tr['order_product_id']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, date('d.M.Y / H:i:s', $tr['date']));
					   $arr_products = unserialize($tr['order_products']);
					  
					   $product_amount = 0;
					   $selling_amount = 0;
					   $firstrow = 0;
					   
					   foreach ($arr_products as $product) {
						   $product_amount += $product['product_info']['price'] * $product['product_quantity'];
					   }
					   foreach ($arr_products as $product) {
						  $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
						  $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "");
								 $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, "#".$tr['order_id']);
								 $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, "#".$tr['order_product_id']);
								 $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, date('d.M.Y / H:i:s', $tr['date']));
						   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $productInfo['title']);	
						   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $product['product_quantity']);
						   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $product['product_info']['price']);
						   $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $product['product_info']['vendor_price']);
						   $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $product['product_info']['weight'].$product['product_info']['weight_unit']);
						   $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $product['product_info']['vendor_name']);
						   $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $product['product_info']['price']*$product['product_quantity']);
						   if($firstrow == 0){
							   $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $tr['shipping_cost']);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $tr['discount_code']);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $tr['discount_amount']);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $tr['total_order_price']);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $tr['first_name'] . ' ' . $tr['last_name']);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $tr['phone']);	
							   $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $tr['address'].".City : ".$tr['city'].".State : ".$tr['thana']);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $type);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $tr['payment_type']);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $tr['payment_status']);
							  
							  
							   
						   }else{
							     $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, "");
								 $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, "");
								 $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, "");
								 $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, "");
								 $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, "");
								 $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, "");
								  $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, "");
								   $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, "");
								    $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, "");
									  $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, "");
						   }
						  $counter++;
					 	  $firstrow++;
						   $excel_row++;
						}
					  
					   $firstrow = 0;
					   $excel_row++;
					   $counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "Advance Order Report ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
			}
			else{
				$this->session->set_userdata("report_message","No Data Found");
				redirect('admin/report');
			}
			
		}
		else{
			$this->load->view('_parts/header', $head);
			$this->load->view('ecommerce/orders_report', $data);
			$this->load->view('_parts/footer');
		}
    }
	public function product($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Product Report';
        $head['description'] = '!';
        $head['keywords'] = '';

        $order_by = null;
        if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
			$data_order = array();
			$order_data = $this->Orders_model->get_order_by_date($_POST['start_date'],$_POST['end_date']);
			if(sizeof($order_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("Main Order ID", "Order ID", "Order Date", "Product ID", "Product Title", "Quantity", "Unit Price");
			  $column = 0;
			  foreach($table_columns as $field)
			  {
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			  }
			  $excel_row = 2;
		      $counter=1;
			  $firstrow = 0;	  
				foreach($order_data as $tr)
				{
					$arr_products = unserialize($tr['order_products']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $tr['order_id']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $tr['order_product_id']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, date('d.M.Y', $tr['date']));
					$arr_products = unserialize($tr['order_products']);
                    foreach ($arr_products as $product) {
					  $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
					  if($firstrow != 0){
							 $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "");
							 $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, "");
							  $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, "");
						}
					   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $product['product_info']['id']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $productInfo['title']);	
					   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $product['product_quantity']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $product['product_info']['price'].' '.$this->config->item('currency'));
					   
					   $excel_row++;
					   $firstrow++;
					}
					   $firstrow = 0;
					   $excel_row++;
					   $counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "Product Sales Report ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
			}
			else{
				$this->session->set_userdata("report_message","No Data Found");
				redirect('admin/report/product');
			}
			
		}
		else{
			$this->load->view('_parts/header', $head);
			$this->load->view('ecommerce/product_report', $data);
			$this->load->view('_parts/footer');
		}
    }
	
	public function subscriber()
    {
       
			$data_order = array();
			$order_data = $this->Orders_model->get_subscriber_user();
			if(sizeof($order_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("Sl.","Subscriber Email", "Subscription Date", "Status");
			  $column = 0;
			  foreach($table_columns as $field)
			  {
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			  }
			  $excel_row = 2;
		      $counter=1;	  
				foreach($order_data as $tr)
				{
					   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $counter);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $tr['subscriber_email']);
					   
					   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, date('d.M.Y h:i A', strtotime($tr['subscription_date'])));
					   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $tr['status']);
					   $excel_row++;
					   $counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "Subscriber Report ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
			}
			else{
				$this->session->set_userdata("report_message","No Data Found");
				redirect('admin/report');
			}
    }
	public function user()
    {
       
			$data_order = array();
			$order_data = $this->Orders_model->get_user();
			if(sizeof($order_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("Sl.","User ID", "Name", "Email", "Phone", "Registration Date");
			  $column = 0;
			  foreach($table_columns as $field)
			  {
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			  }
			  $excel_row = 2;
		      $counter=1;	  
				foreach($order_data as $tr)
				{
					   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $counter);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $tr['id']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $tr['name']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $tr['email']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $tr['phone']);	
					   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, date('d.M.Y', strtotime($tr['created'])));
					   
					   $excel_row++;
					   $counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "User Report ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
			}
			else{
				$this->session->set_userdata("report_message","No Data Found");
				redirect('admin/report/income');
			}
    }
	public function order_updates()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Order account report';
        $head['description'] = '!';
        $head['keywords'] = '';
		
       	  if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
			$data_order = array();
			$order_data = $this->Orders_model->get_vendor_earning($_POST['start_date'],$_POST['end_date']." 23:59:59");
			if(sizeof($order_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("Order ID", "Order Status", "Vendor ID", "Vendor Name", "Warehouse Name", "Vendor Earning", "Payment Status", "Last Updated");
			  $column = 0;
			  foreach($table_columns as $field)
			  {
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			  }
			  $excel_row = 2;
		      $counter=1;	  
				foreach($order_data as $tr)
				{
						if ($tr['orderstatus'] == 0) {
                            $type = 'Processing';
                        }
                        if ($tr['orderstatus'] == 1) {
                            $type = 'Processed';
                        }
                        if ($tr['orderstatus'] == 2) {
                            $type = 'Shipped';
                        }
						if ($tr['orderstatus'] == 3) {
                            $type = 'Delivered';
                        }
						if ($tr['orderstatus'] == 4) {
                            $type = 'Cancelled';
                        }
						if ($tr['orderstatus'] == 5) {
                            $type = 'Settled';
                        }
						if ($tr['orderstatus'] == 6) {
                            $class = 'bg-success';
                            $type = 'Returned';
                        }
						if ($tr['orderstatus'] == 7) {
                            $class = 'bg-success';
                            $type = 'Delivered Returned Sattled';
                        }
						if ($tr['orderstatus'] == 8) {
                            $class = 'bg-success';
                            $type = 'Shipped Return';
                        }
						if ($tr['orderstatus'] == 9) {
                            $class = 'bg-success';
                            $type = 'Returned Sattled';
                        }
						 $table_columns = array("Order ID", "Order Status", "Vendor ID", "Vendor Name", "Warehouse Name", "Vendor Earning", "Payment Status", "Last Updated");
						 
					  $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "#".$tr['order_product_id']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $type);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $tr['vendor_id']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $tr['name']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $tr['warehouse_name']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $tr['vendor_earning']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $tr['vendor_payment_status']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $tr['order_update_date']);
					   $excel_row++;
					   $counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "Order Account Report ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
			}else{
				$this->session->set_userdata("report_message","No Data Found");
				redirect('admin/report/order_updates');
			}
		  }else{
			    $this->load->view('_parts/header', $head);
				$this->load->view('ecommerce/order_update_report', $data);
				$this->load->view('_parts/footer');
		  }
    }
	public function return_order()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Return Order report';
        $head['description'] = '!';
        $head['keywords'] = '';
		
       	  if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
			$data_order = array();
			$order_data = $this->Orders_model->get_return_order($_POST['start_date'],$_POST['end_date']." 23:59:59");
			if(sizeof($order_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("Sl.","Order ID","Order Date", "Order Return Date", "Return Status", "Return Date By Courier Partner", "Return Approval Status", "Remark", "Product", "Product Quantity");
			  $column = 0;
			  foreach($table_columns as $field)
			  {
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			  }
			  $excel_row = 2;
		      $counter=1;	  
				foreach($order_data as $tr)
				{
					   $arr_products = unserialize($tr['products']);
					   $firstrow = 0;
					   if($tr['warehouse_return_date']!="") $warehouse_return_date =  date('d.M.Y / H:i:s', strtotime($tr['warehouse_return_date']));else $warehouse_return_date = "";
					
					   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $counter);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $tr['order_id']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, date('d.M.Y / H:i:s', $tr['date']));
					   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, date('d.M.Y', strtotime($tr['return_date'])));
					   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, strtoupper(str_replace("_"," ",$tr['return_status'])));
					   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $warehouse_return_date);	
					   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $tr['return_accepted_at_warehouse']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $tr['remark']);
					   
					   foreach ($arr_products as $product) {
						  $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
						  if($firstrow != 0){
								   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "");
								   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, "");
								   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, "");
								   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, "");
								   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, "");
								   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, "");
								   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, "");
								   $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, "");
							}
						   $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $productInfo['title']);	
						   $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $product['product_quantity']);
						   $excel_row++;
						   $firstrow++;
						}
					   
					   
					  
					   $excel_row++;
					   $counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "Returned Order Report ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
			}else{
				$this->session->set_userdata("report_message","No Data Found");
				redirect('admin/report/return_order');
			}
		  }else{
			    $this->load->view('_parts/header', $head);
				$this->load->view('ecommerce/return_order_report', $data);
				$this->load->view('_parts/footer');
		  }
    }
	public function invenoty($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Product Invenoty Report';
        $head['description'] = '!';
        $head['keywords'] = '';
			$data_order = array();
			$product_data = $this->Products_model->getAllProductsInventory();
			if(sizeof($product_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("Product ID", "Product Title", "Quantity", "Unit Price");
			  $column = 0;
			  foreach($table_columns as $field)
			  {
			   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			   $column++;
			  }
			  $excel_row = 2;
		      $counter=1;
			  $firstrow = 0;	  
				foreach($product_data as $tr)
				{
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $tr['product_id']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $tr['title']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $tr['quantity']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $tr['price']);
					$excel_row++;
					$counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "Product Inventory Report ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
		}
			
    }
}
