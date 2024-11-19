<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> Success Payment</h1>
</div>
<hr>
<div class="table-responsive">
		<?php if($this->session->userdata("order_message")!=""){?>
        <div class="alert alert-info">
          <?php echo $this->session->userdata("order_message");?>
        </div>
        <?php
		$this->session->unset_userdata("order_message");
		 } ?>
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="form-group col-md-3">
                        <label>Enter Order ID</label>
                        <input class="form-control" name="order_id" id="order_id" value="" type="text" autocomplete="off" required>
            </div>
            
             <div class="form-group col-md-12">
             <button type="submit" name="process_order" class="btn btn-lg btn-default" onClick='return confirmSubmit()'>Update</button>
             </div>
            
       </form>
            
 </div>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure want to make sucess payment for Order Id : "+document.getElementById("order_id").value);
if (agree)
 return true ;
else
 return false ;
}
// -->
</script>