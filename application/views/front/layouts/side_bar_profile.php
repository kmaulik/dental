<?php
	$controller_name = $this->router->fetch_class();
	$method_name = $this->router->fetch_method();
?>
<!-- LEFT -->
<div class="col-lg-3 col-md-3 col-sm-4 col-lg-pull-9 col-md-pull-9 col-sm-pull-8">

	<div class="thumbnail text-center">				
		<?php if($db_data['avatar'] == '') { ?>
			<img src="<?php echo base_url(); ?>uploads/default/no_image_found.jpg" alt="" />
		<?php }else{ ?>
			<img src="<?php echo base_url(); ?>uploads/avatars/<?= $db_data['avatar'] ?>" alt="" />
		<?php } ?>

		<h2 class="size-18 margin-top-10 margin-bottom-0"><?php echo $db_data['fname'].' '.$db_data['lname']; ?></h2>
		<!-- <h3 class="size-11 margin-top-0 margin-bottom-10 text-muted">DEVELOPER</h3> -->
	</div>
	
	<?php if($this->session->userdata('client')['role_id'] == '4'){ ?>
		<a href="<?php echo base_url().'dashboard/view_profile/'.encode($this->session->userdata('client')['id']);?>" class="btn btn-primary profile-btn">
			View my profile
		</a>
	<?php } ?>

</div>