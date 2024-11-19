<?php

class MY_Controller extends MX_Controller
{

    public $nonDynPages = array();
    private $dynPages = array();
    protected $template;

    public function __construct()
    {
        parent::__construct();
        $this->getActivePages();
        $this->checkForPostRequests();
        $this->setReferrer();
        //set selected template
        $this->loadTemplate();
		$all_categories = $this->Public_model->getShopCategories();
        $this->all_categories = $this->getCategories($all_categories);
		if($_SESSION['logged_user']!=""){
			$this->wishlist_counter = $this->Public_model->getUserWishlistCount($_SESSION['logged_user']);
		}else{
			$this->wishlist_counter = 0;
		}
        $this->state_list = $this->Public_model->getStatelist("101");
		$this->all_vendor = $this->Public_model->getVendorList();
		$this->all_state = $this->Public_model->getProductStateList();
    }

    /*
     * Render page from controller
     * it loads header and footer auto
     */

    public function render($view, $head, $data = null, $footer = null)
    {
        $head['cartItems'] = $this->shoppingcart->getCartItems();
        $head['sumOfItems'] = $this->shoppingcart->sumValues;
        if(isset($_SESSION['logged_user'])){
        //$head['preCartProduct'] = $this->Public_model->countCartProduct($_SESSION['logged_user']);
        $cartProduct = $this->Public_model->totalProduct($_SESSION['logged_user']);
        $tot_product = 0;
        foreach ( $cartProduct as $var ) {
            $tot_product += $var['qty'];
        }
        $head['preCartProduct'] = $tot_product;
        }
        $vars = $this->loadVars();
        $this->load->vars($vars);
        $all_categories = $this->Public_model->getShopCategories();

        function buildTree1(array $elements, $parentId = 0)
        {
            $branch = array();
            foreach ($elements as $element) {
                if ($element['sub_for'] == $parentId) {
                    $children = buildTree1($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        }

        $head['nav_categories'] = $tree = buildTree1($all_categories);
        $this->load->view($this->template . '_parts/header', $head);
        $this->load->view($this->template . $view, $data);
        $this->load->view($this->template . '_parts/footer', $footer);
    }

    /*
     * Load variables from values-store
     * texts, social media links, logos, etc.
     */

    private function loadVars()
    {
        $vars = array();
        $vars['nonDynPages'] = $this->nonDynPages;
        $vars['dynPages'] = $this->dynPages;
        $vars['footerCategories'] = $this->Public_model->getFooterCategories();
        $vars['sitelogo'] = $this->Home_admin_model->getValueStore('sitelogo');
		
		$vars['main_banner_section1'] = $this->Home_admin_model->getValueStore('main_banner_section1');
		$vars['main_banner_section1_link'] = $this->Home_admin_model->getValueStore('main_banner_section1_link');
		$vars['main_banner_section2'] = $this->Home_admin_model->getValueStore('main_banner_section2');
		$vars['main_banner_section2_link'] = $this->Home_admin_model->getValueStore('main_banner_section2_link');
		$vars['main_banner_section3'] = $this->Home_admin_model->getValueStore('main_banner_section3');
		$vars['main_banner_section3_link'] = $this->Home_admin_model->getValueStore('main_banner_section3_link');
		$vars['side_banner'] = $this->Home_admin_model->getValueStore('side_banner');
		$vars['side_banner_link'] = $this->Home_admin_model->getValueStore('side_banner_link');
		$vars['footer_banner_section1'] = $this->Home_admin_model->getValueStore('footer_banner_section1');
		$vars['footer_banner_section1_link'] = $this->Home_admin_model->getValueStore('footer_banner_section1_link');
		$vars['footer_banner_section2'] = $this->Home_admin_model->getValueStore('footer_banner_section2');
		$vars['footer_banner_section2_link'] = $this->Home_admin_model->getValueStore('footer_banner_section2_link');
		$vars['footer_banner_section3'] = $this->Home_admin_model->getValueStore('footer_banner_section3');
		$vars['footer_banner_section3_link'] = $this->Home_admin_model->getValueStore('footer_banner_section3_link');
		
        $vars['naviText'] = htmlentities($this->Home_admin_model->getValueStore('navitext'));
        $vars['footerCopyright'] = htmlentities($this->Home_admin_model->getValueStore('footercopyright'));
        $vars['contactsPage'] = $this->Home_admin_model->getValueStore('contactspage');
        $vars['footerContactAddr'] = htmlentities($this->Home_admin_model->getValueStore('footerContactAddr'));
        $vars['footerContactPhone'] = htmlentities($this->Home_admin_model->getValueStore('footerContactPhone'));
        $vars['footerContactEmail'] = htmlentities($this->Home_admin_model->getValueStore('footerContactEmail'));
        $vars['footerAboutUs'] = $this->Home_admin_model->getValueStore('footerAboutUs');
        $vars['footerSocialFacebook'] = $this->Home_admin_model->getValueStore('footerSocialFacebook');
        $vars['footerSocialInstagram'] = $this->Home_admin_model->getValueStore('footerSocialInstagram');	
        $vars['footerSocialTwitter'] = $this->Home_admin_model->getValueStore('footerSocialTwitter');
        $vars['footerSocialGooglePlus'] = $this->Home_admin_model->getValueStore('footerSocialGooglePlus');
        $vars['footerSocialPinterest'] = $this->Home_admin_model->getValueStore('footerSocialPinterest');
        $vars['footerSocialYoutube'] = $this->Home_admin_model->getValueStore('footerSocialYoutube');
        $vars['footerSocialLinkedin'] = $this->Home_admin_model->getValueStore('footerSocialLinkedin');
        $vars['footerSocialAmazon'] = $this->Home_admin_model->getValueStore('footerSocialAmazon');
        $vars['footerSocialNykaa'] = $this->Home_admin_model->getValueStore('footerSocialNykaa');
        $vars['addedJs'] = $this->Home_admin_model->getValueStore('addJs');
        $vars['publicQuantity'] = $this->Home_admin_model->getValueStore('publicQuantity');
        $vars['moreInfoBtn'] = $this->Home_admin_model->getValueStore('moreInfoBtn');
        $vars['multiVendor'] = $this->Home_admin_model->getValueStore('multiVendor');
        $vars['allLanguages'] = $this->getAllLangs();
        $vars['load'] = $this->loop;
        $vars['cookieLaw'] = $this->Public_model->getCookieLaw();
        $vars['codeDiscounts'] = $this->Home_admin_model->getValueStore('codeDiscounts');
        $vars['showRating'] = $this->Home_admin_model->getValueStore('showRating');
        return $vars;
    }

    /*
     * Get all added languages from administration
     */

    private function getAllLangs()
    {
        $arr = array();
        $this->load->model('admin/Languages_model');
        $langs = $this->Languages_model->getLanguages();
        foreach ($langs as $lang) {
            $arr[$lang->abbr]['name'] = $lang->name;
            $arr[$lang->abbr]['flag'] = $lang->flag;
        }
        return $arr;
    }

    /*
     * Active pages for navigation
     * Managed from administration
     */

    private function getActivePages()
    {
        $this->load->model('admin/Pages_model');
        $activeP = $this->Pages_model->getPages(true);
        $dynPages = $this->config->item('no_dynamic_pages');
        $actDynPages = [];
        foreach ($activeP as $acp) {
            if (($key = array_search($acp, $dynPages)) !== false) {
                $actDynPages[] = $acp;
            }
        }
        $this->nonDynPages = $actDynPages;
        $dynPages = getTextualPages($activeP);
        $this->dynPages = $this->Public_model->getDynPagesLangs($dynPages);
    }

    /*
     * Email subscribe form from footer
     */

    private function checkForPostRequests()
    {
        if (isset($_POST['subscribeEmail'])) {
            $arr = array();
            $arr['browser'] = $_SERVER['HTTP_USER_AGENT'];
            $arr['ip'] = $_SERVER['REMOTE_ADDR'];
            $arr['time'] = time();
            $arr['email'] = $_POST['subscribeEmail'];
            if (filter_var($arr['email'], FILTER_VALIDATE_EMAIL) && !$this->session->userdata('email_added')) {
                $this->session->set_userdata('email_added', 1);
                $res = $this->Public_model->setSubscribe($arr);
                $this->session->set_flashdata('emailAdded', lang('email_added'));
            }
            if (!headers_sent()) {
                redirect();
            } else {
                echo 'window.location = "' . base_url() . '"';
            }
        }
    }

    /*
     * Set referrer to save it in orders
     */

    private function setReferrer()
    {
        if ($this->session->userdata('referrer') == null) {
            if (!isset($_SERVER['HTTP_REFERER'])) {
                $ref = 'Direct';
            } else {
                $ref = $_SERVER['HTTP_REFERER'];
            }
            $this->session->set_userdata('referrer', $ref);
        }
    }

    /*
     * Check for selected template 
     * and set it in config if exists
     */

    private function loadTemplate()
    {
        $template = $this->Home_admin_model->getValueStore('template');
        if ($template == null) {
            $template = $this->config->item('template');
        } else {
            $this->config->set_item('template', $template);
        }
        if (!is_dir(TEMPLATES_DIR . $template)) {
            show_error('The selected template does not exists!');
        }
        $this->template = 'templates' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR;
    }
	 private function getCategories($categories)
    {

        /*
         * Tree Builder for categories menu
         */

        function buildCategoryTree(array $elements, $parentId = 0)
        {
            $branch = array();
            foreach ($elements as $element) {
                if ($element['sub_for'] == $parentId) {
                    $children = buildCategoryTree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        }

        return buildCategoryTree($categories);
    }

    
    public function sendWhatsAppSMSPhaseOne($mobile = '',$name = '',$template_name = '')
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://live-server-113762.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91'.$mobile,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "template_name": "'.$template_name.'",
            "broadcast_name": "palson",
            "parameters": [
                {
                    "name": "name",
                    "value": "'.$name.'"
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
    public function sendWhatsAppSMSPointsEarned($mobile = '',$pointBalance = '',$template_name = '', $point_exp = '')
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://live-server-113762.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91'.$mobile,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "template_name": "'.$template_name.'",
            "broadcast_name": "palson",
            "parameters": [
                {
                    "name": "points",
                    "value": "'.$pointBalance.'"
                },
                {
                    "name": "date",
                    "value": "'.$point_exp.'"
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
    public function sendWhatsAppSMSBirthDayCoupon($mobile = '',$discount_code = '',$template_name = '')
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://live-server-113762.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91'.$mobile,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "template_name": "'.$template_name.'",
            "broadcast_name": "palson",
            "parameters": [
                {
                    "name": "discount_code",
                    "value": "'.$discount_code.'"
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
     public function sendWhatsAppSMSrequestCallbackDermatologist($mobile = '',$name = '',$template_name = '',$dermaMob = '')
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://live-server-113762.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91'.$dermaMob,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "template_name": "'.$template_name.'",
            "broadcast_name": "palson",
            "parameters": [
                {
                    "name": "name",
                    "value": "'.$name.'"
                },
                {
                    "name": "mobile",
                    "value": "'.$mobile.'"
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
    public function sendSMS($massageID,$phone,$var_one='',$var_two='')
    {
        // echo "massageID".$massageID."<br>";
        // echo "phone".$phone."<br>";
        // echo $var_one;
        // exit;
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.fast2sms.com/dev/bulkV2?route=dlt&sender_id=NLRPRO&message='.$massageID.'&variables_values='.$var_one.'|'.$var_two.'&numbers='.$phone,
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
    public function sendWhatsAppCancelSMS($phoneNumber,$template_name)
    {
        
       
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://live-server-113762.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91'.$phoneNumber,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "template_name": "'.$template_name.'",
            "broadcast_name": "palson"
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
    public function sendWhatsAppOrderDeliver($orderId='',$template_name='')
    {
        //$orderId = '202312051155241';
        //echo $orderId;
        //$template_name = 'order_delivered';
        $orderdata = $this->Public_model->findOrderID($orderId);
        $orders_info = $this->Public_model->getUserOrderDetailsTwo($orderdata['id']);
        //$orders_info = $this->Public_model->getOrderDetails($orderId);
        

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://live-server-113762.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91'.$orders_info[0]['phone'],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "template_name": "'.$template_name.'",
            "broadcast_name": "palson",
            "parameters": [
                {
                    "name": "name",
                    "value": "'.$orders_info[0]['first_name'].'"
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
    public function sendWhatsAppSMS($orderId = '',$template_name = '')
    {
        $orderdata = $this->Public_model->findOrderID($orderId);
        $orders_info = $this->Public_model->getUserOrderDetailsTwo($orderdata['id']);
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://live-server-113762.wati.io/api/v1/sendTemplateMessage?whatsappNumber=91'.$orders_info[0]['phone'],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "template_name": "'.$template_name.'",
            "broadcast_name": "palson",
            "parameters": [
                {
                    "name": "name",
                    "value": "'.$orders_info[0]['first_name'].'"
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
    
}
