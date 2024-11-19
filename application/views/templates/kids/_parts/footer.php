<!--footer start -->
<footer class="footer-3">
    <div class="subscribe-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="subscribe-content">
                        <h4> <i class="fa fa-envelope-o" aria-hidden="true"></i>newsletter</h4>
                        <p>>Get all the latest information on Events, Sales and Offers. Sign up for newsletter today </p>
                        <form class="form-inline subscribe-form" method="post">
                            <div class="form-group mb-0">
                                <input type="email" class="form-control" id="subscribe_email" name="subscribe_email" placeholder="Email...">
                            </div>
                            <button type="button" id="mc-submit" class="btn btn-solid">subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-section">
        <div class="container">
            <div class="row border-cls section-b-space section-t-space">
                <div class="col-xl-4 col-lg-12 about-section">
                    <div class="footer-title footer-mobile-title">
                        <h4>about</h4>
                    </div>
                    <div class="footer-content">
                        <div class="footer-logo">
                            <img src="<?= base_url('attachments/site_logo/' . $sitelogo) ?>" alt="">
                        </div>
                        <?php if ($footerAboutUs != '') { ?>
                            <div class="media-body">
                               <?= $footerAboutUs ?>
                            </div>
                        <?php } ?>
                        <div class="footer-social">
                            <ul>
                       				<li><?php if ($footerSocialFacebook != '') { ?><a href="<?= $footerSocialFacebook ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
                                  <li>  <?php } if ($footerSocialInstagram != '') { ?><a href="<?= $footerSocialInstagram ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>		 </li>		    
                                   <li> <?php } if ($footerSocialTwitter != '') { ?><a href="<?= $footerSocialTwitter ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
                                  <li>  <?php } if ($footerSocialGooglePlus != '') { ?><a href="<?= $footerSocialGooglePlus ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
                                   <li> <?php } if ($footerSocialPinterest != '') { ?><a href="<?= $footerSocialPinterest ?>" target="_blank"><i class="fa fa-pinterest"  aria-hidden="true"></i></a> </li>
                                   <li> <?php } if ($footerSocialYoutube != '') { ?><a href="<?= $footerSocialYoutube ?>" target="_blank"><i class="fa fa-youtube"  aria-hidden="true"></i></a> </li>
                                   <li> <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="row height-cls">
                        <div class="col-lg-6 footer-link">
                            <div>
                                <div class="footer-title">
                                    <h4>Quick Links</h4>
                                </div>
                                <div class="footer-content">
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/page/aboutus' ?>">About Us</a></li>
                                        <li><a href="<?= LANG_URL . '/page/terms_condition' ?>">Terms & Condition</a></li>
                                        <li><a href="<?= LANG_URL . '/page/return_policy' ?>">Cancellation/ Refund Policy</a></li>
                                        <li><a href="<?= LANG_URL . '/page/privacy_policy' ?>">Privacy Policy</a></li>
                                        <li><a href="<?= LANG_URL . '/contacts' ?>">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 footer-link">
                            <div>
                                <div class="footer-title">
                                    <h4>Connect with us</h4>
                                </div>
                                <div class="footer-content">
                                    <ul class="contact-list">
                                    <?php if ($footerContactAddr != '') { ?>
                                    <li><i class="fa fa-map-marker"></i><?= $footerContactAddr ?></li>
                                     <?php }if ($footerContactPhone != '') { ?>
                                    <li><i class="fa fa-phone"></i>Call Us: <?= $footerContactPhone ?></li>
                                     <?php } if ($footerContactEmail != '') { ?>
                                    <li><i class="fa fa-envelope-o"></i>Email: <a href="<?= $footerContactEmail ?>"><?= $footerContactEmail ?></a></li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="footer-end">
                        <p class="footer-copyright"><?= $footerCopyright ?></p>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="payment-card-bottom">
                        <ul>
                            <li>
                                <a href="#"><img src="<?= base_url('template/imgs/visa.png') ?>" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="<?= base_url('template/imgs/mastercard.png') ?>" alt=""></a>
                            </li>
                           
                            <li>
                                <a href="#"><img src="<?= base_url('template/imgs/american-express.png') ?>" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><img src="<?= base_url('template/imgs/discover.png') ?>" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer end -->


<!-- Add to cart bar -->
<div id="cart_side" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my cart</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeCart()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">
            <ul class="cart_product">
            <?= $load::getCartItems($cartItems) ?>
            </ul>
        </div>
    </div>
</div>
<!-- Add to cart bar end-->


<!-- Add to wishlist bar -->
<?php /*?><div id="wishlist_side" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeWishlist()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my wishlist</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeWishlist()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">
            <ul class="cart_product">
                <li>
                    <div class="media">
                        <a href="#">
                            <img alt="" class="mr-3" src="assets/images/product/1.jpg">
                        </a>
                        <div class="media-body">
                            <a href="#">
                                <h4>item name</h4>
                            </a>
                            <h4>
                                <span>sm</span>
                                <span>, blue</span>
                            </h4>
                            <h4>
                                <span>₹ 299.00</span>
                            </h4>
                        </div>
                    </div>
                    <div class="close-circle">
                        <a href="#">
                            <i class="ti-trash" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="media">
                        <a href="#">
                            <img alt="" class="mr-3" src="assets/images/product/2.jpg">
                        </a>
                        <div class="media-body">
                            <a href="#">
                                <h4>item name</h4>
                            </a>
                            <h4>
                                <span>sm</span>
                                <span>, blue</span>
                            </h4>
                            <h4>
                                <span>₹ 299.00</span>
                            </h4>
                        </div>
                    </div>
                    <div class="close-circle">
                        <a href="#">
                            <i class="ti-trash" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="media">
                        <a href="#"><img alt="" class="mr-3" src="assets/images/product/3.jpg"></a>
                        <div class="media-body">
                            <a href="#"><h4>item name</h4></a>
                            <h4>
                                <span>sm</span>
                                <span>, blue</span>
                            </h4>
                            <h4><span>₹ 299.00</span></h4>
                        </div>
                    </div>
                    <div class="close-circle">
                        <a href="#">
                            <i class="ti-trash" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
            </ul>
            <ul class="cart_total">
                <li>
                    <div class="total">
                        <h5>subtotal : <span>₹299.00</span></h5>
                    </div>
                </li>
                <li>
                    <div class="buttons">
                        <a href="wishlist.html" class="btn btn-solid btn-block btn-solid-sm view-cart">view wislist</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div><?php */?>
<!-- Add to wishlist bar end-->


<!-- My account bar -->
<div id="myAccount" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeAccount()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my account</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeAccount()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <form class="theme-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" placeholder="Email" required="">
            </div>
            <div class="form-group">
                <label for="review">Password</label>
                <input type="password" class="form-control" id="review" placeholder="Enter your password" required="">
            </div>
            <a href="#" class="btn btn-solid btn-solid-sm btn-block ">Login</a>
            <h5 class="forget-class"><a href="forget_pwd.html" class="d-block">forget password?</a></h5>
            <h5 class="forget-class"><a href="register.html" class="d-block">new to store? Signup now</a></h5>
        </form>
    </div>
</div>
<!-- Add to wishlist bar end-->

<!-- Quick-view modal popup start-->
<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="row" id="product_quickview">
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick-view modal popup end-->

<input id="ratings-hidden" name="rating" type="hidden">
<!-- tap to top -->
<div class="tap-top star-top">
    <div>
        <i class="fa fa-star star-icon" aria-hidden="true">
            <i class="fa fa-angle-double-up"></i>
        </i>
    </div>
</div>
<!-- tap to top End -->


<script src="<?= base_url('templatejs/jquery-3.3.1.min.js') ?>" ></script>
<script src="<?= base_url('templatejs/menu.js') ?>"></script>
<script src="<?= base_url('templatejs/popper.min.js') ?>" ></script>
<script src="<?= base_url('templatejs/slick.js') ?>"></script>
<script src="<?= base_url('templatejs/bootstrap.js') ?>" ></script>
<script src="<?= base_url('templatejs/bootstrap-notify.min.js') ?>"></script>
<script src="<?= base_url('templatejs/script.js') ?>" ></script>
<script src="<?= base_url('templatejs/modal.js') ?>" ></script>
<script src="<?= base_url('templatejs/sweetalert2.min.js') ?>"></script>
<script type="text/javascript">
function openWishlist(){
	window.location.href='<?= LANG_URL . '/users/wishlist' ?>';
}
function openDashboard(){
	window.location.href='<?= LANG_URL . '/users/dashboard' ?>';
}
function getSubReason(value,target){
		 $.ajax({
					type: "POST",
					url: "<?= base_url('home/getSubReason') ?>",
					data: {reason_id: value}
				}).done(function (data) {
					$('#return_sub_reason'+target).show();
					$('#return_image'+target).show();
					$('#return_sub_reason'+target).html(data);
				});
}
function open_others(value,target){
	if(value == 'others') $('#others_reason'+target).show();
	else $('#others_reason'+target).hide();
}
function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	function checkuser(){
		$('[name="customer_email"]').removeClass("error");
		$('.email_error').hide();
		var error = false;
				
		if($('#user_email').val()!="")
		var customer_email = $('#user_email').val();
		else{
			var customer_email = $('[name="customer_email"]').val();
			if(customer_email == "")
			{
				$('[name="customer_email"]').addClass("error");
				$('.email_error').html("Please enter your email");
				$('.email_error').show();
				error = true;
			}else{
				if(!isEmail(customer_email)){
					$('[name="customer_email"]').addClass("error");
					$('.email_error').html("Please enter a valid email");
					$('.email_error').show();
					error = true;
				}
			}
		}
		if(!error){
		
		 var subTotal = $('#subTotal').val();
         //console.log("subTotal", $('#subTotal').val())
		 $('#prev_address').html("");
		 $.ajax({
					type: "POST",
					url: "<?= base_url('home/checkUser') ?>",
					dataType: 'JSON',
					data: {customer_email: customer_email}
				}).done(function (data) {
					var id = data.guest_user;
					var address = data.address;
					$('#guest_id').val(id);
					$('#customer_details').hide();
					$('#address_field').show();
					$('#customer_edit').show();
					if(address.length>0){
						$('#prev_address').show();
						$('#add_new_address_btn').show();
						$('#add_new_addreess').hide();
						var addresslist = "<div class='row'>";
						for(var i=0;i<address.length;i++){
							addresslist +='<div class="col-6">'+
                                        	'<div class="card">'+
                                              '<div class="card-body">'+
                                                '<p class="card-text">'+address[i].first_name+' '+address[i].last_name+',<br>Phone - '+address[i].phone+',<br>Address - '+address[i].address+',<br>'+address[i].state_name+','+address[i].city_name+','+address[i].country_name+',<br>Pin Code - '+address[i].post_code+'</p>'+
                                                '<button type="button" onclick="setDeliveryAddress('+address[i].address_id+','+address[i].state+',\''+address[i].sortname+'\','+subTotal+')" class="btn-solid btn">Deliver Here</button><a style="margin-left:10px" href="javascript:void(0)" onclick="deleteAddress('+address[i].address_id+')">Delete</a>'+
                                              '</div>'+
                                            '</div>'+
                                        '</div>';
						}
						addresslist +="</div>"
						$('#prev_address').html(addresslist);
					}
					else{
						$('#add_new_address_btn').hide();
						$('#add_new_addreess').show();
					}
				});
		}
	}
	function deleteAddress(address_id){
		$.ajax({
								type: "POST",
								url: '<?= base_url('home/delete_address') ?>',
								data: {guest: $('#guest_id').val(),address_id:address_id}
				 }).done(function (data) {
					 $(window).scrollTop($('#address_field'));
					checkuser();
		});
		
		
	}
    function razorpayPayment()
    {
        $('#delivery_amount').html("0");
        $('#shpping_cost').val(0);
        var total_amount = parseFloat($('#grand_total').val());
        $('#total_price').html('<?= CURRENCY ?>'+total_amount);
        $('#final-amount').val(total_amount);
            
        $('#razorpay_payment_option').prop('checked',true);
        $('#freecharge_payment').show();
        $('.payment_method').show();
    }
    function changeCod(){
        var stateId = $('#selectedStateID').val();
        var total_amount = parseFloat($('#grand_total').val());
        $('#total_price').html('<?= CURRENCY ?>'+total_amount);
        $('#final-amount').val(total_amount);
        //var subTotalPrice = total_amount;
        //console.log("amount", total_amount);
        if(total_amount >= 1000){
                $('#delivery_amount').html("0");
                $('#shpping_cost').val(0);
                var total_amount = parseFloat($('#grand_total').val());
                $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                $('#final-amount').val(total_amount);
                    
                $('#cod').prop('checked',true);
                $('#freecharge_payment').show();
                $('.payment_method').show();
        }
        else if(total_amount < 1000 && stateId == '41'){
                    $('#delivery_amount').html('45.00');
                    $('#shpping_cost').val('45.00');
                    var total_amount = (parseFloat($('#grand_total').val())+parseFloat('45.00')).toFixed(2);
                    $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                    $('#final-amount').val(total_amount);

                    $('#cod').prop('checked',true);
                    $('#freecharge_payment').show();
                    $('.payment_method').show();
        }
        else{
                    $('#delivery_amount').html('69.00');
                    $('#shpping_cost').val('69.00');
                    var total_amount = (parseFloat($('#grand_total').val())+parseFloat('69.00')).toFixed(2);
                    $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                    $('#final-amount').val(total_amount);

                    $('#cod').prop('checked',true);
                    $('#freecharge_payment').show();
                    $('.payment_method').show();
        }
    }
	function setDeliveryAddress(address_id,stateID,sortname,price){        
        $('#selectedStateID').val(stateID);
        var subTotalPrice = 0;
		$('#selected_address_id').val(address_id);
		$('#address_field').hide();
		$('#add_new_addreess').hide();
		$('#shipping_edit').show();
		$('#place_order').show();
		$('#freecharge_payment_option').prop('checked',false);
        subTotalPrice = price.toFixed(0);
        //console.log(subTotalPrice); 
        if(subTotalPrice >= 1000){
                $('#delivery_amount').html("0");
                $('#shpping_cost').val(0);
                var total_amount = parseFloat($('#grand_total').val());
                $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                $('#final-amount').val(total_amount);
                    
                $('#cod').prop('checked',true);
                $('#freecharge_payment').show();
                $('.payment_method').show();
        }
        else if(subTotalPrice < 1000 && stateID == '41'){
                    $('#delivery_amount').html('45.00');
                    $('#shpping_cost').val('45.00');
                    var total_amount = (parseFloat($('#grand_total').val())+parseFloat('45.00')).toFixed(2);
                    $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                    $('#final-amount').val(total_amount);

                    $('#cod').prop('checked',true);
                    $('#freecharge_payment').show();
                    $('.payment_method').show();
        }
        else{
                    $('#delivery_amount').html('69.00');
                    $('#shpping_cost').val('69.00');
                    var total_amount = (parseFloat($('#grand_total').val())+parseFloat('69.00')).toFixed(2);
                    $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                    $('#final-amount').val(total_amount);

                    $('#cod').prop('checked',true);
                    $('#freecharge_payment').show();
                    $('.payment_method').show();
        }
		
		// if(sortname != "IN"){
		// 	$.ajax({
		// 			type: "POST",
		// 			url: '<?= base_url('home/apply_shipping_charge') ?>',
		// 			dataType: 'JSON',
		// 			data: {sortname: sortname,weight:$('#weight').val()}
		// 		 }).done(function (data) {
		// 			 if(data.price){
		// 				 	$('#delivery_amount').html(data.price);
		// 					$('#shpping_cost').val(data.price);
		// 					var total_amount = (parseFloat($('#grand_total').val())+parseFloat(data.price)).toFixed(2);
		// 					$('#total_price').html('<?= CURRENCY ?>'+total_amount);
		// 					$('#final-amount').val(total_amount);
		// 			 }else{
		// 					$('#delivery_amount').html("0");
		// 					$('#shpping_cost').val(0);
		// 					var total_amount = parseFloat($('#grand_total').val()).toFixed(2);
		// 					$('#total_price').html('<?= CURRENCY ?>'+total_amount);
		// 					$('#final-amount').val(total_amount);
		// 			}
					
					
		// 			$('#freecharge_payment').hide();
		// 			$('.payment_method').show();
		// 		});
		// }else{
		// 	if($('#weightdomestic').val()!="0"){
		// 		$.ajax({
		// 			type: "POST",
		// 			url: '<?= base_url('home/apply_shipping_charge') ?>',
		// 			dataType: 'JSON',
		// 			data: {sortname: sortname,weight:$('#weightdomestic').val()}
		// 		 }).done(function (data) {
		// 			 if(data.price){
		// 				 	$('#delivery_amount').html(data.price);
		// 					$('#shpping_cost').val(data.price);
		// 					var total_amount = (parseFloat($('#grand_total').val())+parseFloat(data.price)).toFixed(2);
		// 					$('#total_price').html('<?= CURRENCY ?>'+total_amount);
		// 					$('#final-amount').val(total_amount);
		// 			}else{
		// 					$('#delivery_amount').html("0");
		// 					$('#shpping_cost').val(0);
		// 					var total_amount = parseFloat($('#grand_total').val()).toFixed(2);
		// 					$('#total_price').html('<?= CURRENCY ?>'+total_amount);
		// 					$('#final-amount').val(total_amount);
		// 			}
					
		// 			$('#razorpay_payment_option').prop('checked',true);
		// 			$('#freecharge_payment').show();
		// 			$('.payment_method').show();
		// 		});
		// 	}else{
		// 		$('#delivery_amount').html("0");
		// 		$('#shpping_cost').val(0);
		// 		var total_amount = parseFloat($('#grand_total').val());
		// 		$('#total_price').html('<?= CURRENCY ?>'+total_amount);
		// 		$('#final-amount').val(total_amount);
					
		// 		$('#razorpay_payment_option').prop('checked',true);
		// 		$('#freecharge_payment').show();
		// 		$('.payment_method').show();
		// 	}
			
		//}
	}
    function apply_free_product(){
            //Reset Previous discount if applied
            if($('#discountAmount').val()!=0){
                $('#final-amount').val($('#final-amount').val()+$('#discountAmount').val());
            }
            
             $('#freeProduct').modal('hide');
             var enteredCode = $('[name="discountCode"]').val();
             var vendors  = $('#vendors').val();
             var subTotal = parseFloat($('#subTotal').val()).toFixed(0);

             var final_amount_before = Number($('#final-amount').val());
             //var sub_total_before = Number($('#subTotal').val());
             var total_offer_amount = Number($('#freeProductPrice').val());
             var discountAmoun;
             var final_amount = final_amount_before;
             discountAmoun = total_offer_amount;
             $('#discount_form').hide();
            discountAmoun = parseFloat(discountAmoun).toFixed(2);
            $('.final-amount').text(final_amount.toFixed(2));
            $('#final-amount').val(final_amount);
            $('[name="discountAmount"]').val(discountAmoun);
            $('#discount_row').show();
            $('#discount-amount').html(" -"+discountAmoun);
            is_discounted = true;
            Swal.fire({
              icon: 'success',
              text: 'Discount Code Applied'
            })
                // $.ajax({
                //     type: "POST",
                //     url: variable.discountCodeChecker,
                //     data: {enteredCode: enteredCode, vendors : vendors, subTotal : subTotal}
                // }).done(function (data) {
                //     if (data == 0) {
                //             Swal.fire({
                //               icon: 'error',
                //               text: lang.discountCodeInvalid
                //             })
                            
                //     }else if(data == 401){
                //                 Swal.fire({
                //                   icon: 'error',
                //                   text: lang.need_total_amount
                //                 })
                //     }else if(data == 402){
                //                 Swal.fire({
                //                   icon: 'error',
                //                   text: lang.more_item_added
                //                 })
                //     }else {
                //         //console.log("Data", data);
                //         if (is_discounted == false) {
                //             var obj = jQuery.parseJSON(data);
                //             if(obj.offer_types == 7){
                //                 console.log("ok");
                //                 var productID = obj.freeProductID;
                //                 var productIDArray = productID.split(',');
                //                 var arr = [];
                //                 //for(var i = 0; i < productIDArray.length; i++){
                //                    //console.log(productIDArray[i]);
                //                     $.ajax({
                //                     type: "POST",
                //                     url: "<?php echo base_url('home/getFreeProductList'); ?>",
                //                     data: { productID: productIDArray },
                //                     success: function(responce)
                //                     {
                //                        // var items = jQuery.parseJSON(responce);
                //                         //console.log("responce", responce);
                //                         $("#freeCartProduct").modal('show');
                //                         $('#freeProduct').html(responce);
                //                        // arr.push(jQuery.parseJSON(responce));

                //                     }
                //                  });

                //                 //}
                //                 //console.log("arr", arr);
                //                 // $("#freeCartProduct").modal('show');
                //                 // $('#freeProduct').html(arr);
                //                 return true;
                //             }
                //             var final_amount_before = Number($('#final-amount').val());
                //             //var sub_total_before = Number($('#subTotal').val());
                //             var discountAmoun;
                //             if (obj.type == 'percent') {
                //                 var substract_num = (obj.amount / 100) * final_amount_before;
                //                 var final_amount = final_amount_before - substract_num;
                //                 discountAmoun = substract_num;
                //             }
                //             if (obj.type == 'float') {
                //                 var final_amount = final_amount_before - obj.amount;
                //                 discountAmoun = obj.amount;
                //             }
                //             $('#discount_form').hide();
                //             discountAmoun = parseFloat(discountAmoun).toFixed(2);
                //             $('.final-amount').text(final_amount.toFixed(2));
                //             $('#final-amount').val(final_amount);
                //             $('[name="discountAmount"]').val(discountAmoun);
                //             $('#discount_row').show();
                //             $('#discount-amount').html(" -"+discountAmoun);
                //             is_discounted = true;
                //             Swal.fire({
                //               icon: 'success',
                //               text: 'Discount Code Applied'
                //             })
                //         }
                //     }
                // });
             
        }
		function applycoupon(){
			//Reset Previous discount if applied
			if($('#discountAmount').val()!=0){
				$('#final-amount').val($('#final-amount').val()+$('#discountAmount').val());
			}
			
			 $('#freeProduct').modal('hide');
			 var enteredCode = $('[name="discountCode"]').val();
			 var vendors  = $('#vendors').val();
             var subTotal = parseFloat($('#subTotal').val()).toFixed(0);
				$.ajax({
					type: "POST",
					url: variable.discountCodeChecker,
					data: {enteredCode: enteredCode, vendors : vendors, subTotal : subTotal}
				}).done(function (data) {
					if (data == 0) {
							Swal.fire({
							  icon: 'error',
							  text: lang.discountCodeInvalid
							})
                            
					}else if(data == 401){
                                Swal.fire({
                                  icon: 'error',
                                  text: lang.need_total_amount
                                })
                    }else if(data == 402){
                                Swal.fire({
                                  icon: 'error',
                                  text: lang.more_item_added
                                })
                    }else {
                        //console.log("Data", data);
						if (is_discounted == false) {
							var obj = jQuery.parseJSON(data);
                            if(obj.offer_types == 7){
                                console.log("ok");
                                var productID = obj.freeProductID;
                                var productIDArray = productID.split(',');
                                var arr = [];
                                //for(var i = 0; i < productIDArray.length; i++){
                                   //console.log(productIDArray[i]);
                                    $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url('home/getFreeProductList'); ?>",
                                    data: { productID: productIDArray },
                                    success: function(responce)
                                    {
                                       // var items = jQuery.parseJSON(responce);
                                        //console.log("responce", responce);
                                        $("#freeCartProduct").modal('show');
                                        $('#freeProduct').html(responce);
                                       // arr.push(jQuery.parseJSON(responce));

                                    }
                                 });

                                //}
                                //console.log("arr", arr);
                                // $("#freeCartProduct").modal('show');
                                // $('#freeProduct').html(arr);
                                return true;
                            }
							var final_amount_before = Number($('#final-amount').val());
                            //var sub_total_before = Number($('#subTotal').val());
							var discountAmoun;
							if (obj.type == 'percent') {
								var substract_num = (obj.amount / 100) * final_amount_before;
								var final_amount = final_amount_before - substract_num;
								discountAmoun = substract_num;
							}
							if (obj.type == 'float') {
								var final_amount = final_amount_before - obj.amount;
								discountAmoun = obj.amount;
							}
							$('#discount_form').hide();
							discountAmoun = parseFloat(discountAmoun).toFixed(2);
							$('.final-amount').text(final_amount.toFixed(2));
							$('#final-amount').val(final_amount);
							$('[name="discountAmount"]').val(discountAmoun);
							$('#discount_row').show();
							$('#discount-amount').html(" -"+discountAmoun);
							is_discounted = true;
							Swal.fire({
							  icon: 'success',
							  text: 'Discount Code Applied'
							})
						}
					}
				});
			 
		}
var variable = {
			clearShoppingCartUrl: "<?= base_url('clearShoppingCart') ?>",
			manageShoppingCartUrl: "<?= base_url('manageShoppingCart') ?>",
			discountCodeChecker: "<?= base_url('discountCodeChecker') ?>"
		};
function changeDeliveryCharge(value){
			var currency = $('#currency').val();
			var district= value.split(',')[0];
			var delivery_charges =value.split(',')[1];
			var district_id =value.split(',')[3];
	  
			$('#delivery_charges').html(delivery_charges+'.00');
			$('#shpping_cost').val(delivery_charges);
			var total_price = (Number($('#grand_total').val())-Number($('#discountAmount').val()))+Number(delivery_charges);
			$('#total_price').html(total_price+".00");
			$('#final-amount').val(total_price);
			$.ajax({
								type: "POST",
								url: "<?php echo site_url('users/getThanaList'); ?>",
								data: { district:district_id },
								success: function(data)
								{
									$('#thana').html(data);
								}
							 });
		}
		function trackDetails(order_id) {
		$.ajax({
			type: "POST",
			url: '<?= base_url('admin/orders/tracking_details') ?>',
			data: {order_id: order_id}
		}).done(function (data) {
			$('#tracking_details_info').html(data);
		});
	}
		  function confirm_delete(order_id){
			  Swal.fire({
					  title: 'Are you sure?',
					  text: "You want to cancel this order",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes'
					}).then((result) => {
					  if (result.value) {
							window.location.href='<?= base_url('users/update-order-status')?>/'+order_id+'/cancel';
						  }
					});
		  }
function sort_item(value){
			 $('#sortform').submit();
		  }
		  function changeCountry(value){
			$.ajax({
								type: "POST",
								url: "<?php echo site_url('users/getStateList'); ?>",
								data: { country_id:value },
								success: function(data)
								{
									$('#stateInput').html(data);
								}
							 });
		}
		function changeState(value){
			$.ajax({
								type: "POST",
								url: "<?php echo site_url('users/getThanaList'); ?>",
								data: { district:value },
								success: function(data)
								{
									$('#thana').html(data);
								}
							 });
		}
		function place_order(){
			var payment_type = $('input[name="payment_type"]:checked').val();
			$('#razorpay_payment_process').hide();
			if(payment_type=="Razorpay"){
				$('#place_order').hide();
				$('#razorpay_payment_process').show();
				$.ajax({
								type: "POST",
								url: "<?php echo site_url('checkout/create_order'); ?>",
								data: $('#goOrder').serialize(),
								dataType: 'JSON',
								success: function(data)
								{
                                    console.log("data", data)
									var options = data;
									options.handler = function (response){
										document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
										document.getElementById('razorpay_signature').value = response.razorpay_signature;
										
										document.razorpayform.submit();
									};
									options.theme.image_padding = false;
									options.modal = {
										ondismiss: function() {
											$('#place_order').show();
											$('#razorpay_payment_process').hide();
										},
										escape: true,
										backdropclose: false
									};
									
									var rzp = new Razorpay(options);
									rzp.open();
								}
				});
				
			}else
			document.getElementById('goOrder').submit();
		}
		//Rating and Review
		var slice=[].slice;!function(t,n){var r;n.Starrr=r=function(){function n(n,r){var s;(this.options=t.extend({},this.defaults,r),this.$el=n,this.createStars(),this.syncRating(),this.options.readOnly)||(this.$el.on("mouseover.starrr","a",(s=this,function(t){return s.syncRating(s.getStars().index(t.currentTarget)+1)})),this.$el.on("mouseout.starrr",function(t){return function(){return t.syncRating()}}(this)),this.$el.on("click.starrr","a",function(t){return function(n){return n.preventDefault(),t.setRating(t.getStars().index(n.currentTarget)+1)}}(this)),this.$el.on("starrr:change",this.options.change))}return n.prototype.defaults={rating:void 0,max:5,readOnly:!1,emptyClass:"fa fa-star-o",fullClass:"fa fa-star",change:function(t,n){}},n.prototype.getStars=function(){return this.$el.find("a")},n.prototype.createStars=function(){var t,n,r;for(r=[],t=1,n=this.options.max;1<=n?t<=n:t>=n;1<=n?t++:t--)r.push(this.$el.append("<a href='#' />"));return r},n.prototype.setRating=function(t){return this.options.rating===t&&(t=void 0),this.options.rating=t,this.syncRating(),this.$el.trigger("starrr:change",t)},n.prototype.getRating=function(){return this.options.rating},n.prototype.syncRating=function(t){var n,r,s,i,e;for(t||(t=this.options.rating),n=this.getStars(),e=[],r=s=1,i=this.options.max;1<=i?s<=i:s>=i;r=1<=i?++s:--s)e.push(n.eq(r-1).removeClass(t>=r?this.options.emptyClass:this.options.fullClass).addClass(t>=r?this.options.fullClass:this.options.emptyClass));return e},n}(),t.fn.extend({starrr:function(){var n,s;return s=arguments[0],n=2<=arguments.length?slice.call(arguments,1):[],this.each(function(){var i;if((i=t(this).data("starrr"))||t(this).data("starrr",i=new r(t(this),s)),"string"==typeof s)return i[s].apply(i,n)})}})}(window.jQuery,window);
		$(document).ready(function(){
			$('.starrr').starrr();
			  $('.open_review_box').click(function(e)
			  {
				var target = $(this).attr('data-target');
				$('#reviewbox'+target).slideDown(400, function()
				  {
				  });
				$('#review_btn'+target).fadeOut(100);
				$('#close-review-box'+target).show();
			  });
			
			  $('.close-review').click(function(e)
			  {
				e.preventDefault();
				var target = $(this).attr('data-target');
				$('#reviewbox'+target).slideUp(300, function()
				  {
					$('#review_btn'+target).fadeIn(100);
				  });
				$('#close-review-box'+target).hide();
			  });
			
			  $('.starrr').on('starrr:change', function(e, value){
				$('#ratings-hidden').val(value);
			  });
			   
			   var submitting_review = false;
			   $('.submit_review').click(function(e){
				   if(!submitting_review){
					    var target = $(this).attr('data-target');
						var product_id = $(this).attr('data-product-id');
						var order_id = $(this).attr('data-order-id');
						var reload_page = $(this).attr('data-reload');

							if($('#ratings-hidden').val()==''){
								Swal.fire({
										  icon: 'error',
										  text: 'Please enter your rating'
								});
							}else{
								$('#review_save'+target).show();
								submitting_review = true;
								$.ajax({
										type: "POST",
										url: "<?php echo site_url('home/add_review'); ?>",
										data: { review:$('#comment'+target).val(),rating:$('#ratings-hidden').val(),product_id:product_id,order_id:order_id },
										success: function(data)
										{
											$('#review_save'+target).hide();
												submitting_review = false;
												$('#comment'+target).val("");
												$('#reviewbox'+target).slideUp(300, function()
												  {
													$('#review_btn'+target).fadeIn(100);
												  });
												$('#close-review-box'+target).hide();
												Swal.fire({
												  icon: 'success',
												  text: 'Thank you for giving your review/rating.'
												})
												
											/*if(reload_page=="true"){
												location.reload();
											}else{
												$('#review_save'+target).hide();
												submitting_review = false;
												$('#comment'+target).val("");
												$('#reviewbox'+target).slideUp(300, function()
												  {
													$('#review_btn'+target).fadeIn(100);
												  });
												$('#close-review-box'+target).hide();
												Swal.fire({
												  icon: 'success',
												  text: 'Thank you for giving your review.'
												})
											}*/
											
										}
								});
						}
				   }
				
			   });
			  $('.open_return_box').click(function(e)
			  {
				var target = $(this).attr('data-target');
				$('#returnbox'+target).slideDown(400, function()
				  {
				  });
				$('#return_btn'+target).fadeOut(100);
				$('#close-return-box'+target).show();
			  });
			
			  $('.close-return').click(function(e)
			  {
				e.preventDefault();
				var target = $(this).attr('data-target');
				$('#returnbox'+target).slideUp(300, function()
				  {
					$('#return_btn'+target).fadeIn(100);
				  });
				$('#close-return-box'+target).hide();
			  });
			 var submitting_return = false;  
			$('.submit_reutrn_request').click(function(e){
				$('#return_save'+target).show();
				   if(!submitting_return){<?php /*?>
					    var target = $(this).attr('data-target');
						var order_id = $(this).attr('data-order-id');
						var reload_page = $(this).attr('data-reload');
						var product_id = $(this).attr('data-product-id');
						var variant_id = $(this).attr('data-variant-id');
						
								$('#return_save'+target).show();
								submitting_return = true;
								$.ajax({
										type: "POST",
										url: "<?php echo site_url('home/ruturn_order'); ?>",
										data: { order_id:order_id, product_id:product_id,variant_id:variant_id, return_reason :$('#return_reason'+target).val() },
										success: function(data)
										{
											$('#return_save'+target).hide();
												submitting_return = false;
												$('#returnbox'+target).slideUp(300, function()
												  {
													$('#return_btn'+target).hide;
												  });
												$('#close-return-box'+target).hide();
												if(data == "1"){
													Swal.fire({
													  icon: 'success',
													  text: 'Your return request is processing'
													})
												}else{
													Swal.fire({
																	  icon: 'error',
																	  title: 'Sorry',
																	  text: 'We cannot process your request'
												 });
												}
												
										
										}
								});
							
				   <?php */?>}
				
			   });
			  
			  
		});
</script>
<script src="<?= base_url('assets/js/system.js') ?>"></script>
<script type="text/javascript">
function deleteFromCart(id){
		Swal.fire({
		  title: 'Delete Cart Item',
		  text: "Sure to delete from cart?",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.value) {
			window.location.href="<?php echo base_url('home/removeFromCart?delete-product="+id+"&back-to=shopping-cart') ?>";
		  }
		})
	}
	function update_variant(variant){
		var price = $("#varient"+variant).attr("data-price");
		var old_price = $("#varient"+variant).attr("data-old_price");
		var available = $("#varient"+variant).attr("data-available");
		$('#product_price').html(price);
		
		if(old_price!="")
		$('#old_price').html(old_price);
		else
		$('#old_price').html("");
		
		if(available>0){
			$('#product_action').show();
			$('#availability').html('<label><?= lang('in_stock') ?></label>');
		}
		else{
			$('#product_action').hide();
			$('#availability').html('<label><span class="out_stock"><?= lang('out_of_stock_product') ?></span></label>');
		}
		
	}
	function update_quick_viewvariant(variant){
		$('#quickview_variant_id').val(variant);
		var price = $("#quick_varient"+variant).attr("data-price");
		var available = $("#quick_varient"+variant).attr("data-available");
		$('#quick_varient_product_price').html(price);
	}
function add_item_to_cart(){
		var variant = $('#variant').val();
		manageShoppingCart('add', variant, false);
		$("#quick-view").modal('hide');
		 
		Swal.fire({
									  icon: 'success',
									  text: 'Item added to your cart'
				 })
	}
    function add_item_to_cart_free_product(varientID, productPrice){
        var variant = varientID;
        $('#freeProductPrice').val(Number($('#freeProductPrice').val())+Number(productPrice));
        manageShoppingCart('add', variant, false);
        Swal.fire({
                                      icon: 'success',
                                      text: 'Item added to your cart'
                 })
       // window.location.href='<?= LANG_URL . '/checkout' ?>';
        
    }
function add_item_to_wishlist(product_id){
		var wishlist_counter = $('.wishlist_conter').text();
		$('#add_to_wishlist').hide();
		$('#save_wishlist').show();
		$.ajax({
								type: "POST",
								url: '<?= base_url('home/add_wishlist') ?>',
								dataType: 'JSON',
								data: {product_id: product_id}
				 }).done(function (response) {
					 if(response.data == 0){
						 Swal.fire({
											  icon: 'error',
											  text: response.message
						 });
					 }else{
						 wishlist_counter++;
						 $('.wishlist_conter').text(wishlist_counter);
						 Swal.fire({
											  icon: 'success',
											  text: response.message
						 });
					 }
				 $('#add_to_wishlist').show();
				 $('#save_wishlist').hide();
		});
}
function remove_item_to_wishlist(product_id){
	  $.ajax({
								type: "POST",
								url: '<?= base_url('home/remove_wishlist') ?>',
								dataType: 'JSON',
								data: {product_id: product_id}
				 }).done(function (response) {
					 Swal.fire({
											  icon: 'success',
											  text: response.message
					});
					$('#wishlist_item'+product_id).remove();
					var wishlist_counter = $('.wishlist_conter').text();
					wishlist_counter--;
					$('.wishlist_conter').text(wishlist_counter);
					if(wishlist_counter == 0){
						$('#no_wishlist_item').show();
					}
		});
}
function buy_now(){
		var variant = $('#variant').val();
		manageShoppingCart('add', variant, 'checkout');
		
}
function set_filter_color(val){
	$('#color').val(val);
	$('#filter_form').submit();
}
function submitSortForm(){
		$('#filter_form').submit();
}
$(document).ready(function () {
		$('#save_address').click(function(){
			var error = false;
			if($('#firstNameInput').val()==""){
				error = true;
				$('#firstNameInput').addClass("error");
			}
			if($('#lastNameInput').val()==""){
				error = true;
				$('#lastNameInput').addClass("error");
			}
			if($('#phoneInput').val()==""){
				error = true;
				$('#phoneInput').addClass("error");
			}
			if($('#addressInput').val()==""){
				error = true;
				$('#addressInput').addClass("error");
			}
			if($('#countryInput').val()==""){
				error = true;
				$('#countryInput').addClass("error");
			}
			if($('#stateInput').val()==""){
				error = true;
				$('#stateInput').addClass("error");
			}
			if($('#thana').val()==""){
				error = true;
				$('#thana').addClass("error");
			}
			if($('#postInput').val()==""){
				error = true;
				$('#postInput').addClass("error");
			}
			if(!error){
				$('#save_address').prop('disabled', true);
				$('#address_save').show();
				$.ajax({
								type: "POST",
								url: '<?= base_url('home/add_address') ?>',
								data: {firstNameInput: $('#firstNameInput').val(),lastNameInput: $('#lastNameInput').val(),
									   phoneInput: $('#phoneInput').val(),addressInput: $('#addressInput').val(),countryInput: $('#countryInput').val(),
									   stateInput: $('#stateInput').val(),thana: $('#thana').val(),postInput: $('#postInput').val(),notes: $('#notesInput').val(),guest: $('#guest_id').val()}
				 }).done(function (data) {
					 $(window).scrollTop($('#address_field'));
					 $('#address_save').hide();
					 $('#save_address').prop('disabled', false);
					 checkuser();
				 });
			
			}
		});
		$('#add_new_address_btn').click(function(){
			$('#add_new_addreess').show();
			$('#add_new_address_btn').hide();
		});
		$('#cancel_address').click(function(){
			$('#add_new_addreess').hide();
			$('#add_new_address_btn').show();
		});
		 $(".btn-add-cart").click(function(){
			var product_id = $(this).data('id');
			
			$.ajax({
								type: "POST",
								url: '<?= base_url('home/quickviewProduct') ?>',
								data: {product_id: product_id},
								dataType: 'JSON',
				 }).done(function (data) {
					 if(data.variants > 0){
						 $('#product_quickview').html("");
						 $("#cartModal").modal();
						  $('#product_quickview').html(data.variant_date);
					 }
					 else{
						 Swal.fire({
											  icon: 'error',
											  title: 'Sorry',
											  text: 'Item not available.Please try again later'
						 });
					 }
					
				 });
		  });
		  $('#shipping_edit').click(function(){
			$('.payment_method').hide();
			$('#shipping_edit').hide();
			$('#place_order').hide();
			$('#address_field').show();
		 });
		  $('#customer_edit').click(function(){
			$('#customer_details').show();
			$('.payment_method').hide();
			$('#address_field').hide();
			$('#customer_edit').hide();
			$('#shipping_edit').hide();
			$('#place_order').hide();
		 });
		$('#mc-submit').click(function(){
					if($('#subscribe_email').val()!=""){
						if( /(.+)@(.+){2,}\.(.+){2,}/.test($('#subscribe_email').val()) ){
							$(this).prop('disabled', true);
							$.ajax({
								type: "POST",
								url: '<?= base_url('users/subscribe_newsletter') ?>',
								data: {email: $('#subscribe_email').val()}
							}).done(function (data) {
								if(data == "1"){
									Swal.fire({
									  icon: 'success',
									  text: 'You are subscribed to our newsletter.'
									})
								}
								else{
									Swal.fire({
									  icon: 'error',
									  text: 'You are already subscribed to our newsletter.'
									})
								}
								
								$('#subscribe_email').val("");
								$('#mc-submit').prop('disabled', false);
							});
						}else{
							Swal.fire({
									  icon: 'error',
									  text: 'Enter a valid email'
									})
						}
						
					}
				});
	});
$(".btn-add-cart").click(function(){
			var product_id = $(this).data('id');
			
			$.ajax({
								type: "POST",
								url: '<?= base_url('home/quickviewProduct') ?>',
								data: {product_id: product_id},
								dataType: 'JSON',
				 }).done(function (data) {
					 if(data.variants > 0){
						 $('#product_quickview').html("");
						 $("#quick-view").modal();
						  $('#product_quickview').html(data.variant_date);
					 }
					 else{
						 Swal.fire({
											  icon: 'error',
											  title: 'Sorry',
											  text: 'Item not available.Please try again later'
						 });
					 }
					
				 });
		  });
</script>
</body>
</html>
