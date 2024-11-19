<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class VendorProfile extends VENDOR_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vendorprofile_model');
    }

    public function index()
    {

        $data = array();
        $head = array();
        $head['title'] = lang('vendor_dashboard');
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
        $data['ordersByMonth'] = $this->Vendorprofile_model->getOrdersByMonth($this->vendor_id);
        $this->load->view('_parts/header', $head);
        $this->load->view('home', $data);
        $this->load->view('_parts/footer');
    }
	public function edit(){
		$data = array();
        $head = array();
        $head['title'] = 'Edit profile';
        $head['description'] = lang('Edit profile');
        $head['keywords'] = '';
		if (isset($_POST['submit'])) {
			
			$count_emails = $this->Vendorprofile_model->countVendorUsersWithEmail($_POST['email'],$this->vendor_id);
			if ($count_emails > 0) {
				$this->session->set_flashdata('result_add', lang('user_email_is_taken'));
			}else{
				
				$this->session->set_flashdata('result_add', 'Profile updated');
				$this->Vendorprofile_model->setVendorUser($_POST);
			}
            redirect('vendor/edit');
        }
        $vendor_details = $this->Vendorprofile_model->getVendorUsers($this->vendor_id);
		$data['vendor_details'] = $vendor_details;
        $this->load->view('_parts/header', $head);
        $this->load->view('edit_profile', $data);
        $this->load->view('_parts/footer');
	}

    public function logout()
    {
        unset($_SESSION['logged_vendor']);
		unset($_SESSION['level_id']);
		unset($_SESSION['adminPermission']);
		
        delete_cookie('logged_vendor');
        redirect(LANG_URL . '/vendor/login');
    }

}
