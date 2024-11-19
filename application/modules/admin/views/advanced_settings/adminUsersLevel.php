<div id="users">
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;"> Admin Users Level</h1> 
    <hr>
    <?php if (validation_errors()) { ?>
        <hr>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_add')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_users" class="btn btn-primary btn-xs pull-right" onclick="resetAddForm()" style="margin-bottom:10px;"><b>+</b> Add new level</a>
    <div class="clearfix"></div>
    <?php
    if ($users->result()) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Active</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <?php foreach ($users->result() as $user) { 
						 $display_user = true;
						 if($this->session->userdata('level_id')!='1' && $user->user_level_id == "1")
						 $display_user = false;
						 
						  if($display_user){
				?>
                    <tr>
                        <td><?= $user->user_level_id ?></td>
                        <td><?= $user->user_level_name ?></td>
                        <td><?= $user->user_level_active ?></td>
                        <td class="text-center">
                            <div>
                                <a href="?delete=<?= $user->user_level_id ?>" class="confirm-delete">Delete</a> | 
                                <a href="?edit=<?= $user->user_level_id ?>">Edit</a>
                            </div>
                        </td>
                    </tr>
                <?php } } ?>
            </table>
        </div>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No level found!</div>
    <?php } ?>

    <!-- add edit users -->
    <div class="modal fade" id="add_edit_users" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
             <div class="col-sm-12">
                <section class="panel">
                 <div class="panel-body">
                    <div class="adv-table">
                       <form action="" method="post">
                        <h3>User Level Details</h3>
                        <div class="form-group">
                          <label for="level_name2">Level name</label>
                          <input class="form-control" name="level_name" type="text" id="level_name" value="<?= isset($_POST['user_level_name']) ? $_POST['user_level_name'] : '' ?>">
                          <input type="hidden" id="editLevel" name="edit" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '0' ?>">
                        </div>
                        <h3>Admin Access</h3>
                         <div class="row">
                         	<div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-10 col-md-offset-1 myWell">
                                                                <div class="col-md-8 paddingTop">
                                                                <strong>Admin access</strong><br>
                                                                 <small><em>User can access admin panel</em></small>
                                                              </div>
                                                              <div class="col-md-4">
                                                                 
                                                                    <label class="radio">
                                                                      <input type="radio" name="admin_access" <?php if(isset($_POST['admin_access']) && $_POST['admin_access']=='yes') echo 'checked="checked"';?> value="yes">Yes
                                                                    </label>
                                                                    <label class="radio">
                                                                      <input type="radio" name="admin_access" value="no" <?php if(isset($_POST['admin_access']) && $_POST['admin_access']=='no') echo 'checked="checked"';?>>No
                                                                    </label>
                                                                 
                                                              </div>      
                                                            </div>
                                                        </div>
                               </div>
                         </div>
                        <h3>Level Permission</h3>
                        
                                <div class="row">
                                				<?php 
												$admin_perimission = $this->session->userdata('adminPermission');
												
												foreach($memberPermission as $permission)
												{
													if(array_key_exists($permission['permission_code'],$admin_perimission) && $admin_perimission[$permission['permission_code']] == 1){?>
														<div class="col-md-6">
															<div class="row">
																<div class="col-md-10 col-md-offset-1 myWell">
																	<div class="col-md-8 paddingTop">
																	<strong><?php echo $permission['permission_name']?></strong><br>
																	 <small><em><?php echo $permission['permission_name']?> Permission</em></small>
																  </div>
																  <div class="col-md-4">
																	  <?php
																	  foreach($permissionType as $permission_type){
																	  ?>
																		<label class="radio">
																		  <input type="radio" name="<?php echo $permission['permission_code']?>" value="<?php echo $permission_type['user_permission_type_id']?>" <?php if(isset($_GET['edit'])){ if(isset($_POST[$permission['permission_code']]) && $_POST[$permission['permission_code']] == $permission_type['user_permission_type_id']) echo 'checked="checked"'; }else echo 'checked="checked"';?> id="<?php echo "permission".$permission['permission_id']?>"><?php echo $permission_type['user_permission_type_name']?>
																		</label>
																	  <?php
																	  }
																	  ?>
																  </div>      
																</div>
															</div>
														</div>
													<?php
													}
												}
												?>
                                
                                                
                                             </div>
                        <h3>Advance Order Management</h3>
                         <div class="row">
                         	<div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-10 col-md-offset-1 myWell">
                                                              <div class="col-md-6 paddingTop">
                                                                <strong>Display Order Status</strong><br>
                                                                 <small><em>Disaplay only order of selected status</em></small>
                                                              </div>
                                                              <div class="col-md-6">
                                                              <?php
															  if(isset($_POST['display_order']))
															  $display_order_array = explode(",",$_POST['display_order']);
															  
															  if($this->session->userdata('logged_in')=='admin'){
																 $display_order_perimission = array("0","1","2","3","4","5","6","7","8","9");
															  }
															  else{
															  		$perimission = $this->session->userdata('adminPermission');
															  		$display_order_perimission = explode(",",$perimission['display_order']);
															  }
															  if(in_array("0",$display_order_perimission)){
															  ?>
                                                              <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(0,$display_order_array) ? 'checked="checked"' : '' ?> name="display_order[]" value="0">Order not processed
															  </label>
                                                              <?php }if(in_array("1",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(1,$display_order_array) == '1' ? 'checked="checked"' : '' ?> name="display_order[]" value="1">Order processed
															  </label>
                                                              <?php }if(in_array("2",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(2,$display_order_array) == '2' ? 'checked="checked"' : '' ?> name="display_order[]" value="2">Order shipped
															  </label>
                                                              <?php }if(in_array("3",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(3,$display_order_array) == '3' ? 'checked="checked"' : '' ?> name="display_order[]" value="3">Order delivered
															  </label>
                                                              <?php }if(in_array("4",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(4,$display_order_array) == '4' ? 'checked="checked"' : '' ?> name="display_order[]" value="4">Order cancelled
															  </label>
                                                              <?php }if(in_array("5",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(5,$display_order_array) == '5' ? 'checked="checked"' : '' ?> name="display_order[]" value="5">Order sattled
															  </label>
                                                              <?php }if(in_array("6",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(6,$display_order_array) == '6' ? 'checked="checked"' : '' ?> name="display_order[]" value="6">Order returned
															  </label>
                                                              <?php }if(in_array("7",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(7,$display_order_array) == '7' ? 'checked="checked"' : '' ?> name="display_order[]" value="7">Order Delivered Returned Sattled
															  </label>
                                                              <?php }if(in_array("8",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(8,$display_order_array) == '8' ? 'checked="checked"' : '' ?> name="display_order[]" value="8">Order Shipped Return
															  </label>
                                                              <?php }if(in_array("9",$display_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['display_order']) && in_array(9,$display_order_array) == '9' ? 'checked="checked"' : '' ?> name="display_order[]" value="9">Order Returned Sattled
															  </label>
                                                              <?php }?>
                                                              </div>      
                                                            </div>
                                                        </div>
                               </div>
                               <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-10 col-md-offset-1 myWell">
                                                              <div class="col-md-6 paddingTop">
                                                                <strong>Update Order Status</strong><br>
                                                                 <small><em>Show and hide order update option</em></small>
                                                              </div>
                                                              <div class="col-md-6">
                                                              <?php
															  if(isset($_POST['update_order']))
															  $update_order_array = explode(",",$_POST['update_order']);
															  
															  if($this->session->userdata('logged_in')=='admin'){
																  $update_order_perimission = array("0","1","2","3","4","5","6","7","8","9");
															  }
															  else{
															  		$perimission = $this->session->userdata('adminPermission');
															  		$update_order_perimission = explode(",",$perimission['update_order']);
															  }
															  if(in_array("0",$update_order_perimission)){
															  ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(0,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="0">Order not processed
															  </label>
                                                              <?php }if(in_array("1",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(1,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="1">Order processed
															  </label>
                                                              <?php }if(in_array("2",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(2,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="2">Order shipped
															  </label>
                                                              <?php }if(in_array("3",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(3,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="3">Order delivered
															  </label>
                                                              <?php }if(in_array("4",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(4,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="4">Order cancelled
															  </label>
                                                              <?php }if(in_array("5",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(5,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="5">Order sattled
															  </label>
                                                              <?php }if(in_array("6",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(6,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="6">Order returned
															  </label>
                                                              <?php }if(in_array("7",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(7,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="7">Order Delivered Returned Sattled
															  </label>
                                                              <?php }if(in_array("8",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(8,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="8">Order Shipped Return
															  </label>
                                                              <?php }if(in_array("9",$update_order_perimission)){ ?>
                                                               <label class="radio">
																		   <input type="checkbox" <?= isset($_POST['update_order']) && in_array(9,$update_order_array) ? 'checked="checked"' : '' ?> name="update_order[]" value="9">Order Returned Sattled
															  </label>
                                                              <?php } ?>
                                                              </div>      
                                                            </div>
                                                        </div>
                               </div>
                             <div class="col-md-6">
															<div class="row">
																<div class="col-md-10 col-md-offset-1 myWell">
																	<div class="col-md-8 paddingTop">
																	<strong>Edit Order</strong><br>
																	 <small><em>Edit Order Permission</em></small>
																  </div>
																  <div class="col-md-4">
																	  <?php
																	  foreach($permissionType as $permission_type){
																	  ?>
																		<label class="radio">
																		   <input type="radio" <?= isset($_POST['edit_order']) && $_POST['edit_order'] == $permission_type['user_permission_type_id'] ? 'checked="checked"' : '' ?> name="edit_order" value="<?php echo $permission_type['user_permission_type_id']?>"><?php echo $permission_type['user_permission_type_name']?>
																		</label>
																	  <?php
																	  }
																	  ?>
																  </div>      
																</div>
															</div>
							</div>
                            <div class="col-md-6">
															<div class="row">
																<div class="col-md-10 col-md-offset-1 myWell">
																	<div class="col-md-8 paddingTop">
																	<strong>Order Invoice</strong><br>
																	 <small><em>Order Invoice Permission</em></small>
																  </div>
																  <div class="col-md-4">
																	  <?php
																	  foreach($permissionType as $permission_type){
																	  ?>
																		<label class="radio">
																		   <input type="radio" <?= isset($_POST['view_invoice']) && $_POST['view_invoice'] == $permission_type['user_permission_type_id'] ? 'checked="checked"' : '' ?> name="view_invoice" value="<?php echo $permission_type['user_permission_type_id']?>"><?php echo $permission_type['user_permission_type_name']?>
																		</label>
																	  <?php
																	  }
																	  ?>
																  </div>      
																</div>
															</div>
							</div>
                            <div class="col-md-6">
															<div class="row">
																<div class="col-md-10 col-md-offset-1 myWell">
																	<div class="col-md-8 paddingTop">
																	<strong>Order Information</strong><br>
																	 <small><em>Order Information Permission</em></small>
																  </div>
																  <div class="col-md-4">
																	  <?php
																	  foreach($permissionType as $permission_type){
																	  ?>
																		<label class="radio">
																		  <input type="radio" <?= isset($_POST['view_more_info']) && $_POST['view_more_info'] == $permission_type['user_permission_type_id'] ? 'checked="checked"' : '' ?> name="view_more_info" value="<?php echo $permission_type['user_permission_type_id']?>"><?php echo $permission_type['user_permission_type_name']?>
																		</label>
																	  <?php
																	  }
																	  ?>
																  </div>      
																</div>
															</div>
							</div>
                         </div>   
                        <input class="btn btn-primary btn-sm" type="submit" name="add_new_level" id="button" value="Add Level">
                        </form>
                         </div>
                    </div>
                </section>
            </div>
            </div>
        </div>
    </div>
</div>
<script>
<?php if (isset($_GET['edit'])) { ?>
        $(document).ready(function () {
            $("#add_edit_users").modal('show');
        });
<?php } ?>
</script>