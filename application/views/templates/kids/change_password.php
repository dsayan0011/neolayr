<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
                    </ol>
                </div><!-- End .container -->
</nav>
<div class="container">
    <div class="row">
    	<div class="col-md-12">
    		 <div class="card">
                                    <div class="card-header">
                                       Reset Your Password
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
                                                <div class="form-group row">
                                                  <label for="pass" class="col-md-4 col-form-label text-md-right">Password</label>
                                                  <div class="col-md-6">
                                                    <input id="pass" type="password" class="form-control " name="pass" required autocomplete="new-password" placeholder="Write More Than 8 Characters.">
                                                  </div>
                                                </div>
                                                <div class="form-group row">
                                                  <label for="pass_repeat" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                                  <div class="col-md-6">
                                                    <input id="pass_repeat" type="password" class="form-control" name="pass_repeat" required autocomplete="new-password" placeholder="Write Same Password Again.">
                                                  </div>
                                                </div>
                                               
                                                <div class="text-center">
                                                  <div class="">
                                                    <button type="submit" class="btn btn-primary" name="update"  id="btncheck"> Update </button>
                                                  </div>
                                                </div>
                                              </form>
                      </div>
        </div>
    </div>
    </div>
    </div>