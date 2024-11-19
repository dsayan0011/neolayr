<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <section class="breadcrumb-section section-b-space">
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
                                    </div>

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
                                    </div>
                                </div>
                                
                    </div>
                </div>
             </div>
        </div>
    </div>
</section> -->

<main>
            <!-- PERSONAL INFO PAGE -->
            <section class="personal-info">
                <div class="container">
                    <div class="personal-information text-center">
                        <div class="personal-info-image mx-auto">
                            <img src="<?= base_url('images/user-5.png') ?>" border="0" alt="">
                        </div>
                        <p>Hello</p>
                        <h2><?php echo $userInfo['name'];?></h2>
                    </div>
                    <div class="personal-info-detailed-content row no-gutters flex-row-reverse">
                        
                        <div class="personal-info-detailed-content-right col-lg-8">
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
                            <div class="label-area d-flex alway-dflex justify-content-between mb-0">
                                <h4>Personal Information</h4>
                                <div class="edit-area d-flex">
                                    <!-- <div class="d-flex align-items-center">
                                        <a href="password-edit.html"><img src="<?= base_url('images/editing-1-copy-3.png') ?>" border="0" alt="">change password</a>
                                    </div> -->
                                    <div class="d-flex align-items-center ">
                                        <a href="<?= LANG_URL . '/edit-personal-info'.'/'.$userInfo['id'] ?>"><img src="<?= base_url('images/editing-1.png') ?>" width="26" height="26" border="0" alt="">EDIT</a>
                                    </div>
                                </div>
                            </div>
                            <div class="personal-info-content label-area mb-5">
                                <table>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>&nbsp;<?php echo $userInfo['name'];?>&nbsp;<?php echo $userInfo['last_name'];?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mobile:</strong></td>
                                        <td>&nbsp;<?php echo $userInfo['phone'];?></td>
                                    </tr>
                                    <?php if($userInfo['dob'] != '0000-00-00'){?>
                                    <tr>
                                        <td><strong>Date of Birth:</strong></td>
                                        <td>&nbsp;<?php echo date("d-m-Y", strtotime($userInfo['dob'])); ?></td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td><strong>Gender:</strong></td>
                                        <td>&nbsp;<?php echo $userInfo['gender']; ?></td>
                                    </tr>
                                     <?php if($userInfo['marital_status'] != ''){?>
                                    <tr>
                                        <td><strong>Marital status:</strong></td>
                                        <td>&nbsp;<?php echo $userInfo['marital_status'];?></td>
                                    </tr>
                                     <?php } ?>
                                    <?php if($userInfo['anniversary'] != '0000-00-00'){?>
                                    <tr>
                                        
                                        <td><strong>Anniversary Date:</strong></td>
                                        <td>&nbsp;<?php echo date("d-m-Y", strtotime($userInfo['anniversary'])); ?></td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>&nbsp;<?php echo $userInfo['email'];?></td>
                                    </tr>
                                </table>
                            </div>
                            <?php if($addressInfo['first_name'] != ''){?>
                            <div class="label-area d-flex justify-content-between mb-0">
                                <h4>Primary Address</h4>
                            </div>
                            <div class="personal-info-content mb-5">
                                <table>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>&nbsp;<?php echo $addressInfo['first_name'];?> <?php echo $addressInfo['last_name'];?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td>&nbsp;<?php echo $addressInfo['address'];?>, <?php echo $addressInfo['road_name'];?></td>
                                    </tr>
                                    <!-- <tr>
                                        <td><strong>Country:</strong></td>
                                        <td>&nbsp;India</td>
                                    </tr> -->
                                    <tr>
                                        <td><strong>State:</strong></td>
                                        <td>&nbsp;<?php echo $addressInfo['state_name'];?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>City:</strong></td>
                                        <td>&nbsp;<?php echo $addressInfo['name'];?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pincode:</strong></td>
                                        <td>&nbsp;<?php echo $addressInfo['post_code'];?></td>
                                    </tr>
                                </table>
                            </div>
                        <?php } ?>
                            <!-- <form method="POST">
                            <div class="each-feild">
                                <lable class="info-label-style">Name</lable>
                                <input type="text" id="name" name="name" class="input-style" placeholder="Name" value="<?php echo $userInfo['name'];?>" />
                            </div>
                            <div class="each-feild gender-feild">
                                <lable class="info-label-style">Gender</lable>
                                <input type="radio" name="gender" value="Male" <?php if($userInfo['gender'] == 'Male') echo 'checked'; ?>>
                                <label for="Male" class="gender-choose">Male</label>
                                <input type="radio" name="gender" value="Female" <?php if($userInfo['gender'] == 'Female') echo 'checked'; ?>>
                                <label for="female" class="gender-choose">Female</label>
                                <input type="radio" name="gender" value="Others" <?php if($userInfo['gender'] == 'Others') echo 'checked'; ?>>
                                <label for="others" class="gender-choose">Others</label>
                            </div>
                            <div class="each-feild">
                                <lable class="info-label-style">Email</lable>
                                <input type="text" class="input-style" placeholder="amritapaul@gmail.com" id="email" name="email" value="<?php echo $userInfo['email'];?>" />
                            </div>
                            <div class="each-feild">
                                <lable class="info-label-style">Mobile Number</lable>
                                <input type="text" class="input-style" name="phone" id="phone" placeholder="8462540156" value="<?php echo $userInfo['phone'];?>" />
                            </div>
                            <div class="each-feild">
                                <button type="submit" name="update" data-loading="" class="gn-button small">Submit</button>
                            </div>
                        </form> -->
                        </div>
                        <div class="personal-info-detailed-content-left col-lg-4">
                            <ul>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                                    <ul style="display:block">
                                        <li class="active"><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
                                        <li><a href="<?= LANG_URL . '/manage-address' ?>">Manage address</a></li>
                                    </ul>
                                </li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy.png') ?>" width="25" height="25" border="0" alt=""></span>Order history</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/orders' ?>"> MY ORDERS</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= LANG_URL . '/users/wishlist' ?>"><span><img src="<?= base_url('images/user-6-copy-4.png') ?>" width="23" height="21" border="0" alt=""></span>Wishlist</a></li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy-6.png') ?>" width="23" height="23" border="0" alt=""></span>Rewards</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
                                        <li><a href="<?= LANG_URL . '/refer-friend' ?>">Refer friends</a></li>
                                    </ul>
                                </li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="25" border="0" alt=""></span>Gift Voucher</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/gift' ?>">Gift Card</a></li>
                                        <li><a href="<?= LANG_URL . '/gift-card-details' ?>">Gift Card Details</a></li>
                                    </ul>
                                </li>
                                <!-- <li><a href="<?= LANG_URL . '/users/gift' ?>"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="23" border="0" alt=""></span>Gift Voucher</a></li> -->
                                <li><a href="<?= LANG_URL . '/users/logout' ?>"><span><img src="<?= base_url('images/user-6-copy-8.png') ?>" width="21" height="23" border="0" alt=""></span>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END:PERSONAL INFO PAGE -->
            
        </main>