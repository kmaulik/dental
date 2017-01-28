<!-- 
	PAGE HEADER 
	
	CLASSES:
		.page-header-xs	= 20px margins
		.page-header-md	= 50px margins
		.page-header-lg	= 80px margins
		.page-header-xlg= 130px margins
		.dark			= dark page header

		.shadow-before-1 	= shadow 1 header top
		.shadow-after-1 	= shadow 1 header bottom
		.shadow-before-2 	= shadow 2 header top
		.shadow-after-2 	= shadow 2 header bottom
		.shadow-before-3 	= shadow 3 header top
		.shadow-after-3 	= shadow 3 header bottom
-->
<section class="page-header page-header-xs">
	<div class="container">

		<!-- breadcrumbs -->
		<ol class="breadcrumb breadcrumb-inverse">
			<li><a href="#">Home</a></li>
			<li><a href="#">Edit Profile</a></li>
			<li class="active"><?php echo $db_data['fname'].' '.$db_data['lname']; ?></li>
		</ol><!-- /breadcrumbs -->

	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section>
	<div class="container">
		<!-- ALERT -->
		<?php if($this->session->flashdata('success')) : ?>
		<div class="alert alert-mini alert-success margin-bottom-30">
			<?=$this->session->flashdata('success');?>
		</div>
		<?php endif; ?>
		<?php if($this->session->flashdata('error')) : ?>
		<div class="alert alert-mini alert-danger margin-bottom-30">
			<?=$this->session->flashdata('error');?>
		</div>
		<?php endif; ?>
		<!-- /ALERT -->

		<!-- RIGHT -->
		<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 margin-bottom-80">

			<ul class="nav nav-tabs nav-top-border">
				<li class="<?php if($tab == 'info'){ echo 'active'; }?>"><a href="#info" data-toggle="tab">Personal Info</a></li>
				<li class="<?php if($tab == 'avatar'){ echo 'active'; }?>"><a href="#avatar" data-toggle="tab">Avatar</a></li>
				<li class="<?php if($tab == 'password'){ echo 'active'; }?>"><a href="#password" data-toggle="tab">Password</a></li>
				<li class="<?php if($tab == 'privacy'){ echo 'active'; }?>"><a href="#privacy" data-toggle="tab">Privacy</a></li>
			</ul>
			
			<div class="tab-content margin-top-20">				

				<!-- PERSONAL INFO TAB -->
				<div class="tab-pane fade <?php if($tab == 'info'){ echo 'in active'; }?>" id="info">
					<?php 
						$all_errors = validation_errors('<li>','</li>');
						if($all_errors != '' && $tab == 'info') { 
					?>
						<div class="alert alert-mini alert-danger">				
							<ul>							
								<?php echo $all_errors; ?>
							</ul>
						</div>
					<?php } ?>

					<form role="form"  method="post">
						<div class="form-group">
							<label class="control-label">First Name</label>
							<input type="text" placeholder="First name" name="fname" class="form-control" value="<?php echo $db_data['fname']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Last Name</label>
							<input type="text" placeholder="Last name" name="lname" class="form-control" value="<?php echo $db_data['lname']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Email ID</label>
							<input type="text" placeholder="Email ID" name="email_id" readonly class="form-control" value="<?php echo $db_data['email_id']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">City</label>
							<input type="text" placeholder="City" name='city' class="form-control" value="<?php echo $db_data['city']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Country</label>							
							<select name="country_id" class="form-control select2" id="country_id">
								<option value="" selected disabled>Select Country</option>
								<?php foreach($country_list as $country) : ?>
									<option value="<?=$country['id']?>" <?php echo  set_select('country_id', $country['id']); ?> >
										<?=$country['name']?>
									</option>
								<?php endforeach; ?>
							</select>	
						</div>

						<div class="form-group">
							<label class="control-label">Zipcode</label>
							<input type="text" placeholder="zipcode" name="zipcode" class="form-control" value="<?php echo $db_data['zipcode']; ?>">
						</div>

						<div class="form-group">
							<label class="control-label">Gender</label>
							<select name="gender" id="" class="form-control">
								<option value="male" <?php if($db_data['gender']=='male'){ echo 'selected'; } ?>>Male</option>
								<option value="female" <?php if($db_data['gender']=='female'){ echo 'selected'; } ?> >Female</option>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Phone No</label>
							<input type="text" placeholder="zipcode" name="phone" class="form-control" value="<?php echo $db_data['phone']; ?>">
						</div>

						<div class="form-group">
							<label class="control-label">Birth Date</label>
							<input type="text" placeholder="Birth Date" name="birth_date" class="form-control birth_date" value="<?php echo $db_data['birth_date']; ?>">
						</div>

						<div class="form-group">
							<label class="control-label">Address</label>
							<textarea name="address" id="address" class="form-control"><?php echo $db_data['address']; ?></textarea>
						</div>

						<div class="margiv-top10">
							<input type="hidden" name="tab" value="info">
							<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>
							<a href="#" class="btn btn-default">Cancel </a>
						</div>
					</form>
				</div>
				<!-- /PERSONAL INFO TAB -->

				<!-- AVATAR TAB -->
				<div class="tab-pane fade <?php if($tab == 'avatar'){ echo 'in active'; }?>" id="avatar">

					<form class="clearfix"  method="post" enctype="multipart/form-data">
						<div class="form-group">
							<div class="row">
								<div class="col-md-9 col-sm-8">
									<div class="sky-form nomargin">
										<label class="label">Select File</label>
										<label for="file" class="input input-file">
											<div class="button">
												<input type="file" id="file" name="img_avatar"
													  onchange="this.parentNode.nextSibling.value = this.value">
													  Browse
											</div>
											<input type="text" readonly id="img_text">
										</label>
									</div>
									
									<?php if($db_data['avatar'] != '') { ?>
										<a href="<?php echo base_url().'dashboard/remove_avatar/'.encode($db_data['id']); ?>" class="btn btn-danger btn-xs noradius">
											<i class="fa fa-times"></i>
											Remove Avatar
										</a>
									<?php } ?>

									<div class="clearfix margin-top-20">
										<span class="label label-warning">NOTE! </span>
										<p>
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt laoreet!
										</p>
									</div>

								</div>

							</div>

						</div>

						<div class="margiv-top10">
							<input type="hidden" name="tab" value="avatar">
							<button type="submit" class="btn btn-primary">Save Changes </button>
							<a href="#" class="btn btn-default">Cancel </a>
						</div>

					</form>

				</div>
				<!-- /AVATAR TAB -->

				<!-- PASSWORD TAB -->
				<div class="tab-pane fade <?php if($tab == 'password'){ echo 'in active'; }?>" id="password">

					<form  method="post">

						<div class="form-group">
							<label class="control-label">Current Password</label>
							<input type="password" name="current_password" class="form-control">
						</div>

						<div class="form-group">
							<?php echo form_error('current_password','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>

						<div class="form-group">
							<label class="control-label">New Password</label>
							<input type="password" class="form-control" name="password">
						</div>

						<div class="form-group">
							<?php echo form_error('password','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>

						<div class="form-group">
							<label class="control-label">Re-type New Password</label>
							<input type="password" class="form-control" name="re_password">
						</div>

						<div class="form-group">
							<?php echo form_error('re_password','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>

						<div class="margiv-top10">
							<input type="hidden" name="tab" value="password">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-check"></i>
								Change Password
							</button>
							<a href="#" class="btn btn-default">Cancel </a>
						</div>

					</form>

				</div>
				<!-- /PASSWORD TAB -->

				<!-- PRIVACY TAB -->
				<div class="tab-pane fade <?php if($tab == 'privacy'){ echo 'in active'; }?>" id="privacy">

					<form  method="post">
						<div class="sky-form">

							<table class="table table-bordered table-striped">
								<tbody>
									<tr>
										<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
										<td>
											<div class="inline-group">
												<label class="radio nomargin-top nomargin-bottom">
													<input type="radio" name="radioOption" checked=""><i></i> Yes
												</label>

												<label class="radio nomargin-top nomargin-bottom">
													<input type="radio" name="radioOption" checked=""><i></i> No
												</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
										<td>
											<label class="checkbox nomargin">
												<input type="checkbox" name="checkbox" checked=""><i></i> Yes
											</label>
										</td>
									</tr>
									<tr>
										<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
										<td>
											<label class="checkbox nomargin">
												<input type="checkbox" name="checkbox" checked=""><i></i> Yes
											</label>
										</td>
									</tr>
									<tr>
										<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
										<td>
											<label class="checkbox nomargin">
												<input type="checkbox" name="checkbox" checked=""><i></i> Yes
											</label>
										</td>
									</tr>
								</tbody>
							</table>

						</div>

						<div class="margin-top-10">
							<a href="#" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </a>
							<a href="#" class="btn btn-default">Cancel </a>
						</div>

					</form>

				</div>
				<!-- /PRIVACY TAB -->

			</div>

		</div>

		
		<!-- LEFT -->
		<div class="col-lg-3 col-md-3 col-sm-4 col-lg-pull-9 col-md-pull-9 col-sm-pull-8">
		
			<div class="thumbnail text-center">				
				<?php if($db_data['avatar'] == '') { ?>
					<img src="<?php echo base_url(); ?>uploads/default/no_image_found.jpg" alt="" />
				<?php }else{ ?>
					<img src="<?php echo base_url(); ?>uploads/avatars/<?= $db_data['avatar'] ?>" alt="" 
						 onerror="this.src='<?php echo base_url().'uploads/default/no_image_found.jpg'; ?>'" />
				<?php } ?>

				<h2 class="size-18 margin-top-10 margin-bottom-0"><?php echo $db_data['fname'].' '.$db_data['lname']; ?></h2>
				<!-- <h3 class="size-11 margin-top-0 margin-bottom-10 text-muted">DEVELOPER</h3> -->
			</div>			 

			<!-- SIDE NAV -->
			<ul class="side-nav list-group margin-bottom-60" id="sidebar-nav">
				<li class="list-group-item"><a href="page-profile.html"><i class="fa fa-eye"></i> PROFILE</a></li>				
				<li class="list-group-item active"><a href="page-profile-settings.html"><i class="fa fa-gears"></i> SETTINGS</a></li>				
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
		
	</div>
</section>
<!-- / -->

<script type="text/javascript">
	document.getElementById('file').onchange = function () { $('#img_text').val(this.value); };
	$('#country_id').val("<?php echo $db_data['country_id']; ?>");	
</script>