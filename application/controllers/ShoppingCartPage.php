<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ShoppingCartPage extends MY_Controller
{
    private $orderId;

    public function __construct()
    {
        parent::__construct();
        $this->load->Model('Public_model');
        $this->load->Model('admin/Products_model');
        $this->load->Model('admin/Orders_model');
        $this->load->Model('admin/Home_admin_model');
    }

    public function index()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('shoppingcart');
        $head['title'] = "Shopping Cart";
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $productVariant = $this->input->get('variant', TRUE);
        $quizProduct = $this->input->get('quiz', TRUE);
        
        $data['productVariant'] = $productVariant;
        $data['quizProduct'] = $quizProduct;
        $quizProductCategory = $this->input->get('category_type', TRUE);
        $data['quizProductCategory'] = $quizProductCategory;
        // echo $quizProductCategory;
        // exit;
        // if($quizProduct == ''){
        //     $this->Public_model->updateISQuizProduct($_SESSION['logged_user']);
        // }
        if(isset($_SESSION['logged_user'])){
            $this->shoppingcart->clearShoppingCart();
            $preCartProduct = $this->Public_model->preCartProduct($_SESSION['logged_user']);
            if(sizeof($preCartProduct)>0){
                if (!isset($_SESSION['shopping_cart'])) {
                            $_SESSION['shopping_cart'] = array();
                }
                foreach ( $preCartProduct as $item ) {
                    for($i=0;$i<$item['qty'];$i++){
                        @$_SESSION['shopping_cart'][] = (int) $item['product_id'];
                    }
                }
                @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->cookieExpTime);
                
            }
        }
        //echo "productVariant".$productVariant; exit;
         if (isset($_POST['payment_type'])) {
                    if($_POST['selected_address_id']==""){
                        $errors[] = "Please select proper address.";
                        $this->session->set_flashdata('submit_error', $errors);
                        redirect(LANG_URL . '/shopping_cart');
                    }else{
                        //echo "productVariant".$_POST['productVariant']; exit;
                         
                        $_POST['id'] = [];
                        $_POST['quantity'] = [];
                        

                        $product_id = array();
                        $product_qunaitity = array();
                        $items = $this->shoppingcart->getCartItems();


                        foreach ($items['array'] as $cartItem) { 
                            array_push($product_id,$cartItem['id']);
                            array_push($product_qunaitity,$cartItem['num_added']);
                        }
                        $_POST['id'] = $product_id;
                        $_POST['quantity'] = $product_qunaitity;

                        $product_id_buynow = array();
                        $product_qunaitity_buynow = array();
                        if($_POST['productVariant'] != ''){
                            $data_cart = array();
                            foreach($items['array'] as $item){
                                if($_POST['productVariant'] == $item['product_id']){
                                    array_push($product_id_buynow,$item['id']);
                                    array_push($product_qunaitity_buynow,$item['num_added']);
                                    //array_push($_POST, $item);
                                }
                            }
                            $_POST['id'] = $product_id_buynow;
                            $_POST['quantity'] = $product_qunaitity_buynow;
                            // $items['array'] = $data_cart;
                            

                        }
                        
                        $address_details = $this->Public_model->getAddressDetails($_POST['selected_address_id']);
                        
                        $_POST['referrer'] = $this->session->userdata('referrer');
                        $_POST['clean_referrer'] = cleanReferral($_POST['referrer']);
                        $userInfo = $this->Public_model->getUserProfileInfo(isset($_SESSION['logged_user'])?$_SESSION['logged_user']:$_SESSION['guest_user_id']);
                        $_POST['user_id'] = isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : $_SESSION['guest_user_id'];
                        
                        $_POST['email'] = isset($userInfo['email']) ? $userInfo['email'] : 0;
                        
                        $_POST['first_name'] = $address_details['first_name'];
                        $_POST['last_name'] = $address_details['last_name'];
                        $_POST['phone'] = $address_details['phone'];
                        $_POST['address'] = $address_details['address'];
                        $_POST['country'] = $address_details['country_name'];
                        $_POST['city'] = $address_details['city_name'];
                        $_POST['post_code'] = $address_details['post_code'];
                        $_POST['thana'] = $address_details['state_name'];
                        $_POST['notes'] = $address_details['notes'];
                        
                        $shipping_cost= $_POST['shpping_cost'];
                        
                        $delivery_time= $_POST['delivery_time'];
                        $order_id =  date('YmdHis').$_POST['user_id'];
                        $pdfFilePath = 'Order_Invoice_'.$order_id.'.pdf';
                        
                        

                        foreach ($_POST['id'] as $productID) {
                            $this->Public_model->removeFromCartTable($productID,$_SESSION['logged_user']);
                        }
                        // echo "<pre>";
                        // print_r($_POST); exit;
                            
                        $orderId = $this->Public_model->setOrder($order_id,$_POST,$shipping_cost,$delivery_time,$pdfFilePath);
                        if ($orderId != false) {
                            $orders_info = $this->Public_model->getOrderDetails($orderId);
                            $userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);

                            $userPointSum = $this->Public_model->getUserPointSum($orders_info['user_id']);
                            $totalSuccTransaction = $this->Public_model->totalSuccTransaction($orders_info['user_id']);
                            $tot_trans_amount = ($userPointSum['total_purchased_value']+$orders_info['total_order_price']);
                            $tier = $this->Public_model->getTier($tot_trans_amount);

                            $pointBalance = ($orders_info['total_order_price']);
                            $currentPointBalance = round($userPointSum['balancePont']+$userPointSum['bonusPoint']-$orders_info['paid_by_point'], 2);

                            if($orders_info['paid_by_point'] != 0){
                                $this->Public_model->setCustomerPointRedeem($orders_info, $userInfo,$orders_info['paid_by_point'],$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);
                            }

                             if($userPointSum && $orders_info['paid_by_point'] != 0){
                                $this->Public_model->updateUserPointRollUps($orders_info['user_id'], $tier['tierMasterID'], $userPointSum['totalEarnPoint']+$pointBalance,$currentPointBalance,$userPointSum['bonusPoint'],$tot_trans_amount,$userPointSum['redeem_point']+$orders_info['paid_by_point']);
                            }

                                /* Start reward */
                        // when unicommerce send status completed this time insert data into customer_point table & and update data into user_point_rollups table
                        //if($_POST['payment_type'] == 'cashOnDelivery'){
                            //print_r("payment_type", $_POST['payment_type']);
                            $totalTransactionBalance = $this->Public_model->totalTransactionBalance($orders_info['user_id']);
                             // $userPointSum = $this->Public_model->getUserPointSum($orders_info['user_id']);
                            /*$totalSuccTransaction = $this->Public_model->totalSuccTransaction($orders_info['user_id']);
                            $tot_trans_amount = 0;
                            foreach ($totalSuccTransaction as $transaction) {
                                if($transaction['payment_type'] == 'Razorpay'){
                                    if($transaction['payment_status'] == 'completed'){
                                         $tot_trans_amount += $transaction['total_order_price'];
                                    }
                                }
                            } */

                            // $tier = $this->Public_model->getTier($totalTransactionBalance);
                            // //print_r($tier); die();

                            // // $pointBalance = (($orders_info['total_order_price'] * $tier['pointPercentage']) / 100);
                            // $pointBalance = ($orders_info['total_order_price']);
                            // //echo $pointBalance; exit;

                            // $customerPoint = $this->Public_model->getCustomerPoint($orders_info['user_id']);
                            // if($customerPoint){
                            //     $currentPointBalance = ($customerPoint['currentPointBalance'] + $pointBalance);
                            // }
                            // else{
                            //     $currentPointBalance = $pointBalance;
                            // }
                            
                            // $customerPoint = $this->Public_model->setCustomerPoint($orders_info, $userInfo,$pointBalance,$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);

                            // $totalCurrentBalance = $this->Public_model->totalCurrentBalance($orders_info['user_id']);
                            
                            // $totalPointBalance = $this->Public_model->totalPointBalance($orders_info['user_id']);
                            // $point = 0;
                            // foreach ($totalPointBalance as $value) {
                            //     $point += $value['pointBalance'];
                            // }
                            // //print_r($point); exit;

                           
                           // if($orders_info['paid_by_point'] != 0){
                           //      $this->Public_model->setCustomerPointRedeem($orders_info, $userInfo,$orders_info['paid_by_point'],$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);
                           //  }

                           //   if($userPointSum && $orders_info['paid_by_point'] != 0){
                           //      $this->Public_model->updateUserPointRollUps($orders_info['user_id'], $tier['tierMasterID'], $userPointSum['totalEarnPoint']+$pointBalance,$currentPointBalance,$userPointSum['bonusPoint'],$tot_trans_amount,$userPointSum['redeem_point']+$orders_info['paid_by_point']);
                           //  }
                            
                            // if($userPointSum){
                            //      $total_transactionAmount = $userPointSum['total_purchased_value'] + $orders_info['total_order_price'];
                            //     $this->Public_model->updateUserPointSum($orders_info, $point, $tier['tierMasterID'], $currentPointBalance, $total_transactionAmount);
                            // }
                            // else{
                            //     $this->Public_model->setUserPointSum($orders_info,$point, $tier['tierMasterID'], $currentPointBalance,$total_transactionAmount);
                            // }
                            // if($_POST['paid_amount'] != 0){
                            // $paidPoin = ($_POST['paid_amount']);
                            // $reward_point = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);
                            // $balancePont = ($reward_point['balancePont'] - $paidPoin);
                            // $this->Public_model->updateRollups($_SESSION['logged_user'], $balancePont);
                            // }
                        //}
                            /* End reward */

                            /* start referral coupon */
                             // $isReferralExist = $this->Public_model->checkReferralExist($_SESSION['referral_code'], $orders_info['user_id']);
                             // if($isReferralExist){
                             //    $text = "";
                             //    $length_of_string = 6;
                             //    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                         
                             //    $text =  substr(str_shuffle($str_result),0, $length_of_string);
                             //       $coupon = $this->Public_model->createCoupon(strtoupper($text));
                             //       $this->Public_model->couponReferralTranslations($_SESSION['referral_code'], $orderId, $orders_info['user_id']);
                             //}
                            /* stop referral coupon */
                            /* insert_order_tracking */
                            $orders_product_info = $this->Public_model->getOrderProductDetails($orders_info['orderID']);
                            foreach ($orders_product_info as $product_info) {
                                $arr_products = unserialize($product_info['order_products']);
                                $orderID = $_SESSION['order_id'];
                                $order_product_id = $product_info['order_product_id'];
                                $skuCode = $arr_products['product_info']['sku'];
                                $status = $product_info['status'];
                                $remarks = '';
                                $insertID = $this->Public_model->insert_order_tracking($orderId,$order_product_id,$skuCode,$status,$remarks);
                            }
                            /* End insert_order_tracking stop */
                            if($_POST['birthday_amount'] != ''){
                                $this->Public_model->updateDiscountCode($_POST['phone']);
                            }
                            /* checking birthday coupon */
                            

                            /* stop birthday coupon*/

                             /* start referral reward */

                             $getReferral = $this->Public_model->getReferral($orders_info['user_id']);
                    if($getReferral['other_referral'] == $orders_info['isReferral']){

                        $getOtherReferral = $this->Public_model->getOtherReferral($getReferral['other_referral']);
                            //if($_SESSION['referral_code'] != ''){
                        $isReferralExist = $this->Public_model->checkIsReferralInOrder($orders_info['user_id'],$orders_info['isReferral']);

                              $tot_bonus_point = 0;
                            if($isReferralExist != false){
                                $referralOwner = $this->Public_model->checkIsReferralOwner($orders_info['isReferral']);

                                $pointBalances = 500;
                                $owner_referralCode = $this->Public_model->ownerReferralCode($orders_info['isReferral']);

                                $ownerBounsPoint = $this->Public_model->ownerBonusPoint($referralOwner['id']);

                                $tot_bonus_point = ($ownerBounsPoint['bonusPoint'] + $pointBalances);
                                
                                $this->Public_model->updateOwnerBonusPoint($referralOwner['id'], $tot_bonus_point);
                                
                               // $customerPoints = $this->Public_model->getCustomerPoint($orders_info['user_id']);
                                $customerPoints = $this->Public_model->getCustomerPoint($referralOwner['id']);
                                if($customerPoints){
                                    $currentPointBalance = ($customerPoints['currentPointBalance'] + $pointBalances);
                                }
                                else{
                                    $currentPointBalance = $pointBalances;
                                }
                                 $customerPoint = $this->Public_model->setCustomerPointForReffaralReward($referralOwner['id'],$orders_info, $userInfo,$pointBalances,$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);
                            
                              }
                          }

                          //    if($this->session->userdata('referral_code') != ''){
                          //     $isReferralExist = $this->Public_model->checkIsReferralInOrder($_SESSION['logged_email'],$this->session->userdata('referral_code'));
                          //     //print_r($this->session->userdata('referral_code')); exit;
                          //     $tot_bonus_point = 0;
                          //     if($isReferralExist == true){
                          //       $bonus_point = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);

                          //       $tot_bonus_point = ($bonus_point['bonusPoint'] + 500);
                          //       $this->Public_model->updateUserBonusPoint($orders_info, $tot_bonus_point);

                          //       $pointBalances = 500;
                          //       $customerPoints = $this->Public_model->getCustomerPoint($orders_info['user_id']);
                          //       if($customerPoints){
                          //           $currentPointBalance = ($customerPoints['currentPointBalance'] + $pointBalances);
                          //       }
                          //       else{
                          //           $currentPointBalance = $pointBalances;
                          //       }
                          //        $customerPoint = $this->Public_model->setCustomerPoint($orders_info, $userInfo,$pointBalances,$currentPointBalance);
                            
                          //     }
                          // }
                             /* stop referral reward */

                            $this->session->set_userdata('orderId', $orderId);
                            if($_POST['payment_type'] == 'cashOnDelivery'){
                                $this->generatePDF_EmailNotification($orderId);
                            }
                            $this->orderId = $orderId;
                            
                            //$orderId = $this->Public_model->setCustomerPoint($);
                            //  $this->setVendorOrders();
                              //$this->sendNotifications();

                              //$this->sendWhatsAppSMS($orderId,'neolayr');
                              $this->sendEmailNotifications($orderId);
                              $this->goToDestination($_POST['productVariant']);
                            //  $this->orderByShiprocket($orderId);
                               

                        } else {
                            log_message('error', 'Cant save order!! ' . implode('::', $_POST));
                            $this->session->set_flashdata('order_error', true);
                            redirect(LANG_URL . '/checkout/order-error');
                        }
                    }
                    
                    
                
        }
        $data['recentlyAdded'] = $this->Public_model->getRecentlyAddedProduct();
        $data['featuredProducts'] = $this->Public_model->getFeatured_products();
        // echo "<pre>";
        // print_r($data['featuredProducts']); exit;
        $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
        $data['cashondelivery_visibility'] = $this->Home_admin_model->getValueStore('cashondelivery_visibility');
         $data['freecharge_payment'] = $this->Home_admin_model->getValueStore('freecharge_payment');
        $data['razorpay_payment'] = $this->Home_admin_model->getValueStore('razorpay_payment');
        $data['bestSellers'] = $this->Public_model->getbestSellers();
        $data['allCoupons'] = $this->Public_model->getAllCoupons($_SESSION['logged_mobile']);
        $data['giftCoupons'] = $this->Public_model->getGiftVouchers($_SESSION['logged_user']);
        $data['previous_address'] = array();
        // echo "<pre>";
        // print_r($data['allCoupons']); exit;
        //Get last order address
        $previous_address = array();;
        if(isset($_SESSION['logged_user'])){
            $previous_address = $this->Public_model->getPreviousAddress($_SESSION['logged_user']);
            $data['previous_address'] = $previous_address;
        }        
        $district_list = $this->Public_model->getdistrictlist();
        /*foreach($district_list as $district){
            if($district['is_default'] == 'yes')
            $district_id = $district['district_id'];
        }*/
        $userdetails = $this->Public_model->checkIsreferral($_SESSION['logged_user']);
        $items = $this->shoppingcart->getCartItems();
        //print_r($items); die();
        $cartQuizData = $this->Public_model->getCartDatafrQuiz($_SESSION['logged_user']);
        $data['quizdiscountAmoun'] = 0;
        $quizdiscountAmoun = 0;
        //if($quizProduct != '' && $quizProductCategory != 24){
        if(sizeof($cartQuizData)>0){
            //$quizProduct = $this->Public_model->quizProduct($_SESSION['logged_user']);
            $quiz_tot_price = 0;
            foreach ( $cartQuizData as $var ) {
                $price = str_replace(",", "", $var['amount']);
                $quiz_tot_price += ($price*1);
            }
            $quizPricePercentage = (($quiz_tot_price*20)/100);
            $data['quizdiscountAmoun'] = round($quizPricePercentage,2);
            $data['quizTotAmoun'] = $data['quizdiscountAmoun'];
            $quizdiscountAmoun = $data['quizTotAmoun'];
            

        }

        
        $ref_tot_price = 0;
        foreach ( $items['array'] as $var ) {
            $ref_tot_price += ($var['price']*$var['num_added']);
        }
        //print_r($ref_tot_price); die();
        $referral_exists = "0";
        $isReferralExist = $this->Public_model->checkIsReferralInOrderTwo($_SESSION['logged_email'],$userdetails['other_referral']);

        // echo "<pre>";
        // print_r($isReferralExist);
        // exit;
        if(sizeof($isReferralExist)>0){
            //echo "ok";
        foreach ($isReferralExist as $value) {
            if($value['payment_type'] == 'Razorpay'){
                //echo "if";
                if($value['payment_status'] != 'pending'){
                    $referral_exists = "1";
                }
            }else{
                if($value['payment_status'] == 'pending'){
                    //echo "else";
                    $referral_exists = "1";
                }
            }
        
        }
        }
        else{
            $referral_exists = '0';
        }
        
        // echo "referral_exists".$referral_exists; 
        // exit;

        // echo $_SESSION['logged_user'];
        // exit;
        if($referral_exists == '0'){
        $isReferral = $this->Public_model->checkIsreferral($_SESSION['logged_user']);
        //print_r($isReferral); exit;
        if($isReferral['other_referral'] != '' && $ref_tot_price >= 700){
            $data['otherReferral'] = $isReferral['other_referral'];
            $data['otherReferralPrices'] = 200;
            //echo "1st";
        }
        else{
            $data['otherReferralPrices'] = 0;
            $data['otherReferral'] = '';
            //echo "2nd";
        }
        }
        else{
            $data['otherReferralPrices'] = 0;
            $data['otherReferral'] = '';
        }
       // print_r($isReferral); die();
        $totalReward = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);
        // $tot = 0;
        //     foreach ( $totalReward as $var ) {
        //         $tot += $var['pointBalance'];
        //     }
        // echo "<pre>";
        // print_r($totalReward); exit;
 

        $data['user_email'] = $_SESSION['logged_email'];
        $data['pointBalance'] = $totalReward['balancePont'] + $totalReward['bonusPoint'];
        $data['country_list'] = $this->Public_model->getcountrylist();
        $data['state_list'] = $this->Public_model->getStatelist("101");
        $data['totalReward'] = $totalReward;
        $this->render('shopping_cart', $head, $data);
    }
    private function goToDestination($productVariant = '')
    {
        if ($_POST['payment_type'] == 'cashOnDelivery' || $_POST['payment_type'] == 'Bank' || $_POST['payment_type'] == 'Razorpay') {
            if($productVariant == ''){
            $this->shoppingcart->clearShoppingCart();
            }
            else{
                $this->removeFromCart($productVariant);
            }
            $this->session->set_flashdata('success_order', true);
            redirect(LANG_URL . '/checkout/successcash');
        }
        if ($_POST['payment_type'] == 'Freecharge') {
            $_SESSION['order_id'] = $this->orderId;
            $_SESSION['final_amount'] = $_POST['final_amount'] . $_POST['amount_currency'];
            redirect(LANG_URL . '/checkout/freecharge_payment');
        }
        //  if ($_POST['payment_type'] == 'Razorpay') {
        //     $_SESSION['order_id'] = $this->orderId;
        //     $_SESSION['final_amount'] = $_POST['final_amount'] . $_POST['amount_currency'];
        //     redirect(LANG_URL . '/checkout/razorpay_payment');
        // }
        if ($_POST['payment_type'] == 'cashOnDelivery') {
            redirect(LANG_URL . '/checkout/successcash');
        }
        if ($_POST['payment_type'] == 'PayPal') {
            @set_cookie('paypal', $this->orderId, 2678400);
            $_SESSION['discountAmount'] = $_POST['discountAmount'];
            redirect(LANG_URL . '/checkout/paypalpayment');
        }
    }
    public function sendWati($orderId){
            //echo $orderId;
            $userInfo = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
            //echo $userInfo['name'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://live-server-113762.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91'.$userInfo['phone'],
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
                "template_name": "orderplaced",
                "broadcast_name": "palson",
                "parameters": [
                    {
                        "name": "name",
                        "value": "'.$userInfo['name'].'"
                    },
                    {
                        "name": "ordernumber",
                        "value": "'.$orderId.'"
                    }
                ]
            }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI3MGNiNjFlNS1mNDRhLTQwNzYtYWM3Ny1hYmI3M2Y2YzY2MzQiLCJ1bmlxdWVfbmFtZSI6Im5lb2xheXJwcm9AcGFsc29uc2Rlcm1hLmNvbSIsIm5hbWVpZCI6Im5lb2xheXJwcm9AcGFsc29uc2Rlcm1hLmNvbSIsImVtYWlsIjoibmVvbGF5cnByb0BwYWxzb25zZGVybWEuY29tIiwiYXV0aF90aW1lIjoiMDgvMTgvMjAyMyAwNzoxOTozNCIsImRiX25hbWUiOiIxMTM3NjIiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJBRE1JTklTVFJBVE9SIiwiZXhwIjoyNTM0MDIzMDA4MDAsImlzcyI6IkNsYXJlX0FJIiwiYXVkIjoiQ2xhcmVfQUkifQ.Kbk0wYYToCHin5TjTmJPFuQ-qIZOQ8gSyOoVefPzbCE',
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              //echo "cURL Error #:" . $err;
            } else {
              //echo ($response);
            }

    }

     public function removeFromCart($productVariant)
    {
        //echo $productVariant;
        $count = count(array_keys($_SESSION['shopping_cart'], $productVariant));
        $i = 1;
        do {
            if (($key = array_search($productVariant, $_SESSION['shopping_cart'])) !== false) {
                unset($_SESSION['shopping_cart'][$key]);
            }
            $i++;
        } while ($i <= $count);
        @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->cookieExpTime);
    }
    private function sendNotifications()
    {
        $users = $this->Public_model->getNotifyUsers();
        $myDomain = $this->config->item('base_url');
        if (!empty($users)) {
            foreach ($users as $user) {
                $this->sendmail->sendTo($user, 'Admin', 'New order in ' . $myDomain, 'Hello, you have new order. Can check it in /admin/orders');
            }
        }
    }
    public function sendEmailNotifications($orderId)
    {
        $orderdata = $this->Public_model->findOrderID($orderId);
        $orders_info = $this->Public_model->getUserOrderDetailsTwo($orderdata['id']);
        //$orders_info = $this->Public_model->getOrderDetails($orderId);
       $userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
                     
                     //echo $userInfo['email']; exit;
                    //print_r($orders_info); exit;
                    $sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
                   
                        
                        $total = 0;
                        $counter = 1;
                        $invoice_product = "";
                        foreach ($orders_info as $product) { 
                        $arr_products = unserialize($product['order_products']);  
                        //print_r($arr_products['product_info']);
                            $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $arr_products['product_info']['id'], true);
                            $total +=$product['product_info']['price']*$product['product_quantity'];
                            $counter++;
                            
                            $invoice_product .= '<table style="width:100%;padding:10px 20px;"><tr>
                            <td>
                                <img src="'.base_url('attachments/shop_images/' . $arr_products['product_info']['image']).'" alt="" width="80">
                            </td>
                            <td style="font-size:15px;color:#505050;font-weight:500; text-align:left;line-height:28px;">
                                <a target="_blank" href="'.base_url($product['product_info']['url']).'">'.character_limiter($productInfo['title'],20).'</a>
                            </td>
                            <td style="font-size:15px;color:#505050;font-weight:500; text-align:left;line-height:28px;">
                                QTY : '.$arr_products['product_quantity'].'
                            </td>
                            
                            <td style="color:#505050;font-size:15px;font-weight:600;text-align:right;">₹'.number_format($product['unit_price']+ $product['reward_amount'],2).'</td>
                        </tr>
                        </table>';
                                                            
                        }
                        
                        //Send Email
                        $invoice_mail = '<div style="max-width:570px;margin:0px auto;padding:30px 45px;">
                        <div style="text-align:center;margin-bottom:30px;">
                <img src="'.base_url('attachments/site_logo/' . $sitelogo).'" width="260" height="38" border="0" alt="">
            </div>
            <h1 style="text-align:center; font-weight:700;color:#505050;font-size:24px;margin-bottom:20px;">Order Confirmation</h1>
            <p style="font-size:15px;line-height:35px;color:#7b7b7b;font-weight:400; text-align:center;">Hi '.$orders_info[0]['first_name'].' '.$orders_info[0]['last_name'].',<br>Order is sucessfully processed and your order in on the way.</p>
            <h3 style="font-size:17px;color:#505050;font-weight:700; text-align:center;margin-bottom:50px;">Order ID : '.$orders_info[0]['order_id'].'</h3>
            <h4 style="font-size:15px;color:#7b7b7b;font-weight:700;text-transform:uppercase;">Item ordered</h4>
            <hr>
            '.$invoice_product.'
            <hr>
            <table style="width:100%;padding:10px 0px 0px;">
            <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Subtotal</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">₹'.number_format($orders_info[0]['total_order_price_two'],2).'</td>
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Discount</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">- ₹'.number_format($orders_info[0]['discount_amount'],2).'</td>
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Gift Voucher</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">- ₹'.number_format($orders_info[0]['gift_amount'],2).'</td>
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Shipping Cost</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">₹'.number_format($orders_info[0]['order_shipping_cost'],2).'</td>
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Paid By Point</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">₹'.number_format($orders_info[0]['paid_amount'],2).'</td>
                </tr>

            </table>
            <hr>
            <table style="width:100%;padding:0px 0px 0px;">
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Total</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">- ₹'.number_format($orders_info[0]['total_order_price'],2).'</td>
                    
                </tr>
                <tr>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:400; text-align:left;line-height:40px;">Payment Method</td>
                    <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;">'.$orderdata['payment_type'].'</td>
                </tr>
            </table>
            <table style="width:100%;padding:10px 0px 0px;">
                <tr>
                    <td>
                        <h3 style="font-size:18px;color:#7b7b7b;margin-bottom:20px;text-transform:uppercase;font-weight:500;">BIlling INFO</h3>
                        <p style="font-size:18px;color:#505050;font-weight:600; text-align:left;line-height:40px;">
                        '.$orders_info[0]['first_name']." ".$orders_info[0]['last_name'].'<br>
                        '.$orders_info[0]['address'].', <br>
                        '.$orders_info[0]['city'].', <br>
                        '.$orders_info[0]['post_code'].', <br>
                        '.$orders_info[0]['phone'].'
                        </p>
                    </td>
                    <td>
                        <h3 style="font-size:18px;color:#7b7b7b;margin-bottom:20px;text-transform:uppercase;font-weight:500;text-align:right;">Shipping INFO</h3>
                        <p style="font-size:18px;color:#505050;font-weight:600; text-align:right;line-height:40px;">
                        '.$orders_info[0]['first_name']." ".$orders_info[0]['last_name'].'<br>
                        '.$orders_info[0]['address'].', <br>
                        '.$orders_info[0]['city'].', <br>
                        '.$orders_info[0]['post_code'].', <br>
                        '.$orders_info[0]['phone'].'</p>
                    </td>
                </tr>
            </table>


                        </div>';
                        //print_r($invoice_mail); exit;
                $toName = $orders_info[0]['first_name'].' '.$orders_info[0]['last_name'];
                $toEmail = $orders_info[0]['email'];
                $fromName = 'NEOLAYR';
                $fromEmail = 'neolayrpro@palsonsderma.com';
                $subject = 'Thank you for your order';
                $htmlMessage = '<p>Hello '.$toName.',</p><p>This is my first transactional email sent from Sendinblue.</p>';

                $data = array(
                    "sender" => array(
                        "email" => $fromEmail,
                        "name" => $fromName         
                    ),
                    "to" => array(
                        array(
                            "email" => $toEmail,
                            "name" => $toName 
                            )
                    ), 
                    "subject" => $subject,
                    "htmlContent" => $invoice_mail
                ); 
                //echo json_encode($data);
                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.sendinblue.com/v3/smtp/email',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_POSTFIELDS => json_encode($data),
                  CURLOPT_HTTPHEADER => array(
                'Api-Key: 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',
                'content-type: application/json'
              ),
            ));
                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                // if ($err) {
                //   echo "cURL Error #:" . $err;
                // } else {
                //   echo $response;
                // }
            }
private function generatePDF_EmailNotification($orderId)
{
            //$orders_info = $this->Public_model->getOrderDetails($orderId);
            $orderdata = $this->Public_model->findOrderID($orderId);
            $orders_info = $this->Public_model->getUserOrderDetailsTwo($orderdata['id']);
            $orders_client_data = $this->Public_model->getOrderClientData($orderdata['id']);
            $userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
            
            //$percentageArray = array();
            $cgst = '';
            $sgst = '';
            $igst = '';
            //$show_percentage = '';
            $percentage = 0;
            if($orders_client_data['thana'] == 'West Bengal'){
                $cgst = '9%';
                $sgst = '9%';
            }
            if($orders_client_data['thana'] != 'West Bengal'){
                $igst = '18%';
            }
            $sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
                        $footerContactPhone = htmlentities($this->Home_admin_model->getValueStore('footerContactPhone'));
                        $footerContactEmail = htmlentities($this->Home_admin_model->getValueStore('footerContactEmail'));
            
                        $this->load->library('m_pdf');
                            $headerhtml = '<table style="text-align:center;width:100%;border-top:1px solid #ddd;" cellspacing="0" cellpadding="1"><tr><td style="width:100%;"><b><img width="150px" src="data:image/jpg;base64,'.base64_encode(file_get_contents(base_url('attachments/site_logo/' . $sitelogo))).'" alt="neolayr"></b></td></tr><tr><td><i>PHONE- '.$footerContactPhone.'; E-mail: '.$footerContactEmail.'</i></td></tr><tr><td style="width:100%; margin-left:10px;border-top:1px solid #ddd; text-align:center;border-bottom:1px solid #ddd;">TAX INVOICE</td></tr></table>';
                            
                            
                            $footerhtml = '<table style="text-align:center;width:100%" cellspacing="0" cellpadding="1"><tr><td style="width:100%;">Thank you for shopping. We hope you will come back soon.</td></tr></table>';
                            $m_pdf = new mPDF('utf-8', 'A4','10', '', '', 0, 0, 10, 10, 0, 0); 
                            $m_pdf->setAutoTopMargin = 'stretch';
                            $m_pdf->allow_charset_conversion = true;
                            $m_pdf->setAutoBottomMargin = 'stretch';
                            $m_pdf->autoPageBreak = true;
                            $m_pdf->SetHTMLHeader($headerhtml);
                            $m_pdf->SetHTMLFooter($footerhtml);
                            $discount = "";
                if($orders_info[0]['discountTypes'] == 7){
                    $subTotal_html = number_format($orders_info[0]['total_order_price_two'] + $orders_info[0]['discount_amount'],2);

                    $subTotal_pdf = number_format($orders_info[0]['total_order_price_two'] + $orders_info[0]['discount_amount'],2);

                    $sale_price = number_format($orders_info[0]['total_order_price_two'] - $orders_info[0]['paid_amount'] - $orders_info[0]['gift_amount'], 2);
                    }
                else{
                    $subTotal_html = number_format($orders_info[0]['total_order_price_two'],2);

                    $subTotal_pdf = number_format($orders_info[0]['total_order_price_two'],2);

                    $sale_price = number_format($orders_info[0]['total_order_price_two'] - $orders_info[0]['discount_amount'] - $orders_info[0]['paid_amount'] - $orders_info[0]['gift_amount'], 2);
                }
                if($orders_info[0]['discount_code'] != ''){
                $discount_code_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">Discount Amount'.$orders_info[0]['discount_code'].': </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">   '.($orders_info[0]['coupon_discount_type']).'</b>
                                    </td>
                                </tr>';
                    $discount_code_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">COUPON DISCOUNT('.$orders_info[0]['discount_code'].'):</td><td style="border-top:1px solid #ddd;">     '.($orders_info[0]['coupon_discount_type']).'</td></tr>';
                    }
            if($orders_info[0]['discount_amount']>0){
                $discount_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">Discount Amount: </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">INR'.number_format($orders_info[0]['discount_amount'],2).'</b>
                                    </td>
                                </tr>';
                    $discount_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right"> DISCOUNT AMOUNT:</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['discount_amount'],2).'</td></tr>';
                    }
                    if($orders_info[0]['gift_amount']>0){
                    $gift_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">Gift Coupon Discount : </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">INR'.number_format($orders_info[0]['gift_amount'],2).'</b>
                                    </td>
                                </tr>';
                    $gift_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">GIFT COUPON DISCOUNT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['gift_amount'],2).'</td></tr>';
                    } 
                    if($orders_info[0]['paid_amount']>0){
                    $paid_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">PAID BY POINT : </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">INR'.number_format($orders_info[0]['paid_amount'],2).'</b>
                                    </td>
                                </tr>';
             $paid_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">PAID BY POINT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['paid_amount'],2).'</td></tr>';
             } 
            
             if($orders_info[0]['referral_amount']>0){
                    $referral_html = '<tr class="pad-left-right-space ">
                                    <td class="m-t-5" colspan="2" align="left">
                                        <p style="font-size: 14px;">Referral Discount : </p>
                                    </td>
                                    <td class="m-t-5" colspan="2" align="right">
                                        <b style="">INR'.number_format($orders_info[0]['referral_amount'],2).'</b>
                                    </td>
                                </tr>';
                    $referral_pdf = '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">REFERRAL DISCOUNT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['referral_amount'],2).'</td></tr>';
                    }
            $html_content = "<table width='100%' style='padding:0 20px;'>
                              <tr>
                                <td width='50%'>
                                        <h4>SENDER</h4><br>
                                        Palsonsderma<br>
                                        Palsons Derma Pvt. Ltd.<br>
                                        (CWH),Village: Alampur ,New<br>
                                        Kolorah ,PS: Sankrail<br>
                                        Howrah - 711302<br>
                                        West Bengal (19) ,India<br>
                                        Ph No: 8100105450<br>
                                        GST : 19AAECP5629D1ZD
                                </td>

                            <td width='50%' style='text-align: right;'>
                                    <h4>SUMMARY</h4><br>
                                     Order No. #(".$orders_info[0]['order_id'].")
                                     <br>Order Date : ".date('F d,Y', $orders_info[0]['date'])."
                                     <br>Payment Method : ".$orders_info[0]['payment_type']."
                                </td>
                             </tr>
                             <tr>
                             <td width='50%'>
                                <h4>DELIVERY ADDRESS</h4><br>
                                    ".$orders_info[0]['first_name']." ".$orders_info[0]['last_name'] ."
                                    <br>".$orders_info[0]['address'] ." ".$orders_info[0]['city']."
                                    <br>State : ".$orders_info[0]['thana'] ."
                                    <br>Pincode : ".$orders_info[0]['post_code'] ."
                                    <br>Contact No. ".$orders_info[0]['phone'] ."
                                    <br>".$orders_info[0]['notes'] ."
                             </td>
                             <td width='50%' style='text-align: right;'>
                                <h4>BILLING ADDRESS</h4><br>
                                    ".$orders_info[0]['first_name']." ".$orders_info[0]['last_name'] ."
                                    <br>".$orders_info[0]['address'] ." ".$orders_info[0]['city']."
                                    <br>State : ".$orders_info[0]['thana'] ."
                                    <br>Pincode : ".$orders_info[0]['post_code'] ."
                                    <br>Contact No. ".$orders_info[0]['phone'] ."
                                    <br>".$orders_info[0]['notes'] ."
                             </td></tr>
                             </table>";
                            
                            $total = 0;
                            $html_content .= '<table width="100%" style="border:1px solid #ddd; margin-top: 10px; padding:0 10px"><tr><td style="border-bottom:1px solid #ddd;" >SL.</td><td style="border-bottom:1px solid #ddd;" width="25px">CODE</td><td style="border-bottom:1px solid #ddd;" width="170px">PRODUCT TITLE</td><td style="border-bottom:1px solid #ddd;" >QUANTITY</td><td style="border-bottom:1px solid #ddd;" >MRP(INR)</td><td style="border-bottom:1px solid #ddd;" >RATE(INR)</td><td style="border-bottom:1px solid #ddd;" >CGST(9%)</td><td style="border-bottom:1px solid #ddd;" >SGST(9%)</td><td style="border-bottom:1px solid #ddd;" >IGST(18%)</td><td style="border-bottom:1px solid #ddd;" >AMOUNT(INR)</td></tr>';
                            $counter = 1;
                            $invoice_product = "";
                            //$percentage = ''; 
                            foreach ($orders_info as $product) { 

                            $rate =  (($product['unit_price']+ $product['reward_amount'] + $product['coupon'] + $product['gift_discount'] - $product['shipping_cost']));
                            $final_rate = (($rate * 100)/118);

                            //$percentage = (($final_rate * 18)/100);
                            
                            if($product['thana'] == 'West Bengal'){
                                $c_percentage = (($final_rate * 18)/100);
                            }
                            else{
                                $c_percentage = '';
                            }

                            if($product['thana'] != 'West Bengal'){
                                $i_percentage = (($final_rate * 18)/100);
                            }
                            else{
                                $i_percentage = '0';
                            }

                            //array_push($percentageArray, $percentage);

                            $arr_products = unserialize($product['order_products']); 
                                $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $arr_products['product_info']['id'], true);
                                $total =number_format($product['unit_price']+ $product['reward_amount'],2);
                                $html_content .= '<tr><td>'.$counter.'.</td><td>SKU:'.$arr_products['product_info']['sku'].'<br>HSN: '.$arr_products['product_info']['hsn_code'].'</td><td>'.$productInfo['title'].'</td><td style=text-align: center;>'.$arr_products['product_quantity'].'</td><td>'.number_format(($product['unit_price']+ $product['reward_amount']- $product['shipping_cost']+ $product['coupon'] + $product['gift_discount'] * $arr_products['product_quantity']),2).'</td><td>'.number_format($final_rate,2).'</td><td style=text-align: center;>'.number_format(($c_percentage/2), 2).'</td><td style=text-align: center;>'.number_format(($c_percentage/2), 2).'</td><td style=text-align: center;>'.number_format($i_percentage, 2).'</td><td>'.number_format(($product['unit_price']+ $product['reward_amount']- $product['shipping_cost']+ $product['coupon'] + $product['gift_discount'] * $arr_products['product_quantity']),2).'</td></tr>';
                                $counter++;
                                
                                $invoice_product .= '<tr>
                                <td>
                                    <img src="'.base_url('attachments/shop_images/' . $arr_products['product_info']['image']).'" alt="" width="80">
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">'.$arr_products['product_info']['hsn_code'].'</h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">'.$productInfo['title'].'</h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top: 10px;">QTY : <span>'.$arr_products['product_quantity'].'</span></h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top:15px"><b>INR'.number_format($product['unit_price']+ $product['reward_amount'],2).'</b></h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">'.$arr_products['product_quantity'].'</h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">'.$arr_products['product_quantity'].'</h5>
                                </td>
                            </tr>';
                                                                
                            }
                            $html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">SUB TOTAL :</td><td style="border-top:1px solid #ddd;"> INR'.$subTotal_pdf.'</td></tr>';

                            $html_content .= $discount_code_pdf.$discount_pdf.$paid_pdf.$gift_pdf.$referral_pdf;

                            $html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">SALE PRICE :</td><td style="border-top:1px solid #ddd;"> INR'.$sale_price.'</td></tr>';

                            $html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">SHIPPING :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['order_shipping_cost'],2).'</td></tr>';

                            /*$html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">PAID BY POINT :</td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['paid_amount'],2).'</td></tr>';*/
                           
                            $html_content .= '<tr><td colspan="9" style="border-top:1px solid #ddd;text-align: right">TOTAL AMOUNT :<br></td><td style="border-top:1px solid #ddd;"> INR'.number_format($orders_info[0]['total_order_price'],2).'</td></tr>';
                            $html_content .= '</table>';
                            // print_r($html_content);
                            // exit;
                            
                            $m_pdf->WriteHTML($html_content);
                            $pdfFilePath = 'Order_Invoice_'.$orderId.'.pdf';
                            $m_pdf->Output('./invoice/'.$pdfFilePath, "F"); 
                            
                             
    }
    private function setActivationLink()
    {
        if ($this->config->item('send_confirm_link') === true) {
            $link = md5($this->orderId . time());
            $result = $this->Public_model->setActivationLink($link, $this->orderId);
            if ($result == true) {
                $url = parse_url(base_url());
                $msg = lang('please_confirm') . base_url('confirm/' . $link);
                $this->sendmail->sendTo($_POST['email'], $_POST['first_name'] . ' ' . $_POST['last_name'], lang('confirm_order_subj') . $url['host'], $msg);
            }
        }
    }
    public function orderError()
    {
        if ($this->session->flashdata('order_error')) {
            $data = array();
            $head = array();
            $arrSeo = $this->Public_model->getSeo('checkout');
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
            $head['keywords'] = str_replace(" ", ",", $head['title']);
            $this->render('checkout_parts/order_error', $head, $data);
        } else {
            redirect(LANG_URL . '/checkout');
        }
    }
    public function successPaymentCashOnD()
    {
        if ($this->session->flashdata('success_order')) {
            $data = array();
            $head = array();
            $arrSeo = $this->Public_model->getSeo('checkout');
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
            $data['orders_info'] = $this->Public_model->getOrderDetails($this->session->userdata('orderId'));
            $head['keywords'] = str_replace(" ", ",", $head['title']);
            $this->render('checkout_parts/payment_success_cash', $head, $data);
        } else {
            redirect(LANG_URL . '/checkout');
        }
    }
    public function successPaymentBank()
    {
        if ($this->session->flashdata('success_order')) {
            $data = array();
            $head = array();
            $arrSeo = $this->Public_model->getSeo('checkout');
            $head['title'] = @$arrSeo['title'];
            $head['description'] = @$arrSeo['description'];
            $head['keywords'] = str_replace(" ", ",", $head['title']);
            $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
            $this->render('checkout_parts/payment_success_bank', $head, $data);
        } else {
            redirect(LANG_URL . '/checkout');
        }
    }

    public function paypal_cancel()
    {
        if (get_cookie('paypal') == null) {
            redirect(base_url());
        }
        @delete_cookie('paypal');
        $orderId = get_cookie('paypal');
        $this->Public_model->changePaypalOrderStatus($orderId, 'canceled');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_cancel', $head, $data);
    }

    public function paypal_success()
    {
        if (get_cookie('paypal') == null) {
            redirect(base_url());
        }
        @delete_cookie('paypal');
        $this->shoppingcart->clearShoppingCart();
        $orderId = get_cookie('paypal');
        $this->Public_model->changePaypalOrderStatus($orderId, 'payed');
        $data = array();
        $head = array();
        $head['title'] = '';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->render('checkout_parts/paypal_success', $head, $data);
    }
     public function add_paperfly_order()
    {
        $url = "http://173.82.130.162/OrderPlacement";
        $post_data = '{
                    "merOrderRef":"911897",
                    "pickMerchantName":"",
                    "pickMerchantAddress":"",
                    "pickMerchantThana":"",
                    "pickMerchantDistrict":"",
                    "pickupMerchantPhone":"",
                    "productSizeWeight":"standard",
                    "productBrief":"USB Fan",
                    "packagePrice":"3400",
                    "deliveryOption":"regular",
                    "custname":"Md. Abdul Karim",
                    "custaddress":"Road 27, Dhanmondi",
                    "customerThana":"Agargaon",
                    "customerDistrict":"Dhaka",
                    "custPhone":"9876543210"
                    }';
        $headers = ['username' => 'm10023', 'password' => 'abcd1234', 'paperflykey' => 'Paperfly_~La?Rj73FcLm'];
        $data = $this->cUrlGetData($url, $post_data, $headers);
        print_r($data);
        
    }
    function cUrlGetData($url, $post_fields = null, $headers = null) {
        $ch = curl_init();
        $timeout = 5;
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
    function mail_test(){
        $orders_info = $this->Public_model->getOrderDetails('2023071500010270');
            $userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
            //print_r($orders_info); exit;
            $sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
           
                $arr_products = unserialize($orders_info['products']);
                $total = 0;
                $counter = 1;
                $invoice_product = "";
                foreach ($arr_products as $product) {   
                    $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
                    $total +=$product['product_info']['price']*$product['product_quantity'];
                    $counter++;
                    
                    $invoice_product .= '<tr>
                                <td>
                                    <img src="'.base_url('attachments/shop_images/' . $product['product_info']['image']).'" alt="" width="80">
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;"><a target="_blank" href="'.base_url($product['product_info']['url']).'">'.character_limiter($productInfo['title'],20).'</a></h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top: 10px;">QTY : <span>'.$product['product_quantity'].'</span></h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top:15px"><b>'.number_format($product['product_info']['price']*$product['product_quantity'],2).'INR</b></h5>
                                </td>
                            </tr>';
                                    
                        }
                        //Send Email
                        $invoice_mail = '<table align="center" border="0" cellpadding="0" cellspacing="0" style="padding: 0 30px;background-color: #fff; -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);width: 650px;border: 1px solid #ddd">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="text-align: left;" width="100%">
                                        <tbody><tr>
                                            <td style="text-align: center;">
                                                <img width="150px" src="'.base_url('attachments/site_logo/' . $sitelogo).'" alt="" style=";margin-bottom: 30px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="font-size: 14px;"><b>Hi '.$userInfo['name'].',</b></p>
                                                <p style="font-size: 14px;">Order Is Successfully Processsed And Your Order Is On The
                                                    Way,</p>
                                                <p style="font-size: 14px;">Transaction ID : '.$orders_info['order_id'].',</p>
                                            </td>
                                        </tr>
                                    </tbody></table>
                
                                    <table cellpadding="0" cellspacing="0" border="0" align="left" style="width: 100%;margin-top: 10px;    margin-bottom: 10px;">
                                        <tbody>
                                            <tr>
                                                <td style="background-color: #fafafa;border: 1px solid #ddd;padding: 15px;letter-spacing: 0.3px;width: 100%;">
                                                    <h5 style="font-size: 16px; font-weight: 600;color: #000; line-height: 16px; padding-bottom: 13px; border-bottom: 1px solid #e6e8eb; letter-spacing: -0.65px; margin-top:0; margin-bottom: 13px;">
                                                        Your Delivery Address</h5>
                                                    <p style="text-align: left;font-weight: normal; font-size: 14px; color: #000000;line-height: 21px;    margin-top: 0;">
                                                    '.$orders_info['first_name']." ".$orders_info['last_name'].','.$orders_info['address'].','.$orders_info['city'].', Pincode - '.$orders_info['post_code'].',Contact No - '.$orders_info['phone'].'
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="order-detail" border="0" cellpadding="0" cellspacing="0" align="left" style="width: 100%;    margin-bottom: 50px;">
                                        <tbody><tr align="left">
                                            <th>PRODUCT</th>
                                            <th style="padding-left: 15px;">DESCRIPTION</th>
                                            <th>QUANTITY</th>
                                            <th>PRICE </th>
                                        </tr>
                                        '.$invoice_product.'<tr align="left">
                                            <th>PRODUCT</th>
                                            <th style="padding-left: 15px;">DESCRIPTION</th>
                                            <th>QUANTITY</th>
                                            <th>PRICE </th>
                                        </tr><tr class="pad-left-right-space ">
                                            <td class="m-t-5" colspan="2" align="left">
                                                <p style="font-size: 14px;">Subtotal : </p>
                                            </td>
                                            <td class="m-t-5" colspan="2" align="right">
                                                <b style="">'.number_format($total,2).'INR</b>
                                            </td>
                                        </tr>
                                        <tr class="pad-left-right-space">
                                            <td colspan="2" align="left">
                                                <p style="font-size: 14px;">SHIPPING Charge :</p>
                                            </td>
                                            <td colspan="2" align="right">
                                                <b> '.number_format($orders_info['shipping_cost'],2).'INR</b>
                                            </td>
                                        </tr>
                                        <tr class="pad-left-right-space ">
                                            <td class="m-b-5" colspan="2" align="left">
                                                <p style="font-size: 14px;">Total :</p>
                                            </td>
                                            <td class="m-b-5" colspan="2" align="right">
                                                <b>'.number_format($orders_info['total_order_price'],2).'INR</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>';
                    print_r($invoice_mail); exit;
                                        
                        /*$this->load->library('email');
                        $this->email->set_mailtype("html");
                        $this->email->from('info@neolayr.com', 'My Indian Toy');
                        $this->email->to($userInfo['email'], $userInfo['email']);
                        $this->email->subject('Reset password instructions');
                        
                        
                        $this->email->message($invoice_mail);
                        
                        $this->email->set_newline("\r\n");
                        $this->email->send();*/ 
                        
                        $api = '7a27fb51afcc9cc732b47c893b929148-713d4f73-a5fac691';
                        $from = 'info@neolayr.com';
                        $to = 'dsayan38@gmail.com';
                        $subject = 'Thank you for your order';
                        
                        $url = 'https://api:'.$api.'@api.mailgun.net/v3/mail.notionalsystems.in/messages';
                        $postfields = 'from='.$from.'&to='.$to.'&subject='.$subject.'&html='.$invoice_mail;
                        $data = $this->cUrlGetData($url,$postfields);
                        var_dump($data);die;
    }
    public function generate_checksum(){
        $data = array('amount' => '1.00',
                      'checksum' => '865fb6dad775e36ac9afa37affd5194d1f8b139b124261f6801e1c3b07cc9f86',
                      'merchantLogo' =>'',
                      'merchantName' =>'',
                      'merchantTxnId' => '202006031147261',
                      'metadata' => '',
                      'status' => 'COMPLETED',
                      'txnId' => 'EZpfh7yEVcWYt4_202006031147261_1' );
        /*$data = array('amount' => '1.00',
                      'checksum' => 'd19ca19ee1a4414a475faf7a14ee6444ab3f476ff16b53b1657c0ee6bf4ecc17',
                      'merchantTxnId' => '202006031156061',
                      'status' => 'COMPLETED',
                      'txnId' => 'EZpfh7yEVcWYt4_202006031156061_1');*/
        $string = "{";
        $counter = 1;
        foreach($data as $key=>$value){
                        if($key!='checksum'){
                            if($value!=""){
                                $string.='"'.$key.'":"'.$value.'"';
                                if($counter<(sizeof($data)))
                                $string.=',';
                            }
                            
                        }
                        $counter++;
        }
        $string.="}".freecharge_key;
        $generated_hash = hash('sha256', $string);
        echo $generated_hash;
        echo "<br>".$data['checksum'];
    }
    

            public function convertInWord()
            {
                $number = '12505.65';
                $decimal = round($number - ($no = floor($number)), 2) * 100;
                $decimal_part = $decimal;
                $hundred = null;
                $hundreds = null;
                $digits_length = strlen($no);
                $decimal_length = strlen($decimal);
                $i = 0;
                $str = array();
                $str2 = array();
                $words = array(0 => '', 1 => 'one', 2 => 'two',
                    3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                    7 => 'seven', 8 => 'eight', 9 => 'nine',
                    10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                    13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                    16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                    19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                    40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                    70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
                $digits = array('', 'hundred','thousand','lakh', 'crore');

                while( $i < $digits_length ) {
                    $divider = ($i == 2) ? 10 : 100;
                    $number = floor($no % $divider);
                    $no = floor($no / $divider);
                    $i += $divider == 10 ? 1 : 2;
                    if ($number) {
                        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                        $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                    } else $str[] = null;
                }

                $d = 0;
                while( $d < $decimal_length ) {
                    $divider = ($d == 2) ? 10 : 100;
                    $decimal_number = floor($decimal % $divider);
                    $decimal = floor($decimal / $divider);
                    $d += $divider == 10 ? 1 : 2;
                    if ($decimal_number) {
                        $plurals = (($counter = count($str2)) && $decimal_number > 9) ? 's' : null;
                        $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
                        @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number].' '. $digits[$decimal_number]. $plural.' '.$hundred:$words[floor($decimal_number / 10) * 10].' '.$words[$decimal_number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                    } else $str2[] = null;
                }

                $Rupees = implode('', array_reverse($str));
                $paise = implode('', array_reverse($str2));
                $paise = ($decimal_part > 0) ? 'and '.$paise . ' Paise' : '';
                echo  ($Rupees ? $Rupees . 'Rupees  ' : '') . $paise;

    
            }

    public function summary()
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('shoppingcart');
        $head['title'] = "Summary";
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $productVariant = $this->input->get('variant', TRUE);
        $data['productVariant'] = $productVariant;
        $quizProduct = $this->input->get('quiz', TRUE);
        $data['quizProduct'] = $quizProduct;
        $quizProductCategory = $this->input->get('category_type', TRUE);
        $data['quizProductCategory'] = $quizProductCategory;
        // echo (isset($_SESSION['logged_user']));
        // exit;
        // if($quizProduct != 'yes'){
        //     $this->Public_model->updateISQuizProduct($_SESSION['logged_user']);
        // }
        //echo "productVariant".$productVariant; exit;
         if (isset($_POST['payment_type'])) {
                    if($_POST['selected_address_id']==""){
                        $errors[] = "Please select proper address.";
                        $this->session->set_flashdata('submit_error', $errors);
                        redirect(LANG_URL . '/shopping_cart');
                    }else{
                        //echo "productVariant".$_POST['productVariant']; exit;
                        $_POST['id'] = [];
                        $_POST['quantity'] = [];
                        

                        $product_id = array();
                        $product_qunaitity = array();
                        $items = $this->shoppingcart->getCartItems();


                        foreach ($items['array'] as $cartItem) { 
                            array_push($product_id,$cartItem['id']);
                            array_push($product_qunaitity,$cartItem['num_added']);
                        }
                        $_POST['id'] = $product_id;
                        $_POST['quantity'] = $product_qunaitity;

                        $product_id_buynow = array();
                        $product_qunaitity_buynow = array();
                        if($_POST['productVariant'] != ''){
                            $data_cart = array();
                            foreach($items['array'] as $item){
                                if($_POST['productVariant'] == $item['product_id']){
                                    array_push($product_id_buynow,$item['id']);
                                    array_push($product_qunaitity_buynow,$item['num_added']);
                                    //array_push($_POST, $item);
                                }
                            }
                            $_POST['id'] = $product_id_buynow;
                            $_POST['quantity'] = $product_qunaitity_buynow;
                            // $items['array'] = $data_cart;
                            

                        }
                        
                        $address_details = $this->Public_model->getAddressDetails($_POST['selected_address_id']);
                        
                        $_POST['referrer'] = $this->session->userdata('referrer');
                        $_POST['clean_referrer'] = cleanReferral($_POST['referrer']);
                        $userInfo = $this->Public_model->getUserProfileInfo(isset($_SESSION['logged_user'])?$_SESSION['logged_user']:$_SESSION['guest_user_id']);
                        $_POST['user_id'] = isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : $_SESSION['guest_user_id'];
                        
                        $_POST['email'] = isset($userInfo['email']) ? $userInfo['email'] : 0;
                        
                        $_POST['first_name'] = $address_details['first_name'];
                        $_POST['last_name'] = $address_details['last_name'];
                        $_POST['phone'] = $address_details['phone'];
                        $_POST['address'] = $address_details['address'];
                        $_POST['country'] = $address_details['country_name'];
                        $_POST['city'] = $address_details['city_name'];
                        $_POST['post_code'] = $address_details['post_code'];
                        $_POST['thana'] = $address_details['state_name'];
                        $_POST['notes'] = $address_details['notes'];
                        
                        $shipping_cost= $_POST['shpping_cost'];
                        
                        $delivery_time= $_POST['delivery_time'];
                        $order_id =  date('YmdHis').$_POST['user_id'];
                        $pdfFilePath = 'Order_Invoice_'.$order_id.'.pdf';
                        

                        foreach ($_POST['id'] as $productID) {
                            $this->Public_model->removeFromCartTable($productID,$_SESSION['logged_user']);
                        }
                        // echo "<pre>";
                        // print_r($_POST); exit;
                            
                        $orderId = $this->Public_model->setOrder($order_id,$_POST,$shipping_cost,$delivery_time,$pdfFilePath);
                        if ($orderId != false) {

                            //$this->sendWhatsAppSMS($orderId,'neolayr');
                            $orders_info = $this->Public_model->getOrderDetails($orderId);
                            $userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);

                            $userPointSum = $this->Public_model->getUserPointSum($orders_info['user_id']);
                            $totalSuccTransaction = $this->Public_model->totalSuccTransaction($orders_info['user_id']);
                            $tot_trans_amount = ($userPointSum['total_purchased_value']+$orders_info['total_order_price']);
                            $tier = $this->Public_model->getTier($tot_trans_amount);

                            $pointBalance = ($orders_info['total_order_price']);
                            $currentPointBalance = round($userPointSum['balancePont']+$userPointSum['bonusPoint']-$orders_info['paid_by_point'], 2);

                            if($orders_info['paid_by_point'] != 0){
                                $this->Public_model->setCustomerPointRedeem($orders_info, $userInfo,$orders_info['paid_by_point'],$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);
                            }

                             if($userPointSum && $orders_info['paid_by_point'] != 0){
                                // $this->Public_model->updateUserPointRollUpsFrPoint($orders_info['user_id'], $tier['tierMasterID'], $userPointSum['totalEarnPoint']+$pointBalance,$currentPointBalance,$userPointSum['bonusPoint'],$tot_trans_amount,$userPointSum['redeem_point']+$orders_info['paid_by_point']);

                                 $this->Public_model->updateUserPointRollUpsFrPoint($orders_info['user_id'], $currentPointBalance,$userPointSum['redeem_point']+$orders_info['paid_by_point']);

                               $this->sendWhatsAppSMSPhaseOne($userInfo['phone'],$userInfo['name'],'redeem_points_near_expiry');
                            }

                                /* Start reward */
                        // when unicommerce send status completed this time insert data into customer_point table & and update data into user_point_rollups table
                        //if($_POST['payment_type'] == 'cashOnDelivery'){
                            //print_r("payment_type", $_POST['payment_type']);
                            $totalTransactionBalance = $this->Public_model->totalTransactionBalance($orders_info['user_id']);
                             // $userPointSum = $this->Public_model->getUserPointSum($orders_info['user_id']);
                            /*$totalSuccTransaction = $this->Public_model->totalSuccTransaction($orders_info['user_id']);
                            $tot_trans_amount = 0;
                            foreach ($totalSuccTransaction as $transaction) {
                                if($transaction['payment_type'] == 'Razorpay'){
                                    if($transaction['payment_status'] == 'completed'){
                                         $tot_trans_amount += $transaction['total_order_price'];
                                    }
                                }
                            } */

                            // $tier = $this->Public_model->getTier($totalTransactionBalance);
                            // //print_r($tier); die();

                            // // $pointBalance = (($orders_info['total_order_price'] * $tier['pointPercentage']) / 100);
                            // $pointBalance = ($orders_info['total_order_price']);
                            // //echo $pointBalance; exit;

                            // $customerPoint = $this->Public_model->getCustomerPoint($orders_info['user_id']);
                            // if($customerPoint){
                            //     $currentPointBalance = ($customerPoint['currentPointBalance'] + $pointBalance);
                            // }
                            // else{
                            //     $currentPointBalance = $pointBalance;
                            // }
                            
                            // $customerPoint = $this->Public_model->setCustomerPoint($orders_info, $userInfo,$pointBalance,$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);

                            // $totalCurrentBalance = $this->Public_model->totalCurrentBalance($orders_info['user_id']);
                            
                            // $totalPointBalance = $this->Public_model->totalPointBalance($orders_info['user_id']);
                            // $point = 0;
                            // foreach ($totalPointBalance as $value) {
                            //     $point += $value['pointBalance'];
                            // }
                            // //print_r($point); exit;

                           
                           
                            
                            // if($userPointSum){
                            //      $total_transactionAmount = $userPointSum['total_purchased_value'] + $orders_info['total_order_price'];
                            //     $this->Public_model->updateUserPointSum($orders_info, $point, $tier['tierMasterID'], $currentPointBalance, $total_transactionAmount);
                            // }
                            // else{
                            //     $this->Public_model->setUserPointSum($orders_info,$point, $tier['tierMasterID'], $currentPointBalance,$total_transactionAmount);
                            // }
                            // if($_POST['paid_amount'] != 0){
                            // $paidPoin = ($_POST['paid_amount']);
                            // $reward_point = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);
                            // $balancePont = ($reward_point['balancePont'] - $paidPoin);
                            // $this->Public_model->updateRollups($_SESSION['logged_user'], $balancePont);
                            // }
                        //}
                            /* End reward */

                            /* start referral coupon */
                             // $isReferralExist = $this->Public_model->checkReferralExist($_SESSION['referral_code'], $orders_info['user_id']);
                             // if($isReferralExist){
                             //    $text = "";
                             //    $length_of_string = 6;
                             //    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                         
                             //    $text =  substr(str_shuffle($str_result),0, $length_of_string);
                             //       $coupon = $this->Public_model->createCoupon(strtoupper($text));
                             //       $this->Public_model->couponReferralTranslations($_SESSION['referral_code'], $orderId, $orders_info['user_id']);
                             //}
                            /* stop referral coupon */
                            /* insert_order_tracking */
                            $orders_product_info = $this->Public_model->getOrderProductDetails($orders_info['orderID']);
                            foreach ($orders_product_info as $product_info) {
                                $arr_products = unserialize($product_info['order_products']);
                                $orderID = $_SESSION['order_id'];
                                $order_product_id = $product_info['order_product_id'];
                                $skuCode = $arr_products['product_info']['sku'];
                                $status = $product_info['status'];
                                $remarks = '';
                                $insertID = $this->Public_model->insert_order_tracking($orderId,$order_product_id,$skuCode,$status,$remarks);
                            }
                            /* End insert_order_tracking stop */
                            if($_POST['birthday_amount'] != ''){
                                $this->Public_model->updateDiscountCode($_POST['phone']);
                            }
                            /* checking birthday coupon */

                            if($_POST['giftAmount'] > 0){
                                $this->Public_model->updateGiftDiscountCode($_POST['giftVoucher'],$orderId);
                            }
                            /* stop birthday coupon*/
                             /* start referral reward */

                    $getReferral = $this->Public_model->getReferral($orders_info['user_id']);
                    if($getReferral['other_referral'] == $orders_info['isReferral']){

                        $getOtherReferral = $this->Public_model->getOtherReferral($getReferral['other_referral']);
                            //if($_SESSION['referral_code'] != ''){
                        $isReferralExist = $this->Public_model->checkIsReferralInOrder($orders_info['user_id'],$orders_info['isReferral']);

                              $tot_bonus_point = 0;
                            if($isReferralExist != false){
                                $referralOwner = $this->Public_model->checkIsReferralOwner($orders_info['isReferral']);

                                $pointBalances = 500;
                                $owner_referralCode = $this->Public_model->ownerReferralCode($orders_info['isReferral']);

                                $ownerBounsPoint = $this->Public_model->ownerBonusPoint($referralOwner['id']);

                                $tot_bonus_point = ($ownerBounsPoint['bonusPoint'] + $pointBalances);
                                
                                $this->Public_model->updateOwnerBonusPoint($referralOwner['id'], $tot_bonus_point);
                                
                               // $customerPoints = $this->Public_model->getCustomerPoint($orders_info['user_id']);
                                $customerPoints = $this->Public_model->getCustomerPoint($referralOwner['id']);
                                if($customerPoints){
                                    $currentPointBalance = ($customerPoints['currentPointBalance'] + $pointBalances);
                                }
                                else{
                                    $currentPointBalance = $pointBalances;
                                }
                                 $customerPoint = $this->Public_model->setCustomerPointForReffaralReward($referralOwner['id'],$orders_info, $userInfo,$pointBalances,$currentPointBalance,$tier['tierMasterID'],$userPointSum['tier']);
                            
                              }
                          }

                          //    if($this->session->userdata('referral_code') != ''){
                          //     $isReferralExist = $this->Public_model->checkIsReferralInOrder($_SESSION['logged_email'],$this->session->userdata('referral_code'));
                          //     //print_r($this->session->userdata('referral_code')); exit;
                          //     $tot_bonus_point = 0;
                          //     if($isReferralExist == true){
                          //       $bonus_point = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);

                          //       $tot_bonus_point = ($bonus_point['bonusPoint'] + 500);
                          //       $this->Public_model->updateUserBonusPoint($orders_info, $tot_bonus_point);

                          //       $pointBalances = 500;
                          //       $customerPoints = $this->Public_model->getCustomerPoint($orders_info['user_id']);
                          //       if($customerPoints){
                          //           $currentPointBalance = ($customerPoints['currentPointBalance'] + $pointBalances);
                          //       }
                          //       else{
                          //           $currentPointBalance = $pointBalances;
                          //       }
                          //        $customerPoint = $this->Public_model->setCustomerPoint($orders_info, $userInfo,$pointBalances,$currentPointBalance);
                            
                          //     }
                          // }
                             /* stop referral reward */

                            $this->session->set_userdata('orderId', $orderId);
                            if($_POST['payment_type'] == 'cashOnDelivery'){
                                $this->generatePDF_EmailNotification($orderId);
                            }
                            $this->orderId = $orderId;
                            $massageID  = 160329;
                            $this->sendSMS($massageID,$orders_info['phone']);
                            //$orderId = $this->Public_model->setCustomerPoint($);
                            //  $this->setVendorOrders();
                              //$this->sendNotifications();

                              $this->sendWhatsAppSMS($orderId,'order_placed');
                              $this->sendEmailNotifications($orderId);
                              $this->goToDestination($_POST['productVariant']);
                            //  $this->orderByShiprocket($orderId);
                               

                        } else {
                            log_message('error', 'Cant save order!! ' . implode('::', $_POST));
                            $this->session->set_flashdata('order_error', true);
                            redirect(LANG_URL . '/checkout/order-error');
                        }
                    }
                    
                    
                
        }
        $data['recentlyAdded'] = $this->Public_model->getRecentlyAddedProduct();
        $data['featuredProducts'] = $this->Public_model->getFeatured_products();
        // echo "<pre>";
        // print_r($data['featuredProducts']); exit;
        $data['bank_account'] = $this->Orders_model->getBankAccountSettings();
        $data['cashondelivery_visibility'] = $this->Home_admin_model->getValueStore('cashondelivery_visibility');
         $data['freecharge_payment'] = $this->Home_admin_model->getValueStore('freecharge_payment');
        $data['razorpay_payment'] = $this->Home_admin_model->getValueStore('razorpay_payment');
        $data['bestSellers'] = $this->Public_model->getbestSellers();
        $data['allCoupons'] = $this->Public_model->getAllCoupons($_SESSION['logged_mobile']);
        $data['giftCoupons'] = $this->Public_model->getGiftVouchers($_SESSION['logged_user']);
        $data['previous_address'] = array();
        // echo "<pre>";
        // print_r($data['allCoupons']); exit;
        //Get last order address
        $previous_address = array();;
        if(isset($_SESSION['logged_user'])){
            $previous_address = $this->Public_model->getPreviousAddress($_SESSION['logged_user']);
            $data['previous_address'] = $previous_address;
            $selectedAddress = $previous_address[0]['state'];
            $data['selectedAddress'] = $previous_address[0]['state'];
            
            $data['selected_address_id'] = $previous_address[0]['address_id'];
            $postCode = $previous_address[0]['post_code'];
            $this->checkDeliverPin($postCode);
            // echo $postCode;
            // exit;
        }

        $district_list = $this->Public_model->getdistrictlist();
        /*foreach($district_list as $district){
            if($district['is_default'] == 'yes')
            $district_id = $district['district_id'];
        }*/
        $getCurentTier = $this->Public_model->getCurentTier($_SESSION['logged_user']);
        $userdetails = $this->Public_model->checkIsreferral($_SESSION['logged_user']);
        $items = $this->shoppingcart->getCartItems();
        //print_r($items); die();
        $cartQuizData = $this->Public_model->getCartDatafrQuiz($_SESSION['logged_user']);
        $data['quizdiscountAmoun'] = 0;
        $quizdiscountAmoun = 0;
        //if($quizProduct != '' && $quizProductCategory != 24){
        if(sizeof($cartQuizData)>0){
            //$quizProduct = $this->Public_model->quizProduct($_SESSION['logged_user']);
            $quiz_tot_price = 0;
            foreach ( $cartQuizData as $var ) {
                $price = str_replace(",", "", $var['amount']);
                $quiz_tot_price += ($price*1);
            }
            $quizPricePercentage = (($quiz_tot_price*20)/100);
            $data['quizdiscountAmoun'] = round($quizPricePercentage,2);
            $data['quizTotAmoun'] = $data['quizdiscountAmoun'];
            $quizdiscountAmoun = $data['quizTotAmoun'];
            

        }

        $ref_tot_price = 0;
        $tot_price = 0;
        foreach ( $items['array'] as $var ) {
            $price = str_replace(",", "", $var['price']);
            $ref_tot_price += ($price*$var['num_added']);
            $tot_price += ($price*$var['num_added']);
        }
        //  echo "tot_price ".$tot_price;
        //  echo "quizdiscountAmoun ".$quizdiscountAmoun;
        // // exit;
        // //$delivery_amount = 0;
        $disTotPrice = $tot_price-$quizdiscountAmoun;
        // echo "disTotPrice".$disTotPrice;
        // exit;
        $data['delivery_amount'] = '0.00';
        if($productVariant == ''){
            if($tot_price >= 1000){
                $data['delivery_amount'] = '0.00';
            }else{
                if($getCurentTier['tier'] == '1' && sizeof($previous_address)>0){
                     if($selectedAddress == '41'){
                         $data['delivery_amount'] = '45.00';
                     }else{
                         $data['delivery_amount'] = '65.00';
                     }
                }
                else{
                        $data['delivery_amount'] = '0.00';
                }
            }
        }
        if($productVariant != ''){
            $productData = $this->Public_model->buyNowProductData($productVariant,$_SESSION['logged_user']);
            $prices = str_replace(",", "", $productData['price']);
            $tot_prices = ($prices*$productData['qty']);
            // echo $tot_prices;
            // exit;

            if($tot_prices >= 1000){
                $data['delivery_amount'] = '0.00';
            }else{
                if($getCurentTier['tier'] == '1' && sizeof($previous_address)>0){
                     if($selectedAddress == '41'){
                         $data['delivery_amount'] = '45.00';
                     }else{
                         $data['delivery_amount'] = '65.00';
                     }
                }
                else{
                        $data['delivery_amount'] = '0.00';
                }
            }
        }
        
        //print_r($ref_tot_price); die();
        $referral_exists = "0";
        $isReferralExist = $this->Public_model->checkIsReferralInOrderTwo($_SESSION['logged_email'],$userdetails['other_referral']);
        $isUserAlreadyOrder = $this->Public_model->isUserAlreadyOrder($_SESSION['logged_user']);
        // echo "<pre>";
        // print_r(sizeof($isUserAlreadyOrder));
        // exit;
        //if(sizeof($isUserAlreadyOrder)<=0){
            if(sizeof($isReferralExist)>0){
            //echo "ok";
        foreach ($isReferralExist as $value) {
            if($value['payment_type'] == 'Razorpay'){
                //echo "if";
                if($value['payment_status'] != 'pending'){
                    $referral_exists = "1";
                }
            }else{
                if($value['payment_status'] == 'pending'){
                    //echo "else";
                    $referral_exists = "1";
                }
            }
        
        }
        }
        else{
            $referral_exists = '0';
        }
        // }
        // else{
        //     $referral_exists = '0';
        // }
        
        // echo "referral_exists".$referral_exists; 
        // exit;

        // echo $_SESSION['logged_user'];
        // exit;
        if($referral_exists == '0'){
        $isReferral = $this->Public_model->checkIsreferral($_SESSION['logged_user']);
        //print_r($isReferral); exit;
        if($isReferral['other_referral'] != '' && $ref_tot_price >= 500){
            $data['otherReferral'] = $isReferral['other_referral'];
            //$data['otherReferralPrices'] = 200;;
            $data['otherReferralPrices'] = ($tot_price*15)/100;
            //echo "1st";
        }
        else{
            $data['otherReferralPrices'] = 0;
            $data['otherReferral'] = '';
            //echo "2nd";
        }
        }
        else{
            $data['otherReferralPrices'] = 0;
            $data['otherReferral'] = '';
        }
       // print_r($isReferral); die();
        $totalReward = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);
        
        // $tot = 0;
        //     foreach ( $totalReward as $var ) {
        //         $tot += $var['pointBalance'];
        //     }
        // echo "<pre>";
        // print_r($totalReward); exit;
        // if($productVariant != ''){
        //     echo "<pre>";
        //     print_r($items);

        // }
        //echo ($tot_price*10)/100;
        // exit;

        $data['user_email'] = $_SESSION['logged_email'];
        $data['pointBalance'] = $totalReward['balancePont'] + $totalReward['bonusPoint'];
        $data['country_list'] = $this->Public_model->getcountrylist();
        $data['state_list'] = $this->Public_model->getStatelist("101");
        $data['totalReward'] = $totalReward;
        $this->render('summary', $head, $data);
    }

    public function checkDeliverPin($pincode){
        $token = $this->Public_model->fetchShiprocketToken();

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/?delivery_postcode='.$pincode.'&pickup_postcode=700045&cod=1&weight=2',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$token['access_token']
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            //echo $response;
            $response_array = json_decode($response);
         
        }
        if($response_array->status == 200){
             $daliveryDate = $response_array->data->available_courier_companies[0]->estimated_delivery_days;
             $_SESSION['daliveryDate'] = $daliveryDate.' Business Days';
        }
        // else{
        //     echo "Sorry! Item(s) are not available in your location";
        // }
    }

    public function checkDeliverPinTwo(){
        $token = $this->Public_model->fetchShiprocketToken();
        $pincode = $_POST['pincode'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/?delivery_postcode='.$pincode.'&pickup_postcode=700045&cod=1&weight=2',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$token['access_token']
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            //echo $response;
            $response_array = json_decode($response);
         
        }
        if($response_array->status == 200){
             $daliveryDate = $response_array->data->available_courier_companies[0]->estimated_delivery_days;
              echo ($daliveryDate.' Business Days');
        }
    }

}
