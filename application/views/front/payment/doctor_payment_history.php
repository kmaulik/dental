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
								<th style="width:75px;">Payment Type</th>
								<th>Request Title</th>
								<th>Patient Name</th>
								<th style="width:90px;">Total Bid Value ($)</th>
								<th style="width:80px;">Total Net Fee ($)</th>
								<th style="width:95px;">This Payment ($)</th>
								<th style="width:100px;">Remaining Fees Due ($)</th>
								<th>Pay Date</th>
								<th>Invoice</th>
							</tr>
						</thead>
						<tbody>
							<?php if(count($transaction_list) >  0) :?>
								<?php foreach ($transaction_list as $key => $record) :?>
									<?php if($record['discount'] != 0) {
										$total_fee = ($record['actual_price'] - (($record['actual_price']*$record['discount'])/100));
									}else{
										$total_fee = $record['actual_price'];
									}?>
									<tr>
										<td><?=$record['paypal_token']?></td>
										<td><?php if($record['payment_type'] == 1) :?>
												<span class="label label-danger">MANUAL</span>
											<?php else : ?>
												<span class="label label-success">PAYPAL</span>
											<?php endif; ?>
										</td>
										<td><a href="<?=base_url('rfp/view_rfp/'.encode($record['rfp_id']));?>" target="_blank" title="<?=$record['rfp_title']?>"><?=character_limiter($record['rfp_title'],50)?></a></td>
										<td><?=$record['patient_name']?></td>
										<td><?=$record['bid_amt']?></td>
										<td><?=$total_fee?></td>
										<td><?=$record['payable_price']?></td>
										<td><?=$record['remaining_payment']?></td>
										<td><?=date("m-d-Y",strtotime($record['created_at']))?></td>
										<td>
											<!-- If Payment is verified then view download invoice option -->
											<?php if($record['status'] == 1) :?>
												<a href="<?=base_url('payment_transaction/download_invoice/'.encode($record['id']))?>" target="_blank" data-toggle="tooltip" data-placement="top" data-original-title="Download Invoice"><i class="fa fa-download"></i>
											<?php endif;?>
										</td>	
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="9"><h4 class="text-center">No Transaction History</h4></td>	
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


	
