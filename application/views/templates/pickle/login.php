<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= lang('user_login') ?></li>
                    </ol>
                </div><!-- End .container -->
</nav>
<div class="container login-popup">
               <div class="row">
               <?php 
			   if ($this->session->flashdata('userError')) {
				if (is_array($this->session->flashdata('userError'))) {
					$usr_err = implode('<br>', $this->session->flashdata('userError'));
				} else {
					$usr_err = $this->session->flashdata('userError');
				}
				?>
                 <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                     <?= $usr_err; ?>
                    </div>
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
						<div class="col-md-12">
							<div class="alert alert-success sanjay" role="alert">
							 <?= //$usr_err; ?>
							</div>
						</div>
						<?php
				}
				?>
                <div class="col-md-6">
                    <h2 class="title mb-2"><?= lang('user_login') ?></h2>
    
                    <form method="POST" class="mb-1">
                        <label for="email">Email address/ Phone<span class="required">*</span></label>
                        <input type="text" name="email" class="form-input form-wide mb-2" id="email" required="">
    
                        <label for="pass">Password <span class="required">*</span></label>
                        <input type="password" class="form-input form-wide mb-2" name="pass" id="pass" required="">
    
                        <div class="form-footer">
                            <button name="login" type="submit" class="btn btn-primary btn-md">LOGIN</button>
                        </div><!-- End .form-footer -->
                        <a href="<?= LANG_URL . '/forgot-password' ?>" class="forget-password"> Forgot your password?</a>
                        <?php if($facebook_login==1 || $google_login==1){?>
                        <h2 class="title mb-2">Login with your social media account</h2>
                         <div class="social-btn">
                           <?php if($facebook_login==1){?><a href="<?php echo $authUrl;?>" class="btn btn-secondary"><i class="fa fa-facebook"></i>&nbsp; Facebook</a><?php } ?>&nbsp;&nbsp;
                           <?php if($google_login==1){?><a href="<?php echo $loginURL;?>" class="btn btn-secondary"><i class="fa fa-google"></i>&nbsp; Google</a><?php } ?>
                        </div>
                        <?php } ?>
                    </form>
                    
                  
                </div><!-- End .col-md-6 -->
    
                <div class="col-md-6">
                    <h2 class="title mb-2"><?= lang('user_register') ?></h2>
    
                    <form  method="post" action="<?= LANG_URL . '/users/register' ?>">
                    	<input type="hidden" name="redirect" value="<?=$redirect;?>" />
                        <label for="name">Name<span class="required">*</span></label>
                        <input type="text" name="name" class="form-input form-wide mb-2" id="name" required="">
                        
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-input form-wide mb-2" id="email" required="">
    
    					<label for="phone">Phone <span class="required">*</span></label>
                        <input type="text" name="phone" class="form-input form-wide mb-2" id="phone" required="">
                        
                        <label for="pass">Password <span class="required">*</span></label>
                        <input type="password" class="form-input form-wide mb-2" name="pass" id="pass" required="">
                        
                        <label for="pass_repeat">Repeat Password <span class="required">*</span></label>
                        <input type="password" class="form-input form-wide mb-2" name="pass_repeat" id="pass_repeat" required="">
    
                        <div class="form-footer">
                            <button type="submit" name="signup" class="btn btn-primary btn-md">Register</button>
    
                            
                        </div><!-- End .form-footer -->
                    </form>
                </div><!-- End .col-md-6 -->
        </div>
        <?php /*?><div class="social-login-wrapper mb-2">
                        <p>Access your account through  your social networks.</p>
                
                        <div class="btn-group">
                            <a class="btn btn-social-login btn-md btn-gplus mb-1"><i class="icon-gplus"></i><span>Google</span></a>
                            <a class="btn btn-social-login btn-md btn-facebook mb-1"><i class="icon-facebook"></i><span>Facebook</span></a>
                        </div>
       </div><?php */?>
</div>