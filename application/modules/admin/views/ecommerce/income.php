<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> Income History</h1>
</div>
<hr>
<div class="well hidden-xs"> 
                <div class="row">
                    <form method="GET" id="searchOrderForm" action="">
                        <div class="col-sm-4">
                            <label>Payment Status:</label>
                            <select name="sort_by" class="form-control selectpicker changeOrder">
                            	  <option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == '' ? 'selected=""' : '' ?> value="">All</option>
                                  <option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'processing' ? 'selected=""' : '' ?> value="processing">Processing</option>
                                  <option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'UNPAID' ? 'selected=""' : '' ?> value="UNPAID">Unpaid</option>
                                  <option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'PAID' ? 'selected=""' : '' ?> value="PAID">Paid</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>Seller Name:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Seller Name" type="text" value="<?= isset($_GET['seller_name']) ? $_GET['seller_name'] : '' ?>" name="seller_name">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Seller Number:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Seller Number" type="text" value="<?= isset($_GET['seller_number']) ? $_GET['seller_number'] : '' ?>" name="seller_number">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
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
                    	<a class="btn btn-default" href="<?= base_url('admin/income') ?>">Clear filter</a>
                    </div>
                </div>
            </div>
            <hr>
<?php
    if (!empty($orders)) {
        ?>
       <?php /*?> <div style="margin-bottom:10px;">
            <select class="selectpicker changeOrder">
                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id' ? 'selected' : '' ?> value="id">Order by new</option>
                <option <?= (isset($_GET['order_by']) && $_GET['order_by'] == 'processed') || !isset($_GET['order_by']) ? 'selected' : '' ?> value="processed">Order by not processed</option>
            </select>
        </div><?php */?>
        <div style="margin-bottom:10px;">
        	<input type="button" name="pay_selected" value="Paid Selected Order"  onclick="update_selected_income()" />
        </div>
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                    	<th></th>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Income</th>
                        <th class="text-center">Order Status</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center">Order Preview</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $tr) {
                        if ($tr['processed'] == 0) {
                            $class = 'bg-danger';
                            $type = 'Processing';
                        }
                        if ($tr['processed'] == 1) {
                            $class = 'bg-success';
                            $type = 'Processed';
                        }
                        if ($tr['processed'] == 2) {
                            $class = 'bg-warning';
                            $type = 'Shipped';
                        }
						if ($tr['processed'] == 3) {
                            $class = 'bg-success';
                            $type = 'Delivered';
                        }
						if ($tr['processed'] == 4) {
                            $class = 'bg-danger';
                            $type = 'Cancelled';
                        }
						if ($tr['processed'] == 5) {
                            $class = 'bg-success';
                            $type = 'Settled';
                        }
						if ($tr['processed'] == 6) {
                            $class = 'bg-success';
                            $type = 'Returned';
                        }
						if ($tr['processed'] == 7) {
                            $class = 'bg-success';
                            $type = 'Delivered Returned Sattled';
                        }
						if ($tr['processed'] == 8) {
                            $class = 'bg-success';
                            $type = 'Shipped Return';
                        }
						if ($tr['processed'] == 9) {
                            $class = 'bg-success';
                            $type = 'Returned Sattled';
                        }
                        ?>
                        <tr>
                        	<td>
                            	<?php if($tr['processed'] == 5 && $tr['payment_status']=='UNPAID'){?>
                            	<input type="checkbox" name="order_id" value="<?= $tr['income_id'];?>" />
                                <?php } ?>
                            </td>
                            <td class="relative" id="order_id-id-<?= $tr['order_id'] ?>">
                                # <?= $tr['order_id'] ?>
                                <?php if ($tr['processed'] == 5 && $tr['payment_status']=='UNPAID') { ?>
                                    <div id="new-order-alert-<?= $tr['id'] ?>">
                                        <img src="<?= base_url('assets/imgs/new-blinking.gif') ?>" style="width:100px;" alt="blinking">
                                    </div>
                                <?php } ?>
                            </td>
                            <td><?= date('d.M.Y / H:i:s', $tr['date']); ?></td>
                            <td>
                                <i class="fa fa-user" aria-hidden="true"></i> 
                                <?= $tr['name'] ?>
                                <br />
                                 <a href="javascript:void(0);" class="btn btn-default" data-toggle="modal" onclick="getTotalIncome(<?php echo $tr['user_id'];?>)" data-target="#modal_income_preview" style="margin-top:10%;" data-more-info="<?= $tr['user_id'] ?>">
                                    View Income
                                </a>
                            </td>
                            <td><i class="fa fa-phone" aria-hidden="true"></i> <?= $tr['phone'] ?></td>
                            <td><?= $tr['income_amount'].$this->config->item('currency') ?></td>
                            <td class="text-center" data-action-id="<?= $tr['id'] ?>">
                                <div class="status" style="padding:5px; font-size:16px;">
                                    -- <b><?= $type ?></b> --
                                </div>
                            </td>
                            <td class="text-center <?php if($tr['processed'] == 5 && $tr['payment_status']=='UNPAID') echo 'bg-danger';?> " data-action-id="<?= $tr['id'] ?>">
                                <div class="status" style="padding:5px; font-size:16px; text-transform:uppercase;">
                                    <b><?= $tr['payment_status'] ?></b>
                                    <?php if($tr['processed'] == 5 && $tr['payment_status']=='UNPAID'){?>
                                     <div style="margin-bottom:4px;">
                                     	<a onclick="display_transaction_modal('<?=$tr['income_id'];?>')" href="javascript:void(0);"  class="btn btn-danger btn-xs">PAID</a>
                                     </div>
                                     
                                	<?php } ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-default more-info" data-toggle="modal" data-target="#modalPreviewMoreInfo" style="margin-top:10%;" data-more-info="<?= $tr['order_id'] ?>">
                                    Order Info 
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="hidden" id="order-id-<?= $tr['order_id'] ?>">
                                <div class="table-responsive">
                                    <table class="table more-info-purchase">
                                        <tbody>
                                            <tr>
                                                <td colspan="2"><b>Products</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <?php
                                                    $arr_products = unserialize($tr['products']);
                                                    foreach ($arr_products as $product) {
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
                                                        <div style="padding-top:10px; font-size:16px;">Total amount of products: <?= $total_amount.' '.$this->config->item('currency') ?></div>
                                                        <hr>
                                                    <?php }
                                                    ?>
                                                     <b>Extra Shipping Charge: <?= $tr['extra_shipping_cost'].' '.$this->config->item('currency') ?></b><br />
                                                </td>
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
<div class="modal fade" id="modal_income_preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Income Details <b id="client-name"></b></h4>
            </div>
            <div class="modal-body" id="preview-info-body">
              <div class="table-responsive" id="income_info">
              		Loading Income Information ...
			
              </div>
            </div>
          
        </div>
    </div>
</div>
<div class="modal fade" id="modal_transaction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Enter Transaction details <b id="client-name"></b></h4>
                                                </div>
                                                <div class="modal-body" id="preview-info-body">
                                                	<form method="post" action="<?= base_url('admin/update_payment_status') ?>">
                                                    	<input type="hidden" name="income_id" id="income_id" value="" />
                                                        <div class="form-group for-shop">
                                                           <input type="text" placeholder="Transaction ID" name="transaction_id" required class="form-control">
                                                        </div>
                                                        <div class="form-group for-shop">
                                                            <textarea placeholder="Transaction Notes" name="transaction_notes" class="form-control"></textarea>
                                                            
                                                        </div>
                                                         <div class="form-group for-shop">
                                                            <button type="submit" name="submit" class="btn btn-lg btn-default">UPDATE</button>
                                                         </div>
                                                    </form>
                                                </div>
                                                
                                            </div>
                                        </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script>
                        $('.datepicker').datepicker({
                            format: "dd.mm.yyyy"
                        });
</script>