<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
<div style="text-align: center;margin: 6em 0;font-size: 2rem;">
	<span>You have selected Razorpay to make the payment. Click the "Pay Now" button below to completed your purchase</span>
    <button id="rzp-button1" class="btn" style="margin-top:20px">Pay with Razorpay</button>
    <form name='razorpayform' action="<?= LANG_URL . '/checkout/process_razorpay_payment';?>" method="POST">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
    </form>
    <script type="text/javascript">
	var options = <?php echo $json?>;
					options.handler = function (response){
						document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
						document.getElementById('razorpay_signature').value = response.razorpay_signature;
						document.razorpayform.submit();
					};
					
					// Boolean whether to show image inside a white frame. (default: true)
					options.theme.image_padding = false;
					
					options.modal = {
						ondismiss: function() {
							console.log("This code runs when the popup is closed");
						},
						// Boolean indicating whether pressing escape key 
						// should close the checkout form. (default: true)
						escape: true,
						// Boolean indicating whether clicking translucent blank
						// space outside checkout form should close the form. (default: false)
						backdropclose: false
					};
					
					var rzp = new Razorpay(options);
		document.getElementById('rzp-button1').onclick = function(e){
			rzp.open();
			e.preventDefault();
		}
	</script>
</div>