<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>contact</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="contact-page section-b-space pb-0">
    <div class="container">
        <div class="row section-b-space">
         	
            <div class="col-lg-7 map">
           		 <?php
                if ($this->session->flashdata('resultSend')) {
                    ?>
                    <hr>
                    <div class="alert alert-info"><?= $this->session->flashdata('resultSend') ?></div>
                    <hr>
                <?php }
                ?>
                <form class="theme-form" method="post">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="name">Name</label>
                           <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required="required" />
                        </div>
                        <div class="col-md-12">
                            <label for="email">Email</label>
                             <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required="required" />
                        </div>
                        <div class="col-md-12">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" class="form-control" >
                        </div>
                         <div class="col-md-12">
                            <label for="subject">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" required="required">
                        </div>
                        <div class="col-md-12">
                            <label for="review">Write Your Message</label>
                            <textarea required="required" class="form-control" placeholder="Write Your Message" id="message" name="message" rows="6"></textarea>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-solid" type="submit">Send Your Message</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="contact-right">
                    <ul>
                    	 <?php if ($footerContactPhone != '') { ?>
                        <li>
                            <div class="contact-icon"><i class="fa fa-phone" aria-hidden="true"></i>
                                <h6>Call Us</h6></div>
                            <div class="media-body">
                                <?= $footerContactPhone ?>
                            </div>
                        </li>
                         <?php } if ($footerContactEmail != '') { ?>
                        <li>
                            <div class="contact-icon"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <h6>Email</h6></div>
                            <div class="media-body">
                               <?= $footerContactEmail ?>
                            </div>
                        </li>
                        <?php } if ($footerContactAddr != '') { ?>
                        <li>
                            <div class="contact-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                <h6>Address</h6></div>
                            <div class="media-body">
                               <?= $footerContactAddr ?>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
    </div>
    <div class="container-fluid map px-0">
        <iframe class="border-0 " src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1605.811957341231!2d25.45976406005396!3d36.3940974010114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1550912388321"></iframe>
    </div>
</section>