<!--<style>
.list-group-item .avatar {
    width: 40px;
    height: 40px;
    margin: 0 10px;
}
span.favorite {
    margin: 0 5px;
}
span.favorite_rfp{
	color: #1980B6;
}
span.unfavorite_rfp{
	color: #555555;
}
span.name {
    width: 100px;
    position: relative;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-weight: 700;
    margin: 0 10px;
}
span.subject {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin: 0 10px;
}
span.attachment {
    float: right;
    position: absolute;
    right: 85px;
    top: 20px;
    text-align: right;
}
span.time {
    float: right;
    width: 80px;
    position: absolute;
    right: 10px;
    top: 20px;
    text-align: right;
    font-size: 13px;
}
@media (max-width:479px){
.rfp-right {
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
    text-align: center;
}
.rfp-right span.attachment {
    float: none;
    position: relative;
    right: 0;
    top: 0;
    text-align: right;
    margin-right: 10px;
}
.rfp-right span.time {
    float: none;
    width: 80px;
    position: relative;
    right: 0;
    top: 0;
    text-align: right;
    font-size: 13px;
}
.rfp-left span.name {
    width: 100%;
    position: relative;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-weight: 700;
    margin: 0 10px;
    display: block;
    text-align: center;
}
.rfp-left span.subject {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin: 0 10px;
    text-align: center;
    margin: 5px auto;
    display: inline-block;
    width: 100%;
}

.list-group-item .rfp-left .avatar {
    width: 40px;
    height: 40px;
    margin: 0 auto;
    display: block;

}
}
</style>-->  
<section class="page-header page-header-xs">
	<div class="container">
		<h1>Search RFP</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard');?>">Home</a></li>
			<li class="active">Search RFP</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>

<!-- -->
<section>
	<div class="container">

		<div class="row">
			<!-- Custom ALERT -->
			<div class="alert-message"></div>
			<!-- /Custom ALERT -->	
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
				<form action="" method="GET" id="search_rfp">
					<!-- =========== For Saved Filter =================== -->
					<div class="row">
						<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
							<label>Saved Filter </label>
							<select name="saved_filter" class="form-control" id="saved_filter">
								<option value="">Select Saved Filter</option>
								<?php foreach($search_filter_list as $search_filter) : ?>
									<option value="<?=$search_filter['id']?>" <?php if($this->input->get('saved_filter') != '' && $search_filter['id'] == $this->input->get('saved_filter')) { echo "selected"; } ?>><?=$search_filter['filter_name']?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
							<label class="space">&nbsp;</label>
							<a class="btn btn-success filter_btn" onclick="saved_filter()">Save Filter</a>
						</div>
					</div>
					<!-- ================== End for saved filter ============= -->	
					<div class="row">	
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Filter Data</label>
							<div class="form-group">
								<div class="fancy-form"><!-- input -->
									<i class="fa fa-search"></i>
									<input type="text" name="search" id="search" class="form-control" placeholder="Search RFP Title, Dentition Type Wise" value="<?=$this->input->get('search') ? $this->input->get('search') :''?>">
									<span class="fancy-tooltip top-left"> <!-- positions: .top-left | .top-right -->
										<em>Search RFP From Here</em>
									</span>
								</div>
							</div>
						</div>
						<!-- <div class="col-lg-3 col-md-5">
							<label>Filter Date Wise</label>
							<input type="text" name="date" id="filter_date" class="form-control rangepicker" value="<?=$this->input->get('date') ? $this->input->get('date') :''?>" data-format="yyyy-mm-dd" data-from="2015-01-01" data-to="2016-12-31" readonly>
						</div> -->
						<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 sorting">
							<label>Sort</label>
							<select name="sort" class="form-control" id="sort">
								<option value="desc">Latest RFP</option>
								<option value="asc">Oldest RFP</option>
							</select>
						</div>	
						<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 sorting">
							<label>Bid</label>
							<select name="bid_search" class="form-control" id="bid_search">
								<option value="All">All</option>
								<option value="Include">Include Bid</option>
								<option value="Exclude">Exclude Bid</option>
							</select>
						</div>	
						<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 sorting">
							<label>Favorite</label>
							<select name="favorite_search" class="form-control" id="favorite_search">
								<option value="All">All</option>
								<option value="Include">Include Favorite</option>
								<option value="Exclude">Exclude Favorite</option>
							</select>
						</div>	
						<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
							<label>Treatment Category </label>
							<select id="treatment_cat_id" class="form-control select2" name="treatment_cat_id[]" data-placeholder="Select Treatment Category" multiple>
								<?php foreach($treatment_category as $cat) :?>
									<option value="<?=$cat['id']?>" <?php if($this->input->get('treatment_cat_id') != '' && in_array($cat['id'],$this->input->get('treatment_cat_id'))) { echo "selected"; } ?>><?=$cat['title']." (".$cat['code'].")"?></option>
								<?php endforeach;?>
							</select>		
						</div>
						<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
							<label class="space">&nbsp;</label>
							<input type="submit" name="btn_search" class="btn btn-info btn_search" value="Search">
							<input type="reset" name="reset" class="btn btn-default" value="Reset" id="reset">
						</div>

					</div>	
				</form>
					
				<?php if(count($rfp_data) > 0) :?>
							
						<!-- <div class="list-group success square no-side-border search_rfp">
							<?php foreach($rfp_data as $record) :?>
								<a href="<?=base_url('rfp/view_rfp/'.encode($record['id']))?>" class="list-group-item">
								<div class="rfp-left">
									<?php if(isset($record['favorite_id']) && $record['favorite_id'] != '') : ?>
										<span class="favorite fa fa-star favorite_rfp" data-id="<?=encode($record['id'])?>" title="Favorite RFP"></span>
									<?php else : ?>
										<span class="favorite fa fa-star unfavorite_rfp" data-id="<?=encode($record['id'])?>" title="Favorite RFP"></span>
									<?php endif; ?>
									<img src="<?php if($record['avatar'] != '') 
			                    		{ echo base_url('uploads/avatars/'.$record['avatar']); } 
			                    	else 
			                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" class="avatar img-circle" alt="Avatar">
									<span class="name"><?=$record['fname']." ".$record['lname'];?></span>
									<span class="subject">
										<span class="label label-info"><?=ucfirst($record['dentition_type'])?></span> 
										<span class="hidden-sm hidden-xs"><?=character_limiter(strip_tags($record['title']), 70);?></span>
									</span>
									<span class="distance">(<?=round($record['distance'],2)." Miles"?>)</span>
									<?php if($record['bid_amt'] != '') :?>
										<span class="bid_amt label label-info">$ <?=$record['bid_amt']?></span>
									<?php endif;?>
									<span class="total_bid label label-success">Total Bid : <?=$record['total_bid']?></span>
								</div>	
								<div class="rfp-right">
									<?php if($record['img_path'] != '') :?>
										<span class="attachment"><i class="fa fa-paperclip"></i></span>
									<?php endif; ?>
									<span class="time"><?=date("m-d-Y H:i a",strtotime($record['created_at']));?></span>
								</div>
								</a>
							<?php endforeach; ?>	
						</div> -->

						<!-- ======== Table View For RFP Search ============= -->
						<div class="table-responsive rfp_doctor_search">
							<table class="table">
								<thead>
									<th>Favorite</th>									
									<th>RFP #</th>
									<th>RPF Title</th>
									<th>Age</th>
									<th>Distance (Miles.)</th>
									<th>Bid Amt ($)</th>
									<th>Total Bid</th>
									<th>Remaining Days</th>
									<!-- <th>Created On</th> -->
								</thead>
								<tbody>
									<?php foreach($rfp_data as $record) :?>
										<tr>
											<td>
												<?php if(isset($record['favorite_id']) && $record['favorite_id'] != '') : ?>
													<!-- Means Favorite RFP -->
													<span class="favorite fa fa-star favorite_rfp" data-id="<?=encode($record['id'])?>" title="Favorite RFP"></span>
												<?php else : ?>
													<!-- Means Not Favorite RFP -->
													<span class="favorite fa fa-star unfavorite_rfp" data-id="<?=encode($record['id'])?>" title="Favorite RFP"></span>
												<?php endif; ?>
											</td>																			
											<td class="search_rfp_info" data-rfp-id="<?=encode($record['id'])?>"><?=$record['id']?></td>
											<td class="search_rfp_info" data-rfp-id="<?=encode($record['id'])?>"><?=character_limiter(strip_tags($record['title']), 70);?></td>
											<td class="search_rfp_info" data-rfp-id="<?=encode($record['id'])?>"><?=$record['patient_age']?></td>
											<td class="search_rfp_info" data-rfp-id="<?=encode($record['id'])?>"><?=round($record['distance'],2)?></td>
											<td class="search_rfp_info" data-rfp-id="<?=encode($record['id'])?>">
												<?php if($record['bid_amt'] != '') :?>
													<?=$record['bid_amt']?>
												<?php else :?>
													-	
												<?php endif;?>
											</td>
											<td class="search_rfp_info" data-rfp-id="<?=encode($record['id'])?>"><span class="total_bid label label-success"><?=$record['total_bid']?></span></td>
											<td class="search_rfp_info" data-rfp-id="<?=encode($record['id'])?>"><?=$record['rfp_valid_days']+1?></td>
											<!-- <td class="search_rfp_info" data-rfp-id="<?=encode($record['id'])?>">
												<span class=""><?=date("m-d-Y H:i a",strtotime($record['created_at']));?></span>
											</td> -->
										</tr>	
									<?php endforeach; ?>
								</tbody>	
							</table>	
						</div>	
						<!-- ======== End Table View For RFP Search ========= -->
			
					<?php echo $this->pagination->create_links(); ?>
				<?php else : ?>
					<h3>No RFP Available</h3>
				<?php endif; ?>	
			</div>
		</div>
	</div>
</section>


<!-- ==================== Modal Popup For Saved Filter ========================= -->
<div class="modal fade saved_filter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">Save Filter</h4>
			</div>
			<form action="<?=base_url('rfp/save_filter_data')?>" method="POST" id="frm_save_filter">
				<input type="hidden" name="search_filter_id" id="search_filter_id">
				<input type="hidden" name="search_filter_name" id="search_filter_name">
				<input type="hidden" name="search_data" id="search_data">
				<input type="hidden" name="search_date" id="search_date">
				<input type="hidden" name="search_sort" id="search_sort">
				<input type="hidden" name="search_bid" id="search_bid">
				<input type="hidden" name="search_favorite" id="search_favorite">
				<input type="hidden" name="search_treatment_cat_id" id="search_treatment_cat_id">
				
				<!-- body modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Filter Name</label>
								<input type="text" id="filter_name" class="form-control" name="filter_name">
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
<!-- ================== /Modal Popup For Saved Filter ========================= -->	
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/validate.min.js"; ?>"></script>
<script>

$(document).ready(function() {

	//------------- If Filter option Choose From doctor dashboard ---------
	var data = "<?php echo $this->session->flashdata('filter_id'); ?>";
	if(data)
	{
		$("#saved_filter").val(data);
		//$("#saved_filter").change();	
		//$("#search_rfp .btn_search").click();
	}
	//-------------------------------------------------------------	
	$("#saved_filter").change();
});


$("#sort").val("<?=$this->input->get('sort')?$this->input->get('sort'):'desc'?>");
$("#bid_search").val("<?=$this->input->get('bid_search')?$this->input->get('bid_search'):'All'?>");
$("#favorite_search").val("<?=$this->input->get('favorite_search')?$this->input->get('favorite_search'):'All'?>");
$("#reset").click(function(){
	$('input[name=search]').val('');
	$('input[name=date]').val('');
	$("#sort").val('desc');
	$("#bid_search").val('All');
	$("#favorite_search").val('All');
	$("#treatment_cat_id").val('');
	$("#search_rfp").submit();
});

//-------------- For Saved Filter ------------
function saved_filter(){

	if($("#search_filter_name").val() != ''){
		//------ Update Filter Data -----
		$("#filter_name").val($("#search_filter_name").val());
		$(".saved_filter .modal-title").html("Update Filter");
		$('.saved_filter').modal('show');
	}
	else{
		//------ Insert Filter Data -----
		$.post("<?=base_url('rfp/count_filter_data')?>",function(data){
			if(data >= 3) // Allow 3 Search Filter Store per Doctor
			{
				$(".alert-message").html('<div class="alert alert-danger margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Max. 3 Search Filter Save</div>');
			}
			else{
				$('.saved_filter').modal('show');
			}
		});		
		$(".saved_filter .modal-title").html("Save Filter");
	}

	$("#search_data").val($("#search").val());
	$("#search_date").val($("#filter_date").val());
	$("#search_sort").val($("#sort").val());
	$("#search_bid").val($("#bid_search").val());
	$("#search_favorite").val($("#favorite_search").val());
	$("#search_treatment_cat_id").val($("#treatment_cat_id").val());

}

$("#saved_filter").change(function(e) {
	var filter_val = $(this).val();
	if(filter_val != ''){	
		$.post("<?=base_url('rfp/fetch_filter_data')?>",{ 'filter_id' : filter_val},function(data){
			if(data)
			{
				$("#search_filter_id").val(data['id']);
				$("#search_filter_name").val(data['filter_name']);
				$("#search").val(data['search_data']);
				$("#filter_date").val(data['search_date']);
				$("#sort").val(data['search_sort']);
				$("#bid_search").val(data['search_bid']);
				$("#favorite_search").val(data['search_favorite']);
				var treat_cat_id = data['search_treatment_cat_id'].split(',');
				$("#treatment_cat_id").val(treat_cat_id);
				$('#treatment_cat_id').trigger('change.select2');
				$(".filter_btn").html('Edit Filter');
				$('#frm_save_filter').attr('action', "<?=base_url('rfp/update_filter_data')?>");
				$(".alert-message").html('');
				//$("#search_rfp .btn_search").click();
			}

		},'json');
	}
	else{
		$("#search_filter_id").val('');
		$("#search_filter_name").val('');
		$(".filter_btn").html('Save Filter');
		$('#frm_save_filter').attr('action', "<?=base_url('rfp/save_filter_data')?>");
	}
});

//--------------------------------------------

//------------ For Set Link in td for rfp details -------------
$(".search_rfp_info").click(function(e) {
	
	var rfp_id = $(this).data('rfp-id');
	var link="<?=base_url('rfp/view_rfp')?>"; 
	var href = link+'/'+rfp_id;
	window.location.href=href;
});
	
//-------------------------------------------------------------

//----------------- For Add To favorite & Remove Favorite RFP ------------------
$(".favorite").on( "click", function() {	
	
		var rfp_id= $(this).attr('data-id');
		var classNames = $(this).attr('class').split(' ');
		var data1=$(this);
		if($.inArray('unfavorite_rfp',classNames) != '-1')
		{
			//bootbox.confirm('Are you sure to add favorite rfp ?' ,function(res){
				//if(res){
					$.post("<?=base_url('rfp/add_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
						if(data){
							data1.removeClass('unfavorite_rfp');
							data1.addClass('favorite_rfp');
							$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP added to your favorite list successfully.</div>');
						}
					});
				//}	
			//});
		}
		else{
			//bootbox.confirm('Are you sure to remove favorite rfp ?' ,function(res){
			//	if(res){	
					$.post("<?=base_url('rfp/remove_favorite_rfp')?>",{ 'rfp_id' : rfp_id},function(data){
						if(data){
							data1.removeClass('favorite_rfp');
							data1.addClass('unfavorite_rfp');
							$(".alert-message").html('<div class="alert alert-success margin-bottom-30"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>RFP removed to your favorite list successfully. </div>');
						
						}
					});
			//	}
			//});
		}
	return false;
});

//--------------- For Save Filter Form Validation --------------
$("#frm_save_filter").validate({
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    rules: {
        filter_name: {
            required: true,
        }
    },
    messages: {
        filter_name: {
            required: "Please provide a Filter Name"
        }
    }
});

/*------------- Custom Select 2 focus open select2 option @DHK-Select2 --------- */
$(document).on('blur', '#favorite_search', function() {
    $('.select2').select2('open');
});
/*-------------End Custom Select 2 focus open select2 options -----*/
</script>
