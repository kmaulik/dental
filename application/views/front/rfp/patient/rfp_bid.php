<link rel="stylesheet" href="<?=DEFAULT_CSS_PATH?>jquery.rateyo.min.css">
<script src="<?=DEFAULT_JS_PATH?>jquery.rateyo.min.js"></script>

<section class="page-header page-header-xs">
	<div class="container">
	<h1> Request Bid List </h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp');?>">Request List</a></li>
			<li class="active">Request Bid List</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section>
	<div class="container bid_detail">
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

			<!-- For Button -->
			<div class="col-sm-12">
				<div class="pull-right">
					<?php if(!empty($rfp_data)) :?>
						<!-- For Check valid date set and valid date >= today and patient validity not extend then display extend button--> 
						<?php if($rfp_data['status'] == 3 &&  $rfp_data['rfp_valid_date'] != '' && $rfp_data['rfp_valid_date'] >= date("Y-m-d") && $rfp_data['is_extended'] == 0) :?>
							<a href="<?=base_url('rfp/extend_rfp_validity/'.encode($rfp_data['id']).'/1')?>" class="btn btn-primary btn_extend" data-toggle="tooltip" data-placement="top" data-original-title="Extend Request End by 7 days"><i class="fa fa-arrows-alt"></i> Extend Request</a>
						<?php endif; ?>
						<!-- End Check Valid date -->
						<a href="<?=base_url('rfp/view_rfp/'.encode($rfp_data['id']))?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Return to Request Details"><i class="fa fa-arrow-left"></i> Return to Request Details</a>
					<?php endif;?>
				</div>
			</div>			
			<!-- End For Button -->

			<div class="col-sm-12 rfp-title bottom_space">
				<h3 class=""><?=isset($rfp_data['title'])?$rfp_data['title']:''?></h3>
			</div>
			<div class="col-sm-12">
				<h4 class="win-desc-text">Select the winning doctor during the bidding period by selecting this symbol <i class="fa fa-trophy"></i></h4>
			</div>	
			<div class="col-sm-12">
				<!-- Bid List -->	
				<?php if(count($rfp_bid_list) > 0) :  ?>
					<?php foreach ($rfp_bid_list as $key => $bid_list) :?>
						<div class="the-box no-border store-list">
							 <div class="media">
								<a class="pull-left" href="#fakelink">
								<img alt="image" src="<?php if($bid_list['avatar'] != '' && $bid_list['is_profile_allow'] == 1) 
		                    		{ echo base_url('uploads/avatars/'.$bid_list['avatar']); } 
		                    	else 
		                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" class="store-image img-responsive" style="height:120px;width:120px;"></a>
								<div class="clearfix visible-xs"></div>
								<div class="media-body">
									<a href="#fakelink"></a>
									<h4 class="media-heading">
										<a href="<?=base_url('dashboard/view_profile/'.encode($bid_list['doctor_id']).'/'.encode($bid_list['id']))?>" class="my_custom_strong">
											<!-- Check for allow doctor profile or not -->
											<?php if($bid_list['is_profile_allow'] == 1): ?>
												<strong><?=$bid_list['fname']." ".$bid_list['lname']?></strong>
											<?php else :?>
												<strong>Click here to view the Doctor Reviews</strong>
											<?php endif;?>	
											<!-- End Check for allow doctor profile or not -->

											<!-- For Check who is winner -->	
											<?php if($bid_list['rfp_status'] >= 5 && $bid_list['bid_status'] == 2) :?>
												<span class="label label-success">Winner</span>
											<?php endif;?>
											<!-- End For Check who is winner -->	
										</a> 
										<div class="pull-right msg-btn">
											<?php $valid_rfp_date= date("Y-m-d",strtotime($bid_list['rfp_approve_date']. ' + 30 days')); ?>
											<!-- For Choose Winner Doctor (Once Choose winner doctor then hide the button) -->
											<?php if($bid_list['rfp_status'] == 3 && $valid_rfp_date > date("Y-m-d")) : ?> <!-- 3 Means (Open)  Agent Approve && (approv_date + 30 days > curdate) RFP -->
												<a href="<?=base_url('rfp/choose_winner_doctor/'.encode($bid_list['id']).'/'.encode($bid_list['rfp_bid_id']))?>" class="label label-info rfp-price confirm_winner" title="Choose Winner" ><i class="fa fa-trophy"></i></a> 
											<?php endif; ?>	
											<!-- End Choose Winner Doctor -->

											<!-- Add Condition For Cancel Winner Doctor (RFP status waiting for approval (4) && bid status (2) winner then display)-->
											<?php if($bid_list['rfp_status'] == 4 && $bid_list['bid_status'] == 2 && $valid_rfp_date > date("Y-m-d")) :?>
												<a href="<?=base_url('rfp/cancel_winner_doctor/'.encode($bid_list['id']).'/'.encode($bid_list['rfp_bid_id']))?>" class="label label-danger rfp-price cancel_winner" title="Cancel Winner"><i class="fa fa-user-times"></i></a>
											<?php endif; ?>

											<!-- Add Condition For Message & Review Button (RFP status winner(5) && bid status (2) winner then display)-->
											<?php if($bid_list['rfp_status'] >= 5 && $bid_list['bid_status'] == 2) :?>
												<!-- If Review not given for this RFP then display the review button -->
												<?php if(isset($is_rated_rfp) && count($is_rated_rfp) == 0) : ?>
													<a class="label label-info rfp-price" onclick="send_review(<?=$key?>)" title="Review" data-toggle="modal" data-target=".doctor_review"><i class="fa fa-star"></i></a> 
												<?php endif; ?>
												<!-- End Review -->
												<a class="label label-info rfp-price" onclick="send_msg(<?=$key?>)" title="Send Mail" data-toggle="modal" data-target=".send_message"><i class="fa fa-envelope"></i></a> 
												<!-- Display all Message button (If Chat started b/w doctor & patient)-->
												<?php if($bid_list['is_chat_started'] == 1) :?>
													<a href="<?=base_url('messageboard/message/'.encode($bid_list['id']).'/'.encode($bid_list['doctor_id']))?>" class="label label-info rfp-price" title="View Mail"><i class="fa fa-eye"></i></a> 	
												<?php endif; ?>
												<!-- End all Message button-->
											<?php endif; ?>
											<!-- End Message & Review Button-->
											<span class="label label-success rfp-price">&#36;<?=$bid_list['bid_amount']?></span>
										</div>	
									</h4>
									<ul class="list-inline">
										<li>
											<?php $rate=number_format(($bid_list['avg_rating']),2);?>
											<div class="avg-star-rating">
											    <span class="display_rating_<?=$key?>"></span>
											</div>
										</li>
										<!-- For Display Star Rating -->
										<script>
											$(".avg-star-rating .display_rating_<?=$key?>").rateYo({
												rating: <?=$rate?>,
												starWidth : "25px",
												readOnly: true
											});
										</script>
										<!-- End Display Star Rating -->

										<li>(<?=$bid_list['total_review']?$bid_list['total_review']:'0'?>)</li>
										<li><span class="label label-info rating"><?=$rate?> / 5.0</span></li>
										<li> | </li>
										<li><i class="fa fa-clock-o"></i> <?=time_ago($bid_list['created_at'])?> </li>
									</ul>
									<p class="hidden-xs bid-desc">
										<?php echo character_limiter(strip_tags($bid_list['description']), 200);?>
									</p>
								</div><!-- /.media-body -->
							</div><!-- /.media -->
						</div><!-- /.the-box no-border -->
					<?php endforeach ; ?>
				<?php else : ?>
					<h3>No Bid Available</h3>
				<?php endif; ?>	
				<!-- /Bid List -->
			</div>
		</div>
	</div>
</section>	

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
				<input type="hidden" name="rfp_id" id="rfp_id">
				<input type="hidden" name="rfp_title" id="rfp_title">
				<input type="hidden" name="rfp_bid_id" id="rfp_bid_id">
				<input type="hidden" name="to_id" id="to_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<label>Message</label>
							<div class="form-group">
								<textarea name="message" id="message" class="form-control" rows="5" required></textarea>
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

<!-- ==================== Modal Popup For Doctor Appointment  ========================= -->
<div class="modal fade doctor_appointment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Patient’s Appointment Preference:</h4>
			</div>
			<form action="" method="POST" id="frm_doctor_appointment">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<h6 class="app-prefrence">Congratulation to your selection. In order to support you and the doctor, finding a matching appointment, kindly select your preferred availability in the near future. We will share this with your doctor - and the doctor office will revert back with you either through YourToothFairy with an appointment proposal which you can confirm.</h6>
						</div>	
						<div class="col-sm-12">
							<!-- <label>Appointment</label>	 -->
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
<!-- <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'vague.js'; ?>"></script> -->
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


function send_msg(key){
	var rfp_data = <?php echo json_encode($rfp_bid_list); ?>;
	$("#rfp_id").val(rfp_data[key]['id']);
	$("#rfp_title").val(rfp_data[key]['title']);
	$("#rfp_bid_id").val(rfp_data[key]['rfp_bid_id']);
	$("#to_id").val(rfp_data[key]['doctor_id']);
}

function send_review(key){
	var rfp_data = <?php echo json_encode($rfp_bid_list); ?>;
	$("#review_rfp_id").val(rfp_data[key]['id']);
	//$("#rfp_title").val(rfp_data[key]['title']);
	$("#doctor_id").val(rfp_data[key]['doctor_id']);
}


// var vague = $('.my_custom_strong').Vague({
//     intensity:      3,      // Blur Intensity
//     forceSVGUrl:    false,   // Force absolute path to the SVG filter,
//     // default animation options
//     animationOptions: {
//       duration: 1000,
//       easing: 'linear' // here you can use also custom jQuery easing functions
//     }
// });

// vague.blur();
$(".btn_extend").click(function(e){		
	e.preventDefault();
	var lHref = $(this).attr('href');
	bootbox.confirm('Are you sure to extend validity for this Request?' ,function(res){ 	 		
	    if(res) {
	        window.location.href = lHref;
	    }
	});
});


$(".confirm_winner").click(function(e) {
	e.preventDefault();
	var lHref = $(this).attr('href');
	$(".doctor_appointment").modal('show');
	$(".doctor_appointment #frm_doctor_appointment").attr("action",lHref);		
});
	

$(".cancel_winner").click(function(e) {
	e.preventDefault();
	var lHref = $(this).attr('href');
	bootbox.confirm('Are you sure to cancel winner for this Request ?' ,function(res){
		if(res){
			window.location.href = lHref;
		}
	});	
});
	

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

//--------------- For Review Form Validation --------------
// $("#frmreview").validate({
// 	ignore: [],
//     errorClass: 'validation-error-label',
//     successClass: 'validation-valid-label',
//     highlight: function(element, errorClass) {
//         $(element).removeClass(errorClass);
//     },
//     unhighlight: function(element, errorClass) {
//         $(element).removeClass(errorClass);
//     },
//     rules: {
//         rating: {
//             required: true,
//         }
//     },
//     messages: {
//         rating: {
//             required: "Please provide a Rating"
//         }
//     }
// });

</script>