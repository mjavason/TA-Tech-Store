<?php

$db = new mysqli("localhost","root","","tats");

if($db->connect_error){
die("Error Occured".$db->connect_error);
}else{
    //echo "Connection Established";
}
