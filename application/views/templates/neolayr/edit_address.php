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
         <div class="personal-info-detailed-content row no-gutters flex-row-reverse" id="add_address_profiles">
            <div class="personal-info-detailed-content-right col-lg-8">
               <div class="label-area d-flex justify-content-between label-areas">
                  <h4>Add new address</h4>
               </div>
               <form method="POST">
                  <?php
                     if ($this->session->flashdata('userSuccess')) {
                         ?>
                  <hr>
                  <div class="alert alert-info"><?= $this->session->flashdata('userSuccess') ?></div>
                  <hr>
                  <?php }
                     ?>
                  <div class="row edit-form-address">
                     <div class="col-lg-10">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="each-feild each-feilds">
                                 <div class="row">
                                    <div id="" class="col-lg-12">
                                       <lable class="info-label-style"> Name *</lable>
                                       <input type="text" class="input-style" placeholder=" Name" required="required" name="add_name" value="<?php echo $user_address['first_name'] ?>" />
                                    </div>
                                    <!-- <div id="" class="col-lg-6">
                                       <lable class="info-label-style">Last Name</lable>
                                       <input type="text" class="input-style" placeholder="Last Name" required="required" name="add_last_name" value="<?php echo $user_address['last_name'] ?>"/>
                                       </div> -->
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12"></div>
                           <div class="col-lg-6">
                              <div class="each-feild each-feilds">
                                 <label class="info-label-style">Mobile Number *</label>
                                 <input type="phone" class="input-style new-input-style" placeholder="Mobile Number" required="required" maxlength="10" name="add_mob" value="<?php echo $user_address['phone'] ?>" onkeypress="return isNumber(event)"/>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="each-feild each-feilds">
                                 <label class="info-label-style">Pincode *</label>
                                 <input type="phone" class="input-style new-input-style" placeholder="Pincode" required="required" name="add_pincode" maxlength="6" id="add_pincode" value="<?php echo $user_address['post_code'] ?>"/>
                                 <!-- <input type="phone" class="input-style new-input-style" placeholder="Pincode" required="required" name="add_pincode"  maxlength="6"/> -->
                              </div>
                           </div>
                           <!-- <div class="col-lg-12"></div> -->
                           <!-- <div class="col-lg-6">
                              <div class="each-feild">
                                 <label class="info-label-style">Pincode</label>
                                 <input type="phone" class="input-style new-input-style" placeholder="Pincode"/>
                              </div>
                              </div> -->                       
                           <!-- <div class="col-lg-6">
                              <div class="each-feild">
                                 <label class="info-label-style">Country</label>
                                 <input type="phone" class="input-style new-input-style" placeholder="Country"/>
                              </div>
                              </div>    -->                       
                           <div class="col-lg-12"></div>
                           <div class="col-lg-6">
                              <div class="each-feild each-feilds">
                                 <label class="info-label-style">State *</label>
                                 <input type="text" name="add_state" id="stateInput" class="input-style new-input-style  add_state" placeholder="State" required="required" value="<?php echo $user_address['state_name'] ?>">
                                 <!-- <select id="stateInput" name="add_state" class="input-style new-input-style add-field add_state" onChange="changeState(this.value);" required="required">
                                    <option value="">-</option>
                                    <?php foreach($state_list as $state){?>
                                    <option <?php if($state['id'] == $user_address['state']) echo 'selected';?> value="<?php echo $state['id'];?>"><?php echo $state['state_name'];?></option>
                                    <?php } ?>
                                    </select> -->
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="each-feild each-feilds">
                                 <label class="info-label-style">City *</label>
                                 <input type="text" name="add_city" id="thana" class="input-style new-input-style" placeholder="City" required="required" value="<?php echo $user_address['city_name'] ?>">
                                 <!-- <select name="add_city" id="thana" class="add-field input-style new-input-style" required="required">
                                    <option value="">-</option>
                                    <?php foreach($city_list as $city){?>
                                    <option <?php if($city['id'] == $user_address['city']) echo 'selected';?> value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
                                    <?php } ?>
                                    </select> -->
                              </div>
                           </div>
                           <div class="col-lg-12"></div>
                           <div class="col-lg-6">
                              <div class="each-feild each-feilds">
                                 <label class="info-label-style">House No., Building Name *</label>
                                 <input type="text" class="input-style new-input-style" placeholder="House No., Building Name" required="required" name="add_build_name" value="<?php echo $user_address['address'] ?>"/>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="each-feild each-feilds">
                                 <label class="info-label-style">Road Name, Area, Colony *</label>
                                 <input type="text" class="input-style new-input-style" placeholder="Road Name, Area, Colony" required="required" name="add_road_name" value="<?php echo $user_address['road_name'] ?>"/>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="each-feild each-feilds">
                                 <label class="info-label-style">Landmark</label>
                                 <input type="text" class="input-style new-input-style" placeholder="Landmark"  name="landmark" value="<?php echo $user_address['landmark'] ?>"/>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="each-feild each-feilds each-feilds-btn">
                                 <button type="submit" class="gn-button small new-input-style add_address_profile" name="edit_address">Save Address</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="personal-info-detailed-content-left col-lg-4">
               <ul>
                  <li class="submenu">
                     <a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                     <ul style="display:block">
                        <li><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
                        <li class="active"><a href="<?= LANG_URL . '/manage-address' ?>">Manage address</a></li>
                     </ul>
                  </li>
                  <li class="submenu">
                     <a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy.png') ?>" width="25" height="25" border="0" alt=""></span>Order history</a>
                     <ul>
                        <li><a href="<?= LANG_URL . '/users/orders' ?>">MY ORDERS</a></li>
                     </ul>
                  </li>
                  <li><a href="<?= LANG_URL . '/users/wishlist' ?>"><span><img src="<?= base_url('images/user-6-copy-4.png') ?>" width="23" height="21" border="0" alt=""></span>Wishlist</a></li>
                  <li class="submenu">
                     <a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy-6.png') ?>" width="23" height="23" border="0" alt=""></span>Rewards</a>
                     <ul>
                        <li><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
                        <li><a href="<?= LANG_URL . '/refer-friend' ?>">Refer friends</a></li>
                     </ul>
                  </li>
                  <li class="submenu">
                     <a href="javascript:void(0)"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="25" border="0" alt=""></span>Gift Voucher</a>
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