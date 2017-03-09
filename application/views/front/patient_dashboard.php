<link rel="stylesheet" href="<?=DEFAULT_CSS_PATH?>jquery.rateyo.min.css">
<script src="<?=DEFAULT_JS_PATH?>jquery.rateyo.min.js"></script>
<section class="page-header page-header-xs">
	<div class="container">
		<h1>Dashboard</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Dashboard</li>
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
				<h1>WelCome To Dashboard</h1>	
			</div>	
			
		</div>

		<!-- <div class="row">

			<div class="col-md-4">
				<div class="box-flip box-icon box-icon-center box-icon-round box-icon-large text-center">
					<div class="front">
						<div class="box1">
							<div class="box-icon-title">
								<i class="fa fa-tint"></i>
								<h2>Fully Reposnive</h2>
							</div>
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
						</div>
					</div>

					<div class="back">
						<div class="box2">
							<h4>BACK SIDE</h4>
							<hr />
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
							<a href="#" class="btn btn-translucid btn-lg btn-block">PURCHASE NOW</a>
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-4">

				<div class="box-flip box-icon box-icon-center box-icon-round box-icon-large text-center">
					<div class="front">
						<div class="box1">
							<div class="box-icon-title">
								<i class="fa fa-random"></i>
								<h2>Clean Design</h2>
							</div>
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
						</div>
					</div>

					<div class="back">
						<div class="box2">
							<h4>BACK SIDE</h4>
							<hr />
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
							<a href="#" class="btn btn-translucid btn-lg btn-block">PURCHASE NOW</a>
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-4">

				<div class="box-flip box-icon box-icon-center box-icon-round box-icon-large text-center">
					<div class="front">
						<div class="box1">
							<div class="box-icon-title">
								<i class="fa fa-cogs"></i>
								<h2>Multipurpose</h2>
							</div>
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
						</div>
					</div>

					<div class="back">
						<div class="box2">
							<h4>BACK SIDE</h4>
							<hr />
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
							<a href="#" class="btn btn-translucid btn-lg btn-block">PURCHASE NOW</a>
						</div>
					</div>
				</div>

			</div>

		</div> -->

		<!-- Active RFP For this patient Table -->
		<div class="row active_rfp">
			<div class="col-md-12 firrst_ul">
				<h4>Active RFP
				<a href="<?=base_url('rfp/add');?>" class="custom_btn_plus">
					<i class="fa fa-plus"></i>Create RFP
				</a>	
				</h4>	
			
			</div>	
			<div class="col-md-12 rfp_table_layout">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th></th>
								<th>#</th>
								<th>RFP Title</th>
								<th>User Name</th>
								<th>RFP Status</th>
								<th>Total Bid</th>
								<th>% Saving of lowest bid</th>
								<th>Expire Date</th>
								<th>Extended</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(count($active_rfp_list) > 0) :?>
								<?php foreach($active_rfp_list as $key=>$active_rfp) :?>
									<tr class="<?php if($key >= 3) { echo "active_rfp_data"; } ?>">
										<td>
											<?php if(count($active_rfp['bid_data']) > 0) :?>
												<a id="view_bid_data_<?=$key?>" class="view_bid_data" data-id="<?=$key?>" ><i class="fa fa-plus"></i></a>
												<a id="hide_bid_data_<?=$key?>" class="hide_bid_data" data-id="<?=$key?>"><i class="fa fa-minus"></i></a>
											<?php endif; ?>
										</td>
										<td><?=$key+1?></td>
										<td><?=$active_rfp['title']?></td>
										<td><?=$active_rfp['fname']." ".$active_rfp['lname']?></td>
										<td><?=rfp_status_label($active_rfp['status']); ?></td>
										<td><?=$active_rfp['total_bid']?></td>
										<td>
											<?php if($active_rfp['treatment_plan_total'] != '' && $active_rfp['min_bid_amt'] != '') :?>
												<?php $Total_save = 100 - round((($active_rfp['min_bid_amt']*100) / $active_rfp['treatment_plan_total']),2); ?>
												<?php if($Total_save > 0) :?>
													<span class="label label-success total_save">+<?=$Total_save?> %</span>
												<?php else :?>
													<span class="label label-danger total_save"><?=$Total_save?> %</span>
												<?php endif; ?>
											<?php else : ?>
												N/A
											<?php endif; ?>
										</td>
										<td><?=isset($active_rfp['rfp_valid_date'])?date("m-d-Y",strtotime($active_rfp['rfp_valid_date'])):'N/A'?></td>
										<td>
											<?php if($active_rfp['is_extended'] == 1) :?>	
											Yes
											<?php else : ?>
											No
											<?php endif; ?>
										</td>
										<td>
											<a href="<?=base_url('rfp/view_rfp/'.encode($active_rfp['id']))?>" class="label label-info rfp-price" data-toggle="tooltip" data-placement="top" data-original-title="View RFP"><i class="fa fa-eye"></i></a>
											<!-- For Check valid date set and valid date >= today and patient validity not extend then display extend button--> 
											<?php if($active_rfp['status'] == 3 &&  $active_rfp['rfp_valid_date'] != '' && $active_rfp['rfp_valid_date'] >= date("Y-m-d") && $active_rfp['is_extended'] == 0) :?>
												<a href="<?=base_url('rfp/extend_rfp_validity/'.encode($active_rfp['id']))?>" class="label label-primary rfp-price btn_extend" data-toggle="tooltip" data-placement="top" data-original-title="Extend RFP Validity For 7 Days"><i class="fa fa-arrows"></i></a>
											<?php endif; ?>
											<!-- End Check Valid date -->
										</td>
									</tr>
									<!-- ======= For Bid Details ========= -->
									<tr id="bid_data_<?=$key?>" class="bid_data">
										<td></td>
										<td colspan="8">
											<table class="table table-hover table-bordered">
												<thead>
													<th>Name</th>
													<th>Rating</th>
													<th>Bid Amount</th>
													<th>% Saving</th>
													<th>Distance (Miles.)</th>
													<th>Action</th>
												</thead>
												<tbody>
													<?php foreach($active_rfp['bid_data'] as $k=>$bid_data) :?> 
														<tr>
															<td><a href="<?=base_url('dashboard/view_profile/'.encode($bid_data['user_id']))?>">
																	<?=$bid_data['user_name']?>
																	<!-- For Check who is winner -->	
																	<?php if($active_rfp['status'] >= 5 && $bid_data['status'] == 2) :?>
																		<span class="label label-success">Winner</span>
																	<?php endif;?>
																	<!-- End For Check who is winner -->	
																</a>
															</td>
															<td>
																<div class="star-rating">
																    <span class="display_rating_<?=$key.'_'.$k?>"></span>
																	<span class="avg_rating"><?=isset($bid_data['avg_rating'])?$bid_data['avg_rating']:'0'?> / 5.0 (<?=$bid_data['total_rating']?> Reviews)</span>
																</div>
															</td>
															<!-- For Display Star Rating -->
															<script>
																$(".star-rating .display_rating_<?=$key.'_'.$k?>").rateYo({
																	rating: <?=isset($bid_data['avg_rating'])?$bid_data['avg_rating']:'0'?>,
																	starWidth : "20px",
																	readOnly: true
																});
															</script>
															<!-- End Display Star Rating -->		
															<td><?=$bid_data['amount']?></td>
															<td>
																<?php if($active_rfp['treatment_plan_total'] != '' && $bid_data['amount'] != '') :?>
																	<?php $Total_save = 100 - round((($bid_data['amount']*100) / $active_rfp['treatment_plan_total']),2); ?>
																	<?php if($Total_save > 0) :?>
																		<span class="label label-success total_save">+<?=$Total_save?> %</span>
																	<?php else :?>
																		<span class="label label-danger total_save"><?=$Total_save?> %</span>
																	<?php endif; ?>
																<?php else : ?>
																	N/A
																<?php endif; ?>
															</td>
															<td><?=round($bid_data['distance'],2)?></td>
															<td>
																<?php $valid_rfp_date= date("Y-m-d",strtotime($active_rfp['rfp_approve_date']. ' + 30 days')); ?>
																<?php if($active_rfp['status'] == 3 && $valid_rfp_date > date("Y-m-d")) : ?> <!-- 3 Means (Open)  Agent Approve && (approv_date + 30 days > curdate) RFP -->
																	<a href="<?=base_url('rfp/choose_winner_doctor/'.encode($bid_data['rfp_id']).'/'.encode($bid_data['id']))?>" class="label label-info rfp-price confirm_winner" data-toggle="tooltip" data-placement="top" data-original-title="Choose Winner"><i class="fa fa-trophy"></i></a> 
																<?php endif; ?>

																<!-- Add Condition For Cancel Winner Doctor (RFP status waiting for approval (4) && bid status (2) winner then display)-->
																<?php if($active_rfp['status'] == 4 && $bid_data['status'] == 2 && $valid_rfp_date > date("Y-m-d")) :?>
																	<a href="<?=base_url('rfp/cancel_winner_doctor/'.encode($bid_data['rfp_id']).'/'.encode($bid_data['id']))?>" class="label label-danger rfp-price cancel_winner" data-toggle="tooltip" data-placement="top" data-original-title="Cancel Winner"><i class="fa fa-user-times"></i></a>
																<?php endif; ?>

																<!-- Add Condition For Message & Review Button (RFP status winner(5) && bid status (2) winner then display)-->
																<?php if($active_rfp['status'] >= 5 && $bid_data['status'] == 2) :?>
																	<!-- If Review not given for this RFP then display the review button -->
																	<?php if($active_rfp['is_rated'] == '') : ?>
																		<a class="label label-info rfp-price" onclick="send_review(<?=$key?>,<?=$k?>)" title="Review" data-toggle="modal" data-target=".doctor_review"><i class="fa fa-star"></i></a> 
																	<?php endif; ?>
																	<!-- End Review -->
																	<a class="label label-info rfp-price" onclick="send_msg(<?=$key?>,<?=$k?>)" title="Send Mail" data-toggle="modal" data-target=".send_message"><i class="fa fa-envelope"></i></a> 
																	<!-- Display all Message button (If Chat started b/w doctor & patient)-->
																	<?php if($bid_data['is_chat_started'] == 1) :?>
																		<a href="<?=base_url('messageboard/message/'.encode($bid_data['rfp_id']).'/'.encode($bid_data['doctor_id']))?>" class="label label-info rfp-price" data-toggle="tooltip" data-placement="top" data-original-title="View Message"><i class="fa fa-eye"></i></a> 	
																	<?php endif; ?>
																	<!-- End all Message button-->
																<?php endif; ?>
																<!-- End Message & Review Button-->	

															</td>
														</tr>	
													<?php endforeach;?>
												</tbody>	
											</table>
										</td>
									</tr>
									<!-- =======End For Bid Details ============ -->
								<?php endforeach; ?>
								<tr>
									<td colspan="10">
										<a class="btn btn-3d btn-sm btn-reveal btn-success pull-right show_more">
											<i class="fa fa-arrow-circle-down"></i><span>Show More</span>
										</a>
										<a class="btn btn-3d btn-sm btn-reveal btn-success pull-right show_less">
											<i class="fa fa-arrow-circle-up"></i><span>Hide</span>
										</a>	
									</td>
								</tr>	
							<?php else :?>
								<tr>
									<td colspan="9">No Active RFP</td>
								</tr>	
							<?php endif; ?>	
						</tbody>	
					</table>	
				</div>	
			</div>
		</div>		
		<!-- End Active RFP For this patient Table -->

		<div class="divider divider-color divider-center divider-short">
			<!-- divider -->
			<i class="fa fa-cog"></i>
		</div>

		<!-- Patient's Appointment -->
		<div class="row appointment-list">
			<div class="col-md-12">
				<h4> Your Appointment </h4>
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Doctor Name</th>
								<th>RFP Title</th>
								<th>Appointment Date</th>
								<th>Appointment Time</th>
								<th>Created on</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($appointment_list)) { ?>
								<?php foreach($appointment_list as $key=>$appointment) :?>	
									<tr>
										<td><?=$appointment['user_name'];?></td>
										<td><?=$appointment['title']; ?></td>
										<!-- For Check Appointment fixed or not by patient -->
										<?php $appointment_date ='';
											  $appointment_time = '';
										foreach($appointment['appointment_schedule_arr'] as $app_sche) {
											if($app_sche['is_selected'] == 1) {
												$appointment_date = $app_sche['appointment_date'];
												$appointment_time = $app_sche['appointment_time'];
											}
										} ?>	
										<!-- End For Check Appointment fixed or not by patient -->
										<td><?php if($appointment_date) { echo date("m-d-Y",strtotime($appointment_date)); } else { echo 'N/A';} ?></td>
										<td><?php if($appointment_time) { echo date("H:i:s",strtotime($appointment_time)); } else { echo 'N/A';} ?></td>
										<td><?=isset($appointment['created_at'])?date("m-d-Y",strtotime($appointment['created_at'])):'N/A'; ?></td>
										<td>
											<a class="label label-info" title="View Appointment" data-toggle="modal" data-target=".manage_appointment" onclick="view_appointment(<?=$key?>)"><i class="fa fa-eye"></i></a>
										</td>
									</tr>
								<?php endforeach; ?>	
							<?php }else{ ?>
								<tr>
									<td colspan="5" class="text-center">
										<b>No data Found</b>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>	
			</div>	
		</div>	
		<!-- // ENDS here Appointment -->

		<div class="divider divider-color divider-center divider-short">
			<!-- divider -->
			<i class="fa fa-cog"></i>
		</div>


		<!-- Payment Table -->
		<!-- <div class="row">
			<div class="col-md-12">
				<h4>Payment History</h4>	
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>RFP Title</th>
								<th>User Name</th>
								<th>RFP Status</th>
								<th>Dentition Type</th>
								<th>Paid Price</th>
								<th>Refund Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($rfp_list as $key=>$list) : ?>
								<tr>
									<td><?=$list['rfp_title']?></td>
									<td><?=$list['user_name']?></td>
									<td><?= rfp_status_label($list['rfp_status'])?></td>
									<td><?=$list['dentition_type']?></td>
									<td><?=$list['paid_price']?></td>
									<td>
										<?php if($list['refund_status'] == '') :?>
										<span class="label label-default">--</span>
										<?php elseif($list['refund_status'] == '0') :?>
										<span class="label label-info">In-Progress</span>
										<?php elseif($list['refund_status'] == '1') :?>
										<span class="label label-success">Approved</span>
										<?php elseif($list['refund_status'] == '2') :?>
										<span class="label label-danger">Rejected</span>
										<?php endif; ?>
									</td>
									<td>
										<?php if($list['refund_id'] == '') :?>
											<a onclick="refund_request(<?=$key?>)" class="btn btn-3d btn-xs btn-reveal btn-green" data-toggle="modal" data-target=".refund_request">
												<i class="fa fa-money"></i><span>Refund</span>
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>	
						</tbody>
					</table>
				</div>			
			</div>	
		</div>	 -->
		<!-- Payment List -->
	</div>
</section>	

<!-- ==================== Modal Popup For Refund Payment ========================= -->
<div class="modal fade refund_request" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Refund Payment</h4>
			</div>
			<form action="<?=base_url('dashboard/refund_request')?>" method="POST" id="frmrefund">
				<input type="hidden" name="payment_id" id="payment_id">
				<input type="hidden" name="rfp_id" id="rfp_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>RFP Title</label>
								<input type="text" id="rfp_title" class="form-control" disabled>
							</div>
						</div>	
						<div class="col-sm-6">
							<div class="form-group">
								<label>Refund Amount</label>
								<input type="text" id="refund_amt" class="form-control" disabled>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Description (Refund Reason)</label>
								<textarea name="description" id="description" class="form-control" rows="5" required></textarea>
							</div>	
						</div>		
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-info" value="Submit">
								<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
							</div>	
						</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Refund Payment ========================= -->		

<!-- ==================== Modal Popup For Send Message ========================= -->
<div class="modal fade send_message" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Send Message</h4>
			</div>
			<form action="<?=base_url('rfp/send_message')?>" method="POST" id="frmmsg">
				<input type="hidden" name="rfp_id" id="msg_rfp_id">
				<input type="hidden" name="rfp_title" id="msg_rfp_title">
				<input type="hidden" name="rfp_bid_id" id="msg_rfp_bid_id">
				<input type="hidden" name="to_id" id="msg_to_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<label>Message</label>
							<div class="form-group">
								<textarea name="message" id="message" class="form-control" rows="5"></textarea>
							</div>	
						</div>		
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-info" value="Submit">
								<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
							</div>	
						</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Send Message ========================= -->	

<!-- ==================== Modal Popup For Doctor Review  ========================= -->
<div class="modal fade doctor_review" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Review</h4>
			</div>
			<form action="<?=base_url('rfp/doctor_review')?>" method="POST" id="frmreview">
				<input type="hidden" name="rfp_id" id="review_rfp_id">
				<!-- <input type="hidden" name="rfp_title" id="rfp_title"> -->
				<input type="hidden" name="doctor_id" id="doctor_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<label>Rating</label>	
						    <div class="star-rating">
							    <span id="rateYo"></span>
							    <span class="point" style="display:none">0</span>
							</div>
						</div>
						<div class="col-sm-12">	
							<input type="hidden" name="rating" id="rating"/>
						</div>	
						<div class="col-sm-12">
							<label>Comment (Optional)</label>
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
							<input type="submit" name="submit" class="btn btn-info" value="Submit Review">
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
						</div>	
					</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Doctor Review ========================= -->

<!-- ==================== Modal Popup For Manage Appointment (select one schedule by patient)========================= -->
<div class="modal fade manage_appointment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">View Appointment</h4>
			</div>
			<form action="<?=base_url('dashboard/choose_appointment_schedule')?>" method="POST" id="frm_choose_app">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Doctor Name : <span id="appointment_user_name"></span></label>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>RFP Title : <span id="appointment_rfp_title"></span></label>
							</div>
						</div>	
						<div class="col-sm-12 patient_schedule">
							<div class="form-group">
								<label>Appointment Schedule : <span></span></label>
								<div class="table-responsive appointment_schedule_table">
									<table class="table">
										<thead>
											<tr>
												<th>Shift</th>
												<th>Mon</th>
												<th>Tue</th>
												<th>Wed</th>
												<th>Thu</th>
												<th>Fri</th>
												<th>Sat</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>Morning</th>
												<?php for($i=1;$i<=6;$i++) :?>
													<th><input type="checkbox" id="M_<?=$i?>" name="appointment_schedule[]" value="M_<?=$i?>" disabled></th>
												<?php endfor; ?>
											</tr>
											<tr>
												<th>AfterNoon</th>
												<?php for($i=1;$i<=6;$i++) :?>
													<th><input type="checkbox" id="A_<?=$i?>" name="appointment_schedule[]" value="A_<?=$i?>" disabled></th>
												<?php endfor; ?>
											</tr>		
										</tbody>	
									</table>	
								</div>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Comment :</label>
								<span id="appointment_rfp_comment"></span>
							</div>
						</div>	

						<!-- For multiple Appointment manage --> 
							<?php for($i=1;$i<=3;$i++) : ?>	
								<div class="mul_schedule_<?=$i?> schedule_data">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Appointment Date <?=$i?> :</label>
											<input type="text" id="appointment_date_<?=$i?>" name="appointment_date[]" class="form-control datepicker" data-format="mm-dd-yyyy" readonly>
										</div>
									</div>	
									<div class="col-sm-5">
										<div class="form-group">
											<label>Appointment Time <?=$i?> :</label>
											<input type="text" id="appointment_time_<?=$i?>" name="appointment_time[]" class="form-control timepicker" readonly>
										</div>
									</div>
									<div class="col-sm-1">
										<div class="form-group">
											<label>&nbsp;</label>
											<input type="radio" name="schedule_selected" id="schedule_selected_<?=$i?>">
										</div>
									</div>
								</div>			
							<?php endfor; ?>
							<div class="col-sm-12">
								<div class="mul_app"></div>
							</div>
						<!-- End For multiple Appointment manage --> 
						<div class="col-sm-12">
							<div class="form-group">
								<label>Doctor Comment :</label>
								<span id="appointment_doc_comments"></span>
							</div>	
						</div>		
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-info submit_btn" value="Submit">
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
						</div>	
					</div>	
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Manage Appointment ========================= -->	

<!-- ==================== Modal Popup For Doctor Appointment (Suggest time by client first time) ========================= -->
<div class="modal fade doctor_appointment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Appointment Schedule</h4>
			</div>
			<form action="" method="POST" id="frm_doctor_appointment">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<label>Appointment</label>	
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Shift</th>
											<th>Mon</th>
											<th>Tue</th>
											<th>Wed</th>
											<th>Thu</th>
											<th>Fri</th>
											<th>Sat</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>Morning</th>
											<?php for($i=1;$i<=6;$i++) :?>
												<th><input type="checkbox" name="appointment_schedule[]" value="M_<?=$i?>"></th>
											<?php endfor; ?>
										</tr>
										<tr>
											<th>AfterNoon</th>
											<?php for($i=1;$i<=6;$i++) :?>
												<th><input type="checkbox" name="appointment_schedule[]" value="A_<?=$i?>"></th>
											<?php endfor; ?>
										</tr>		
									</tbody>	
								</table>	
							</div>	
						</div>
						<div class="col-sm-12">
							<label>Comment (Optional)</label>
							<div class="form-group">
								<textarea name="appointment_comment" id="appointment_comment" class="form-control" rows="5"></textarea>
							</div>	
						</div>		
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-info" value="Submit">
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
						</div>	
					</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Doctor Appointment ========================= -->	


<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>
<script>

$(function () {
 //------------- For Star Rating ----------------
$("#rating").val('0.5'); 
$(".star-rating #rateYo").rateYo({
    halfStar: true,
    rating: 0.5,
     onSet: function (rating, rateYoInstance) {
			$(".point").show();
			$("#rating").val(rating);
		}
  });

$(".star-rating #rateYo").rateYo().on("rateyo.change", function (e, data) {

	var rating = data.rating;
	$(".point").show();
	$(".point").text(rating +" Star");
});
 //------------- End Star Rating ----------------
});

function refund_request(key){
	var rfp_data = <?php echo json_encode($rfp_list); ?>;
	$("#rfp_id").val(rfp_data[key]['rfp_id']);
	$("#payment_id").val(rfp_data[key]['payment_id']);
	$("#rfp_title").val(rfp_data[key]['rfp_title']);
	$("#refund_amt").val(rfp_data[key]['paid_price']);
}


/* -------- Show/Hide Column ------- */
$(".active_rfp .show_less").hide();
$(".active_rfp .active_rfp_data").hide();
$(".active_rfp .show_more").click(function(e) {
	$(".active_rfp .active_rfp_data").show();
	$(".active_rfp .show_more").hide();
	$(".active_rfp .show_less").show();
	$(".active_rfp .bid_data").hide(); // For Sub table hide
	$(".active_rfp .hide_bid_data").hide();
	$(".active_rfp .view_bid_data").show();
});

$(".active_rfp .show_less").click(function(e) {
	$(".active_rfp .active_rfp_data").hide();
	$(".active_rfp .show_more").show();
	$(".active_rfp .show_less").hide();
	$(".active_rfp .bid_data").hide(); // For Sub table hide
	$(".active_rfp .hide_bid_data").hide();
	$(".active_rfp .view_bid_data").show();
});



//------------------- Hide/Show Sub Table for Active RFP -----------------
$(".active_rfp .bid_data").hide();
$(".active_rfp .hide_bid_data").hide();

$(".active_rfp .view_bid_data").click(function(e) {
	var id = $(this).data('id');
	$(".bid_data").hide();
	$("#bid_data_"+id).show();
	$(".active_rfp .hide_bid_data").hide();
	$(".active_rfp .view_bid_data").show();
	$(".active_rfp #view_bid_data_"+id).hide();
	$(".active_rfp #hide_bid_data_"+id).show();

});

$(".active_rfp .hide_bid_data").click(function(e) {
	var id = $(this).data('id');
	$(".bid_data").hide();
	$(".active_rfp #view_bid_data_"+id).show();
	$(".active_rfp #hide_bid_data_"+id).hide();
});
//------------------- End Hide/Show Sub Table for Active RFP -----------------



//-------------- For Winner Select & Cancel -------------------------
$(".confirm_winner").click(function(e) {
	e.preventDefault();
	var lHref = $(this).attr('href');
	$(".doctor_appointment").modal('show');
	$(".doctor_appointment #frm_doctor_appointment").attr("action",lHref);	
});
	

$(".cancel_winner").click(function(e) {
	e.preventDefault();
	var lHref = $(this).attr('href');
	bootbox.confirm('Are you sure to cancel winner for this rfp ?' ,function(res){
		if(res){
			window.location.href = lHref;
		}
	});	
});

$(".btn_extend").click(function(e){		
	e.preventDefault();
	var lHref = $(this).attr('href');
	bootbox.confirm('Are you sure to extend validity for this rfp?' ,function(res){ 	 		
	    if(res) {
	        window.location.href = lHref;
	    }
	});
});
//-------------- End For Winner Select & Cancel -------------------------


//---------------- Send Message ------------------
function send_msg(rfp_key,bid_key){
	var rfp_data = <?php echo json_encode($active_rfp_list); ?>;
	$("#msg_rfp_id").val(rfp_data[rfp_key]['id']);
	$("#msg_rfp_title").val(rfp_data[rfp_key]['title']);
	$("#msg_rfp_bid_id").val(rfp_data[rfp_key]['bid_data'][bid_key]['id']);
	$("#msg_to_id").val(rfp_data[rfp_key]['bid_data'][bid_key]['doctor_id']);
}
//---------------- End Send Message ------------------

//--------------- Send Review -------------------
function send_review(rfp_key,bid_key){
	var rfp_data = <?php echo json_encode($active_rfp_list); ?>;
	$("#review_rfp_id").val(rfp_data[rfp_key]['id']);
	//$("#rfp_title").val(rfp_data[key]['title']);
	$("#doctor_id").val(rfp_data[rfp_key]['bid_data'][bid_key]['doctor_id']);
}
//--------------- Send Review ----------------------

// ----------- For View Appointment by patient -----------

function view_appointment(key){

	$(".appointment_schedule_table input:checkbox").prop('checked', false);
	$(".schedule_data").hide();
	$(".schedule_data input:radio").prop('checked', false);
	$(".validation-error-label").hide(); // For Hide Validation error
	$("#frm_choose_app .submit_btn").show();
	$(".schedule_data input:radio").prop('disabled', false);

	var appointment_data = <?php echo json_encode($appointment_list); ?>;
	
	$("#appointment_id").val(appointment_data[key]['appointment_id']);
	$("#appointment_rfp_id").val(appointment_data[key]['id']);
	$("#appointment_user_name").html(appointment_data[key]['user_name']);
	$("#appointment_rfp_title").html(appointment_data[key]['title']);
	
	//----------- For Select Appointment data submit by patient -----------
	
	if(appointment_data[key]['appointment_schedule'] != ''){
		$(".patient_schedule label span").html("");
		$(".appointment_schedule_table").show();
		var app_arr = appointment_data[key]['appointment_schedule'].split(',');

		$.each(app_arr, function( key, data ) {
		  var app_data = data.split('_');
		  $("#"+app_data[0]+"_"+app_data[1]).prop('checked', true);
		});

	}
	else{
		$(".patient_schedule label span").html("N/A");
		$(".appointment_schedule_table").hide();
	}
	//-----------------------------------------------------------------------

	if(appointment_data[key]['appointment_comment'] != '') {	
		$("#appointment_rfp_comment").html(appointment_data[key]['appointment_comment']);
	}else{
		$("#appointment_rfp_comment").html('N/A');
	}

	//----------------- For Multiple Appointment Schedule (Date & Time) Submit by doctor---------
	var app_sch_arr= appointment_data[key]['appointment_schedule_arr'];
	$.each(app_sch_arr, function( key, data ) {
		var date= data['appointment_date'];
		var d= date.split("-");
		var time = data['appointment_time'];
		var t = time.split(":");

		$(".mul_schedule_"+(key+1)).show();

		$("#appointment_date_"+(key+1)).val(d[1]+"-"+d[2]+"-"+d[0]);
		$("#appointment_time_"+(key+1)).val(t[0]+":"+t[1]);
		$("#schedule_selected_"+(key+1)).val(data['id']);

		//---------- IF Schedule selected then checked radio button & hide submit button -------
		if(data['is_selected'] == 1){
			
			$(".schedule_data input:radio").prop('disabled', true);
			$("#schedule_selected_"+(key+1)).prop("checked", true);
			$("#frm_choose_app .submit_btn").hide();
		}
		//------------------
	});
	//----------------- End For Multiple Appointment Schedule (Date & Time) Submit by doctor---------

	$("#appointment_doc_comments").html(appointment_data[key]['doc_comments']);
}
// ----------- End For View Appointment  -----------

//--------------- For Message Form Validation --------------
$("#frmmsg").validate({
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    rules: {
        message: {
            required: true,
        }
    },
    messages: {
        message: {
            required: "Please provide a Message"
        }
    }
});


//--------------- For Select Schedule --------------
$("#frm_choose_app").validate({
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    rules: {
        schedule_selected: {
            required: true,
        }
    },
     errorPlacement: function (error, element) {
     		console.log(element);
            if (element[0]['name'] == "schedule_selected") {
                error.insertAfter(".mul_app");
            } else {
                error.insertAfter(element)
            }
        },
    messages: {
        schedule_selected: {
            required: "Please select one Appointment schedule"
        }
    }
});



</script>