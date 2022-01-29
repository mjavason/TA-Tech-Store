<?php loadRelatedProductsBlock($_GET['id']) ?>
</div>




<div class="tab-pane active" id="blockView">
	<ul class="thumbnails">
		<?php loadRelatedProducts($_GET['id']); ?>
	</ul>
	<hr class="soft" />
</div>