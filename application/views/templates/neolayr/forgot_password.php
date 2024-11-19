<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>Reset Password</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('users/login');?>">Login</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="register-page section-b-space">
    <div class="container">
        <div class="row">
        		<div class="col-lg-6 offset-lg-3">
                
               <div class="theme-card">
               <h2>Forget Your Password?</h2>
                <h4>We will send you a link to reset your password.</h4>
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
                <form class="theme-form" method="post">
                    <div class="form-row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter Your Email" required="">
                      	</div>
                    </div>
                    <div class="form-row">
                    	<button type="submit" name="forgot_pass" style="margin:0px auto" class="btn btn-solid"> Send Reset Link </button>
                    </div>
                </form>
             </div>
            </div>
        </div>
    </div>
</section>
