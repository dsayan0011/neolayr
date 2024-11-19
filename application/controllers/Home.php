<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->Model('admin/Brands_model');
		$this->load->Model('admin/Vendor_model');
		$this->load->Model('admin/Products_model');
		$this->load->Model('admin/Pages_model');
		$this->load->Model('admin/Orders_model');
		$this->load->model('Orders_model');
    }

    public function index($page = 0)
    {

		//   $inputString = "SOURAV SOIURAV 1245 PANJA";
		// if (preg_match('/\d/', $inputString, $matches)) {
		//     $index = strpos($inputString, $matches[0]);
		//     $result = substr($inputString, 0, $index);
		//     echo "Resulting string: " . $result;
		// } else {
		//     echo "No numeric character found in the string.";
		// }

		//   die();
        $data = array();
        $head = array();
        $data['pageactive'] = "home";
        $referral = $this->input->get('referral', TRUE);
        $this->session->set_userdata('referral_code', $referral);
        $arrSeo = $this->Public_model->getSeo('home');
        $head['title'] = @$arrSeo['title'];
        if(isset($_GET['search_in_title']))
        $head['title'] = $_GET['search_in_title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $all_categories = $this->Public_model->getShopCategories();
        $data['home_categories'] = $this->getHomeCategories($all_categories);
		$data['home_slider'] = $this->Public_model->getHomeSlider();
        $data['all_categories'] = $all_categories;
        $data['countQuantities'] = $this->Public_model->getCountQuantities();
        $data['bestSellers'] = $this->Public_model->getbestSellers();
        $data['newProducts'] = $this->Public_model->getNewProducts();
        $data['homeProducts'] = $this->Public_model->getSliderProducts();
        $data['lastBlogs'] = $this->Public_model->getLastBlogs();
        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET);
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['showOutOfStock'] = $this->Home_admin_model->getValueStore('outOfStock');
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
		$data['post'] = $this->Public_model->getPosts(1, 0, null, null);
        $data['brands'] = $this->Brands_model->getBrands();
        $data['concern'] = $this->Public_model->getConcern();
        $data['testimonial'] = $this->Public_model->getTestimonial();
        $data['regime'] = $this->Public_model->getRegime();
        $data['storeLocator'] = $this->Public_model->getStoreLocator();
        $data['trendingProduct'] = $this->Public_model->getTrendingProduct();
        $data['recentlyAdded'] = $this->Public_model->getRecentlyAddedProduct();
        $data['mostView'] = $this->Public_model->getMostViewProduct();
        $data['giftSet'] = $this->Public_model->getRegimeProduct();
        $data['quizImages'] = $this->Public_model->getQuizImages(1);
        //$data['quizImages'] = $quizImage;
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        // echo "<pre>";
        // print_r($data['recentlyAdded']); exit;
        // exit();
        $this->render('home', $head, $data);
    }

    /*
     * Used from greenlabel template
     * shop page
     */

    public function shop($page = 0)
    {
        $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('shop');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $all_categories = $this->Public_model->getShopCategories();
        $data['home_categories'] = $this->getHomeCategories($all_categories);
        $data['all_categories'] = $all_categories;
        $data['showBrands'] = $this->Home_admin_model->getValueStore('showBrands');
        $data['brands'] = $this->Brands_model->getBrands();
        $data['showOutOfStock'] = $this->Home_admin_model->getValueStore('outOfStock');
        $data['shippingOrder'] = $this->Home_admin_model->getValueStore('shippingOrder');
        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET);
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['links_pagination'] = pagination('home', $rowscount, $this->num_rows);
        $this->render('shop', $head, $data);
    }

    private function getHomeCategories($categories)
    {

        /*
         * Tree Builder for categories menu
         */

        function buildTree(array $elements, $parentId = 0)
        {
            $branch = array();
            foreach ($elements as $element) {
                if ($element['sub_for'] == $parentId) {
                    $children = buildTree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }
            return $branch;
        }

        return buildTree($categories);
    }

    /*
     * Called to add/remove quantity from cart
     * If is ajax request send POST'S to class ShoppingCart
     */

    public function manageShoppingCart()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $this->shoppingcart->manageShoppingCart();
    }

    /*
     * Called to remove product from cart
     * If is ajax request and send $_GET variable to the class
     */

    public function removeFromCart()
    {

        $backTo = $_GET['back-to'];
        $productID = $_GET['delete-product'];
        $isQuizProduct = $this->Public_model->checkISQuizProduct($productID,$_SESSION['logged_user']);
        $QuizProduct= 0;
        if($isQuizProduct != ''){
        	$QuizProduct = 1;
        }
        $this->Public_model->removeFromCartTable($productID,$_SESSION['logged_user']);
        
        $this->shoppingcart->removeFromCart();
        if($QuizProduct == 1){
        	$this->Public_model->updateISQuizProduct($_SESSION['logged_user'],$isQuizProduct['category_type']);
        }
        $this->session->set_flashdata('deleted', lang('deleted_product_from_cart'));
        redirect(LANG_URL . '/' . $backTo);
    }

    public function clearShoppingCart()
    {
        $this->shoppingcart->clearShoppingCart();
    }

    public function viewProduct($id)
    {
        $data = array();
        $head = array();
        $this->load->vars($vars);
		$product = $this->Public_model->getOneProduct($id);
		$variants = $this->Public_model->getVariantsFrPDP($id);
		$data['allProduct'] = $this->Public_model->getAllProducts();
		$data['attributesOption'] = $this->Public_model->get_attributes_set_option();
		$data['ingredients'] = $this->Public_model->get_ingredients();
        $data['product'] = $product;
        $data['variants'] = $variants;
        $data['pRating'] = $product['rating'];
		$mostViewCount = ($product['most_view'] + 1);
		$this->Public_model->update_most_view($mostViewCount, $id);
		// echo "<pre>";
		// print_r($variants); die();
        
		if($product['related_products'] != ''){
		$related_product = explode(",",$product['related_products']);
		$relatedProductArray = array();
		foreach ($related_product as $rProduct) {
			$rItem = $this->Public_model->related_product($rProduct);
			array_push($relatedProductArray, $rItem);
		}
			$data['relatedProductArray'] = $relatedProductArray;
		}else{
			$data['relatedProductArray'] = '';
		}
		// echo "<pre>";
		// print_r($data['relatedProductArray']); die();
		$shop_categorie = explode(",",$product['shop_categorie']);
		$data['shop_categorie'] = $shop_categorie;
		$data['tags'] = explode(",",$product['tag']);
		$shop_categorie_array = array();
		array_push($shop_categorie_array, $shop_categorie[0]);
		$get_category = $this->Public_model->get_category_pdp($shop_categorie_array[0]);
		//if($category_details['sub_for'] != 1){
			$sub_category_details = $this->Public_model->categoryDetails($get_category['sub_for']);
	        $data['sub_category_details'] = $sub_category_details;
	        if($sub_category_details['sub_for'] == 4){
	        $data['fst_category_details'] = $this->Public_model->fst_category_details($sub_category_details['sub_for']);
	        }
	        $data['category_details'] = $get_category;
    	//}

        if($product['frequently_bought'] != ''){
        $frequently_product = explode(",",$product['frequently_bought']);
        $frequentlyProductArray = array();
        foreach ($frequently_product as $fProduct) {
            //same function call(related_product)
            $fItem = $this->Public_model->related_product($fProduct);
            array_push($frequentlyProductArray, $fItem);
        }
            $data['frequentlyProductArray'] = $frequentlyProductArray;
        }else{
            $data['frequentlyProductArray'] = '';
        }
        
		// if($product['frequently_bought'] != ''){
		// $frequently_bought = explode(",",$product['frequently_bought']);
		// $data['frequently_bought'] = $frequently_bought;
		// $sum = array();
		// $variantID = array();
		// $lastvalue =  end($frequently_bought);
		// $data['lastValue'] = $lastvalue;
		
		// foreach ($frequently_bought as $key => $value) {

		// 	$item = $this->Public_model->getSinglefrequentlyBought($value);
			
		// 	foreach ($item as $product) {
		// 		array_push($sum, $product['variantPrice']);
		// 		array_push($variantID, $product['variantID']);
		// 	}
			
		// }
		// }
		// else{
		// 	$data['frequently_bought'] = '';
		// }
		
		$data['variantID'] = implode(',', $variantID);
		$summation =  array_sum($sum);
		$data['summation'] = $summation;
        $data['sameCagegoryProducts'] = $this->Public_model->sameCagegoryProducts($data['product']['sku'], $id);
        
		if($product['vendor_id'] != "0"){
			$data['vendor_details'] = $this->Vendor_model->getVendorUsers($product['vendor_id']);
		}
        $vars['publicDateAdded'] = $this->Home_admin_model->getValueStore('publicDateAdded');
       
        $head['title'] = $data['product']['title'];
        $description = url_title(character_limiter(strip_tags($data['product']['description']), 130));
        $description = str_replace("-", " ", $description) . '..';
		$data['product_attribute'] = $this->Public_model->getProductAttribute($id);
		// echo "<pre>";
		// print_r($data['sameCagegoryProducts']); exit;
        $head['description'] = $description;
        $head['keywords'] = str_replace(" ", ",", $data['product']['title']);
		$reviews = $this->Public_model->getProductReview($id);
		$data['review'] = $reviews;
		$data['countTotalReview'] = $this->Public_model->countTotalReview($id);
		$totReview = 0;
        foreach ( $reviews as $review ) {
            $totReview += $review['rating'];
        }
        $data['totReview'] = $totReview;

        $VideoReviewsData = $this->Public_model->getProductVideoReview($id);
        if(sizeof($VideoReviewsData)>0){
        	$VideoReviewsArray = array();
			$VideoReviewsTitleArray = array();
			$video_link = explode(",",$VideoReviewsData['video_review_link']);
			$video_title = explode(",",$VideoReviewsData['video_title']);
		
			foreach ($video_link as $videoItem) {
				$videoItems = array('videoLink'=>$videoItem);
				array_push($VideoReviewsArray, $videoItems);
			}
			foreach ($video_title as $videoTitle) {
				$videoTitles = array('videoTitle'=>$videoTitle);
				array_push($VideoReviewsTitleArray, $videoTitles);
			}

				//$data['VideoReviewsData'] = $VideoReviewsData;
				// $data['VideoReviews'] = $VideoReviewsArray;
				// $data['VideoReviewsTitle'] = $VideoReviewsTitleArray;
			$video_final_arr = array();
			for ($i=0; $i < sizeof($VideoReviewsArray) ; $i++) { 
				$new_item = array(
					"videoLink" => $VideoReviewsArray[$i]['videoLink'],
					"videoTitle" => $VideoReviewsTitleArray[$i]['videoTitle']
				);
				array_push($video_final_arr, $new_item);

			}
				$data['video_final_arr'] = $video_final_arr;
		}else {
				$data['video_final_arr'] = '';
		}
        if ($data['product'] === null) {
            show_404();
        }
		// echo "<pre>";
        // print_r($video_final_arr);
        // echo "<pre>";
        // print_r($data['VideoReviewsTitle']);
        //die();
		// echo "<pre>";
		 // print_r($get_category); exit;
        $this->render('view_product', $head, $data);
    }

    public function confirmLink($md5)
    {
        if (preg_match('/^[a-f0-9]{32}$/', $md5)) {
            $result = $this->Public_model->confirmOrder($md5);
            if ($result === true) {
                $data = array();
                $head = array();
                $head['title'] = '';
                $head['description'] = '';
                $head['keywords'] = '';
                $this->render('confirmed', $head, $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }
	public function getFreeProductList(){
    	 $resultArray = array();
    	 $variantsArray = '';
    	 $productIDArray = $_POST['productID'];
    	 foreach ($productIDArray as $value) {
			  $result =  $this->Public_model->getproductList($value);
			  //$variants = $this->Public_model->getVariants($value);
			  array_push($resultArray, $result);
			  //array_push($variantsArray, $variants);
			}
			//print_r($resultArray); exit;
			foreach($resultArray as $item){
			 $product_string .='<li class="list-group-item"><div class="pop-product"><div><img src="'.base_url('/attachments/shop_images/' . $item['image']).'" alt=""> </div><div>'.$item['productTitle']. $variants_string.'</div><div><button class="btn btn-success btn-lg float-right" id="mybtn'.$item['variantID'].'" onclick="add_item_to_cart_free_product('.$item['variantID'].','.$item['variantPrice'].',\''. $item['productTitle'] .'\',\''.base_url('/attachments/shop_images/' . $item['image']).'\')">Add to Cart</button></div></div>
			 	
			 </li>';
		 }			
    	 $freeProduct_data = '<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" onclick="close_free_product_modal()">&times;</button>
			        
			      </div>
			      <div class="modal-body">
			        <ul class="list-group">
			        	'.$product_string.'
					</ul>
					<input type="hidden" id="freeProductPrice" value="0">
					<input type="hidden" id="freeProductTotalPrice" value="0">
					<p class="max_p" id="no_free_product" style="display: none;"><p/>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default add_default_btn" onclick="apply_free_product()">Save</button>
			      </div>';
			echo $freeProduct_data;
    }
    public function free_product_remove_cart(){
    	 $productID = $_POST['free_product_id'];
    	
    	 $productIDArray = explode(",",$productID);
    	 foreach ($productIDArray as $value) {
    	 		$this->cartItemRemoved($value);
    	 		//$this->Public_model->removeFromCartTable($value,$_SESSION['logged_user']);
		}
		echo '1';
    }
     public function cartItemRemoved($productVariant)
    {
        //echo "productVariant".$productVariant;
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
    public function applyGiftVoucher()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        //echo $_POST['enteredCode'];
        $result = $this->Public_model->getValidVoucherCode($_POST['enteredCode']);
        if ($result == null) {
            echo 0;
            exit;
        } else {
        	$offerData = new stdClass;
			$offerData->type = 'float';
			$offerData->amount = $result['giftCouponAmount'];

			echo json_encode($offerData);
        }

    }
    public function discountCodeChecker()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $userID = $_SESSION['logged_user'];
        $subTotal =  $_POST['subTotal'];
        $subTotalTwo =  $_POST['subTotalTwo'];
        $userMobile = $_SESSION['logged_mobile'];
        $result = $this->Public_model->getValidDiscountCode($_POST['enteredCode']);
       
        if ($result == null) {
            echo 0;
        } else {
        	if($result['user_specific'] == 'no'){
				if($result['categories'] == 'all'){
					if($_POST['enteredCode'] == 'NEOFIRST'){
						$isValidNeofirst = $this->Public_model->isValidNEOFIRST($userID);
						if($isValidNeofirst == null){
							echo json_encode($result);
							exit();
						}
						else{
							 echo 0;
							 exit();
						}
					}
					else if($result['offer_types'] == 5){
						if($subTotalTwo > $result['totalProductPrice']){
						 	echo json_encode($result);
							exit();
						}
						else{
							echo "401";
							 exit();
						}
					}

					else if($result['offer_types'] == 6){
						$items = $this->shoppingcart->getCartItems();
						$totalCount = 0;
						$price = array();
						foreach ( $items['array'] as $var ) {
								$prices = str_replace(",", "", $var['price']);
								array_push($price,($prices));
								$totalCount = $totalCount+$var['num_added'];
						}

						if($totalCount > 1){
							$min_price = (min($price));
							$offerData = new stdClass;
							$offerData->type = $result['type'];
							$offerData->amount = $min_price;
							$offerData->vendors = $result['vendors'];
							$offerData->offer_types = $result['offer_types'];
							echo json_encode($offerData);
							 exit();
						}
						else{
							echo 402;
							exit;
						}
						
					}
					else if($result['offer_types'] == 7){
							$offerData = new stdClass;
							$offerData->type = $result['type'];
							$offerData->amount = $result['amount'];
							$offerData->vendors = $result['vendors'];
							$offerData->offer_types = $result['offer_types'];
							$offerData->numberOfFreeProduct = $result['numberOfFreeProduct'];
							$offerData->freeProductID = $result['freeProductID'];
							echo json_encode($offerData);
							exit;
					}
					if($result['offer_types'] == 9){
						$items = $this->shoppingcart->getCartItems();
						
						$productSku = explode(",",$result['product']);
						$matchingProductPrice = 0;
						$product = array();
						foreach ( $items['array'] as $var ) {
							$productCat = explode(",",$var['sku']);
							array_push($product, $var['sku']);
							$matchingCat=array_intersect($productSku,$productCat);
							if(sizeof($matchingCat) > 0){
								
								$price = str_replace(",", "", $var['price']);
								$matchingProductPrice += ($price * $var['num_added']);
							}


							
						}
						if ($matchingProductPrice >0 && $items['flot_finalSum'] > $result['totalProductPrice']) {
								$offerData = new stdClass;
								$offerData->type = $result['type'];
								$offerData->offer_types = $result['offer_types'];
								$offerData->product_amount =$matchingProductPrice;
								$offerData->vendors = $result['vendors'];
								$offerData->amount = $result['amount'];
								 echo json_encode($offerData);
								exit();
							}
							else {
								echo 402;
								exit();
							}
					
					}
					else{
						echo json_encode($result);
					}
				//echo json_encode($result);
				}
				// else{
				// 	if($result['offer_types'] == 2){
				// 		$items = $this->shoppingcart->getCartItems();
				// 		print_r($items);
				// 		$categories = explode(",",$result['categories']);
				// 		$matchingProductPrice = 0;
				// 		$product = array();
				// 		foreach ( $items['array'] as $var ) {
				// 			$productCat = explode(",",$var['shop_categorie']);
				// 			array_push($product, $var['shop_categorie']);
				// 			$matchingCat=array_intersect($categories,$productCat);
				// 			if(sizeof($matchingCat) > 0){
				// 				$matchingProductPrice += $var['price'] * $var['num_added'];
				// 			}
				// 			//array_push($product, $var['shop_categorie']);

							
				// 		}
				// 		print_r($categories)."<br>";
				// 		print_r($product)."<br>";
				// 		print_r($productCat)."<br>";
				// 		print_r($matchingCat);
				// 		exit;
				// 			$offerData = new stdClass;
				// 			$offerData->type = $result['type'];
				// 			$offerData->product_amount =$matchingProductPrice;
				// 			$offerData->vendors = $result['vendors'];
				// 			$offerData->amount = $result['amount'];
				// 			 echo json_encode($offerData);
					
				// 	}
					else{
							$items = $this->shoppingcart->getCartItems();
							$categories = explode(",",$result['categories']);
							//print_r($items); die();
							$matchingProductPrice = 0;
							$product = array();
							foreach ( $items['array'] as $var ) {
								$productCat = explode(",",$var['shop_categorie']);
								$matchingCat=array_intersect($categories,$productCat);
								
								if(sizeof($matchingCat) > 0){
									$price = str_replace(",", "", $var['price']);
									$matchingProductPrice += ($price * $var['num_added']);
								}

								array_push($product, $var['shop_categorie']);

								
							}
							//print_r($matchingProductPrice); die();
							//print_r($product); die();
							$productImplode = implode(",",$product);
							// print_r($productImplode); die();
							$productExplode = explode(",",$productImplode);
							//print_r($productExplode); die();				
							
							//print_r($categories); 
							
							$discountCategory = array();
							foreach($categories as $category){
								array_push($discountCategory, $category);
							}
							//print_r($discountCategory); die();
							$category_exists = false;//
							foreach ($discountCategory as $discount) {
								if(in_array($discount,$productExplode))
								$category_exists = true;
							}
							//print_r($category_exists); die();
							if($category_exists){
									if ($items['flot_finalSum'] > $result['totalProductPrice']) {
										$offerData = new stdClass;
										$offerData->type = $result['type'];
										$offerData->offer_types = $result['offer_types'];
										$offerData->product_amount = $matchingProductPrice;
										$offerData->vendors = $result['vendors'];
										$offerData->amount = $result['amount'];
										 echo json_encode($offerData);
										exit();
									}
									else {
										echo 402;
										exit();
									}					
							}
							else {
								echo 402;
								exit();
							}
					}
				//}
			}
			else{
					$isValidUser = $this->Public_model->isValidUserSpecificCoupon($userMobile,$_POST['enteredCode']);
					if($isValidUser != false){
						$offerData = new stdClass;
						$offerData->type = $isValidUser['type'];
						$offerData->amount = $isValidUser['amount'];
						$offerData->vendors = $isValidUser['vendors'];
						$offerData->offer_types = $isValidUser['offer_types'];
						$offerData->birthday_amount = $isValidUser['amount'];
						echo json_encode($offerData);
						exit;
					}else{
						echo 0;
						exit;
					}
			}
        }
    }

    public function sitemap()
    {
        header("Content-Type:text/xml");
        echo '<?xml version="1.0" encoding="UTF-8"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $products = $this->Public_model->sitemap();
        $blogPosts = $this->Public_model->sitemapBlog();

        foreach ($blogPosts->result() as $row1) {
            echo '<url>

      <loc>' . base_url('blog/' . $row1->url) . '</loc>

      <changefreq>monthly</changefreq>

      <priority>0.1</priority>

   </url>';
        }

        foreach ($products->result() as $row) {
            echo '<url>

      <loc>' . base_url($row->url) . '</loc>

      <changefreq>monthly</changefreq>

      <priority>0.1</priority>

   </url>';
        }

        echo '</urlset>';
    }
	public function category($page=0)
    {
    	// echo "<pre>";
    	// print_r($_GET);
    	// die();
    	$num_rows = 200;
		$category = $this->input->get('type', TRUE);
		$searcInTtitle = $this->input->get('search_in_title', TRUE);
		// echo $category;
		// exit;
		$ingredients = $this->input->get('ingredients', TRUE);
		$category_details = $this->Public_model->categoryDetailsByFind($category);
		if($category == ''){
			$category_type = 'shop-all';
		}
		else{
			$category_type = $category;
		}
		if($ingredients != ''){
			$ingredientData = $this->Public_model->getIngredientData($ingredients);
			$_GET['ingredients'] = $ingredientData['product_sku'];
			

		}
		if($_GET['type'] == 'shop-by-ingredients'){
			redirect(LANG_URL . '/ingredient');
		}
		$searchCategory = '';
		if($_GET['body'] || $_GET['hair'] != ''){
			$searchCategory = 'active';
		}
		
		$category_banner = $this->Public_model->categoryBanner($category_type);
		//print_r($category_details); exit;
		if($category_details['tag']==""){
			$_GET['category'] = $category_details['id'];
		}else{
			$_GET['tag'] = $category_details['tag'];
		}
		$data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('home');
        $head['title'] = $category_details['name'];
        $head['description'] = @$arrSeo['description'];
		$data["category_details"] = $category_details;
		$head['pageactive'] = "category";
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		
        $data['products'] = $this->Public_model->getProducts($num_rows, $page, $_GET);
		
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['links_pagination'] = pagination('category', $rowscount, $this->num_rows);
		$data['rowscount'] = $rowscount;
		$data['num_rows'] = $this->num_rows;
		if($category_details['sub_for'] != 1){
		$sub_category_details = $this->Public_model->categoryDetails($category_details['sub_for']);
        $data['sub_category_details'] = $sub_category_details;
        if($sub_category_details['sub_for'] == 4){
        $data['fst_category_details'] = $this->Public_model->fst_category_details($sub_category_details['sub_for']);
        }
    }
        
		if(isset($_GET['orderby']))
		$data['order_by'] = $_GET['orderby'];
		$data['category_banner'] = $category_banner;
		$data['attributes_set'] = $this->Public_model->getAllAttribute();
		$data['search'] = $_GET;
		$data['searchCategory'] = $searchCategory;
		$data['search_in_title'] = $_GET['search_in_title'];
		$data['ingredients'] = $ingredients;
		$data['searchData'] = $_GET;
		//echo $searchCategory; die();
		// echo "<pre>";
        //print_r($data["sub_category_details"]); 
		 //print_r($data["category_details"]);
         
		//exit;
        // echo "<pre>";
        // print_r($data['products']);
        // exit;
        $this->render('product_listing', $head, $data);
    }
	public function products($page=0)
    {
		$data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('home');
		if(isset($_GET['search_in_title']))
        $head['title'] = $_GET['search_in_title'];
		if(isset($_GET['suppliers']))
        $head['title'] = urldecode($_GET['suppliers']);
		if(isset($_GET['state']))
        $head['title'] = urldecode($_GET['state']);
		
        $head['description'] = @$arrSeo['description'];
		
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		
        $data['products'] = $this->Public_model->getProducts($this->num_rows, $page, $_GET);
        $rowscount = $this->Public_model->productsCount($_GET);
        $data['links_pagination'] = pagination('products', $rowscount, $this->num_rows);
		$data['rowscount'] = $rowscount;
		$data['num_rows'] = $this->num_rows;
		$data['attributes_set'] = $this->Products_model->getAllAttribute();
		 
		if(isset($_GET['orderby']))
		$data['order_by'] = $_GET['orderby'];
		
		$data['search'] = $_GET;
		
        $this->render('product_listing', $head, $data);
    }
	 public function checkUser()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		
        $result = $this->Public_model->publicUsersWithEmail($_POST['customer_email']);
        if ($result) {
			$previous_address = $this->Public_model->getPreviousAddress($result['id']);
			$return_arr = array("guest_user"=>$result['id'],"address"=>$previous_address);
			echo json_encode($return_arr);
			
        } else {
			$post['email'] = $_POST['customer_email'];
			$post['phone'] = "";
			$post['name'] = "Guest User";
			$post['pass'] = md5(123456);
			$user_id = $this->Public_model->registerUser($post);
			$return_arr = array("guest_user"=>$user_id);
			echo json_encode($return_arr);
			$_SESSION['guest_user_id'] = $user_id; 
        }
    }
	public function add_address()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		
		if($_SESSION['guest_user_id'] == $_POST['guest']){
			$user_id = $this->Public_model->addAddress($_POST);
		}
    }
	public function getSubReason()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		$subreason_value = $this->Public_model->getReturnSubReason($_POST['reason_id']);
		$list_value = "";
		foreach($subreason_value as $subreason){
			$list_value .="<option value='".$subreason['sub_id']."'>".$subreason['title']."</option>";
		}
		$list_value .="<option value='others'>Others</option>";
		echo $list_value;
    }
	public function apply_shipping_charge()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		$weight = $_POST['weight'];
		$country = $_POST['sortname'];
		$data = $this->Public_model->getShippingCharge($country,$weight);
		echo json_encode($data);
    }
	public function delete_address()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		if($_SESSION['guest_user_id'] == $_POST['guest']){
			$user_id = $this->Public_model->deleteAddress($_POST);
		}
    }
    public function delete_manage_address()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
			$user_id = $this->Public_model->deleteManageAddress($_POST);
    }
	public function add_review()
    {
		
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		$user_id = $_SESSION['logged_user'];
		$user_name = $_SESSION['logged_name'];
		
		$review = $_POST['review'];
		$rating = $_POST['rating'];
		$product_id = $_POST['product_id'];
		$order_id = $_POST['order_id'];
		
		$data = $this->Public_model->submitReview($user_name,$review,$rating,$product_id,$order_id);
		$ratingCount = $this->Public_model->countProductRating($product_id);
		$productRating = $this->Public_model->productRatingSum($product_id);
		$totRating = 0;
		foreach ($productRating as $rating) {
			$totRating += $rating['rating'];
		}
		$average = $totRating/$ratingCount;
		$totAverage = round($average, 2);
		$this->Public_model->updateProductRating($product_id,$totAverage);
		echo json_encode($data);
    }
	public function generate_shiprocket_token()
    {
		$post = array(
					  "email"=>"sanjay@myindiantoy.com",
					  "password"=>"MIT@2020"
				);
		$headers = array(
						"Content-Type: application/json"
				);
		$token_details = json_decode($this->cUrlGetData(shiprocket_api_url.'auth/login', json_encode($post), $headers));
		 $this->Home_admin_model->setValueStore('shiprocket_api_key', $token_details->token);
    }
	public function ruturn_order(){
		$user_id = isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : $_SESSION['guest_user_id'];
		
		$counter = $_POST['order_product_counter'];
		$order_id = $_POST['order_id'.$counter];
		$orders_info = $this->Public_model->getUserOrderDetails($order_id);
		
		if($orders_info['user_id']==$user_id){
			$arr_products = unserialize($orders_info['order_products']);
			$product_array = array();
			$order_date = $orders_info['date'];
			$diff = abs(time() - $order_date);  
			$years = floor($diff / (365*60*60*24));  
			$months = floor(($diff - $years * 365*60*60*24)/ (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
			if($days<=30){
				foreach ($arr_products as $product) {
					if($product['product_info']['id'] == $_POST['product_id'.$counter] && $product['product_info']['variant_id'] == $_POST['variant_id'.$counter]){
						if($product['product_returned'] == "1"){
							$this->session->set_flashdata('userError',"Return period exipred. Please contact us.");
							redirect(LANG_URL . '/users/order/'.$order_id);
						}else{
							$product['product_returned'] = "1";
							//Upload Image
							$config['upload_path'] = './attachments/return_images/';
							$config['max_size'] = '2048';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|JPG|PNG|JPEG';
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('return_image'.$counter)) {
								$this->session->set_flashdata('userError',$this->upload->display_errors());
								redirect(LANG_URL . '/users/order/'.$order_id);
							}
							$img = $this->upload->data();
							$file_name = $img['file_name'];
							
							$return_reason = $this->Public_model->getReturnReasonByID($_POST['return_reason'.$counter]);
							if($_POST['return_sub_reason'.$counter] == 'others'){
								$reason2 = $_POST['others_reason'.$counter];
							}else{
								$return_sub_reason = $this->Public_model->getSubReturnReasonByID($_POST['return_sub_reason'.$counter]);
								$reason2 = $return_sub_reason['title'];
							}
							
							$this->Public_model->insertReturnRequest($order_id,$_POST['product_id'.$counter],$_POST['variant_id'.$counter],$return_reason['title'],$reason2,$file_name);
						}
					}
					array_push($product_array,$product);
				}
				$this->Public_model->updateProductOrder($order_id,$product_array);
				$this->session->set_flashdata('userSuccess',"Thank you ".$orders_info['first_name']." for reporting an issue. We will verify and respond soon..!!");
				redirect(LANG_URL . '/users/order/'.$order_id);
				
			}else{
				$this->session->set_flashdata('userError',"Return period exipred. Please contact us.");
				redirect(LANG_URL . '/users/order/'.$order_id);
			}
		}
		else{
			redirect(LANG_URL . '/');
		}
		
	}
	public function add_wishlist()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		if(!isset($_SESSION['logged_user'])){
			$return_arr = array("data"=>0,"message"=>"Please login to your account");
			echo json_encode($return_arr);
		}else{
			$checkItemalreadyAdded = $this->Public_model->itemAddedWishlist($_SESSION['logged_user'],$_POST['product_id']);
			if($checkItemalreadyAdded>0){
				$return_arr = array("data"=>0,"message"=>"Item already added in your wishlist");
				echo json_encode($return_arr);
			}else{
				$return_arr = array("data"=>1,"message"=>"Item added in your wishlist");
				$this->Public_model->addWishlist($_SESSION['logged_user'],$_POST['product_id']);
				echo json_encode($return_arr);
			}
		}
    }
	public function remove_wishlist()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		if(!isset($_SESSION['logged_user'])){
			$return_arr = array("data"=>0,"message"=>"Please login to your account");
			echo json_encode($return_arr);
		}else{
			$return_arr = array("data"=>1,"message"=>"Item removed from your wishlist");
			$this->Public_model->removeWishlist($_SESSION['logged_user'],$_POST['product_id']);
			echo json_encode($return_arr);
		}
    }
	
	function cUrlGetData($url, $post_fields = null, $headers = null) {
		$ch = curl_init();
		$timeout = 100;
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

		$err = curl_error($ch);

		// curl_close($ch);
		// if ($err) {
		//   echo "cURL Error #:" . $err;
		// } else {
		//   echo ($response);
		// }
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $data;
	}
	public function quickviewProduct()
    {
		if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		
		$id = $_POST['product_id'];
        $product = $this->Public_model->getOneProduct($id);
		$variants = $this->Public_model->getVariants($id);
       
		$variants_details = "";
		$variant_hidden = "";
		$variant_data = "";
		if(sizeof($variants)){
		foreach($variants as $variant){
			$variants_details .='<option value="'.$variant['variant_id'].'">'.$variant['weight'].' '.$variant['weight_unit'].'</option>';
			$variant_hidden .='<input type="hidden" id="quick_varient'.$variant['variant_id'].'" data-price="'.CURRENCY .number_format($variant['price'],2).'" data-available="'.$variant['quantity'].'" />';
         }
		 
		 $product_attribute = $this->Public_model->getProductAttribute($id);
		 $attribute_string = "";
		 foreach($product_attribute as $attribute){
			 $attribute_string .='<tr><td>'.$attribute["attribute_set_name"].'</td><td>'.$attribute["attribute_title"].'</td></tr>';
		 }
		 if($product['min_age']!=""){
										$attribute_string .='<tr><td>Min Age </td><td>'.$product['min_age']." ".$product['age_unit'].'</td></tr>';
		 }
                
		$variant_data = '<div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="'.base_url('/attachments/shop_images/' . $product['image']).'" alt="" class="img-fluid "></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2>'.$product['title'].'</h2>
                            <h3><span id="quick_varient_product_price">'.CURRENCY .number_format($variants[0]['price'],2).'</span></h3>
                            
							<div class="product-description border-product">
							    <p>'.substr(strip_tags($product['description']),0,150) . "...".'<a href="'.LANG_URL . '/' . $product['vendor_url'] . '/' . $product['url'].'">View Map</a></p>
							    <div class="quickview-product-tables">
									<table>
										<tbody>'.$attribute_string.'
										</tbody>
									</table>
								</div>
								<input type="hidden" id="variant" value="'.$variants[0]['variant_id'].'">
                            </div>
                            <div class="product-buttons">
								<button id="addToCart" onclick="add_item_to_cart()" class="btn btn-solid">Add To Cart</button>&nbsp;&nbsp;
								<button onclick="buy_now()" class="btn btn-solid">Buy Now</button>
                           
                            </div>
                        </div>
                    </div>';                                    
 		/*$variant_data = '<div class="modal-header">
              <h4 class="modal-title">'.$product['title'].'</h4>
			   <button type="button" data-dismiss="modal">X</button></div>
            </div>
			<input type="hidden" id="quickview_variant_id">
            <div class="modal-body quickview">
              <div class="flex-default readMoreText"><p class="readMore">Read more about the product</p><a href="'.LANG_URL . '/' . $product['vendor_url'] . '/' . $product['url'].'"><button class="btn btn-dark btn-sm">Here</button></a></div>
              <div class="divider bgcolor-teal"></div>
              <div>
              	<div class="productPriceDisplay flex-default">
                	<label class="">Price&nbsp;&nbsp;:&nbsp;&nbsp;</label><span class="product-price" id="quick_varient_product_price">'.CURRENCY .number_format($variants[0]['price'],2).'</span>
               </div></br>
                <div class="flex-default"><div class="margin-right-20 form-group">
              	<label class="">Weight</label>
                <select name="weight" onchange="update_quick_viewvariant(this.value)" id="variant" class="form-control">'.$variants_details.'</select></div>
               </div><div class="flex-default">
               	<button id="addToCart" onclick="add_item_to_cart()" class="bgcolor-yellow btn btn-secondary btn-sm">Add To Cart</button>&nbsp;&nbsp;
				<button onclick="buy_now()" class="bgcolor-yellow btn btn-secondary btn-sm">Buy Now</button>
               
			   '.$variant_hidden.'
              
               </div>
              
            </div>';*/
		}
		$return_arr = array("variants"=>sizeof($variants),"variant_date"=>$variant_data);
		echo json_encode($return_arr);
			
    }
    function addToCartProduct()
    {
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		
		$id = $_POST['product_id'];
		//echo $id;
        $product = $this->Public_model->getOneProduct($id);
		$variants = $this->Public_model->getVariants($id);
		
		// print_r($existProduct);
		// exit;
		if($_SESSION['logged_user'] != ''){
		$existProduct = $this->Public_model->checkCartProductExist($id, $_SESSION['logged_user']);
		$product_qunaitity = 0;
		
		if($existProduct != false){
			$product_qunaitity = ($existProduct['qty'] + 1);
			$this->Public_model->updateCart($id, $_SESSION['logged_user'], $product_qunaitity);
		}
		else{
			$this->Public_model->insertCart($id, $_SESSION['logged_user'],$variants[0]['price']);
		}
	}
		//print_r($variants);
		$variantsID = $variants[0]['variant_id'];
		echo $variantsID;
    }
    function addProductIntoCartDB()
    {
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		
		$id = $_POST['product_id'];
		//echo $id;
        $product = $this->Public_model->getOneProduct($id);
		$variants = $this->Public_model->getVariants($id);
		if($_SESSION['logged_user']){
		$existProduct = $this->Public_model->checkCartProductExist($id, $_SESSION['logged_user']);
		
		$product_qunaitity = 0;
		if($existProduct != false){
			$product_qunaitity = ($existProduct['qty'] + 1);
			$this->Public_model->updateCart($id, $_SESSION['logged_user'], $product_qunaitity);
		}
		else{
			$this->Public_model->insertCart($id, $_SESSION['logged_user'],$variants[0]['price']);
		}
		}
    }
      function removeProductIntoCartDB()
    {
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		
		$id = $_POST['product_id'];
		//echo $id;
        $product = $this->Public_model->getOneProduct($id);
		$variants = $this->Public_model->getVariants($id);
		if($_SESSION['logged_user'] != ''){
		$existProduct = $this->Public_model->checkCartProductExist($id, $_SESSION['logged_user']);
		
		$product_qunaitity = 0;
		if($existProduct != false){
			$product_qunaitity = ($existProduct['qty'] - 1);
			$this->Public_model->updateCart($id, $_SESSION['logged_user'], $product_qunaitity);
		}
	}
		// else{
		// 	$this->Public_model->insertCart($id, $_SESSION['logged_user'],$variants[0]['price']);
		// }
    }
    function addToCartWishlist(){
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
		
		$id = $_POST['product_id'];
		//echo $id;
        $product = $this->Public_model->getOneProduct($id);
		$variants = $this->Public_model->getVariants($id);
		//print_r($variants);
		$existProduct = $this->Public_model->checkCartProductExist($id, $_SESSION['logged_user']);
		if($existProduct == false){
		$this->Public_model->insertCart($id, $_SESSION['logged_user'],$variants[0]['price']);
		}
		$variantsID = $variants[0]['variant_id'];
		$this->Public_model->removeWishlist($_SESSION['logged_user'],$id);
		echo $variantsID;
    }
    function search_store(){
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        //echo $_POST['pincode'];
        $pincode = $_POST['pincode'];
        $store = $this->Public_model->getStore($pincode);
        if($store){
        foreach($store as $key=>$item){
			 $store_string .=' <a href="javascript:void(0)" class="more-blog more_store" onclick="more_store('.$item['storeLocatorID'].')"><div class="each-location check'.$item['storeLocatorID'].' "><h3>'.$item["store_name"].'</h3><p>'.$item["store_address"].'</p>
			Select <img src="'.base_url("images/down-arrow.png").'" alt=""></div></a>';
			 
		 }
		 $maps .='<iframe
									src="https://maps.google.com/maps?q='.$store[0]["store_latitude"].','.$store[0]["store_longitude"].'&hl=es;z=14&amp;output=embed"
									width="600" height="450" style="border:0; margin-top: -150px;" allowfullscreen="" loading="lazy"
									referrerpolicy="no-referrer-when-downgrade"></iframe>';
		
        $storeData = '<div class="container">
					<div class="row">
						<div class="col-lg-6 l-details">
							<div class="each-slide ">
								'.$store_string.'
							</div>
						</div>
						<div class="col-lg-6 map-area" id="map_two">
							<div class="map">
								'.$maps.'
							</div>
						</div>
					</div>
				</div>';
        //print_r($store);
        echo json_encode($storeData);
    }
    else{
    	echo '0';
    }
    }
    function frequentlyBoughTtogether(){
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    	$variantID = (explode(",", $_POST['varientID']));
    	$data = array();
    	foreach ($variantID as  $item) {
    		array_push($data, $item);
    	$existProduct = $this->Public_model->checkCartProductExist($item, $_SESSION['logged_user']);
		
		$product_qunaitity = 0;
		if($existProduct != false){
			$product_qunaitity = ($existProduct['qty'] + 1);
			$this->Public_model->updateCart($item, $_SESSION['logged_user'], $product_qunaitity);
		}
		else{
			$this->Public_model->insertCart($item, $_SESSION['logged_user'],$variants[0]['price']);
		}
    	}
		 echo json_encode($data);
    }
    function loginDuplicate(){
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $mobile = $_POST['mobile'];
        $result = $this->Public_model->checkUserIsValid($mobile);
            if ($result !== false) {
            	$_SESSION['logged_mobile'] = $mobile;
            	$six_digit_random_number = rand(100000, 999999);
            	//$six_digit_random_number = '123456';
            	$data = $this->Public_model->updateOtp($six_digit_random_number, $mobile);
            		$massageID  = 160331;
					$this->sendSMS($massageID,$mobile,$six_digit_random_number);
					
            		echo '1';
            	
                				
            }
            else{
            	echo '0';
            }
    }
    public function otp_verify()
    {
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $otp_verify = $_POST['otp_no'];
        $mobile = $_POST['mobile_no'];
        //exit;
        $result = $this->Public_model->checkOTPIsValid($otp_verify, $mobile);

        if ($result !== false) {
        	$_SESSION['logged_user'] = $result['id']; //id of user
			$_SESSION['logged_email'] = $result['email'];
			$name = explode(" ",$result['name']);
			$_SESSION['logged_user_name'] = $name[0];
			$_SESSION['guest_user_id'] = $result['id'];
			$_SESSION['logged_mobile'] = $result['phone'];
			$_SESSION['logged_name'] = $result['name'];

			



			$preCartProduct = $this->Public_model->preCartProduct($_SESSION['logged_user']);
			if(sizeof($preCartProduct)>0){
				if (!isset($_SESSION['shopping_cart'])) {
			                $_SESSION['shopping_cart'] = array();
			    }
				foreach ( $preCartProduct as $item ) {
					@$_SESSION['shopping_cart'][] = (int) $item['product_id'];
				}
				@set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->cookieExpTime);
				
			}


			$items = $this->shoppingcart->getCartItems();
			$product_qunaitity = 0;
			foreach ( $items['array'] as $var ) {
				
	            $data = $this->Public_model->cartProduct($_SESSION['logged_user'], $var['product_id']);
	            if($data == false){
	            	$this->Public_model->insertCookiesCart($var['product_id'], $_SESSION['logged_user'],$var['price'],$var['num_added']);
	            }
	            else{
	            	$this->Public_model->updateCookiesCart($var['product_id'], $_SESSION['logged_user'],$var['price'],$var['num_added']);
	            }
        	}

        	

			echo '1';
        }
        else{
            	echo '0';
            }
    }
    public function resend_otp(){

    	$mobile = $_POST['mobile_no'];
        $result = $this->Public_model->checkUserIsValid($mobile);
            if ($result !== false) {
            	$six_digit_random_number = rand(100000, 999999);
            	$data = $this->Public_model->updateOtp($six_digit_random_number, $mobile);
            	$massageID  = 160331;
            	$this->sendSMS($massageID,$mobile,$six_digit_random_number);
            	echo '1';
            	
                				
            }
            else{
            	echo '0';
            }
    }
    function registrationLogin(){
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $mobile = $_POST['mobile_no'] ? $_POST['mobile_no'] : $_POST['mobile'];
        // echo $mobile;
        // die();
        $result = $this->Public_model->checkUserIsValid($mobile);
        //print_r($result);
        if($result != ''){
        	$resultData = 0;
        }
        else{
        	$resultData = 1;
        }
        // echo $aaa;
        // exit;
            //if ($resultData == 1) {
            	$_SESSION['logged_mobile'] = $mobile;
            	$six_digit_random_number = rand(100000, 999999);
            	//$six_digit_random_number = '123456';
            	$data = $this->Public_model->updateOtp($six_digit_random_number, $mobile);
            		$massageID  = 160331;
					$this->sendSMS($massageID,$mobile,$six_digit_random_number);
            		echo '1';
            	
                				
            // }
            // else{
            // 	echo '0';
            // }
    }
    public function otp_verify_reg()
    {
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $otp_verify = $_POST['otp_no_reg'];
        $mb = $_POST['mobile'];
        
        
        $mobile = $_POST['mobile_regs'] ? $_POST['mobile_regs'] : $_POST['mobile'];
        //exit;

        $result = $this->Public_model->checkOTPIsValid($otp_verify, $mobile);
        
        //print_r($result);
        if ($result != false) {
        	$_SESSION['logged_user'] = $result['id']; //id of user
			$_SESSION['logged_email'] = $result['email'];
			$name = explode(" ",$result['name']);
			$_SESSION['logged_user_name'] = $name[0];
			$_SESSION['guest_user_id'] = $result['id'];
			$_SESSION['logged_mobile'] = $result['phone'];
			$_SESSION['logged_name'] = $result['name'];

			$preCartProduct = $this->Public_model->preCartProduct($_SESSION['logged_user']);
			if($mb != ''){
			$this->sendWhatsAppSMSPhaseOne($result['phone'],$result['name'],'new_register_user');			
			$this->sendEmailNewUser($result['name'], $result['email']);
			$massageID  = 160328;
			$this->sendSMS($massageID,$result['phone']);
			}
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


			$items = $this->shoppingcart->getCartItems();
			// print_r($items);
			// exit;
			$product_qunaitity = 0;
			if(sizeof($items)>0){
				
				foreach ( $items['array'] as $var ) {
					
		            $data = $this->Public_model->cartProduct($_SESSION['logged_user'], $var['product_id']);
		            if($data == false){
		            	$this->Public_model->insertCookiesCart($var['product_id'], $_SESSION['logged_user'],$var['price'],$var['num_added']);
		            }
		            else{
		            	$this->Public_model->updateCookiesCart($var['product_id'], $_SESSION['logged_user'],$var['price'],$var['num_added']);
		            }
	        	}
	        }

			

        	
			echo '1';
        }
        else{
            	echo '0';
            }
    }
    public function registration(){

    	$first_name = $_POST['first_name'];
    	$last_name = $_POST['last_name'];
    	$mobile = $_POST['mobile'];
    	$email = $_POST['email']; 
    	$gender = $_POST['gender'];
    	$dob = $_POST['dob'];
    	$mobile_regs = $_POST['mobile_regs'];
    	$own_referral = "";
        $length_of_string = 6;

        $finale_mob_no = $_POST['mobile'] ? $_POST['mobile'] : $_POST['mobile_regs'];
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
 
        $own_referral =  substr(str_shuffle($str_result),0, $length_of_string);
        $other_referral = $this->session->userdata('referral_code');
        //echo $other_referral;
    	//$anniversary = $_POST['anniversary'];
    	$result = $this->Public_model->mobileExist($mobile);
    	if ($result !== false) {    		  		
    		echo '0';
    	}
    	else{


    		$item = $this->Public_model->registration($_POST, $own_referral,$other_referral);
    		//print_r($item); exit;
    		$this->Public_model->insertUserPointRollups($item);
    		$this->sendEmailRegistration($first_name,$last_name,$email);

    		$six_digit_random_number = rand(100000, 999999);
            	//$six_digit_random_number = '123456';
            	$data = $this->Public_model->updateOtp($six_digit_random_number, $mobile);
            $massageID  = 160331;
            $this->sendSMS($massageID,$mobile,$six_digit_random_number);
					
    		echo '1';
    	}

    }

    public function edit_delivery_address(){
    	
    	//print_r($_POST['address_id']);
        $addressID = $_POST['address_id'];
        //echo $addressID; exit;
        $result = $this->Public_model->fetch_singleDeliveryAddress($addressID);
        print_r($result);
        // $item = '<div id="delivery-address" style="width:879px; max-width:100%; overflow:hidden; padding:10px; background:#fff">
        //     <div class="login-inner" id="addressDataDiv"><div class="delivery-address" >
        //             <h2>Address</h2>                 
        //             <div>
        //                 <label>First Name</label>
        //                 <input type="text" name="first_name" placeholder="First Name" id="first_name">
        //                 <p class="wrong_registration wrong_firstName" id="wrong_firstName">Invalid First Name</p>
        //                 <label>last Name</label>
        //                 <input type="text" name="last_name" placeholder="Last Name" id="last_name">
        //                 <p class="wrong_registration wrong_lastName" id="wrong_lastName">Invalid Last Name</p>
        //                 <label>Mobile Number</label>
        //                 <input type="text" name="mobile" placeholder="Mobile Number" id="mobile">
        //                 <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Invalid Mobile Number</p>
        //                 <label>Address</label>
        //                 <textarea id="address" class="address"></textarea>
        //                 <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Invalid Mobile Number</p>
        //                 <label>State</label>
        //                 <input type="text" name="mobile" placeholder="Mobile Number" id="mobile">
        //                 <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Invalid Mobile Number</p>
        //                 <label>City</label>
        //                 <input type="text" name="mobile" placeholder="Mobile Number" id="mobile">
        //                 <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Invalid Mobile Number</p>
        //                 <label>Pincode</label>
        //                 <input type="text" name="mobile" placeholder="Mobile Number" id="mobile">
        //                 <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Invalid Mobile Number</p>
                        
        //                 <button type="button" class="first-sign" id="registration" onclick="registration()";>Submit</button>
        //                 <!-- <input type="submit" value="Sign in" > -->
        //             </div>
        //         </div>
        //         </div>
        // </div>';
		echo json_encode($item);

    }
    public function pageData(){
    	$value = $this->shoppingcart->getCartItems();
    	foreach($value['array'] as $item){
    		
    			$cartItem .='<div class="each-p-product">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <a href="'.LANG_URL . '/' . $item['url'].'"><img src="'.base_url('/attachments/shop_images/' . $item['image']).'" width="100%" height="auto" border="0" alt=""></a>
                                    </div>
                                    <div class="col-lg-5 cart-product">
                                        <p><a href="'.LANG_URL . '/' . $item['url'].'">'.$item['title'].'</a></p>
                                        
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="button-container">
                                            <div id="" class="">
                                                <a class="cart-qty-minus" onclick="removeProduct('.$item['id'] .', true)" href="javascript:void(0);" type="button" value="-">-</a>
                                            </div>
                                            <div id="" class="">
                                                <input type="text" name="qty" class="qty quantity-num" maxlength="12" value="'.$item['num_added'].'" class="input-text qty">
                                            </div>
                                            <div id="" class="">
                                                <a class="cart-qty-plus refresh-me add-to-cart " data-id="'. $item['id'] .'" href="javascript:void(0);" type="button" value="+">+</a>
                                            </div>                                                  
                                        </div>
                                    </div>
                                    <div class="col-lg-2 ">
                                        <h6 class="cart-price td-color">'. CURRENCY.$item['sum_price'].'</h6>
                                    </div>
                                </div>
                                <div class="each-p-product-bottom">
                                    <ul>
                                       <li><a href="javascript:void(0);" onclick="deleteFromCart('.$item['id'].')">Remove</a></li>
                                        <li><a href="javascript:void(0);" onclick="add_item_to_wishlist('.$item['id'].')">add to wishlist</a></li>
                                    </ul>
                                </div>
                            </div>';
    		
			 
		 }
    	

           

            
            		
    	//print_r($cartData);
    	echo $cartItem;
    }

    public function ingredients($page = 0){
	  $data = array();
        $head = array();
        $arrSeo = $this->Public_model->getSeo('ingredients');
        $head['title'] = @$arrSeo['title'];
        $head['description'] = @$arrSeo['description'];
        $head['keywords'] = str_replace(" ", ",", $head['title']); 
		$data['class'] = "ingredients";
		$data['active'] = "ingredients";
		$head['pageactive'] = "ingredient";
		$ingredients = $this->Pages_model->getIngredientPublic();
		$data['ingredients_banner'] = $this->Pages_model->getIngredientBanner(1);
		// echo "<pre>";
		// print_r($ingredients); exit;
		$result = [];
		foreach ($ingredients as $item) {
		    $firstLetter = strtoupper(substr($item['ingredientsTitle'], 0, 1));

		    if (!isset($result[$firstLetter])) {
		        $result[$firstLetter] = [];
		    }

		    $result[$firstLetter][] = $item;
		}
 		 $data['ingredients'] = $result;
		 

        $this->render('ingredients', $head, $data);
}
		public function ingredient_details($id = 0){
			$data = array();
	        $head = array();
	        $arrSeo = $this->Public_model->getSeo('ingredients');
	        $head['title'] = @$arrSeo['title'];
	        $head['description'] = @$arrSeo['description'];
	        $head['keywords'] = str_replace(" ", ",", $head['title']); 
			$data['class'] = "ingredients";
			$data['active'] = "ingredients";
			$head['pageactive'] = "ingredient";
	        $ingredients = $this->Pages_model->getOneIngredientdetails($id);
	        $ingredients_product = explode(",",$ingredients['product_sku']);
			
			
			$data['ingredients'] = $ingredients;
			$data['ingredients_product'] = $ingredients_product[0];
			//print_r($data['ingredients_product']); die();
	        $this->render('ingredients_details', $head, $data);
		}
	public function add_new_address(){

    	$add_name = $_POST['add_name'];
    	$add_last_name = $_POST['add_last_name'];
    	$add_mob = $_POST['add_mob'];
    	$add_pincode = $_POST['add_pincode'];
    	$add_state = $_POST['add_state'];
    	$add_city = $_POST['add_city'];
    	$add_build_name = $_POST['add_build_name'];
    	$add_road_name = $_POST['add_road_name'];
    	$landmark = $_POST['landmark'];
    	$state = $this->Public_model->searchState($_POST['add_state']);
    	$city = $this->Public_model->searchCity($_POST['add_city']);

        $productVariant = $_POST['productVariant'];

    	
    	if(sizeof($city)>0){
    	$result = $this->Public_model->addNewAddress($_POST,$state['id'],$city['id']);
    	}
    	else{
    		$cityID = $this->Public_model->insertCity($_POST['add_city'],$state['id']);
    		$result = $this->Public_model->addNewAddress($_POST,$state['id'],$cityID);
    	}
    	$getUserAddress = $this->Public_model->getPreviousAddress($_SESSION['logged_user']);

        $data['selectedAddress'] = $getUserAddress[0]['state']; 
    	$selectedState = $getUserAddress[0]['state'];            
        $selected_address_id = $getUserAddress[0]['address_id'];
        $totalReward = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);
        $getCurentTier = $this->Public_model->getCurentTier($_SESSION['logged_user']);
    	if ($result != '') {
            if($productVariant != ''){
                $productData = $this->Public_model->buyNowProductData($productVariant,$_SESSION['logged_user']);
                $prices = str_replace(",", "", $productData['price']);
                $tot_prices = ($prices*$productData['qty']);
                
                $tot_price = $tot_prices;

            } else{
            	$items = $this->shoppingcart->getCartItems();
                
                $ref_tot_price = 0;
                foreach ( $items['array'] as $var ) {
                	$price = str_replace(",", "", $var['price']);
                    $ref_tot_price += ($price*$var['num_added']);
                    $tot_price += ($price*$var['num_added']);
                }
            }
        //$delivery_amount = 0;

        $data['delivery_amount'] = '0.00';
        if($tot_price >= 1000){
            $delivery_amount = '0.00';
        }else{
        	if($getCurentTier['tier'] == '1'){
             if($selectedState == '41'){
                 $delivery_amount = '45.00';
             }else{
                 $delivery_amount = '65.00';
             }
         }
         else{
         	$delivery_amount = '0.00';
         }
        } 
    		
    		foreach($getUserAddress as $key => $addreess){
    			$chcek = '';
    			if($key == '0')
    			{
    			 $chcek = 'checked';
    			} 
			 $address_string .='<tr>
								<td><input type="radio" name="a" '.$chcek.' id='.$addreess['address_id'].' onChange="setDeliveryAddress('.$addreess['address_id'].','.$addreess['state'].',\''.$addreess['sortname'].'\','.$tot_price.','.$totalReward['tier'].',\''.$addreess['post_code'].'\')"></td>
								<td><p>'.$addreess['first_name']. ', ' .$addreess['address']. ', ' .$addreess['road_name']. ', ' .$addreess['city_name'] . ', ' .$addreess['state_name'].', '.$addreess['post_code'].', Phone number: '. $addreess['phone'] .' <br>
								<a href="javascript:void(0)" onclick="edit_address('.$addreess['address_id'].')">Edit address</a></p></td>
							</tr>';
		 }  
		 $addreess_data ='<table id="secAddressData">
		 					'.$address_string.'
                        	<tr>
                              <td colspan="2"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-address" class="n-address">+ Add New Address</a></td>
                           </tr>
                        </table>'; 
        $addreess_div ='<div class="cart-heading-new">
							<h2>Select a delivery address</h2>
						</div>';                
                        $token = $this->Public_model->fetchShiprocketToken();

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/?delivery_postcode='.$add_pincode.'&pickup_postcode=700045&cod=1&weight=2',
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
          //echo "cURL Error #:" . $err;
        } else {
            //echo $response;
            $response_array = json_decode($response);
         
        }
        if($response_array->status == 200){
             $daliveryDate = $response_array->data->available_courier_companies[0]->estimated_delivery_days;
             $daliveryDate = ($daliveryDate.' Business Days');
        }
           $return_arr = array("delivery_amount"=>$delivery_amount,"addreess_data"=>$addreess_data,"total_amount"=>$tot_price,"selectedState" => $selectedState, "selected_address_id" => $selected_address_id, "delivery_address" => $daliveryDate, "addreess_div" => $addreess_div);
           echo json_encode($return_arr);		
    		
    	}
    	else{
    		echo '0';
    	}

    }
    public function add_skin_quiz(){

    	
    	$result = $this->Public_model->addSkinQuiz($_POST);
    	if ($result != '') {    		
    		echo $result;
    	}
    	else{
    		echo '0';
    	}

    }
    public function update_concern_name(){

    	$concern_name = $_POST['concern_name'];
    	$last_insert_id = $_POST['last_insert_id'];
    	$result = $this->Public_model->updateConcernName($concern_name,$last_insert_id);
    	$category = $this->Public_model->concernCategory($concern_name);
    	if ($category != '') {    		
    		echo $category['id'];
    	}
    	else{
    		echo '0';
    	}

    }
    public function fetch_quiz_product(){
    	$category_type = $_POST['category_type'];
    	$specified_type = $_POST['specified_type'];
    	$skin_type_h = $_POST['skin_type_h'];
    	$your_skin_type = $_POST['your_skin_type'];

    	$productArray = array();    	
    	$result = $this->Public_model->fetchQuizProduct($category_type,$specified_type,$skin_type_h,$your_skin_type);
    	$totItem = sizeof($result);
    	// echo "<pre>";
    	// print_r($result);
    	// die();
    	$tot_price = 0;

    	if($result){
    	foreach ($result as $key => $item) {

    		array_push($productArray, $item['variantID']);
    		$product .='<div class="col-6 col-lg-4 col-md-6">
	                        <div class="each-listing-of-product">
	                            <div class="product-image">
	                               
	                                <a href="'.LANG_URL . '/'.$item['url'].'" target=_blank><img src="'.base_url('/attachments/shop_images/' . $item['image']).'" border="0" alt="" ></a>
	                            </div>
	                            <div class="product-short-decription text-center">
	                                <p><a href="">'.$item['product_title'].'</a></p>
	                            </div>
	                            <div class="product-price-and-description text-center">
	                                 ₹'.$item['default_price'].'
	                            </div>
                                <div class="col-lg-12 text-center mt-4 product-add-to-cart">
                                <a href="javascript:void(0)" class="common-button btn-add-cart-list quiz_cart'.$key.'" onclick="quiz_product_add_single('.$item['productsID'].','.$key.')">Add to cart</a>
                                <a href="'.LANG_URL . '/shopping-cart" class="common-button quiz_go_to_cart'.$key.'" style="display: none;">Go to Cart</a>
                            </div>
	                        </div>
	                    </div>';
	        $tot_price += $item['default_price'];
    	}
    	$price = round($tot_price,0);
    	$price_percent = (($tot_price * 20)/100);
    	$buy_price = round($tot_price - $price_percent,0);
    	$productID = implode(',', $productArray);
    	$product_data = '<div class="row">'.$product.'<div class="col-lg-12 text-center mt-4 product-add-to-cart">
    	<input type="hidden" name="implodeProductID" id="implodeProductID" class="implodeProductID" value="'.$productID.'">

    			<div class="tot-regime-price price_none'.$category_type.'">Total Regime Price <strong>₹'.$buy_price. '</strong> <del>₹'.$price.'</del></div>
				<a href="javascript:void(0)" class="common-button btn-add-cart-list quiz_product_cartAdd" onclick="quiz_product_add()">BUY COMPLETE REGIME('.$totItem.' items)<span class="price_none'.$category_type.'"> & GET 20% OFF</span></a>
				<a href="'.LANG_URL . '/shopping-cart" style="display: none" class="common-button btn-add-cart-list quiz_product_gotocart">Go To Cart</a>
                
				<!-- <a href="'.LANG_URL . '/shopping-cart?quiz=yes&category_type='.$category_type.'" style="display: none" class="common-button btn-add-cart-list quiz_product_gotocart" target="_blank">Go To Cart</a> -->
				<!-- <div class="add-quiz-price price_none'.$category_type.'">
								<p>Total Regime Price</p>
								<h4><strong>₹'.$buy_price.'</strong><del>₹'.$price.'</del></h4>
								</div> -->						
					</div></div>';
    	
    	echo $product_data;
    }
    else{
    	echo '0';
    }
    }
    function skin_quiz_product_add(){
    	if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    	$productID = explode(",", $_POST['productID']);
    	$category_type = $_POST['category_type'];
    	$data = array();
    	foreach ($productID as  $item) {
    		array_push($data, $item);
    	$existProduct = $this->Public_model->checkCartProductExist($item, $_SESSION['logged_user']);
    	$productPrice = $this->Public_model->getProductPrice($item);
		
		$product_qunaitity = 0;
		if($existProduct != false){
			$product_qunaitity = ($existProduct['qty'] + 1);
			$this->Public_model->updateCartQuiz($item, $_SESSION['logged_user'], $product_qunaitity,$productPrice['price'],'1');
		}
		else{
			$this->Public_model->insertCartQuiz($item, $_SESSION['logged_user'],$productPrice['price'],'1',$category_type);
		}
    	}
		 echo json_encode($data);
    }
    public function getToken(){
    	$url = 'https://palsonsderma.unicommerce.com/oauth/token?grant_type=password&client_id=my-trusted-client&username=ayan@notionalsystems.com&password=7003660344Ad@';

		//Auth credentials
		// $username = "ayan@notionalsystems.com";
		// $password = "7003660344Ad@";

		//create a new cURL resource
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST , 'GET');
		curl_setopt($ch, CURLOPT_HTTPHEADER , array(
		    'Cookie: unicommerce=app1'
		));
		$response = curl_exec($ch);
		$err = curl_error($ch);

		curl_close($ch);
		$data = json_decode($response);
		//echo "<pre>"; print_r($data);
		$result = $this->Public_model->updateUnicommerceToken($data);
		//$_SESSION['access_token'] = $data->access_token;

		// if ($err) {
		//   echo "cURL Error #:" . $err;
		// } else {
		//   echo ($response);
		// }
		
	}
	public function getShipRocketToken(){
    	$url = 'https://apiv2.shiprocket.in/v1/external/auth/login';

		//Auth credentials
		// $username = "prasenjit@notionalsystems.com";
		// $password = "Prasenjit@2023";

		 $curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/auth/login',
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_SSL_VERIFYPEER => false,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'POST',
				  CURLOPT_POSTFIELDS =>'{
				    "email": "prasenjit@notionalsystems.com",
				    "password": "Prasenjit@2023"
				}',
				  CURLOPT_HTTPHEADER => array(
				    'Content-Type: application/json'
				  ),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				//echo $response;
				$data = json_decode($response);
				// echo "<pre>"; print_r($data);
				$result = $this->Public_model->updateShiprocketToken($data->token);
		//$_SESSION['access_token'] = $data->access_token;

		// if ($err) {
		//   echo "cURL Error #:" . $err;
		// } else {
		//   echo ($response);
		// }
		
	}
    public function create_category(){

    	 $token = $this->Public_model->getUnicommerceToken();

    	 $result = $this->Public_model->allCategory();
    	 $url = 'https://palsonsderma.unicommerce.com/services/rest/v1/product/category/addOrEdit';
    	 foreach($result as $item){
    	 	$category = array();
			$category['category']['code'] = $item['id'];
			$category['category']['name'] = $item['name'];
			$category['category']['taxTypeCode'] = "DEFAULT";
			$category['category']['gstTaxTypeCode'] = "GST_SERVICE_CHARGE";
    	 	$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_SSL_VERIFYHOST =>0,
			  CURLOPT_SSL_VERIFYPEER =>0,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => json_encode($category),
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Bearer ".$token['access_token'],
			    "Content-Type: application/json",
			    "Cookie: unicommerce=app1"
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			}

     
    }
    public function verify_reward(){
    	$mobile = $_POST['mobile_no'];
    	$redeem_paid_point = $_POST['redeem_paid_point'];
    	$result = $this->Public_model->checkUserIsValid($mobile);
    	$request_id = rand(100000, 999999);
            if ($result !== false) {
            	$otp = rand(100000, 999999);
            	//$otp = '123456';
            	$data = $this->Public_model->insertPointRedeemOTP($mobile, $request_id, $otp,$redeem_paid_point);
            	$_SESSION['logged_mobile'] = $mobile;
            	$massageID  = 161691;
				$this->sendSMS($massageID,$mobile,$otp);
            	 
            	echo $request_id;
            	
                				
            }
            else{
            	echo '0';
            }
    }
    public function verify_reward_otp(){
    	$reward_otp = $_POST['reward_otp'];
        $mobile = $_POST['mobile_no'];
        $request_id = $_POST['request_id'];
        $result = $this->Public_model->checkRewardOTPIsValid($reward_otp, $mobile);
        //print_r($result); exit;
        if ($result != false) {
        	 $items = $this->Public_model->totalRewardPointForReward($_SESSION['logged_user']);
        	 $tier = $this->Public_model->find_tier($items['tier']);
        	
        	 	$point = ($items['balancePont'] + $items['bonusPoint']);
        	 	$tot = ($point * $tier['pointPercentage']);

        	 	$this->Public_model->updatePoint_redeem_otp($request_id);
        	 	//$this->session->set_userdata('total_point', $point);
        	 
        	$six_digit_random_number = rand(100000, 999999);
			$offerData = new stdClass;
			$offerData->type = 'float';
			$offerData->amount = $tot;
			$offerData->point = $point;
			$offerData->request_id = $request_id;
			echo json_encode($offerData);
			//echo '1';
        }
        else{
            	echo '0';
            }
    }
    public function add_doctor_consultation(){

    	$name = $_POST['name'];
    	$mobile = $_POST['mobile'];
    	$state = $this->Public_model->searchState($_POST['add_state']);
    	$city = $this->Public_model->searchCity($_POST['add_city']);
    	// print_r($city);
    	// die();
    	$result = $this->Public_model->addNewDoctorConsultation($_POST,$state['id'],$city['id']);

    	if ($result != '') { 
    		$massageID = 160338;
    		$massageIDs = 160473;
    		$dermaMob = '7596004901';
			$this->sendWhatsAppSMSPhaseOne($mobile,$name,'dermatologist_consultant');
			$this->sendWhatsAppSMSrequestCallbackDermatologist($mobile,$name,'callback_request',$dermaMob);
			$this->sendSMS($massageID,$mobile);
			$this->sendSMS($massageIDs,$dermaMob,$name,$mobile);		
    		echo '1';
				
    	}
    	else{
    		echo '0';
    	}

    }
    public function find_store(){
    	$target = $_POST['target'];
    	$storeLocator = $this->Public_model->findStore($target);
    	
    	$store_data = '<div class="map">
								<iframe
									src="https://maps.google.com/maps?q='.$storeLocator['store_latitude'].','.$storeLocator['store_longitude'].'&hl=es;z=14&amp;output=embed"
									width="600" height="450" style="border:0; margin-top: -150px;" allowfullscreen="" loading="lazy"
									referrerpolicy="no-referrer-when-downgrade"></iframe>
							</div>';
    	//print_r($store_data);
    	echo $store_data;
    }
public function getOrderDetails(){
	$token = $this->Public_model->getUnicommerceToken();
	$orders_info = $this->Public_model->getAllOrder();
	//$orders_tracking = $this->Public_model->getAllTracking();
	
	// echo "<pre>";
	// print_r($orders_info); exit;
	foreach ($orders_info as $value) {
		//$this->sendEmailREADYTOSHIP($value['order_id']);
		// echo "<pre>";
		// print_r($order_product); exit;
		$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://palsonsderma.unicommerce.com/services/rest/v1/oms/saleorder/get',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_SSL_VERIFYHOST => 0,
  			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => '{
			  	"code" : '.$value['order_id'].' 
			  	}',
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Bearer '.$token['access_token'],
			    'Content-Type: application/json'
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($ch);
			curl_close($curl);
			if ($err) {
			  //echo "cURL Error #:" . $err;
			} else {
				
				$response_array = json_decode($response);
				if($response_array->successful){
				$saleOrderItems = $response_array->saleOrderDTO->saleOrderItems;
				$shippingPackages = $response_array->saleOrderDTO->shippingPackages;
				$returnItems = $response_array->saleOrderDTO->returns;

				$userName = $response_array->saleOrderDTO->billingAddress->name;
				$userMobile = $response_array->saleOrderDTO->billingAddress->phone;
				
				// echo "<pre>";
				// print_r($shippingPackages); 
				$order_product = $this->Orders_model->getLineItemOrderDetailsAdmin($value['id']);
				//$liste = array();
				foreach ($order_product as  $product) {
					$arr_products = unserialize($product['order_products']);
					$sales_order_code = explode(',', $product['sales_order_code']);
					 // if(!in_array($product['id'], $liste, true)){
					 //        array_push($liste, $product['id']);
					// 	}
					// echo "<pre>";
					// print_r($product['id']);
					foreach ($shippingPackages as $packages) {
						$invoice = $this->Public_model->updateInvoice($packages->code,$product['id']);
					}
					// echo "<pre>";
					// print_r($sales_order_code);exit;
					foreach ($saleOrderItems as $values) {
						//foreach ($sales_order_code as $order_code) {
							if(in_array($values->code,$sales_order_code)){
								$status = $values->shippingPackageStatus;

								if(sizeof($returnItems)>0){
									foreach ($returnItems as $return_value)
									{
										if($values->reversePickupCode == $return_value->code){
											if($return_value->statusCode == 'CREATED'){
												$return_value->statusCode = 'RETURN CREATED';
											}
											$status = $return_value->statusCode;
										}
									}
								}

								$result = $this->Public_model->changeOrderStatusLineItem($value['id'], $product['order_product_id'],strtolower($status));

							$orderTrackingData = $this->Public_model->findTrackingDataTrack($value['order_id'],$product['order_product_id'],$arr_products['product_info']['sku']);
							

						if($orderTrackingData['status'] != strtolower($status)){
								
						//if($values->shippingPackageStatus != $product['status']){
						   $trackingID = $this->Public_model->trackingOrderInsert($value['order_id'],$product['order_product_id'],$arr_products['product_info']['sku'],strtolower($status));

						  if($status == 'RETURNED'){
						  	if($order_product['refund_completed'] == 0){
						  		//get getails from point rollups
						  	$userPointRollups = $this->Public_model->userPointRollups($value['user_id']);

						  	$balancePoint = ($userPointRollups['balancePont'] + $orders_info['reward']);

						  	$rollupsUpdaetData = $this->Public_model->update_user_point_rollups_return($value['user_id'],$balancePoint);

							$this->Public_model->updateCustomarPointFrRefund($value['order_id'], $product['reward']);

							if($value['payment_type'] == 'Razorpay'){
					        	$this->amoundRefundByRazorpay($product['id']);
					    			}
								}
							}
							if($status == 'DELIVERED' && $value['payment_type'] == 'cashOnDelivery'){
										$this->shiprocketCod($product['id']);
										
									}
								/*  Start send email, whatsApp, text sms  */
							 	if($status == 'READY_TO_SHIP'){
									$this->sendEmailREADYTOSHIP($value['order_id']);
								}
								if($status == 'DISPATCHED'){
									$this->sendEmailDISPATCHED($value['order_id']);
								}
								if($status == 'DELIVERED'){
									$massageID = 160334;
									$this->sendEmailDELIVERED($value['order_id']);
									$this->sendSMS($massageID,$userMobile);
                                    $this->sendWhatsAppOrderDeliver($value['order_id'],'order_delivered');
								}

								/*  END send email, whatsApp, text sms  */
							}
								
							}
						//}

					}
			}
			}
		}
	
	}
				
				
	}
		public function amoundRefundByRazorpay($lineItem_id){
				//$razorpayOrderId = $razorpayOrder['id'];
				//$orders_info = $this->Public_model->getUserOrderDetails($order_id);
				$orders_info = $this->Public_model->getLineItemOrderDetails($lineItem_id);
				$refundAmount = $orders_info['unit_price'];
				$data = $this->Public_model->getpayID($orders_info['order_id']);
				$pay_id = $data['razorpay_payment_id'];

				$api = new RazorpayApi(razorpay_key, razorpay_secret);
				
				$api->payment->fetch($pay_id)->refund(array(
					"amount"=> $refundAmount * 100,
					'currency'        => "INR",
					"speed"=>"normal",
					"notes"=>array(
						"notes_key_1"=> "",
						"notes_key_2"=> ""
						),
						 "receipt"=> $orders_info['order_product_id'].$orders_info['id']
						)
					);
				
	}
	public function shiprocketCod($orderProductID){
		$lineItemID = $orderProductID;
		$orders_info = $this->Public_model->getLineItemOrderDetails($lineItemID);
		$findCustomarPoint = $this->Public_model->findCustomarPoint($lineItemID,$orders_info['order_id'],$orders_info['user_id']);

		$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);

		if(!$findCustomarPoint){
			$userPointSum = $this->Public_model->getUserPointSum($orders_info['user_id']);
		$tot_trans_amount = ($userPointSum['total_purchased_value']+$orders_info['unit_price']);
		$tier = $this->Public_model->getTier($tot_trans_amount);
		$pointBalance = ($orders_info['unit_price']);
		$currentBalance = $userPointSum['balancePont']+$userPointSum['bonusPoint']+$orders_info['unit_price'];
		$this->Public_model->insertCustomarPoint($orders_info, $currentBalance, $tier['tierMasterID'],$userPointSum['tier']);

		$currentPointBalance = $userPointSum['balancePont']+$orders_info['unit_price'];

		if($userPointSum){
	    	$this->Public_model->updateUserPointRollUps($orders_info['user_id'], $tier['tierMasterID'], $userPointSum['totalEarnPoint']+$orders_info['unit_price'],$currentPointBalance,$userPointSum['bonusPoint'],$tot_trans_amount,$userPointSum['redeem_point']);
	 
	    	}
	    	$point_exp = date("Y-m-d",strtotime ( '+1 year' , strtotime ( $orders_info['updated_date'] ) )) ;

	    	$this->sendWhatsAppSMSPointsEarned($userInfo['phone'],$pointBalance,'points_earned', $point_exp);
    	}
		// echo "<pre>";
		// print_r($orders_info);
	}
	public function sendBirthdayWishes(){
		$birthdayWishes = $this->Public_model->getBirthdayTierBydate();
		// echo "<pre>";
		// print_r($birthdayWishes);
		// exit;
		$massageID = 160332;
		foreach ($birthdayWishes as $value) {
				$this->sendSMS($massageID,$value['phone'],$value['name']);
				$this->sendWhatsAppSMSPhaseOne($value['phone'],$value['name'],'birthday_wishes');
		}
		
	}
	public function assignBirthdayCoupon(){
		$birthdayWishes = $this->Public_model->getBirthdayTier();
		// echo "<pre>";
		// print_r($birthdayWishes);
		// exit;
		foreach ($birthdayWishes as $value) {
			if($value['tier'] == '2'){
					$couponAmount = 299;
			   		$length_of_string = 6;
			   		$massageID = 160340;
	                $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	         
	                $text =  substr(str_shuffle($str_result),0, $length_of_string);
	                $coupon = $this->Public_model->createCoupon(strtoupper($text),$couponAmount,$value['phone']);
	                $this->sendWhatsAppSMSBirthDayCoupon($value['phone'],$text,'birthday_coupon');
	                $this->sendSMS($massageID,$value['phone'],strtoupper($text));
			}
			if($value['tier'] == '3'){
					$couponAmount = 499;
			   		$length_of_string = 6;
			   		$massageID = 160340;
	                $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	         
	                $text =  substr(str_shuffle($str_result),0, $length_of_string);
	                   $coupon = $this->Public_model->createCoupon(strtoupper($text),$couponAmount,$value['phone']);
	                $this->sendWhatsAppSMSBirthDayCoupon($value['phone'],$text,'birthday_coupon');
	                $this->sendSMS($massageID,$value['phone'],strtoupper($text));
				
			}
		}

	}
	public function order_tracking(){

		$orderTrackingData = $this->Public_model->findTrackingData($_POST['trackOrderId'],$_POST['trackSku']);
		foreach ($orderTrackingData as  $orderTracking) {
			$orderDate = date("d-m-Y h:i:s a", strtotime($orderTracking['updated_date']));
			$tracking_string .= '<div class="tracking-item">
		      <div class="tracking-icon status-intransit">
		         <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
		            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
		         </svg>
		      </div>
		      <div class="tracking-date">
		         <p><strong>'.$orderDate.'</strong><br></p>
		      </div>
		      <div class="tracking-content">
		         <p><strong style="text-transform: capitalize">'.$orderTracking['status'].'</strong><br>Order ID: '.$orderTracking['orderID'].'</p>
		      </div>
		   </div>';
		}
		$tracking_data = '<div class="tracking-list">'.$tracking_string.'</div>';
		echo $tracking_data;
	}

	public function getInventorySync(){
		$token = $this->Public_model->getUnicommerceToken();
		$allProducts = $this->Public_model->getAllProducts();		
		// echo "<pre>";
		// print_r($allProducts);exit;
		foreach ($allProducts as $products) {
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://palsonsderma.unicommerce.com/services/rest/v1/inventory/inventorySnapshot/get',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			    "itemTypeSKUs": [
			        "'.$products['sku'].'"
			    ]
			}',
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Bearer '.$token['access_token'],
			    'Facility: palsonsderma',
			    'Content-Type: application/json'
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($ch);
			curl_close($curl);
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
				//echo "<pre>";
				//print_r($response);
				$response_array = json_decode($response);
				if($response_array->successful){
					$inventorySnapshots = $response_array->inventorySnapshots;
					//print_r($inventorySnapshots);
					foreach ($inventorySnapshots as $value) {
						$this->Public_model->updateProductsInventory($value->inventory,$products['id']);
					}
				}
			}
		}
	}
	public function expiryPoint(){
		$previousData = $this->Public_model->expiryPoint();
		$nxtSavenDays = $this->Public_model->nxtSavenDays();
		$massageID = 160339;
		foreach ($nxtSavenDays as $items) {
			$userInfo = $this->Public_model->getUserProfileInfo($items['customerID']);
			$this->sendSMS($massageID,$userInfo['phone'],$items['pointBalance']);
		}
		
		foreach ($previousData as $value) {
			$this->Public_model->updateCustomerPointExpFlag($value['coustomerPointID']);

			$customerPoint = $this->Public_model->getTotCustomerPoint($value['customerID']);
			$this->Public_model->updateExpiryRollups($value['customerID'], $customerPoint['balancePont'] - $value['pointBalance']);
						
		}
	}
	public function checkDeliverPin(){
		$token = $this->Public_model->fetchShiprocketToken();
		$delivery_pincode = $_POST['delivery_pincode'];

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/?delivery_postcode='.$delivery_pincode.'&pickup_postcode=700045&cod=1&weight=2',
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
			 echo ($delivery_pincode . ' Pincode Available. Expected Delivery in ' .$daliveryDate.' Days');
		}
		else{
			echo "Sorry! Item(s) are not available in your location";
		}
	}
	
	public function genarate_invoice(){

		  $blob_contents = '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t2GFjICkFAfO/s3wltv2TNU8M+ING1hv2zP7VmLqllcnxfN4oa5aSC6huFXb9l27JAysIvKy3L43fsU1rG86StHG0kYIRyo3KD1APbOB+VAtYxced5cfmhdgfaN23OcZ9M9qAPyN8Xfs/wDhnx//AME3PHXxM8XaTpuofFO7+Kc1vqfiJWzdMz+IodMngjmXBFt5EjxCJcIARgKcY9ws/wBgz4OXX/BVjVvBsvw58K/8Iq3woh1n+xo7XFmt5Lqc1k10IgdqyG2hiTeoBBUt945r7+GlWot2h+zW/ks28p5Y2ls5zjpnPOfWnLYW63ZuBDCJyuwyBBvK5zjPXGSTj1NAH4//AA9+C2m/D/8A4J1fs5/EjwHp2m6X8YNY+JEGl23iFci8vXub6+sRbyzNy0DRxwpsb5AsfuSeR/Zs+H1x8TL74e+DdF1r4M+EfjJp+tC+EsvhrxFB4+ttUtiZ7o6lclnjPmBXWQyr5DKxVQPlC/tYuk2qQRxLa24ihcPGgjG1GByCBjg55yO9TeRH5rSbF8xgFLY5IGSBn2yfzNAH5Ln4TaT8Sf2DND+Nmr6LdeJNQ8Z/Em5v/ivqltG9zqtx4Xh1e+tri1jMY85LVBbWe6KHbtSJ8YVSBl/tiat8C/GGlWWofAHSdBXwlp+p6ZL8R72w0LVR4WawQStafb4rfy1kjikdZZlQiUlomy219v6821jDZIFhhihUZICIFAycnp6kk0+KCOBNsaKi5LYUYGSSSfxJJ/GgD89f+CU3gx9Y+P3jTxp4V8R/B8+DW0qPRtZ0f4faPqul6TLqX7uW3u1S8BieRITJGzQNgLJhl3Ek/oZUdvaRWkCxQxRxRoMKiKFVfoKkoAKKKKAP/9kNCmVuZHN0cmVhbQplbmRvYmoKeHJlZgowIDE1CjAwMDAwMDAwMDAgNjU1MzUgZg0KMDAwMDAwMDAxNSAwMDAwMCBuDQowMDAwMDAwMjExIDAwMDAwIG4NCjAwMDAwMDAyNTAgMDAwMDAgbg0KMDAwMDAwMDExNSAwMDAwMCBuDQowMDAwMDAwMzA3IDAwMDAwIG4NCjAwMDAwMDAzNjIgMDAwMDAgbg0KMDAwMDAwMDYwOSAwMDAwMCBuDQowMDAwMDAwNjY3IDAwMDAwIG4NCjAwMDAwMDI1MDMgMDAwMDAgbg0KMDAwMDAwMjYwMCAwMDAwMCBuDQowMDAwMDAyNzAzIDAwMDAwIG4NCjAwMDAwMDMxNTQgMDAwMDAgbg0KMDAwMDAwMzU4MyAwMDAwMCBuDQowMDAwMDA0MDYwIDAwMDAwIG4NCnRyYWlsZXIKPDwKL0luZm8gNCAwIFIKL0lEIFs8OTc4NUM4QUIwMDJFMTRFMUVCMTZDREFCREVCOTJCNzM+IDxENjg5NENFMjQxRUU2NEUxOUY3MzVDNUM3NkE0RTg0MD5dCi9Sb290IDEgMCBSCi9TaXplIDE1Cj4+CnN0YXJ0eHJlZgo3ODc1CiUlRU9GCg==';
		  $decoded = base64_decode($blob_contents);
		$file = 'invoice.pdf';
		file_put_contents($file, $decoded);

		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}
		// $shippingPackageCode = $_POST['shippingPackageCode'];
		// $curl = curl_init();

		// curl_setopt_array($curl, array(
		//   CURLOPT_URL => 'https://onboarding.unicommerce.com/services/rest/v1/oms/shippingPackage/getInvoiceLabel',
		//   CURLOPT_RETURNTRANSFER => true,
		//   CURLOPT_ENCODING => '',
		//   CURLOPT_MAXREDIRS => 10,
		//   CURLOPT_TIMEOUT => 0,
		//   CURLOPT_SSL_VERIFYHOST => 0,
		//   CURLOPT_SSL_VERIFYPEER => 0,
		//   CURLOPT_FOLLOWLOCATION => true,
		//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		//   CURLOPT_CUSTOMREQUEST => 'POST',
			//  CURLOPT_POSTFIELDS =>'{
		    // "shippingPackageCode ": '.$shippingPackageCode.'
			// }',
		//   CURLOPT_HTTPHEADER => array(
		//     'Authorization: Bearer ceb47911-cd70-433d-a8a1-99d51daeea34',
		//     'Type: application/pdf',
		//     'Charset: UTF-8',
		//     'Facility: palsonsderma'
		//   ),
		// ));

		// $response = curl_exec($curl);
		// $err = curl_error($curl);
		// curl_close($curl);
		// if ($err) {
		//   //echo "cURL Error #:" . $err;
		// } else {
		//   echo ($response);
		// }

	}
	public function sendEmailRegistration($first_name,$last_name,$email)
	{
           
            $sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
                   
                        //Send Email
                        $invoice_mail = '<div style="max-width:570px;margin:0px auto;padding:30px 45px;">
			<div style="text-align:center;margin-bottom:30px;">
				<img src="'.base_url('attachments/site_logo/' . $sitelogo).'" width="260" height="38" border="0" alt="">
			</div>
			
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">Hello <strong>'.$first_name.'</strong>,<br>We proudly welcome you to our <strong>PRO family</strong>, where you can win exciting offers while receiving the best care your skin can care.</p>
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">We are happy to have you on board and ensure the best shopping experience you can get!!!</p>
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center; margin-bottom:0px;
			margin-top:20px;">Yours Lovingly,</p>

			<h3 style="font-size: 23px;color: #1a9ba9;font-weight: 700;text-align: center;margin-bottom: 50px;margin-top: 0px;line-height: 12px;"><br>Neolayr Pro</h3>
			<hr>
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">Please do not hesitate to call us at <a href="" style="color: #1a9ba9;"><strong>1 800 891 6349</strong></a> or email us at <a href="" style="color: #1a9ba9;"><strong>info@palsonsderma.com</strong></a>, to get your queries answered!<br> We are always here for you.</p>
			<hr>
			
		</div>';
                        //print_r($invoice_mail); exit;
                $toName = $first_name.' '.$last_name;
                $toEmail = $email;
                $fromName = 'NEOLAYR';
                $fromEmail = 'neolayrpro@palsonsderma.com';
                $subject = 'Successfully Registration';
                

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

            public function verify_pincode()
            {
            	$pincode = $_POST['pins'];
            	$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://api.data.gov.in/resource/04cbe4b1-2f2b-4c39-a1d5-1c2e28bc0e32?api-key=579b464db66ec23bdd000001a3cf87c1940f413b62be5d896fb153d3&format=json&filters%5Bpincode%5D='.$pincode,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_SSL_VERIFYPEER => false,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'GET',
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);
				$data = json_decode($response);
				//echo $response;
				// if ($err) {
                //   echo "cURL Error #:" . $err;
                // } else {
                //   echo $response;
                // }

                 //exit;

                $stateItem = $this->Public_model->searchState(ucwords(strtolower($data->records[0]->statename)));

                if($stateItem == ''){
                	$sateID = $this->Public_model->insertState(ucwords(strtolower($data->records[0]->statename)));
                }


                $cityItem = $this->Public_model->searchCity(ucwords(strtolower($data->records[0]->taluk)));

                if($cityItem == ''){
                	if($stateItem == ''){
                		$this->Public_model->insertCity(ucwords(strtolower($data->records[0]->taluk)), $sateID);
                	}
                	else{
                		$this->Public_model->insertCity(ucwords(strtolower($data->records[0]->taluk)), $stateItem['id']);
                	}
                }
                if($data->records[0]->taluk == 'NA'){
                	$taluk = '';
                }
                else{
                	$taluk = $data->records[0]->taluk;
                }
				$pincode_data = array("city"=>$taluk,"state"=>$data->records[0]->statename);
				 echo json_encode($pincode_data);

            }
            public function address_edits()
            {
            	$id = $_POST['id'];
            	$address = $this->Public_model->getAddressDetails($id);
            	echo json_encode($address);
            }
        public function update_address(){

    	$add_name = $_POST['add_name'];
    	$add_last_name = $_POST['add_last_name'];
    	$add_mob = $_POST['add_mob'];
    	$add_pincode = $_POST['add_pincode'];
    	$add_state = $_POST['add_state'];
    	$add_city = $_POST['add_city'];
    	$add_build_name = $_POST['add_build_name'];
    	$add_road_name = $_POST['add_road_name'];
    	$landmark = $_POST['landmark'];
    	$state = $this->Public_model->searchState($_POST['add_state']);
    	$city = $this->Public_model->searchCity($_POST['add_city']);
    	$address_id = $_POST['address_id'];
        $productVariant = $_POST['productVariant'];
        
    	if(sizeof($city)>0){
    	$this->Public_model->updateAddress($_POST,$state['id'],$city['id'],$address_id);
    	}
    	else{
    		$cityID = $this->Public_model->insertCity($_POST['add_city'],$state['id']);
    		$this->Public_model->updateAddress($_POST,$state['id'],$cityID,$address_id);
    	}
    	
        
    	$getUserAddress = $this->Public_model->getPreviousAddress($_SESSION['logged_user']);
    	$data['selectedAddress'] = $getUserAddress[0]['state']; 
    	$selectedState = $getUserAddress[0]['state'];            
        $selected_address_id = $getUserAddress[0]['address_id'];
        $totalReward = $this->Public_model->totalRewardPoint($_SESSION['logged_user']);
        $getCurentTier = $this->Public_model->getCurentTier($_SESSION['logged_user']);
    	if ($getUserAddress != '') {
            if($productVariant != ''){
                $productData = $this->Public_model->buyNowProductData($productVariant,$_SESSION['logged_user']);
                $prices = str_replace(",", "", $productData['price']);
                $tot_prices = ($prices*$productData['qty']);
                
                $tot_price = $tot_prices;

            } else{
                $items = $this->shoppingcart->getCartItems();
                $ref_tot_price = 0;
                foreach ( $items['array'] as $var ) {
                    $price = str_replace(",", "", $var['price']);
                    $ref_tot_price += ($price*$var['num_added']);
                    $tot_price += ($price*$var['num_added']);
                }
            }
    	
        //$delivery_amount = 0;
        $data['delivery_amount'] = '0.00';
        if($tot_price >= 1000){
            $delivery_amount = '0.00';
        }else{
        	if($getCurentTier['tier'] == '1'){
	             if($selectedState == '41'){
	                 $delivery_amount = '45.00';
	             }else{
	                 $delivery_amount = '65.00';
	             }
	         }
	         else{
                    $delivery_amount = '0.00';
            }
        } 
    		
    		foreach($getUserAddress as $key => $addreess){
    			$chcek = '';
    			if($key == '0')
    			{
    			 $chcek = 'checked';
    			} 
			 $address_string .='<tr>
								<td><input type="radio" name="a" '.$chcek.' id='.$addreess['address_id'].' onChange="setDeliveryAddress('.$addreess['address_id'].','.$addreess['state'].',\''.$addreess['sortname'].'\','.$tot_price.','.$totalReward['tier'].',\''.$addreess['post_code'].'\')"></td>
								<td><p>'.$addreess['first_name']. ', ' .$addreess['address']. ', ' .$addreess['road_name']. ', ' .$addreess['city_name'] . ', ' .$addreess['state_name'].', '. $addreess['post_code'] .', Phone number: '. $addreess['phone'] .'<br>
								<a href="javascript:void(0)" onclick="edit_address('.$addreess['address_id'].')">Edit address</a></p></td>
							</tr>';
		 }  
		 $addreess_data ='<table id="secAddressData">
		 					'.$address_string.'
                        	<tr>
                              <td colspan="2"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-address" class="n-address">+ Add New Address</a></td>
                           </tr>
                        </table>'; 
           $return_arr = array("delivery_amount"=>$delivery_amount,"addreess_data"=>$addreess_data,"total_amount"=>$tot_price,"selectedState" => $selectedState, "selected_address_id" => $selected_address_id);
           echo json_encode($return_arr);
    	}
    	else{
    		echo '0';
    	}

    }
    public function check_address_avail(){
    	$data = $this->Public_model->check_address_avail($_SESSION['logged_user']);

    	if(sizeof($data)<= 0){
    		$user_arr = array("name"=>$_SESSION['logged_name'],"mobile"=>$_SESSION['logged_mobile']);
           echo json_encode($user_arr);
    	}
    }
    public function sendEmailNewUser($name, $email){
        
        $sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
        //Send Email
        $new_user = '<div style="max-width:570px;margin:0px auto;padding:30px 45px;">
			<div style="text-align:center;margin-bottom:30px;">
				<img src="'.base_url('attachments/site_logo/' . $sitelogo).'" width="260" height="38" border="0" alt="">
			</div>
			
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">Hello <strong>'.$name.'</strong>,<br>We proudly welcome you to our <strong>PRO family</strong>, where you can win exciting offers while receiving the best care your skin can care.</p>
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">We are happy to have you on board and ensure the best shopping experience you can get!!!</p>
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center; margin-bottom:0px;
			margin-top:20px;">Yours Lovingly,</p>

			<h3 style="font-size: 23px;color: #1a9ba9;font-weight: 700;text-align: center;margin-bottom: 50px;margin-top: 0px;line-height: 12px;"><br>Neolayr Pro</h3>
			<hr>
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">Please do not hesitate to call us at <a href="" style="color: #1a9ba9;"><strong>1 800 891 6349</strong></a> or email us at <a href="" style="color: #1a9ba9;"><strong>info@palsonsderma.com</strong></a>, to get your queries answered!<br> We are always here for you.</p>
			<hr>
			
		</div>';
        //print_r($new_user); exit;
        $toName = $name;
        $toEmail = $email;
        $fromName = 'NEOLAYR';
        $fromEmail = 'neolayrpro@palsonsderma.com';
        $subject = 'Welcome to NEOLAYRPRO family';

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
            "htmlContent" => $new_user
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
    public function sendEmailREADYTOSHIP($orderId)
	{
		//$orderId = '202308280000591';
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
		$invoice_product .= '
		<table style="width:100%;padding:10px 20px;">
		   <tr>
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
		</table>
		';
		}
		//Send Email
		$invoice_mail = '
		<div style="max-width:570px;margin:0px auto;padding:30px 45px;">
		   <div style="text-align:center;margin-bottom:30px;">
		      <img src="'.base_url('attachments/site_logo/' . $sitelogo).'" width="260" height="38" border="0" alt="">
		   </div>
		   
		   <p style="font-size:15px;line-height:35px;color:#7b7b7b;font-weight:400; text-align:center;">Hi '.$orders_info[0]['first_name'].' '.$orders_info[0]['last_name'].',<br>Get ready to experience the best care for your skin as we have dispatched your items.</p>
		   <p style="font-size:15px;line-height:28px;color: #27a1ae;;font-weight:400; text-align:center;"><strong>Your order is on the way!</strong></p>
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
		         <td style="font-size:15px;color:#7b7b7b;font-weight:600; text-align:right;line-height:40px;"> ₹'.number_format($orders_info[0]['total_order_price'],2).'</td>
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
		               '.$orders_info[0]['phone'].'
		            </p>
		         </td>
		      </tr>
		   </table>
		</div>
		';
		//print_r($invoice_mail); exit;
		$toName = $orders_info[0]['first_name'].' '.$orders_info[0]['last_name'];
		$toEmail = $orders_info[0]['email'];
		$fromName = 'NEOLAYR';
		$fromEmail = 'neolayrpro@palsonsderma.com';
		$subject = 'Your NEOLAYRPRO order is READYTOSHIP';
		$htmlMessage = '<p>Hello '.$toName.',</p>';
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
	public function sendEmailDISPATCHED($orderId)
	{
		//$orderId = '202308280000591';
		$orderdata = $this->Public_model->findOrderID($orderId);
		$orders_info = $this->Public_model->getUserOrderDetailsTwo($orderdata['id']);
		//$orders_info = $this->Public_model->getOrderDetails($orderId);
		$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
		//echo $userInfo['email']; exit;
		//print_r($orders_info); exit;
		$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
		
		//Send Email
		$invoice_mail = '<div style="max-width:570px;margin:0px auto;padding:30px 45px;">
			<div style="text-align:center;margin-bottom:30px;">
				<img src="'.base_url('attachments/site_logo/' . $sitelogo).'" width="260" height="38" border="0" alt="">
			</div>
			
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">Hi <strong>'.$orders_info[0]['first_name'].' '.$orders_info[0]['last_name'].'</strong>,<br>Your package will be delivered today by our executives.</p>
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">We have accumulated the <strong>best from the world</strong> in these packages, so, drop in an unboxing video so that we can preach about how <strong>PRO you are at skincare</strong>.</p>			
			
			
		</div>';
		//print_r($invoice_mail); exit;
		$toName = $orders_info[0]['first_name'].' '.$orders_info[0]['last_name'];
		$toEmail = $orders_info[0]['email'];
		$fromName = 'NEOLAYR';
		$fromEmail = 'neolayrpro@palsonsderma.com';
		$subject = 'Your NEOLAYRPRO order is DISPATCHED';
		$htmlMessage = '
		<p>Hello '.$toName.',</p>
		';
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
	public function sendEmailDELIVERED($orderId)
	{
		//$orderId = '202308280000591';
		$orderdata = $this->Public_model->findOrderID($orderId);
		$orders_info = $this->Public_model->getUserOrderDetailsTwo($orderdata['id']);
		//$orders_info = $this->Public_model->getOrderDetails($orderId);
		$userInfo = $this->Public_model->getUserProfileInfo($orders_info['user_id']);
		//echo $userInfo['email']; exit;
		//print_r($orders_info); exit;
		$sitelogo = $this->Home_admin_model->getValueStore('sitelogo');
		
		//Send Email
		$invoice_mail = '<div style="max-width:570px;margin:0px auto;padding:30px 45px;">
			<div style="text-align:center;margin-bottom:30px;">
				<img src="'.base_url('attachments/site_logo/' . $sitelogo).'" width="260" height="38" border="0" alt="">
			</div>
			
			<p style="font-size:15px;line-height:28px;color:#7b7b7b;font-weight:400; text-align:center;">Hi <strong>'.$orders_info[0]['first_name'].' '.$orders_info[0]['last_name'].'</strong>,<br><strong>The World Class care</strong> for your skin has been delivered.</p>
						
			<h3 style="font-size:17px;color:#505050;font-weight:700; text-align:center;margin-bottom:50px;">Check out your Procoins here!  <a href="'.base_url('/users/reward').'">Reward</a></h3>
			
		</div>';
		//print_r($invoice_mail); exit;
		$toName = $orders_info[0]['first_name'].' '.$orders_info[0]['last_name'];
		$toEmail = $orders_info[0]['email'];
		$fromName = 'NEOLAYR';
		$fromEmail = 'neolayrpro@palsonsderma.com';
		$subject = 'Your NEOLAYRPRO order is DELIVERED';
		$htmlMessage = '
		<p>Hello '.$toName.',</p>
		';
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
    
    
}
