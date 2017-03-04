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
							<a href="<?=base_url('rfp/view_rfp/'.encode($record['rfp_id']))?>" 
							   class="list-group-item a_fav_rfp <?php if($i > 2){ echo 'hide'; }  ?> ">
								<div class="rfp-left">									
									<!-- Means Favorite RFP -->
									<span class="favorite fa fa-star favorite_rfp" data-id="<?=encode($record['rfp_id'])?>"></span>																										
									
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
			<?php //pr($won_rfps); ?>
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
								<!-- <th>Patient Name</th> -->
								<th>Patient Email</th>
								<th>Dentition Type</th>
								<th>Treatment Plan Amount</th>
								<th>Bid Price</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if(!empty($won_rfps)) { 
									foreach($won_rfps as $w_rfp) {
										
										$amt = $w_rfp['amount']; // Bid price
										
										$percentage = config('doctor_fees');
										$payable_price = ($percentage * $amt)/100; // calculate 10% againts the bid of doctor

										$is_second_due = 1;
										$due_1 = config('doctor_initial_fees');
										$due_2 = 0;
										$is_second_due = 0;

										if($payable_price > $due_1){
											$due_2 = $payable_price - $due_1;
											$is_second_due = 1;
										}else{
											$payable_price = $due_1;
										}
							?>
									<tr>
										<td>
											<?php echo $w_rfp['title']; ?>
										</td>
										<!-- <td>
											<?php echo ucfirst($w_rfp['fname']).' '.$w_rfp['lname']; ?>
										</td> -->
										<td>
											<?php echo $w_rfp['email_id']; ?>
										</td>
										<td><?php echo ucfirst($w_rfp['dentition_type']); ?></td>
										<td><?php echo ucfirst($w_rfp['treatment_plan_total']); ?></td>
										<td><?php echo ucfirst($w_rfp['amount']); ?></td>
										<td>

										</td>
										<td>
											<a class="btn btn-3d btn-xs btn-reveal btn-green"
											   data-is-second-due="<?php echo $is_second_due; ?>"
											   data-due-one="<?php echo $due_1; ?>"
											   data-due-two="<?php echo $due_2; ?>"
											   data-total-due="<?php echo $payable_price; ?>"
											   data-mybid="<?php echo $amt; ?>"
											   data-rfpid="<?php echo encode($w_rfp['rfp_id']); ?>"
											   onclick="show_modal_doctor(this)" >
												<i class="fa fa-money"></i><span>Proceed </span>
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

		<div class="divider divider-color divider-center divider-short">
			<!-- divider -->
			<i class="fa fa-cog"></i>
		</div>
		
		<!-- Payment Table -->
		<!-- <div class="row">
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
		</div> -->	
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


<!-- ==================== Modal Popup For Apply Promotional Code ========================= -->
<div class="modal fade doctor_payment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Proceed with your payment for won RFP</h4>
			</div>
			<form action="<?=base_url('rfp/make_doctor_payment')?>" method="POST" id="form_doctor_payment">							
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h4>
									Your Bid : $ <span class="my_bid"></span>
								</h4>
							</div>	
						</div>

						<div class="col-sm-8 margin-bottom-10">	
														
							<span class="clearfix due_1">
								<span class="pull-right due_1_price">$0.00</span>
								<span class="pull-left">Due payment 1 (will deduct instantly):</span>
							</span>

							<span class="clearfix due_2">
								<span class="pull-right due_2_price">$0.00</span>
								<span class="pull-left">Due payment 2 (will deduct after 45 days):</span>
							</span>
							
							<hr>

							<span class="clearfix">
								<span class="pull-right size-20 total-price">									
									
								</span>
								<strong class="pull-left">TOTAL:</strong>
							</span>																	
						</div>

						<br/>
						<br/>

						<div class="col-sm-12">
							<div class="form-group">
								<label>Coupon Code</label>
								<div class="fancy-file-upload fancy-file-success">
									<input type="text" class="form-control" name="coupan_code" id="coupan_code"/>
									<span class="button" id="apply-code">Apply Code</span>
								</div>
								<span class="coupan-msg"></span>
							</div>
						</div>

						<!-- <div class="col-sm-12">
							<div class="form-group">
								<h4>Final Price : $ <span class="final-prices"><?=config('patient_fees')?></span></h4>
							</div>
						</div>	 -->					
					</div>	
				</div>
				<!-- body modal -->
				<div class="modal-footer">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="hidden" name="due_1" id="due_1_id">
							<input type="hidden" name="due_2" id="due_2_id">							
							<input type="hidden" name="rfp_id" id="rfp_id_frm">
							<input type="hidden" name="total_due_modal" id="total_due_modal">
							<input type="hidden" name="orignal_price" id="orignal_price">
							<input type="hidden" name="is_coupon_applied" id="is_coupon_applied" value="0" >
							<input type="submit" name="submit" class="btn btn-info" value="Make Payment">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>	
					</div>	
				</div>	
			</form>

		</div>
	</div>
</div>

<!-- ================== /Modal Popup For Place a Bid ========================= -->		

<script type="text/javascript">

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
		if($.inArray('unfavorite_rfp',classNames) != '-1'){				
			$.post("<?=base_url('rfp/add_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
				if(data){
					data1.removeClass('unfavorite_rfp');
					data1.addClass('favorite_rfp');
					$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP added to your favorite list successfully.</div>');
				}
			});
		} else {
			$.post("<?=base_url('rfp/remove_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
				if(data){
					data1.removeClass('favorite_rfp');
					data1.addClass('unfavorite_rfp');
					$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP removed to your favorite list successfully. </div>');
				
				}
			});
		}
		return false;
	});
	
	function show_modal_doctor(obj){

		var is_second_due= $(obj).data('is-second-due');
		var due_1= $(obj).data('due-one');
		var due_2= $(obj).data('due-two');
		var mybid= $(obj).data('mybid');
		var rfp_id = $(obj).data('rfpid');
		var total_due = $(obj).data('total-due');

		var total_payment = parseFloat(due_1) + parseFloat(due_2);

		$('.my_bid').html(mybid);
		$('.due_1_price').html('$ '+due_1);
		$('.due_2_price').html('$ '+due_2);

		$('#due_1_id').val(due_1);
		$('#due_2_id').val(due_2);
		$('#rfp_id_frm').val(rfp_id);
		$('#total_due_modal').val(total_due);

		$('.total-price').html('$ '+total_payment);
		
		$(".coupan-msg").html("");
		$('#coupan_code').val('');
		$('#is_coupon_applied').val('0');
		$('.doctor_payment').modal('show');			
	}

	$("#apply-code").click(function(){
		$(".coupan-msg").html('');
		var coupan_code = $("#coupan_code").val();
		if(coupan_code != ''){
			
			var discount_amt=0;

			$.post("<?=base_url('rfp/fetch_coupan_data')?>",{'coupan_code' : coupan_code},function(data){

				if(data != 0){
					var is_coupon_appiled = $('#is_coupon_applied').val();
					// If coupon code is limit is exceed than allowed no of times
					if(data['per_user_limit'] > data['total_apply_code'] && is_coupon_appiled == '0'){
							
						var total = parseFloat($('#total_due_modal').val());
						var intial_payment = '<?php echo config("doctor_initial_fees"); ?>'; // fetch initial value from db

						discount_amt = 	((total * data['discount'])/100);
						var after_discount = total - discount_amt;						
					 	
						if(after_discount > parseFloat(intial_payment)){
							due_1 = parseFloat(intial_payment);
							due_2 = after_discount - due_1;
						}else{
							due_1 = after_discount;
							due_2 = 0
						}
							
						$('.due_1_price').html('$ '+due_1);
						$('.due_2_price').html('$ '+due_2);

						$('#due_1_id').val(due_1);
						$('#due_2_id').val(due_2);

						$('#orignal_price').val(total); // orignal price
						$('#total_due_modal').val(after_discount); // after discount price						
						$('.total-price').html('$ '+ after_discount);

						$('#is_coupon_applied').val('1');
						$(".coupan-msg").html("Coupon Code apply successfully");
						$(".coupan-msg").css("color", "green");
					}else{
						$(".coupan-msg").html("Sorry, You've already applied this code.");
						$(".coupan-msg").css("color", "red");
					}
				}else{
					$(".coupan-msg").html("Invalid Coupon Code");
					$(".coupan-msg").css("color", "red");
				}

			},"json");
		}else{
			$(".coupan-msg").html("Please Enter Coupon Code");
			$(".coupan-msg").css("color", "red");	
		}
	});

</script>