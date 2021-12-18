<h4>Product Information</h4>
<table class="table table-bordered">
	<tbody>
	<?php loadFullSpecs($_GET['id']); ?>
	</tbody>
</table>

<h4>Colors</h4>
<table class="table table-bordered">
	<tbody>
	<?php loadProductColors($_GET['id']); ?>
	</tbody>
</table>

<h5>Features</h5>
<?php loadProductFeatures($_GET['id']); ?>