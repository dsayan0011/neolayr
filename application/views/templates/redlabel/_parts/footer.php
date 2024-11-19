<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 f-col">
                    <h3><?= lang('about_us') ?></h3>
                    <p><?= $footerAboutUs ?></p>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 f-col">
                    <h3><?= lang('pages') ?></h3>
                      <ul>
                                <li><a href="<?= LANG_URL . '/page/terms_condition' ?>">» Terms & Condition</a></li>
                                <li><a href="<?= LANG_URL . '/page/return_policy' ?>">» Return Policy</a></li>
                                <li><a href="<?= LANG_URL . '/page/faq' ?>">» FAQ</a></li>
                            </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 f-col">
                    <h3><?= lang('categories') ?></h3>
                    <?php if (!empty($footerCategories)) { ?>
                        <ul>
                            <?php foreach ($footerCategories as $key => $categorie) { ?>
                                <li><a href="javascript:void(0);" data-categorie-id="<?= $key ?>" class="go-category"><?= $categorie ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p><?= lang('no_categories') ?></p>
                    <?php } ?>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 f-col">
                    <h3><?= lang('contacts') ?></h3>
                    <ul class="footer-icon">
                        <?php if ($footerContactAddr != '') { ?>
                            <li>
                                <span class="pull-left"><i class="fa fa-map-marker"></i></span> 
                                <span class="pull-left f-cont-info"> <?= $footerContactAddr ?></span> 
                            </li>
                        <?php }if ($footerContactPhone != '') { ?>
                            <li>
                                <span class="pull-left"><i class="fa fa-phone"></i></span> 
                                <span class="pull-left f-cont-info"> <?= $footerContactPhone ?></span> 
                            </li>
                        <?php } if ($footerContactEmail != '') { ?>
                            <li>
                                <span class="pull-left"><i class="fa fa-envelope"></i></span> 
                                <span class="pull-left f-cont-info"><a href="mailto:<?= $footerContactEmail ?>"><?= $footerContactEmail ?></a></span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 f-col">
                    <h3><?= lang('newsletter') ?></h3>
                    <ul>
                        <li>
                            <div class="input-append newsletter-box text-center">
                                <form method="POST" id="subscribeForm">
                                    <input type="text" class="full text-center" id="subscribe_email" name="subscribe_email" placeholder="<?= lang('email_address') ?>">
                                    <button class="btn bg-gray" type="button" id="mc-submit"> <?= lang('subscribe') ?> <i class="fa fa-long-arrow-right"></i></button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <ul class="social">
                        <?php if ($footerSocialFacebook != '') { ?>
                            <li> <a href="<?= $footerSocialFacebook ?>"><i class=" fa fa-facebook"></i></a></li>
                        <?php } if ($footerSocialTwitter != '') { ?>
                            <li> <a href="<?= $footerSocialTwitter ?>"><i class="fa fa-twitter"></i></a></li>
                        <?php } if ($footerSocialGooglePlus != '') { ?>
                            <li> <a href="<?= $footerSocialGooglePlus ?>"><i class="fa fa-google-plus"></i></a></li>
                        <?php } if ($footerSocialPinterest != '') { ?>
                            <li> <a href="<?= $footerSocialPinterest ?>"><i class="fa fa-pinterest"></i></a></li>
                        <?php } if ($footerSocialYoutube != '') { ?>
                            <li> <a href="<?= $footerSocialYoutube ?>"><i class="fa fa-youtube"></i></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"><?= $footerCopyright ?></p>
            <div class="pull-right">
                <ul class="nav nav-pills payments">
                    <li><i class="fa fa-cc-visa"></i></li>
                    <li><i class="fa fa-cc-mastercard"></i></li>
                    <li><i class="fa fa-cc-amex"></i></li>
                    <li><i class="fa fa-cc-paypal"></i></li>
                </ul> 
            </div>
        </div>
    </div>
</footer>
<?php 
echo $addedJs;
if ($this->session->flashdata('userError')) {
    if (is_array($this->session->flashdata('userError'))) {
        $usr_err = implode(' ', $this->session->flashdata('userError'));
    } else {
        $usr_err = $this->session->flashdata('userError');
    }
    ?>
    <script>
        $(document).ready(function () {
            ShowNotificator('alert-danger', '<?= $usr_err ?>');
        });
    </script>
    <?php
}
if ($this->session->flashdata('userSuccess')) {
    if (is_array($this->session->flashdata('userSuccess'))) {
        $usr_success = implode(' ', $this->session->flashdata('userSuccess'));
    } else {
        $usr_success = $this->session->flashdata('userSuccess');
    }
    ?>
    <script>
        $(document).ready(function () {
            ShowNotificator('alert-info', '<?= $usr_success ?>');
        });
    </script>
    <?php
}
?>

</div>
</div>
<div id="notificator" class="alert"></div>
<input type="hidden" id="currency" value="<?= CURRENCY ?>" />
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-confirmation.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-select-1.12.1/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= base_url('assets/js/placeholders.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<!-- slick js-->
<script src="<?= base_url('templatejs/slick.js') ?>"></script>

<script>
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
$('.slide-1').slick({
         autoplay: true,
         autoplaySpeed: 3000
    });
	
var variable = {
    clearShoppingCartUrl: "<?= base_url('clearShoppingCart') ?>",
    manageShoppingCartUrl: "<?= base_url('manageShoppingCart') ?>",
    discountCodeChecker: "<?= base_url('discountCodeChecker') ?>"
};
function isEmail(email) {
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  return reg.test(email);
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
 $(document).ready(function () {
            $('#mc-submit').click(function(){
				if(isEmail($('#subscribe_email').val())){
					$(this).prop('disabled', true);
					$.ajax({
						type: "POST",
						url: '<?= base_url('users/subscribe_newsletter') ?>',
						data: {email: $('#subscribe_email').val()}
					}).done(function (data) {
						if(data == "1")
						ShowNotificator('alert-info', 'You are subscribed to our newsletter.');
						else
						ShowNotificator('alert-danger', 'You are already subscribed to our newsletter.');
						
						$('#subscribe_email').val("");
						$('#mc-submit').prop('disabled', false);
					});
				}else
				ShowNotificator('alert-danger', lang.enter_valid_email);
			});
        });
</script>
<script src="<?= base_url('assets/js/system.js') ?>"></script>
<script src="<?= base_url('templatejs/mine.js') ?>"></script>
</body>
</html>
