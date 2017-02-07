<section class="page-header page-header-xs">
	<div class="container">

		<h1>Forgot Password</h1>

		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Forgot Password</li>
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


			<!-- Forgot Password -->
			<div class="col-md-4">

				<h2 class="size-16">Forgot Password</h2>

				<!-- Forgot Password form -->
				<form method="post" action="" id="frmforgot" class="sky-form">

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
				<!-- /Forgot Password form -->

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
		<!-- /Forgot Password -->
	</div>
</div>
</section>
<!-- / --> 