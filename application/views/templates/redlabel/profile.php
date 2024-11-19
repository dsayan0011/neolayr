<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="inner-nav">
  <div class="container">
     <ul class="list-inline">
            <li><a href="<?= LANG_URL ?>"><i class="fa fa-home" aria-hidden="true"></i></a> > </li>
			<li class="active"><?= lang('my_acc') ?></li>
      </ul>
  </div>
</div>
<div class="container user-page">
  <div class="row">
    <div class="col-sm-3">
      <div class="my-account loginmodal-container">
        <h1>
          <div class="sidebar-menu">
            <ul class="list-inline">
              <li class=""> <a href="<?= LANG_URL . '/users/dashboard' ?>"> <i class="fa fa-dashboard" aria-hidden="true"></i>
                <?= lang('vendor_dashboard') ?>
                </a> </li>
              <li> <a href="<?= LANG_URL . '/users/orders' ?>"> <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                <?= lang('my_order') ?>
                </a> </li>
              <li class="active"> <a href="<?= LANG_URL . '/users/profile' ?>"> <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                <?= lang('my_acc') ?>
                </a> </li>
              <li> <a href="<?= LANG_URL . '/users/logout' ?>"> <i class="fa fa-sign-out" aria-hidden="true"></i>
                <?= lang('logout') ?>
                </a> </li>
            </ul>
          </div>
        </h1>
        <br>
      </div>
    </div>
    <div class="col-sm-9">
      <div class="content-right clearfix">
        <form method="POST">
          <div class="account-details">
            <div class="account clearfix">
              <h4>Account</h4>
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
          <button type="submit" name="update" class="btn btn-primary" data-loading=""> Save Changes </button>
        </form>
      </div>
    </div>
  </div>
</div>
