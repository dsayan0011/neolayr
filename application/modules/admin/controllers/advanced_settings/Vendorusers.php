<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendorusers extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vendor_model');
		$this->load->model('Public_model');
		$this->load->model('Products_model');
    }

    public function index()
    {
        $this->login_check();
        if (isset($_GET['delete'])) {
            $this->Vendor_model->deleteVendorUser($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Vendor is deleted!');
            redirect('admin/vendors');
        }
       /* if (isset($_GET['edit']) && !isset($_POST['username'])) {
            $_POST = $this->Vendor_model->getVendorUsers($_GET['edit']);
			$data["thana_list"] = $this->Public_model->getThanalist($_POST['state']);
        }*/
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Manage Vendors';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['users'] = $this->Vendor_model->getVendorUsers();
		$data['users_level'] = $this->Vendor_model->getAdminUsersLevel();
		$data['stateList'] = $this->Vendor_model->getStateList();
       	

        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/vendor', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Vendor');
    }
	public function editvendor($vendor_id){
		$this->login_check();
		$data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Vendors';
        $head['description'] = '!';
        $head['keywords'] = '';
		$vendor_details = $this->Vendor_model->getVendorUsers($vendor_id);
		if (isset($_POST['submit'])) {
			$count_emails = $this->Vendor_model->countVendorUsersWithEmail($_POST['email'],$_POST['edit']);
			if ($count_emails > 0) {
				$this->session->set_flashdata('result_add', lang('user_email_is_taken'));
			}else{
			    
			    $this->Vendor_model->setVendorUser($_POST);
			    	
				//Edit Warehouse in Shiprocket system
				
				// $getCityNameByID = $this->Vendor_model->getCityNameByID($_POST['city']);
				// $getStateNameByID = $this->Vendor_model->getStateNameByID($_POST['state']);
				// $headers = array(
				// 		"Content-Type: application/json",
				// 		"Authorization: Bearer ".shiprocket_auth_key
				// 	  );
				// $post = [
				// 		  "pickup_location" => $_POST['nickname'],
				// 		  "name" => $getCityNameByID['name'],
				// 		  "email" => $_POST['email'],
				// 		  "phone" => $_POST['phone'],
				// 		  "address" => $_POST['address_line1'],
				// 		  "address_2" => "",
				// 		  "city" => $getCityNameByID['name'],
				// 		  "state" => $getStateNameByID['state_name'],
				// 		  "country" => 'India',
				// 		  "pin_code" =>$_POST['pincode']
				// 	];
				// $warehouse_creation_data = json_decode($this->cUrlGetData(shiprocket_api_url.'settings/company/addpickup', json_encode($post), $headers));
			 //   //print_r($warehouse_creation_data);
			 //   //die();
				// if(!$warehouse_creation_data->success){
				// 	if($warehouse_creation_data->status_code == '422'){
				// 		$this->Vendor_model->setVendorUser($_POST);
				// 	}else{
				// 		$this->session->set_flashdata('result_add', $warehouse_creation_data);
				// 	}
				// }else{
				// 	$this->Vendor_model->setVendorUser($_POST);
				// }
			}
            redirect('admin/vendors');
        }
		
		$data['stateList'] = $this->Vendor_model->getStateList('','101');
       	$data['users_level'] = $this->Vendor_model->getAdminUsersLevel();
		$data['vendor_details'] = $vendor_details;
		$data["thana_list"] = $this->Public_model->getThanalist($vendor_details['state']);
		$this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/edit_vendor', $data);
        $this->load->view('_parts/footer');
	}
	public function syncVendor($vendor_id){
		$this->login_check();
		$data = array();
        $head = array();
        $vendor_details = $this->Vendor_model->getVendorUsers($vendor_id);
		$getAllVendorProduct =  $this->Products_model->getVendorProducts($vendor_id);
		foreach($getAllVendorProduct as $vendorProduct){
			$this->Products_model->updateProductlocation($vendorProduct['id'],$vendor_details['city_name'],$vendor_details['state_name']);
		}
		$this->session->set_flashdata('result_add', "Product lccation updated");
		redirect('admin/vendors');
		
	}
	public function addvendor(){
		$this->login_check();
		$data = array();
        $head = array();
        $head['title'] = 'Administration - Add Vendors';
        $head['description'] = '!';
        $head['keywords'] = '';
		if (isset($_POST['submit'])) {
		        /*$getCityNameByID = $this->Vendor_model->getCityNameByID($_POST['city']);
				$getStateNameByID = $this->Vendor_model->getStateNameByID($_POST['state']);
				$shiprocket_auth_key = $this->Home_admin_model->getValueStore('shiprocket_api_key');
				$headers = array(
						"Content-Type: application/json",
						"Authorization: Bearer ".$shiprocket_auth_key
					  );
				$post = [
						  "pickup_location" => $_POST['nickname'],
						  "name" => $_POST['name'],
						  "email" => $_POST['email'],
						  "phone" => $_POST['phone'],
						  "address" => $_POST['address_line1'],
						  "address_2" =>$_POST['address'],
						  "city" => $getCityNameByID['name'],
						  "state" => $getStateNameByID['state_name'],
						  "country" => 'India',
						  "pin_code" =>$_POST['pincode']
					];
				$warehouse_creation_data = json_decode($this->cUrlGetData(shiprocket_api_url.'settings/company/addpickup', json_encode($post), $headers));*/
			    //print_r($warehouse_creation_data);
			    //die();
			    
			$this->Vendor_model->setVendorUser($_POST);
            redirect('admin/vendors');
        }
		$data['stateList'] = $this->Vendor_model->getStateList('','101');
       	$data['users_level'] = $this->Vendor_model->getAdminUsersLevel();
		$this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/edit_vendor', $data);
        $this->load->view('_parts/footer');
	}
	public function getThanaList(){
		$thana_list = $this->Public_model->getThanalist($_POST['district']);
		$str = "";
		foreach($thana_list as $thana){
			$str .= "<option value='".$thana['id']."'>".$thana['name']."</option>";
		}
		echo $str;
	}
	function cUrlGetData($url, $post_fields = null, $headers = null) {
		$ch = curl_init();
		$timeout = 500;
		curl_setopt($ch, CURLOPT_URL, $url);
		if ($post_fields && !empty($post_fields)) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		}
		if ($headers && !empty($headers)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $data;
	}

}
