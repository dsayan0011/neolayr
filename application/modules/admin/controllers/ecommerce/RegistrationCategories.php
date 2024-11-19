<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class RegistrationCategories extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Categories_model', 'Languages_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Registration Categories';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['categories'] = $this->Categories_model->getRegistrationCategories($this->num_rows, $page);
        $data['languages'] = $this->Languages_model->getLanguages();
        $rowscount = $this->Categories_model->registrationcategoriesCount();
        $data['links_pagination'] = pagination('admin/registration-categories', $rowscount, $this->num_rows, 3);
        if (isset($_GET['delete'])) {
            $this->saveHistory('Delete a shop categorie');
            $this->Categories_model->deleteRegistrationCategorie($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Registration category is deleted!');
            redirect('admin/registration-categories');
        }
		if (isset($_POST['submit'])) {
			if($_POST['edit']!="0"){
				$this->Categories_model->updateCategory($_POST['edit']);
           		$this->session->set_flashdata('result_add', 'Registration category updated!');
			}else{
				 $this->Categories_model->setRegistrationCategorie($_POST);
           		 $this->session->set_flashdata('result_add', 'Registration category is added!');
			}
            redirect('admin/registration-categories');
        }
		if (isset($_GET['edit'])) {
            $_POST = $this->Categories_model->getCategoryDetails($_GET['edit']);
        }
        
       
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/registraioncategories', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to registration categories');
    }

    /*
     * Called from ajax
     */

    public function editShopCategorie()
    {
        $this->login_check();
        $result = $this->Categories_model->editShopCategorie($_POST);
        $this->saveHistory('Edit shop categorie to ' . $_POST['name']);
    }

    /*
     * Called from ajax
     */

    public function changePosition()
    {
        $this->login_check();
        $result = $this->Categories_model->editShopCategoriePosition($_POST);
        $this->saveHistory('Edit shop categorie position ' . $_POST['name']);
    }

}
