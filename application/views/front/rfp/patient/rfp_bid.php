<style>
.rfp-title h3{
	text-align: center;
}
.store-list{
	padding: 15px;
	margin-bottom: 30px;
	background-color: #eeeeee;
	position: relative;

}
.list-inline{
	margin-bottom: 5px;
}
.rating{
	font-size: 15px;
	font-weight: 600;
	color: #fff;
}
.bid-desc{
	margin-bottom: 5px;
}
.rfp-mail{
	padding-left: 10px;
}
.rfp-price{
	font-size: 18px;
	padding: 8px 10px !important;
}
.rating-img{
	height: 20px;
}
</style>

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
			<div class="col-sm-12 rfp-title">
				<h3><?=isset($rfp_bid_list[0]['title'])?$rfp_bid_list[0]['title']:''?></h3>
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
									  <a href="#fakelink"><strong><?=$bid_list['fname']." ".$bid_list['lname']?></strong></a> 
									  <a href="#" class="rfp-mail"><i class="fa fa-envelope" title="Send Mail"></i></a> 
									  <span class="label label-success pull-right rfp-price">&#36;<?=$bid_list['bid_amount']?></span>
									</h4>
									<ul class="list-inline">
										<li>
											<?php $rate=number_format(($bid_list['rating']/2),2);?>
											<?php if($rate == 0):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star.png';?>" class="rating-img">
								            <?php elseif($rate <=0.5):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star1.png';?>" class="rating-img">
								            <?php elseif($rate <=1):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star2.png';?>" class="rating-img">
								            <?php elseif($rate <=1.5):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star3.png';?>" class="rating-img">
								            <?php elseif($rate <=2):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star4.png';?>" class="rating-img">
								            <?php elseif($rate <=2.5):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star5.png';?>" class="rating-img">
								            <?php elseif($rate <=3):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star6.png';?>" class="rating-img">
								            <?php elseif($rate <=3.5):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star7.png';?>" class="rating-img">
								            <?php elseif($rate <=4):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star8.png';?>" class="rating-img">
								            <?php elseif($rate <=4.5):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star9.png';?>" class="rating-img">
								            <?php elseif($rate <=5):?>
								            	<img src="<?=DEFAULT_IMAGE_PATH.'rating/star10.png';?>" class="rating-img">
								            <?php endif;?>
										</li>
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