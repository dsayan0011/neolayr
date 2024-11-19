<main>
			<!-- START BANNER -->
			<section class="inner-banner-section position-relative">
				<img src="<?= base_url('attachments\ingredient_banner').'/'.$ingredients_banner['ingredient_banner_image'] ?>" border="0" alt="" class="w-100">
				<div class="inner-page-banner-content position-absolute">
					<div class="container d-flex align-items-center">
						<h1><?php echo $ingredients_banner['banner_title']?></h1>
					</div>
				</div>
			</section>
			<!-- END BANNER  -->
			<!-- INGREDIENTS -->
			<section class="ingredients-area">
				<div class="container">
					<p>Neolayr Pro is a bouquet of carefully crafted products with proven benefits of well-researched ingredients, which improves skin’s health. The brand contains ingredients that the skin is compatible with and which further supports the integrity of the formulation.</p>
					<h2>Glossary</h2>
					<div class="alphabatical-listing">
						<div class="card-columns">
							<?php  
							foreach ($ingredients as $letter => $values) { ?>
									<div class="card">  
										<div class="each-alphabetical-area">
											<h5><?php   echo  $letter; ?></h5>	
											<ul>
										 <?php 
									    foreach ($values as $value) { ?>
									        	<li><a href="<?= LANG_URL . '/ingredient_details'.'/'.$value['ingredientsID'] ?>" style="color:inherit"><?php echo $value['ingredientsTitle']; ?></a></li>
									        <?php } ?>
									</ul>
										</div>
										
									</div>
							<?php } ?>

							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- End:INGREDIENTS -->
	 