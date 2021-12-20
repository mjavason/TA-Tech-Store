<?php

require_once "admin/config/connect.php";
require_once "admin/functions/functions.php";



//formatAllProductCategories(getAllProductCategories());

echo validateProductCategory('CAMERAS', '[
    {
        "title": "CAMERAS",
        "value": "8"
    },
    {
        "title": "UI",
        "value": "8"
    },
    {
        "title": "JIK",
        "value": "8"
    }
]');
?>