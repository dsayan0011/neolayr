<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $product['title'] ?></li>
                    </ol>
                </div><!-- End .container -->
            </nav>
            <div class="container">
                <div class="product-single-container product-single-default">
                    <div class="row">
                        <div class="col-lg-7 product-single-gallery">
                            <div class="sticky-slider">
                                <div class="product-slider-container product-item">
                                    <div class="product-single-carousel owl-carousel owl-theme">
                                    	 <?php
										if ($product['folder'] != null) {
											$dir = "attachments/shop_images/" . $product['folder'] . '/';
											 if (is_dir($dir)) {
                       						 	if ($dh = opendir($dir)) {
												  $i = 1;
														while (($file = readdir($dh)) !== false) {
															if (is_file($dir . $file)) {
																?>
                                                                <div class="product-item">
                                                                    <img class="product-single-image" src="<?= base_url($dir . $file) ?>" data-zoom-image="<?= base_url($dir . $file) ?>"/>
                                                                </div>
																
																<?php
																$i++;
															}
														}
														closedir($dh);
													}
												}
											}
												?>
                                    </div>
                                    <!-- End .product-single-carousel -->
                                    <span class="prod-full-screen">
                                        <i class="icon-plus"></i>
                                    </span>
                                </div>

                                <div class="prod-thumbnail row owl-dots transparent-dots" id='carousel-custom-dots'>
                                	<?php
										if ($product['folder'] != null) {
											$dir = "attachments/shop_images/" . $product['folder'] . '/';
											 if (is_dir($dir)) {
                       						 	if ($dh = opendir($dir)) {
												  $i = 1;
														while (($file = readdir($dh)) !== false) {
															if (is_file($dir . $file)) {
																?>
                                                                <div class="owl-dot">
                                                                    <img src="<?= base_url($dir . $file) ?>" />
                                                                </div>
																
																<?php
																$i++;
															}
														}
														closedir($dh);
													}
												}
											}
												?>
                                </div>
                            </div>
                        </div><!-- End .col-md-6 -->

                        <div class="col-lg-5">
                            <div class="product-single-details">
                                <h1 class="product-title"><?= $product['title'] ?></h1>
								<?php /*?><div class="product-single-share mb-1 mt-1">
                                <?php if ($product['weight']!="") { ?>
                                     <label>Weight : <span><?= $product['weight']." ".$product['weight_unit'] ?></span></label>
                                    <?php } ?>
                                </div><?php */?>
                                <div class="product-single-share" style="padding-top: 20px;">
                                <?php if ($product['tag']!="") { ?>
                                     <label><span style="font-size: 2.4rem;text-transform: capitalize;"><?= $product['tag'] ?></span></label><br />  
                                    <?php } ?>
                                </div>				
                               
								
                                <div class="price-box">
                                    <?php 
									if(sizeof($variants)>0){
										if($variants[0]['old_price']!=""){?><span class="old-price" id="old_price"><?= CURRENCY. number_format($variants[0]['old_price'],2) ?></span><?php } ?>
                                   		<span class="product-price" id="product_price"><?= CURRENCY .number_format($variants[0]['price'],2) ?></span>
                                    <?php }else {
                                    	if($product['old_price']!=""){?><span class="old-price" id="old_price"><?= CURRENCY. number_format($product['old_price'],2) ?></span><?php } ?>
                                   		<span class="product-price" id="product_price"><?= CURRENCY .number_format($product['price'],2) ?></span>
                                    <?php } ?>
                                </div><!-- End .price-box -->
                                <?php if(sizeof($variants)>0){?>
                                 <div class="product-single-filter">
                                                <label>Weight:</label>
                                                <select onchange="update_variant(this.value)" id="variant">
                                                	<?php foreach($variants as $variant){?>
                                                	<option value="<?= $variant['variant_id']?>"><?= $variant['weight']." ".$variant['weight_unit']?></option>
                                                    <?php } ?>
                                                </select>
                                              
                                            </div>
                                 <?php foreach($variants as $variant){?>
                                 	<input type="hidden" id="varient<?= $variant['variant_id']?>" data-price="<?= CURRENCY .number_format($variant['price'],2) ?>" data-old_price="<?php if($variant['old_price']!="") echo CURRENCY.number_format($variant['old_price'],2); else echo ''; ?>" data-available="<?= $variant['quantity']?>" />
                                 <?php } ?>
								<div><label>Currently taking 5-7 days</label></div>
                                <div class="product-single-share mb-1" id="availability">
                                    <?php if ($variants[0]['quantity'] > 0) { ?>
                                    <label><?= lang('in_stock') ?></label>
                                    <?php }else{ ?>
                                    <label><span class="out_stock"><?= lang('out_of_stock_product') ?></span></label>
                                    <?php } ?>
                                </div>
                                <div class="product-action" id="product_action">
									<?php if ($variants[0]['quantity'] > 0) { ?>
                                     <a href="javascript:void(0);" onclick="add_item_to_cart(<?= $product['id'] ?>)" data-id="<?= $product['id'] ?>" class="add_item_to_cart btn-custom paction add-cart">
                                        <span>Add to Cart</span>
                                    </a>
                                    <a href="javascript:void(0);" onclick="buy_now(<?= $product['id'] ?>)" data-id="<?= $product['id'] ?>" data-goto="<?= LANG_URL . '/checkout' ?>" class="btn-custom paction add-cart buy-now">
                                        <span>Buy Now</span>
                                    </a>
                                    <?php } ?>
                                    
                                   <!-- <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                        <span>Add to Wishlist</span>
                                    </a>
                                    <a href="#" class="paction add-compare" title="Add to Compare">
                                        <span>Add to Compare</span>
                                    </a>-->
                                </div><!-- End .product-action -->
                                <?php }else{?>
                                	<div class="product-single-share mb-1" id="availability">
                                    	<label><span class="out_stock">Item is not available now.</span></label>
                                    </div>
                                    <?php }  ?>
								<div class="">
                                <?php if ($product['vendor_id']!="0") { ?>
                                     <label>Sold By : <span><?= $vendor_details['warehouse_name'] ?></span></label><br />
                                     <label>Location : <span><?= $vendor_details['city_name'].", ".$vendor_details['state_name'] ?></span></label>
                                    <?php } ?>
                                </div>
                                <div class="product-single-share mb-4">
                                	
                                    <br /><br />
                                    <label>Share:</label>
                                     <ul class="product-social">
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= LANG_URL . '/' . $product['url'] ?>&t=<?= $product['title'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://twitter.com/share?url=<?= LANG_URL . '/' . $product['url'] ?>&text=<?= $product['title'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="whatsapp://send?text=<?= LANG_URL . '/' . $product['url'] ?>" data-action="share/whatsapp/share" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on whatsapp"><i class="fa fa-whatsapp"></i></a></li>
                                    </ul>
                                </div><!-- End .product single-share -->
                            </div><!-- End .product-single-details -->

                            <div class="product-single-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
                                    </li>
                                     <li class="nav-item">
                                        <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                                        <div class="product-desc-content">
                                           <?= $product['description'] ?>
                                        </div><!-- End .product-desc-content -->
                                    </div><!-- End .tab-pane -->
                                    <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                        <div class="product-reviews-content">
                                        	<?php if(!isset($_SESSION['logged_user'])){?>
                                            <div class="collateral-box">
                                                <ul>
                                                    <li>Please login to give your review</li>
                                                </ul>
                                            </div>
                                            <?php } else{
											$counter = 1;?>
                                            <div class="row">
                                              <div class="col-12">
                                                         <div class="text-left">
                                                            <a class="btn btn-success btn-green open_review_box" data-target="<?=$counter;?>" id="review_btn<?=$counter;?>" href="javascript:void(0)">Leave your Review</a>
                                                         </div>
                                                         <div class="post-review-box" style="display:none;" id="reviewbox<?=$counter;?>">
                                                          <div class="row">
                                                            <div class="col-md-12">
                                                                <form accept-charset="UTF-8" action="" method="post">
                                                                    <textarea class="form-control animated" cols="50" id="comment<?=$counter;?>" name="comment<?=$counter;?>" placeholder="Enter your review here..." rows="5"></textarea>
                                                    
                                                                    <div class="text-right">
                                                                        <div class="stars starrr" data-rating="0"></div>
                                                                        <a class="btn btn-danger btn-sm close-review" data-target="<?=$counter;?>" href="javascript:void(0)" id="close-review-box<?=$counter;?>" style="display:none; margin-right: 10px;">
                                                                            <span class="glyphicon glyphicon-remove"></span>Cancel
                                                                        </a>
                                                                        <button class="btn btn-success btn-lg submit_review" data-target="<?=$counter;?>" type="button" data-order-id="" data-reload="true" data-product-id="<?=$product['id'];?>">Save</button>
                                                                        <br />
                                                                        <span style="display:none;" id="review_save<?=$counter;?>"><img src="<?= base_url('assets/imgs/load.gif') ?>" /> Submitting your review. Please wait..</span>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                           </div>
                                                        </div>
                                                       </div>
                                              </div>
            								<?php } if(sizeof($review)>0){?>
                                            <div class="add-product-review">
                                             <?php foreach($review as $row){?>
                                                <div class="card">
                                                    <div class="card-body">
                                                     
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p>
                                                                    <strong><?=$row['name']?></strong>
                                                                    <?php for($i=0;$i<$row['rating'];$i++){?>
                                                                    <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                                    <?php } ?>
                                                               </p>
                                                               <div class="clearfix"></div>
                                                                <p><?=$row['comment']?></p>
                                                            </div>
                                                        </div> 
                                                     
                                                    </div>
                                                </div>
                                              <?php } ?>
                                            </div><!-- End .add-product-review -->
                                           <?php }else{ ?>
                                           <div class="collateral-box">
                                                <ul>
                                                    <li>This product has no review yet. Be the first to review this product</li>
                                                </ul>
                                            </div>
                                           <?php } ?>
                                        </div><!-- End .product-reviews-content -->
                                    </div>

                                </div><!-- End .tab-content -->
                            </div><!-- End .product-single-tabs -->
                        </div><!-- End .col-md-6 -->
                    </div><!-- End .row -->
                </div><!-- End .product-single-container -->
            </div>
            <?php if (!empty($sameCagegoryProducts)) { ?>
            <div class="featured-section">
                <div class="container">
                    <h2 class="carousel-title">Related Product</h2>

                    <div class="featured-products owl-carousel owl-theme owl-dots-top"> 
                    	<?php foreach($sameCagegoryProducts as $article){?>
                        <div class="product-default">
                            <figure>
                                <a href="<?= LANG_URL . '/' . $article['url'] ?>">
                                    <img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>">
                                </a>
                            </figure>
                            <div class="product-details">
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:100%">
                                        	<?php for($i=1;$i<=5;$i++){?>
                                                	<i class="fa fa-star <?php if($article['rating']>=$i) echo 'active';?>"></i>
                                                    <?php } ?>
                                        </span><!-- End .ratings -->
                                    </div><!-- End .product-ratings -->
                                </div><!-- End .product-container -->
                                <h2 class="product-title">
                                     <a href="<?= LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>"><?= character_limiter($article['title'], 20) ?></a>
                                </h2>
                                <div class="price-box">
                                     <span class="product-price"><?= $article['default_price'] != '' ? number_format($article['default_price'], 2) : 0 ?><?= CURRENCY ?> <strike class="pevious_price"><?= $article['default_old_price'] != '' ? number_format($article['default_old_price'], 2) . CURRENCY : '' ?></strike></span>
                                </div><!-- End .price-box -->
                                 <?php if ($article['city_name']!="") { ?>
                                        <div class="supplier_location-box mb-1"> <i class="icon-location"></i><?= $article['city_name'].", ".$article['state_name'];?></div>
                                 <?php } ?>
                                <div class="product-action">
                                 <?php //if ($article['quantity'] > 0){ ?>
                                   <!-- <a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>-->
                                   <a href="javascript:void(0);" class="btn-icon btn-add-cart btn-add" data-id="<?= $article['id'] ?>">
                                                                       <i class="icon-bag"></i>ADD TO CART
                                                        </a>
                                                        
                                  <?php /*?> <a href="javascript:void(0);" class="btn-icon btn-add-cart add-to-cart btn-add" data-id="<?= $article['id'] ?>">
                                                           <i class="icon-bag"></i>ADD TO CART
                                                        </a>
                                                        <a href="javascript:void(0);" data-goto="<?= LANG_URL . '/shopping-cart' ?>" class="btn-icon btn-add-cart add-to-cart btn-add" data-id="<?= $article['id'] ?>">
                                                           <i class="icon-shipped"></i>BUY NOW
                                                        </a><?php */?>
                                 <?php //} ?>
                                </div>
                            </div><!-- End .product-details -->
                        </div>
						<?php } ?>
                    </div><!-- End .featured-proucts -->
                </div><!-- End .container -->
            </div>
            <?php } ?>