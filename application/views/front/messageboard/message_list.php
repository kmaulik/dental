<link rel="stylesheet" href="<?=DEFAULT_CSS_PATH.'message-board.css'?>">

<section class="page-header page-header-xs">
	<div class="container">
		<h1>Messageboard</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('')?>">Home</a></li>
			<li class="active">Messageboard</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section>
	<div class="container message-board">
		<div class="row">
    		<div class="col-sm-12">
    			<!-- <div class="bg-success"> </div> -->
    			<div class="btn-toolbar">
    				<!-- <div class="btn-group"> <a href="#" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="Delete"> <i class="fa fa-trash-o"></i> </a> </div> -->
    				<div class="btn-group pull-right"> <?php echo $this->pagination->create_links(); ?> </div>
    			</div>
    		</div>
    	</div>	
		<div class="row message-part">
    		<div class="col-sm-12">

    			<!-- ======== Search Box ========== -->
    			<div class="the-box full no-border">
	                <form action="#" method="post" name="search_inbox">
	                  <div class="row">
	                    <div class="col-sm-9 col-md-10">
	                      <input type="text" class="form-control" placeholder="Search message..." name="search_msg">
	                    </div>
	                    <div class="col-sm-3 col-md-2">
	                      <input type="submit" value="Search" class="btn btn-info" name="search">
	                      <input type="submit" value="All" class="btn btn-info" name="all">
	                    </div>
	                  </div>
	                </form>
              	</div>
    			<!-- ======== /Search Box ========= -->

    			<!-- ========== Message List ========= -->
    			<form name="recordlist" id="mainform"  method="post"  action="#">
    				<!-- <div class="select-all">
    					<label class="checkbox"><input type="checkbox" id="ckbCheckAll" value="1"><i></i> Select All</label>	
    				</div> -->	
	            	<div class="list-group success square no-side-border">
						<?php foreach($messages as $record) :?>
							<a href="<?=base_url('messageboard/message/'.encode($record['rfp_id']).'/'.encode($record['user_id']))?>" class="list-group-item">
								<div class="message-left">
									<!-- <label class="checkbox"><input type="checkbox" class="checkboxes" name="Id_List[]" id="Id_List[]"><i></i></label> -->
									<img src="<?php if($record['user_avatar'] != '') 
			                    		{ echo base_url('uploads/avatars/'.$record['user_avatar']); } 
			                    	else 
			                    		{ echo DEFAULT_IMAGE_PATH."user/user-img.jpg"; }?>" class="avatar img-circle" alt="Avatar">
									<span class="name"><?=$record['fname']." ".$record['lname']?></span>
									<span class="subject">
										<span class="badge badge-aqua"><strong>5-</strong></span> &nbsp;
										<span class="hidden-xs">RFP : <?=$record['rfp_title']?></span>
									</span>
								</div>	
								<div class="message-right hidden-xs">
									<!-- <span class="attachment"><i class="fa fa-paperclip"></i></span> -->
									<span class="time"><?=date("Y-m-d",strtotime($record['bid_date']))?></span>
								</div>
							</a>
						<?php endforeach; ?>	
					</div>
				</form>  
				<!-- ========= /Message List ========= -->

            </div>
		</div> 	
	</div>
</section>

<script>
//  $("#ckbCheckAll").click(function () {
// 	 $(".checkboxes").prop('checked', $(this).prop('checked'));
// });
</script>		