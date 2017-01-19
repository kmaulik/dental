<style>
.table th{
	text-align: center;
	color: #000;
}
.table .checkbox{
	margin-right: 0px;
}
.rfp-title{
	border-bottom: 2px solid gray;
	margin-bottom: 0px;
	margin-top: 10px;
}
</style>


<section class="page-header page-header-xs">
	<div class="container">
		<h1>Patient RFP</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
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
	
			<div class="col-md-12">
				<h2 class="size-16">Patient RFP</h2>
				<form method="post" action="" id="frmrfp" enctype="multipart/form-data">
					<input type="hidden" id="dentition_type" value="<?=$this->session->userdata['rfp_data']['dentition_type'];?>">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<h3 class="rfp-title">Treatment Plan</h3>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Treatment Category</label>
								<select name="treatment_cat_id[]" class="form-control select2" data-placeholder="Select Treatment Category" multiple id="treatment_cat_id">
									<?php foreach($treatment_category as $cat) :?>
										<option value="<?=$cat['id']?>" <?php echo  set_select('treatment_cat_id[]', $cat['id']); ?>><?=$cat['title']?></option>
									<?php endforeach;?>
								</select>	
							</div>
							<?php echo form_error('treatment_cat_id[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>
					</div>	
					<div class="row">
						<div class="col-md-12 col-sm-12" id="primary">
							<div class="form-group">
								<div class="table-responsive">	
									<table class="table table-bordered">
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
												<td><label class="checkbox"><input type="checkbox" value="<?=chr($k+$i);?>" name="teeth[]" <?=set_checkbox('teeth', chr($k+$i));?>><i></i><?=chr($k+$i);?></label> </td>
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
												<td><label class="checkbox"><input type="checkbox" value="<?=chr($k-$i);?>" name="teeth[]" <?=set_checkbox('teeth', chr($k-$i));?>><i></i><?=chr($k-$i);?></label> </td>
												<?php endfor; ?>
												<td></td>
												<td></td>
												<td></td>
												</tr>
										</tbody>	
									</table>
								</div>	
							</div>
							<?php echo form_error('teeth[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>		
						<div class="col-md-12 col-sm-12" id="permenant">
							<div class="form-group">
								<div class="table-responsive">	
									<table class="table table-bordered">
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
												<td><label class="checkbox"><input type="checkbox" value="<?=$i?>" name="teeth[]" <?=set_checkbox('teeth',$i);?>><i></i><?=$i?></label> </td>
												<?php endfor;?>
											</tr>
											<tr>
												<?php for($i=32;$i>16;$i--) : ?>
												<td><label class="checkbox"><input type="checkbox" value="<?=$i?>" name="teeth[]" <?=set_checkbox('teeth',$i);?>><i></i> <?=$i?></label> </td>
												<?php endfor;?>
											</tr>
										</tbody>	
									</table>
								</div>	
							</div>
							<?php echo form_error('teeth[]','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>
					</div>	
					<div class="row">	
						<div class="col-md-12 col-sm-12" id="other">
							<div class="form-group">
								<label>Other Description</label> 
								<textarea name="other_description" class="form-control" placeholder="Enter Description"><?php echo set_value('other_description'); ?></textarea>
							</div>
							<?php echo form_error('other_description','<div class="alert alert-mini alert-danger">','</div>'); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 text-right">
							<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- / --> 


<script>
fetch_definition_data();

function fetch_definition_data(){

	$("#primary").hide();
	$("#permenant").hide();
	$("#other").hide();

	if($("#dentition_type").val() == 'primary'){
		$("#permenant input[type='checkbox']").attr('checked', false);
		$("input[name='other_description']").val('');
		$("#primary").show();
	}
	else if($("#dentition_type").val() == 'permenant'){
		$("#primary input[type='checkbox']").attr('checked', false);
		$("input[name='other_description']").val('');
		$("#permenant").show();
	}
	else if($("#dentition_type").val() == 'other'){
		$("#permenant input[type='checkbox']").attr('checked', false);
		$("#primary input[type='checkbox']").attr('checked', false);
		$("#other").show();
	}
	else{
		$("#permenant input[type='checkbox']").attr('checked', false);
		$("#primary input[type='checkbox']").attr('checked', false);
		$("input[name='other_description']").val('');
		$("#primary").hide();
		$("#permenant").hide();
		$("#other").hide();
	}
}

</script>

