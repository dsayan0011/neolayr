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
                            <?php 
                                           if ($this->session->flashdata('userError')) {
                                            if (is_array($this->session->flashdata('userError'))) {
                                                $usr_err = implode('<br>', $this->session->flashdata('userError'));
                                            } else {
                                                $usr_err = $this->session->flashdata('userError');
                                            }
                                            ?>
                                                <div class="alert alert-danger" role="alert">
                                                 <?= $usr_err; ?>
                                                </div>
                                            <?php
                                            }
                                            if ($this->session->flashdata('userSuccess')) {
                                                if (is_array($this->session->flashdata('userSuccess'))) {
                                                    $usr_err = implode('<br>', $this->session->flashdata('userSuccess'));
                                                } else {
                                                    $usr_err = $this->session->flashdata('userSuccess');
                                                }
                                                ?>
                                                    <div class="alert alert-success" role="alert">
                                                     <?= $usr_err; ?>
                                                    </div>
                                                <?php
                                                }
                                            ?>
                            <div class="label-area">
                                <div class="row">
									<div class="col-lg-6">
										<div class="gift-card-left-wrapper">
											<h4>SEND A GIFT CARD</h4>
											<h5>Amount*</h5>
                                            <form method="POST" enctype="multipart">
											<div class="gift-card-amount d-flex">
												<div class="price-symbol">
													<img src="<?= base_url('images/Indian_Rupee_symbol1044.png') ?>" border="0" alt="">
												</div>
												<div class="price-amount-box">
													<input type="text" class="input-style" name="gift_price" id="gift_price" placeholder="Enter Amount" maxlength="8" minlength="3" required onkeypress="return isNumber(event)" onkeyup="updatePrice()"/>
                                                    <p class="wrong_registration wrong_amount" id="wrong_amount">Enter Amount</p>
                                                    <p class="wrong_registration wrong_amount_two" id="wrong_amount_two">Enter Amount Greater then 499</p>
												</div>
											</div>
											<h5>To*</h5>
											<div class="gift-receiver-name">
												<input type="text" class="input-style" placeholder="Name" required name="gift_name" id="gift_name" onkeyup="updateName()" />
                                                 <p class="wrong_registration wrong_firstName" id="wrong_firstName">Enter Name</p>
											</div>
											<h5>recipient's Email*</h5>
											<div class="gift-receiver-name">
												<input type="email" class="input-style" placeholder="Email address" name="gift_email" id="gift_email"  />
                                                <p class="wrong_registration wrong_emailAddress" id="wrong_emailAddress">Enter Valid Email Address</p>
											</div>
											<h5>recipient's Mobile*</h5>
											<div class="gift-Sender-name">
												<input type="text" class="input-style" placeholder="Mobile no."  name="gift_mobile_no" id="gift_mobile_no" onkeypress="return isNumber(event)"  required maxlength="10"/>
                                                 <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Enter Mobile Number</p>
											</div>
											<h5>Message</h5>
											<div class="Sender-message">
												<textarea class="input-style" rows="5" placeholder="Message" name="gift_message" id="gift_message"></textarea>
											</div>
											<div class="mt-4">
												<button type="button" class="gn-button small new-input-style buy_gift" name="buy_gift" onclick="giftCoupon()">Buy Now</button>
                                                <span id="giftcard_payment_process" style="display:none">Processing your payment. Please do not press back button/refresh your page.</span>
											</div>
                                        </form>
                    <form name='razorpayGiftform' action="<?= LANG_URL . '/users/giftcard_razorpay_payment';?>" method="POST">
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                    </form>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="gift-crad-design">
											<div class="gift-card-design">
                                            <div class="gift-heading">
                                                <h3>Gift</h3>
                                                <p>Voucher</p>
                                            </div>
                                            <div class="name-area">
                                                <p>To:&nbsp;&nbsp;<span id="gift_name_view">John Doe</span></p>
                                                <p>From:&nbsp;&nbsp;<?php echo $userInfo['name'].' '.$userInfo['last_name']?></p>
                                            </div>
                                            <div class="voucher-amount-area">
                                                <div class="price-box">
                                                    <p>VALUE</p>
                                                    <h3 id="gift_price_view">₹100</h3>
                                                </div>
                                            </div>
                                            <div class="message-box">
                                                <p>Happy birthday! I hope all  your birthday wishes <br>and dreams come true.</p>
                                            </div>
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
                                        <li class="active"><a href="<?= LANG_URL . '/users/gift' ?>">Gift Card</a></li>
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