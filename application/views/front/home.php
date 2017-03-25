<!--<style type="text/css">
	/* Hide the arrows for the revolution slider */
	.tparrows {
		display: none !important;
	}
</style>-->
<!-- REVOLUTION SLIDER -->
<link href="<?= DEFAULT_PLUGINS_PATH ?>slider.revolution/css/extralayers.css" rel="stylesheet" type="text/css" />
<link href="<?= DEFAULT_PLUGINS_PATH ?>slider.revolution/css/settings.css" rel="stylesheet" type="text/css" />

<!-- REVOLUTION SLIDER -->
<div class="slider fullwidthbanner-container roundedcorners">
	<!--
		Navigation Styles:
		
			data-navigationStyle="" theme default navigation
			
			data-navigationStyle="preview1"
			data-navigationStyle="preview2"
			data-navigationStyle="preview3"
			data-navigationStyle="preview4"
			
		Bottom Shadows
			data-shadow="1"
			data-shadow="2"
			data-shadow="3"
			
		Slider Height (do not use on fullscreen mode)
			data-height="300"
			data-height="350"
			data-height="400"
			data-height="450"
			data-height="500"
			data-height="550"
			data-height="600"
			data-height="650"
			data-height="700"
			data-height="750"
			data-height="800"
	-->
	<div class="fullwidthbanner" data-height="600" data-shadow="0" data-navigationStyle="preview1">
		<ul class="hide">

			<!-- SLIDE  -->
			<li data-transition="parallaxtobottom" data-slotamount="7" data-masterspeed="600"  data-saveperformance="off"  data-title="Architectural View">
				<!-- MAIN IMAGE -->
				<div class="overlay dark-1"><!-- dark overlay [0 to 9 opacity] --></div>
				<img src="<?= DEFAULT_IMAGE_PATH ?>demo/n_img_1.jpeg"  alt="cover image"  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
				<div class="tp-caption font-roboto skewfromleft tp-resizeme"
					data-x="50"
					data-y="100" 
					data-speed="500"
					data-start="1500"
					data-easing="Cubic.easeOut"
					data-splitin="none"
					data-splitout="none"
					data-elementdelay="0.1"
					data-endelementdelay="0.1"
					data-endspeed="500"
					style="z-index: 2; color:#fff; font-size:65px; line-height:85px; font-weight:bold; letter-spacing:0; text-shadow:none;">
						<!-- Creating a Bright Future 
						Together -->

						Making Smiles Brighter <br />
						Together
				</div>

				<div class="tp-caption skewfromrightshort tp-resizeme"
					data-x="50"
					data-y="300" 
					data-speed="500"
					data-start="1000"
					data-easing="easeInCirc"
					data-splitin="none"
					data-splitout="none"
					data-elementdelay="0.1"
					data-endelementdelay="0.1"
					data-endspeed="500"
					style="z-index: 3; font-size:20px; color:#fff; font-weight:300; text-shadow:none;">
						<!-- If you dream of designing a new home that takes full advantage, <br />
						our team is the best in this field. -->

						Choose the right dental professional near you to protect your smile.
				</div>

				<div class="tp-caption sfb tp-resizeme"
					data-x="50"
					data-y="410" 
					data-speed="500"
					data-start="1500"
					data-easing="Power3.easeIn"
					data-splitin="none"
					data-splitout="none"
					data-elementdelay="1"
					data-endelementdelay="0.1"
					data-endspeed="500"
					style="z-index: 4; max-width: auto;">
						<a class="btn btn-primary btn-lg" href="#">OUR SERVICES &nbsp; <i class="fa fa-angle-right"></i></a>
				</div>

				<div class="tp-caption sfb tp-resizeme"
					data-x="250"
					data-y="410" 
					data-speed="500"
					data-start="1500"
					data-easing="Power3.easeInOut"
					data-splitin="none"
					data-splitout="none"
					data-elementdelay="0.1"
					data-endelementdelay="0.1"
					data-endspeed="500"
					style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;">
						<a class="btn btn-default btn-lg " href="<?php echo base_url().'registration/user'; ?>"> REQUEST A QUOTE &nbsp; 
							<i class="fa fa-angle-right"></i>
						</a>
				</div>
			</li>

			<!-- SLIDE  -->
			<li data-transition="parallaxtotop" data-slotamount="7" data-masterspeed="300"  data-saveperformance="off" data-title="Bright Future">
				<!-- MAIN IMAGE -->
				<img src="<?= DEFAULT_IMAGE_PATH ?>/demo/thematics/medical/slider_2-min.jpg" alt="cover image"  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

				<div class="overlay dark-1"><!-- dark overlay [0 to 9 opacity] --></div>

				<div class="tp-caption font-roboto skewfromleft tp-resizeme"
					data-x="50"
					data-y="100" 
					data-speed="500"
					data-start="1500"
					data-easing="Cubic.easeOut"
					data-splitin="none"
					data-splitout="none"
					data-elementdelay="0.1"
					data-endelementdelay="0.1"
					data-endspeed="500"
					style="z-index: 2; color:#fff; font-size:65px; line-height:85px; font-weight:bold; letter-spacing:0; text-shadow:none;">
						Making Smiles Brighter <br />
						Together
				</div>

				<div class="tp-caption skewfromrightshort tp-resizeme"
					data-x="50"
					data-y="300" 
					data-speed="500"
					data-start="1000"
					data-easing="easeInCirc"
					data-splitin="none"
					data-splitout="none"
					data-elementdelay="0.1"
					data-endelementdelay="0.1"
					data-endspeed="500"
					style="z-index: 3; font-size:20px; color:#fff; font-weight:300; text-shadow:none;">
						Choose the right dental professional near you to protect your smile.
				</div>

				<div class="tp-caption sfb tp-resizeme"
					data-x="50"
					data-y="410" 
					data-speed="500"
					data-start="1500"
					data-easing="Power3.easeIn"
					data-splitin="none"
					data-splitout="none"
					data-elementdelay="1"
					data-endelementdelay="0.1"
					data-endspeed="500"
					style="z-index: 4; max-width: auto;">
						<a class="btn btn-primary btn-lg" href="#">OUR SERVICES &nbsp; <i class="fa fa-angle-right"></i></a>
				</div>

				<div class="tp-caption sfb tp-resizeme"
					data-x="250"
					data-y="410" 
					data-speed="500"
					data-start="1500"
					data-easing="Power3.easeInOut"
					data-splitin="none"
					data-splitout="none"
					data-elementdelay="0.1"
					data-endelementdelay="0.1"
					data-endspeed="500"
					style="z-index: 6; max-width: auto; max-height: auto; white-space: nowrap;">
						<a class="btn btn-default btn-lg " href="<?php echo base_url().'registration/user'; ?>"> REQUEST A QUOTE &nbsp; 
							<i class="fa fa-angle-right"></i>
						</a>
				</div>
			</li>

		</ul>

	</div>
</div>
<!-- /REVOLUTION SLIDER -->

<hr class="nomargin" /><!-- 1px line separator -->

<!-- BUTTON CALLOUT -->
<!-- <a href="<?php echo base_url().'contact_us'; ?>" class="btn btn-xlg btn-info size-20 fullwidth nomargin noradius padding-40">
	<span class="font-lato size-30">
		Do you have questions? 
		<strong>Contact us &raquo;</strong>
	</span>
</a> -->
<!-- /BUTTON CALLOUT -->


<!-- Overview -->
<section>
	<div class="container">

		<div class="row">

			<div class="col-lg-4 col-md-4 col-sm-12 ">
				<!-- <h2>Health and Medical</h2> -->
				<h2>Find Dental Options in Your Area</h2>
				<p>We spend significant time vetting highly qualified professionals to provide dental plan options tailored to you.</p>
				<a class="btn btn-danger btn-lg" href="<?php echo base_url().'registration/user'; ?>">
					VIEW OUR SERVICES
				</a>
			</div>

			<div class="col-lg-8 col-md-8 col-sm-12 services">
				<h3 class="weight-900"><span><b>What We Can Do for You</b></span></h3>

				<p>
					Our experienced dentists, oral surgeons, orthodontists, and dental hygienists have provided services to 
					hundreds of patients over the years. We work hard to match you with a dental plan to meet your needs. 
					Our online tool makes it easy to select the perfect plan for you and your family – without making a single phone call. 
					Our large and highly vetted pool of dental professionals nationwide make sure you’re getting the best services for your 
					unique requirements. And we’re there too - providing you with the right information needed to select the right dental 
					plan and schedule your appointment.
				</p>
				

				<hr />

				<ul class="list-unstyled list-icons">
					<li><i class="fa fa-check"></i>General Dentistry </li>
					<li><i class="fa fa-check"></i>Extractions & Wisdom Teeth </li>
					<li><i class="fa fa-check"></i>Crowns & Veneers </li>
					<li><i class="fa fa-check"></i>Root Canals </li>
					<li><i class="fa fa-check"></i>Dentures & Partials </li>
					<li><i class="fa fa-check"></i>Teeth Cleaning & Whitening</li>
				</ul>
				<ul class="list-unstyled list-icons">
					<li><i class="fa fa-check"></i>Fillings</li>
					<li><i class="fa fa-check"></i>Pediatric Denistry</li>
					<li><i class="fa fa-check"></i>Implants</li>
					<li><i class="fa fa-check"></i>Teeth Straightening Options</li>
					<li><i class="fa fa-check"></i>Additional Dental Services </li>
				</ul>

			</div>
		</div>

	</div>
</section>
<!-- /Overview -->

<!-- Parallax -->
<section class="parallax parallax-1" style="background-image: url('<?= DEFAULT_IMAGE_PATH ?>demo/n_img_2.jpg');">
	<div class="overlay dark-5"><!-- dark overlay [1 to 9 opacity] --></div>

	<div class="container">

		<div class="text-center">
			<h2 class="size-40 weight-300">Compare Local Dental Options</h2>
			<a class="btn btn-danger btn-lg" href="<?php echo base_url().'registration/user'; ?>">REQUEST A QUOTE</a>
		</div>

	</div>
</section>
<!-- /Parallax -->

<!-- -->
<section>
	<div class="container">
		<div class="row">
		
			<div class="col-md-4">
				
				<div class="heading-title heading-border-bottom heading-color">
					<h3>QUALITY DENTAL SERVICES</h3>
				</div>
				
				<p>
					Finding the best dental professional for you and your family is a challenge. And that’s only what we offer – the best. 
					The YourToothFairy team draws together dental professionals who have spent years working in the dental services industry 
					and have the experience to meet your service standards.
				</p>
				
				<!-- <a href="#">
					Read					
					<span class="word-rotator" data-delay="2000">
						<span class="items">
							<span>more</span>
							<span>now</span>
						</span>
					</span>
					<i class="glyphicon glyphicon-menu-right size-12"></i>
				</a> -->

			</div>

			<div class="col-md-4">
				<div class="heading-title heading-border-bottom heading-color">
					<h3>COMPARE DENTAL PLANS</h3>
				</div>
				<p>					
					Our website evaluates your dental needs, carefully considers dental services, and offers multiple plan options in your 
					area — all while providing optimum service and support at a known cost. Our website allows patients to read service reviews, 
					explore options, and select a plan.
				</p>

				<!-- <a href="#">
					Read					
					<span class="word-rotator" data-delay="2000">
						<span class="items">
							<span>more</span>
							<span>now</span>
						</span>
					</span>
					<i class="glyphicon glyphicon-menu-right size-12"></i>
				</a> -->

			</div>

			<div class="col-md-4">
				<div class="heading-title heading-border-bottom heading-color">
					<h3>SAVE MONEY AND TIME</h3>
				</div>
				<p>
					Not only does our website provide you with many different dental plans and options, but it allows you to quickly 
					and easily compare costs of those dental plans. Matching your unique dental needs directly with a local professional 

					will save you both time and money.
				</p>

				<!-- <a href="#">
					Read					
					<span class="word-rotator" data-delay="2000">
						<span class="items">
							<span>more</span>
							<span>now</span>
						</span>
					</span>
					<i class="glyphicon glyphicon-menu-right size-12"></i>
				</a> -->

			</div>

		</div>
		
	</div>
</section>
<!-- / -->

<!-- <div class="divider divider-border divider-right">
	<i class="fa fa-star-o"></i>
</div> -->

<?php if(!empty($all_testimonials)) {   ?>
	<!-- Testimonials -->
	<section class="padding-xxs dark">
		<div class="container">

			<div class="owl-carousel text-center owl-testimonial nomargin" data-plugin-options='{"singleItem": true, "autoPlay": 3500, "navigation": false, "pagination": true, "transitionStyle":"fade"}'>				
				<?php foreach($all_testimonials as $testimonial) { ?>
					<div class="testimonial">
						<figure>
							<img class="rounded" src="<?php echo base_url().'uploads/testimonial/'.$testimonial['img_path']; ?>" alt="" />
						</figure>
						<div class="testimonial-content nopadding">
							<p class="lead"><?php echo $testimonial['description']; ?></p>
							<cite>
								<?php echo $testimonial['auther']; ?>
								<span><?php echo $testimonial['designation']; ?></span>
							</cite>
						</div>
					</div>
				<?php } ?>				
			</div>

		</div>
	</section>
	<!-- /Testimonials -->
<?php } ?>

<!-- BUTTON CALLOUT -->
<a href="<?php echo base_url().'contact_us'; ?>" class="btn btn-xlg btn-info size-20 fullwidth nomargin noradius padding-40">
	<span class="font-lato size-30">
		Do you have questions? 
		<strong>Contact us &raquo;</strong>
	</span>
</a>
<!-- /BUTTON CALLOUT -->
