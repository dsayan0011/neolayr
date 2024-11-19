<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products_review extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Products_model', 'Languages_model', 'Categories_model', 'Vendor_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Products Review';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['action'])) {
			if($_GET['action'] == 'active'){
				$this->Products_model->updateReviewStatus($_GET['id'],'active');
				$this->session->set_flashdata('result_delete', 'Product review Updated');
			}
			if($_GET['action'] == 'inactive'){
				$this->Products_model->updateReviewStatus($_GET['id'],'inactive');
				$this->session->set_flashdata('result_delete', 'Product review Updated');
			}
           if($_GET['action'] == 'delete'){
				$this->Products_model->deleteReview($_GET['id']);
				$this->session->set_flashdata('result_delete', 'Product review Updated');
			}
            redirect('admin/products_review');
        }

      
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Products_model->productsReviewCount($search_title);
        $data['products'] = $this->Products_model->getproducts_review($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/products_review', $rowscount, $this->num_rows, 3);
        $data['languages'] = $this->Languages_model->getLanguages();
		
        $this->saveHistory('Go to products');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/products_review', $data);
        $this->load->view('_parts/footer');
    }
	

}
