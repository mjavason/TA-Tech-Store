<?php
//below is some javascript code to format the amounts into real currency. example: 10000 into ₦10,000
//the code is referenced here because this functions.php file appears in nearly all the pages.
echo "<script>
function nairaFormat(number) {
    console.log('inside nairaFormat function');
    document.write('₦')
    document.write(number.toLocaleString(undefined , {maximumFractionDigits: 0 }));
    //return ''.formater.format(number);
}

function nairaFormatR(number) {
    console.log('inside nairaFormatR function');
    //window.alert('this should be working');
    amount = number.toLocaleString(undefined, {maximumFractionDigits: 0 });
    return(amount);
}
//window.alert('This naira format function is working');
</script>";
//This starts a session for the entire project
session_start();



/**
 * Goes to a specific page
 * 
 * Sends the user to the specified page
 * 
 * @param string $location The path to which the user is directed to, if the path is invalid or not a page, the result will display a 404 error.
 * @return void
 * 
 */
function gotoPage($location)
{
    header('location:' . $location);
    exit();
}

/**
 * Removes unwanted and harmful characters
 * 
 * Takes in a string cleanses and formats it, then returns a clean copy.
 * 
 * @param string $data
 * Any data or variable that may contain characters that needs cleansing.
 * @param string $case
 * [optional]
 * 
 * If set to 'lower' it automatically formats the results to lowercase, if set to 'none' it is left as it is.
 * @return string
 * Returns cleansed string.
 */
function Sanitize($data, $case = null)
{
    $result = htmlentities($data, ENT_QUOTES);
    if ($case == 'lower') {
        $result = strtoupper($result);
    } elseif ($case == 'none') {
        //leave it as it is
    } else {
        $result = strtoupper($result);
    }
    return $result;
}

/**
 * Validates new product
 * 
 * This checks if all data entered for a new product is correct and valid, if valid it moves to the next, if not it returns an error array.
 * 
 * @param array $formstream
 * This is the post array containing all the items filled in the form in the create new product page.
 * @param int $editId
 * [optional]
 * 
 * If this item is entered, it means a product with that particular id needs to be updated.
 * 
 * @return array 
 * returns an array $datamissing containing missing or invalid items if there are any.
 * @return void
 * returns nothing if there are no errors, and moves on to the next function.
 */
function processNewProduct($formstream, $editId = null)
{
    //this collects and prepares all the data entered for a new product for storage. It also makes sure all the required fields are filled and accurate to avoid errors in the database

    //It also helps in confirming if what the user entered is Okay, like someone entering two different things in the password and confirm password box
    extract($formstream);
    $noImages = false;

    if (isset($submit)) {

        $datamissing = [];

        if (empty($title)) {
            $datamissing['pt'] = "Missing product title";
        } else {
            $title = trim(Sanitize($title));
        }

        if (empty($price)) {
            $datamissing['p'] = "Missing product price";
        } else {
            $price = htmlentities($price, ENT_QUOTES);
        }

        if (empty($stock)) {
            //$datamissing['st'] = "Missing product stock";
            $stock = 0;
        } else {
            $stock = htmlentities($stock, ENT_QUOTES);
        }


        if (empty($discount)) {
            //$datamissing['d'] = "Missing product discount";
            $discount = 0;
        } else {
            $discount = trim(Sanitize($discount));
        }

        if (empty($tax)) {
            $tax = 0;
            //$datamissing['t'] = "Missing product tax";
        } else {
            $tax = trim(Sanitize($tax));
        }

        if (empty($specsummary)) {
            $datamissing['ss'] = "Missing product spec summary";
        } else {
            $specsummary = trim(Sanitize($specsummary));
        }

        if (empty($specsjson)) {
            $datamissing['fs'] = "Missing product full specs";
        } else {
            $specsjson = htmlentities($specsjson, ENT_QUOTES);
        }

        if (empty($colorsjson)) {
            $datamissing['c'] = "Missing product colors";
        } else {
            $colorsjson = htmlentities($colorsjson, ENT_QUOTES);
        }

        if (empty($categoriesjson)) {
            $datamissing['pc'] = "Missing product categories";
        } else {
            $categoriesjson = htmlentities($categoriesjson, ENT_QUOTES);
        }

        if (empty($features)) {
            $datamissing['pf'] = "Missing product features";
        } else {
            $features = htmlentities($features, ENT_QUOTES);
        }



        //image adding section

        //main image
        if (empty($_FILES['mi']['name'])) {
            if ($_SESSION['editpost'] != true) {
                $datamissing['mainimage'] = "Missing Main Product Image";
            } else {
                $noImages = true;
            }
        } else {
            //creates a unique string to help avoid a situation of files having the same name
            $uniqueimagename = time() . uniqid(rand());

            //stores the target folder name in a variable
            $target = "../product_images/" . $uniqueimagename;
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            //if the folder doesn't exist, create it.
            if (!is_dir("../product_images")) {
                mkdir("../product_images", 0755);
            }

            $filename = "";
            $tmpfilename = "";

            //this gets the uncleaned file name, including the local path to it
            $filename =  $_FILES['mi']['tmp_name'];

            //this gets the real filename. The function basename simply cleanses the filename of any unnecessary slashes and returns just the filename without the file extension
            $tmpfilename = basename($_FILES['mi']['name']);

            //this gets the file format. eg: jpg, png, avi etc.
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);

            //if the filetype is inside the list of allowed filenames, carry on to move it to the database.
            if (in_array($filetype, $allowtypes)) {

                //upload image to server and rename said file to unique image name variable above. the file name is contained in the target variable.
                if (move_uploaded_file($filename, $target . "." . $filetype)) {
                    $imagename = $uniqueimagename . "." . $filetype;
                } else {
                    echo '<br>';
                    echo 'Something went wrong with the image upload';
                    $datamissing['image'] = "Missing Main Product Image";
                }
            } else {
                $datamissing['mainimage'] = "Invalid File Type";
            }
        }

        //side image 1
        if (empty($_FILES['si1']['name'])) {
            if ($_SESSION['editpost'] != true) {
                $datamissing['sideimage1'] = "Missing First Side Product Image";
            } else {
                $noImages = true;
            }
        } else {
            //creates a unique string to help avoid a situation of files having the same name
            $uniqueimagename = time() . uniqid(rand());

            //stores the target folder name in a variable
            $target = "../product_images/" . $uniqueimagename;
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            //if the folder doesn't exist, create it.
            if (!is_dir("../product_images")) {
                mkdir("../product_images", 0755);
            }

            $filename = "";
            $tmpfilename = "";


            $filename =  $_FILES['si1']['tmp_name'];

            $tmpfilename = basename($_FILES['si1']['name']);
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes)) {

                //upload file to server
                if (move_uploaded_file($filename, $target . "." . $filetype)) {



                    $imagename1 = $uniqueimagename . "." . $filetype;
                } else {
                    echo '<br>';
                    echo 'Something went wrong with the image upload1';
                    $datamissing['sideimage1'] = "Missing First Side Product Image";
                }
            } else {
                $datamissing['sideimage1'] = "Invalid File Type";
            }
        }

        //side image 2
        if (empty($_FILES['si2']['name'])) {
            if ($_SESSION['editpost'] != true) {
                $datamissing['sideimage2'] = "Missing Second Side Product Image";
            } else {
                $noImages = true;
            }
        } else {
            //creates a unique string to help avoid a situation of files having the same name
            $uniqueimagename = time() . uniqid(rand());

            //stores the target folder name in a variable
            $target = "../product_images/" . $uniqueimagename;
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            //if the folder doesn't exist, create it.
            if (!is_dir("../product_images")) {
                mkdir("../product_images", 0755);
            }

            $filename = "";
            $tmpfilename = "";


            $filename =  $_FILES['si2']['tmp_name'];

            $tmpfilename = basename($_FILES['si2']['name']);
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes)) {

                //upload file to server
                if (move_uploaded_file($filename, $target . "." . $filetype)) {



                    $imagename2 = $uniqueimagename . "." . $filetype;
                } else {
                    echo '<br>';
                    echo 'Something went wrong with the image upload2';
                    $datamissing['sideimage2'] = "Missing Second Side Product Image";
                }
            } else {
                $datamissing['sideimage2'] = "Invalid File Type";
            }
        }

        //side image 3
        if (empty($_FILES['si3']['name'])) {
            if ($_SESSION['editpost'] != true) {
                $datamissing['sideimage3'] = "Missing Third Side Product Image";
            } else {
                $noImages = true;
            }
        } else {
            //creates a unique string to help avoid a situation of files having the same name
            $uniqueimagename = time() . uniqid(rand());

            //stores the target folder name in a variable
            $target = "../product_images/" . $uniqueimagename;
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');

            //if the folder doesn't exist, create it.
            if (!is_dir("../product_images")) {
                mkdir("../product_images", 0755);
            }

            $filename = "";
            $tmpfilename = "";


            $filename =  $_FILES['si3']['tmp_name'];

            $tmpfilename = basename($_FILES['si3']['name']);
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes)) {

                //upload file to server
                if (move_uploaded_file($filename, $target . "." . $filetype)) {

                    $imagename3 = $uniqueimagename . "." . $filetype;
                } else {
                    echo '<br>';
                    echo 'Something went wrong with the image upload3';
                    $datamissing['sideimage3'] = "Missing Third Side Product Image";
                }
            } else {
                $datamissing['sideimage3'] = "Invalid File Type";
            }
        }




        if (empty($datamissing)) {

            if (isset($editId)) {
                //if none of the images are touched, use the editProductWithoutImages function, else use the edit all function
                if ($noImages) {
                    editProductWithoutImages($editId, $title, $price, $stock, $discount, $tax, $specsummary, $specsjson, $colorsjson, $categoriesjson, $features);
                    // die;
                } else {
                    unlink("../product_images/" . $_SESSION['editImage1']);
                    unlink("../product_images/" . $_SESSION['editImage2']);
                    unlink("../product_images/" . $_SESSION['editImage3']);
                    unlink("../product_images/" . $_SESSION['editImage4']);

                    EditProduct($editId, $title, $price, $stock, $discount, $tax, $specsummary, $specsjson, $colorsjson, $categoriesjson, $features, $imagename, $imagename1, $imagename2, $imagename3);
                }

                $_SESSION['editproduct'] = null;
            } else {

                AddProduct($title, $price, $stock, $discount, $tax, $specsummary, $specsjson, $colorsjson, $categoriesjson, $features, $imagename, $imagename1, $imagename2, $imagename3);
                // die;
            }
        } else {
            return $datamissing;
        }
    }
}

/**
 * Creates a new product
 * 
 * This creates a new product row in the items table after being cleansed.
 * 
 * @param string $title
 * The name of the product.
 * @param int $price
 * The price of the item.
 * @param int $stock
 * The number of items available for said product.
 * @param int $discount
 * The amount to be reduced in case of a promo or event.
 * @param int $tax
 * The amount charged for tax returns.
 * @param string $specsummary
 * A small summary for the specs of a product, like ram, processor and hard disk space for a computer.
 * @param string $fullspecs
 * A json string containing all the products full specifications.
 * @param string $colors
 * A json string containing the different colors available for the product.
 * @param string $categories
 * A json string containing the products categories.
 * @param string $features
 * A summary about a product, something like a blog post.
 * @param string $mi
 * Unique name for main product image. The said image has already been uploaded in the previous function.
 * @param string $si1
 * Unique name for side product image 1. The said image has already been uploaded in the previous function.
 * @param string $si2
 * Unique name for side product image 2. The said image has already been uploaded in the previous function.
 * @param string $si3
 * Unique name for side product image 3. The said image has already been uploaded in the previous function.
 * 
 * @see admin/functions/functions.php/processNewProduct() for details on the product image upload.
 * 
 * @return void
 * When the function is complete, and the data is succesfully added to the database, the user is sent to admin/products.php
 */
function AddProduct($title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features, $mi, $si1, $si2, $si3)
{
    //adds the prepared data into the database

    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $admin = $_SESSION['admin_id'];

    $sql = "INSERT INTO item(title, 	price, stock, 	discount,	tax,  spec_summary, full_spec, colors, categories, features, main_img, side_img1, side_img2, side_img3, created_by) VALUES ('$title', '$price', '$stock', '$discount', '$tax', '$specsummary', '$fullspecs', '$colors', '$categories', '$features', '$mi', '$si1', '$si2', '$si3', '$admin')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['ProductJustAdded'] = 1;
        gotoPage("products.php");
    } else {

        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
        die;
    }
    //mysqli_close($db);
}

/**
 * Get all products in the database
 * 
 * This loads all products from the database into the admin section for easy editing, updating and deleting
 * 
 * @return bool
 * return true, after succesfully loading the product.
 */
function loadProducts()
{
    global $db;
    $query = "SELECT id, title, price, stock, sold, 	discount,	tax,  spec_summary, full_spec, colors, categories, features, main_img, side_img1, side_img2, side_img3, created_by  FROM item ORDER BY `id` DESC ";
    $response = @mysqli_query($db, $query);
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            //this function simply rendered the data in a way that we desire, using the product data fed to it.
            adminProductView($row);
            $checker = $row['id'];
           
        }
        if (empty($checker)) {
            echo '<p class="text-center">No Products Added Yet</p>';
        }else{
             return true;
        }
    }
}

/**
 * renders products in a table
 * 
 * Takes the product details contained inside the product array and returns fully rendered html table code.
 * 
 * @param array $productsArray
 * An associative array with all attributes for a complete product, including the title, price, stock, tax and id.
 * 
 * @return bool
 * returns true after all products have been successfully rendered.
 */
function adminProductView($productsArray)
{
    //this function simply renders the data in a way that we desire, using the product data fed to it.

    //id===========================
    echo '<tr><td>';
    echo $productsArray['id'];
    echo '</td>';

    //title============================
    echo  '<td>';
    if ($productsArray['stock'] <= 0) {
        echo '<span class="text-danger">';
    }
    $string = substr($productsArray['title'], 0, 25);
    echo ucwords(strtolower($string));
    if ($productsArray['stock'] == 0) {
        echo '</span>';
    }
    echo '</td>';

    //specification summary
    echo '<td>';
    $string = substr($productsArray['spec_summary'], 0, 25);
    echo $string;
    echo '</td>';

    //price
    echo '<td>';
    echo $productsArray['price'];
    echo '</td>';

    //discount
    echo '<td>';
    echo $productsArray['discount'];
    echo '</td>';

    //tax
    echo '<td>';
    echo $productsArray['tax'];
    echo '</td>';

    //stock
    echo '<td>';
    if ($productsArray['stock'] <= 0) {
        echo '<span class="text-danger">';
    }
    echo $productsArray['stock'];
    if ($productsArray['stock'] == 0) {
        echo '</span>';
    }
    echo '</td>';

    //How many sold
    echo '<td>';
    echo $productsArray['sold'];
    echo '</td>';

    //created by
    echo '<td>';
    echo $productsArray['created_by'];
    echo '</td>';

    //edit
    echo '<td>';
    echo '<a href="newproduct.php?id=';
    echo $productsArray['id'];

    echo '&title=';
    echo ucwords(strtolower($productsArray['title']));

    echo '&specsummary=';
    echo ucwords(strtolower($productsArray['spec_summary']));

    echo '&features=';
    echo ucwords(strtoupper($productsArray['features']));

    echo '&price=';
    echo ucwords(strtoupper($productsArray['price']));

    echo '&discount=';
    echo ucwords(strtoupper($productsArray['discount']));

    echo '&tax=';
    echo ucwords(strtoupper($productsArray['tax']));

    echo '&stock=';
    echo ucwords(strtoupper($productsArray['stock']));

    echo '&image1=';
    echo ucwords(strtoupper($productsArray['main_img']));

    echo '&image2=';
    echo ucwords(strtoupper($productsArray['side_img1']));

    echo '&image3=';
    echo ucwords(strtoupper($productsArray['side_img2']));

    echo '&image4=';
    echo ucwords(strtoupper($productsArray['side_img3']));

    //json class
    echo '&fullspec=';
    echo ($productsArray['full_spec']);

    echo '&colors=';
    echo ($productsArray['colors']);

    echo '&categories=';
    echo ($productsArray['categories']);
    //json class


    echo '&edit=1';

    echo '">';
    echo '<i class="fa fa-edit"></i></a></td>';


    //delete
    echo '<td><a href="deleteproduct.php?id=';
    echo $productsArray['id'];

    echo '&image1=';
    echo ucwords(strtoupper($productsArray['main_img']));

    echo '&image2=';
    echo ucwords(strtoupper($productsArray['side_img1']));

    echo '&image3=';
    echo ucwords(strtoupper($productsArray['side_img2']));

    echo '&image4=';
    echo ucwords(strtoupper($productsArray['side_img3']));

    echo '"';
    echo '><i class="fa fa-trash"></i></a></td>';

    echo '</tr>';

    return true;
}

/**
 * Shows invalid or missing data in form submission
 * 
 * Shows all the entries in the datamissing array if it isnt empty.
 * 
 * @param array $datamissing
 * An array containing information on errors in form submission, including invalid entries and empty forms
 * @param bool $showSuccess
 * [optional]
 * 
 * When set to yes a success message is echoed wherever the function is called.
 * 
 * @return void
 * Depending on the content of $datamissing, a message will be echoed or not.
 */
function showDataMissing($datamissing, $showSuccess = null)
{
    if (isset($datamissing)) {
        foreach ($datamissing as $miss) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Holy guacamole! </strong>' . $miss . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
        }
    } elseif (isset($showSuccess)) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Holy guacamole! </strong> Successful
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
}

/**
 * Updates a product
 * 
 * This updates/edits a product row that has already been previously created.
 * 
 * @param int $id
 * Unique identifier for product about to be updated.
 * @param string $title
 * The name of the product.
 * @param int $price
 * The price of the item.
 * @param int $stock
 * The number of items available for said product.
 * @param int $discount
 * The amount to be reduced in case of a promo or event.
 * @param int $tax
 * The amount charged for tax returns.
 * @param string $specsummary
 * A small summary for the specs of a product, like ram, processor and hard disk space for a computer.
 * @param string $fullspecs
 * A json string containing all the products full specifications.
 * @param string $colors
 * A json string containing the different colors available for the product.
 * @param string $categories
 * A json string containing the products categories.
 * @param string $features
 * A summary about a product, something like a blog post.
 * @param string $mi
 * Unique name for main product image. The said image has already been uploaded in the previous function.
 * @param string $si1
 * Unique name for side product image 1. The said image has already been uploaded in the previous function.
 * @param string $si2
 * Unique name for side product image 2. The said image has already been uploaded in the previous function.
 * @param string $si3
 * Unique name for side product image 3. The said image has already been uploaded in the previous function.
 * 
 * @see admin/functions/functions.php/processNewProduct() for details on the product image upload.
 * 
 * @return void
 * When the function is complete, and the data is succesfully updated in the database, the user is sent to admin/products.php
 */
function EditProduct($id, $title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features, $mi, $si1, $si2, $si3)
{
    //this function simply edit the product in the database by passing in new data

    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `item` SET `title` = '$title', `price` = '$price',  `stock` = '$stock', `discount` = '$discount', `tax` = '$tax', `spec_summary` = '$specsummary', `full_spec` = '$fullspecs', `colors` = '$colors', `categories` = '$categories', `features` = '$features', `main_img` = '$mi', `side_img1` = '$si1', `side_img2` = '$si2', `side_img3` = '$si3' WHERE `item`.`id` = $id ";
    //$sql = "INSERT INTO posts(title, 	blog_post, 	imagename,	minread, 	tags 	) VALUES ('$title', '$bp', '$imagename', '$minread', '$tag')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['postJustAdded'] = 1;
        $_SESSION['editproduct'] = null;
        gotoPage("products.php");
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Updates a product without touching the images
 * 
 * This updates/edits a product row that has already been previously created without affecting the images, this function is important because images can't be passed in programmatically due to security reasons. If a user wants to edit a product without touching the images a seperate function has to be created for it.
 * 
 * @param int $id
 * Unique identifier for product about to be updated.
 * @param string $title
 * The name of the product.
 * @param int $price
 * The price of the item.
 * @param int $stock
 * The number of items available for said product.
 * @param int $discount
 * The amount to be reduced in case of a promo or event.
 * @param int $tax
 * The amount charged for tax returns.
 * @param string $specsummary
 * A small summary for the specs of a product, like ram, processor and hard disk space for a computer.
 * @param string $fullspecs
 * A json string containing all the products full specifications.
 * @param string $colors
 * A json string containing the different colors available for the product.
 * @param string $categories
 * A json string containing the products categories.
 * @param string $features
 * A summary about a product, something like a blog post.
 * 
 * @return void
 * When the function is complete, and the data is succesfully updated in the database, the user is sent to admin/products.php
 */
function editProductWithoutImages($id, $title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features)
{
    //this is another version of the editProduct function but works without the problematic files data

    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `item` SET `title` = '$title', `price` = '$price',  `stock` = '$stock', `discount` = '$discount', `tax` = '$tax', `spec_summary` = '$specsummary', `full_spec` = '$fullspecs', `colors` = '$colors', `categories` = '$categories', `features` = '$features' WHERE `item`.`id` = $id ";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['postJustAdded'] = 1;
        $_SESSION['editproduct'] = null;
        gotoPage("products.php");
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Deletes a product
 * 
 * This deletes a product row that has already been previously created. It uses very few parameters because those are what are needed to delete a row. The image names are required because they have to be located in the product_images directory and deleted directly.
 * 
 * @param int $id
 * Unique identifier for product about to be deleted.
 * @param string $mi
 * Unique name for main product image. Said image exists in the product_images folder.
 * @param string $si1
 * Unique name for side product image 1. Said image exists in the product_images folder.
 * @param string $si2
 * Unique name for side product image 2. Said image exists in the product_images folder.
 * @param string $si3
 * Unique name for side product image 3. Said image exists in the product_images folder.
 * 
 * @return void
 * When the function is complete, and the data is succesfully deleted in the database, the user is sent to admin/products.php
 */
function deleteProduct($id, $imagename, $imagename1, $imagename2, $imagename3)
{
    global $db;

    $sql = "DELETE FROM `item`  WHERE item.id = '$id' ";
    if (mysqli_query($db, $sql)) {

        unlink("../product_images/" . $imagename);
        unlink("../product_images/" . $imagename1);
        unlink("../product_images/" . $imagename2);
        unlink("../product_images/" . $imagename3);

        //echo "Course Saved";
        //echo '<p class="text-success">';
        //echo "Course deleted";
        //echo '</p>';
        gotoPage('products.php');
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Checks if email address is valid
 * 
 * This checks if passed in email address is valid and exists in the database, if it exists it returns false, if it doesnt it returns true. In the context of this application, it is used to check if someone trying to create a new account has already being registered.
 * 
 * @param string $email
 * This is the email address or string about to be validated.
 * 
 * @return bool
 * If the email address exists in the database, it returns false, if it doesnt it returns true.
 */
function validateMailAddress($email)
{
    global $db;

    $sql = "SELECT * FROM `admins` WHERE `email`='$email'";
    $result = $db->query($sql);

    //if the results are greater than 0, check if they are truly equal then return true. if not return false.
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        if ($email == isset($result['email'])) {
            //echo 'email exists';
            return false;
        } else {
            //echo 'email doesnt exist';
            return true;
        }
    } else {
        //echo 'email definitely doesnt exist';
        return true;
    }
}

/**
 * Validates new admin
 * 
 * This checks if all data entered for a new admin is correct and valid, if valid it moves to the next, if not it returns an error array.
 * 
 * @param array $formstream
 * This is the $POST[] array containing all the items filled in the form in the admin/register page.
 * @param int $editId
 * [optional]
 * 
 * If this item is entered, it means an admin with that particular id needs to be updated.
 * 
 * @return array 
 * returns an array $datamissing containing missing or invalid items if there are any.
 * @return void
 * returns nothing if there are no errors, and moves on to the next function.
 */
function processNewAdmin($formstream, $editId = null)
{
    //converts form input into variables.
    extract($formstream);

    //checks if submit button was clicked.
    if (isset($submit)) {

        $datamissing = [];

        //firstname
        if (empty($firstname)) {
            $datamissing['firstname'] = "Missing First Name";
        } else {
            $firstname = trim(Sanitize($firstname));
        }

        //lastname
        if (empty($lastname)) {
            $datamissing['lastname'] = "Missing Last Name";
        } else {
            $lastname = trim(Sanitize($lastname));
        }

        // //facebook
        // if (empty($facebook)) {
        //     $datamissing['facebook'] = "Missing facebook profile page";
        // } else {
        //     $facebook = trim(Sanitize($facebook));
        // }

        // //twitter
        // if (empty($twitter)) {
        //     $datamissing['twitter'] = "Missing twitter page";
        // } else {
        //     $twitter = trim(Sanitize($twitter));
        // }

        // //instagram
        // if (empty($instagram)) {
        //     $datamissing['instagram'] = "Missing instagram page";
        // } else {
        //     $instagram = trim(Sanitize($instagram));
        // }

        // //linkedin
        // if (empty($linkedin)) {
        //     $datamissing['linkedin'] = "Missing Linkedin page";
        // } else {
        //     $linkedin = trim(Sanitize($linkedin));
        // }

        //email address
        if (empty($email)) {
            $datamissing['email'] = "Missing email Address";
        } else {
            $email = trim(Sanitize($email));
            if (!validateMailAddress($email)) {
                $datamissing['email'] = "Email already exists";
            }
        }
        //phone number
        // if (empty($phone)) {
        //     $datamissing['phone'] = "Phone Number";
        // } else {
        //     $phone = trim(Sanitize($phone));
        // }


        if (empty($password)) {
            $datamissing['password'] = "Missing Password";
        } else {
            $password = trim(Sanitize($password));
        }

        if (empty($password1)) {
            $datamissing['confpass'] = "Missing Confirm Password";
        } else {
            $password1 = trim(Sanitize($password1));
            if ($password != $password1) {
                $datamissing['confpass'] = "Password Mismatch";
            } else {
                // $password1 = trim(Sanitize($password1));
                $password = sha1($password);
            }
        }

        if (empty($datamissing)) {

            //addRegistered($firstname, $lastname, $email, $password, $facebook, $twitter, $linkedin, $instagram);
            addRegistered($firstname, $lastname, $email, $password);
        } else {
            return $datamissing;
        }
    }
}

/**
 * Creates a new admin
 * 
 * After the form entries are cleansed in the admin/functions/functions.php/processNewAdmin() function, it takes all the data, including the name, email and pasword and stores them in the database.
 * 
 * @param string $fname
 * The admins first name. eg: Michael.
 * @param string lname
 * The admins last name. eg: Orji.
 * @param string $em
 * The admins unique email address.
 * @param string $pass
 * The admins case sensitive hashed password.
 *
 * @return void
 * When a new admin is successfully created, they are sent to the admin/login.php page
 */
function addRegistered($fname, $lname, $em, $pass)
{
    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $sql = "INSERT INTO admins(  	firstname, 	lastname,	email, 	password) VALUES ('$fname', '$lname', '$em', '$pass')";

    if (mysqli_query($db, $sql)) {
        $_SESSION['registered'] = "true";
        gotoPage("login.php");
        //echo "New record created successfully";
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Validates login credentials
 * 
 * Makes sure all admin credentials are valid before giving access or being logged into the system
 * 
 * @param array $formstream
 * This is the $POST[] array containing all the items filled in the form in the admin/login page including email and case sensitive password.
 * 
 * @return array 
 * returns an array $datamissing containing missing or invalid items if there are any.
 * @return void
 * Logs the admin in if all went well then sets the users data to a session to show theyve logged in
 */
function processLogin($formstream)
{
    extract($formstream);
    global $db;


    if (isset($submit)) {
        // username and password sent from form 

        $myusername = Sanitize($email);
        $mypassword = trim(Sanitize($password));
        $mypassword = sha1($mypassword);

        $result = mysqli_query($db, "SELECT * FROM admins WHERE email ='$myusername' AND password = '$mypassword'      ");

        if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 1) {
            $result = $result->fetch_assoc();

            $_SESSION['username'] = ucwords(strtolower($result['firstname'])) . " " . ucwords(strtolower($result['lastname']));
            $_SESSION['firstname'] = $result['firstname'];
            $_SESSION['lastname'] = $result['lastname'];
            $_SESSION['admin_id'] = $result['id'];

            //$_SESSION['datejoined'] = $result['datejoined'];
            $_SESSION['email'] = $result['email'];
            //$_SESSION['phone'] = $result['phone'];
            // $_SESSION['profilepic'] = $result['profilepic'];

            $_SESSION['log'] = "true";


            //print_r($formstream);
            //die;

            //This is the line of code for saving cookies AKA remember me

            // if (isset($remember)) {
            if ($remember == true) {
                //die;
                setcookie("mem_mail",  $_SESSION['email'], time() + (10 * 365 * 24 * 60 * 60));
                setcookie("mem_pass", $password, time() + (10 * 365 * 24 * 60 * 60));
                setcookie("mem_sele",  $_SESSION['admin_id'], time() + (10 * 365 * 24 * 60 * 60));
            } else {
                if (isset($_COOKIE['mem_log'])) {
                    setcookie('mem_log', '');
                }
                setcookie("mem_mail",  $_SESSION['email'], time() + (10 * 365 * 24 * 60 * 60));
                setcookie("mem_pass", '', time() + (10 * 365 * 24 * 60 * 60));
            }
            gotoPage('index.php');
        } else {

            //     echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            //     <strong>Holy guacamole!</strong> Your username or password are incorrect.
            //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //       <span aria-hidden="true">&times;</span>
            //     </button>
            //   </div>';
            $datamissing['login_error'] = 'Your email or password are incorrect.';
            return $datamissing;
        }
    }
}

/**
 * Validates password reset code
 * 
 * Checks if reset code passed in corresponds with what is in the database.
 * 
 * @param string $code
 * The reset code sent to admins email address, then passed in through a $_GET[] array.
 * 
 * @return bool
 * Returns true if the code is valid and false if the code is not found.
 */
function validateResetCode($code)
{
    global $db;
    $sql = "SELECT * FROM `resetpassword` WHERE `code`='$code'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        if ($code == isset($result['code'])) {
            //echo 'code exists';
            $_SESSION['resetMail'] = $result['email'];
            return true;
        } else {
            //echo 'code doesnt exist';
            return false;
        }
    } else {
        //echo 'code definitely doesnt exist';
        return false;
    }
}

/**
 * Reset user details
 * 
 * Stores reset data in database, this same reset data will have been sent to the email of the admin in question, so when they click on it, they can succesfully set a new password.
 * 
 * @param string $code
 * Unique code used to change password.
 * @param string $email
 * Email address of admin who wants to change his or her password.
 * 
 * @return bool
 * Return true if the data was succesfully added to the database and false if it wasnt.
 */
function addNewResetData($code, $email)
{
    global $db;
    $sql = "INSERT INTO resetpassword(  	email, 	code 	) VALUES ('$email', '$code')";
    $_SESSION['resetMail'] = strtoupper($email);

    if (mysqli_query($db, $sql)) {
        //gotoPage("login.php");
        return true;
    } else {
        return false;
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Process new password
 * 
 * Checks if new password is valid. This includes asking the admin to input their passwords twice then checking if they match or if the new password field is empty.
 * 
 * @param array $formstream
 * A $_POST[] array containing all the items passed in a form.
 * 
 * @return array
 * If any items are invalid an array $datamissing containing the error report is sent to the user
 * @return void
 * If all went well move on to the next function
 */
function ResetPassword($formstream)
{
    extract($formstream);

    if (isset($submit)) {

        $datamissing = [];

        if (empty($pass1)) {
            $datamissing['password'] = "Missing Password";
        } else {
            $password = trim(Sanitize($pass1));
        }

        if (empty($pass2)) {
            $datamissing['password2'] = "Missing Confirm Password";
        } else {
            $password1 = trim(Sanitize($pass2));
            if ($password != $password1) {
                $datamissing['confpass'] = "Password Mismatch";
            } else {
                // $password1 = trim(Sanitize($password1));
                $password = sha1($password);
            }
        }

        if (empty($datamissing)) {
            if (isset($_SESSION['resetMail'])) {
                setNewPassword($_SESSION['resetMail'], $password);
                deleteResetPassword($_SESSION['resetMail']);
            } else {
                $datamissing['Reset Email'] = "Email not found";
                return $datamissing;
            }
            //addRegistered($firstname, $lastname, $email, $password, $facebook, $twitter, $linkedin, $instagram);
        } else {
            return $datamissing;
        }
    }
}

/**
 * Update admin password in database
 * 
 * Updates said admins password in the database using the email address as a key.
 * 
 * @param string $email
 * The admins email address, used as a unique key to find row belonging to admin.
 * @param string $password
 * The admins new validated and hashed case sensitive password.
 * 
 * @return void
 * if all goes well, 'password updated' will be echoed to the screen, if not the oppposite will be done.
 */
function setNewPassword($email, $password)
{
    $email = strtoupper($email);
    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `admins` SET `password` = '$password' WHERE `admins`.`email` = '$email'";

    if (mysqli_query($db, $sql)) {
        echo 'password updated';
        //gotoPage("login.php");
    } else {
        echo 'admins password not updated';
        echo  "<br>" . "Error: " . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Delete updated reset password code
 * 
 * Delete the reset code sent to said admins email address, stored in the database, there is no need for it anymore.
 * 
 * @param string $email
 * Email address of said admin, will be used as key in finding exact row to delete.
 * 
 * @return void
 * Send admin to login page once code is deleted.
 */
function deleteResetPassword($email)
{
    global $db;
    $email = strtoupper($email);
    $sql2 = "DELETE FROM `resetpassword` WHERE `resetpassword`.`email` = '$email'";

    if (mysqli_query($db, $sql2)) {
        gotoPage("login.php");
    } else {
        echo '<br>';
        echo 'reset password not deleted';
        echo  "<br>" . "Error: " . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Get current logged in admins name
 * 
 * Uses the values stored in the session global variable, to get and print the name of the admin from the database. The session global variable is filled automatically when the admin logs in.
 * 
 * @return void
 * Prints users first names and last names.
 */
function getAdminName()
{
    $id = $_SESSION['admin_id'];
    global $db;

    $query = "SELECT lastname, firstname FROM admins WHERE id = $id";
    $result = mysqli_query($db, $query);
    if (!$result) {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    } else {
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                echo ucwords(strtolower($row['lastname']));
                echo " ";
                echo ucwords(strtolower($row['firstname']));
            }
        }
        // $total_visitors = mysqli_num_rows($result);
    }
}

/**
 * Get all admins in the database
 * 
 * Gets all admin data in the database and renders it into a table for updating, deleting and information purposes.
 * 
 * @return void
 * Renders/echoes all admins into a table.
 */
function loadAdmins()
{
    global $db;

    $query = "SELECT id, firstname, lastname, email, joined FROM admins ORDER BY `id` DESC ";
    $response = @mysqli_query($db, $query);

    if ($response) {

        while ($row = mysqli_fetch_array($response)) {

            //$query2 = "SELECT profilepic FROM users WHERE emailaddress = '$master' ";

            echo '<tr><td>';
            echo $row['id'];
            echo '</td>';

            echo  '<td>';
            //echo '<a href="admin_details.php?id=';
            //echo $row['id'];
            //echo '"> ';
            echo ucwords(strtolower($row['firstname']));
            //echo '</a>';
            echo '</td>';

            echo '<td>';
            echo ucwords(strtolower($row['lastname']));
            echo '</td>';


            echo '<td>';
            echo ucwords(strtolower($row['email']));
            echo '</td>';

            echo '<td>';
            echo $row['joined'];
            echo '</td>';




            // echo '<td><a href="new_exam.php?id=';
            // echo $row['id'];
            // echo '&coursename=';
            // echo ucwords(strtolower($row['title']));
            // echo '"><i class="fa fa-plus"></i></a></td>';

            // echo '<td><a href="edit_admin.php?id=';
            // echo $row['id'];
            // echo '"';
            // echo '>';
            // echo '<i class="fa fa-edit"></i></a></td>';


            if ($row['id'] == 1 || $row['id'] == 6) {
                echo '<td></td>';
            } else {
                echo '<td><a href="delete_admin.php?id=';
                echo $row['id'];
                echo '"';
                // echo 'data-toggle="modal" data-target="#deleteModal"';
                echo '><i class="fa fa-trash"></i></a></td>';
            }

            echo '</tr>';
        }
    } else {
        echo '<tr>Though Impossible, there are no admins yet</tr>';
    }
}

/**
 * Delete an admin from the database
 * 
 * Deletes an admin from the database, using their unique id.
 * 
 * @param int $id
 * Unique id for each row in the admin database table, used to accurately identify the desired row.
 */
function deleteAdmin($id)
{
    global $db;
    if ($id == 1) {
        header("location:admins.php");
    } else {
        //This sql statement deletes the course with the mentioned id
        $sql = "DELETE FROM `admins`  WHERE admins.id = '$id' ";
        if (mysqli_query($db, $sql)) {
            header("location:admins.php");
        } else {
            //header("location:course_detail.php?exam_id=$id&coursename=$course");
            header("location:courses.php");
        }
    }
    //mysqli_close($db);
}

/**
 * Shows active page for link groups
 * 
 * Shows that a link under a link group is active by checking through an array of pages under that particular link group.
 * 
 * @param array $pages
 * List of pages/links under a link group. If the current page is contained in the array, then that link group is active.
 * 
 * @return void
 * Echoes 'active' if the page is found.
 */
function findActivePage($pages)
{
    for ($i = 0; $i < count($pages); $i++) {

        if (strpos($_SERVER["PHP_SELF"], $pages[$i])) {
            echo 'active';
        }
    }
}

/**
 * Load/print paystack javascript code
 * 
 * This is the paystack javascript code containing all the functions it needs, including the API keys. For security reasons, it has to be echoed from here.
 * 
 * @return void
 * Simply echoes javascript code for paystack
 */
function loadPaystackCode()
{
    $paystackCode = "<script>
    const paymentForm = document.getElementById('paymentForm');

    paymentForm.addEventListener('submit', payWithPaystack, false);

    function payWithPaystack(e) {

        e.preventDefault();

        let handler = PaystackPop.setup({

            //pk_test_1048ab7f91600dfe9fbda1e16e191b778302a6b7
            //pk_live_21bba98bf9a683dc3215452aa76419d4204ce121

            key: 'pk_live_21bba98bf9a683dc3215452aa76419d4204ce121', // Replace with your public key

            //email: document.getElementById('email-address').value,
            email: 'nomail@mail.com',

            //amount: document.getElementById('amount').value * 100,
            amount: getGrossTotalPrice() * 100,

            // ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you

            // label: 'Customer'

            onClose: function() {

                //alert('Window closed.');

            },

            callback: function(response) {

                let message = 'Payment complete! Reference: ' + response.reference;
                //clearProductTable();
                //deleteAllCartItems();
                window.location = 'admin/verify_transaction.php?reference=' + response.reference + '&cart=' + getJsonFromObject(getProductsInLocalStorage());
                //alert(message);

            }

        });

        handler.openIframe();

        }</script>";

    return $paystackCode;
}

/**
 * Verifies paystack payment
 * 
 * Uses a reference code passed into the get superglobal array to verify payments. After a user finishes paying, another page opens('verify_transaction.php') that makes sure we received the payment. if yes it takes us to the payment confirmed page('payment_confirmed.php'). If not it takes us to the payment_error.php page.
 * 
 * @return void
 * If all goes well, another function is run to show the results
 */
function verifyPayment()
{
    if (isset($_GET['reference'])) {
        $reference = $_GET['reference'];
    }
    $curl = curl_init();

    curl_setopt_array($curl, array(

        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_ENCODING => "",

        CURLOPT_MAXREDIRS => 10,

        CURLOPT_TIMEOUT => 30,

        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

        CURLOPT_CUSTOMREQUEST => "GET",

        CURLOPT_HTTPHEADER => array(

            "Authorization: Bearer sk_live_eb443ca5a5686ca06797b9bbccd044f9d9e97e70",

            "Cache-Control: no-cache",

        ),

    ));


    $response = curl_exec($curl);

    $err = curl_error($curl);

    curl_close($curl);


    if ($err) {
        echo "cURL Error #:" . $err;
    } else {

        // $number = rand(100, 100000);
        // $t = time();
        // $random = $number . '' . $t;



        // $response = '{
        //     "status": true,
        //     "message": "Verification successful",
        //     "data": {
        //       "id": ' . $random . '6,
        //       "domain": "test",
        //       "status": "success",
        //       "reference": "nms6uvr1pl",
        //       "amount": 15600,
        //       "message": null,
        //       "gateway_response": "Successful",
        //       "paid_at": "2022-01-19T12:30:56.000Z",
        //       "created_at": "2022-01-19T12:26:44.000Z",
        //       "channel": "card",
        //       "currency": "NGN",
        //       "ip_address": "154.118.28.239",
        //       "metadata": "",
        //       "log": {
        //         "start_time": 1589891451,
        //         "time_spent": 6,
        //         "attempts": 1,
        //         "errors": 0,
        //         "success": true,
        //         "mobile": false,
        //         "input": [],
        //         "history": [
        //           {
        //             "type": "action",
        //             "message": "Attempted to pay with card",
        //             "time": 5
        //           },
        //           {
        //             "type": "success",
        //             "message": "Successfully paid with card",
        //             "time": 6
        //           }
        //         ]
        //       },
        //       "fees": 300,
        //       "fees_split": {
        //         "paystack": 300,
        //         "integration": 40,
        //         "subaccount": 19660,
        //         "params": {
        //           "bearer": "account",
        //           "transaction_charge": "",
        //           "percentage_charge": "0.2"
        //         }
        //       },
        //       "authorization": {
        //         "authorization_code": "AUTH_xxxxxxxxxx",
        //         "bin": "408408",
        //         "last4": "4081",
        //         "exp_month": "12",
        //         "exp_year": "2020",
        //         "channel": "card",
        //         "card_type": "visa DEBIT",
        //         "bank": "Test Bank",
        //         "country_code": "NG",
        //         "brand": "visa",
        //         "reusable": true,
        //         "signature": "SIG_xxxxxxxxxxxxxxx",
        //         "account_name": null
        //       },
        //       "customer": {
        //         "id": 24259516,
        //         "first_name": null,
        //         "last_name": null,
        //         "email": "customer@email.com",
        //         "customer_code": "CUS_xxxxxxxxxxx",
        //         "phone": null,
        //         "metadata": null,
        //         "risk_action": "default"
        //       },
        //       "plan": null,
        //       "order_id": null,
        //       "paidAt": "2020-05-19T12:30:56.000Z",
        //       "createdAt": "2020-05-19T12:26:44.000Z",
        //       "requested_amount": 20000,
        //       "transaction_date": "2020-05-19T12:26:44.000Z",
        //       "plan_object": {},
        //       "subaccount": {
        //         "id": 37614,
        //         "subaccount_code": "ACCT_xxxxxxxxxx",
        //         "business_name": "Cheese Sticks",
        //         "description": "Cheese Sticks",
        //         "primary_contact_name": null,
        //         "primary_contact_email": null,
        //         "primary_contact_phone": null,
        //         "metadata": null,
        //         "percentage_charge": 0.2,
        //         "settlement_bank": "Guaranty Trust Bank",
        //         "account_number": "0123456789"
        //       }
        //     }
        //   }';
        //echo '<pre>';
        //echo $response;
        if (isset($_GET['cart'])) {
            $cart = $_GET['cart'];
        } else {
            $cart = null;
        }

        processVerifyTransactionResult($response, $cart);
    }
}

/**
 * Reads through the paystack json response and stores in the database
 * 
 * Processes the json transaction results passed in through the admin/functions/functions.php/verifyPayment(). 
 * 
 * @param string $response
 * A json string containing all the info concerning a transaction, including the amount paid, time paid, charges, account paid from etc.
 * @param string $cart
 * A json string containing all the items bought by the user from the store.
 * 
 * @return void
 * If the transaction was successful, run the next function that stores all the info in the database, if not send the user back to the user home page.
 */
function processVerifyTransactionResult($response, $cart)
{
    $phpclassresponse = json_decode($response, true);

    $status = $phpclassresponse['data']['status'];
    $redeem_code = $phpclassresponse['data']['id'];
    $amount = $phpclassresponse['data']['amount'];
    $channel = $phpclassresponse['data']['channel'];
    $ip = $phpclassresponse['data']['ip_address'];
    $paid_at = $phpclassresponse['data']['paid_at'];
    $created_at = $phpclassresponse['data']['created_at'];
    $fees = $phpclassresponse['data']['fees'];
    $full_transaction_info_json = json_encode($phpclassresponse);

    // echo '<pre>';
    // print_r($phpclassresponse);
    // gotoPage('payment_confirmed.php?redeem_code=' . $phpclassresponse['message']);

    //$phpclassresponse['status'] === 'false' 
    if ($phpclassresponse['data']['status'] === 'success') {
        addTransactionDetail($status, $redeem_code, $cart, $amount, $channel, $ip, $paid_at, $created_at, $fees, $full_transaction_info_json);
    } else {
        gotoPage('../index.php');
    }
}

/**
 * Store transaction response in database
 * 
 * Stores the paystack API response(including the redeem code) into the database for future reference.
 * 
 * @param string $status
 * Contains 'true' if the transaction was successful
 * @param string $redeem_code
 * Unique code/identifier for particular purchase/transaction. It's also whats given to users to use for redeeming their goods.
 * @param string $cart_items
 * Cart items the user paid for from the store.
 * @param string $amount
 * Total amount charged for the sale.
 * @param string $channel
 * Channel through which customer paid. It can be through ussd, debit card transfer etc.
 * @param string $ip
 * The users ip address as at time of payment.
 * @param string $paid_at
 * Time the users payment was successfully made.
 * @param string $created_at
 * Time the user started the transaction, whether successful or not.
 * @param string $fees
 * Fees charged for processing the transaction.
 * @param string $full_transaction_info_json
 * Full json response for further reference.
 * 
 * @return void
 * Sends the user to the payment confirmed page: admin/payment_confirmed.php if all goes well.
 */
function addTransactionDetail($status, $redeem_code, $cart_items, $amount, $channel, $ip, $paid_at, $created_at, $fees, $full_transaction_info_json)
{
    $cart_items_decoded = json_decode($cart_items, true);

    for ($i = 0; $i < sizeof($cart_items_decoded); $i++) {
        $id = $cart_items_decoded[$i]['id'];
        $quantity = $cart_items_decoded[$i]['quantity'];
        updateStockAndSold($id, $quantity);
    }

    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $sql = "INSERT INTO transactions(status, redeem_code, cart_items, 	amount, 	channel, 	ip, 	paid_at, 	created_at, 	fees, full_transaction_info_json) VALUES ('$status', '$redeem_code', '$cart_items', '$amount', '$channel', '$ip', '$paid_at', '$created_at', '$fees', '$full_transaction_info_json')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['ProductJustAdded'] = 1;
        //gotoPage("products.php");
        gotoPage('payment_confirmed.php?redeem_code=' . $redeem_code);
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
        // die;
    }
    //mysqli_close($db);
}

/**
 * Update product stock and sold details
 * 
 * Updates the stock and sold details in the database by reducing from the stock when an item is bought and increasing the number of that item sold.
 * 
 * @param int $id
 * Unique identifier for the product in the database.
 * @param int $quantity
 * The quantity being bought in that particular transaction.
 * 
 * @return true
 * Returns true if database operation was successful.
 */
function updateStockAndSold($id, $quantity)
{
    //this gets the previous stock of the item and subtracts the current quantity being bought
    $oldStock = getCurrentStock($id);
    $newStock = $oldStock - $quantity;
    if ($newStock < 0) {
        $newStock = 0;
    }

    //this gets the previous sold amount of the item and adds the current quantity being bought
    $oldSold = getCurrentSold($id);
    $newSold = $oldSold + $quantity;


    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `item` SET `stock` = '$newStock', `sold` = '$newSold' WHERE `item`.`id` = '$id' ";

    if (mysqli_query($db, $sql)) {
        return true;
        //gotoPage('../product_summary.php?fin=true');
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Get the stock of a particular product
 * 
 * Gets the value of stock a particular product in the product('item') table.
 * 
 * @param int $id
 * Unique identifier for product in the database.
 * 
 * @return int
 * Returns the product stock.
 */
function getCurrentStock($id)
{
    global $db;

    //get current stock
    $oldStock = 0;

    $query = "SELECT stock FROM item WHERE id = $id";
    $result = mysqli_query($db, $query);
    if (!$result) {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    } else {
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $oldStock = $row['stock'];
            }
        }
        // $total_visitors = mysqli_num_rows($result);
    }
    return $oldStock;
}

/**
 * Get number of items sold, for a particular product
 * 
 * Gets number of items sold, from the sold column in the products table.
 * 
 * @param int $id
 * Unique identifier for a product in the database.
 * 
 * @return int
 * Returns number of items sold for said product.
 */
function getCurrentSold($id)
{
    global $db;

    //get current sold items
    $oldSold = 0;

    $query = "SELECT sold FROM item WHERE id = $id";
    $result = mysqli_query($db, $query);
    if (!$result) {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    } else {
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $oldSold = $row['sold'];
            }
        }
        // $total_visitors = mysqli_num_rows($result);
    }
    return $oldSold;
}

/**
 * Updates transaction details in the database.
 * 
 * Adds some extra details to the transaction table. these details are name and phone number which are not compulsory.
 * 
 * @param string $redeem_code
 * Unique code used to identify the sale/transaction made.
 * @param string $name
 * Name of the person making the transaction.
 * @param string $phone
 * Phone number of the person making the transaction.
 * 
 * @return void
 * Sends the user to the product summary page if all went well. echoes an error message if all didnt go well.
 */
function UpdateTransactionDetail($redeem_code, $name, $phone)
{
    $name = trim(Sanitize($name));
    $phone = trim(Sanitize($phone));

    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `transactions` SET `customer_name` = '$name', `customer_phone` = '$phone' WHERE `transactions`.`redeem_code` = '$redeem_code' ";

    if (mysqli_query($db, $sql)) {
        gotoPage('../product_summary.php?fin=true');
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Validate a redeem code
 * 
 * This validates and gets all the info for a particular redeem code. It is used mainly by the admins, to confirm a user has made a purchase and handover their items to them.
 * 
 * @param array $formstream
 * This is a post super global array, containing the info passed into the form on the admin/verify_transaction.php page.
 * 
 * @return void|array
 * If the redeem code is valid, the user will be sent to a page detailing all the transaction info. if not a datamissing array containing the error will be returned.
 */
function processRedeemCode($formstream)
{
    extract($formstream);
    global $db;


    if (isset($submit)) {

        $result = mysqli_query($db, "SELECT * FROM transactions WHERE redeem_code ='$redeem_code' AND status = 'success' ORDER BY `id` DESC      ");

        if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 1) {
            $result = $result->fetch_assoc();

            $_SESSION['username'] = $result['id'];

            if ($result['redeemed'] == 0) {
                gotoPage('showcart.php?redeem_id=' . $result['id'] . '&' . 'redeem_code=' . $result['redeem_code'] . '&' . 'customer_name=' . $result['customer_name'] . '&' . 'customer_phone=' . $result['customer_phone'] . '&' . 'cart=' . $result['cart_items']);
            } else {
                $datamissing['redeem_error'] = 'Items have already been redeemed by the customer';
                return $datamissing;
            }
        } else {

            //     echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            //     <strong>Holy guacamole!</strong> Your username or password are incorrect.
            //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //       <span aria-hidden="true">&times;</span>
            //     </button>
            //   </div>';
            $datamissing['redeem_error'] = 'Redeem code is Invalid';
            return $datamissing;
        }
    }
}

/**
 * Layout the transaction info gotten from the redeem code into a table.
 * 
 * Parses through all the return variables, and lays them out in a clean table at the admin/showcart.php page. It also incorporates some price and item validation.
 * 
 * @param string $jsonCart
 * A json string containing all the info about the transaction, including the items, total price, quantity etc.
 * 
 * @return void
 * If all goes well, all the items will be accurately rendered into a table.
 */
function layoutCart($jsonCart)
{
    $phpClassCart = json_decode($jsonCart, true);
    $itemsCount = count($phpClassCart);
    $confirmed = true;
    $total = 0;

    for ($i = 0; $i < $itemsCount; $i++) {
        $id = $phpClassCart[$i]['id'];
        $price = $phpClassCart[$i]['price'];
        $discount = $phpClassCart[$i]['discount'];
        $title = $phpClassCart[$i]['title'];
        $quantity = $phpClassCart[$i]['quantity'];
        $tax = $phpClassCart[$i]['tax'];
        $temptotal = ($price - $discount + $tax) * $quantity;
        $total += $temptotal;

        if (confirmItemData($id, $price, $discount, $tax) == true) {
            echo ' <tr>
            <td>' . $quantity . '</td>
            <td>' . $title . '</td>
            <td class="text-success">' . $temptotal . '</td>
            <td>' . getRealItemPrice($id, $quantity) . '</td>
        </tr>';
        } else {
            echo ' <tr>
           
            <td>' . $quantity . '</td>
            <td>' . $title . '</td>
            <td class="text-danger">' . $temptotal . '</td>
            <td>' . getRealItemPrice($id, $quantity) . '</td>
        </tr>';
        }
    }
}

/**
 * Gets the most basic info of the transaction.
 * 
 * Gets all the basic things of the transaction through the redeem code. including the name, phone number and total amount paid. The amount is also validated to make sure they correspond with everything.
 * 
 * @param string $jsonCart
 * A json string containing all the info about the transaction, including the items, total price, quantity etc.
 * 
 * @return void
 * Renders all the basic info if all goes well.
 */
function getCartBasicInfo($jsonCart)
{
    $phpClassCart = json_decode($jsonCart, true);
    $itemsCount = count($phpClassCart);
    $confirmed = true;
    $total = 0;

    echo ' <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h3 class="h4 mb-0 text-gray-800">Number of Items:  ' . $itemsCount . '</h3></div>';

    for ($i = 0; $i < $itemsCount; $i++) {
        $id = $phpClassCart[$i]['id'];
        $price = $phpClassCart[$i]['price'];
        $discount = $phpClassCart[$i]['discount'];
        $quantity = $phpClassCart[$i]['quantity'];
        $tax = $phpClassCart[$i]['tax'];
        $temptotal = ($price - $discount + $tax) * $quantity;
        $total += $temptotal;

        if (confirmItemData($id, $price, $discount, $tax) == true) {
        } else {
            $confirmed = false;
        }
    }

    if ($confirmed == true) {
        echo '<div class="d-sm-flex align-items-center justify-content-between mb-4">
             <h3 class="h4 mb-0 text-success">Total paid: ' . $total . '</h3>
         </div>';
    } else {
        echo '<div class="d-sm-flex align-items-center justify-content-between mb-4">
             <h3 class="h4 mb-0 text-danger">Total paid: ' . $total . '</h3>
         </div>';
    }
}

/**
 * Confirms if purchase data correspond with proprietary data
 * 
 * Confirms if the data in a transaction is accurate and not tampered with. This context is in the case an item price is tampered with by a user, the payment would go through but when processed by our admins, any difference made will immediately be identified and the purchase/transaction will immediately be nullified.
 * 
 * @param int $id
 * The unique identifier for the transaction in the database.
 * @param int $price
 * The price for a particular product.
 * @param int $discount
 * The discount for a particular product.
 * @param int $tax
 * The tax for a particular product.
 * 
 * @return bool
 * If all is well and all info is accurate, it returns true. The opposite is the case if something is wrong.
 *  */
function confirmItemData($id, $price, $discount, $tax)
{
    global $db;
    $sql = "SELECT * FROM `item` WHERE `id`='$id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        if ($price == $result['price'] && $tax == $result['tax'] && $discount == $result['discount']) {
            //nothing has been tampered with
            return true;
        } else {
            //something is wrong somewhere
            //return $result['price'] + $result['tax'] - $result['discount'];
            return false;
        }
    } else {
        //something is definitely wrong somewhere;
        return false;
    }
}

/**
 * Gets valid item price multiplied by the quantity
 * 
 * Get valid and up to date price from the database, then multiplies it by a quantity. The result is used for transaction validation.
 * 
 * @param int $id
 * Unique identifier for product in the database.
 * @param int $quantity
 * The quantity of a particular product bought by a customer.
 * 
 * @return int
 * Returns the product of price and quantity, returns 0 if something goes wrong.
 */
function getRealItemPrice($id, $quantity)
{
    global $db;
    $sql = "SELECT * FROM `item` WHERE `id`='$id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        return ($result['price'] - $result['discount'] + $result['tax']) * $quantity;
    } else {
        //something is definitely wrong somewhere;
        return 0;
    }
}


/**
 * Shows an item has been redeemed or retrieved by the customer
 * 
 * Updates the database row of a particular of transaction to show the item has been retrieved by the customer.
 * 
 * @param string $redeem_id
 * Unique identifier for a particular transaction row in the database table.
 * 
 * @return void
 * Sends the admin to the admin/redeem.php page if all goes well.
 */
function finish_redeem($redeem_id)
{
    global $db;
    $sql = "UPDATE `transactions` SET `redeemed` = 1 WHERE `transactions`.`id` = '$redeem_id' ";

    if (mysqli_query($db, $sql)) {
        gotoPage('redeem.php');
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    //mysqli_close($db);
}

/**
 * Gets product title
 * 
 * Gets the title of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes title if its found and echoes an error if it isnt.
 */
function loadProductTitle($id)
{
    global $db;

    $query = "SELECT title FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['title'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Returns the product title as a string
 * 
 * Returns the title of a particular product in the database as a string.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return string|void
 * returns title if its found and echoes an error if it isnt.
 */
function getProductTitle($id)
{
    global $db;

    $query = "SELECT title FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            return $row['title'];
        }
    } else {
        echo $id;
        echo ' Error! title Not found.';
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);

        //die;
    }
}

/**
 * Returns product price
 * 
 * Returns the price of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return int|void
 * Returns price if its found and echoes an error if it isnt.
 */
function getProductPrice($id)
{
    global $db;

    $query = "SELECT price FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            return $row['price'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Returns product specifications summary
 * 
 * Returns the specifications summary of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return string|void
 * Returns specifications summary if its found and echoes an error if it isnt.
 */
function getProductSpec_summary($id)
{
    global $db;

    $query = "SELECT spec_summary FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            return $row['spec_summary'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Returns product main image
 * 
 * Returns the main image of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return string
 * Returns main image if its found and echoes an error if it isnt.
 */
function getProductMainImage($id)
{
    global $db;

    $query = "SELECT main_img FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            return $row['main_img'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * echoes product specifications summary
 * 
 * echoes the specifications summary of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes specifications summary if its found and echoes an error if it isnt.
 */
function loadSpecSummary($id)
{
    global $db;

    $query = "SELECT spec_summary FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['spec_summary'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * echoes product main image
 * 
 * echoes the main image of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes main image if its found and echoes an error if it isnt.
 */
function loadProductImage1($id)
{
    global $db;

    $query = "SELECT main_img FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['main_img'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * echoes product side image 1
 * 
 * echoes the side image 1 of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes side image 1 if its found and echoes an error if it isnt.
 */
function loadProductImage2($id)
{
    global $db;

    $query = "SELECT side_img1 FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['side_img1'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * echoes product side image 2
 * 
 * echoes the side image 2 of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes side image 2 if its found and echoes an error if it isnt.
 */
function loadProductImage3($id)
{
    global $db;

    $query = "SELECT side_img2 FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['side_img2'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * echoes product side image 3
 * 
 * echoes the side image 3 of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes side image 3 if its found and echoes an error if it isnt.
 */
function loadProductImage4($id)
{
    global $db;

    $query = "SELECT side_img3 FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            echo $row['side_img3'];
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * echoes product full specifications
 * 
 * echoes the full specifications of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes full specifications if its found and echoes an error if it isnt.
 */
function loadFullSpecs($id)
{
    global $db;

    $query = "SELECT full_spec FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $fullspecs = json_decode(html_entity_decode($row['full_spec']), true);
            //    echo '<pre>';
            //    print_r($fullspecs);
            for ($i = 0; $i < count($fullspecs); $i++) {
                echo '<tr class="techSpecRow">';
                echo '<td class= "techSpecTD1">' . $fullspecs[$i]["title"] . '</td>';
                echo '<td class = "techSpecTD2">' . $fullspecs[$i]["value"] . '</td>';
                echo '</tr>';
            }

            //echo html_entity_decode($row['full_spec']);
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * echoes product colors
 * 
 * echoes the colors of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes colors if its found and echoes an error if it isnt.
 */
function loadProductColors($id)
{
    global $db;

    $query = "SELECT colors FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $colors = json_decode(html_entity_decode($row['colors']), true);
            //    echo '<pre>';
            //    print_r($fullspecs);
            for ($i = 0; $i < count($colors); $i++) {
                echo '<tr class="techSpecRow">';
                echo '<td class= "techSpecTD1">' . $colors[$i]["title"] . '</td>';
                // echo '<td class = "techSpecTD2">' . $colors[$i]["value"] . '</td>';
                echo '</tr>';
            }

            //echo html_entity_decode($row['full_spec']);
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * echoes product features
 * 
 * echoes the features of a particular product in the database.
 * 
 * @param int $id
 * Unique identifier for product in the product table.
 * 
 * @return void
 * echoes features if its found and echoes an error if it isnt.
 */
function loadProductFeatures($id)
{
    global $db;

    $query = "SELECT features FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            //echo $row['features'];

            //echo html_entity_decode( ucwords(strtolower($row['features'])));
            echo html_entity_decode(ucwords($row['features']));
            //echo ucwords(strtolower($string));
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Loads all products under a particular category, renders in the block looking form.
 * 
 * Shows only products under a particular category, by checking if a product matches before showing them to the user.
 * 
 * @param string $category
 * Particular category the product must be under. Eg Laptops
 * 
 * @return void
 * Renders the products that match the category. If none are found it echoes 'Not found'
 */
function loadProductsWithCategories($category)
{
    global $db;

    $query = "SELECT * FROM item";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            //echo $row['side_img3'];
            if (!validateProductCategory($category, html_entity_decode($row['categories']))) {
            } else {
                echo ' <li class="span3">
        <div class="thumbnail">
            <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
            <div class="caption">
                <h5>' . $row['title'] . '</h5>
                <p>' . $row['spec_summary'] . '
                </p>
    
                <h4 style="text-align:center">
                    <a class="btn" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a>
                    <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                </h4>
            </div>
        </div>
        </li>';
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Loads all products under a particular category, renders in text looking form.
 * 
 * Shows only products under a particular category, by checking if a product matches before showing them to the user.
 * 
 * @param string $category
 * Particular category the product must be under. Eg Laptops
 * 
 * @return void
 * Renders the products that match the category. If none are found it echoes 'Not found'
 */
function loadProductsWithCategoriesBlock($category)
{
    global $db;

    $query = "SELECT * FROM item";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            //echo $row['side_img3'];
            // if($category != 'ALL'){

            if (!validateProductCategory($category, html_entity_decode($row['categories']))) {
            } else {
                echo '
    <div class="row">
	<div class="span2">
    <img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" />	</div>
	<div class="span4">
    <h3>' . $row['title'] . '</h3>
		<hr class="soft" />
		<p>' . $row['spec_summary'] . '
                </p>
		<a class="btn btn-small pull-right" href="product_details.php?id=' . $row['id'] . '">View Details</a>
		<br class="clr" />
	</div>
	<div class="span3 alignR">
		<form class="form-horizontal qtyFrm">
			<h3><script>nairaFormat(' . $row['price'] . ')</script></h3>
			<br />
			
		</form>
	</div>
    </div><hr class="soft" />';
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Echoes the javascript add to cart code/function
 * 
 * Loads the javascript add to cart code with all the details needed for it to work, including the title, id and image.
 * 
 * @param int $id
 * Unique identifier for each product in the database.
 * 
 * @return void
 * Renders the javascript code, into the product block if all goes well. shows an error if it doesnt work.
 */
function loadProductCartInfo($id)
{
    global $db;

    $query = "SELECT * FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {

            echo "getProductData('";

            echo $row['main_img'];
            echo "', ";

            echo $row['discount'];
            echo ", '";

            echo $row['title'];
            echo "', ";

            echo $row['price'];
            echo ", ";

            echo  $row['id'];
            echo ", ";

            echo 1;
            echo ", ";

            echo $row['tax'];

            echo ");";

            //echo html_entity_decode($row['full_spec']);
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Returns the javascript add to cart code as a string
 * 
 * Returns the javascript add to cart code/function with all the details needed for it to work, including the title, id and image.
 * 
 * @param int $id
 * Unique identifier for each product in the database.
 * 
 * @return string|void
 * Returns the javascript code, as a string if all goes well and shows an error if it doesnt work.
 */
function returnProductCartInfo($id)
{
    global $db;

    $query = "SELECT * FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {

            $jsCartFunction = "getProductData('" . $row['main_img'] . "', " . $row['discount'] . ", '" . $row['title'] . "', " . $row['price'] . ", " .  $row['id'] . ", " . 1 . ", " . $row['tax'] . ');"';

            return $jsCartFunction;
            //echo html_entity_decode($row['full_spec']);
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Loads/echoes the latest 10 products in block form
 * 
 * Loads products by order of last created, and loads only 10 at once so the home page isnt slowed.
 * 
 * @param int $id
 * [optional]
 * 
 * Unique identifier for products in the database. If passed in, the function loads only that particular product.
 */
function loadLatestProducts($id = null)
{
    //this loads up all the latest products in the database
    global $db;
    if ($_SERVER["PHP_SELF"] == '/tats/index.php') {
        $itemLimit = 10;
    } else {
        $itemLimit = 10000;
    }


    $query = "SELECT * FROM item ORDER BY created desc";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        if (isset($id)) {
            while ($row = mysqli_fetch_array($response)) {
                //echo $row['side_img3'];
                if ($row['stock'] > 0) {
                    if ($row['id'] == $id) {
                    } else {
                        echo ' <li class="span3">
            <div class="thumbnail">
                <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
                <div class="caption">
                    <h5>' . $row['title'] . '</h5>
                    <p>' . $row['spec_summary'] . '
                    </p>

                    <h4 style="text-align:center">
                    <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                </h4>
                </div>
            </div>
        </li>';
                    }
                } //end of stock checker
            }
        } else {
            $count = 0;

            while ($row = mysqli_fetch_array($response)) {
                if ($row['stock'] > 0) {
                    if ($count != $itemLimit) {
                        //echo $row['side_img3'];

                        echo ' <li class="span3">
        <div class="thumbnail">
            <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
            <div class="caption">
                <h5>' . $row['title'] . '</h5>
                <p>' . $row['spec_summary'] . '
                </p>
    
                <h4 style="text-align:center">
                    <a class="btn" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a>
                    <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                </h4>
            </div>
        </div>
    </li>';
                        $count++;
                    }
                } //end of stock checker
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Loads/echoes the latest 10 products in text form
 * 
 * Loads products by order of last created, and loads only 10 at once so the home page isnt slowed.
 * 
 * @param int $id
 * [optional]
 * 
 * Unique identifier for products in the database. If passed in, the function loads only that particular product.
 */
function loadLatestProductsBlock($id = null)
{

    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
    global $db;

    if ($_SERVER["PHP_SELF"] == '/tats/index.php') {
        $itemLimit = 10;
    } else {
        $itemLimit = 10000;
    }

    $query = "SELECT * FROM item ORDER BY created desc";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {

        if (isset($id)) {
            while ($row = mysqli_fetch_array($response)) {
                //echo $row['side_img3'];
                if ($row['stock'] > 0) {

                    if ($row['id'] == $id) {
                    } else {
                        echo '
                    <hr class="soft" /><div class="row">
                    <div class="span2">
                    <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>	</div>
                    <div class="span4">
                    <h3>' . $row['title'] . '</h3>
                        <hr class="soft" />
                        <p>' . $row['spec_summary'] . '
                                </p>
                        <a class="btn btn-small pull-right" href="product_details.php?id=' . $row['id'] . '">View Details</a>
                        <br class="clr" />
                    </div>
                    <div class="span3 alignR">
                            <h3><script>nairaFormat(' . $row['price'] . ')</script></h3>
                    </div>
                    </div>';
                    }
                } //end of stock checker
            }
        } else {
            $count = 0;
            while ($row = mysqli_fetch_array($response)) {
                if ($row['stock'] > 0) {
                    if ($count != $itemLimit) {
                        echo '
    <hr class="soft" /><div class="row">
	<div class="span2">
    <img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" />	</div>
	<div class="span4">
    <h3>' . $row['title'] . '</h3>
		<hr class="soft" />
		<p>' . $row['spec_summary'] . '
                </p>
		<a class="btn btn-small pull-right" href="product_details.php?id=' . $row['id'] . '">View Details</a>
		<br class="clr" />
	</div>
	<div class="span3 alignR">
		<form class="form-horizontal qtyFrm">
			<h3><script>nairaFormat(' . $row['price'] . ')</script></h3>
			<br />
			<div class="btn-group">
                
               
			</div>
		</form>
	</div>
    </div>';
                        $count++;
                    }

                    // echo '<a class="btn btn-large btn-primary" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a> <a href="product_summary.php?id=' . $row['id'] . '" class="btn btn-large"> Go to <i class=" icon-shopping-cart"></i></a>';
                } //end of stock checker
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Load related products to the one referenced in block form
 * 
 * Loads all products related to the one referenced. This works by getting all the referenced products categories, then loading all the products under each of them, without repeating any.
 * 
 * @param int $id
 * Unique identifier for product in database.
 * 
 * @return void
 * Echoes all products related to one referenced.
 */
function loadRelatedProducts($id)
{
    global $db;
    $productsArray = getIdsOfProductsUnderCategories(getParticularProductCategories($id), $id);

    $query = "SELECT * FROM item ORDER BY updated desc";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        if (isset($id)) {
            while ($row = mysqli_fetch_array($response)) {
                if ($row['stock'] > 0) {
                    if (in_array($row['id'], $productsArray)) {
                        //echo $row['side_img3'];

                        echo ' <li class="span3">
        <div class="thumbnail">
            <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
            <div class="caption">
                <h5>' . $row['title'] . '</h5>
                <p>' . $row['spec_summary'] . '
                </p>
    
                <h4 style="text-align:center">
                    <a class="btn" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a>
                    <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                </h4>
            </div>
        </div>
    </li>';
                    }
                } //end of stock checker
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Load related products to the one referenced in text form
 * 
 * Loads all products related to the one referenced. This works by getting all the referenced products categories, then loading all the products under each of them, without repeating any.
 * 
 * @param int $id
 * Unique identifier for product in database.
 * 
 * @return void
 * Echoes all products related to one referenced.
 */
function loadRelatedProductsBlock($id)
{
    global $db;
    $productsArray = getIdsOfProductsUnderCategories(getParticularProductCategories($id), $id);

    $query = "SELECT * FROM item ORDER BY updated desc";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    if ($response) {
        if (isset($id)) {
            while ($row = mysqli_fetch_array($response)) {
                if ($row['stock'] > 0) {
                    if (in_array($row['id'], $productsArray)) {
                        //echo $row['side_img3'];

                        echo '
    <hr class="soft" /><div class="row">
	<div class="span2">
    <img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" />	</div>
	<div class="span4">
    <h3>' . $row['title'] . '</h3>
		<hr class="soft" />
		<p>' . $row['spec_summary'] . '
                </p>
		<a class="btn btn-small pull-right" href="product_details.php?id=' . $row['id'] . '">View Details</a>
		<br class="clr" />
	</div>
	<div class="span3 alignR">
		<form class="form-horizontal qtyFrm">
			<h3><script>nairaFormat(' . $row['price'] . ')</script></h3>
			<br />
			<div class="btn-group">
                
               
			</div>
		</form>
	</div>
    </div>';
                    }
                } //end of stock checker
            }
        }
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Get all product categories
 * 
 * Combines all product categories stored in json, and converts them into a php array or object.
 * 
 * @return array|void
 * returns an array containing all categories or echoes an error message if something goes wrong.
 */
function getAllProductCategories()
{
    global $db;
    $allCategories = [];
    $query = "SELECT categories FROM item";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $categories = json_decode(html_entity_decode($row['categories']), true);
            //    echo '<pre>';
            //    print_r($fullspecs);

            array_push($allCategories, $categories);

            //echo html_entity_decode($row['full_spec']);
        }
        //    echo '<pre>';
        //    print_r($allCategories);
        return $allCategories;
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Gets a products categories
 * 
 * Gets the products categories stored as json in the database then converts it to a php array or object.
 * 
 * @param int $id
 * Unique identifier for product in the database.
 * 
 * @return array|void
 * Returns products category as array or echoes an error message if something goes wrong.
 */
function getParticularProductCategories($id)
{
    global $db;
    $allCategories = [];
    $query = "SELECT categories FROM item WHERE id = $id";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $categories = json_decode(html_entity_decode($row['categories']), true);
        }
        return $categories;
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Get id's of products under a list of categories
 * 
 * Gets id's of products under a category array by scanning through the database for products that match, skipping the product id for which the search was initiated. This helps in the loading of related products.
 * 
 * @param array $categories
 * An array containing all the categories relevant for the operation.
 * @param int $parentId
 * Unique identifier for a particular product that must be skipped in the search. In the case of this product, where looking for its related products.
 * 
 * @return array|void
 * Returns array containing the id's of the products that matched or an echoed error if something goes wrong.
 */
function getIdsOfProductsUnderCategories($categories, $parentId)
{
    global $db;
    $idsOfProductsUnderCategory = [];

    $query = "SELECT * FROM item";
    $response = @mysqli_query($db, $query);
    // echo returnProductCartInfo(7);
    // die;
    for ($i = 0; $i < count($categories); $i++) {
        if ($response) {
            while ($row = mysqli_fetch_array($response)) {
                //echo $row['side_img3'];
                if (validateProductCategory($categories[$i]['title'], html_entity_decode($row['categories']))) {
                    if (!in_array($row['id'], $idsOfProductsUnderCategory) && $row['id'] != $parentId) {
                        array_push($idsOfProductsUnderCategory, $row['id']);
                    }
                }
            }
        } else {
            echo 'Error! Not found.';
            die;
        }
    }
    return $idsOfProductsUnderCategory;
}

/**
 * Cleans array of all product categories
 * 
 * Formats all product categories by sorting them and removing repetitions.
 * 
 * @param array $allCategories
 * Array containing all the dirty categories, about to be cleaned.
 * 
 * @return array
 * returns cleaned array containing all categories.
 */
function formatAllProductCategories($allCategories)
{
    $allCategoriesFormatted = [];
    for ($i = 0; $i < count($allCategories); $i++) {
        for ($j = 0; $j < count($allCategories[$i]); $j++) {

            if (in_array($allCategories[$i][$j]['title'], $allCategoriesFormatted) == false) {
                array_push($allCategoriesFormatted, $allCategories[$i][$j]['title']);
            }
        }
    }
    // echo '<pre>';
    //print_r($allCategoriesFormatted);
    sort($allCategoriesFormatted, SORT_DESC);

    return $allCategoriesFormatted;
}

/**
 * Load all product categories into the sidebar
 * 
 * Gets all the categories for all products then renders them into links at the sidebar.
 * 
 * @return void
 * Echo categories, wrapped in links, wrapped in lists.
 */
function loadCategories()
{
    $allCategories = formatAllProductCategories(getAllProductCategories());
    $active = '';
    for ($i = 0; $i < count($allCategories); $i++) {

        if ($i == 0) {
            $active = 'active';
        } else {
            $active = '';
        }

        echo '<li><a class="' . $active . '" href="products.php?category=' . $allCategories[$i] . '"><i class="icon-chevron-right"></i>' . $allCategories[$i] . ' [' . numberOfProductsUnderCategory($allCategories[$i]) . ']</a></li>';
    }
}

/**
 * Gets number of products under a category
 * 
 * Counts through an array of all categories, then searches for the number of products that match the category.
 * 
 * @param string $category
 * Category used to search for products.
 * 
 * @return int
 * Returns the number of products found or 0 if none. 
 */
function numberOfProductsUnderCategory($category)
{
    $allCategories = getAllProductCategories();
    $count = 0;
    for ($i = 0; $i < count($allCategories); $i++) {
        for ($j = 0; $j < count($allCategories[$i]); $j++) {
            //array_push($allCategoriesFormatted, $allCategories[$i][$j]['title']);
            if ($category == $allCategories[$i][$j]['title']) {
                $count++;
            }
        }
    }
    //echo '<pre>';
    //print_r($allCategoriesFormatted);
    return $count;
}

/**
 * Finds if a category exists in a products category group.
 * 
 * Works by comparing a single category string to a json array containing seperate categories. In this applications context, it checks if a product belongs to a single category. A product usually has up to 3 categories.
 * 
 * @param string $category
 * Single category used to validate a product's category group.
 * @param string $categoryjson
 * A products category group in json.
 * 
 * @return bool
 * returns true if the product belongs to the category or false if it doesnt.
 */
function validateProductCategory($category, $categoryjson)
{
    $productCategories = json_decode($categoryjson, true);
    $result = false;
    for ($i = 0; $i < count($productCategories); $i++) {
        if ($category == $productCategories[$i]['title']) {
            $result = true;
        }
    }
    //echo $result;
    return $result;
}


/**
 * Get total number of products
 * 
 * Queries the database for all products, then counts through the result array.
 * 
 * @return int|void
 * Returns number of products found, echoes an error message if something wrong occurs.
 */
function getTotalNumberOfProducts()
{
    global $db;
    $allProducts = 0;
    $query = "SELECT * FROM item";
    $response = @mysqli_query($db, $query);

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $allProducts++;
        }
        return $allProducts;
    } else {
        echo 'Error! Not found.';
        die;
    }
}

/**
 * Load all product categories into the topbar
 * 
 * Gets all the categories for all products then renders them into links at the topbar.
 * 
 * @return void
 * Echo categories, wrapped in links, wrapped in lists.
 */
function loadTopBarCategories()
{

    $allCategories = formatAllProductCategories(getAllProductCategories());
    $active = '';
    for ($i = 0; $i < count($allCategories); $i++) {

        if ($i == 0) {
            $active = 'active';
        } else {
            $active = '';
        }

        echo '<li><a class="" href="products.php?category=' . $allCategories[$i] . '">' . $allCategories[$i] . ' [' . numberOfProductsUnderCategory($allCategories[$i]) . ']</a></li>';
    }
}

/**
 * Load all product categories into the search section
 * 
 * Gets all the categories for all products then renders them into links at the search section as a dropdown to help narrow down the search accuracy.
 * 
 * @return void
 * Echo categories, wrapped in links, wrapped in lists.
 */
function loadSearchBarCategories()
{

    $allCategories = formatAllProductCategories(getAllProductCategories());
    $active = '';
    for ($i = 0; $i < count($allCategories); $i++) {

        if ($i == 0) {
            $active = 'active';
        } else {
            $active = '';
        }
        echo '<option value="' . $allCategories[$i] . '">' . $allCategories[$i] . '</option>';
    }
}

/**
 * Show product search result
 * 
 * Searches through the database for matches to what the user input in the search bar. It uses categories as well to make the search more straight forward.
 * 
 * @param array $formstream
 * Post superglobal array containing entries by the user in the search bar.
 * 
 * @return array|void
 * Echoes search result if found. Returns datamissing array showing errors if error occurs. If nothing is found and no error occurs, it echoes 'not found'.
 */
function loadProductSearchResults($formstream)
{
    global $db;
    extract($formstream);
    $category = '0';

    if (!empty($name)) {

        //if (!empty($category)) {

        $wordsAry = explode(" ", $name);
        $wordsCount = count($wordsAry);
        for ($i = 0; $i < $wordsCount; $i++) {

            $queryCondition = "WHERE title LIKE '%" . $wordsAry[$i] . "%' OR spec_summary LIKE '%" . $wordsAry[$i] . "%' ";

            if ($i != $wordsCount - 1) {
                $queryCondition .= " OR ";
            }
        }
        //  }
    } else {
        $name = "";
        $wordsAry = explode(" ", $name);
        $wordsCount = count($wordsAry);
        for ($i = 0; $i < $wordsCount; $i++) {

            $queryCondition = "WHERE title LIKE '%" . $wordsAry[$i] . "%' OR spec_summary LIKE '%" . $wordsAry[$i] . "%' ";

            if ($i != $wordsCount - 1) {
                $queryCondition .= " OR ";
            }
        }
    }



    $orderby = " ORDER BY id desc";
    //echo $queryCondition;
    $sql = "SELECT * FROM item " . $queryCondition . $orderby;

    $checker = null;
    $response = @mysqli_query($db, $sql);
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            if ($row['stock'] > 0) {
                //     if (validateProductCategory($category, html_entity_decode($row['categories'])) && 2 < 1) {
                //         $checker = $row['id'];
                //         echo ' <li class="span3">
                //     <div class="thumbnail">
                //         <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
                //         <div class="caption">
                //             <h5>' . $row['title'] . '</h5>
                //             <p>' . $row['spec_summary'] . '
                //             </p>

                //             <h4 style="text-align:center">

                //                 <a class="btn " href="product_summary.php">&#8358;' . $row['price'] . '</a>
                //             </h4>
                //         </div>
                //     </div>
                // </li>';
                //  } elseif ($category == '0') {
                $checker = $row['id'];
                echo ' <li class="span3">
               <div class="thumbnail">
                   <a href="product_details.php?id=' . $row['id'] . '"><img src="product_images/' . $row['main_img'] . '" alt="picture of ' . $row['title'] . '" /></a>
                   <div class="caption">
                       <h5>' . $row['title'] . '</h5>
                       <p>' . $row['spec_summary'] . '
                       </p>
           
                       <h4 style="text-align:center">
                       
                       <a class="btn" id="cartToggleButton' . $row['id'] . '" onclick="' . returnProductCartInfo($row['id']) . '>Add to <i class="icon-shopping-cart"></i></a>
                           <a class="btn btn-primary" href="product_summary.php"><script>nairaFormat(' . $row['price'] . ')</script></a>
                       </h4>
                   </div>
               </div>
           </li>';
                // }
            } //end of stock checker
        }
        if ($checker == null) {
            echo '<li>Not found</li>';
        }
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
}

/**
 * (incomplete) Dynamically load pagination
 * 
 * Reads through the get super global array to know the location exact location that is active. It does this by dividing by ten.
 * 
 * @param int $pag
 * [optional]
 * 
 * Value used to know the particular pagination link active. It divides this by 10. If not set, the page is automatically assumed to be at one.
 */
function loadPagination($pag = null)
{

    if (isset($pag)) {
        // if ($pag == 'prev') {
        //ceil(getTotalNumberOfProducts() / 10)
        // }
        if ($pag < 5) {
            $modulus = $pag % 5;
        } else {
            $modulus = 0;
        }
        $level = $pag - $modulus;
        $level = $level/10;
        $level++;
        //echo $level;
        //Prev button
        //echo ceil(getTotalNumberOfProducts() / 10);
        if ($level > 5) {
            $prev = ($level - 5);
            echo '<li><a href="index.php?pag=' . $prev . '>Prev</a></li>';
        } else {
            echo '<li class="disabled"><a>Prev</a></li>';
        }

        for ($i = $level; $i <= ceil(getTotalNumberOfProducts() / 10); $i++) {
            echo '<li><a href="index.php?pag=' . $i . '">' . $i . '</a></li>';
        }

        //Next button
        if ($level >= ceil(getTotalNumberOfProducts() / 10)) {
            echo '<li class="disabled"><a>Next</a></li>';
        } else {
            $next = ((int)$level + (int)5);
            echo '<li><a href="index.php?pag="' . $next . '>Next</a></li>';
        }
        // echo '<li class="disabled"><a href="#">Prev</a></li>
        // 	<li class="active"><a href="#">1</a></li>
        // 	<li><a href="#">2</a></li>
        // 	<li><a href="#">3</a></li>
        // 	<li><a href="#">4</a></li>
        // 	<li><a href="#">Next</a></li>';






    } else {
        for ($i = 0; $i < ceil(getTotalNumberOfProducts() / 10); $i++) {
            // echo '<li><a href="#">'.$i.'</a></li>';
        }
    }
}

/**
 * Return total monthly income
 * 
 * Sums through all monthly transactions made in the current month, and returns the result.
 * 
 * @return int
 * Returns total monthly income as int.
 */
function getTotalMonthlyIncome()
{
    global $db;
    $allProducts = 0;
    $query = "SELECT * FROM transactions";
    $response = @mysqli_query($db, $query);
    $total = 0;

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {

            $currentmonth = date("Y-m");
            $paidmonth = date("Y-m", strtotime($row['created']));
            // 

            if ($paidmonth == $currentmonth) {
                $total += $row['amount'];
            }
        }
    }
    return $total;
}

/**
 * Return total yearly income
 * 
 * Sums through all monthly transactions in the current year, and returns the result.
 * 
 * @return int
 * Returns total yearly income as int.
 */
function getTotalYearlyIncome()
{
    global $db;

    $query = "SELECT * FROM transactions";
    $response = @mysqli_query($db, $query);
    $total = 0;

    if ($response) {
        while ($row = mysqli_fetch_array($response)) {

            $currentyear = date("Y");
            $paidyear = date("Y", strtotime($row['paid_at']));
            // 

            if ($paidyear == $currentyear) {
                $total += $row['amount'];
            }
        }
    }
    return $total;
}

/**
 * Get income for the twelve months of the year
 * 
 * Gets income for each month from january to december, arrange and return as a json. Used mainly for the admin dashboard for income charts.
 * 
 * @return string
 * Returns json array containing all income made for each of the twelve months.
 */
function getAllTwelveMonthsIncome()
{

    global $db;
    $query = "SELECT * FROM transactions";
    $response = @mysqli_query($db, $query);
    $amountArray = [];
    $dateArray = [];
    $allMonthsReport = '';

    //echo '------outside-loop<br>';
    if ($response) {

        while ($row = mysqli_fetch_array($response)) {
            array_push($amountArray, $row['amount']);
            array_push($dateArray, $row['created']);
        }

        //loop through january to february and get their total amounts
        for ($j = 1; $j <= 12; $j++) {
            $totalMonthly = 0;
            //echo '------looping through month' . $j . '<br>';
            //echo '<pre>';
            //print_r($amountArray);

            //loop through all transactions and get total amount for a single month
            for ($i = 0; $i < sizeof($amountArray); $i++) {
                //echo '------inside main loop, count ' . $i . '<br>';
                //$currentmonth = date("Y-m");

                if ($j < 10) {
                    $currentmonth = '2022-0' . $j;
                } else {
                    $currentmonth = '2022-' . $j;
                }


                //echo '------the year is ' . $currentmonth . '<br>';
                $paidmonth = date("Y-m", strtotime($dateArray[$i]));

                if ($paidmonth == $currentmonth) {
                    $totalMonthly += $amountArray[$i];
                }
            }

            //check if total monthly amount is valid, if yes add it to all report
            $allMonthsReport .= $totalMonthly . ', ';
            //echo $totalMonthly;
            //echo $allMonthsReport;
            // echo '<br><br><br>';
        } //end of for loop
    }
    return $allMonthsReport;
}

/**
 * Generate random string/number
 * 
 * Generates random string/number, using date and time.
 * 
 * @return string|int
 * Returns random number as a string or an integer.
 */
function generateTrulyRandomNumber()
{
    $number = rand(100, 100000);
    $t = time();
    $random = $number . '' . $t;
    return $random;
}

/**
 * Deletes invalid images
 * 
 * Deletes invalid images located in the product images folder by checking whose names arent found in the database.
 * 
 * @return void
 * Deletes any invalid images if found.
 */
function deleteDuplicateImages()
{
    global $db;
    $validImages = [];

    $query = "SELECT main_img, side_img1, side_img2, side_img3  FROM item";
    $response = @mysqli_query($db, $query);
    if ($response) {
        //this loops through the whole product images and stores all their images in a single array. This array will then be used to validate the false images
        while ($row = mysqli_fetch_array($response)) {
            array_push($validImages, $row['main_img'], $row['side_img1'], $row['side_img2'], $row['side_img3']);
        }

        //the next three lines gets all the files in the product_images folder and stores their names in an array
        $path = 'product_images/';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));

        //this takes a single image from all the ones in the folder, and checks if they are contained in the valid images array, if not they are deleted.
        foreach ($files as $file) {
            //echo "<a href='product_images/$file'>$file</a><br>";
            if (!in_array($file, $validImages, true)) {
                echo "$file deleted<br>";
                unlink("product_images/" . $file);
            }
        }
    }
}

/**
 * Load page metadata.
 * 
 * Loads unique page metadata for each page, based on what is passed in. 
 * 
 * @param string $page
 * The unique key, used to identify a particular page.
 * @param  mixed $uniqueId
 * [optional]
 * 
 * Unique id used for some pages that show dynamic content, like a product details page for a particular product.
 * 
 * @return void
 * Loads/Echoes all the details needed for each particular page.
 */
function loadPageMetaData($page, $uniqueId = null)
{

    echo loadPageMetaTitle($page, $uniqueId = null);
    echo loadPageMetaDescription($page, $uniqueId = null);
    echo loadPageMetaUrl($page, $uniqueId = null);
    echo loadPageMetaImage($page, $uniqueId = null);
    echo loadPageMetaKeywords($page, $uniqueId = null);
    echo loadPageMetaType($page, $uniqueId = null);
}

/**
 * Load page title metadata.
 * 
 * Loads unique page title metadata for each page, based on what is passed in. 
 * 
 * @param string $page
 * The unique key, used to identify a particular page.
 * @param  mixed $uniqueId
 * [optional]
 * 
 * Unique id used for some pages that show dynamic content, like a product details page for a particular product.
 * 
 * @return void
 * Loads/Echoes all the details needed for each particular page.
 */
function loadPageMetaTitle($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here
            return '<title>I-Plan Store</title>';
            break;

        case 'contact':
            //code here
            return '<title>I-Plan Store Contact Page</title>';
            break;

        case 'faq':
            //code here
            return '<title>I-Plan Store Frequently Asked Questions</title>';
            break;

        case 'legal':
            //code here
            return '<title>I-Plan Store Legal Notice Page</title>';
            break;

        case 'product_details':
            if (isset($uniqueId)) {
                return '<title>Buy ' . ucwords(strtolower(getProductTitle($uniqueId)))  . ' on I-Plan Store at ' . getProductPrice($uniqueId) . ' Naira</title>';
            }
            //code here
            break;

        case 'cart':
            //code here
            return '<title>I-Plan Store Shopping Cart</title>';
            break;

        case 'products':
            //code here
            if (isset($uniqueId)) {
                return '<title>[' . numberOfProductsUnderCategory($uniqueId) . '] Products Under ' . ucwords(strtolower($uniqueId))  . ' at I-Plan Store</title>';
            } else {
                return '<title>All [' . getTotalNumberOfProducts() . '] products at I-Plan Store</title>';
            }
            break;

        case 'tac':
            return '<title>I-Plan Store Terms and Conditions</title>';
            //code here
            break;

        case 'register':
            return '<title>Register as an I-Plan Store Admin</title>';
            //code here
            break;

        case 'test':
            return '<title>Developer Test Page</title>';
            //code here
            break;

        case 'search':
            return '<title>Search Results</title>';
            //code here
            break;


            //////////////////////////////////////////////// ADMIN SECTION /////////////////////////////////////////////
        case 'admins':
            return '<title>I-Plan Store Admins Page</title>';
            //code here
            break;

        case 'dashboard':
            //code here
            return '<title>I-Plan Store Dashboard</title>';
            break;

        case 'login':
            //code here
            return '<title>I-Plan Store Login Page</title>';
            break;

        case 'new_product':
            //code here
            return '<title>Create New Product on I-Plan Store</title>';
            break;

        case 'payment_confirmed':
            //code here
            return '<title>Payment Confirmed on I-Plan Store</title>';
            break;

        case 'payment_error':
            //code here
            return '<title>Payment Error on I-Plan Store</title>';
            break;

        case 'admin_products':
            //code here
            return '<title>All Products on I-Plan Store</title>';
            break;

        case 'redeem':
            //code here
            return '<title>I-Plan Store Redeem Page</title>';
            break;

        case 'newpass':
            //code here
            return '<title>Set New I-Plan Store Password</title>';
            break;

        case 'forgotpass':
            //code here
            return '<title>Forgot I-Plan Store Password</title>';
            break;

        case 'showcart':
            //code here
            return '<title>Customer Items Redeem and Final Validations Page</title>';
            break;


        default:
            //incase all else fails. don't forget to end code with semicolon
            return '<title>I-Plan Store</title>';
    }
}

/**
 * Load page type metadata.
 * 
 * Loads unique page type metadata for each page, based on what is passed in. 
 * 
 * @param string $page
 * The unique key, used to identify a particular page.
 * @param  mixed $uniqueId
 * [optional]
 * 
 * Unique id used for some pages that show dynamic content, like a product details page for a particular product.
 * 
 * @return void
 * Loads/Echoes all the details needed for each particular page.
 */
function loadPageMetaType($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here

            break;

        case 'contact':
            //code here
            break;

        case 'faq':
            //code here
            break;

        case 'legal':
            //code here
            break;

        case 'product_details':
            //code here
            break;

        case 'cart':
            //code here
            break;

        case 'products':
            //code here
            break;

        case 'tac':
            //code here
            break;

        case 'test':
            //code here
            break;

            ////////////////////////////////////// ADMIN SECTION //////////////////////////////////////////////////////////
        case 'admins':
            //code here
            break;

        case 'dashboard':
            //code here
            break;

        case 'login':
            //code here
            break;

        case 'new_product':
            //code here
            break;

        case 'payment_confirmed':
            //code here
            break;

        case 'payment_error':
            //code here
            break;

        case 'admin_products':
            //code here
            break;

        case 'redeem':
            //code here
            break;

        case 'newpass':
            //code here
            break;

        case 'forgotpass':
            //code here
            break;

        case 'showcart':
            //code here
            break;

        default:
            //incase all else fails. don't forget to end code with semicolon

    } //end of switch statement
    return '<meta property="og:type" content="website">';
}

/**
 * Load page description metadata.
 * 
 * Loads unique page description metadata for each page, based on what is passed in. 
 * 
 * @param string $page
 * The unique key, used to identify a particular page.
 * @param  mixed $uniqueId
 * [optional]
 * 
 * Unique id used for some pages that show dynamic content, like a product details page for a particular product.
 * 
 * @return void
 * Loads/Echoes all the details needed for each particular page.
 */
function loadPageMetaDescription($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here
            return '<meta property="og:description" content="Welcome! This is an online store for electronics, computer gadgets and computers. We are located opposite Nnamdi Azikiwe Stadium Enugu, Nigeria." >';
            break;

        case 'contact':
            //code here
            return '<meta property="og:description" content="
            For complaints relating to unprocessed transactions or errors, feedback on how to better serve you, including suggestions and ideas on where you think we should improve, design and functionality feedback, strictly for people with coding experience or technical know how..." >';
            break;

        case 'faq':
            //code here
            return '<meta property="og:description" content="Home for questions frequently asked by our customers." >';
            break;

        case 'legal':
            //code here
            return '<meta property="og:description" content="For any legal doubts, please do well to read it." >';
            break;

        case 'product_details':
            //code here
            if (isset($uniqueId)) {
                return '<meta property="og:description" content="' . ucwords(strtolower(getProductSpec_summary($uniqueId))) . '" >';
            }
            break;

        case 'cart':
            //code here
            return '<meta property="og:description" content="Exactly as it sounds, its your shopping cart." >';
            break;

        case 'products':
            //code here
            return '<meta property="og:description" content="This page contains all the products I-Plan Store has to offer." >';
            break;

        case 'tac':
            //code here
            return '<meta property="og:description" content="We have little to no terms and conditions, but you can check out the few we do have." >';
            break;

        case 'register':
            //code here
            return '<meta property="og:description" content="As an admin, you will be able to create new products, edit or delete old ones. You will also be able to redeem customer products." >';
            break;

        case 'test':
            //code here
            return '<meta property="og:description" content="product testing is a really important part of software development." >';
            break;


            ///////////////////////////////////////////////////////// ADMIN SECTION ////////////////////////////////////////////////
        case 'admins':
            //code here
            return '<meta property="og:description" content="This page contains a list of all the admins who control how the site works." >';
            break;

        case 'dashboard':
            //code here
            return '<meta property="og:description" content="This page contains all the info you need on sales and the general overview of the site." >';
            break;

        case 'login':
            //code here
            return '<meta property="og:description" content="Input your email and password to access admin privileges" >';
            break;

        case 'new_product':
            //code here
            return '<meta property="og:description" content="Create a new product and add details like name, price, stock, discount etc." >';
            break;

        case 'payment_confirmed':
            //code here
            return '<meta property="og:description" content="Congratulations!!! Your payment has been confirmed and you can redeem your product at any of our stores or ask for a delivery. Thanks for your patronage." >';
            break;

        case 'payment_error':
            //code here
            return '<meta property="og:description" content="Oops!!! Seems your payment didnt go through... If you were debited, your funds will be refunded shortly" >';
            break;

        case 'admin_products':
            //code here
            return '<meta property="og:description" content="This is where all products can be created, updated or destroyed." >';
            break;

        case 'redeem':
            //code here
            return '<meta property="og:description" content="Enter the customers redeem code to view and validate their goods before delivery." >';
            break;

        case 'newpass':
            //code here
            return '<meta property="og:description" content="Input your new password. Do make sure not to forget it this time..." >';
            break;

        case 'forgotpass':
            //code here
            return '<meta property="og:description" content="Things happen, we get it, Just input your email and request for a new password." >';
            break;

        case 'showcart':
            //code here
            return '<meta property="og:description" content="Full summary of everything purchased by client" >';
            break;

        default:
            return '<meta property="og:description" content="I-Plan store page" >';

            //incase all else fails. don't forget to end code with semicolon
    } //end of switch statement
}

/**
 * Load page url metadata.
 * 
 * Loads unique page url metadata for each page, based on what is passed in. 
 * 
 * @param string $page
 * The unique key, used to identify a particular page.
 * @param  mixed $uniqueId
 * [optional]
 * 
 * Unique id used for some pages that show dynamic content, like a product details page for a particular product.
 * 
 * @return void
 * Loads/Echoes all the details needed for each particular page.
 */
function loadPageMetaUrl($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here

            break;

        case 'contact':
            //code here
            break;

        case 'faq':
            //code here
            break;

        case 'legal':
            //code here
            break;

        case 'product_details':
            //code here
            break;

        case 'cart':
            //code here
            break;

        case 'products':
            //code here
            break;

        case 'tac':
            //code here
            break;

        case 'test':
            //code here
            break;

        case 'admins':
            //code here
            break;

        case 'dashboard':
            //code here
            break;

        case 'login':
            //code here
            break;

        case 'new_product':
            //code here
            break;

        case 'payment_confirmed':
            //code here
            break;

        case 'payment_error':
            //code here
            break;

        case 'admin_products':
            //code here
            break;

        case 'redeem':
            //code here
            break;

        case 'newpass':
            //code here
            break;

        case 'forgotpass':
            //code here
            break;

        case 'showcart':
            //code here
            break;

        default:
            //incase all else fails. don't forget to end code with semicolon

    } //end of switch statement
    return '<meta property="og:url" content="http://store.techac.net">';
}

/**
 * Load page image metadata.
 * 
 * Loads unique page image metadata for each page, based on what is passed in. 
 * 
 * @param string $page
 * The unique key, used to identify a particular page.
 * @param  mixed $uniqueId
 * [optional]
 * 
 * Unique id used for some pages that show dynamic content, like a product details page for a particular product.
 * 
 * @return void
 * Loads/Echoes all the details needed for each particular page.
 */
function loadPageMetaImage($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'contact':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'faq':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'legal':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'product_details':
            //code here
            if (isset($uniqueId)) {
                return '<meta property="og:image" content="https://techac.net/tats/product_images/' . getProductMainImage($uniqueId) . '">';
            }
            break;

        case 'cart':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'products':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'tac':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'test':
            //code here

            break;



            ////////////////////////////////////////////////////////////ADMIN SECTION/////////////////////////////////////////////////////

        case 'admins':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'dashboard':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'login':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'new_product':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'payment_confirmed':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'payment_error':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'admin_products':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'redeem':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'newpass':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'forgotpass':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        case 'showcart':
            //code here
            return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
            break;

        default:
            //incase all else fails. don't forget to end code with semicolon

    } //end of switch statement
    // return '<meta property="og:image" content="https://techac.net/tats/themes/images/iplan_square.jpg">';
}

/**
 * Load page keywords metadata.
 * 
 * Loads unique page metadata for each page, based on what is passed in. 
 * 
 * @param string $page
 * The unique key, used to identify a particular page.
 * @param  mixed $uniqueId
 * [optional]
 * 
 * Unique id used for some pages that show dynamic content, like a product details page for a particular product.
 * 
 * @return void
 * Loads/Echoes all the details needed for each particular page.
 */
function loadPageMetaKeywords($page, $uniqueId = null)
{
    switch ($page) {

        case 'home':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';
            break;

        case 'contact':
            //code 
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, contact us,  contact, phone number, address">';
            break;

        case 'faq':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, faq, frequently asked questions">';
            break;

        case 'legal':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, legal notice">';
            break;

        case 'product_details':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, ' . ucwords(strtolower(getProductTitle($uniqueId))) . '">';
            break;

        case 'cart':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, cart, shopping cart">';
            break;

        case 'products':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, products">';
            break;

        case 'tac':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, terms and conditions">';
            break;

        case 'test':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';
            break;

        case 'admins':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, admins">';
            break;

        case 'dashboard':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';
            break;

        case 'login':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, login">';
            break;

        case 'new_product':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, products, create products">';
            break;

        case 'payment_confirmed':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, payment confirmed, confirmed, payed">';
            break;

        case 'payment_error':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, error">';
            break;

        case 'admin_products':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, admin products, cms, admin">';
            break;

        case 'redeem':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, redeem">';
            break;

        case 'newpass':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';
            break;

        case 'forgotpass':
            //code here
            break;

        case 'showcart':
            //code here
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops, set new password, new, password, new password">';
            break;

        default:
            return  '<meta property="keywords" content="computers, iplan, i-plan technologies, electronics, computers, repairs, laptops">';

            //incase all else fails. don't forget to end code with semicolon
    } //end of switch statement

}


// switch ($page) {

//     case 'home':
//         //code here

//         break;

//     case 'contact':
//         //code here
//         break;

//     case 'faq':
//         //code here
//         break;

//     case 'legal':
//         //code here
//         break;

//     case 'product_details':
//         //code here
//         break;

//     case 'cart':
//         //code here
//         break;

//     case 'products':
//         //code here
//         break;

//     case 'tac':
//         //code here
//         break;

//     case 'test':
//         //code here
//         break;

//     default:
//         //incase all else fails. don't forget to end code with semicolon
// } //end of switch statement


// <title>TA TECH BLOG ADMIN HOME PAGE</title>
//     <meta name="description" content= 'Tech Acoustic Tech Blog ADMIN HOME' ">
//     <!-- <meta property='og:title' content="tats HOME"> -->
//     <meta property='og:url' content="https://techac.net/tats">
//     <!-- <meta property='og:image' itemprop="image" content="https://techac.net/tats/assets/images/mike.jpg"> -->
//     <meta property='keywords' content="Admin, home, Tech Acoustic, TA, tats, Tech Blog, Tech, Science, Computers">
//     <!-- <meta property='og:locale' content="">
// 	<meta property='og:type' content=""> -->



// $path = './';
// $files = scandir($path);
// $files = array_diff(scandir($path), array('.', '..'));
// foreach($files as $file){
// echo "<a href='$file'>$file</a>";
// }


         
// if (!is_dir("../product_images/".$row['main_img'])) {
//     //mkdir("../product_images", 0755);
//     unlink("../product_images/" . $_SESSION['editImage1']);
//     unlink("../product_images/" . $_SESSION['editImage2']);
//     unlink("../product_images/" . $_SESSION['editImage3']);
//     unlink("../product_images/" . $_SESSION['editImage4']);
// } else {
   
// }


//     }

//https://localhost/tats/admin/showcart.php?redeem_id=11&redeem_code=690075529&customer_name=Orji Michael&customer_phone=08148863871&cart=[{"image":"4.jpg","discount":700,"title":"Camera","price":15000,"quantity":1,"id":7,"tax":200},{"image":"7.jpg","discount":500,"title":"32 Gig USB","price":4500,"quantity":1,"id":8,"tax":100}]