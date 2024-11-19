<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pickuplocation extends ADMIN_Controller
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
            $this->Public_model->deleteLocation($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Location is deleted!');
            redirect('admin/pickuplocation');
        }
       /* if (isset($_GET['edit']) && !isset($_POST['username'])) {
            $_POST = $this->Vendor_model->getVendorUsers($_GET['edit']);
			$data["thana_list"] = $this->Public_model->getThanalist($_POST['state']);
        }*/
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Manage Pickup Location';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['locations'] = $this->Public_model->getPickupLocation();
		//$data['stateList'] = $this->Vendor_model->getStateList();
       	

        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/pickuplocation', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Vendor');
    }
	public function editlocation($location_id){
		$this->login_check();
		$data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Location';
        $head['description'] = '!';
        $head['keywords'] = '';
		$vendor_details = $this->Public_model->getPickupLocation($location_id);
		if (isset($_POST['submit'])) {
			$this->Public_model->setPickupLocation($_POST);
            redirect('admin/pickuplocation');
        }
		
		$data['stateList'] = $this->Vendor_model->getStateList('','101');
       	$data['users_level'] = $this->Vendor_model->getAdminUsersLevel();
		$data['vendor_details'] = $vendor_details;
		$data["thana_list"] = $this->Public_model->getThanalist($vendor_details['state']);
		$this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/edit_location', $data);
        $this->load->view('_parts/footer');
	}
	
	public function addlocation(){
		$this->login_check();
		$data = array();
        $head = array();
        $head['title'] = 'Administration - Add Location';
        $head['description'] = '!';
        $head['keywords'] = '';
		if (isset($_POST['submit'])) {
		        $getCityNameByID = $this->Vendor_model->getCityNameByID($_POST['city']);
				$getStateNameByID = $this->Vendor_model->getStateNameByID($_POST['state']);
				$shiprocket_auth_key = $this->Home_admin_model->getValueStore('shiprocket_api_key');
				$headers = array(
						"Content-Type: application/json",
						"Authorization: Bearer ".$shiprocket_auth_key
					  );
				$post = [
						  "pickup_location" => $_POST['name'],
						  "name" => $_POST['warehouse_name'],
						  "email" => $_POST['email'],
						  "phone" => $_POST['phone'],
						  "address" => $_POST['address_line1'],
						  "address_2" =>$_POST['address'],
						  "city" => $getCityNameByID['name'],
						  "state" => $getStateNameByID['state_name'],
						  "country" => 'India',
						  "pin_code" =>$_POST['pincode']
					];
				$warehouse_creation_data = json_decode($this->cUrlGetData(shiprocket_api_url.'settings/company/addpickup', json_encode($post), $headers));
			    
			    
				if($warehouse_creation_data->success){
				    $this->Public_model->setPickupLocation($_POST);
				}else{
						$this->session->set_flashdata('result_add', json_encode($warehouse_creation_data));
				}
            redirect('admin/pickuplocation');
        }
		$data['stateList'] = $this->Vendor_model->getStateList('','101');
		$this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/edit_location', $data);
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
