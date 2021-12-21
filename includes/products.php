<div class="tab-pane" id="listView">
<?php 
if(isset($_GET['category'])){
loadProductsWithCategoriesBlock($_GET['category']);
}else{
	loadLatestProductsBlock();
} ?>
	</div>

	<div class="tab-pane  active" id="blockView">
		<ul class="thumbnails">
			
		<?php
		if(isset($_GET['category'])){
		loadProductsWithCategories($_GET['category']); 
		}else{
			loadLatestProducts();
		}
		?>
		  </ul>
	<hr class="soft"/>
	</div>