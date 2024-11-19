<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home_banner extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Languages_model');
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Home Banner';
        $head['description'] = '!';
        $head['keywords'] = '';

        $this->postChecker();

        $data['main_banner_section1'] = $this->Home_admin_model->getValueStore('main_banner_section1');
		$data['main_banner_section1_link'] = $this->Home_admin_model->getValueStore('main_banner_section1_link');
		$data['main_banner_section2'] = $this->Home_admin_model->getValueStore('main_banner_section2');
		$data['main_banner_section2_link'] = $this->Home_admin_model->getValueStore('main_banner_section2_link');
		$data['main_banner_section3'] = $this->Home_admin_model->getValueStore('main_banner_section3');
		$data['main_banner_section3_link'] = $this->Home_admin_model->getValueStore('main_banner_section3_link');
		$data['side_banner'] = $this->Home_admin_model->getValueStore('side_banner');
		$data['side_banner_link'] = $this->Home_admin_model->getValueStore('side_banner_link');
		$data['footer_banner_section1'] = $this->Home_admin_model->getValueStore('footer_banner_section1');
		$data['footer_banner_section1_link'] = $this->Home_admin_model->getValueStore('footer_banner_section1_link');
		$data['footer_banner_section2'] = $this->Home_admin_model->getValueStore('footer_banner_section2');
		$data['footer_banner_section2_link'] = $this->Home_admin_model->getValueStore('footer_banner_section2_link');
		$data['footer_banner_section3'] = $this->Home_admin_model->getValueStore('footer_banner_section3');
		$data['footer_banner_section3_link'] = $this->Home_admin_model->getValueStore('footer_banner_section3_link');
		
        $this->load->view('_parts/header', $head);
        $this->load->view('settings/home_banner', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Settings Page');
    }

    private function postChecker()
    {
        if (isset($_POST['main_banner_section1_update'])) {
			if(!empty($_FILES['main_banner_section1']['name'])){
				$config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'banner_images' . DIRECTORY_SEPARATOR;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width'] = 390;
				$config['max_height'] = 143;
	
				$this->load->library('upload', $config);
	
				if (!$this->upload->do_upload('main_banner_section1')) {
					$this->session->set_flashdata('banner_update_image', $this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$newImage = $data['upload_data']['file_name'];
					$this->Home_admin_model->setValueStore('main_banner_section1', $newImage);
				}
			}
			$this->session->set_flashdata('banner_update', 'New Banner is set!');
			$this->Home_admin_model->setValueStore('main_banner_section1_link', $_POST['main_banner_section1_link']);
            redirect('admin/home_banner');
        }
		if (isset($_POST['main_banner_section2_update'])) {
			if(!empty($_FILES['main_banner_section2']['name'])){ 
				$config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'banner_images' . DIRECTORY_SEPARATOR;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width'] = 390;
				$config['max_height'] = 143;
	
				$this->load->library('upload', $config);
	
				if (!$this->upload->do_upload('main_banner_section2')) {
					$this->session->set_flashdata('banner_update_image', $this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$newImage = $data['upload_data']['file_name'];
					$this->Home_admin_model->setValueStore('main_banner_section2', $newImage);
				}
			}
			$this->session->set_flashdata('banner_update', 'New Banner is set!');
			$this->Home_admin_model->setValueStore('main_banner_section2_link', $_POST['main_banner_section2_link']);
            redirect('admin/home_banner');
        }
		
       	if (isset($_POST['main_banner_section3_update'])) {
			if(!empty($_FILES['main_banner_section3']['name'])){ 
				$config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'banner_images' . DIRECTORY_SEPARATOR;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width'] = 390;
				$config['max_height'] = 143;
	
				$this->load->library('upload', $config);
	
				if (!$this->upload->do_upload('main_banner_section3')) {
					$this->session->set_flashdata('banner_update_image', $this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$newImage = $data['upload_data']['file_name'];
					$this->Home_admin_model->setValueStore('main_banner_section3', $newImage);
				}
			}
			$this->session->set_flashdata('banner_update', 'New Banner is set!');
			$this->Home_admin_model->setValueStore('main_banner_section3_link', $_POST['main_banner_section3_link']);
            redirect('admin/home_banner');
        }
		if (isset($_POST['side_banner_update'])) {
			if(!empty($_FILES['side_banner']['name'])){ 
				$config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'banner_images' . DIRECTORY_SEPARATOR;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width'] = 220;
				$config['max_height'] = 700;
	
				$this->load->library('upload', $config);
	
				if (!$this->upload->do_upload('side_banner')) {
					$this->session->set_flashdata('banner_update_image', $this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$newImage = $data['upload_data']['file_name'];
					$this->Home_admin_model->setValueStore('side_banner', $newImage);
				}
			}
			$this->session->set_flashdata('banner_update', 'New Banner is set!');
			$this->Home_admin_model->setValueStore('side_banner_link', $_POST['side_banner_link']);
            redirect('admin/home_banner');
        }
		if (isset($_POST['footer_banner_section1_update'])) {
			if(!empty($_FILES['footer_banner_section1']['name'])){ 
				$config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'banner_images' . DIRECTORY_SEPARATOR;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width'] = 675;
				$config['max_height'] = 260;
	
				$this->load->library('upload', $config);
	
				if (!$this->upload->do_upload('footer_banner_section1')) {
					$this->session->set_flashdata('banner_update_image', $this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$newImage = $data['upload_data']['file_name'];
					$this->Home_admin_model->setValueStore('footer_banner_section1', $newImage);
				}
			}
			$this->session->set_flashdata('banner_update', 'New Banner is set!');
			$this->Home_admin_model->setValueStore('footer_banner_section1_link', $_POST['footer_banner_section1_link']);
            redirect('admin/home_banner');
        }
		if (isset($_POST['footer_banner_section2_update'])) {
			if(!empty($_FILES['footer_banner_section2']['name'])){ 
				$config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'banner_images' . DIRECTORY_SEPARATOR;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width'] = 675;
				$config['max_height'] = 260;
	
				$this->load->library('upload', $config);
	
				if (!$this->upload->do_upload('footer_banner_section2')) {
					$this->session->set_flashdata('banner_update_image', $this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$newImage = $data['upload_data']['file_name'];
					$this->Home_admin_model->setValueStore('footer_banner_section2', $newImage);
				}
			}
			$this->session->set_flashdata('banner_update', 'New Banner is set!');
			$this->Home_admin_model->setValueStore('footer_banner_section2_link', $_POST['footer_banner_section2_link']);
            redirect('admin/home_banner');
        }
		if (isset($_POST['footer_banner_section3_update'])) {
			if(!empty($_FILES['footer_banner_section3']['name'])){ 
				$config['upload_path'] = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'banner_images' . DIRECTORY_SEPARATOR;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width'] = 560;
				$config['max_height'] = 280;
	
				$this->load->library('upload', $config);
	
				if (!$this->upload->do_upload('footer_banner_section3')) {
					$this->session->set_flashdata('banner_update_image', $this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
					$newImage = $data['upload_data']['file_name'];
					$this->Home_admin_model->setValueStore('footer_banner_section3', $newImage);
				}
			}
			$this->session->set_flashdata('banner_update', 'New Banner is set!');
			$this->Home_admin_model->setValueStore('footer_banner_section3_link', $_POST['footer_banner_section3_link']);
            redirect('admin/home_banner');
        }
    }


}
