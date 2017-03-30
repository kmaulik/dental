<!--<style>
#coupan_code{
	padding-left: 12px;
}
#apply-code{
	cursor: pointer;
}
</style>-->

<section class="page-header page-header-xs">
	<div class="container">
		<h1> RFP Details </h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp');?>">RFP List</a></li>
			<li class="active">RFP Details</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section class="view-rfp">
	<div class="container">
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
		<div class="row">
			<div class="col-md-12">
				<div class="pull-right">
					<!-- Check For Submit RFP Or Not -->
					<?php if(isset($confirm_rfp) && $confirm_rfp == '1') : ?>
					<form action="" method="POST">
						<!-- <a href="<?=base_url('rfp/edit/'.encode($record['id']).'/2')?>" class="btn btn-success"><i class="fa fa-arrow-left"></i> Prev</a> -->
						<?php if($record['is_paid'] == 0) :?>
							<a class="btn btn-success" data-toggle="modal" data-target=".promotional_code"><i class="fa fa-check"></i> Submit</a>
						<?php else : ?>
							<?php if($record['status'] == 2) :?> <!-- If Status is submit pending (2) then visible button -->
								<button type="submit" name="submit" class="btn btn-success" value="submit"><i class="fa fa-check"></i> Resubmit</button>
							<?php endif; ?>
						<?php endif; ?>
					</form>	
					<?php else : ?>
					<a href="<?=base_url('rfp/view_rfp_bid/'.encode($record['id']))?>" class="btn btn-info"><i class="fa fa-eye"></i> View Proposal</a>
					<?php endif; ?>
				</div>
			</div>	
			<div class="col-md-12">
				<h3 class="rfp-main-title"><?=$record['title']?></h3>
			</div>	
			<!-- Start Common RFP View From Here -->	
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<!--  Basic Details  -->
						<div class="rfp-basic">
							<h4 class="rfp-title">Basic Details
								<!-- For check Rfp created by = session id && status < 3 (open)  then display edit button-->
								<?php if($this->session->userdata['client']['id'] == $record['patient_id'] && $record['status'] < 3): ?>
									<a href="<?=base_url('rfp/edit/'.encode($record['id']))?>" class="pull-right"><i class="fa fa-edit"></i> Edit</a>	
								<?php endif; ?>
							</h4>
							<!-- <div class="col-sm-12">
								<span class="title">RFP Title : </span> <span><?=$record['title']?></span>
							</div> -->
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
								<span class="title">Dentition Type : </span> <span><?=$record['dentition_type']?></span>
							</div>
							<div class="col-sm-6">
								<span class="title">Zip Code : </span> <span><?=$record['zipcode']?></span>
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
							<h4 class="rfp-title">Treatment Plan Information
								<!-- For check Rfp created by = session id && status < 3 (open)  then display edit button-->
								<?php if($this->session->userdata['client']['id'] == $record['patient_id'] && $record['status'] < 3): ?>
									<a href="<?=base_url('rfp/edit/'.encode($record['id']).'/1')?>" class="pull-right"><i class="fa fa-edit"></i>Edit</a>
								<?php endif;?>
							</h4>
							<?php $teeth_arr1=array(); ?>						
							<?php if(isset($record['teeth_data'])) { $teeth_arr=json_decode($record['teeth_data']); $teeth_arr1=array_keys((array)$teeth_arr); } ?>
							
							<!-- For Teeth Image -->
							<div class="col-sm-12">
								<div class="teeth-bg">
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

							<div class="col-sm-12">
								<label>Treatment Plan Total : <?php if($record['treatment_plan_total'] != '') 
								{	echo "$ ".$record['treatment_plan_total'];	} 
								else
								{	echo "N/A";	}	
								?></label> 
							</div>

						</div>	
						<!--  /Treatment Plan  -->


						<!--  Additional Information  -->
						<div class="rfp-additional rfp-info">
							<h4 class="rfp-title">Additional Information
								<!-- For check Rfp created by = session id && status < 3 (open)  then display edit button-->
								<?php if($this->session->userdata['client']['id'] == $record['patient_id'] && $record['status'] < 3): ?>
									<a href="<?=base_url('rfp/edit/'.encode($record['id']).'/2')?>" class="pull-right"><i class="fa fa-edit"></i>Edit</a>
								<?php endif;?>
							</h4>
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
							<div class="col-sm-12">
								<label>Further Information for our Agents : </label><?php if($record['message'] != '') { echo $record['message']; } else { echo 'N/A'; } ?> 
							</div>
						</div>	
						<!--  /Additional Information  -->
						
					</div>
				</div>
			</div>
			<!-- End Common RFP View -->
		</div>
	</div>
</section>


<!-- ==================== Modal Popup For Apply Promotional Code ========================= -->
<div class="modal fade promotional_code" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Apply Coupon Code</h4>
			</div>
			<form action="<?=base_url('rfp/make_payment')?>" method="POST" id="frmcoupan">
				<input type="hidden" name="is_paid" value="1">
				<input type="hidden" name="rfp_id" value="<?=encode($record['id'])?>">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h4>RFP Price : $ <?=config('patient_fees')?></h4>
							</div>	
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Coupon Code</label>
								<!-- <div class="fancy-file-upload fancy-file-success">
									<input type="text" class="form-control" name="coupan_code" id="coupan_code"/>
									<span class="button" id="apply-code">Apply Code</span>
								</div> -->
								<div class="col-sm-9">
									<input type="text" class="form-control" name="coupan_code" id="coupan_code"/>
								</div>
								<div class="col-sm-3">
									<a href="#" class="btn btn-info" id="apply-code">Apply Code </a>
								</div>	
								<span class="coupan-msg"></span>	

							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<h4>Final Price : $ <span class="final-prices"><?=config('patient_fees')?></span></h4>
							</div>
						</div>						
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-info make-payment" value="Make Payment">
							<input type="reset" name="reset" class="btn btn-default cancel-payment" value="Cancel">
						</div>	
					</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Place a Bid ========================= -->


<script>

$('#apply-code').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#apply-code').click();//Trigger search button click event
    }
});


$("#apply-code").click(function(){
	$(".coupan-msg").html('');
	var coupan_code = $("#coupan_code").val();
	if(coupan_code != ''){
		var discount_amt=0;
		$.post("<?=base_url('rfp/fetch_coupan_data')?>",{'coupan_code' : coupan_code},function(data){
			console.log(data);
			if(data != '' && data['id'] != null){
				//---------- Check apply code limit for per user ----------
				if(data['per_user_limit'] > data['total_apply_code']){
					discount_amt = 	((<?=config('patient_fees')?> * data['discount'])/100);
					var final_price = <?=config('patient_fees')?> - discount_amt;
					$(".final-prices").html(final_price);
					$(".coupan-msg").html("Coupon Code Apply Successfully");
					$(".coupan-msg").css("color", "green");
				}
				else{
					var final_price = <?=config('patient_fees')?>;
					$(".final-prices").html(final_price);
					$(".coupan-msg").html("Sorry, You Already applied this code");
					$(".coupan-msg").css("color", "red");
				}
			}else{
				var final_price = <?=config('patient_fees')?>;
				$(".final-prices").html(final_price);
				$(".coupan-msg").html("Invalid Coupon Code");
				$(".coupan-msg").css("color", "red");
			}

		},"json");
	}else{
		var final_price = <?=config('patient_fees')?>;
		$(".final-prices").html(final_price);
		$(".coupan-msg").html("Please Enter Coupon Code");
		$(".coupan-msg").css("color", "red");	
	}
});

$(".cancel-payment").click(function(){
	$('.promotional_code .close').click();
});

$(".promotional_code .close").click(function(){
	$(".final-prices").html(<?=config('patient_fees')?>);
	$("#coupan_code").val('');
	$(".coupan-msg").html('');
});

</script>