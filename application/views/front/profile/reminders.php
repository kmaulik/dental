<section class="page-header page-header-xs">
	<div class="container">
		<!-- breadcrumbs -->
		<ol class="breadcrumb breadcrumb-inverse">
			<li><a href="#">Home</a></li>
			<li><a href="#">Reminders</a></li>
			<li class="active"><?php echo $db_data['fname'].' '.$db_data['lname']; ?></li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section>
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

		<!-- RIGHT -->
		<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 margin-bottom-80">

			<ul class="nav nav-tabs nav-top-border">
				<li class="active">
					<a href="#info" data-toggle="tab">
						Reminders
					</a>
				</li>
			</ul>
			<div class="tab-content margin-top-20">
				<!-- PERSONAL INFO TAB -->
				<div class="tab-pane fade in active" id="info">
					
					<a class="btn btn-primary" onclick="$('#reminder_modal_form').trigger('reset');
						$('#reminder_id_hidden').val(''); $('#reminders_modal').modal('show'); ">
						<i class="et-clock"></i>
						Add Reminder
					</a>

					<br/>
					<br/>
					<br/>

					<div class="row">
						<div class="col-md-12">
							<h4>My Reminders</h4>	
							<hr/>
						</div>
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>No</th>
											<th>Reminder Title</th>
											<th>Reminder Time</th>
											<th>Is Active ?</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($reminders_data as $reminder) : ?>
											<tr>
												<td>1</td>
												<td><?=$reminder['reminder_title']?></td>
												<td><?=$reminder['reminder_time']?></td>
												<td>
													<?php
														if($reminder['is_active']=='1'){
															echo 'Yes';
														}else{
															echo 'No';
														}
													?>
												</td>
												<td>													
													<a class="btn btn-3d btn-xs btn-reveal btn-green" 
														data-id="<?php echo $reminder['id']; ?>"
														onclick="edit_reminder(this)"
													    data-toggle="modal" data-target=".refund_request">
														<i class="fa fa-money"></i><span>Edit</span>
													</a>
													<a class="btn btn-3d btn-xs btn-reveal btn-green" 
														data-id="<?php echo $reminder['id']; ?>"
														onclick="delete_reminder(this)"
														data-toggle="modal" data-target=".refund_request">
														<i class="fa fa-money"></i><span>Delete</span>
													</a>
												</td>
											</tr>
										<?php endforeach; ?>	
									</tbody>
								</table>
							</div>			
						</div>	
					</div>
						
				</div>
				<!-- /PERSONAL INFO TAB -->

			</div>
		</div>
		<!-- load Partial view for the side bar  -->
		<?php $this->load->view('front/layouts/side_bar_profile'); ?>
	</div>
</section>
<!-- / -->


<!-- ==================== Modal Popup For Apply Promotional Code ========================= -->
<div class="modal fade" id="reminders_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Doctor Reminder</h4>
			</div>
			<form action="<?php echo base_url().'home/add_reminder'; ?>" id="reminder_modal_form" method="POST" onsubmit="return validate_form();">
				<div class="modal-body">
					<div class="row">						
						<div class="col-sm-12">							
							<div class="form-group">
								<label>Reminder Title</label>								
								<input type="text" class="form-control" name="reminder_title" id="reminder_title" />
								<span class="reminder_title_msg"></span>
							</div>
							
							<div class="form-group">
								<label>Reminder date</label>
								<input type="text" class="form-control disable_past" data-format="yyyy-mm-dd" 
									   data-lang="en" data-RTL="false" readonly  id="reminder_date" name="reminder_date" >
								<span class="reminder_date_msg"></span>	   
							</div>

							<div class="form-group">
								<label>Reminder date</label>
								<input type="text" class="form-control timepicker" id="reminder_time" name="reminder_time"
										readonly >
								<span class="reminder_time_msg"></span>
							</div>	
							
							<br/>	

							<div class="form-group">
								<label>Make reminder active ?</label>																
								<label class="switch switch-info">
									<input type="checkbox" checked="" name="is_active" id="is_active">
									<span class="switch-label" data-on="YES" data-off="NO"></span>									
								</label>								
							</div>

						</div>
					</div>
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="hidden" name="reminder_id_hidden" id="reminder_id_hidden" />
							<input type="submit" name="submit" class="btn btn-info" value="Save">
							<a onclick="$('#reminders_modal').modal('hide')" class="btn btn-default cancel-payment">Cancel</a>
						</div>	
					</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Place a Bid ========================= -->

<!-- ==================== Modal Popup For Apply Promotional Code ========================= -->
<div class="modal fade" id="reminders_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Doctor Reminder</h4>
			</div>
			<form action="<?php echo base_url().'home/add_reminder'; ?>" id="reminder_modal_form" method="POST" onsubmit="return validate_form();">
				<div class="modal-body">
					<div class="row">						
						<div class="col-sm-12">							
							<div class="form-group">
								<label>Reminder Title</label>								
								<input type="text" class="form-control" name="reminder_title" id="reminder_title" />
								<span class="reminder_title_msg"></span>
							</div>
							
							<div class="form-group">
								<label>Reminder date</label>
								<input type="text" class="form-control disable_past" data-format="yyyy-mm-dd" 
									   data-lang="en" data-RTL="false" readonly  id="reminder_date" name="reminder_date" >
								<span class="reminder_date_msg"></span>	   
							</div>

							<div class="form-group">
								<label>Reminder date</label>
								<input type="text" class="form-control timepicker" id="reminder_time" name="reminder_time"
										readonly >
								<span class="reminder_time_msg"></span>
							</div>	
							
							<br/>	

							<div class="form-group">
								<label>Make reminder active ?</label>																
								<label class="switch switch-info">
									<input type="checkbox" checked="" name="is_active" id="is_active">
									<span class="switch-label" data-on="YES" data-off="NO"></span>									
								</label>								
							</div>

						</div>
					</div>
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="hidden" name="reminder_id_hidden" id="reminder_id_hidden" />
							<input type="submit" name="submit" class="btn btn-info" value="Save">
							<a onclick="$('#reminders_modal').modal('hide')" class="btn btn-default cancel-payment">Cancel</a>
						</div>	
					</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Place a Bid ========================= -->

<script type="text/javascript">
	
	function validate_form(){
		var reminder_title = $('#reminder_title').val();
		var reminder_date = $('#reminder_date').val();
		var reminder_time = $('#reminder_time').val();
		var error_cnt = 0;

		$('.reminder_title_msg').html(''); $('.reminder_date_msg').html(''); $('.reminder_time_msg').html('');

		if(reminder_title == ''){
			$('.reminder_title_msg').html('<div class="alert alert-mini alert-danger margin-top-10">Please enter reminder title.</div>');
			error_cnt++;
		}

		if(reminder_date == ''){
			$('.reminder_date_msg').html('<div class="alert alert-mini alert-danger margin-top-10">Please enter reminder date.</div>');
			error_cnt++;
		}

		if(reminder_time == ''){
			$('.reminder_time_msg').html('<div class="alert alert-mini alert-danger margin-top-10">Please enter reminder time.</div>');
			error_cnt++;
		}

		if(error_cnt == 0){			
			return true;
		}else{
			return false;
		}
	}

	function delete_reminder(obj){
		var reminder_id = $(obj).attr('data-id');
		bootbox.confirm('Are you sure ?',function(res){
			if(res){
				window.location.href="<?php echo base_url().'home/delete_reminder/'; ?>"+reminder_id;
			}
		});
	}

	function edit_reminder(obj){
		var reminder_id = $(obj).attr('data-id');
		console.log(edit_reminder);
		$.ajax({
			type:"POST",
			url:"<?php echo base_url().'home/get_reminder_data'; ?>",
			data:{reminder_id:reminder_id},
			dataType:'JSON',
			success:function(data){

				$('#reminder_id_hidden').val(data['id']);
				$('#reminder_title').val(data['reminder_title']);
				$('#reminder_date').val(data['only_date']);
				$('#reminder_time').val(data['only_time']);
				
				if(data['is_active'] == '1'){
					$('#is_active').attr('checked',true);
				}else{
					$('#is_active').attr('checked',false);
				}

				$('#reminders_modal').modal('show');
			}
		});
	}
		
</script>

 