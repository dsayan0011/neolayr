<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Accounts extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Orders_model', 'Home_admin_model'));
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

        $rowscount = $this->Orders_model->getTotalOnlinePurchase();
		
		if($rowscount<$page)
		$page = 0;
		
        $data['orders'] = $this->Orders_model->getOnlineOrders($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/accounts', $rowscount, $this->num_rows, 3);
      	
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/accounts', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to orders page');
        }
    }
}
