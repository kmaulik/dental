<!--<style>
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
	.check_label{
		float: right;
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
					<input type="hidden" id="dentition_type" value="<?=$this->session->userdata['rfp_data']['dentition_type'];?>">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<h3 class="rfp-title">Treatment Plan</h3>
						</div>
					</div>

					<!-- Posted Teeth values For validation and value selected for teeth and treatment category -->
					<?php  $teeth_post = $this->input->post('teeth'); ?>
					<!-- // ENDs comment  -->
					<div class="row">
						<div class="col-md-12 col-sm-12" id="primary">
							<div class="form-group">
								<div class="table-responsive">	
									<table class="table table-bordered table_custom_data">
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
												<td><label class="checkbox"><input class="toggle_cat" type="checkbox" value="<?=chr($k+$i);?>" name="teeth[]" <?php echo set_checkbox('teeth', chr($k+$i)); ?>><i></i><?=chr($k+$i);?></label> </td>
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
												<td><label class="checkbox"><input class="toggle_cat" type="checkbox" value="<?=chr($k-$i);?>" name="teeth[]" <?php echo set_checkbox('teeth', chr($k-$i));?>><i></i><?=chr($k-$i);?></label> </td>
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
												<td><label class="checkbox"><input class="toggle_cat" type="checkbox" value="<?=$i?>" name="teeth[]" <?php echo set_checkbox('teeth',$i); ?>><i></i><?=$i?></label> </td>
												<?php endfor;?>
											</tr>
											<tr>
												<?php for($i=32;$i>16;$i--) : ?>
												<td><label class="checkbox"><input class="toggle_cat" type="checkbox" value="<?=$i?>" name="teeth[]" <?php echo set_checkbox('teeth',$i); ?>><i></i> <?=$i?></label> </td>
												<?php endfor;?>
											</tr>
										</tbody>	
									</table>
								</div>	
							</div>
							<?php echo form_error('teeth[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>
					</div>	

					<div class="list_treatment_category">
						<!-- For Validation Time Data -->	
						<?php if(!empty($teeth_post)) :?>
							<?php foreach($teeth_post as $k=>$val) :?>
								<?php 
									$post_cat_id = $this->input->post('treatment_cat_id_'.$val);
									$post_cat_text = $this->input->post('treat_cat_text_'.$val);  
								?>
								<div class="row treatment_cat_<?=$val?>">
									<div class="col-sm-12">
										<div class="form-group">
											<label><span class="cat_label">Treatment Category For Teeth <?=$val?></span>
											<span class="check_label">	
											<input type="checkbox" class="toggle_text" name="chk_box_name" id="chk_box_id_<?=$val?>" value="<?=$val?>" <?php if($post_cat_text != '') { echo "checked"; }?>>	
									Not finding your category? (Tick here and manually enter)</span></label> 
											
											<select id="treatment_id_<?=$val?>" class="form-control select2" name="treatment_cat_id_<?=$val?>[]" data-placeholder="Select Treatment Category" multiple>
												<?php $post_cat=$this->input->post('treatment_cat_id_'.$val); ?>
												<?php foreach($treatment_category as $cat) :?>
													<option value="<?=$cat['id']?>" 
														<?php 
															if(isset($post_cat_id) && in_array($cat['id'],$post_cat_id)) { 
																echo "selected"; 
															}
															?>>
														<?=$cat['title']." (".$cat['code'].")"?>
													</option>
												<?php endforeach;?>
											</select>	
										</div>
									</div>
								</div>	
								
								<div class="row treat_text_area_<?=$val?>">
									<div class="col-md-12">
										<div class="form-group">
											<label>In case your doctor stated a treatment code, not in our repository, kindly manually enter it in the following field</label>
											<input type="text" name="treat_cat_text_<?=$val?>" class="form-control" value="<?=$post_cat_text;?>">
										</div>
									</div>
								</div>
								<!-- IF Extra Category Text Not Exixt then hide the textbox -->
								<?php 										
									if($post_cat_text == '') :
								?>
									<script>
										$(".treat_text_area_<?=$val?>").hide();
									</script>
								<?php endif; ?>	
								<!-- ======= -->
								<?php echo form_error('treatment_cat_id_'.$val.'[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
								<hr/>	
							<?php endforeach; ?>
						<?php endif; ?>
						<!-- For Validation Time Data -->	
					</div>	

					<!-- ========== Use For Dynamic Select2 (Default Not Display)============ -->
					<div class="treatment_category" style="display:none;">
						<div class="treatment_cat">	
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label><span class="cat_label"></span>
										<span class="check_label">	
										<input type="checkbox" class="toggle_text" name="chk_box_name" id="chk_box_id">	
									Not finding your category? (Tick here and manually enter)</span></label>
										<select id="treatment_id" class="form-control" name="treatment_cat_id[]" data-placeholder="Select Treatment Category" multiple>
											<?php foreach($treatment_category as $cat) :?>
												<option value="<?=$cat['id']?>" <?=set_select('treatment_cat_id[]', $cat['id']);?>><?=$cat['title']." (".$cat['code'].")"?></option>
											<?php endforeach;?>
										</select>	
									</div>
									<?php echo form_error('treatment_cat_id[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
								</div>
							</div>	
							<div class="row treat_text_area">
								<div class="col-md-12">
									<div class="form-group">
										<label>In case your doctor stated a treatment code, not in our repository, kindly manually enter it in the following field</label>
										<input type="text" name="treat_cat_text" class="form-control">
									</div>
								</div>
							</div>	
							<hr/>			
						</div>
					</div>	
					<!-- ========== End For Dynamic Select2 ============ -->

					<!-- For Other Treatment Category -->
					
						<div id="other">
							<div class="row">	
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<label>Other Description</label> 
										<textarea name="other_description" class="form-control" placeholder="Enter Description"><?php echo set_value('other_description'); ?></textarea>
									</div>
									<?php echo form_error('other_description','<div class="alert alert-mini alert-danger">','</div>'); ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Other Treatment Category
										<span class="check_label">		
										<input type="checkbox" class="other_treatment_cat">Not finding your category? (Tick here and manually enter)</span></label>
										<select id="other_treatment_cat_id" class="form-control select2" name="other_treatment_cat_id[]" data-placeholder="Select Treatment Category" multiple>
											<?php foreach($treatment_category as $cat) :?>
												<option value="<?=$cat['id']?>" <?=set_select('other_treatment_cat_id[]', $cat['id']) ?>><?=$cat['title']." (".$cat['code'].")"?></option>
											<?php endforeach;?>
										</select>	
									</div>
								</div>	
							</div>
							<div class="row other_treatment_cat_text" style="display:none">	
								<div class="col-md-12">
									<div class="form-group">
										<label>In case your doctor stated a treatment code, not in our repository, kindly manually enter it in the following field</label>
										<input type="text" name="other_treatment_cat_text" class="form-control">
									</div>
								</div>
							</div>	
							<?php echo form_error('other_treatment_cat_id[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>	
					
					<!-- End For Other Treatment Category -->

					<div class="row">
						<div class="col-sm-12">
							<h3 class="rfp-title">Additional Section</h3>
						</div>	
					</div>	
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<label>Additional Comments</label> 
							<div class="fancy-form">
								<textarea rows="3" name="message" class="form-control char-count" data-maxlength="500" data-info="textarea-chars-info" placeholder="Enter Additional Comments"><?php echo set_value('message'); ?></textarea>
								<i class="fa fa-comments"><!-- icon --></i>
								<span class="fancy-hint size-11 text-muted">
									<strong>Hint:</strong> 500 characters allowed!
									<span class="pull-right">
										<span id="textarea-chars-info"><span class="count-text_data">0</span>/500</span> Characters
										<script>
											var text_length=$(".char-count").val().length;
											$(".count-text_data").html(text_length);
										</script>
									</span>
								</span>
							</div>	
							<?php echo form_error('message','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>	
					</div>	


					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<label>Attachment</label>
								<div class="all_file_uploads">									
									<div class="fancy-file-upload">
										<i class="fa fa-upload"></i>
										<input type="file" id="img_path_id_1" data-id="1" class="img_upload form-control" name="img_path[]"/>
										<input type="text" id="img_path_txt_1" class="form-control" placeholder="no file selected" readonly="" />
										<span class="button">Choose File</span>
									</div>
								</div>
								<small class="text-muted block">Max Allow File : 10 & Max file size: 10 MB & Allow jpg, jpeg, png, pdf File</small>
								<a class="btn btn-primary" onclick="add_more_img()">Add</a>
								<a class="btn btn-danger" style="display:none" id="remove_btn" onclick="remove_img()">Remove</a>
							</div>
						</div>
					</div>		

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right">
							<input type="hidden" id="total_img" value="1">
							<a href="<?=base_url('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']))?>" class="btn btn-success"><i class="fa fa-arrow-left"></i> Prev</a>
							<button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Next</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>



<!-- / --> 
<script type="text/javascript">
	
	var arrayExtensions = ["jpg" , "jpeg", "png", "pdf"];

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
		} else {
			$("#permenant input[type='checkbox']").attr('checked', false);
			$("#primary input[type='checkbox']").attr('checked', false);
			$("input[name='other_description']").val('');
		}
	}
	
	//-------------------------------------------------------------------------------------------------------------------------

	function add_more_img(){
		var total_img_upload = $('.fancy-file-upload').length;		

		if(total_img_upload < 10){
			

			var fancy_html = '';
			fancy_html += '<div class="fancy-file-upload">';
			fancy_html += '<i class="fa fa-upload"></i>';
			fancy_html += '<input type="file" id="img_path_id_'+(total_img_upload+1)+'"  data-id="'+(total_img_upload+1)+'" class="form-control img_upload" name="img_path[]"/>';
			fancy_html += '<input type="text" id="img_path_txt_'+(total_img_upload+1)+'" class="form-control" placeholder="no file selected" readonly="" />';
			fancy_html += '<span class="button">Choose File</span>';
			fancy_html += '</div>';

			$('.all_file_uploads').append(fancy_html);

			if($('.fancy-file-upload').length > 1){
				$('#remove_btn').show();
			}else{
				$('#remove_btn').hide();
			}			
		}else{
			bootbox.alert('Can not enter more than 10 images.');
		}	
	}

	function remove_img(){
		$('.fancy-file-upload').last().remove();
		if($('.fancy-file-upload').length > 1){
			$('#remove_btn').show();
		}else{
			$('#remove_btn').hide();
		}
	}

	$(document).on('change','.img_upload',function(){		
		var d_id = $(this).attr('data-id');
		var files = $(this)[0].files;
		var file_text= files.length+" files selected";
		$('#img_path_txt_'+d_id).val(file_text);
	});


	//----------- For Display Treatment Category ----------
	$(".toggle_cat").click(function(e){
		var teeth_val = $(this).val();
		if($(this). prop("checked") == true) {
			var str = $(".treatment_category").html();
			str = str.replace('<span class="cat_label"></span>','<span class="cat_label"> Treatment Category For Teeth '+teeth_val+'</span>');
			str = str.replace("treatment_cat","treatment_cat_"+teeth_val);
			str = str.replace("treatment_id","treatment_id_"+teeth_val);
			str = str.replace("treatment_cat_id[]", "treatment_cat_id_"+teeth_val+"[]");

			//---------- For Text Box -------
			str = str.replace("treat_text_area","treat_text_area_"+teeth_val);
			str = str.replace("chk_box_id","chk_box_id_"+teeth_val);
			str = str.replace("treat_cat_text","treat_cat_text_"+teeth_val);
			//--------------
			$(".list_treatment_category").append(str);
			
			//---------- Assign Value to Check Box & Hide Text Box -------
			$("#chk_box_id_"+teeth_val).val(teeth_val);
			$(".treat_text_area_"+teeth_val).hide();
			//--------------

			loadScript(plugin_path + 'select2/js/select2.full.min.js', function() {			
				jQuery("#treatment_id_"+teeth_val).select2({ maximumSelectionLength: 5 });
			});

		}else{
			$("#treatment_id_"+teeth_val).select2("val", "");
			$(".treatment_cat_"+teeth_val).remove();
			$(".treat_text_area_"+teeth_val).remove();
		}
		
	});

	//--------- For Other Category textbox hide and show ------
	$(".other_treatment_cat").click(function(e) {
		if($(this). prop("checked") == true) {
			$(".other_treatment_cat_text").show();
		}else{
			$(".other_treatment_cat_text").hide();
			$("input[name=other_treatment_cat_text]").val('');
		}
	});
	//--------- End Other Category textbox hide and show ------


	//------ For Text Box Hide And Show -------
		
	$(".list_treatment_category").on('click', '.toggle_text', function() {
	   	var cat_chk_val = $(this).val();
		if($(this). prop("checked") == true) {
			$(".treat_text_area_"+cat_chk_val).show();
		}
		else{
			$(".treat_text_area_"+cat_chk_val).hide();
			$("input[name=treat_cat_text_"+cat_chk_val+"]").val('');
		}	
	});	


	// ===========Check Validation For teeth category ===============//
	// $("#frmrfp").submit(function(e){
	// 	$(".cat_error").remove();
	// 	var validation_error=0;
		
	// 	$(".toggle_cat:checkbox:checked").each(function(key){
	// 		var teeth_val = $(this).val();
	// 		var category_val= $("#treatment_id_"+teeth_val).val();
	// 		var treat_cat_text = $("input[name=treat_cat_text_"+teeth_val).val();
	// 	  	if(category_val)
	// 	  	{
	// 	  		if(category_val.length > 5){
	// 	  			var error_msg='<div class="alert alert-mini alert-danger cat_error">Only Select Max. 5 Category per Teeth.</div>';
	// 		  		$(".treatment_cat_"+teeth_val+ " hr").before(error_msg);
	// 		  		validation_error = 1;
	// 	  		}
	// 	  	}	
	// 	  	else if(treat_cat_text == ''){
	// 	  		var error_msg='<div class="alert alert-mini alert-danger cat_error">Select Atleast 1 Category For Teeth '+teeth_val+'.</div>';
	// 	  		$(".treatment_cat_"+teeth_val+ " hr").before(error_msg);
	// 	  		validation_error = 1;
	// 	  	}

	// 	});

	// 	if(validation_error != 0){
	// 		e.preventDefault();
	// 	}
	// });
	// =========== END Check Validation For teeth category ===============//

</script>


