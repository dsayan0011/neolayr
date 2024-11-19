<!DOCTYPE html>
<html lang="<?= MY_LANGUAGE_ABBR ?>"><head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>
	<?= $title ?>
	</title>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-51402701-2"></script>	
	<script>	
	  window.dataLayer = window.dataLayer || [];	
	  function gtag(){dataLayer.push(arguments);}	
	  gtag('js', new Date());	
	  gtag('config', 'UA-51402701-2');	
	</script>	
	<meta name="keywords" content="<?= $keywords ?>" />
	<meta name="description" content="<?= $description ?>">
	<meta name="author" content="<?= $title ?>">
	<meta property="og:title" content="<?= $title ?>" />
	<meta property="og:description" content="<?= $description ?>" />
	<meta property="og:url" content="<?= LANG_URL ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?= base_url('assets/img/site-overview.png') ?>" />
	<link rel="stylesheet" href="<?= base_url('templatecss/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/sweetalert2.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('templatecss/fontawesome.css') ?>">
	<link rel="stylesheet" href="<?= base_url('templatecss/style.min.css') ?>">
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <?php if(isset($add_google) && $add_google){?>
    <script data-ad-client="ca-pub-1128402722206399" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <?php } ?>
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
		discountCodeInvalid: "Discount code is invalid"
	};
	</script>
</head>
<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-middle">
                <div class="container">
                    <div class="header-left">
                        <a href="<?= base_url() ?>" class="logo">
                            <img src="<?= base_url('attachments/site_logo/' . $sitelogo) ?>" alt="myindiantoy">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                            <form class="form-horizontal" method="GET" action="<?= LANG_URL.'/products' ?>" id="bigger-search">
                            		 <input type="hidden" name="category" value="<?= isset($_GET['category']) ? $_GET['category'] : '' ?>">
                            		<input type="hidden" name="in_stock" value="<?= isset($_GET['in_stock']) ? $_GET['in_stock'] : '' ?>">
                                    <input type="hidden" name="order_new" value="<?= isset($_GET['order_new']) ? $_GET['order_new'] : '' ?>">
                                    <input type="hidden" name="order_price" value="<?= isset($_GET['order_price']) ? $_GET['order_price'] : '' ?>">
                                    <input type="hidden" name="order_procurement" value="<?= isset($_GET['order_procurement']) ? $_GET['order_procurement'] : '' ?>">
                                    <input type="hidden" name="brand_id" value="<?= isset($_GET['brand_id']) ? $_GET['brand_id'] : '' ?>">
                                <div class="header-search-wrapper">
                                    <input type="search"  value="<?= isset($_GET['search_in_title']) ? $_GET['search_in_title'] : '' ?>" class="form-control" name="search_in_title" id="search_in_title" placeholder="Search..." required>
                                    <!-- End .select-custom -->
                                    <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                    </div><!-- End .headeer-center -->

                    <div class="header-right">
                        <button class="mobile-menu-toggler" type="button">
                            <i class="icon-menu"></i>
                        </button>

                        <div class="header-contact">
                            <span>Call Us</span>
				<?php
				if ($footerContactPhone != '') {?>			    
				    <a href="tel:<?= $footerContactPhone;?>"><strong><?= $footerContactPhone;?></strong></a>
				<?php } ?>
			</div>
                        <div class="header-contact">
                            <span>Email Us</span>			
				<?php
				if ($footerContactEmail != '') {?>			
				    <a href="email:<?= $footerContactEmail;?>"><strong><?= $footerContactEmail;?></strong></a>				<?php } ?>			
			</div>			

                        <div class="dropdown cart-dropdown">
                            <a href="<?= LANG_URL . '/shopping-cart' ?>" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <span class="cart-count sumOfItems"><?= $cartItems['array'] == 0 ? 0 : $sumOfItems ?></span>
                            </a>

                            <div class="dropdown-menu" >
                                <div class="dropdownmenu-wrapper">
                                    <div class="dropdown-cart-header">
                                        <span> <span class="sumOfItems"><?= $cartItems['array'] == 0 ? 0 : $sumOfItems ?></span> Items</span>
										<?php if (!empty($cartItems['array'])) {?>
                                        <a href="<?= LANG_URL . '/shopping-cart' ?>">View Cart</a>
										<?php } ?>
                                    </div><!-- End .dropdown-cart-header -->
                                    <ul class="dropdown-cart-products dropdown-cart">
                                     <?= $load::getCartItems($cartItems) ?>
                                    	 <?php /*?><?php
										  if (!empty($cartItems['array'])) {
											foreach ($cartItems['array'] as $cartItem) {?>
                                                <div class="product">
                                                    <div class="product-details">
                                                        <h4 class="product-title">
                                                            <a href="<?= LANG_URL . '/' . $cartItem['url'] ?>"><?= $cartItem['title'] ?></a>
                                                        </h4>
        
                                                        <span class="cart-product-info">
                                                            <span class="cart-product-qty"><?= $cartItem['num_added'] ?></span>
                                                            x <?= CURRENCY.$cartItem['price']?>
                                                        </span>
                                                    </div><!-- End .product-details -->
        
                                                    <figure class="product-image-container">
                                                        <a href="<?= LANG_URL . '/' . $cartItem['url'] ?>" class="product-image">
                                                            <img src="<?= base_url('/attachments/shop_images/' . $cartItem['image']) ?>" alt="product">
                                                        </a>
                                                        <a onclick="removeProduct(<?= $cartItem['id'] ?>,true)" href="javascript:void(0)" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                                    </figure>
                                                </div>
                                         <?php } } ?><?php */?>
                                    </ul>
									
                                   <?php /*?> <div class="dropdown-cart-total">
                                        <span>Total</span>

                                        <span class="cart-total-price"><?= CURRENCY.$cartItems['finalSum'];?></span>
                                    </div>

                                    <div class="dropdown-cart-action">
                                        <a href="<?= LANG_URL . '/shopping-cart' ?>" class="btn btn-block">Checkout</a>
                                    </div><?php */?>
                                </div><!-- End .dropdownmenu-wrapper -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->

            <div class="header-bottom sticky-header">
                <div class="container">
                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            <li class="<?= uri_string() == '' || uri_string() == MY_LANGUAGE_ABBR ? 'active' : '' ?>"><a href="<?= base_url() ?>">Home</a></li>
                            
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
		<?php if(sizeof($this->all_vendor)>0){?>
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
		 </li>
        <?php } ?>
        <?php if(!isset($_SESSION['logged_user'])){?>
        <li class="float-right <?= uri_string() == 'login' || uri_string() == MY_LANGUAGE_ABBR . '/users/login' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/users/login' ?>">Log In</a></li>
        <?php } else{?>
        <li class="float-right <?= uri_string() == 'logout' || uri_string() == MY_LANGUAGE_ABBR . '/users/logout' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/users/logout' ?>">Logout</a></li>
        <li class="float-right <?= uri_string() == 'dashboard' || uri_string() == MY_LANGUAGE_ABBR . '/users/dashboard' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/users/dashboard' ?>">My Orders</a></li>
        <?php } ?>
        <li class="float-right <?= uri_string() == 'contacts' || uri_string() == MY_LANGUAGE_ABBR . '/contacts' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/contacts' ?>">Contact Us</a></li>
        </ul>
      </nav>
        </div>
    <!-- End .header-bottom --> 
  </div>
      <!-- End .header-bottom --> 
    </header>
<!-- End .header -->

        <main class="main">