<h3><?php loadProductTitle($_GET['id']); ?></h3>
<small><?php loadSpecSummary($_GET['id']); ?></small>
<hr class="soft" />

<div class="control-group">

	<div class="controls">
		<a class="btn btn-large" href="product_summary.php">
			<script>
				<?php echo 'nairaFormat(' . getProductPrice($_GET['id']) . ')' ?>
			</script>
		</a>
		<?php if (getProductStock($_GET['id']) < 1 || getProductPrice($_GET['id']) < 2) { ?>
			<span class="text-large text-warning pull-right">Out of stock!</span>
		<?php } else { ?>
			<button id="cartToggleButton<?php echo $_GET['id']; ?>" onclick="<?php loadProductCartInfo($_GET['id']); ?>" class="btn btn-large btn-primary pull-right"> Add to cart <i class=" icon-shopping-cart"></i></button>
		<?php	} ?>

	</div>
</div>

<hr class="soft clr" />
<!-- <p>
	14 Megapixels. 18.0 x Optical Zoom. 3.0-inch LCD Screen. Full HD photos and 1280 x 720p HD movie capture. ISO sensitivity ISO6400 at reduced resolution.
	Tracking Auto Focus. Motion Panorama Mode. Face Detection technology with Blink detection and Smile and shoot mode. 4 x AA batteries not included. WxDxH 110.2 ×81.4x73.4mm.
	Weight 0.341kg (excluding battery and memory card). Weight 0.437kg (including battery and memory card).

</p> -->
<!-- <a class="btn btn-small pull-right" href="#detail">More Details</a> -->
<br class="clr" />
<a href="#" name="detail"></a>
<hr class="soft" />