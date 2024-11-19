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
					<form method="POST">
						
					<div class="personal-info-detailed-content row no-gutters flex-row-reverse" id="edit_personalInfos">

						 

						<div class="personal-info-detailed-content-right col-lg-8">
							<?php
			                if ($this->session->flashdata('userSuccess')) {
			                    ?>
			                    <hr>
			                    <div class="alert alert-info"><?= $this->session->flashdata('userSuccess') ?></div>
			                    <hr>
			                <?php }
			                ?>
							<div class="label-area d-flex justify-content-between">
								<h4>Personal Information</h4>							
							</div>
							<div class="each-feild">
								<!-- <div class="row"> -->
									<!-- <div id="" class="col-lg-6"> -->
										<lable class="info-label-style"> Name *</lable>
										<input type="text" class="input-style" placeholder="Name" name="name" value="<?php echo $userInfo['name'];?>" required/>
									<!-- </div> -->
									<!-- <div id="" class="col-lg-6">
										<lable class="info-label-style">Last Name</lable>
										<input type="text" class="input-style" placeholder="Last Name" name="last_name" value="<?php echo $userInfo['last_name'];?>" required/>
									</div> -->
								<!-- </div> -->
							</div>
							<div class="each-feild">
								<lable class="info-label-style">Mobile Number *</lable>
								<input type="text" class="input-style" placeholder="Mobile Number" name="phone" maxlength="10" value="<?php echo $userInfo['phone'];?>" onkeypress="return isNumber(event)" required/>
							</div>
							<div class="each-feild">
								<lable class="info-label-style">Email</lable>
								<input type="email" class="input-style" placeholder="Email" name="email" value="<?php echo $userInfo['email'];?>"/>
							</div>
							<div class="each-feild">
								<lable class="info-label-style">Date Of Birth</lable>
								<input type="date" class="input-style" placeholder="Date Of Birth" name="dob" value="<?php echo $userInfo['dob'];?>"/>
							</div>
							<div class="each-feild gender-feild">
								<lable class="info-label-style">Gender</lable>
								<input type="radio" name="gender" value="Male" <?php if($userInfo['gender'] == 'Male') echo 'checked';?>>
								<label for="Male" class="gender-choose">Male</label>
								<input type="radio" name="gender" value="Female" <?php if($userInfo['gender'] == 'Female') echo 'checked';?>>
								<label for="female" class="gender-choose">Female</label>
								<input type="radio" name="gender" value="Others" <?php if($userInfo['gender'] == 'Others') echo 'checked';?>>
								<label for="others" class="gender-choose">Others</label>
							</div>
							<div class="each-feild">
								<lable class="info-label-style">Marital Status</lable>
								<select class="input-style" name="marital_status">
									<option disabled <?php if($userInfo['marital_status'] != 'Married' || $userInfo['marital_status'] != 'Unmarried') echo 'selected';?>>Select Marital Status</option>
									<option <?php if($userInfo['marital_status'] == 'Married') echo 'selected' ?> value="Married">Married</option>
									<option <?php if($userInfo['marital_status'] == 'Unmarried') echo 'selected' ?> value="Unmarried">Unmarried</option>
								</select>
							</div>
							<div class="each-feild">
								<lable class="info-label-style">Anniversary Date:</lable>
								<input type="date" class="input-style" placeholder="Anniversary Date" name="anniversary" value="<?php echo $userInfo['anniversary'];?>"/>
							</div>
							
							<div class="each-feild">
								<button type="submit" class="gn-button small new-input-style edit_personalInfo" name="edit_personal_info">Save</button>
							</div>
						</div>
						<div class="personal-info-detailed-content-left col-lg-4">
                            <ul>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                                    <ul style="display:block">
                                        <li class="active"><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
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
					</form>
				</div>
			</section>
			<!-- END:PERSONAL INFO PAGE -->
			<!-- SITE FOOTER-->
			
			<!-- END FOOTER-->
		</main>