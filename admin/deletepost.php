<?php

require_once "config/connect.php";
require_once "functions/functions.php";

if (!isset($_SESSION['log'])) {
    gotoPage("login.php");
}
//this code snippet sets the coursename and id variables to the session global array, this is so the data is retained even when the page is refreshed
if (isset($_GET['id'])) {
    $_SESSION['post_id'] = $_GET['id'];
}
deletePost($_SESSION['post_id']);
?>