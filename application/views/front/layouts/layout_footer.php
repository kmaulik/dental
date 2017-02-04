<footer id="footer">
    <div class="container">

        <div class="row margin-top-60 margin-bottom-40 size-13">

            <!-- col #1 -->
            <div class="col-md-4 col-sm-4">

                <!-- Footer Logo -->
                <a href="<?=base_url('')?>"><img class="footer-logo" src="<?= DEFAULT_IMAGE_PATH ?>/logo-footer.png" alt="" /></a>

                <p>
                    Incredibly beautiful responsive Bootstrap Template for Corporate and Creative Professionals.
                </p>

                <h2><?=config('phone');?></h2>

                <!-- Social Icons -->
                <div class="clearfix">
                    <?php if(config('facebook_link') != '') :?>
                        <a href="<?=config('facebook_link');?>" class="social-icon social-icon-sm social-icon-border social-facebook pull-left" data-toggle="tooltip" data-placement="top" title="Facebook">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>
                    <?php endif; ?>
                    <?php if(config('twitter_link') != '') :?>
                    <a href="<?=config('twitter_link');?>" class="social-icon social-icon-sm social-icon-border social-twitter pull-left" data-toggle="tooltip" data-placement="top" title="Twitter">
                        <i class="icon-twitter"></i>
                        <i class="icon-twitter"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(config('gplus_link') != '') :?>
                    <a href="<?=config('gplus_link');?>" class="social-icon social-icon-sm social-icon-border social-gplus pull-left" data-toggle="tooltip" data-placement="top" title="Google plus">
                        <i class="icon-gplus"></i>
                        <i class="icon-gplus"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(config('youtube_link') != '') :?>
                    <a href="<?=config('youtube_link');?>" class="social-icon social-icon-sm social-icon-border social-youtube pull-left" data-toggle="tooltip" data-placement="top" title="YouTube">
                        <i class="icon-youtube"></i>
                        <i class="icon-youtube"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <!-- /Social Icons -->

            </div>
            <!-- /col #1 -->

            <!-- col #2 -->
            <div class="col-md-8 col-sm-8">

                <div class="row">

                    <div class="col-md-5 hidden-sm hidden-xs">
                        <h4 class="letter-spacing-1">RECENT NEWS</h4>
                        <ul class="list-unstyled footer-list half-paddings">
                            <li>
                                <a class="block" href="#">New CSS3 Transitions this Year</a>
                                <small>June 29, 2015</small>
                            </li>
                            <li>
                                <a class="block" href="#">Inteligent Transitions In UX Design</a>
                                <small>June 29, 2015</small>
                            </li>
                            <li>
                                <a class="block" href="#">Lorem Ipsum Dolor</a>
                                <small>June 29, 2015</small>
                            </li>
                            <li>
                                <a class="block" href="#">New CSS3 Transitions this Year</a>
                                <small>June 29, 2015</small>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-3 hidden-sm hidden-xs">
                        <h4 class="letter-spacing-1">EXPLORE US</h4>
                        <ul class="list-unstyled footer-list half-paddings noborder">
                            <li><a class="block" href="#"><i class="fa fa-angle-right"></i> About Us</a></li>
                            <li><a class="block" href="#"><i class="fa fa-angle-right"></i> About Me</a></li>
                            <li><a class="block" href="#"><i class="fa fa-angle-right"></i> About Our Team</a></li>
                            <li><a class="block" href="#"><i class="fa fa-angle-right"></i> Services</a></li>
                            <li><a class="block" href="#"><i class="fa fa-angle-right"></i> Careers</a></li>
                            <li><a class="block" href="#"><i class="fa fa-angle-right"></i> Gallery</a></li>
                            <li><a class="block" href="<?=base_url('faq')?>"><i class="fa fa-angle-right"></i> FAQ</a></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h4 class="letter-spacing-1">SECURE PAYMENT</h4>
                        <p>Donec tellus massa, tristique sit amet condim vel, facilisis quis sapien. Praesent id enim sit amet.</p>
                        <p> <!-- see <?= DEFAULT_IMAGE_PATH ?>/cc/ for more icons -->
                            <img src="<?= DEFAULT_IMAGE_PATH ?>/cc/Visa.png" alt="" />
                            <img src="<?= DEFAULT_IMAGE_PATH ?>/cc/Mastercard.png" alt="" />
                            <img src="<?= DEFAULT_IMAGE_PATH ?>/cc/Maestro.png" alt="" />
                            <img src="<?= DEFAULT_IMAGE_PATH ?>/cc/PayPal.png" alt="" />
                        </p>
                    </div>

                </div>
            </div>
            <!-- /col #2 -->

        </div>

    </div>

    <div class="copyright">
        <div class="container">
            <ul class="pull-right nomargin list-inline mobile-block">
                <li><a href="#">Terms &amp; Conditions</a></li>
                <li>&bull;</li>
                <li><a href="#">Privacy</a></li>
            </ul>

            © All Rights Reserved, Company LTD
        </div>
    </div>

</footer>


<link href="<?= DEFAULT_CSS_PATH ?>custom_scrollbar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'public/front/js/scrollbar.min.js'; ?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
            jQuery('.scrollbar-inner').scrollbar();
        });
</script>