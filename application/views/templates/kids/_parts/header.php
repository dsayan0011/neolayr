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
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/fontawesome.css') ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/ico">
    
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/animate.css') ?>">

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/slick.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/slick-theme.css') ?>">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/bootstrap.css') ?>">

    <!-- Themify icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/themify-icons.css') ?>">
    
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/sweetalert2.min.css') ?>">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/styles.css') ?>">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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
</head>
<body>


    <!-- loader start -->
 <div class="loader-wrapper">
    <div class=" bar">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    </div>
</div>
    <!-- loader end -->

<!-- header part start -->
<header class="header-1">
    <div class="mobile-fix-header">
    </div>
    <div class="container">
        <div class="row header-content">
            <div class="col-12">
                <div class="header-section">
                    <div class="brand-logo">
                        <a href="<?= base_url() ?>"> <img src="<?= base_url('attachments/site_logo/' . $sitelogo) ?>" class="" alt=""></a>
                    </div>
                    <div class="search-bar">
                    <form method="GET" action="<?= LANG_URL.'/products' ?>" id="bigger-search">
                        <input class="search__input" type="search" value="<?= isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' ?>" name="search_in_title" placeholder="Search a product">
                        <button class="search-icon" type="submit"></button>
                     </form>  
                    </div>
                    <div class="nav-icon">
                        <ul>
                         <li class="onhover-div setting-icon">
                               <a href="<?= base_url() ?>"><i class="fa fa-home home-icon" aria-hidden="true"></i></a>
                        </li>
                        <li class="onhover-div search-3">
                                <div onclick="openSearch()">
                                    <i class="ti-search mobile-icon-search" ></i>
                                    <img src="<?= base_url('templatecss/imgs/search.png') ?>" class=" img-fluid search-img" alt="">
                                </div>
                                <div id="search-overlay" class="search-overlay">
                                    <div>
                                        <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                        <div class="overlay-content">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <form method="GET" action="<?= LANG_URL.'/products' ?>" id="bigger-search">
                                                            <div class="form-group">
                                                                <input type="search" value="<?= isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' ?>" name="search_in_title" class="form-control" id="search_in_title" placeholder="Search a Product">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                           
                            
                            <li class="onhover-div wishlist-icon" onclick="openWishlist()">
                                <img src="<?= base_url('templatecss/imgs/wishlist.png') ?>" alt=""  class="wishlist-img">
                                <i class="ti-heart mobile-icon"></i>
                                <div class="wishlist icon-detail">
                                    <h6 class="up-cls"><span><span class="wishlist_conter"><?=$this->wishlist_counter;?></span> item</span></h6>
                                    <h6><a href="<?= LANG_URL . '/users/wishlist' ?>">wish list</a></h6>
                                </div>
                            </li>
                            <li class="onhover-div user-icon" onclick="openDashboard()">
                                <img src="<?= base_url('templatecss/imgs/user.png') ?>" alt="" class="user-img">
                                <i class="ti-user mobile-icon"></i>
                                <div class="wishlist icon-detail">
                                    <h6 class="up-cls"><span>my account</span></h6>
                                    <?php if(!isset($_SESSION['logged_user'])){?>
                                    <h6><a href="<?= LANG_URL . '/users/login' ?>">login/sign up</a></h6>
                                    <?php } else{?>
                                    <h6><a href="<?= LANG_URL . '/users/dashboard' ?>">Orders</a></h6>
                                    <?php } ?>
                                </div>
                            </li>
                            <li class="onhover-div cart-icon" onclick="openCart()">
                                <img src="<?= base_url('templatecss/imgs/cart.png') ?>" alt="" class="cart-image">
                                <span class="cart_counter sumOfItems"><?= $cartItems['array'] == 0 ? 0 : $sumOfItems ?></span>
                                <i class="ti-shopping-cart mobile-icon"></i>
                                <div class="cart  icon-detail">
                                    <h6 class="up-cls"><span><span class="sumOfItems"><?= $cartItems['array'] == 0 ? 0 : $sumOfItems ?></span> item</span></h6>
                                    <h6><a href="#">my cart</a></h6>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-class">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav id="main-nav">
                        <div class="toggle-nav">
                            <i class="ti-menu-alt"></i>
                        </div>
                        <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                            <li>
                                <div class="mobile-back text-right">
                                    Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i>
                                </div>
                            </li>
                            <li class="icon-cls"><a href="<?= base_url() ?>"><i class="fa fa-home home-icon" aria-hidden="true"></i></a></li>
                            <li><a href="<?= base_url() ?>">Home</a> </li>
                            <?php 
							function loop_menu_tree($pages, $is_recursion = false)
								{
									
										foreach ($pages as $page) {
											$children = false;
											if (isset($page['children']) && !empty($page['children'])) {
												$children = true;
											}
											?>
											<li>
											<a href="<?= LANG_URL . '/category?type='.$page['category_slug'] ?>" data-categorie-id="<?= $page['id'] ?>">
												<?= $page['name'] ?>
											</a>
											<?php
											if ($children === true) {
												echo '<ul>';
												loop_menu_tree($page['children'], true);
											} else {
											?>
											</li>
											<?php
											}
										}
										?>
									</li>
									<?php
									if ($is_recursion === true) {
										?>
										</ul>
										<?php
									}
								}
							
							loop_menu_tree($this->all_categories);
							?>
                            <!--<?php if(sizeof($this->all_vendor)>0){?>
                             <li class="">
                                    <a href="javascript:void(0)" class="sf-with-ul">Suppliers</a>
                                    <ul>
                                        <?php foreach($this->all_vendor as $vendor){?>
                                        <li><a href="<?= LANG_URL . '/products' ?>?suppliers=<?= $vendor['warehouse_name'];?>"><?= $vendor['warehouse_name'];?></a> </li>  
                                        <?php } ?>
                                     </ul>
                             </li>
                            <?php } ?>
                            <?php if(sizeof($this->all_state)>0){?>
                             <li class="">
                                    <a href="javascript:void(0)" class="sf-with-ul">Location</a>
                                    <ul>
                                        <?php foreach($this->all_state as $state){?>
                                        <li><a href="<?= LANG_URL . '/products' ?>?state=<?= $state['state_name'];?>"><?= $state['state_name'];?></a> </li>  
                                        <?php } ?>
                                     </ul>
                             </li>-->
                            <?php } ?>
                            <?php if(isset($_SESSION['logged_user'])){?>
                             <li class="float-left <?= uri_string() == 'logout' || uri_string() == MY_LANGUAGE_ABBR . '/users/logout' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/users/logout' ?>">Logout</a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header part end -->