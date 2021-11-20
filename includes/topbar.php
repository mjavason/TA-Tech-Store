<div class="container">
	<div id="welcomeLine" class="row">
		<div class="span6">Welcome!<strong> User</strong></div>
		<div class="span6">
			<div class="pull-right">
				<!-- <a href="product_summary.php"><span class="">Fr</span></a>
						<a href="product_summary.php"><span class="">Es</span></a>
						<span class="btn btn-mini">En</span> -->
				<!-- <a href="product_summary.php"><span>&pound;</span></a>
						<span class="btn btn-mini">E155.00</span> -->
				<!-- <a href="product_summary.php"><span class="">$</span></a>
				<span class="btn btn-mini">$155.00</span> -->
				<a href="product_summary.php"><span>&#8358;</span></a>
				<span class="btn btn-mini " id="top_product_summary_total"></span>
				<a href="product_summary.php"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i>[ <span id="top_product_summary_count"></span> ] Items in your cart </span> </a>
			</div>
		</div>
	</div>
	<!-- Navbar ================================================== -->
	<div id="logoArea" class="navbar">
		<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-inner">
			<a class="brand" href="index.php"><img src="themes/images/logo.png" alt="Bootsshop" /></a>
			<form class="form-inline navbar-search" method="post" action="products.php">
				<input id="srchFld" class="srchTxt" type="text" />
				<select class="srchTxt">
					<option>All</option>
					<option>CLOTHES </option>
					<option>FOOD AND BEVERAGES </option>
					<option>HEALTH & BEAUTY </option>
					<option>SPORTS & LEISURE </option>
					<option>BOOKS & ENTERTAINMENTS </option>
				</select>
				<button type="submit" id="submitButton" class="btn btn-primary">Go</button>
			</form>
			<ul id="topMenu" class="nav pull-right">
				<li class=""><a href="special_offer.php">Special Offers</a></li>
				<!-- <li class=""><a href="normal.php">Delivery</a></li> -->
				<li class=""><a href="contact.php">Contact</a></li>

			</ul>
		</div>
	</div>
</div>