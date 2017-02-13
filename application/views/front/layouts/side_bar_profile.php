<?php
	$controller_name = $this->router->fetch_class();
	$method_name = $this->router->fetch_method();
?>
<!-- LEFT -->
<div class="col-lg-3 col-md-3 col-sm-4 col-lg-pull-9 col-md-pull-9 col-sm-pull-8">

	<div class="thumbnail text-center">				
		<?php if($db_data['avatar'] == '') { ?>
			<img src="<?php echo base_url(); ?>uploads/default/no_image_found.jpg" alt="" />
		<?php }else{ ?>
			<img src="<?php echo base_url(); ?>uploads/avatars/<?= $db_data['avatar'] ?>" alt="" />
		<?php } ?>

		<h2 class="size-18 margin-top-10 margin-bottom-0"><?php echo $db_data['fname'].' '.$db_data['lname']; ?></h2>
		<!-- <h3 class="size-11 margin-top-0 margin-bottom-10 text-muted">DEVELOPER</h3> -->
	</div>			 

	<!-- SIDE NAV -->
	<ul class="side-nav list-group margin-bottom-60" id="sidebar-nav">
		<li class="list-group-item <?php if($method_name == 'edit_profile'){ echo 'active'; } ?>">
			<a href="<?php echo base_url().'dashboard/edit_profile';?>">
				<i class="fa fa-eye"></i>
				PROFILE
			</a>
		</li>
		
		<!-- Only for the Doctors Login - RFP Bids -->
		<li class="list-group-item <?php if($method_name == 'rfp_bids'){ echo 'active'; } ?>">
			<a href="<?php echo base_url().'dashboard/rfp_bids'; ?>">
				<i class="fa fa-gears"></i>
				RFP Bids
			</a>
		</li>

		<!-- Only for the Doctors Login - RFP Bids -->
		<li class="list-group-item <?php if($method_name == 'rfp_alert'){ echo 'active'; } ?>">
			<a href="<?php echo base_url().'dashboard/rfp_alert'; ?>">
				<i class="fa fa-gears"></i>
				RFP Alerts Setting
			</a>
		</li>

	</ul>
	<!-- /SIDE NAV -->


	<!-- info -->
	<div class="box-light margin-bottom-30"><!-- .box-light OR .box-light -->
		<div class="row margin-bottom-20">
			<div class="col-md-4 col-sm-4 col-xs-4 text-center bold">
				<h2 class="size-30 margin-top-10 margin-bottom-0 font-raleway">12</h2>
				<h3 class="size-11 margin-top-0 margin-bottom-10 text-info">PROJECTS</h3>
			</div>

			<div class="col-md-4 col-sm-4 col-xs-4 text-center bold">
				<h2 class="size-30 margin-top-10 margin-bottom-0 font-raleway">34</h2>
				<h3 class="size-11 margin-top-0 margin-bottom-10 text-info">TASKS</h3>
			</div>

			<div class="col-md-4 col-sm-4 col-xs-4 text-center bold">
				<h2 class="size-30 margin-top-10 margin-bottom-0 font-raleway">32</h2>
				<h3 class="size-11 margin-top-0 margin-bottom-10 text-info">UPLOADS</h3>
			</div>
		</div>
		<!-- /info -->

		<div class="text-muted">
			<h2 class="size-18 text-muted margin-bottom-6"><b>About</b> Felicia Doe</h2>
			<p>Lorem ipsum dolor sit amet diam nonummy nibh dolore.</p>					
			<ul class="list-unstyled nomargin">
				<li class="margin-bottom-10"><i class="fa fa-globe width-20 hidden-xs hidden-sm"></i> <a href="http://www.stepofweb.com">www.stepofweb.com</a></li>
				<li class="margin-bottom-10"><i class="fa fa-facebook width-20 hidden-xs hidden-sm"></i> <a href="http://www.facebook.com/stepofweb">stepofweb</a></li>
				<li class="margin-bottom-10"><i class="fa fa-twitter width-20 hidden-xs hidden-sm"></i> <a href="http://www.twitter.com/stepofweb">@stepofweb</a></li>
			</ul>
		</div>
	
	</div>
</div>