<section class="page-header">
	<div class="container">

		<h1>LOGIN</h1>

		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Login</li>
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


			<!-- LOGIN -->
			<div class="col-md-4">

				<h2 class="size-16">LOGIN</h2>

				<!-- login form -->
				<form method="post" action="" id="frmlogin" class="sky-form">

					<?php //echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
					<div class="clearfix">

						<!-- Email -->
						<div class="form-group">
							<label class="input margin-bottom-10">
								<i class="ico-append fa fa-envelope"></i>
								<input type="text" name="email_id" class="form-control" placeholder="Email" value="<?php echo set_value('email_id'); ?>" >
							</label>	
						</div>
						<?php echo form_error('email_id','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<!-- Password -->
						<div class="form-group">
							<label class="input margin-bottom-10">
								<i class="ico-append fa fa-lock"></i>
								<input type="password" name="password" class="form-control" placeholder="Password">
							</label>
						</div>
						<?php echo form_error('password','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<div class="form-group">
							<label class="radio">
								<input type="radio" name="role_id" value="5" checked="checked">
								<i></i> Patient
							</label>
							<label class="radio">
								<input type="radio" name="role_id" value="4">
								<i></i> Doctor
							</label>
						</div>

					</div>

					<div class="row">

						<div class="col-md-6 col-sm-6 col-xs-6">

							<!-- Inform Tip -->                                        
							<div class="form-tip pt-20">
								<a class="no-text-decoration size-13 margin-top-10 block" href="#">Forgot Password?</a>
							</div>

						</div>

						<div class="col-md-6 col-sm-6 col-xs-6 text-right">

							<input type="submit" class="btn btn-primary" name="submit" value="OK, LOG IN">

						</div>

					</div>

				</form>
				<!-- /login form -->

				<!-- ALERT -->
				<?php if($this->session->flashdata('success')) : ?>
				<div class="alert alert-mini alert-success margin-bottom-30">
					<strong>Oh snap!</strong> <?=$this->session->flashdata('success');?>
				</div>
				<?php endif; ?>
				<?php if($this->session->flashdata('error')) : ?>
				<div class="alert alert-mini alert-danger margin-bottom-30">
					<strong>Oh snap!</strong> <?=$this->session->flashdata('error');?>
				</div>
				<?php endif; ?>
				<!-- /ALERT -->
		</div>
		<!-- /LOGIN -->
	</div>
</div>
</section>
<!-- / --> 