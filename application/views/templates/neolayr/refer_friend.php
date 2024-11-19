
<main>
			<!-- PERSONAL INFO PAGE -->
			<section class="personal-info">
				<div class="container">
					<div class="personal-information text-center">
						<div class="personal-info-image mx-auto">
							<img src="<?= base_url('images/user-5.png') ?>" border="0" alt="">
						</div>
						<p>Hello</p>
						<h2><?php echo $userInfo['name'];?></h2>
					</div>
					<div class="personal-info-detailed-content row no-gutters flex-row-reverse">
						
						<div class="personal-info-detailed-content-right col-lg-8">
							<div class="label-area d-flex justify-content-between">
								<h4>Refer Friends</h4>
							</div>
							<div class="refer-friends">
								<p>Share a link to give your friend a coupon of 15% off on minimum order of ₹500 & above and you earn 500 procoins if he/she purchases using the coupon </p>
								<ul>
									<li><a href="javascript:void(0)" onclick="openWhatsApp('https://wa.me/?text=Hi, I am using skincare products from Neolayr Pro and highly recommend. You can use this link and get 15% OFF on your purchase. Thanks. <?= LANG_URL . '/' ?>?referral=<?php echo $userInfo['own_referral']?>')"><img src="<?= base_url('images/whatsapp.png') ?>" width="78" height="78" border="0" alt=""></a></li>

									<li><a href="https://www.facebook.com/sharer.php?u=https://neolayrpro.com/?referral=<?php echo $userInfo['own_referral']?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook"><img src="<?= base_url('images/facebook.png') ?>" width="78" height="78" border="0" alt=""></a></li>

									<li><a href="https://www.instagram.com/"><img src="<?= base_url('images/Instagram.png') ?>" width="78" height="78" border="0" alt="" target="_blank"></a></li>

									<li><a href="https://twitter.com/intent/tweet?url=https://neolayrpro.com/?referral=<?php echo $userInfo['own_referral']?>&text=<?php echo urlencode('referral'); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank"><img src="<?= base_url('images/twitter.png') ?>" width="78" height="78" border="0" alt=""></a></li>

									

									

									

									<!-- <li><a href="https://www.pinterest.com/join/?next=/pin/create/button/&url=https://neolayrpro.com/?referral=<?php echo $userInfo['own_referral']?>"><img src="<?= base_url('images/pinterest.png') ?>" width="78" height="78" border="0" alt=""></a></li> -->

									<!-- <li><a href="mailto:?subject=[neolayrpro]&body=[https://neolayrpro.com/?referral=<?php echo $userInfo['own_referral']?>]"><img src="<?= base_url('images/mail.png') ?>" width="78" height="78" border="0" alt=""></a></li> -->
								</ul>
								<p>or copy the link and share it anywhere</p>
								<a href="javascript:void(0)" class="reward-link" id="clickCopy" onclick="clickCopy();"><?php echo base_url();?>?referral=<?php echo $userInfo['own_referral']?> <img src="<?= base_url('images/PEPPER.png') ?>" width="21" height="25" border="0" alt=""></a>
								<p class="text-copy" style="display: none;">Copied</p>
								<div id="goodContent" style="display: none;">
								<?php echo base_url();?>?referral=<?php echo $userInfo['own_referral']?>
								</div>
							</div>
							
						</div>
						<div class="personal-info-detailed-content-left col-lg-4">
                            <ul>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
                                        <li><a href="<?= LANG_URL . '/manage-address' ?>">Manage address</a></li>
                                    </ul>
                                </li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy.png') ?>" width="25" height="25" border="0" alt=""></span>Order history</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/orders' ?>"> MY ORDERS</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= LANG_URL . '/users/wishlist' ?>"><span><img src="<?= base_url('images/user-6-copy-4.png') ?>" width="23" height="21" border="0" alt=""></span>Wishlist</a></li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy-6.png') ?>" width="23" height="23" border="0" alt=""></span>Rewards</a>
                                    <ul style="display:block">
                                        <li><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
                                        <li class="active"><a href="<?= LANG_URL . '/refer-friend' ?>">Refer friends</a></li>
                                    </ul>
                                </li>
                                 <!-- <li><a href="<?= LANG_URL . '/users/gift' ?>"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="23" border="0" alt=""></span>Gift Voucher</a></li> -->
                                 <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="25" border="0" alt=""></span>Gift Voucher</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/gift' ?>">Gift Card</a></li>
                                        <li><a href="<?= LANG_URL . '/gift-card-details' ?>">Gift Card Details</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= LANG_URL . '/users/logout' ?>"><span><img src="<?= base_url('images/user-6-copy-8.png') ?>" width="21" height="23" border="0" alt=""></span>Logout</a></li>
                            </ul>
                        </div>
					</div>
				</div>
			</section>
			<!-- END:PERSONAL INFO PAGE -->
			<!-- SITE FOOTER-->
			
			<!-- END FOOTER-->
		</main>