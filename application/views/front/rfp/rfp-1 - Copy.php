<style>
.rfp-title{
	border-bottom: 2px solid gray;
	margin-bottom: 0px;
	margin-top: 10px;
}
</style>

  <script type="text/javascript" src="http://localhost/dental/public/back/js/plugins/notifications/bootbox.min.js"></script>

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
			
	
	<div class="col-md-12">
		<h2 class="size-16">Patient RFP</h2>
		<form method="post" action="" id="frmrfp" enctype="multipart/form-data" onsubmit="return check_file_limit()">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h3 class="rfp-title">Basic Details</h3>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-6 col-sm-6">	
					<div class="form-group">
						<label>First Name</label>
						<input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php if(isset($record['fname'])) { echo $record['fname']; } else { if(set_value('fname') != '') { echo set_value('fname'); }else { echo $this->session->userdata['client']['fname']; }} ?>" >
					</div>
					<?php echo form_error('fname','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6 col-sm-6">	
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php if(isset($record['lname'])) { echo $record['lname']; } else { if(set_value('lname') != '') { echo set_value('lname'); }else { echo $this->session->userdata['client']['lname']; }} ?>" >
					</div>
					<?php echo form_error('lname','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>				
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="form-group">
						<label>Birth Date</label>	
						<input type="text" name="birth_date" id="birth_date" onchange="fetch_definition_type()" class="form-control datepicker" placeholder="Birth Date" value="<?php if(isset($record['birth_date'])) { echo $record['birth_date']; } else { if(set_value('birth_date') != '') { echo set_value('birth_date'); }else { echo $this->session->userdata['client']['birth_date']; }} ?>" >
					</div>
					<?php echo form_error('birth_date','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="form-group">
						<label>RFP Title</label>
						<input type="text" name="title" class="form-control" placeholder="RFP Title" value="<?php echo (isset($record['title'])? $record['title'] : set_value('title')); ?>" >
					</div>
					<?php echo form_error('title','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
			</div>	
			<div class="row dentition_type">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Dentition Type</label>	
						<select name="dentition_type" class="form-control" id="dentition_type" onchange="fetch_definition_data()">
						</select>
					</div>
					<?php echo form_error('dentition_type','<div class="alert alert-mini alert-danger">','</div>'); ?>	
				</div>
			</div>	

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<label>Additional Comments</label> 
					<div class="fancy-form">
						<textarea rows="3" name="message" class="form-control char-count" data-maxlength="500" data-info="textarea-chars-info" placeholder="Enter Additional Comments"><?php echo (isset($record['message'])? $record['message'] : set_value('message')); ?></textarea>
						<i class="fa fa-comments"><!-- icon --></i>
						<span class="fancy-hint size-11 text-muted">
							<strong>Hint:</strong> 500 characters allowed!
							<span class="pull-right">
								<span id="textarea-chars-info">0/500</span> Characters
							</span>
						</span>
					</div>	
					<?php echo form_error('message','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	

			<?php if(isset($record['img_path']) && $record['img_path'] != '') :?>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<?php 
							
							$all_images_str = $record['img_path'];
							if($all_images_str != ''){
								$all_images = explode('|',$all_images_str);
							}						
							if(!empty($all_images)){
								foreach($all_images as $key=>$img){
							?>
							<span class="rpf_attachment">
								<?php $ext=explode(".",$img); 
								if(isset($ext) && $ext[1] == 'pdf') { ?>
									<img src="<?php echo DEFAULT_IMAGE_PATH.'document-file.jpg'?>" width="100px" height="50px">
							    <?php } else { ?>
									<img src="<?php echo base_url().'uploads/rfp/'.$img;?>" width="100px" height="50px">
								<?php } ?>
								<?php $file_name = 'uploads/rfp/'.$img; 
									  $file_size= filesize($file_name);	
								?>
								<a onclick="delete_img(this)" data-size="<?php echo $file_size;?>" data-img="<?php echo $img; ?>" data-rfpid="<?php echo $record['id']; ?>">
									<i class="fa fa-close text-danger"></i>
								</a>
							</span>
						<?php } } ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Attachment</label>
						<div class="fancy-file-upload">
							<i class="fa fa-upload"></i>
							<input type="file" id="img_path_id" class="form-control" multiple="multiple" name="img_path[]"/>							
							<input type="text" id="img_path_txt" class="form-control" placeholder="no file selected" readonly="" />
							<span class="button">Choose File</span>
						</div>
						<small class="text-muted block">Max Allow File : 5 & Max file size: 10 MB </small>
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
					<div class="form-group">
						<label>Known Allergies</label> 
						<textarea name="allergies" class="form-control" placeholder="Enter Allergies"><?php echo (isset($record['allergies'])? $record['allergies'] : set_value('allergies')); ?></textarea>
					</div>
					<?php echo form_error('allergies','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Full Medication List</label> 
						<textarea name="medication_list" class="form-control" placeholder="Enter Medication List"><?php echo (isset($record['medication_list'])? $record['medication_list'] : set_value('medication_list')); ?></textarea>
					</div>
					<?php echo form_error('medication_list','<div class="alert alert-mini alert-danger">','</div>'); ?>

				</div>	
			</div>

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Any heart problems including blood pressure ?</label> 
						<textarea name="heart_problem" class="form-control" placeholder="Enter Heart Problem"><?php echo (isset($record['heart_problem'])? $record['heart_problem'] : set_value('heart_problem')); ?></textarea>
					</div>
					<?php echo form_error('heart_problem','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	


			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Any history of chemo/radiation ?</label> 
						<textarea name="chemo_radiation" class="form-control" placeholder="Enter Chemo/Radiation"><?php echo (isset($record['chemo_radiation'])? $record['chemo_radiation'] : set_value('chemo_radiation')); ?></textarea>
					</div>
					<?php echo form_error('chemo_radiation','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	

			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Surgery occurred during the last two years.</label> 
						<textarea name="surgery" class="form-control" placeholder="please describe in Brief type of surgery and date"><?php echo (isset($record['surgery'])? $record['surgery'] : set_value('surgery')); ?></textarea>
					</div>
					<?php echo form_error('surgery','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>	

			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-right">
					<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Next</button>
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
	fetch_definition_type();

	function fetch_definition_type(){
		if($("#birth_date").val() != '')
		{
			$(".dentition_type").show();
			dob = new Date($("#birth_date").val());
			var today = new Date();
			var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
			//console.log('Your Age is : '+age);
			if(age >= 5 && age <= 14) 
			{
				var data='<option value=""> Select Dentition Type</option><option value="primary">Primary</option><option value="permenant">Permenant</option>';
				$("#dentition_type").html(data);
			}else{
				var data='<option value=""> Select Dentition Type</option><option value="other">Other</option>';				
				$("#dentition_type").html(data);
			}
			$("#dentition_type").val("<?php echo (isset($record['dentition_type'])? $record['dentition_type'] : set_value('dentition_type')); ?>");
		}
		else{
			$(".dentition_type").hide();
			$("#dentition_type").html('');
		}	
		
	}

	//---------------- For Change Image Upload  --------------
	$('#img_path_id').change(function(){
		var files = $(this)[0].files;
		var file_text= files.length+" files selected";
		$('#img_path_txt').val(file_text);
		check_file_limit();
	});

	//---------------- For Check File Limit,size & Extension For Image Upload  --------------
	function check_file_limit(){

		$(".valid-file").remove();
		var files = $("#img_path_id")[0].files;
		var valid_extension = 0, b = 0;
		for (var i=0, F=files, L=files.length; i<L; i++) {
			b += files[i].size/1024/1024;
			//---- For Check Extension ----
			var arrayExtensions = ["jpg" , "jpeg", "png", "pdf"];
			var valid_ext=validate(files[i].name,arrayExtensions);
			if(!valid_ext){
				valid_extension=1;
			}
			//--------
		}
		//------- Fetch Uploaded(old) File Size -------
		var total_old_size = 0;
		$('.rpf_attachment a').each(function(i, obj) {
		     var file_size = obj.getAttribute('data-size');
		     if(file_size){
		     	total_old_size = total_old_size + (file_size/1024/1024);  // Convert Size (byte to MB)
		     }
			    
		});
		//-------------
		var total_file=(files.length + $(".rpf_attachment").length); // For Total File With (Old & New)
		var total_size = (total_old_size + b); // For Total File Size With (Old & New)
		//console.log(total_size);
		if(total_file > 5) // For Max. 5 File upload at a time
		{
			$("#img_path_id").parent().after('<div class="alert alert-mini alert-danger valid-file">Please Choose Max. 5 File</div>');
			return false;
		}
		else if(total_size > 10) // For Max 10 Mb File Size Upload
		{
			$("#img_path_id").parent().after('<div class="alert alert-mini alert-danger valid-file">Please Choose Max. 10 MB File</div>');
			return false;
		}
		else if(valid_extension == 1) // For check Valid Extension or Not
		{
			$("#img_path_id").parent().after('<div class="alert alert-mini alert-danger valid-file">Only Allowed '+arrayExtensions.join(', ')+' Extension</div>');
			return false;
		}
		else{
			return true;
		}
	}

	//---------------- For Check valid File Extension  --------------
	function validate(file,arrayExtensions) {
		var ext = file.split(".");
		ext = ext[ext.length-1].toLowerCase();      
		if (arrayExtensions.lastIndexOf(ext) == -1) {
			$("#img_path_id").val("");
			$("#img_path_txt").val("");
			return false;
		}else{
			return true;
		}
	}

	function delete_img(obj){
		var img_name = $(obj).attr('data-img');
		var rfp_id = $(obj).attr('data-rfpid');
		bootbox.confirm('Delete this image?' ,function(res){
			if(res){
				$.ajax({
					url:'<?php echo base_url()."rfp/delete_img_rfp"; ?>',
					method:'POST',
					data:{img_name:img_name,rfp_id:rfp_id},
					dataType:'JSON',
					success:function(res){
						if(res['success'] == true){
							$(obj).parent().remove();
						}
					}
				});
			}
		});

	}

</script>

