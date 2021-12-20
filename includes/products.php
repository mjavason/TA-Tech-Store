<div class="tab-pane" id="listView">
<?php loadProductsWithCategoriesBlock($_GET['category']); ?>
	</div>

	<div class="tab-pane  active" id="blockView">
		<ul class="thumbnails">
		<?php loadProductsWithCategories($_GET['category']); ?>
		  </ul>
	<hr class="soft"/>
	</div>