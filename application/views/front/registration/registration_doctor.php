<section class="page-header page-header-xs">
	<div class="container">
		<h1>Doctor Registration</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">			
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Doctor Registration</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">
			<!-- LOGIN -->
			<div class="col-md-12">
				<!-- ALERT -->
				<?php if($this->session->flashdata('error')) : ?>
					<div class="alert alert-mini alert-danger margin-bottom-30">
						<?=$this->session->flashdata('error');?>
					</div>
				<?php endif; ?>
				<!-- /ALERT -->

				<?php 
					$all_errors = validation_errors('<li>','</li>');
					if($all_errors != '') { 
				?>
					<div class="alert alert-mini alert-danger">				
						<ul>							
							<?php echo $all_errors; ?>
						</ul>
					</div>
				<?php } ?>

				<!-- login form -->
				<form method="post" action="" id="frmregister">

					<input type="hidden" name="role_id" value="4">  <!-- 4 => Doctor Role -->

					<div class="form-group">
						<input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo set_value('fname'); ?>" >
					</div>

					<div class="form-group">
						<input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo set_value('lname'); ?>" >
					</div>

					<!-- Email -->
					<div class="form-group">
						<input type="text" name="email_id" class="form-control" placeholder="Email" value="<?php echo set_value('email_id'); ?>" >
					</div>						

					<!-- Password -->
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>">
					</div>						

					<div class="form-group">
						<input type="password" name="c_password" class="form-control" placeholder="Confirm Password" value="<?php echo set_value('c_password'); ?>">
					</div>						

					<div class="form-group">
						<input type="text" name="city" class="form-control" placeholder="City" value="<?php echo set_value('city'); ?>" >
					</div>						

					<div class="form-group">
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
						<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip code" value="<?php echo set_value('zipcode'); ?>" >
					</div>					

					<div class="form-group">
						<select name="gender" class="form-control" id="gender">							
							<option value="male" <?php echo  set_select('gender', 'male', TRUE); ?> >Male</option>
							<option value="female" <?php echo  set_select('gender', 'female'); ?>>Female</option>							
						</select>		
					</div>

					<div class="form-group">
						<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo set_value('phone'); ?>" >
					</div>					

					<div class="form-group">
						<input type="text" id="birth_date" name="birth_date" placeholder="YYYY-MM-DD" class="form-control birth_date" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" value="<?php echo set_value('birth_date'); ?>" readonly>
						<small class="text-muted block">Please Select Date in YYYY-MM-DD Format</small>	
					</div>					
					<div class="form-group address-box">
						<textarea rows="4" name="address" class="form-control" placeholder="Your Address"><?php echo set_value('address'); ?></textarea>
					</div>						

					<div class="margin-top-30">
						<label class="checkbox nomargin"><input class="checked-agree" type="checkbox" name="agree"><i></i>I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms of Service</a></label>
					</div>
				 
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<!-- Inform Tip -->                                        
							<div class="form-tip margin-top-10">
								Already have an account? <a href="<?=base_url('login')?>"><strong>Back to login!</strong></a>
							</div>
						</div>
					</div>
														
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right register-btn">
							<button type="submit" class="btn btn_custom"><i class="fa fa-check"></i> REGISTER</button>
						</div>
					</div>
				</form>
				<!-- /login form -->			
			</div>
			<!-- /LOGIN -->
		</div>
	</div>
</section>
<!-- / --> 
 
