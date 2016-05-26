<!--<div class="slideshow">
  <div id="slideshow<?php echo $module; ?>" class="nivoSlider" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;">
    <?php foreach ($banners as $banner) { ?>
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
    <?php } ?>
    <?php } ?>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#slideshow<?php echo $module; ?>').nivoSlider();
});
</script>-->

<!-- srcm slider start -->

<script type="text/javascript">
		jQuery(document).ready(function() {	
		startPageInit();
		});
		</script>				
		
		<div id="absolutNav" </a></div>

		<div style="display: block;" class="container lang-en">

		<div class="slider">
		<div class="faderLeft"></div>

		<div class="items">


		 <?php
		 $count=0;
		 $selectClass = "";
		 $title = '';
		 $link = '';

		 foreach ($banners as $banner) {
		 
		 $count++;
		 if($count==1){
			$selectClass = "selected";
			$title = $banner['title'];
			$link = $banner['link'];
		 }
		 ?>

		<div style="transform: rotateY(0deg) translateZ(-20px) scale3d(1, 1, 1) translateY(-30px);" class="slideItem <?php echo $selectClass;?>" data-header="<?php echo $banner['title']; ?>" data-sub-header="<?php echo $banner['title']; ?>" data-intro="" data-link="<?php echo $banner['link']; ?>">

			<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />

		<div class="gradientOverlay"></div>
		<div class="bottomShadow"></div>

		<div class="reflection">
			<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
		<div class="overlay"></div>
		</div>
		</div>

    <?php } ?>
		

		</div>

		<div class="faderRight"></div>

		<div class="slideNav">
		<div>
		<a href="<?php echo $link; ?>" class="slideInfo">
		<h2><?php echo $title; ?></h2>
		<p></p>
		</a>
		<span class="arrowLeft" unselectale="on"></span>
		<span class="arrowRight" unselectale="on"></span>
		</div>
		</div>
		</div>
		</div>
		<!-- </div> -->

   <!-- srcm slider end -->
