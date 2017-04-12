<link rel="stylesheet" href="<?=DEFAULT_CSS_PATH?>jquery.rateyo.min.css">
<script src="<?=DEFAULT_JS_PATH?>jquery.rateyo.min.js"></script>
<script type="text/javascript" src="<?php echo DEFAULT_JS_PATH.'vague.js'; ?>"></script>

<?php 
	if(!empty($map)){
		echo $map['js'];
	}
?>

<section class="page-header page-header-xs">
	<div class="container">

		<!-- breadcrumbs -->
		<ol class="breadcrumb breadcrumb-inverse">
			<li><a href="#">Home</a></li>
			<li><a href="#">View Profile</a></li>
			<li class="active <?php if($allow_view == '0'){ echo 'blur_8'; } ?>">
				<?php echo $db_data['fname'].' '.$db_data['lname']; ?>
			</li>
		</ol><!-- /breadcrumbs -->

	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section>
	<div class="container view_profile">
		<!-- <div class="col-md-12">
			<div class="pull-right">					
				<a href="http://localhost/dental/rfp/view_rfp_bid/Mw%3D%3D" class="btn btn-info"><i class="fa fa-eye"></i> View Proposal</a>
			</div>
		</div> -->

		<!-- RIGHT -->
		<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 margin-bottom-80">			


			<ul class="nav nav-tabs nav-top-border">
				<li class=""><a href="#info" data-toggle="tab">Personal Info</a></li>	
				<li class="<?php if($tab == ''){ echo 'active'; }?>"><a href="#review" data-toggle="tab">Review</a></li>
				<?php if(!empty($map)){ ?>
					<li class="<?php if($tab == 'office_map'){ echo 'active'; }?>">
						<?php if($this->session->userdata('client')['role_id'] == 4) :?> <!-- (4 Means Doctor) -->
							<a href="<?php echo base_url().'dashboard/view_profile/'.$encoded_user_id.'/?tab=office_map'; ?>">
								Office Map
							</a>
						<?php else : 
							$rfp_id = $this->uri->segment(4);
							?>
							<a href="<?php echo base_url().'dashboard/view_profile/'.$encoded_user_id.'/'.$rfp_id.'/?tab=office_map'; ?>">
								Office Map
							</a>
						<?php endif; ?>					
					</li>
				<?php } ?>
			</ul>
			
			<div class="tab-content">
				<!-- 
					PERSONAL INFO TAB 
					my_custom_strong
					my_custom_strong_1
				-->
				<div class="tab-pane fade" id="info">
					<div class="form-group">
						<span class="title">Name : </span>
						<span class="desc <?php if($allow_view == '0'){ echo 'blur_1'; } ?>"> <?=$db_data['fname'] ." ".$db_data['lname']?></span>
					</div>
					<div class="form-group">
						<span class="title">Email : </span>
						<span class="desc <?php if($allow_view == '0'){ echo 'blur_2'; } ?>"> <?=$db_data['email_id']?></span>
					</div>
					<div class="form-group">
						<span class="title">Street : </span>
						<span class="desc <?php if($allow_view == '0'){ echo 'blur_3'; } ?>"> <?=$db_data['street']?></span>
					</div>
					<div class="form-group">
						<span class="title">City : </span>
						<span class="desc"> <?=$db_data['city']?></span>
					</div>
					<div class="form-group">
						<span class="title">State : </span>
						<span class="desc">
							<?php 
								$state = fetch_row_data('states',['id' => $db_data['state_id']],'name');
								if($state == ''){
									echo 'N/A';
								}else{
									echo $state;
								}
							?>
						</span>
					</div>
					<div class="form-group">
						<span class="title">Country : </span>
						<span class="desc"> <?=fetch_row_data('country',['id' => $db_data['country_id']],'name')?></span>
					</div>
					<div class="form-group">
						<span class="title">Zipcode : </span>
						<span class="desc <?php if($allow_view == '0'){ echo 'blur_6'; } ?>"> <?=$db_data['zipcode']?></span>
					</div>
					<div class="form-group">
						<span class="title">Gender : </span>
						<span class="desc <?php if($allow_view == '0'){ echo 'blur_4'; } ?>"> <?=ucfirst($db_data['gender'])?></span>
					</div>
					<div class="form-group">
						<span class="title">Phone : </span>
						<span class="desc <?php if($allow_view == '0'){ echo 'blur_5'; } ?>"> <?=$db_data['phone']?></span>
					</div>
					<div class="form-group">
						<span class="title">Age : </span>
						<span class="desc">								
							<?php
								$birthday = new DateTime($db_data['birth_date']);
								$interval = $birthday->diff(new DateTime);
								echo $interval->y.' years';
							?>
						</span>
					</div>
					<div class="form-group">
						<span class="title">Public Email : </span>
						<span class="desc <?php if($allow_view == '0'){ echo 'blur_9'; } ?>"> <?php echo ($db_data['public_email'] == '') ? 'N/A':$db_data['public_email']; ?></span>
					</div>
					<div class="form-group">
						<span class="title">Office address : </span>
						<span class="desc <?php if($allow_view == '0'){ echo 'blur_10'; } ?>"> <?php echo $db_data['office_description']; ?></span>
					</div>
				</div>	
				<!-- /PERSONAL INFO TAB -->

				<!-- Review TAB -->
				<div class="tab-pane fade <?php if($tab == ''){ echo 'in active'; }?>" id="review">
					<?php if(count($review_data) > 0 ) : ?>
						<?php foreach($review_data as $key => $review) : ?>
							<div class="the-box no-border store-list">
								<div class="media">
									<a class="pull-left" href="#fakelink">
									<img alt="image" src="<?php if($review['avatar'] != '') 
			                    		{ echo base_url('uploads/avatars/'.$review['avatar']); } 
			                    	else 
			                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" class="store-image img-responsive" style="height:120px;width:120px;"></a>
									<div class="clearfix visible-xs"></div>
									<div class="media-body">
										<a href="#fakelink"></a>
										<h4 class="media-heading">
											<a href="#" class="my_custom_strong"><strong><?=$review['user_name']?></strong></a> 
											<div class="pull-right msg-btn">
												<!-- <span class="label label-success rfp-price">&#36;<?=$review['bid_amount']?></span> -->
											</div>	
										</h4>
										<!-- ========= Request Title ======== -->
										<p class="review-rfp_title">Request Title : <?php echo $review['rfp_title']; ?></p>
										<!-- ========= End Request Title ======== -->	
										<ul class="list-inline">
											<li>
												<?php $rate=number_format(($review['rating']),2);?>
												<div class="star-rating">
												    <span class="display_rating_<?=$key?>"></span>
												</div>
											</li>
											<!-- For Display Star Rating -->
											<script>
												$(".star-rating .display_rating_<?=$key?>").rateYo({
													rating: <?=$rate?>,
													starWidth : "25px",
													readOnly: true
												});
											</script>
											<!-- End Display Star Rating -->							
											<li><span class="label label-info rating"><?=$rate?> / 5.0</span></li>
											<li> | </li>
											<li><i class="fa fa-clock-o"></i> <?=time_ago($review['created_at'])?> </li>
										</ul>
										<p class="bid-desc">
											<?php //echo character_limiter(strip_tags($review['feedback']), 200);?>
											<?php echo $review['feedback']; ?>
										</p>
										<!-- ========== Doctor Comment (Thank you note) ===== -->
										<?php if($review['doctor_comment'] != '') :?>
											<p class="review-doc-comment">
												<?php echo $review['doctor_comment']; ?>
											</p>	
										<?php endif; ?>	
										<!-- ========== End Doctor Comment (Thank you note) ===== -->
									</div><!-- /.media-body -->
								</div><!-- /.media -->
							</div><!-- /.the-box no-border -->
						<?php endforeach; ?>
					<?php else : ?>
						<h4> No Review</h4>	
					<?php endif;?>	
				</div>
				<!-- /Review TAB -->
	
				<!-- Office Map TAB -->
				<div class="tab-pane fade <?php if($tab == 'office_map'){ echo 'in active'; }?>" id="office_map">
					<?php 
						if(!empty($map)){ 
							echo $map['html']; 
						}
					?>
				</div>
				<!--  //Office Map TAB -->

			</div>
		</div>

		<!-- LEFT -->
		<div class="col-lg-3 col-md-3 col-sm-4 col-lg-pull-9 col-md-pull-9 col-sm-pull-8">
			<div class="thumbnail text-center">				
				<?php if($db_data['avatar'] != '' && $allow_view == '1') { ?>
					<img src="<?php echo base_url(); ?>uploads/avatars/<?= $db_data['avatar'] ?>" alt="" />
				<?php }else{ ?>
					<img src="<?php echo base_url(); ?>uploads/default/no_image_found.jpg" alt="" />
				<?php } ?>

				<h2 class="size-18 margin-top-10 margin-bottom-0 <?php if($allow_view == '0') { echo 'blur_7';} ?>">
					<?php echo $db_data['fname'].' '.$db_data['lname']; ?>
				</h2>
				<!-- <h3 class="size-11 margin-top-0 margin-bottom-10 text-muted">DEVELOPER</h3> -->
			</div>	

			<!-- info -->
			<div class="box-light margin-bottom-30 user-avg-review"><!-- .box-light OR .box-light -->
				<div class="text-muted">
					<h2 class="size-18 text-muted margin-bottom-6 text-center"><b>Total Review</b></h2>
					<hr/>
					<div class="avg-star-rating">
						<span class="display_rating"></span>
					</div>
					<script>
						$(".avg-star-rating .display_rating").rateYo({
							rating: <?=isset($overall_review['avg_rating'])?$overall_review['avg_rating']:'0'?>,
							starWidth : "25px",
							readOnly: true
						});
					</script>	
					<h4><?=isset($overall_review['avg_rating'])?number_format($overall_review['avg_rating'],2):'0'?> / 5.0 (<?=isset($overall_review['total_rating'])?$overall_review['total_rating']:'0'?>)</h4>			
				</div>
			</div>
			<!-- /info -->

		</div>
		<!-- LEFT -->

	</div>
</section>
<!-- / -->

<script type="text/javascript">
	
	var vague_1 = $('.blur_1').Vague({
	    intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,  // Force absolute path to the SVG filter,
	    animationOptions: {
	     	duration: 1000,
	     	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_1.blur();

	var vague_2 = $('.blur_2').Vague({
	    intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	    animationOptions: {
	     	duration: 1000,
	     	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_2.blur();

	var vague_3 = $('.blur_3').Vague({
	   	intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	   	animationOptions: {
	     	duration: 1000,
	      	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_3.blur();

	var vague_4 = $('.blur_4').Vague({
	   	intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	   	animationOptions: {
	     	duration: 1000,
	      	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_4.blur();

	var vague_5 = $('.blur_5').Vague({
	   	intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	   	animationOptions: {
	     	duration: 1000,
	      	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_5.blur();

	var vague_6 = $('.blur_6').Vague({
	   	intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	   	animationOptions: {
	     	duration: 1000,
	      	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_6.blur();

	var vague_7 = $('.blur_7').Vague({
	   	intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	   	animationOptions: {
	     	duration: 1000,
	      	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_7.blur();

	var vague_8 = $('.blur_8').Vague({
	   	intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	   	animationOptions: {
	     	duration: 1000,
	      	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_8.blur();

	var vague_9 = $('.blur_9').Vague({
	   	intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	   	animationOptions: {
	     	duration: 1000,
	      	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_9.blur();

	var vague_10 = $('.blur_10').Vague({
	   	intensity:      3,      // Blur Intensity
	    forceSVGUrl:    false,   // Force absolute path to the SVG filter,	    
	   	animationOptions: {
	     	duration: 1000,
	      	easing: 'linear' // here you can use also custom jQuery easing functions
	    }
	});

	vague_10.blur();

</script>
