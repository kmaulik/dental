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
				<?php if($this->session->userdata('client')['role_id'] == 4) :?> <!-- If Role (4) Dcotor Then display this map option-->
					<li class="<?php if($tab == 'office_map'){ echo 'active'; }?>"><a href="#office_map" data-toggle="tab">Office Map</a></li>
				<?php endif; ?>
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
								<textarea placeholder="Office Description" name="office_description" class="form-control"><?php echo $db_data['office_description']; ?></textarea>
							</div>
						<?php endif;?>

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
				
				<!-- Office Map TAB -->
				<div class="tab-pane fade <?php if($tab == 'office_map'){ echo 'in active'; }?>" id="office_map">
					<input type="text" id="myPlaceTextBox" />
					<br/>
					<br/>
					<?php echo $map['html']; ?>
					<!-- <div id="googleMap" style="width:100%;height:400px;"></div> -->

					<script>
						// function myMap() {
						// 	var mapProp= {
						// 	    center:new google.maps.LatLng(51.508742,-0.120850),
						// 	    zoom:5,
						// 	};
						// 	var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
						// 	google.maps.event.addListenerOnce(map, 'idle', function() {
						// 	   google.maps.event.trigger(map, 'resize');
						// 	});
						// }
					</script>

					<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrAT6XIzO4FSwU1_iXBgvvOkAqqx8GRBw&callback=myMap"></script> -->
				</div>
				<!--  //Office Map TAB -->

			</div>
		</div>
		
		<?php $this->load->view('front/layouts/side_bar_profile'); ?>
		
	</div>
</section>
<!-- / -->

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrAT6XIzO4FSwU1_iXBgvvOkAqqx8GRBw"></script> -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrAT6XIzO4FSwU1_iXBgvvOkAqqx8GRBw&callback=myMap"></script> -->
				
<script type="text/javascript">
	
	document.getElementById('file').onchange = function () { $('#img_text').val(this.value); };
	$('#country_id').val("<?php echo $db_data['country_id']; ?>");

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
    	var myPlaceTextBox_str = $('#myPlaceTextBox').val();
       	myPlaceTextBox_str_decode = encodeURIComponent(btoa(myPlaceTextBox_str));
       	window.location.href="<?php echo base_url().'dashboard/edit_profile/?tab=office_map&address=';?>"+myPlaceTextBox_str_decode;
    }

     function fetch_lat_long(lat,longi){
        bootbox.alert('lat --> '+lat+'long --'+longi);
    }
	
</script>