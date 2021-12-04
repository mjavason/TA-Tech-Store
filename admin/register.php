<?php
require_once "config/connect.php";
require_once "functions/functions.php";

if (!isset($_SESSION['log'])) {
    //gotoPage('login.php');
}

if (isset($_GET['edit'])) {
    $_SESSION['editadmin'] = true;
    $_SESSION['editId'] = $_GET['id'];
}

if (isset($_SESSION['editpost'])) {
    $datamissing = processNewAdmin($_POST, $_SESSION['editId']);
    //  print_r($datamissing);
    //  die;
} else {
    $datamissing = processNewAdmin($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<title>REGISTER ADMIN</title>
	<meta name="description" content="<?= 'Admin Registration' ?>">
	<!-- <meta property='og:title' content="TATB HOME"> -->
	<meta property='og:url' content="https://techac.net/tatb">
	<!-- <meta property='og:image' itemprop="image" content="https://techac.net/tatb/assets/images/mike.jpg"> -->
	<meta property='keywords' content="Admin, Register, Tech Acoustic, TA, TATB, Tech Blog, Tech, Science, Computers">
	<!-- <meta property='og:locale' content="">
	<meta property='og:type' content=""> -->

	<!-- Meta -->
	<meta name="author" content="Orji Michael Chukwuebuka at Tech Acoustic">
	

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <?php
                            showDataMissing($datamissing);
                            ?>
                            <!-- <?= $_SERVER['PHP_SELF'] ?> -->
                            <form action="" enctype="multipart/form-data" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName" name="firstname" placeholder="First Name" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="lastname" id="exampleLastName" placeholder="Last Name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" placeholder="Email Address" required>
                                </div>

                                <!-- facebook -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="facebook" name="facebook" placeholder="Facebook Link" required>
                                </div>

                                <!-- twitter -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="twitter" placeholder="Twitter Link" name="twitter" required>
                                </div>
                                <!-- 
                                whatsapp 
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                                </div> -->

                                <!-- instagram -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="instagram" placeholder="Instagram Link" required name="instagram">
                                </div>

                                <!-- linkedin -->
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="linkedin" placeholder="LinkedIn Link" required name="linkedin">
                                </div>

                                <!-- profile picture -->
                                <!-- <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="profilepic" placeholder="LinkedIn Link" required name="dp">
                                </div> -->

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password" name="password1" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block" id="submit" name="submit">Register Account</button>

                                <!-- <hr> 
                               <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a> -->
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>