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
.store-list .msg-btn{
	margin: 5px 0px;
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
									  <div class="pull-right msg-btn">
									  <a class="label label-info rfp-price" onclick="send_msg(<?=$key?>)" title="Send Mail" data-toggle="modal" data-target=".send_message"><i class="fa fa-envelope"></i> Send Mail</a> 
									  <span class="label label-success rfp-price">&#36;<?=$bid_list['bid_amount']?></span>
									  </div>	
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


<script>
function send_msg(key){
	var rfp_data = <?php echo json_encode($rfp_bid_list); ?>;
	$("#rfp_id").val(rfp_data[key]['id']);
	$("#rfp_title").val(rfp_data[key]['title']);
	$("#rfp_bid_id").val(rfp_data[key]['rfp_bid_id']);
	$("#to_id").val(rfp_data[key]['doctor_id']);
}

</script>