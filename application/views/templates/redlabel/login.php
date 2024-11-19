<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="inner-nav">
    <div class="container">
        <?= lang('home') ?> <span class="active"> > <?= lang('user_login') ?></span>
    </div>
</div>
<div class="login-page container user-page">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-3">
            <div class="loginmodal-container">
            	<div class="theme-card">
                    <h3 class="text-center"><?= lang('login_to_acc') ?></h3>
                    <form class="theme-form" method="POST" action="">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" required="">
                        </div>
                        <div class="form-group">
                            <label for="review">Password</label>
                            <input type="password" class="form-control" id="review" name="pass" placeholder="Enter your password" required="">
                        </div>
                        <input type="submit" name="login" class="btn btn-normal" value="<?= lang('login') ?>">
                       
                       <!-- <a class="float-right txt-default mt-2" href="forget-pwd.html" id="fgpwd">Forgot your password?</a>-->
                    </form>
                    <p class="mt-3">Sign up for a free account at our store. Registration is quick and easy. It allows you to be able to order from our shop. To start shopping click register.</p>
                    <a href="<?= LANG_URL . '/register' ?>" class="txt-default pt-3 d-block">Create an Account</a>
                </div>
            </div>
        </div>
    </div>
</div>