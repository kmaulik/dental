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
				<?=$this->session->flashdata('success');?>
			</div>
		<?php endif; ?>
		<?php if($this->session->flashdata('error')) : ?>
			<div class="alert alert-danger margin-bottom-30">
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
					
					<a class="btn btn-primary" onclick="$('#reminders_modal').modal('show'); ">
						<i class="et-clock"></i>
						Add Reminder
					</a>

					<br/>
					<br/>
					<br/>

					<?php if(count($rfp_data) > 0) :?>
						<div class="list-group success square no-side-border search_rfp">
							<?php foreach($rfp_data as $record) :?>
								<!-- href="<?=base_url('rfp/view_rfp/'.encode($record['id']))?>" -->
								<a  class="list-group-item list_groop_item_2">
									<div class="rfp-left">
										<?php if(isset($record['favorite_id']) && $record['favorite_id'] != '') : ?>
											<!-- Means Favorite RFP -->
											<span class="favorite fa fa-star favorite_rfp" data-id="<?=encode($record['id'])?>"></span>
										<?php else : ?>
											<!-- Means Not Favorite RFP -->
											<span class="favorite fa fa-star unfavorite_rfp" data-id="<?=encode($record['id'])?>"></span>
										<?php endif; ?>
										<img src="<?php if($record['avatar'] != '') 
				                    		{ echo base_url('uploads/avatars/'.$record['avatar']); } 
				                    	else 
				                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" class="avatar img-circle" alt="Avatar">
										<span class="name"><?=$record['fname']." ".$record['lname'];?></span>
										<span class="subject">
											<span class="label label-info"><?=ucfirst($record['dentition_type'])?></span> 
											<span class="hidden-sm hidden-xs"><?=character_limiter(strip_tags($record['title']), 70);?></span>
										</span>
									</div>	
									<div class="rfp-right">
										<?php if($record['img_path'] != '') :?>
											<span class="attachment"><i class="fa fa-paperclip"></i></span>
										<?php endif; ?>
										<span class="time"><?=date("Y-m-d H:i a",strtotime($record['created_at']));?></span>
									</div>
								</a>
							<?php endforeach; ?>	
						</div>
						<?php echo $this->pagination->create_links(); ?>
					<?php else : ?>
						<h3>No data Available</h3>
					<?php endif; ?>			
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
			<form action="<?php echo base_url().'home/add_reminder'; ?>" method="POST" onsubmit="return validate_form();">
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
									<input type="checkbox" checked="" name="is_active">
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
							<input type="submit" name="submit" class="btn btn-info" value="Add">
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

</script>

 