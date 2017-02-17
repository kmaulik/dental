<link rel="stylesheet" href="<?=DEFAULT_CSS_PATH?>jquery.rateyo.min.css">
<script src="<?=DEFAULT_JS_PATH?>jquery.rateyo.min.js"></script>

<section class="page-header page-header-xs">
	<div class="container">
		<h1> RFP Bid List </h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp');?>">RFP List</a></li>
			<li class="active">RFP Bid List</li>
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
			<div class="col-sm-12 rfp-title bottom_space">
				<h3 class=""><?=isset($rfp_bid_list[0]['title'])?$rfp_bid_list[0]['title']:''?></h3>
			</div>
			<div class="col-sm-12">
				<!-- Bid List -->	
				<?php if(count($rfp_bid_list) > 0) :  ?>
					<?php foreach ($rfp_bid_list as $key => $bid_list) : ?>
						<div class="the-box no-border store-list">
							 <div class="media">
								<a class="pull-left" href="#fakelink">
								<img alt="image" src="<?php if($bid_list['avatar'] != '') 
		                    		{ echo base_url('uploads/avatars/'.$bid_list['avatar']); } 
		                    	else 
		                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" class="store-image img-responsive" style="height:120px;width:120px;"></a>
								<div class="clearfix visible-xs"></div>
								<div class="media-body">
									<a href="#fakelink"></a>
									<h4 class="media-heading">
										<a href="<?=base_url('dashboard/view_profile/'.encode($bid_list['doctor_id']))?>" class="my_custom_strong"><strong><?=$bid_list['fname']." ".$bid_list['lname']?></strong></a> 
										<div class="pull-right msg-btn">
											<!-- For Choose Winner Doctor (Once Choose winner doctor then hide the button) -->
											<?php if($bid_list['rfp_status'] < 4 ) : ?> <!-- 4 Means In_Progress (Winner Doctor) For this RFP -->
												<a href="<?=base_url('rfp/choose_winner_doctor/'.encode($bid_list['id']).'/'.encode($bid_list['rfp_bid_id']))?>" class="label label-info rfp-price confirm_winner" title="Choose Winner" ><i class="fa fa-trophy"></i></a> 
											<?php endif; ?>	
											<!-- End Choose Winner Doctor -->
											<!-- Add Condition For Review Here (If Review not given & Bid status winner(2) then display)-->
											<?php if(isset($is_rated_rfp) && count($is_rated_rfp) == 0 && $bid_list['bid_status'] == 2) : ?>
												<a class="label label-info rfp-price" onclick="send_review(<?=$key?>)" title="Review" data-toggle="modal" data-target=".doctor_review"><i class="fa fa-star"></i></a> 
											<?php endif; ?>
											<!-- End Review -->
											<a class="label label-info rfp-price" onclick="send_msg(<?=$key?>)" title="Send Mail" data-toggle="modal" data-target=".send_message"><i class="fa fa-envelope"></i></a> 
											<?php if($bid_list['is_chat_started'] == 1) :?>
												<a href="<?=base_url('messageboard/message/'.encode($bid_list['id']).'/'.encode($bid_list['doctor_id']))?>" class="label label-info rfp-price" title="View Mail"><i class="fa fa-eye"></i></a> 	
											<?php endif; ?>
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

<!-- ==================== Modal Popup For Place a Bid ========================= -->
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
<!-- ================== /Modal Popup For Place a Bid ========================= -->		

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


<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>
<!-- <script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'vague.js'; ?>"></script> -->
<script>

$(function () {
 
$(".star-rating #rateYo").rateYo({
    halfStar: true,
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

$(".confirm_winner").click(function(e) {
	e.preventDefault();
	var lHref = $(this).attr('href');
	bootbox.confirm('Are you sure to winner doctor for this rfp ?' ,function(res){
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