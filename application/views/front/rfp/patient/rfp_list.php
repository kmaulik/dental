<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/notifications/bootbox.min.js"></script>
<section class="page-header page-header-xs">
	<div class="container">
		<h1>RFP List</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li class="active">RFP List</li>
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
			<i class="fa fa-plus"></i><span>Create RFP</span>
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
						<td>
							<?php if($record['status'] == 0) :?>
								<span class="label label-default">Draft</span>
							<?php elseif($record['status'] == 1) : ?>
								<span class="label label-primary">Pending</span>
							<?php elseif($record['status'] == 2) : ?>
								<span class="label label-danger">Submit Pending</span>
							<?php elseif($record['status'] == 3) : ?>
								<span class="label label-info">Open</span>
							<?php elseif($record['status'] == 4) : ?>
								<span class="label label-warning">In-Progress</span>			
							<?php elseif($record['status'] == 5) : ?>
								<span class="label label-success">Close</span>			
							<?php endif; ?>
						</td>
						<td><?=$record['dentition_type']?></td>
						<td>
							<a href="<?=base_url('rfp/view_rfp/'.encode($record['id']))?>" class="btn btn-3d btn-xs btn-reveal btn-info">
								<i class="fa fa-eye"></i><span>View</span>
							</a>
							<!-- ==== Check Status (0=draft,1=pending,2=submit Pending) then show edit option -->
							<?php if($record['status'] == 0 || $record['status'] == 1 || $record['status'] == 2) : ?>
								<a href="<?=base_url('rfp/edit/'.encode($record['id']))?>" class="btn btn-3d btn-xs btn-reveal btn-green">
									<i class="fa fa-edit"></i><span>Edit</span>
								</a>
							<?php endif; ?>
							<a data-href="<?=base_url('rfp/action/delete/'.encode($record['id']))?>" class="btn btn-3d btn-xs btn-reveal btn-red btn_delete" >
								<i class="fa fa-trash"></i><span>Delete</span>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else :?>
			<tr class="text-center"><td colspan="6">No RFP Data</td></tr>
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


$(".btn_delete").click(function(){		
	var href = $(this).data('href');
	bootbox.confirm('Are you sure to delete this rfp?' ,function(res){ 	 		
	    if(res) {
	        window.location.href = href;
	    }
	});
});


</script>		