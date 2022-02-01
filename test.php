<?php

require_once "admin/config/connect.php";
require_once "admin/functions/functions.php";



//formatAllProductCategories(getAllProductCategories());

// echo validateProductCategory('CAMERAS', '[
//     {
//         "title": "CAMERAS",
//         "value": "8"
//     },
//     {
//         "title": "UI",
//         "value": "8"
//     },
//     {
//         "title": "JIK",
//         "value": "8"
//     }
// ]');
// echo '<pre>';
// print_r($_POST);

// echo $_SERVER["PHP_SELF"];

//  loadPageMetaData('/tats/index.php');

// $pageUrl = '/tats/index.php';

//  loadPageMetaTitle($pageUrl, $uniqueId = null);
//  loadPageMetaDescription($pageUrl, $uniqueId = null);
//  loadPageMetaUrl($pageUrl, $uniqueId = null);
//  loadPageMetaImage($pageUrl, $uniqueId = null);
//  loadPageMetaKeywords($pageUrl, $uniqueId = null);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <!-- include head.php -->
    <?php
   // loadPageMetaData('test');
   echo loadPageMetaTitle('test');
		echo loadPageMetaDescription('test');
		echo loadPageMetaUrl('test');
		echo loadPageMetaImage('test');
		echo loadPageMetaKeywords('test');
		echo loadPageMetaType('test');
    require_once('includes/head.php');
    ?>

</head>

<body>
    <?php deleteDuplicateImages(); ?>
</body>

</html>