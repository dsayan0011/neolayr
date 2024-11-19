<link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> Orders Report</h1>
</div>
<hr>
<div class="table-responsive">
		<?php if($this->session->userdata("report_message")!=""){?>
        <div class="alert alert-info">
          <?php echo $this->session->userdata("report_message");?>
        </div>
        <?php
		$this->session->unset_userdata("report_message");
		 } ?>
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="form-group col-md-3">
                        <label>Start Date</label>
                        <input class="form-control datepicker" name="start_date" value="" type="text" autocomplete="off">
            </div>
            <div class="form-group col-md-3">
                        <label>End Date</label>
                        <input class="form-control datepicker" name="end_date" value="" type="text" autocomplete="off">
            </div>
             <div class="form-group col-md-12">
             <button type="submit" name="submit" class="btn btn-lg btn-default">Generate</button>
             </div>
            
       </form>
            
 </div>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script>
                        $('.datepicker').datepicker({
                            format: "dd.mm.yyyy",
							 todayHighlight: true,
                        });
</script>
