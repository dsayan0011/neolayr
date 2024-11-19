<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="breadcrumb-section section-b-space">
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
                                    </div><!-- End .card-header -->

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
                                                                        </span><!-- End .ratings -->
                                                                    </div><!-- End .product-ratings -->
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
                                    </div><!-- End .card-body -->
                                </div>
                                
                    </div>
                </div>
             </div>
        </div>
    </div>
</section>

