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
			<hr class="soften">
			<h1>Visit us</h1>
			<hr class="soften" />
			<div class="row">
				<div class="span4">
					<h4>Contact Details</h4>
					<p> 18 Fresno,<br /> CA 93727, USA
						<br /><br />
						info@bootsshop.com<br />
						﻿Tel 123-456-6780<br />
						Fax 123-456-5679<br />
						web:bootsshop.com
					</p>
				</div>

				<div class="span4">
					<h4>Opening Hours</h4>
					<h5> Monday - Friday</h5>
					<p>09:00am - 09:00pm<br /><br /></p>
					<h5>Saturday</h5>
					<p>09:00am - 07:00pm<br /><br /></p>
					<h5>Sunday</h5>
					<p>12:30pm - 06:00pm<br /><br /></p>
				</div>
				<div class="span4">
					<h4>Email Us</h4>
					<form class="form-horizontal">
						<fieldset>
							<div class="control-group">

								<input type="text" placeholder="name" class="input-xlarge" />

							</div>
							<div class="control-group">

								<input type="text" placeholder="email" class="input-xlarge" />

							</div>
							<div class="control-group">

								<input type="text" placeholder="subject" class="input-xlarge" />

							</div>
							<div class="control-group">
								<textarea rows="3" id="textarea" class="input-xlarge"></textarea>

							</div>

							<button class="btn btn-large" type="submit">Send Messages</button>

						</fieldset>
					</form>
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
	<!-- MainBody End ============================= -->
	<!-- Footer ================================================================== -->
	<div id="footerSection">
		<?php
		// include footer.php
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