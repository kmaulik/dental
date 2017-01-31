<section class="page-header page-header-xs">
	<div class="container">
		<h1>Set Password</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Password</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">
			<!-- LOGIN -->
			<div class="col-md-12">
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

				<!-- login form -->
				<form method="post" action="" id="frmlogin" class="sky-form">

					<?php //echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
					<div class="clearfix">						

						<!-- Password -->
						<div class="form-group">
							<label class="input margin-bottom-10">
								<i class="ico-append fa fa-lock"></i>
								<input type="password" name="password" class="form-control" placeholder="Password">
							</label>
						</div>
						<?php echo form_error('password','<div class="alert alert-mini alert-danger">','</div>'); ?>

						<!-- Password -->
						<div class="form-group">
							<label class="input margin-bottom-10">
								<i class="ico-append fa fa-lock"></i>
								<input type="password" name="re_password" class="form-control" placeholder="Retype Password">
							</label>
						</div>
						<?php echo form_error('re_password','<div class="alert alert-mini alert-danger">','</div>'); ?>

					</div>

					<div class="row">						
						<div class="">
							<input type="submit" class="btn btn_custom" name="submit" value="Set Password">
						</div>
					</div>
				</form>
				<!-- /login form -->				
			</div>
			<!-- /LOGIN -->
		</div>
	</div>
</section>
<!-- / --> 