<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/media/fancybox.min.js"></script>

<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/gallery.js"></script>

<style>
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
	padding: 12px !important;
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
label {
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
.col_custom .thumbnail {
    float: left;
    margin-right: 10px;
}
.manual_category{
	padding-left: 40px;
}
</style>

<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - <?php echo $heading; ?></h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
			<li><a href="<?php echo site_url('admin/rfp'); ?>">RFP</a></li>
			<li class="active"><?php echo $heading; ?></li>
		</ul>
	</div>
</div>
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-flat">
				<div class="panel-body">
					<!--  Basic Details  -->
					<div class="rfp-basic">
						<h4 class="rfp-title">Basic Details</h4>
						<div class="col-sm-6">
							<label>RFP Title : </label> <?=$record['title']?>
						</div>
						<div class="col-sm-6">
							<label>Created By : </label> <?=fetch_username($record['patient_id'])?>
						</div>
						<div class="col-sm-6">
							<label>First Name : </label> <?=$record['fname']?>
						</div>	
						<div class="col-sm-6">
							<label>Last Name : </label> <?=$record['lname']?>
						</div>
						<div class="col-sm-6">
							<label>BirthDate : </label> <?=$record['birth_date']?>
						</div>
						<div class="col-sm-6">
							<label>Dentition Type : </label> <?=$record['dentition_type']?>
						</div>
						<div class="col-sm-6">
							<label>RFP Status : </label> 
							<?php if($record['status'] == 0) :?>
								<span class="label label-default">Draft</span>
							<?php elseif($record['status'] == 1) : ?>
								<span class="label label-primary">Pending</span>
							<?php elseif($record['status'] == 2) : ?>
								<span class="label label-danger">Invalid</span>
							<?php elseif($record['status'] == 3) : ?>
								<span class="label label-info">Open</span>
							<?php elseif($record['status'] == 4) : ?>
								<span class="label label-success">Close</span>			
							<?php endif; ?>
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
						
						<?php 
						if(isset($record['teeth_data'])) { $teeth_arr=json_decode($record['teeth_data']); $teeth_arr1=array_keys((array)$teeth_arr); }
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
														<div class="checkbox">
															<label>
																<input type="checkbox" disabled value="<?=chr($k+$i);?>" name="teeth[]" class="styled" <?php if(in_array(chr($k+$i),$teeth_arr1)) { echo "checked"; }?>><?=chr($k+$i);?>
															</label>
														</div>
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
														<div class="checkbox">
															<label>
																<input type="checkbox" disabled value="<?=chr($k-$i);?>" name="teeth[]" class="styled" <?php if(in_array(chr($k-$i),$teeth_arr1)) { echo "checked"; }?>><?=chr($k-$i);?>
															</label>
														</div>
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
														<div class="checkbox">
															<label>
																<input type="checkbox" disabled value="<?=$i?>" name="teeth[]" class="styled" <?php if(in_array($i,$teeth_arr1)) { echo "checked"; }?>><?=$i?>
															</label>
														</div>
													</td>
													<?php endfor;?>
												</tr>
												<tr>
													<?php for($i=32;$i>16;$i--) : ?>
													<td>
														<div class="checkbox">
															<label>
																<input type="checkbox" disabled value="<?=$i?>" name="teeth[]" class="styled" <?php if(in_array($i,$teeth_arr1)) { echo "checked"; }?>><?=$i?>
															</label>
														</div>
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

						<?php if(!empty($teeth_arr)) : ?>
							<?php foreach($teeth_arr as $key=>$val) :?>
								<!-- ===== For Tratment Category === -->
								<div class="col-sm-12">
									<label>Treatment Category For Teeth : <?=$key?></label> 
									<ul>
										<?php if(isset($val->cat_id)) :?>
											<?php foreach($val->cat_id as $category) :?>
												<li><?= fetch_row_data('treatment_category',['id' => $category],'title') ?></li>
											<?php endforeach; ?>
										<?php else : ?>
											<li> N/A</li>	
										<?php endif; ?>	
									</ul>
								</div>
								<!-- ===== End Tratment Category === -->
								<!-- ===== For Check Manual Category Exist or not === -->
								<?php if($val->cat_text != '') :?>
								<div class="col-sm-12 manual_category">
									<label>Manual Category For Teeth : <?=$key?></label> 
										<?= $val->cat_text;?>
								</div>	
								<?php endif; ?>
								<!-- ===== End Check Manual Category Exist or not === -->
							<?php endforeach; ?>
						<?php endif; ?>

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
								<?php foreach($attach_arr as $attach) : ?>
									<div class="thumbnail">
										<div class="thumb">
											<?php $ext=explode(".",$attach); 
											if(isset($ext) && $ext[1] == 'pdf') { ?>
											<img src="<?=DEFAULT_IMAGE_PATH.'document-file.jpg'?>" alt="" style="height:150px;width:150px;">
											<?php } else { ?>
											<img src="<?=base_url('uploads/rfp/'.$attach)?>" alt="" style="height:150px;width:150px;">
											<?php } ?>
											<div class="caption-overflow">
												<span>
													<?php if(isset($ext) && $ext[1] != 'pdf') { ?>
													<a href="<?=base_url('uploads/rfp/'.$attach)?>" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>
													<?php } ?>
													<a href="<?=base_url('uploads/rfp/'.$attach)?>" target="_blank" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-link2"></i></a>
												</span>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<?php else : ?>
								N/A	
							<?php endif;?>
						</div>

					</div>	
					<!-- /Additional Section  -->	

					<!--  Financial Information  -->
					<div class="rfp-history">
						<h4 class="rfp-title">Financial Information</h4>
						<div class="col-sm-12">
							<label>Insurance Provider : </label> 
							<?php if($record['insurance_provider'] != '') 
							{	echo $record['insurance_provider'];	} 
							else
							{	echo "N/A";	}	
							?>
						</div>
						<div class="col-sm-12">
							<label>Treatment Plan Total : <?php if($record['treatment_plan_total'] != '') 
							{	echo "$ ".$record['treatment_plan_total'];	} 
							else
							{	echo "N/A";	}	
							?></label> 
						</div>
					</div>	
					<!--  /Financial Information  -->
					
				</div>
			</div>
		</div>
	</div>
</div>
