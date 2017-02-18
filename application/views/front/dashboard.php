<section class="page-header page-header-xs">
	<div class="container">
		<h1>Dashboard</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url();?>">Home</a></li>
			<li class="active">Dashboard</li>
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
				<h1>WelCome To Dashboard</h1>	
			</div>	
			
		</div>

		<div class="row">

			<div class="col-md-4">
				<div class="box-flip box-icon box-icon-center box-icon-round box-icon-large text-center">
					<div class="front">
						<div class="box1">
							<div class="box-icon-title">
								<i class="fa fa-tint"></i>
								<h2>Fully Reposnive</h2>
							</div>
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
						</div>
					</div>

					<div class="back">
						<div class="box2">
							<h4>BACK SIDE</h4>
							<hr />
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
							<a href="#" class="btn btn-translucid btn-lg btn-block">PURCHASE NOW</a>
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-4">

				<div class="box-flip box-icon box-icon-center box-icon-round box-icon-large text-center">
					<div class="front">
						<div class="box1">
							<div class="box-icon-title">
								<i class="fa fa-random"></i>
								<h2>Clean Design</h2>
							</div>
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
						</div>
					</div>

					<div class="back">
						<div class="box2">
							<h4>BACK SIDE</h4>
							<hr />
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
							<a href="#" class="btn btn-translucid btn-lg btn-block">PURCHASE NOW</a>
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-4">

				<div class="box-flip box-icon box-icon-center box-icon-round box-icon-large text-center">
					<div class="front">
						<div class="box1">
							<div class="box-icon-title">
								<i class="fa fa-cogs"></i>
								<h2>Multipurpose</h2>
							</div>
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
						</div>
					</div>

					<div class="back">
						<div class="box2">
							<h4>BACK SIDE</h4>
							<hr />
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere</p>
							<a href="#" class="btn btn-translucid btn-lg btn-block">PURCHASE NOW</a>
						</div>
					</div>
				</div>

			</div>

		</div>

		<!-- Payment Table -->
		<div class="row">
			<div class="col-md-12">
				<h4>Payment History</h4>	
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>RFP Title</th>
								<th>User Name</th>
								<th>RFP Status</th>
								<th>Dentition Type</th>
								<th>Paid Price</th>
								<th>Refund Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($rfp_list as $key=>$list) : ?>
								<tr>
									<td><?=$list['rfp_title']?></td>
									<td><?=$list['user_name']?></td>
									<td>
										<?php if($list['rfp_status'] == 0) :?>
											<span class="label label-default">Draft</span>
										<?php elseif($list['rfp_status'] == 1) : ?>
											<span class="label label-primary">Pending</span>
										<?php elseif($list['rfp_status'] == 2) : ?>
											<span class="label label-danger">Submit Pending</span>
										<?php elseif($list['rfp_status'] == 3) : ?>
											<span class="label label-info">Open</span>
										<?php elseif($list['rfp_status'] == 4) : ?>
											<span class="label label-warning">In-Progress</span>			
										<?php elseif($list['rfp_status'] == 5) : ?>
											<span class="label label-success">Close</span>			
										<?php endif; ?>
									</td>
									<td><?=$list['dentition_type']?></td>
									<td><?=$list['paid_price']?></td>
									<td>
										<?php if($list['refund_status'] == '') :?>
										<span class="label label-default">--</span>
										<?php elseif($list['refund_status'] == '0') :?>
										<span class="label label-info">In-Progress</span>
										<?php elseif($list['refund_status'] == '1') :?>
										<span class="label label-success">Approved</span>
										<?php elseif($list['refund_status'] == '2') :?>
										<span class="label label-danger">Rejected</span>
										<?php endif; ?>
									</td>
									<td>
										<?php if($list['refund_id'] == '') :?>
											<a onclick="refund_request(<?=$key?>)" class="btn btn-3d btn-xs btn-reveal btn-green" data-toggle="modal" data-target=".refund_request">
												<i class="fa fa-money"></i><span>Refund</span>
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>	
						</tbody>
					</table>
				</div>			
			</div>	
		</div>	
		<!-- Payment List -->
	</div>
</section>	

<!-- ==================== Modal Popup For Refund Payment ========================= -->
<div class="modal fade refund_request" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Refund Payment</h4>
			</div>
			<form action="<?=base_url('dashboard/refund_request')?>" method="POST" id="frmrefund">
				<input type="hidden" name="payment_id" id="payment_id">
				<input type="hidden" name="rfp_id" id="rfp_id">
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>RFP Title</label>
								<input type="text" id="rfp_title" class="form-control" disabled>
							</div>
						</div>	
						<div class="col-sm-6">
							<div class="form-group">
								<label>Refund Amount</label>
								<input type="text" id="refund_amt" class="form-control" disabled>
							</div>
						</div>	
						<div class="col-sm-12">
							<div class="form-group">
								<label>Description (Refund Reason)</label>
								<textarea name="description" id="description" class="form-control" rows="5" required></textarea>
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
<!-- ================== /Modal Popup For Refund Payment ========================= -->				

<script>
function refund_request(key){
	var rfp_data = <?php echo json_encode($rfp_list); ?>;
	console.log(rfp_data[key]);
	$("#rfp_id").val(rfp_data[key]['rfp_id']);
	$("#payment_id").val(rfp_data[key]['payment_id']);
	$("#rfp_title").val(rfp_data[key]['rfp_title']);
	$("#refund_amt").val(rfp_data[key]['paid_price']);
}
</script>