<!-- home slider section start-->
<section class="p-0 full-slider">
    <div class="slide-1 home-slider home-55">
     <?php
     foreach ($home_slider as $row) {
														$u_path = 'attachments/banner_images/';
														if ($row->banner_image != null && file_exists($u_path . $row->banner_image)) {
															$image = base_url($u_path . $row->banner_image);
														} else {
															$image = base_url('attachments/no-image.png');
														}
														?>
        <div>
            <div class="home text-left p-left">
                <img src="<?= $image ?>" class="bg-img " alt="">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="slider-contain">
                                <div>
                                    <h5>baby products</h5>
                                    <h1>kids fashion</h1>
                                    <h4>valid till 25 august</h4>
                                    <?php if($row->banner_link!=""){?>
                                    
												<a href="<?= $row->banner_link;?>" class="btn btn-solid" tabindex="0">shop now</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>
</section>
<!-- home slider section end-->


<!-- service layout -->
<div class="container">
    <section class="service section-b-space border-section border-top-0 service-abjust">
        <div class="row">
            <div class="col-lg-3 col-sm-6 service-block">
                <div class="media">
                   <img src="<?= base_url('templatecss/imgs/services-1.png') ?>" alt="" class="img-fluid">
                    <div class="media-body">
                        <h5>free shipping</h5>
                        <p>Shipping on order over ₹999</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service-block">
                <div class="media">
                    <img src="<?= base_url('templatecss/imgs/services-2.png') ?>" alt="" class="img-fluid">
                    <div class="media-body">
                        <h5>online payment</h5>
                        <p>service for new customer</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service-block">
                <div class="media">
                    <img src="<?= base_url('templatecss/imgs/services-3.png') ?>" alt="" class="img-fluid">
                    <div class="media-body">
                        <h5>24 X 7 service</h5>
                        <p>flexible service for user</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 service-block">
                <div class="media">
                    <img src="<?= base_url('templatecss/imgs/services-4.png') ?>" alt="" class="img-fluid">
                    <div class="media-body">
                        <h5>festival offer</h5>
                        <p>100% easy replacement</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- service layout end-->


<!-- banner layout -->
<!--<section class="section-b-space banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="banner-content layout-3">
                    <h6>grand offer of the day</h6>
                    <h2>Sale <span>hurry UP</span>! Opening Dhamaka <span class="f-bold">Buy 3 Get 1 Free</span></h2>
                    <h4>win 100% cashback</h4>
                    <div class="banner-btn">
                        <h6>Win 100% cashback Every hour Offer Code <span>Save 2 Get 1</span> the great deal</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
<!-- banner layout end -->


<!-- category layout -->
<!--<section class="section-b-space category grey-bg no-arrow">
    <div class="container">
        <div class="cat-slide-6">
            <div>
                <a href="#">
                    <div class="category-wrap">
                        <div>
                            <img src="<?= base_url('templatecss/imgs/tshirt.png') ?>" alt="">
                            <h6>20% off</h6>
                            <h5>clothes</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="category-wrap">
                        <div>
			    <img src="<?= base_url('templatecss/imgs/pyramid.png') ?>" alt="">
                            <h6>-10% off</h6>
                            <h5>toys</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="category-wrap">
                        <div>
			    <img src="<?= base_url('templatecss/imgs/shoe.png') ?>" alt="">
                            <h6>30% off</h6>
                            <h5>footwear</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="category-wrap">
                        <div>
			    <img src="<?= base_url('templatecss/imgs/gel.png') ?>" alt="">
                            <h6>sale</h6>
                            <h5>Grooming</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="category-wrap">
                        <div>
			    <img src="<?= base_url('templatecss/imgs/clothes.png') ?>" alt="">
                            <h6>sale</h6>
                            <h5>bottom</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="category-wrap">
                        <div>
			    <img src="<?= base_url('templatecss/imgs/socks.png') ?>" alt="">
                            <h6>₹99</h6>
                            <h5>accessories</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="category-wrap">
                        <div>
			    <img src="<?= base_url('templatecss/imgs/gel.png') ?>" alt="">
                            <h6>-5% off</h6>
                            <h5>sports</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>-->
<!-- category layout end -->


<!-- tab section start -->
<section class="section-b-space vertical-tab vertical-tab2 ratio_square">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 padding-class pr-0">
                <div class="tab-head">
                    <h2 class="title title-color">New Arrivals</h2>
                </div>
                <div class="tab-inner tab-title2">
                    <div class="theme-tab">
                        <div class="tab-content-cls">
                            <div id="tab-1" class="tab-content active default" >
                                <div class="product-4">
                                  <div>
                                	<?php 
										$counter = 0;
										foreach($homeProducts as $article){
											$counter++; ?>
                                    	
                                        <div class="product-box">
                                                    <div class="img-block">
                                                        <a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" class=" img-fluid bg-img" alt=""></a>
                                                        
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
                                        
                                    
                                    <?php if($counter%2 == 0 && $counter!=sizeof($homeProducts)) echo '</div><div>'; } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 side-banner pl-0">
                  <a href="<?= $side_banner_link; ?>">
                                    <img src="<?= base_url('attachments/banner_images/' . $side_banner) ?>" alt="banner">
                  </a>
            </div>
        </div>
    </div>
</section>
<!-- tab section end -->


<!-- collection banner start -->
<section class="section-b-space grey-bg ratio_40">
    <div class="container">
        <div class="row partition-3">
            <div class="col-md-6">
                <a href="<?= $footer_banner_section1_link; ?>">
                    <div class="collection-banner border-0 p-right text-right">
                        <div class="img-part">
                            <img src="<?= base_url('attachments/banner_images/' . $footer_banner_section1) ?>" class=" img-fluid  bg-img" alt="">
                        </div>
                        <div class="contain-banner">
                            <div>
                                <div class="banner-deal">
                                    <h6>free shipping</h6>
                                </div>
                                <h3>nikon camera</h3>
                                <h6>shop now</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="<?= $footer_banner_section2_link; ?>">
                    <div class="collection-banner border-0 p-right text-left">
                        <div class="img-part">
                            <img src="<?= base_url('attachments/banner_images/' . $footer_banner_section2) ?>" class=" img-fluid bg-img" alt="">
                        </div>
                        <div class="contain-banner">
                            <div>
                                <div class="banner-deal">
                                    <h6>minimum 30% off</h6>
                                </div>
                                <h3>kids fashion</h3>
                                <h6>shop now</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- collection banner end -->


<!-- tab section start -->

<!-- tab section end -->


<!-- section start -->
<!--<section class="">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 logo no-border">
                <h2 class="title title-color">trusted brand</h2>
                <div class="logo-3 border-logo">
                    <div>
                        <div class="logo-img">
                            <img src="<?= base_url('templatecss/imgs/1.png') ?>" class=" img-fluid" alt="">
                        </div>
                    </div>
                     <div>
                        <div class="logo-img">
                            <img src="<?= base_url('templatecss/imgs/2.png') ?>" class=" img-fluid" alt="">
                        </div>
                    </div>
                    <div>
                        <div class="logo-img">
                            <img src="<?= base_url('templatecss/imgs/3.png') ?>" class=" img-fluid" alt="">
                        </div>
                    </div>
                    <div>
                        <div class="logo-img">
                            <img src="<?= base_url('templatecss/imgs/4.png') ?>" class=" img-fluid" alt="">
                        </div>
                       
                    </div>
                    <div>
                        <div class="logo-img">
                            <img src="<?= base_url('templatecss/imgs/5.png') ?>" class=" img-fluid" alt="">
                        </div>
                       
                    </div>
                     <div>
                        <div class="logo-img">
                            <img src="<?= base_url('templatecss/imgs/6.png') ?>" class=" img-fluid" alt="">
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
<!-- section end -->