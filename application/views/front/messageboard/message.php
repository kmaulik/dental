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
										<h4 class="media-heading bold">John Doe</h4>
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

		<div class="row">
			<div class="col-sm-10">
				<textarea class="form-control" name="message" rows="5"></textarea>
			</div>	
			<div class="col-sm-2">
				<input type="submit" name="submit" value="Send" class="btn btn-info">
			</div>	
		</div>	
	</div>
</section>		