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
								<h4>Manage Address</h4>
								
							</div>
							<?php if(sizeof($user_address)> 0){?>
							<div class="row address-list" >
								<?php foreach ($user_address as $value) {
									
								 ?>
								<div class="col-lg-6">
									<div class="edit-address">
										<p><strong><?php echo $value['first_name'];?> <?php echo $value['last_name'];?></strong><a href="<?= LANG_URL . '/edit-address/'.$value['address_id'] ?>">Edit</a></p>
										<p><?php echo $value['phone'];?><br><?php echo $value['address'];?><br> <?php echo $value['post_code'];?>,India</p>
										<div class="remove-address">
											<a href="javascript:void(0)" onclick="deleteShippingAddress(<?=$value['address_id'];?>)">Remove</a>
										</div>
									</div>
								</div>
							<?php } ?>
								<!-- <div class="col-lg-6">
									<div class="edit-address">
										<p><strong>Debesh Samanta</strong><a href="edit-address.html">Edit</a></p>
										<p>7098500276<br>81/2 Dr. S R C Banerjee Road<br>Kolkata,West Bengal 700010,India</p>
										<div class="remove-address">
											<a href="">Remove</a>
										</div>
									</div>
								</div> -->
							</div>
							<?php } else{?>
								<span>No data found!!</span>
							<?php } ?>
							<div class="each-feild">
								<a href="<?= LANG_URL . '/add-address' ?>">
								<button type="submit" class="gn-button small new-input-style">+ Add new address</button></a>
							</div>
						</div>
						<div class="personal-info-detailed-content-left col-lg-4">
							<ul>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                                    <ul style="display:block">
                                        <li><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
                                        <li class="active"><a href="<?= LANG_URL . '/manage-address' ?>">Manage address</a></li>
                                    </ul>
                                </li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy.png') ?>" width="25" height="25" border="0" alt=""></span>Order history</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/orders' ?>">MY ORDERS</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= LANG_URL . '/users/wishlist' ?>"><span><img src="<?= base_url('images/user-6-copy-4.png') ?>" width="23" height="21" border="0" alt=""></span>Wishlist</a></li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy-6.png') ?>" width="23" height="23" border="0" alt=""></span>Rewards</a>
                                    <ul>
                                       <li><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
                                        <li><a href="<?= LANG_URL . '/refer-friend' ?>">Refer friends</a></li>
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
			
		</main>