<section class="page-header page-header-xs">
	<div class="container">
		<h1>BLOG</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('')?>">Home</a></li>
			<li class="active">Blog</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section>
	<div class="container">

		<?php foreach($blog_list as $blog) :?>
			<!-- POST ITEM -->
			<div class="blog-post-item">

				<?php $img=explode("|",$blog['img_path']); 
				if(count($img) == 1) : ?>
					<figure class="margin-bottom-20">
						<img class="img-responsive" src="<?=base_url('uploads/blogs/'.$img[0])?>" alt="" style="height:475px;width: 1140px;">
					</figure>
				<?php else : ?>
					<!-- OWL SLIDER -->
					<div class="owl-carousel buttons-autohide controlls-over" data-plugin-options='{"items": 1, "autoPlay": 3000, "autoHeight": false, "navigation": true, "pagination": true, "transitionStyle":"fadeUp", "progressBar":"false"}'>
						<?php foreach($img as $image) : ?>
							<div>
								<img class="img-responsive" src="<?=base_url('uploads/blogs/'.$image)?>" alt="" style="height:475px;width: 1140px;">
							</div>
						<?php endforeach; ?>
					</div>
					<!-- /OWL SLIDER -->
				<?php endif; ?>

				<h2><a href="<?=base_url('blog/blog_details/'.$blog['blog_slug'])?>"><?=$blog['blog_title'];?></a></h2>

				<ul class="blog-post-info list-inline">
					<li>
						<a href="#">
							<i class="fa fa-clock-o"></i> 
							<span class="font-lato"><?=date("M d, Y",strtotime($blog['created_at']));?></span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-user"></i> 
							<span class="font-lato"><?=fetch_username($blog['created_by'])?></span>
						</a>
					</li>
				</ul>

				<p><?=character_limiter(strip_tags($blog['blog_description']), 200);?></p>

				<a href="<?=base_url('blog/blog_details/'.$blog['blog_slug'])?>" class="btn btn-reveal btn-default">
					<i class="fa fa-plus"></i>
					<span>Read More</span>
				</a>

			</div>
			<!-- /POST ITEM -->
		<?php endforeach; ?>

		<!-- PAGINATION -->
		<div class="text-center">
			<?php echo $this->pagination->create_links();?>
		</div>
		<!-- /PAGINATION -->
	</div>
</section>		