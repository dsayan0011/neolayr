<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Userlevel extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_users_model');
    }

    public function index()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $this->Admin_users_model->deleteAdminUserLevel($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'User Level is deleted!');
            redirect('admin/userlevel');
        }
        if (isset($_POST['add_new_level'])) {
			if($_POST['edit']!=""){
				$this->Admin_users_model->updateLevelDetails($_POST['edit']);
				$this->Admin_users_model->updateLevelPermission($_POST['edit']);
			}else{
				$level_id = $this->Admin_users_model->addMemberLevel();
				$this->Admin_users_model->addLevelPermission($level_id);
			}
			redirect("admin/userlevel");
        }
		if (isset($_GET['edit'])) {
            $_POST = $this->Admin_users_model->getLevelDetails($_GET['edit']);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Admin Users Level';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['users'] = $this->Admin_users_model->getAdminUsersLevel();
		$data["memberPermission"] = $this->Admin_users_model->getAllMemberpermission();
		$data["permissionType"] = $this->Admin_users_model->getAllMemberpermissionType();
		

        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/adminUsersLevel', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Users');
    }

}
