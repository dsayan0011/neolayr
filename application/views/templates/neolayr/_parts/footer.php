<footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <ul class="footer-menu">
                            <li><a href="<?= LANG_URL . '/aboutus' ?>">About Us</a></li>
                            <li><a href="<?= LANG_URL . '/contacts' ?>">Contact Us</a></li>
                            <li><a href="<?= LANG_URL . '/blog' ?>">BLOG</a></li>
                            <li><a href="<?= LANG_URL . '/page/privacy-policy' ?>">Privacy policy</a></li>
                            <li><a href="<?= LANG_URL . '/page/cookies-policy' ?>">COOKIES POLICY</a></li>
                            <li><a href="<?= LANG_URL . '/page/terms-condition' ?>">Terms and conditions</a></li>
                            <li><a href="<?= LANG_URL . '/page/shipping-and-return' ?>">SHIPPING AND RETURN </a></li>
                            <li><a href="<?= LANG_URL . '/page/payment-terms' ?>">PAYMENT TERMS</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 touch-area">
                        <h3>stay in touch</h3>
                        <ul class="social-media">
                           <li> <?php if ($footerSocialFacebook != '') { ?><a href="<?= $footerSocialFacebook ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>

                            <li><?php } if ($footerSocialInstagram != '') { ?><a href="<?= $footerSocialInstagram ?>" target="_blank"><i class="fa-brands fa-instagram "></i></a></li>

                            <li><?php } if ($footerSocialTwitter != '') { ?><a href="<?= $footerSocialTwitter ?>" target="_blank">
                                 <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#DC7633" width="38"
                                zoomAndPan="magnify" viewBox="0 0 375 374.9999" height="38" preserveAspectRatio="xMidYMid meet" version="1.0">
                                <defs>
                                  <path d="M 7.09375 7.09375 L 367.84375 7.09375 L 367.84375 367.84375 L 7.09375 367.84375 Z M 7.09375 7.09375 "
                                    fill="#0f1419" />
                                </defs>
                                
                                <g transform="translate(85, 75)"> <svg xmlns="http://www.w3.org/2000/svg" width="213" height="213"
                                    viewBox="0 0 300 300" version="1.1">
                                    <path
                                      d="M178.57 127.15 290.27 0h-26.46l-97.03 110.38L89.34 0H0l117.13 166.93L0 300.25h26.46l102.4-116.59 81.8 116.59h89.34M36.01 19.54H76.66l187.13 262.13h-40.66"
                                      fill="#ffffff" />
                                  </svg> </g>
                              
                              </svg>
                             </a></li>                        
                            <li><?php } if ($footerSocialLinkedin != '') { ?><a href="<?= $footerSocialLinkedin ?>" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>

                            <li><?php } if ($footerSocialYoutube != '') { ?><a href="<?= $footerSocialYoutube ?>" target="_blank"><i class="fa-brands fa-youtube"></i></a></li>

                            <li><?php } if ($footerSocialPinterest != '') { ?><a href="<?= $footerSocialPinterest ?>" target="_blank"><i class="fa-brands fa-pinterest"></i></a></li>
                            
                            <?php } ?>
                        </ul>
                        <div class="touch-area-two">
                            <h3>Also Available On</h3>
                            <ul class="social-media">
                            <li><?php if ($footerSocialPinterest != '') { ?><a href="https://palsonsderma.com/" target="_blank"><img src="<?= base_url('images/PD_logo.png') ?>" width="120px"></a></li>
                            <li><?php } if ($footerSocialAmazon != '') { ?><a href="<?= $footerSocialAmazon ?>" target="_blank"><i class="fa-brands fa-amazon"></i></a></li>
                            <li><?php } if ($footerSocialNykaa != '') { ?>
                                    <a href="<?= $footerSocialNykaa ?>" target="_blank">
                                <svg height="38" viewBox="0 0 375 374.9999" width="50" xmlns="http://www.w3.org/2000/svg"><path d="m157.9 57.2c5-9.6-11.2-6.9-11.2-6.9-5.8 0-8.4 7-9.6 9l-17.5 34.5c-3.3 5.7-14.2 30.1-17.8 35.5-.3-5.5.1-16.5.2-19.1.7-10.4 1.4-18.3 2.5-27.8.8-7.4 2.4-15.7.9-23.1-1-4.6-2.5-4.9-9.1-5.6-6.9-.7-11.6 9.3-13.9 14-8.4 17.4-17.8 34.4-25.3 52.2-2.2 5.2-4.9 10.4-7.2 15.5-2.7 6.2-5.2 12.3-8.1 18.4-3.1 6.4-12.8 27.4-15.5 34-3 7.2-3.6 13 8.4 12.7 1.9 0 6.1.4 11.3-5.2 4.1-4.4 4.9-8.5 7.3-14.6 8.6-21.6 14.7-35.9 24.1-57.3.9-2.1 3-8.2 5.1-12.9-.1 6.7-1.2 14.7-1.7 20-1.6 19.4-2.7 38.1-4.4 57.3-.2 2.6-.9 5.7.3 8.1s4.2 3 6.6 3.3c9.6 1.2 10.6-3.6 13.6-10.2 2.7-5.9 4.3-10.7 6.7-16.7 7.4-18.5 15.2-36.8 23.8-54.8 2.2-4.6 4.4-9.1 6.8-13.6 4.4-8.3 8-16.1 12.8-25.3 3.6-6.6 7.1-14.1 10.9-21.4zm329.5 52.1c-1.1-11.1-16.3-5.5-25.4-3.8-3.4.6-13.9 2.6-26 4.9-.5-12.5-.3-10-.4-17.6-.3-11-.9-19.6-1.5-29.3-.4-6.1-1.3-14.6-12.3-13-12.8 1.8-14.9 8.2-18.3 15.9-8.9 20.1-8.6 20.2-18.7 42.6-.8 1.7-4.5 10.7-5.1 12.5-.4.1-1.2.3-2.2.6-4.1.9-9.1 2-14.6 3.2l.1-.5c1.3-10.2 2.9-20.4 4.3-30.6 1.3-9.3 2.7-24.5 3.8-33.8 1.2-10-10.4-9.8-10.4-9.8-7.1-.4-9.8 1.7-14.3 7.5-7.7 10-17 20.8-25.2 31.8-14.9 19.9-25.8 34.9-39.3 54.9-3.9 5.8-9.9 14.6-15.1 21.5-3.5-6.9-6.5-14.5-9.4-21.5-4.2-10-7.3-16.2-9.3-22.8-1.8-5.8.4-6.6 4.7-9.9 12.4-9.4 26.4-15.9 39.1-24.9 9-6.4 19.8-13.5 28.6-20.1 0 0 5.1-3 7.9-6.8 3.5-4.8-6.4-9.8-6.4-9.8-5.6-.9-8.7.4-12.6 2.2-4 1.8-9.2 5.9-12.6 8.6-7.5 5.8-17 12.7-24.4 18.5-9.1 7.1-15.3 11.5-25.3 17.4l25.4-38c8.3-10.7-13.7-13.7-22.1-2.4-7.8 10.1-13.1 19-19.2 28.2-14.7 21.9-26.8 44.9-38.9 69-4.6 9.2-9.1 18.8-13.3 28.3-2 4.6-7.9 15.2.2 16.3 17.3 2.2 20.1-6 24-15.9 6.4-16.3 8.5-19.3 12.6-29.4 4-9.8 6.9-15.4 11.4-23.8.1-.1 1.4-2.2 1.4-2.2.8 1.7 6.1 19.3 6.8 21.3 3.6 9.5 9.9 31.7 13.5 41.8 2.6 8.4 3.3 10.8 14.6 10.5 5.6-.1 8-2.3 11.7-9.3s19.7-36.8 19.7-36.8c4.8-.8 11.7-2 16.2-2.8.8-.1 2.6-.5 5.1-1 1.7-.2 3.1-.5 4.2-.8.1 0 .1 0 .2-.1 4.4-.9 10-2 16.1-3.2-1.1 5.5-4.5 17.6-5.2 20.7 0 0-7.4 28.8 2.2 30.3 6 .9 9.1-.1 9.1-.1 11.2-1.3 11.4-16.4 11.4-16.4l6.1-39.1c4.4-.9 8.8-1.8 13.1-2.6l-13.2 44.6c-1.9 6.3-3.3 14.4 8 14.4 9.2.5 9.8-5.3 9.8-5.3.2-.9 7.5-24.4 9.3-32.8 1.2-5.4 5.5-19.3 7.2-24.9 4.8-.9 8.4-1.6 10.1-1.9 2-.3 5.9-1 11-1.8-.1 5.2 0 12.4.1 13.4 1.1 15.8-.1 32.2 3.2 47.7.5 2.5 1.5 5.7 4.7 5.7 3.8 0 5-.4 9-.7 11.6-1 9.5-12.7 8.8-20.1-.8-8.2-1.6-15.1-2.7-23.3-.9-6.7-1.5-15.5-1.6-26.1v-.2c19-3.2 39.5-6.7 42.5-7.2 4.8-1.3 8.8-.9 7.8-11.9zm-148.5 21c0 .1-.1.1-.1.2-13.3 2.9-25.8 5.7-32.8 7.3 7-11.7 37.8-54.3 42.5-59.3-2.6 13.2-6.8 37.7-9.6 51.8zm76.8-16.8v.7c-6.4 1.2-12.4 2.4-17.2 3.3 6.1-15.8 12.5-35.2 16.3-45-.3 7.3 1.2 33.8.9 41zm-186.5-47.1c2-3.7 6.5-11 .9-13.8-3.3-1.6-7.7-2.6-11.1-.9-2.8 1.5-4.9 4.4-6.3 7.1l-21.4 33.7c-3.5 4.8-6.8 10.8-13.9 11.6-4.7.5-8.1-1.5-8-5.7.1-4.3 2.6-10 4.5-13.7 5.6-10.6 6.3-14.2 11.7-24.7 5.2-10.1-11.8-12.4-16-5.1-3 5.2-8.8 15-10.1 18.3-2.4 6-20.4 34.6-12.6 45.9 10 12.8 36.6-7.4 23 15.9-11 18.7-17.9 29.4-27.5 46.7-2.1 3.7-4.7 7.4-5.4 11.8-1 6.2 7.5 6.1 11.2 5.9 6.5-.5 9.6-3.5 12.2-9.4 1.4-3.1 3.3-6.9 4.7-10 12.6-27.5 26-51.4 42.6-78 7.9-12.6 14.9-23.4 21.5-35.6z" fill="#FFFFFF"/></svg>
                            </a>
                        </li>
                        <?php } ?>
                              
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 n-form-area">
                        <h3>SIGN UP AND NEVER MISS OUT</h3>
                        <p>Get the latest news from NEOLAYR PRO in your inbox.</p>
                        <form class="n-latter subscribe-form" method="post">
                            <div class="">
                                <input type="text" class="email" placeholder="Your email address" id="subscribe_email" name="subscribe_email">

                            </div>

                            <div>
                                <!-- <input type="submit" value="SUBMIT" class="n-submit"> -->
                                <button type="button" id="mc-submit" class="n-submit">subscribe</button>
                            </div>

                        </form>
                        <p class="success_newsletter" style="display: none;">You are subscribed to our newsletter.</p>
                                <p class="error_newsletter" style="display: none;">You are already subscribed to our newsletter</p>
                                <p class="email_error_newsletter" style="display: none;">Please enter a valid email</p>
                    </div>
                </div>
            </div>
            <div class="cart-gap"></div>
        </footer>
        <!-- END FOOTER-->
        <input type="hidden" id="free_product_removed" value="">
        <input type="hidden" id="regMobileNumber" value="">
        <input type="hidden" id="redirecPage" value="0">
    
    
<!-- footer end -->


<!-- Add to cart bar -->
<!-- <div id="cart_side" class="add_to_cart right">
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
</div> -->
<!-- Add to cart bar end-->


<!-- Add to wishlist bar -->
<!-- <div id="wishlist_side" class="add_to_cart right">
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
</div> -->
<!-- Add to wishlist bar end-->


<!-- My account bar -->
<!-- <div id="myAccount" class="add_to_cart right">
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
</div> -->
<!-- Add to wishlist bar end-->

<!-- Quick-view modal popup start-->
<!-- <div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="row" id="product_quickview">
                    
                    
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Quick-view modal popup end-->

<input id="ratings-hidden" name="rating" type="hidden">
<!-- tap to top -->
<!-- <div class="tap-top star-top">
    <div>
        <i class="fa fa-star star-icon" aria-hidden="true">
            <i class="fa fa-angle-double-up"></i>
        </i>
    </div>
</div> -->
<!-- tap to top End -->

<script src="<?= base_url('assets/js/system.js') ?>"></script>
<script src="<?= base_url('templatejs/bootstrap.min.js') ?>" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script src="<?= base_url('templatejs/swiper.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="<?= base_url('templatejs/custom.js') ?>" ></script>

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
    function deleteShippingAddress(address_id){
        $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/delete_manage_address') ?>',
                                data: {address_id:address_id}
                 }).done(function (data) {
                     location.reload(true);
                    
        });
        
        
    }
    function razorpayPayment()
    {
        $('#payment_type').val('Razorpay');
        // $('#delivery_amount').html("0");
        // $('#shpping_cost').val(0);
        // var total_amount = 0;
        // var discountType = $('#discountType').val();
        // if(discountType == 7){
        //             var total_amount = (parseFloat($('#subTotalTwo').val())  - parseFloat($('#paid_amount').val()));
        //         }
        //         else{
        //         var total_amount = (parseFloat($('#subTotalTwo').val()) - parseFloat($('#discountAmount').val()) - parseFloat($('#paid_amount').val()));
        //         }
        // //total_amount = (parseFloat($('#subTotalTwo').val()) - parseFloat($('#discountAmount').val()) - parseFloat($('#paid_amount').val()));
        // $('.total_price').html('<?= CURRENCY ?>'+total_amount);
        // $('#final-amount').val(total_amount);
        // $('#final-amount-two').val(total_amount);    
        // $('#razorpay_payment_option').prop('checked',true);
        // $('#freecharge_payment').show();
        // $('.payment_method').show();
    }
    function changeCod(){
        $('#payment_type').val('cashOnDelivery');
        // //console.log($('#final-amount-two').val());
        // var stateId = $('#selectedStateID').val();
        // var total_amount = 0;
        // var total_amount = parseFloat($('#final-amount-two').val());
        // $('#total_price').html('<?= CURRENCY ?>'+total_amount);
        // $('#final-amount').val(total_amount);
        // //var subTotalPrice = total_amount;
        // //console.log("amount", total_amount);
        // if(total_amount >= '1000'){
        //         console.log("1st");
        //         $('#delivery_amount').html("0");
        //         $('#shpping_cost').val(0);
        //         total_amount = parseFloat($('#final-amount-two').val());
        //         console.log("total_amount", total_amount);
        //         $('.total_price').html('<?= CURRENCY ?>'+total_amount);
        //         $('#final-amount').val(total_amount);
        //         $('[name="final_amount_two"]').val(total_amount);
        //         $('#cod').prop('checked',true);
        //         $('#freecharge_payment').show();
        //         $('.payment_method').show();
        // }
        // else if(total_amount < '1000' && stateId == '41'){
        //             console.log("2nd");
        //             $('#delivery_amount').html('45.00');
        //             $('#shpping_cost').val('45.00');
        //             total_amount = (parseFloat($('#final-amount-two').val())+parseFloat('45.00')).toFixed(2);
        //             console.log("total_amount", total_amount);
        //             $('.total_price').html('<?= CURRENCY ?>'+total_amount);
        //             $('#final-amount').val(total_amount);
        //             $('[name="final_amount_two"]').val(total_amount);
        //             $('#cod').prop('checked',true);
        //             $('#freecharge_payment').show();
        //             $('.payment_method').show();
        // }
        // else{
        //             console.log("3rd");
        //             $('#delivery_amount').html('69.00');
        //             $('#shpping_cost').val('69.00');
        //             total_amount = (parseFloat($('#final-amount-two').val())+parseFloat('69.00')).toFixed(2);
        //             console.log("total_amount", total_amount);
        //             $('.total_price').html('<?= CURRENCY ?>'+total_amount);
        //             $('#final-amount').val(total_amount);
        //             $('[name="final_amount_two"]').val(total_amount);
        //             $('#cod').prop('checked',true);
        //             $('#freecharge_payment').show();
        //             $('.payment_method').show();
        // }
    }
	function setDeliveryAddress(address_id,stateID,sortname,price,tier,pincode){
    //console.log("ok");        
        $('#selectedStateID').val(stateID);
        var subTotalPrice = 0;
        var discountAmount = 0;
        var paid_amount = 0;
        var isReferral = 0;
        var total_amount = 0;
        var giftAmount = 0;
        var discountType = $('#discountType').val();
        $('#selected_address_id').val(address_id);
        $('#address_field').hide();
        $('#add_new_addreess').hide();
        $('#shipping_edit').show();
        $('#place_order').show(); 
        $('.second-mode').show();
        discountAmount = parseFloat($('[name="discountAmount"]').val());
        paid_amount = parseFloat($('#paid_amount').val());
        giftAmount = parseFloat($('#giftAmount').val());
        isReferral = parseFloat($('.isReferral').val());
        //console.log(giftAmount); return;
        //$('#freecharge_payment_option').prop('checked',false);
        subTotalPrice = parseFloat(price - discountAmount - isReferral - paid_amount - giftAmount);
        subTotalPriceTwo = parseFloat(price);
        //console.log("subTotalPrice",subTotalPrice);
        //console.log("subTotalPriceTwo",subTotalPriceTwo); 
        $.ajax({
            type: "POST",
            url: '<?= base_url('ShoppingCartPage/checkDeliverPinTwo') ?>',
            data: {pincode: pincode},
            //dataType: 'JSON',
        }).done(function (data) {
            //$('.deliveryAvailable').show();
            $('.daliveryDate').html(data);
        });
        if(tier == 1){
         
        if(subTotalPriceTwo >= 1000){
                console.log("1st");
                $('#delivery_amount').html("0.00");
                $('#delivery_amount_two').html("0.00");
                $('#shpping_cost').val(0.00);
                var total_amount = subTotalPrice;
                if(discountType == 7){
                    var total_amount = (subTotalPriceTwo).toFixed(2);
                }
                else{
                var total_amount = (subTotalPrice).toFixed(2);
                }
                console.log("total_amount", total_amount);
                $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                $('.total_price').html('<?= CURRENCY ?>'+total_amount);
                $('#final-amount').val(total_amount);
                $('[name="final_amount_two"]').val(total_amount);
                $('#selectedAmount').html('<?= CURRENCY ?>'+total_amount);
                    
                $('#razorpay_payment_option').prop('checked',true);
                //$('#freecharge_payment').show();
                $('.payment_method').show();
        }else{
            if(stateID == '41'){

                        console.log("2nd");
                        var discountType = $('#discountType').val();
                        // if(discountType == 7){
                        //     var total_amount = (parseFloat($('#subTotalTwo').val())  - parseFloat($('#paid_amount').val()));
                        // }
                        // else{
                        // var total_amount = (parseFloat($('#subTotalTwo').val()) - parseFloat($('#discountAmount').val()) - parseFloat($('#paid_amount').val()));
                        // }
                        $('#delivery_amount').html("45.00");
                        $('#delivery_amount_two').html("45.00");
                        $('#shpping_cost').val('45.00');
                        // var total_amount = (subTotalPrice - discountAmount - paid_amount - isReferral);
                        if(discountType == 7){
                             //console.log("discountType 7");
                        var total_amount = (subTotalPriceTwo + parseFloat('45.00') - paid_amount - isReferral - giftAmount).toFixed(2);
                        }
                        else{
                        var total_amount = (subTotalPrice + parseFloat('45.00')).toFixed(2);
                        }
                        // total_amount = (parseFloat($('#final-amount-two').val())+parseFloat('45.00')).toFixed(2);
                        // total_amount = (subTotalPrice + parseFloat('45.00') -discountAmount - paid_amount - isReferral).toFixed(2);
                        console.log("total_amount", total_amount);
                        $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                        $('.total_price').html('<?= CURRENCY ?>'+total_amount);
                        $('#final-amount').val(total_amount);
                        $('[name="final_amount_two"]').val(total_amount);
                        $('#selectedAmount').html('<?= CURRENCY ?>'+total_amount);
                        
                        $('#razorpay_payment_option').prop('checked',true);
                        $('.payment_method').show();
            }
            else{
                        console.log("3rd");
                        $('#delivery_amount').html("65.00");
                        $('#delivery_amount_two').html("65.00");
                        $('#shpping_cost').val('65.00');
                        //var total_amount = subTotalPrice;
                        //var total_amount = (subTotalPrice - discountAmount - paid_amount - isReferral);
                        if(discountType == 7){
                        var total_amount = (subTotalPriceTwo + parseFloat('65.00') - paid_amount - isReferral - giftAmount).toFixed(2);
                        }
                        else{
                        var total_amount = (subTotalPrice + parseFloat('65.00')).toFixed(2);
                        }
                        // total_amount = (parseFloat($('#final-amount-two').val())+parseFloat('45.00')).toFixed(2);
                        //total_amount = (subTotalPrice + parseFloat('65.00') -discountAmount - paid_amount - isReferral).toFixed(2);
                        console.log("total_amount", total_amount);
                        $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                        $('.total_price').html('<?= CURRENCY ?>'+total_amount);
                        $('#final-amount').val(total_amount);
                        $('[name="final_amount_two"]').val(total_amount);
                        $('#selectedAmount').html('<?= CURRENCY ?>'+total_amount);

                        $('#razorpay_payment_option').prop('checked',true);
                        //$('#freecharge_payment').show();
                        $('.payment_method').show();
            }
        } 
    }
        
        
    }

    
    function apply_free_product(){
            //Reset Previous discount if applied
            // if($('#discountAmount').val()!=0){
            //     $('#final-amount').val($('#final-amount').val()+$('#discountAmount').val());
            // }
        if($('#free_product_added').val() == 0){
            $("#freeCartProduct").modal('show');
            return true;
        }
        else{
         if($('#discountAmount').val()!=0){
                $('#final-amount').val($('#subTotalTwo').val());
                // $('#final-amount-two').val($('#final-amount-two').val()+$('#discountAmount').val());
            }

             $('.cart-product-area div#show_product:last').append(cart_line_item);
            
             $('#freeProduct').modal('hide');
             var enteredCode = $('[name="discountCode"]').val();
             var vendors  = $('#vendors').val();
             var subTotal = parseFloat($('#subTotal').val()).toFixed(0);

             var final_amount_before = Number($('#final-amount').val());
             //var sub_total_before = Number($('#subTotal').val());
             var total_offer_amount = Number($('#freeProductPrice').val());
             var discountAmoun;
             var final_amount = final_amount_before - total_offer_amount;
             //var final_amount = final_amount_before;
             var discountAmoun = total_offer_amount;
             $('#discount_form').hide();

            //discountAmoun = parseFloat(discountAmoun).toFixed(2);
            // $('.final-amount').text(final_amount.toFixed(2));
            // $('#final-amount-two').val(final_amount);
            // $('#final-amount').val(final_amount);
            $('[name="discountAmount"]').val(discountAmoun);
            $('#discount_row').show();
            $('#discount-amount').html(" -"+discountAmoun);
            $('.discount-amount').html(" -"+discountAmoun);
            //$('.applyedCouponCode').html("Coupon Applied : "+enteredCode);
            $('.before-apply').hide();
            $('.after-apply').show();
            
            $("#coupon_discount_type").val(discountAmoun);
            $("#freeCartProduct").modal('hide');
            // $('.final-amount').text(final_amount.toFixed(2));
            // $('#final-amount').val(final_amount);
            // $('[name="discountAmount"]').val(discountAmoun);
            // $('#discount_row').show();
            // $('#discount-amount').html(" -"+discountAmoun);
            //is_discounted = true;
        }
            
             
        }
		function applycoupon(){
			//Reset Previous discount if applied
			// if($('#discountAmount').val()!=0){
			// 	$('#final-amount').val($('#final-amount').val()+$('#discountAmount').val());
			// }
            if($('#discountAmount').val()!=0){
                $('#final-amount').val($('#subTotalTwo').val());
                // $('#final-amount-two').val($('#final-amount-two').val()+$('#discountAmount').val());
            }
			 $('.not_applyed').hide();
             $('.apply').show();
			 $('#freeProduct').modal('hide');
             $('.applyed').hide();
			 var enteredCode = $('[name="discountCode"]').val();
			 var vendors  = $('#vendors').val();
             var subTotal = parseFloat($('#subTotal').val()).toFixed(0);
             var subTotalTwo = parseFloat($('#subTotalTwo').val()).toFixed(0);
             var subTotalThree = parseFloat($('#subTotalTwo').val()).toFixed(2);
             //console.log("subTotal", subTotal); return;
             var shppingCost = Number($('#shpping_cost').val());
				$.ajax({
					type: "POST",
					url: variable.discountCodeChecker,
					data: {enteredCode: enteredCode, vendors : vendors, subTotal : subTotal, subTotalTwo : subTotalTwo}
				}).done(function (data) {
                    //console.log(data)
					if (data == 0) {
							$('.not_applyed_text').show();
                            // $('.final-amount').text(subTotalThree);
                            // $('#final-amount').val(subTotalThree);
                            // $('#final-amount-two').val(subTotal);
                            $('[name="discountAmount"]').val(0);
                            $('#discount_row').hide();
                            $('#discount-amount').html(0);
                            $('.discount-amount').html(0);
                            
					}else if(data == 401){
                            $('.not_applyed_text').show();
                            // $('.final-amount').text(subTotalThree);
                            // $('#final-amount').val(subTotalThree);
                            // $('#final-amount-two').val(subTotalTwo);
                            $('[name="discountAmount"]').val(0);
                            $('#discount_row').hide();
                            $('#discount-amount').html(0);
                            $('.discount-amount').html(0);
                    }else if(data == 402){
                            $('.not_applyed_text').show();
                            // $('.final-amount').text(subTotalThree);
                            // $('#final-amount').val(subTotalThree);
                            // $('#final-amount-two').val(subTotalTwo);
                            $('[name="discountAmount"]').val(0);
                            $('#discount_row').hide();
                            $('#discount-amount').html(0);
                            $('.discount-amount').html(0);
                    }else {
                        //console.log("Data", data);
						//if (is_discounted == false) {
							var obj = jQuery.parseJSON(data);
                            //console.log("obj", obj);
                            if(obj.offer_types == 7){
                                //console.log("ok");
                                var productID = obj.freeProductID;
                                var productIDArray = productID.split(',');
                                var numberOfFreeProduct = obj.numberOfFreeProduct
                                $('#max_free_product').val(numberOfFreeProduct);
                                var arr = [];

                                var final_amount_before = Number($('#final-amount').val());


                                // $('.final-amount').text(subTotalThree);
                                // $('#final-amount').val(subTotalThree);
                                // $('#final-amount-two').val(subTotalTwo);
                                // $('[name="discountAmount"]').val(0);
                                // $('#discount_row').hide();
                                // $('#discount-amount').html(0);
                                // $('.discount-amount').html(0);

                                //for(var i = 0; i < productIDArray.length; i++){
                                   //console.log(productIDArray[i]);
                                    $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url('home/getFreeProductList'); ?>",
                                    data: { productID: productIDArray },
                                    success: function(responce)
                                    {
                                        $.fancybox.close();
                                        $('#discountType').val(7);
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
							var final_amount_before = Number($('#merchandise_subtotal').val());
                            //var sub_total_before = Number($('#subTotal').val());
							var discountAmoun;
                            var final_amount;
                            var coupon_discount_type = "";
							if (obj.type == 'percent') {
                                if(obj.offer_types == 2  || obj.offer_types == 9){
                                    var substract_num = (obj.amount / 100) * obj.product_amount;
                                    if(substract_num>final_amount_before){
                                        substract_num = final_amount_before;
                                     }
                                     final_amount= (final_amount_before + shppingCost) - substract_num;
                                    discountAmoun = substract_num;
                                    coupon_discount_type = '%';
                                }else{
                                     var substract_num = (obj.amount / 100) * final_amount_before;
                                    if(substract_num>final_amount_before){
                                        substract_num = final_amount_before;
                                     }
                                     final_amount= (final_amount_before + shppingCost) - substract_num;
                                    discountAmoun = substract_num;
                                    coupon_discount_type = '%';
                                }
                               
                            }
							if (obj.type == 'float') {
                                if(obj.amount>final_amount_before){
                                    obj.amount = final_amount_before;
                                 }
								final_amount = (final_amount_before + shppingCost) - obj.amount;
								discountAmoun = obj.amount;
							}
							$('#discount_form').hide();
							discountAmoun = parseFloat(discountAmoun).toFixed(2);
							$('.final-amount').text('<?= CURRENCY ?>'+final_amount.toFixed(2));
                            $('#final-amount-two').val(final_amount);
							$('#final-amount').val(final_amount);
							$('[name="discountAmount"]').val(discountAmoun);
							$('#discount_row').show();
							$('#discount-amount').html(" -"+discountAmoun);
                            $('.discount-amount').html(" -"+discountAmoun);
                            $('.not_applyed_text').hide();
							//is_discounted = true;
                            // var spendValue = 0;
                            // if(final_amount < 1000){
                            //     spendValue = (1000 - final_amount).toFixed(2);
                            //     $('.firstOpenSpend').hide();
                            //     $('.firsthideSpend').show();
                            //     $('.firsthideSpend').html('Spend ₹'+spendValue+' more to get free delivery');
                            // }
                            $('.applyedCouponCode').html("Coupon Applied : "+enteredCode);
                            $("#coupon_code").val(enteredCode);
                            $("#coupon_discount_type").val(obj.amount+" "+coupon_discount_type);
                            $('.before-apply').hide();
                            $('.after-apply').show();
                            $('.birthday_amount').val(obj.birthday_amount);
                            $.fancybox.close();
							// Swal.fire({
							//   icon: 'success',
							//   text: 'Discount Code Applied'
							// })
						//}
					}
				});
			 
		}
var variable = {
			clearShoppingCartUrl: "<?= base_url('clearShoppingCart') ?>",
			manageShoppingCartUrl: "<?= base_url('manageShoppingCart') ?>",
			discountCodeChecker: "<?= base_url('discountCodeChecker') ?>"
		};
        function singleCouponApply(code,key){            
            var discount_code = code;
            var couponID = key;

            $('.applyed').hide();
            $('.apply').show();
            $('.not_applyed_text').hide();
            //is_discounted == false
            // if($('#discountAmount').val()!=0){
            //     $('#final-amount').val($('#final-amount').val()+$('#discountAmount').val());
            //     // $('#final-amount-two').val($('#final-amount-two').val()+$('#discountAmount').val());
            // }
            if($('#discountAmount').val()!=0){
                $('#final-amount').val($('#subTotalTwo').val());
                // $('#final-amount-two').val($('#final-amount-two').val()+$('#discountAmount').val());
            }
            
             $('#freeProduct').modal('hide');
             var enteredCode = discount_code;
             
             var enteredCodes = $('[name="free_product_coupon"]').val();
             //console.log(enteredCode);
             var vendors  = $('#vendors').val();
             var subTotal = parseFloat($('#subTotal').val()).toFixed(0);
             var subTotalTwo = parseFloat($('#subTotalTwo').val()).toFixed(0);
             var subTotalThree = parseFloat($('#subTotalTwo').val()).toFixed(2);

             var shppingCost = Number($('#shpping_cost').val());
            //console.log("shppingCost", shppingCost);
            // console.log("subTotalTwo", subTotalTwo);
            // console.log("subTotalThree", subTotalThree);
            // return;
             $('.not_applyed').hide();
             
             //console.log("subTotalTwo", subTotalTwo); 
                $.ajax({
                    type: "POST",
                    url: variable.discountCodeChecker,
                    data: {enteredCode: enteredCode, vendors : vendors, subTotal : subTotal, subTotalTwo : subTotalTwo}
                }).done(function (data) {
                    //console.log(data)
                    if (data == 0) {
                            $('#not_applyed'+couponID).show();
                            //$('#applyed'+couponID).show();
                            $('#apply'+couponID).hide();
                            // $('.final-amount').text(subTotalThree);
                            // $('#final-amount').val(subTotalThree);
                            // $('#final-amount-two').val(subTotalTwo);
                            $('[name="discountAmount"]').val(0);
                            $('#discount_row').hide();
                            $('#discount-amount').html(0);
                            $('.discount-amount').html(0);
                            
                    }else if(data == 401){
                            $('#not_applyed'+couponID).show();
                            //$('#applyed'+couponID).show();
                            $('#apply'+couponID).hide();
                            // $('.final-amount').text(subTotalThree);
                            // $('#final-amount').val(subTotalThree);
                            // $('#final-amount-two').val(subTotalTwo);
                            $('[name="discountAmount"]').val(0);
                            $('#discount_row').hide();
                            $('#discount-amount').html(0);
                            $('.discount-amount').html(0);
                    }else if(data == 402){
                            $('#not_applyed'+couponID).show();
                            //$('#applyed'+couponID).show();
                            $('#apply'+couponID).hide();
                            // $('.final-amount').text(subTotalThree);
                            // $('#final-amount').val(subTotalThree);
                            // $('#final-amount-two').val(subTotalTwo);
                            $('[name="discountAmount"]').val(0);
                            $('#discount_row').hide();
                            $('#discount-amount').html(0);
                            $('.discount-amount').html(0);
                    }else {
                        //console.log("Data", data);
                        //if (is_discounted == false) {
                            var obj = jQuery.parseJSON(data);
                            //console.log("obj", obj);
                            if(obj.offer_types == 7){                                
                                var productID = obj.freeProductID;
                                var numberOfFreeProduct = obj.numberOfFreeProduct;
                                var productIDArray = productID.split(',');
                                //console.log("productIDArray", productIDArray);
                                $('#max_free_product').val(numberOfFreeProduct);
                                var arr = [];

                                var final_amount_before = Number($('#final-amount').val());

                                // $('.final-amount').text(subTotalThree);
                                // $('#final-amount').val(subTotalThree);
                                // $('#final-amount-two').val(subTotalTwo);
                                // $('[name="discountAmount"]').val(0);
                                // $('#discount_row').hide();
                                // $('#discount-amount').html(0);
                                // $('.discount-amount').html(0);


                                //for(var i = 0; i < productIDArray.length; i++){
                                   //console.log(productIDArray[i]);
                                    $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url('home/getFreeProductList'); ?>",
                                    data: { productID: productIDArray },
                                    success: function(responce)
                                    {
                                        $.fancybox.close();
                                        $('#discountType').val(7);
                                        $('.applyedCouponCode').html("Coupon Applied : "+enteredCode);
                                       // var items = jQuery.parseJSON(responce);
                                        $("#coupon_code").val(enteredCode);
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
                            var final_amount_before = Number($('#merchandise_subtotal').val());
                            //var sub_total_before = Number($('#subTotal').val());
                            var discountAmoun;
                            var final_amount;
                            var coupon_discount_type = "";
                            if (obj.type == 'percent') {
                                if(obj.offer_types == 2 || obj.offer_types == 9){
                                    var substract_num = (obj.amount / 100) * obj.product_amount;
                                    if(substract_num>final_amount_before){
                                        substract_num = final_amount_before;
                                     }
                                     final_amount= (final_amount_before + shppingCost) - substract_num;
                                    discountAmoun = substract_num;
                                    coupon_discount_type = '%';
                                }else{
                                     var substract_num = (obj.amount / 100) * final_amount_before;
                                    if(substract_num>final_amount_before){
                                        substract_num = final_amount_before;
                                     }
                                     final_amount= (final_amount_before + shppingCost) - substract_num;
                                    discountAmoun = substract_num;
                                    coupon_discount_type = '%';
                                }
                               
                            }
                            if (obj.type == 'float') {
                                if(obj.amount>final_amount_before){
                                    obj.amount = final_amount_before;
                                 }

                                final_amount = (final_amount_before + shppingCost) - obj.amount;
                                discountAmoun = obj.amount;
                            }

                           

                            $('#discount_form').hide();
                            discountAmoun = parseFloat(discountAmoun).toFixed(2);
                            $('.final-amount').text('<?= CURRENCY ?>'+final_amount.toFixed(2));
                            $('#final-amount').val(final_amount);
                            $('#final-amount-two').val(final_amount);
                            $('[name="discountAmount"]').val(discountAmoun);
                            $('#discount_row').show();
                            $('#discount-amount').html(" -"+discountAmoun);
                            $('.discount-amount').html(" -"+discountAmoun);
                            //is_discounted = true;
                            // $('.home_cart'+product_key).hide();
                            // $('.go_to_cart'+product_key).show();
                            $('#applyed'+couponID).show();
                            $('#apply'+couponID).hide();
                            $('#not_applyed'+couponID).hide();
                            // var spendValue = 0;
                            // if(final_amount < 1000){
                            //     spendValue = (1000 - final_amount).toFixed(2);
                            //     $('.firstOpenSpend').hide();
                            //     $('.firsthideSpend').show();
                            //     $('.firsthideSpend').html('Spend ₹'+spendValue+' more to get free delivery');
                            // }
                            $('.applyedCouponCode').html("Coupon Applied : "+discount_code);
                            $("#coupon_code").val(discount_code);
                            $("#coupon_discount_type").val(obj.amount+" "+coupon_discount_type);
                            $('.before-apply').hide();
                            $('.after-apply').show();
                            $('.birthday_amount').val(obj.birthday_amount);
                            $.fancybox.close();
                            //$('#total_price').html('<?= CURRENCY ?>'+total_amount);
                            // Swal.fire({
                            //   icon: 'success',
                            //   text: 'Discount Code Applied'
                            // })
                        //}
                    }
                });
        }
            function applyGiftVoucher(){
            // //Reset Previous discount if applied
            // // if($('#discountAmount').val()!=0){
            // //  $('#final-amount').val($('#final-amount').val()+$('#discountAmount').val());
            // // }
            if($('#giftAmount').val()!=0){
                $('#final-amount').val($('#subTotalTwo').val());
                // $('#final-amount-two').val($('#final-amount-two').val()+$('#discountAmount').val());
            }
            //  $('.not_applyed').hide();
            //  $('.apply').show();
            //  $('#freeProduct').modal('hide');
            //  $('.applyed').hide();
             var enteredCode = $('#giftVoucher').val();
             var subTotal = parseFloat($('#subTotal').val()).toFixed(0);
             var subTotalTwo = parseFloat($('#subTotalTwo').val()).toFixed(0);
             var subTotalThree = parseFloat($('#subTotalTwo').val()).toFixed(2);
             //console.log("enteredCode", enteredCode); return;
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('home/applyGiftVoucher'); ?>',
                    data: {enteredCode: enteredCode, subTotal : subTotal, subTotalTwo : subTotalTwo},
                }).done(function (data) {
                    console.log(data)
                    var obj = jQuery.parseJSON(data);
                    if (data == 0) {
                        $('.voucher_not_applyed_text').show();
                        $('.gift_amount_tr').hide();
                        // $('.final-amount').text(subTotalThree);
                        // $('#final-amount').val(subTotalThree);
                        // $('#final-amount-two').val(subTotal);
                        // $('[name="giftAmount"]').val(0);
                        // $('#gift_amount').html(0);
                    }
                    else{
                        $('.voucher_not_applyed_text').hide();
                        var final_amount_before = Number($('#final-amount').val());
                            //var sub_total_before = Number($('#subTotal').val());
                            var discountAmoun;
                            var final_amount;                            
                                if(obj.amount>final_amount_before){
                                    obj.amount = final_amount_before;
                                 }

                                final_amount = final_amount_before - obj.amount;
                                discountAmoun = obj.amount;

                           

                            //$('#discount_form').hide();
                            discountAmoun = parseFloat(discountAmoun).toFixed(2);
                            $('.final-amount').text(final_amount.toFixed(2));
                            $('#final-amount').val(final_amount);
                            $('#final-amount-two').val(final_amount);
                            $('.gift_amount_tr').show();
                            $('[name="giftAmount"]').val(discountAmoun);
                            //$('#gift_amount').html(" -₹"+discountAmoun);
                            $('.gift_amount').html(" -₹"+discountAmoun);
                            $('.applyedGiftCouponCode').html("Coupon Applied : "+enteredCode);

                            $('#gift-card-body').hide();
                            $('.apply-gift-card').show();
                            // $('#applyed'+couponID).show();
                            // $('#apply'+couponID).hide();
                            // $('#not_applyed'+couponID).hide();
                            // var spendValue = 0;
                            // if(final_amount < 1000){
                            //     spendValue = (1000 - final_amount).toFixed(2);
                            //     $('.firstOpenSpend').hide();
                            //     $('.firsthideSpend').show();
                            //     $('.firsthideSpend').html('Spend ₹'+spendValue+' more to get free delivery');
                            // }
                            // $('.applyedCouponCode').html("Coupon Applyed : "+discount_code);
                            // $('.before-apply').hide();
                            // $('.after-apply').show();
                            // $('.birthday_amount').val(obj.birthday_amount);
                           
                    }
                    
                });
             
        }

        $(".coupon_cancel").click(function(){

            //var shiping = parseFloat($('#shpping_cost').val()).toFixed(0);
            //console.log(shiping); return;
            $('.applyed').hide();
            $('.apply').show();
            // discountAmount = parseFloat($('[name="discountAmount"]').val());
            // paid_amount = parseFloat($('#paid_amount').val());
            // isReferral = parseFloat($('.isReferral').val());

            $('.not_applyed_text').hide();
            // $('#paid_amount').val();
            // $('#paid_by_point').val();
            var subTotal = (parseFloat($('#subTotalTwo').val()) + parseFloat($('#shpping_cost').val()) - parseFloat($('#paid_amount').val()) - parseFloat($('#giftAmount').val()));
            //console.log(subTotal); return;
            //var subTotalTwo = parseFloat($('#subTotalTwo').val());
            var discountAmoun = 0;
            //var final_amount = 0;
            $('.final-amount').text(subTotal.toFixed(2));
            $('#final-amount').val(subTotal);
            $('#final-amount-two').val(subTotal);
            $('[name="discountAmount"]').val(discountAmoun);
            $('#discount_row').show();
            $('#discount-amount').html(" ₹"+discountAmoun);
            $('.discount-amount').html(" ₹"+discountAmoun);
            $('#discountType').val(0);
            $('.free_product_show').remove();
            $("#coupon_code").val("");
            $("#coupon_discount_type").val("");
            var freeProductRemoved = $('#free_product_removed').val();
            if(freeProductRemoved != ''){
                $.ajax({
                                type: "POST",
                                url: "<?php echo site_url('home/free_product_remove_cart'); ?>",
                                data: { free_product_id : freeProductRemoved },
                                success: function(data)
                                {
                                    if(data != ''){
                                        location.reload(true);
                                    }
                                }
                             });
            }


        });

$(".gift_coupon_cancel").click(function(){

           
            $('.apply-gift-card').hide();
             discountAmount = parseFloat($('[name="discountAmount"]').val());
            // paid_amount = parseFloat($('#paid_amount').val());
            // isReferral = parseFloat($('.isReferral').val());

            $('.voucher_not_applyed_text').hide();
            var subTotal = (parseFloat($('#subTotalTwo').val()) + parseFloat($('#shpping_cost').val()) - parseFloat($('#paid_amount').val()) - discountAmount);
            var giftDiscountAmoun = 0;
            //var final_amount = 0;
            $('.final-amount').text(subTotal.toFixed(2));
            $('#final-amount').val(subTotal);
            $('#final-amount-two').val(subTotal);
            $('[name="giftAmount"]').val(giftDiscountAmoun);
            //$('#discount_row').show();
            $('#giftVoucher').val('');
            $('#gift_amount').html(" ₹"+giftDiscountAmoun);
            $('.gift_amount').html(" ₹"+giftDiscountAmoun);
            


        });
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
			  // Swal.fire({
			// 		  title: 'Are you sure?',
			// 		  text: "You want to cancel this order",
			// 		  icon: 'warning',
			// 		  showCancelButton: true,
			// 		  confirmButtonColor: '#3085d6',
			// 		  cancelButtonColor: '#d33',
			// 		  confirmButtonText: 'Yes'
			// 		}).then((result) => {
			// 		  if (result.value) {
			// 				window.location.href='<?= base_url('users/update-order-status')?>/'+order_id+'/cancel';
			// 			  }
			// 		});
            if (confirm("Are you sure you want to Delete")){
                window.location.href='<?= base_url('users/cancelOrder')?>/'+order_id+'/cancel';
            }
                 //location.href='linktoaccountdeletion';
		  }
          function confirm_cancel(order_id){
            
            if (confirm("Are you sure you want to cancel?")){
                window.location.href='<?= base_url('users/cancelOrder')?>/'+order_id+'/cancel';
            }
                 
          }

function sort_item(value){
			 $('#sortform').submit();
		  }
          function sort_order(value){
            $('#sortOrder').submit();
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
            $('.select_state').hide();
            $('.select_city').hide();
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

        function changeStateForDoctor(value){
            $('.select_state').hide();
            $('.select_city').hide();
            $.ajax({
                                type: "POST",
                                url: "<?php echo site_url('users/getThanaListForDoctor'); ?>",
                                data: { district:value },
                                success: function(data)
                                {
                                    $('#thanaDoctor').html(data);
                                }
                             });
        }
        function giftCoupon(){
            //console.log("ok"); return;
            var price = $('#gift_price').val();
            var name = $('#gift_name').val();
            var email = $('#gift_email').val();
            var mobile = $('#gift_mobile_no').val();
            var message = $('#gift_message').val();
            // console.log("price", price); 
            // console.log("name", name); 
            // console.log("email", email); 
            // console.log("mobile", mobile); 
            // console.log("message", message); return;
            $('.wrong_amount').hide();
            $('.wrong_firstName').hide();
            $('.wrong_emailAddress').hide();
            $('.wrong_mobileNumber').hide();
            $('.wrong_amount_two').hide();

            if (price == ""){
                $('.wrong_amount').show();
                return true;
            }
            if (price < 500){
                $('.wrong_amount_two').show();
                return true;
            }
            var nameReg = /^[a-zA-Z ]+$/;
            if(nameReg.test(name) == false){
                //alert('Invalid First Name');
                $('.wrong_firstName').show();
                return true;
            }
             
            var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (regEmail.test(email) == false){
                    $('.wrong_emailAddress').show();
                    //alert('Invalid Email Address');
                    return true;
                }
                var regxMobile = /^[6-9]\d{9}$/;
                if(regxMobile.test(mobile) == false){
                    $('.wrong_mobileNumber').show();
                    //alert('Invalid Mobile Number');
                    return true;
                }

                $('.buy_gift').hide();
                $('#giftcard_payment_process').show();
                $.ajax({
                                type: "POST",
                                url: "<?php echo site_url('users/create_gift'); ?>",
                                data: {price:price, name:name, email:email, mobile:mobile, message:message},
                                dataType: 'JSON',
                                success: function(data)
                                {
                                    //console.log("data", data)
                                    var options = data;
                                    options.handler = function (response){
                                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                        document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                        
                                        document.razorpayGiftform.submit();
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
    }
    function selectAddressMessageRemoveClass() {
        $('.select-address-message').removeClass("active");
    }
		function place_order(){
            //console.log("ok");
            var stateId = $('#selectedStateID').val();
            var amount = $('#final-amount-two').val();
            //console.log("amount", amount); return;
            if(stateId == '' || stateId == null){
                //alert("Please select address");
                $('.select-address-message').addClass("active");
                setTimeout(selectAddressMessageRemoveClass, 2000);
                return true;
            }
            else{
            if(amount > 0){
            // var payment_type = $('input[name="payment_type"]:checked').val();
			var payment_type = $('#payment_type').val();
            //console.log(payment_type);

            //console.log("payment_type_fotter", payment_type);
            $('.please_wait').show();
            $('.place_order').hide();
            //return;
			$('#razorpay_payment_process').hide();
			if(payment_type=="Razorpay"){
				$('.place_order').hide();
                $('.please_wait').hide();
				$('#razorpay_payment_process').show();
				$.ajax({
								type: "POST",
								url: "<?php echo site_url('checkout/create_order'); ?>",
								data: $('#goOrder').serialize(),
								dataType: 'JSON',
								success: function(data)
								{
                                    //console.log("data", data)
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
        }else
            document.getElementById('goOrder').submit();
    }
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
                // console.log("star", $('#ratings-hidden').val());
			  });
			   
			   var submitting_review = false;
			   $('.submit_review').click(function(e){
				   if(!submitting_review){
					    var target = $(this).attr('data-target');
						var product_id = $(this).attr('data-product-id');
						var order_id = $(this).attr('data-order-id');
						var reload_page = $(this).attr('data-reload');
                        //console.log("target", target);
							if($('#ratings-hidden').val()==''){
                                alert("Please enter your rating");
                                return;
								// Swal.fire({
								// 		  icon: 'error',
								// 		  text: 'Please enter your rating'
								// });
							}else{
								$('#review_save'+target).show();
								submitting_review = true;
								$.ajax({
								type: "POST",
								url: "<?php echo site_url('home/add_review'); ?>",
								data: { review:$('#comment'+target).val(),rating:$('#ratings-hidden').val(),product_id:product_id,order_id:order_id },
								success: function(data)
								{
                                    $('.comment-box').hide(300);
                                    $('#reviewBox'+target).hide();
									//$('#review_save'+target).hide();
										submitting_review = false;
									$('#comment'+target).val("");
                                    //$('#ratings-hidden').val("");
                                    $('.review-success-message').addClass("active");
                                    setTimeout(RemoveReviewClass, 1700);
                                    
										/*$('#reviewbox'+target).slideUp(300, function()
										  {
											$('#review_btn'+target).fadeIn(100);
										  });
										$('#close-review-box'+target).hide();
										Swal.fire({
										  icon: 'success',
										  text: 'Thank you for giving your review/rating.'
										})*/
										
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
   function RemoveReviewClass() {
    $('.review-success-message').removeClass("active");
    }
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
<!-- <script src="<?= base_url('assets/js/system.js') ?>"></script> -->
<script type="text/javascript">
let cart_line_item = "";

//append to form element that you want .
//document.getElementById("chells").appendChild(input);
function deleteFromCart(id){
    window.location.href="<?php echo base_url('home/removeFromCart?delete-product="+id+"&back-to=shopping-cart') ?>";
		// Swal.fire({
		//   title: 'Delete Cart Item',
		//   text: "Sure to delete from cart?",
		//   icon: 'warning',
		//   showCancelButton: true,
		//   confirmButtonColor: '#3085d6',
		//   cancelButtonColor: '#d33',
		//   confirmButtonText: 'Yes, delete it!'
		// }).then((result) => {
		//   if (result.value) {
		// 	window.location.href="<?php echo base_url('home/removeFromCart?delete-product="+id+"&back-to=shopping-cart') ?>";
		//   }
		// })
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
    function add_item_to_cart_free_product(varientID, productPrice, freeProductTitle, freeProductImage){
        //const removeProductID = [];
        //removeProductID.push(varientID);
        //console.log("removeProductID",removeProductID);
        $('#no_free_product').hide();
        var variant = varientID;        
        var max_free_product = $('#max_free_product').val();
        var free_product_added = $('#free_product_added').val();


        if($('#free_product_removed').val()!=""){
            let prev_data = $('#free_product_removed').val().split(",");
            prev_data.push(variant);
            $('#free_product_removed').val(prev_data.toString());
        }else{
            $('#free_product_removed').val(variant);
        }

        if(free_product_added < max_free_product){
            cart_line_item += "<div class='free_product_show' id='show_product'><div class='each-p-product'><div class='row'><div class='col-3'><a href='javascript:void(0)'><img src='"+freeProductImage+"' width='100%'' height='auto' border='0'></a></div><div class='col-5 cart-product'><p><a href='javascript:void(0)'>"+freeProductTitle+"</a></p></div><div class='col-2'><div class='button-container'><div id='' class=''><a class='cart-qty-minus' href='javascript:void(0);'' type='button' value=''></a></div><div id='' class=''><input type='text' name='qty' class='qty quantity-num' maxlength='12' value='1' disabled='disabled'> </div><div id='' class=''> <a class='cart-qty-plus refresh-me add-to-cart' data-id='19' href='javascript:void(0);' type='button' value=''></a></div></div></div><div class='col-lg-2 col-2'><h6 class='cart-price td-color'>₹"+productPrice+".00</h6></div>  </div></div></div>";
            var btn = document.getElementById("mybtn"+variant);
            btn.value = 'Add to Cart'; // will just add a hidden value
            btn.innerHTML = 'Added';
            free_product_added++;
            $('#free_product_added').val(free_product_added);
            $('#freeProductPrice').val(Number($('#freeProductPrice').val())+Number(productPrice));
            manageShoppingCart('add', variant, false);
        }
        else{
            $('#no_free_product').show();
             $('#no_free_product').html("Maximum products allready added");

        }
        
        
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
                        $('.already-add-wishlist-message').addClass("active");
                         setTimeout(RemoveAlreadyAddWishlistClass, 1700);
                     //alert(response.message);                       
						 // Swal.fire({
						// 					  icon: 'error',
						// 					  text: response.message
						 // });
					 }else{
						 wishlist_counter++;
						 $('.wishlist_conter').text(wishlist_counter);
                         $('.add-wishlist-message').addClass("active");
                         setTimeout(RemoveAddWishlistClass, 1700);
						 //alert(response.message); 
                         //window.location.href="<?php echo base_url('home/removeFromCart?delete-product="+product_id+"&back-to=shopping-cart') ?>";
					 }
				 $('#add_to_wishlist').show();
				 $('#save_wishlist').hide();
		});
}
function RemoveAddWishlistClass() {
        $('.add-wishlist-message').removeClass("active");
}
function RemoveAlreadyAddWishlistClass() {
        $('.already-add-wishlist-message').removeClass("active");
}
function remove_item_to_wishlist(product_id){
	  $.ajax({
								type: "POST",
								url: '<?= base_url('home/remove_wishlist') ?>',
								dataType: 'JSON',
								data: {product_id: product_id}
				 }).done(function (response) {
					$('#wishlist_item'+product_id).remove();
					var wishlist_counter = $('.wishlist_conter').text();
					wishlist_counter--;
					$('.wishlist_conter').text(wishlist_counter);
					if(wishlist_counter == 0){
						$('#no_wishlist_item').show();
					}
		});
}
function best_add_remove_item_to_wishlist(product_id){
    var wishlist_counter = $('.wishlist_conter').text();
     if ($('#bestWishListAdd'+product_id).hasClass('active')){
                     $.ajax({
                                        type: "POST",
                                        url: '<?= base_url('home/remove_wishlist') ?>',
                                        dataType: 'JSON',
                                        data: {product_id: product_id}
                         }).done(function (response) {
                            wishlist_counter--;
                            $('.wishlist_conter').text(wishlist_counter);
                            
                });
             }else{
                $.ajax({
                            type: "POST",
                            url: '<?= base_url('home/add_wishlist') ?>',
                            dataType: 'JSON',
                            data: {product_id: product_id}
                         }).done(function (response) {
                             if(response.data == 0){ 
                             }else{
                                wishlist_counter++;
                                $('.wishlist_conter').text(wishlist_counter);
                                 
                             }
                });
             }

}
function recently_add_remove_item_to_wishlist(product_id){
    var wishlist_counter = $('.wishlist_conter').text();
    var target = $("#recentlyWishListAdd"+product_id).attr("data-target");
    // console.log(target); return;
    
    if ($('#recentlyWishListAdd'+product_id).hasClass('active')){
        $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/remove_wishlist') ?>',
                                dataType: 'JSON',
                                data: {product_id: product_id}
                 }).done(function (response) {
                            wishlist_counter--;
                            $('.wishlist_conter').text(wishlist_counter);
                    
        });
    }
    else{
        $.ajax({
                    type: "POST",
                    url: '<?= base_url('home/add_wishlist') ?>',
                    dataType: 'JSON',
                    data: {product_id: product_id}
                 }).done(function (response) {
                     if(response.data == 0){ 
                     }else{
                         wishlist_counter++;
                         $('.wishlist_conter').text(wishlist_counter);
                         
                     }
        });
    }
}
function gift_add_remove_item_to_wishlist(product_id){
     //setTimeout(function(){
    var wishlist_counter = $('.wishlist_conter').text();
                if ($('#giftWishListAdd'+product_id).hasClass('active')){
                     $.ajax({
                                        type: "POST",
                                        url: '<?= base_url('home/remove_wishlist') ?>',
                                        dataType: 'JSON',
                                        data: {product_id: product_id}
                         }).done(function (response) {
                            wishlist_counter--;
                            $('.wishlist_conter').text(wishlist_counter);
                            
                });
             }else{
                $.ajax({
                            type: "POST",
                            url: '<?= base_url('home/add_wishlist') ?>',
                            dataType: 'JSON',
                            data: {product_id: product_id}
                         }).done(function (response) {
                             if(response.data == 0){ 
                             }else{
                                 wishlist_counter++;
                                 $('.wishlist_conter').text(wishlist_counter);
                                 
                             }
                });
             }                
     //},300);
     
    

}
function regime_add_remove_to_wishlist(product_id){
    var wishlist_counter = $('.wishlist_conter').text();
     //setTimeout(function(){
    //console.log(($('#rgimeWishListAdd'+product_id).hasClass('active')));
                if ($('#rgimeWishListAdd'+product_id).hasClass('active')){
                     $.ajax({
                                        type: "POST",
                                        url: '<?= base_url('home/remove_wishlist') ?>',
                                        dataType: 'JSON',
                                        data: {product_id: product_id}
                         }).done(function (response) {
                            wishlist_counter--;
                            $('.wishlist_conter').text(wishlist_counter);
                            
                });
             }else{
                $.ajax({
                            type: "POST",
                            url: '<?= base_url('home/add_wishlist') ?>',
                            dataType: 'JSON',
                            data: {product_id: product_id}
                         }).done(function (response) {
                             if(response.data == 0){ 
                             }else{
                                wishlist_counter++;
                                $('.wishlist_conter').text(wishlist_counter);
                                 
                             }
                });
             }                
     //},300);
     
    

}
function pdp_add_remove_to_wishlist(product_id){
    var wishlist_counter = $('.wishlist_conter').text();
                if ($('#pdpAddToWishList'+product_id).hasClass('active')){
                     $.ajax({
                                        type: "POST",
                                        url: '<?= base_url('home/remove_wishlist') ?>',
                                        dataType: 'JSON',
                                        data: {product_id: product_id}
                         }).done(function (response) {
                            wishlist_counter--;
                            $('.wishlist_conter').text(wishlist_counter);
                            
                });
             }else{
                $.ajax({
                            type: "POST",
                            url: '<?= base_url('home/add_wishlist') ?>',
                            dataType: 'JSON',
                            data: {product_id: product_id}
                         }).done(function (response) {
                             if(response.data == 0){ 
                             }else{
                                 wishlist_counter++;
                                 $('.wishlist_conter').text(wishlist_counter);
                                 
                             }
                });
             }

}
function relatedProduct_add_remove_to_wishlist(product_id){
    var wishlist_counter = $('.wishlist_conter').text();
        if ($('#relatedProductAdd'+product_id).hasClass('active')){
             $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/remove_wishlist') ?>',
                                dataType: 'JSON',
                                data: {product_id: product_id}
                 }).done(function (response) {
                    wishlist_counter--;
                    $('.wishlist_conter').text(wishlist_counter);
                    
        });
     }else{
        $.ajax({
                    type: "POST",
                    url: '<?= base_url('home/add_wishlist') ?>',
                    dataType: 'JSON',
                    data: {product_id: product_id}
                 }).done(function (response) {
                     if(response.data == 0){ 
                     }else{
                         wishlist_counter++;
                         $('.wishlist_conter').text(wishlist_counter);
                         
                     }
        });
     }

}
function newArival_add_remove_to_wishlist(product_id){
    var wishlist_counter = $('.wishlist_conter').text();
        if ($('#newArivalListAdd'+product_id).hasClass('active')){
             $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/remove_wishlist') ?>',
                                dataType: 'JSON',
                                data: {product_id: product_id}
                 }).done(function (response) {
                    wishlist_counter--;
                    $('.wishlist_conter').text(wishlist_counter);
                    
        });
     }else{
        $.ajax({
                    type: "POST",
                    url: '<?= base_url('home/add_wishlist') ?>',
                    dataType: 'JSON',
                    data: {product_id: product_id}
                 }).done(function (response) {
                     if(response.data == 0){ 
                     }else{
                         wishlist_counter++;
                         $('.wishlist_conter').text(wishlist_counter);
                         
                     }
        });
     }

}
function featured_add_remove_to_wishlist(product_id){
    var wishlist_counter = $('.wishlist_conter').text();
        if ($('#featuredListAdd'+product_id).hasClass('active')){
             $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/remove_wishlist') ?>',
                                dataType: 'JSON',
                                data: {product_id: product_id}
                 }).done(function (response) {
                    wishlist_counter--;
                    $('.wishlist_conter').text(wishlist_counter);
                    
        });
     }else{
        $.ajax({
                    type: "POST",
                    url: '<?= base_url('home/add_wishlist') ?>',
                    dataType: 'JSON',
                    data: {product_id: product_id}
                 }).done(function (response) {
                     if(response.data == 0){ 
                     }else{
                         wishlist_counter++;
                         $('.wishlist_conter').text(wishlist_counter);
                         
                     }
        });
     }

}
function buy_now(){
		var variant = $('#variant').val();
		manageShoppingCart('add', variant, 'checkout');
		
}
function buy_now_pdp(product_id){
        var variant = product_id;
        $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/addProductIntoCartDB') ?>',
                                data: {product_id: variant},
                                dataType: 'JSON',
                 });
        manageShoppingCart('add', variant, 'shopping-cart', 'buy_now');
        
}
$('.cart-qty-plus').click(function(){
    var variant = $(this).attr('data-id');
        $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/addProductIntoCartDB') ?>',
                                data: {product_id: variant},
                                dataType: 'JSON',
                 });
});
$('.cart-qty-minus').click(function(){
    var variant = $(this).attr('data-id');
        $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/removeProductIntoCartDB') ?>',
                                data: {product_id: variant},
                                dataType: 'JSON',
                 });
});

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
									$('.success_newsletter').show();
                                    $('.error_newsletter').hide();
                                    $('.email_error_newsletter').hide();
								}
								else{
									$('.success_newsletter').hide();
                                    $('.error_newsletter').show();
                                    $('.email_error_newsletter').hide();
								}
								
								$('#subscribe_email').val("");
								$('#mc-submit').prop('disabled', false);
							});
						}else{
							        $('.success_newsletter').hide();
                                    $('.error_newsletter').hide();
                                    $('.email_error_newsletter').show();
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
<script type="text/javascript">
    $(".btn-add-cart-list").click(function(){
            var product_id = $(this).data('id');
            var product_key = $(this).data('key');
            //manageShoppingCart('add', product_id, false);
            console.log(product_id);
            $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/addToCartProduct') ?>',
                                data: {product_id: product_id},
                                dataType: 'JSON',
                 }).done(function (data) {
                     if(data){
                         //console.log(data)
                         manageShoppingCart('add', data, false);
                         $('.home_cart'+product_key).hide();
                         $('.go_to_cart'+product_key).show();
                         //alert("Item added to your cart");
                     }
                     
                    
                 });
          });
    $(".frequentlyProduct-add-cart").click(function(){
            var product_id = $(this).data('id');
            var product_key = $(this).data('key');
            //manageShoppingCart('add', product_id, false);
            console.log(product_id);
            $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/addToCartProduct') ?>',
                                data: {product_id: product_id},
                                dataType: 'JSON',
                 }).done(function (data) {
                     if(data){
                         //console.log(data)
                         manageShoppingCart('add', data, false);
                         $('.frequently_cart'+product_key).hide();
                         $('.go_to_frequently_cart_cart'+product_key).show();
                         //alert("Item added to your cart");
                     }
                     
                    
                 });
          });
    $(".btn-add-cart-wishlist").click(function(){
            var product_id = $(this).data('id');
            //manageShoppingCart('add', product_id, false);
            //console.log(product_id);
            $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/addToCartWishlist') ?>',
                                data: {product_id: product_id},
                                dataType: 'JSON',
                 }).done(function (data) {
                     if(data){
                         //console.log(data)
                        manageShoppingCart('add', data, false);
                        $('#wishlist_item'+product_id).remove();
                        var wishlist_counter = $('.wishlist_conter').text();
                        wishlist_counter--;
                        $('.wishlist_conter').text(wishlist_counter);
                        if(wishlist_counter == 0){
                            $('#no_wishlist_item').show();
                        }
                         //alert("Item added to your cart");
                     }
                     
                    
                 });
          });
    function add_item_to_cart_pdp(variant){
        $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/addProductIntoCartDB') ?>',
                                data: {product_id: variant},
                                dataType: 'JSON',
                 });
       manageShoppingCart('add', variant, false);
        $('.pdpAddCart').hide();
        $('.pdpGoCart').show();
        //alert("Item added to your cart");
    };
     $(".add_item_cartpage").click(function(){
        var variant = $(this).data('id');
        $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/addProductIntoCartDB') ?>',
                                data: {product_id: variant},
                                dataType: 'JSON',
                 });
        manageShoppingCart('add', variant, 'shopping-cart');
        //alert("Item added to your cart");
    });
    function frequentlyBought(){
        var varientID = $('#vID').val();
        //console.log(varientID);
        $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/frequentlyBoughTtogether') ?>',
                                data: {varientID: varientID},
                                dataType: 'JSON',
                 }).done(function (data) {
                     if(data){
                        var i; 
                        for (i = 0; i < data.length; i++) {
                            //console.log(data[i]);
                            manageShoppingCart('add', data[i], false);
                            
                        }
                        $('.frequentlyBoughtCart').hide();
                        $('.frequentlyBoughtGoto').show();
                        //alert("Item added to your cart");
                     }
                     
                    
                 });
    }

    $("#loginDuplicate").click(function(e){
        // var pathname = window.location.pathname;
        // console.log("pathname",pathname);
        // return;
          // var queryString = window.location.search;
          // console.log("queryString",queryString);
          // return;
          $('.blank_number').hide();
          var mobile = $("#mobile_no").val();
          var validForm = true;
          if(mobile == '' || mobile == null){
            $('.blank_number').show();
            validForm = false;
            return true;
            
          }
          //$('#redirecPage').val('');
          $('#no_mobile').val(mobile);
          $('.otp-login').hide();
          $('.wrong_mobile').hide();
          $('.login_wait').show();
          $('.firstLogin').hide();
           $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/loginDuplicate',
                data: {mobile : mobile},
                dataType: 'JSON',              
              }).done(function (data) {
                        //console.log(data);
                        $('.login_wait').hide();
                        $('.firstLogin').show();
                        if(data == '1'){
                            //console.log("ok");
                            $('.blank_number').hide();
                            $.fancybox.close();
                            $.fancybox.close();
                            $.fancybox.close();
                            $.fancybox.close();
                            $('#registration_otp').modal('show');

                            $('.f-login').show();                            
                           // $('.otp-login').show();
                            
                            /*setTimeout(function(){
                                
                            },300);*/
                            // $('.otp-login').show()
                        }
                        else{
                            //console.log(data);
                            //alert("Mobile number are not valid!");
                            $('#mobile').val($('#mobile_no').val());
                            $('.hide-signup').show();
                            $('.if-errow').hide();
                            $('.wrong_mobile').show();
                            $('.f-login').show();
                            $('.otp-login').hide()
                            $('.blank_number').hide();
                        }
                    
                 });
      });
    $("#otpVerify").click(function(e){
          var otp_no = $("#otp_no").val();
          var mobile_no = $('#no_mobile').val();
          var redirecPage = $('#redirecPage').val();
          // $('.otp-login').hide();
          $('.wrong_mobile').hide();
           $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/otp_verify',
                data: {otp_no : otp_no, mobile_no : mobile_no},
                dataType: 'JSON',              
              }).done(function (data) {
                        console.log(data);
                        if(data == '1'){
                            $('.sent_to').val('');

                            $.fancybox.close();
                            $.fancybox.close();
                            //$('#new_address').modal('show');
                            if(redirecPage == 1)
                            {
                                window.location.href='<?= LANG_URL . '/summary' ?>';
                            }
                            else{
                                location.reload(true);
                            }
                            $('#redirecPage').val('');
                            // setTimeout(function(){
                            //      location.reload(true);
                            //     //$('#new_address').modal('show');
                            // },1400);
                            // $('.f-login').hide();
                            // $('.otp-login').hide();
                        }
                        else{
                            //console.log(data);
                            //alert("OTP number are not valid!");
                            $('.wrong_mobile').show();
                            $('.f-login').hide();
                            $('.otp-login').show()
                        }
                    
                 });
      });
    function resendOtp(){
         var mobile_no = $('#no_mobile').val();
         // console.log(mobile_no);
         // return true;
         $('.wrong_mobile').hide()
        $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/resend_otp',
                data: {mobile_no : mobile_no},
                dataType: 'JSON',              
              }).done(function (data) {
                        console.log(data);
                        if(data == '1'){
                            $('.resend_otp').show();
                            $('.f-login').hide();
                            $('.otp-login').show();
                        }
                        else{
                            //console.log(data);
                            alert("OTP number are not valid!");
                            $('.wrong_mobile').show();
                            $('.f-login').hide();
                            $('.otp-login').show()
                        }
                    
                 });
    }
    function registration_otp(){
        $.fancybox.close();
        $.fancybox.close();
        $.fancybox.close();
        
          var otp_no_reg = $("#otp_no_reg").val();
          var mobile_no = $('#mobile_no').val();
          var mobile = $("#mobile").val();
          //console.log(mobile_no);
          // $('.otp-login').hide();
          $('.wrong_mobile').hide();
          $('.waitOtp').show();
          $('.firstOtp').hide();
          registration();
          // $('#registration_otp').modal('show');
          $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/registrationLogin',
                data: {mobile_no : mobile_no, mobile : mobile},
                dataType: 'JSON',              
              }).done(function (data) {
                        //console.log(data);
                        $('.waitOtp').hide();
                        $('.firstOtp').show();
                        if(data == '1'){
                            $('.resend_otp').show();
                            $('.f-login').hide();
                            $('#registration_otp').modal('show');
                            //$('.otp-login').show();
                        }
                        else{
                            $('#registration_otp').modal('hide');
                            //console.log(data);
                            //alert("OTP number are not valid!");
                            //$('.wrong_mobile').show();
                            //$('.f-login').hide();
                            //$('.otp-login').show()
                        }
                    
                 });
           
    }
    $("#otpVerifyReg").click(function(){
          var otp_no_reg = $("#otp_no_reg").val();
          var mobile_regs = $('#mobile_no').val();
          var redirecPage = $('#redirecPage').val();
          var mobile = $("#regMobileNumber").val();
          $('.wrong_mobile').hide();
          // $('.waitOtp').show();
          // $('.firstOtp').hide();
          // console.log("mobile_regs", mobile_regs);
          // console.log("mobile", mobile);
          // return;
          // console.log("redirecPage", redirecPage);
          // return;
          // $('.otp-login').hide();
          // console.log("mobile", mobile);
          // return;
          $('.wrong_mobile').hide();
           $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/otp_verify_reg',
                data: {otp_no_reg : otp_no_reg, mobile_regs : mobile_regs, mobile : mobile},
                dataType: 'JSON',              
              }).done(function (data) {
                        //console.log(data);
                        // $('.waitOtp').hide();
                        // $('.firstOtp').show();
                        if(data == '1'){
                            $('.sent_to').val('');
                            $.fancybox.close();
                            $.fancybox.close();
                            //setTimeout(function(){
                            $('#registration_otp').modal('hide');
                            // if(redirecPage == 1)
                            // {
                            //     window.location.href='<?= LANG_URL . '/summary' ?>';
                            // }
                            // else if(redirecPage == 2 || redirecPage == 0)
                            // {
                            //     location.reload(true);
                            // }
                            // else{
                            // window.location.href='<?= LANG_URL . '/category?type=shop-all' ?>';
                            // }

                            var pathname = window.location.pathname;
                            var queryString = window.location.search;
                            if(pathname == '/neolayr_v3/' || pathname == '' || pathname == '/'){
                                location.reload(true);
                            }
                            else{
                                if(queryString != ''){
                                window.location.href='<?= LANG_URL . '/summary'?>'+queryString;
                                }
                                else{
                                    window.location.href='<?= LANG_URL . '/summary'?>';
                                }
                            }
                                 //location.reload(true);
                            //},1400);
                            // $('.f-login').hide();
                            // $('.otp-login').hide();
                        }
                        else{
                            //console.log(data);
                            //alert("OTP number are not valid!");
                            $('.wrong_mobile').show();
                            $('.f-login').hide();
                            $('.otp-login').show()
                        }
                    
                 });
      });
    $(".shopping_login").click(function(e){
        //console.log("ok");
        $('#redirecPage').val(1);
        // var url = document.location.href+"&success=yes";
        // document.location = url;
    });
    $(".others_login").click(function(e){
        //console.log("ok");
        $('#redirecPage').val(2);
        // var url = document.location.href+"&success=yes";
        // document.location = url;
    });
    $(".sign_login").click(function(e){
        //console.log("ok");
        $('#redirecPage').val(3);
        // var url = document.location.href+"&success=yes";
        // document.location = url;
    });
    $(".ad-wish").click(function(e){
        //console.log("ok");
        $('#redirecPage').val(0);
        // var url = document.location.href+"&success=yes";
        // document.location = url;
    });
    function registration(){
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var mobile = $("#mobile").val();
        var email = $("#email").val();
        var gender = document.querySelector('input[name="gender"]:checked').value;
        var dob = $("#dob").val();
        var mobile_regs = $('#mobile_no').val();
        $('#regMobileNumber').val(mobile);
        // console.log("mobile", mobile);
        // console.log("mobile_regs", mobile_regs);
        // return;
        //var anniversary = $("#anniversary").val();
        $('.wrong_firstName').hide();
        $('.wrong_lastName').hide(); 
        $('.wrong_mobileNumber').hide();
        $('.wrong_mobile').hide();
        $('.wrong_emailAddress').hide();
        $('.select_dob').hide();
        var validForm = true;
        var firstNameReg = /^[a-zA-Z ]+$/;
            if(firstNameReg.test(first_name) == false){
                //alert('Invalid First Name');
                $('.wrong_firstName').show();
                validForm = false;
                return true;
            }
        // var lastNameReg = /^[a-zA-Z ]+$/;
        //     if(lastNameReg.test(last_name) == false){
        //         $('.wrong_lastName').show();
        //         //alert('Invalid Last Name');
        //         return true;
        //     }
        var regxMobile = /^[6-9]\d{9}$/;
            if(regxMobile.test(mobile) == false){
                $('.wrong_mobileNumber').show();
                //alert('Invalid Mobile Number');
                validForm = false;
                return true;
            } 
            if(validForm == true){
                 $('.subReg').hide(); 
                 $('.subRegWait').show();
            }
            else{
                $('.subReg').show(); 
                $('.subRegWait').hide();
            }
            
        // var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        //     if (regEmail.test(email) == false){
        //         $('.wrong_emailAddress').show();
        //         //alert('Invalid Email Address');
        //         return true;
        //     }
        // if (dob ==""){
        //         $('.select_dob').show();
        //         return true;
        // }
        // console.log("dob", dob); 
        // return true;
            // $('.subReg').hide(); 
            // $('.subRegWait').show();
        $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/registration',
                data: {first_name : first_name, last_name : last_name, mobile : mobile, email : email, gender : gender, dob : dob, mobile_regs : mobile_regs},
                dataType: 'JSON',              
              }).done(function (data) {
                // $('.subReg').hide(); 
                // $('.subRegWait').show();
                        //console.log(data);
                        if(data == '1'){
                            $('#registration_otp').modal('show');
                            $("#first_name").val('');
                            $("#last_name").val('');
                            $("#mobile").val('');
                            $("#email").val('');
                            document.querySelector('input[name="gender"]:checked').value;
                            $("#dob").val('');
                            $.fancybox.close();
                            $.fancybox.close();
                            $.fancybox.close(); 
                            $('.subReg').hide(); 
                            $('.subRegWait').show();
                            
                            // setTimeout(function(){
                            //      //location.reload(true);
                            // },1400);
                           
                        }
                        else{
                            $('#mobileNumber_exists').show();
                            //alert('Mobile number already exist');
                        }
                    
                 });

        
        
        }
        function editDeliveryAddress(addressID){
            var address_id = addressID;
             $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/edit_delivery_address',
                data: {address_id : address_id},
                dataType: 'JSON',              
              }).done(function (data) {
                        console.log(data);
                        $('#addressDataDiv').html(data);
                        // if(data == '1'){                            
                        //     $.fancybox.close();
                        // }
                        // else{
                        //     //$('#mobileNumber_exists').show();
                        // }
                    
                 });
        }
        // function gotocheckout_page(){
        //     window.history.pushState(null, 'Checkout Summary - Neolayr', 'summary');
        //     $('#cart_page').hide();
        //     $('#checkout_page').show();
        //     window.addEventListener('popstate', (event) => {                
        //         if (document.getElementsByClassName("modal-open").length === 0 || !window.location.href.includes("summary")) {
        //         history.replaceState(null, 'Checkout Summary - Neolayr', 'shopping-cart');
        //         $('#cart_page').show();
        //         $('#checkout_page').hide();
               
        // }
        // else{
        //         history.replaceState(null, 'Checkout Summary - Neolayr', 'summary');
        // }
        // });
        // }

        function skin_quiz(){
            var quiz_name = $("#quiz_name").val();
            var quiz_age = $("#quiz_age").val();
            var quiz_number = $("#quiz_number").val();
            var quiz_email = $("#quiz_email").val();

            $('.wrong_Name').hide();
            $('.wrong_age').hide();
            $('.wrong_mobile').hide();
            $('.wrong_email').hide();

            // console.log("quiz_email",quiz_email);
            // return;
            var validForm = true;
            var nameReg = /^[^-\s][a-zA-Z\s-]+$/;
            if(quiz_name == ''){
                $('.wrong_Name').show();
                $('.wrong_Name').html("Please enter your Name");
                validForm = false;
                return true;
            }
            if(nameReg.test(quiz_name) == false){
                $('.wrong_Name').show();
                $('.wrong_Name').html("Please enter valid Name");
                validForm = false;
                return true;
            }
            if(quiz_age == ''){
                $('.wrong_age').show();
                $('.wrong_age').html("Please enter your Age");
                validForm = false;
                return true;
            }
            var regxAge = /^[0-9]+$/;
            if(regxAge.test(quiz_age) == false){
                $('.wrong_age').show();
                $('.wrong_age').html("Please enter valid Age");
                validForm = false;
                return true;
            }
            if(quiz_number == ''){
                $('.wrong_mobile').show();
                $('.wrong_mobile').html("Please enter your Mobile Number");
                validForm = false;
                return true;
            }
            var regxMobile = /^[6-9]\d{9}$/;
            if(regxMobile.test(quiz_number) == false){
                $('.wrong_mobile').show();
                $('.wrong_mobile').html("Please enter your valid Mobile Number");
                validForm = false;
                return true;
            }
            var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            if(quiz_email == ''){
                $('.wrong_email').show();
                $('.wrong_email').html("Please enter your email");
                validForm = false;
                return true;
            }
            if (regEmail.test(quiz_email) == false){
                $('.wrong_email').show();
                $('.wrong_email').html("Please enter valid email");
                validForm = false;
                return true;
            }
            if(validForm == true){
                 // $('.subReg').hide(); 
                 // $('.subRegWait').show();
            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/add_skin_quiz',
                data: {quiz_name : quiz_name, quiz_age : quiz_age, quiz_number : quiz_number, quiz_email : quiz_email},
                dataType: 'JSON',              
              }).done(function (data) {
                        //console.log(data);
                        if(data == '0'){
                            $('.step-one').show();
                            $('.step-two').hide();
                            
                        }
                        else{
                            $("#quiz_name").val('');
                            $("#quiz_age").val('');
                            $("#quiz_number").val('');
                            $("#quiz_email").val('');
                            $('.step-one').hide();
                            $('.step-two').show();
                            $('#last_insert_id').val(data);
                        }
                    
                 });
          }

        }
        function specified(specified){
            $('.specified').html(specified);
            $('#specified_type').val(specified);
            $('.specifiedConcern').hide();
            console.log("specified", specified);
        }
        function skin_type(skin_type){
            $('.skin-type').html(skin_type);
            $('#skin_type_h').val(skin_type);
            $('.SkinType').hide();
            $('.SkinType').addClass('force-hide');
            console.log("skin_type_h", skin_type);
        }
        function your_skin(skin){
            $('.skin').html(skin);
            $('#your_skin_type').val(skin);
            $('.IsSkin').hide();
            $('.IsSkin').addClass('force-hide');
            console.log("your_skin_type", skin);
        }
        function seletConcern(concern_name){
            var last_insert_id = $('#last_insert_id').val();
            console.log("concern_name",concern_name);
            $('#skin_concern_name').val(concern_name);
            $('.select_concern').hide();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/update_concern_name',
                data: {concern_name : concern_name, last_insert_id : last_insert_id},
                dataType: 'JSON',              
              }).done(function (data) {
                        if(data != ''){
                            console.log("skin_category_type", data);
                            $('#skin_category_type').val(data);
                            
                        }
                        else{
                            
                        }
                    
            });
        }
        function quiz_product(){
            var category_type = $('#skin_category_type').val();
            var specified_type = $('#specified_type').val();
            var skin_type_h = $('#skin_type_h').val();
            var your_skin_type = $('#your_skin_type').val();
            //console.log("category_type",category_type);
            //$('.concern').html(category_type);
            //$('.no_quiz_product').hide();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/fetch_quiz_product',
                data: {category_type : category_type,specified_type : specified_type,skin_type_h : skin_type_h,your_skin_type : your_skin_type},
              }).done(function (data) {
                        if(data != '0'){
                            $('.quiz-product').html(data);
                            document.getElementById('quizProduct').scrollIntoView();
                            //$(window).scrollTop($('#skin_quiz'));
                           // $('.category_type').val(data);
                            
                        }
                        else{
                            $('.no_quiz_product').show();
                            $('.no_quiz_product').html('No Product Found!!!');
                        }
                    
            });
        }
        function quiz_product_add(){
            //var logged_user = '<?php echo $_SESSION['logged_user'] ?>';

            // console.log(logged_user);
            // return;
            //if(logged_user != 1){
               // $("#login").fancybox().trigger('click');
              //    $.fancybox({
              //    'autoScale': true,
              //    'transitionIn': 'elastic',
              //    'transitionOut': 'elastic',
              //    'speedIn': 500,
              //    'speedOut': 300,
              //    'autoDimensions': true,
              //    'centerOnScroll': true,
              //    'href' : '#login'
              // });
            //} else {
            var productID = $('.implodeProductID').val();
            var category_type = $('#skin_category_type').val();
            //var quizProductPrice = $('.implodeProductPrice').val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/skin_quiz_product_add',
                data: {productID : productID, category_type : category_type},
                dataType: 'JSON',
              }).done(function (data) {
                //console.log("data", data);
                          if(data){
                            var i; 
                            for (i = 0; i < data.length; i++) {
                                //console.log(data[i]);
                                manageShoppingCart('add', data[i], false);
                                
                            }
                            $('.quiz_product_cartAdd').hide();
                            $('.quiz_product_gotocart').show();
                            //alert("Item added to your cart");
                         }
                    
            });
          //}
        }
        
        function add_address(){
        var add_name = $("#add_name").val();
        var add_last_name = $("#add_last_name").val();
        var add_mob = $("#add_mob").val();
        var add_pincode = $("#add_pincode").val();
        var add_state = $("#stateInput").val();
        var add_city = $("#thana").val();
        var add_build_name = $("#add_build_name").val();
        var add_road_name = $("#add_road_name").val();
        var landmark = $("#landmark").val();
        var isReferral = $("#isReferral").val();
        var couponAmount = $('[name="discountAmount"]').val();
        var reward_amount = $('#paid_amount').val();
        var productVariant = $('#productVariant').val();
        $('.select_state').hide();
        $('.select_city').hide();
        $('.wrong_firstName').hide();
        $('.wrong_lastName').hide();
        $('.wrong_mobileNumber').hide();
        $('.wrong_emailAddress').hide();
        $('.select_pincode').hide();
        $('.select_build_name').hide();
        $('.select_road_name').hide();
        $('.add_n_add').show();
        $('.edit_n_add').hide();
        $('.ad_add').show();
        $('.ed_add').hide();
        var firstNameReg = /^[a-zA-Z ]+$/;
            if(firstNameReg.test(add_name) == false){
                //alert('Invalid First Name');
                $('.wrong_firstName').show();
                 
                //$(".fancybox").trigger('click');
                return true;
            }
        // var lastNameReg = /^[a-zA-Z ]+$/;
        //     if(lastNameReg.test(add_last_name) == false){
        //         $('.wrong_lastName').show();
        //         //alert('Invalid Last Name');
        //         return true;
        //     }
        var regxMobile = /^[6-9]\d{9}$/;
            if(regxMobile.test(add_mob) == false){
                $('.wrong_mobileNumber').show();
                
                //alert('Invalid Mobile Number');
                return true;
            } 
        // var regxPincode = /^[0-9]\d{6}$/;
        //     if(regxMobile.test(add_pincode) == false){
        //         $('.wrong_mobileNumber').show();
        //         //alert('Invalid Mobile Number');
        //         return true;
        //     }
        // var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        //     if (regEmail.test(email) == false){
        //         $('.wrong_emailAddress').show();
        //         //alert('Invalid Email Address');
        //         return true;
        //     }
        if (add_pincode == ""){
                $('.select_pincode').show();
                //alert('please enter Date of Birth');
                return true;
        }
        if (add_state == ""){
                $('.select_state').show();
                
                //alert('please enter Date of Birth');
                return true;
        }
        if (add_city == ""){
                $('.select_city').show();
                
                //alert('please enter Date of Birth');
                return true;
        }
         if (add_build_name == ""){
                $('.select_build_name').show();
                
                //alert('please enter Date of Birth');
                return true;
        }
         if (add_road_name == ""){
                $('.select_road_name').show();
                
                //alert('please enter Date of Birth');
                return true;
        }
        //$.fancybox.close();
        // console.log("dob", dob); 
         //return true;
        $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/add_new_address',
                data: {add_name : add_name, add_last_name : add_last_name, add_mob : add_mob, add_pincode : add_pincode, add_state : add_state, add_city : add_city, add_build_name : add_build_name, add_road_name : add_road_name, landmark : landmark, productVariant : productVariant},
                dataType : 'JSON',  
              }).done(function (data) {
                        // console.log(data);
                        // return;
                        if(data){
                            $("#add_name").val('');
                            $("#add_last_name").val('');
                            $("#add_mob").val('');
                            $("#add_pincode").val('');
                            $("#stateInput").val('');
                            $("#thana").val('');
                            $("#add_build_name").val('');
                            $("#add_road_name").val('');
                            $("#landmark").val('');
                            $('#fstAddress').hide();
                            $('#secAddress').show();
                            $('#secAddress').html(data.addreess_data);
                            $('#delivery_amount').html(data.delivery_amount);
                            $('#delivery_amount_two').html(data.delivery_amount);
                            $('#shpping_cost').val(data.delivery_amount);
                            $("#selectedStateID").val(data.selectedState);
                            $("#selected_address_id").val(data.selected_address_id);
                            $('#daliveryDate').html(data.delivery_address);
                            $('.save_delivery_add').show();
                            $(".save_delivery_add").html(data.addreess_div);
                        
                            $('.select_dd_add').hide();
                       
                        var total_amount = (data.total_amount - isReferral - couponAmount - reward_amount + parseFloat(data.delivery_amount)).toFixed(2);
                        //console.log("total_amount", total_amount);
                        $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                        $('.total_price').html('<?= CURRENCY ?>'+total_amount);
                        $('#final-amount').val(total_amount);
                        $('[name="final_amount_two"]').val(total_amount);
                        $('#selectedAmount').html('<?= CURRENCY ?>'+total_amount);
                        
                        $('#add-address').modal('hide');
                        $.fancybox.close();
                        $.fancybox.close();

                        
                        
                            //location.reload(true);
                        }
                        else{
                            //$('#mobileNumber_exists').show();
                            //alert('Mobile number already exist');
                        }
                    
                 });

        
        
        }
        $(".check-reward").click(function(e){         
            var mobile_no = '<?php echo $_SESSION['logged_mobile'] ?>';
            var redeem_paid_point = $("#redeem_paid_point").val();
            // console.log("redeem_paid_point", redeem_paid_point);
            // return;
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/verify_reward',
                data: {mobile_no : mobile_no, redeem_paid_point : redeem_paid_point},
                dataType: 'JSON',              
              }).done(function (data) {
                        $('#request_id_otp').val(data);
                        //console.log(data);
                        
                    
                 });

        })

        $(".check_address_avail").click(function(e){         
            var test = "Test";
        //     console.log("ok");
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/check_address_avail',
                data: {test : test},
                dataType: 'JSON',              
              }).done(function (data) {
                //console.log(data);
                        //console.log(data.name);
                        $("#add_name").val(data.name);
                        $("#add_mob").val(data.mobile);
                        
                    
                 });

        })

        
        function reward_otp_submit(){
            var reward_otp = $("#reward_otp").val();
            var request_id = $('#request_id_otp').val();
            var mobile_no = '<?php echo $_SESSION['logged_mobile'] ?>';
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/verify_reward_otp',
                data: {reward_otp : reward_otp, mobile_no : mobile_no, request_id : request_id}
              }).done(function (data) {
                        //console.log("data", data);
                        if(data != 0){
                        var obj = jQuery.parseJSON(data);
                            var final_amount_before = Number($('#final-amount').val());
                            //var sub_total_before = Number($('#subTotal').val());
                            var discountAmoun;
                            if (obj.type == 'percent') {
                                var substract_num = (obj.amount / 100) * final_amount_before;
                                if(substract_num>final_amount_before){
                                    substract_num = final_amount_before;
                                 }
                                var final_amount = final_amount_before - substract_num;
                                discountAmoun = substract_num;
                            }
                            if (obj.type == 'float') {
                                if(obj.amount>final_amount_before){
                                    obj.amount = final_amount_before;
                                 }
                                var final_amount = final_amount_before - obj.amount;
                                discountAmoun = obj.amount;
                            }
                            $('.open-otp').hide();
                            $('.rb').hide();
                            $('.pbp').show();
                            $("input.check-reward").prop("disabled", true);
                            discountAmoun = parseFloat(discountAmoun).toFixed(2);
                            $('.final-amount').text('<?= CURRENCY ?>'+final_amount.toFixed(2));
                            $('#final-amount-two').val(final_amount.toFixed(2));
                            $('#final-amount').val(final_amount.toFixed(2));
                            //$('[name="discountAmount"]').val(discountAmoun);
                            $('#discount_row').show();
                            $('.paid_amount').html(" -"+discountAmoun);
                            $('#paid_amount').val(discountAmoun);
                            $('#paid_by_point').val(obj.point);
                            $('#request_id').val(obj.request_id);
                        }
                        else{
                            alert("Wrong Otp");
                        }
                    
                 });
        }
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
        function add_doctor_consultation(){
            var name = $("#d_name").val();
            var mobile = $("#d_mobile").val();
            var pincode = $("#add_pincode_dermatologist").val();
            var add_state = $("#stateInputDoctor").val();
            var add_city = $("#thanaDoctor").val();
            $('.wrong_firstName').hide();
            $('.wrong_mobileNumber').hide();
            $('.select_pincode').hide();
            $('.select_state').hide();
            $('.select_city').hide();
            $('.we_contact').hide();
            // $('.add_consultation').hide();
            // $('.add_consultation_wait').show();
            var validForm = true;
            var firstNameReg = /^[a-zA-Z ]+$/;
            if(firstNameReg.test(name) == false){
                $('.wrong_firstName').show();
                validForm = false;
                return true;
            }
            var regxMobile = /^[6-9]\d{9}$/;
            if(regxMobile.test(mobile) == false){ 
                $('.wrong_mobileNumber').show();
                validForm = false;
                return true;
            }
            if (pincode == ""){
                    $('.select_pincode').show();
                    validForm = false;
                    return true;
            }
            if (add_state == "" || add_state == null){
                $('.select_state').show();
                validForm = false;
                return true;
            }
            if (add_city == ""){
                    $('.select_city').show();
                    validForm = false;
                    return true;
            }
            if(validForm == true){
                 $('.add_consultation').hide(); 
                 $('.add_consultation_wait').show();
            }
            else{
                $('.add_consultation').show(); 
                $('.add_consultation_wait').hide();
            }

            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/add_doctor_consultation',
                data: {name : name, mobile : mobile,add_state : add_state,add_city : add_city },
                dataType: 'JSON',              
              }).done(function (data) {
                        if(data == 1){
                            $("#d_name").val('');
                            $("#d_mobile").val('');
                            $("#stateInputDoctor").val('');
                            $("#thanaDoctor").val('');
                            $("#add_pincode_dermatologist").val('');
                            $('.add_consultation').show();
                            $('.add_consultation_wait').hide();
                            $('#doctor-popup').modal('hide');
                            $('.consultation-message').addClass("active");
                            setTimeout(consultationMessageRemove, 1700);
                            //$('.we_contact').show();
                            //location.reload(true);
                            //$.fancybox.close();
                        }
                    
                 });
        }
        function consultationMessageRemove() {
            $('.consultation-message').removeClass("active");
        }
         $(document).ready(function () {

                    // $(".search__input").keyup(function () {
                    //     var str = $(this).val();
                    //     console.log("str",str);
                    //     window.location.href='<?= LANG_URL . '/products?search_in_title=' ?>'+str;
                    //     // $.get("http://localhost/sitename/controllername/phoneError?p=" + str, function (data) {
                    //     //     $("#txtResult").html(data);
                    //     // });
                    // });

                   //   $("#storeLocators").on("click" ,function(){
                   //   scrolled=scrolled-300;
                   //      $("#storeDataDivFst").animate({
                   //        scrollTop:  scrolled
                   //   });
                   // });
                });

         function getProductSearch(){
            var str = $("#search__input").val();
            if(str != ''){
            window.location.href='<?= LANG_URL . '/category?search_in_title=' ?>'+str;
            //$("#search__input").val('');
        }
         }

            $(".more_store").click(function(e){
                var target = $(this).attr('data-target');
                $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/find_store',
                data: {target: target},        
              }).done(function (data) {
                            
                            $('#fstStoreMaps').hide();
                            $('#secStoreMaps').show();
                            $('#secStoreMaps').html(data);
                        
                    
                 });
            });
            function searchStore(){
                var pincode = $('#pincode').val();

                $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/search_store') ?>',
                                data: {pincode: pincode},
                                dataType: 'JSON'
                 }).done(function (data) {
                    if(data != 0){
                    $('#storeDataDivFst').hide();
                    $('#storeDataDiv').show();
                    $('#noStoreFound').hide();
                    $('#storeDataDiv').html(data);
                    }
                    else{
                         $('#storeDataDivFst').hide();
                         $('#storeDataDiv').hide();
                         $('#noStoreFound').show();
                         $('#noStoreFound').html('No Store found!');
                    }
                 });
            }
            function more_store(value){
                var target = value;
                $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/find_store',
                data: {target: target},        
              }).done(function (data) {
                            $('.each-location').removeClass(' active');
                            $('.check'+value).addClass(' active');
                            $('#fstStoreMaps').hide();
                            $('#secStoreMaps').show();
                            $('#map_two').html(data);
                        
                    
                 });

            }
            function clickCopy(){
                copyToClipboard(document.getElementById("goodContent"));
            }
            // document.getElementById("clickCopy").onclick = function() {
            //     copyToClipboard(document.getElementById("goodContent"));
            // }
            function copyToClipboard(e) {
            var tempItem = document.createElement('input');

            tempItem.setAttribute('type','text');
            tempItem.setAttribute('display','none');
            
            let content = e;
            if (e instanceof HTMLElement) {
                    content = e.innerHTML;
            }
            
            tempItem.setAttribute('value',content);
            document.body.appendChild(tempItem);
            
            tempItem.select();
            document.execCommand('Copy');

            tempItem.parentElement.removeChild(tempItem);
            $('.text-copy').show();
        }
        function openWhatsApp(value) {  
    window.open(value);  
    }

     function confirm_return(order_id){
            
            if (confirm("Return Order?")){
                window.location.href='<?= base_url('users/returnOrder')?>/'+order_id+'/return';
            }
                 
          }

    function orderTracking(trackOrderId,trackSku){
         
       $.ajax({
            type: "POST",
            url: '<?= base_url('home/order_tracking') ?>',
            data: {trackOrderId: trackOrderId, trackSku: trackSku}
        }).done(function (data) {
            $('#tracking').html(data);
        });
    }
    function updateName(){
        $('#gift_name_view').html($('#gift_name').val())
    }
    function updatePrice(){
        $('#gift_price_view').html($('#gift_price').val())
    }

    function checkDeliverPin(){
        var delivery_pincode = $('#delivery_pincode').val();
        $.ajax({
            type: "POST",
            url: '<?= base_url('home/checkDeliverPin') ?>',
            data: {delivery_pincode: delivery_pincode},
            //dataType: 'JSON',
        }).done(function (data) {
            $('.deliveryAvailable').show();
            $('.deliveryAvailable').html(data);
        });
    }

    function close_free_product_modal(){
        $('.free_product_show').remove();
        $('#discountType').val(0);
            var freeProductRemoved = $('#free_product_removed').val();
            if(freeProductRemoved != ''){
                $.ajax({
                                type: "POST",
                                url: "<?php echo site_url('home/free_product_remove_cart'); ?>",
                                data: { free_product_id : freeProductRemoved },
                                success: function(data)
                                {
                                    if(data != ''){
                                        location.reload(true);
                                    }
                                }
                             });
            }
    }
    function genarate_invoice(){
        var shippingPackageCode = "PALS00094";
        $.ajax({
                                type: "POST",
                                url: "<?php echo site_url('home/genarate_invoice'); ?>",
                                data: { shippingPackageCode : shippingPackageCode },
                                success: function(data)
                                {
                                    //window.print(data)
                                    console.log(data);
                                    // if(data != ''){
                                    //     location.reload(true);
                                    // }
                                }
                             });
    }
    function closeAddModal(){
        $('.add_n_add').show();
        $('.edit_n_add').hide();
        $('.ad_add').show();
        $('.ed_add').hide();
        $("#add_name").val('');
        $("#add_last_name").val('');
        $("#add_mob").val('');
        $("#add_pincode").val('');
        $("#stateInput").val('');
        $("#thana").val('');
        $("#add_build_name").val('');
        $("#add_road_name").val('');
        $("#landmark").val('');
    }
    function edit_address(id)
    {
        $('.add_n_add').hide();
        $('.edit_n_add').show();
        $('.ad_add').hide();
        $('.ed_add').show();
        $('.select_state').hide();
        $('.select_city').hide();
        $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/address_edits',
                data: {id : id},
                dataType: 'JSON',              
              }).done(function (data) {
                    console.log(data);
                    $("#add_name").val(data.first_name);
                    $("#add_mob").val(data.phone);
                    $("#add_pincode").val(data.post_code);
                    $("#stateInput").val(data.state_name);
                    $("#thana").val(data.city_name);
                    $("#add_build_name").val(data.address);
                    $("#add_road_name").val(data.road_name);
                    $("#landmark").val(data.landmark);
                    $("#address_id").val(data.address_id);  
                    
                    $("#add-address").modal('show');
                 });
    }
    function update_address(){
        var add_name = $("#add_name").val();
        var add_last_name = $("#add_last_name").val();
        var add_mob = $("#add_mob").val();
        var add_pincode = $("#add_pincode").val();
        var add_state = $("#stateInput").val();
        var add_city = $("#thana").val();
        var add_build_name = $("#add_build_name").val();
        var add_road_name = $("#add_road_name").val();
        var landmark = $("#landmark").val();
        var address_id = $("#address_id").val();
        var isReferral = $("#isReferral").val();
        var couponAmount = $('[name="discountAmount"]').val();
        var reward_amount = $('#paid_amount').val();
        var productVariant = $('#productVariant').val();
        $('.wrong_firstName').hide();
        $('.wrong_lastName').hide();
        $('.wrong_mobileNumber').hide();
        $('.wrong_emailAddress').hide();
        $('.select_pincode').hide();
        $('.select_build_name').hide();
        $('.select_road_name').hide();
        var firstNameReg = /^[a-zA-Z ]+$/;
            if(firstNameReg.test(add_name) == false){
                //alert('Invalid First Name');
                $('.wrong_firstName').show();
                //$(".fancybox").trigger('click');
                return true;
            }
        // var lastNameReg = /^[a-zA-Z ]+$/;
        //     if(lastNameReg.test(add_last_name) == false){
        //         $('.wrong_lastName').show();
        //         //alert('Invalid Last Name');
        //         return true;
        //     }
        var regxMobile = /^[6-9]\d{9}$/;
            if(regxMobile.test(add_mob) == false){
                $('.wrong_mobileNumber').show();
                //alert('Invalid Mobile Number');
                return true;
            } 
        // var regxPincode = /^[0-9]\d{6}$/;
        //     if(regxMobile.test(add_pincode) == false){
        //         $('.wrong_mobileNumber').show();
        //         //alert('Invalid Mobile Number');
        //         return true;
        //     }
        // var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        //     if (regEmail.test(email) == false){
        //         $('.wrong_emailAddress').show();
        //         //alert('Invalid Email Address');
        //         return true;
        //     }
        if (add_pincode == ""){
                $('.select_pincode').show();
                //alert('please enter Date of Birth');
                return true;
        }
        if (add_state == ""){
                $('.select_state').show();
                //alert('please enter Date of Birth');
                return true;
        }
        if (add_city == ""){
                $('.select_city').show();
                //alert('please enter Date of Birth');
                return true;
        }
         if (add_build_name == ""){
                $('.select_build_name').show();
                //alert('please enter Date of Birth');
                return true;
        }
         if (add_road_name == ""){
                $('.select_road_name').show();
                //alert('please enter Date of Birth');
                return true;
        }
        //$.fancybox.close();
        // console.log("dob", dob); 
         //return true;
        $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/update_address',
                data: {add_name : add_name, add_last_name : add_last_name, add_mob : add_mob, add_pincode : add_pincode, add_state : add_state, add_city : add_city, add_build_name : add_build_name, add_road_name : add_road_name, landmark : landmark, address_id : address_id, productVariant : productVariant},
                dataType : 'JSON',  
              }).done(function (data) {
                        // console.log(data);
                        // return;
                        if(data){
                            $("#add_name").val('');
                            $("#add_last_name").val('');
                            $("#add_mob").val('');
                            $("#add_pincode").val('');
                            $("#stateInput").val('');
                            $("#thana").val('');
                            $("#add_build_name").val('');
                            $("#add_road_name").val('');
                            $("#landmark").val('');
                            $('#fstAddress').hide();
                            $('#secAddress').show();
                            $('.add_n_add').show();
                            $('.edit_n_add').hide();
                            $('.ad_add').show();
                            $('.ed_add').hide();
                            $('#secAddress').html(data.addreess_data);
                            //$('#add-address').modal('hide');
                            $('#delivery_amount').html(data.delivery_amount);
                            $('#delivery_amount_two').html(data.delivery_amount);
                            $('#shpping_cost').val(data.delivery_amount);



                       
                        var total_amount = (data.total_amount - isReferral - couponAmount - reward_amount + parseFloat(data.delivery_amount)).toFixed(2);
                        //console.log("total_amount", total_amount);
                        $('#total_price').html('<?= CURRENCY ?>'+total_amount);
                        $('.total_price').html('<?= CURRENCY ?>'+total_amount);
                        $('#final-amount').val(total_amount);
                        $('[name="final_amount_two"]').val(total_amount);
                        $('#selectedAmount').html('<?= CURRENCY ?>'+total_amount);
                        $('#add-address').modal('hide');
                        // $.fancybox.close();
                        // $.fancybox.close();

                        
                        
                            //location.reload(true);
                        }
                        else{
                            //$('#mobileNumber_exists').show();
                            //alert('Mobile number already exist');
                        }
                    
                 });

        
        
        }
    $(document).ready(function () {
            $("#add_pincode").keyup(function () {
                $('#select_pincode').hide();
                var pins = $(this).val();
                if(pins.length == 6){
                    $('.select_state').hide();
                    $('.select_city').hide();
                $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/verify_pincode',
                data: {pins : pins},
                dataType: 'JSON',              
              }).done(function (data) {
                        $('#stateInput').val(data.state);
                        $('#thana').val(data.city);
                 });
            }
        });
    
    });

    $(".processModal").click(function(e){
            var stateId = $('#selectedStateID').val();
            var amount = $('#final-amount-two').val();
            //console.log("amount", amount); return;
            if(stateId == '' || stateId == null){
                //alert("Please Add address");
                $('.select-address-message').addClass("active");
                setTimeout(selectAddressMessageRemoveClass, 2000);
                return true;
            }
            else{
                $("#exampleModalLong").modal('show');
            }
    });
    $(document).ready(function () {
            $("#add_pincode_dermatologist").keyup(function () {
                $('#select_pincode').hide();
                var pins = $(this).val();
                if(pins.length == 6){
                    $('.select_state').hide();
                    $('.select_city').hide();
                $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>home/verify_pincode',
                data: {pins : pins},
                dataType: 'JSON',              
              }).done(function (data) {
                        $('#stateInputDoctor').val(data.state);
                        $('#thanaDoctor').val(data.city);
                 });
            }
        });
    
    });
     function quiz_product_add_single(product_id,product_key){
           
            $.ajax({
                                type: "POST",
                                url: '<?= base_url('home/addToCartProduct') ?>',
                                data: {product_id: product_id},
                                dataType: 'JSON',
                 }).done(function (data) {
                     if(data){
                         //console.log(data)
                         manageShoppingCart('add', data, false);
                         $('.quiz_cart'+product_key).hide();
                         $('.quiz_go_to_cart'+product_key).show();
                         //alert("Item added to your cart");
                     }
                     
                    
                 });
          };
          function take_another_test(){
            $('.step-one').show();
            $('.all-qz').show();
            $('.fifte-step').hide();
            $('.each-screen').removeClass('active');
            $('.with-out-select-three, .with-out-select-two, .with-out-select-one').show();
            $('.go-third-step, .go-forth-step, .go-fifth-step').hide();
            $('.last-step').removeClass('is-sk');
        }

        var input = document.getElementById("search__input");
        input.addEventListener("keypress", function(event) {
          if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search_submit").click();
          }
        });
</script>
</body>
</html>
