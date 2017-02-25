<!--<style>
#coupan_code{
	padding-left: 12px;
}
#apply-code{
	cursor: pointer;
}
</style>-->

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
						<a href="<?=base_url('rfp/edit/'.encode($record['id']).'/2')?>" class="btn btn-success"><i class="fa fa-arrow-left"></i> Prev</a>
						<?php if($record['is_paid'] == 0) :?>
							<a class="btn btn-success" data-toggle="modal" data-target=".promotional_code"><i class="fa fa-check"></i> Make a Payment</a>
						<?php else : ?>
							<button type="submit" name="submit" class="btn btn-success" value="submit"><i class="fa fa-check"></i> Submit</button>
						<?php endif; ?>
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


<!-- ==================== Modal Popup For Apply Promotional Code ========================= -->
<div class="modal fade promotional_code" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Apply Coupan Code</h4>
			</div>
			<form action="<?=base_url('rfp/make_payment')?>" method="POST" id="frmcoupan">
				<input type="hidden" name="is_paid" value="1">
				<input type="hidden" name="rfp_id" value="<?=encode($record['id'])?>">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h4>RFP Price : $ <?=config('patient_fees')?></h4>
							</div>	
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Coupan Code</label>
								<div class="fancy-file-upload fancy-file-success">
									<input type="text" class="form-control" name="coupan_code" id="coupan_code"/>
									<span class="button" id="apply-code">Apply Code</span>
								</div>
								<span class="coupan-msg"></span>	
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<h4>Final Price : $ <span class="final-prices"><?=config('patient_fees')?></span></h4>
							</div>
						</div>						
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-info" value="Make Payment">
							<input type="reset" name="reset" class="btn btn-default cancel-payment" value="Cancel">
						</div>	
					</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Place a Bid ========================= -->


<script>


$("#apply-code").click(function(){
	$(".coupan-msg").html('');
	var coupan_code = $("#coupan_code").val();
	if(coupan_code != ''){
		var discount_amt=0;
		$.post("<?=base_url('rfp/fetch_coupan_data')?>",{'coupan_code' : coupan_code},function(data){
			
			if(data != 0){
				//---------- Check apply code limit for per user ----------
				if(data['per_user_limit'] > data['total_apply_code']){
					discount_amt = 	((<?=config('patient_fees')?> * data['discount'])/100);
					var final_price = <?=config('patient_fees')?> - discount_amt;
					$(".final-prices").html(final_price);
					$(".coupan-msg").html("Coupan Code Apply Successfully");
					$(".coupan-msg").css("color", "green");
				}
				else{
					$(".coupan-msg").html("Sorry, You Already applied this code");
					$(".coupan-msg").css("color", "red");
				}
			}else{
				$(".coupan-msg").html("Invalid Coupan Code");
				$(".coupan-msg").css("color", "red");
			}

		},"json");
	}else{
		$(".coupan-msg").html("Please Enter Coupan Code");
		$(".coupan-msg").css("color", "red");	
	}
});

$(".cancel-payment").click(function(){
	$('.promotional_code .close').click();
});

$(".promotional_code .close").click(function(){
	$(".final-prices").html(<?=config('patient_fees')?>);
	$("#coupan_code").val('');
	$(".coupan-msg").html('');
});

</script>