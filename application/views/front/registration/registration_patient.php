<section class="page-header">
	<div class="container">

		<h1>Patient Registration</h1>

		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Patient Registration</li>
		</ol><!-- /breadcrumbs -->

	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">
			<!-- ALERT -->
				<?php if($this->session->flashdata('success')) : ?>
				<div class="alert alert-mini alert-success margin-bottom-30">
					<strong>Oh snap!</strong> <?=$this->session->flashdata('success');?>
				</div>
				<?php endif; ?>
				<?php if($this->session->flashdata('error')) : ?>
				<div class="alert alert-mini alert-danger margin-bottom-30">
					<strong>Oh snap!</strong> <?=$this->session->flashdata('error');?>
				</div>
				<?php endif; ?>
				<!-- /ALERT -->
			<!-- LEFT TEXT -->
			<div class="col-md-5 col-md-offset-1">

				<h2 class="size-16">IMPORTANT INFORMATION</h2>
				<p class="text-muted">Maecenas metus nulla, commodo a sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>
				<p class="text-muted">Sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>

			</div>
			<!-- /LEFT TEXT -->


			<!-- LOGIN -->
			<div class="col-md-4">

				<h2 class="size-16">Patient Registration</h2>

				<!-- login form -->
				<form method="post" action="" id="frmlogin" onsubmit="return zip_validate()">

					<input type="hidden" name="role_id" value="5">  <!-- 5 => Patient Role -->
					<input type="hidden" name="longitude" id="longitude">
					<input type="hidden" name="latitude" id="latitude">
					<?php //echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
					<div class="clearfix">

						<div class="form-group">
							<input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo set_value('fname'); ?>" >
						</div>
						<?php echo form_error('fname','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<div class="form-group">
							<input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo set_value('lname'); ?>" >
						</div>
						<?php echo form_error('lname','<div class="alert alert-mini alert-danger">','</div>'); ?>


						<!-- Email -->
						<div class="form-group">
							<input type="text" name="email_id" class="form-control" placeholder="Email" value="<?php echo set_value('email_id'); ?>" >
						</div>
						<?php echo form_error('email_id','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<!-- Password -->
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="Password">
						</div>
						<?php echo form_error('password','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<div class="form-group">
							<textarea rows="4" name="address" class="form-control" placeholder="Your Address"><?php echo set_value('address'); ?></textarea>
						</div>
						<?php echo form_error('address','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<div class="form-group">
							<input type="text" name="city" class="form-control" placeholder="City" value="<?php echo set_value('city'); ?>" >
						</div>
						<?php echo form_error('city','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<div class="form-group">
							<select name="country_id" class="form-control select2" id="country_id">
								<option value="" selected disabled>Select Country</option>
								<?php foreach($country_list as $country) : ?>
								<option value="<?=$country['id']?>"><?=$country['name']?></option>
							<?php endforeach; ?>
						</select>	
					</div>
					<script>
					$("#country_id").val(<?php echo set_value('country_id'); ?>);
					</script>
					<?php echo form_error('country_id','<div class="alert alert-mini alert-danger">','</div>'); ?>

					<div class="form-group">
						<input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip code" value="<?php echo set_value('zipcode'); ?>" >
					</div>
					<?php echo form_error('zipcode','<div class="alert alert-mini alert-danger">','</div>'); ?>

					<div class="form-group">
						<select name="gender" class="form-control" id="gender">
							<option value="" selected disabled>Select Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
						</select>		
					</div>
					<script>
					$("#gender").val("<?php echo set_value('gender'); ?>");
					</script>
					<?php echo form_error('gender','<div class="alert alert-mini alert-danger">','</div>'); ?>

					<div class="form-group">
						<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo set_value('phone'); ?>" >
					</div>
					<?php echo form_error('phone','<div class="alert alert-mini alert-danger">','</div>'); ?>

					<div class="form-group">
						<input type="text" name="birth_date" placeholder="Birth Date" class="form-control datepicker" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" value="<?php echo set_value('birth_date'); ?>">
					</div>
					<?php echo form_error('birth_date','<div class="alert alert-mini alert-danger">','</div>'); ?>

					<div class="margin-top-30">
						<label class="checkbox nomargin"><input class="checked-agree" type="checkbox" name="agree"><i></i>I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms of Service</a></label>
					</div>					
					<?php echo form_error('agree','<div class="alert alert-mini alert-danger">','</div>'); ?>

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
					<div class="col-md-12 col-sm-12 col-xs-12 text-right">
						<button type="submit" class="btn btn-primary" onclick="check_zipcode()"><i class="fa fa-check"></i> REGISTER</button>
					</div>
				</div>
			</form>
			<!-- /login form -->

			<!-- ALERT -->
			<?php if($this->session->flashdata('error')) : ?>
			<div class="alert alert-mini alert-danger margin-bottom-30">
				<strong>Oh snap!</strong> <?=$this->session->flashdata('error');?>
			</div>
		<?php endif; ?>
		<!-- /ALERT -->
	</div>
	<!-- /LOGIN -->
</div>
</div>
</section>
<!-- / --> 

<script>
function check_zipcode()
{
	var zipcode = $('#zipcode').val();
	if(zipcode != '')
	{
		$.ajax({
	       url : "http://maps.googleapis.com/maps/api/geocode/json?address=santa+cruz&components=postal_code:"+zipcode+"&sensor=false",
	       method: "POST",
	       success:function(data){
	           latitude = data.results[0].geometry.location.lat;
	           longitude= data.results[0].geometry.location.lng;
	           
	           $("#latitude").val(latitude);
	           $("#longitude").val(longitude);
	       }
		});	
	}
 }

 function zip_validate(){
 	var longitude = $('#longitude').val();
	var latitude = $('#latitude').val();

	if(longitude == '' || latitude == ''){
		$("#zipcode").parent().before('<div class="alert alert-mini alert-danger">Please Enter Valid Zipcode</div>');
		return false;
	}else{
		return true;
	}
 } 
</script>