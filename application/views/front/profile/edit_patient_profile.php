<section class="page-header">
	<div class="container">

		<h1>Edit Profile</h1>

		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Edit Profile</li>
		</ol><!-- /breadcrumbs -->

	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="size-16">Edit Profile</h2>
				<form method="post" action="" id="frmprofile" onsubmit="return zip_validate()">
					<input type="hidden" name="longitude" id="longitude">
					<input type="hidden" name="latitude" id="latitude">
					<div class="col-md-6">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo set_value('fname'); ?>" >
						</div>
						<?php echo form_error('fname','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo set_value('lname'); ?>" >
						</div>
						<?php echo form_error('lname','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-6">

						<!-- Email -->
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email_id" class="form-control" placeholder="Email" value="<?php echo set_value('email_id'); ?>" >
						</div>
						<?php echo form_error('email_id','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-6">
					<div class="form-group">
						<label>Phone</label>
						<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo set_value('phone'); ?>" >
					</div>
					<?php echo form_error('phone','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Address</label>
							<textarea rows="4" name="address" class="form-control" placeholder="Your Address"><?php echo set_value('address'); ?></textarea>
						</div>
						<?php echo form_error('address','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>City</label>
							<input type="text" name="city" class="form-control" placeholder="City" value="<?php echo set_value('city'); ?>" >
						</div>
						<?php echo form_error('city','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Country</label>
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
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Zipcode</label>
						<input type="text" name="zipcode" id="zipcode" class="form-control" onblur="check_zipcode()" placeholder="Zip code" value="<?php echo set_value('zipcode'); ?>" >
					</div>
					<?php echo form_error('zipcode','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Gender</label>
						<select name="gender" class="form-control" id="gender">							
							<option value="male">Male</option>
							<option value="female">Female</option>							
						</select>		
					</div>
					<script>
					$("#gender").val("<?php echo set_value('gender'); ?>");
					</script>
					<?php echo form_error('gender','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				
				<div class="col-md-6">
					<div class="form-group">
						<label>Birth Date</label>
						<input type="text" name="birth_date" placeholder="Birth Date" class="form-control datepicker" data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" value="<?php echo set_value('birth_date'); ?>">
					</div>
					<?php echo form_error('birth_date','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Profile Image</label>
						<div class="fancy-file-upload">
							<i class="fa fa-upload"></i>
							<input type="file" class="form-control" name="avatar" onchange="jQuery(this).next('input').val(this.value);" />
							<input type="text" class="form-control" placeholder="no file selected" readonly="" />
							<span class="button">Choose File</span>
						</div>
						<input type="hidden" name="h_avatar">
					</div>
					<?php echo form_error('avatar','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>

				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 text-right">
						<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
					</div>
				</div>
			</form>
		

	</div>

</div>
</div>
</section>
<!-- / --> 

<script>
check_zipcode();
function check_zipcode()
{
	$(".valid-zip").remove();
	var zipcode = $('#zipcode').val();
	if(zipcode != '')
	{
		$.ajax({
			url : "http://maps.googleapis.com/maps/api/geocode/json?components=postal_code:"+zipcode+"&sensor=false",
			method: "POST",
			success:function(data){
				if(data.status != 'OK'){
					$("#latitude").val('');
					$("#longitude").val('');
					$("#zipcode").parent().after('<div class="alert alert-mini alert-danger valid-zip">Please Enter Valid Zipcode</div>');
				}
				else{
					latitude = data.results[0].geometry.location.lat;
					longitude= data.results[0].geometry.location.lng;
					$("#latitude").val(latitude);
					$("#longitude").val(longitude);
				}

			}
		});	
	}
}

function zip_validate(){
	var longitude = $('#longitude').val();
	var latitude = $('#latitude').val();
	if(longitude == '' || latitude == ''){
		$(".alert").remove();
		$(".valid-zip").remove();
		$("#zipcode").parent().after('<div class="alert alert-mini alert-danger valid-zip">Please Enter Valid Zipcode</div>');
		return false;
	}else{
		return true;
	}
} 
</script>