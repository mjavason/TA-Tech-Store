<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader 
// require 'vendor/autoload.php';

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';


require_once "config/connect.php";
require_once "functions/functions.php";

if (!isset($_SESSION['log'])) {
    //gotoPage("index.php");
}
?>


<?php
if (isset($_POST['submit'])) {
    if (validateMailAddress($_POST['email']) == false) {
?>
        <?php
        //Create an instance; passing `true` enables exceptions 
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'www.techac.net';
            $mail->SMTPAuth = TRUE;
            $mail->SMTPSecure = 'ssl';
            $mail->Username = 'michaelson@techac.net';
            $mail->Password = 'Emerald22401507';
            $mail->Port = 465;

            /* Enable SMTP debug output. */
            $mail->SMTPDebug = 4;


            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients 
            $mail->setFrom('michaelson@techac.net', 'Orji Michael Chukwuebuka');
            $mail->addAddress($_POST['email'], 'Tech Acoustic');

            //Add a recipient 
            //$mail->addAddress('ellen@example.com');

            //Name is optional 
            $mail->addReplyTo('no-replyinfo@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments 
            //$mail->addAttachment('/var/tmp/file.tar.gz');

            //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

            //Optional name //Content 
            $mail->isHTML(true);

            //Set email format to HTML 
            $code = uniqid(true);
            //addNewResetData($code, $_POST['email']);

            $url = "https://techac.net/tats/admin/setnewpass.php?code=" . $code;
            $mail->Subject = 'Password Reset Request';
            $mail->Body = '
    <h1>You requested a password reset link</h1>
    Click <a href="' . $url . '">this link to do so</a>';
            $mail->AltBody = 'copy this link into your browser to reset your password: ' . $url;
            $mail->send();

            addNewResetData($code, $_POST['email']);
            $message = '<p class="text-success">Reset link has been sent to your email address. go check it out</p>';
        } catch (Exception $e) {
            $message = '<p class="text-danger">Reset link could not be sent, an error has occured</p>';

            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        //$datamissing =  processLogin($_POST);

        ?>


<?php } else {
        $message = '<p class="text-warning">Your account does not exist.</p>';
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    echo loadPageMetaTitle('forgotpass');
    echo loadPageMetaDescription('forgotpass');
    echo loadPageMetaUrl('home');
    echo loadPageMetaImage('home');
    echo loadPageMetaKeywords('forgotpass');
    echo loadPageMetaType('home');
    ?>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <?php if (isset($_POST['submit'])) {
                                        echo $message;
                                    } ?>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input required type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" id="submit" name="submit">Reset Password</button>
                                    </form>
                                    <hr>
                                    <!-- <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> -->
                                    <div class="text-center">
                                        <a class="small" href="login.php">Already have an account? Login!</a>
                                    </div>
                                </div>
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