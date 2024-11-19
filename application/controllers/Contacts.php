<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    public function index()
    {
        $head = array();
        $data = array();
        if (isset($_POST['message'])) {
            $item = $this->Public_model->insertContacts($_POST);
            $result = $this->sendEmail();
            if ($result) {
                $this->session->set_flashdata('resultSend', 'Thank you for reaching to us. Will get back to you soon!');
            } else {
                $this->session->set_flashdata('resultSend', 'Please try again later!');
            }
            //redirect('contacts');
        }
        $data['googleMaps'] = $this->Home_admin_model->getValueStore('googleMaps');
        $data['googleApi'] = $this->Home_admin_model->getValueStore('googleApi');
        $arrSeo = $this->Public_model->getSeo('contacts');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('contacts', $head, $data);
    }

    private function sendEmail()
    {

            //     $toName = $_POST['name'];
            //     $toEmail = $_POST['email'];
            //     $fromName = 'NEOLAYR';
            //     $fromEmail = 'neolayrpro@palsonsderma.com';
            //     $subject = 'CONTACT US';
            //     $htmlMessage = "Contact Number : ".$_POST['contact_number']."<br>Message : ".$_POST['message'];

            //     $data = array(
            //         "sender" => array(
            //             "email" => $toEmail,
            //             "name" => $toName         
            //         ),
            //         "to" => array(
            //             array(
            //                 "email" => $fromEmail,
            //                 "name" => $fromName
            //                 )
            //         ), 
            //         "subject" => $subject,
            //         "htmlContent" => $htmlMessage
            //     ); 
            //     //echo json_encode($data);
            //     $curl = curl_init();

            //     curl_setopt_array($curl, array(
            //       CURLOPT_URL => 'https://api.sendinblue.com/v3/smtp/email',
            //       CURLOPT_RETURNTRANSFER => true,
            //       CURLOPT_ENCODING => '',
            //       CURLOPT_MAXREDIRS => 10,
            //       CURLOPT_TIMEOUT => 0,
            //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //       CURLOPT_CUSTOMREQUEST => 'POST',
            //       CURLOPT_SSL_VERIFYPEER => false,
            //       CURLOPT_POSTFIELDS => json_encode($data),
            //       CURLOPT_HTTPHEADER => array(
            //     'Api-Key: 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',
            //     'content-type: application/json'
            //   ),
            // ));
            //     $response = curl_exec($curl);
            //     $err = curl_error($ch);

            //     curl_close($ch);
                
            //     if ($err) {
            //       //echo "cURL Error #:" . $err;
            //     } else {
            //       //echo ($response);
            //         return true;
            //     }
        $myEmail = $this->Home_admin_model->getValueStore('contactsEmailTo');
        if (filter_var($myEmail, FILTER_VALIDATE_EMAIL) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->load->library('email');

            $this->email->from($_POST['email'], $_POST['name']);
            $this->email->to($myEmail);

            $this->email->subject($_POST['subject']);
            $this->email->message("Contact Number : ".$_POST['contact_number']."<br>Message : ".$_POST['message']);

            $this->email->send();
            return true;
        }
        return false;
    }

}
