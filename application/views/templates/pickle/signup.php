<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="inner-nav">
  <div class="container"> <a href="<?= LANG_URL ?>">
    <?= lang('home') ?>
    </a> <span class="active"> >
    <?= lang('user_register') ?>
    </span> </div>
</div>
<div class="container user-page">
  <div class="row">
    <div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-3">
      <div class="login-page loginmodal-container">
        <div class="theme-card">
                    <h3 class="text-center"><?= lang('user_register') ?></h3>
                    <form class="theme-form" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" required="">
                        </div>
                         <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required="">
                        </div>
                         <div class="form-group">
                            <label for="pass_repeat">Password repeat</label>
                            <input type="password" class="form-control" id="pass_repeat" name="pass_repeat" placeholder="Password repeat" required="">
                        </div>
                        <input type="submit" name="signup" class="btn btn-normal" value="<?= lang('register_me') ?>">
                       
                       <!-- <a class="float-right txt-default mt-2" href="forget-pwd.html" id="fgpwd">Forgot your password?</a>--><br /><br />
                        <p>Have you already account? <a href="<?= LANG_URL . '/login' ?>" class="txt-default">click</a> here to &nbsp;<a href="<?= LANG_URL . '/login' ?>" class="txt-default">Login</a></p>
                    </form>
                </div>
                
      </div>
    </div>
  </div>
</div>
