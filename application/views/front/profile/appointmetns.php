
<!--<style>
	.list-group-item .avatar {
	    width: 40px;
	    height: 40px;
	    margin: 0 10px;
	}
	span.favorite {
	    margin: 0 5px;
	}
	span.favorite_rfp{
		color: #1980B6;
	}
	span.unfavorite_rfp{
		color: #555555;
	}
	span.name {
	    width: 100px;
	    position: relative;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	    font-weight: 700;
	    margin: 0 10px;
	}
	span.subject {
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	    margin: 0 10px;
	}
	span.attachment {
	    float: right;
	    position: absolute;
	    right: 85px;
	    top: 20px;
	    text-align: right;
	}
	span.time {
	    float: right;
	    width: 80px;
	    position: absolute;
	    right: 10px;
	    top: 20px;
	    text-align: right;
	    font-size: 13px;
	}
	@media (max-width:479px){
	.rfp-right {
	    display: block;
	    margin-top: 10px;
	    margin-bottom: 5px;
	    text-align: center;
	}
	.rfp-right span.attachment {
	    float: none;
	    position: relative;
	    right: 0;
	    top: 0;
	    text-align: right;
	    margin-right: 10px;
	}
	.rfp-right span.time {
	    float: none;
	    width: 80px;
	    position: relative;
	    right: 0;
	    top: 0;
	    text-align: right;
	    font-size: 13px;
	}
	.rfp-left span.name {
	    width: 100%;
	    position: relative;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	    font-weight: 700;
	    margin: 0 10px;
	    display: block;
	    text-align: center;
	}
	.rfp-left span.subject {
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	    margin: 0 10px;
	    text-align: center;
	    margin: 5px auto;
	    display: inline-block;
	    width: 100%;
	}

	.list-group-item .rfp-left .avatar {
	    width: 40px;
	    height: 40px;
	    margin: 0 auto;
	    display: block;

	}
	}
</style>  --> 
<section class="page-header page-header-xs">
	<div class="container">
		<!-- breadcrumbs -->
		<ol class="breadcrumb breadcrumb-inverse">
			<li><a href="#">Home</a></li>
			<li><a href="#">Edit Profile</a></li>
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
		<div class="alert alert-mini alert-success margin-bottom-30">
			<?=$this->session->flashdata('success');?>
		</div>
		<?php endif; ?>
		<?php if($this->session->flashdata('error')) : ?>
		<div class="alert alert-mini alert-danger margin-bottom-30">
			<?=$this->session->flashdata('error');?>
		</div>
		<?php endif; ?>
		<!-- /ALERT -->

		<!-- RIGHT -->
		<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 margin-bottom-80">

			<ul class="nav nav-tabs nav-top-border">
				<li class="active">
					<a href="#info" data-toggle="tab">
						Personal Info
					</a>
				</li>
			</ul>
			<div class="tab-content margin-top-20">
				<!-- PERSONAL INFO TAB -->
				<div class="tab-pane fade <?php if($tab == 'info'){ echo 'in active'; }?>" id="info">
					<form action="" method="GET" id="search_rfp">
						<div class="row">
							
							<div class="alert-message"></div>


							<div class="col-lg-5 col-md-12">
								<label>Filter Data</label>
								<div class="form-group">
									<div class="fancy-form"><!-- input -->
										<i class="fa fa-search"></i>
										<input type="text" name="search" id="search" class="form-control" placeholder="Search Request Title, Dentition Type Wise" value="<?=$this->input->get('search') ? $this->input->get('search') :''?>">
										<span class="fancy-tooltip top-left"> <!-- positions: .top-left | .top-right -->
											<em>Search Request From Here</em>
										</span>
									</div>
								</div>
							</div>
							
							<div class="col-lg-2 col-md-3 sorting">
								<label>Sort</label>
								<select name="sort" class="form-control" id="sort">
									<option value="desc">Latest Request</option>
									<option value="asc">Oldest Request</option>
								</select>
							</div>	
							<div class="col-lg-2 col-md-4">
								<label>&nbsp;</label>
								<input type="submit" name="btn_search" class="btn btn-info btn_search_reset" value="Search">
								<input type="reset" name="reset" class="btn btn-default btn_search_reset" value="Reset" id="reset">
							</div>	
						</div>	
					</form>

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
						<h3>No Request Available</h3>
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

<script type="text/javascript">
	//----------------- For Add To favorite & Remove Favorite RFP ------------------
	$(".favorite").on( "click", function() {
		var rfp_id= $(this).attr('data-id');
		var classNames = $(this).attr('class').split(' ');
		var data1=$(this);
		if($.inArray('unfavorite_rfp',classNames) != '-1')
		{
			bootbox.confirm('Are you sure to add favorite Request ?' ,function(res){
				if(res){
					$.post("<?=base_url('rfp/add_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
						if(data){
							data1.removeClass('unfavorite_rfp');
							data1.addClass('favorite_rfp');
							$(".alert-message").html('<div class="alert alert-success margin-bottom-30"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times; </button>Request added to your favorite list successfully.</div>');
						}
					});
				}	
			});
		}else{
			bootbox.confirm('Are you sure to remove favorite Request ?' ,function(res){
				if(res){	
					$.post("<?=base_url('rfp/remove_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
						if(data){
							data1.removeClass('favorite_rfp');
							data1.addClass('unfavorite_rfp');
							$(".alert-message").html('<div class="alert alert-success margin-bottom-30"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times; </button>Request removed to your favorite list successfully. </div>');
						}
					});
				}
			});
		}
		return false;
	});

</script>