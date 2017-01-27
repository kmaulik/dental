<style>
.message-board .bg-success{
	background-color: #8CC152;
	padding: 15px;
}
.message-board .btn-toolbar{
	padding: 15px;
}
.message-board .list-group .list-group-item{
	border-radius: 0px;
}
.message-board .list-group .list-group-item.active{
	background-color: #8CC152;
	color:#fff;
	border: none;
	
}
.message-board .list-group-item .bdg-success{
	float: right;
	display: inline-block;
    min-width: 10px;
    padding: 3px 7px;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    background-color: #8CC152;
    border-radius: 10px;
}
.message-board .list-group-item.active .bdg-success{
	background-color: #fff;
	color: #8CC152;
}

.list-group-item .avatar {
    width: 40px;
    height: 40px;
    margin: 0 10px;
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
.message-board .checkbox{
	margin :0 15px 18px 0;
}
.message-board .select-all{
	margin: 0px 16px;
}
.message-board .message-part{
    padding-top: 15px;
    background-color: rgba(238, 238, 238, 0.5);
}
.message-board .btn-success{
	background-color: #8CC152;
	border: none;
}
</style>

<section class="page-header page-header-xs">
	<div class="container">
		<h1>Messageboard</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('')?>">Home</a></li>
			<li><a href="<?=base_url('messageboard')?>">Messageboard</a></li>
			<li class="active">Inbox</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section>
	<div class="container message-board">
		<div class="row">
    		<div class="col-sm-12">
    			<div class="bg-success"> </div>
    			<div class="btn-toolbar">
    				<div class="btn-group"> <a href="#msg_new" class="btn btn-danger"><i class="fa fa-pencil"></i> New mail</a> </div>
    				<div class="btn-group"> <a href="#" data-toggle="tooltip" title="" class="btn btn-success" onclick="return action_delete(document.recordlist)" data-original-title="Delete"> <i class="fa fa-trash-o"></i> </a> </div>
    				<div class="btn-group pull-right"> <?php echo $this->pagination->create_links(); ?> </div>
    			</div>
    		</div>
    	</div>	
		<div class="row message-part">
    		<!-- =========== Left Side Menu  ============ -->
    		<div class="col-sm-4 col-md-3">
              <div class="list-group success square no-border"> 
              		<a href="#" class="list-group-item active">Inbox <span class="bdg-success"> 1 </span></a> 
              		<a href="#" class="list-group-item">Sent mail</a> </div>
            </div>
    		<!-- =============/ Left Side Menu ========= -->
    		<!-- =========== Right Side   ============ -->
    		<div class="col-sm-8 col-md-9">

    			<!-- ======== Search Box ========== -->
    			<div class="the-box full no-border">
	                <form action="#" method="post" name="search_inbox">
	                  <div class="row">
	                    <div class="col-sm-8">
	                      <input type="text" class="form-control" placeholder="Search mail..." name="search_msg_inbox" value="<?=$this->session->userdata('search_msg_inbox');?>">
	                    </div>
	                    <div class="col-sm-4">
	                      <input type="submit" value="Submit" class="btn btn-success" name="search_inbox">
	                      <input type="submit" value="All" class="btn btn-success" name="all_inbox">
	                    </div>
	                  </div>
	                </form>
              	</div>
    			<!-- ======== /Search Box ========= -->

    			<!-- ========== Message List ========= -->
    			<form name="recordlist" id="mainform"  method="post"  action="#">
    				<div class="select-all">
    					<label class="checkbox"><input type="checkbox" onclick="CheckAll()" value="1"><i></i> Select All</label>	
    				</div>	
	            	<div class="list-group success square no-side-border">
						<?php for($i=0;$i<5;$i++) :?>
							<a href="#" class="list-group-item">
							<div class="message-left">
								<label class="checkbox"><input type="checkbox" name="Id_List[]" id="Id_List[]"><i></i></label>
								<img src="<?=DEFAULT_IMAGE_PATH."user/user-img.jpg";?>" class="avatar img-circle" alt="Avatar">
								<span class="name">Dhaval Patel</span>
								<span class="subject">
									<span class="hidden-sm hidden-xs label label-info">Doctor</span> 
									<span class="hidden-sm hidden-xs">Subject Here</span>
								</span>
							</div>	
							<div class="message-right hidden-xs">
								<span class="attachment"><i class="fa fa-paperclip"></i></span>
								<span class="time">2017-01-12</span>
							</div>
							</a>
						<?php endfor; ?>	
					</div>
				</form>  
				<!-- ========= /Message List ========= -->

            </div>
    		<!-- =============/ Right Side ========= -->
		</div> 	
	</div>
</section>

<script>
function CheckAll()
{
  
    var checks = document.getElementsByName('Id_List[]');
	for (i = 0; i < checks.length; i++)
	{
		if(checks[i].checked == false) 
			checks[i].checked = true;
	}
}
</script>		