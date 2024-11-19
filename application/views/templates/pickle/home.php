<div class="home-top-container">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="home-slider owl-carousel owl-carousel-lazy">
                             <?php
                            	foreach ($home_slider as $row) {
														$u_path = 'attachments/banner_images/';
														if ($row->banner_image != null && file_exists($u_path . $row->banner_image)) {
															$image = base_url($u_path . $row->banner_image);
														} else {
															$image = base_url('attachments/no-image.png');
														}
														?>
						<?php if($row->banner_link!=""){?>
						<a href="<?= $row->banner_link;?>" >
                                                        <div class="home-slide">
                                                            <img class="owl-lazy" src="<?= base_url('template/imgs/lazy.png') ?>" data-src="<?= $image ?>" alt="slider image">
                                                            <div class="home-slide-content">
                                                                <!-- <h1>up to 40% off</h1>
                                                                <h3>Punjabi Green chilly</h3>
								<a href="#" class="btn btn-primary">Shop Now</a>-->
                                                            </div><!-- End .home-slide-content -->
                                                        </div><!-- End .home-slide -->
						</a>
						<?php } ?>							
								<?php } ?>
                            </div><!-- End .home-slider -->
                        </div><!-- End .col-lg-8 -->

                        <div class="col-lg-4 top-banners">
                            <div class="banner banner-image">
                                <a href="<?= $main_banner_section1_link;?>">
                                    <img src="<?= base_url('attachments/banner_images/' . $main_banner_section1) ?>" alt="banner">
                                </a>
                            </div><!-- End .banner -->
							<div class="banner banner-image">
                                <a href="<?= $main_banner_section2_link;?>">
                                    <img src="<?= base_url('attachments/banner_images/' . $main_banner_section2) ?>" alt="banner">
                                </a>
                            </div><!-- End .banner -->
                            <div class="banner banner-image">
                                <a href="<?= $main_banner_section3_link;?>">
                                    <img src="<?= base_url('attachments/banner_images/' . $main_banner_section3) ?>" alt="banner">
                                </a>
                            </div><!-- End .banner -->
                        </div><!-- End .col-lg-4 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div>
            <div class="info-boxes-container">
                <div class="container">
                    <div class="info-box">
                        <i class="icon-shipping"></i>

                        <div class="info-box-content">
                            <h4>BULK ORDERS and CUSTOMIZATION</h4>
                            <p>Mail or Whatsapp, will get back to you</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->

                    <div class="info-box">
                        <i class="icon-us-dollar"></i>

                        <div class="info-box-content">
                            <h4>100% SATISFACTION GUARANTEE</h4>
                            <p>We believe in delivering quality & original products</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->

                    <div class="info-box">
                        <i class="icon-support"></i>

                        <div class="info-box-content">
                            <h4>ONLINE SUPPORT 24/7</h4>
                            <p>Uninterrupted service and support</p>
                        </div><!-- End .info-box-content -->
                    </div><!-- End .info-box -->
                </div><!-- End .container -->
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="home-product-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#featured-products" role="tab" aria-controls="featured-products" aria-selected="true">Featured Products</a>
                                </li>
                               
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                                    <div class="row row-sm">
                                    	<?php 
										$counter = 1;
										foreach($homeProducts as $article){?>
                                        <div class="col-6 col-md-4">
                                            <div class="product-default mb-4">
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
                                                        <span class="product-price"><?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?> <strike class="pevious_price"><?= $article['default_old_price'] != '0' ? CURRENCY.number_format($article['default_old_price'], 2):'' ?></strike></span>
                                                    </div><!-- End .price-box -->
                                                    <div class="product-action">
                                                    <?php //if ($article['quantity'] > 0){ ?>
                                                       <a href="javascript:void(0);" class="btn-icon btn-add-cart btn-add" data-id="<?= $article['id'] ?>">
                                                                       <i class="icon-bag"></i>ADD TO CART
                                                        </a>
                                                    <?php //} ?>
                                                        <!--<a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i class="fas fa-external-link-alt"></i></a> -->
                                                    </div>
                                                </div><!-- End .product-details -->
                                            </div>
                                        </div><!-- End .col-md-4 -->
                                       <?php } ?>
                                    </div><!-- End .row -->
                                </div><!-- End .tab-pane -->
                                <!-- End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .home-product-tabs -->

                        <div class="banners-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="banner banner-image">
                                        <a href="<?= $footer_banner_section1_link;?>">
                                            <img src="<?= base_url('attachments/banner_images/' . $footer_banner_section1); ?>" alt="banner">
                                        </a>
                                    </div><!-- End .banner -->

                                   <div class="banner banner-image">
                                        <a href="<?= $footer_banner_section2_link;?>">
                                            <img src="<?= base_url('attachments/banner_images/' . $footer_banner_section2); ?>" alt="banner">
                                        </a>
                                    </div><!-- End .banner -->
                                </div><!-- End .col-md-4 -->

                                <div class="col-md-8">
                                    <div class="banner banner-image">
                                        <a href="<?= $footer_banner_section3_link;?>">
                                            <img src="<?=  base_url('attachments/banner_images/' . $footer_banner_section3); ?>" alt="banner">
                                        </a>
                                    </div><!-- End .banner -->
                                </div><!-- End .col-md-4 -->
                            </div><!-- End .row -->
                        </div><!-- End .banners-group -->
                    </div><!-- End .col-lg-9 -->

                    <aside class="sidebar-home col-lg-3">
                        <div class="widget widget-cats">
                            <h3 class="widget-title">Categories</h3>
                            <ul class="catAccordion">
                            	<?php
									function loop_tree($pages, $is_recursion = false)
									{
										?>
										<ul class="<?= $is_recursion === true ? 'children' : 'parent' ?>">
											<?php
											foreach ($pages as $page) {
												$children = false;
												if (isset($page['children']) && !empty($page['children'])) {
													$children = true;
												}
												?>
												<li>
													<?php if ($children === true) {
														?>
														<i class="fa fa-chevron-right" aria-hidden="true"></i>
													<?php } else { ?>
														<i class="fa fa-circle-o" aria-hidden="true"></i>
													<?php } ?>
													<a href="javascript:void(0);" data-categorie-id="<?= $page['id'] ?>" class="go-category left-side <?= isset($_GET['category']) && $_GET['category'] == $page['id'] ? 'selected' : '' ?>">
														<?= $page['name'] ?>
													</a>
													<?php
													if ($children === true) {
														loop_tree($page['children'], true);
													} else {
														?>
													</li>
													<?php
												}
											}
											?>
										</ul>
										<?php
										if ($is_recursion === true) {
											?>
											</li>
											<?php
										}
									}
				
									loop_tree($home_categories);
									?>
                    
                               <!-- <li>
                                    <a href="category.html">Fashion</a> 
                                    <button class="accordion-btn collapsed" type="button" data-toggle="collapse" data-target="#accordion-ul-1" aria-expanded="false" aria-controls="accordion-ul-1"></button>

                                    <ul class="collapse" id="accordion-ul-1">
                                        <li><a href="#">WOMEN CLOTHES</a></li>
                                        <li><a href="#">MEN CLOTHES</a></li>
                                        <li><a href="#">HOES</a></li>
                                        <li><a href="#">Accessories</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="category.html">Electronics </a>
                                    <button class="accordion-btn collapsed" type="button" data-toggle="collapse" data-target="#accordion-ul-2" aria-expanded="false" aria-controls="accordion-ul-2"></button>

                                    <ul class="collapse" id="accordion-ul-2">
                                        <li><a href="#">Computers</a></li>
                                        <li><a href="#">Mobile Phones</a></li>
                                        <li><a href="#">Laptops</a></li>
                                        <li><a href="#">Tablets</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="category.html">Gifts</a>
                                </li>
                                <li>
                                    <a href="category.html">Home & Garden</a>
                                </li>
                                <li>
                                    <a href="category.html">Music</a>
                                </li>
                                <li>
                                    <a href="category.html">Motors</a>
                                    <button class="accordion-btn collapsed" type="button" data-toggle="collapse" data-target="#accordion-ul-3" aria-expanded="false" aria-controls="accordion-ul-3"></button>

                                    <ul class="collapse" id="accordion-ul-3">
                                        <li><a href="#">Sub Category</a></li>
                                        <li><a href="#">Sub Category</a></li>
                                        <li><a href="#">Sub Category</a></li>
                                        <li><a href="#">Sub Category</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="category.html">Clothes</a>
                                    <button class="accordion-btn collapsed" type="button" data-toggle="collapse" data-target="#accordion-ul-4" aria-expanded="false" aria-controls="accordion-ul-4"></button>

                                    <ul class="collapse" id="accordion-ul-4">
                                        <li><a href="#">Sub Category</a></li>
                                        <li><a href="#">Sub Category</a></li>
                                        <li><a href="#">Sub Category</a></li>
                                        <li><a href="#">Sub Category</a></li>
                                    </ul>
                                </li>-->
                            </ul>
                        </div>
                        <div class="widget">
                            <div class="banner banner-image">
                                <a href="<?= $side_banner_link; ?>">
                                    <img src="<?= base_url('attachments/banner_images/' . $side_banner) ?>" alt="banner">
                                </a>
                            </div><!-- End .banner -->
                        </div><!-- End .widget -->

                        <div class="widget">
                            <h3 class="widget-title">From Our Blog</h3>

                            <article class="entry">
                            	<?php if(sizeof($post)>0){?>
                                <div class="entry-media">
                                    <a href="<?= LANG_URL . '/blog/' ?>">
                                        <img src="<?= base_url('attachments/blog_images/' . $post[0]['image']) ?>" alt="<?= $post[0]['title'] ?>">
                                    </a>
                                    <div class="entry-date">
                                         <?= date('d', $post[0]['time']) ?>
                                        <span> <?= date('M', $post[0]['time']) ?></span>
                                    </div><!-- End .entry-date -->
                                </div><!-- End .entry-media -->
								<?php } ?>
                                <div class="entry-body">

                                    <h2 class="entry-title">
                                        <a href="#">Customer Review</a>
                                    </h2>

                                    <div class="entry-content">
                                        <p></p>
                                        <p></p>
                                        <a href="#" class="read-more"></a>
                                    </div><!-- End .entry-content -->
                                </div><!-- End .entry-body -->
                            </article><!-- End .entry -->
                        </div><!-- End .widget -->

                    </aside><!-- End .col-lg-3 -->    
                </div><!-- End .row -->
            </div>
            <div class="mb-4"></div><!-- margin -->
            <div class="partners-container">
                <div class="container">
                    <div class="partners-carousel owl-carousel owl-theme">
                        <a href="#" class="partner">
                            <img src="<?= base_url('template/imgs/1.png') ?>" alt="logo">
                        </a>
                        <a href="#" class="partner">
                            <img src="<?= base_url('template/imgs/2.png') ?>" alt="logo">
                        </a>
                        <a href="#" class="partner">
                            <img src="<?= base_url('template/imgs/3.png') ?>" alt="logo">
                        </a>
                        <a href="#" class="partner">
                            <img src="<?= base_url('template/imgs/4.png') ?>" alt="logo">
                        </a>
                        <a href="#" class="partner">
                            <img src="<?= base_url('template/imgs/5.png') ?>" alt="logo">
                        </a>			
                       
                    </div><!-- End .partners-carousel -->
                </div><!-- End .container -->
            </div>