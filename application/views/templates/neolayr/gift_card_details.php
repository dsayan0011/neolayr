<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
p.wrong_registration{
    display: none;
}
p.wrong_mobileNumber{
    display: none;
}
p.wrong_emailAddress{
    display: none;
}
p.wrong_amount{
    display: none;
}
p.wrong_amount_two{
    display: none;
}
</style>
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
									<div class="order-title-area">
										<div class="">
											<h4>GIFT CARD DETAILS</h4>
										</div>
										<div class="">
											<!-- <form method="GET" id="sortOrder">
												<select name="sortby" class="input-style" onchange="sort_order(this.value);">
													<option value="all">All</option>
													<option value="6month">Last 6 month</option>
													<option value="12month">Last 12 month</option>
												</select>
											</form> -->
										</div>
									</div>
								</div>
								<!-- each order start -->

								<?php 
								if(sizeof($giftdetails)){

								foreach ($giftdetails as $value) {

								 ?>
								<div class="each-order-n">
									<div class="order-top">
										<div class="row">
											<div class="col-6">
												<h4>Order placed: <?php echo date('d-m-Y', strtotime($value['created_at']));?></h4>
											</div>
											<div class="col-6 text-right">
												<h4>TransactionID: #<?php echo $value['transitionID'];?></h4>												
											</div>											
										</div>
									</div>
									<div class="order-middle">
										<div class="row">
											<div class="col-lg-3">
												<img src="<?= base_url('images/n-product.png') ?>" width="100%" height="auto" border="0" alt="">
											</div>
											<div class="col-lg-6 gift_card-details">
												<p>Order total: <strong>₹<?php echo $value['giftCouponAmount'];?></strong></p>
												<p>To: <strong><?php echo $value['giftCouponTo'];?></strong></p>

												<p>Mobile No : <strong><?php echo $value['giftCouponMobile'];?></strong></p>

												<p>Email : <strong><?php echo $value['giftCouponEmail'];?></strong></p>
												<!-- <p>From: <strong><?php echo $value['giftCouponTo'];?></strong></p> -->
												<?php if($value['giftCouponMessage'] != ''){?>
												<div class="message">
													<table>
														<tr>
															<td><p>Message:</p></td>
															<td><p><?php echo $value['giftCouponMessage'];?></p></td>
														</tr>
													</table>
												</div>
											<?php } ?>
											</div>											
											<div class="col-lg-3 align-self-start text-right">
												<p class="ordfer-on">Payment Status <br><strong><?php echo $value['transitionStatus'];?></strong></p>
											</div>
											<hr>
										</div>
									</div>									
								</div>
							<?php } } else{?>
								<div class="col-xl-12 col-md-12 col-12" id="no_wishlist_item">
									No Gift Card Found !!!
								</div>
							<?php } ?>
								
							</div>
						<!-- </div> -->
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
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
                                        <li><a href="<?= LANG_URL . '/refer-friend' ?>">Refer friends</a></li>
                                    </ul>
                                </li>
                                <!-- <li class="active"><a href="<?= LANG_URL . '/users/gift' ?>"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="23" border="0" alt=""></span>Gift Voucher</a></li> -->
								<li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="25" border="0" alt=""></span>Gift Voucher</a>
                                    <ul style="display:block">
                                        <li><a href="<?= LANG_URL . '/users/gift' ?>">Gift Card</a></li>
                                        <li class="active"><a href="<?= LANG_URL . '/gift-card-details' ?>">Gift Card Details</a></li>
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