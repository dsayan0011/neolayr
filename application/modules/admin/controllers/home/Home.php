<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends ADMIN_Controller
{

    private $num_rows = 10;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Orders_model', 'History_model', 'Pages_model', 'Languages_model', 'Categories_model'));
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Home';
        $head['description'] = '';
        $head['keywords'] = '';
        $data['newOrdersCount'] = $this->Orders_model->ordersCount(true);
		$data['todaysOrderCount'] = $this->Orders_model->todaysOrdersCount();
        $data['lowQuantity'] = $this->Home_admin_model->countLowQuantityProducts();
        $data['lastSubscribed'] = $this->Home_admin_model->lastSubscribedEmailsCount();
        $data['newUsersCheck'] = $this->Home_admin_model->newUsersCheck();        
        $data['activity'] = $this->History_model->getHistory(10, 0);
        $data['mostSold'] = $this->Home_admin_model->getMostSoldProducts();
        $data['byReferral'] = $this->Home_admin_model->getReferralOrders();
        $data['ordersByPaymentType'] = $this->Home_admin_model->getOrdersByPaymentType();
        $data['ordersByMonth'] = $this->Home_admin_model->getOrdersByMonth();
        $this->load->view('_parts/header', $head);
        $this->load->view('home/home', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to home page');
    }

    /*
     * Called from ajax
     */

    public function changePass()
    {
        $this->login_check();
        $result = $this->Home_admin_model->changePass($_POST['new_pass'], $this->username);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Password change for user: ' . $this->username);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin');
    }
    public function shop_concern($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Pages_model->deleteConcern($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Concern is deleted!');
            $this->saveHistory('Delete Concern id - ' . $_GET['delete']);
            redirect('admin/shopConcern');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Pages_model->concernCount();
        $data['banner'] = $this->Pages_model->getConcern($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/shopConcern', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Pages_model->concernCount();
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->saveHistory('Go to Concern');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/shop_concern', $data);
        $this->load->view('_parts/footer');
    }
    public function add_shop_concern($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneConcern($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadImage();
            $this->Pages_model->setConcern($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Concern is added!');
            $this->saveHistory('Concern Added');
             redirect('admin/shopConcern');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Concern';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_shop_concern', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    public function edit_concern($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneConcern($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadImage();
            $this->Pages_model->setConcern($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Concern is added!');
            $this->saveHistory('Concern Added');
             redirect('admin/shopConcern');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Concern';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_shop_concern', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    private function uploadImage()
    {
        $config['upload_path'] = './attachments/concern_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
    public function testimonial($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Testimonial';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Pages_model->deleteTestimonial($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Testimonial is deleted!');
            $this->saveHistory('Delete Testimonial id - ' . $_GET['delete']);
            redirect('admin/testimonial');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Pages_model->testimonialCount();
        $data['testimonials'] = $this->Pages_model->getTestimonials($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/testimonial', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Pages_model->testimonialCount();
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->saveHistory('Go to Testimonial');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/testimonial', $data);
        $this->load->view('_parts/footer');
    }
    public function add_testimonial($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneTestimonials($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $config['upload_path'] = './attachments/testimonial_images/';
            $config['allowed_types'] = $this->allowed_img_types;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
            }
            $img = $this->upload->data();
            $_POST['image'] = $img['file_name'];
            $this->Pages_model->setTestimonials($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Testimonial is added!');
            $this->saveHistory('Testimonial Added');
             redirect('admin/testimonial');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Testimonial';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_testimonial', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    public function edit_testimonial($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneTestimonials($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $config['upload_path'] = './attachments/testimonial_images/';
            $config['allowed_types'] = $this->allowed_img_types;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
            }
            $img = $this->upload->data();
            $_POST['image'] = $img['file_name'];
            $this->Pages_model->setTestimonials($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Testimonial is added!');
            $this->saveHistory('Testimonial Added');
             redirect('admin/testimonial');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Testimonial';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_testimonial', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    public function regime()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Regime';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Pages_model->deleteTestimonial($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Testimonial is deleted!');
            $this->saveHistory('Delete Testimonial id - ' . $_GET['delete']);
            redirect('admin/testimonial');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Pages_model->regimeCount();
        $data['regime'] = $this->Pages_model->getRegime($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/testimonial', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Pages_model->regimeCount();
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->saveHistory('Go to Regime');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/regime', $data);
        $this->load->view('_parts/footer');
    }
    public function add_regime($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneTestimonials($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $config['upload_path'] = './attachments/testimonial_images/';
            $config['allowed_types'] = $this->allowed_img_types;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
            }
            $img = $this->upload->data();
            $_POST['image'] = $img['file_name'];
            $this->Pages_model->setTestimonials($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Testimonial is added!');
            $this->saveHistory('Testimonial Added');
             redirect('admin/testimonial');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Testimonial';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_testimonial', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
     public function product_list_banner($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View List image';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Pages_model->deletePlistImages($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'product List Banner is deleted!');
            $this->saveHistory('Delete product List Banner id - ' . $_GET['delete']);
            redirect('admin/product_list_banner');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Pages_model->plistImagesCount();
        $data['product_list_banner'] = $this->Pages_model->getPlistImages($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/product_list_banner', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Pages_model->plistImagesCount();
        $data['languages'] = $this->Languages_model->getLanguages();
        
        // echo "<pre>";
        // print_r($data['categoryList']); exit;
        $this->saveHistory('Go to Concern');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/product_list_banner', $data);
        $this->load->view('_parts/footer');
    }
    public function add_product_list_banner($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOnePlistImages($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadProductListImage();
            $this->Pages_model->setPlistImages($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Product List image is added!');
            $this->saveHistory('Product List Banner Added');
             redirect('admin/product_list_banner');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Product List Banner';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['categoryList'] = $this->Pages_model->categoryList();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_product_list_banner', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    public function edit_product_list_banner($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOnePlistImages($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadProductListImage();
            $this->Pages_model->setPlistImages($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Product List Banner is updated!');
            $this->saveHistory('Concern Added');
             redirect('admin/product_list_banner');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Product List Banner';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['categoryList'] = $this->Pages_model->categoryList();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_product_list_banner', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    private function uploadProductListImage()
    {
        $config['upload_path'] = './attachments/product_listing/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

    public function quiz_image($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getQuizImages($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadQuizImage();
            $this->Pages_model->setQuizImages($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Image is updated!');
            $this->saveHistory('Quiz Updated');
             redirect('admin/quiz_image'.'/'.$id);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Quiz Updated';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        // $data['languages'] = $this->Languages_model->getLanguages();
        // $data['categoryList'] = $this->Pages_model->categoryList();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/quiz_image', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    private function uploadQuizImage()
    {
        $config['upload_path'] = './attachments/quiz/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
}
