<h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;"> <?= $title;?></h1>
<hr>
<?php
$timeNow = time();
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
    <?php
}
if ($this->session->flashdata('result_add')) {
    ?>
    <hr>
    <div class="alert alert-warning"><?= $this->session->flashdata('result_add') ?></div>
    <hr>
    <?php
}
?>
<form method="POST">
 <input type="hidden" name="edit" value="<?= isset($vendor_details) ? $vendor_details['id'] : '0' ?>">
						<div class="form-group">
                            <label for="name">Nickname( Max 8 characters)</label>
                            <input type="text" name="name" maxlength="8" required value="<?= isset($vendor_details['name']) ? $vendor_details['name'] : '' ?>" class="form-control" id="name">
                        </div>
                         <div class="form-group">
                            <label for="warehouse_name">Warehouse Name</label>
                            <input type="text" name="warehouse_name" required value="<?= isset($vendor_details['warehouse_name']) ? $vendor_details['warehouse_name'] : '' ?>" class="form-control" id="warehouse_name">
                        </div>
                        <div class="form-group">
                            <label for="address">Address Line 1</label>
                            <input type="text" name="address_line1" required value="<?= isset($vendor_details['address_line1']) ? $vendor_details['address_line1'] : '' ?>" class="form-control" id="address_line1">
                        </div>
                        <div class="form-group">
                            <label for="address">Address Line 2</label>
                            <input type="text" name="address" required value="<?= isset($vendor_details['address']) ? $vendor_details['address'] : '' ?>" class="form-control" id="address">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" required value="<?= isset($vendor_details['phone']) ? $vendor_details['phone'] : '' ?>" class="form-control" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" required class="form-control" value="<?= isset($vendor_details['email']) ? $vendor_details['email'] : '' ?>" id="email">
                        </div>
                        <div class="form-group">
                            <label for="pincode">Pincode</label>
                            <input type="text" name="pincode" required  value="<?= isset($vendor_details['pincode']) ? $vendor_details['pincode'] : '' ?>" class="form-control" id="pincode">
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <select name="state" class="form-control" required onChange="getCity(this.value);">
                            	<?php foreach($stateList->result() as $state){
									?>
                            	<option <?php if(isset($vendor_details['state']) && ($vendor_details['state'] == $state->id)) echo 'selected="selected"';?> value="<?php echo $state->id;?>"><?php echo $state->state_name;?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <select name="city" id="city" class="form-control" required>
                            	<?php if(isset($thana_list)){
										foreach($thana_list as $thana){?>
											<option <?php if(isset($vendor_details['city']) && ($vendor_details['city'] == $thana['id'])) echo 'selected="selected"';?> value=<?= $thana['id'];?>><?= $thana['name'];?></option>
										
                                <?php } }else{?>
                            	<option>Select State</option>
                                <?php } ?>
                            </select>
                        </div>
                         <div class="form-group">
                            <label for="vendor_status">Status</label>
                            <select name="location_status" id="location_status" class="form-control" required>
                            	<option <?php if(isset($vendor_details['location_status']) && ($vendor_details['location_status'] == 1)) echo 'selected="selected"';?> value="1">Active</option>
                                <option <?php if(isset($vendor_details['location_status']) && ($vendor_details['location_status'] == 0)) echo 'selected="selected"';?> value="0">Inactive</option>
                            </select>
                        </div>
      <input type="submit" name="submit" class="btn btn-lg btn-default" />

    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/vendors') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>
