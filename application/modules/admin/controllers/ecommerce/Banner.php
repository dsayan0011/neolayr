<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Banner extends ADMIN_Controller
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
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Pages_model->deleteBanner($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Banner is deleted!');
            $this->saveHistory('Delete Banner id - ' . $_GET['delete']);
            redirect('admin/banner');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Pages_model->bannerCount();
        $data['banner'] = $this->Pages_model->getBanner($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/banner', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Pages_model->numShopBanner();
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->saveHistory('Go to banner');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/banner', $data);
        $this->load->view('_parts/footer');
    }
	public function add_banner($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOnebanner($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            if($_POST['link_for'] == 'pdp'){
                $_POST['banner_link_plp'] = '';
            }
            if($_POST['link_for'] == 'plp'){
                $_POST['banner_link_pdp'] = '';
            }
            if($_POST['link_for'] == 'ingredient'){
                $_POST['banner_link_plp'] = '';
                $_POST['banner_link_pdp'] = '';
            }
            $_POST['image'] = $this->uploadImage();
            $_POST['banner_image_mob'] = $this->uploadMobImage();
            $this->Pages_model->setBanner($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Banner is added!');
            $this->saveHistory('Banner Added');
             redirect('admin/banner');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Banner';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_banner', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
	public function edit_banner($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOnebanner($id);
            //print_r($_POST); die();
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            if($_POST['link_for'] == 'pdp'){
                $_POST['banner_link_plp'] = '';
            }
            if($_POST['link_for'] == 'plp'){
                $_POST['banner_link_pdp'] = '';
            }
            if($_POST['link_for'] == 'ingredient'){
                $_POST['banner_link_plp'] = '';
                $_POST['banner_link_pdp'] = '';
            }
            $_POST['image'] = $this->uploadImage();
            $_POST['banner_image_mob'] = $this->uploadMobImage();
            $this->Pages_model->setBanner($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Banner is Updated!');
            $this->saveHistory('Banner Added');
             redirect('admin/banner');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Banner';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_banner', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    private function uploadImage()
    {
        $config['upload_path'] = './attachments/banner_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
     private function uploadMobImage()
    {
        $config['upload_path'] = './attachments/banner_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('mobuserfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }


}
