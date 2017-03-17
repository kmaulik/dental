<link rel="stylesheet" href="<?=DEFAULT_CSS_PATH?>jquery.rateyo.min.css">
<script src="<?=DEFAULT_JS_PATH?>jquery.rateyo.min.js"></script>

<style>
/* For Chatting history css */

.timeline {
    list-style: none;
    padding: 20px 0 20px;
    position: relative;
    padding-bottom: 0px;
        margin: 0px 50px 0px;
}

.timeline:before {
    top: 0;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 2px;
    background-color: rgb(49, 176, 213);
    left: 5%;
    margin-left: -1.6px;
}

.timeline > li {
    margin-bottom: 20px;
    position: relative;
}

.timeline > li:before,
.timeline > li:after {
    content: " ";
    display: table;
}

.timeline > li:after {
    clear: both;
}

.timeline > li:before,
.timeline > li:after {
    content: " ";
    display: table;
}

.timeline > li:after {
    clear: both;
}

.timeline > li > .timeline-panel {
    width: 89%;
    float: left;
    border-radius: 2px;
    padding: 15px;
    position: relative;
    background: #eaeaea;
}

.timeline > li > .timeline-panel:before {
    position: absolute;
    top: 15px;
    right: -15px;
    display: inline-block;
    border-top: 15px solid transparent;
    border-left: 15px solid #f8f8f8;
    border-right: 0 solid #f8f8f8;
    border-bottom: 15px solid transparent;
    content: " ";
}

.timeline > li > .timeline-panel:after {
    position: absolute;
    top: 15px;
    right: -14px;
    display: inline-block;
    border-top: 14px solid transparent;
    border-left: 14px solid #f8f8f8;
    border-right: 0 solid #f8f8f8;
    border-bottom: 14px solid transparent;
    content: " ";
}

.timeline > li > .timeline-badge {
    color: #fff;
    width: 50px;
    height: 50px;
    line-height: 50px;
    font-size: 1.4em;
    text-align: center;
    position: absolute;
    top: 15px;
    left: 5%;
    margin-left: -25px;
    background-color: #999999;
    z-index: 100;
    border-top-right-radius: 50%;
    border-top-left-radius: 50%;
    border-bottom-right-radius: 50%;
    border-bottom-left-radius: 50%;
    border: 2px solid rgb(49, 176, 213);
}

.timeline > li.timeline-inverted > .timeline-panel {
    float: right;
}

.timeline > li.timeline-inverted > .timeline-panel:before {
    border-left-width: 0;
    border-right-width: 15px;
    left: -15px;
    right: auto;
}

.timeline > li.timeline-inverted > .timeline-panel:after {
    border-left-width: 0;
    border-right-width: 14px;
    left: -14px;
    right: auto;
}

.timeline-badge.warning {
    background-color: #f0ad4e !important;
}

.timeline-title {
    margin-top: 0;
    color: inherit;
}

.timeline-body > p,
.timeline-body > ul {
    margin-bottom: 0;
}

.timeline-body > p + p {
    margin-top: 5px;
}

.timeline-badge.warning img {
    height: 100%;
    width: 100%;
    border-radius: 50px;
    vertical-align: top;
}

.verticle-timeline {
    list-style: none;
    padding: 20px 0 0px;
    position: relative;
}

.verticle-timeline:before {
    left: 0;
    right: 0;
    position: absolute;
    content: " ";
    background-color: rgb(49, 176, 213);
    margin-top: 50px;
    height: 3px;
}

.verticle-timeline li .timeline-msg {
    background-color: rgb(255, 255, 255);
    border: 3px solid rgb(49, 176, 213);
    border-radius: 30px;
    color: rgb(65, 65, 65);
    font-size: 15px;
    font-weight: bold;
    left: 50%;
    margin-left: -25px;
    padding: 7px;
    position: absolute;
    text-align: center;
    top: 35px;
    z-index: 100;
}

.timeline-msg img {
    height: 100%;
    width: 100%;
    border-radius: 50px;
    vertical-align: top;
}
.verticle-timeline::before {
    background-color: rgb(49, 176, 213);
    content: " ";
    height: 3px;
    left: 0;
    margin-top: 35px;
    position: absolute;
    right: 0;
}

.verticle-timeline .left-section {
    border: 3px solid rgb(49, 176, 213);
    border-radius: 50%;
    display: inline-block;
    height: 70px;
    margin-top: 0;
    position: relative;
    width: 70px;
}
        
.verticle-timeline .right-section {
    border: 3px solid rgb(49, 176, 213);
    border-radius: 50%;
    display: inline-block;
    float: right;
    height: 70px;
    margin-top: 0;
    position: relative;
    width: 70px;
}

.verticle-timeline .left-section img,
.verticle-timeline .right-section img {
    border-radius: 50%;
    height: 100%;
    width: 100%;
    margin-bottom: 10px;
}

.cong-msg {
    text-align: center;
    background: rgb(49, 176, 213);
    padding: 15px;
    color: #fff;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    border-radius: 6px;
        clear: both;
        margin: 30px 50px 0px;
}

.cong-msg h2 {
    margin: 10px;
    font-size: 32px;
    font-weight: bold;
    color: #fff;
}
.cong-msg h5{color: #fff;margin-bottom: 0px;}

.verticle-timeline .left-section span,
.verticle-timeline .right-section span {
    width: 130px;
    display: block;
    font-size: 15px;
    color: #414141;
    font-weight: bold;
}

.timeline-panel-input {
    float: right;
    width: 89%;
}

.timeline-panel-input input {
    width: 100%;
    padding: 6px;
    border: 2px solid #ddd;
}

.send-btn {
    background: rgb(49, 176, 213);
    color: #fff;
    padding: 10px 20px;
    float: right;
    margin-top: 15px;
    text-decoration: none;
    font-weight: bold;
    border: 2px solid #fff;
}

.send-btn:hover {
    color: #fff;
}

.product-reviews .title {
    color: #414141;
    font-size: 14px;
    font-weight: bold;
    line-height: 20px;
    margin: 0 0 10px;
    font-family: 'Open Sans', sans-serif;
}

.product-reviews .reviews .review {
    margin-bottom: 20px;
    font-family: 'Open Sans', sans-serif, sans-serif;
    text-transform: none;
    background: #f8f8f8;
    padding: 20px;
}

.product-reviews .reviews .review .review-title {
    margin-bottom: 5px;
}

.product-reviews .reviews .review .review-title .summary {
    color: #666666;
    font-size: 14px;
    font-weight: normal;
    margin-right: 10px;
    font-style: italic;
}

.product-reviews .reviews .review .review-title .date {
    font-size: 12px;
}

.product-reviews .reviews .review .review-title .date span {
    color: #0f6cb2;
}

.product-reviews .reviews .review .text {
    line-height: 18px;
}

.timeline-heading h5 {
    font-weight: bold;
    margin-bottom: 10px;
}

.review-form label {
    font-weight: normal;
    font-size: 13px;
}

.cong-msg .check {
    display: inline-block;
    height: 60px;
    width: 60px;
    line-height: 58px;
    border-radius: 50%;
    box-shadow: 1px 2px 20px -6px rgba(0, 0, 0, 1);
    background: rgb(39, 175, 214);
    margin-bottom: 0px;
}

.cong-msg .check i {
    font-size: 40px;
    line-height: 62px;
    color: #fff;
    font-weight: lighter;
}

.patient-reviews {
    background: rgb(49, 176, 213);
    color: #fff;
    padding: 20px 50px;
    overflow: hidden;
    border-radius: 6px;
    margin-bottom: 50px;
}

.chatting .star-rating {
    font-size: 18px;
}

.chatting .star-rating .star-rating-stars {
    font-family: "Arial Unicode MS", Arial, sans-serif;
    unicode-bidi: bidi-override;
    color: #cccccc;
}

.chatting .star-rating .star-rating-stars .star-rating-star {
    float: left;
    width: 0.88em;
    font-size: 36px;
    color: #fff;
}

.chatting .star-rating .star-rating-stars .star-rating-star:before {
    content: "\2605";
    position: absolute;
    color: #ffb400;
}

.chatting .star-rating .star-rating-current-value:before,
.chatting .star-rating .star-rating-current-value ~ .star-rating-star:before {
    content: normal;
}

.chatting .star-rating.editable:hover .star-rating-current-value:before,
.chatting .star-rating.editable:hover .star-rating-current-value ~ .star-rating-star:before {
    content: "\2605";
    position: absolute;
    color: #ffb400;
}

.chatting .star-rating.editable .star-rating-star:hover,
.chatting .star-rating.editable .star-rating-star:hover ~ .star-rating-star:before {
    content: normal;
    cursor: pointer;
}

.chatting .star-rating .star-rating-aside {
    float: left;
    margin-left: 5px;
    color: #999999;
    font-size: 11px;
    line-height: 24px;
}

.chatting .star-rating.small {
    font-size: 16px;
    line-height: 1;
}

.chatting .star-rating.small .star-rating-aside {
    line-height: 16px;
}

.chatting .star-rating.large {
    font-size: 20px;
}

.chatting .star-rating.large .star-rating-aside {
    line-height: 26px;
}

.chatting .star-rating {
    margin: 0 auto;
    text-align: center;
    display: block;
    max-width: 200px;
}
.timeline-up-section{overflow: hidden;}
.timeline-inverted .timeline-panel{text-align: left;}
.new-section.timeline-up-section {
    margin: 0 auto;
    max-width: 500px;
}
button.btn.send-btn{margin-top: 15px;}
tr.hover-timeline:hover{background: #fff !important;}
        .timeline > li.timeline-inverted > .timeline-panel:before {
    border-left-width: 0;
    border-right-width: 15px;
    left: -15px;
    right: auto;
}
.timeline > li > .timeline-panel:before {
    position: absolute;
    top: 20px;
    right: -15px;
    display: inline-block;
    border-top: 15px solid transparent;
    border-left: 15px solid #ccc;
    border-right: 0 solid #ccc;
    border-bottom: 15px solid transparent;
    content: " ";
}

.timeline > li.timeline-inverted > .timeline-panel:after {
    border-left-width: 0;
    border-right-width: 14px;
    left: -14px;
    right: auto;
}

.timeline > li > .timeline-panel:after {
    position: absolute;
    top: 20px;
    right: -14px;
    display: inline-block;
    border-top: 14px solid transparent;
    border-left: 14px solid #eaeaea;
    border-right: 0 solid #eaeaea;
    border-bottom: 14px solid transparent;
    content: " ";
}
.send_chat_loader{    
	position: relative;
	padding-left: 30px;
	line-height: 18px !important;
}
.send_chat_loader i{    
	position: absolute;
	left: 7px;
	top: 50%;
	margin-top: -7px;
	padding-right: 0px !important;
}
@media (max-width: 767px) {
   ul.timeline:before {
        left: 40px;
    }
    ul.timeline > li > .timeline-panel {
        width: calc(100% - 90px);
        width: -moz-calc(100% - 90px);
        width: -webkit-calc(100% - 90px);
    }
    ul.timeline > li > .timeline-badge {
        left: 15px;
        margin-left: 0;
        top: 16px;
    }
    ul.timeline > li > .timeline-panel {
        float: right;
    }
    ul.timeline > li > .timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto;
    }
    ul.timeline > li > .timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }
}


/* End Chatting history css */
</style>
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
																<div class="star-rating doctor_rating_<?=$bid_data['doctor_id']?>">
																    <span class="display_rating_<?=$key.'_'.$k?> doctor_star"></span>
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
																	<a class="label label-info" onclick="view_chat(<?=$key?>,<?=$k?>)" title="Chat"><i class="fa fa-wechat"></i></a>
																	<?php if($active_rfp['is_rated'] == '') : ?>
																		<a class="label label-info rfp-price" id="rated_btn_<?=$bid_data['id']?>" onclick="send_review(<?=$key?>,<?=$k?>)" title="Review" data-toggle="modal" data-target=".doctor_review"><i class="fa fa-star"></i></a> 
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
														<!-- ============ Chat History for winner ============= -->
														<?php if($active_rfp['status'] >= 5 && $bid_data['status'] == 2) :?>
															<tr class="hover-timeline chatting chat_data_<?=$key?>_<?=$k?>" style="display:none;">
																<td colspan="8">
											                    <!-- ============ Avatar ======== -->
																<div class="new-section timeline-up-section">
																	<ul class="verticle-timeline">
																		<li>
    																		<div class="left-section"><img src="<?php if($this->session->userdata['client']['avatar'] != '') 
    												                    		{ echo base_url('uploads/avatars/'.$this->session->userdata['client']['avatar']); } 
    												                    	else 
    												                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>"><span>Has Requested</span></div>
    																		<div class="timeline-msg">$<?=$bid_data['amount']?></div>
    																		<div class="right-section"><img src="<?php if($bid_data['avatar'] != '') 
    												                    		{ echo base_url('uploads/avatars/'.$bid_data['avatar']); } 
    												                    	else 
    												                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>"><span>Has Confirmed</span></div>
																		</li>
																	</ul>
																</div>
																<!-- ============ End Avatar ==== -->
																<!-- ============= Congratulation Box ===== -->
																<div class="cong-msg">
																	<p class="check"><i class="fa fa-check" aria-hidden="true"></i></p>
																	<h2>Congratulation!!</h2>
																	<h5>Your RFP Was successful</h5>
																</div>
																<!-- ============= End Congratulation Box === -->
																<!-- ============= Chat Conversation ===== -->
																<ul class="timeline">
                                                                <?php if(!empty($bid_data['chat_data'])) :?>    
    																<?php foreach($bid_data['chat_data'] as $chat) :?>
    															        <li class="timeline-inverted">
    															          <div class="timeline-badge warning"><img src="<?php if($chat['sender_avatar'] != '') 
    												                    		{ echo base_url('uploads/avatars/'.$chat['sender_avatar']); } 
    												                    	else 
    												                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>"></div>
    															          <div class="timeline-panel">
    															            <div class="timeline-heading">
    															              <h5 class="timeline-title"><?=$chat['sender_name']?></h5>
    															            </div>
    															            <div class="timeline-body">
    															              <p><?=$chat['message']?></p>
    															            </div>
    															          </div>
    															        </li>
    																<?php endforeach; ?>
                                                                <?php endif; ?>
																<!-- ============= Chat Text Box ===== -->
																<li class="timeline-inverted chat_text_box">
																	<div class="timeline-panel-input">
																		<form method="post" id="chat_msg_form_<?=$bid_data['id']?>">
																			<input type="hidden" name="rfp_id" value="<?=$active_rfp['id']?>">
																			<input type="hidden" name="rfp_title" value="<?=$active_rfp['title']?>">
																			<input type="hidden" name="rfp_bid_id" value="<?=$bid_data['id']?>">
																			<input type="hidden" name="to_id" value="<?=$bid_data['doctor_id']?>">	
																            <input type="text" name="message" placeholder="Your Message"/>
                                                                            <span class="validate-msg"></span>
																			<button type="submit" class="btn send-btn send_chat_msg" data-id="<?=$bid_data['id']?>">SUBMIT</button>
																			<a class="btn send-btn send_chat_loader" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Loading...</a>
																		</form>	
																	</div>
														        </li>
														        <!-- ============= End Chat Text Box ===== -->
																</ul>
																<!-- ============= End Chat Conversation ===== -->
																<!-- =============== Review =============== -->
                                                                <?php if($active_rfp['is_rated'] == '') :?>
    																<form role="form" class="cnt-form" id="chat_review_form_<?=$bid_data['id']?>">
                                                                        <input type="hidden" name="rfp_id" value="<?=$active_rfp['id']?>">
                                                                        <input type="hidden" name="doctor_id" value="<?=$bid_data['doctor_id']?>">
    																	<div class="patient-reviews">
    																		<div class="star-rating">
    																		    <span id="rateYo"></span>
    																		    <span class="point" style="display:none">0</span>
    																			<input type="hidden" name="rating" class="my-rating"/>
    																		</div>
    																		<div class="review-form">
    																			<div class="form-container">
    																				<div class="row">
    																					<div class="col-md-12">
    																						<div class="form-group">
    																							<label for="exampleInputReview">Review <span class="astk">*</span></label>
    																							<textarea class="form-control txt txt-review" id="exampleInputReview" name="description" rows="4" style="margin-top: 0px; margin-bottom: 0px; height: 107px;"></textarea>
    																						</div><!-- /.form-group -->
    																					</div>
    																				</div><!-- /.row -->
    																				<div class="action text-right">
                                                                                        <input type="hidden" name="submit" value="submit">
    																					<button type="submit" class="btn send-btn send_chat_review" data-id="<?=$bid_data['id']?>">SUBMIT REVIEW</button>
    																				    <a class="btn send-btn send_review_loader" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Loading...</a>
                                                                                    </div><!-- /.action -->
    																			</div><!-- /.form-container -->
    																		</div>
    																	</div>
    																</form><!-- /.cnt-form -->
                                                                <?php endif; ?>    
																<!-- ============= End Review ============= -->
																</td>
															</tr>	
														<?php endif; ?>
														<!-- ============== End Chat History for winner ================ -->
													<?php endforeach;?>
												</tbody>	
											</table>
										</td>
									</tr>
									<!-- =======End For Bid Details ============ -->
								<?php endforeach; ?>
								<?php if(count($active_rfp_list) > 3) :?>
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
								<?php endif; ?>	
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
												$appointment_time = $app_sche['new_appointment_time'];
											}
										} ?>	
										<!-- End For Check Appointment fixed or not by patient -->
										<td><?php if($appointment_date) { echo date("m-d-Y",strtotime($appointment_date)); } else { echo 'N/A';} ?></td>
										<td><?php if($appointment_time) { echo $appointment_time; } else { echo 'N/A';} ?></td>
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
							<input type="hidden" name="rating" class="my-rating"/>
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
				<input type="hidden" id="app_key" name="app_key">
				<input type="hidden" id="appointment_rfp_id" name="rfp_id">
				<input type="hidden" id="appointment_doctor_id" name="doctor_id">
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
											<input type="text" id="appointment_date_<?=$i?>" name="appointment_date[]" class="form-control" data-format="mm-dd-yyyy" readonly>
										</div>
									</div>	
									<div class="col-sm-5">
										<div class="form-group">
											<label>Appointment Time <?=$i?> :</label>
											<input type="text" id="appointment_time_<?=$i?>" name="appointment_time[]" class="form-control" readonly>
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
							<a class="btn btn-info send_msg_app" onclick="send_msg_for_change_app()" title="Send Message" data-toggle="modal" data-target=".send_message"><i class="fa fa-envelope"></i> Send Message</a>
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
$(".my-rating").val('0.5'); 
$(".star-rating #rateYo").rateYo({
    halfStar: true,
    rating: 0.5,
     onSet: function (rating, rateYoInstance) {
			$(".point").show();
			$(".my-rating").val(rating);
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
	$(".chatting").hide(); // Hide Chat Section

});

$(".active_rfp .hide_bid_data").click(function(e) {
	var id = $(this).data('id');
	$(".bid_data").hide();
	$(".active_rfp #view_bid_data_"+id).show();
	$(".active_rfp #hide_bid_data_"+id).hide();
	$(".chatting").hide(); // Hide Chat Section
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
    //------------ For reset rating ------
    $(".my-rating").val('0.5'); 
    $(".point").html('0.5 Star');
    $("#frmreview #rateYo").rateYo().rateYo("rating", '0.5');
    //------------ End For reset rating ------
}
//--------------- Send Review ----------------------

//----------------- For modal popup close then reset review value ----------
$('.doctor_review').on('hidden.bs.modal', function (e) {
    $(".my-rating").val('0.5'); 
    $(".point").html('0.5 Star');
    $("#rateYo").rateYo().rateYo("rating", '0.5');
}); 
//----------------- End For modal popup close then reset review value ----------

// ----------- For View Appointment by patient -----------

function view_appointment(key){
	$("#app_key").val(key); // For send message from appointment section
	$(".appointment_schedule_table input:checkbox").prop('checked', false);
	$(".schedule_data").hide();
	$(".schedule_data input:radio").prop('checked', false);
	$(".validation-error-label").hide(); // For Hide Validation error
	$("#frm_choose_app .send_msg_app").show(); // For Hide send message button
	$("#frm_choose_app .submit_btn").show();
	$(".schedule_data input:radio").prop('disabled', false);

	var appointment_data = <?php echo json_encode($appointment_list); ?>;
	
	$("#appointment_id").val(appointment_data[key]['appointment_id']);
	$("#appointment_rfp_id").val(appointment_data[key]['id']);
	$("#appointment_doctor_id").val(appointment_data[key]['doc_id']);
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
		var time = data['new_appointment_time'];
		

		$(".mul_schedule_"+(key+1)).show();

		$("#appointment_date_"+(key+1)).val(d[1]+"-"+d[2]+"-"+d[0]);
		$("#appointment_time_"+(key+1)).val(time);
		$("#schedule_selected_"+(key+1)).val(data['id']);

		//---------- IF Schedule selected then checked radio button & hide submit button -------
		if(data['is_selected'] == 1){
			
			$(".schedule_data input:radio").prop('disabled', true);
			$("#schedule_selected_"+(key+1)).prop("checked", true);
			$("#frm_choose_app .send_msg_app").hide();
			$("#frm_choose_app .submit_btn").hide();
		}
		//------------------
	});
	//----------------- End For Multiple Appointment Schedule (Date & Time) Submit by doctor---------

	$("#appointment_doc_comments").html(appointment_data[key]['doc_comments']);
}
// ----------- End For View Appointment  -----------


//---------------- Send Message For Change Appointment ------------------
function send_msg_for_change_app(){
	$(".modal").removeClass("fade").modal("hide");
	var app_data = <?php echo json_encode($appointment_list); ?>;
	
	var key = $("#app_key").val();
	$("#msg_rfp_id").val(app_data[key]['id']);
	$("#msg_rfp_title").val(app_data[key]['title']);
	$("#msg_rfp_bid_id").val(app_data[key]['rfp_bid_id']);
	$("#msg_to_id").val(app_data[key]['doc_id']);
}
//---------------- End Send Message For Change Appointment ------------------


//------------------- View Chatting ----------------------
function view_chat(rfp_key,bid_key){

    //------------ For reset rating ------
    $(".my-rating").val('0.5'); 
    $(".point").html('0.5 Star');
    $("#rateYo").rateYo().rateYo("rating", '0.5');
    //------------ End For reset rating ------
	//var app_data = <?php echo json_encode($appointment_list); ?>;
	$(".chat_data_"+rfp_key+"_"+bid_key).show();
}
//------------------- End View Chatting ----------------------

//------------------- Send Message From Chatting ----------------------
$(".send_chat_msg").click(function(e){
	e.preventDefault();
	var bid_id=$(this).data('id');
	var chat_msg_data = $("#chat_msg_form_"+bid_id).serialize();
	var chat_msg = $("#chat_msg_form_"+bid_id+" input[name='message']").val();
    if(chat_msg != ''){
        $(".validate-msg").html('');
    	$(".send_chat_msg").hide();
    	$(".send_chat_loader").show();
    	$.post("<?=base_url('rfp/send_message/1')?>",chat_msg_data,function(data){
    		
    		if(data){
    			$("#chat_msg_form_"+bid_id+" input[name='message']").val('');
    			var uname= "<?=$this->session->userdata('client')['fname'].' '.$this->session->userdata('client')['lname']?>";

    			<?php if($this->session->userdata('client')['avatar'] != '') { ?>
    				var uavatar= "<?php echo base_url('uploads/avatars/'.$this->session->userdata('client')['avatar']); ?>";
    			<?php }else { ?>
    				var uavatar= "<?php echo DEFAULT_IMAGE_PATH.'user/user-img.jpg';  ?>";
    			<?php } ?>

    			var msg_block ='<li class="timeline-inverted"><div class="timeline-badge warning"><img src="'+uavatar+'"></div><div class="timeline-panel"><div class="timeline-heading"><h5 class="timeline-title">'+uname+'</h5></div><div class="timeline-body"><p>'+chat_msg+'</p></div></div></li>';
    			$(".timeline .chat_text_box").before(msg_block);
    		}
    		
    		$(".send_chat_msg").show();
    		$(".send_chat_loader").hide();
    	});
    }
    else{
        $(".validate-msg").html('<label class="validation-error-label" for="message">Please provide a Message</label>');
    }    
	
});
//------------------- End Send Message From Chatting ----------------------


//-------------------- Submit Review From Chatting -------------------
$(".send_chat_review").click(function(e){
    e.preventDefault();
    var bid_id=$(this).data('id');
    var chat_review_data = $("#chat_review_form_"+bid_id).serialize();

    $(".send_chat_review").hide();
    $(".send_review_loader").show();
    $.post("<?=base_url('rfp/doctor_review/1')?>",chat_review_data,function(data){

            if(data){

                //---------- Hide Rating Form and rating button ----------
                $("#chat_review_form_"+bid_id).hide();
                $("#rated_btn_"+bid_id).hide();
                 //---------- /Hide Rating Form and rating button --------

                //----- For Change rating for particular doctor -------
                $(".doctor_rating_"+data['doctor_id']+" .doctor_star").rateYo().rateYo("rating", data['avg_rating']);
                $(".doctor_rating_"+data['doctor_id']+" .avg_rating").html(data['avg_rating']+' / 5.0 ('+data['total_rating']+' Reviews)');
               //----- /For Change rating for particular doctor -------

            }
            
            $(".send_chat_review").show();
            $(".send_review_loader").hide();
        },'json');
    
});    
//--------------------- End Submit Review From Chatting --------------


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