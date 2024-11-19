</main><!-- End .main -->

        <footer class="footer">
            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="widget">
                                <h4 class="widget-title">About Us</h4>
								<p><?= $footerAboutUs ?></p>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-2 -->

                        <div class="col-lg-3 col-md-6">
                            <div class="widget">
                                <h4 class="widget-title">Pages</h4>
                                
                             <ul class="links">
                                <li><a href="<?= LANG_URL . '/page/aboutus' ?>">» About Us</a></li>
                                <li><a href="<?= LANG_URL . '/page/terms_condition' ?>">» Terms & Condition</a></li>
                                <li><a href="<?= LANG_URL . '/page/return_policy' ?>">» Shipping and Return Policy</a></li>
                                <li><a href="<?= LANG_URL . '/page/privacy_policy' ?>">» Privacy Policy</a></li>
                                <li><a href="<?= LANG_URL . '/page/faq' ?>">» FAQ</a></li>
                            </ul>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-5 col-md-6">
                            <div class="widget widget-newsletter">
                                <h4 class="widget-title">Subscribe newsletter</h4>
                                <p>Get all the latest information on Events,Sales and Offers. Sign up for newsletter today</p>
                                <form  method="post">
                                    <input type="email" name="subscribe_email" id="subscribe_email" class="form-control" placeholder="Email address" required>

                                    <button type="button" id="mc-submit" class="btn">Subscribe<i class="icon-angle-right"></i></button>
                                </form>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-5 -->

                        <div class="col-lg-4 col-md-6">
                            <div class="widget">
                                <ul class="contact-info">
                                	<?php if ($footerContactAddr != '') { ?>
                                    <li><span class="contact-info-label">Address:</span><?= $footerContactAddr ?></li>
                                     <?php }if ($footerContactPhone != '') { ?>
                                    <li><span class="contact-info-label">Phone:</span>Call Us: <?= $footerContactPhone ?></li>
                                     <?php } if ($footerContactEmail != '') { ?>
                                    <li><span class="contact-info-label">Email:</span> <a href="<?= $footerContactEmail ?>"><?= $footerContactEmail ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-4 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="container">
                <div class="footer-bottom">
                    <p class="footer-copyright"><?= $footerCopyright ?></p>
                    <img src="<?= base_url('template/imgs/payments.png') ?>" alt="payment methods" class="footer-payments">
                     <div class="social-icons">
                                    <?php if ($footerSocialFacebook != '') { ?><a href="<?= $footerSocialFacebook ?>" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                                    <?php } if ($footerSocialInstagram != '') { ?><a href="<?= $footerSocialInstagram ?>" class="social-icon" target="_blank"><i class="fa fa-instagram"></i></a>				    
                                    <?php } if ($footerSocialTwitter != '') { ?><a href="<?= $footerSocialTwitter ?>" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                                    <?php } if ($footerSocialGooglePlus != '') { ?><a href="<?= $footerSocialGooglePlus ?>" class="social-icon" target="_blank"><i class="fa fa-google-plus"></i></a>
                                    <?php } if ($footerSocialPinterest != '') { ?><a href="<?= $footerSocialPinterest ?>" class="social-icon" target="_blank"><i class="fa fa-pinterest"></i></a>
                                    <?php } if ($footerSocialYoutube != '') { ?><a href="<?= $footerSocialYoutube ?>" class="social-icon" target="_blank"><i class="fa fa-youtube"></i></a>
                                    <?php } ?>
                    </div>
                </div><!-- End .footer-bottom -->
            </div><!-- End .containr -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="<?= uri_string() == '' || uri_string() == MY_LANGUAGE_ABBR ? 'active' : '' ?>"><a href="<?= base_url() ?>">Home</a></li>
                    <?= loop_menu_tree($this->all_categories);?>
                    <?php if(sizeof($this->all_vendor)>0){?>
                     <li class="">
                            <a href="javascript:void(0)" class="sf-with-ul">Suppliers</a>
                            <ul>
                                <?php foreach($this->all_vendor as $vendor){?>
                                <li><a href="<?= LANG_URL . '/products' ?>?suppliers=<?= $vendor['warehouse_name'];?>"><?= $vendor['warehouse_name'];?></a> </li>  
                                <?php } ?>
                             </ul>
                     </li>
                    <?php } ?>
                    <?php if(sizeof($this->all_state)>0){?>
                     <li class="">
                            <a href="javascript:void(0)" class="sf-with-ul">Location</a>
                            <ul>
                                <?php foreach($this->all_state as $state){?>
                                <li><a href="<?= LANG_URL . '/products' ?>?state=<?= $state['state_name'];?>"><?= $state['state_name'];?></a> </li>  
                                <?php } ?>
                             </ul>
                     </li>
                    <?php } ?>
		    <?php if(!isset($_SESSION['logged_user'])){?>
		    <li class="<?= uri_string() == 'login' || uri_string() == MY_LANGUAGE_ABBR . '/users/login' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/users/login' ?>">Log In</a></li>
		    <?php } else{?>
		    <li class="<?= uri_string() == 'logout' || uri_string() == MY_LANGUAGE_ABBR . '/users/logout' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/users/logout' ?>">Logout</a></li>
		    <li class="<?= uri_string() == 'dashboard' || uri_string() == MY_LANGUAGE_ABBR . '/users/dashboard' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/users/dashboard' ?>">My Orders</a></li>
		    <?php } ?>
		    </li>
                     <li class="<?= uri_string() == 'contacts' || uri_string() == MY_LANGUAGE_ABBR . '/contacts' ? 'active' : '' ?>"><a href="<?= LANG_URL . '/contacts' ?>">Contact Us</a></li>
                </ul>
            </nav><!-- End .mobile-nav -->

             <div class="social-icons">
                                    <?php if ($footerSocialFacebook != '') { ?><a href="<?= $footerSocialFacebook ?>" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                                    <?php } if ($footerSocialInstagram != '') { ?><a href="<?= $footerSocialInstagram ?>" class="social-icon" target="_blank"><i class="fa fa-instagram"></i></a>				    
                                    <?php } if ($footerSocialTwitter != '') { ?><a href="<?= $footerSocialTwitter ?>" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                                    <?php } if ($footerSocialGooglePlus != '') { ?><a href="<?= $footerSocialGooglePlus ?>" class="social-icon" target="_blank"><i class="fa fa-google-plus"></i></a>
                                    <?php } if ($footerSocialPinterest != '') { ?><a href="<?= $footerSocialPinterest ?>" class="social-icon" target="_blank"><i class="fa fa-pinterest"></i></a>
                                    <?php } if ($footerSocialYoutube != '') { ?><a href="<?= $footerSocialYoutube ?>" class="social-icon" target="_blank"><i class="fa fa-youtube"></i></a>
                                    <?php } ?>
                    </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
    <div class="modal fade" id="cartModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content" id="product_quickview"> </div>
      </div>
    </div>
    <div id="razorpay_process_payment">
    	<h2>Processing your payment. Please do not press back button/refresh your page....</h2>
    </div>
     <input id="ratings-hidden" name="rating" type="hidden">
    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
    <script src="<?= base_url('templatejs/jquery.min.js') ?>"></script>
    <script src="<?= base_url('templatejs/bootstrap.bundle.min.js')?>"></script>
    <script src="<?= base_url('templatejs/plugins.min.js')?>"></script>
    <script src="<?= base_url('templatejs/main.min.js')?>"></script>
    <script src="<?= base_url('templatejs/sweetalert2.min.js') ?>"></script>
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
	function addToCart(){
		var variant = $('#quickview_variant_id').val();
		 manageShoppingCart('add', variant, false);
		 Swal.fire({
									  icon: 'success',
									  text: 'Item added to your cart'
				 })
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
		$("#cartModal").modal('hide');
		 
		Swal.fire({
									  icon: 'success',
									  text: 'Item added to your cart'
				 })
	}
	function buy_now(){
		var variant = $('#variant').val();
		manageShoppingCart('add', variant, 'checkout');
		
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
                                                '<button type="button" onclick="setDeliveryAddress('+address[i].address_id+',\''+address[i].sortname+'\')" class="btn btn-primary">Deliver Here</button><a style="margin-left:10px" href="javascript:void(0)" onclick="deleteAddress('+address[i].address_id+')">Delete</a>'+
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
	function setDeliveryAddress(address_id,sortname){
		$('#selected_address_id').val(address_id);
		$('#address_field').hide();
		$('#add_new_addreess').hide();
		$('#shipping_edit').show();
		$('#place_order').show();
		$('#freecharge_payment_option').prop('checked',false);
		
		if(sortname != "IN"){
			$.ajax({
					type: "POST",
					url: '<?= base_url('home/apply_shipping_charge') ?>',
					dataType: 'JSON',
					data: {sortname: sortname,weight:$('#weight').val()}
				 }).done(function (data) {
					 if(data.price){
						 	$('#delivery_amount').html(data.price);
							$('#shpping_cost').val(data.price);
							var total_amount = (parseFloat($('#grand_total').val())+parseFloat(data.price)).toFixed(2);
							$('#total_price').html('<?= CURRENCY ?>'+total_amount);
							$('#final-amount').val(total_amount);
					 }else{
							$('#delivery_amount').html("0");
							$('#shpping_cost').val(0);
							var total_amount = parseFloat($('#grand_total').val()).toFixed(2);
							$('#total_price').html('<?= CURRENCY ?>'+total_amount);
							$('#final-amount').val(total_amount);
					}
					
					
					$('#freecharge_payment').hide();
					$('.payment_method').show();
				});
		}else{
			if($('#weightdomestic').val()!="0"){
				$.ajax({
					type: "POST",
					url: '<?= base_url('home/apply_shipping_charge') ?>',
					dataType: 'JSON',
					data: {sortname: sortname,weight:$('#weightdomestic').val()}
				 }).done(function (data) {
					 if(data.price){
						 	$('#delivery_amount').html(data.price);
							$('#shpping_cost').val(data.price);
							var total_amount = (parseFloat($('#grand_total').val())+parseFloat(data.price)).toFixed(2);
							$('#total_price').html('<?= CURRENCY ?>'+total_amount);
							$('#final-amount').val(total_amount);
					}else{
							$('#delivery_amount').html("0");
							$('#shpping_cost').val(0);
							var total_amount = parseFloat($('#grand_total').val()).toFixed(2);
							$('#total_price').html('<?= CURRENCY ?>'+total_amount);
							$('#final-amount').val(total_amount);
					}
					
					$('#razorpay_payment_option').prop('checked',true);
					$('#freecharge_payment').show();
					$('.payment_method').show();
				});
			}else{
				$('#delivery_amount').html("0");
				$('#shpping_cost').val(0);
				var total_amount = parseFloat($('#grand_total').val());
				$('#total_price').html('<?= CURRENCY ?>'+total_amount);
				$('#final-amount').val(total_amount);
					
				$('#razorpay_payment_option').prop('checked',true);
				$('#freecharge_payment').show();
				$('.payment_method').show();
			}
			
		}
	}
		function applycoupon(){
			//Reset Previous discount if applied
			if($('#discountAmount').val()!=0){
				$('#final-amount').val($('#final-amount').val()+$('#discountAmount').val());
			}
			
			
			 var enteredCode = $('[name="discountCode"]').val();
			 var vendors  = $('#vendors').val();
				$.ajax({
					type: "POST",
					url: variable.discountCodeChecker,
					data: {enteredCode: enteredCode, vendors : vendors}
				}).done(function (data) {
					if (data == 0) {
							Swal.fire({
							  icon: 'error',
							  text: lang.discountCodeInvalid
							})
					} else {
						if (is_discounted == false) {
							var obj = jQuery.parseJSON(data);
							var final_amount_before = Number($('#final-amount').val());
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
				$('#razorpay_process_payment').css("display",'none');
				$.ajax({
								type: "POST",
								url: "<?php echo site_url('checkout/create_order'); ?>",
								data: $('#goOrder').serialize(),
								dataType: 'JSON',
								success: function(data)
								{
									var options = data;
									options.handler = function (response){
										document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
										document.getElementById('razorpay_signature').value = response.razorpay_signature;
										$('#razorpay_process_payment').css("display",'flex');
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
						
						if($('#comment'+target).val()==''){
							Swal.fire({
									  icon: 'error',
									  text: 'Please enter your review'
							});
						}else{
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
												  text: 'Thank you for giving your review.'
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
				   }
				
			   });
			  
			  
		});
	</script> 
<script src="<?= base_url('assets/js/system.js') ?>"></script>
</body></html>
