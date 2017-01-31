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
		<div class="row">
			<div class="col-sm-12">
				<div id="comments">
					<h4 class="page-header margin-bottom-60 size-20">
						<span><?=count($message_data)?></span> Messages
					</h4>
					<?php if(count($message_data) > 0) : ?>
						<!-- comment item -->
						<?php foreach($message_data as $message) : ?> 
							<!-- For Receive Message -->
							<?php if($message['to_id'] == $this->session->userdata('client')['id']) :?> 
								<div class="comment-item left-msg">
									<span class="user-avatar">
										<img class="pull-left img-circle" src="<?php if($message['user_avatar'] != '') 
						                    		{ echo base_url('uploads/avatars/'.$message['user_avatar']); } 
						                    	else 
						                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" width="64" height="64" alt="">
									</span>
									<div class="media-body">
										<!-- <a href="#commentForm" class="scrollTo comment-reply">reply</a> -->
										<h4 class="media-heading bold"><?=$message['user_name']?></h4>
										<small class="block"><?=$message['created_at']?></small>
										<span class="message"><?=$message['message']?></span>
									</div>
								</div>
							<?php else :?>
								<!-- For Send Message -->
								<div class="comment-item right-msg">
									<span class="user-avatar">
										<img class="pull-left img-circle" src="<?php if($message['user_avatar'] != '') 
						                    		{ echo base_url('uploads/avatars/'.$message['user_avatar']); } 
						                    	else 
						                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" width="64" height="64" alt="">
									</span>
									<div class="media-body">
										<!-- <a href="#commentForm" class="scrollTo comment-reply">reply</a> -->
										<h4 class="media-heading bold"><?=$message['user_name']?></h4>
										<small class="block"><?=$message['created_at']?></small>
										<span class="message"><?=$message['message']?></span>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else :?>
						<h4> No Message Available</h4>
					<?php endif; ?>	
				</div>
			</div>		
		</div>	

		<!-- ================== Send Message Text Area =============== -->
		<div class="row">
			<div class="send_message_area">
				<form action="" method="POST" id="send_text_msg">	
					<div class="col-sm-10">
						<textarea class="form-control" name="message" rows="5" placeholder="Enter Message Here"></textarea>
					</div>	
					<div class="col-sm-2">
						<input type="submit" name="submit" value="Send" class="btn btn-info">
					</div>
				</form>	
			</div>		
		</div>	
		<!-- ================== /Send Message Text Area =============== -->

	</div>
</section>		

<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>
<script>
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