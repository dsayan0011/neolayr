<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section>
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-1 col-sm-2 col-xs-12">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="slider-right-nav">
                            <?php
										$image_files = array();
										if ($product['folder'] != null) {
											$dir = "attachments/shop_images/" . $product['folder'] . '/';
											 if (is_dir($dir)) {
                       						 	if ($dh = opendir($dir)) {
												  $i = 1;
														while (($file = readdir($dh)) !== false) {
															if (is_file($dir . $file)) {
																array_push($image_files,$file);
																$i++;
															}
														}
														closedir($dh);
													}
												}
											}
											sort($image_files);
									foreach($image_files as $file){
									?>
                                    <div><img src="<?= base_url($dir . $file) ?>" alt="" class="img-fluid "></div>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-10 col-xs-12 order-up">
                    <div class="product-right-slick">
                    <?php
									foreach($image_files as $file){
									?>
                                    <div><img src="<?= base_url($dir . $file) ?>" alt="" class="img-fluid  image_zoom_cls-0"></div>
                                    <?php } ?>
                    </div>
                </div>
                <div class="col-lg-6 rtl-text">
                    <div class="product-right">
                        <h2><?= $product['title'] ?></h2>
                        <?php if(sizeof($variants)>0){?>
                		<h4><del id="old_price"><?= CURRENCY. number_format($variants[0]['old_price'],2) ?></del></h4>
						<?php }else if($product['default_old_price']!=""){?>
                        <h4><del id="old_price"><?= CURRENCY. number_format($product['default_old_price'],2) ?></del></h4>
                        <?php } ?>
                        <h3>
                         <?php 
									if(sizeof($variants)>0){?>
                                   		<span class="product-price" id="product_price"><?= CURRENCY .number_format($variants[0]['price'],2) ?></span>
                                    <?php }else {?>
                                    	<span class="product-price" id="product_price"><?= CURRENCY .number_format($product['default_price'],2) ?></span>
                                    <?php } ?>
                        </h3>
                       
                        <div class="product-description border-product">
                        	
                             <?php if($product['min_age']!=""){?>
                           	 <div class="product-single-share mb-1 age_limit">
                                    <label><?=$product['min_age'];?> <?= $product['max_age']?' - '.$product['max_age']:'+';?> <?=$product['age_unit'];?> </label>
                             </div>
                             <?php } ?>
                            
                           <?php if(sizeof($variants)>0){?>
                           					<div style="display:none">
                             					<h6 class="product-title size-text">Weight <span></span></h6>
                                                <select onchange="update_variant(this.value)" id="variant">
                                                	<?php foreach($variants as $variant){?>
                                                	<option value="<?= $variant['variant_id']?>"><?= $variant['weight']." ".$variant['weight_unit']?></option>
                                                    <?php } ?>
                                                </select>
                            				</div>
                                 
                                             
                                 <?php foreach($variants as $variant){?>
                                 	<input type="hidden" id="varient<?= $variant['variant_id']?>" data-price="<?= CURRENCY .number_format($variant['price'],2) ?>" data-old_price="<?php if($variant['old_price']!="") echo CURRENCY.number_format($variant['old_price'],2); else echo ''; ?>" data-available="<?= $variant['quantity']?>" />
                                 <?php } ?>
								<div><label>Currently taking <?= $product['days_to_deliver'];?> days to deliver</label></div>
                                <div class="product-single-share mb-1" id="availability">
                                    <?php if ($variants[0]['quantity'] > 0) { ?>
                                    <label><?= lang('in_stock') ?></label>
                                    <?php }else{ ?>
                                    <label><span class="out_stock"><?= lang('out_of_stock_product') ?></span></label>
                                    <?php } ?>
                                </div>
                                <div class="product-action" id="product_action">
									<?php if ($variants[0]['quantity'] > 0) { ?>
                                   <div class="product-buttons">
										<?php if ($variants[0]['quantity'] > 0) { ?>
                                                     <a href="javascript:void(0);" onclick="add_item_to_cart(<?= $product['id'] ?>)" data-id="<?= $product['id'] ?>" class="add_item_to_cart btn btn-solid paction add-cart">
                                                        <span>Add to Cart</span>
                                                    </a>
                                                    <a href="javascript:void(0);" onclick="buy_now(<?= $product['id'] ?>)" data-id="<?= $product['id'] ?>" data-goto="<?= LANG_URL . '/checkout' ?>" class="btn btn-solid paction add-cart buy-now">
                                                        <span>Buy Now</span>
                                                    </a>
                                        <?php } ?>
                                    <?php } ?>
                                </div><!-- End .product-action -->
                                <?php }else{?>
                                	<div class="product-single-share mb-1" id="availability">
                                    	<label><span class="out_stock">Item is not available now.</span></label>
                                    </div>
                                    <?php }  ?>
                            <div class="border-product">
                                <!--<h6 class="product-title">product details</h6>-->
                                <p><?= $product['description'] ?></p>
                            </div>
                        
                        
                        </div>
                        <div class="border-product">
                            <h6 class="product-title">share it</h6>
                            <div class="product-icon">
                                <ul class="product-social">
                                   <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= LANG_URL . '/' . $product['url'] ?>&t=<?= $product['title'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a></li>
                                   <li><a href="whatsapp://send?text=<?= LANG_URL . '/' . $product['url'] ?>" data-action="share/whatsapp/share" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on whatsapp"><i class="fa fa-whatsapp"></i></a></li>
                                </ul>
                                <form class="d-inline-block">
                                <?php if(!isset($_SESSION['logged_user'])){?>
                                    	<a class="wishlist-btn" href="<?= LANG_URL . '/users/login?redirect='.$product['url'];?>"><i class="fa fa-heart"></i><span class="title-font">Add To WishList</span></a>
                                <?php }else{?>
                                 <button id="add_to_wishlist" onclick="add_item_to_wishlist(<?= $product['id'] ?>)" type="button" class="wishlist-btn"><i class="fa fa-heart"></i><span class="title-font">Add To WishList</span></button>
								 <span style="display:none;" id="save_wishlist"><img src="<?= base_url('assets/imgs/load.gif') ?>" /> Adding to your wishlist. Please wait..</span>
								<?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
<section class="tab-product m-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="review-top-tab" data-toggle="tab" href="#top-review" role="tab" aria-selected="true">Review</a>
                        <div class="material-border"></div>
                    </li>
                    <li class="nav-item"><a class="nav-link" id="specification-tab" data-toggle="tab" href="#product-specification" role="tab">Specifications</a>
                        <div class="material-border"></div>
                    </li>
                </ul>
                <div class="tab-content nav-material" id="top-tabContent">
                   
                    <div class="tab-pane fade show active product_review" id="top-review" role="tabpanel" aria-labelledby="review-top-tab">
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
                                                            <div class="col-md-6">
                                                                <form accept-charset="UTF-8" action="" method="post">
                                                                    <textarea class="form-control animated" cols="50" id="comment<?=$counter;?>" name="comment<?=$counter;?>" placeholder="Enter your review here..." rows="5"></textarea>
                                                    
                                                                    <div class="text-right">
                                                                        <div class="stars starrr" data-rating="0"></div>
                                                                        <a class="btn btn-solid close-review" data-target="<?=$counter;?>" href="javascript:void(0)" id="close-review-box<?=$counter;?>" style="display:none; margin-right: 10px;">
                                                                            <span class="glyphicon glyphicon-remove"></span>Cancel
                                                                        </a>
                                                                        <button class="btn btn-solid submit_review" data-target="<?=$counter;?>" type="button" data-order-id="" data-reload="true" data-product-id="<?=$product['id'];?>">Save</button>
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
                                            <div class="row">
                                                <div class="add-product-review col-md-6">
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
                                              </div>
                                           <?php }else{ ?>
                                           <div class="collateral-box">
                                                <ul>
                                                    <li>This product has no review yet. Be the first to review this product</li>
                                                </ul>
                                            </div>
                                           <?php } ?>                  
                        
                    </div>
                    <div class="tab-pane fade" id="product-specification" role="tabpanel" aria-labelledby="specification-tab">
                        <div class="single-product-tables">
                            <table>
                                <tbody>
                                <?php foreach($product_attribute as $attribute){?>
                                <tr>
                                    <td><?php echo $attribute['attribute_set_name'];?></td>
                                    <td><?php echo $attribute['attribute_title'];?></td>
                                </tr>
                               <?php } ?>
                               <?php if($product['min_age']!=""){?>
                                <tr>
                                    <td>Manufacturer Recommended Age</td>
                                    <td><?=$product['min_age'];?> <?= $product['max_age']?' - '.$product['max_age']:'+';?> <?=$product['age_unit'];?></td>
                                </tr>
                               <?php } ?>
                             
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (!empty($sameCagegoryProducts)) { ?>
<section class="section-b-space ratio_square product-related">
    <div class="container">
        <div class="row">
            <div class="col-12 product-related">
                <h2 class="title pt-0">related products</h2></div>
        </div>
        <div class="slide-6">
        <?php foreach($sameCagegoryProducts as $article){?>
            <div class="">
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
                                                            <a href="<?= LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>"><h6><?= character_limiter($article['title'], 20) ?></h6></a>
                                                            <h5><?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?> <strike class="pevious_price"><?= $article['default_old_price'] != '0' ? CURRENCY.number_format($article['default_old_price'], 2):'' ?></strike></h5>
                                                        </div>
                                                        <div class="product-action">
														<button tabindex="0" class="addcart-box btn-add-cart btn-add btn btn-solid" data-id="<?= $article['id'] ?>" title="Add to cart"><i class="ti-shopping-cart" ></i> ADD TO CART</button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
            </div>
         <?php } ?>  
        </div>
    </div>
</section>
<?php } ?>