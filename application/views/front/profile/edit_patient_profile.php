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
<?php echo $map['js']; ?>

<?php //pr($map['html'],1);?>
<section class="page-header page-header-xs">
	<div class="container">

		<!-- breadcrumbs -->
		<ol class="breadcrumb breadcrumb-inverse">
			<li><a href="<?=base_url('')?>">Home</a></li>
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
				<?php if($this->session->userdata('client')['role_id'] == 4) :?> <!-- If Role (4) Dcotor Then display this map option-->
				<li class="<?php if($tab == 'office_map'){ echo 'active'; }?>">
					<a href="<?php echo base_url().'dashboard/edit_profile/?tab=office_map'; ?>"> Office Map </a>
				</li>
				<li class="<?php if($tab == 'payment_method'){ echo 'active'; }?>">
					<a href="#payment_method" data-toggle="tab">Manage Payment</a>
				</li>
				<?php endif; ?>
			</ul>
			
			<div class="tab-content profile-edit-form">
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
							<input type="text" placeholder="First name" name="fname" class="form-control AlphaAndDotWithhypen" value="<?php echo $db_data['fname']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Last Name</label>
							<input type="text" placeholder="Last name" name="lname" class="form-control AlphaAndDotWithhypen" value="<?php echo $db_data['lname']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Email ID</label>
							<input type="text" placeholder="Email ID" name="email_id" readonly class="form-control" value="<?php echo $db_data['email_id']; ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Street</label>
							<input type="text" placeholder="Street" name="street" class="form-control" value="<?php echo $db_data['street']; ?>">
						</div>

						<div class="form-group">
							<label class="control-label">City</label>
							<input type="text" placeholder="City" name='city' class="form-control" value="<?php echo $db_data['city']; ?>">
						</div>

						<div class="form-group">
							<label class="control-label">State</label>
							<select name="state_id" class="form-control select2" id="state_id">
								<option value="" selected disabled>Select State</option>
								<?php foreach($state_list as $state) : ?>
									<option value="<?=$state['id']?>" <?php echo  set_select('state_id', $state['id']); ?> ><?=$state['name']?></option>
								<?php endforeach; ?>
							</select>	
						</div>	

						<div class="form-group">
							<label class="control-label">Zipcode</label>
							<input type="text" placeholder="zipcode" name="zipcode" class="form-control" value="<?php echo $db_data['zipcode']; ?>">
						</div>	
						
						<div class="form-group country_custom">
							<label class="control-label">Country</label>
							<select name="country_id" class="form-control"  id="country_id">
								<option value="" selected disabled>Select Country</option>
								<?php foreach($country_list as $country) : ?>
									<option disabled value="<?=$country['id']?>" <?php echo  set_select('country_id', $country['id']); ?> ><?=$country['name']?></option>
								<?php endforeach; ?>
							</select>	
						</div>						

						<div class="form-group ">
							<label class="control-label">Gender</label>
							<select name="gender" id="" class="form-control">
								<option value="male" <?php if($db_data['gender']=='male'){ echo 'selected'; } ?>>Male</option>
								<option value="female" <?php if($db_data['gender']=='female'){ echo 'selected'; } ?> >Female</option>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">Phone No</label>
							<input type="text" placeholder="Phone no" name="phone" class="form-control" value="<?php echo $db_data['phone']; ?>">
						</div>
						
						<div class="form-group">
							<label class="control-label">Birth Date</label>
							<input type="text" placeholder="MM-DD-YYYY" name="birth_date" data-format="mm-dd-yyyy" class="form-control birth_date" value="<?php echo date("m-d-Y",strtotime($db_data['birth_date'])); ?>">
							<small class="text-muted block">Please Select Date in MM-DD-YYYY Format</small>	
						</div>

						<!-- <div class="form-group">
							<label class="control-label">Address</label>
							<textarea name="address" id="address" class="form-control"><?php echo $db_data['address']; ?></textarea>
						</div> -->

						<!-- If Role (4) Dcotor Then display office email & description-->
						<?php if($this->session->userdata('client')['role_id'] == 4) :?> 
							<div class="form-group">
								<label class="control-label">Public Email</label>
								<input type="text" placeholder="Public Email" name="public_email" class="form-control" value="<?php echo $db_data['public_email']; ?>">
							</div>
							<div class="form-group">
								<label class="control-label">Office Description</label>
								<!-- <textarea placeholder="Office Description" name="office_description" id="office_description" class="form-control"><?php echo $db_data['office_description']; ?></textarea> -->
								
								<div class="fancy-form">
									<textarea rows="5" name="office_description" class="form-control char-count" data-maxlength="3000" data-info="textarea-chars-info" placeholder="Office Description"><?php echo $db_data['office_description']; ?></textarea>
									<i class="fa fa-comments"><!-- icon --></i>
									<span class="fancy-hint size-11 text-muted">
										<strong>Hint:</strong> 3000 characters allowed!
										<span class="pull-right">
											<span id="textarea-chars-info"><span class="count-text_data">0</span>/3000</span> Characters
											<script>
												var text_length=$(".char-count").val().length;
												$(".count-text_data").html(text_length);
											</script>
										</span>
									</span>
								</div>	

							</div>
						<?php endif;?>

						<div class="margiv-top10">
							<input type="hidden" name="tab" value="info">
							<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>
							<button type="reset" class="btn btn-default">Cancel</button>
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
							<button type="reset" class="btn btn-default">Cancel</button>
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
							<button type="reset" class="btn btn-default">Cancel</button>
						</div>

					</form>
				</div>
				<!-- /PASSWORD TAB -->

				<!-- Office Map TAB -->
				<div class="tab-pane fade <?php if($tab == 'office_map'){ echo 'in active'; }?>" id="office_map">
					<form  method="post">
						<?php														
							if($this->input->get('address') != ''){		
								$get_address = $this->input->get('address');
								$get_address_decode = utf8_encode(decode($get_address));
							}else{													
								$get_address_decode = utf8_encode($get_address);
							}
						?>
						<div class="form-group">
							<label class="control-label">Search office address</label>
							<input type="text" id="new_id" class="form-control" value="<?php echo $get_address_decode; ?>" />							
							<input type="hidden" id="latlong_location" value="<?php echo $latlong_location; ?>" >
							<input type="hidden" id="lat" value="<?php echo ($lat) ? $lat:''; ?>">
							<input type="hidden" id="lng" value="<?php echo ($lng) ? $lng:''; ?>">
						</div>

						<div class="form-group">
							<a class="btn btn-primary for_pointer" onclick="save_office_map_address()">
								Save Address
							</a>
						</div>
					</form>
					<br/>
					<br/>
					<?php echo $map['html']; ?>
				</div>
				<!--  //Office Map TAB -->

				<!-- Payment method TAB -->
				<div class="tab-pane fade <?php if($tab == 'payment_method'){ echo 'in active'; }?>" id="payment_method">
					
					<div class="row">
						<?php if(!empty($agreement_created)) { ?>
							<?php $paypal_email = json_decode($agreement_created['meta_arr']); ?>
							<div class="col-sm-8">
								<h4 class="current-paypal">Your Current Paypal Account : <span><?php echo $paypal_email->EMAIL; ?></span></h4>	
							</div>	
							<div class="col-sm-4">
								<a href="<?php echo base_url().'home/create_manual_agreement'; ?>" class="btn btn-primary">Change Paypal Account</a>
							</div>	
						<?php } else { ?>
							<div class="col-sm-8">
								<h4>You not set paypal account yet</h4>	
							</div>	
							<div class="col-sm-4">	
								<a href="<?php echo base_url().'home/create_manual_agreement'; ?>" class="btn btn-primary">Create Agreement</a>
							</div>		
						<?php } ?>	
					</div>	
					<hr>
					<form  method="post">

						<div class="form-group">
							<label class="control-label">Default payment method</label>
							<select name="default_payment" id="default_payment" class="form-control">
								<option value="paypal" <?php if($db_data['default_payment'] == 'paypal'){ echo 'selected'; } ?> > Paypal</option>
								<option value="manual" <?php if($db_data['default_payment'] == 'manual'){ echo 'selected'; } ?> > Monthly Payment</option>
							</select>
						</div>					
						

						<div class="margiv-top10">
							<input type="hidden" name="tab" value="payment_method">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-check"></i>
								Change Method
							</button>
							<button type="reset" class="btn btn-default">Cancel</button>
						</div>

					</form>
				</div>
				<!-- /Payment method TAB -->

			</div>
		</div>
	
		<?php $this->load->view('front/layouts/side_bar_profile'); ?>
		
	</div>
</section>
<!-- / -->

<script type="text/javascript">

	$('.AlphaAndDotWithhypen').keyup(function () {
    	this.value = this.value.replace(/[^A-Za-z.-\s]/g,'');
	});
	
	document.getElementById('file').onchange = function () { $('#img_text').val(this.value); };

	$('#country_id').val("<?php echo $db_data['country_id']; ?>");
	$("#country_id").prop("disabled", true); // For Disable select option
	$('#state_id').val("<?php echo $db_data['state_id']; ?>");

	$(document).ready(function() {

        $('a[href="#office_map"]').click(function(e) {
            setTimeout(initialise, 1000);
        });

        function initialise() {
           	var myMap = document.getElementById('map_canvas');
            google.maps.event.trigger(myMap, 'resize');
        };
    });

    function get_location(){
    	$('#preloader').show();
    	var myPlaceTextBox_str = $('#new_id').val();       	
       	myPlaceTextBox_str_decode = encodeURIComponent(btoa(myPlaceTextBox_str));
    	window.location.href="<?php echo base_url().'dashboard/edit_profile/?tab=office_map&address=';?>"+myPlaceTextBox_str_decode;    	   
    }

    function fetch_lat_long(lat,lng){              	       	       	       	    
       	var office_text = $('#new_id').val();
       	$('#lat').val(lat);
		$('#lng').val(lng);
    }
	
	function save_office_map_address(){	

		var office_text = $('#new_id').val();
		var lat = $('#lat').val();
		var lng = $('#lng').val();

		$.ajax({
			url: '<?php echo base_url()."dashboard/save_map_address"; ?>',
			type: 'POST',
			dataType: 'JSON',
			data: {office_text:office_text,lat:lat,lng:lng},
			success:function(data){
				bootbox.alert('Save Successfully.');				
			}
		});

	}

/*------------- Custom Select 2 focus open select2 option @DHK-Select2 --------- */
$(document).on('focus', '.select2', function() {
    $(this).siblings('select').select2('open');
});
/*-------------End Custom Select 2 focus open select2 options -----*/
</script>