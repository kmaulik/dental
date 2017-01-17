<section class="page-header">
	<div class="container">

		<h1>Reset Password</h1>

		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Reset Password</li>
		</ol><!-- /breadcrumbs -->

	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">

			<!-- LEFT TEXT -->
			<div class="col-md-5 col-md-offset-1">

				<h2 class="size-16">IMPORTANT INFORMATION</h2>
				<p class="text-muted">Maecenas metus nulla, commodo a sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>
				<p class="text-muted">Sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>

			</div>
			<!-- /LEFT TEXT -->


			<!-- Reset Password -->
			<div class="col-md-4">

				<h2 class="size-16">Reset Password</h2>

				<!-- Reset Password form -->
				<form method="post" action="" id="frmreset" class="sky-form">

					<?php //echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
					<div class="clearfix">

						<!-- Password -->
						<div class="form-group">
							<label class="input margin-bottom-10">
								<i class="ico-append fa fa-lock"></i>
								<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>" >
							</label>	
						</div>
						<?php echo form_error('password','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<div class="form-group">
							<label class="input margin-bottom-10">
								<i class="ico-append fa fa-lock"></i>
								<input type="password" name="c_password" class="form-control" placeholder="Confirm Password" value="<?php echo set_value('c_password'); ?>" >
							</label>	
						</div>
						<?php echo form_error('c_password','<div class="alert alert-mini alert-danger">','</div>'); ?>

					</div>

					<div class="row">

						<div class="col-md-12 col-sm-12 col-xs-12">

							<!-- Inform Tip -->                                        
							<div class="form-tip pt-20">
								Already have an account? <a href="<?=base_url('login')?>"><strong>Back to login!</strong></a>
							</div>

						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 text-right">

							<input type="submit" class="btn btn-primary" name="submit" value="Sumbit">

						</div>

					</div>

				</form>
				<!-- /Reset Password form -->

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
		</div>
		<!-- /Reset Password -->
	</div>
</div>
</section>
<!-- / --> 