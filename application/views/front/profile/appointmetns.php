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
							<input type="text" placeholder="YYYY-MM-DD" name="birth_date" class="form-control birth_date" value="<?php echo $db_data['birth_date']; ?>">
							<small class="text-muted block">Please Select Date in YYYY-MM-DD Format</small>	
						</div>

						<!-- <div class="form-group">
							<label class="control-label">Address</label>
							<textarea name="address" id="address" class="form-control"><?php echo $db_data['address']; ?></textarea>
						</div> -->

						<div class="margiv-top10">
							<input type="hidden" name="tab" value="info">
							<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>
							<a href="#" class="btn btn-default">Cancel </a>
						</div>
					</form>
				</div>
				<!-- /PERSONAL INFO TAB -->

			</div>
		</div>
		
		<!-- load Partial view for the side bar  -->
		<?php $this->load->view('front/layouts/side_bar_profile'); ?>

	</div>
</section>
<!-- / -->