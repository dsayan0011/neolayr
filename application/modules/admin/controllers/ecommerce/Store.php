<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Store extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Pages_model', 'Languages_model', 'Categories_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Store';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Pages_model->deleteStore($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Store is deleted!');
            $this->saveHistory('Delete Store id - ' . $_GET['delete']);
            redirect('admin/store');
        }

        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Pages_model->storeCount();
        $data['storeLocator'] = $this->Pages_model->getStore($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/store', $rowscount, $this->num_rows, 3);
        //echo "<pre>";print_r($data['storeLocator']);exit;
        $data['num_shop_art'] = $this->Pages_model->numShopBanner();
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->saveHistory('Go to Store Locator');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/store_locator', $data);
        $this->load->view('_parts/footer');
    }
	public function add_store($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneStore($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $this->Pages_model->setStore($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Store is added!');
            $this->saveHistory('Store Added');
             redirect('admin/store');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Store';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_store', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
	public function edit_store($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneStore($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $this->Pages_model->setStore($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Store is Updated!');
            $this->saveHistory('Store Added');
             redirect('admin/store');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Store';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_store', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    // private function uploadImage()
    // {
    //     $config['upload_path'] = './attachments/banner_images/';
    //     $config['allowed_types'] = $this->allowed_img_types;
    //     $this->load->library('upload', $config);
    //     $this->upload->initialize($config);
    //     if (!$this->upload->do_upload('userfile')) {
    //         log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
    //     }
    //     $img = $this->upload->data();
    //     return $img['file_name'];
    // }


}
