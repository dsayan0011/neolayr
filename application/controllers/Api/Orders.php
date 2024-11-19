<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Orders extends REST_Controller
{

    private $allowed_img_types;

    function __construct()
    {
        parent::__construct();
        $this->methods['all_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['one_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['set_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['productDel_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model(array('Api_model', 'admin/Products_model'));
        $this->allowed_img_types = $this->config->item('allowed_img_types');
    }

    public function set_post()
    {
         $postdata = file_get_contents("php://input");
		 $data = json_decode($postdata);
		 file_put_contents('./order_'.time().'.txt', $postdata);
         $message = [
                'message' => 'Order Status Updated'
            ];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

}
