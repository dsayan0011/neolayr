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
						
						<div class="personal-info-detailed-content-right invoice-details col-lg-8">
							<div class="label-area d-flex justify-content-between">
								<h4>earn points</h4>
							</div>
							<div class="earn-area">								
								<div class="row">
									<div class="col-lg-6">
										<div class="earn-box">
											<div class="earn-box-top">
												<p><img src="<?= base_url('images/credit-card.png') ?>" width="27" height="19" border="0" alt=""> Make a purchase</p>
											</div>
											<div class="earn-box-bottom">
												1 point per ₹1
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="label-area d-flex justify-content-between">
								<h4>Reward History</h4>
							</div>							
							<div class="reward-history">
								<div class="row">
									<div class="col-lg-5">
										<div class="reward-history-box">
											<div class="histry-top">
												<img src="<?= base_url('images/histry-icon.png') ?>" width="15" height="27" border="0" alt="">Points Earned
											</div>
											<div class="histry-bottom">
												<?php if($reward_details['totalEarnPoint'] >= 1){?>
													<p><?php echo $reward_details['totalEarnPoint']?><sup>Pts.</sup></p>
												<?php } else { ?>
													<p>0<sup>Pts.</sup></p>
												<?php }?>
											</div>
										</div>
									</div>
								</div>
								<ul class="reward-list">
									<li>
										<p>
											<?php if($reward_details['totalEarnPoint'] >= 1){?>
												<strong><?php echo $reward_details['totalEarnPoint']?></strong>
												<sup>Pts.</sup>
												<br> Earned
											<?php } else { ?>
												<strong>0</strong>
												<sup>Pts.</sup>
												<br> Earned
											<?php }?>
										</p>
									</li>
									<li>
										<p>
											<?php if($reward_details['redeem_point'] >= 1){?>
											<strong><?php echo $reward_details['redeem_point']?></strong>
											<sup>Pts.</sup>
											<br> Redeemed
											<?php } else { ?>
												<strong>0</strong>
											<sup>Pts.</sup>
											<br> Redeemed
											<?php }?>
										</p>
									</li>
									<li>
										<p><strong><?php echo $reward_details['balancePont'] + $reward_details['bonusPoint']?></strong><sup>Pts.</sup><br> Available</p>
									</li>

									<li>
										<p><strong>₹<?php echo (($reward_details['balancePont'] + $reward_details['bonusPoint']) * $tier['pointPercentage']);?></strong><!--<sup>Pts.</sup>--><br> Available</p>
									 </li>									 
								</ul>
							</div>
							<div class="label-area d-flex justify-content-between">
								<h4>Tiers</h4>
							</div>	
							<div class="tire-label">
								<div class="tire-label-line">
									<ul>
										<li><p>&nbsp;</p></li>
										<li><p>5000<sup>pts</sup></p></li>
										<li><p>10000<sup>pts</sup></p></li>
										<li><p>10000+<sup>pts</sup></p></li>										
									</ul>
								</div>
								<div class="label-body">
									<div class="lable-gradient" style="width:<?php echo $percent_reward;?>%"></div>
								</div>
								<div class="row lable-bottom">
									<div class="col-4">
										<p>INSIDER</p>
									</div>
									<div class="col-4">
										<p>Ace</p>
									</div>
									<div class="col-4">
										<p>Pro</p>
									</div>
								</div>
							</div>
							<div class="tiers-list">
								<div class="row">
									<div class="col-lg-6">
										<div class="each-tier">
											<div class="tier-top <?php if($reward_details['tier'] == '1') echo 'active' ?>">
												INSIDER
											</div>
											<div class="tier-content">
												<p>Privilege member benefits</p>
												<table>
													<tr>
														<td><img src="<?= base_url('images/credit-card.png') ?>" width="27" height="19" border="0" alt=""></td>
														<td>
															<strong>1 point</strong>
															For every ₹100 spend on shopping 
														</td>
													</tr>
													<tr>
														<td><img src="<?= base_url('images/sound.png') ?>" width="27" height="27" border="0" alt=""></td>
														<td>
															<strong>₹ 0.10</strong>
															When 1 reward point is redeemed
														</td>
													</tr>												
												</table>
											</div>
											<div class="tier-bottom">
												<?php if($reward_details['tier'] == '1'){?>You are here <?php } ?>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="each-tier">
											<div class="tier-top <?php if($reward_details['tier'] == '2') echo 'active' ?>">
												Ace
											</div>
											<div class="tier-content">
												<p>Privilege member benefits</p>
												<table>
													<tr>
														<td><img src="<?= base_url('images/credit-card.png') ?>" width="27" height="19" border="0" alt=""></td>
														<td>
															<strong>1 point</strong>
															For every ₹100 spend on shopping 
														</td>
													</tr>
													<tr>
														<td><img src="<?= base_url('images/sound.png') ?>" width="27" height="27" border="0" alt=""></td>
														<td>
															<strong>₹ 0.15</strong>
															When 1 reward point is redeemed
														</td>
													</tr>												
												</table>
											</div>
											<div class="tier-bottom"><?php if($reward_details['tier'] == '2'){?>You are here <?php }else{ ?>
												Earn <?php echo (5000 - $reward_details['total_purchased_value']);?> points to reach this tires <?php } ?>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="each-tier">
											<div class="tier-top <?php if($reward_details['tier'] == '3') echo 'active' ?>">
												Pro
											</div>
											<div class="tier-content">
												<p>Privilege member benefits</p>
												<table>
													<tr>
														<td><img src="<?= base_url('images/credit-card.png') ?>" width="27" height="19" border="0" alt=""></td>
														<td>
															<strong>1 point</strong>
															For every ₹100 spend on shopping 
														</td>
													</tr>
													<tr>
														<td><img src="<?= base_url('images/sound.png') ?>" width="27" height="27" border="0" alt=""></td>
														<td>
															<strong>₹ 0.20</strong>
															When 1 reward point is redeemed
														</td>
													</tr>												
												</table>
											</div>
											<div class="tier-bottom">
												<?php if($reward_details['tier'] == '3'){?>You are here <?php }else{ ?>
												Earn <?php echo (10000 - $reward_details['total_purchased_value']);?> points to reach this tires <?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="personal-info-detailed-content-left col-lg-4">
                            <ul>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                                    <ul>
                                        <li ><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
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
                                        <li class="active"><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
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