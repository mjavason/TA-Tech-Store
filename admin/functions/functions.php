<?php
//This starts a session for the entire project
session_start();

//This takes me to any page i want
function gotoPage($location)
{
    header('location:' . $location);
    exit();
}

//This cleans any data i'm accepting. Removing security vulnerabilities and bugs
function Sanitize($data, $case = null)
{
    //This function cleanses and arranges the data about to be stored. like freeing it from any impurities like sql injection
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

//CREATE start

//this collects and prepares all the data entered for a new post for storage
function processNewProduct($formstream, $editId = null)
{
    //This function processes what user data is being stored and checks if they are accurate or entered at all.
    //It also helps in confirming if what the user entered is Okay, like someone entering two different things in the password and confirm password box
    extract($formstream);

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
            $datamissing['st'] = "Missing product stock";
        } else {
            $stock = htmlentities($stock, ENT_QUOTES);
        }


        if (empty($discount)) {
            $datamissing['d'] = "Missing product discount";
        } else {
            $discount = trim(Sanitize($discount));
        }

        if (empty($tax)) {
            $datamissing['t'] = "Missing product tax";
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
            $datamissing['mainimage'] = "Missing Main Product Image";
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


            $filename =  $_FILES['mi']['tmp_name'];

            $tmpfilename = basename($_FILES['mi']['name']);
            $filetype = pathinfo($tmpfilename, PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes)) {

                //upload file to server
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
            $datamissing['sideimage1'] = "Missing First Side Product Image";
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
            $datamissing['sideimage2'] = "Missing Second Side Product Image";
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
            $datamissing['sideimage3'] = "Missing Third Side Product Image";
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
                unlink("../product_images/" . $_SESSION['editImage']);
                EditPost($editId, $title, $bp, $tag, $imagename, $minread);
                $_SESSION['editpost'] = null;
            } else {
                AddPost($title, $price, $stock, $discount, $tax, $specsummary, $specsjson, $colorsjson, $categoriesjson, $features, $imagename, $imagename1, $imagename2, $imagename3);
                // die;
            }
        } else {
            return $datamissing;
        }
    }
}

//adds the prepared data into the database
function AddPost($title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features, $mi, $si1, $si2, $si3)
{
    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $admin = 1; //$_SESSION['admin_id'];
    $sql = "INSERT INTO item(title, 	price, stock, 	discount,	tax,  spec_summary, full_spec, colors, categories, features, main_img, side_img1, side_img2, side_img3, created_by) VALUES ('$title', '$price', '$stock', '$discount', '$tax', '$specsummary', '$fullspecs', '$colors', '$categories', '$features', '$mi', '$si1', '$si2', '$si3', '$admin')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['postJustAdded'] = 1;
        gotoPage("products.php");
    } else {

        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
        die;
    }
    mysqli_close($db);
}

//CREATE end

//READ start

function loadProducts()
{
    global $db;
    // $user = $_SESSION['username'];
    // if (!empty($user)) {
    $query = "SELECT id, title, price, stock, sold, 	discount,	tax,  spec_summary, full_spec, colors, categories, features, main_img, side_img1, side_img2, side_img3, created_by  FROM item ORDER BY `id` DESC ";
    $response = @mysqli_query($db, $query);
    if ($response) {
        while ($row = mysqli_fetch_array($response)) {
            $checker = $row['id'];

            adminProductView($row);
        }
        if (empty($checker)) {
            echo '<p class="text-center">No Posts Added Yet</p>';
        }
    }
    //}
}

function adminProductView($productsArray)
{
    //id===========================
    echo '<tr><td>';
    echo $productsArray['id'];
    echo '</td>';

    //title============================
    echo  '<td>';
    $string = substr($productsArray['title'], 0, 25);
    echo ucwords(strtolower($string));
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
    echo $productsArray['stock'];
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

    echo '&spec_summary=';
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

    echo '&tax=';
    echo ucwords(strtoupper($productsArray['colors']));

    echo '&fullspec=';
    echo ucwords(strtoupper($productsArray['full_spec']));

    echo '&sold=';
    echo ucwords(strtoupper($productsArray['sold']));

    echo '&categories=';
    echo ucwords(strtoupper($productsArray['categories']));

    echo '&image1=';
    echo ucwords(strtoupper($productsArray['main_img']));

    echo '&image2=';
    echo ucwords(strtoupper($productsArray['side_img1']));

    echo '&image3=';
    echo ucwords(strtoupper($productsArray['side_img2']));

    echo '&image4=';
    echo ucwords(strtoupper($productsArray['side_img3']));


    echo '&edit=1';

    echo '">';
    echo '<i class="fa fa-edit"></i></a></td>';


    //delete
    echo '<td><a href="deletepost.php?id=';
    echo $productsArray['id'];
    echo '"';
    echo '><i class="fa fa-trash"></i></a></td>';

    echo '</tr>';

    return true;
}
//READ end

function EditPost($id, $title, $bp, $tag, $imagename, $minread)
{
    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `posts` SET `title` = '$title', `blog_post` = '$bp', `imagename` = '$imagename', `minread` = '$minread', `tags` = '$tag' WHERE `posts`.`id` = $id ";
    //$sql = "INSERT INTO posts(title, 	blog_post, 	imagename,	minread, 	tags 	) VALUES ('$title', '$bp', '$imagename', '$minread', '$tag')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['postJustAdded'] = 1;
        $_SESSION['editpost'] = null;
        gotoPage("products.php");
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    mysqli_close($db);
}

//shows all the entries in the datamissing array or just a success message if everything went well
function showDataMissing($datamissing, $showSuccess = null)
{
    //this function checks if the datamissing array passed in is empty. if it isnt it prints out all of its contents. if it is empty nothing happens
    if (isset($datamissing)) {
        foreach ($datamissing as $miss) {
            echo '<p class="text-danger">';
            echo $miss;
            echo '</p>';
        }
    } elseif (isset($showSuccess)) {
        echo '<p class="text-success">';
        echo "Successful";
        echo '</p>';
    }
}
