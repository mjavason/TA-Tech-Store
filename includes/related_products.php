<?php loadLatestProductsBlock($_GET['id']) ?>
</div>




<div class="tab-pane active" id="blockView">
	<ul class="thumbnails">
		<?php loadLatestProducts($_GET['id']); ?>
	</ul>
	<hr class="soft" />
</div>