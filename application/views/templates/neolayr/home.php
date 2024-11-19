<style type="text/css">
.gm-style .place-card-large{
	display: none;
}
.home-banner img{
	width: 100%;
}
.gm-style .place-card-large {
    display: none !important;
}


</style>
<main>	
	 <div class="rightarea-heading-offer">
		<span class="f-offer"><marquee width="90%">Get 20% off on your first purchase | Use code: NEOFIRST. </marquee></span>
	</div> 
	<!--<div class="test-heading-offer">-->
	<!--	<span class="test-color">This website is under testing period. Don't place any order now!!! </span>-->
	<!--</div>-->
		<!-- START BANNER -->
		<section class="home-banner-section">
			<!-- Slider main container -->
			<div class="swiper-container home-banner">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
					<?php
     					foreach ($home_slider as $row) { 
			     		$u_path = 'attachments/banner_images/';
						if ($row->banner_image != null && file_exists($u_path . $row->banner_image)) {
							$image = base_url($u_path . $row->banner_image);
						} else {
							$image = base_url('attachments/no-image.png');
						} 

						if ($row->banner_image_mob != null && file_exists($u_path . $row->banner_image_mob)) {
							$mob_image = base_url($u_path . $row->banner_image_mob);
						} else {
							$mob_image = base_url('attachments/no-image.png');
						}?>
					<!-- Slides -->
					<div class="swiper-slide">
						<!-- <img src="<?= $image ?>" alt="" class="each-banner-image"> -->
						<?php if($row->link_for != 'ingredient'){?>
						<?php if($row->banner_link_pdp != ''){?>
							<a href="<?= LANG_URL . '/'.$row->banner_link_pdp ?>">
						<?php } else{ ?>
						<a href="<?= LANG_URL . '/category?type='.$row->banner_link_plp ?>">
						<?php } } else{?>
							<a href="<?= LANG_URL . '/ingredient'?>">
						<?php } ?>
						<picture>
							<source media="(min-width:1024px)" class="imageResponsive" srcset="<?= $image ?>">
                            <img class="imageResponsive" src="<?= $mob_image ?>" alt="" >
    					</picture>
    				</a>
					</div>
					<?php } ?>
				</div>
				<div class="swiper-pagination"></div>
			
			</div>
		</section>
		<!-- END BANNER  -->
		<!-- START SHOP PRODUCT -->
		<section class="shop-product shop-product-for-home-only">
			<div class="container">
				<h2 class="text-center">Shop By Products</h2>
				<ul class="product-category">
					<li><a href="javascript:void(0)" class="each-cat active">Best Seller</a></li>
					<li><a href="javascript:void(0)" class="each-cat">Newly Launched</a></li>
					<li><a href="javascript:void(0)" class="each-cat">Gift Sets</a></li>
				</ul>
				<div class="product-sl-list position-relative">
					<div class="each-slide active">
						<div class="swiper-container product-slider product-slider1">
							<!-- Additional required wrapper -->
							<div class="swiper-wrapper">
								<?php 
										$counter = 0;
										
										foreach($bestSellers as $key => $article){

											$wishListData = $this->Public_model->wishListSelectedData($article['id'],$_SESSION['logged_user']);

											$image_files = array();
                                        if ($article['folder'] != null) {
                                            $dir = "attachments/shop_images/" . $article['folder'] . '/';
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

                                            //print_r($image_files);
											 ?>
								<div class="swiper-slide">
									<div class="each-product">
										<?php if(!isset($_SESSION['logged_user'])){?>
                                         <div id="" class="wishlist-img">
                                            <a href="#login" class="fancybox ad-wish">
                                                <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                            </a>
                                        </div>
                                 		<?php }else{?>
											<div id="bestWishListAdd<?= $article['id'] ?>" class="wishlist-img <?php if($article['id'] == $wishListData['product_id']) echo 'active';?>" data-target="add">
												<a href="javascript:void(0);" onclick="best_add_remove_item_to_wishlist(<?= $article['id'] ?>)">
												<i class="far fa-heart"></i></a>
											</div>
										<?php } ?>
										<?php  ?> 
										<div class="single-item">
											<?php foreach ($image_files as $keys => $images) {
													?>
													<?php if($keys <= 1){?>
										  <div class="slide"><a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('attachments/shop_images/' . $article['folder'].'/' . $images) ?>" class="product-image" alt="" loading="lazy">
												</a></div>
										<?php } }?>
										</div>
										<?php  ?>
										<?php /* ?>
										<div class="swiper-container slider">
											<div class="swiper-wrapper">
												<?php foreach ($image_files as $keys => $images) {
													?>
												<?php if($keys <= 3){?>
												<div class="swiper-slide">
													<a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('attachments/shop_images/' . $article['folder'].'/' . $images) ?>" class="product-image" alt="" loading="lazy">
												</a>
												</div>
											<?php } }?>
																								
											</div>
											 <div class="swiper-pagination-new"></div> 
										</div>
										<?php */ ?>
										<!-- <a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" class="product-image" alt=""></a> -->
										<div class="product-content">
											<?php  if($showRating == 1){?>
											<div class="star-area">
												<img src="<?= base_url('images/Star-line.png') ?>" border="0" alt="">
												<span class="rating-cover" style="width:<?php echo ($article['rating']/5)*100; ?>%;">
													<img src="<?= base_url('images/Star-solid.png') ?>" border="0" alt="">
												</span>
											</div>
										<?php } ?>
											<div class="row">
												<div class="col-md-12">
													<h3><a href="<?= LANG_URL . '/' . $article['url'] ?>"><?= $article['product_title'] ?>
														</a></h3>
													<!-- <h3><?php echo $article['weight'] ?> <?php echo $article['weight_unit'] ?></h3> -->
												</div>
												<div class="col-md-12 hm_price">
													<h4><?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 0); else echo 'Coming soon' ?></h4>
												</div>
												<div class="col-lg-12 text-center mt-4 product-add-to-cart">
													<a href="javascript:void(0)" class="common-button btn-add-cart-list home_cart<?php echo $key ?>" data-id="<?= $article['id'] ?>" data-key="<?= $key ?>">Add to cart</a>
													<a href="<?= base_url('shopping-cart') ?>" class="common-button go_to_cart<?php echo $key ?>" style='display: none;'>Go to Cart</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							</div>
						</div>
						<!-- If we need navigation buttons -->
						
								<!-- If we need navigation buttons -->
						<div class="swiper-button-prev product-prev product-prev1 common-prev"><img src="<?= base_url('images/red-prev.png') ?>"alt=""></div>
						<div class="swiper-button-next product-next product-next1 common-next"><img src="<?= base_url('images/red-next.png') ?>"alt=""></div>
					</div>
					<div class="each-slide">
						<div class="swiper-container product-slider product-slider2">
							<!-- Additional required wrapper -->
							<div class="swiper-wrapper">
								<?php 
										$counter = 0;
										foreach($recentlyAdded as $key => $recently){
											$wishListData = $this->Public_model->wishListSelectedData($recently['id'],$_SESSION['logged_user']);

												$image_files = array();
                                        if ($recently['folder'] != null) {
                                            $dir = "attachments/shop_images/" . $recently['folder'] . '/';
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
                                            //print_r($image_files);
											 ?>
								<div class="swiper-slide">
									<div class="each-product">
										<?php if(!isset($_SESSION['logged_user'])){?>
                                         <div id="" class="wishlist-img">
                                            <a href="#login" class="fancybox  ad-wish">
                                                <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                            </a>
                                        </div>
                                 		<?php }else{?>
										<div id="recentlyWishListAdd<?= $recently['id'] ?>" class="wishlist-img <?php if($recently['id'] == $wishListData['product_id']) echo 'active';?>" data-target="add">
											<a href="javascript:void(0);" onclick="recently_add_remove_item_to_wishlist(<?= $recently['id'] ?>)">
											<i class="far fa-heart"></i></a>
										</div>
									<?php } ?>
										<?php  ?> 
										<div class="single-item">
											<?php foreach ($image_files as $keys => $images) {
													?>
													<?php if($keys <= 1){?>
										  <div class="slide"><a href="<?= LANG_URL . '/' . $recently['url'] ?>"><img src="<?= base_url('attachments/shop_images/' . $recently['folder'].'/' . $images) ?>" class="product-image" alt="" loading="lazy">
												</a></div>
										<?php } }?>
										</div>
										<?php  ?>
										<?php /* ?><div id="" class="wishlist-img">
											<a href="javascript:void(0);" onclick="add_item_to_wishlist(<?= $recently['id'] ?>)"><i class="far fa-heart"></i></a>
										</div> -->
										<!-- <div class="swiper-container slider">
											<div class="swiper-wrapper">
												<div class="swiper-slide"><a href="<?= LANG_URL . '/' . $recently['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $recently['image']) ?>" class="product-image" alt=""></a></div>	
												<div class="swiper-slide"><a href="<?= LANG_URL . '/' . $recently['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $recently['image']) ?>" class="product-image" alt=""></a></div>												
											</div>
											<div class="swiper-pagination-new"></div>
										</div> <?php */ ?>
										<!-- <a href="<?= LANG_URL . '/' . $recently['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $recently['image']) ?>" class="product-image" alt=""></a> -->
										<div class="product-content">
											<?php  if($showRating == 1){?>
											<div class="star-area">
												<img src="<?= base_url('images/Star-line.png') ?>" border="0" alt="">
												<span class="rating-cover" style="width:<?php echo ($recently['rating']/5)*100; ?>%;">
													<img src="<?= base_url('images/Star-solid.png') ?>" border="0" alt="">
												</span>
											</div> 
										<?php } ?>
											<div class="row">
												<div class="col-md-12">
													<h3><a href="<?= LANG_URL . '/' . $recently['url'] ?>"><?= $recently['p_title'] ?>
														</a></h3>
													<!-- <h3><?php echo $recently['weight'] ?> <?php echo $recently['weight_unit'] ?></h3> -->
												</div>
												<div class="col-md-12 hm_price">
													<h4><?php if($recently['default_price'] != '0') echo CURRENCY.number_format($recently['default_price'], 0); else echo 'Coming soon' ?></h4>
												</div>
												<div class="col-lg-12 text-center mt-4 product-add-to-cart">
													<a href="javascript:void(0)" class="common-button btn-add-cart-list home_cart<?php echo $key ?>" data-id="<?= $recently['id'] ?>" data-key="<?= $key ?>">Add to cart</a>
													<a href="<?= base_url('shopping-cart') ?>" class="common-button go_to_cart<?php echo $key ?>" style='display: none;'>Go to Cart</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							</div>
						</div>
						<!-- If we need navigation buttons -->
						<div class="swiper-button-prev product-prev2 common-prev"><img src="<?= base_url('images/red-prev.png') ?>"
								alt=""></div>
						<div class="swiper-button-next product-next2 common-next"><img src="<?= base_url('images/red-next.png') ?>"
								alt=""></div>
					</div>
					<div class="each-slide">
						<div class="swiper-container product-slider product-slider3">
							<!-- Additional required wrapper -->
							<div class="swiper-wrapper">
								<?php 
										$counter = 0;
										foreach($regime as $key => $view){
											$wishListData = $this->Public_model->wishListSelectedData($view['id'],$_SESSION['logged_user']);

										$image_files = array();
                                        if ($view['folder'] != null) {
                                            $dir = "attachments/shop_images/" . $view['folder'] . '/';
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
											 ?>
								<div class="swiper-slide">
									<div class="each-product">
										<?php if(!isset($_SESSION['logged_user'])){?>
                                         <div id="" class="wishlist-img">
                                            <a href="#login" class="fancybox  ad-wish">
                                                <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                            </a>
                                        </div>
                                 		<?php }else{?>
										<div id="giftWishListAdd<?= $view['id'] ?>" class="wishlist-img <?php if($view['id'] == $wishListData['product_id']) echo 'active';?>" data-target="add">
											<a href="javascript:void(0);" onclick="gift_add_remove_item_to_wishlist(<?= $view['id'] ?>)">
											<i class="far fa-heart"></i></a>
										</div>
										<?PHP } ?>

										<?php  ?> 
										<div class="single-item">
											<?php foreach ($image_files as $keys => $images) {
													?>
													<?php if($keys <= 1){?>
										  <div class="slide"><a href="<?= LANG_URL . '/' . $view['url'] ?>"><img src="<?= base_url('attachments/shop_images/' . $view['folder'].'/' . $images) ?>" class="product-image" alt="" loading="lazy">
												</a></div>
										<?php } }?>
										</div>
										<?php  ?>
										<!-- <div id="" class="wishlist-img" >
											<a href="javascript:void(0);" onclick="add_item_to_wishlist(<?= $view['id'] ?>)"><i class="far fa-heart"></i></a>
										</div> -->
										<!-- <a href="<?= LANG_URL . '/' . $view['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $view['image']) ?>" class="product-image" alt=""></a> -->
										<div class="product-content">
											<?php  if($showRating == 1){?>
											<div class="star-area">
												<img src="<?= base_url('images/Star-line.png') ?>" border="0" alt="">
												<span class="rating-cover" style="width:<?php echo ($view['rating']/5)*100; ?>%;">
													<img src="<?= base_url('images/Star-solid.png') ?>" border="0" alt="">
												</span>
											</div> 
										<?php } ?>
											<div class="row">
												<div class="col-md-12">
													<h3><a href="<?= LANG_URL . '/' . $view['url'] ?>"><?= $view['product_title'] ?>
														</a></h3>
													<!-- <h3><?php echo $view['weight'] ?> <?php echo $view['weight_unit'] ?></h3> -->
												</div>
												<div class="col-md-12 hm_price">
													<h4><?php if($view['default_price'] != '0') echo CURRENCY.number_format($view['default_price'], 0); else echo 'Coming soon' ?></h4>
												</div>
												<div class="col-lg-12 text-center mt-4 product-add-to-cart">
													<a href="javascript:void(0)" class="common-button btn-add-cart-list home_cart<?php echo $key ?>" data-id="<?= $view['id'] ?>" data-key="<?= $key ?>">Add to cart</a>
													<a href="<?= base_url('shopping-cart') ?>" class="common-button go_to_cart<?php echo $key ?>" style='display: none;'>Go to Cart</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
								<!-- <div class="swiper-slide">
									<div class="each-product">
										<img src="assets/images/product-2.jpg" class="product-image" alt="">
										<div class="product-content">
											<div class="star-area">
												<img src="assets/images/start.png" alt="">
												<img src="assets/images/start.png" alt="">
												<img src="assets/images/start.png" alt="">
												<img src="assets/images/start.png" alt="">
												<img src="assets/images/half-start.png" alt="">
											</div>
											<div class="row">
												<div class="col-8">
													<h3><a href="">Neolayr Pro Prohair Quick Hair Fall Control Solution
														</a></h3>
													<h3>40 ML</h3>
												</div>
												<div class="col-4">
													<h4>₹340.00</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide">
									<div class="each-product">
										<img src="assets/images/product-3.jpg" class="product-image" alt="">
										<div class="product-content">
											<div class="star-area">
												<img src="assets/images/start.png" alt="">
												<img src="assets/images/start.png" alt="">
												<img src="assets/images/start.png" alt="">
												<img src="assets/images/start.png" alt="">
												<img src="assets/images/half-start.png" alt="">
											</div>
											<div class="row">
												<div class="col-8">
													<h3><a href="">Neolayr Pro Prohair Quick Hair Fall Control Solution
														</a></h3>
													<h3>40 ML</h3>
												</div>
												<div class="col-4">
													<h4>₹340.00</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide">
									<div class="each-product">
										<img src="assets/images/product-4.jpg" class="product-image" alt="">
										<div class="product-content">
											<div class="star-area">
												<img src="<?= base_url('images/start.png') ?>" alt="">
												<img src="<?= base_url('images/start.png') ?>" alt="">
												<img src="<?= base_url('images/start.png') ?>" alt="">
												<img src="<?= base_url('images/start.png') ?>" alt="">
												<img src="<?= base_url('images/half-start.png') ?>" alt="">
											</div>
											<div class="row">
												<div class="col-8">
													<h3><a href="">Neolayr Pro Prohair Quick Hair Fall Control Solution
														</a></h3>
													<h3>40 ML</h3>
												</div>
												<div class="col-4">
													<h4>₹340.00</h4>
												</div>
											</div>
										</div>
									</div>
								</div> -->
							</div>
						</div>
						<!-- If we need navigation buttons -->
						<div class="swiper-button-prev product-prev3 common-prev"><img src="<?= base_url('images/red-prev.png') ?>"alt=""></div>
						<div class="swiper-button-next product-next3 common-next"><img src="<?= base_url('images/red-next.png') ?>"alt=""></div>
					</div>
				</div>
				<!-- <div class="wishlist-popup">
					<h4>Your item added to wishlist</h4>
				</div> -->
			</div>
		</section>
		<div class="wishlist-popup">
											<h4>your item added to wishlist</h4>
										</div>
		<!-- END SHOP PRODUCT -->
		<!-- STARt Regime SECTION-->
		<section class="regime-section">
			<div class="container">
				<h2>Shop by Regime</h2>
				<div class="regime-slider-outer position-relative">
					<div class="swiper-container regime-slider">
						<!-- Additional required wrapper -->
						<div class="swiper-wrapper">
							<?php 
										$counter = 0;
										foreach($regime as $article){
											$articleTitle = substr($article['product_title'], 0, strpos($article['product_title'], "("));
											$wishListData = $this->Public_model->wishListSelectedData($article['id'],$_SESSION['logged_user']);
											$counter++; ?> 
							<div class="swiper-slide">
								<div class="re-image">
									
										<?php  if(!isset($_SESSION['logged_user'])){?>
                                         <div class="wishlist-img wishlist-img-shop-regime">
											<a href="#login" class="fancybox  ad-wish">
                                                <img src="<?= base_url('images/heart.png'); ?>">
                                            </a>
										</div>
                                 		<?php }else{  ?>
										<div id="rgimeWishListAdd<?= $article['id'] ?>" class="wishlist-img  <?php if($article['id'] == $wishListData['product_id']) echo 'active';?>" data-target="add">
											<a href="javascript:void(0);" onclick="regime_add_remove_to_wishlist(<?= $article['id'] ?>)">
											<i class="far fa-heart"></i></a>
										</div>
									<?php  }  ?>

									
									<a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" class=" img-fluid bg-img" alt=""></a>
								</div>
								<div class="re-content">
									<?php if($articleTitle != ''){?>
									<h3><?= $articleTitle ?></h3>
								<?php } else {?>
									<h3><?= $article['product_title'] ?></h3>
									
								<?php } ?>
									
									<a href="<?= LANG_URL . '/' . $article['url'] ?>" class="know-more">Know More</a>
								</div>
							</div>
						<?php } ?>
							
						</div>
					</div>
					<div class="swiper-button-prev regime-prev common-prev"><img src="<?= base_url('images/prev.png') ?>" alt=""/>
					</div>
					<div class="swiper-button-next regime-next common-next"><img src="<?= base_url('images/next.png') ?>" alt=""/>
					</div>
				</div>
			</div>
		</section>
		<!-- END Regime SECTION  -->
		<!-- START CONCERN AREA-->
		<section class="concern-section">
			<div class="container">
				<h2>Shop by concern</h2>
				<div class="concern-slider-outer">
					<div class="swiper-container concern-slider">
						<!-- Additional required wrapper -->
						<div class="swiper-wrapper">
							<?php
     							foreach ($concern as $item) { ?> 
							<div class="swiper-slide">								
								<div class="each-concern-slider">
									<div class="concern-image">								
										<a href="<?= LANG_URL . '/category?type='.$item['category'] ?>"><img src="<?php if($item['concernImage']!="") echo base_url('attachments/concern_images').'/'.$item['concernImage']; else echo base_url('attachments/no-image.png')?>" />
										</a>
									</div>
									<h3><?php echo $item['title']; ?></h3>
								</div>								
							</div>
							<?php } ?>
						</div>

					</div>
					<div class="swiper-button-prev common-prev concern-prev"><img src="<?= base_url('images/prev.png') ?>" alt="">
					</div>
					<div class="swiper-button-next common-next concern-next"><img src="<?= base_url('images/next.png') ?>" alt="">
					</div>
				</div>
			</div>
		</section>
		<!-- END CONCERN AREA -->
		<!-- START SKIN QUIZ SECTION-->
		<div class="login-successfully-message quiz-message">
	        <span class="quiz-message-text"></span> <a href="javascript:void(0)" class="common-button quuiz-close">Close</a>
	    </div>
		<section class="skin-quiz-section" id="skin_quiz">
			<div class="container">
				<div class="row all-qz">
					<div class="col-lg-6 align-self-center">
						<div class="skin-image-area skin-image-height">

							<img src="<?= base_url('attachments/quiz') .'/'.$quizImages['quiz_image'] ?>" alt="" class="w-100">
							
							
							
						</div>
					</div>
					<div class="col-lg-6 align-self-center">
						<div class="skin-content">
							<h2>FREE SKIN ASSESSMENT</h2>
							
							<!-- <h3>Take this short test to know what your skin needs</h3> -->
							<!--<div class="check-box-area">
								<ul>
									<li>
										<input type="radio" id="a-option" name="selector" checked>
										<label for="a-option">17 or younger </label>
										<div class="check"></div>
									</li>
									<li>
										<input type="radio" id="b-option" name="selector">
										<label for="b-option">18-24</label>
										<div class="check">
											<div class="inside"></div>
										</div>
									</li>
									<li>
										<input type="radio" id="c-option" name="selector">
										<label for="c-option">25-34</label>
										<div class="check">
											<div class="inside"></div>
										</div>
									</li>
									<li>
										<input type="radio" id="d-option" name="selector">
										<label for="d-option">35-50</label>
										<div class="check">
											<div class="inside"></div>
										</div>
									</li>
									<li>
										<input type="radio" id="e-option" name="selector">
										<label for="e-option">50 or Older</label>
										<div class="check">
											<div class="inside"></div>
										</div>
									</li>
								</ul>
							</div>
							<a href="" class="common-button">Continue</a> -->
							<div class="step-one">
								<p>Build your skin care routine</p>
								<p>Take this short test to know what your skin needs</p>
								<!-- <p>To help build your skin care routine, we’d like to learn a little more about you At the
									end, we’ll also give you the opportunity to book a 1:1 consultation with one of our
									in-house Skin Care Experts.</p> -->
								<div class="contact-form-wrapper c-form-home ">
									<!-- <form method="post"> -->
										<div class="each-form-field">
											<label>Name *</label>
											<input type="text" placeholder="Name" name="quiz_name" id="quiz_name">
											<p class="wrong_Name" id="wrong_Name">Invalid Name</p>
										</div>
										<div class="each-form-field">
											<label>Your Age *</label>
											<input type="text" placeholder="Your Age" name="quiz_age" id="quiz_age" maxlength="2" onkeypress="return isNumber(event)">
											<p class="wrong_age" id="wrong_age">Please Enter Age</p>
										</div>
										<div class="each-form-field">
											<label>Mobile Number * (Whatsapp)</label>
											<input type="text" placeholder="Mobile Number" name="quiz_number" id
											="quiz_number" maxlength="10" onkeypress="return isNumber(event)">
											<p class="wrong_mobile" id="wrong_mobile">Invalid Mobile Number</p>
										</div>
										<div class="each-form-field">
											<label>Email *</label>
											<input type="email" placeholder="Email" name="quiz_email" id="quiz_email">
											<p class="wrong_email" id="wrong_email">Invalid Email Address</p> 
										</div>
										<?php  if(!isset($_SESSION['logged_user'])){?>
											<div class="each-form-field">
												<a href="#login" class="fancybox">
												<button type="button" id="open-step-2">Continue</button>
												</a>
											</div>
                                
                                 		<?php }else{?>
										<div class="each-form-field">
											<button type="button" id="open-step-2" onclick="skin_quiz()">Continue</button>
										</div>
									<?php } ?>
										<!-- <div class="each-form-field">
											<button type="button" id="open-step-2" onclick="skin_quiz()">Continue</button>
										</div> -->
										<input type="hidden" name="last_insert_id" id="last_insert_id" value="">
										<!-- <input type="hidden" name="concern_type" id="concern_type" class="concern_type" value=""> -->
										<input type="hidden" name="skin_category_type" id="skin_category_type" class="skin_category_type" value="">

									<!-- </form> -->
								</div>
							</div>
							<div class="step-two" style="display:none;">
								<p>Select Your Skin Concern</p>
								<div class="skin-concern">
									<div class="row">
										<div class="col-6">
											<div class="each-screen  qz-step-first" data_screen="fine-lines-wrinkles" onclick="seletConcern('fine-lines-wrinkles')">
												<div class="">
													<img src="<?php echo base_url('attachments/p1.jpg');?>" >
												</div>
												<div class="first-sk-name">Fine Lines & Wrinkles</div>
											</div>
										</div>
										<div class="col-6">
											<div class="each-screen  qz-step-first" data_screen="dullness" onclick="seletConcern('dull-skin')">
												<div class="">
													<img src="<?php echo base_url('attachments/p2.png');?>" >
												</div>
												<div class="first-sk-name" >Dullness</div>
											</div>
										</div>
										<div class="col-6">
											<div class="each-screen  qz-step-first" data_screen="dryness" onclick="seletConcern('dehydrated-skin')">
												<div class="">
													<img src="<?php echo base_url('attachments/p3.jpg');?>" >
												</div>
												<div class="first-sk-name" >Dryness</div>
											</div>
										</div>
										<div class="col-6">
											<div class="each-screen  qz-step-first" data_screen="acne" onclick="seletConcern('acne')">
												<div class="">
													<img src="<?php echo base_url('attachments/p4.png');?>" >
												</div>
												<div class="first-sk-name" >Acne</div>
											</div>
										</div>
										<div class="col-6">
											<div class="each-screen  qz-step-first" data_screen="hair-fall" onclick="seletConcern('hair-fall')">
												<div class="">
													<img src="<?php echo base_url('attachments/p5.png');?>" >
												</div>
												<div class="first-sk-name" >Hair Fall</div>
											</div>
										</div>
										<div class="col-6">
											<div class="each-screen  qz-step-first" data_screen="pigmentation" onclick="seletConcern('Pigmentation')">
												<div class="">
													<img src="<?php echo base_url('attachments/p6.png');?>" >
												</div>
												<div class="first-sk-name" >Pigmentation</div>
											</div>
										</div>
										<input type="hidden" name="skin_concern_name" id="skin_concern_name" value="">
									</div>
									<p class="select_concern" style="display: none;">Please select a Concern</p>
									<div class="each-form-field fast-gap">
										<div class="row">
											<div class="col-6">
												<button type="button " class="greay previous-one">Previous</button>
											</div>
											<div class="col-6 text-right">
												<button type="button " class="with-out-select-one">Continue</button>
												<button type="button" class="go-third-step" style="display:none">Continue</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="step-three" style="display:none;">
								<h3 class="concern">Your skin Type</h3>
								<p>Select Specified Concern</p>
								<div class="skin-concern">
									<div class="row justify-content-md-center">
										
										<div class="col-6 gp-bottom common-sc-screen pigmentation" >
											<div class="each-screen  qz-step-sccond"  >
												<div class="text-center sk-big"   onclick="specified('DarkSpots')">
													Dark Spots
												</div>
											</div>
										</div>																		
										<div class="col-6  gp-bottom common-sc-screen pigmentation" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big"  onclick="specified('UnevenSkinTone')">
													Uneven Skin Tone
												</div>
											</div>
										</div>

										<div class="col-6 gp-bottom common-sc-screen pigmentation" >
											<div class="each-screen  qz-step-sccond">
												<div class="text-center sk-big"  onclick="specified('Blemishes')">
													Blemishes
												</div>
											</div>
										</div>	
										<!-- ***************** -->
										<div class="col-6 gp-bottom common-sc-screen fine-lines-wrinkles" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('Dehydration')">
													Dehydration
												</div>
											</div>
										</div>
										<div class="col-6  gp-bottom common-sc-screen fine-lines-wrinkles">
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('Fine Lines')">
													Fine Lines
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom common-sc-screen fine-lines-wrinkles"  >
											<div class="each-screen  qz-step-sccond" >
												<div  class="text-center sk-big" onclick="specified('Wrinkles')">
													Wrinkles
												</div>
											</div>
										</div>
										<!-- *************** -->
										<div class="col-6 gp-bottom common-sc-screen dullness" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('dullLacklustreSkin')">
													Dull or Lacklustre skin
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom common-sc-screen dullness" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('roughBumpySkin')">
													Rough or Bumpy skin
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom common-sc-screen dullness">
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('tiredDrabComplexion')">
													Tired & Drab complexion
												</div>
											</div>
										</div>
										<!-- *************** -->
										<div class="col-6 gp-bottom common-sc-screen acne">
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('Blackheads')">
													Blackheads
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom common-sc-screen acne" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('ExcessSebumOil')">
													Excess Sebum/Oil
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom common-sc-screen acne" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('Whiteheads')">
													Whiteheads
												</div>
											</div>
										</div>
										<!-- *************** -->
										<div class="col-6 gp-bottom common-sc-screen hair-fall" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('TriggeredStress')">
													Triggered by stress
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom common-sc-screen hair-fall" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('DueEnvironmentalFactors')">
													Due to Environmental Factors

												</div>
											</div>
										</div>
										<!-- *************** -->
										<div class="col-6 gp-bottom common-sc-screen dryness" >
											<div class="each-screen  qz-step-sccond"  >
												<div  class="text-center sk-big" onclick="specified('DrynessOnFace')">
													Dryness on the Face
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom common-sc-screen dryness"  >
											<div class="each-screen  qz-step-sccond" >
												<div  class="text-center sk-big" onclick="specified('DrynessOnBody')">
													Dryness on the Body
												</div>
											</div>
										</div>
										
										<!-- /**************************/ -->
										<input type="hidden" name="specified_type" id="specified_type" class="specified_type" value="">
									</div>
									<p class="select_concern specifiedConcern" style="display: none;">Select Specified Concern</p>
									<div class="each-form-field space2">
										<div class="row">
											<div class="col-6">
												<button type="button " class="greay previous-two">Previous</button>
											</div>
											<div class="col-6 text-right">
												<button type="button " class="with-out-select-two">Continue</button>
												<button type="button" class="go-forth-step" style="display:none">Continue</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="step-four" style="display:none;">								
								<p>Select Your Skin Type:</p>
								<div class="skin-concern">
									<div class="row justify-content-md-center">
										<div class="col-6 gp-bottom " >
											<div class="each-screen qz-step-third ">
												<div class="text-center sk-big" onclick="skin_type('Dry')">
													Dry
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom" >
											<div class="each-screen  qz-step-third"  >
												<div class="text-center sk-big" onclick="skin_type('Combination')">
													Combination
												</div>
											</div>
										</div>									<div class="col-6  gp-bottom" >
											<div class="each-screen  qz-step-third"  >
												<div  class="text-center sk-big" onclick="skin_type('Normal')">
													Normal
												</div>
											</div>
										</div>									
										<div class="col-6  gp-bottom" >
											<div class="each-screen  qz-step-third"  >
												<div  class="text-center sk-big" onclick="skin_type('Oily')">
													Oily
												</div>
											</div>
										</div>	
										<!-- ***************** -->
										<input type="hidden" name="skin_type_h" id="skin_type_h" class="skin_type_h" value="">
									</div>
									<p class="select_concern SkinType" style="display: none;" id="SkinType">Select Your Skin Type</p>
								</div>
								<p>Is your skin</p>
								<div class="skin-concern">
									<div class="row justify-content-md-center">
										<div class="col-6 gp-bottom">
											<div class="each-screen qz-step-forth ">
												<div class="text-center sk-big" onclick="your_skin('Sensitive')">
													Sensitive
												</div>
											</div>
										</div>
										<div class="col-6 gp-bottom">
											<div class="each-screen qz-step-forth "  >
												<div class="text-center sk-big" onclick="your_skin('Normal')">
													Normal
												</div>
											</div>
										</div>										
										<!-- /**************************/ -->
										<input type="hidden" name="nsk" id="nsk" class="nsk" value="Select Your Skin Type">
										<input type="hidden" name="your_skin_type" id="your_skin_type" class="your_skin_type" value="">
									</div>
									<p class="select_concern IsSkin" style="display: none;" id="IsSkin">Select  Is Skin</p>
									<div class="each-form-field last-step space3">
										<div class="row">
											<div class="col-6">
												<button type="button " class="greay previous-three">Previous</button>
											</div>
											<div class="col-6 text-right">
												<button type="button " class="with-out-select-three">Continue</button>
												<button type="button" class="go-fifth-step  " style="display:none" onclick="quiz_product()">Continue</button>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<!-- ************************** -->
				<div class="fifte-step" style="display:none;">
					<div class="st-top-part" id="quizProduct">
						<span class="st-top-part-close">X</span>
						<h3>Concern: <span class="concern"></span></h3>
						<h3>Specified Concern: <span class="specified"></span></h3>
						<h3>Skin Type: <span class="skin-type"></span></h3>
						<h3>Skin Sensitivity: <span class="skin"></span></h3>
					</div>
					<div id="" class="skin-concern">
						<div class="common-sc-screen  quiz_products_list">
							<div class="quiz-product">
								<!-- <div class="row">
									
									<div id="quizproduct">
									
                                	</div>
									<div class="col-lg-12 text-center mt-4 product-add-to-cart">
										<a href="javascript:void(0)" class="common-button btn-add-cart-list " >Add to cart</a>									
									</div>
								</div> -->
								<p class="no_quiz_product" style="display: none;"></p>
							</div>
							<!-- <div class="quiz-p-price">
								<p>We have suggested the entire Enlite regime for you, crafted especially for your concerns.</p>
								<h3>The total price: 2645</h3>
								<h3>Our Price:  <del>2645</del>  <span class="gn">2450</span></h3>
							</div> -->
							<div class="qz-bottom">
								Book a 1-on-1 online consultation with one of our Dermatologists. <span data-toggle="modal" data-target="#doctor-popup"><a href="javascript:void(0)" class="line-border"  data-placement="top" title="BOOK NOW">BOOK NOW</a></span>
								<span ><a href="javascript:void(0)" class="line-border scroll_skin_quiz" onclick="take_another_test()">Take Another Test</a></span>
							</div>
							<!-- <div class="qz-bottom">
							<a href="javascript:void(0)" class="common-button btn-add-cart-list" onclick="take_another_test()">Take Another Test</a>
						</div> -->
								<!-- <div class="add-quiz-price price_none'.$category_type.'">
								<p>Total Regime Price</p>
								<h4><strong>₹'.$buy_price.'</strong><del>₹'.$price.'</del></h4>
								</div> -->
						</div>
						
						
					</div>
				</div>
				<!-- ************************** -->
			</div>
		</section>
		<!-- END SKIN QUIZ SECTION-->
		<!-- START TESTIMONIAL SECTION -->
		<section class="testimonial-section">
			<div class="container">
				<h2>Customer’s Testimonials</h2>
				<div class="testimonial-slider-outer">
					<div class="swiper-container testimonial-slider">
						<!-- Additional required wrapper -->
						<div class="swiper-wrapper">
							<?php
     							foreach ($testimonial as $item) { ?> 
							<div class="swiper-slide">
								<div class="each-teestimonial">
									<div>
										<a href="<?php echo $item['link'] ? $item['link'] : 'javascript:void(0)';?>" target="<?php echo $item['link'] ? '_blank' : '';?>">
										<div class="testimonial-image-area">
											<img src="<?php if($item['image']!="") echo base_url('attachments/testimonial_images').'/'.$item['image']; else echo base_url('attachments/no-image.png')?>" />
										</div>
										<div class="testimonial-title-area">
											<h3><?php echo $item['name']?></h3>
											<h4><?php echo $item['designation']?></h4>
										</div>
										<div class="quote-area">
											<img src="<?= base_url('images/quote.png') ?>" alt="">
										</div>
										<div class="testimonial-content">
											<p><?php echo $item['description']?>
												.</p>
										</div>
									</a>
									</div>
								</div>
							</div>
						<?php } ?>
							<!-- <div class="swiper-slide">
								<div class="each-teestimonial">
									<div>
										<div class="testimonial-image-area">
											<img src="<?= base_url('images/testimonial-2.png') ?>" alt="">
										</div>
										<div class="testimonial-title-area">
											<h3>Bishakha Das</h3>
											<h4>Student</h4>
										</div>
										<div class="quote-area">
											<img src="<?= base_url('images/quote.png') ?>" alt="">
										</div>
										<div class="testimonial-content">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
												tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
												veniam,
												quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
												consequat. Duis aute ivelit esse cillum dolore eu fugiat nulla pariatur.
												.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="each-teestimonial">
									<div>
										<div class="testimonial-image-area">
											<img src="<?= base_url('images/testimonial-3.png') ?>" alt="">
										</div>
										<div class="testimonial-title-area">
											<h3>Shilpa Ganguli</h3>
											<h4>Student</h4>
										</div>
										<div class="quote-area">
											<img src="<?= base_url('images/quote.png') ?>" alt="">
										</div>
										<div class="testimonial-content">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
												tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
												veniam,
												quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
												consequat. Duis aute ivelit esse cillum dolore eu fugiat nulla pariatur.
												.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="each-teestimonial">
									<div>
										<div class="testimonial-image-area">
											<img src="<?= base_url('images/testimonial-4.png') ?>" alt="">
										</div>
										<div class="testimonial-title-area">
											<h3>Dibakar Gupta</h3>
											<h4>actor</h4>
										</div>
										<div class="quote-area">
											<img src="<?= base_url('images/quote.png') ?>" alt="">
										</div>
										<div class="testimonial-content">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
												tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
												veniam,
												quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
												consequat. Duis aute ivelit esse cillum dolore eu fugiat nulla pariatur.
												.</p>
										</div>
									</div>
								</div>
							</div> -->
						</div>
					</div>
					<div class="swiper-pagination testimonial-pagination"></div>
					<div class="swiper-button-prev testimonial-prev common-prev"><img src="<?= base_url('images/prev.png') ?>"
							alt=""></div>
					<div class="swiper-button-next testimonial-next common-next"><img src="<?= base_url('images/next.png') ?>"
							alt=""></div>
				</div>
			</div>
		</section>
		<!-- END TESTIMONIAL SECTION-->
		<!-- START BLOG SECTION -->
		<section class="our-blog">
			<div class="container">
				<h2>Our Blog</h2>
				<div class="each-slide">
                    <div class="swiper-container blog-slider">
					<div class="swiper-wrapper">
					<?php
     					foreach ($lastBlogs as $blog) { ?>
					<div class="swiper-slide ">
						<div class="each-blog">
							<div class="blogimage">
								<a href="<?= LANG_URL . '/blog/' . $blog['url'] ?>">
								<img src="<?php if($blog['image']!="") echo base_url('attachments/blog_images').'/'.$blog['image']; else echo base_url('attachments/no-image.png')?>" />
								</a>			
							</div>
							<div class="blog-content">
								<h5><?php echo date('F j, Y', $blog['time']);?></h5>
								<h3 class="min-height"><a href="<?= LANG_URL . '/blog/' . $blog['url'] ?>"><?php echo $blog['title'];?></a></h3>
								<a href="<?= LANG_URL . '/blog/' . $blog['url'] ?>" class="more-blog">Read MORe <img src="<?= base_url('images/down-arrow.png') ?>"
										alt=""></a>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>
				</div>
					<!-- <div class="col-md-6 col-lg-3">
						<div class="each-blog">
							<div class="blogimage">
								<img src="<?= base_url('images/2.jpg') ?>" alt="">
							</div>
							<div class="blog-content">
								<h5>February 10, 2023</h5>
								<h3><a href="">Why should you add Vitamin C to your Routine</a></h3>
								<a href="" class="more-blog">Read MORe <img src="<?= base_url('images/down-arrow.png') ?>"
										alt=""></a>
							</div>
						</div>
					</div> -->
					<!-- <div class="col-md-6 col-lg-3">
						<div class="each-blog">
							<div class="blogimage">
								<img src="<?= base_url('images/3.jpg') ?>" alt="">
							</div>
							<div class="blog-content">
								<h5>February 10, 2023</h5>
								<h3><a href="">Why should you add Vitamin C to your Routine</a></h3>
								<a href="" class="more-blog">Read MORe <img src="<?= base_url('images/down-arrow.png') ?>"
										alt=""></a>
							</div>
						</div>
					</div> -->
					<!-- <div class="col-md-6 col-lg-3">
						<div class="each-blog">
							<div class="blogimage">
								<img src="<?= base_url('images/4.jpg') ?>" alt="">
							</div>
							<div class="blog-content">
								<h5>February 10, 2023</h5>
								<h3><a href="">Why should you add Vitamin C to your Routine</a></h3>
								<a href="" class="more-blog">Read MORe <img src="<?= base_url('images/down-arrow.png') ?>"
										alt=""></a>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</section>
		<!-- END BLOG SECTION-->
		<!-- START community SECTION -->
		<!-- <section class="community-section">
			<div class="container">
				<h2><img src="<?= base_url('images/site-logo.png') ?>" alt=""> community</h2>
				<h3>The community of skin lovers</h3>
				<div class="row">
					<div class="col-lg-4">
						<div class="each-community">
							<div class="community-image"><img src="<?= base_url('images/beauty.png') ?>" alt=""></div>
							<p>Enjoy unique products and experiences.</p>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="each-community">
							<div class="community-image"><img src="<?= base_url('images/beauty-copy.png') ?>" alt=""></div>
							<p>Learn to take care of your skin with best experts.</p>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="each-community">
							<div class="community-image"><img src="<?= base_url('images/beauty-copy-3.png') ?>" alt=""></div>
							<p>Find out about latest news before anyone else!</p>
						</div>
					</div>
				</div>
			</div>
		</section> -->
		<!-- END community SECTION-->
		<!-- START Instagrum -->
		<!-- <section class="instragram-area">
			<div class="container">
				<h3>LEARN MORE ABOUT YOUR SKIN BY <br> FOLLOWING US ON INSTAGRAM</h3>
				<div class="instragram-block">
					<div class="row">
						<div class="col-lg-3 col-6">
							<div class="each-story">
								<img src="<?= base_url('images/1.jpg') ?>" border="0" alt="" class="w-100">
							</div>
						</div>
						<div class="col-lg-3 col-6">
							<div class="each-story">
								<img src="<?= base_url('images/2.jpg') ?>" border="0" alt="" class="w-100">
							</div>
						</div>
						<div class="col-lg-3 col-6">
							<div class="each-story">
								<img src="<?= base_url('images/2.jpg') ?>" border="0" alt="" class="w-100">
							</div>
						</div>
						<div class="col-lg-3 col-6">
							<div class="each-story">
								<img src="<?= base_url('images/4.jpg') ?>" border="0" alt="" class="w-100">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> -->
		<section class="instragram-area">
			<div class="container">
				<div class="instragram-block" style="background:#fff;">
					<div class="row no-gutters">
						<div class="col-lg-6">
							<div class="each-story">
								<img src="<?= base_url('images/1.jpg') ?>" border="0" alt="" class="w-100">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="instragram-content pt-5 pb-5 d-flex align-items-center justify-content-center text-center h-100">
								<div id="" class="">
									<img src="<?= base_url('images/pngegg.png') ?>" border="0" alt="" class="">
									<h3 class="mb-5">LEARN MORE ABOUT YOUR SKIN BY <br> FOLLOWING US ON INSTAGRAM</h3>
									<a href="<?= $footerSocialInstagram ?>" class="common-button" target="_blank">Follow</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- END Instagrum-->
		<!-- START Store Locator -->
		<section class="store-locator" id="scorll-hear">
			<div class="location-top">
				<div class="container">
					<h2>Store Locator</h2>
					<div class="location-search">
						<div>
							<div><input type="text" class="search-field" placeholder="Enter your PIN code" id="pincode"></div>
							<div><input type="button" value="Enter your pin code" class="btn-submit" onclick="searchStore()" autocomplete="off"></div>
						</div>
						<p id="noStoreFound" class="noStoreFound" style="display: none;"></p>
					</div>
				</div>
			</div>

			<div class="location-bottom cover" id="storeDataDiv">

			</div>
			<div class="location-bottom store_locatorss cover" id="storeDataDivFst">
				<div class="container">
					<div class="row">
						
						<div class="col-lg-6 l-details">
							<div class="each-slide ">							
							<?php 
     					foreach ($storeLocator as $row)
     					{  ?>	
     					<a href="javascript:void(0)" class="more-blog more_store" data-target="<?php echo $row['storeLocatorID']; ?>">						
							<div class="each-location ">
								
								<h3><?php echo $row['store_name']; ?></h3>
								<p><?php echo $row['store_address']; ?>,<?php echo $row['store_city']; ?>,<?php echo $row['store_state']; ?>,<?php echo $row['store_pincode']; ?></p>
								<!-- <p class="call-l"><a href="tel:09007574000">09007574000</a></p> -->
								Select <img src="<?= base_url('images/down-arrow.png') ?>" alt="">
							</div>
							</a>
							<?php } ?>
						
						</div>
						
						</div>
					
						<div class="col-lg-6 map-area" id="fstStoreMaps">
							<div class="map">
								<iframe 
									src="https://maps.google.com/maps?q=<?php echo $storeLocator[0]['store_latitude']?>,<?php echo $storeLocator[0]['store_longitude']?>&hl=es;z=14&amp;output=embed"
									width="600" height="450" style="border:0; margin-top: -150px;" allowfullscreen="" loading="lazy"
									referrerpolicy="no-referrer-when-downgrade"></iframe>
							</div>
						</div>
						<div class="col-lg-6 map-area" id="secStoreMaps" style="display: none;">
							
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- END Store Locator -->
		