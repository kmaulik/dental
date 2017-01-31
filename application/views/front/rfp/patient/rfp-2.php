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
  <script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/notifications/bootbox.min.js"></script>

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
	
			<div class="col-md-12">
				<form method="post" action="" id="frmrfp" enctype="multipart/form-data" onsubmit="return check_file_limit()">
					<input type="hidden" id="dentition_type" value="<?=$this->session->userdata['rfp_data']['dentition_type'];?>">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<h3 class="rfp-title">Treatment Plan</h3>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Treatment Category </label>
								<select name="treatment_cat_id[]" class="form-control select2" data-placeholder="Select Treatment Category" multiple id="treatment_cat_id">
									<?php if(isset($record['treatment_cat_id'])) { $treat_arr=explode(",",$record['treatment_cat_id']); } ?>
									<?php foreach($treatment_category as $cat) :?>
										<option value="<?=$cat['id']?>" <?php  if(isset($treat_arr)) { if(in_array($cat['id'],$treat_arr)) { echo "selected"; }} else { echo  set_select('treatment_cat_id[]', $cat['id']); } ?>><?=$cat['title']." (".$cat['code'].")"?></option>
									<?php endforeach;?>
								</select>	
							</div>

							<?php echo form_error('treatment_cat_id[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>
					</div>	
					<?php if(isset($record['teeth'])) { $teeth_arr=explode(",",$record['teeth']); } ?>
					<div class="row">
						<div class="col-md-12 col-sm-12" id="primary">
							<div class="form-group">
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
												<td><label class="checkbox"><input type="checkbox" value="<?=chr($k+$i);?>" name="teeth[]" <?php if(isset($teeth_arr)) { if(in_array(chr($k+$i),$teeth_arr)) { echo "checked"; }} else { echo set_checkbox('teeth', chr($k+$i)); }?>><i></i><?=chr($k+$i);?></label> </td>
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
												<td><label class="checkbox"><input type="checkbox" value="<?=chr($k-$i);?>" name="teeth[]" <?php if(isset($teeth_arr)) { if(in_array(chr($k-$i),$teeth_arr)) { echo "checked"; }} else { echo set_checkbox('teeth', chr($k-$i)); }?>><i></i><?=chr($k-$i);?></label> </td>
												<?php endfor; ?>
												<td></td>
												<td></td>
												<td></td>
												</tr>
										</tbody>	
									</table>
								</div>	
							</div>
							<?php echo form_error('teeth[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>		
						<div class="col-md-12 col-sm-12" id="permenant">
							<div class="form-group">
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
												<td><label class="checkbox"><input type="checkbox" value="<?=$i?>" name="teeth[]" <?php if(isset($teeth_arr)) { if(in_array($i,$teeth_arr)) { echo "checked"; }} else { echo set_checkbox('teeth',$i); }?>><i></i><?=$i?></label> </td>
												<?php endfor;?>
											</tr>
											<tr>
												<?php for($i=32;$i>16;$i--) : ?>
												<td><label class="checkbox"><input type="checkbox" value="<?=$i?>" name="teeth[]" <?php if(isset($teeth_arr)) { if(in_array($i,$teeth_arr)) { echo "checked"; }} else { echo set_checkbox('teeth',$i); }?>><i></i> <?=$i?></label> </td>
												<?php endfor;?>
											</tr>
										</tbody>	
									</table>
								</div>	
							</div>
							<?php echo form_error('teeth[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>
					</div>	
					<div class="row">	
						<div class="col-md-12 col-sm-12" id="other">
							<div class="form-group">
								<label>Other Description</label> 
								<textarea name="other_description" class="form-control" placeholder="Enter Description"><?php echo (isset($record['other_description'])? $record['other_description'] : set_value('other_description')); ?></textarea>
							</div>
							<?php echo form_error('other_description','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<h3 class="rfp-title">Additional Section</h3>
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
											if(file_exists($file_name)) {
											    $file_size= filesize($file_name);	
											}else{
												$file_size= 0;	
											}
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
								<small class="text-muted block">Max Allow File : 5 & Max file size: 10 MB & Allow jpg, jpeg, png, pdf File</small>
							</div>
						</div>
					</div>		

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
fetch_definition_data();

function fetch_definition_data(){

	$("#primary").hide();
	$("#permenant").hide();
	$("#other").hide();

	if($("#dentition_type").val() == 'primary'){
		$("#permenant input[type='checkbox']").attr('checked', false);
		$("input[name='other_description']").val('');
		$("#primary").show();
	}
	else if($("#dentition_type").val() == 'permenant'){
		$("#primary input[type='checkbox']").attr('checked', false);
		$("input[name='other_description']").val('');
		$("#permenant").show();
	}
	else if($("#dentition_type").val() == 'other'){
		$("#permenant input[type='checkbox']").attr('checked', false);
		$("#primary input[type='checkbox']").attr('checked', false);
		$("#other").show();
	}
	else{
		$("#permenant input[type='checkbox']").attr('checked', false);
		$("#primary input[type='checkbox']").attr('checked', false);
		$("input[name='other_description']").val('');
		$("#primary").hide();
		$("#permenant").hide();
		$("#other").hide();
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


