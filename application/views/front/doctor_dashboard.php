<?php    
    $url = base_url().'cron/check_status';
    $res = $this->unirest->get($url);

	$reload = $this->input->get('reload');
	if($reload != ''){		
		$this->session->set_flashdata('success','Congratulations to your new patient, please, schedule an appointment, from the appointment management tab <a href="'.base_url().'dashboard'.'">click here</a>');
		redirect('dashboard?schedule_rfp='.$reload);
	}
	$default_method = $db_data['default_payment'];	
?>
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
				<h1>Doctor Dashboard</h1>	
			</div>		
		</div>
						
		<!-- Doctor's Tab Section -->
		<div class="row">
			
			<div class="alert-message"></div>
	
			<?php
				$cur_tab = $this->input->get('tab');
			?>
			<ul class="nav nav-tabs nav-top-border">
				<li class="<?php if($cur_tab == ''){ echo 'active'; } ?>"><a href="#won_rfps" data-toggle="tab">Bids Won</a></li>
				<li class="<?php if($cur_tab == 'appointment'){ echo 'active'; } ?>"><a href="#schedule_rfps" data-toggle="tab">Appointments</a></li>
				<li class=""><a href="#rfp_bids" data-toggle="tab">Placed Bids</a></li>
				<li class=""><a href="#favorite_rfp" data-toggle="tab">Favorite Bids</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane fade <?php if($cur_tab == ''){ echo 'in active'; } ?>" id="won_rfps">
					<div class="table-responsive rfp_table_layout col-md-12">
						<table class="table table-hover chatting">
							<thead>
								<tr>
									<th>Request Title</th>
									<th>Bid Value ($)</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									if(!empty($won_rfps)) {
										foreach($won_rfps as $w_rfp) {

											$u_data = $this->session->userdata('client');
											$all_billing_data = $this->db->get_where('billing_schedule',['rfp_id'=>$w_rfp['rfp_id']])->result_array();

											$amt = $w_rfp['amount']; // Bid price										
											$percentage = config('doctor_fees');

											$payable_price = ($percentage * $amt)/100; // calculate 10% againts the bid of doctor
											$total_transaction_cnt = 0;
											
											$due_1 = config('doctor_initial_fees');
											$due_2 = 0;
											$is_second_due = 0;

											if($payable_price > $due_1){
												$due_2 = $payable_price - $due_1;
												$is_second_due = 1;
											}else{
												$payable_price = $due_1;
											}
								?>
										<tr>
											<td>
												<a href="<?php echo base_url().'rfp/view_rfp/'.encode($w_rfp['rfp_id']); ?>">
													<?php echo $w_rfp['title']; ?>
												</a>
											</td>										
											<td><?php echo ucfirst($w_rfp['amount']); ?></td>
											<td>
												<?php
													if(empty($all_billing_data)){ 
														if($w_rfp['rfp_status'] == '4') { ?>
															<a onclick="$('.payment_rfp_<?=$w_rfp['rfp_id']?>').click();"> 
														<?php } echo rfp_status_label($w_rfp['rfp_status']); 
															if($w_rfp['rfp_status'] == '4') { ?>
															</a>
														<?php } ?>
													<?php }else{
														$check_transactions = array_column($all_billing_data,'transaction_id');													
														$total_transaction_cnt = count(array_filter($check_transactions, function($x) {return !is_null($x); }));

														// Check if there are any payment Errors in case of cancellation of agreement
														if(in_array('DOCTOR_PAYMENT_ERROR',$check_transactions) == true){
															echo '<span class="label label-danger">Payment Error</span>';
														}else{
															if($w_rfp['rfp_status'] == '5') {
																echo '<span class="label label-primary">Appointment Pending</span>';
															}else{
																echo '<span class="label label-dark-blue">Service in Progress</span>';
															}
														}
													}
												?>
											</td>
											<td>										
												<?php if($w_rfp['rfp_status'] == '4' && empty($all_billing_data)) { ?>
													<a class="label label-success payment_rfp_<?=$w_rfp['rfp_id']?>"
													   data-is-second-due="<?php echo $is_second_due; ?>"
													   data-due-one="<?php echo $due_1; ?>"
													   data-due-two="<?php echo $due_2; ?>"
													   data-total-due="<?php echo $payable_price; ?>"
													   data-mybid="<?php echo $amt; ?>"
													   data-rfpid="<?php echo encode($w_rfp['rfp_id']); ?>"
													   onclick="show_modal_doctor(this)" data-toggle="tooltip" data-placement="top" data-original-title="Proceed">
														<i class="fa fa-check"></i></a>
													<a href="<?php echo base_url().'rfp/view_rfp/'.encode($w_rfp['rfp_id']); ?>" class="label label-info" data-toggle="tooltip" data-placement="top" data-original-title="View Request">
	                                                    		<i class="fa fa-eye"></i></a>
												<?php }else{
													
														$show_pending_payment = 0;
														// pr($all_billing_data);
														foreach($all_billing_data as $bill_data){
															if($bill_data['status']=='0' && !empty($bill_data['transaction_id']) && $bill_data['transaction_id'] != 'MANUAL'){
															  $show_pending_payment++;
															}
														}  

	                                                    $won_rfp_id = $w_rfp['rfp_id'];
	                                                    $timeline_id = '#timeline_id_'.$w_rfp['rfp_id'];

														if($show_pending_payment != 0){
															echo '<span class="label label-warning">Payment is under review</span>';													
	                                                    }else{
	                                                    ?>
														    <a class="label label-info a_show_<?php echo $won_rfp_id; ?>" 
	                                                          onclick="$('<?php echo $timeline_id; ?>').show(); $(this).hide(); $('.a_hide_<?php echo $won_rfp_id; ?>').show();" data-toggle="tooltip" data-placement="top" data-original-title="Message"> <i class="fa fa-wechat"></i></a>

	                                                        <a class="label label-info a_hide_<?php echo $won_rfp_id; ?>" 
	                                                          onclick="$('<?php echo $timeline_id; ?>').hide(); $(this).hide(); $('.a_show_<?php echo $won_rfp_id; ?>').show();" style="display:none;" data-toggle="tooltip" data-placement="top" data-original-title="Hide Message"> <i class="fa fa-wechat"></i></a>
	                                                    	
	                                                    	<a href="<?php echo base_url().'rfp/view_rfp/'.encode($w_rfp['rfp_id']); ?>" class="label label-info" data-toggle="tooltip" data-placement="top" data-original-title="View Request">
	                                                    		<i class="fa fa-eye"></i></a>

                                                			<!-- For Check Appointment is schedule or not (If not schedule by doctor then display appointment option)-->
	                                                    	<?php if(empty($w_rfp['appointment_data'])) :?>
	                                                    		<a class="label label-danger schedule_app_<?=$w_rfp['rfp_id']?>" title="Manage Appointment" onclick="schedule_won_rfp_app(<?=$w_rfp['rfp_id']?>)"><i class="fa fa-calendar"></i></a>
	     													<?php endif; ?>	
                                                    		<!-- End For Check Appointment is schedule or not -->

                                                    		
                                                			<!-- For Reschedule appointment -->
	                                                    	<?php if(!empty($w_rfp['appointment_data'])) :?>
	                                                    		<?php $reschedule_app = 0; ?>	
																<?php foreach($w_rfp['appointment_data'] as $app_data) :?>
																	<?php if($app_data['is_selected'] == 1) {
																		$reschedule_app = 1;
																	} ?>	
																<?php endforeach;?>	
																
																<?php if($reschedule_app == 0) :?>
																	<a class="label label-teal" data-toggle="tooltip" data-placement="top" data-original-title="View Appointment" onclick="view_won_rfp_app(<?=$w_rfp['rfp_id']?>)"><i class="fa fa-calendar"></i></a>
																<?php endif; ?>	
																<?php if($reschedule_app == 1 && $w_rfp['rfp_close_date'] == null) :?>
																	<!-- <a onclick="reschedule_won_rfp_app(<?=$w_rfp['rfp_id']?>)" class="label label-warning" title="Reschedule Appointment"><i class="fa fa-calendar-minus-o"></i></a>     -->
																	<a class="label label-success" data-toggle="tooltip" data-placement="top" data-original-title="View Appointment" onclick="view_won_rfp_app(<?=$w_rfp['rfp_id']?>)"><i class="fa fa-calendar"></i></a>
																<?php endif; ?>
															<?php endif; ?>	
															<!-- End For Reschedule appointment -->	
	                                                    <?php
														}
													}
												?>
											</td>
										</tr>
										<tr class="hover-timeline" id="timeline_id_<?php echo $w_rfp['rfp_id']; ?>" style="display:none;">
											<td colspan="7" class="text-center">						        
										        <div class="new-section timeline-up-section">
										            <ul class="verticle-timeline">
										                <li>
										                    <div class="left-section">
	                                                            <div class="profile-image-border">	                                                            
	                                                            	<?php if(empty($w_rfp['avatar'])){ ?>
	                                                                	<img src="<?php echo base_url().'uploads/default/user-img.jpg'; ?>">
	                                                                <?php }else{ ?>
																		<img src="<?php echo base_url().'uploads/avatars/'.$w_rfp['avatar']; ?>">
	                                                                <?php } ?>	                                                                
	                                                            </div>
										                    	<span><?php echo $w_rfp['fname'].' '.$w_rfp['lname']; ?>  has accepted</span>
										                    </div>
										                    <div class="timeline-msg">$<?php echo ucfirst($w_rfp['amount']); ?></div>
										                    <div class="right-section">
	                                                            <div class="profile-image-border">
	                                                            	<?php if(empty($u_data['avatar'])){ ?>
	                                                                	<img src="<?php echo base_url().'uploads/default/user-img.jpg'; ?>">
	                                                                <?php }else{ ?>
																		<img src="<?php echo base_url().'uploads/avatars/'.$u_data['avatar']; ?>">
	                                                                <?php } ?>
	                                                            </div>
										                    	<span><?php echo $u_data['fname'].' '.$u_data['lname']; ?> has confirmed</span>
										                    </div>
										                </li>
										            </ul>
										        </div>
												
												<!-- For Check Appointment Confirm or not -->
												<?php 
												$appointment_confirm = 0;
												if(!empty($w_rfp['appointment_data'])) {
													foreach($w_rfp['appointment_data'] as $app_data) {
														if($app_data['is_selected'] == 1) {
															$appointment_confirm = 1;
														}
													}	
												} ?>	
												<!-- End For Check Appointment Confirm or not -->

										        <div class="cong-msg">
										            <p class="check"><i class="fa fa-check" aria-hidden="true"></i></p>
										            <h2>Congratulation!!</h2>
										            <?php if($appointment_confirm == 1) :?>
										            	<h5>Appointment is successfully agreed between the Patient and Doctor.</h5>
										        	<?php else : ?>
										        		<h5>Your Request is successful, next step find agree an appointment.</h5>
										        	<?php endif;?>
										        </div>
										        <ul class="timeline">
													<!-- For Appointment -->	
													<?php if($appointment_confirm == 1) :?>
														<li class="timeline-inverted appointment-fix">
															<p><span>Appointment Date : </span><?=date("m-d-Y",strtotime($app_data['appointment_date']))?>
															<span>Appointment Time :</span> <?=$app_data['appointment_time']?></p>
															<p><span>Doctor Comment : </span><?=$app_data['doc_comments']?></p>
														</li>
													<?php endif; ?>		
													<!-- End Appointment -->
																
	                                                <?php 
	                                                    if(!empty($w_rfp['chat_data'])) :
	                                                        foreach($w_rfp['chat_data'] as $chat) :                                                            
	                                                ?>
	                                                    <li class="timeline-inverted <?php if($this->session->userdata('client')['id'] == $chat['from_id']){ echo 'from_login_user'; }else{ echo 'non_user'; } ?>">
	                                                        <div class="timeline-badge warning"><img src="<?php if($chat['sender_avatar'] != '')
	                                                            { echo base_url('uploads/avatars/'.$chat['sender_avatar']); } 
	                                                            else 
	                                                            { echo DEFAULT_IMAGE_PATH."user/user-img.jpg "; }?>">
	                                                        </div>
	                                                        <div class="timeline-panel">
	                                                            <div class="timeline-heading">
	                                                                <h5 class="timeline-title"><?=$chat['sender_name']?></h5>
	                                                            </div>
	                                                            <div class="timeline-body">
	                                                                <p>
	                                                                    <?=$chat['message']?>
	                                                                </p>
	                                                            </div>
	                                                        </div>
	                                                    </li>
	                                                    <?php endforeach; ?>
	                                                <?php endif; ?>
	                                                
	    									            <div class="timeline-panel-input" id="div_before_timeline_<?php echo $w_rfp['rfp_id']; ?>">
	                                                        <form method="post" data-id="<?php echo $w_rfp['rfp_id']; ?>" id="timeline_form_<?php echo $w_rfp['rfp_id']; ?>" 
	                                                              onsubmit="event.preventDefault(); submit_form(this);">

	                                                            <input type="hidden" name="rfp_id" value="<?=$w_rfp['rfp_id']?>">
	                                                            <input type="hidden" name="rfp_title" value="<?=$w_rfp['title']?>">
	                                                            <input type="hidden" name="to_id" value="<?php echo $w_rfp['patient_id']; ?>">
	                                                            <input type="textbox" name="message" id="message_id_<?php echo $w_rfp['rfp_id'];?>" placeholder="Your Message"/>                                                        
	                                                            <span id="validate-msg-<?php echo $w_rfp['rfp_id']; ?>"></span>
	                                                            <button class="btn btn-primary" id="button_<?php echo $w_rfp['rfp_id']; ?>" style="float:right">SUBMIT</button>
	                                                            <a class="btn btn-primary" style="display:none; float:right;" id="anchor_<?php echo $w_rfp['rfp_id']; ?>"><i class="fa fa-spinner fa-spin"></i> Loading...</a>
	                                                        </form>
	                                                    </div>
										        </ul>							        
											</td>
										</tr>
									<?php } ?>
								<?php }else{ ?>
									<tr>
										<td colspan="7" class="text-center">
											<b>Go to <a href="<?=base_url('rfp/search_rfp')?>" class="goto_rfp">Bid on Requests</a> to find new patient treatments plans to bid on - once you are selected as winner - you will these listed in this section</b>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane fade <?php if($cur_tab == 'appointment'){ echo 'in active'; } ?>" id="schedule_rfps">
					<!-- Doctor's Manage Appointment -->
                    <div class="row appointment-list col-md-12">
                        <!-- <div class="col-md-12">
                            <h4> Manage Appointment </h4>
                            <hr/>
                        </div>   -->
                        <div class="col-md-12">
                            <div class="table-responsive rfp_table_layout">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Request Title</th>
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
                                                          $is_approve_app = '';
                                                    foreach($appointment['appointment_schedule_arr'] as $app_sche) {
                                                        if($app_sche['is_selected'] == 1) {
                                                            $appointment_date = $app_sche['appointment_date'];
                                                            $appointment_time = $app_sche['new_appointment_time'];
                                                            $is_approve_app = 1;
                                                        }
                                                    } ?>    
                                                    <!-- End For Check Appointment fixed or not by patient -->
                                                    <td><?php if($appointment_date) { echo date("m-d-Y",strtotime($appointment_date)); } else { echo 'N/A';} ?></td>
                                                    <td><?php if($appointment_time) { echo $appointment_time; } else { echo 'N/A';} ?></td>
                                                    <td><?=isset($appointment['created_at'])?date("m-d-Y",strtotime($appointment['created_at'])):'N/A'; ?></td>
                                                    <td>
                                                        <!-- === If Appointment not set then display the manage appointment button otherwise view == -->
                                                        <?php if($appointment['appointment_id'] == '') :?>
                                                            <a class="label label-danger" title="Manage Appointment" id="rfp_id_<?=$appointment['id']?>" data-toggle="modal" data-target=".select_appointment_option" onclick="select_appointment_option(<?=$key?>)"><i class="fa fa-calendar"></i></a>
                                                        <?php else : ?>
                                                            <?php if($is_approve_app != 1) :?> <!-- If patient approve appointment then not display Delete Appointment -->
                                                                <a id="rfp_id_<?=$appointment['id']?>" class="label label-info label-teal" title="View Appointment" data-toggle="modal" data-target=".manage_appointment" onclick="view_appointment(<?=$key?>)"><i class="fa fa-calendar"></i></a>
                                   								<a href="<?=base_url('dashboard/delete_appointment/'.encode($appointment['appointment_id']))?>" id="delete_rfp_id_<?=$appointment['id']?>" class="label label-danger delete_appointment" title="Delete Appointment"><i class="fa fa-trash"></i></a>
                                                            <?php elseif($appointment['rfp_close_date'] == null):?>
                                                            	<a id="rfp_id_<?=$appointment['id']?>" class="label label-success" title="View Appointment" data-toggle="modal" data-target=".manage_appointment" onclick="view_appointment(<?=$key?>)"><i class="fa fa-calendar"></i></a>
                                                            	<a href="<?=base_url('dashboard/reschedule_appointment/'.encode($appointment['appointment_id']))?>" id="resch_rfp_id_<?=$appointment['id']?>" class="label label-warning reschedule_appointment" title="Reschedule Appointment"><i class="fa fa-calendar-minus-o"></i></a>    
                                                            <?php endif; ?>
                                                        <?php endif;?>
                                                        <!-- == End == -->
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>    
                                        <?php }else{ ?>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <b>Manage Patient Appointments on your won bids (Propose or Call / Confirm / Change)</b>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div>  
                    </div>  
                    <!-- // ENDS here Appointment -->
				</div>
				<div class="tab-pane fade" id="rfp_bids">
					<div class="col-md-12">
						<div class="table-responsive rfp_table_layout">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Request Title</th>
										<th>Bid Value ($)</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 													
										if(!empty($total_rfp_bids)){
											foreach($total_rfp_bids as $total_bids){										
									?>
										<tr>
											<td><?php echo $total_bids['title']; ?></td>
											<td><?php echo $total_bids['amount']; ?></td>
											<td><?php echo rfp_status_label($total_bids['rfp_status']); ?></td>
											<td>
												<a href="<?php echo base_url().'rfp/view_rfp/'.encode($total_bids['rfp_id']); ?>" 
												   class="label label-info" data-toggle="tooltip" data-placement="top" data-original-title="View RFP">
													<i class="fa fa-eye"></i>
												</a>
											</td>
										</tr>
									<?php } } else { ?>
										<tr>
											<td colspan="4" class="text-center"><b><a href="<?=base_url('rfp/search_rfp')?>" class="goto_rfp">Bid on Requests</a> and your active bids are listed in this section.</b></td>
										</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="favorite_rfp">
					<div class="col-md-12">
						<!-- ============== Favorite RFP Table =============== -->
						<div class="table-responsive rfp_table_layout">
							<table class="table table-hover">
								<thead>
									<tr>
										<th></th>
										<th>Request Title</th>
										<th>Dentition Type</th>
										<th>Created On</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if(count($rfp_data_fav) > 0) : ?>
										<?php foreach($rfp_data_fav as $record) :?>
											<tr>
												<td><span class="favorite fa fa-star favorite_rfp" data-id="<?=encode($record['rfp_id'])?>" data-toggle="tooltip" data-placement="top" data-original-title="Favorite Request"></span></td>
					                    		<td><?=character_limiter(strip_tags($record['title']), 70);?></td>
					                    		<td><span class="label label-info"><?=ucfirst($record['dentition_type'])?></span></td>
					                    		<td><?=date("Y-m-d H:i a",strtotime($record['created_at']));?></td>
												<td>
													<a href="<?=base_url('rfp/view_rfp/'.encode($record['rfp_id']))?>" class="label label-info" data-toggle="tooltip" data-placement="top" data-original-title="View Request"><i class="fa fa-eye"></i></a>
												</td>
											</tr>
										<?php endforeach; ?>	
									<?php else : ?>
										<tr><td colspan="6" class="text-center"><b>In the view of <a href="<?=base_url('rfp/search_rfp')?>" class="goto_rfp">Bid on Requests</a> you can mark your favorite Requests with <i class="fa fa-star"></i>. Search them and come back here to place a bid when you are ready.</b></td></tr>
									<?php endif; ?>
								</tbody>	
							</table>	
						</div>	
						<!-- ============ End Favorite RFP Table ============= -->
					</div>	
				</div>	
			</div>
		</div>	
		<!-- End Doctor's Tab Section -->

		<div class="divider divider-color divider-center divider-short"><!-- divider -->
			<i class="fa fa-cog"></i>
		</div>

		<!-- Doctor's Filter For Search RFP -->
		<div class="row rfp_radar_filter">			
			<div class="col-md-12">
				<h4>Search & Email Notifications</h4>
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive rfp_table_layout">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Filter Name</th>
								<th>Notification</th>
								<th>Created On</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(count($search_filter_list) > 0) :?>
							<?php foreach($search_filter_list as $key=>$search_filter) :?>
							<tr class="search_filter_row_<?=$key?>">
								<td><a href="<?=base_url('rfp/view_filter_data/'.encode($search_filter['id']))?>"><?=$search_filter['filter_name']?></a></td>
								<td>
									<label class="radio">
										<input type="radio" class="notify_status" name="notification_<?=$key?>" data-id="<?=$search_filter['id']?>" value="0" <?php if($search_filter['notification_status'] == '0') { echo "checked"; }?>>
										<i title="None"></i> None
									</label>
									<label class="radio">
										<input type="radio" class="notify_status" name="notification_<?=$key?>" data-id="<?=$search_filter['id']?>" value="1" <?php if($search_filter['notification_status'] == '1') { echo "checked"; }?>>
										<i title="Daily"></i> Daily
									</label>
									<label class="radio">
										<input type="radio" class="notify_status" name="notification_<?=$key?>" data-id="<?=$search_filter['id']?>" value="2" <?php if($search_filter['notification_status'] == '2') { echo "checked"; }?>>
										<i title="Weekly"></i> Weekly
									</label>
									<label class="radio">
										<input type="radio" class="notify_status" name="notification_<?=$key?>" data-id="<?=$search_filter['id']?>" value="3" <?php if($search_filter['notification_status'] == '3') { echo "checked"; }?>>
										<i title="Biweekly"></i> Biweekly
									</label>
								</td>
								<td><?=date("m-d-Y",strtotime($search_filter['created_at']))?></td>
								<td>
									<a href="<?=base_url('rfp/view_filter_data/'.encode($search_filter['id']))?>" class="label label-info" title="Edit Filter"><i class="fa fa-edit"></i></a>
									<a onclick="delete_search_filter(<?=$search_filter['id']?>,<?=$key?>)" class="label label-danger" title="Delete Filter"><i class="fa fa-trash"></i></a>
								</td>
							</tr>	
							<?php endforeach; ?>
							<?php else :?>
								<tr>
									<td colspan="4" class="text-center">
										<b>Save your <a href="<?=base_url('rfp/search_rfp')?>" class="goto_rfp">Bid on Requests</a> Searches! In this section you can manage your searches and define your Email Notification to receive updates on new treatment plans.</b>
									</td>
								</tr>
							<?php endif;?>
						</tbody>
					</table>
				</div>	
			</div>	
		</div>	
		<!-- // ENDS Doctor's Filter For Search RFP -->

		<div class="divider divider-color divider-center divider-short">
			<!-- divider -->
			<i class="fa fa-cog"></i>
		</div>


		<!-- Doctor's All Review -->
		<div class="row review-list">
			<div class="col-md-12">
				<h4> Your Reviews by Patient: </h4>
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive rfp_table_layout">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Patient Name</th>
								<th>Request Title</th>
								<th>Rating</th>
								<th>Review Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($review_list)) { ?>
								<?php foreach($review_list as $key=>$review) :?>	
									<tr>
										<td><?=$review['user_name'];?></td>
										<td><?=$review['rfp_title']; ?></td>
										<td class="doctor_rating">
											<div class="star-rating">
											    <span class="display_rating_<?=$key?>"></span>
												<span class="avg_rating"><?=$review['rating']?> / 5.0</span>
											</div>
										</td>
										<!-- For Display Star Rating -->
										<script>
											$(".star-rating .display_rating_<?=$key?>").rateYo({
												rating: <?=$review['rating']?>,
												starWidth : "20px",
												readOnly: true
											});
										</script>
										<!-- End Display Star Rating -->	
										<td><?=date("m-d-Y",strtotime($review['created_at'])); ?></td>
										<td>
											<!-- === If Thank you note not submitted then enable send note button otherwise only view == -->
											<?php if($review['doctor_comment'] == '') :?>
												<a class="label label-success" title="Send Thank you note" data-toggle="modal" data-target=".thankyou_note" onclick="send_reply(<?=$key?>)"><i class="fa fa-reply"></i></a>
											<?php else : ?>
												<a class="label label-info" title="View Review" data-toggle="modal" data-target=".thankyou_note" onclick="view_review(<?=$key?>)"><i class="fa fa-eye"></i></a>
											<?php endif;?>
											<!-- == End == -->
										</td>
									</tr>
								<?php endforeach; ?>	
							<?php }else{ ?>
								<tr>
									<td colspan="6" class="text-center">
										<b>No data Found</b>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>	
			</div>	
		</div>	
		<!-- // ENDS here Review -->

		<div class="divider divider-color divider-center divider-short">
			<!-- divider -->
			<i class="fa fa-cog"></i>
		</div>

		

		<!-- <div class="divider divider-color divider-center divider-short">
			<i class="fa fa-cog"></i>
		</div> -->
		
		<!-- Payment Table -->
		<!-- <div class="row">
			<div class="col-md-12">
				<h4>Payment History</h4>	
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive rfp_table_layout">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Request Title</th>
								<th>User Name</th>
								<th>Request Status</th>
								<th>Dentition Type</th>
								<th>Paid Price</th>
								<th>Refund Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($rfp_list)) { ?>
								<?php foreach($rfp_list as $key=>$list) { ?>
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
								<?php } ?>
							<?php }else{ ?>
								<tr>
									<td colspan="7" class="text-center">
										<b>No data Found</b>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>			
			</div>	
		</div> -->	
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
								<label>Request Title</label>
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


<!-- ==================== Modal Popup For Apply Promotional Code ========================= -->
<div class="modal fade doctor_payment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Proceed with your payment for won Request</h4>
			</div>
			<form action="<?=base_url('rfp/make_doctor_payment')?>" method="POST" id="form_doctor_payment"
				onsubmit="$('#preloader').show();">							
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h4>
									Your Bid : $ <span class="my_bid"></span>
								</h4>
							</div>	
						</div>

						<div class="col-sm-8 margin-bottom-10">	
														
							<span class="clearfix due_1">
								<span class="pull-left">Due payment 1 (will deduct instantly):</span>
								<span class="pull-right due_1_price">$0.00</span>
							</span>

							<span class="clearfix due_2">
								<span class="pull-left">Due payment 2 (will deduct after 45 days):</span>
								<span class="pull-right due_2_price">$0.00</span>
							</span>
							
							<hr>

							<span class="clearfix">
								<span class="pull-right size-20 total-price">									
									
								</span>
								<strong class="pull-left">TOTAL:</strong>
							</span>																	
						</div>

						<br/>
						<br/>

						<div class="coupen-code-div">
							<div class="form-group">
								
								<!-- <div class="fancy-file-upload fancy-file-success">
									<input type="text" class="form-control" name="coupan_code" id="coupan_code"/>
									<span class="button" id="apply-code">Apply Code</span>
								</div> -->
								<div class="col-sm-9">
									<label>Coupon Code</label>
									<input type="text" class="form-control" name="coupan_code" id="coupan_code"/>
								</div>
								<div class="col-sm-3">
									<label>&nbsp;</label>
									<a href="#" class="btn btn-info" id="apply-code">Apply Code </a>
								</div>	
								<span class="coupan-msg"></span>
							</div>

						</div>
						
						<div class="payment-type-div">
							<div class="form-group">
								
								<?php if(!empty($agreement_data)) { 
									$agree_data = json_decode($agreement_data['meta_arr']);
									$paypal_email = $agree_data->EMAIL;	
								 } ?>
								<div class="col-sm-9">
									<label>Your current payment type</label>
									<select name="payment_method" class="form-control">
										<option value="paypal" <?php if($default_method == 'paypal'){ echo 'selected'; } ?>>Paypal <?=isset($paypal_email)?" - (".$paypal_email.")":''?></option>
										<?php if(!empty($agreement_data)) { ?>
										<option value="paypal_new" <?php if($db_data['default_payment'] == 'paypal_new'){ echo 'selected'; } ?> > Change Paypal</option>
										<?php } ?>
										<option value="manual" <?php if($default_method == 'manual'){ echo 'selected'; } ?>>Manual</option>
									</select>
								</div>								
							</div>
						</div>

						<!-- <div class="col-sm-12">
							<div class="form-group">
								<h4>Final Price : $ <span class="final-prices"><?=config('patient_fees')?></span></h4>
							</div>
						</div>	 -->					
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="hidden" name="due_1" id="due_1_id">
							<input type="hidden" name="due_2" id="due_2_id">							
							<input type="hidden" name="rfp_id" id="rfp_id_frm">
							<input type="hidden" name="total_due_modal" id="total_due_modal">
							<input type="hidden" name="orignal_price" id="orignal_price">
							<input type="hidden" name="is_coupon_applied" id="is_coupon_applied" value="0" >
							<input type="submit" name="submit" class="btn btn-info" value="Make Payment">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>	
					</div>	
				</div>	
			</form>

		</div>
	</div>
</div>

<!-- ==================== Modal Popup For Thank You Note ========================= -->
<div class="modal fade thankyou_note" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel"></h4>
			</div>
			<form action="<?=base_url('dashboard/thankyou_note')?>" method="POST" id="frmreviewreply">
				<input type="hidden" name="rfp_rating_id" id="rfp_rating_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Patient Name : <span id="review_user_name"></span></label>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Rating : <span id="rating_num"></span> / 5.0</label>
								<div class="star-rating">
								    <span class="view_display_rating"></span>
								</div>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Review Description :</label>
								<span id="review_description"></span>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Your Comment :</label>
								<textarea name="doctor_comment" id="text_doctor_comment" class="form-control" rows="5" required></textarea>
								<span id="label_doctor_comment"></span>
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
<!-- ================== /Modal Popup For Thank You Note ========================= -->	


<!-- ==================== Modal Popup For Select Appointment option ========================= -->
<div class="modal fade select_appointment_option" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Appointment Options</h4>
			</div>
			<form action="" method="POST" id="frm_select_app_option">
				<input type="hidden" name="select_app_key" id="select_app_key">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Patient Name : <span id="select_patient_name"></span></label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Patient Phone : <span id="select_patient_phone"></span></label>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Request Title : <span id="select_rfp_title"></span></label>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<a class="btn btn-info" onclick="choose_call_option()"><i class="fa fa-phone"></i> Call</a>
								<a class="btn btn-info" onclick="choose_app_option()"><i class="fa fa-share-alt"></i> Share available Appointments</a>
							</div>	
						</div>	
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
						</div>	
					</div>	
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Select Appointment option ========================= -->	

<!-- ==================== Modal Popup For Call Appointment ========================= -->
<div class="modal fade call_appointment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Call & Confirm Appointment</h4>
			</div>
			<form action="<?=base_url('dashboard/call_appointment')?>" method="POST" id="frm_call_appointment">
				<input type="hidden" name="rfp_id" id="call_app_rfp_id">
				<input type="hidden" name="appointment_id" id="call_app_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Patient Name : <span id="call_app_user_name"></span></label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Patient Phone : <span id="call_patient_phone"></span></label>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Request Title : <span id="call_app_rfp_title"></span></label>
							</div>
						</div>
						<div class="col-sm-12 patient_schedule">
							<div class="form-group">
								<label>Your Patient's Appointment Preference : <span></span></label>
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
													<th><input type="checkbox" id="Call_M_<?=$i?>" name="appointment_schedule[]" value="M_<?=$i?>" disabled></th>
												<?php endfor; ?>
											</tr>
											<tr>
												<th>Afternoon</th>
												<?php for($i=1;$i<=6;$i++) :?>
													<th><input type="checkbox" id="Call_A_<?=$i?>" name="appointment_schedule[]" value="A_<?=$i?>" disabled></th>
												<?php endfor; ?>
											</tr>		
										</tbody>	
									</table>	
								</div>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Message from Your Patient :</label>
								<span id="call_app_rfp_comment"></span>
							</div>
						</div>	

						<!-- For call Appointment manage --> 
						<div class="col-sm-6">
							<div class="form-group">
								<label>Appointment Date :</label>
								<input type="text" id="call_app_date" name="appointment_date" class="form-control datepicker" data-format="mm-dd-yyyy" readonly required >
							</div>
						</div>	
						<div class="col-sm-6">
							<div class="form-group">
								<label>Appointment Time :</label>
								<input type="text" id="call_app_time" name="appointment_time" class="form-control timepicker" readonly required >
							</div>
						</div>
						<!-- End For call Appointment manage --> 

						<div class="col-sm-12">
							<div class="form-group">
								<label>Your Comment :</label>
								<textarea name="doc_comments" id="call_app_doc_comments" class="form-control" rows="5"></textarea>
							</div>	
						</div>		
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-info submit_btn" value="Submit">
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="var rfp_id= $('#call_app_rfp_id').val(); $('.close').click(); $('.schedule_app_'+rfp_id).click();">
						</div>	
					</div>	
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Call Appointment ========================= -->	

<!-- ==================== Modal Popup For Manage Appointment ========================= -->
<div class="modal fade manage_appointment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Manage Appointment</h4>
			</div>
			<form action="<?=base_url('dashboard/manage_appointment')?>" method="POST" id="frm_manage_appointment">
				<input type="hidden" name="rfp_id" id="appointment_rfp_id">
				<input type="hidden" name="appointment_id" id="appointment_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Patient Name : <span id="appointment_user_name"></span></label>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Request Title : <span id="appointment_rfp_title"></span></label>
							</div>
						</div>
					   <div class="col-sm-12 patient_schedule">
							<div class="form-group">
								<label>Your Patient's Appointment Preference : <span></span></label>
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
												<th>Afternoon</th>
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
								<label>Message from Your Patient :</label>
								<span id="appointment_rfp_comment"></span>
							</div>
						</div>	

						<!-- For multiple Appointment manage --> 
						<?php for($i=1;$i<=3;$i++) : ?>	
							<div class="mul_schedule_<?=$i?> schedule_data">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Appointment Date <?=$i?> :</label>
										<input type="text" id="appointment_date_<?=$i?>" name="appointment_date[]" class="form-control datepicker" data-format="mm-dd-yyyy" readonly <?php if($i == 1) { echo "required"; } ?>>
									</div>
								</div>	
								<div class="col-sm-5">
									<div class="form-group">
										<label>Appointment Time <?=$i?> :</label>
										<input type="text" id="appointment_time_<?=$i?>" name="appointment_time[]" class="form-control timepicker" readonly <?php if($i == 1) { echo "required"; } ?>>
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
						<!-- End For multiple Appointment manage --> 

						<div class="col-sm-12">
							<div class="form-group">
								<label>Your Comment :</label>
								<textarea name="doc_comments" id="appointment_doc_comments" class="form-control" rows="5"></textarea>
							</div>	
						</div>		
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<a class="btn btn-info btn_call" onclick="choose_call_option()"><i class="fa fa-phone"></i> Call</a>
							<a onclick="reschedule_from_view_app()" class="btn btn-warning reschedule_view_app">Reschedule Appointment</a>
							<input type="submit" name="submit" class="btn btn-info submit_btn" value="Submit">
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick=" var rfp_id= $('#appointment_rfp_id').val(); $('.close').click(); $('.schedule_app_'+rfp_id).click();">
							<a onclick="delete_from_view_app()" class="btn btn-danger delete_view_app">Delete Appointment</a>	
						</div>	
					</div>	
				</div>	
			</form>
		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Manage Appointment ========================= -->

<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>

<script type="text/javascript">

	<?php 
    	$schedule_rfp = $this->input->get('schedule_rfp');
    	if($schedule_rfp != ''){ 
    		$schedule_rfp = decode($schedule_rfp);
   	?> 
   		setTimeout(function(){ $("#rfp_id_<?php echo $schedule_rfp;?>").click(); $.popVar("schedule_rfp"); }, 2000);
    <?php } ?>

    <?php 
        $proceed_rfp = $this->input->get('proceed_rfp');
        if($proceed_rfp != ''){ 
            $proceed_rfp = decode($proceed_rfp);
    ?> 
        setTimeout(function(){ $(".payment_rfp_<?php echo $proceed_rfp;?>").click(); $.popVar("proceed_rfp"); }, 2000);
    <?php } ?>



    function submit_form(obj){

        var dynamic_id = $(obj).data('id');
        var message_text = $('#message_id_'+dynamic_id).val();        
        $('#validate-msg-'+dynamic_id).html('');

        if(message_text == ''){
            $('#validate-msg-'+dynamic_id).html('<label class="validation-error-label" for="message">Please provide a Message</label>');
        }else{            
            $('#button_'+dynamic_id).hide();
            $('#anchor_'+dynamic_id).show();
            var chat_msg_data = $("#timeline_form_"+dynamic_id).serialize();

            $.post("<?=base_url('rfp/send_message')?>",chat_msg_data,function(data){

                $('#message_id_'+dynamic_id).val('');

                var uname= "<?=$this->session->userdata('client')['fname'].' '.$this->session->userdata('client')['lname']?>";

                <?php if($this->session->userdata('client')['avatar'] != '') { ?>
                    var uavatar= "<?php echo base_url('uploads/avatars/'.$this->session->userdata('client')['avatar']); ?>";
                <?php }else { ?>
                    var uavatar= "<?php echo DEFAULT_IMAGE_PATH.'user/user-img.jpg';  ?>";
                <?php } ?>

                var msg_block = '';                
                msg_block += '<li class="timeline-inverted"><div class="timeline-badge warning">';
                msg_block += '<img src="'+uavatar+'"></div><div class="timeline-panel">';
                msg_block += '<div class="timeline-heading"><h5 class="timeline-title">'+uname+'</h5></div>';
                msg_block += '<div class="timeline-body"><p>'+message_text+'</p></div></div></li>';

                $('#div_before_timeline_'+dynamic_id).before(msg_block);
                $('#button_'+dynamic_id).show();
                $('#anchor_'+dynamic_id).hide();
            });
        }
    }
	
	function send_reply(key){
		var review_data = <?php echo json_encode($review_list); ?>;
		$("#rfp_rating_id").val(review_data[key]['rating_id']);
		$("#review_user_name").html(review_data[key]['user_name']);
		$("#rating_num").html(review_data[key]['rating']);
		$("#label_doctor_comment").hide();
		$("#text_doctor_comment").show();
		$("#review_description").html(review_data[key]['feedback']);
		$(".thankyou_note .modal-title").html("Send Thank you note");
		$(".thankyou_note .submit_btn").show();
		star_rating(review_data[key]['rating']);

	}

	function view_review(key){
		var review_data = <?php echo json_encode($review_list); ?>;
		$("#review_user_name").html(review_data[key]['user_name']);
		$("#rating_num").html(review_data[key]['rating']);
		$("#review_description").html(review_data[key]['feedback']);
		$("#label_doctor_comment").html(review_data[key]['doctor_comment']);
		$("#text_doctor_comment").hide();
		$("#label_doctor_comment").show();
		$(".thankyou_note .modal-title").html("View Review Details");
		$(".thankyou_note .submit_btn").hide();
		star_rating(review_data[key]['rating']);
		
	}

	function star_rating(rate){
		$(".star-rating .view_display_rating").rateYo({
			rating: rate,
			starWidth : "25px",
			readOnly: true
		});
	}

	function refund_request(key){
		var rfp_data = <?php echo json_encode($rfp_list); ?>;
		console.log(rfp_data[key]);
		$("#rfp_id").val(rfp_data[key]['rfp_id']);
		$("#payment_id").val(rfp_data[key]['payment_id']);
		$("#rfp_title").val(rfp_data[key]['rfp_title']);
		$("#refund_amt").val(rfp_data[key]['paid_price']);
	}

	function save_alert_data(){
		var treatment_cat = $('#treatment_cat').val();

		$.ajax({
			type:"POST",
			url:"<?php echo base_url().'dashboard/save_dashboard_alert'; ?>",
			data:{treatment_cat:treatment_cat},
			dataType:"JSON",
			success:function(data){
				bootbox.alert('Alert has been saved successfully.');
			}
		});
	}

	//----------------- For Add To favorite & Remove Favorite RFP ------------------
	$(".favorite").on( "click", function() {		
		var rfp_id= $(this).attr('data-id');
		var classNames = $(this).attr('class').split(' ');
		var data1=$(this);
		if($.inArray('unfavorite_rfp',classNames) != '-1'){				
			$.post("<?=base_url('rfp/add_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
				if(data){
					data1.removeClass('unfavorite_rfp');
					data1.addClass('favorite_rfp');
					$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Request added to your favorite list successfully.</div>');
				}
			});
		} else {
			$.post("<?=base_url('rfp/remove_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
				if(data){
					data1.removeClass('favorite_rfp');
					data1.addClass('unfavorite_rfp');
					$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Request removed to your favorite list successfully. </div>');
				
				}
			});
		}
		return false;
	});
	
	function show_modal_doctor(obj){

		var is_second_due= $(obj).data('is-second-due');
		var due_1= $(obj).data('due-one');
		var due_2= $(obj).data('due-two');
		var mybid= $(obj).data('mybid');
		var rfp_id = $(obj).data('rfpid');
		var total_due = $(obj).data('total-due');

		var total_payment = parseFloat(due_1) + parseFloat(due_2);

		// console.log('total_payment '+total_payment);

		$('.my_bid').html(mybid);
		$('.due_1_price').html('$ '+due_1);
		$('.due_2_price').html('$ '+due_2);

		$('#due_1_id').val(due_1);
		$('#due_2_id').val(due_2);
		$('#rfp_id_frm').val(rfp_id);
		$('#total_due_modal').val(total_due);

		$('.total-price').html('$ '+total_payment);
		$('#orignal_price').val(total_payment);
		
		$(".coupan-msg").html("");
		$('#coupan_code').val('');
		$('#is_coupon_applied').val('0');
		$('.doctor_payment').modal('show');			
	}

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

				//if(data != 0){
				if(data != '' && data['id'] != null) {	 
					var is_coupon_appiled = $('#is_coupon_applied').val();
					// If coupon code is limit is exceed than allowed no of times
					if(data['per_user_limit'] > data['total_apply_code'] && is_coupon_appiled == '0'){
							
						var total = parseFloat($('#total_due_modal').val());
						var intial_payment = '<?php echo config("doctor_initial_fees"); ?>'; // fetch initial value from db

						discount_amt = 	((total * data['discount'])/100);
						var after_discount = total - discount_amt;						
					 	
						if(after_discount > parseFloat(intial_payment)){
							due_1 = parseFloat(intial_payment);
							due_2 = after_discount - due_1;
						}else{
							due_1 = after_discount;
							due_2 = 0
						}
						
						due_1 = due_1.toFixed(2);
						due_2 = due_2.toFixed(2);
						after_discount = after_discount.toFixed(2);
						
						$('.due_1_price').html('$ '+due_1);
						$('.due_2_price').html('$ '+due_2);

						$('#due_1_id').val(due_1);
						$('#due_2_id').val(due_2);

						$('#orignal_price').val(total); // orignal price
						$('#total_due_modal').val(after_discount); // after discount price						
						$('.total-price').html('$ '+ after_discount);

						$('#is_coupon_applied').val('1');
						$(".coupan-msg").html("Coupon Code apply successfully");
						$(".coupan-msg").css("color", "green");
					}else{
						$(".coupan-msg").html("Sorry, You've already applied this code.");
						$(".coupan-msg").css("color", "red");
					}
				}else{
					$(".coupan-msg").html("Invalid Coupon Code");
					$(".coupan-msg").css("color", "red");
				}

			},"json");
		}else{
			$(".coupan-msg").html("Please Enter Coupon Code");
			$(".coupan-msg").css("color", "red");	
		}
	});

	//--------------- Appointment Re schedule from view appointment section -------
	function reschedule_from_view_app(){
		$(".modal").removeClass("fade").modal("hide");
		var rfp_id = $('#appointment_rfp_id').val();
		reschedule_won_rfp_app(rfp_id);
	}
	//--------------- End Appointment Re schedule from view appointment section -------

	//--------------- Appointment Delete from view appointment section -------
	function delete_from_view_app(){
		$(".modal").removeClass("fade").modal("hide");
		var rfp_id = $('#appointment_rfp_id').val();
		$("#delete_rfp_id_"+rfp_id).click();
		// reschedule_won_rfp_app(rfp_id);
	}
	//--------------- End Appointment Delete from view appointment section -------
	

	//--------------- Appointment schedule from won rfp section -------
	function schedule_won_rfp_app(rfp_id){
		$("#rfp_id_"+rfp_id).click();
	}

	//--------------- Appointment Reschedule from won rfp section -------
	function reschedule_won_rfp_app(rfp_id){
		$("#resch_rfp_id_"+rfp_id).click();
	}

	//--------------- Appointment View from won rfp section -------
	function view_won_rfp_app(rfp_id){
		$("#rfp_id_"+rfp_id).click();
	}
	


    // ----------- For Select Appointment option -----------
    function select_appointment_option(key){
    	var appointment_data = <?php echo json_encode($appointment_list); ?>;
    	$("#select_app_key").val(key);
    	$("#select_patient_name").html(appointment_data[key]['user_name']);
    	$("#select_patient_phone").html(appointment_data[key]['phone']);
    	$("#select_rfp_title").html(appointment_data[key]['title']);
    }

    //---------------- Choose Call Option ---------------------
    function choose_call_option(){
    	$(".modal").removeClass("fade").modal("hide");
    	$(".call_appointment").addClass("fade").modal("show");
    	call_appointment($("#select_app_key").val());
    }

    //---------------- Choose Appointment option --------------
    function choose_app_option(){
    	$(".modal").removeClass("fade").modal("hide");
    	$(".manage_appointment").addClass("fade").modal("show");
    	manage_appointment($("#select_app_key").val());
    }

    //--------------- For Call Appointment ------------
    function call_appointment(key){
    	var appointment_data = <?php echo json_encode($appointment_list); ?>;
    	$("#call_app_rfp_id").val(appointment_data[key]['id']);
    	$("#call_app_id").val(appointment_data[key]['appointment_id']);
    	$("#call_app_user_name").html(appointment_data[key]['user_name']);
    	$("#call_patient_phone").html(appointment_data[key]['phone']);
    	$("#call_app_rfp_title").html(appointment_data[key]['title']);

    	//----------- For Select Appointment data submit by patient -----------
    	if(appointment_data[key]['appointment_schedule'] != ''){
    		$(".patient_schedule label span").html("");
    		$(".appointment_schedule_table").show();
    		var app_arr = appointment_data[key]['appointment_schedule'].split(',');

    		$.each(app_arr, function( key, val ) {
    		  var app_data = val.split('_');
    		  $("#Call_"+app_data[0]+"_"+app_data[1]).prop('checked', true);
    		});
    	}
    	else{
    		$(".patient_schedule label span").html("N/A");
    		$(".appointment_schedule_table").hide();
    	}
    	//-----------------------------------------------------------------------
    	if(appointment_data[key]['appointment_comment'] != '') {	
    		$("#call_app_rfp_comment").html(appointment_data[key]['appointment_comment']);
    	}else{
    		$("#call_app_rfp_comment").html('N/A');
    	}
    	//-----------------------------------------------------------------------
    	$(".validation-error-label").remove();
    }

    // ----------- For manage Appointment-----------
    function manage_appointment(key){
    	var appointment_data = <?php echo json_encode($appointment_list); ?>;
    	$("#appointment_rfp_id").val(appointment_data[key]['id']);
    	$("#appointment_id").val(''); // It means add appointment
    	$("#appointment_user_name").html(appointment_data[key]['user_name']);
    	$("#appointment_rfp_title").html(appointment_data[key]['title']);
    	$(".schedule_data input:radio").hide();
    	$(".schedule_data").show();

    	//----------- For Select Appointment data submit by patient -----------
    	if(appointment_data[key]['appointment_schedule'] != ''){
    		$(".patient_schedule label span").html("");
    		$(".appointment_schedule_table").show();
    		var app_arr = appointment_data[key]['appointment_schedule'].split(',');

    		$.each(app_arr, function( key, val ) {
    		  var app_data = val.split('_');
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
    	//-----------------------------------------------------------------------

    	$('#appointment_doc_comments').html('');
    	$('#appointment_doc_comments').attr('readonly', false);
    	$('#frm_manage_appointment .btn_call').show();
    	$('#frm_manage_appointment .reschedule_view_app').hide();
    	$('#frm_manage_appointment .delete_view_app').hide();
    	$("#frm_manage_appointment .submit_btn").show();
    	$(".validation-error-label").remove();
    }
    function view_appointment(key){

    	$(".appointment_schedule_table input:checkbox").prop('checked', false);
    	$(".schedule_data input:radio").hide();
    	$(".schedule_data").hide();
    	var appointment_data = <?php echo json_encode($appointment_list); ?>;
    	
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
    	var approve_appointment = 0;
    	var app_sch_arr= appointment_data[key]['appointment_schedule_arr'];
    	$.each(app_sch_arr, function( key, data ) {
    		var date= data['appointment_date'];
    		var d= date.split("-");
    		var time = data['new_appointment_time'];
    		

    		$(".mul_schedule_"+(key+1)).show();

    		$("#appointment_date_"+(key+1)).val(d[1]+"-"+d[2]+"-"+d[0]);
    		$("#appointment_time_"+(key+1)).val(time);
    		$("#schedule_selected_"+(key+1)).val(data['id']);

    		//---------- IF Schedule selected then checked radio button -------
    		$(".schedule_data input:radio").prop('disabled', true);
    		if(data['is_selected'] == 1){
    			$(".schedule_data input:radio").show();
    			$("#schedule_selected_"+(key+1)).prop("checked", true);
    			approve_appointment= 1;
    		}
    		//------------------
    	});

    	if(approve_appointment == 0) // If condition true means doctor able to edit appointment otherwise only view
    	{
    		$("#select_app_key").val(key); // For call option in manage appointment
    		$(".schedule_data").show();
    		$("#appointment_id").val(appointment_data[key]['appointment_id']); // It means edit appointment
    		$('#appointment_doc_comments').attr('readonly', false);
    		$('#frm_manage_appointment .btn_call').show();
    		$('#frm_manage_appointment .reschedule_view_app').hide();
    		$('#frm_manage_appointment .delete_view_app').show();
    		$("#frm_manage_appointment .submit_btn").show();
    	}
    	else{
    		$("#select_app_key").val(''); // IF apporve then remove the value for call option in manage appointment
    		$("#appointment_id").val(''); // It means only view appointment
    		$('#appointment_doc_comments').attr('readonly', true);
    		$('#frm_manage_appointment .btn_call').hide();
    		$('#frm_manage_appointment .reschedule_view_app').show();
    		$('#frm_manage_appointment .delete_view_app').hide();
    		$("#frm_manage_appointment .submit_btn").hide();
    	}
    	//----------------- End For Multiple Appointment Schedule (Date & Time) Submit by doctor---------

    	$("#appointment_doc_comments").html(appointment_data[key]['doc_comments']);
    	$(".validation-error-label").remove();
    }
    // ----------- End For manage Appointment  -----------


    //---------------- Chnage Notification status for rfp search --------------
    $(".notify_status").click(function(e){
    	var filter_id=$(this).data('id');
    	var notify_status= $(this).val();
    	$.post("<?=base_url('dashboard/change_filter_notify_status/')?>",{	'filter_id' : filter_id , 'notification_status' : notify_status},function(data){

    	});
    });

    //-----------------End Notification status for rfp search -----------------

    //------------------------ Delete RFP Filter -------------------
    function delete_search_filter(filter_id,key){
    	bootbox.confirm('Are you sure to delete Request filter ?' ,function(res){
    		if(res){
    			$.post("<?=base_url('dashboard/delete_search_filter/')?>",{	'filter_id' : filter_id },function(data){
    				if(data){
   					$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Request Filter Deleted Successfully.</div>');
    					$(".search_filter_row_"+key).hide();
    				}
    				else{
    					$(".alert-message").html('<div class="alert alert-danger margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error Into Delete Request Filter.</div>');
    				}
    			});
    		}
    	});	
    }
    //----------------------- End Delete RFP Filter ----------------


    //-------------------------- Delete Appointment ------------------
    $(document).on( "click",".delete_appointment", function(e) {  
    	e.preventDefault();
        var lHref = $(this).attr('href');
    	bootbox.confirm('Are you sure to delete appointment ?' ,function(res){
    		if(res){
    			window.location.href = lHref; 
    		}	
    	});
    });
    //------------------------- End Delete Appointment ---------------

//-------------------------- Reschedule Appointment ------------------
    $(document).on( "click",".reschedule_appointment", function(e) {  
    	e.preventDefault();
        var lHref = $(this).attr('href');
    	bootbox.confirm('Are you sure to reschedule appointment ?' ,function(res){
    		if(res){
    			window.location.href = lHref; 
    		}	
    	});
    });
    //------------------------- End Reschedule Appointment ---------------

    //--------------- For manage Appointment Form Validation --------------
    $("#frm_manage_appointment").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
    });

    $("#frm_call_appointment").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
    });

    

    

</script>