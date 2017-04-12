<section class="page-header page-header-xs">
	<div class="container">
		<h1> Treatment Plan </h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp/search_rfp');?>">Search Request</a></li>
			<li class="active">Treatment Plan</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section class="view-rfp">
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
				<div class="pull-right">
					<!-- ====== For Check Payment by doctor ====== -->
					
					<!-- ====== End For Check Payment by doctor  ====== -->
					
					<!-- ====== For Check Bid Already Placed Or Not  ====== -->
					<?php if(isset($rfp_bid) && $rfp_bid != '') :?>
						<?php if($record['status'] == 4 && $rfp_bid['status'] == '2') :?>
							<a href="<?=base_url('dashboard?proceed_rfp='.encode($record['id']))?>" class="btn btn-info"><i class="fa fa-check"></i> Payment</a>
						<?php endif; ?>

						<!-- ====== For Check chat is started or not ====== -->
						<?php if($rfp_bid['is_chat_started'] == '1') : ?>
							<a href="<?=base_url('messageboard/message/'.encode($record['id']).'/'.encode($record['patient_id']))?>" class="btn btn-info"><i class="fa fa-envelope"></i> Message</a>
						<?php endif; ?>
						<!-- ====== End Check chat is started or not ====== -->	


					<?php else : ?>
						<!-- ====== For Check RFP status Open or not ====== -->
						<?php if($record['status'] == 3 && $record['rfp_valid_date'] >= date("Y-m-d")) : ?> <!-- 3 Means Open RFP & rfp_valid_date >= date) For this RFP then show bid button -->
							<a class="btn btn-success" data-toggle="modal" data-target=".manage_bid" id="place_bid"><i class="fa fa-plus"></i> Place Bid</a>
						<?php endif; ?>
						<!-- ====== End Check RFP status Open or not ====== -->
					<?php endif; ?>
					<!-- ====== End Check Bid Already Placed Or Not  ====== -->
					<a href="<?php echo base_url().'dashboard'; ?>" class="btn btn-info">
						<i class="fa fa-arrow-left"></i> 
						Back to Dashboard 
					</a>
					<a href="<?php echo base_url().'rfp/search_rfp'; ?>" class="btn btn-info">
						<i class="fa fa-arrow-left"></i> 
						Back to Request
					</a>
				</div>
			</div>	
			<div class="col-md-12">
				<h3 class="rfp-main-title"><?=$record['title']?></h3>
			</div>	
			<!-- Start Common RFP View From Here -->		
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<!-- My Bid Information ONLY for Doctor -->
						<?php if(!empty($rfp_bid)) { ?>
							<div class="my-bid-doctor">
								<h4 class="rfp-title">My Bid Information</h4>
								<div class="col-sm-12 col-md-6">						
									<span class="title">Bid Value ($) : </span>
									<span><?php echo '$ '.$rfp_bid['amount']; ?></span>
								</div>

								<div class="col-md-12 col-sm-12 bid-title">								
									<span class="title">Bid Description : </span>
									<span><?php echo $rfp_bid['description']; ?></span>
								</div>
							</div>
						<?php } ?>		
						<!-- End My Bid Information ONLY for Doctor -->
						<!--  Basic Details  -->
						<div class="rfp-basic">
							<h4 class="rfp-title">Basic Details</h4>

							<!-- For Check doctor is pay the money for this rfp or not -->
							<?php if($is_allow_rfp_info == 1) {?>
								<div class="col-sm-6">
									<span class="title">Created By : </span> <span><?=fetch_username($record['patient_id'])?></span>
								</div>
								<div class="col-sm-6">
									<span class="title">Patient Name : </span> <span><?=$record['fname']." ".$record['lname']?></span>
								</div>	
								<div class="col-sm-6">
									<span class="title">BirthDate : </span> 
									<span>
										<?=date("m-d-Y",strtotime($record['birth_date']));?>
									</span>
								</div>
								<div class="col-sm-6">
									<span class="title">Zip Code : </span> <span><?=$record['zipcode']?></span>
								</div>
							<?php } ?>
							<!-- End For Check doctor is pay the money for this rfp or not -->
							<div class="col-sm-6">
								<span class="title">Dentition Type : </span> <span><?=$record['dentition_type']?></span>
							</div>
							<div class="col-sm-6">
								<span class="title">Age : </span>
								<span>
									<?php
										$birthday = new DateTime($record['birth_date']);
										$interval = $birthday->diff(new DateTime);
										echo $interval->y.' years';
									?>
								</span>
							</div>
							<!-- ======= For Display distance to doctor ======= -->
							<?php if(isset($record['distance'])) :?>
								<div class="col-sm-6">
									<span class="title">Distance (Miles) : </span>
									<span><?=round($record['distance'],2)?></span>
								</div>
							<?php endif; ?>
							<!-- ======= End For Display distance to doctor ======= -->
											

						</div>	
						<!--  /Basic Details  -->

						<!--  Medical History  -->
						<div class="rfp-history">
							<h4 class="rfp-title">Medical History</h4>
							<div class="col-sm-12">
								<label>Known Allergies : </label><span> <?=$record['allergies']?></span>
							</div>
							<div class="col-sm-12">
								<label>Full Medication List : </label><span> <?=$record['medication_list']?></span>
							</div>
							<div class="col-sm-12">
								<label>Any heart problems including blood pressure? : </label> <span><?=$record['heart_problem']?><span>
							</div>
							<div class="col-sm-12">
								<label>Any history of chemo/radiation ? : </label><span> <?=$record['chemo_radiation']?></span>
							</div>	
							<div class="col-sm-12">
								<label>Surgery occurred during the last two years. : </label><span> <?=$record['surgery']?></span>
							</div>
						</div>	
						<!--  /Medical History  -->
						
						<!--  Treatment Plan  -->
						<div class="rfp-treatment">
							<h4 class="rfp-title">Treatment Plan Information</h4>
							<?php $teeth_arr1=array(); ?>						
							<?php if(isset($record['teeth_data'])) { $teeth_arr=json_decode($record['teeth_data']); $teeth_arr1=array_keys((array)$teeth_arr); } ?>
							
							<!-- For Teeth Image -->
							<div class="">
								<div class="teeth-bg">
									<div class="upper-right">Upper Right</div>
									<div class="upper-left">Upper left</div>
									<div class="lower-right">Lower Right</div>
									<div class="lower-left">Lower left</div>
									<?php for($i=1;$i<=32;$i++) : ?>
										<span id="t<?=$i?>">
											<span class="checkbox-wrapper">
												<label>
													<input type="checkbox" disabled value="<?=$i?>" name="teeth[]" class="toggle_cat" <?php if(in_array($i,$teeth_arr1)) { echo "checked"; }?>>
													<span class="checked-bg"></span>
												</label>
											</span>
										</span>
									<?php endfor; ?>
								</div>
							</div>
							<!-- End For Teeth Image -->

							<?php if(!empty($teeth_arr)) : ?>
								<?php foreach($teeth_arr as $key=>$val) :?>
									<!-- ===== For Tratment Category === -->
									<div class="col-sm-12">
										<label>Treatment Category For Teeth : <?=$key?></label> 
										<ul>
											<?php if(isset($val->cat_id)) :?>
												<?php foreach($val->cat_id as $category) :?>
													<li><?= fetch_row_data('treatment_category',['id' => $category],'title') ?> [<?= fetch_row_data('treatment_category',['id' => $category],'code') ?>]</li>
												<?php endforeach; ?>
											<?php else : ?>
												<li> N/A</li>	
											<?php endif; ?>	
										</ul>
									</div>
									<!-- ===== End Tratment Category === -->
									<!-- ===== For Check Manual Category Exist or not === -->
									<?php if($val->cat_text != '') :?>
									<div class="col-sm-12 manual_category">
										<label>Manual Category For Teeth : <?=$key?></label> 
											<?= $val->cat_text;?>
									</div>	
									<?php endif; ?>
									<!-- ===== End Check Manual Category Exist or not === -->
								<?php endforeach; ?>
							<?php endif; ?>

							<div class="col-sm-12">
								<label>Treatment Description : </label> <?php if($record['other_description'] != '') { echo $record['other_description']; } else { echo 'N/A'; } ?> 	
							</div>

						</div>	
						<!--  /Treatment Plan  -->

						<!--  Financial Information  -->
						<div class="rfp-additional rfp-info">
							<h4 class="rfp-title">Additional Information</h4>
							<div class="col-sm-12">
								<label>Insurance Provider : </label> 
								<?php if($record['insurance_provider'] != '') 
								{	echo $record['insurance_provider'];	} 
								else
								{	echo "N/A";	}	
								?>
							</div>
							<div class="col-sm-12 col_custom">
								<label>Attachment : </label>
								<?php $attach_arr= explode("|",$record['img_path']);
								// Check Attachment found or not 
								if(isset($attach_arr[0]) && $attach_arr[0] != '') : ?>
								<div class="text-center">
									<div class="owl-carousel owl-padding-1 nomargin buttons-autohide controlls-over" data-plugin-options='{"singleItem": false, "items": "3", "autoPlay": 3500, "navigation": true, "pagination": false}'>
										<?php foreach($attach_arr as $attach) : ?>
											<div class="item-box">
												<figure>
													<span class="item-hover">
														<span class="overlay dark-5"></span>
														<span class="inner">

															<!-- lightbox -->
															<?php $ext=explode(".",$attach);  
															if(isset($ext) && $ext[1] != 'pdf') { ?>
																<a class="ico-rounded lightbox" href="<?=base_url('uploads/rfp/'.$attach)?>" data-plugin-options='{"type":"image"}'>
																	<span class="fa fa-plus size-20"></span>
																</a>
															<?php } ?>
															<!-- details -->
															<a class="ico-rounded" href="<?=base_url('uploads/rfp/'.$attach)?>" target="_blank">
																<span class="glyphicon glyphicon-option-horizontal size-20"></span>
															</a>
														</span>
													</span>
													
													<?php if(isset($ext) && $ext[1] == 'pdf') { ?>
													<img class="img-responsive" src="<?=DEFAULT_IMAGE_PATH.'document-file.jpg'?>" width="600" height="399" alt="">	
													<?php } else { ?>
													<img class="img-responsive" src="<?=base_url('uploads/rfp/'.$attach)?>" width="600" height="399" alt="">
													<?php } ?>
												</figure>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
								<?php else : ?>
									N/A	
								<?php endif;?>
							</div>
						</div>	
						<!--  /Financial Information  -->
						
					</div>
				</div>
			</div>
			<!-- End Common RFP View -->
		</div>
	</div>
</section>

<!-- ==================== Modal Popup For Place a Bid ========================= -->
<div class="modal fade manage_bid" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Place Bid</h4>
			</div>
			<form action="<?=base_url('rfp/manage_bid')?>" method="POST" id="frmbid">
				<input type="hidden" name="rfp_id" id="rfp_id">
				<input type="hidden" name="rfp_bid_id" id="rfp_bid_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<label>Amount ($)</label>
							<div class="form-group">
								<input type="text" name="amount" id="amount" class="form-control NumbersAndDot">
							</div>	
						</div>
						<div class="col-sm-12">
							<label>Description (Optionally share a comment for the patient to specify your treatment)</label>
							<div class="form-group">
								<textarea name="description" id="description" class="form-control" rows="5"></textarea>
							</div>	
						</div>		
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-info custom-submit" value="Submit">
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
						</div>	
					</div>	
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Place a Bid ========================= -->
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/additional_methods.min.js"; ?>"></script>
<?php 	
	$description = str_replace(array("\r","\n"),"",$rfp_bid['description']);
?>
<script>
$('.NumbersAndDot').keyup(function () { 
    this.value = this.value.replace(/[^0-9.]/g,'');
});

$("#place_bid").click(function(){
	$("#rfp_id").val(<?=$record['id']?>);
});

$("#update_bid").click(function(){
	$("#rfp_id").val(<?=$record['id']?>);
	$("#rfp_bid_id").val(<?=$rfp_bid['id']?>);
	$("#amount").val("<?=$rfp_bid['amount']?>");
	$("#description").val("<?= $description?>");

	//---------- For Read Only when update bid ----
	$('#amount').prop('readonly', true);
	$('#description').prop('readonly', true);
	$('.custom-submit').hide();
	//---------------------------------------------
});

//---------------------- Validation -------------------
$("#frmbid").validate({
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    rules: {
        amount: {
            required: true,
        },
        // description: {
        //     required: true
        // }
    },
    messages: {
        amount: {
            required: "Please provide a Amount"
        },
        // description: {
        //     required: "Please provide a Description"
        // }
    }
});
</script>

