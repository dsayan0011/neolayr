<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ingredient extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Pages_model', 'Languages_model', 'Categories_model', 'Products_model'));
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
            $this->Pages_model->deleteIngredient($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Ingredient is deleted!');
            $this->saveHistory('Delete ingredient id - ' . $_GET['delete']);
            redirect('admin/ingredient');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Pages_model->ingredientCount();
        $data['ingredient'] = $this->Pages_model->getIngredient($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/ingredient', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->Pages_model->numShopBanner();
        $data['languages'] = $this->Languages_model->getLanguages();
        $_POST = $this->Pages_model->getIngredientBanner(1);
        //print_r( $_POST); exit;
        $this->saveHistory('Go to ingredient');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/ingredient', $data);
        $this->load->view('_parts/footer');
    }
	public function add_ingredient($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneIngredient($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $this->Pages_model->setIngredient($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Ingredient is added!');
            $this->saveHistory('Ingredient Added');
             redirect('admin/ingredient');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Ingredient';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_ingredient', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
	public function edit_ingredient($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneIngredient($id);
        }
        //print_r($_POST); die;
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $this->Pages_model->setIngredient($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Ingredient is added!');
            $this->saveHistory('Ingredient Added');
             redirect('admin/ingredient');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Ingredient';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_ingredient', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }

    public function product_list($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->Pages_model->deleteIngredientDetails($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Ingredient Details is deleted!');
            $this->saveHistory('Delete ingredient Details id - ' . $_GET['delete']);
            redirect('admin/ingredient/product_list');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->Pages_model->ingredientProductCount();
        $data['ingredientDetails'] = $this->Pages_model->getIngredientDetails($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/ingredient/product_list', $rowscount, $this->num_rows, 4);
        $data['num_shop_art'] = $this->Pages_model->numShopBanner();
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['allProduct'] = $this->Products_model->getAllProducts();
        //print_r( $data['ingredientDetails']); exit;
        $this->saveHistory('Go to ingredient');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/ingredient_product_list', $data);
        $this->load->view('_parts/footer');
    }
    public function add_ingredient_product($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneIngredient($id);
            $productBought = (explode(",", $_POST['product_sku']));
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadImage();
            $this->Pages_model->setIngredientProduct($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Ingredient Product is added!');
            $this->saveHistory('Ingredient Product Added');
             redirect('admin/ingredient/product_list');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Ingredient Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['frequentlyBought'] = $frequentlyBought;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['allIngredient'] = $this->Pages_model->getAllIngredients();
        $data['allProduct'] = $this->Products_model->getAllProducts();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_ingredient_product', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    public function edit_ingredient_product($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneIngredientProduct($id);
            $productBought = (explode(",", $_POST['product_sku']));
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadImage();
            $this->Pages_model->setIngredientProduct($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Ingredient Product is added!');
            $this->saveHistory('Ingredient Product Added');
             redirect('admin/ingredient/product_list');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Ingredient Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['productBought'] = $productBought;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['allIngredient'] = $this->Pages_model->getAllIngredients();
        $data['allProduct'] = $this->Products_model->getAllProducts();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_ingredient_product', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
     private function uploadImage()
    {
        $config['upload_path'] = './attachments/ingredientImages/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
    public function ingredient_banner(){
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        $id = 1;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getIngredientBanner($id);
        }
        if (isset($_POST['update'])) {
            // if (isset($_GET['to_lang'])) {
            //     $id = 0;
            // }
            $_POST['ingredient_banner_image'] = $this->uploadBanner();
            $this->Pages_model->setIngredientBanner($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Ingredient Banner is Updated!');
            $this->saveHistory('ingredient Banner is Updated!');
            redirect('admin/ingredient');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Ingredient Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $this->saveHistory('Go to ingredient');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/ingredient', $data);
        $this->load->view('_parts/footer');
    }
     private function uploadBanner()
    {
        $config['upload_path'] = './attachments/ingredient_banner/';
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
