<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products extends VENDOR_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Products_model','admin/Categories_model'));
    }

    public function index($page = 0)
    {
        if (isset($_GET['delete'])) {
            $this->Products_model->deleteProduct($_GET['delete'],$this->vendor_id);
            $this->session->set_flashdata('result_delete', 'product is deleted!');
            redirect('vendor/products');
        }
		$search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
        }
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_products');
        $head['description'] = lang('vendor_products');
        $head['keywords'] = '';
        $rowscount = $this->Products_model->productsCount($this->vendor_id,$search_title, $category);
        $data['products'] = $this->Products_model->getproducts($this->num_rows, $page, $this->vendor_id, $search_title, $orderby, $category);
        $data['links_pagination'] = pagination('vendor/products', $rowscount, $this->num_rows, MY_LANGUAGE_ABBR == MY_DEFAULT_LANGUAGE_ABBR ? 3 : 4);
		$data['shop_categories'] = $this->Categories_model->getShopCategories(null, null, 2);
        $this->load->view('_parts/header', $head);
        $this->load->view('products', $data);
        $this->load->view('_parts/footer');
    }

    public function deleteProduct($id)
    {
        $this->Products_model->deleteProduct($id, $this->vendor_id);
        $this->session->set_flashdata('result_delete', lang('vendor_product_deleted'));
        redirect(LANG_URL . '/vendor/products');
    }

    public function logout()
    {
        unset($_SESSION['logged_vendor']);
        delete_cookie('logged_vendor');
        redirect(LANG_URL . '/vendor/login');
    }

}
