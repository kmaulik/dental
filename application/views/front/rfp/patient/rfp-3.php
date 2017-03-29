<!--<style>
	.rfp-title{
		border-bottom: 2px solid gray;
		margin-bottom: 0px;
		margin-top: 10px;
	}
</style>-->

<section class="page-header page-header-xs">
	<div class="container">
		<h1>Patient RFP</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp');?>">RFP List</a></li>
			<li class="active">Patient RFP</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">
		
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
	
	<div class="col-md-12">
		<form method="post" action="" id="frmrfp" enctype="multipart/form-data">
			
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h3 class="rfp-title">Financial Information</h3>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-12 col-sm-12">	
					<div class="form-group">
						<label>Insurance Provider</label>
						<textarea name="insurance_provider" class="form-control" placeholder="Optionally, you can share your Insurance Provider and Type with the doctor in this field."><?=set_value('insurance_provider');?></textarea>
					</div>
					<?php echo form_error('insurance_provider','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>	
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label>Treatment Plan Total ($)</label>
						<input type="text" name="treatment_plan_total" class="form-control NumbersAndDot" placeholder="If you already have received an estimate or a budget, you may enter. We will calculate your potential saving per each quote against this value." value="<?=set_value('treatment_plan_total');?>" >
					</div>
					<?php echo form_error('treatment_plan_total','<div class="alert alert-mini alert-danger">','</div>'); ?>
				</div>
			</div>	
			
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 text-right">
					<!-- <a href="<?=base_url('rfp/edit/'.encode($this->session->userdata['rfp_data']['rfp_last_id']).'/1')?>" class="btn btn-success"><i class="fa fa-arrow-left"></i> Prev</a> -->
					<button type="submit" name="prev" value="prev" class="btn btn-success submit_data"><i class="fa fa-arrow-left"></i> Prev</button>
					<button type="submit" name="next" value="next" class="btn btn-success submit_data" value="submit"><i class="fa fa-arrow-right"></i> Next</button>
					<a class="btn btn-success send_chat_loader" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Loading...</a>
				</div>
			</div>
		</form>
	</div>
</div>	
</div>	
</section>
<!-- / --> 

<script>
$('.NumbersAndDot').keyup(function () { 
    this.value = this.value.replace(/[^0-9.]/g,'');
});

$(".submit_data").click(function(event) {
	$(".submit_data").hide();
	$(".send_chat_loader").show();
});
</script>
