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
	loadPageMetaData('product_details');
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
						<li class="active">Product Details</li>
					</ul>
					<div class="row">
						<div id="gallery" class="span3">
							<!-- include product_info_gallery.php -->
							<?php
							require_once('includes/product_info_gallery.php');
							?>
						</div>
						<div class="span6">
							<!-- include product_info1.php -->
							<?php
							require_once('includes/product_info1.php');
							?>
							
						</div>

						<div class="span9">
							<ul id="productDetail" class="nav nav-tabs">
								<li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
								<li><a href="#profile" data-toggle="tab">Related Products</a></li>
							</ul>
							<div id="myTabContent" class="tab-content">
								<div class="tab-pane fade active in" id="home">
									<!-- include product_info2.php -->
									<?php
									require_once('includes/product_info2.php');
									?>
								</div>
								<div class="tab-pane fade" id="profile">
									<div id="myTab" class="pull-right">
										<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
										<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
									</div>
									<br class="clr" />
									<hr class="soft" />
									<div class="tab-content">
										<div class="tab-pane" id="listView">
											<!-- include related products.php -->
											<?php
											require_once('includes/related_products.php');
											?>
										</div>
										<br class="clr">
									</div>
								</div>
							</div>

						</div>
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