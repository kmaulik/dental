<footer id="footer">
    <div class="container">
        <div class="row margin-top-60 margin-bottom-40 size-13">
            <!-- col #1 -->
            <div class="col-md-4 col-sm-5">                
                <!-- Footer Logo -->
                <a href="<?=base_url('')?>">
                    <img src="<?= DEFAULT_IMAGE_PATH ?>logo.png" alt="" />
                </a>
                <br/>
                <br/>
                <p>
                    With experts in both dental health and technology, this dental option tool was built with the patient in mind; not only is this tool quick and easy, but it also provides high quality dental care options.
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
                    <!-- <a href="<?=config('youtube_link');?>" class="social-icon social-icon-sm social-icon-border social-youtube pull-left" data-toggle="tooltip" data-placement="top" title="YouTube">
                        <i class="icon-youtube"></i>
                        <i class="icon-youtube"></i>
                    </a> -->
                    <?php endif; ?>
                </div>
                <!-- /Social Icons -->

            </div>
            <!-- /col #1 -->

            <!-- col #1 -->
            <div class="col-md-4 col-sm-3 column2-footer">                 
                <h4 class="letter-spacing-1">EXPLORE US</h4>
                <ul class="list-unstyled footer-list half-paddings noborder">
                    <li><a class="block" href="<?=base_url('who-we-are')?>"><i class="fa fa-angle-right"></i>Who We Are</a></li>                    
                    <li><a class="block" href="<?=base_url('faq')?>"><i class="fa fa-angle-right"></i> FAQ</a></li>
                    <li><a class="block" href="<?=base_url('terms-condition')?>"><i class="fa fa-angle-right"></i> Terms & Conditions</a></li>
                    <li><a class="block" href="<?=base_url('privacy-policy')?>"><i class="fa fa-angle-right"></i> Privacy Policy</a></li>
                </ul>                
            </div>
            <!-- /col #1 -->

            <!-- col #2 -->
            <div class="col-md-4 col-sm-4">
                <h4 class="letter-spacing-1">SECURE PAYMENT</h4>
                <p>
                    Payments on this site are processed securely by PayPal. PayPal uses industry-leading encryption and fraud prevention tools and does not share your financial information with the merchant. After making a payment, you will receive a confirmation email.
                </p>
                <p> <!-- see <?= DEFAULT_IMAGE_PATH ?>/cc/ for more icons -->
                    <img src="<?= DEFAULT_IMAGE_PATH ?>/cc/Visa.png" alt="" />
                    <img src="<?= DEFAULT_IMAGE_PATH ?>/cc/Mastercard.png" alt="" />
                    <img src="<?= DEFAULT_IMAGE_PATH ?>/cc/Maestro.png" alt="" />
                    <img src="<?= DEFAULT_IMAGE_PATH ?>/cc/PayPal.png" alt="" />
                </p>
            </div>
        </div>

    </div>

    <div class="copyright">
        <div class="container">
            <ul class="pull-right nomargin list-inline mobile-block">
                <li><a href="<?=base_url('terms-condition')?>">Terms &amp; Conditions</a></li>
                <li>&bull;</li>
                <li><a href="<?=base_url('privacy-policy')?>">Privacy</a></li>
            </ul>

            © All Rights Reserved, Dental Plans LLC
        </div>
    </div>

</footer>
 
<script>
//     $('body').on('click', function (e) {
//     $('[data-toggle="tooltip"]').each(function () {
//         //the 'is' for buttons that trigger popups
//         //the 'has' for icons within a button that triggers a popup
//         if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.tooltip').has(e.target).length === 0) {
//             $(this).tooltip('hide');
//         }
//     });
// });
</script>
