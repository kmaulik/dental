<section class="page-header page-header-xs">
	<div class="container">
		<h1>CONTACT US</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('')?>">Home</a></li>
			<li class="active">Contact Us</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section>
	<div class="container">
		<div class="row">
			<!-- FORM -->
			<div class="col-md-8 col-sm-8">

				<h3>Contact Inquiry</h3>

				<?php if($this->session->flashdata('success')) : ?>
				<!-- Alert Success -->
				<div class="alert alert-success margin-bottom-30">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?= $this->session->flashdata('success'); ?>
				</div><!-- /Alert Success -->
				<?php endif; ?>

				<?php if($this->session->flashdata('error')) : ?>
				<!-- Alert Failed -->
				<div class="alert alert-danger margin-bottom-30">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?= $this->session->flashdata('error'); ?>
				</div><!-- /Alert Failed -->
				<?php endif; ?>

				<form action="" method="post">
					<fieldset>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Full Name *</label>
									<?php
										if(!empty($client_data)){
											$full_name = $client_data['fname'].' '.$client_data['lname'];
										}else{
											$full_name = set_value('name');
										}
									?>
									<input type="text" value="<?php echo $full_name; ?>" class="form-control" name="name">
								</div>
								<?php echo form_error('name','<div class="alert alert-mini alert-danger">','</div>'); ?>

							</div>
							<div class="col-md-6">
								<div class="form-group">
									<?php
										if(!empty($client_data)){
											$email = $client_data['email_id'];
										}else{
											$email = set_value('email');
										}
									?>
									<label>E-mail Address *</label>
									<input type="text" value="<?php echo $email; ?>" class="form-control" name="email">
								</div>
								<?php echo form_error('email','<div class="alert alert-mini alert-danger">','</div>'); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Subject *</label>
									<input type="text" value="<?php echo set_value('subject'); ?>" class="form-control" name="subject">
								</div>
								<?php echo form_error('subject','<div class="alert alert-mini alert-danger">','</div>'); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Message *</label>
									<textarea rows="8" class="form-control" name="description"><?php echo set_value('description'); ?></textarea>
								</div>
								<?php echo form_error('description','<div class="alert alert-mini alert-danger">','</div>'); ?>
							</div>
						</div>
					</fieldset>

					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> SEND MESSAGE</button>
						</div>
					</div>
				</form>

			</div>
			<!-- /FORM -->


			<!-- INFO -->
			<div class="col-md-4 col-sm-4">

				<h2>Visit Us</h2>

				<!-- 
				Available heights
					height-100
					height-150
					height-200
					height-250
					height-300
					height-350
					height-400
					height-450
					height-500
					height-550
					height-600
				-->
				<div id="map2" class="height-400">
					<iframe width="500" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?=config('contact_address')?>&output=embed"></iframe>
				</div>

				<hr />

				<p>
					<span class="block"><strong><i class="fa fa-map-marker"></i> Address:</strong> <?=config('contact_address');?></span>
					<span class="block"><strong><i class="fa fa-phone"></i> Phone:</strong> <a href="tel:<?=config('phone');?>"><?=config('phone');?></a></span>
					<span class="block"><strong><i class="fa fa-envelope"></i> Email:</strong> <a href="mailto:<?=config('contact_email'); ?>"><?=config('contact_email'); ?></a></span>
				</p>

			</div>
			<!-- /INFO -->
		</div>
	</div>
</section>
<!-- / -->
