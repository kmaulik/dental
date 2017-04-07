<section class="page-header page-header-xs">
	<div class="container">
		<h1>Request List</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li class="active">Request List</li>
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
			<div class="col-sm-12">
				<a href="<?=base_url('rfp/add');?>" class="btn btn-3d btn-sm btn-reveal btn-info pull-right">
					<i class="fa fa-plus"></i><span>Create Request</span>
				</a>
			</div>	
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Status</th>
								<th>Expire Date</th>
								<th>Extended</th>
								<th>Dentition Type</th>
								<th style="width:235px;">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(count($rfp_list) > 0) :?>
								<?php foreach($rfp_list as $key=>$record) : ?>
									<tr>
										<td><?=$key+1;?></td>
										<td><?=$record['title']?></td>
										<td><?=$record['fname']?></td>
										<td><?=$record['lname']?></td>
										<td><?=rfp_status_label($record['status'])?></td>
										<td><?=isset($record['rfp_valid_date'])?date("m-d-Y",strtotime($record['rfp_valid_date'])):'N/A'?></td>
										<td>
											<?php if($record['is_extended'] == 1) :?>	
											Yes
											<?php else : ?>
											No
											<?php endif; ?>
										</td>
										<td><?=$record['dentition_type']?></td>
										<td>
											<a href="<?=base_url('rfp/view_rfp/'.encode($record['id']))?>" class="btn btn-3d btn-xs btn-reveal btn-info" data-toggle="tooltip" data-placement="top" data-original-title="View Request">
												<i class="fa fa-eye"></i><span>View</span>
											</a>
											<!-- For Check Status == 3 && valid date set and valid date >= today and patient validity not extend then display extend button--> 
											<?php if($record['status'] == 3 && $record['rfp_valid_date'] != '' && $record['rfp_valid_date'] >= date("Y-m-d") && $record['is_extended'] == 0) :?>
												<a href="<?=base_url('rfp/extend_rfp_validity/'.encode($record['id']))?>" class="btn btn-3d btn-xs btn-reveal btn-blue btn_extend" data-toggle="tooltip" data-placement="top" data-original-title="Extend Request Validity For 7 Days">
												<i class="fa fa-arrows"></i><span>Extend</span>
											<?php endif; ?>
											<!-- End Check Valid date -->
											<!-- ==== Check Status (0=draft,1=pending,2=submit Pending) then show edit & delete option -->
											<?php if($record['status'] <= 2) : ?>
												<a href="<?=base_url('rfp/edit/'.encode($record['id']).'/3')?>" class="btn btn-3d btn-xs btn-reveal btn-green" data-toggle="tooltip" data-placement="top" data-original-title="Edit Request">
													<i class="fa fa-edit"></i><span>Edit</span>
												</a>
												<a data-href="<?=base_url('rfp/action/delete/'.encode($record['id']))?>" class="btn btn-3d btn-xs btn-reveal btn-red btn_delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete Request">
													<i class="fa fa-trash"></i><span>Delete</span>
												</a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else :?>
									<tr class="text-center"><td colspan="6">No Request Data</td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-12">
				<?php echo $this->pagination->create_links(); ?>	
			</div>	
		</div>
	</div>
</section>	

<script>
//$(document).on( "click",".btn_delete", function(e) {  


$(".btn_delete").click(function(e){	
	e.preventDefault();	
	var href = $(this).data('href');
	bootbox.confirm('Are you sure to delete this Request?' ,function(res){ 	 		
	    if(res) {
	        window.location.href = href;
	    }
	});
});

$(".btn_extend").click(function(e){		
	e.preventDefault();
	var lHref = $(this).attr('href');
	bootbox.confirm('Are you sure to extend validity for this Request?' ,function(res){ 	 		
	    if(res) {
	        window.location.href = lHref;
	    }
	});
});


</script>		