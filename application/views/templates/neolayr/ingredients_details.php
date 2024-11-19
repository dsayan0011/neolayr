<main>
			<!-- BLOG DETAILS PAGE-->
			<!-- START BANNER -->
			<section class="inner-banner-section position-relative">
				<img src="<?= base_url('attachments\ingredientImages').'/'.$ingredients['ingredientImage'] ?>" width="100%" height="auto" border="0" alt="">				
			</section>
			<!-- END BANNER  -->
			<section class="blog-details-page">
				<div class="container">					
					<div class="inc-intro">
						<p><?php echo $ingredients['shortDescription']?> <br><strong><?php echo $ingredients['title']?></strong></p>
					</div>
					
					<div class="blog-details-content inc-content">
						<div class="row">
							<div class="col-lg-8">
								<div class="blog-details-content-left ">									
									<div class="blog-detailed-content" style="padding-left:0px;">	
										<?php echo $ingredients['longDescription']?>
									</div>
								</div>
							</div>
							<div class="col-lg-4 blog-listing-area">
								<?php $result = $this->Products_model->getProductsBySKU($ingredients_product);
									foreach ($result as $key => $value) {
									
								?>
								<div class="each-listing-of-product">
									<div class="product-image">
										<!-- <a href="<?= LANG_URL . '/' . $value['url'] ?>"> -->
											<a href="<?= LANG_URL . '/' . $value['url'] ?>">
										<img src="<?= base_url('/attachments/shop_images/' . $value['image']) ?>" border="0" alt="" class="w-100">
									</a>
									<!-- </a> -->
									</div>
									<div class="product-short-decription text-center">
										<p><?= character_limiter($value['title'], 20) ?></p>
									</div>
									<div class="product-price-and-description text-center">
										<a href="javascript:void(0)" class="btn-add-cart-list home_cart<?php echo $value['id'] ?>" data-id="<?= $value['id'] ?>" data-key="<?= $value['id'] ?>">ADD to cart <span>| </span> <?php if($value['default_price'] != '0') echo CURRENCY.number_format($value['default_price'], 2); else echo 'Coming soon' ?></a>
										<a href="<?= base_url('shopping-cart') ?>" class="common-button go_to_cart<?php echo $value['id'] ?>" style='display: none;'>Go to Cart</a>
									</div> 
									<!-- <div class="view-more-button text-center mt-4">
										<a href="<?= LANG_URL . '/' . $value['url'] ?>" class="common-button">View More</a>
									</div> -->
									<div class="view-more-button text-center mt-4">
										<a href="<?= LANG_URL . '/category?ingredients='.$ingredients['ingredients_id'] ?>" class="common-button">View More</a>
									</div>
								</div>	
								<?php } ?>							
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- END:BLOG DETAILS PAGE-->
			
			<!-- END FOOTER-->
		</main>