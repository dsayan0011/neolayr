<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
<div style="text-align: center;margin: 6em 0;font-size: 2rem;">
	<img style="margin: 0px auto;margin-bottom: 2rem;" src="<?= base_url('attachments/loading.gif') ?>" />
    <br />
	<span>Redirecting to payment gateway. Please do not press back button or refresh the page.</span>
</div>
    <?php
   
    if (!empty($cartItems['array'])) {
        ?>
	<!-- sandbox https://checkout-sandbox.freecharge.in   Live https://checkout.freecharge.in -->
        <form action="<?= freecharge_url."api/v1/co/pay/init";?>" name="freecharge_checkout" enctype='application/json' class="text-center" method="post">
            <input type="hidden" name="amount" value="<?= $payment_info['amount'];?>">
           <input type="hidden" name="channel" value="<?= $payment_info['channel'];?>">
           <input type="hidden" name="currency" value="<?= $payment_info['currency'];?>">
           <input type="hidden" name="customerName" value="<?= $payment_info['customerName'];?>">
           <input type="hidden" name="email" value="<?= $payment_info['email'];?>">
           <input type="hidden" name="furl" value="<?= $payment_info['furl'];?>">
           <input type="hidden" name="merchantId" value="<?= $payment_info['merchantId'];?>">
           <input type="hidden" name="merchantTxnId" value="<?= $payment_info['merchantTxnId'];?>">
           <input type="hidden" name="mobile" value="<?= $payment_info['mobile'];?>">
           <input type="hidden" name="productInfo" value="<?= $payment_info['productInfo'];?>">
           <input type="hidden" name="surl" value="<?= $payment_info['surl'];?>">
           <input type="hidden" name="checksum" value="<?= $hash;?>">
        </form>
        <?php
    } else {
        redirect(base_url());
    }
    ?>
</div>
<script type="text/javascript">
<!--
   var wait=setTimeout("document.freecharge_checkout.submit();",2000);
//-->
</script>