<!-- <section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>Check-out</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= LANG_URL . '/shopping-cart' ?>">Shopping Cart</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Check-out</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="section-b-space">
    <div class="container">
        <div class="checkout-page">
            <div class="checkout-form">
                <form method="POST" id="goOrder">
                    <div class="row">
                    <?php
					if (isset($_SESSION['success_order']) && $_SESSION['success_order'] == 'false') {?>
					<div class="col-lg-12">
							<div class="alert alert-warning">Unable to process your payment. Please try again later.</div>
						</div>
					<?php 
					unset($_SESSION['success_order']);
					}
					if ($cartItems['array'] == null) {
						?>
						<div class="col-lg-12">
							<div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
						</div>
						<?php
					} else {?>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                             <?php if(!isset($_SESSION['logged_user'])){?>
                            <div class="checkout-payment customer_info">
                           		 <h2 class="step-title">1. Customer <div class="edit_option" id="customer_edit"><a href="javascript:void(0)">Edit</a></div></h2>
                                 <div id="customer_details">
                                 	 <div class="input-group">
                                        <h4><a href="<?= LANG_URL . '/users/login?redirect=checkout' ?>">Click here to register.</a></h4>
                                      </div>
                                     
                                      <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" name="customer_email" placeholder="Enter email">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm btn-primary" onclick="checkuser()">Continue as Guest</button>
                                            </div>
                                      </div>
                                       <span class="email_error error"></span>
                                       <div class="input-group">
                                        <h4><a href="<?= LANG_URL . '/users/login?redirect=checkout' ?>">Click here to login</a></h4>
                                      </div>
                                 </div>
                                 
                            </div>
                            <?php } ?>
			    			<div class="checkout-payment">
                            	<h2 class="step-title">2. Shipping Address <div class="edit_option" id="shipping_edit"><a href="javascript:void(0)">Edit</a></div></h2>
                                <div id="address_field" <?php if(!isset($_SESSION['logged_user'])) echo 'style="display:none"';?>>
                                	<div id="prev_address" <?php if(!isset($_SESSION['logged_user']) || sizeof($previous_address)==0) echo 'style="display:none"';?>>
                                      <div class="row">
                                    	<?php foreach($previous_address as $addreess){?>
                                        	<div class="col-6">
                                            	<div class="card">
                                                	<div class="card-body">
                                                    	<p class="card-text">
															<?=$addreess['first_name'].' '.$addreess['last_name'].',<br>Phone - '.$addreess['phone'].',<br>Address - '.$addreess['address'].',<br>'.$addreess['state_name'].','.$addreess['city_name'].','.$addreess['country_name'].',<br>Pin Code - '.$addreess['post_code'];?>
                                                        </p>
                                                    	<button type="button" onclick="setDeliveryAddress(<?=$addreess['address_id'];?>,<?=$addreess['state'];?>,'<?=$addreess['sortname'];?>',<?=$cartItems['finalSum'];?>)" class="btn-solid btn">Deliver Here</button>
                                            			<a style="margin-left:10px" href="javascript:void(0)" onclick="deleteAddress(<?=$addreess['address_id'];?>)">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                       </div>
                                    </div>
                                    <button type="button" <?php if(!isset($_SESSION['logged_user']) || sizeof($previous_address)==0) echo 'style="display:none"';?> class="btn-solid btn" id="add_new_address_btn">Add New Address</button>
                                     <input type="hidden" id="guest_id" value="<?php if(isset($_SESSION['logged_user'])) echo $_SESSION['logged_user'];?>" />
                                        <input type="hidden" id="user_email" value="<?php if(isset($_SESSION['logged_email'])) echo $_SESSION['logged_email'];?>" />
                                    <div id="add_new_addreess" <?php if(isset($_SESSION['logged_user']) && sizeof($previous_address)>0) echo 'style="display:none"'?>>
                                    <div class="form-group required-field">
                                            <label for="firstNameInput">First Name *</label>
                                            <input id="firstNameInput" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name'];else if(isset($previous_address['first_name'])) echo $previous_address['first_name']; ?>" type="text" placeholder="First Name">
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="lastNameInput"><?= lang('last_name') ?> *</label>
                                            <input id="lastNameInput" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name'];else if(isset($previous_address['last_name'])) echo $previous_address['last_name']; ?>" type="text" placeholder="<?= lang('last_name') ?>">
                                        </div>
                                       <div class="form-group required-field">
                                            <label for="phoneInput"><?= lang('phone') ?> *</label>
                                            <input id="phoneInput" class="form-control" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone'];else if(isset($previous_address['phone'])) echo $previous_address['phone']; ?>" type="text" placeholder="<?= lang('phone') ?>">
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="addressInput"><?= lang('address') ?> *</label>
                                            <textarea id="addressInput" name="address" class="form-control" rows="3"><?php if(isset($_POST['address'])) echo $_POST['address'];else if(isset($previous_address['address'])) echo $previous_address['address']; ?></textarea>
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="countryInput">Country *</label>
                                            <select id="countryInput" name="country" class="form-control" onChange="changeCountry(this.value);">
                                            	 <option disabled="disabled" selected="selected">Select country</option>
                                           		 <?php foreach($country_list as $country){?>
                                                 <option value="<?php echo $country['id'];?>" <?php if($country['id']=='101') echo 'selected="selected"';?>><?php echo $country['country_name'];?></option>
                                                 <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="state"><?= lang('state') ?> *</label>
                                            <select id="stateInput" name="state" class="form-control" onChange="changeState(this.value);">
                                          		<option value="">-</option>
                                                <?php foreach($state_list as $state){?>
                                                 <option value="<?php echo $state['id'];?>"><?php echo $state['state_name'];?></option>
                                                 <?php } ?>
                                                
                                            </select>
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="postInput"><?= lang('city') ?> *</label>
                                            <select name="thana" id="thana" class="form-control" >
                                               <option value="">-</option>
                                            </select>
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="postInput"><?= lang('post_code') ?> *</label>
                                            <input id="postInput" class="form-control" name="post_code" value="<?php if(isset($_POST['post_code'])) echo $_POST['post_code'];else if(isset($previous_address['post_code'])) echo $previous_address['post_code']; ?>" type="text" placeholder="<?= lang('post_code') ?>">
                                        </div>
                                        
                                       
                                        
                                        <div class="form-group">
                                        	<span class="required-field">(All * fields are mendatory)</span><br /><br />
                                        	<button type="button" class="btn-solid btn" id="save_address">Save Address</button>
                                            <button type="button" class="btn-solid btn" id="cancel_address">Cancel</button><br />
                                            <span style="display:none;" id="address_save"><img src="<?= base_url('assets/imgs/load.gif') ?>" /> Saving your address. Please wait..</span>
                                        </div>
                                    </div>
                                     
                                    
                                </div>
                            </div>
                           <div class="checkout-payment">
                           		 <h2 class="step-title">3. Payment Method</h2>
                                 <div class="payment_method" style="display:none">
                                 	<ul>
                                    	<?php if ($cashondelivery_visibility == 1) { ?>
                                    	<li>
                                        <input type="hidden" name="selectedStateID" id="selectedStateID" value="">
                                            <input checked="checked" type="radio" name="payment_type" value="cashOnDelivery" id="cod"  onclick="changeCod()"/>  <img src="<?= base_url('template/imgs/cash-on-delivery.png') ?>" alt="Cash On Delivery"></li>
                                         <?php } if ($freecharge_payment == 1) { ?>
                                        <li id="freecharge_payment"><input id="freecharge_payment_option" checked="checked" type="radio" name="payment_type" value="Freecharge" style="margin-top: 25px;"/>&nbsp;UPI | Cards | Net Banking powered by <img style="width: 65px;" src="<?= base_url('template/imgs/FreeCharge_Logo.png') ?>" alt="FreeCharge"></li>
                                        <?php } if ($razorpay_payment == 1) { ?>
                                        <li><input id="razorpay_payment_option" checked="checked" type="radio" name="payment_type" value="Razorpay" style="margin-top: 25px;" onclick="razorpayPayment()"/>  <img src="<?= base_url('template/imgs/Razorpay_logo.png') ?>" alt="Razorpay"></li>
                                        <?php } ?>
                                    </ul>
                                     <?php if ($codeDiscounts == 1) { ?>
                                        <div class="cart-discount" id="discount_form">
                                            <h4>Apply Discount Code</h4>
                                          
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" name="discountCode" value="<?= @$_POST['discountCode'] ?>" placeholder="Enter discount code">
                                                    <div class="input-group-append">
                                                        <a href="javascript:void(0);" class="btn-solid btn" onclick="applycoupon()"><?= lang('check_code') ?></a>
                                                    </div>
                                                </div>
                                        </div>
                                        <?php } ?>
                                 </div>
     
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                            <div class="checkout-details">
                                <div class="order-box">
                                    <div class="title-box">
                                        <div>Product <span>Total</span></div>
                                    </div>
                                    <ul class="qty">
                                     <?php 
										 $total_price = 0;
										 $weight = 0;
										 $weightdomestic = 0;
										 $vendor = array();
										 $delivery_time = 0;
										 foreach ($cartItems['array'] as $item) { 
										 	$checkcourier_charge = $this->Public_model->checkcourier_charge($item['product_id']);
											array_push($vendor,$item['vendor_id']);
											if($item['days_to_deliver']>$delivery_time){
												$delivery_time = $item['days_to_deliver'];
											}
										 ?>
                                           <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                                           <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
                                        	<li><a href="<?= LANG_URL . '/' . $item['url'] ?>"> <?= $item['title'] ?> × <?= $item['num_added'] ?> </a><span><?= CURRENCY.$item['price'] ?></span></li>
                                             <?php 
											 if($item['weight_unit'] == 'grams')
											 $weight_in_kg = $item['weight']/1000;
											 else
											 $weight_in_kg = $item['weight'];
											 
											 if($item['length']!="" && $item['width']!="" && $item['height']!=""){
												 $volumn = $item['length']*$item['width']*$item['height'];
												 $volumn_weight = round($volumn/5000,2);
												 if($volumn_weight>$weight_in_kg){
													 $weight_in_kg = $volumn_weight;
												 }
											 }
											 
											 
											 $weight = $weight+($weight_in_kg*$item['num_added']);
												 
											 if($checkcourier_charge=='1'){
												 if($item['weight_unit'] == 'grams')
												 $weight_in_kg_domestic = $item['weight']/1000;
												 else
												 $weight_in_kg_domestic = $item['weight'];
												 
												 if($item['length']!="" && $item['width']!="" && $item['height']!=""){
													 $volumn = $item['length']*$item['width']*$item['height'];
													 $volumn_weight = round($volumn/5000,2);
													 if($volumn_weight>$weight_in_kg_domestic){
														 $weight_in_kg_domestic = $volumn_weight;
													 }
												 }
												 
												 $weightdomestic = $weightdomestic+($weight_in_kg_domestic*$item['num_added']);
											 }
											 
											 $price = str_replace(",", "", $item['price']);  $total_price+=($price*$item['num_added']); 
											 } 
											 ?>
                                         <input type="hidden" id="grand_total" value="<?php echo $total_price;?>" />
                                         <input type="hidden" id="weight" value="<?php echo $weight;?>" />
                                         <input type="hidden" id="weightdomestic" value="<?php echo $weightdomestic;?>" />
                                         <input type="hidden" name="delivery_time" value="<?php echo $delivery_time;?>" />
                                          <input type="hidden" id="subTotal" value="<?php echo $cartItems['finalSum'];?>" />
                                        
                                    </ul>
                                    <ul class="sub-total">
                                        <li>Subtotal <span class="count" id="subTotal"><?= CURRENCY.$cartItems['finalSum'] ?></span></li>
                                        <li>Coupon Discount <span class="count" id="discount-amount"><?= CURRENCY ?>0</span></li>  
                                        <li>Delivery Charge <span class="count" id="delivery_charges"><?= CURRENCY ?><span id="delivery_amount">0</span></span></li>                                       
                                    </ul>
                                    <ul class="total">
                                        <li>Total <span class="count final-amount"  id="total_price"><?= CURRENCY ?><?= number_format($total_price,2) ?></span></li>
                                    </ul>
                                </div>
                                <div class="payment-box">
                                     <input type="hidden" name="selected_address_id" id="selected_address_id" value="" />
                                    <input  type="hidden" id="shpping_cost" name="shpping_cost" value="0" />
                                    <input type="hidden" id="final-amount" name="final_amount" value="<?= $total_price ?>">
                                    <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                                    <input type="hidden" id="discountAmount" name="discountAmount" value="0">
                                    <input type="hidden" id="vendors" value="<?php echo implode(",",$vendor);?>" />
                                    <div class="text-left">
                                     <a href="javascript:void(0);" style="display:none" id="place_order" onclick="place_order()" class="btn-solid btn">Place Order</a>
                               		 <span id="razorpay_payment_process" style="display:none">Processing your payment. Please do not press back button/refresh your page.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php } ?>
                    </div>
                </form>
                 <form name='razorpayform' action="<?= LANG_URL . '/checkout/process_razorpay_payment';?>" method="POST">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="freeCartProduct" role="dialog">
     <div class="modal-dialog">
        <div class="modal-content" id="freeProduct"> </div>
     </div>
    </div>


</section>
 -->
 <main>
            <style>
                .address-list-area h4{
                    color: #000;
                    font-size: 23px;
                    font-weight: 600;
                    text-transform: uppercase;
                    margin-bottom: 20px;
                }
                .each--addressbox{
                    padding: 20px;
                    color: #28292a;
                    border: 1px solid #dddddd;
                    margin-bottom: 40px;
                }
                .each--addressbox h5{
                    font-weight: 600;
                }
                .each--addressbox ul{
                    list-style:none;
                    margin:0px;
                    padding:0px;
                    display:flex;
                }
                .each--addressbox ul li a{
                    color: #61afb7;
                    font-weight: 600;
                    text-transform:uppercase
                }
                .each--addressbox ul li{
                    margin-right:20px;
                }
            </style>
            <section class="cart-page">
                <div class="container">
                    <h1>Cart</h1>
                    <form method="POST" id="goOrder">
                    <div class="row">
                        <div class="col-lg-8 cart-product-area">
                            <div class="address-list-area">
                                <h4>Address List Area</h4>
                                <?php foreach($previous_address as $addreess){?>
                                <div class="each--addressbox">
                                    <h5><?=$addreess['first_name'].' '.$addreess['last_name']?></h5>
                                    <p><?='Phone - '.$addreess['phone'].',<br>Address - '.$addreess['address'].',<br>'.$addreess['state_name'].','.$addreess['city_name'].','.$addreess['country_name'].',<br>Pin Code - '.$addreess['post_code'];?></p>
                                    <ul>
                                        <li><a href="javascript:void(0)" onclick="setDeliveryAddress(<?=$addreess['address_id'];?>,<?=$addreess['state'];?>,'<?=$addreess['sortname'];?>',<?=$cartItems['flot_finalSum'];?>)">Select This Address</a></li>
                                        <li><a href="javascript:void(0)" onclick="editDeliveryAddress(<?php echo $addreess['address_id'] ?>)" class="fancybox">Edit</a></li>
                                    </ul>
                                </div>
                            <?php } ?>
                                <!-- <div class="each--addressbox">
                                    <h5>Address 1</h5>
                                    <p>Address Details</p>
                                    <ul>
                                        <li><a href="">Select This Address</a></li>
                                        <li><a href="">Edit</a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="p-title-area">
                                <div class="row">
                                    <div class="col-lg-10" style="text-transform:uppercase;">Have you got a gift voucher?</div>
                                    <div class="col-lg-2"><a href="#apply-cuppon" class="fancybox" >Apply</a></div>
                                </div>
                            </div>
                        </div>
                        <!-- ********************** -->
                        <div style="display: none;">
                            <div id="apply-cuppon" style="width:879px; max-width:100%; overflow:hidden; padding:10px; background:#fff   ">
                                <div class="login-inner cuppon-form-outer" >
                                    <h2>Apply Coupon</h2>
                                    <div class="cuppon-form">
                                        <div class="">
                                            <input type="text" name="" placeholder="Enter a valid coupon Code">
                                        </div>
                                        <div  class="">
                                            <input type="submit" value="Check">
                                        </div>
                                    </div>
                                    <div class="cuppon-no">
                                        <div class="">
                                            <img src="<?= base_url('images/percent.png') ?>" width="65" height="64" border="0" alt="">
                                        </div>
                                        <div class="">
                                            <h3>first150</h3>
                                            <p>FLAT ₹150/- OFF on your first purchase</p>
                                        </div>
                                        <div class="">
                                            <a href="">APPLY</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ********************** -->
                        <div style="display: none;">
                            <div id="add-address" style="width:879px; max-width:100%; overflow:hidden; padding:10px; background:#fff">
                                <div class="login-inner add-address" >
                                    <div class="f-login" >
                                        <h2>ADD new address</h2>                                        
                                        <div class="text-left ">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <label>Name</label>
                                                    <input type="text" name="" class="add-field" placeholder="Name">
                                                </div>
                                                <div class="col-lg-9">
                                                    <label>Mobile Number</label>
                                                    <input type="text" name="" class="add-field" placeholder="Mobile Number">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>PINCode</label>
                                                    <input type="text" name="" class="add-field" placeholder="Pincode">
                                                </div>
                                                <div class="col-lg-12"></div>
                                                <div class="col-lg-6">
                                                    <label>State</label>
                                                    <input type="text" name="" class="add-field" placeholder="State">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>City</label>
                                                    <input type="text" name="" class="add-field" placeholder="City">
                                                </div>
                                                <div class="col-lg-12">
                                                    <label>House No., Building Name</label>
                                                    <input type="text" name="" class="add-field" placeholder="House No., Building Name">
                                                </div>
                                                <div class="col-lg-12">
                                                    <label>Road Name, Area, Colony</label>
                                                    <input type="text" name="" class="add-field" placeholder="Road Name, Area, Colony">
                                                </div>
                                                <div class="col-lg-12">
                                                    <label>Landmark</label>
                                                    <input type="text" name="" class="add-field" placeholder="Landmark">
                                                </div>
                                                <div class="col-lg-12"></div>
                                                <div class="col-lg-6">
                                                    <input type="submit" value="Save Address" class="first-sign">
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                        <!-- ********************** -->
                        <div class="col-lg-4 cart-price-area">
                            <div class="cart-right-side">
                                <h2 class="cat-top">Order summary</h2>
                                <div class="order-list">
                                    <?php 
                                         $total_price = 0;
                                         $weight = 0;
                                         $weightdomestic = 0;
                                         $vendor = array();
                                         $delivery_time = 0;
                                         foreach ($cartItems['array'] as $item) { 
                                            $checkcourier_charge = $this->Public_model->checkcourier_charge($item['product_id']);
                                            array_push($vendor,$item['vendor_id']);
                                            if($item['days_to_deliver']>$delivery_time){
                                                $delivery_time = $item['days_to_deliver'];
                                            }
                                         ?>
                                         <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                                           <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
                                    <div class="each-order">
                                        <div class="order-image">
                                            <a href="<?= LANG_URL . '/' . $item['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" width="100%" height="auto" border="0" alt=""></a>
                                        </div>
                                        <div class="or-pdetails">
                                            <!-- <p class="od-date">Espected Delivery on 15-Jun-23</p> -->
                                            <h2><a href="<?= LANG_URL . '/' . $item['url'] ?>"><?= $item['title'] ?></a></h2>
                                            <p>QTY : <?= $item['num_added'] ?> | Price : <?= CURRENCY.$item['price'] ?></p>
                                            <!-- <p></p> -->

                                            <?php 
                                             if($item['weight_unit'] == 'grams')
                                             $weight_in_kg = $item['weight']/1000;
                                             else
                                             $weight_in_kg = $item['weight'];
                                             
                                             if($item['length']!="" && $item['width']!="" && $item['height']!=""){
                                                 $volumn = $item['length']*$item['width']*$item['height'];
                                                 $volumn_weight = round($volumn/5000,2);
                                                 if($volumn_weight>$weight_in_kg){
                                                     $weight_in_kg = $volumn_weight;
                                                 }
                                             }
                                             
                                             
                                             $weight = $weight+($weight_in_kg*$item['num_added']);
                                                 
                                             if($checkcourier_charge=='1'){
                                                 if($item['weight_unit'] == 'grams')
                                                 $weight_in_kg_domestic = $item['weight']/1000;
                                                 else
                                                 $weight_in_kg_domestic = $item['weight'];
                                                 
                                                 if($item['length']!="" && $item['width']!="" && $item['height']!=""){
                                                     $volumn = $item['length']*$item['width']*$item['height'];
                                                     $volumn_weight = round($volumn/5000,2);
                                                     if($volumn_weight>$weight_in_kg_domestic){
                                                         $weight_in_kg_domestic = $volumn_weight;
                                                     }
                                                 }
                                                 
                                                 $weightdomestic = $weightdomestic+($weight_in_kg_domestic*$item['num_added']);
                                             }
                                             
                                             $price = str_replace(",", "", $item['price']);  $total_price+=($price*$item['num_added']);
                                             ?>
                                         
                                        </div>
                                    </div>  
                                <?php } ?>
                                <input type="hidden" id="grand_total" value="<?php echo $total_price;?>" />
                                         <input type="hidden" id="weight" value="<?php echo $weight;?>" />
                                         <input type="hidden" id="weightdomestic" value="<?php echo $weightdomestic;?>" />
                                         <input type="hidden" name="delivery_time" value="<?php echo $delivery_time;?>" />
                                          <input type="hidden" id="subTotal" value="<?php echo $cartItems['finalSum'];?>" />
                                   <!--  <div class="each-order">
                                        <div class="order-image">
                                            <img src="<?= base_url('images/product-listing1-Copy.jpg') ?>" width="100%" height="auto" border="0" alt="">
                                        </div>
                                        <div class="or-pdetails">
                                            <h2>Product Name</h2>
                                            <p>Size: 39 | QTY : 12</p>
                                            <p>Price : $1155</p>
                                        </div>
                                    </div> -->  
                                    <!-- <div class="each-order">
                                        <div class="order-image">
                                            <img src="<?= base_url('images/product-listing1-Copy.jpg') ?>" width="100%" height="auto" border="0" alt="">
                                        </div>
                                        <div class="or-pdetails">
                                            <h2>Product Name</h2>
                                            <p>Size: 39 | QTY : 12</p>
                                            <p>Price : $1155</p>
                                        </div>
                                    </div> -->  

                                </div>
                                <h2 class="cat-top">Cart summary</h2>
                                <div class="cart-summery">
                                    <table>
                                        <tr>
                                            <td>Merchandise Subtotal:</td>
                                            <td><span class="count" id="subTotal"><?= CURRENCY.$cartItems['finalSum'] ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Cost:</td>
                                            <td><span class="count" id="delivery_charges"><?= CURRENCY ?><span id="delivery_amount">0</span></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Coupon Discount:</span></td>
                                            <td><span class="count" id="discount-amount"><?= CURRENCY ?>0</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Paid by Points:</span></td>
                                            <td><span class="">0</span></td>
                                        </tr>
                                        <tr>
                                            <td>Total:</td>
                                            <td><span class="count final-amount"  id="total_price"><?= CURRENCY ?><?= number_format($total_price,2) ?></span></td>
                                        </tr>                                       
                                    </table>
                                    <p><?php if( $cartItems['flot_finalSum'] < '1000.00')  {?><p>Spend ₹<?php echo '1000' - $cartItems['finalSum'] ?> more to get free delivery</p> <?php } ?></p>
                                    <input type="hidden" name="selected_address_id" id="selected_address_id" value="" />
                                    <input  type="hidden" id="shpping_cost" name="shpping_cost" value="0" />
                                    <input type="hidden" id="final-amount" name="final_amount" value="<?= $total_price ?>">
                                    <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                                    <input type="hidden" id="discountAmount" name="discountAmount" value="0">
                                    <input type="hidden" id="vendors" value="<?php echo implode(",",$vendor);?>" />
                                    <input type="hidden" id="selectedAmount" name="selectedAmount" value="0">
                                    <a href="javascript:void(0)" class="gn-button" id="place_order" onclick="place_order()">CHECKOUT</a>
                                    <span id="razorpay_payment_process" style="display:none">Processing your payment. Please do not press back button/refresh your page.</span>
                                </div>
                                <h2 class="cat-top">Select Payment option</h2>
                                <div class="select-payment-option">
                                    <ul>
                                         <?php  if ($razorpay_payment == 1) { ?>
                                        <li><label><input type="radio" id="razorpay_payment_option"  name="payment_type" value="Razorpay" onclick="razorpayPayment()" checked="checked"> Online Payment</label></li>
                                    <?php } ?>
                                         <?php if ($cashondelivery_visibility == 1) { ?>
                                            <input type="hidden" name="selectedStateID" id="selectedStateID" value="">
                                        <li><label><input type="radio" name="payment_type" value="cashOnDelivery" id="cod"   onclick="changeCod()"> Cash on delivery</label></li>
                                    <?php } ?>
                                       

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form name='razorpayform' action="<?= LANG_URL . '/checkout/process_razorpay_payment';?>" method="POST">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                </form>
                </div>
                <div class="modal fade" id="freeCartProduct" role="dialog">
                 <div class="modal-dialog">
                    <div class="modal-content" id="freeProduct"> </div>
                 </div>
                </div>
            </section>
            <section class="related-producted">
                <div class="container">
                    <h2 class="text-center">New Arrival</h2>
                    <div class="product-sl-list position-relative">
                        <div class="each-slide">
                            <div class="swiper-container product-slider product-slider1">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <?php 
                                        $counter = 0;
                                        foreach($recentlyAdded as $recently){
                                             ?>
                                    <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <div class="product-image">
                                                <a href="<?= LANG_URL . '/' . $recently['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $recently['image']) ?>" border="0" alt="" class="w-100">
                                                </a>
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p><a href="<?= LANG_URL . '/' . $recently['vendor_url'] . '/' . $recently['url'] ?>"><?= character_limiter($recently['title'], 20) ?>
                                                <?php echo $recently['weight'] ?> <?php echo $recently['weight_unit'] ?></a></p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <a href="javascript:void(0)" class="add_item_cartpage" data-id="<?php echo $recently['variant_id'] ?>">ADD to cart <span>| </span> <?php if($recently['default_price'] != '0') echo CURRENCY.number_format($recently['default_price'], 2); else echo 'Coming soon' ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                    <!-- <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <div class="product-image">
                                                <img src="<?= base_url('images/product-listing1.jpg') ?>" border="0" alt="" class="w-100">
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p>Neolayr Pro Prohair Quick 
                                                Hair Fall Control Solution 
                                                40 ML</p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <a href="">ADD to cart <span>| </span> ₹340.00</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <div class="product-image">
                                                <img src="<?= base_url('images/product-listing1.jpg') ?>" border="0" alt="" class="w-100">
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p>Neolayr Pro Prohair Quick 
                                                Hair Fall Control Solution 
                                                40 ML</p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <a href="">ADD to cart <span>| </span> ₹340.00</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <div class="product-image">
                                                <img src="<?= base_url('images/product-listing1.jpg') ?>" border="0" alt="" class="w-100">
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p>Neolayr Pro Prohair Quick 
                                                Hair Fall Control Solution 
                                                40 ML</p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <a href="">ADD to cart <span>| </span> ₹340.00</a>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev product-prev1 common-prev"><img src="<?= base_url('images/left-arrow.png') ?>" alt=""></div>
                            <div class="swiper-button-next product-next1 common-next"><img src="<?= base_url('images/right-arrow.png') ?>" alt=""></div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="featured-producted">
                <div class="container">
                    <h2 class="text-center">Featured Products</h2>
                    <div class="product-sl-list position-relative">
                        <div class="each-slide">
                            <div class="swiper-container testimonial-slider">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <?php 
                                        $counter = 0;
                                        foreach($featuredProducts as $featured){
                                             ?>
                                    <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <div class="product-image">
                                                 <a href="<?= LANG_URL . '/' . $featured['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $featured['image']) ?>" border="0" alt="" class="w-100">
                                                </a>
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p><a href="<?= LANG_URL . '/' . $featured['vendor_url'] . '/' . $featured['url'] ?>"><?= character_limiter($featured['title'], 20) ?>
                                                <?php echo $featured['weight'] ?> <?php echo $featured['weight_unit'] ?></a></p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <a href="javascript:void(0)" class="add_item_cartpage" data-id="<?php echo $featured['variant_id'] ?>">ADD to cart <span>| </span> <?php if($featured['default_price'] != '0') echo CURRENCY.number_format($featured['default_price'], 2); else echo 'Coming soon' ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                    <!-- <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <div class="product-image">
                                                <img src="<?= base_url('images/product-listing1.jpg') ?>" border="0" alt="" class="w-100">
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p>Neolayr Pro Prohair Quick 
                                                Hair Fall Control Solution 
                                                40 ML</p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <a href="">ADD to cart <span>| </span> ₹340.00</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <div class="product-image">
                                                <img src="<?= base_url('images/product-listing1.jpg') ?>" border="0" alt="" class="w-100">
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p>Neolayr Pro Prohair Quick 
                                                Hair Fall Control Solution 
                                                40 ML</p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <a href="">ADD to cart <span>| </span> ₹340.00</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <div class="product-image">
                                                <img src="<?= base_url('images/product-listing1.jpg') ?>" border="0" alt="" class="w-100">
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p>Neolayr Pro Prohair Quick 
                                                Hair Fall Control Solution 
                                                40 ML</p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <a href="">ADD to cart <span>| </span> ₹340.00</a>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev testimonial-prev common-prev"><img src="<?= base_url('images/left-arrow.png') ?>" alt=""></div>
                            <div class="swiper-button-next testimonial-next common-next"><img src="<?= base_url('images/right-arrow.png') ?>" alt=""></div>
                        </div>
                    </div>
                </div>
            </section>
            
        </main>