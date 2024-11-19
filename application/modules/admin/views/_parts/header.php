<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $description ?>">
        <title><?= $title ?></title>
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Favicon -->
	<link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/ico">	    
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
        <link href="<?= base_url('assets/css/custom-admin.css') ?>" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <?php if ($this->session->userdata('logged_in')) { ?>
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-lg fa-bars"></i>
                            </button>
                        </div>
                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> Home</a></li>
                                <li><a href="<?= base_url() ?>" target="_blank"><i class="glyphicon glyphicon-star"></i> Production</a></li>
                                <li>
                                    <a href="javascript:void(0);" class="h-settings"><i class="fa fa-key" aria-hidden="true"></i> Pass Change</a>
                                    <div class="relative">
                                        <div class="settings">
                                            <div class="panel panel-primary" >
                                                <div class="panel-heading">
                                                    <div class="panel-title">Security</div>
                                                </div>     
                                                <div class="panel-body">
                                                    <label>Change my password</label> <span class="bg-success" id="pass_result">Changed!</span>
                                                    <form class="form-inline" role="form">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control new-pass-field" placeholder="New password" name="new_pass">
                                                        </div>
                                                        <a href="javascript:void(0);" onclick="changePass()" class="btn btn-sm btn-primary">Update</a>
                                                        <hr>
                                                        <span>Password Strength:</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-default generate-pwd">Generate Password</button> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="javascript:void(0);" data-toggle="modal" data-target="#modalCalculator"><i class="fa fa-calculator" aria-hidden="true"></i> Calculator</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?= base_url('admin/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </div>
                    </nav>
                <?php } ?>
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($this->session->userdata('logged_in')) {
							$perimission = $this->session->userdata('adminPermission');
							 ?>
                            <div class="col-sm-3 col-md-3 col-lg-2 left-side navbar-default">
                                <div class="show-menu">
                                    <a id="show-xs-nav" class="visible-xs" href="javascript:void(0)">
                                        <span class="show-sp">
                                            Show menu
                                            <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                                        </span>
                                        <span class="hidde-sp">
                                            Hide menu
                                            <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </div>
                                <ul class="sidebar-menu">
                                    <li class="sidebar-search">
                                        <div class="input-group custom-search-form">
                                            <form method="GET" action="<?= base_url('admin/products') ?>">
                                                <div class="input-group">
                                                    <input class="form-control" name="search_title" value="<?= isset($_GET['search_title']) ? $_GET['search_title'] : '' ?>" type="text" placeholder="Search in products...">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" value="" placeholder="Find product.." type="submit">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                    <li class="header">ECOMMERCE</li>
                                    <?php 
									if(array_key_exists('publish_product',$perimission) && $perimission['publish_product'] == 1){?>
                                    <li><a href="<?= base_url('admin/publish') ?>" <?= urldecode(uri_string()) == 'admin/publish' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> Publish product</a></li>
                                    <?php }if(array_key_exists('manage_product',$perimission) && $perimission['manage_product'] == 1){ ?>
                                    <li><a href="<?= base_url('admin/products') ?>" <?= urldecode(uri_string()) == 'admin/products' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> Products</a></li>

                                     <li><a href="<?= base_url('admin/products_bulk_upload') ?>" <?= urldecode(uri_string()) == 'admin/products_bulk_upload' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> Products Bulk Upload</a></li>
                                    <!-- <li><a href="<?= base_url('admin/products_review') ?>" <?= urldecode(uri_string()) == 'admin/products_review' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> Product Review</a></li> -->
									<?php }if(array_key_exists('manage_shop_categories',$perimission) && $perimission['manage_shop_categories'] == 1){ ?>
                                    <li><a href="<?= base_url('admin/shopcategories') ?>" <?= urldecode(uri_string()) == 'admin/shopcategories' ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> Shop Categories</a></li>
                                    <?php }if(array_key_exists('success_payment',$perimission) && $perimission['success_payment'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/orders/process_order') ?>" <?= urldecode(uri_string()) == 'admin/orders/process_order' ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> Success Payment</a></li> -->
									<?php }if(array_key_exists('manage_orders',$perimission) && $perimission['manage_orders'] == 1){ ?>
                                    <li>
                                        <a href="<?= base_url('admin/orders') ?>" <?= urldecode(uri_string()) == 'admin/orders' ? 'class="active"' : '' ?>>
                                            <i class="fa fa-money" aria-hidden="true"></i> Orders 
                                            <?php if ($numNotPreviewOrders > 0) { ?>
                                                <img src="<?= base_url('assets/imgs/exlamation-hi.png') ?>" style="position: absolute; right:10px; top:7px;" alt="">
                                            <?php } ?>
                                        </a>
                                    </li>
                                    <?php }?>
                                    <?php if(array_key_exists('update_delivery_charge',$perimission) && $perimission['update_delivery_charge'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/deliveryCharge') ?>" <?= urldecode(uri_string()) == 'admin/deliveryCharge' ? 'class="active"' : '' ?>><i class="fa fa-money" aria-hidden="true"></i> Delivery Charges</a></li> -->
                                     <?php }if(array_key_exists('return_update',$perimission) && $perimission['return_update'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/return') ?>" <?= urldecode(uri_string()) == 'admin/return' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>
                                     <?php if ($numNotViewReturnOrders > 0) { ?>
                                                <img src="<?= base_url('assets/imgs/exlamation-hi.png') ?>" style="position: absolute; right:10px; top:7px;" alt="">
                                    <?php } ?>
                                    Return Order</a></li> -->
									
									<?php }if(array_key_exists('manage_account',$perimission) && $perimission['manage_account'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/account') ?>" <?= urldecode(uri_string()) == 'admin/account' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Accounts</a></li> -->

                                    <?php } ?>

                                    <li><a href="<?= base_url('admin/store') ?>" <?= urldecode(uri_string()) == 'admin/store' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Store Locator</a></li>

                                    <li><a href="<?= base_url('admin/shopConcern') ?>" <?= urldecode(uri_string()) == 'admin/shopConcern' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Shop Concern</a></li>

                                    <li><a href="<?= base_url('admin/testimonial') ?>" <?= urldecode(uri_string()) == 'admin/testimonial' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Testimonials</a></li>
                                    <!-- <li><a href="<?= base_url('admin/regime') ?>" <?= urldecode(uri_string()) == 'admin/regime' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Regime Shop</a></li> -->

                                    <li><a href="<?= base_url('admin/ingredient') ?>" <?= urldecode(uri_string()) == 'admin/ingredient' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Ingredient</a></li>
                                    <li><a href="<?= base_url('admin/ingredient/product_list') ?>" <?= urldecode(uri_string()) == 'admin/ingredient/product_list' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Ingredient Product</a></li>
                                    <li><a href="<?= base_url('admin/doctor_consultation') ?>" <?= urldecode(uri_string()) == 'admin/doctor_consultation' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Doctor Consultation </a></li>
                                    <li><a href="<?= base_url('admin/contact_us') ?>" <?= urldecode(uri_string()) == 'admin/contact_us' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Contact Us </a></li>
                                    <li><a href="<?= base_url('admin/product_list_banner') ?>" <?= urldecode(uri_string()) == 'admin/product_list_banner' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Product List Banner </a></li>
                                    <li><a href="<?= base_url('admin/quiz_image/1') ?>" <?= urldecode(uri_string()) == 'admin/quiz_image' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Quiz Image </a></li>

                                    <!-- <li class="header">REPORT</li> -->
                                    <?php if(array_key_exists('view_order_report',$perimission) && $perimission['view_order_report'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/report') ?>" <?= urldecode(uri_string()) == 'admin/report' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> Order Report</a></li> -->
                                    <!-- <li><a href="<?= base_url('admin/report/advance_order') ?>" <?= urldecode(uri_string()) == 'admin/report/advance_order' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Advance Order Report</a></li> -->
									<?php }if(array_key_exists('view_product_sales_report',$perimission) && $perimission['view_product_sales_report'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/report/product') ?>" <?= urldecode(uri_string()) == 'admin/report/product' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> Product Sales Report</a></li> -->
                                    <?php }if(array_key_exists('view_user_report',$perimission) && $perimission['view_user_report'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/report/user') ?>" <?= urldecode(uri_string()) == 'admin/report/user' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> User Report</a></li> -->
                                    <?php }if(array_key_exists('view_newsletter_subscriber_report',$perimission) && $perimission['view_newsletter_subscriber_report'] == 1){ ?>
                                    <li><a href="<?= base_url('admin/report/subscriber') ?>" <?= urldecode(uri_string()) == 'admin/report/subscriber' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> Newsletter Subscriber Report</a></li>
                                    <?php }if(array_key_exists('manage_discount_code',$perimission) && $perimission['manage_discount_code'] == 1){ ?>
                                    <li><a href="<?= base_url('admin/discounts') ?>" <?= urldecode(uri_string()) == 'admin/discounts' ? 'class="active"' : '' ?>><i class="fa fa-percent" aria-hidden="true"></i> Discount Codes</a></li>
                                    <?php }if(array_key_exists('manage_order_updates',$perimission) && $perimission['manage_order_updates'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/report/order_updates') ?>" <?= urldecode(uri_string()) == 'admin/report/order_updates' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Order Account</a></li> -->
                                     <?php }if(array_key_exists('return_update',$perimission) && $perimission['return_update'] == 1){ ?>
                                    <!-- <li><a href="<?= base_url('admin/report/return_order') ?>" <?= urldecode(uri_string()) == 'admin/report/return_order' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Returned Order Report</a></li>				 -->
				   					<?php } ?>
                                    <!-- <li><a href="<?= base_url('admin/report/invenoty') ?>" <?= urldecode(uri_string()) == 'admin/report/invenoty' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Inventory Report</a></li>				 -->
                                    <?php if(array_key_exists('manage_cms_page',$perimission) && $perimission['manage_cms_page'] == 1){
										if (!empty($textualPages)) {
											foreach ($nonDynPages as $nonDynPage) {
												if (($key = array_search($nonDynPage, $textualPages)) !== false) {
													unset($textualPages[$key]);
												}
											}
											?>
											<!-- <li class="header">TEXTUAL PAGES</li> -->
											<?php foreach ($textualPages as $textualPage) { ?>
												<li><a href="<?= base_url('admin/pageedit/' . $textualPage) ?>" <?= strpos(urldecode(uri_string()), $textualPage) ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> <?= strtoupper($textualPage) ?></a></li>
												<?php
											}
										}
									} if(array_key_exists('manage_banner',$perimission) && $perimission['manage_banner'] == 1){?>
									<li><a href="<?= base_url('admin/banner') ?>" <?= urldecode(uri_string()) == 'admin/banner' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> Banner</a></li>
                                    <!-- <li><a href="<?= base_url('admin/home_banner') ?>" <?= urldecode(uri_string()) == 'admin/home_banners' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> Home Banner</a></li> -->
									<li><a href="<?= base_url('admin/blog') ?>" <?= urldecode(uri_string()) == 'admin/blog' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> Blog</a></li>
                                    <li><a href="<?= base_url('admin/aboutusbanner') ?>" <?= urldecode(uri_string()) == 'admin/aboutusbanner' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> About Us Banner</a></li>
                                    <li><a href="<?= base_url('admin/aboutus/1') ?>" <?= urldecode(uri_string()) == 'admin/aboutus' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> About us</a></li>
                                    <li><a href="<?= base_url('admin/abandoned_cart') ?>" <?= urldecode(uri_string()) == 'admin/abandoned_cart' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> Abandoned Cart</a></li>
                                    <li><a href="<?= base_url('admin/rating') ?>" <?= urldecode(uri_string()) == 'admin/rating' ? 'class="active"' : '' ?>><i class="glyphicon glyphicon-star" aria-hidden="true"></i> Rating</a></li>
                                    <li><a href="<?= base_url('admin/video_review') ?>" <?= urldecode(uri_string()) == 'admin/video_review' ? 'class="active"' : '' ?>><i class="glyphicon glyphicon-star" aria-hidden="true"></i> Video Review</a></li>	
									<?php }if(array_key_exists('manage_website_settings',$perimission) && $perimission['manage_website_settings'] == 1){
                                    ?>
                                  <!-- <li class="header">SETTINGS</li>
                                    <li><a href="<?= base_url('admin/settings') ?>" <?= urldecode(uri_string()) == 'admin/settings' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> Settings</a></li>
                                    <li><a href="<?= base_url('admin/styling') ?>" <?= urldecode(uri_string()) == 'admin/styling' ? 'class="active"' : '' ?>><i class="fa fa-laptop" aria-hidden="true"></i> Styling</a></li>
                                    <li><a href="<?= base_url('admin/templates') ?>" <?= urldecode(uri_string()) == 'admin/templates' ? 'class="active"' : '' ?>><i class="fa fa-binoculars" aria-hidden="true"></i> Templates</a></li>
                                    <li><a href="<?= base_url('admin/titles') ?>" <?= urldecode(uri_string()) == 'admin/titles' ? 'class="active"' : '' ?>><i class="fa fa-font" aria-hidden="true"></i> Titles / Descriptions</a></li>
                                    <li><a href="<?= base_url('admin/pages') ?>" <?= urldecode(uri_string()) == 'admin/pages' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> Active Pages</a></li>
                                    <li><a href="<?= base_url('admin/emails') ?>" <?= urldecode(uri_string()) == 'admin/emails' ? 'class="active"' : '' ?>><i class="fa fa-envelope-o" aria-hidden="true"></i> Subscribed Emails</a></li>
                                    <li><a href="<?= base_url('admin/history') ?>" <?= urldecode(uri_string()) == 'admin/history' ? 'class="active"' : '' ?>><i class="fa fa-history" aria-hidden="true"></i> Activity History</a></li>
                                    <?php }if(array_key_exists('manage_advance_settings',$perimission) && $perimission['manage_advance_settings'] == 1){ ?>
                                    <li class="header">ADVANCED SETTINGS</li>
                                    <li><a href="<?= base_url('admin/languages') ?>" <?= urldecode(uri_string()) == 'admin/languages' ? 'class="active"' : '' ?>><i class="fa fa-globe" aria-hidden="true"></i> Languages</a></li>
                                    <li><a href="<?= base_url('admin/filemanager') ?>" <?= urldecode(uri_string()) == 'admin/filemanager' ? 'class="active"' : '' ?>><i class="fa fa-file-code-o" aria-hidden="true"></i> File Manager</a></li>
                                    <?php }if(array_key_exists('manage_admin_user_permission',$perimission) && $perimission['manage_admin_user_permission'] == 1){ ?>
                                    <li><a href="<?= base_url('admin/adminusers') ?>" <?= urldecode(uri_string()) == 'admin/adminusers' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> Admin Users</a></li>
                                    <li><a href="<?= base_url('admin/userlevel') ?>" <?= urldecode(uri_string()) == 'admin/userlevel' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> Users Level</a></li>
                                    <?php }if(array_key_exists('manage_vendor',$perimission) && $perimission['manage_vendor'] == 1){ ?>
                                    <li><a href="<?= base_url('admin/vendors') ?>" <?= urldecode(uri_string()) == 'admin/vendors' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> Vendors</a></li>
                                    <li><a href="<?= base_url('admin/pickuplocation') ?>" <?= urldecode(uri_string()) == 'admin/pickuplocation' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> Pickup Location</a></li>
                                    <?php } ?> -->
                                </ul>
                            </div>
                            <div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
                                <?php if ($warnings != null) { ?>
                                    <div class="alert alert-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        There are some errors that you must fix!
                                        <ol>
                                            <?php foreach ($warnings as $warning) { ?>
                                                <li><?= $warning ?></li>
                                            <?php } ?>
                                        </ol>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div>
                                <?php } ?>

