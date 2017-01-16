<style>
.table th{
	text-align: center;
	color: #000;
}
.table .checkbox{
	margin-right: 0px;
}
.rfp-title{
	border-bottom: 2px solid gray;
	margin-bottom: 0px;
	margin-top: 10px;
}
</style>


<section class="page-header">
	<div class="container">
		<h1>Patient RFP</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
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
			<div class="alert alert-mini alert-success margin-bottom-30">
				<?=$this->session->flashdata('success');?>
			</div>
		<?php endif; ?>
		<?php if($this->session->flashdata('error')) : ?>
		<div class="alert alert-mini alert-danger margin-bottom-30">
			<strong>Oh snap!</strong> <?=$this->session->flashdata('error');?>
		</div>
	<?php endif; ?>
	<!-- /ALERT -->			
	
	<div class="col-md-12">
		<h2 class="size-16">Patient RFP</h2>
		<form method="post" action="" id="frmrfp" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h3 class="rfp-title">Basic Details</h3>
				</div>
			</div>	
			<div class="row">
				<div class="form-group">
					<div class="col-md-6 col-sm-6">	
						<label>First Name</label>
						<input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo set_value('fname'); ?>" >
						<?php echo form_error('fname','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-6 col-sm-6">	
						<label>Last Name</label>
						<input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo set_value('lname'); ?>" >
						<?php echo form_error('lname','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<div class="col-md-6 col-sm-6">
						<label>Birth Date</label>	
						<input type="text" name="birth_date" id="birth_date" onchange="fetch_definition_type()" class="form-control datepicker" placeholder="Birth Date" value="<?php echo set_value('birth_date'); ?>" >

						<?php echo form_error('birth_date','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-6 col-sm-6">
						<label>RFP Title</label>
						<input type="text" name="title" class="form-control" placeholder="RFP Title" value="<?php echo set_value('title'); ?>" >
						<?php echo form_error('title','<div class="alert alert-mini alert-danger">','</div>'); ?>
					</div>
				</div>
			</div>	
			<div class="row dentition_type">
				<div class="form-group">
					<div class="col-md-12 col-sm-12">
						<label>Dentition Type</label>	
						<select name="dentition_type" class="form-control" id="dentition_type" onchange="fetch_definition_data()">
						</select>
						<?php echo form_error('dentition_type','<div class="alert alert-mini alert-danger">','</div>'); ?>	
					</div>
					<script>
					$("#dentition_type").val("<?php echo set_value('dentition_type'); ?>");
					</script>
				</div>
			</div>	
			<div class="row">
				<div class="form-group">
					<div class="col-md-12 col-sm-12" id="primary">
						<div class="table-responsive">	
							<table class="table table-bordered">
								<thead>
									<tr>
										<th colspan="16">Primary Dentition</th>
									</tr>
									<tr>
										<th colspan="8">upper right</th>
										<th colspan="8">upper left</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th colspan="8">lower right</th>
										<th colspan="8">lower left</th>
									</tr>
								</tfoot>
								<tbody>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<?php for($i=0,$k=65;$i<10;$i++) : ?>
										<td><label class="checkbox"><input type="checkbox" value="<?=chr($k+$i);?>" name="teeth[]"><i></i><?=chr($k+$i);?></label> </td>
									<?php endfor; ?>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<?php for($i=0,$k=84;$i<10;$i++) : ?>
									<td><label class="checkbox"><input type="checkbox" value="<?=chr($k-$i);?>" name="teeth[]"><i></i><?=chr($k-$i);?></label> </td>
								<?php endfor; ?>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>	
					</table>
				</div>	
			</div>
			<div class="col-md-12 col-sm-12" id="permenant">
				<div class="table-responsive">	
					<table class="table table-bordered">
						<thead>
							<tr>
								<th colspan="16">Permenant Dentition</th>
							</tr>
							<tr>
								<th colspan="8">upper right</th>
								<th colspan="8">upper left</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th colspan="8">lower right</th>
								<th colspan="8">lower left</th>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<?php for($i=1;$i<=16;$i++) : ?>
								<td><label class="checkbox"><input type="checkbox" value="<?=$i?>" name="teeth[]"><i></i><?=$i?></label> </td>
							<?php endfor;?>
						</tr>
						<tr>
							<?php for($i=32;$i>16;$i--) : ?>
							<td><label class="checkbox"><input type="checkbox" value="<?=$i?>" name="teeth[]"><i></i> <?=$i?></label> </td>
						<?php endfor;?>
					</tr>
				</tbody>	
			</table>
		</div>	
	</div>
	<div class="col-md-12 col-sm-12" id="other">
		<label>Other Description</label> 
		<textarea name="description" class="form-control" placeholder="Enter Description"><?php echo set_value('description'); ?></textarea>
	</div>
</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<label>Message</label> 
		<textarea name="message" class="form-control" placeholder="Enter Message"><?php echo set_value('message'); ?></textarea>
		<?php echo form_error('message','<div class="alert alert-mini alert-danger">','</div>'); ?>
	</div>	
</div>	

<div class="row">
	<div class="col-md-12 col-sm-12">
		<label>Attachment</label>
		<div class="fancy-file-upload">
			<i class="fa fa-upload"></i>
			<input type="file" id="img_path_id" class="form-control" multiple="multiple" name="img_path[]"/>
			<input type="text" id="img_path_txt" class="form-control" placeholder="no file selected" readonly="" />
			<span class="button">Choose File</span>
		</div>
	</div>
</div>		

<div class="row">
	<div class="col-md-12 col-sm-12">
		<h3 class="rfp-title">Medical History</h3>
	</div>
</div>	
<div class="row">
	<div class="col-md-12 col-sm-12">
		<label>Known Allergies</label> 
		<textarea name="allergies" class="form-control" placeholder="Enter Allergies"><?php echo set_value('allergies'); ?></textarea>
	</div>	
</div>	

<div class="row">
	<div class="col-md-12 col-sm-12">
		<label>Full Medication List</label> 
		<textarea name="medication_list" class="form-control" placeholder="Enter Medication List"><?php echo set_value('medication_list'); ?></textarea>
	</div>	
</div>
<?php echo form_error('medication_list','<div class="alert alert-mini alert-danger">','</div>'); ?>	

<div class="row">
	<div class="col-md-12 col-sm-12">
		<label>Any heart problems including blood pressure ?</label> 
		<textarea name="heart_problem" class="form-control" placeholder="Enter Heart Problem"><?php echo set_value('heart_problem'); ?></textarea>
	</div>	
</div>	
<?php echo form_error('heart_problem','<div class="alert alert-mini alert-danger">','</div>'); ?>

<div class="row">
	<div class="col-md-12 col-sm-12">
		<label>Any history of chemo/radiation ?</label> 
		<textarea name="chemo_radiation" class="form-control" placeholder="Enter Chemo/Radiation"><?php echo set_value('chemo_radiation'); ?></textarea>
	</div>	
</div>	
<?php echo form_error('chemo_radiation','<div class="alert alert-mini alert-danger">','</div>'); ?>

<div class="row">
	<div class="col-md-12 col-sm-12">
		<label>Surgery occurred during the last two years.</label> 
		<textarea name="surgery" class="form-control" placeholder="please describe in Brief type of surgery and date"><?php echo set_value('surgery'); ?></textarea>
	</div>	
</div>	
<?php echo form_error('surgery','<div class="alert alert-mini alert-danger">','</div>'); ?>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 text-right">
		<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
	</div>
</div>
</form>
</div>
</div>
</div>
</section>
<!-- / --> 


<script>

$(".dentition_type").hide();
fetch_definition_data();

function fetch_definition_data(){

	$("#primary").hide();
	$("#permenant").hide();
	$("#other").hide();

	if($("#dentition_type").val() == 'primary'){
		$("#primary").show();
	}
	else if($("#dentition_type").val() == 'permenant'){
		$("#permenant").show();
	}
	else if($("#dentition_type").val() == 'other'){
		$("#other").show();
	}
	else{
		$("#primary").hide();
		$("#permenant").hide();
		$("#other").hide();
	}
}

function fetch_definition_type(){
	if($("#birth_date").val() != '')
	{
		$(".dentition_type").show();
		dob = new Date($("#birth_date").val());
		var today = new Date();
		var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
		console.log('Your Age is : '+age);
		if(age >= 5 && age <= 14) 
		{
			var data='<option value=""> Select Dentition Type</option><option value="primary">Primary</option><option value="permenant">Permenant</option>';
			$("#dentition_type").html(data);
		}else{
			var data='<option value=""> Select Dentition Type</option><option value="other">Other</option>';				
			$("#dentition_type").html(data);
		}
	}
	else{
		$(".dentition_type").hide();
		$("#dentition_type").html('');
	}	
	
}

$('#img_path_id').change(function(){
	var files = $(this)[0].files;
	var file_text= files.length+" files selected";
	$('#img_path_txt').val(file_text);
});
</script>

