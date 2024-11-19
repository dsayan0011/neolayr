<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>My Account</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Account</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="container">
        <div class="row">
        	<div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">my order</a></div>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                    <div class="block-content">
                        <ul>
                           <li > <a href="<?= LANG_URL . '/users/dashboard' ?>"> <?= lang('vendor_dashboard') ?> </a> </li>
                              <li class=""> <a href="<?= LANG_URL . '/users/orders' ?>"> <?= lang('my_order') ?> </a> </li>
                              <li class="active"> <a href="<?= LANG_URL . '/users/profile' ?>"> <?= lang('my_acc') ?> </a> </li>
                              <li class="last"> <a href="<?= LANG_URL . '/users/logout' ?>"> <?= lang('logout') ?> </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
             <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                    	<div class="card">
                                    <div class="card-header">
                                       Account
                                    </div><!-- End .card-header -->

                                    <div class="card-body">
                                    	 <?php 
										   if ($this->session->flashdata('userError')) {
											if (is_array($this->session->flashdata('userError'))) {
												$usr_err = implode('<br>', $this->session->flashdata('userError'));
											} else {
												$usr_err = $this->session->flashdata('userError');
											}
											?>
												<div class="alert alert-danger" role="alert">
												 <?= $usr_err; ?>
												</div>
											<?php
											}
											if ($this->session->flashdata('userSuccess')) {
												if (is_array($this->session->flashdata('userSuccess'))) {
													$usr_err = implode('<br>', $this->session->flashdata('userSuccess'));
												} else {
													$usr_err = $this->session->flashdata('userSuccess');
												}
												?>
													<div class="alert alert-success" role="alert">
													 <?= $usr_err; ?>
													</div>
												<?php
												}
											?>
                                        <form method="POST">
                                          <div class="account-details">
                                            <div class="account clearfix">
                                              <div class="row">
                                                <div class="col-sm-8">
                                                  <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $userInfo['name'];?>" placeholder="Name" required="">
                                                    </div>
                                                    <div class="form-group">
                                                            <label for="phone">Phone</label>
                                                            <input type="text" class="form-control" id="phone" value="<?php echo $userInfo['phone'];?>" name="phone" placeholder="Phone" required="">
                                                   </div>
                                                   <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="text" class="form-control" id="email" value="<?php echo $userInfo['email'];?>" name="email" placeholder="Email" required="">
                                                   </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="password">
                                              <h4>Password</h4>
                                              <div class="row">
                                                <div class="col-sm-8">
                                                  <div class="form-group ">
                                                    <label for="new-password"> New Password </label>
                                                    <input type="password" name="pass" id="pass" class="form-control">
                                                  </div>
                                                  <div class="form-group ">
                                                    <label for="confirm-password"> Confirm Password </label>
                                                    <input type="password" name="pass_repeat" id="pass_repeat" class="form-control">
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <button type="submit" name="update" class="btn btn-solid" data-loading=""> Save Changes </button>
                                        </form>
                                    </div><!-- End .card-body -->
                                </div>
                                
                    </div>
                </div>
             </div>
        </div>
    </div>
</section>