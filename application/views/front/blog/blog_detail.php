<section class="page-header page-header-xs">
	<div class="container">
		<h1>BLOG</h1>
		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?=base_url('')?>">Home</a></li>
			<li><a href="<?=base_url('blog')?>">Blog</a></li>
			<li class="active">Blog Detail</li>
		</ol><!-- /breadcrumbs -->
	</div>
</section>
<!-- /PAGE HEADER -->


<!-- -->
<section>
	<div class="container">

		<h1 class="blog-post-title"><?=$blog_details[0]['blog_title']?></h1>
		<ul class="blog-post-info list-inline">
			<li>
				<a href="#">
					<i class="fa fa-clock-o"></i> 
					<span class="font-lato"><?=date("M d, Y",strtotime($blog_details[0]['created_at']));?></span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class="fa fa-user"></i> 
					<span class="font-lato"><?=fetch_username($blog_details[0]['created_by'])?></span>
				</a>
			</li>
		</ul>

		<?php $img=explode("|",$blog_details[0]['img_path']); 
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
		<p><?=$blog_details[0]['blog_description']?></p>
		<div class="divider divider-dotted"><!-- divider --></div>

		<ul class="pager">
			<?php if (isset($prev) && $prev != null) : ?>
				<li class="previous"><a class="noborder" href="<?=base_url('blog/blog_details/'.$prev['blog_slug'])?>">&larr; Previous Blog</a></li>
			<?php endif; ?>
			<?php if (isset($next) && $next != null) : ?>
				<li class="next"><a class="noborder" href="<?=base_url('blog/blog_details/'.$next['blog_slug'])?>">Next Blog &rarr;</a></li>
			<?php endif; ?>
		</ul>
	</div>
</section>		