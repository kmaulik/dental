
<section class="page-header page-header-xs">
	<div class="container">
		<h1> RFP Details </h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp');?>">RFP List</a></li>
			<li class="active">RFP Details</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section class="view-rfp">
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
			<div class="col-md-12">
				<div class="pull-right">
					<!-- Check For Submit RFP Or Not -->
					<?php if(isset($confirm_rfp) && $confirm_rfp == '1') : ?>
					<form action="" method="POST">
						<button type="submit" name="submit" class="btn btn-success" value="submit"><i class="fa fa-check"></i> Submit</button>
					</form>	
					<?php else : ?>
					<a href="<?=base_url('rfp/view_rfp_bid/'.encode($record['id']))?>" class="btn btn-info"><i class="fa fa-eye"></i> View Proposal</a>
					<?php endif; ?>
				</div>
			</div>	
			<div class="col-md-12">
				<h3 class="rfp-main-title"><?=$record['title']?></h3>
			</div>	
			<!-- Start RFP View From Here -->	
			<?php $this->load->view('front/rfp/common_view_rfp'); ?>
			<!-- End RFP View -->
		</div>
	</div>
</section>

