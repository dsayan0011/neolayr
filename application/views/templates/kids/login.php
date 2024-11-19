<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2><?= lang('user_login') ?></h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= lang('user_login') ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="register-page section-b-space">
    <div class="container">
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
					    <div class="alert alert-success" role="alert">
					     <?= $usr_err; ?>
					    </div>
				    </div>
				    <?php
				}
			?>
            <div class="col-md-6">
                    <h2 class="title mb-2"><?= lang('user_login') ?></h2>
    				<div class="theme-card">
                    <form class="theme-form" method="POST">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="email">Email address/ Phone<span class="required">*</span></label>
                        		<input type="text" name="email" class="form-control" id="email" required="">
                                
                            </div>
                            <div class="col-md-6">
                               <label for="pass">Password <span class="required">*</span></label>
                        	  <input type="password" class="form-control" name="pass" id="pass" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <button name="login" type="submit" class="btn btn-solid">LOGIN</button>
                                 <a href="<?= LANG_URL . '/forgot-password' ?>" class="forget-password"> Forgot your password?</a>
                                 <?php if($facebook_login==1 || $google_login==1){?>
                                <h2 class="title mb-2">Login with your social media account</h2>
                                 <div class="social-btn">
                                   <?php if($facebook_login==1){?><a href="<?php echo $authUrl;?>" class="btn btn-secondary"><i class="fa fa-facebook"></i>&nbsp; Facebook</a><?php } ?>
                                   <?php if($google_login==1){?><a href="<?php echo $loginURL;?>" class="btn btn-danger"><i class="fa fa-google"></i>&nbsp; Google</a><?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            
                        </div>
                    </form>
                </div>
                
                  
                </div>
                <div class="col-md-6">
                    <h2 class="title mb-2"><?= lang('user_register') ?></h2>
    				<div class="theme-card">
                    <form class="theme-form"  method="post" action="<?= LANG_URL . '/users/register' ?>">
                    	<input type="hidden" name="redirect" value="<?=$redirect;?>" />
                    	<div class="form-row">
                            <div class="col-md-6">
                                <input type="hidden" name="redirect" value="<?=$redirect;?>" />
                                <label for="name">Name<span class="required">*</span></label>
                                <input type="text" name="name" class="form-control" id="name" required="">
                            </div>
                            <div class="col-md-6">
                            	<label for="email">Email <span class="required">*</span></label>
                        		<input type="email" name="email" class="form-control" id="email" required="">
                             </div>
                       </div>
                       <div class="form-row">
                       		<div class="col-md-6">
                            	<label for="phone">Phone <span class="required">*</span></label>
                       			<input type="text" name="phone" class="form-control" id="phone" required="">
                            </div>
                            <div class="col-md-6">
                            	 <label for="pass">Password <span class="required">*</span></label>
                        		 <input type="password" class="form-control" name="pass" id="pass" required="">
                            </div>
                       </div>
                       <div class="form-row">
                       		<div class="col-md-6">
                       		 <label for="pass_repeat">Repeat Password <span class="required">*</span></label>
                        	 <input type="password" class="form-control" name="pass_repeat" id="pass_repeat" required="">
                           </div>
                       </div>
                        <div class="form-row">
                        	 <button type="submit" name="signup" class="btn btn-solid">Register</button>
                        </div>
                    </form>
                    </div>
                </div>
        </div>
    </div>
</section>