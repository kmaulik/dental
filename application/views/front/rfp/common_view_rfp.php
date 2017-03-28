<div class="col-md-12">
	<div class="panel panel-flat">
		<div class="panel-body">
			<!--  Basic Details  -->
			<div class="rfp-basic">
				<h4 class="rfp-title">Basic Details
					<!-- For check Rfp created by = session id && status < 3 (open)  then display edit button-->
					<?php if($this->session->userdata['client']['id'] == $record['patient_id'] && $record['status'] < 3): ?>
						<a href="<?=base_url('rfp/edit/'.encode($record['id']))?>" class="pull-right"><i class="fa fa-edit"></i> Edit</a>	
					<?php endif; ?>

				</h4>
				<!-- <div class="col-sm-12">
					<span class="title">RFP Title : </span> <span><?=$record['title']?></span>
				</div> -->
				<div class="col-sm-6">
					<span class="title">Created By : </span> <span><?=fetch_username($record['patient_id'])?></span>
				</div>
				<div class="col-sm-6">
					<span class="title">Patient Name : </span> <span><?=$record['fname']." ".$record['lname']?></span>
				</div>	
				<div class="col-sm-6">
					<span class="title">BirthDate : </span> 
					<span>
						<?=date("m-d-Y",strtotime($record['birth_date']));?>
					</span>
				</div>
				<div class="col-sm-6">
					<span class="title">Dentition Type : </span> <span><?=$record['dentition_type']?></span>
				</div>
				<div class="col-sm-6">
					<span class="title">Zip Code : </span> <span><?=$record['zipcode']?></span>
				</div>
				<div class="col-sm-6">
					<span class="title">Age : </span>
					<span>
						<?php
							$birthday = new DateTime($record['birth_date']);
							$interval = $birthday->diff(new DateTime);
							echo $interval->y.' years';
						?>
					</span>
				</div>
				<!-- ======= For Display distance to doctor ======= -->
				<?php if(isset($record['distance'])) :?>
					<div class="col-sm-6">
						<span class="title">Distance (Miles) : </span>
						<span><?=round($record['distance'],2)?></span>
					</div>
				<?php endif; ?>
				<!-- ======= End For Display distance to doctor ======= -->
				<?php 
					if(!empty($rfp_bid)) {						
				?>
					<div class="col-sm-6">						
						<span class="title">Bid amount : </span>
						<span><?php echo '$ '.$rfp_bid['amount']; ?></span>
					</div>

					<div class="col-sm-12 bid-title">						
						<br/>					
						<span class="title">Bid Description : </span>
						<span><?php echo $rfp_bid['description']; ?></span>
					</div>

				<?php } ?>
				

			</div>	
			<!--  /Basic Details  -->

			<!--  Medical History  -->
			<div class="rfp-history">
				<h4 class="rfp-title">Medical History</h4>
				<div class="col-sm-12">
					<label>Known Allergies : </label><span> <?=$record['allergies']?></span>
				</div>
				<div class="col-sm-12">
					<label>Full Medication List : </label><span> <?=$record['medication_list']?></span>
				</div>
				<div class="col-sm-12">
					<label>Any heart problems including blood pressure? : </label> <span><?=$record['heart_problem']?><span>
				</div>
				<div class="col-sm-12">
					<label>Any history of chemo/radiation ? : </label><span> <?=$record['chemo_radiation']?></span>
				</div>	
				<div class="col-sm-12">
					<label>Surgery occurred during the last two years. : </label><span> <?=$record['surgery']?></span>
				</div>
			</div>	
			<!--  /Medical History  -->

			<!--  Treatment Plan  -->
			<div class="rfp-treatment">
				<h4 class="rfp-title">Treatment Plan
					<!-- For check Rfp created by = session id && status < 3 (open)  then display edit button-->
					<?php if($this->session->userdata['client']['id'] == $record['patient_id'] && $record['status'] < 3): ?>
						<a href="<?=base_url('rfp/edit/'.encode($record['id']).'/1')?>" class="pull-right"><i class="fa fa-edit"></i>Edit</a>
					<?php endif;?>
				</h4>
				<?php $teeth_arr1=array(); ?>						
				<?php if(isset($record['teeth_data'])) { $teeth_arr=json_decode($record['teeth_data']); $teeth_arr1=array_keys((array)$teeth_arr); } ?>
				
				<!-- For Teeth Image -->
				<div class="col-sm-12">
					<div class="teeth-bg">
						<?php for($i=1;$i<=32;$i++) : ?>
							<span id="t<?=$i?>">
								<span class="checkbox-wrapper">
									<label>
										<input type="checkbox" disabled value="<?=$i?>" name="teeth[]" class="toggle_cat" <?php if(in_array($i,$teeth_arr1)) { echo "checked"; }?>>
										<span class="checked-bg"></span>
									</label>
								</span>
							</span>
						<?php endfor; ?>
					</div>
				</div>
				<!-- End For Teeth Image -->

					<!-- <div class="col-sm-12">
						<div class="table-responsive">	
								<table class="table table-bordered teeth">
									<thead>
										<tr>
											<th colspan="16">Permanent Dentition</th>
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
												<label class="checkbox">
													<input type="checkbox" disabled value="<?=$i?>" name="teeth[]" <?php if(in_array($i,$teeth_arr1)) { echo "checked"; }?>><i></i><?=$i?>
												</label>
											</td>
											<?php endfor;?>
										</tr>
										<tr>
											<?php for($i=32;$i>16;$i--) : ?>
											<td>
												<label class="checkbox">
													<input type="checkbox" disabled value="<?=$i?>" name="teeth[]" <?php if(in_array($i,$teeth_arr1)) { echo "checked"; }?>><i></i><?=$i?>
												</label>
											</td>
											<?php endfor;?>
										</tr>
									</tbody>	
								</table>
						</div>	
					</div> -->
				<!-- Other Treatment Category Type -->	
			
					
					<!-- ===== For Other Treatment Category === -->
					<!-- <div class="col-sm-12">
						<label>Treatment Category</label>
						<ul>
							<?php $other_category=explode(",",$record['other_treatment_cat_id']); ?>
							<?php if(count($other_category) > 0) :?>
								<?php foreach($other_category as $category) :?>
									<li><?= fetch_row_data('treatment_category',['id' => $category],'title') ?> [<?= fetch_row_data('treatment_category',['id' => $category],'code') ?>]</li>
								<?php endforeach; ?>
							<?php else : ?>
								<li> N/A</li>
							<?php endif;?>	
						</ul>
					</div> -->
					<!-- ===== End Other Treatment Category === -->	
					<!-- ===== For Check Other Manual Category Exist or not === -->
					
					<!-- <div class="col-sm-12 manual_category">
						<label>Manual Category</label> 
							<?= $record['other_treatment_cat_text'];?>
					</div>	 -->
					
					<!-- ===== End Check Other Manual Category Exist or not === -->
			
				<!-- End Other Treatment Category Type -->	

				<?php if(!empty($teeth_arr)) : ?>
					<?php foreach($teeth_arr as $key=>$val) :?>
						<!-- ===== For Tratment Category === -->
						<div class="col-sm-12">
							<label>Treatment Category For Teeth : <?=$key?></label> 
							<ul>
								<?php if(isset($val->cat_id)) :?>
									<?php foreach($val->cat_id as $category) :?>
										<li><?= fetch_row_data('treatment_category',['id' => $category],'title') ?> [<?= fetch_row_data('treatment_category',['id' => $category],'code') ?>]</li>
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

				<div class="col-sm-12">
					<label>Treatment Description : </label> <?php if($record['other_description'] != '') { echo $record['other_description']; } else { echo 'N/A'; } ?> 	
				</div>

			</div>	
			<!--  /Treatment Plan  -->

			<!--  Additional Section -->
			<div class="rfp-additional">
				<h4 class="rfp-title">Additional Section</h4>
				<div class="col-sm-12">
					<label>Further Information for our Agents : </label><?php if($record['message'] != '') { echo $record['message']; } else { echo 'N/A'; } ?> 
				</div>
				
				<div class="col-sm-12 col_custom">
					<label>Attachment : </label>
					<?php $attach_arr= explode("|",$record['img_path']);
					// Check Attachment found or not 
					if(isset($attach_arr[0]) && $attach_arr[0] != '') : ?>
					<div class="text-center">
						<div class="owl-carousel owl-padding-1 nomargin buttons-autohide controlls-over" data-plugin-options='{"singleItem": false, "items": "3", "autoPlay": 3500, "navigation": true, "pagination": false}'>
							<?php foreach($attach_arr as $attach) : ?>
								<div class="item-box">
									<figure>
										<span class="item-hover">
											<span class="overlay dark-5"></span>
											<span class="inner">

												<!-- lightbox -->
												<?php $ext=explode(".",$attach);  
												if(isset($ext) && $ext[1] != 'pdf') { ?>
													<a class="ico-rounded lightbox" href="<?=base_url('uploads/rfp/'.$attach)?>" data-plugin-options='{"type":"image"}'>
														<span class="fa fa-plus size-20"></span>
													</a>
												<?php } ?>
												<!-- details -->
												<a class="ico-rounded" href="<?=base_url('uploads/rfp/'.$attach)?>" target="_blank">
													<span class="glyphicon glyphicon-option-horizontal size-20"></span>
												</a>
											</span>
										</span>
										
										<?php if(isset($ext) && $ext[1] == 'pdf') { ?>
										<img class="img-responsive" src="<?=DEFAULT_IMAGE_PATH.'document-file.jpg'?>" width="600" height="399" alt="">	
										<?php } else { ?>
										<img class="img-responsive" src="<?=base_url('uploads/rfp/'.$attach)?>" width="600" height="399" alt="">
										<?php } ?>
									</figure>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<?php else : ?>
						N/A	
					<?php endif;?>
				</div>

			</div>	
			<!-- /Additional Section  -->	

			<!--  Financial Information  -->
			<div class="rfp-history rfp-info">
				<h4 class="rfp-title">Financial Information
					<!-- For check Rfp created by = session id && status < 3 (open)  then display edit button-->
					<?php if($this->session->userdata['client']['id'] == $record['patient_id'] && $record['status'] < 3): ?>
						<a href="<?=base_url('rfp/edit/'.encode($record['id']).'/2')?>" class="pull-right"><i class="fa fa-edit"></i>Edit</a>
					<?php endif;?>
				</h4>
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