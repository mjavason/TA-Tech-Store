<?php

require_once "config/connect.php";
require_once "functions/functions.php";

if (!isset($_SESSION['log'])) {
   gotoPage("login.php");
}
//this code snippet sets the coursename and id variables to the session global array, this is so the data is retained even when the page is refreshed
if (isset($_GET['id'])) {
    $_SESSION['product_id'] = $_GET['id'];
    $_SESSION['editImage1'] = $_GET['image1'];
    $_SESSION['editImage2'] = $_GET['image2'];
    $_SESSION['editImage3'] = $_GET['image3'];
    $_SESSION['editImage4'] = $_GET['image4'];
}
deleteProduct($_SESSION['product_id'],  $_SESSION['editImage1'], $_SESSION['editImage2'], $_SESSION['editImage3'], $_SESSION['editImage4']);
 
?>