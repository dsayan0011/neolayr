<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Order_return extends VENDOR_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Orders_model', 'Home_admin_model'));
    }

    public function index($page = 0)
    {
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
       
		$data['get'] = $_SERVER['QUERY_STRING'];
		
        unset($_SESSION['filter']);
        $search_title = null;
        $rowscount = $this->Orders_model->returnCount($start_date, $end_date, $order_number,$this->vendor_id);
        $data['orders'] = $this->Orders_model->getReturn($this->num_rows, $page, $start_date, $end_date, $order_number,$this->vendor_id);
        $data['links_pagination'] = pagination('vendor/return', $rowscount, $this->num_rows, 3);
        $this->load->view('_parts/header', $head);
        $this->load->view('return', $data);
        $this->load->view('_parts/footer');
    }
	public function change_return_status()
    {
		 $cancel_reason = $_POST['cancel_reason'];
		 if($cancel_reason == "")
		 $cancel_reason = "";
		 
		 $result = $this->Orders_model->changeReturnStatus($_POST['the_id'],$_POST['order_id'], $_POST['to_status'], $_POST['return_status'], $cancel_reason);
		 if ($result == true) {
           	redirect('vendor/return');
        } else {
            redirect('vendor/return');
        }
	}
}
