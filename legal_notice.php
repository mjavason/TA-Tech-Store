<?php

require_once "admin/config/connect.php";
require_once "admin/functions/functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<!-- include head.php -->
	<?php
	loadPageMetaData('legal');
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
						<li class="active">Legal Notice</li>
					</ul>
					<h3>Legal Notice</h3>
					<hr class="soft" />
					<h4>
						I-Plan Tech and Tech Acoustic are in no way responsible for any damages arising from use of any products we sell </h4>
					<h4>We at I-Plan Tech and Tech Acoustic are not manufacturers and thereby take no credit for the building of any products found here.</h4>

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