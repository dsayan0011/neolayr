<nav aria-label="breadcrumb" class="breadcrumb-nav mb-1">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= LANG_URL . '/shopping-cart' ?>">Shopping Cart</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div><!-- End .container -->
</nav>
<div class="container">
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
                    <div class="col-lg-8">
                       
                         <?php
                            if ($this->session->flashdata('submit_error')) {
                                ?>
                                <hr>
                                <div class="alert alert-danger">
                                    <h4><span class="glyphicon glyphicon-alert"></span> <?= lang('finded_errors') ?></h4>
                                    <?php
                                    foreach ($this->session->flashdata('submit_error') as $error) {
                                        echo $error . '<br>';
                                    }
                                    ?>
                                </div>
                                <hr>
                                <?php
                            }
                            ?>
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
                                                    	<button type="button" onclick="setDeliveryAddress(<?=$addreess['address_id'];?>,'<?=$addreess['sortname'];?>')" class="btn btn-primary">Deliver Here</button>
                                            			<a style="margin-left:10px" href="javascript:void(0)" onclick="deleteAddress(<?=$addreess['address_id'];?>)">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                       </div>
                                    </div>
                                    <button type="button" <?php if(!isset($_SESSION['logged_user']) || sizeof($previous_address)==0) echo 'style="display:none"';?> class="btn btn-primary" id="add_new_address_btn">Add New Address</button>
                                    <div id="add_new_addreess" <?php if(isset($_SESSION['logged_user']) && sizeof($previous_address)>0) echo 'style="display:none"'?>>
                                    <div class="form-group required-field">
                                            <label for="firstNameInput">First Name</label>
                                            <input id="firstNameInput" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name'];else if(isset($previous_address['first_name'])) echo $previous_address['first_name']; ?>" type="text" placeholder="First Name">
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="lastNameInput"><?= lang('last_name') ?></label>
                                            <input id="lastNameInput" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name'];else if(isset($previous_address['last_name'])) echo $previous_address['last_name']; ?>" type="text" placeholder="<?= lang('last_name') ?>">
                                        </div>
                                       <div class="form-group required-field">
                                            <label for="phoneInput"><?= lang('phone') ?></label>
                                            <input id="phoneInput" class="form-control" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone'];else if(isset($previous_address['phone'])) echo $previous_address['phone']; ?>" type="text" placeholder="<?= lang('phone') ?>">
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="addressInput"><?= lang('address') ?></label>
                                            <textarea id="addressInput" name="address" class="form-control" rows="3"><?php if(isset($_POST['address'])) echo $_POST['address'];else if(isset($previous_address['address'])) echo $previous_address['address']; ?></textarea>
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="countryInput">Country</label>
                                            <select id="countryInput" name="country" class="form-control" onChange="changeCountry(this.value);">
                                            	 <option disabled="disabled" selected="selected">Select country</option>
                                           		 <?php foreach($country_list as $country){?>
                                                 <option value="<?php echo $country['id'];?>"><?php echo $country['country_name'];?></option>
                                                 <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="state"><?= lang('state') ?></label>
                                            <select id="stateInput" name="state" class="form-control" onChange="changeState(this.value);">
                                          		<option value="">-</option>
                                            </select>
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="postInput"><?= lang('city') ?></label>
                                            <select name="thana" id="thana" class="form-control" >
                                               <option value="">-</option>
                                            </select>
                                        </div>
                                        <div class="form-group required-field">
                                            <label for="postInput"><?= lang('post_code') ?></label>
                                            <input id="postInput" class="form-control" name="post_code" value="<?php if(isset($_POST['post_code'])) echo $_POST['post_code'];else if(isset($previous_address['post_code'])) echo $previous_address['post_code']; ?>" type="text" placeholder="<?= lang('post_code') ?>">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="notesInput"><?= lang('notes') ?></label>
                                            <textarea id="notesInput" class="form-control" name="notes" rows="3"><?php if(isset($_POST['notes'])) echo $_POST['notes'];else if(isset($previous_address['notes'])) echo $previous_address['notes']; ?></textarea>
                                        </div>
                                        <input type="hidden" id="guest_id" value="<?php if(isset($_SESSION['logged_user'])) echo $_SESSION['logged_user'];?>" />
                                        <input type="hidden" id="user_email" value="<?php if(isset($_SESSION['logged_email'])) echo $_SESSION['logged_email'];?>" />
                                        
                                        <div class="form-group">
                                        	<span class="required-field">(All * fields are mendatory)</span><br /><br />
                                        	<button type="button" class="btn btn-primary" id="save_address">Save Address</button>
                                            <button type="button" class="btn btn-primary" id="cancel_address">Cancel</button><br />
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
                                    	<li><input checked="checked" type="radio" name="payment_type" value="cashOnDelivery" />  <img src="<?= base_url('template/imgs/cash-on-delivery.png') ?>" alt="payment methods"></li>
                                         <?php } if ($freecharge_payment == 1) { ?>
                                        <li id="freecharge_payment"><input id="freecharge_payment_option" checked="checked" type="radio" name="payment_type" value="Freecharge" />&nbsp;UPI | Cards | Net Banking powered by <img style="width: 65px;" src="<?= base_url('template/imgs/FreeCharge_Logo.png') ?>" alt="payment methods"></li>
                                        <?php } if ($razorpay_payment == 1) { ?>
                                        <li><input id="razorpay_payment_option" checked="checked" type="radio" name="payment_type" value="Razorpay" />  <img src="<?= base_url('template/imgs/Razorpay_logo.png') ?>" alt="payment methods"></li>
                                        <?php } ?>
                                    </ul>
                                     <?php if ($codeDiscounts == 1) { ?>
                                        <div class="cart-discount" id="discount_form">
                                            <h4>Apply Discount Code</h4>
                                          
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" name="discountCode" value="<?= @$_POST['discountCode'] ?>" placeholder="Enter discount code">
                                                    <div class="input-group-append">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary" onclick="applycoupon()"><?= lang('check_code') ?></a>
                                                    </div>
                                                </div><!-- End .input-group -->
                                        </div>
                                        <?php } ?>
                                 </div>
     
                            </div>
                            
                           
                    </div><!-- End .col-lg-8 -->

                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3>Summary</h3>

							<table class="table table-mini-cart">
                                    <tbody>
                                        <tr>
                                         <?php 
										 $total_price = 0;
										 $weight = 0;
										 $weightdomestic = 0;
										 $vendor = array();
										 foreach ($cartItems['array'] as $item) { 
										 	$checkcourier_charge = $this->Public_model->checkcourier_charge($item['product_id']);
											array_push($vendor,$item['vendor_id']);
										 ?>
                                           <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                                           <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
                                            <td class="product-col">
                                                <figure class="product-image-container">
                                                    <a href="<?= LANG_URL . '/' . $item['url'] ?>" class="product-image">
                                                        <img src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" alt="<?= $item['title'] ?>">
                                                    </a>
                                                </figure>
                                                <div>
                                                    <h2 class="product-title">
                                                        <a href="<?= LANG_URL . '/' . $item['url'] ?>"><?= $item['title'] ?></a>
                                                    </h2>

                                                    <span class="product-qty">Qty: <?= $item['num_added'] ?></span>
                                                </div>
                                            </td>
                                            <td class="price-col"><?= CURRENCY.$item['price'] ?></td>
                                        </tr>
										 <?php 
										 if($item['weight_unit'] == 'grams')
										 $weight = $weight+(($item['weight']/1000)*$item['num_added']);
									     else
									     $weight = $weight+($item['weight']*$item['num_added']);
											 
										 if($checkcourier_charge=='1'){
											 if($item['weight_unit'] == 'grams')
											 $weightdomestic = $weightdomestic+(($item['weight']/1000)*$item['num_added']);
											 else
											 $weightdomestic = $weightdomestic+($item['weight']*$item['num_added']);
										 }
										 
										 $price = str_replace(",", "", $item['price']);  $total_price+=($price*$item['num_added']); } ?>
                                         <input type="hidden" id="grand_total" value="<?php echo $total_price;?>" />
                                         <input type="hidden" id="weight" value="<?php echo $weight;?>" />
                                         <input type="hidden" id="weightdomestic" value="<?php echo $weightdomestic;?>" />
                                         
                                    </tbody>    
                                </table>
                            <table class="table table-totals">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td><?= CURRENCY.$cartItems['finalSum'] ?></td>
                                    </tr>
									<tr>
                                        <td>Coupon Discount</td>
                                        <td><span id="discount-amount"><?= CURRENCY ?>0</span></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Charge</td>
                                        <td><span id="delivery_charges"><?= CURRENCY ?><span id="delivery_amount">0</span></span></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Order Total</td>
                                        <td><span id="total_price" class="final-amount"><?= CURRENCY ?><?= number_format($total_price,2) ?></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" name="selected_address_id" id="selected_address_id" value="" />
							<input  type="hidden" id="shpping_cost" name="shpping_cost" value="0" />
                            <input type="hidden" id="final-amount" name="final_amount" value="<?= $total_price ?>">
                            <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                            <input type="hidden" id="discountAmount" name="discountAmount" value="0">
                            <input type="hidden" id="vendors" value="<?php echo implode(",",$vendor);?>" />
                            <div class="checkout-methods">
                                <a href="javascript:void(0);" style="display:none" id="place_order" onclick="place_order()" class="btn btn-block btn-sm btn-primary">Place Order</a>
                                <span id="razorpay_payment_process" style="display:none">Processing your payment. Please do not press back button/refresh your page.</span>
                            </div><!-- End .checkout-methods -->
                        </div><!-- End .cart-summary -->
                    </div><!-- End .col-lg-4 -->
                    
                    <?php } ?>
                </div><!-- End .row -->
                </form>
                <form name='razorpayform' action="<?= LANG_URL . '/checkout/process_razorpay_payment';?>" method="POST">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
                </form>
            </div>     
