<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('SendMail');
        $this->load->model(array('Users_model', 'Home_admin_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Users';
        $head['description'] = '!';
        $head['keywords'] = '';

        $order_by = null;
        if (isset($_GET['order_by'])) {
            $order_by = $_GET['order_by'];
        }
        $rowscount = $this->Users_model->userCount();
        $data['users'] = $this->Users_model->users($this->num_rows, $page, $order_by);
        $data['links_pagination'] = pagination('admin/users', $rowscount, $this->num_rows, 3);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/users', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to users page');
        }
    }

    public function changeUsersStatus()
    {
        $this->login_check();

        $result = false;
        $result = $this->Users_model->changeUserStatus($_POST['the_id'], $_POST['to_status']);
		echo 1;
        $this->saveHistory('Change status of User Id ' . $_POST['the_id'] . ' to status ' . $_POST['to_status']);
    }
    public function doctor_consultation($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Users';
        $head['description'] = '!';
        $head['keywords'] = '';
        $rowscount = $this->Users_model->doctorConsultationCount();
        $data['doctorConsultation'] = $this->Users_model->doctorConsultation($this->num_rows, $page, $order_by);
        $data['links_pagination'] = pagination('admin/doctor_consultation', $rowscount, $this->num_rows, 3);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/doctor_consultation', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to users page');
        }
    }
    public function aboutus($id = 0){
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getAboutUs($id);
        }
        if (isset($_POST['update'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['banner_image'] = $this->uploadBannerImage();
            $_POST['origin_image'] = $this->uploadOriginImage();
            $_POST['expertise_image'] = $this->uploadExpertiseImage();
            $_POST['dermatologically_image'] = $this->uploaddermatologicallyImage();
            $this->Pages_model->setAboutUs($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Aboutus is update!');
            $this->saveHistory('Aboutus update');
             redirect('admin/aboutus'.'/'.$id);
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About us';
        $head['description'] = '!';
        $head['keywords'] = '';
        $rowscount = $this->Users_model->doctorConsultationCount();
        $data['doctorConsultation'] = $this->Users_model->doctorConsultation($this->num_rows, $page, $order_by);
        $data['links_pagination'] = pagination('admin/users', $rowscount, $this->num_rows, 3);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/aboutus', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to users page');
        }
    }
    private function uploadBannerImage()
    {
        $config['upload_path'] = './attachments/aboutus/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
    private function uploadOriginImage()
    {
        $config['upload_path'] = './attachments/aboutus/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('origin_image')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
    private function uploadExpertiseImage()
    {
        $config['upload_path'] = './attachments/aboutus/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('expertise_image')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
    private function uploaddermatologicallyImage()
    {
        $config['upload_path'] = './attachments/aboutus/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('dermatologically_image')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
    public function abandoned_cart($page = 0){
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Users';
        $head['description'] = '!';
        $head['keywords'] = '';
        
        $rowscount = $this->Users_model->cartCount();
        $data['abandoned_cart'] = $this->Users_model->cart($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/abandoned_cart', $rowscount, $this->num_rows, 3);
        // echo "<pre>";
        // print_r($data['cart']);
        // exit;

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/abandoned_cart', $data);
        $this->load->view('_parts/footer');
        
    }
    public function sendPush(){
        $result = $this->Users_model->pushData();
        $massageID = 160333;
        foreach ($result as  $value) {
            $user_details = $this->Users_model->getUserDetails($value['user_id']);
            $this->abandonedSMS($massageID,$user_details['phone']);
            //$result = $this->Users_model->updatePushData($value['cartID']);

        }
        redirect('admin/abandoned_cart');
    }
    public function contact_us($page = 0){
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Users';
        $head['description'] = '!';
        $head['keywords'] = '';
        
        $rowscount = $this->Users_model->contactUsCount();
        $data['contacts'] = $this->Users_model->contacts($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/contact_us', $rowscount, $this->num_rows, 3);
        // echo "<pre>";
        // print_r($data['cart']);
        // exit;

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/contact_us', $data);
        $this->load->view('_parts/footer');
        
    }
    public function aboutusbanner($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Users';
        $head['description'] = '!';
        $head['keywords'] = '';
        if (isset($_GET['delete'])) {
            $this->Pages_model->deleteAboutUsImages($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Banner is deleted!');
            $this->saveHistory('Delete Banner id - ' . $_GET['delete']);
            redirect('admin/aboutusbanner');
        }
        $rowscount = $this->Users_model->aboutUsBannerCount();
        $data['aboutUsBanner'] = $this->Users_model->aboutUsBanner($this->num_rows, $page, $order_by);
        $data['links_pagination'] = pagination('admin/aboutusbanner', $rowscount, $this->num_rows, 3);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/aboutusbanner', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to users page');
        }
    }
    public function add_aboutusbanner($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneAboutUsBannerImages($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadAboutUsImage();
            $_POST['mob_image'] = $this->uploadAboutUsImageMob();
            $this->Pages_model->setAboutUsBannerImages($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Banner image is added!');
            $this->saveHistory('Banner Added');
             redirect('admin/aboutusbanner');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Banner';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_aboutusbanner', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    public function edit_aboutusbanner($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOneAboutUsBannerImages($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadAboutUsImage();
            $_POST['mob_image'] = $this->uploadAboutUsImageMob();
            $this->Pages_model->setAboutUsBannerImages($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Banner is updated!');
            $this->saveHistory('Banner Added');
             redirect('admin/aboutusbanner');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us Banner';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_aboutusbanner', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
     private function uploadAboutUsImage()
    {
        $config['upload_path'] = './attachments/aboutUsBanner/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
     private function uploadAboutUsImageMob()
    {
        $config['upload_path'] = './attachments/aboutUsBanner/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);        
        if (!$this->upload->do_upload('mobImage')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
    public function abandonedSMS($massageID,$phone)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.fast2sms.com/dev/bulkV2?route=dlt&sender_id=NLRPRO&message='.$massageID.'&numbers='.$phone,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'authorization: tXqICbFZAnH8LKBsydoe7vE64lS5u2ihwgPVGrO0xJU1N9kDmT59sGSt7qX3guJTIDoMvaW8QRpjiUHP',
            'Cookie: FVt68hhNJgSvPOBgn0NQn1wbYUdnRoBTTr1A0bTl=eyJpdiI6InJVMWdKQjhTWEZ6V285UVoxMFErNkE9PSIsInZhbHVlIjoiZXo3Y2JGSjJjcUVGM0h4djZ5bWtLYlc4YnVQNEVtVzBjZldNZEhmdmtwZ25NK1ErOVlDSXFRU2NIQ3Q4MjRcL0lyalF6YTYrdXJjUTlvZGtBMXUzVituQ1piVEVFUENDZzgycFo2TVpDZUJaMEViQXI5NEhzdGJ2Mm93ZGJaeDluYTAyUGNqZTFMQzJYUDBJaHpPWGN3aDAwaHhHTFpPaHExemdNaUx5NkVcL2dXM0dRdUR4SzFkNitpSm83MzVLZnl1UitmZmhNb21PVlNCZ1l6ak1sNGg1RWt5TlBoRmlyTVRZb0R1T0hDWU9ZSXk2MlJBWlJJdnhUSWRhSUFnOEozM1pTemNINFNsRkptMDROYVcrcXlwaUpxbXJkVlo5OHBkeGJodUpiVWt6d1M2UDg2TUp4V2hQangwdXpNUkJGV0kxd2JNRysrNHJua3A1YTBsNDhmZkRuR2dRNDc2dnhlcDZCdm9mYkU3MEtBSkN1bXduYVdhTkVodmxmZmJYcjlubytQaUJNZmVXK3hyMjF1VEg5VEN3ZVNieUlpSFQ5MmVpR0tnenV6K05PblFPaU1XcnE5TDM4elppSFpDV2kwdVZ6U2xzMmNTOU55YkdmeitabGs4MThvNFpwSHZzZE9DVlhGSG85RlN2ektqc3hDK3Y2SGtkVVRrdjA2OTU0YW00YlJkYmdibFN0dG4yYUc4T3Q5UUt3Yjc0dWVOcFlGZDVMQ09KR2xoeGc9IiwibWFjIjoiZDIxMGU1ZjM5M2QzMWFiNjZmMDdmM2JmN2EwYzhmYzc5NTRmZTM2NGUyM2ZlZDRhMDdiMGI2NGRmNDQwZTYyNCJ9; XSRF-TOKEN=eyJpdiI6Im1cL3E5enh3THE1YjBWaFJjMHk4WHh3PT0iLCJ2YWx1ZSI6ImZpdHNcL0t4SnhObERVbVYxcXZlUHV0UU9jWDN3NE1BcG9MMjVjQXduOU1IeXBLaXg4bHRMZHJJQm55c3JEK2l6VUZSTmhJYzE0eFkzVnF4XC9KWm5nUWc9PSIsIm1hYyI6IjdkMmUyZjQ3YWQwY2RjYjEzODQ5NTlkM2ZiYzc0MTVlOWQxOTQyZDA3OTgzMDcwM2QxZjBlYWE1ZDdlNWYzZjcifQ%3D%3D; laravel_session=eyJpdiI6IjhZNTkyeUJPRnZRYmpiazh0Vlp3MVE9PSIsInZhbHVlIjoiVEJlamtzeDQ4eVpHK0FMQjVnbWxIM3lXUStTcXdWRnU0TUg3emtDYitsc0RzMDhJaFBqV3p6RlBzeUJZNENuT1liZXkyT2ZpZWM1S294ZmhkUHgxNGc9PSIsIm1hYyI6ImFjY2I2ZTI0ZTlhZDMxOWQ4MDE5MThjZGExMTNhZDE5NDMxNDU5NzUzOTEyMjQ0Mzk0MzI1MjRmZjU1NmZlNTgifQ%3D%3D'
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          //echo "cURL Error #:" . $err;
        } else {
          //echo $response;
        }
        //echo $response;

    }
}
