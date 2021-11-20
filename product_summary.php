<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Bootshop online Shopping cart</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- include head.php -->
	<?php
	require_once('includes/head.php');
	?>
</head>

<body>
	<div id="header">
		<!-- include topbar.php -->
		<?php
		require_once('includes/topbar.php');
		?>
	</div>
	<!-- Header End====================================================================== -->
	<div id="mainBody">
		<div class="container">
			<div class="row">
				<!-- Sidebar ================================================== -->
				<div id="sidebar" class="span3">
					<!-- include sidebar.php -->
					<?php
					require_once('includes/sidebar.php');
					?>

				</div>
				<!-- Sidebar end=============================================== -->
				<div class="span9">
					<ul class="breadcrumb">
						<li><a href="index.php">Home</a> <span class="divider">/</span></li>
						<li class="active"> SHOPPING CART</li>
					</ul>
					<h3> SHOPPING CART [ <small>3 Item(s) </small>]<a href="products.php" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
					<hr class="soft" />

					<table class="table table-bordered">
						<!-- include checkout.php -->
						<?php
						require_once('includes/checkout.php');
						?>
					</table>

					<table class="table table-bordered">
						<!-- include voucher.php -->
						<?php
						require_once('includes/voucher.php');
						?>
					</table>

					<table class="table table-bordered">
						<!-- include shipping.php -->
						<?php
						require_once('includes/shipping.php');
						?>
					</table>
					<a href="products.php" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
					<a href="login.php" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

				</div>
			</div>
		</div>
	</div>
	<!-- MainBody End ============================= -->
	<!-- Footer ================================================================== -->
	<div id="footerSection">
		<?php
		require_once('includes/footer.php');
		?>
	</div>
	<!-- Placed at the end of the document so the pages load faster ============================================= -->

	<!-- include frontScripts.php -->
<?php
require_once('includes/frontScripts.php');
?>

	<!-- Themes switcher section ============================================================================================= -->
	<div id="secectionBox">
		<!-- include themes.php -->
	</div>
	<span id="themesBtn"></span>
</body>

</html>