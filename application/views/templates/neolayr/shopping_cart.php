 
<!-- <section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>cart</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="cart-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
             <?php
				if ($cartItems['array'] == null) {
					?>
                   <div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
					<?php
				} else {?>
                
                <table class="table cart-table table-responsive-xs striped-table">
                    <thead>
                    <tr class="table-head">
                        <th scope="col">image</th>
                        <th scope="col">product name</th>
                        <th scope="col">price</th>
                        <th scope="col">quantity</th>
                        <th scope="col">action</th>
                        <th scope="col">total</th>
                    </tr>
                    </thead>
                    
                    <?php
					$not_avialable = false;
					foreach ($cartItems['array'] as $item) { ?>
                    <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                    <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
                    <tbody>
                    <tr>
                        <td>
                            <a href="<?= LANG_URL . '/' . $item['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" alt=""></a>
                        </td>
                        <td><a href="<?= LANG_URL . '/' . $item['url'] ?>"><?= $item['title'] ?></a>
                         <?php if($item['vendor_status'] == '0' || $item['variant_status']!='show' || $item['quantity']<1 ){ $not_avialable = true; ?> <span class="not_available">Currently not available</span><?php } ?>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group cart_quanitity">
                                        	<span class="quantity-num"> <?= $item['num_added'] ?></span>
                                            <span class="input-group-btn-vertical">
                                                <a class="btn btn-outline bootstrap-touchspin-up icon-up-dir refresh-me add-to-cart <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);"></a>
                                                <a class="btn btn-outline bootstrap-touchspin-down icon-down-dir" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);"></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><?= CURRENCY.$item['price']?></h2></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="javascript:void(0)" onclick="deleteFromCart(<?= $item['id'] ?>)" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h2><?= CURRENCY.$item['price']?></h2></td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group cart_quanitity">
                                    <span class="quantity-num"> <?= $item['num_added'] ?></span>
                                    <span class="input-group-btn-vertical">
                                                <a class="btn btn-outline bootstrap-touchspin-up icon-up-dir refresh-me add-to-cart <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);"><i class="fa fa-angle-up"></i></a>
                                                <a class="btn btn-outline bootstrap-touchspin-down icon-down-dir" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td><a href="javascript:void(0)" onclick="deleteFromCart(<?= $item['id'] ?>)" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color"><?= CURRENCY.$item['sum_price']?></h2></td>
                    </tr>
                    </tbody>
                  <?php } ?>
                </table>
                <table class="table cart-table table-responsive-md">
                    <tfoot>
                    <tr>
                        <td>total price :</td>
                        <td>
                            <h2><?= CURRENCY.$cartItems['finalSum'] ?></h2></td>
                    </tr>
                    </tfoot>
                </table>
                <?php } ?>
            </div>
        </div>
        <div class="row cart-buttons">
            <div class="col-6"><a href="<?php echo base_url();?>" class="btn btn-solid">continue shopping</a></div>
            <div class="col-6">
           						<?php 
								if($not_avialable){?>
									<span class="cart_message">One or more item is not avaialbe in your cart. Please remove them to proceed checkout</span>
								<?php }else{ ?>
                                <a href="<?= LANG_URL . '/checkout' ?>" class="btn btn-solid">Go to Checkout</a>
                                <?php } ?>
			</div>
        </div>
    </div>
</section> -->
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
                    border: 2px solid #dddddd;
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
        <main id="cart_page">
            <section class="cart-page">
                <div class="container">
                    <h1>Cart</h1>
                    <?php
                    //echo "<pre>";
                    //print_r($cartItems['array']);
                    //exit;
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
                    // print_r($cartItems['array']);
                    // exit;

                    

                if ($cartItems['array'] == null) {
                    ?>
                   <div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
                    <?php
                } else {?>
                    <div class="row">
                        <div class="col-lg-8 cart-product-area">
                            <div class="p-title-area p-mbl">
                                <div class="row">
                                    <div class="col-3">Item</div>
                                    <div class="col-5"></div>
                                    <div class="col-2">Qty</div>
                                    <div class="col-2">Price</div>
                                </div>
                            </div>
                            <!--  -->
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

                                 // echo "<pre>";
                                 // print_r($item);
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
                                             $total_price+=($price*$item['num_added']);
                                             $qty += $item['num_added'];
                                             //echo "price".$price*$item['num_added'];
                                             ?>
                                         
                                         <input type="hidden" id="weight" value="<?php echo $weight;?>" />
                                         <input type="hidden" id="weightdomestic" value="<?php echo $weightdomestic;?>" />
                                         <input type="hidden" name="delivery_time" value="<?php echo $delivery_time;?>" />
                                          <input type="hidden" id="subTotal" value="<?php echo ($cartItems['finalSum'] - $otherReferralPrice);?>" />
                                          <input type="hidden" id="max_free_product" value="0" />
                                          <input type="hidden" id="free_product_added" value="0" />
                                          <input type="hidden" id="free_product_coupon" value="0" />
                                          <input type="hidden" id="isReferral" class="isReferral" value="<?php echo $otherReferralPrice; ?>" />
                            <div id="show_product">
                            <div class="each-p-product">
                                <div class="row">
                                    
                                    <div class="col-5 col-md-3">
                                        <a href="<?= LANG_URL . '/' . $item['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" width="100%" height="auto" border="0" alt=""></a>
                                    </div>                          
                                    <div class="col-7 col-md-9">
                                        <div class="row">
                                            <div class="col-12 col-md-6 cart-product">
                                                <p><a href="<?= LANG_URL . '/' . $item['url'] ?>"><?= $item['product_title'] ?></a></p>
                                                <?php if($item['variant_status']!='show' || $item['quantity']<1 ){ $not_avialable = true; ?> <span class="not_available">Currently not available</span><?php } ?>
                                                <p class="shop_weight">Weight : <?= $item['weight']. $item['weight_unit'] ?></p>
                                                
                                            </div>

                                            <div class="col-6 col-md-3">
                                                <div class="button-container">
                                                    <div id="" class="">
                                                        <a class="cart-qty-minus" <?php if($item['num_added'] > 1 ){ ?> onclick="removeProduct(<?= $item['id'] ?>, true)" <?php } ?> data-id="<?= $item['id'] ?>" href="javascript:void(0);" type="button" value="-">-</a>
                                                    </div>
                                                    <div id="" class="">
                                                        <input type="text" name="qty" disabled="disabled" class="qty quantity-num" maxlength="12" value="<?= $item['num_added'] ?>" class="input-text qty" />
                                                    </div>
                                                    <div id="" class="">
                                                        <a class="cart-qty-plus refresh-me add-to-cart <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);" type="button" value="+">+</a>
                                                    </div>                                                  
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <h6 class="cart-price td-color"><?= CURRENCY.number_format($price*$item['num_added'], 2)?></h6>
                                                <!-- <h6 class="cart-price td-color"><?= CURRENCY.number_format($item['price'],2)?></h6> -->
                                            <!-- <div class="col-2 ">
                                                <h6 class="cart-price td-color"><?= CURRENCY.$item['sum_price']?></h6>
                                            </div> -->
                                            </div>
                                            <!-- <div class="col-12 col-md-6 cart-product return_available"><p>7 days return available</p>
                                            </div> --> 
                                            <!-- <div class="col-6 col-md-6 test"><h6>Delivery by 21 Sep 2023</h6>
                                            </div> --> 
                                        </div>
                                    </div>
                                
                            </div>
                            <div class="each-p-product-bottom">
                                    <ul>
                                        <li><a href="javascript:void(0);" onclick="deleteFromCart(<?= $item['id'] ?>)">Remove</a></li>
                                        <li><a href="javascript:void(0);" onclick="add_item_to_wishlist(<?= $item['id'] ?>)">add to wishlist</a></li>
                                    </ul>
                                </div>
                        </div>
                        </div>
                        <?php } ?>
                            
                            <!-- <div class="select-payment-option p-title-area">
                                <div class="" style="text-transform:uppercase;">BUYING FOR</div>
                                <ul>
                                    <li><label><input type="radio" name="t">Self</label></li>
                                    <li><label><input type="radio" name="t">Spouse</label></li>
                                    <li><label><input type="radio" name="t">Family</label></li>
                                    <li><label><input type="radio" name="t">Friend/Others</label></li>
                                </ul>
                            </div> -->
                            <?php /*  if ($codeDiscounts == 1) { ?>
                            <div class="p-title-area before-apply">
                                <div class="row">
                                    <div class="col-lg-10" style="text-transform:uppercase;">have you got a Coupon code</div>
                                    <div class="col-lg-2 text-lg-right"><a href="#apply-cuppon" class="fancybox" >Apply</a></div>
                                </div>
                            </div>
                        <?php } */ ?>
                            <div class="p-title-area after-apply">
                                <div class="row">
                                    <div class="col-lg-10" style="text-transform:uppercase;" > 
                                        <p class="applyedCouponCode"></p>
                                    </div>
                                    <div class="col-lg-2 text-lg-right"><a href="javascript:void(0)" class="open-before-apply coupon_cancel" >X</a></div>
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
                       <!--  <div style="display: none;">
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
                            <div class="cart-right-side proceed-content">
                                <div class="">
                                    <?php 
                           $last_amt = 1000;
                           if( $total_price < $last_amt && $totalReward['tier'] == '1')  {?>
                        <p class="firstOpenSpend">Spend ₹<?php echo number_format($last_amt - ($total_price - $quizTotAmoun),2) ?> more to get free delivery</p>
                        <?php } /*else if($total_price < $last_amt) { ?>
                                    <p class="firstOpenSpend">Spend ₹<?php echo number_format($last_amt - ($total_price - $quizTotAmoun),2) ?> more to get free delivery</p>
                                    <?php /*} else{*/ ?>

                                    <?php /*}*/ ?>
                                    
                                    <?php if(!isset($_SESSION['logged_user'])) {?>
                                        <h3>Subtotal (<?= $qty;?> item):   <?= CURRENCY.number_format(($total_price),2)  ?></h3>
                                    <a href="#login" class="shopping_login n-address fancybox common-button " style="color:#fff">Proceed to Buy</a>
                                <?php } else { ?>
                                    <h3>Subtotal (<?= $qty;?> item):   <?= CURRENCY.number_format(($total_price - $quizdiscountAmoun),2)  ?></h3>
                                    <?php if($not_avialable){?>
                                        <span class="cart_message not_available">One or more item is not avaialbe in your cart. Please remove them to proceed checkout</span>

                                    <?php } else{ ?>
                                    <?php if($productVariant != ''){?>
                                    <a href="<?= LANG_URL . '/summary'.'?variant='.$productVariant ?>" class=" common-button" style="color:#fff">Proceed to Buy</a>
                                   <?php } else if($quizProduct != ''){?> 
                                    <a href="<?= LANG_URL . '/summary'.'?quiz=yes'.$productVariant .'&category_type='.$quizProductCategory?>" class=" common-button" style="color:#fff">Proceed to Buy</a>
                                    <?php } else { ?>
                                     <a href="<?= LANG_URL . '/summary' ?>" class=" common-button" style="color:#fff">Proceed to Buy</a>
                                  <?php } ?>  
                                <?php } }?>
                                </div>
                            </div>
                            <?php /*?>
                            <div class="cart-right-side">
                                <?php if($previous_address){?>
                                <h2>Delivered to</h2>
                                 <div class="edit-address mb-4">
                                    <p><strong><?php echo $previous_address[0]['first_name'] ?> <?php echo $previous_address[0]['last_name'] ?></strong><a href="<?= LANG_URL . '/edit_address/'.$previous_address[0]['address_id'] ?>">Edit</a></p>
                                    <p><?=$previous_address[0]['address'].',<br>'.$previous_address[0]['city_name'].','.$previous_address[0]['state_name'].','.$previous_address[0]['country_name'].',<br>Pin Code - '.$previous_address[0]['post_code'].',<br>'.'Phone No. - '.$previous_address[0]['phone'];?></p>
                                    <div class="remove-address d-flex justify-content-between">
                                        <a href="javascript:void(0)" onclick="deleteShippingAddress(<?=$previous_address[0]['address_id'];?>)">Remove</a>
                                        <a href="#add-address" class="fancybox">+ Add new address</a>
                                    </div>
                                </div> 
                            <?php } else {?>
                                <?php if(!isset($_SESSION['logged_user'])) {?>
                                <a href="#login" class="n-address fancybox">+ Add new address</a>
                            <?php } else{?>
                                <a href="#add-address" class="n-address fancybox">+ Add new address</a>
                            <?php } }?>
                             <?php */ ?>

                              <?php /*?>
                                <h2>redeem reward</h2>
                                <div class="using-point">
                                    <div id="" class="">
                                        <?php if($pointBalance > 0){?>
                                        <input type="checkbox" name="" class="open-otp-box check-reward">
                                    <?php } else { ?>
                                        <input type="checkbox" name="" class="open-otp-box check-reward" disabled="disabled">
                                    <?php } ?>
                                    </div>
                                    <div id="" class="">
                                        <h5>Pay using Points</h5>
                                        <?php if($pointBalance > 0){?>
                                        <h6 class="rb">Remaining Balance: <?php echo $pointBalance; ?>pt</h6>
                                        <?php } else { ?>
                                            <h6 class="rb">Remaining Balance: 0pt</h6>
                                            <?php } ?>
                                        <h6 class="pbp">Paid by point: <?php echo $pointBalance; ?>pt</h6>
                                    </div>                                  
                                </div>
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
                                 <?php */ ?>
                                  <?php /*?>
                                <h2 class="cat-top">Cart summary</h2>
                                <div class="cart-summery">
                                    <table>
                                        <tr>
                                            <td>Merchandise Subtotal:</td>
                                            <td id="subTotal"><?= CURRENCY.number_format(($total_price),2)  ?></td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Cost:</td>
                                            <td><span class="count" id="delivery_charges"><?= CURRENCY ?><span id="delivery_amount_two">0</span></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Coupon Discount:</span></td>
                                            <td><span class="" id="discount-amount">0</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Paid by Points:</span></td>
                                            <td><span class="paid_amount">0</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Gift Discount:</span></td>
                                            <td><span class="count gift_amount" id="gift_amount"><?= CURRENCY ?>0</span></td>
                                        </tr>
                                        <?php if($otherReferralPrice != 0){?>
                                         <tr>
                                            <td><span class="">Referral Discount:</span></td>
                                            <td><span class="referral_text">-200</span></td>
                                        </tr>
                                    <?php } ?>

                                        <tr>
                                            <td>Total:</td>
                                            <td><span class="final-amount" id="total_price"><?= CURRENCY ?><?= number_format(($total_price - $otherReferralPrice),2) ?></span></td>
                                        </tr>                                       
                                    </table>

                                    <!-- <input type="hidden" name="selected_address_id" id="selected_address_id" value="" /> -->
                                    <!-- <input  type="hidden" id="shpping_cost" name="shpping_cost" value="0" /> -->
                                    <input type="hidden" id="final-amount" name="final_amount" value="<?= ($total_price - $otherReferralPrice); ?>">
                                    <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                                    <input type="hidden" id="discountAmount" name="discountAmount" value="0">
                                    <input type="hidden" id="discountType" value="0">
                                    <input type="hidden" id="subTotalTwo" value="<?php echo ($cartItems['flot_finalSum'] - $otherReferralPrice);?>" />
                                    <input type="hidden" id="vendors" value="<?php echo implode(",",$vendor);?>" />

                                    <?php 
                                    $last_amt = 1000;
                                    if( $total_price < $last_amt && $totalReward['tier'] == '1')  {?>
                                        <p class="firstOpenSpend">Spend ₹<?php echo number_format($last_amt - $total_price) ?> more to get free delivery</p> <?php } ?>
                                        <?php if($totalReward['tier'] == '1'){?>
                                    <p class="firsthideSpend" style="display: none;"></p>
                                <?php } ?>
                                    <?php 
                                if($not_avialable){?>
                                    <span class="cart_message not_available">One or more item is not avaialbe in your cart. Please remove them to proceed checkout</span>
                                <?php }else{ ?>
                                    <?php if(!isset($_SESSION['logged_user'])) { ?>
                                    <a href="#login" class="gn-button fancybox" >Continue</a>
                                    <?php } else { ?>
                                    <a href="javascript:void(0)" class="gn-button" onclick="gotocheckout_page()">Continue</a>
                                    <?php } }?>
                                </div>
                                 <?php */ ?>

                            </div>
                        </div>  
                    </div>
                    
                     </div>
                <?php } ?>
                </div>
            </section>
            <?php if(sizeof($recentlyAdded)){?>
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
                                            $wishListData = $this->Public_model->wishListSelectedData($recently['id'],$_SESSION['logged_user']);
                                            $quantity = $this->Public_model->getquantity($recently['id']);
                                             ?>
                                    <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <?php if(!isset($_SESSION['logged_user'])){?>
                                         <div id="" class="wishlist-img">
                                            <a href="#login" class="fancybox">
                                                <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                            </a>
                                        </div>
                                 <?php }else{?>
                                        <div id="newArivalListAdd<?= $recently['id'] ?>" class="wishlist-img <?php if($recently['id'] == $wishListData['product_id']) echo 'active';?>" data-target="add">
                                            <a href="javascript:void(0);" onclick="newArival_add_remove_to_wishlist(<?= $recently['id'] ?>)">
                                            <i class="far fa-heart"></i></a>
                                        </div>
                                    <?php } ?>
                                            <div class="product-image">
                                                <a href="<?= LANG_URL . '/' . $recently['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $recently['image']) ?>" border="0" alt="" class="w-100">
                                                </a>
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p><a href="<?= LANG_URL . '/' . $recently['url'] ?>"><?= $recently['p_title'] ?>
                                                <?php /* echo $recently['weight'] ?> <?php echo $recently['weight_unit'] */?></a></p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <?php if ($quantity[0]['quantity'] != 0){
                                            ?>
                                                <a href="javascript:void(0)" class="add_item_cartpage" data-id="<?php echo $recently['variant_id'] ?>">ADD to cart <span>| </span> <?php if($recently['default_price'] != '0') echo CURRENCY.number_format($recently['default_price'], 2); else echo 'Coming soon' ?></a>
                                            <?php } else{ ?>
                                                <a href="javascript:void(0)" class="">Coming soon</a>
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev product-prev1 common-prev"><img src="<?= base_url('images/left-arrow.png') ?>" alt=""></div>
                            <div class="swiper-button-next product-next1 common-next"><img src="<?= base_url('images/right-arrow.png') ?>" alt=""></div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>
            <?php if(sizeof($featuredProducts)){?>
            <section class="featured-producted">
                <div class="container">
                    <h2 class="text-center">Featured Products</h2>
                    <div class="product-sl-list position-relative">
                        <div class="each-slide">
                            <div class="swiper-container testimonial-slider-new">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <?php 
                                        $counter = 0;
                                        foreach($featuredProducts as $featured){
                                            $wishListData = $this->Public_model->wishListSelectedData($featured['id'],$_SESSION['logged_user']);
                                            $quantity = $this->Public_model->getquantity($featured['id']);
                                             ?>
                                    <div class="swiper-slide">
                                        <div class="each-listing-of-product">
                                            <?php if(!isset($_SESSION['logged_user'])){?>
                                         <div id="" class="wishlist-img">
                                            <a href="#login" class="fancybox">
                                                <img src="<?= base_url('images/heart.png'); ?>"  border="0" alt="">
                                            </a>
                                        </div>
                                 <?php }else{?>
                                        <div id="featuredListAdd<?= $featured['id'] ?>" class="wishlist-img <?php if($featured['id'] == $wishListData['product_id']) echo 'active';?>" data-target="add">
                                            <a href="javascript:void(0);" onclick="featured_add_remove_to_wishlist(<?= $featured['id'] ?>)">
                                            <i class="far fa-heart"></i></a>
                                        </div>
                                    <?php } ?>
                                            <div class="product-image">
                                                 <a href="<?= LANG_URL . '/' . $featured['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $featured['image']) ?>" border="0" alt="" class="w-100">
                                                </a>
                                            </div>
                                            <div class="product-short-decription text-center">
                                                <p><a href="<?= LANG_URL . '/' . $featured['url'] ?>"><?= $featured['p_title'] ?>
                                                </a></p>
                                            </div>
                                            <div class="product-price-and-description text-center">
                                                <?php if ($quantity[0]['quantity'] != 0){
                                            ?>
                                                <a href="javascript:void(0)" class="add_item_cartpage" data-id="<?php echo $featured['variant_id'] ?>">ADD to cart <span>| </span> <?php if($featured['default_price'] != '0') echo CURRENCY.number_format($featured['default_price'], 2); else echo 'Coming soon' ?></a>
                                                <?php } else{?>
                                                    <a href="javascript:void(0)" class="">Coming soon</a>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev testimonial-prev-new common-prev"><img src="<?= base_url('images/left-arrow.png') ?>" alt=""></div>
                            <div class="swiper-button-next testimonial-next-new common-next"><img src="<?= base_url('images/right-arrow.png') ?>" alt=""></div>
                        </div>
                    </div>
                </div>
                
            </section>
        <?php } ?>
            <!-- SITE FOOTER-->
            <!-- <div class="modal fade" id="freeCartProduct" role="dialog" data-keyboard="false" data-backdrop="static">
                 <div class="modal-dialog">
                    <div class="modal-content" id="freeProduct"> </div>
                 </div>
            </div> -->
            <!-- END FOOTER-->
        </main>
        <main id="checkout_page" style="display : none;">

            <!-- START CHECKOUT -->
             <section class="cart-page" >
                <div class="container">
                    <h1>Cart</h1>
                    <form method="POST" id="goOrder">
                    <div class="row">
                        <div class="col-lg-8 cart-product-area">
                            <div class="address-list-area">
                                <!-- <h4>Address List Area</h4>
                                <?php foreach($previous_address as $addreess){?>
                                <div class="each--addressbox">
                                    <h5><?=$addreess['first_name'].' '.$addreess['last_name']?></h5>
                                    <p><?='Phone - '.$addreess['phone'].',<br>Address - '.$addreess['address'].',<br>'.$addreess['state_name'].','.$addreess['city_name'].','.$addreess['country_name'].',<br>Pin Code - '.$addreess['post_code'];?></p>
                                    <ul>
                                        <li><a href="javascript:void(0)" onclick="setDeliveryAddress(<?=$addreess['address_id'];?>,<?=$addreess['state'];?>,'<?=$addreess['sortname'];?>',<?=$cartItems['flot_finalSum'];?>)">Select This Address</a></li>
                                        <li><a href="javascript:void(0)" onclick="editDeliveryAddress(<?php echo $addreess['address_id'] ?>)" class="fancybox">Edit</a></li>
                                    </ul>
                                </div>
                            <?php } ?> -->
                            <h4>Address List Area</h4>
                                <div class="row">                                    
                                    <?php foreach($previous_address as $addreess){?>
                                    <div class="col-lg-6">
                                        <div class="each--addressbox position-relative ad_select ">
											<a href="javascript:void(0)" class="select-address" onclick="setDeliveryAddress(<?=$addreess['address_id'];?>,<?=$addreess['state'];?>,'<?=$addreess['sortname'];?>',<?=$total_price;?>,<?=$totalReward['tier'];?>)">
                                            <h5><?=$addreess['first_name'].' '.$addreess['last_name']?></h5>
                                                <p><?='Phone No - '.$addreess['phone'].',<br>Address - '.$addreess['address'].',<br>'.$addreess['city_name'].','.$addreess['state_name'].','.$addreess['country_name'].',<br>Pin Code - '.$addreess['post_code'];?></p>
                                            <span class="first-mode">Select Address</span><span class="second-mode">Selected</span></a>
											<!-- <label><input type="radio" id="razorpay_payment_option" name="payment_type" value="Razorpay" onclick="razorpayPayment()" checked="checked"> <strong>Select This Address</strong></label> -->
                                            <div class="edit-address-and-remove-address-area">
                                                <ul>
                                                    <li><a href="javascript:void(0)" onclick="deleteShippingAddress(<?=$addreess['address_id'];?>)"><i class="fas fa-trash-alt"></i></a></li>
                                                    <li><a href="<?= LANG_URL . '/edit_address/'.$addreess['address_id'] ?>" ><i class="fas fa-edit"></i></a></li>
                                                    <!-- <li><a href="javascript:void(0)"  onclick="editDeliveryAddress(<?php echo $addreess['address_id'] ?>)" class="fancybox"><i class="fas fa-edit"></i></a></li> -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php   } ?>
                                    <!-- <div class="col-lg-6">
                                        <div class="each--addressbox position-relative">
                                            <h5>Address 1</h5>
                                            <p>20/A Deshapriya Nagar, <br>
                                                Belgharia<br>
                                                Near k8 Bustand<br>
                                                Kolkata - 70056</p>
                                            <a href="" class="select-address">Select Address</a>
                                            <div class="edit-address-and-remove-address-area">
                                                <ul>
                                                    <li><a href=""><i class="fas fa-trash-alt"></i></a></li>
                                                    <li><a href=""><i class="fas fa-edit"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
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
                                    <div class="col-lg-2"><a href="#apply-gift" class="fancybox" >Apply</a></div>
                                </div>
                            </div>
							
                        </div>
                        <!-- ********************** -->
                        <div style="display: none;">
                            <div id="apply-gift" style="width:879px; max-width:100%; overflow:hidden; padding:10px; background:#fff   ">
                                <div class="login-inner cuppon-form-outer" >
                                    <h2>Apply voucher</h2>
                                    <div class="cuppon-form">
                                        <div class="">
                                            <input type="text" name="giftVoucher" id="giftVoucher" placeholder="Enter a valid voucher Code">
                                        </div>
                                        <!-- <div  class="">
                                            <input type="submit" value="Check" class="v-check">
                                        </div> -->
                                         <button type="button" class="first-sign"  onclick="applyGiftVoucher()">Submit</button>
                                    </div>
									<p class="voucher_not_applyed_text" style="display: none;">Not applicable</p>
                                    <!-- <div class="cuppon-no">
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
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- ********************** -->
                        <div style="display: none;">
                            <div id="add-address" style="width:879px; max-width:100%; overflow:hidden; padding:10px; background:#fff">
                                <div class="login-inner add-address" >
                                    <div class="f-login f-address" >
                                        <h2>ADD new address</h2>                                        
                                        <div class="text-left ">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>First Name*</label>
                                                    <input type="text" name="add_name" id="add_name" class="add-field" placeholder="Name">
                                                    <p class="wrong_registration wrong_firstName" id="wrong_firstName">Please enter First Name</p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Last Name*</label>
                                                    <input type="text" name="add_last_name" id="add_last_name" class="add-field" placeholder="Name">
                                                    <p class="wrong_registration wrong_lastName" id="wrong_lastName">Please enter Last Name</p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Mobile Number*</label>
                                                    <input type="text" name="add_mob" id="add_mob" class="add-field" placeholder="Mobile Number" maxlength="10" onkeypress="return isNumber(event)">
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
                                                    <select id="stateInput" name="state" class="add-field add_state" onChange="changeState(this.value);">
                                                    <option value="">-</option>
                                                    <?php foreach($state_list as $state){?>
                                                     <option value="<?php echo $state['id'];?>"><?php echo $state['state_name'];?></option>
                                                     <?php } ?>

                                                
                                            </select>
                                            <p class="wrong_registration mobileNumber_exists select_state" id="select_state">Please select State</p>
                                                    
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>City*</label>
                                                    <select name="thana" id="thana" class="add-field" >
                                                       <option value="">-</option>
                                                    </select>
                                                    <p class="wrong_registration mobileNumber_exists select_city" id="select_city">Please select City</p>
                                                    <!-- <input type="text" name="add_city" id="add_city" class="add-field" placeholder="City"> -->
                                                </div>
                                                <div class="col-lg-12">
                                                    <label>House No., Building Name*</label>
                                                    <input type="text" name="add_build_name" id="add_build_name" class="add-field" placeholder="House No., Building Name">
                                                    <p class="wrong_registration mobileNumber_exists select_build_name" id="select_build_name">Please enter House No., Building Name</p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label>Road Name, Area, Colony*</label>
                                                    <input type="text" name="add_road_name" id="add_road_name" class="add-field" placeholder="Road Name, Area, Colony">
                                                    <p class="wrong_registration mobileNumber_exists select_road_name" id="select_build_name">Please enter Road Name, Area, Colony</p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label>Landmark</label>
                                                    <input type="text" name="landmark" id="landmark" class="add-field" placeholder="Landmark">
                                                </div>
                                                <div class="col-lg-12"></div>
                                                <div class="col-lg-6">
                                                    <!-- <input type="button" value="Save Address" class="first-sign new_address"> -->
                                                    <button type="button" class="first-sign" id="add_address" onclick="add_address()";>Save</button>
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
                                <?php if(sizeof($previous_address) < 1){?>
                                <a href="#add-address" class="n-address fancybox">+ Add new address</a>
                            <?php } ?>
                                <h2 class="cat-top">Order summary</h2>
                                <div class="order-list">
                                    <?php 
                                         $total_price = 0;
                                         $weight = 0;
                                         $weightdomestic = 0;
                                         $vendor = array();
                                         $delivery_time = 0;
                                         $qty = 0;
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
                                             
                                             $price = str_replace(",", "", $item['price']);
                                             $total_price+=($price*$item['num_added']);
                                             $qty += $item['num_added'];
                                             ?>
                                         
                                        </div>
                                    </div>  
                                <?php } ?>
                                        <input type="hidden" id="grand_total" value="<?php echo $total_price;?>" />
                                         <input type="hidden" id="weight" value="<?php echo $weight;?>" />
                                         <input type="hidden" id="weightdomestic" value="<?php echo $weightdomestic;?>" />
                                         <input type="hidden" name="delivery_time" value="<?php echo $delivery_time;?>" />
                                          <input type="hidden" id="subTotal" value="<?php echo $cartItems['finalSum'] - $otherReferralPrice;?>" />

                                          <input type="hidden" name="redeem_paid_point" id="redeem_paid_point" value="<?php echo $pointBalance;?>" />
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
                                <?php 
                                // if($total_price < 1000){
                                //     $total_price = ($total_price + 99);
                                //        }       
                                ?>
                                <h2 class="cat-top">Cart summary</h2>
                                <div class="cart-summery">
                                    <table>
                                        <tr>
                                            <td>Merchandise Subtotal:</td>
                                            <td><span class="count" id="subTotal"><?= CURRENCY.number_format(($total_price),2) ?></span></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Shipping Cost:</td>
                                            <td><span class="count" id="delivery_charges"><?= CURRENCY ?><span id="delivery_amount">0</span></span></td>
                                        </tr>
                                    
                                        <tr>
                                            <td><span class="">Coupon Discount:</span></td>
                                            <td><span class="count discount-amount" id="discount-amount"><?= CURRENCY ?>0</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Gift Discount:</span></td>
                                            <td><span class="count gift_amount" id="gift_amount"><?= CURRENCY ?>0</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="">Paid by Points:</span></td>
                                            <td><span class="paid_amount">0</span></td>
                                        </tr>
                                        <?php if($otherReferralPrice != 0){?>
                                         <tr>
                                            <td><span class="">Referral Discount:</span></td>
                                            <td><span class="referral_text">-200</span></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Total:</td>
                                            <td><span class="count final-amount total_price"  id="total_price"><?= CURRENCY ?><?= number_format(($total_price - $otherReferralPrice),2) ?></span></td>
                                        </tr>                                       
                                    </table>
                                    <p><?php 
                                    $last_amt = 1000;
                                    if( $total_price < $last_amt && $totalReward['tier'] == '1')  {?>
                                        <p class="firstOpenSpend">Spend ₹<?php echo number_format($last_amt - $total_price) ?> more to get free delivery</p> <?php } ?></p>
                                         <?php if($totalReward['tier'] == '1'){?>
                                    <p class="firsthideSpend" style="display: none;"></p>
                                <?php } ?>
                                    <input type="hidden" name="selected_address_id" id="selected_address_id" value="" />
                                    <input  type="hidden" id="user_email" name="user_email" value="<?php echo $user_email;?>" />
                                    <input  type="hidden" id="shpping_cost" name="shpping_cost" value="0" />
                                    <!-- <input type="hidden" id="final-amount" name="final_amount" value="<?= $total_price ?>"> -->
                                    <input  type="hidden" id="paid_amount" name="paid_amount" value="0" />
                                    <input type="hidden" name='referralCode' id="referralCode" class="referralCode" value="<?php echo $otherReferral; ?>" />
                                    <input type="hidden" id="final-amount-two" name="final_amount_two" value="<?= ($total_price - $otherReferralPrice)?>">
                                    <input type="hidden" name="amount_currency" value="<?= CURRENCY ?>">
                                    <input type="hidden" id="discountAmount" name="discountAmount" value="0">
                                    <input type="hidden" id="vendors" value="<?php echo implode(",",$vendor);?>" />
                                    <input type="hidden" id="selectedAmount" name="selectedAmount" value="0">
                                    <input type="hidden" name="paid_by_point" id="paid_by_point" value="0">
                                    <input type="hidden" name="request_id" id="request_id" value="">
                                    <input type="hidden" name="request_id_otp" id="request_id_otp" value="">
                                    <input type="hidden" name="birthday_amount" class="birthday_amount" value="">
                                    <input type="hidden" name="giftAmount" class="giftAmount" id="giftAmount" value="0">
                                    <input type="hidden" id="grand_total" name="grand_total" value="<?php echo $total_price;?>" />
                                    <input type="hidden" id="productVariant" name="productVariant" value="<?php echo $productVariant;?>" />
                                    <!-- <a href="javascript:void(0)" class="gn-button" id="place_order" onclick="place_order()">CHECKOUT</a>
                                    <span id="razorpay_payment_process" style="display:none">Processing your payment. Please do not press back button/refresh your page.</span> -->
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
                                <div class="mt-4">
                                    <a href="javascript:void(0)" class="gn-button place_order" id="place_order" onclick="place_order()">CHECKOUT</a>
                                    <a href="javascript:void(0)" class="gn-button please_wait" id="please_wait" style="display: none;">PROCESSING...</a>
                                    <span id="razorpay_payment_process" style="display:none">Processing your payment. Please do not press back button/refresh your page.</span>
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

            <!-- END CHECKOUT -->
        </main>
        <style>
            @media(max-width:991px){
                .cart-gap{
                    height:130px;
                }
            }
        </style>