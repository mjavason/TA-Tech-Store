<?php
require_once "config/connect.php";
require_once "functions/functions.php";

// if (!isset($_SESSION['log'])) {
//     gotoPage("login.php");
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    echo loadPageMetaTitle('payment_error');
    echo loadPageMetaDescription('payment_error');
    echo loadPageMetaUrl('home');
    echo loadPageMetaImage('payment_error');
    echo loadPageMetaKeywords('register');
    echo loadPageMetaType('home');
    ?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            /* background-color: greenyellow; */
            text-align: center;
            padding: 2rem;
        }

        form {
            background-color: skyblue;
            padding: 2rem;
        }

        form input {
            width: 100%;
            margin: 10px;
        }
    </style>
</head>

<body>
    <h1>Unfortunately an error occured in your payments, please return to the <a href="../index.php">Store</a> store and try again. If your account was debited, your funds will be refunded shortly.</h1>
</body>

</html>