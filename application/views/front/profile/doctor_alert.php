<?php 	
	$all_treatment_cat = [];
	if(!empty($settings)){
		$all_treatment_cat = $settings['treatment_cat'];
	}
?>
<!-- 
	PAGE HEADER 
	
	CLASSES:
		.page-header-xs	= 20px margins
		.page-header-md	= 50px margins
		.page-header-lg	= 80px margins
		.page-header-xlg= 130px margins
		.dark			= dark page header

		.shadow-before-1 	= shadow 1 header top
		.shadow-after-1 	= shadow 1 header bottom
		.shadow-before-2 	= shadow 2 header top
		.shadow-after-2 	= shadow 2 header bottom
		.shadow-before-3 	= shadow 3 header top
		.shadow-after-3 	= shadow 3 header bottom
-->
<section class="page-header page-header-xs">
	<div class="container">
		<!-- breadcrumbs -->
		<ol class="breadcrumb breadcrumb-inverse">
			<li><a href="#">Home</a></li>
			<li><a href="#">Edit Profile</a></li>
			<li class="active"><?php echo $db_data['fname'].' '.$db_data['lname']; ?></li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section>
	<div class="container">
		<!-- ALERT -->		
		<?php if($this->session->flashdata('success')) : ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
				&times;
			</button>
			<?=$this->session->flashdata('success');?>
		</div>
		<?php endif; ?>
		<?php if($this->session->flashdata('error')) : ?>
		<div class="alert alert-danger ">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
				&times;
			</button>
			<?=$this->session->flashdata('error');?>
		</div>
		<?php endif; ?>
		<!-- /ALERT -->

		<!-- RIGHT -->
		<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 margin-bottom-80">

			<ul class="nav nav-tabs nav-top-border">
				<li class="active">
					<a href="#info" data-toggle="tab">
						Request Search Alert
					</a>
				</li>
			</ul>
			
			<div class="tab-content margin-top-20">
				<!-- PERSONAL INFO TAB -->
				<div class="tab-pane fade in active" id="info">

					<form role="form"  method="post">						
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
							<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>							
						</div>
						
						<hr/>

						<div class="form-group">
							<label class="control-label">
								<b> Note : </b> 
							</label>
							Save a Request alert setting. Based on this setting you'll have notification in website and in email for yourselected search criteria.
						</div>
					</form>
				</div>
				<!-- /PERSONAL INFO TAB -->				
			</div>
		</div>
		<?php $this->load->view('front/layouts/side_bar_profile'); ?>
	</div>
</section>
<!-- / -->

<script type="text/javascript">
/*------------- Custom Select 2 focus open select2 option @DHK-Select2 --------- */
$(document).on('focus', '.select2', function() {
    $(this).siblings('select').select2('open');
});
/*-------------End Custom Select 2 focus open select2 options -----*/
</script>