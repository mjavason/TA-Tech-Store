<?php

require_once "admin/config/connect.php";
require_once "admin/functions/functions.php";
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
						<li class="active">Contact</li>
					</ul>
					<h3>Contact Us</h3>
					<hr class="soft" />
					<!-- <hr class="soften" /> -->
					<div class="row">

					<div class="span4">
							<a href=""><h4>For complaints relating to unprocessed transactions or errors click here</h4></a><br>

							<a href=""><h4>For feedback on how to better serve you, including suggestions and ideas on where you think we should improve, click here</h4></a><br>

							<a href=""><h4>For design and functionality feedback, strictly for people with coding experience or technical know how, click here</h4></a><br>
						
						</div>

						<div class="span4">
							<h4>Contact Details</h4>
							<strong>Address: </strong>
							<p>110 Ogui Road Enugu, Opposite Nnamdi Azikiwe Stadium</p><br>

							<strong>Phone: </strong>
							<p><a href="tel:+2348088410054">+234-8088410054</a></p>
							<a href="tel:+2349059928764">+234-9059928764</a>
						</div>

						<div class="span4">
							<h4>Opening Hours</h4>
							<h5> Monday - Saturday</h5>
							<p>08:00am - 06:00pm<br /><br /></p>
						</div>

					</div>
					<div class="row">
						<!-- include map.php -->
						<?php
						require_once('includes/map.php');
						?>
					</div>
					

				</div>
			</div>
		</div>
	</div>
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
		<?php
		//require_once('includes/themes.php')
		?>
	</div>
	<span id="themesBtn"></span>

</body>

</html>