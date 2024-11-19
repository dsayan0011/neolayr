<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends ADMIN_Controller
{

    public function index()
    {
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Login';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->load->view('_parts/header', $head);
        if ($this->session->userdata('logged_in')) {
            redirect('admin/home');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run($this)) {
                $result = $this->Home_admin_model->loginCheck($_POST);
                if (!empty($result)) {
					$permission_data = $this->Home_admin_model->getUserPermission($result["level"]);
					if($permission_data["admin_access"] == "yes")
					{
						 $_SESSION['last_login'] = $result['last_login'];
						 $this->session->set_userdata('logged_in', $result['username']);
						 $this->session->set_userdata('level_id', $result['level']);
						 $this->session->set_userdata('adminPermission', $permission_data);
						 $this->saveHistory('User ' . $result['username'] . ' logged in');
						 redirect('admin/home');
					}else{
						 $this->saveHistory('Cant login with - User: ' . $_POST['username'] . ' and Pass: ' . $_POST['username']);
						$this->session->set_flashdata('err_login', 'Permission denied.');
						redirect('admin');
					}
                   
                } else {
                    $this->saveHistory('Cant login with - User: ' . $_POST['username'] . ' and Pass: ' . $_POST['username']);
                    $this->session->set_flashdata('err_login', 'Wrong username or password!');
                    redirect('admin');
                }
            }
            $this->load->view('home/login');
        }
        $this->load->view('_parts/footer');
    }

}
