<section class="page-header page-header-xs">
	<div class="container">
		<h1>Payment Transaction History</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Payment History</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- ============ Filter Payment History =========== -->
				<form action="" method="GET" id="filter_transaction">
					<div class="row">
						
						<div class="col-lg-5 col-md-12">
							<label>Filter Data</label>
							<div class="form-group">
								<div class="fancy-form"><!-- input -->
									<i class="fa fa-search"></i>
									<input type="text" name="search" id="search" class="form-control" placeholder="Search Transaction Id , Request Title Wise , Patient Name" value="<?=$this->input->get('search') ? $this->input->get('search') :''?>">
									<span class="fancy-tooltip top-left"> <!-- positions: .top-left | .top-right -->
										<em>Filter Payment History From Here</em>
									</span>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-md-5">
							<label>Filter Date Wise</label>
							<input type="text" name="date" class="form-control rangepicker" value="<?=$this->input->get('date') ? $this->input->get('date') :''?>" data-format="yyyy-mm-dd" data-from="2015-01-01" data-to="2016-12-31" readonly>
						</div>

						<div class="col-lg-2 col-md-3 sorting">
							<label>Sort Transaction</label>
							<select name="sort" class="form-control" id="sort">
								<option value="desc">Latest</option>
								<option value="asc">Oldest</option>
							</select>
						</div>

						<div class="col-lg-2 col-md-4">
							<label>&nbsp;</label>
							<input type="submit" name="btn_search" class="btn btn-info" value="Search">
							<input type="reset" name="reset" class="btn btn-default" value="Reset" id="reset">
						</div>	
					</div>	
				</form>
				<!-- ============ Filter Payment History =========== -->
			</div>	
			<div class="col-md-12">
				<!-- ================ Table ============= -->
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Transaction #</th>
								<th>Request Title</th>
								<th>Patient Name</th>
								<th>Total Fee ($)</th>
								<th>Payment Value ($)</th>
								<th>Discount (%)</th>
								<th>Pay Date</th>
							</tr>
						</thead>
						<tbody>
							<?php if(count($transaction_list) >  0) :?>
								<?php foreach ($transaction_list as $key => $record) : ?>
									<tr>
										<td><?=$record['paypal_token']?></td>
										<td><a href="<?=base_url('rfp/view_rfp/'.encode($record['rfp_id']));?>" target="_blank"><?=character_limiter($record['rfp_title'],50)?></a></td>
										<td><?=$record['patient_name']?></td>
										<td><?=$record['actual_price']?></td>
										<td><?=$record['payable_price']?></td>
										<td><?=$record['discount']?></td>
										<td><?=date("m-d-Y",strtotime($record['created_at']))?></td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="5"><h4 class="text-center">No Transaction History</h4></td>	
								</tr>	
							<?php endif; ?>
						</tbody>
					</table>
				</div>		
				<!-- =============== End Table ========== -->	
			</div>	
			<div class="col-sm-12">
				<?php echo $this->pagination->create_links(); ?>	
			</div>	
		</div>
	</div>
</section>	


<script>
$("#sort").val("<?=$this->input->get('sort')?$this->input->get('sort'):'desc'?>");
$("#reset").click(function(){
	$('input[name=search]').val('');
	$('input[name=date]').val('');
	$("#sort").val('desc');
	$("#filter_transaction").submit();
});

</script>


	
