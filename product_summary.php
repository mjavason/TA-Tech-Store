<?php
require_once "admin/config/connect.php";
require_once "admin/functions/functions.php";

// if (!isset($_SESSION['log'])) {
//     gotoPage("login.php");
// }


?>
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
						<li><a href="products.php">Products</a> <span class="divider">/</span></li>
						<li class="active"> SHOPPING CART</li>
					</ul>
					<h3> <span id="mid_product_summary_count"></span> Items <a href="products.php" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
					<hr class="soft" />




					
						<table id="product_table" class="table table-bordered">
							<!-- include checkout.php -->
							<?php
							require_once('includes/checkout.php');
							?>
						</table>
		



					<!-- <table class="table table-bordered">
						 include voucher.php
						<?php
						require_once('includes/voucher.php');
						?>

					</table>

					<table class="table table-bordered">
						include shipping.php
						<?php
						require_once('includes/shipping.php');
						?>
					</table> -->
					<button class="btn-large btn-danger pull-left" id="clear_cart" onclick="deleteAllCartItems();">Clear Cart</button>

					<div>
						<form id="paymentForm">
							<div class="form-submit">
								<button type="submit" class="btn-large btn-success pull-right" id="checkout" onclick="payWithPaystack()">Checkout</button>
								
							</div>
						</form>
					</div>


					<!-- <button class="btn-large btn-success pull-right" id="checkout" onclick="payWithPaystack()">Checkout</button> -->
					<!-- <a href="products.php" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
					<a href="login.php" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a> -->

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

	
<?php
if(isset($_GET['fin'])){
	if ($_GET['fin'] == true) {
	?>
		<script>
			clearLocalStorage();
			clearProductTable();
			deleteAllCartItems();
			setFrontendItems();
			
		</script>
	<?php } }?>

	<?php echo loadPaystackCode();
	?>

	<script src="https://js.paystack.co/v1/inline.js"></script>


	<!-- Themes switcher section ============================================================================================= -->
	<div id="secectionBox">
		<!-- include themes.php -->
	</div>
	<span id="themesBtn"></span>
</body>

</html>