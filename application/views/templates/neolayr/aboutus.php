<style type="text/css">
.aboutUs-banner img{
	width: 100%;
}
</style>

<main>
			<!-- PERSONAL INFO PAGE -->
			<div class="for-about-us-page">
				<?php if(sizeof($aboutUsBanner)>0){?>
				<section>
					<div class="swiper-container aboutUs-banner">
						<div class="swiper-wrapper">
							<?php
		     					foreach ($aboutUsBanner as $row) { 
					     		$u_path = 'attachments/aboutUsBanner/';
								if ($row->image != null && file_exists($u_path . $row->image)) {
									$image = base_url($u_path . $row->image);
								} else {
									$image = base_url('attachments/no-image.png');
								} 

								if ($row->mob_image != null && file_exists($u_path . $row->mob_image)) {
									$mob_image = base_url($u_path . $row->mob_image);
								} else {
									$mob_image = base_url('attachments/no-image.png');
								}?>
							<div class="swiper-slide">
								<picture>
									<source media="(min-width:1024px)" class="imageResponsive" srcset="<?= $image ?>">
		                            <img class="imageResponsive" src="<?= $mob_image ?>" alt="" >
		    					</picture>
							</div>
							<?php } ?>
						</div>
						<div class="swiper-pagination"></div>
			
				</div>
					<!-- <img src="<?= base_url('/attachments/aboutus/' . $aboutUs['banner_image']) ?>" width="100%" height="auto" border="0" alt=""> -->
				</section>
			<?php } ?>
				<section class="personal-info">
					<div class="container">
						<div class="personal-information text-center">						
							<h1>About Us</h1>
						</div>					
					</div>
				</section>
				<section class="skin-quiz-section">
					<div class="container">
						<div class="row">
							<div class="col-lg-6">
								<div class="skin-image-area">
									
									<img src="<?= base_url('/attachments/aboutus/' . $aboutUs['origin_image']) ?>" class="skin-left mw-100" alt="">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="skin-content">
									<h2>The Origin Story</h2>
									<?= $aboutUs['origin_story']; ?>							
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="md-text">
					<div class="container">
						<div class="skin-content text-center">
							<h2>Why Is NEOLAYR PRO The Best?</h2>
							<?= $aboutUs['neo_pro_best']; ?>							
						</div>
					</div>
				</section>
				<section class="r-imaage-area">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 align-self-center">
								<div class="skin-content">
									<h2>The Expertise of Palsons Derma</h2>
									<?= $aboutUs['expertise']; ?>							
								</div>
							</div>
							<div class="col-lg-6">
								<img src="<?= base_url('/attachments/aboutus/' . $aboutUs['expertise_image']) ?>" width="100%" height="auto" border="0" alt="">
							</div>
						</div>
					</div>
				</section>
				<section class="ab-icon-area">
					<div class="container">
						<div class="skin-content text-center">
							<h2>Quality: The NEOLAYR PRO Way</h2>
							<?= $aboutUs['pro_way']; ?>							
						</div>
						<div class="row about-icon-area" >
							<div class="col-4">
								<img src="<?= base_url('images/ab8.png') ?>" width="582" height="127" border="0" alt="">
							</div>
							<div class="col-4">
								<img src="<?= base_url('images/ab6.jpg') ?>" width="199" height="159" border="0" alt="">
							</div>
							<div class="col-4">
								<img src="<?= base_url('images/ab7.jpg') ?>" width="176" height="149" border="0" alt="">
							</div>
						</div>
					</div>
				</section>
				<section class="skin-quiz-section">
					<div class="container">
						<div class="row">
							<div class="col-lg-6">
								<div class="skin-image-area">
									<img src="<?= base_url('/attachments/aboutus/' . $aboutUs['dermatologically_image']) ?>" class="skin-left about-skin-left">
									
								</div>
							</div>
							<div class="col-lg-6 align-self-center">
								<div class="skin-content">
									<h2>Dermatologically Tested</h2>
									<?= $aboutUs['dermatologically_tested']; ?>						
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<!-- END:PERSONAL INFO PAGE -->
			
		</main>