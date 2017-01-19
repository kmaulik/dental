<!-- FOOTER -->
<footer id="footer">
    <div class="container">


        <div class="row">

            <!-- col #1 -->
            <div class="col-md-8">

                <h3 class="letter-spacing-1">WHY US?</h3>

                <!-- Small Description -->
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet hendrerit volutpat. Sed in nunc nec ligula consectetur mollis in vel justo. Vestibulum ante ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet hendrerit volutpat.
                </p>
                <h2><?=config('phone');?></h2>
            </div>
            <!-- /col #1 -->

            <!-- col #2 -->
           <!--  <div class="col-md-4">
                <h3 class="letter-spacing-1">KEEP IN TOUCH</h3>

                
                <p>Subscribe to Our Newsletter to get Important News & Offers</p>

                <form class="validate" action="php/newsletter.php" method="post" data-success="Subscribed! Thank you!" data-toastr-position="bottom-right">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control required" placeholder="Enter your Email">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="submit">Subscribe</button>
                        </span>
                    </div>
                </form>
              


            </div> -->
            <!-- /col #2 -->

        </div>


    </div>

    <div class="copyright">
        <div class="container">
            <ul class="pull-right nomargin list-inline mobile-block">
                <li><a href="<?=base_url('terms-condition')?>">Terms &amp; Conditions</a></li>
                <li>&bull;</li>
                <li><a href="<?=base_url('privacy-policy')?>">Privacy</a></li>
            </ul>
            <?=config('copy_right');?>
        </div>
    </div>

</footer>
            <!-- /FOOTER -->