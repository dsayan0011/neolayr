<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>My Wishlist</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="container">
        <div class="row">
        	<div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">my wishlist</a></div>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                    <div class="block-content">
                        <ul>
                          	  <li > <a href="<?= LANG_URL . '/users/dashboard' ?>"> <?= lang('vendor_dashboard') ?> </a> </li>
                              <li> <a href="<?= LANG_URL . '/users/orders' ?>"> <?= lang('my_order') ?> </a> </li>
                              <li class=""> <a href="<?= LANG_URL . '/users/profile' ?>"> <?= lang('my_acc') ?> </a> </li>
                              <li class="last"> <a href="<?= LANG_URL . '/users/logout' ?>"> <?= lang('logout') ?> </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
             <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                    	<div class="card">
                                    <div class="card-header">
                                       My Wishlist Item
                                    </div>

                                    <div class="card-body">
                                        <div class="product-wrapper-grid ratio_square">
                                            <div class="row">
                                             <?php 
											  if (!empty($products)) {
                                               foreach($products as $article){?>
                                                <div class="col-xl-3 col-md-4 col-6" id="wishlist_item<?= $article['id'] ?>">
                                                    <div class="product-box">
                                                        <div class="img-block">
                                                            <a href="<?= LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" class=" img-fluid bg-img" alt=""></a>
                                                            
                                                        </div>
                                                        <div class="product-info">
                                                            <div>
                                                                <div class="ratings-container">
                                                                    <div class="product-ratings">
                                                                        <span class="ratings" style="width:100%">
                                                                            <?php for($i=1;$i<=5;$i++){?>
                                                                                    <i class="fa fa-star <?php if($article['rating']>=$i) echo 'active';?>"></i>
                                                                                    <?php } ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <a href="<?= LANG_URL . '/' . $article['url'] ?>"><h6><?= character_limiter($article['title'], 20) ?></h6></a>
                                                                <h5><?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?> <strike class="pevious_price"><?= $article['default_old_price'] != '0' ? CURRENCY.number_format($article['default_old_price'], 2):'' ?></strike></h5>
                                                            </div>
                                                            <div class="product-action">
                                                            
                                                                <button tabindex="0" class="addcart-box btn-add-cart btn-add btn btn-solid" data-id="<?= $article['id'] ?>" title="Add to cart"><i class="ti-shopping-cart" ></i> ADD TO CART</button>
                                                                <button tabindex="0" onclick="remove_item_to_wishlist(<?= $article['id'] ?>)"  class="addcart-box btn-remove-wishlist btn btn-solid" data-id="<?= $article['id'] ?>" title="Remove from wishlist"><i class="fa fa-remove"></i> REMOVE</button>
                                                              
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                              <?php }
											  }?>
                                               <div class="col-xl-12 col-md-12 col-12" id="no_wishlist_item" style="display:<?php echo sizeof($products)>0?'none':'block';?>">
                                               No Item in your wishlist
                                               </div>
                                                
                                                
                                            </div>
                                        </div>
                                       <?php  if (!empty($products)) {?>
                                         <div class=" product-pagination">
										  <?= $links_pagination ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                
                    </div>
                </div>
             </div>
        </div>
    </div>
</section> -->

<main>
            <!-- PERSONAL INFO PAGE -->
            <section class="personal-info">
                <div class="container">
                    <div class="personal-information text-center">
                        <div class="personal-info-image mx-auto">
                            <img src="<?= base_url('images/user-5.png'); ?>" border="0" alt="">
                        </div>
                        <p>Hello</p>
                        <h2><?php echo $_SESSION['logged_user_name'];?></h2>
                    </div>
                    <div class="personal-info-detailed-content row no-gutters flex-row-reverse">
                        
                        <div class="personal-info-detailed-content-right col-lg-8">
                            <div class="label-area d-flex justify-content-between">
                                <h4>Wishlist</h4>
                            </div>
							<div class="row">
                            <!-- each order start -->
                            <?php 
                                              if (!empty($products)) {
                                               foreach($products as $article){?>
											   <div class="col-6 col-sm-6 col-md-12">
                            <div class="each-order-n" id="wishlist_item<?= $article['product_id'] ?>">                              
                                <div class="order-middle">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="<?= LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" width="100%" height="auto" border="0" alt="" class="wishlist-image"></a>
                                        </div>
                                        <div class="col-md-5">
                                            <p><a href="<?= LANG_URL . '/' . $article['url'] ?>"><?= character_limiter($article['title'], 20) ?></a></p>
                                        </div>
                                        <div class="col-md-2">                                          
                                        </div>
                                        <div class="col-md-3 wish-price">   
                                            <p><strong><?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-bottom">
                                    <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <p><a href="javascript:void(0)" onclick="remove_item_to_wishlist(<?= $article['product_id'] ?>)" data-id="<?= $article['product_id'] ?>">Remove</a></p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <p><a href="javascript:void(0)" class="btn-add-cart-wishlist" data-id="<?= $article['product_id'] ?>" title="Add to cart">Move to cart</a></p>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
							</div>
                        <?php } } ?>
                        <div class="col-xl-12 col-md-12 col-12" id="no_wishlist_item" style="display:<?php echo sizeof($products)>0?'none':'block';?>">
                                               No Item in your wishlist
                                               </div>
                            <!-- each order end -->
                            <!-- each order start -->
                            <!-- <div class="each-order-n">                              
                                <div class="order-middle">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <img src="<?= base_url('images/product-listing1-Copy.jpg'); ?>" width="100%" height="auto" border="0" alt="">
                                        </div>
                                        <div class="col-lg-5">
                                            <p>Neolayr Pro Prohair Quick Hair Fall Control Solution 40 ML</p>
                                            
                                        </div>
                                        <div class="col-lg-2">                                          
                                        </div>
                                        <div class="col-lg-3 wish-price">   
                                            <p><strong>₹340.00</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p><a href="">Remove</a></p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p><a href="">Move to cart</a></p>
                                        </div>
                                        <div class="col-lg-3">                                          
                                        </div>
                                        <div class="col-lg-3">
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- each order end -->
                            
                        </div>
                    </div>
                    <div class="personal-info-detailed-content-left col-lg-4">
                            <ul>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
                                        <li><a href="<?= LANG_URL . '/manage-address' ?>">Manage address</a></li>
                                    </ul>
                                </li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy.png') ?>" width="25" height="25" border="0" alt=""></span>Order history</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/orders' ?>">MY ORDERS</a></li>
                                    </ul>
                                </li>
                                <li class="active"><a href="<?= LANG_URL . '/users/wishlist' ?>"><span><img src="<?= base_url('images/user-6-copy-4.png') ?>" width="23" height="21" border="0" alt=""></span>Wishlist</a></li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy-6.png') ?>" width="23" height="23" border="0" alt=""></span>Rewards</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
                                        <li><a href="<?= LANG_URL . '/refer-friend' ?>">Refer friends</a></li>
                                    </ul>
                                </li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="25" border="0" alt=""></span>Gift Voucher</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/gift' ?>">Gift Card</a></li>
                                        <li><a href="<?= LANG_URL . '/gift-card-details' ?>">Gift Card Details</a></li>
                                    </ul>
                                </li>
                                 <!-- <li><a href="<?= LANG_URL . '/users/gift' ?>"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="23" border="0" alt=""></span>Gift Voucher</a></li> -->
                                <li><a href="<?= LANG_URL . '/users/logout' ?>"><span><img src="<?= base_url('images/user-6-copy-8.png') ?>" width="21" height="23" border="0" alt=""></span>Logout</a></li>
                            </ul>
                        </div>
                </div>
            </section>
            <!-- END:PERSONAL INFO PAGE -->
            <!-- SITE FOOTER-->
           
        </main>