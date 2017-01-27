<style>
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
.sorting .sort-asc-data,.sorting .sort-desc-data{
	padding: 10px;
}
.sorting .sort-asc-data:hover,.sorting .sort-desc-data:hover{
	cursor: pointer;
	color:#000;
	background-color: rgba(0,0,0,0.05);
	border-radius: 5px;
}
.sorting .sort-asc-data.active,.sorting .sort-desc-data.active{
	cursor: pointer;
	color:#1980B6;
	background-color: rgba(0,0,0,0.05);
	border-radius: 5px;
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
</style>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/notifications/bootbox.min.js"></script>
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
			<!-- ALERT -->
			<div class="alert-message"></div>
			<!-- /ALERT -->		
			<div class="col-sm-12">
				<form action="" method="GET" id="search_rfp">
					<div class="row">
						<div class="col-sm-10">
							<div class="form-group">
								<div class="fancy-form"><!-- input -->
									<i class="fa fa-search"></i>
									<input type="text" name="search" id="search" class="form-control" placeholder="Search RFP" value="<?=isset($_GET['search']) ? $_GET['search'] :''?>">
									<span class="fancy-tooltip top-left"> <!-- positions: .top-left | .top-right -->
										<em>Search RFP From Here</em>
									</span>
								</div>
							</div>
						</div>
						<div class="col-sm-2 sorting">
							<input type="hidden" name="sort" id="sort" value="<?=isset($_GET['sort'])?$_GET['sort']:'asc'?>">
							<span class="sort-asc-data"><i class="icon-sort-by-attributes">&nbsp;Asc</i></span> &nbsp;
							<span class="sort-desc-data"><i class="icon-sort-by-attributes-alt">&nbsp; Desc</i></span>
						</div>	
					</div>	
				</form>
				<?php if(count($rfp_data) > 0) :?>
					<div class="list-group success square no-side-border search_rfp">
						<?php foreach($rfp_data as $record) :?>
							<a href="<?=base_url('rfp/view_rfp/'.encode($record['id']))?>" class="list-group-item">
							<div class="rfp-left">
								<?php if(isset($record['favorite_id']) && $record['favorite_id'] != '') : ?>
									<!-- Means Favorite RFP -->
									<span class="favorite fa fa-star favorite_rfp" data-id="<?=encode($record['id'])?>"></span>
								<?php else : ?>
									<!-- Means Not Favorite RFP -->
									<span class="favorite fa fa-star unfavorite_rfp" data-id="<?=encode($record['id'])?>"></span>
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
							</div>	
							<div class="rfp-right">
								<?php if($record['img_path'] != '') :?>
									<span class="attachment"><i class="fa fa-paperclip"></i></span>
								<?php endif; ?>
								<span class="time"><?=date("Y-m-d H:i a",strtotime($record['created_at']));?></span>
							</div>
							</a>
						<?php endforeach; ?>	
					</div>
					<?php echo $this->pagination->create_links(); ?>
				<?php else : ?>
					<h3>No RFP Available</h3>
				<?php endif; ?>	
			</div>
		</div>
	</div>
</section>

<script>
//--------------- For Filter RFP Data (Search)--------------
// $('#search_rfp_text').keyup(function (e) {
// 	var rex = new RegExp($(this).val(), 'i');
// 	$('.search_rfp .list-group-item').hide();
// 	$('.search_rfp .list-group-item').filter(function () {
// 		return rex.test($(this).text());
// 	}).show();
// });

$('#search').keyup(function (e) {
	if(e.which == 13) {
       $("#search_rfp").submit();
    }
});	
//--------------- /End Filter RFP Data --------------

if($("#sort").val() == 'desc'){
	$(".sort-desc-data").addClass('active');
}else{
	$(".sort-asc-data").addClass('active');
}
//--------------- Sorting Data ---------
$(".sort-asc-data").click(function(){
	$("#sort").val('asc');
	$("#search_rfp").submit();
});

$(".sort-desc-data").click(function(){
	$("#sort").val('desc');
	$("#search_rfp").submit();
});
//-------------- / End Sorting Data ----


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
