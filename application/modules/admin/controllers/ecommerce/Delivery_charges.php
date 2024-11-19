<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Delivery_charges extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Products_model', 'Languages_model', 'Categories_model'));
		$this->load->library('excel');
    }

    public function index($page = 0)
    {
        $this->login_check();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			if(isset($_FILES["userfile"]["name"]))
			  {
			   $path = $_FILES["userfile"]["tmp_name"];
			   $object = PHPExcel_IOFactory::load($path);
			   foreach($object->getWorksheetIterator() as $worksheet)
			   {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				 
				for($row=2; $row<=$highestRow; $row++)
				{
				$data = array(
				  'state_name'   => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
				  'delivery_time'    =>  $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
				  'delivery_charges'  => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
				  'is_default'  => $worksheet->getCellByColumnAndRow(4, $row)->getValue()
				 );
				 $this->Products_model->update_delivery_chrage($worksheet->getCellByColumnAndRow(0, $row)->getValue(),$data);
				}
			   } 
			  } 
			  $this->session->set_flashdata('result_publish','Delivery charges updated');
			  redirect('admin/deliveryCharge');
		}
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Delivery Charges';
        $head['description'] = '!';
        $head['keywords'] = '';
		$rowscount = $this->Products_model->districtCount();
        $data['delivery'] = $this->Products_model->getdistrict($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/deliveryCharge', $rowscount, $this->num_rows, 3);
        $this->saveHistory('Go to Devlivery');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/delivery_chrages', $data);
        $this->load->view('_parts/footer');
	}
	public function download()
    {
        $this->login_check();
        $data = array();
        $head = array();
        
			$data_order = array();
			$order_data = $this->Products_model->getAlldistrict();
			if(sizeof($order_data)>0){
			  $this->load->library("excel");
			  $object = new PHPExcel();
			  $object->setActiveSheetIndex(0);
			  $table_columns = array("District ID","District Name", "Delivery Time", "Delivery Charges", "Is Default");
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
					   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $tr['district_id']);
					   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $tr['state_name']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $tr['delivery_time']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $tr['delivery_charges']);
					  $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $tr['is_default']);
					 
					   $excel_row++;
					   $counter++;
				}
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				  $filename = "Delivery Charges ".date("d-m-Y").".xls";
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$filename.'"');
				  $object_writer->save('php://output');
			}
    }
}
