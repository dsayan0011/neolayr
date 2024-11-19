<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> Return Order</h1>
</div>
<hr>
<div class="well hidden-xs"> 
                <div class="row">
                    <form method="GET" id="searchOrderForm" action="">
                        <div class="col-sm-4">
                            <label>Start Date:</label>
                            <div class="input-group">
                            	 <input class="form-control datepicker" name="start_date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>" type="text" autocomplete="off">
                                 <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>End Date:</label>
                            <div class="input-group">
                                <input class="form-control datepicker" name="end_date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>" type="text" autocomplete="off">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Order:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Order Number" type="text" value="<?= isset($_GET['order_number']) ? $_GET['order_number'] : '' ?>" name="order_number">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                    <div class="col-sm-12" style="float:right; text-align:right; margin-top:10px;">
                    	<a class="btn btn-default" href="<?= base_url('admin/return') ?>">Clear filter</a>
                    </div>
                </div>
            </div>
            <hr>
<?php

if (!isset($_GET['settings'])) {
    if (!empty($orders)) {
        ?>
        
        <?php /*?><div style="margin-bottom:10px;">
            <select class="selectpicker changeOrder">
                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id' ? 'selected' : '' ?> value="id">Order by new</option>
                <option <?= (isset($_GET['order_by']) && $_GET['order_by'] == 'processed') || !isset($_GET['order_by']) ? 'selected' : '' ?> value="processed">Order by not processed</option>
            </select>
        </div><?php */?>
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Return Date</th>
                        <th>Return Status</th>
                        <th>Return Date By Courier Partner</th>
                        <th>Return Approval Status</th>
                        <th class="text-center">Preview</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $tr) {
						$class = "";
						$type = "";
                         	if ($tr['return_accepted_at_warehouse'] == "") {
								$class = 'bg-danger';
								$type = 'Return Processing';
							}
							if ($tr['return_accepted_at_warehouse'] == "approved") {
								$class = 'bg-success';
								$type = 'Approved';
							}
							if ($tr['return_accepted_at_warehouse'] == "rejected") {
								$class = 'bg-warning';
								$type = 'Rejected';
							}
                        ?>
                        <tr>
                            <td class="relative" id="order_id-id-<?= $tr['return_order_id'] ?>">
                                # <?= $tr['return_order_id'] ?>
                                <?php if ($tr['return_viewed'] == 0) { ?>
                                    <div>
                                        <img src="<?= base_url('assets/imgs/new-blinking.gif') ?>" style="width:100px;" alt="blinking">
                                    </div>
                                <?php } ?>
                            </td>
                            <td><?= date('d.M.Y / H:i:s', strtotime($tr['return_date'])); ?></td>
                            <td>
                                <?= strtoupper(str_replace("_"," ",$tr['return_status'])) ?>
                            </td>
                            <td>
                            	 <?php if($tr['warehouse_return_date']!="0000-00-00 00:00:00") echo date('d.M.Y / H:i:s', strtotime($tr['warehouse_return_date'])); ?></td>
                            </td>
                            <td class="<?= $class ?> text-center"> -- <b><?= $type ?></b> --
                            <?php 
							if($tr['return_status'] == 'initiated'){?>
								<div style="margin-bottom:4px;"><a href="<?= base_url('admin/processReturnOrder').'/'.$tr['return_order_id'].'/'.$tr['return_update_id'].'/'.$tr['product_id'].'/'.$tr['variant_id'] ?>" class="btn btn-success btn-xs">Process</a></div>
							<?php }else if($tr['return_status'] != 'return_processing' && $tr['return_accepted_at_warehouse']==""){?>
                                 <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="change_return_order_status(<?= $tr['return_update_id'] ?>,<?= $tr['id'] ?>,'approved','<?= $tr['return_status'] ?>')" class="btn btn-success btn-xs">Approved</a></div>
                                 <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="change_return_order_status(<?= $tr['return_update_id'] ?>,<?= $tr['id'] ?>,'rejected','<?= $tr['return_status'] ?>')" class="btn btn-danger btn-xs">Rejected</a></div>
                            <?php } ?>
                            </td>
                            <td class="text-center">	
                                <a href="javascript:void(0);" class="btn btn-default more-info" data-toggle="modal" data-target="#modalPreviewMoreInfo" style="margin-top:10%;" data-more-info="<?= $tr['return_order_id'] ?>">
                                    More Info 
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="hidden" id="order-id-<?= $tr['return_order_id'] ?>">
                                <div class="table-responsive">
                                    <table class="table more-info-purchase">
                                        <tbody>
                                            <tr>
                                                <td><b>Email</b></td>
                                                <td><a href="mailto:<?= $tr['email'] ?>"><?= $tr['email'] ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><b>Name</b></td>
                                                <td><?= $tr['first_name']." ".$tr['last_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>City</b></td>
                                                <td><?= $tr['city'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Address</b></td>
                                                <td><?= $tr['address'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Postcode</b></td>
                                                <td><?= $tr['post_code'] ?></td>
                                            </tr>
                                             <tr>
                                                <td><b>State</b></td>
                                                <td><?= $tr['thana'] ?></td>
                                            </tr>
                                            
                                            <tr>
                                                <td><b>Notes</b></td>
                                                <td><?= $tr['notes'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Postcode</b></td>
                                                <td><?= $tr['post_code'] ?></td>
                                            </tr>
                                             <tr>
                                                <td><b>Shop Name</b></td>
                                                <td><?= $tr['shop_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Come from site</b></td>
                                                <td>
                                                    <?php if ($tr['referrer'] != 'Direct') { ?>
                                                        <a target="_blank" href="<?= $tr['referrer'] ?>" class="orders-referral">
                                                            <?= $tr['referrer'] ?>
                                                        </a>
                                                    <?php } else { ?>
                                                        Direct traffic or referrer is not visible                       
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Payment Type</b></td>
                                                <td><?= $tr['payment_type'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Discount</b></td>
                                                <td><?= $tr['discount_type'] == 'float' ? '-' . $tr['discount_amount'] : '-' . $tr['discount_amount'] . '%' ?></td>
                                            </tr>
                                            <?php if ($tr['payment_type'] == 'PayPal') { ?>
                                                <tr>
                                                    <td><b>PayPal Status</b></td>
                                                    <td><?= $tr['paypal_status'] ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="2"><b>Products</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <?php
                                                    $arr_products = unserialize($tr['products']);
                                                    foreach ($arr_products as $product) {
														if($product['product_info']['id'] == $tr['product_id'] && $product['product_info']['variant_id'] == $tr['variant_id']){
                                                        $total_amount = 0;
                                                        $total_amount += str_replace(' ', '', str_replace(',', '.',$product['product_selling_price']));
                                                        ?>
                                                        <div style="word-break: break-all;">
                                                            <div>
                                                                <img src="<?= base_url('attachments/shop_images/' . $product['product_info']['image']) ?>" alt="Product" style="width:100px; margin-right:10px;" class="img-responsive">
                                                            </div>
                                                            <a data-toggle="tooltip" data-placement="top" title="Click to preview" target="_blank" href="<?= base_url($product['product_info']['url']) ?>">
                                                                
                                                                <div style=" background-color: #f1f1f1; border-radius: 2px; padding: 2px 5px;">
                                                                    <b>Quantity:</b> <?= $product['product_quantity'] ?><br />
                                                                    <b>Original Price: <?= $product['product_info']['price'].' '.$this->config->item('currency') ?></b><br />
                                                                    <b>Selling Price: <?= $product['product_selling_price'].' '.$this->config->item('currency') ?></b><br />
                                                                </div>
                                                            </a>
                                                            
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    <?php }
													}
                                                    ?>
                                                   
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><b>Return Reason : <?= $tr['reason1'] ?></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><b>Return Reason 2: <?= $tr['reason2'] ?></b></td>
                                            </tr>
                                             <tr>
                                                <td colspan="2"><a href="<?= base_url('attachments/return_images/' . $tr['image_name']) ?>" target="_blank"><img src="<?= base_url('attachments/return_images/' . $tr['image_name']) ?>" width="200px" /></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?= $links_pagination ?>
    <?php } else { ?>
        <div class="alert alert-info">No orders to the moment!</div>
    <?php }
    ?>        
    <hr>
    <?php
}
?>
<!-- Modal for more info buttons in orders -->
<div class="modal fade" id="modalPreviewMoreInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Preview <b id="client-name"></b></h4>
            </div>
            <div class="modal-body" id="preview-info-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Enter your remark<b id="client-name"></b></h4>
            </div>
            <div class="modal-body">
              <form method="POST" action="<?= base_url('admin/changeReturnStatus') ?>">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" value="" name="cancel_reason" placeholder="Enter Your Remark"></td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="the_id" value="" id="the_id"  />
                <input type="hidden" name="return_order_id" value="" id="return_order_id"  />
                 <input type="hidden" name="to_status" id="to_status" value=""  />
                 <input type="hidden" name="return_status" id="return_status"  value=""  />
                <input type="submit" class="form-control" value="Save">
            </form>
            </div>
          
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script>
                        $('.datepicker').datepicker({
                            format: "dd.mm.yyyy",
							todayHighlight: true
                        });
</script>