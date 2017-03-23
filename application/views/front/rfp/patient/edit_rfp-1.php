<!--<style>
	.rfp-title{
		border-bottom: 2px solid gray;
		margin-bottom: 0px;
		margin-top: 10px;
	}
</style>-->

<section class="page-header page-header-xs">
	<div class="container">
		<h1>Patient RFP</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp');?>">RFP List</a></li>
			<li class="active">Patient RFP</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">
			
		<!-- ALERT -->
		<?php if($this->session->flashdata('success')) : ?>
			<div class="alert alert-success margin-bottom-30">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$this->session->flashdata('success');?>
			</div>
		<?php endif; ?>
		<?php if($this->session->flashdata('error')) : ?>
			<div class="alert alert-danger margin-bottom-30">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$this->session->flashdata('error');?>
			</div>
		<?php endif; ?>
		<!-- /ALERT -->	
						
	<div class="col-md-12">
		<form method="post" action="" id="frmrfp" enctype="multipart/form-data">
			
			<?php if(!isset($record)) :?>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<a href="<?=base_url('rfp/redirect_profile')?>" class="btn btn-info">Edit Profile</a>
						<a href="#" class="btn btn-info new_person">Clear All Fields</a>
					</div>
				</div>
			<?php endif;?>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h3 class="rfp-title">Basic Details</h3>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-6 col-sm-6">	
					<div class="form-group">
						<label>First Name</label>
						<input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php if($this->input->post('fname') != '') { echo $this->input->post('fname'); } else { if(isset($record['fname'])) { echo $record['fname']; } else { if(set_value('fname') != '') { echo set_value('fname'); }else { echo $this->session->userdata['client']['fname']; }}} ?>" >
					</div>
					<?php echo form_error('fname','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6 col-sm-6">	
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php if($this->input->post('lname') != '') { echo $this->input->post('lname'); } else { if(isset($record['lname'])) { echo $record['lname']; } else { if(set_value('lname') != '') { echo set_value('lname'); }else { echo $this->session->userdata['client']['lname']; }}} ?>" >
					</div>
					<?php echo form_error('lname','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>				
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="form-group">
						<label>Birth Date</label>	
						<input type="text" name="birth_date" id="birth_date" data-format="mm-dd-yyyy" class="form-control datepicker" 
							  placeholder="MM-DD-YYYY" onchange="fetch_definition_type()" value="<?php if($this->input->post('birth_date') != '') { echo $this->input->post('birth_date'); } else { if(isset($record['birth_date'])) { echo date("m-d-Y",strtotime($record['birth_date'])); } else { 
							  	if(set_value('birth_date') != '') { echo set_value('birth_date'); }
							  	else { echo date("m-d-Y",strtotime($this->session->userdata['client']['birth_date'])); }}} ?>" >
						<small class="text-muted block">Please Select Date in MM-DD-YYYY Format</small>	
					</div>
					<?php echo form_error('birth_date','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6 col-sm-6">	
					<div class="form-group">
						<label>Zip Code</label>
						<input type="text" name="zipcode" class="form-control" placeholder="Zip Code" value="<?php if($this->input->post('zipcode') != '') { echo $this->input->post('zipcode'); } else { if(isset($record['zipcode'])) { echo $record['zipcode']; } else { if(set_value('zipcode') != '') { echo set_value('zipcode'); }else { echo $this->session->userdata['client']['zipcode']; }}} ?>" >
					</div>
					<?php echo form_error('zipcode','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>		
				
			</div>	
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="form-group">
						<label>RFP Title</label>
						<input type="text" name="title" class="form-control" placeholder="RFP Title" value="<?php if($this->input->post('title') != '') { echo $this->input->post('title'); } else { echo (isset($record['title'])? $record['title'] : set_value('title')); } ?>" >
					</div>
					<?php echo form_error('title','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6 col-sm-6 dentition_type">
					<div class="form-group">
						<label>Dentition Type</label>	
						<select name="dentition_type" class="form-control" id="dentition_type">
							<option value=""> Select Dentition Type</option>
							<!-- <option value="primary">Primary</option>
							<option value="permanent">Permanent</option>
							<option value="other">Other</option> -->	
						</select>
					</div>
					<?php echo form_error('dentition_type','<div class="alert alert-mini alert-danger">','</div>'); ?>	
				</div>
			</div>

			<!-- Range Picker -->
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="margin-bottom-20">
						<label for="donation">Travel Distance (In. Miles)</label>
						<label class="field">
							<input type="text" name="distance_travel" id="distance_travel" class="form-control NumbersAndRange" value="<?php if($this->input->post('distance_travel') != '') { echo $this->input->post('distance_travel'); } else { echo (isset($record['distance_travel'])? $record['distance_travel'] : set_value('distance_travel')); } ?>">
						</label> 
					</div>                
					<div class="slider-wrapper black-slider custom-range-slider">
						<div id="slider5"></div>
					</div>
				</div>
			</div>
			<!-- End Range Picker -->

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h3 class="rfp-title">Medical History</h3>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Known Allergies</label> 
						<textarea name="allergies" class="form-control" placeholder="Enter Allergies"><?php if($this->input->post('allergies') != '') { echo $this->input->post('allergies'); } else { echo (isset($record['allergies'])? $record['allergies'] : set_value('allergies')); } ?></textarea>
					</div>
					<?php echo form_error('allergies','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Full Medication List</label> 
						<textarea name="medication_list" class="form-control" placeholder="Enter Medication List"><?php if($this->input->post('medication_list') != '') { echo $this->input->post('medication_list'); } else { echo (isset($record['medication_list'])? $record['medication_list'] : set_value('medication_list')); } ?></textarea>
					</div>
					<?php echo form_error('medication_list','<div class="alert alert-mini alert-danger">','</div>'); ?>

				</div>	
			</div>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Any heart problems including blood pressure ?</label> 
						<textarea name="heart_problem" class="form-control" placeholder="Enter Heart Problem"><?php if($this->input->post('heart_problem') != '') { echo $this->input->post('heart_problem'); } else { echo (isset($record['heart_problem'])? $record['heart_problem'] : set_value('heart_problem')); } ?></textarea>
					</div>
					<?php echo form_error('heart_problem','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	


			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Any history of chemo/radiation ?</label> 
						<textarea name="chemo_radiation" class="form-control" placeholder="Enter Chemo/Radiation"><?php if($this->input->post('chemo_radiation') != '') { echo $this->input->post('chemo_radiation'); } else { echo (isset($record['chemo_radiation'])? $record['chemo_radiation'] : set_value('chemo_radiation')); } ?></textarea>
					</div>
					<?php echo form_error('chemo_radiation','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Surgery occurred during the last two years.</label> 
						<textarea name="surgery" class="form-control" placeholder="please describe in Brief type of surgery and date"><?php if($this->input->post('surgery') != '') { echo $this->input->post('surgery'); } else { echo (isset($record['surgery'])? $record['surgery'] : set_value('surgery')); } ?></textarea>
					</div>
					<?php echo form_error('surgery','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	

			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-right">
					<button type="submit" class="btn btn-success submit_data"><i class="fa fa-arrow-right"></i> Next</button>
					<a class="btn btn-success send_chat_loader" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Loading...</a>

				</div>
			</div>
		</form>
	</div>
</div>	
</div>	
</section>
<!-- / --> 


<script>
	$('.NumbersAndRange').keyup(function () { 
    	this.value = this.value.replace(/[^0-9]/g,'');
    	if(this.value > 2000){
    		this.value= 2000;
    	}
  });
	
	$(".new_person").click(function(){
		$("input[name=fname]").val('');
		$("input[name=lname]").val('');
		$("input[name=birth_date]").val('');
		$("input[name=zipcode]").val('');
	});

	//------ For Check Age and display dentition type -----------------------
	fetch_definition_type();
	function fetch_definition_type(){
		if($("#birth_date").val() != '')
		{
			//$(".dentition_type").show();
			var birthdate = $("#birth_date").val().split('-');
			var birth_date=birthdate[2]+"-"+birthdate[0]+"-"+birthdate[1];
			dob = new Date(birth_date);
			var today = new Date();
			var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
			console.log('Your Age is : '+age);
			if(age > 18) 
			{
				var data='<option value=""> Select Dentition Type</option><option value="permanent">Permanent</option><option value="other">Others, e.g. Dentures, Bracelets</option>';
				$("#dentition_type").html(data);
			}else{
				var data='<option value=""> Select Dentition Type</option><option value="primary">Primary</option><option value="permanent">Permanent</option><option value="other">Others, e.g. Dentures, Bracelets</option>';				
				$("#dentition_type").html(data);
			}
			$("#dentition_type").val("<?php if($this->input->post('dentition_type') != '') { echo $this->input->post('dentition_type'); } else { echo (isset($record['dentition_type'])? $record['dentition_type'] : set_value('dentition_type')); } ?>");
		}
		else{
			//$(".dentition_type").hide();
			$("#dentition_type").html('');
		}	
		
	}

	$(window).ready(function() {
		//------- For Range Picker -------------
		loadScript(plugin_path + 'jquery/jquery-ui.min.js', function() { /** jQuery UI **/
			loadScript(plugin_path + 'jquery/jquery.ui.touch-punch.min.js', function() { /** Mobile Touch Slider **/
				loadScript(plugin_path + 'form.slidebar/jquery-ui-slider-pips.min.js', function() { /** Slider Script **/
		            
		            var initialValue = $("#distance_travel").val() || 100;
					$("#slider5").slider({
						value: initialValue,
						animate: true,
						min: 0,
						max: 2000,
						step: 1,
						range: "min",
						slide: function(event, ui) {
							$("#distance_travel").val(ui.value);
							//------- For Tooltip -------
							var curValue = ui.value;
							var tooltip = '<div class="tooltip"><div class="tooltip-inner">' + curValue + '</div><div class="tooltip-arrow"></div></div>';
							$('.ui-slider-handle').html(tooltip);
							//-------------------------------
						}
					});

					$("#slider5").slider("pips" , {
						rest: false
					});	
					
					$("#distance_travel").val($("#slider5").slider("value"));
					$("#distance_travel").blur(function() {
						$("#slider5").slider("value", $(this).val());
						//------- For Tooltip -------
						var curValue = $(this).val() || initialValue;
						var tooltip = '<div class="tooltip"><div class="tooltip-inner">' + curValue + '</div><div class="tooltip-arrow"></div></div>';
						$('.ui-slider-handle').html(tooltip);
						//-------------------------------
					});

				});	
			});
		});
		//------- End For Range Picker -------------
	});

$(".submit_data").click(function(event) {
	$(".submit_data").hide();
	$(".send_chat_loader").show();
});

</script>

