<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<style type="text/css">
    .offerTypeDisabled{
        cursor: none;
        pointer-events: none;
    }
    .bestSeller{
        display: none;
    }
    .catagory{
        display: none;
    }
</style>
<h1><img src="<?= base_url('assets/imgs/discount.png') ?>" class="header-img" style="margin-top:-3px;"> Discount Codes</h1>
<hr>
<div style="margin-bottom: 20px;">
    <a href="javascript:void(0);" data-toggle="modal" data-target="#addDiscountCode" class="btn btn-primary pull-left">
        <b>+</b> Add discount code
    </a>
    <form method="POST" action="" class="pull-right">
        <label>Code discounts</label>
        <input type="hidden" name="codeDiscounts" value="<?= $codeDiscounts ?>">
        <input <?= $codeDiscounts == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="codeDiscounts" class="toggle-changer" type="checkbox">
        <button class="btn btn-default" value="" type="submit">
            Save
        </button>
    </form>
    <div class="clearfix"></div>
</div>
<?php if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php } ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Offer Type</th>
                <th>Code</th>
                <th>Amount</th>
                <th>Valid from</th>
                <th>Valid to</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($discountCodes)) {
                foreach ($discountCodes as $code) {
                    if ($code['status'] == 1) {
                        $tostatus = 0;
                    } else {
                        $tostatus = 1;
                    }
                    ?>
                    <tr> 
                        <td><?= $code['offerType'] ?></td>
                        <td><?= $code['code'] ?></td>
                        <td><?= $code['type'] == 'float' ? '-' . $code['amount'] : '-' . $code['amount'] . '%' ?></td>
                        <td><?= date('d.m.Y', $code['valid_from_date']) ?></td>
                        <td <?= time() > $code['valid_to_date'] ? 'class="text-danger"' : '' ?>><?= date('d.m.Y', $code['valid_to_date']) ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/discounts?codeid=' . $code['id'] . '&tostatus=' . $tostatus) ?>">
                                <?= $code['status'] == 1 ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>' ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/discounts?edit=' . $code['id']) ?>" class="btn btn-primary btn-xs">Edit</a>
                        </td>
                    </tr> 
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="6">No discount codes added</td> 
                </tr> 
            <?php } ?>
        </tbody>
    </table>
</div>
<?= $links_pagination ?>
<!-- add/edit discounts -->
<div class="modal fade" id="addDiscountCode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <input type="hidden" name="update" value="<?= isset($_POST['update']) ? $_POST['update'] : '0' ?>">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <h4 class="modal-title" id="myModalLabel">Add discount code</h4>
                </div>
                <div class="modal-body">
                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"><?= implode('<br>', $this->session->flashdata('error')) ?></div>
                    <?php } ?>
                    <div class="form-group">
                        <label>Offer Type</label>                        
                        <select class="selectpicker form-control show-tick show-menu-arrow" name="offer_types" id="offer_types" required>
                            <!-- <option value="all" <?= isset($_POST['offer_types']) && in_array('all',$_POST['offer_types']) ? 'selected="selected"' : '' ?>>All</option> -->
                            <option value="" <?= isset($_POST['offer_types']) && $_POST['offer_types'] == '' ? 'selected' : '' ?> class="<?= isset($_POST['offer_types']) ? 'offerTypeDisabled' : 'offerTypeDisabled' ?>">Please Select Offer Type</option>
                            <?php foreach ($offerType as $item) { ?>                          
                                    <option <?= isset($_POST['offer_types']) && ($item['offer_typeID'] == $_POST['offer_types']) ? 'selected="selected"' : '' ?> value="<?= $item['offer_typeID'] ?>">
                                       <?php echo $item['type']; ?>
                                    </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group <?= ($_POST['offer_types']) == '2' ? '' : 'catagory' ?>" id="catagory">
                        <label>Category specific</label>
                        <?php $_POST['categories'] = explode(",",$_POST['categories']);?>
                        <select class="selectpicker form-control show-tick show-menu-arrow" name="categories[]" multiple="multiple">
                            <!-- <option value="all" <?= isset($_POST['categories']) && in_array('all',$_POST['categories']) ? 'selected="selected"' : '' ?>>All</option> -->
                             <option value="" <?= isset($_POST['categories']) && $_POST['categories'] == '' ? 'selected' : '' ?> class="<?= isset($_POST['categories']) ? 'offerTypeDisabled' : 'offerTypeDisabled' ?>">Please Select Offer Type</option>
                            <?php foreach ($getCategories as $categories) { ?>
                                
                                    <option <?= isset($_POST['categories']) && in_array($categories['id'],$_POST['categories']) ? 'selected="selected"' : '' ?> value="<?= $categories['id'] ?>">
                                       <?php echo $categories['name']; ?>
                                    </option>
                            <?php }  ?>
                        </select>
                    </div>
                    <div class="form-group <?= ($_POST['offer_types']) == '9' ? '' : 'catagory' ?>" id="products">
                                <label>Products</label> 
                                <?php $_POST['product'] = explode(",",$_POST['product']);?>
                                <select class="selectpicker form-control show-tick show-menu-arrow"  multiple="multiple" name="products[]" >
                                    <option value="" <?= isset($_POST['product']) && $_POST['product'] == '' ? 'selected' : '' ?> class="<?= isset($_POST['product']) ? 'offerTypeDisabled' : 'offerTypeDisabled' ?>">Please Select Product</option>
                                        <?php foreach ($getProduct as $item) { ?>
                                            <option <?= isset($_POST['product']) && in_array($item['sku'],$_POST['product']) ? 'selected="selected"' : '' ?> value="<?= $item['sku'] ?>">
                                               <?php echo $item['sku']; ?>
                                            </option>
                                        <?php } ?>
                                </select>
                        </div>
                    <div class="form-group">
                        <label>Type of discount</label>
                        <select class="selectpicker form-control show-tick show-menu-arrow" name="type">
                            <option <?= (isset($_POST['type']) && $_POST['type'] == 'percent') || !isset($_POST['percent']) ? 'selected=""' : '' ?> value="percent">%</option>
                            <option <?= isset($_POST['type']) && $_POST['type'] == 'float' ? 'selected=""' : '' ?> value="float">Float</option> 
                        </select>
                    </div>
                     <!-- <div class="form-group">
                        <label>Vendor specific</label>
                        <?php $_POST['vendors'] = explode(",",$_POST['vendors']);?>
                        <select class="selectpicker form-control show-tick show-menu-arrow" name="vendors[]" multiple="multiple">
                            <option value="all" <?= isset($_POST['vendors']) && in_array('all',$_POST['vendors']) ? 'selected="selected"' : '' ?>>All</option>
                            <?php foreach ($vendor_list->result() as $vendor) { ?>
                                    <option <?= isset($_POST['vendors']) && in_array($vendor->id,$_POST['vendors']) ? 'selected="selected"' : '' ?> value="<?= $vendor->id ?>">
                                       <?php echo $vendor->name; ?>
                                    </option>
                            <?php } ?>
                        </select>
                    </div> -->
                    
                    <div class="form-group">
                        <label>Discount value</label>
                        <input class="form-control" name="amount" value="<?= isset($_POST['amount']) ? $_POST['amount'] : '' ?>" type="text">
                    </div>
                    
                    <div class="form-group <?= ($_POST['offer_types'] == '2') || ($_POST['offer_types'] == '9') ? '' : 'catagory' ?>" id="totalProductPrice">
                        <label>Purchase above limit</label>
                        <input class="form-control" name="totalProductPrice" value="<?= isset($_POST['totalProductPrice']) ? $_POST['totalProductPrice'] : '' ?>" type="text">
                    </div>
                    
                    <div class="form-group">
                        <label>Discount Details</label>
                        <input class="form-control" name="description" value="<?= isset($_POST['description']) ? $_POST['description'] : '' ?>" type="text">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <label>Discount code</label>
                        <input class="form-control" name="code" value="<?= isset($_POST['code']) ? $_POST['code'] : '' ?>" type="text">
                        <div style="position: absolute; right:5px; top:30px;">
                            <input type="text" data-toggle="tooltip" title="Set length of code" data-placement="top" class="codeLength" value="6" style="border: 1px solid #dadada;float: left;height: 20px; margin-right: 4px; text-align: center; margin-top: 1px; width: 20px;">
                            <a href="javascript:void(0);" onclick="generateDiscountCode()" class="btn btn-xs btn-default">Generate</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Valid from date</label>
                        <input class="form-control datepicker" name="valid_from_date" value="<?= isset($_POST['valid_from_date']) ? $_POST['valid_from_date'] : '' ?>" type="text" autocomplete="off">
                    </div>                    
                    <div class="form-group">
                        <label>Valid to date</label>
                        <input class="form-control datepicker" name="valid_to_date" value="<?= isset($_POST['valid_to_date']) ? $_POST['valid_to_date'] : '' ?>" type="text" autocomplete="off">
                    </div>
                        <div id="bestSeller" class="<?= ($_POST['offer_types']) == '7' ? '' : 'bestSeller' ?>">
                            <div class="form-group">
                                <label>Max Number of Free Product</label>
                                <input class="form-control" name="numberOfFreeProduct" value="<?= isset($_POST['numberOfFreeProduct']) ? $_POST['numberOfFreeProduct'] : '1' ?>" type="text"  pattern="[1-9]+">
                            </div>                    
                            <div class="form-group">
                                <label>Product</label> 
                                <?php $_POST['freeProductID'] = explode(",",$_POST['freeProductID']);?>
                                <select class="selectpicker form-control show-tick show-menu-arrow"  multiple="multiple" name="freeProductID[]" >
                                    <option value="" <?= isset($_POST['freeProductID']) && $_POST['freeProductID'] == '' ? 'selected' : '' ?> class="<?= isset($_POST['freeProductID']) ? 'offerTypeDisabled' : 'offerTypeDisabled' ?>">Please Select Offer Type</option>
                                        <?php foreach ($getProduct as $item) { ?>
                                            <option <?= isset($_POST['freeProductID']) && in_array($item['productID'],$_POST['freeProductID']) ? 'selected="selected"' : '' ?> value="<?= $item['productID'] ?>">
                                               <?php echo $item['productTitle']; ?>
                                            </option>
                                        <?php } ?>
                                </select>
                            </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" onclick="location.href = '<?= base_url('admin/discounts') ?>';" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script>
                        $(document).ready(function () {
                            $('[data-toggle="tooltip"]').tooltip();
<?php if (isset($_POST['code'])) { ?>
                                $('#addDiscountCode').modal('show');
<?php } ?>
                        });
                        $('.datepicker').datepicker({
                            format: "dd.mm.yyyy"
                        });
                        function generateDiscountCode() {
                            var length = $('.codeLength').val();
                            if (length < 3 || length == '') {
                                alert('Too short discount code!');
                            } else {
                                var text = "";
                                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                                for (var i = 0; i < length; i++) {
                                    text += possible.charAt(Math.floor(Math.random() * possible.length));
                                }
                                $('[name="code"]').val(text.toUpperCase());
                            }
                        }
</script>
<script type="text/javascript">
      $(document).ready(function(){
        $('#offer_types').on('change', function(){ 
            if($(this).val() == '7'){
                 $("#bestSeller").show();
            }
            else{
                 $("#bestSeller").hide();
            }
            if($(this).val() == '2'){
                 $("#catagory").show();
                 //$("#totalProductPrice").show();
            }
            else{
                 $("#catagory").hide();
                 //$("#totalProductPrice").hide();
            }
            if(($(this).val() == '5') || ($(this).val() == '9') || ($(this).val() == '2') || ($(this).val() == '7')){
                 $("#totalProductPrice").show();
            }
            else{
                 $("#totalProductPrice").hide();
            }
            if($(this).val() == '9'){
                 $("#products").show();
            }
            else{
                 $("#products").hide();
            }
            
        });
    });
</script>