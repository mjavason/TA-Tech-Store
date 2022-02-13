<div class="container">
	<div id="welcomeLine" class="row">
		<div class="span6"></div>
		<div class="span6">
			<div class="pull-right">
				<!-- <a href="product_summary.php"><span class="">Fr</span></a>
						<a href="product_summary.php"><span class="">Es</span></a>
						<span class="btn btn-mini">En</span> -->
				<!-- <a href="product_summary.php"><span>&pound;</span></a>
						<span class="btn btn-mini">E155.00</span> -->
				<!-- <a href="product_summary.php"><span class="">$</span></a>
				<span class="btn btn-mini">$155.00</span> -->
				<a href="product_summary.php"><span>₦</span></a>
				<span class="btn btn-mini " id="top_product_summary_total"></span>
				<a href="product_summary.php"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i>[ <span id="top_product_summary_count"></span> ] Items in your cart </span> </a>
			</div>
		</div>
	</div>
	<!-- Navbar ================================================== -->
	<div id="logoArea" class="navbar">
		<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar collapsed">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-inner">
			<a class="brand" href="index.php"><img src="themes/images/logo.png" alt="Bootsshop" /></a>
			<form class="form-inline navbar-search pull-right" method="post" action="search.php">
				<input id="srchFld" name="name" class="srchTxt" required type="text" />
				<!-- <select class="srchTxt" name="category">
					<option value='0'>ALL</option>
					<?php loadSearchBarCategories() ?>
				</select> -->
				<button type="submit" id="submitButton" name="submit" class="btn btn-primary">Search</button>
			</form>
			<ul id="topMenu" class="nav pull-right collapse" style="height: 0px;">
				<li class=""><a href="products.php">ALL [<?php echo getTotalNumberOfProducts() ?>]</a></li>
				<li class=""><a href="products.php?category=SPECIAL">SPECIAL OFFERS [<?php echo numberOfProductsUnderCategory('SPECIAL') ?>]</a></li>
				<?php loadTopBarCategories() ?>

				<!-- <li class=""><a href="normal.php">Delivery</a></li> -->
				<!-- <li class=""><a href="contact.php">CONTACT</a></li> -->

			</ul>
		</div>
	</div>
</div>