<div class="well well-small"><a id="myCart" href="product_summary.php"><img src="themes/images/ico-cart.png" alt="cart"><span class="cart_num " id="side_product_summary_count"></span> Items in your cart <span class="badge badge-warning pull-right">₦<span class="cart_total " id="side_product_summary_total"></span></span></a></div>
<ul id="sideManu" class="nav nav-tabs nav-stacked">
	<li class="subMenu"><a> ELECTRONICS [<?php echo count(formatAllProductCategories(getAllProductCategories())) + 1; ?>]</a>
		<!-- <li class="subMenu open"><a> ELECTRONICS [230]</a> -->

		<ul style="display:none">
			<li><a href="products.php"><i class="icon-chevron-right"></i>ALL [<?php echo getTotalNumberOfProducts() ?>]</a>
				<?php loadCategories() ?>
		</ul>
	</li>
</ul>
<br />