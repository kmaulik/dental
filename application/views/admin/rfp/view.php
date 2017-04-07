<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/media/fancybox.min.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/gallery.js"></script>

<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/form_inputs.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/selects/select2.min.js"></script>

<style>
	.rfp-title{
		border-bottom: 2px solid gray;
	    margin-bottom: 0px;
	    margin-top: 10px;
	}
	.teeth th{
		text-align: center;
		color: #000;
		font-size: 15px;
	}
	.teeth td{
		padding: 12px !important;
	}
	h4.rfp-title {
	    margin-bottom: 20px;
	    border-bottom: 1px solid #ccc;
	    padding-bottom: 10px;
	}
	.rfp-basic,.rfp-history, .rfp-treatment,.rfp-additional {
	    display: inline-block;
	    width: 100%;
	    margin-bottom: 10px;
	}
	.rfp-history .col-sm-12, .rfp-additional .col-sm-12 {
	    margin-bottom: 20px;
	    line-height: 16px;
	}
	label {
	    font-size: 15px;
	    font-weight: 600;
	}
	.rfp-additional a img {
	    border: 2px solid #ccc;
	    padding: 2px;
	}
	.rfp-additional a {
	    margin-right: 10px;
	}
	.col_custom label {
	    display: block;
	    margin-bottom: 10px;
	}
	.col_custom .thumbnail {
	    float: left;
	    margin-right: 10px;
	}
	.manual_category{
		padding-left: 40px;
	}
	.label-dark-blue{
		background: #4765a0 !important;
	}
</style>

<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - <?php echo $heading; ?></h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
			<li><a href="<?php echo site_url('admin/rfp'); ?>">Request</a></li>
			<li class="active"><?php echo $heading; ?></li>
		</ul>
	</div>
</div>
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-flat">
				<div class="panel-body">

					<div class="rfp-history">
						<h4 class="rfp-title">Previous Admin or Agent Remarks</h4>
						<?php
							$last_remark = $record['admin_remarks'];
							if(!empty($last_remark)){
								$last_remark_arr = json_decode($last_remark,true);													
								$last_remark_arr = end($last_remark_arr);
								// pr(end($last_remark_arr));
						?>
							<div class="col-sm-12">								
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_theme_primary">
									<i class="icon-alarm-add position-right"></i>
									View History
								</button>
							</div>
							<div class="col-sm-12">
								<label>Total Attempt No : </label> 
								<?php echo $last_remark_arr['attempt_no']; ?>
							</div>
							<div class="col-sm-12">
								<label>Last Send message : </label> 
								<?php echo $last_remark_arr['last_message']; ?>
							</div>
							<div class="col-sm-12">
								<label>Last Remark by admin : </label> 
								<?php echo $last_remark_arr['last_remarks']; ?>
							</div>												
							<div class="col-sm-12">
								<label>Last Action Date: </label> 
								<?php 
									echo '&nbsp;&nbsp;'.date('d/m/Y',strtotime($last_remark_arr['last_action']));
									echo ' ( '.get_no_of_days($last_remark_arr['last_action']).' Days before)';
								?>
							</div>
							<div class="col-sm-12">
								<label>Last Review by : </label> 
								<?php echo $last_remark_arr['last_action_by']; ?>
							</div>
						<?php } else { ?>
							<div class="col-sm-12">
								No  Remarks Yet													
							</div>
						<?php } ?>
					</div>						

					<?php if($record['status'] == '1') { ?>
						<!--  Additional Section -->
						<div class="rfp-additional" id="action_choose">
							<h4 class="rfp-title">Your Action</h4>
							<div class="col-sm-12">
								<a class="btn btn-success" onclick="$('#action_div').slideDown(); $('#action_choose').slideUp();">
									Choose your Action 
								</a>
							</div>
						</div>	
						<!-- /Additional Section  -->
						
						<div class="col-md-12" id="action_div" style="display:none" >
				            <form class="form-horizontal form-validate" id="frm_rfp_action" method="POST" 
				            	  action="<?php echo base_url().'admin/rfp/choose_action/'.encode($rfp_id);  ?>">
				                <div class="panel panel-flat">
				                    <div class="panel-body">
				                        <div class="form-group">
				                            <label class="col-lg-3 control-label">Action :</label>
				                            <div class="col-lg-3">
				                                <select name="action" class="form-control select" id="action" onchange="fetch_pre_drafted_text()">
				                                    <option value="no">Dis-Approve</option>
				                                    <option value="yes">Approve</option>
				                                </select>
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <label class="col-lg-3 control-label">
				                                    Your message:<br/>
				                                    <small style="color:red">( This message will sent it to patient in mail.)</small>
				                             </label>
				                            <div class="col-lg-3">
				                                <textarea rows="4" name="message" class="form-control" placeholder="Message...." id="pre_drafted_text"></textarea>
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <label class="col-lg-3 control-label">
				                                    Admin Remarks:<br/>                                    
				                             </label>
				                            <div class="col-lg-3">
				                                <textarea rows="4" name="remarks" class="form-control" placeholder="Remarks...."></textarea>
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <label class="col-lg-3 control-label">
				                                    
				                             </label>
				                            <div class="col-lg-3">
				                                <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
				                                <a class="btn btn-default" 
				                                	onclick="$('#action_div').slideUp(); $('#action_choose').slideDown();">Cancel</a>
				                            </div>
				                        </div>				                        
				                    </div>
				                </div>
				            </form>
				        </div>


					<?php } ?>
																			
					<!--  Basic Details  -->
					<div class="rfp-basic">
						<h4 class="rfp-title">Basic Details</h4>
						<div class="col-sm-6">
							<label>Request Title : </label> <?=$record['title']?>
						</div>
						<div class="col-sm-6">
							<label>Created By : </label> <?=fetch_username($record['patient_id'])?>
						</div>
						<div class="col-sm-6">
							<label>First Name : </label> <?=$record['fname']?>
						</div>	
						<div class="col-sm-6">
							<label>Last Name : </label> <?=$record['lname']?>
						</div>
						<div class="col-sm-6">
							<label>BirthDate : </label> <?=$record['birth_date']?>
						</div>
						<div class="col-sm-6">
							<label>Dentition Type : </label> <?=$record['dentition_type']?>
						</div>
						<div class="col-sm-6">
							<label>Travel Distance : </label> <?=$record['distance_travel']." Miles"?>
						</div>
						<div class="col-sm-6">
							<label>Request Status : </label> 
							<?php if($record['status'] == 0) :?>
								<span class="label label-default">Quote Request Draft</span>
							<?php elseif($record['status'] == 1) : ?>
								<span class="label label-primary">Quote Request Pending</span>
							<?php elseif($record['status'] == 2) : ?>
								<span class="label label-danger">Patient Review</span>
							<?php elseif($record['status'] == 3) : ?>
								<span class="label label-info">Quote Request Received</span>
							<?php elseif($record['status'] == 4) : ?>
								<span class="label label-warning">Doctor Confirmation Pending</span>	
							<?php elseif($record['status'] == 5) : ?>
								<span class="label label-primary">Appointment Pending</span>			
							<?php elseif($record['status'] == 6) : ?>
								<span class="label label-dark-blue">Service in Progress</span>
							<?php elseif($record['status'] == 7) : ?>
								<span class="label label-success">Closed</span>					
							<?php endif; ?>
						</div>
					</div>	
					<!--  /Basic Details  -->

					<!--  Medical History  -->
					<div class="rfp-history">
						<h4 class="rfp-title">Medical History</h4>
						<div class="col-sm-12">
							<label>Known Allergies : </label> <?=$record['allergies']?>
						</div>
						<div class="col-sm-12">
							<label>Full Medication List : </label> <?=$record['medication_list']?>
						</div>
						<div class="col-sm-12">
							<label>Any heart problems including blood pressure? : </label> <?=$record['heart_problem']?>
						</div>
						<div class="col-sm-12">
							<label>Any history of chemo/radiation ? : </label> <?=$record['chemo_radiation']?>
						</div>
						<div class="col-sm-12">
							<label>Surgery occurred during the last two years. : </label> <?=$record['surgery']?>
						</div>
					</div>	
					<!--  /Medical History  -->

					<!--  Treatment Plan  -->
					<div class="rfp-treatment">
						<h4 class="rfp-title">Treatment Plan Information</h4>

						<?php
						if(isset($record['teeth_data'])) { $teeth_arr=json_decode($record['teeth_data']); $teeth_arr1=array_keys((array)$teeth_arr); } ?>
							
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
					<div class="rfp-additional">
						<h4 class="rfp-title">Additional Information</h4>
						<div class="col-sm-12">
							<label>Insurance Provider : </label> 
							<?php if($record['insurance_provider'] != '') 
							{	echo $record['insurance_provider'];	} 
							else
							{	echo "N/A";	}	
							?>
						</div>

						<!-- For Attachment -->
						<form method="post" action="<?php echo base_url().'admin/rfp/move_to_private'; ?>" >
							<div class="col-sm-12 col_custom">
								<label>Attachment (Public): </label>
								<?php 

									$attach_arr = [];
									$attach_arr_private = [];

									if(!empty($record['img_path'])){ $attach_arr= explode("|",$record['img_path']); }
									if(!empty($record['private_img_path'])){ $attach_arr_private= explode("|",$record['private_img_path']); }

									// Check Attachment found or not 								
									if(!empty($attach_arr)) : ?>
									<?php 
										foreach($attach_arr as $attach) : 										
									?>
										<div class="thumbnail">
											<div class="thumb">
												<?php $ext=explode(".",$attach); 
												if(isset($ext) && $ext[1] == 'pdf') { ?>
													<img src="<?=DEFAULT_IMAGE_PATH.'document-file.jpg'?>" alt="" style="height:150px;width:150px;">
												<?php } else { ?>
													<img src="<?=base_url('uploads/rfp/'.$attach)?>" alt="" style="height:150px;width:150px;">
												<?php } ?>
												<div class="caption-overflow">
													<span>
														<?php if(isset($ext) && $ext[1] != 'pdf') { ?>
														<a href="<?=base_url('uploads/rfp/'.$attach)?>" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>
														<?php } ?>
														<a href="<?=base_url('uploads/rfp/'.$attach)?>" target="_blank" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-link2"></i></a>
													</span>
												</div>
											</div>
											<input type="checkbox" value="<?php echo $attach; ?>" name="rfp_images[]" class="styled" >
										</div>

									<?php endforeach; ?>
								<?php else : ?>
									N/A	
								<?php endif;?>
							</div>
							<input type="hidden" name="rfp_id" value="<?php echo $rfp_id; ?>">
							<?php if(!empty($attach_arr)) { ?>
								<input type="submit" class="btn btn-primary" value="Move to Private">
							<?php } ?>
							<br/>							
							<br/>
						</form>
						
						<form action="<?php echo base_url().'admin/rfp/move_to_public'; ?>" method="post">
							<div class="col-sm-12 col_custom">
								<label>Attachment (Private) : </label>
								<?php 															
									// Check Attachment found or not 								
									if(!empty($attach_arr_private)) : 
										// pr($attach_arr_private);
								?>
									<?php 
										foreach($attach_arr_private as $attach_p) : 										
									?>
										<div class="thumbnail">
											<div class="thumb">
												<?php $ext=explode(".",$attach_p); 
												if(isset($ext) && $ext[1] == 'pdf') { ?>
													<img src="<?=DEFAULT_IMAGE_PATH.'document-file.jpg'?>" alt="" style="height:150px;width:150px;">
												<?php } else { ?>
													<img src="<?=base_url('uploads/rfp/'.$attach_p)?>" alt="" style="height:150px;width:150px;">
												<?php } ?>
												<div class="caption-overflow">
													<span>
														<?php if(isset($ext) && $ext[1] != 'pdf') { ?>
														<a href="<?=base_url('uploads/rfp/'.$attach_p)?>" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>
														<?php } ?>
														<a href="<?=base_url('uploads/rfp/'.$attach_p)?>" target="_blank" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-link2"></i></a>
													</span>
												</div>
											</div>
											<input type="checkbox" value="<?php echo $attach_p; ?>" name="rfp_images[]" class="styled" >
										</div>
									<?php endforeach; ?>
								<?php else : ?>
									N/A	
								<?php endif;?>
							</div>
														
							<input type="hidden" name="rfp_id" value="<?php echo $rfp_id; ?>">
							<?php if(!empty($attach_arr_private)) { ?>
								<input type="submit" class="btn btn-primary" value="Move to Public">
							<?php } ?>
						</form>
						<!-- End For Attachment -->
						<br/>
						<div class="col-sm-12">
							<label>Further Information for our Agents : </label><?=$record['message'] ?> 
						</div>
					</div>	
					<!--  /Additional Information  -->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Primary modal -->
<div id="modal_theme_primary" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h6 class="modal-title">History of Request Reviews</h6>
			</div>

			<div class="modal-body">
				<?php
					$last_remark = $record['admin_remarks'];
					if(!empty($last_remark)){
						$last_remark_arr = json_decode($last_remark,true);
						// pr($last_remark_arr);
						$last_cnt =  count($last_remark_arr);
						foreach($last_remark_arr as $l_arr){
							$style='border-bottom:1px dotted black; margin-bottom:10px;';
							if($last_cnt == $l_arr['attempt_no']){
								$style = '';
							}
				?>
						<div class="col-sm-12">
							<label>Total Attempt No : </label> 
							<?php echo $l_arr['attempt_no']; ?>
						</div>
						<div class="col-sm-12">
							<label>Last Send message : </label> 
							<?php echo $l_arr['last_message']; ?>
						</div>
						<div class="col-sm-12">
							<label>Last Remark by admin : </label> 
							<?php echo $l_arr['last_remarks']; ?>
						</div>												
						<div class="col-sm-12">
							<label>Last Action Date: </label> 
							<?php 
								echo '&nbsp;&nbsp;'.date('d/m/Y',strtotime($l_arr['last_action']));
								echo ' ( '.get_no_of_days($l_arr['last_action']).' Days before)';
							?>
						</div>
						<div class="col-sm-12" style="<?php echo $style; ?>">
							<label>Last Review by : </label> 
							<?php echo $l_arr['last_action_by']; ?>
						</div>					

				<?php } } ?>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>				
			</div>
		</div>
	</div>
</div>
<!-- /primary modal -->


<script type="text/javascript">

    $(function() {        
        // Fixed width. Single select
        $('.select').select2({
            minimumResultsForSearch: Infinity,
            width: 250            
        });
        fetch_pre_drafted_text(); // For fetch predrafted text based on rfp action
    });

    //--------------- Fetch Predrafted Text --------------
    function fetch_pre_drafted_text(){
    	var field='';
    	var action = $("#action").val(); 
    	if(action == 'yes'){
    		field='rfp_approve_text';
    	}else{
    		field='rfp_dis_approve_text';
    	}
    	$.post("<?=base_url('admin/rfp/fetch_pre_drafted_text')?>",{'key':field},function(data){
    		if(data){
    			$("#pre_drafted_text").val(data);
    		}else{
    			$("#pre_drafted_text").val('');
    		}
    	});
    }
    //------------ End Fetch Predrafted Text ------------- 
 

    // fname ,lname
    // city country_id zipcode gender
    //---------------------- Validation -------------------
    $("#frm_rfp_action").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);            
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);            
        },
        validClass: "validation-valid-label",
        ignore:[],
        rules: {
            // remarks:{required: true },
            message:{required: true }
        },        
        messages: {
            // remarks:{required: 'Please provide a Remarks..' },
            message:{required: 'Please provide a Message..'}
        }
    });
</script>