<link rel="stylesheet" href="<?=DEFAULT_CSS_PATH?>jquery.rateyo.min.css">
<script src="<?=DEFAULT_JS_PATH?>jquery.rateyo.min.js"></script>
<style>
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
        
        .star-rating {
            font-size: 18px;
        }
        
        .star-rating .star-rating-stars {
            font-family: "Arial Unicode MS", Arial, sans-serif;
            unicode-bidi: bidi-override;
            color: #cccccc;
        }
        
        .star-rating .star-rating-stars .star-rating-star {
            float: left;
            width: 0.88em;
            font-size: 36px;
            color: #fff;
        }
        
        .star-rating .star-rating-stars .star-rating-star:before {
            content: "\2605";
            position: absolute;
            color: #ffb400;
        }
        
        .star-rating .star-rating-current-value:before,
        .star-rating .star-rating-current-value ~ .star-rating-star:before {
            content: normal;
        }
        
        .star-rating.editable:hover .star-rating-current-value:before,
        .star-rating.editable:hover .star-rating-current-value ~ .star-rating-star:before {
            content: "\2605";
            position: absolute;
            color: #ffb400;
        }
        
        .star-rating.editable .star-rating-star:hover,
        .star-rating.editable .star-rating-star:hover ~ .star-rating-star:before {
            content: normal;
            cursor: pointer;
        }
        
        .star-rating .star-rating-aside {
            float: left;
            margin-left: 5px;
            color: #999999;
            font-size: 11px;
            line-height: 24px;
        }
        
        .star-rating.small {
            font-size: 16px;
            line-height: 1;
        }
        
        .star-rating.small .star-rating-aside {
            line-height: 16px;
        }
        
        .star-rating.large {
            font-size: 20px;
        }
        
        .star-rating.large .star-rating-aside {
            line-height: 26px;
        }
        
        .star-rating {
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
						
		<!-- Doctor's All favorite RFP -->
		<div class="row">
			
			<div class="alert-message"></div>

			<ul class="nav nav-tabs nav-top-border">
				<li class="active"><a href="#won_rfps" data-toggle="tab">Won RFPs</a></li>
				<li><a href="#schedule_rfps" data-toggle="tab">Schedule RFPs</a></li>
				<li><a href="#rfp_bids" data-toggle="tab">RFP Bids</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane fade in active" id="won_rfps">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>RFP Title</th>
								<th>Bid Price</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if(!empty($won_rfps)) {
									foreach($won_rfps as $w_rfp) {

										// pr($w_rfp);
										$all_billing_data = $this->db->get_where('billing_schedule',['rfp_id'=>$w_rfp['rfp_id']])->result_array();										
										// $rfp_status_data = $this->Rfp_model->return_status($w_rfp['rfp_id']);

										$amt = $w_rfp['amount']; // Bid price										
										$percentage = config('doctor_fees');

										$payable_price = ($percentage * $amt)/100; // calculate 10% againts the bid of doctor
										$total_transaction_cnt = 0;

										$is_second_due = 1;
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
													echo rfp_status_label($w_rfp['rfp_status']);
												}else{
													$check_transactions = array_column($all_billing_data,'transaction_id');													
													$total_transaction_cnt = count(array_filter($check_transactions, function($x) {return !is_null($x); }));

													// Check if there are any payment Errors in case of cancellation of agreement
													if(in_array('DOCTOR_PAYMENT_ERROR',$check_transactions) == true){
														echo '<span class="label label-danger">Payment Error</span>';
													}else{
														echo '<span class="label label-primary">In-progress</span>';
													}
												}
											?>
										</td>
										<td>										
											<?php if($w_rfp['rfp_status'] == '4' && empty($all_billing_data)) { ?>
												<a class="btn btn-3d btn-xs btn-reveal btn-green"
												   data-is-second-due="<?php echo $is_second_due; ?>"
												   data-due-one="<?php echo $due_1; ?>"
												   data-due-two="<?php echo $due_2; ?>"
												   data-total-due="<?php echo $payable_price; ?>"
												   data-mybid="<?php echo $amt; ?>"
												   data-rfpid="<?php echo encode($w_rfp['rfp_id']); ?>"
												   onclick="show_modal_doctor(this)" >
													<i class="fa fa-money"></i><span>Proceed</span>
												</a>
											<?php }else{
												
													$show_pending_payment = 0;
													foreach($all_billing_data as $bill_data){
														if($bill_data['status']=='0' && !empty($bill_data['transaction_id'])){
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
                                                          onclick="$('<?php echo $timeline_id; ?>').show(); $(this).hide(); $('.a_hide_<?php echo $won_rfp_id; ?>').show();"> Show Timeline </a>

                                                        <a class="label label-info a_hide_<?php echo $won_rfp_id; ?>" 
                                                          onclick="$('<?php echo $timeline_id; ?>').hide(); $(this).hide(); $('.a_show_<?php echo $won_rfp_id; ?>').show();" style="display:none;"> Hide Timeline </a>
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
									                    	<img src="<?php echo base_url().'uploads/default/user-img.jpg'; ?>">
									                    	<span>Have accepted</span>
									                    </div>
									                    <div class="timeline-msg">$3333</div>
									                    <div class="right-section">
									                    	<img src="<?php echo base_url().'uploads/default/user-img.jpg'; ?>">
									                    	<span>Has Confirmed</span>
									                    </div>
									                </li>
									            </ul>
									        </div>
									        <div class="cong-msg">
									            <p class="check"><i class="fa fa-check" aria-hidden="true"></i></p>
									            <h2>Congratulation!!</h2>
									            <h5>Your sale Was successful</h5>
									        </div>
									        <ul class="timeline">

                                                <?php 
                                                    if(!empty($w_rfp['chat_data'])) :
                                                        foreach($w_rfp['chat_data'] as $chat) :
                                                ?>
                                                    <li class="timeline-inverted">
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

									            <div class="timeline-panel-input">
                                                    <input type="textbox" placeholder="Your Message"/>
                                                    <button class="btn send-btn">SUBMIT</button>
                                                </div>
									        </ul>							        
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
				<div class="tab-pane fade" id="schedule_rfps">
					<p> Schedule RFPs </p>
				</div>
				<div class="tab-pane fade" id="rfp_bids">					
					
					<table class="table table-hover">
						<thead>
							<tr>
								<th>RFP Title</th>
								<th>Bid Price</th>
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
										   class="btn btn-3d btn-xs btn-reveal btn-green">
											View
										</a>
									</td>
								</tr>
							<?php } } ?>
						</tbody>
					</table>

				</div>
			</div>
			
			<div class="divider divider-color divider-center divider-short"><!-- divider -->
				<i class="fa fa-cog"></i>
			</div>

			<div class="col-md-12">
				<h4> Favorite RFP </h4>
				<hr/>
			</div>	


			<div class="col-md-12">
				<?php 
					$i = 0;
					if(count($rfp_data_fav) > 0) :
				?>
					<div class="list-group success square no-side-border search_rfp">
						<?php foreach($rfp_data_fav as $record) :?>
							<a href="<?=base_url('rfp/view_rfp/'.encode($record['rfp_id']))?>" 
							   class="list-group-item a_fav_rfp <?php if($i > 2){ echo 'hide'; }  ?> ">
								<div class="rfp-left">									
									<!-- Means Favorite RFP -->
									<span class="favorite fa fa-star favorite_rfp" data-id="<?=encode($record['rfp_id'])?>"></span>																										
									
									<img src="<?php if($record['avatar'] != '') 
			                    		{ echo base_url('uploads/avatars/'.$record['avatar']); } 
			                    	else 
			                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" class="avatar img-circle" alt="Avatar">								
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

						<?php $i++; ?>	
						<?php endforeach; ?>
						
						<?php if(count($rfp_data_fav) > 3) { ?>
							<br/>
							<a onclick="$('.a_fav_rfp').removeClass('hide');$(this).hide();" 
							   class="btn btn-primary text-center">
								Show More
							</a>
						<?php } ?>
					</div>					
				<?php else : ?>
					<h5>No RFP Available</h5>
				<?php endif; ?>
			</div>	
		</div>	
		<!-- // ENDS here FAV RFPs -->		

		<div class="divider divider-color divider-center divider-short">
			<!-- divider -->
			<i class="fa fa-cog"></i>
		</div>


		<!-- Doctor's Filter For Search RFP -->
		<div class="row rfp_radar_filter">			
			<div class="col-md-12">
				<h4> RFP Radar </h4>
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive">
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
									<td colspan="2" class="text-center">
										<b>No Filter Data Found</b>
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
				<h4> Your Review </h4>
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Patient Name</th>
								<th>RFP Title</th>
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

		<!-- Doctor's Manage Appointment -->
		<div class="row appointment-list">
			<div class="col-md-12">
				<h4> Manage Appointment </h4>
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Patient Name</th>
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
												<a class="label label-success" title="Manage Appointment" data-toggle="modal" data-target=".select_appointment_option" onclick="select_appointment_option(<?=$key?>)"><i class="fa fa-hand-o-right"></i></a>
											<?php else : ?>
												<a class="label label-info" title="View Appointment" data-toggle="modal" data-target=".manage_appointment" onclick="view_appointment(<?=$key?>)"><i class="fa fa-eye"></i></a>
												<?php if($is_approve_app != 1) :?> <!-- If patient approve appointment then not display Delete Appointment -->
													<a href="<?=base_url('dashboard/delete_appointment/'.encode($appointment['appointment_id']))?>" class="label label-danger delete_appointment" title="Delete Appointment"><i class="fa fa-trash"></i></a>	
												<?php endif; ?>
											<?php endif;?>
											<!-- == End == -->
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


<!-- ==================== Modal Popup For Apply Promotional Code ========================= -->
<div class="modal fade doctor_payment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Proceed with your payment for won RFP</h4>
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
								<span class="pull-right due_1_price">$0.00</span>
								<span class="pull-left">Due payment 1 (will deduct instantly):</span>
							</span>

							<span class="clearfix due_2">
								<span class="pull-right due_2_price">$0.00</span>
								<span class="pull-left">Due payment 2 (will deduct after 45 days):</span>
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

						<div class="col-sm-12">
							<div class="form-group">
								<label>Coupon Code</label>
								<div class="fancy-file-upload fancy-file-success">
									<input type="text" class="form-control" name="coupan_code" id="coupan_code"/>
									<span class="button" id="apply-code">Apply Code</span>
								</div>
								<span class="coupan-msg"></span>
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
								<label>RFP Title : <span id="select_rfp_title"></span></label>
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
				<h4 class="modal-title" id="myLargeModalLabel">Call Appointment</h4>
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
								<label>RFP Title : <span id="call_app_rfp_title"></span></label>
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
													<th><input type="checkbox" id="Call_M_<?=$i?>" name="appointment_schedule[]" value="M_<?=$i?>" disabled></th>
												<?php endfor; ?>
											</tr>
											<tr>
												<th>AfterNoon</th>
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
								<label>Comment :</label>
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
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
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
							<input type="submit" name="submit" class="btn btn-info submit_btn" value="Submit">
							<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
						</div>	
					</div>	
				</div>	
			</form>
		</div>
	</div>
</div>

<?php
	$run_cron = $this->session->flashdata('run_cron');
	if($run_cron == 'yes'){
	   // $url = base_url().'cron/check_status';
	   // $res = $this->unirest->get($url);   
	}
?>	
<!-- ================== /Modal Popup For Manage Appointment ========================= -->	
	

<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>

<script type="text/javascript">
	
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
					$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP added to your favorite list successfully.</div>');
				}
			});
		} else {
			$.post("<?=base_url('rfp/remove_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
				if(data){
					data1.removeClass('favorite_rfp');
					data1.addClass('unfavorite_rfp');
					$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP removed to your favorite list successfully. </div>');
				
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
		$("#frm_manage_appointment .submit_btn").show();
	}
	else{
		$("#select_app_key").val(''); // IF apporve then remove the value for call option in manage appointment
		$("#appointment_id").val(''); // It means only view appointment
		$('#appointment_doc_comments').attr('readonly', true);
		$('#frm_manage_appointment .btn_call').hide();
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
	bootbox.confirm('Are you sure to delete rfp filter ?' ,function(res){
		if(res){
			$.post("<?=base_url('dashboard/delete_search_filter/')?>",{	'filter_id' : filter_id },function(data){
				if(data){
					$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP Filter Deleted Successfully.</div>');
					$(".search_filter_row_"+key).hide();
				}
				else{
					$(".alert-message").html('<div class="alert alert-danger margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error Into Delete RFP Filter.</div>');
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