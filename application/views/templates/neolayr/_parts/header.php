<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= $title ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="keywords" content="<?= $keywords ?>" />
	<meta name="description" content="<?= $description ?>">
	<meta name="author" content="<?= $title ?>">
	<meta property="og:title" content="<?= $title ?>" />
	<meta property="og:description" content="<?= $description ?>" />
	<meta property="og:url" content="<?= LANG_URL ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?= base_url('assets/img/site-overview.png') ?>" />

    <!--Google font-->
    <link href="https://fonts.cdnfonts.com/css/univers-lt-std" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Icons -->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('fancyboxCss/jquery.fancybox-1.3.4.css') ?>" media="screen" />    -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <!-- Favicon -->
    <link rel="icon" href="<?php echo base_url(); ?>fabicon.ico" type="image/ico">

    
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/bootstrap.min.css') ?>">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/swiper.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/site-common.css') ?>">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/fonts.css') ?>">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/main.css') ?>">
    
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/inner-page-css.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/style.css') ?>">
    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/mediaquery.css') ?>">
    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->

    <!-- <script type="text/javascript" src="<?= base_url('fancyboxJS/jquery.fancybox-1.3.4.pack.js') ?>"></script> -->

    <!-- <script src="<?= base_url('templatejs/jquery-3.4.1.min.js') ?>" ></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js" integrity="sha512-j7/1CJweOskkQiS5RD9W8zhEG9D9vpgByNGxPIqkO5KrXrwyDAroM9aQ9w8J7oRqwxGyz429hPVk/zR6IOMtSA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
 <script type="text/javascript">
            $(window).load(function() {
                $(".loader").fadeOut("slow");
            });
        </script>
	<script type="text/javascript">
		var lang = {
			added_to_cart: "Added to cart",
			error_to_cart: "Problem with shopping cart! Try again!",
			no_products: "No products",
			confirm_clear_cart: "Are you sure want to delete items in shopping cart?",
			cleared_cart: "Your cart is empty",
			are_you_sure: "Are you sure?",
			yes: "Yes",
			no: "No",
			clear_all: "Clear",
			checkout: "Payment",
			remove_from_cart: "Deleted from shopping cart",
			enter_valid_email: "Please enter a valid email address",
			discountCodeInvalid: "Discount code is invalid",
            need_total_amount: "Need total amount geter then 199",
            more_item_added: "Add more item",
		};
		</script>
        <script>
                var url = 'https://wati-integration-prod-service.clare.ai/v2/watiWidget.js?81624';
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = url;
                var options = {
                "enabled":true,
                "chatButtonSetting":{
                    "backgroundColor":"#00e785",
                    "ctaText":"Chat with us",
                    "borderRadius":"25",
                    "marginLeft": "0",
                    "marginRight": "20",
                    "marginBottom": "60",
                    "ctaIconWATI":false,
                    "position":"right"
                },
                "brandSetting":{
                    "brandName":"Neolayr Pro",
                    "brandSubTitle":"undefined",
                    "brandImg":"https://pps.whatsapp.net/v/t61.24694-24/328712064_311590161282213_9027239698308586842_n.jpg?ccb=11-4&oh=01_AdRQbc-UEbg1OLwmH79VYsrjxYVtaPsjwTQzKzZPv8XWuQ&oe=65019114&_nc_sid=000000&_nc_cat=107",
                    "welcomeText":"Hi there!\nHow can I help you?",
                    "messageText":"Hi there!%0AHow can I help you?",
                    "backgroundColor":"#00e785",
                    "ctaText":"Chat with us",
                    "borderRadius":"25",
                    "autoShow":false,
                    "phoneNumber":"917596005367"
                }
                };
                s.onload = function() {
                    CreateWhatsappChatWidget(options);
                };
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            </script>        
</head>
<body>
    <!-- <div class="whats-float">
    <a href=""
       target="_blank">
        <i class="fa fa-whatsapp"></i><span>WhatsApp<br><small>+917596005367</small></span>
    </a>
</div> -->
    <div class="loader"></div>
    <!-- START : TOP BAR -->
    <div class="top-bar">
        <ul>
            <li><a href="<?php echo base_url();?>#storeDataDivFst" class="scroll_storeLocators" id="storeLocators" style="height: 80px; overflow-y: auto">Store Locator </a></li>
            <li><a href="<?php echo base_url();?>#skin_quiz" class="scroll_skin_quiz" style="height: 80px; overflow-y: auto">Free Skin Assessment</a></li>
        </ul>
    </div>
    <!-- END TOP BAR ----->
    <!-- START HEADER -->
    <header class="site-header">
        <div class="container">
            <div class="row">
                <div class="col-5 menu-area">
                    <ul class="dextop-menu">
                        <li><a href="<?= base_url() ?>" class="<?php if($pageactive == 'home' || $pageactive == '') echo 'active' ?>">Home</a></li>
                        <?php 
                            function loop_menu_tree($pages, $is_recursion = false)
                                {
                                    //print_r($pages);die;
                                        foreach ($pages as $page) {
                                            $children = false;
                                            if (isset($page['children']) && !empty($page['children'])) {
                                                $children = true;
                                            }
                                            ?>
                                            <?php if($page['name'] != 'Ingredients' ){ ?>
                                            <li class="<?php if($children === true) echo 'has-children mega-menu';?>">
                                                <?php
                                                
                                            if ($children === true) { ?>
                                            <a href="javascript:void(0)" data-categorie-id="<?= $page['id'] ?>">
                                                <?= $page['name'] ?>
                                            </a>
                                             <?php }  else{ ?>
                                                <a href="<?= LANG_URL . '/category?type='.$page['category_slug'] ?>" data-categorie-id="<?= $page['id'] ?>">
                                                <?= $page['name'] ?>
                                            </a>
                                             <?php } ?>
                                            <?php
                                            if ($children === true) {
                                                echo '<ul>';
                                                loop_menu_tree($page['children'], true);
                                            } else {
                                            ?>
                                            </li>
                                            <?php
                                            } }
                                        }
                                        ?>
                                    </li>
                                    <?php
                                    if ($is_recursion === true) {
                                        ?>
                                       <!--   <li><a href="<?= LANG_URL . '/ingredient' ?>">Shop by Ingredients</a></li>
                                        <li><a href="<?= LANG_URL . '/category' ?>">Shop All</a></li> -->
                                       
                                        </ul>
                                        <?php
                                    }
                                }
                            
                            loop_menu_tree($this->all_categories);
                            ?>
                        <!-- <li class="has-children mega-menu">
                            <a href="">Shop</a>
                            <ul>
                                
                                 <li class="has-children mega-menu">
                                    <a href="">Shop by Concern</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/category?type=acne' ?>">Acne</a></li>
                                        <li><a href="">Pigmentation</a></li>
                                        <li><a href="">Dullness</a></li>
                                        <li><a href="">Lines & Wrinkles</a></li>
                                        <li><a href="<?= LANG_URL . '/category?type=dry-skin' ?>">Dry Skin</a></li>
                                        <li><a href="">Hair Fall</a></li>
                                    </ul>
                                </li>
                                <li class="has-children mega-menu"><a href="">Shop by ingredients</a>
                                    <ul>
                                        <li><a href="">Acne</a></li>
                                        <li><a href="">Pigmentation</a></li>
                                        <li><a href="">Dullness</a></li>
                                        <li><a href="">Lines & Wrinkles</a></li>
                                        <li><a href="">Dry Skin</a></li>
                                        <li><a href="">Hair Fall</a></li>
                                    </ul>
                                </li>
                                <li class="has-children mega-menu"><a href="">Shop by ingredients</a>
                                    <ul>
                                        <li><a href="">Acne</a></li>
                                        <li><a href="">Pigmentation</a></li>
                                        <li><a href="">Dullness</a></li>
                                        <li><a href="">Lines & Wrinkles</a></li>
                                        <li><a href="">Dry Skin</a></li>
                                        <li><a href="">Hair Fall</a></li>
                                    </ul>
                                </li>
                                <li class="has-children mega-menu"><a href="">Shop by ingredients</a>
                                    <ul>
                                        <li><a href="">Acne</a></li>
                                        <li><a href="">Pigmentation</a></li>
                                        <li><a href="">Dullness</a></li>
                                        <li><a href="">Lines & Wrinkles</a></li>
                                        <li><a href="">Dry Skin</a></li>
                                        <li><a href="">Hair Fall</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->
                        <!-- <li><a href="<?= LANG_URL . '/ingredient' ?>" class="<?php if($pageactive == 'ingredient') echo 'active' ?>">Ingredients</a>
                        </li>  -->
                        <!-- <li><a href="">Gift Sets</a></li> -->
                        <li><a href="<?= LANG_URL . '/aboutus' ?>" class="<?php if($pageactive == 'aboutus') echo 'active' ?>">About Us</a></li>
                    </ul>
                </div>
                <div class="col-2 logo-area-body">
                    <div class="logo-area">
                        <a href="<?= base_url() ?>"><img src="<?= base_url('images/site-logo.png') ?>" alt=""></a>
                    </div>
                </div>
                <div class="col-5 d-flex justify-content-end align-items-center">
                    <div class="m-serch">
                        <span class="">
                            <a href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" title="Search">
                                <img src="<?= base_url('images/search.png') ?>" alt="" >
                            </a>
                            
                            <input type="search" placeholder="SEARCH" id="search__input" class="search__input" value="<?= isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' ?>" name="search_in_title" autocomplete="off">
							<input type="submit" value="SEARCH" class="header-form-submit"  onclick="getProductSearch();" id="search_submit">
                        
                        </span>
                    </div>
                    <div class="mobile-search">
                        <a href="javascript:void(0)" >
                            <img src="<?= base_url('images/search.png') ?>" alt="">
                        </a>
                    </div>
                    <div class="hamburger" id="hamburger-1">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <ul class="right-profile-area">
                        <?php if(!isset($_SESSION['logged_user'])){?>
                        <li>
                            <a href="#login" class="fancybox others_login" data-toggle="tooltip" data-placement="top" title="Profile">
                                <img src="<?= base_url('images/user.png')?>" alt="">
                            </a>
                        </li>
                    <?php } else {?>
                        <li class="when-already-login">
                            <a href="javascript:void(0)">
                                <img src="<?= base_url('images/user.png')?>" alt=""></a>
                            <div class="personal-info-when-login text-left">
                                <div class="name-area">
                                    <h6> <strong>Hello <?php echo $_SESSION['logged_user_name']; ?></strong></h6>
                                    <p>Welcome to NEOLAYR PRO </p>
                                </div>
                                <ul>
                                    <li><a href="<?= LANG_URL . '/users/orders' ?>">My Orders</a></li>
                                    <!-- <li><a href="<?= LANG_URL . '/users/wishlist' ?>">Wishlist</a></li> -->
                                    <li><a href="<?= LANG_URL . '/users/profile' ?>">Profile</a></li>
                                    <li><a href="<?= LANG_URL . '/users/reward' ?>">Reward</a></li>
                                    
                                    <li><a href="<?= LANG_URL . '/manage-address' ?>">Manage Address</a></li>
                                    <!-- <li><a href="<?= LANG_URL . '/manage-address' ?>">Edit Profile</a></li> -->
                                    <li><a href="<?= LANG_URL . '/logout' ?>">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <?php } ?> 
                        <?php if(!isset($_SESSION['logged_user'])){?>
                         <li><a href="#login" class="fancybox position-relative" data-toggle="tooltip" data-placement="top" title="Wishlist"><span class="counter-number wishlist_conter"><?=$this->wishlist_counter;?></span><img src="<?= base_url('images/wishlist.png')?>" alt=""></a></li>
                         <?php } else { ?>                     
                        <li onclick="openWishlist()"><a href="<?= LANG_URL . '/users/wishlist' ?>" class="position-relative" data-toggle="tooltip" data-placement="top" title="Wishlist"><span class="counter-number wishlist_conter"><?=$this->wishlist_counter;?></span> <img src="<?= base_url('images/wishlist.png') ?>" alt=""></a></li>
                        <?php } ?>
                        <?php if(!isset($_SESSION['logged_user'])){?>
                         <li><a href="#login" class="fancybox" data-toggle="tooltip" data-placement="top" title="Tracking"><img src="<?= base_url('images/fast-delivery.png')?>" alt=""></a></li>
                        <?php } else{?>
                        <li><a href="<?= LANG_URL . '/users/orders' ?>" data-toggle="tooltip" data-placement="top" title="Tracking"><img src="<?= base_url('images/fast-delivery.png')?>" alt=""></a></li>
                        <?php } ?>
                        <?php if(!isset($_SESSION['logged_user'])){?>
                        <li><a href="<?= base_url('shopping-cart') ?>" data-toggle="tooltip" data-placement="top" title="Cart" class="position-relative"><span class="counter-number sumOfItems"><?= $cartItems['array'] == 0 ? 0 : $sumOfItems ?></span><img src="<?= base_url('images/shopping-bag.png')?>" alt=""></a></li>
                        <?php } else { ?>
                             <li><a href="<?= base_url('shopping-cart') ?>" data-toggle="tooltip" data-placement="top" title="Cart" class="position-relative"><span class="counter-number sumOfItems"><?= $preCartProduct == 0 ? 0 : $preCartProduct ?></span><img src="<?= base_url('images/shopping-bag.png')?>" alt=""></a></li>
                        <?php } ?>

                        <li><span data-toggle="modal" data-target="#doctor-popup"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Dermatologist Consultation"><img src="<?= base_url('images/love-copy.png')?>" alt=""></a></span></li> 
                    </ul>
                    <!-- <ul class="right-profile-area">
                        <li class="m-serch"><span class=""><a href="javascript:void(0)"><img src="<?= base_url('images/search.png') ?>" alt=""></a><input type="text" placeholder="SERCH"></span></li>
                        <?php if(!isset($_SESSION['logged_user'])){?>
                        <li><a href="#login" class="fancybox"><img src="<?= base_url('images/user.png')?>" alt=""></a></li>
                        <?php } else{ ?>
                            <li><a href="<?= LANG_URL . '/users/profile' ?>"><img src="<?= base_url('images/user.png')?>" alt=""></a></li>
                            <?php } ?>
                        <li><a href="<?= LANG_URL . '/users/orders' ?>"><img src="<?= base_url('images/fast-delivery.png')?>" alt=""></a></li>
                        <li><a href="<?= base_url('shopping-cart') ?>"><img src="<?= base_url('images/shopping-bag.png')?>" alt=""></a></li>
                        <?php if(!isset($_SESSION['logged_user'])){?>
                        <li><a href="#login" class="fancybox"><img src="<?= base_url('images/wishlist.png') ?>" alt=""></a></li>
                        <?php } else{ ?>
                            <li onclick="openWishlist()"><a href="<?= LANG_URL . '/users/wishlist' ?>"><img src="<?= base_url('images/wishlist.png') ?>" alt=""></a></li>
                        <?php } ?>
                        
                        <li><a href=""><img src="<?= base_url('images/love-copy.png')?>" alt=""></a></li>
                    </ul> -->
                </div>
            </div>
        </div>
        <div class="mobile-search-wrapper">
            <input type="text" placeholder="Search by product name" id="search__input" class="search__input" value="<?= isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' ?>" name="search_in_title" autocomplete="off">
        </div>
    </header>    
    <div id="login" style="width:879px; max-width:100%; overflow:hidden; padding:10px; background:#fff; display: none;  ">
            <div class="login-inner" >
                <div class="f-login always-open" >
                    <h2>sign in</h2>
                    <div class="h-gap"></div>
                    <div>
                        
                        <label>Enter Mobile Number</label>
                        <input type="text" name="mobile_no" id="mobile_no" placeholder="Enter Mobile Number" maxlength="10" onkeypress="return isNumber(event)">
                        <input type="hidden" name="no_mobile" value="" id="no_mobile">
                        <p class="wrong_mobile blank_number">Please enter valid mobile number.</p>
                        <p class="wrong_mobile add-new-message">This number is not registered with us. Please SIGN UP.</p>
                        <div class="hide-signup">
                        <a href="#sign-up" class="fancybox sign_login"><button type="button" class="first-sign" > Sign Up</button></a>
                        </div>
                        <div class="if-errow">
                            <div class="h-gap"></div>
                            <p>By signing in, I agree to <a href="<?= LANG_URL . '/page/terms_condition' ?>">Terms and Conditions</a></p>
    
                            <button type="button" class="first-sign firstLogin" id="loginDuplicate">Sign In</button>
                            <button type="button" class="first-sign login_wait" style="display: none;">Please Wait..</button>
                            <!-- <input type="submit" value="Sign in" class="first-sign"><br> -->
                            <br>
                            <br>
                            <!-- <p>New Member ? <a href="#sign-up" class="newMember fancybox">Register Here</a></p> -->
                        </div>
                    </div>
                </div>
                <!-- <div class="otp-login" style="display:none">
                    <h2>Verify with OTP....</h2>                    
                    <div >
                        <div class="otp-gap"></div>
                        <label>Enter OTP</label>
                        <input type="text" name="otp_no" id="otp_no" placeholder="Enter OTP">
                        <p class="wrong_mobile">You have enter wrong OTP number</p>
                        <p class="resend_otp">OTP send to your mobile number</p>
                        <label><a href="javascript:void(0)" onclick="resendOtp();">Resend</a></label>
                        <div class="otp-gap"></div>
                        <p><a href="">Trouble getting OTP?</a><br>Make sure you entered correct mobile number</p>
                        <button type="button" class="first-sign" id="otpVerify">Submit</button>
                    </div>
                </div> -->
            </div>
        </div>
    <div id="sign-up" style="width:879px; max-width:100%; overflow:hidden; padding:10px; background:#fff;   display:none  ">
            <div class="login-inner" >
                <div class="sign-up" >
                    <h2>Sign up</h2>                 
                    <div>
                        <div  class="row">
                            <div class="col-12">
                        <label>Enter Your Name *</label>
                        <input type="text" name="first_name" placeholder="Enter Your Name" id="first_name">
                        <p class="wrong_registration wrong_firstName" id="wrong_firstName">Invalid  Name</p>
                        <!--<label>last Name *</label>-->
                        <!--<input type="text" name="last_name" placeholder="Last Name" id="last_name">-->
                        <!--<p class="wrong_registration wrong_lastName" id="wrong_lastName">Invalid Last Name</p>-->
                    </div>
                        <div class="col-6">
                        <label>Mobile Number *</label>
                        <input type="text" name="mobile" placeholder="Mobile Number" id="mobile" maxlength="10" onkeypress="return isNumber(event)" class="mobile_reg">
                        <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Invalid Mobile Number</p>
                        <p class="wrong_registration mobileNumber_exists" id="mobileNumber_exists">Mobile number already exist</p>
                    </div>
                    <div class="col-6">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email" id="email">
                        <p class="wrong_registration wrong_emailAddress" id="wrong_emailAddress">Invalid Email Address</p>
                    </div>
                    <div class="col-12">
                        <label>Date of Birth </label>
                        <input type="date" name="dob" placeholder="DOB" id="dob">
                        <p class="special_wish">Share your special date to avail exciting offers during your birthday week!</p>
                        <p class="wrong_registration select_dob" id="select_dob">Please select Date of Birth</p>
                        <!-- <label>Anniversary Date</label>
                        <input type="date" name="anniversary" placeholder="Anniversary" id="anniversary">
                        <p class="special_wish">Share your special date to avail exciting offers during your anniversary week!</p> -->
                    </div>
                    <div class="col-12">
                        <label>Gender</label>
                        <div class="n-check-box-area ">
                            <ul class="">
                                <li>
                                    <input type="radio" id="gender1" name="gender" value="Male" checked>
                                    <label for="a-option">Male</label>                                  
                                </li>
                                <li>
                                    <input type="radio" id="gender2" name="gender" value="Female">
                                    <label for="b-option">Female</label>                                    
                                </li>
                                <li>
                                    <input type="radio" id="gender3" name="gender" value="Other">
                                    <label for="c-option">Other</label>                                 
                                </li>                           
                            </ul>
                        </div>
                        </div>
                        <button type="button" class="subReg" id="registration" onclick="registration()";>Submit</button>
                        <button type="button" class="subRegWait" style="display: none;">Please Wait..</button>
                        <!-- <button type="button" class="" id="registration" onclick="registration_otp()";>Submit</button> -->
                        <!-- <input type="submit" value="Sign in" > -->
                        </div>
                    </div>
                </div>              
            </div>
        </div>
<div class="modal common-popup-style" tabindex="-1" role="dialog" id="registration_otp">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div  class="login-inner">
               <div class="otp-login" >
                  <h2>Verify with OTP</h2>
                  <div >
                     <!-- <label class="sent_to">Sent to <?php echo $_SESSION['logged_mobile'];?></label> -->
                     <div class="otp-gap"></div>
                     <label>Enter OTP</label>
                     <input type="text" name="otp_no_reg" id="otp_no_reg" placeholder="Enter OTP">
                     <p class="wrong_mobile">You have enter wrong OTP number</p>
                     <p class="resend_otp">OTP send to your mobile number</p>
                     <label><a href="javascript:void(0)" onclick="resendOtp();">Resend</a></label>
                     <div class="otp-gap"></div>
                     <p><a href="">Trouble getting OTP?</a><br>Make sure you entered correct mobile number</p>
                     <button type="button" class="first-sign firstOtp" id="otpVerifyReg">Submit</button>
                     <button type="button" class="first-sign waitOtp" style="display:none;">Please wait..</button>
                     <!-- <input type="submit" value="Sign in"> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
    <div class="modal fade common-popup-style" id="doctor-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<h3 class="text-center">Dermatologist Consultation</h3>
                    <div class="login-inner dermatologist" >
                        <div class="f-login f-address" >
                            <div>
                                <!-- <h3>Doctor Consultation</h3> -->
                                <label>Enter Your Name *</label>
                                <input type="text" name="d_name" id="d_name" placeholder="Enter Your Name">
                                <p class="wrong_registration wrong_firstName" id="wrong_firstName">Please enter your name</p>
                               
                                <label>Enter Mobile Number *</label>
                                <input type="text" name="d_mobile" id="d_mobile" placeholder="Enter Mobile Number" maxlength="10" onkeypress="return isNumber(event)">
                                <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Please enter Mobile Number</p>
                                
                                <label>PINCode *</label>
                                <input type="text" name="add_pincode" id="add_pincode_dermatologist" class="add-pin" placeholder="Pincode" maxlength="6" onkeypress="return isNumber(event)">
                                <p class="wrong_registration mobileNumber_exists select_pincode" id="select_pincode">Please enter Pincode</p>
                                
                                <label>State *</label>
                                <input type="text" name="state" id="stateInputDoctor" class="add_state" placeholder="State">
                                <p class="wrong_registration mobileNumber_exists select_state" id="select_state">Please Enter State</p>
                                <!-- <select id="stateInputDoctor" name="state" class=" add_state" onChange="changeStateForDoctor(this.value);">
                                <option value="" disabled selected>Please Select State</option>
                                <?php foreach($this->state_list as $state){?>
                                 <option value="<?php echo $state['id'];?>"><?php echo $state['state_name'];?></option>
                                 <?php } ?> 
                                 
                            
                            </select> -->
                        <!-- <p class="wrong_registration mobileNumber_exists select_state" id="select_state">Please select State</p> -->
                        
                        <label>City *</label>
                            <!-- <select name="thana" id="thanaDoctor" class="" >
                               <option value="">-</option>
                            </select> -->
                            <input type="text" name="thana" id="thanaDoctor" class="" placeholder="City">
                            <p class="wrong_registration mobileNumber_exists select_city" id="select_city">Please enter City</p>
                             <br>
                                <button type="button" class="add_consultation" id="add_consultation" onclick="add_doctor_consultation()">Submit</button>
                                <button type="button" class="add_consultation_wait" id="add_consultation_wait" style="display: none;">Please wait...</button>
                                <p style="display: none;" class="we_contact">We will contact with you shortly!</p>
                                <!-- <input type="submit" value="Submit" class="first-sign"> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- <div class="login-successfully-message login-message">
		You're successfully logged in 
	</div> -->
	<!-- <div class="login-successfully-message regiter-message">
		you're now registered with us, Please�<a href="">log in</a>
	</div> -->

    <div class="login-successfully-message consultation-message">
        We will contact with you shortly!
    </div>

    <div class="login-successfully-message review-success-message">
        Thank you for giving your review/rating!
    </div>

    <div class="login-successfully-message add-wishlist-message">
        Item added to your wishlist!
    </div>

    <div class="login-successfully-message already-add-wishlist-message">
         This item already added to your wishlist!
    </div>

    <div class="login-successfully-message select-address-message">
         Please Add address !
    </div>
    
    <!-- END HEADER -->
    <main>