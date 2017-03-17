<section class="page-header page-header-xs">
	<div class="container">
		<h1> RFP Details </h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li><a href="<?=base_url('rfp/search_rfp');?>">Search RFP</a></li>
			<li class="active">RFP Details</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section class="view-rfp">
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
				<div class="pull-right">
					<!-- ====== For Check Bid Already Placed Or Not  ====== -->
					<?php if(isset($rfp_bid) && $rfp_bid != '') :?>
						<!-- ====== For Check chat is started or not ====== -->
						<?php if($rfp_bid['is_chat_started'] == '1') : ?>
							<a href="<?=base_url('messageboard/message/'.encode($record['id']).'/'.encode($record['patient_id']))?>" class="btn btn-info"><i class="fa fa-envelope"></i> Message</a>
						<?php endif; ?>
						<!-- ====== End Check chat is started or not ====== -->
						<!-- ====== For Check RFP status In-progress(Winner) or not ====== -->
						<a class="btn btn-success" data-toggle="modal" data-target=".manage_bid" id="update_bid"><i class="fa fa-eye"></i> View Bid</a>
						<!-- ====== End Check RFP status In-progress(Winner) or not ====== -->
					<?php else : ?>
						<!-- ====== For Check RFP status Open or not ====== -->
						<?php if($record['status'] == 3 && $record['rfp_valid_date'] >= date("Y-m-d")) : ?> <!-- 3 Means Open RFP & rfp_valid_date >= date) For this RFP then show bid button -->
							<a class="btn btn-success" data-toggle="modal" data-target=".manage_bid" id="place_bid"><i class="fa fa-plus"></i> Place Bid</a>
						<?php endif; ?>
						<!-- ====== End Check RFP status Open or not ====== -->
					<?php endif; ?>
					<!-- ====== End Check Bid Already Placed Or Not  ====== -->
					<a href="<?=base_url('rfp/search_rfp')?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back To RFP List</a>
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



<!-- ==================== Modal Popup For Place a Bid ========================= -->
<div class="modal fade manage_bid" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Place Bid</h4>
			</div>
			<form action="<?=base_url('rfp/manage_bid')?>" method="POST" id="frmbid">
				<input type="hidden" name="rfp_id" id="rfp_id">
				<input type="hidden" name="rfp_bid_id" id="rfp_bid_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<label>Amount ($)</label>
							<div class="form-group">
								<input type="text" name="amount" id="amount" class="form-control NumbersAndDot">
							</div>	
						</div>
						<div class="col-sm-12">
							<label>Description</label>
							<div class="form-group">
								<textarea name="description" id="description" class="form-control" rows="5"></textarea>
							</div>	
						</div>		
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-info custom-submit" value="Submit">
								<input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="$('.close').click()">
							</div>	
						</div>	
				</div>	
			</form>

		</div>
	</div>
</div>
<!-- ================== /Modal Popup For Place a Bid ========================= -->
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/additional_methods.min.js"; ?>"></script>
<?php 	
	$description = str_replace(array("\r","\n"),"",$rfp_bid['description']);
?>
<script>
$('.NumbersAndDot').keyup(function () { 
    this.value = this.value.replace(/[^0-9.]/g,'');
});

$("#place_bid").click(function(){
	$("#rfp_id").val(<?=$record['id']?>);
});

$("#update_bid").click(function(){
	$("#rfp_id").val(<?=$record['id']?>);
	$("#rfp_bid_id").val(<?=$rfp_bid['id']?>);
	$("#amount").val("<?=$rfp_bid['amount']?>");
	$("#description").val("<?= $description?>");

	//---------- For Read Only when update bid ----
	$('#amount').prop('readonly', true);
	$('#description').prop('readonly', true);
	$('.custom-submit').hide();
	//---------------------------------------------
});

//---------------------- Validation -------------------
$("#frmbid").validate({
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    rules: {
        amount: {
            required: true,
        },
        description: {
            required: true
        }
    },
    messages: {
        amount: {
            required: "Please provide a Amount"
        },
        description: {
            required: "Please provide a Description"
        }
    }
});
</script>

