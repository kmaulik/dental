<?php 	
	$all_treatment_cat = [];
	if(!empty($settings)){
		$all_treatment_cat = $settings['treatment_cat'];
	}	
?>
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

		

		<div class="divider divider-color divider-center divider-short"><!-- divider -->
			<i class="fa fa-cog"></i>
		</div>

		<!-- Doctor's All favorite RFP -->
		<div class="row">
			
			<div class="alert-message"></div>

			<div class="col-md-12">
				<h4> Favorite RFP </h4>
				<hr/>
			</div>	
			<div class="col-md-12">
				<?php 
					$i = 0;
					if(count($rfp_data_fav) > 0) :
				?>
					<div class="list-group success square no-side-border search_rfp">
						<?php foreach($rfp_data_fav as $record) :?>
							<a href="<?=base_url('rfp/view_rfp/'.encode($record['id']))?>" 
							   class="list-group-item a_fav_rfp <?php if($i > 2){ echo 'hide'; }  ?> ">
								<div class="rfp-left">
									<?php if(isset($record['favorite_id']) && $record['favorite_id'] != '') : ?>
										<!-- Means Favorite RFP -->
										<span class="favorite fa fa-star favorite_rfp" data-id="<?=encode($record['rfp_id'])?>"></span>
									<?php else : ?>
										<!-- Means Not Favorite RFP -->
										<span class="favorite fa fa-star unfavorite_rfp" data-id="<?=encode($record['rfp_id'])?>"></span>
									<?php endif; ?>
									<img src="<?php if($record['avatar'] != '') 
			                    		{ echo base_url('uploads/avatars/'.$record['avatar']); } 
			                    	else 
			                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" class="avatar img-circle" alt="Avatar">								
									<span class="subject">
										<span class="label label-info"><?=ucfirst($record['dentition_type'])?></span> 
										<span class="hidden-sm hidden-xs"><?=character_limiter(strip_tags($record['title']), 70);?></span>
									</span>
								</div>	
								<div class="rfp-right">
									<?php if($record['img_path'] != '') :?>
										<span class="attachment"><i class="fa fa-paperclip"></i></span>
									<?php endif; ?>
									<span class="time"><?=date("Y-m-d H:i a",strtotime($record['created_at']));?></span>
								</div>
							</a>

						<?php $i++; ?>	
						<?php endforeach; ?>
						
						<?php if(count($rfp_data_fav) > 3) { ?>
							<br/>
							<a onclick="$('.a_fav_rfp').removeClass('hide');$(this).hide();" 
							   class="btn btn-primary text-center">
								Show More
							</a>
						<?php } ?>
					</div>					
				<?php else : ?>
					<h3>No RFP Available</h3>
				<?php endif; ?>	
			</div>	
		</div>	
		<!-- // ENDS here FAV RFPs -->

		<div class="divider divider-color divider-center divider-short"><!-- divider -->
			<i class="fa fa-cog"></i>
		</div>
		
		<!-- Doctor's All WON RFP -->
		<div class="row">
			<?php pr($won_rfps); ?>
			<div class="col-md-12">
				<h4> Won RFPs </h4>
				<hr/>
			</div>	
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>RFP Title</th>
								<th>Patient Name</th>
								<th>Patient Email</th>
								<th>Dentition Type</th>
								<th>Price</th>
								<th>Refund Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($won_rfps)) { ?>
								<?php foreach($won_rfps as $w_rfp) { ?>
									<tr>
										<td><?php echo $w_rfp['title']; ?></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td>
											<a class="btn btn-3d btn-xs btn-reveal btn-green" data-toggle="modal">
												<i class="fa fa-money"></i><span>Action</span>
											</a>
										</td>
									</tr>
								<?php } ?>
							<?php }else{ ?>
								<tr>
									<td colspan="7" class="text-center">
										<b>No data Found</b>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>	
			</div>	
		</div>	
		<!-- // ENDS here WON RFP -->

		<div class="divider divider-color divider-center divider-short"><!-- divider -->
			<i class="fa fa-cog"></i>
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
							<?php if(!empty($rfp_list)) { ?>
								<?php foreach($rfp_list as $key=>$list) { ?>
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
								<?php } ?>
							<?php }else{ ?>
								<tr>
									<td colspan="7" class="text-center">
										<b>No data Found</b>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>			
			</div>	
		</div>	
		<!-- Payment List -->

		<div class="divider divider-color divider-center divider-short"><!-- divider -->
			<i class="fa fa-cog"></i>
		</div>
		
		<!-- Alert Doctor -->
		<div class="row">
			
			<ul class="nav nav-tabs nav-top-border">
				<li class="active">
					<a href="#info" data-toggle="tab">
						RFP Search Alert
					</a>
				</li>
			</ul>
			
			<div class="tab-content margin-top-20">
				<!-- PERSONAL INFO TAB -->
				<div class="tab-pane fade in active" id="info">
					<div class="form-group">
						<label class="control-label">Treatment Category</label>							
						<select name="treatment_cat[]" class="form-control select2" id="treatment_cat" multiple data-placeholder="Select Treatment Category">
							<?php foreach($treatment_category as $t_cat) : ?>
								<option value="<?=$t_cat['id']?>"<?php if(in_array($t_cat['id'], $all_treatment_cat)){ echo 'selected'; } ?>><?=$t_cat['title']?></option>
							<?php endforeach; ?>
						</select>	
					</div>

					<div class="margiv-top10">
						<input type="hidden" name="test" value="" >
						<a onclick="save_alert_data()" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </a>
					</div>
					
					<hr/>
					
					<div class="form-group">
						<label class="control-label">
							<b> Note : </b> 
						</label>
						Save a RFp alert setting. Based on this setting you'll have notification in website and in email for yourselected search criteria.
					</div>					
				</div>
				<!-- /PERSONAL INFO TAB -->				
			</div>
		</div>
		<!-- EDNS here Alert -->

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

	function save_alert_data(){
		var treatment_cat = $('#treatment_cat').val();

		$.ajax({
			type:"POST",
			url:"<?php echo base_url().'dashboard/save_dashboard_alert'; ?>",
			data:{treatment_cat:treatment_cat},
			dataType:"JSON",
			success:function(data){
				bootbox.alert('Alert has been saved successfully.');
			}
		});
	}

	//----------------- For Add To favorite & Remove Favorite RFP ------------------
	$(".favorite").on( "click", function() {	
		
			var rfp_id= $(this).attr('data-id');
			var classNames = $(this).attr('class').split(' ');
			var data1=$(this);
			if($.inArray('unfavorite_rfp',classNames) != '-1')
			{
				bootbox.confirm('Are you sure to add favorite rfp ?' ,function(res){
					if(res){
						$.post("<?=base_url('rfp/add_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
							if(data){
								data1.removeClass('unfavorite_rfp');
								data1.addClass('favorite_rfp');
								$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP added to your favorite list successfully.</div>');
							}
						});
					}	
				});
			}
			else{
				bootbox.confirm('Are you sure to remove favorite rfp ?' ,function(res){
					if(res){	
						$.post("<?=base_url('rfp/remove_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
							if(data){
								data1.removeClass('favorite_rfp');
								data1.addClass('unfavorite_rfp');
								$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP removed to your favorite list successfully. </div>');
							
							}
						});
					}
				});
			}
		return false;
	});
</script>