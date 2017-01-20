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
						<th>Dentition Type</th>
						<th>Action</th>
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
						<td><?=$record['dentition_type']?></td>
						<td>
							<a href="<?=base_url('rfp/edit/'.encode($record['id']))?>" class="btn btn-3d btn-xs btn-reveal btn-green">
								<i class="fa fa-edit"></i><span>Edit</span>
							</a>
							<a href="<?=base_url('rfp/action/delete/'.encode($record['id']))?>" class="btn btn-3d btn-xs btn-reveal btn-red btn_delete">
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
$(document).on( "click",".btn_delete", function(e) {    
    if(confirm('Are you sure ?')) 
    {
        return true;
    } else{
    	return false;
    }    
});
</script>		