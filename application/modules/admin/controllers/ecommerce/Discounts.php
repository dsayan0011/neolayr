<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Discounts extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Discounts_model', 'Home_admin_model', 'Vendor_model', 'Products_model', 'Languages_model', 'Public_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Discounts';
        $head['description'] = '!';
        $head['keywords'] = '';
        if (isset($_POST['code'])) {
            $this->setDiscountCode();
        }
        if ($this->session->flashdata('post')) {
            $_POST = $this->session->flashdata('post');
        }
        if (isset($_GET['edit'])) {
            $_POST = $this->Discounts_model->getDiscountCodeInfo($_GET['edit']);
            if (empty($_POST)) {
                redirect('admin/discounts');
            }
            $_POST['valid_from_date'] = date('d.m.Y', $_POST['valid_from_date']);
            $_POST['valid_to_date'] = date('d.m.Y', $_POST['valid_to_date']);
            $_POST['update'] = $_POST['id'];
        }
        if (isset($_GET['tostatus']) && isset($_GET['codeid'])) {
            $this->Discounts_model->changeCodeDiscountStatus($_GET['codeid'], $_GET['tostatus']);
            redirect('admin/discounts');
        }
        if (isset($_POST['codeDiscounts'])) {
            $this->Home_admin_model->setValueStore('codeDiscounts', $_POST['codeDiscounts']);
            redirect('admin/discounts');
        }
        $data['codeDiscounts'] = $this->Home_admin_model->getValueStore('codeDiscounts');
        $rowscount = $this->Discounts_model->discountCodesCount();
        $data['discountCodes'] = $this->Discounts_model->getDiscountCodes($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/discounts', $rowscount, $this->num_rows, 3);
		$data['vendor_list'] = $this->Vendor_model->getVendorUsers();
		$data['offerType'] = $this->Vendor_model->getOfferType();
        $data['getProduct'] = $this->Home_admin_model->getProduct();
        $data['getCategories'] = $this->Discounts_model->getCategories();
        // foreach ($getCategories as $value) {
        //     $result = $this->Discounts_model->getSelectedCategories($value['id']);
        // }
        // echo "<pre>";
        // print_r($data['getCategories']); die();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/discounts', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to discounts page');
        }
    }

    private function setDiscountCode()
    {
        $isValid = $this->validateCode();
        if ($isValid === true) {
            if ($_POST['update'] == 0) {
               //print_r($_POST); exit;
                $this->Discounts_model->setDiscountCode($_POST);
            } else {
                $this->Discounts_model->updateDiscountCode($_POST);
            }
            $this->session->set_flashdata('success', 'Changes are saved');
        } else {
            $this->session->set_flashdata('error', $isValid);
            $this->session->set_flashdata('post', $_POST);
        }
        redirect('admin/discounts');
    }

    private function validateCode()
    {
        $errors = array();
        if ($_POST['type'] != 'percent' && $_POST['type'] != 'float') {
            $errors[] = 'Type of discount is not valid!';
        }
        if ((float) $_POST['amount'] == 0) {
            $errors[] = 'Discount amount is 0!';
        }
        if (mb_strlen(trim($_POST['code'])) < 3) {
            $errors[] = 'Discount code is lower than 3 symbols!';
        } else {
            $isFree = $this->Discounts_model->discountCodeTakenCheck($_POST);
            if ($isFree === false) {
                $errors[] = 'Discount code taken!';
            }
        }
        if (strtotime($_POST['valid_from_date']) === false) {
            $errors[] = 'From date is invalid!';
        }
        if (strtotime($_POST['valid_to_date']) === false) {
            $errors[] = 'To date is invalid!';
        }
        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function rating($page = 0){
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Rating';
        $head['description'] = '!';
        $head['keywords'] = '';
        if (isset($_POST['code'])) {
            $this->setDiscountCode();
        }
        if ($this->session->flashdata('post')) {
            $_POST = $this->session->flashdata('post');
        }
        
        if (isset($_GET['tostatus']) && isset($_GET['codeid'])) {
            $this->Discounts_model->changeRatingStatus($_GET['codeid'], $_GET['tostatus']);
            redirect('admin/rating');
        }
        if (isset($_POST['showRating'])) {
            $this->Home_admin_model->setValueStore('showRating', $_POST['showRating']);
            redirect('admin/rating');
        }
        if (isset($_GET['delete'])) {
            $product = $this->Pages_model->getProductID($_GET['delete']);
            $productID = $product['product_id'];
            // print_r($productID);
            // exit;
            $this->Pages_model->deleteRating($_GET['delete']);

            $ratingCount = $this->Pages_model->countProductRating($productID);
            // print_r($ratingCount);
            // exit;
            if($ratingCount > 0){
                $productRating = $this->Pages_model->productRatingSum($productID);
                $totRating = 0;
                foreach ($productRating as $rating) {
                    $totRating += $rating['rating'];
                }
                $average = $totRating/$ratingCount;
                $totAverage = round($average, 2);
                $this->Pages_model->updateProductRating($productID,$totAverage);
            }
            else{
                $totAverage = 0;
                $this->Pages_model->updateProductRating($productID,$totAverage);
            }
            $this->session->set_flashdata('result_delete', 'Rating/Review is deleted!');
            $this->saveHistory('Delete Rating id - ' . $_GET['delete']);
            redirect('admin/rating');
        }
        $data['showRating'] = $this->Home_admin_model->getValueStore('showRating');
        $rowscount = $this->Discounts_model->starRatingCount();
        $data['starRating'] = $this->Discounts_model->getStarRating($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/rating', $rowscount, $this->num_rows, 3);
       
        // echo "<pre>";
        // print_r($data['starRating']); die();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/rating', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to discounts page');
        }
    }
    public function add_rating()
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getOnebanner($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $this->Pages_model->setRating($_POST, $id);
            $ratingCount = $this->Public_model->countProductRating($_POST['product_id']);
            $productRating = $this->Public_model->productRatingSum($_POST['product_id']);
            $totRating = 0;
            foreach ($productRating as $rating) {
                $totRating += $rating['rating'];
            }
            $average = $totRating/$ratingCount;
            $totAverage = round($average, 2);
            $this->Public_model->updateProductRating($_POST['product_id'],$totAverage);
            $this->session->set_flashdata('result_publish', 'Rating is added!');
            $this->saveHistory('Rating Added');
             redirect('admin/rating');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Add Rating';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['allProduct'] = $this->Products_model->getAllProducts();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_rating', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
    public function edit_rating($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Pages_model->getProductID($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            //$productID = $this->Pages_model->getProductID($_GET['delete']);
            
            //print_r($productID['product_id']);
            //exit;
            $this->Pages_model->deleteRating($id);
            $id = 0;
            $this->Pages_model->setRating($_POST, $id);
            $ratingCount = $this->Public_model->countProductRating($_POST['product_id']);
            $productRating = $this->Public_model->productRatingSum($_POST['product_id']);
            $totRating = 0;
            foreach ($productRating as $rating) {
                $totRating += $rating['rating'];
            }
            $average = $totRating/$ratingCount;
            $totAverage = round($average, 2);
            $this->Public_model->updateProductRating($_POST['product_id'],$totAverage);
            $this->session->set_flashdata('result_publish', 'Rating is added!');
            $this->saveHistory('Rating Added');
             redirect('admin/rating');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Rating';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['allProduct'] = $this->Products_model->getAllProducts();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/add_rating', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }

    public function video_review($page = 0){
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Rating';
        $head['description'] = '!';
        $head['keywords'] = '';
        if (isset($_GET['delete'])) {
           $this->Discounts_model->deleteVideoReview($_GET['delete']);
           $this->session->set_flashdata('success', 'Video Review is Deleted!');
           $this->saveHistory('Video Review Deleted');
              redirect('admin/video_review');
        }
        $rowscount = $this->Discounts_model->allProductCount();
        $data['allProduct'] = $this->Discounts_model->getAllProduct($this->num_rows, $page);
        $data['links_pagination'] = pagination('admin/video_review', $rowscount, $this->num_rows, 3);
       
        // echo "<pre>";
        // print_r($data['allProduct']); die();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/video_review', $data);
        $this->load->view('_parts/footer');
        if ($page == 0) {
            $this->saveHistory('Go to discounts page');
        }
    }
    public function edit_video_review($id = 0)
    {
        $this->login_check();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $_POST = $this->Discounts_model->getVideoReview($id);
            $_POST['video_review_sku'] = $id;
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $this->Discounts_model->deleteVideoReview($id);
            $getProductID = $this->Discounts_model->getProductID($id);
            $_POST['productID'] = $getProductID['id'];
            $this->Discounts_model->setVideoReview($_POST, $id);
             
            $this->session->set_flashdata('success', 'Video Review is Updated!');
            $this->saveHistory('Video Review Updated');
              redirect('admin/video_review');
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Edit Video Review Link';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['allProduct'] = $this->Products_model->getAllProducts();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/edit_video_review', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }
}
