<?php
require_once "config/connect.php";
require_once "functions/functions.php";
if(isset($_GET['redeem_id'])){
$redeem_id = $_GET['redeem_id'];
finish_redeem($redeem_id);

}else{
    gotoPage('index.php');
}

?>