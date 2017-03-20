<!--<style>
.right-msg .media-body {
  text-align: right;
}
.right-msg img.pull-left {
  float: right !important;
  margin-left: 15px !important;
}
.right-msg img.pull-left, .left-msg img.pull-left {
  margin: 0;
}
.right-msg .user_name .block {
  left: 0;
  position: absolute;
  top: 0;
}
.left-msg .user_name .block {
  position: absolute;
  right: 0;
  top: 0;
}
.user_name {
  position: relative;
}
.comment-item.right-msg, .comment-item.left-msg {
  margin-bottom: 20px;
  min-height: 95px;
  border-radius: 6px; 
  margin-right: 5px;
}
.wrapper_msg h4 {
  color: #1980b6;
  margin: 0 0 5px !important;
}
.left-msg img.pull-left {
  margin-right: 15px !important;
}
.comment-item.right-msg {
  background: #f1f1f1 none repeat scroll 0 0;
  padding: 15px;
}
.comment-item.left-msg { 
  padding: 0px 15px;
}
.wrapper_msg {
  background: #fff none repeat scroll 0 0;
  box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.15);
padding: 20px;
}
.wrapper_msg h4.page-header {
  margin-bottom: 20px !important;
}
.wrapper_inner_box{
  max-height: 760px;
  overflow: auto;
}
.send_message_area.text_right {
  margin-top: 20px;
  text-align: right;
}
.send_message_area .btn_info {
  background: #1980b6 none repeat scroll 0 0;
  border: 2px solid #1980b6;
  border-radius: 4px !important;
  color: #fff;
  height: auto;
  line-height: normal;
  padding: 9px 30px;
  transition: all 0.5s ease-in-out 0s;
}
.send_message_area .btn_info:hover {
  background: transparent none repeat scroll 0 0;
  color: #1980b6;
}
.right-msg .user_name h4 {
  padding-left: 120px;
}
.left-msg .user_name h4 {
  padding-right: 120px;
}
@media (min-width:768px) and (max-width:991px){
	.wrapper_inner_box {
  padding-right: 20px;
}
}
@media (min-width:992px) and (max-width:1199px){
	.wrapper_inner_box {
  padding-right: 20px;
}
}

@media (max-width:767px){
.right-msg .user_name h4 {
  padding-left: 0;
}
.right-msg .user_name .block {
  left: auto;
  position: relative;
  top: auto;
}
.right-msg img.pull-left {
  float: none !important;
  margin-left: 0 !important;
}
.user-avatar {
  display: inline-block;
  text-align: center;
  width: 100%;
}
.right-msg .media-body {
  text-align: center;
}
.left-msg img.pull-left {
  float: none !important;
  margin-right: 0 !important;
}
.left-msg .media-body {
  text-align: center;
}
.left-msg .user_name h4 {
  padding-right: 0;
}
.left-msg .user_name .block {
  position: relative;
  right: auto;
  top: auto;
}
.wrapper_inner_box {
  padding-right: 15px;
}
.message {
  font-size: 13px;
}
}
</style>-->
<section class="page-header page-header-xs">
	<div class="container">
		<h1>Messageboard</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('')?>">Home</a></li>
			<li><a href="<?=base_url('messageboard')?>">Messageboard</a></li>
			<li class="active">Message</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<!-- /PAGE HEADER -->

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
		<div class="row">
			<div class="col-sm-12">
				<h3 class="rfp-title">
					<?php if(!empty($message_data)) : ?>	
						<a href="<?=base_url('rfp/view_rfp/'.encode($message_data[0]['rfp_id']))?>"><?=isset($message_data[0]['rfp_title'])?$message_data[0]['rfp_title']:''?></a>
					<?php endif; ?>
				</h3>
				<div id="comments" class="wrapper_msg">
					<h4 class="page-header margin-bottom-60 size-20">
						<span><?=count($message_data)?></span> Messages
					</h4>
					<?php if(count($message_data) > 0) : ?>
						<div class="wrapper_inner_box">
							<?php foreach($message_data as $message) : ?> 
								<!-- For Receive Message -->
								<?php if($message['to_id'] == $this->session->userdata('client')['id']) :?> 
									<!-- comment item -->
									<div class="comment-item left-msg">
										<span class="user-avatar">
											<img class="pull-left img-circle" src="<?php if($message['user_avatar'] != '') 
							                    		{ echo base_url('uploads/avatars/'.$message['user_avatar']); } 
							                    	else 
							                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" width="64" height="64" alt="">
										</span>
										<div class="media-body">
											<!-- <a href="#commentForm" class="scrollTo comment-reply">reply</a> -->
											<div class="user_name">
												<h4 class="media-heading bold"><?=$message['user_name']?></h4>
												<small class="block"><i class="fa fa-clock-o"></i> <?=date("d-M-y H:i A",strtotime($message['created_at']))?></small>
											</div>	
											<span class="message"><?=$message['message']?></span>
										</div>
									</div>
									<!-- /comment item -->
								<?php else :?>
									<!-- For Send Message -->
									<!-- comment item -->
									<div class="comment-item right-msg">
										<span class="user-avatar">
											<img class="pull-left img-circle" src="<?php if($message['user_avatar'] != '') 
							                    		{ echo base_url('uploads/avatars/'.$message['user_avatar']); } 
							                    	else 
							                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" width="64" height="64" alt="">
										</span>
										<div class="media-body">
											<!-- <a href="#commentForm" class="scrollTo comment-reply">reply</a> -->
											<div class="user_name">
												<h4 class="media-heading bold"><?=$message['user_name']?></h4>
												<small class="block"><i class="fa fa-clock-o"></i> <?=date("d-M-y H:i A",strtotime($message['created_at']))?></small>
											</div>
											<span class="message"><?=$message['message']?></span>
										</div>
									</div>
									<!-- /comment item -->
								<?php endif; ?> 
							<?php endforeach; ?>
						</div>
					<?php else :?>
						<h4> No Message Available</h4>
					<?php endif; ?>	
				</div>
			</div>		
		</div>	

		<?php if(count($message_data) > 0) : ?>
			<!-- ================== Send Message Text Area =============== -->
			<div class="row">
				<div class="send_message_area">
					<form action="" method="POST" id="send_text_msg">	
						<div class="col-sm-12">
							<textarea class="form-control" name="message" rows="5" placeholder="Enter Message Here"></textarea>
						</div>	
						<div class="col-sm-12">
							<div class="text_right">
								<input type="submit" name="submit" value="Send" class="btn btn-info btn_info">
							</div>
						</div>
					</form>	
				</div>		
			</div>	
			<!-- ================== /Send Message Text Area =============== -->
		<?php endif; ?>

	</div>
</section>		

<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>
<script>
$("document").ready(function(){
	<?php if(count($message_data) > 0) : ?>
		$('.wrapper_inner_box').scrollTop($('.wrapper_inner_box')[0].scrollHeight);
	<?php endif;?>	
});


$("#send_text_msg").validate({
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
</script>