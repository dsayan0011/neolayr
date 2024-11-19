<style type="text/css">
    li {
  list-style-type: none;
}
</style>

<main>
   <section class="cart-page">
      <div class="container">
         <h1>Cart</h1>
         <form method="POST" id="goOrder">
            <div class="row">
               <div class="col-lg-8 cart-product-area ">
                  <div class="p-title-area p-mbl less-gap select_dd_add" id="select-a-delivery-address" style="cursor:pointer">
                    <?php if(sizeof($previous_address)>0){?>
						<div class="cart-heading-new">
							<h2>Select a delivery address</h2>
						</div>
                    <?php } else {?>
                        <div class="cart-heading-new">
                            <h2>Save your addresses now</h2>
                        </div>
                    <?php } ?>
					</div>
                    <div class="p-title-area p-mbl less-gap save_delivery_add" id="select-a-delivery-address" style="cursor:pointer; display: none;">
                    
                    </div>
                  <div class="address-list-area">
                     <div class="each--addressbox" id="fstAddress">
                        <table >
                        	<?php
                        	if($productVariant != ''){
                                $data_cart = array();
                                foreach($cartItems['array'] as $item){
                                    if($productVariant == $item['product_id']){
                                        array_push($data_cart, $item);
                                        //array_push($data_cart, $item['num_added'] = 1);
                                    }
                                }
                                $cartItems['array'] = $data_cart;
                                //$cartItems['array'][0]['num_added'] = 1;
                            }
                            // echo "<pre>";
                            // print_r($cartItems);
                            // exit;
                        $not_avialable = false;
                        $total_price = 0;
                        $weight = 0;
                        $weightdomestic = 0;
                        $vendor = array();
                        $delivery_time = 0;
                        $otherReferralPrice = $otherReferralPrices;
                        $qty = 0;
                        //echo $otherReferralPrice; exit;
                        //print_r($cartItems['array']);
                        foreach ($cartItems['array'] as $item) { 
                            $checkcourier_charge = $this->Public_model->checkcourier_charge($item['product_id']);
                                        array_push($vendor,$item['vendor_id']);
                            ?>
                     <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                     <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
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
                        
                        $price = str_replace(",", "", $item['price']);
                        $total_price += ($price*$item['num_added']);
                        $qty += $item['num_added'];
                        //echo "qty".$qty;
                        ?>
                     <?php } ?>

                           <?php
                           foreach($previous_address as $key => $addreess){?>
                           <tr>
                              <td><input type="radio" name="a"  <?php if($key == '0') echo 'checked'?> id="<?= $addreess['address_id']?>" onChange="setDeliveryAddress(<?=$addreess['address_id'];?>,<?=$addreess['state'];?>,'<?=$addreess['sortname'];?>',<?=$total_price;?>,<?=$totalReward['tier'];?>,<?=$addreess['post_code'];?>)"></td>
                              <td>
                                 <p><?=$addreess['first_name']. ', ' .$addreess['address']. ' ,' .$addreess['road_name']. ', ' .$addreess['city_name'] . ', ' .$addreess['state_name']. ', ' .$addreess['post_code'].', Phone number: '. $addreess['phone'] ?><br>
                                 	<a href="javascript:void(0)" onclick="edit_address('<?= $addreess['address_id']?>')">Edit address</a></p>
                              </td>
                           </tr>
                           <?php } ?>										
                           <tr>
                              <td colspan='2'><a href="javascript:void(0)" data-toggle="modal" data-target="#add-address" class="n-address check_address_avail">+ Add New Address</a></td>
                           </tr>
                        </table>
                     </div>
                     <div class="each--addressbox" id="secAddress" style="display: none;">

                     </div>
                  </div>
                  <?php /* if(sizeof($previous_address)){?>
                  <div class="use-this-address less-gap-n">
					 <a href="javascript:void(0)" class="use-address">Use this Address</a>
				  </div>
                  <?php } */ ?>
                  <?php if ($codeDiscounts == 1 && $quizdiscountAmoun == 0) { ?>
                  <div class="p-title-area p-mbl less-gap" id="open-coupon-code" style="cursor:pointer">
                     <div class="cart-heading-new">
                        <h2>COUPON CODE?</h2>
                     </div>
                  </div>
                  
                  <div class="p-title-area coupon-title before-apply" id="coupon-body"style="display:none;">
                     <div class="row">
                        <div class="col-lg-10" style="text-transform:uppercase;">have you got a Coupon code</div>
                        <div class="col-lg-2"><a href="#apply-cuppon" class="fancybox" >Apply</a></div>
                     </div>
                  </div>
                  <?php } ?>
                  <div class="p-title-area after-apply">
                    <div class="row">
                        <div class="col-10" style="text-transform:uppercase;" > 
                            <p class="applyedCouponCode m-0"></p>
                        </div>
                        <div class="col-2 text-lg-right"><a href="javascript:void(0)" class="open-before-apply coupon_cancel" >X</a></div>
                    </div>
                </div>
                  <div class="p-title-area p-mbl less-gap" id="redeem-reward" style="cursor:pointer">
                     <div class="cart-heading-new">
                        <h2>REDEEM REWARD</h2>
                     </div>
                  </div>
                  <div class="row card-cuppon mb-3" id="reedem-body" style="display:none">
                     <div class="col-md-6">
                        <div class="using-point">
                           <div id="" class="">
                              <?php if($pointBalance >= 1){?>
                                        <input type="checkbox" name="" class="open-otp-box check-reward">
                                    <?php } else { ?>
                                        <input type="checkbox" name="" class="open-otp-box check-reward" disabled="disabled">
                                    <?php } ?>
                           </div>
                           <div id="" class="">
                                        <h5>Pay using Points</h5>
                                        <?php if($pointBalance >= 1){?>
                                        <h6 class="rb">Remaining Balance: <?php echo $pointBalance; ?>pt</h6>
                                        <?php } else { ?>
                                            <h6 class="rb">Remaining Balance: 0pt</h6>
                                            <?php } ?>
                                        <h6 class="pbp">Paid by point: <?php echo $pointBalance; ?>pt</h6>
                                    </div> 
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="open-otp">
                                    <h5>Verify with OTP</h5>
                                    <div class="opt-box ">
                                        <div class="">
                                            <input type="text" name="reward_otp" id="reward_otp">
                                        </div>
                                        <div id="" class="">
                                            <input type="button" value="Confirm" onclick="reward_otp_submit();">
                                        </div>
                                    </div>
                                </div>
                     </div>
                  </div>


                  <div class="p-title-area p-mbl less-gap" id="gift-card" style="cursor:pointer">
                     <div class="cart-heading-new">
                        <h2>Gift Card?</h2>
                     </div>
                  </div>
                  <div class=" card-cuppon" id="gift-card-body" style="display:none">
                     
                     <div class="gift-coupan-area">
                         <div class="gift-coupan-text">
                            <input type="text" name="giftVoucher" id="giftVoucher" placeholder="Gift Code">
                         </div>
                         <div clas="gift-coupan-button">
                             <input type="button" class="gift-button" value="Apply" onclick="applyGiftVoucher()">
                         </div>
                         
                     </div>
                     <p class="voucher_not_applyed_text" style="display: none;">Not applicable</p>
                  </div>
                  <div class="p-title-area apply-gift-card" style="display: none;">
                    <div class="row">
                        <div class="col-10" style="text-transform:uppercase;"> 
                            <p class="applyedGiftCouponCode m-0"></p>
                        </div>
                        <div class="col-2 text-lg-right"><a href="javascript:void(0)" class="gift_coupon_cancel">X</a></div>
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
                                            <input type="text" name="discountCode" value="<?= @$_POST['discountCode'] ?>" placeholder="Enter a valid coupon Code">
                                        </div>

                                        <div  class="">
                                            <button type="button" class="first-sign"  onclick="applycoupon()";>Submit</button>
                                        </div>

                                    </div>
                                    <p class="not_applyed_text" style="display: none;">Not applicable</p>
                                    <?php foreach ($allCoupons as $key => $item) {
                                        

                                     ?>
                                    <div class="cuppon-no">
                                        <?php if($item['type'] == 'percent'){?>
                                        <div class="">
                                            <img src="<?= base_url('images/percent.png') ?>" width="65" height="64" border="0" alt="">
                                        </div>
                                        <?php } else { ?>
                                            <div class="">
                                            <img src="<?= base_url('images/offer.png') ?>" width="65" height="64" border="0" alt="">
                                        </div>
                                        <?php } ?>
                                        <div class="">
                                            <h3><?php echo $item['code'] ?></h3>
                                            <p><?php echo $item['description']?></p>
                                        </div>
                                        <div class="">
                                            <a id="apply<?php echo $key; ?>" class="apply" href="javascript:void(0);" data-id="<?php echo $key; ?>" onclick="singleCouponApply('<?= $item['code']; ?>','<?= $key; ?>')">APPLY</a>
                                            <a id="applyed<?php echo $key; ?>" class="applyed" data-id="<?php echo $key; ?>" href="javascript:void(0);" style="display: none;">APPLIED</a>
                                            <a id="not_applyed<?php echo $key; ?>" class="not_applyed" data-id="<?php echo $key; ?>" href="javascript:void(0);" style="display: none;">Not applicable</a>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
               <!-- ********************** -->
               <!-- <div style="display: none;">
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
                  </div> -->
               <!-- ********************** -->
               <div class="col-lg-4 cart-price-area">
                  <div class="cart-right-side">
                     <div class="p-title-area coupon-title businessdays">
                        <div class="row">
                           <div class="col-6" style="text-transform:uppercase;"><img src="<?= base_url('images/fast-delivery.png')?>"  alt="">DELIVERY</div>
                           <div class="col-6 text-right">
                           	<span class="daliveryDate" id="daliveryDate"><?php echo $_SESSION['daliveryDate']; ?></span></div>
                        </div>
                     </div>
                     <?php
                        $not_avialable = false;
                        $total_price = 0;
                        $weight = 0;
                        $weightdomestic = 0;
                        $vendor = array();
                        $delivery_time = 0;
                        $otherReferralPrice = $otherReferralPrices;
                        $qty = 0;
                        //echo $otherReferralPrice; exit;
                        foreach ($cartItems['array'] as $item) { 
                            $checkcourier_charge = $this->Public_model->checkcourier_charge($item['product_id']);
                                        array_push($vendor,$item['vendor_id']);
                            ?>
                     <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                     <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
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
                        
                        $price = str_replace(",", "", $item['price']);
                        $total_price += ($price*$item['num_added']);
                        $qty += $item['num_added'];
                        //echo "qty".$qty;
                        ?>
                     <?php } ?>
                     <input type="hidden" id="grand_total" value="<?php echo $total_price;?>" />
                     <input type="hidden" id="weight" value="<?php echo $weight;?>" />
                     <input type="hidden" id="weightdomestic" value="<?php echo $weightdomestic;?>" />
                     <input type="hidden" name="delivery_time" value="<?php echo $delivery_time;?>" />
                     <input type="hidden" id="subTotal" value="<?php echo $cartItems['finalSum'] - $otherReferralPrice;?>" />
                     <input type="hidden" name="redeem_paid_point" id="redeem_paid_point" value="<?php echo $pointBalance;?>" />
                     <h2 class="cat-top">Cart summary</h2>
                     <div class="cart-summery">
                        <table>
                           <tr>
                              <td>Merchandise Subtotal:</td>
                              <td><span class="count" id="subTotal"><?= CURRENCY.number_format(($total_price),2) ?></span></td>
                           </tr>
                           <tr>
                              <td>Shipping Cost:</td>
                              <td><span class="count" id="delivery_charges"><?= CURRENCY ?><span id="delivery_amount"><?php echo $delivery_amount;?></span></span></td>
                           </tr>
                           <tr>
                              <td><span class="">Coupon Discount:</span></td>
                              <td><span class="count discount-amount" id="discount-amount"><?= CURRENCY ?><?php echo $quizdiscountAmoun ? $quizdiscountAmoun : 0 ?></span></td>
                           </tr>
                           <tr class="gift_amount_tr" style="display: none;">
                                <td><span class="">Gift Discount:</span></td>
                                <td><span class="count gift_amount" id="gift_amount"><?= CURRENCY ?>0</span></td>
                            </tr>
                           <tr>
                              <td><span class="">Paid by Points:</span></td>
                              <td><span class="paid_amount"><?= CURRENCY ?>0</span></td>
                           </tr>
                           <?php if($otherReferralPrice != 0){?>
                           <tr>
                              <td><span class="">Referral Discount:</span></td>
                              <td><span class="referral_text">-<?= $otherReferralPrice ?></span></td>
                           </tr>
                           <?php } ?>
                           <tr>
                              <td>Total:</td>
                              <td><span class="count final-amount total_price"  id="total_price"><?= CURRENCY ?><?= number_format(($total_price+$delivery_amount - $otherReferralPrice - $quizTotAmoun),2) ?></span></td>
                           </tr>
                        </table>
                        <p><?php /*
                           $last_amt = 1000;
                           if( $total_price < $last_amt && $totalReward['tier'] == '1')  {?>
                        <p class="firstOpenSpend">Spend ₹<?php echo number_format($last_amt - $total_price) ?> more to get free delivery</p>
                        <?php } */ ?></p>
                        <?php /*if($totalReward['tier'] == '1'){?>
                        <p class="firsthideSpend" style="display: none;"></p>
                        <?php } */ ?>
                        <input type="hidden" name="selected_address_id" id="selected_address_id" value="<?php echo $selected_address_id?>" />
                        <input  type="hidden" id="user_email" name="user_email" value="<?php echo $user_email;?>" />
                        <input  type="hidden" id="coupon_code" name="coupon_code" value="" />
                        <input  type="hidden" id="shpping_cost" name="shpping_cost" value="<?php echo $delivery_amount;?>" />
                        <!-- <input type="hidden" id="final-amount" name="final_amount" value="<?= $total_price ?>"> -->
                        <input  type="hidden" id="paid_amount" name="paid_amount" value="0" />
                        <input type="hidden" id="merchandise_subtotal" name="merchandise_subtotal" value="<?= $total_price ?>">
                        <input type="hidden" name='referralCode' id="referralCode" class="referralCode" value="<?php echo $otherReferral; ?>" />
                        <input type="hidden" id="final-amount" name="final_amount" value="<?= ($total_price  + $delivery_amount - $otherReferralPrice - $quizTotAmoun); ?>">
                        <input type="hidden" id="final-amount-two" name="final_amount_two" value="<?= ($total_price + $delivery_amount - $otherReferralPrice - $quizTotAmoun)?>">
                        <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                        <input type="hidden" id="discountAmount" name="discountAmount" value="<?php echo $quizdiscountAmoun ? $quizdiscountAmoun : 0 ?>">
                        <input type="hidden" id="vendors" value="<?php echo implode(",",$vendor);?>" />
                        <input type="hidden" id="selectedAmount" name="selectedAmount" value="0">
                        <input type="hidden" name="paid_by_point" id="paid_by_point" value="0">
                        <input type="hidden" name="other_referral_prices" id="other_referral_prices" value="<?php echo $otherReferralPrices?>">
                        <input type="hidden" name="request_id" id="request_id" value="">
                        <input type="hidden" name="request_id_otp" id="request_id_otp" value="">
                        <input type="hidden" name="birthday_amount" class="birthday_amount" value="">
                        <input type="hidden" name="giftAmount" class="giftAmount" id="giftAmount" value="0">
                        <input type="hidden" id="grand_total" name="grand_total" value="<?php echo $total_price;?>" />
                        <input type="hidden" id="payment_type" name="payment_type" value="Razorpay">
                       
                        <input type="hidden" name="discountType" id="discountType" value="0">
                        <input type="hidden" name="coupon_discount_type" id="coupon_discount_type" value="">
                        <input type="hidden" id="subTotalTwo" value="<?php echo ($cartItems['flot_finalSum'] - $otherReferralPrice);?>" />

                         <input type="hidden" id="max_free_product" value="0" />
                      <input type="hidden" id="free_product_added" value="0" />
                      <input type="hidden" id="free_product_coupon" value="0" />
                      <input type="hidden" id="isReferral" class="isReferral" value="<?php echo $otherReferralPrice; ?>" />
                      <!-- <input type="hidden" name="selectedStateID" id="selectedStateID" value=""> -->
                        <input type="hidden" id="productVariant" name="productVariant" value="<?php echo $productVariant;?>" />
                        <?php /*?>
                        <h2 class="cat-top">Select Payment option</h2>
                                <div class="select-payment-option">
                                    <ul>
                                         <?php  if ($razorpay_payment == 1) { ?>
                                        <li><label><input type="radio" id="razorpay_payment_option"  name="payment_type" value="Razorpay" onclick="razorpayPayment()" checked="checked"> Online Payment</label></li>
                                    <?php } ?>
                                         <?php if ($cashondelivery_visibility == 1) { ?>
                                            <input type="hidden" name="selectedStateID" id="selectedStateID" value="<?php echo $selectedAddress?>">
                                        <li><label><input type="radio" name="payment_type" value="cashOnDelivery" id="cod"   onclick="changeCod()"> Cash on delivery</label></li>
                                    <?php } ?>
                                       

                                    </ul>
                                </div>
						<?php */ ?>
                        <!-- <a href="javascript:void(0)" class="gn-button place_order" id="place_order" onclick="place_order()">CHECKOUT</a> -->
                        <a href="javascript:void(0)"   class="gn-button processModal">PROCEED</a>

                        <!-- <a href="javascript:void(0)" class="gn-button please_wait" id="please_wait" style="display: none;">PROCESSING...</a>
                        <span id="razorpay_payment_process" style="display:none">Processing your payment. Please do not press back button/refresh your page.</span> -->
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
   </section>
   <div class="modal fade common-popup-style" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered payment-modal" role="document">
		<div class="modal-content">
		  <div class="modal-header">					
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
		  	<h2 class="cat-top payment-heading">Select Payment option</h2>
			<div class="select-payment-option">
				<ul>
                                         <?php  if ($razorpay_payment == 1) { ?>
                                        <li><label><input type="radio" id="razorpay_payment_option"  name="payment_type_option" value="Razorpay" onclick="razorpayPayment()" checked="checked"> Online Payment</label></li>
                                    <?php } ?>
                                         <?php if ($cashondelivery_visibility == 1) { ?>
                                            <input type="hidden" name="selectedStateID" id="selectedStateID" value="<?php echo $selectedAddress?>">
                                        <li><label><input type="radio" name="payment_type_option" value="cashOnDelivery" id="cod"   onclick="changeCod()"> Cash on delivery</label></li>
                                    <?php } ?>
                                       

                                    </ul>

			</div>
			<li><a href="javascript:void(0)" class="gn-button place_order" id="place_order" onclick="place_order()">CHECKOUT</a></li>
			<a href="javascript:void(0)" class="gn-button please_wait" id="please_wait" style="display: none;">PROCESSING...</a>
             <span id="razorpay_payment_process" style="display:none">Processing your payment. Please do not press back button/refresh your page.</span>
		  </div>				  
		</div>
	  </div>
	</div>
   <!-- SITE FOOTER-->
   <!-- END FOOTER-->
   

   <div class="modal fade common-popup-style" id="add-address" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeAddModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					
         <div class="login-inner add-address" id="order_add_newAddress">
            <div class="f-login f-address" >
               <h2 class="add_n_add">ADD new address</h2>
               <h2 class="edit_n_add" style="display: none;">Edit address</h2>
               <div class="text-left ">
                  <div class="row">
                     <div class="col-lg-12">
                        <label> Name*</label>
                        <input type="text" name="add_name" id="add_name" class="add-field" placeholder="Name" value="">
                        <p class="wrong_registration wrong_firstName" id="wrong_firstName">Please Enter Name</p>
                     </div>
                     <!-- <div class="col-lg-6">
                        <label>Last Name*</label>
                        <input type="text" name="add_last_name" id="add_last_name" class="add-field" placeholder="Name">
                        <p class="wrong_registration wrong_lastName" id="wrong_lastName">Please enter Last Name</p>
                        </div> -->
                     <div class="col-lg-6">
                        <label>Mobile Number*</label>
                        <input type="text" name="add_mob" id="add_mob" class="add-field" placeholder="Mobile Number" maxlength="10" onkeypress="return isNumber(event)" value="">
                        <p class="wrong_registration wrong_mobileNumber" id="wrong_mobileNumber">Please enter  Mobile Number</p>
                        <p class="wrong_registration mobileNumber_exists" id="mobileNumber_exists">Mobile number already exist</p>
                     </div>
                     <div class="col-lg-6">
                        <label>PINCode*</label>
                        <input type="text" name="add_pincode" id="add_pincode" class="add-field" placeholder="Pincode" maxlength="6" onkeypress="return isNumber(event)">
                        <p class="wrong_registration mobileNumber_exists select_pincode" id="select_pincode">Please enter Pincode</p>
                     </div>
                     <div class="col-lg-12"></div>
                     <div class="col-lg-6">
                        <label>State*</label>
                        <input type="text" name="state" id="stateInput" class="add-field" placeholder="State">
                        <!-- <select id="stateInput" name="state" class="add-field add_state" onChange="changeState(this.value);">
                           <option value="">-</option>
                           <?php foreach($state_list as $state){?>
                            <option value="<?php echo $state['id'];?>"><?php echo $state['state_name'];?></option>
                            <?php } ?>
                           </select> -->
                        <p class="wrong_registration mobileNumber_exists select_state" id="select_state">Please Enter State</p>
                     </div>
                     <div class="col-lg-6">
                        <label>City*</label>
                        <!-- <select name="thana" id="thana" class="add-field" >
                           <option value="">-</option>
                           </select> -->
                        <input type="text" name="thana" id="thana" class="add-field" placeholder="City">
                        <p class="wrong_registration mobileNumber_exists select_city" id="select_city">Please Enter City</p>
                     </div>
                     <div class="col-lg-6">
                        <label>House No., Building Name*</label>
                        <input type="text" name="add_build_name" id="add_build_name" class="add-field" placeholder="House No., Building Name">
                        <p class="wrong_registration mobileNumber_exists select_build_name" id="select_build_name">Please enter House No., Building Name</p>
                     </div>
                     <div class="col-lg-6">
                        <label>Road Name, Area, Colony*</label>
                        <input type="text" name="add_road_name" id="add_road_name" class="add-field" placeholder="Road Name, Area, Colony">
                        <p class="wrong_registration mobileNumber_exists select_road_name" id="select_build_name">Please enter Road Name, Area, Colony</p>
                     </div>
                     <div class="col-lg-6">
                        <label>Landmark</label>
                        <input type="text" name="landmark" id="landmark" class="add-field" placeholder="Landmark">
                     </div>
                     
                     <div class="col-lg-6 ad_add">
                        <!-- <input type="button" value="Save Address" class="first-sign new_address"> -->
                        <button type="button" class="first-sign " id="add_address" onclick="add_address()";>Save</button>
                     </div>
                     <div class="col-lg-6 ed_add" style="display: none;">
                        <!-- <input type="button" value="Save Address" class="first-sign new_address"> -->
                        <input type="hidden" name="address_id" id="address_id" value="">
                        <button type="button" class="first-sign" id="add_address" onclick="update_address()";>Save</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="freeCartProduct" role="dialog" data-keyboard="false" data-backdrop="static">
                 <div class="modal-dialog">
                    <div class="modal-content" id="freeProduct"> </div>
                 </div>
    </div>
</main>
<style>
    @media(max-width:991px){
        .cart-price-area{
            position:static;
        }
        .cart-gap{
            height:70px;
        }
        .cart-summery a.gn-button {
            position: fixed;
            width: 100%;
            left: 0px;
            bottom: 53px;
            z-index: 9999;
            border: 2px solid #fff;
            font-size:18px;
        }
        .cart-price-area {            
            padding: 15px;            
            box-shadow: none;
        }
        .p-mbl{
            display: block;
        }
    }
</style>