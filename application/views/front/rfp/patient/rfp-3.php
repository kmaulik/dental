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
			<!-- For Step View -->
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<ul class="process-steps nav nav-tabs nav-justified">
						<li class="active">
							<a onclick="$('#step-btn').val('0'); $('#frmrfp').submit();">1</a>
							<h5>Account Details</h5>
						</li>
						<li class="active">
							<a onclick="$('#step-btn').val('1'); $('#frmrfp').submit();">2</a>
							<h5>Consent</h5>
						</li>
						<li class="active">
							<a>3</a>
							<h5>Result</h5>
						</li>
						<li>
							<a onclick="$('#step-btn').val('3'); $('#frmrfp').submit();">4</a>
							<h5>Summary</h5>
						</li>
					</ul>
				</div>
			</div>
			<input type="hidden" name="step-btn" id="step-btn" value="">
			<!-- End For Step View -->
			<div class="row">
				<div class="col-sm-12">
					<h3 class="rfp-title">Additional Information</h3>
				</div>	
			</div>	
			<div class="row">
				<div class="col-sm-12">
					<div class="col-md-12">
						<h4>In this section you optionally can share additional data for a better quote. Share if available an x-ray, existing treatment plan as PDF, or a “selfie” of your tooth that you need help with.</h4>
					</div>	
				</div>	
			</div>	
			<div class="row">
				<div class="col-md-12 col-sm-12">	
					<div class="form-group">
						<label>Insurance Provider</label>
						<textarea name="insurance_provider" class="form-control" placeholder="Optionally, you can share your Insurance Provider and Type with the doctor in this field."><?=set_value('insurance_provider');?></textarea>
					</div>
					<?php echo form_error('insurance_provider','<div class="alert alert-mini alert-danger">','</div>'); ?>
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
				<div class="col-md-12 col-sm-12">
					<label>Further Information for our Agents</label> 
					<div class="fancy-form">
						<textarea rows="3" name="message" class="form-control char-count" data-maxlength="500" data-info="textarea-chars-info" placeholder="Share any comments you would like to provide to us."><?php echo set_value('message'); ?></textarea>
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
				<div class="col-md-12 col-sm-12 col-xs-12 text-right">
					<!-- <a href="<?=base_url('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']).'/1')?>" class="btn btn-success"><i class="fa fa-arrow-left"></i> Prev</a> -->
					<button type="submit" name="prev" value="prev" class="btn btn-success submit_data"><i class="fa fa-arrow-left"></i> Prev</button>
					<button type="submit" name="next" value="next" class="btn btn-success submit_data" value="submit"><i class="fa fa-arrow-right"></i> Next</button>
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
$('.NumbersAndDot').keyup(function () { 
    this.value = this.value.replace(/[^0-9.]/g,'');
});

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


$(".submit_data").click(function(event) {
	$(".submit_data").hide();
	$(".send_chat_loader").show();
});
</script>
