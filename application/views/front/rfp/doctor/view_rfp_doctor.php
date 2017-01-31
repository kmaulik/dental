<style>
.rfp-main-title{
	text-align: center;
}
.rfp-title{
	border-bottom: 2px solid gray;
    margin-bottom: 0px;
    margin-top: 10px;
}
.teeth th{
	text-align: center;
	color: #000;
	font-size: 15px;
}
.teeth td{
	padding: 10px !important;
}
.table .checkbox {
    margin-right: 0px;
}
h4.rfp-title {
    margin-bottom: 20px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 10px;
}
.rfp-basic,.rfp-history, .rfp-treatment,.rfp-additional {
    display: inline-block;
    width: 100%;
    margin-bottom: 10px;
}
.rfp-history .col-sm-12, .rfp-additional .col-sm-12 {
    margin-bottom: 20px;
    line-height: 16px;
}
label, .title {
    font-size: 15px;
    font-weight: 600;
}
.rfp-additional a img {
    border: 2px solid #ccc;
    padding: 2px;
}
.rfp-additional a {
    margin-right: 10px;
}
.col_custom label {
    display: block;
    margin-bottom: 10px;
}
.owl-wrapper .owl-item .item-box .img-responsive {
    width: 100%;
    height: 250px;
}
</style>

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
				<div class="pull-right">
					<?php if(isset($rfp_bid) && $rfp_bid != '') :?>
						<a class="btn btn-success" data-toggle="modal" data-target=".manage_bid" id="update_bid"><i class="fa fa-edit"></i> Update Bid</a>
					<?php else : ?>
						<a class="btn btn-success" data-toggle="modal" data-target=".manage_bid" id="place_bid"><i class="fa fa-plus"></i> Place Bid</a>
					<?php endif; ?>
					<a href="<?=base_url('rfp/search_rfp')?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back To RFP List</a>
				</div>
			</div>	
			<div class="col-md-12">
				<h3 class="rfp-main-title"><?=$record['title']?></h3>
			</div>	
		<div class="col-md-12">
			<div class="panel panel-flat">
				<div class="panel-body">
					<!--  Basic Details  -->
					<div class="rfp-basic">
						<h4 class="rfp-title">Basic Details</h4>
						<!-- <div class="col-sm-12">
							<span class="title">RFP Title : </span> <span><?=$record['title']?></span>
						</div> -->
						<div class="col-sm-6">
							<span class="title">Created By : </span> <span><?=fetch_username($record['patient_id'])?></span>
						</div>
						<div class="col-sm-6">
							<span class="title">Patient Name : </span> <span><?=$record['fname']." ".$record['lname']?></span>
						</div>	
						<div class="col-sm-6">
							<span class="title">BirthDate : </span> <span><?=$record['birth_date']?></span>
						</div>
						<div class="col-sm-6">
							<span class="title">Dentition Type : </span> <span><?=$record['dentition_type']?></span>
						</div>
					</div>	
					<!--  /Basic Details  -->

					<!--  Medical History  -->
					<div class="rfp-history">
						<h4 class="rfp-title">Medical History</h4>
						<div class="col-sm-12">
							<label>Known Allergies : </label> <?=$record['allergies']?>
						</div>
						<div class="col-sm-12">
							<label>Full Medication List : </label> <?=$record['medication_list']?>
						</div>
						<div class="col-sm-12">
							<label>Any heart problems including blood pressure? : </label> <?=$record['heart_problem']?>
						</div>
						<div class="col-sm-12">
							<label>Any history of chemo/radiation ? : </label> <?=$record['chemo_radiation']?>
						</div>
						<div class="col-sm-12">
							<label>Surgery occurred during the last two years. : </label> <?=$record['surgery']?>
						</div>
					</div>	
					<!--  /Medical History  -->

					<!--  Treatment Plan  -->
					<div class="rfp-treatment">
						<h4 class="rfp-title">Treatment Plan</h4>
						<div class="col-sm-12">
							<label>Treatment Category : </label> 
							<ul>
								<?php $treat_cat=explode(",",$record['treatment_cat_id']);
								foreach($treat_cat as $category) :?>
									<li><?= fetch_row_data('treatment_category',['id' => $category],'title') ?></li>
								<?php endforeach; ?>
							</ul>
						</div>

						<?php 
						$teeth_arr=explode(",",$record['teeth']);
						if($record['dentition_type'] == 'primary') :?>
							<div class="col-sm-12">
								<div class="table-responsive">	
										<table class="table table-bordered teeth">
											<thead>
												<tr>
													<th colspan="16">Primary Dentition</th>
												</tr>
												<tr>
													<th colspan="8">upper right</th>
													<th colspan="8">upper left</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th colspan="8">lower right</th>
													<th colspan="8">lower left</th>
												</tr>
											</tfoot>
											<tbody>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<?php for($i=0,$k=65;$i<10;$i++) : ?>
													<td>
														<label class="checkbox">
															<input type="checkbox" disabled value="<?=chr($k+$i);?>" name="teeth[]" <?php if(in_array(chr($k+$i),$teeth_arr)) { echo "checked"; }?>><i></i> <?=chr($k+$i);?>
														</label>
													</td>	
													<?php endfor; ?>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<?php for($i=0,$k=84;$i<10;$i++) : ?>
													<td>
														<label class="checkbox">
															<input type="checkbox" disabled value="<?=chr($k-$i);?>" name="teeth[]" <?php if(in_array(chr($k-$i),$teeth_arr)) { echo "checked"; }?>><i></i><?=chr($k-$i);?>
														</label>
													</td>
													<?php endfor; ?>
													<td></td>
													<td></td>
													<td></td>
													</tr>
											</tbody>	
										</table>
								</div>
							</div>	
						<?php elseif($record['dentition_type'] == 'permenant') :?>	
							<div class="col-sm-12">
								<div class="table-responsive">	
										<table class="table table-bordered teeth">
											<thead>
												<tr>
													<th colspan="16">Permenant Dentition</th>
												</tr>
												<tr>
													<th colspan="8">upper right</th>
													<th colspan="8">upper left</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th colspan="8">lower right</th>
													<th colspan="8">lower left</th>
												</tr>
											</tfoot>
											<tbody>
												<tr>
													<?php for($i=1;$i<=16;$i++) : ?>
													<td>
														<label class="checkbox">
															<input type="checkbox" disabled value="<?=$i?>" name="teeth[]" <?php if(in_array($i,$teeth_arr)) { echo "checked"; }?>><i></i><?=$i?>
														</label>
													</td>
													<?php endfor;?>
												</tr>
												<tr>
													<?php for($i=32;$i>16;$i--) : ?>
													<td>
														<label class="checkbox">
															<input type="checkbox" disabled value="<?=$i?>" name="teeth[]" <?php if(in_array($i,$teeth_arr)) { echo "checked"; }?>><i></i><?=$i?>
														</label>
													</td>
													<?php endfor;?>
												</tr>
											</tbody>	
										</table>
								</div>	
							</div>
						<?php elseif($record['dentition_type'] == 'other') :?>
							<div class="col-sm-12">
								<label>Other Description : </label> <?=$record['other_description'] ?> 	
							</div>
						<?php endif;?>
					</div>	
					<!--  /Treatment Plan  -->

					<!--  Additional Section -->
					<div class="rfp-additional">
						<h4 class="rfp-title">Additional Section</h4>
						<div class="col-sm-12">
							<label>Additional Comments : </label><?=$record['message'] ?> 
						</div>
						
						<div class="col-sm-12 col_custom">
							<label>Attachment : </label>
							<?php $attach_arr= explode("|",$record['img_path']);
							// Check Attachment found or not 
							if(isset($attach_arr[0]) && $attach_arr[0] != '') : ?>
							<div class="text-center">
								<div class="owl-carousel owl-padding-1 nomargin buttons-autohide controlls-over" data-plugin-options='{"singleItem": false, "items": "3", "autoPlay": 3500, "navigation": true, "pagination": false}'>
									<?php foreach($attach_arr as $attach) : ?>
										<div class="item-box">
											<figure>
												<span class="item-hover">
													<span class="overlay dark-5"></span>
													<span class="inner">

														<!-- lightbox -->
														<?php $ext=explode(".",$attach);  
														if(isset($ext) && $ext[1] != 'pdf') { ?>
															<a class="ico-rounded lightbox" href="<?=base_url('uploads/rfp/'.$attach)?>" data-plugin-options='{"type":"image"}'>
																<span class="fa fa-plus size-20"></span>
															</a>
														<?php } ?>
														<!-- details -->
														<a class="ico-rounded" href="<?=base_url('uploads/rfp/'.$attach)?>" target="_blank">
															<span class="glyphicon glyphicon-option-horizontal size-20"></span>
														</a>
													</span>
												</span>
												
												<?php if(isset($ext) && $ext[1] == 'pdf') { ?>
												<img class="img-responsive" src="<?=DEFAULT_IMAGE_PATH.'document-file.jpg'?>" width="600" height="399" alt="">	
												<?php } else { ?>
												<img class="img-responsive" src="<?=base_url('uploads/rfp/'.$attach)?>" width="600" height="399" alt="">
												<?php } ?>
											</figure>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<?php else : ?>
								N/A	
							<?php endif;?>
						</div>

					</div>	
					<!-- /Additional Section  -->	
					
				</div>
			</div>
		</div>
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
							<label>Amount</label>
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
								<input type="submit" name="submit" class="btn btn-info" value="Submit">
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
	$("#description").val("<?=$rfp_bid['description']?>");
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

