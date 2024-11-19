<!-- <link rel="stylesheet" type="text/css" href="<?= base_url('fancyboxCss/jquery.fancybox-1.3.4.css') ?>" media="screen" /> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url('fancyboxJS/jquery.fancybox-1.3.4.pack.js') ?>"></script> -->
<!-- <?php
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
                                </div>
                                <?php }else{?>
                                	<div class="product-single-share mb-1" id="availability">
                                    	<label><span class="out_stock">Item is not available now.</span></label>
                                    </div>
                                    <?php }  ?>
                            <div class="border-product">
                                
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
                                                </div>
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
                                                                </span>
                                                            </div>
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
<?php } ?> -->

<style type="text/css">p a{
    color: black;
}</style>



<main>
            <!-- PRODUCT DETAILS-->
            <div class="col-lg-12">
                <div class="container">
                        <div id="" class="d-lg-flex justify-content-between breadcum-wrapper align-items-center pt-4">
                           <ol class="breadcrumb d-none d-lg-flex">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        
                        
                        <?php if(isset($fst_category_details)){?><li class="breadcrumb-item"><?= $fst_category_details['name'];?></li><?php } ?>

                        <?php if(isset($sub_category_details)){?><li class="breadcrumb-item"><?= $sub_category_details['name'];?></li><?php } ?>
                        <?php if(isset($category_details)){?> <li class="breadcrumb-item"><a href="<?= LANG_URL . '/category?type='.$category_details['category_slug'] ?>"><?= $category_details['name'];?></a></li><?php } ?>
                        <?php if(isset($product['title'])){?><li class="breadcrumb-item"><?= $product['title'] ?></li>
                        <?php } ?>
                    </ol>
                </div>
            </div>
            <section class="product-details-area">
                <div class="container">
                    <div class="each-slide only-mobile">
                        <div class="swiper-container product-slider product-slider_pdetails">
                            <div class="swiper-wrapper">
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
                                    foreach($image_files as $key => $file){
                                    ?>
                                    
                                        
                                            <div class="swiper-slide">
                                                <a href="#<?php echo $key; ?>" class="active">
                                                <img src="<?= base_url($dir . $file) ?>" width="100%" height="auto" border="0" alt=""></a>
                                            </div>

                                            
                                        
                        
                                <?php } ?>
                                <?php if($product['product_video'] != ''){?>
                                    <div class="swiper-slide">
                                        <iframe width="100%" height="323" src="<?php echo $product['product_video']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                <?php } ?>

                                </div>
                                <div class="swiper-pagination static-pagination"></div> 
                                </div>
                        <!-- <div class="swiper-container product-slider">
                            
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="<?= base_url('images/big-product.png'); ?>" width="100%" height="auto" border="0" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="<?= base_url('images/big-product.png'); ?>" width="100%" height="auto" border="0" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="<?= base_url('images/big-product.png'); ?>" width="100%" height="auto" border="0" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="<?= base_url('images/big-product.png'); ?>" width="100%" height="auto" border="0" alt="">
                                </div>
                            </div>
                        </div> -->
                        <!-- If we need navigation buttons -->
                        <!-- <div class="swiper-button-prev product-prev common-prev"><img src="<?= base_url('images/left-arrow.png'); ?>" alt=""></div>
                        <div class="swiper-button-next product-next common-next"><img src="<?= base_url('images/right-arrow.png'); ?>" alt=""></div> -->
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-md-2 only-desktop">
                            <div class="product-details-image-area">
                                <div class="product-details-for-desktop">
                                    <div class="thumb-area">                                        
                                        <ul>
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
                                            //$tot_arry = '';

                                    foreach($image_files as $key => $file){
                                        $count_arry =  count($image_files);
                                        $tot_arry = $count_arry;
                                    ?>
                                    <li>
                                        <a href="#<?php echo $key; ?>" class="active">
                                        <img src="<?= base_url($dir . $file) ?>" border="0" alt="">
                                    </a>
                                    </li>
                                    <?php } ?>
                                    <?php if($product['product_video'] != ''){?>
                                         <li>
                                            <a href="#<?php echo $tot_arry; ?>"  class="active">
                                            <div class="video-iframe">
                                            <iframe width="100%" height="138" src="<?php echo $product['product_video']; ?>"></iframe>
                                            </div>
                                        </a>
                                         </li> 
                                         <?php } ?>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5 only-desktop">
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
                                    foreach($image_files as $key => $file){
                                        $wishListData = $this->Public_model->wishListSelectedData($product['id'],$_SESSION['logged_user']);
                                        $count_arry =  count($image_files);
                                        $tot_arry = $count_arry;
                                    ?>
                                    <div  id="<?php echo $key; ?>" class="each-big-p">
                                        <?php if($key == 0){?>
                                            
                                       <!--  <div id="pdpAddToWishList" class="wishlist-img">
                                            <a href="javascript:void(0);" onclick="add_item_to_wishlist(<?= $product['id'] ?>)">
                                            <i class="far fa-heart"></i></a>
                                        </div> -->
                                         <?php if(!isset($_SESSION['logged_user'])){?>
                                         <div id="" class="wishlist-img">
                                            <a href="#login" class="fancybox">
                                                <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                            </a>
                                        </div>
                                 <?php }else{?>
                                        <div id="pdpAddToWishList<?= $product['id'] ?>" class="wishlist-img <?php if($product['id'] == $wishListData['product_id']) echo 'active';?>"
                                            data-target="add">
                                            <a href="javascript:void(0);" onclick="pdp_add_remove_to_wishlist(<?= $product['id'] ?>)">
                                            <i class="far fa-heart"></i></a>
                                        </div>
                                   
										<!-- <div id="" class="wishlist-img">
                                            <a href="javascript:void(0);" onclick="add_item_to_wishlist(<?= $product['id'] ?>)">
											<i class="far fa-heart"></i>
                                        </a>
										</div> -->
                                    <?php } }?>
                                        <a href="<?= base_url($dir . $file) ?>" data-fancybox="images" data-type="image" >
                                        <img src="<?= base_url($dir . $file) ?>"width="100%" height="auto" border="0" alt="">
                                    </a>
                                        
                                    </div>
                                    <?php } ?>
                                    <?php if($product['product_video'] != ''){?>
                                    <div id="<?php echo $tot_arry; ?>" class="each-big-p video-iframe r-margin">
                                        <iframe width="100%" height="250" src="<?php echo $product['product_video']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                <?php } ?>
                           
                        </div>
                        <div class="col-lg-5 col-md-5">
                            <div class="product-details-content-area">
                                <div class="upper-content-area">
                                    <h1><?= $product['title'] ?> </h1>
                                    <h3><?= $product['description'] ?>  (<?php echo $variants[0]['weight'].$variants[0]['weight_unit'];?>)</h3>
                                    <?php  if(sizeof($review)>0 && $showRating == 1){?>
                                    <div class="star-area">
                                        <div style="position:relative; display:inline-block">
                                        <img src="<?= base_url('images/Star-line.png') ?>" border="0" alt="" style="margin-right:0px">
                                        <span class="rating-cover" style="width:<?php echo ($product['rating']/5)*100; ?>%;">
                                            <img src="<?= base_url('images/Star-solid.png') ?>" border="0" alt="">
                                        </span>
                                    </div>
                                        (<?php echo $totReview/$countTotalReview;?>)
                                    </div>
                                <?php } ?>
                                    <div  class="p-price">
                                        <?php if(sizeof($variants)>0){?>
                                        <?= CURRENCY. number_format($variants[0]['old_price'],2) ?>
                                    <?php } else{ ?>
                                        <?= CURRENCY. number_format($product['default_old_price'],2) ?>
                                    <?php } ?>
                                    </div>
                                    <div class="price-quantity price-fordesktop">
                                        <div class="" style="display: none;">                                          
                                            <div class="button-container">
                                                <div id="" class="">
                                                    <button class="cart-qty-minus" type="button" value="-" onclick="removeProduct(<?php echo $variants[0]['variant_id'];?>, true)" href="javascript:void(0);">-</button>
                                                </div>
                                                <div id="" class="">
                                                    <input type="text" name="qty" class="qty" maxlength="12" value="1" class="input-text qty" />
                                                </div>
                                                <div id="" class="">
                                                    <a class="cart-qty-plus refresh-me add-to-cart 2" data-id="<?php echo $variants[0]['variant_id'];?>" href="javascript:void(0);" type="button" value="+">+</a>
                                                </div>                                                  
                                            </div>
                                            <input type="hidden" name="product_qty" id="product_qty" value="1">
                                        </div>
                                        <div class="pdpAddCart">
                                            <?php if ($variants[0]['quantity'] != 0){
                                            ?>
                                            <button class="common-button line-button " onclick="add_item_to_cart_pdp(<?php echo $variants[0]['variant_id']; ?>)"><img src="<?= base_url('images/shopping-bag.png'); ?>" width="27" height="31" border="0" alt="">ADD to cart </button>
                                        <?php } else{?>
                                            <button class="common-button line-button ">Coming soon </button>
                                        <?php }?>
                                        </div>
                                        <div class="pdpGoCart" style="display: none;">
                                             <a href="<?= LANG_URL . '/shopping-cart' ?>"><button class="common-button line-button "><img src="<?= base_url('images/shopping-bag.png'); ?>" width="27" height="31" border="0" alt="">Go to cart </button></a>
                                        </div>
                                        <?php if ($variants[0]['quantity'] != 0){
                                            ?>
                                        <div class="">
                                            <button class="common-button line-button" onclick="buy_now_pdp(<?php echo $variants[0]['variant_id']; ?>)" data-id="<?php echo $variants[0]['product_id']; ?>" data-goto="<?= LANG_URL . '/shopping-cart' ?>">Buy now</button>
                                        </div>
                                    <?php } ?>
                                    </div>
                                    <!-- <p>To help build your skin care routine, we’d like to learn a little more about you At the end, we’ll also give you the opportunity to book a 1:1 consultation with one of our in-house Skin Care Experts.</p> -->
                                </div>
                                <div class="bottom-icon-area">
                                    <h2>good to know</h2>
                                    <ul>
                                        <?php
                                        $image_files = array();
                                        if ($product['folder'] != null) {
                                            $dir = "attachments/tag_images/" . $product['folder'] . '/';
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
                                    foreach($image_files as $key => $file){
                                    ?>
                                        <li>
                                            <div class="p-icon p-icon-two">
                                                <img src="<?= base_url($dir . $file) ?>"  alt="">
                                            </div>
                                            <!-- <p>SLS/SLES<br> Free</p> -->
                                        </li>
                                    <?php } ?>
                                        <!-- <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p2.png'); ?>"  alt="">
                                            </div>
                                            <p>PEG<br> free</p>
                                        </li>
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p3.png'); ?>"  alt="">
                                            </div>
                                            <p>Silicone<br> Free</p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p4.png'); ?>"  alt="">
                                            </div>
                                            <p>Paraben<br> Free</p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p5.png'); ?>"  alt="">
                                            </div>
                                            <p>Phthalate<br> Free</p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p6.png'); ?>"  alt="">
                                            </div>
                                            <p>Oil<br> Free</p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p7.png'); ?>"  alt="">
                                            </div>
                                            <p>Mineral oil<br> free </p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p8.png'); ?>"  alt="">
                                            </div>
                                            <p>Alcohol<br> Free</p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p9.png'); ?>"  alt="">
                                            </div>
                                            <p>Colour<br> Free</p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p10.png'); ?>"  alt="">
                                            </div>
                                            <p>Fragrance<br> Free</p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p11.png'); ?>"  alt="">
                                            </div>
                                            <p>Preservative<br> free </p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p12.png'); ?>"  alt="">
                                            </div>
                                            <p>pH<br> balanced</p>
                                        </li>   
                                        <li>
                                            <div class="p-icon">
                                                <img src="<?= base_url('images/p13.png'); ?>"  alt="">
                                            </div>
                                            <p>Non-<br>.comedogenic</p>
                                        </li>  -->  
                                    </ul>
                                </div>
                                <div class="cat-area">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h2>Categories: </h2>
                                        </div>
                                        <div class="col-lg-8">
                                            
                                            <?php 
                                            $category = [];
                                            foreach ($attributesOption as $value) 
                                            { 
                                                ?>
                                                <?php foreach ($shop_categorie as $item)
                                                {
                                                ?>
                                                <?php if(($value['id'] == $item)){ 
                                                   // $category .=',';
                                                    $cat = array('slug'=>$value['category_slug'],
                                                        'title'=> $value['name']);
                                                    array_push($category, $cat);
                                                }?>
                                           <?php } }?>
                                           <p>
                                            <!-- <?php echo implode(', ', $category) ?> -->

                                            <?php 
                                            $counter = 1;
                                            foreach ($category as $categorys) { ?>
                                                <a href="<?= LANG_URL . '/category?type='.$categorys['slug'] ?>"><?= $categorys['title'] ?>
                                                <?php if(sizeof($category) > 1 && $counter < sizeof($category)) echo ',' ?>
                                            </a>

                                                
                                           <?php
                                            $counter++; 
                                            } ?>
                                           </p>
                                        </div>
                                        <div class="col-lg-12 ad-height"></div>
                                        <div class="col-lg-4">
                                            <h2>Tags: </h2>
                                        </div>
                                        <div class="col-lg-8">
                                           
                                            
                                                <?php 
                                                $counter = 1;
                                                foreach ($tags as $item)
                                                {
                                                $singleTag = $this->Public_model->singleTag($item);
                                          
                                       ?>
                                            
                                            <p>
                                                <a href="<?= LANG_URL . '/ingredient_details/'.$singleTag['ingredientsID'] ?>"><?= $singleTag['ingredientsTitle'] ?><?php if(sizeof($tags) > 1 && $counter < sizeof($tags)) echo ',' ?></a>
                                                </p>
                                          
                                            <?php 
                                            //echo $counter;
                                            $counter++;
                                        } ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="social-area">
                                    <div class="social-title">
                                        <h2>Share this product on</h2>
                                    </div>
                                    <div class="social-icon">
                                        <ul>
                                            <li><a href="javascript:void(0)" onclick="openWhatsApp('https://wa.me/?text= <?= LANG_URL . '/' .$product['url']?>')">
                                                <i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>

                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= LANG_URL . '/' . $product['url'] ?>&t=<?= $product['title'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook">

                                            <i class="fa-brands fa-facebook-f"></i></a></li>

                                            <li><a href="https://www.instagram.com/" target="_blank" title="Share on Instagram">

                                            <i class="fa fa-instagram" aria-hidden="true"></i></a></li>


                                            <li><a href="https://twitter.com/share?url=<?= LANG_URL . '/' . $product['url'] ?>&text=<?php echo urlencode($product['title']); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#2374f7" width="30"
                                zoomAndPan="magnify" viewBox="0 0 375 374.9999" height="38" preserveAspectRatio="xMidYMid meet" version="1.0">
                                <defs>
                                  <path d="M 7.09375 7.09375 L 367.84375 7.09375 L 367.84375 367.84375 L 7.09375 367.84375 Z M 7.09375 7.09375 "
                                    fill="#2374f7" />
                                </defs>
                                
                                <g transform="translate(85, 75)"> <svg xmlns="http://www.w3.org/2000/svg" width="213" height="213"
                                    viewBox="0 0 300 300" version="1.1">
                                    <path
                                      d="M178.57 127.15 290.27 0h-26.46l-97.03 110.38L89.34 0H0l117.13 166.93L0 300.25h26.46l102.4-116.59 81.8 116.59h89.34M36.01 19.54H76.66l187.13 262.13h-40.66"
                                      fill="#2374f7" />
                                  </svg> </g>
                              
                              </svg></a></li>

                                            <!-- <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?= LANG_URL . '/' . $product['url'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li> -->

                                            <li><a href="https://in.pinterest.com/pin-builder/?description=<?= $product['title'] ?>&media=<?= LANG_URL .'/attachments/shop_images/'.$product['image'] ?>&method=button&url=<?= LANG_URL . '/' . $product['url'] ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"  target="_blank"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="delivery-option">
                                    <h2>delivery option</h2>
                                        <input type="text" name="delivery_pincode" class="c-pin" id="delivery_pincode" placeholder="Enter Pincode" minlength="6" maxlength="6" onkeypress="return isNumber(event)" autocomplete="off">
                                        <button type="button" value="CHECK" class="c-submit" onclick="checkDeliverPin()">CHECK</button>
                                    <p class="deliveryAvailable" style="display: none;"></p>
                                </div>
                                <div class="price-quantity price-for-mobile">
                                        <div class="" style="display: none;">                                          
                                            <div class="button-container">
                                                <div id="" class="">
                                                    <button class="cart-qty-minus" type="button" value="-" onclick="removeProduct(<?php echo $variants[0]['variant_id'];?>, true)" href="javascript:void(0);">-</button>
                                                </div>
                                                <div id="" class="">
                                                    <input type="text" name="qty" class="qty" maxlength="12" value="1" class="input-text qty" />
                                                </div>
                                                <div id="" class="">
                                                    <a class="cart-qty-plus refresh-me add-to-cart 2" data-id="<?php echo $variants[0]['variant_id'];?>" href="javascript:void(0);" type="button" value="+">+</a>
                                                </div>                                                  
                                            </div>
                                            <input type="hidden" name="product_qty" id="product_qty" value="1">
                                        </div>
                                        <div class="pdpAddCart">
                                            <?php if ($variants[0]['quantity'] != 0){
                                            ?>
                                            <button class="common-button line-button " onclick="add_item_to_cart_pdp(<?php echo $variants[0]['variant_id']; ?>)"><img src="<?= base_url('images/shopping-bag.png'); ?>" width="27" height="31" border="0" alt="">ADD to cart </button>
                                        <?php } else{?>
                                            <!-- <button class="common-button line-button ">Coming soon </button> -->
                                        <?php }?>
                                        </div>
                                        <div class="pdpGoCart" style="display: none;">
                                             <a href="<?= LANG_URL . '/shopping-cart' ?>"><button class="common-button line-button "><img src="<?= base_url('images/shopping-bag.png'); ?>" width="27" height="31" border="0" alt="">Go to cart </button></a>
                                        </div>
                                        <?php if ($variants[0]['quantity'] != 0){
                                            ?>
                                        <div class="">
                                            <button class="common-button line-button" onclick="buy_now_pdp(<?php echo $variants[0]['variant_id']; ?>)" data-id="<?php echo $variants[0]['product_id']; ?>" data-goto="<?= LANG_URL . '/shopping-cart' ?>">Buy now</button>
                                        </div>
                                    <?php }?>
                                    </div>
                                <div class="faq-area">
                                    <!-- For demo purpose -->                                    
                                      <div class="row">
                                        <div class="col-lg-12 mx-auto">
                                          <!-- Accordion -->
                                          <div id="accordionExample" class="accordion ">

                                            <!-- Accordion item 1 -->
                                            <div class="card">
                                              <div id="headingOne" class="card-header bg-white  border-0">
                                                <h2 class="mb-0">
                                                  <button type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne"
                                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">WHAT IS IT?</button>
                                                </h2>
                                              </div>
                                              <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" class="collapse show">
                                                <div class="card-body ">
                                                  <p class="font-weight-light m-0"><?php echo $product['what_is_it']; ?></p>
                                                </div>
                                              </div>
                                            </div><!-- End -->

                                            <!-- Accordion item 2 -->
                                            <div class="card">
                                              <div id="headingTwo" class="card-header bg-white  border-0">
                                                <h2 class="mb-0">
                                                  <button type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo"
                                                    class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link">WHY DO YOU NEED IT?</button>
                                                </h2>
                                              </div>
                                              <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionExample" class="collapse">
                                                <div class="card-body ">
                                                  <p class="font-weight-light m-0"><?php echo $product['why_do_you_ned_it']; ?></p>
                                                </div>
                                              </div>
                                            </div><!-- End -->

                                            <!-- Accordion item 3 -->
                                            <div class="card">
                                              <div id="headingThree" class="card-header bg-white  border-0">
                                                <h2 class="mb-0">
                                                  <button type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                                    aria-controls="collapseThree"
                                                    class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link">How does it help you?</button>
                                                </h2>
                                              </div>
                                              <div id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionExample" class="collapse">
                                                <div class="card-body ">
                                                  <p class="font-weight-light m-0"><?php echo $product['how_dose_it_help']; ?></p>
                                                </div>
                                              </div>
                                            </div><!-- End -->
                                            <div class="card">
                                              <div id="headingFour" class="card-header bg-white  border-0">
                                                <h2 class="mb-0">
                                                  <button type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                                    aria-controls="collapseFour"
                                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">WHEN TO USE?</button>
                                                </h2>
                                              </div>
                                              <div id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionExample" class="collapse">
                                                <div class="card-body ">
                                                  <p class="font-weight-light m-0"><?php echo $product['when_to_use']; ?></p>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="card">
                                              <div id="headingFive" class="card-header bg-white  border-0">
                                                <h2 class="mb-0">
                                                  <button type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false"
                                                    aria-controls="collapseFive"
                                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">WHERE TO APPLY?</button>
                                                </h2>
                                              </div>
                                              <div id="collapseFive" aria-labelledby="headingFive" data-parent="#accordionExample" class="collapse">
                                                <div class="card-body ">
                                                  <p class="font-weight-light m-0"><?php echo $product['where_to_apply']; ?></p>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="card">
                                              <div id="headingSix" class="card-header bg-white  border-0">
                                                <h2 class="mb-0">
                                                  <button type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false"
                                                    aria-controls="collapseSix"
                                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">WHO IS IT FOR?</button>
                                                </h2>
                                              </div>
                                              <div id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionExample" class="collapse">
                                                <div class="card-body ">
                                                  <p class="font-weight-light m-0"><?php echo $product['who_is_it_for']; ?></p>
                                                </div>
                                              </div>
                                            </div><!-- End -->
                                        </div>
                                          </div>
                                          
                                      </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <div>
                <?php
                    $image_files = array();
                    //echo $product['folder'];
                    if ($product['folder'] != null) {
                        $dir = "attachments/plus_content_images/" . $product['folder'] . '/';
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
                    foreach($image_files as $key => $file){
                    ?>
                        <section class="banner-one plus-<?php echo $key+1;?>">
                            <div class="container">
                                <div class="ban-one">
                                    <img src="<?= base_url($dir . $file) ?>" width="100%" height="auto" border="0" alt=""><br>
                                </div>
                            </div>
                        </section>
                    
                    <?php } ?>
            </div>
            <?php if (!empty($frequentlyProductArray)) { ?>
            <section class="related-product frequently-bought-product">
                <div class="container position-relative">
                    <div id="" class="repated-product-heading">
                        <h2>Frequently bought together</h2>
                    </div>
                    <div class="swiper-container frequently-bought-slider">
                    <div class="swiper-wrapper">
                        
                        <?php foreach($frequentlyProductArray as $key => $article){
                            $wishListData = $this->Public_model->wishListSelectedData($article['id'],$_SESSION['logged_user']);
                            $quantity = $this->Public_model->getquantity($article['id']);
                            ?>
                        <div class="swiper-slide ">
                            <div class="each-listing-of-product">
                                 <?php if(!isset($_SESSION['logged_user'])){?>
                                 <div id="" class="wishlist-img">
                                    <a href="#login" class="fancybox">
                                        <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                    </a>
                                </div>
                                 <?php }else{?>
                                    <div id="relatedProductAdd<?= $article['id'] ?>" class="wishlist-img <?php if($article['id'] == $wishListData['product_id']) echo 'active';?>" data-target="add">
                                            <a href="javascript:void(0);" onclick="relatedProduct_add_remove_to_wishlist(<?= $article['id'] ?>)">
                                            <i class="far fa-heart"></i></a>
                                        </div>
                                
                                <?php } ?>
                                <div class="product-image">
                                    <a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" border="0" alt="" class="w-100"></a>
                                </div>
                                <div class="product-short-decription text-center">
                                    <a href="<?= LANG_URL . '/' . $article['url'] ?>">
                                        <p><?= $article['product_title'] ?>
                                    
                                </p>
                                </a>
                                </div>
                                <div class="product-price-and-description text-center">
                                    <?php if ($quantity[0]['quantity'] != 0){
                                            ?>
                                    <a href="javascript:void(0)" class="addcart-box frequentlyProduct-add-cart btn-add btn frequently_cart<?php echo $key ?>"  data-id="<?= $article['id'] ?>" data-key="<?= $key ?>">ADD to cart <span>| </span> <?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?></a>
                                    <a href="<?= base_url('shopping-cart') ?>" class="common-button go_to_frequently_cart_cart<?php echo $key ?>" style='display: none;'>Go to Cart</a>
                                <?php } else{?>
                                    <a href="javascript:void(0)" class="addcart-box btn-add btn">Coming soon</a>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                        <?php } ?> 
                        
                    </div>
                    </div>
                     <div class="swiper-button-prev frequently-bought-prev common-prev"><img src="<?= base_url('images/left-arrow.png') ?>" alt=""></div>
                            <div class="swiper-button-next frequently-bought-next common-next"><img src="<?= base_url('images/right-arrow.png') ?>" alt=""></div>
                </div>
            </section>
            <?php } ?>
            <?php /* if (!empty($frequently_bought)) { ?>
            <section class="freequently-bought-togrether-sec">
                <div id="" class="container">
                    <div id="" class="repated-product-heading">
                        <h2>Frequently bought together</h2>
                    </div>
                    <div id="" class="row justify-content-md-center align-items-center">
                        <?php foreach ($frequently_bought as $value) {
                            //print_r($frequently_bought);
                            $item = $this->Public_model->getSinglefrequentlyBought($value);
                            //print_r($item);
                            //$numItems = count($item);
                            $count = 0;
                            $length = count($item);
                                    foreach ($item as $key => $product) { 
                                        //echo end($key);
                                      //   if(++$i === $numItems) {
                                      //   echo "last index!".$product;
                                      // }
                        ?>
                        <div id="" class="col-lg-5 col-md-5">
                            <div class="product-main-wrapper">
                                <div id="" class="product-lft-img">
                                    <!-- <img src="<?= base_url('images/Layer14.png'); ?>"  border="0" alt=""> -->
                                    <img src="<?= base_url('/attachments/shop_images/' . $product['image']) ?>" border="0" alt="">
                                </div>
                                <div id="" class="product-contents">
                                    <h4><?php echo $product['product_title']  ?> </h4>
                                    <p>₹<?php echo $product['variantPrice'];?></p>
                                </div>
                            </div>
                        </div>
                        <div id="" class="col-lg-1 col-md-2 <?php if($value == $lastValue) echo 'not_show'?>" >
                            <div id="" class="text-center ">
                                <img src="<?= base_url('images/plus1.png'); ?>"  border="0" alt="">
                            </div>
                        </div>
                    <?php  } }?>
                        
                        <div class="col-lg-12">
                            <div class="product-price-and-description text-center  f-m">
                                <input type="hidden" name="vID" id="vID" value="<?php echo $variantID; ?>">
                                <a class="frequentlyBoughtCart auto-width" href="javascript:void(0)" onclick="frequentlyBought()">ADD to cart <span>| </span>  Total  =  ₹<?php echo $summation; ?></a>
                                <a class="frequentlyBoughtGoto auto-width" href="<?= LANG_URL . '/shopping-cart' ?>" style="display: none;">Go to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } */ ?>
            <?php if (!empty($relatedProductArray)) { ?>
            <section class="related-product new-related-product">
                <div class="container position-relative">
                    <div id="" class="repated-product-heading">
                        <h2>Related Products</h2>
                    </div>
                    <div class="swiper-container blog-slider-new">
					<div class="swiper-wrapper">
						<?php /* foreach($sameCagegoryProducts as $key => $article){ */ ?>
                        <?php foreach($relatedProductArray as $key => $article){
                            $wishListData = $this->Public_model->wishListSelectedData($article['id'],$_SESSION['logged_user']);
                            $quantity = $this->Public_model->getquantity($article['id']);
                            ?>
                        <div class="swiper-slide ">
                            <div class="each-listing-of-product">
                                 <?php if(!isset($_SESSION['logged_user'])){?>
                                 <div id="" class="wishlist-img">
                                    <a href="#login" class="fancybox">
                                        <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                    </a>
                                </div>
                                 <?php }else{?>
                                    <div id="relatedProductAdd<?= $article['id'] ?>" class="wishlist-img <?php if($article['id'] == $wishListData['product_id']) echo 'active';?>" data-target="add">
                                            <a href="javascript:void(0);" onclick="relatedProduct_add_remove_to_wishlist(<?= $article['id'] ?>)">
                                            <i class="far fa-heart"></i></a>
                                        </div>
                                <!-- <div id="" class="wishlist-img">
                                    <a href="javascript:void(0);" onclick="add_item_to_wishlist(<?= $article['id'] ?>)"><i class="far fa-heart"></i></a>
                                </div> -->
                                <?php } ?>
                                <div class="product-image">
                                    <a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" border="0" alt="" class="w-100"></a>
                                </div>
                                <div class="product-short-decription text-center">
                                    <a href="<?= LANG_URL . '/' . $article['url'] ?>">
                                        <p><?= $article['product_title'] ?>
                                    <!-- <?php echo $variants[0]['quantity'].$variants[0]['weight_unit'];?> -->
                                </p>
                                </a>
                                </div>
                                <div class="product-price-and-description text-center">
                                    <?php if ($quantity[0]['quantity'] != 0){
                                            ?>
                                    <a href="javascript:void(0)" class="addcart-box btn-add-cart-list btn-add btn home_cart<?php echo $key ?>"  data-id="<?= $article['id'] ?>" data-key="<?= $key ?>">ADD to cart <span>| </span> <?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?></a>
                                    <a href="<?= base_url('shopping-cart') ?>" class="common-button go_to_cart<?php echo $key ?>" style='display: none;'>Go to Cart</a>
                                <?php } else{?>
                                    <a href="javascript:void(0)" class="addcart-box btn-add btn">Coming soon</a>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                        <?php } ?> 
                        <!-- <div class="col-lg-4 col-md-6">
                            <div class="each-listing-of-product">
                                <div id="" class="wishlist-img">
                                    <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                </div>
                                <div class="product-image">
                                    <img src="<?= base_url('images/product-listing2.jpg'); ?>" border="0" alt="" class="w-100">
                                </div>
                                <div class="product-short-decription text-center">
                                    <p>Neolayr Pro Prohair Quick 
                                    Hair Fall Control Solution 
                                    40 ML</p>
                                </div>
                                <div class="product-price-and-description text-center">
                                    <a href="">ADD to cart <span>| </span> ₹340.00</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="each-listing-of-product">
                                <div id="" class="wishlist-img">
                                    <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                </div>
                                <div class="product-image">
                                    <img src="<?= base_url('images/product-listing3.jpg'); ?>" border="0" alt="" class="w-100">
                                </div>
                                <div class="product-short-decription text-center">
                                    <p>Neolayr Pro Prohair Quick 
                                    Hair Fall Control Solution 
                                    40 ML</p>
                                </div>
                                <div class="product-price-and-description text-center">
                                    <a href="">ADD to cart <span>| </span> ₹340.00</a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    </div>
                     <div class="swiper-button-prev blog-prev common-prev"><img src="<?= base_url('images/left-arrow.png') ?>" alt=""></div>
                            <div class="swiper-button-next blog-next common-next"><img src="<?= base_url('images/right-arrow.png') ?>" alt=""></div>
                </div>
            </section>
            <?php } ?>
            <?php if(!empty($video_final_arr)){?>
            <section class="review-video-banner ">
                <div class="container position-relative">
                    <h2>Reviews with Videos</h2>
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach ($video_final_arr as $reviews) {

                            ?>
                            <div class="swiper-slide">
                                <div class="each-review-video">
                                    <div class="video-iframe">
                                        <iframe width="100%" height="171" src="<?php echo $reviews['videoLink'];?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                    <div class="video-title text-center">
                                        <h6><?php echo $reviews['videoTitle'];?></h6>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                
                     <div class="swiper-button-prev review-video-prev common-prev"><img src="<?= base_url('images/left-arrow.png') ?>" alt=""></div>
                            <div class="swiper-button-next review-video-next common-next"><img src="<?= base_url('images/right-arrow.png') ?>" alt=""></div>
                </div>
            </section>
        <?php } ?>
            <?php  if(sizeof($review)>0 && $showRating == 1){?>
            <section class="product-review-section">
                <div id="" class="container">
                    <div id="" class="row  align-items-center">
                        <div id="" class="col-lg-4">
                            <div id="" class="review-left-wrapper">
                                <h4>Product review</h4>
                                <p>Write a review</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="" class="protuct-total-review justify-content-center align-items-center d-flex">
                                <div id="" class="total-ratting">
                                    <?php echo $totReview/$countTotalReview;?>
                                </div>
                                <div id="" class="star-ratting">
                                    <div class="star-area">
                                                <img src="<?= base_url('images/Star-line.png') ?>" border="0" alt="" style="margin-right:0px">
                                                <span class="rating-cover" style="width:<?php echo ($pRating/5)*100; ?>%;">
                                                    <img src="<?= base_url('images/Star-solid.png') ?>" border="0" alt="">
                                                </span>
                                            </div> 
                                    <p><?php echo $countTotalReview;?> Review</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach($review as $row){?>
                    <div class="row align-items-start pt-3">
                        <div id="" class="col-lg-4">
                            <div id="" class="review-cm-wrapper">
                                <h4>Review</h4>
                                <p><?=$row['user_id']?></p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="" class="product-review-comment">
                                <h3><?php /* ?>FANTASTIC<?php */ ?>
                                <?php for($i=0;$i<$row['rating'];$i++){?>
                                        <span class=""><i class="text-warning fa fa-star"></i></span>
                                        <?php } ?>
                                </h3>
                                <p><?=$row['comment']?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <hr>
                    <?php /* ?>
                    <div class="row align-items-start pt-3">
                        <div id="" class="col-lg-4">
                            <div id="" class="review-cm-wrapper">
                                <h4>Product review</h4>
                                <!-- <p>Housewife</p> -->
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="" class="product-review-comment">
                                <h3>FANTASTIC<span>
                                    <img src="<?= base_url('images/yellow-star.png'); ?>"  border="0" alt=""><img src="<?= base_url('images/yellow-star.png'); ?>"  border="0" alt=""><img src="<?= base_url('images/yellow-star.png'); ?>"  border="0" alt=""><img src="<?= base_url('images/yellow-star.png'); ?>"  border="0" alt=""><img src="<?= base_url('images/yellow-half-star.png'); ?>"  border="0" alt=""></span>
                                </h3>
                                <p>To help build your skin care routine, we’d like to learn a little more about you At the end, we’ll also give you the opportunity to book a 1:1</p>
                            </div>
                        </div>
                    </div>
                    <?php */ ?>
                </div>
            </section>
        <?php } ?>
            <!-- END:PRODUCT DETAILS-->
            <!-- SITE FOOTER-->
           
            <!-- END FOOTER-->
        </main>