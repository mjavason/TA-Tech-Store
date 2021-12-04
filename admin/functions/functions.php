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
                unlink("../product_images/" . $_SESSION['editImage1']);
                unlink("../product_images/" . $_SESSION['editImage2']);
                unlink("../product_images/" . $_SESSION['editImage3']);
                unlink("../product_images/" . $_SESSION['editImage4']);

                EditProduct($editId, $title, $price, $stock, $discount, $tax, $specsummary, $specsjson, $colorsjson, $categoriesjson, $features, $imagename, $imagename1, $imagename2, $imagename3);
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

//adds the prepared data into the database
function AddProduct($title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features, $mi, $si1, $si2, $si3)
{
    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $admin = 1; //$_SESSION['admin_id'];
    $sql = "INSERT INTO item(title, 	price, stock, 	discount,	tax,  spec_summary, full_spec, colors, categories, features, main_img, side_img1, side_img2, side_img3, created_by) VALUES ('$title', '$price', '$stock', '$discount', '$tax', '$specsummary', '$fullspecs', '$colors', '$categories', '$features', '$mi', '$si1', '$si2', '$si3', '$admin')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['ProductJustAdded'] = 1;
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
            echo '<p class="text-center">No Products Added Yet</p>';
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

//READ end


// UPDATE start

function EditProduct($id, $title, $price, $stock, $discount, $tax, $specsummary, $fullspecs, $colors, $categories, $features, $mi, $si1, $si2, $si3)
{
    //This simply adds the filtered and cleansed data that is edited into the database 
    global $db;
    $sql = "UPDATE `item` SET `title` = '$title', `price` = '$price',  `stock` = '$stock', `discount` = '$discount', `tax` = '$tax', `spec_summary` = '$specsummary', `full_spec` = '$fullspecs', `colors` = '$colors', `categories` = '$categories', `features` = '$features', `main_img` = '$mi', `side_img1` = '$si1', `side_img2` = '$si2', `side_img3` = '$si3' WHERE `item`.`id` = $id ";
    //$sql = "INSERT INTO posts(title, 	blog_post, 	imagename,	minread, 	tags 	) VALUES ('$title', '$bp', '$imagename', '$minread', '$tag')";

    if (mysqli_query($db, $sql)) {
        //$_SESSION['postJustAdded'] = 1;
        $_SESSION['editproduct'] = null;
        gotoPage("products.php");
    } else {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    mysqli_close($db);
}

//UPDATE end

//DELETE start

function deleteProduct($id, $imagename, $imagename1, $imagename2, $imagename3)
{
    global $db;

    //This sql statement deletes the course with the mentioned id
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
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    mysqli_close($db);
}


//DELETE end

//checks if the input mail exists in the admins database. if it exists return false, if not return true
function validateMailAddress($email)
{
    global $db;
    $sql = "SELECT * FROM `admins` WHERE `email`='$email'";
    $result = $db->query($sql);
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

function processNewAdmin($formstream, $editId = null)
{
    //This function processes what user data is being stored and checks if they are accurate or entered at all.
    //It also helps in confirming if what the user entered is Okay, like someone entering two different things in the password and confirm password box
    extract($formstream);

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

        //facebook
        if (empty($facebook)) {
            $datamissing['facebook'] = "Missing facebook profile page";
        } else {
            $facebook = trim(Sanitize($facebook));
        }

        //twitter
        if (empty($twitter)) {
            $datamissing['twitter'] = "Missing twitter page";
        } else {
            $twitter = trim(Sanitize($twitter));
        }

        //instagram
        if (empty($instagram)) {
            $datamissing['instagram'] = "Missing instagram page";
        } else {
            $instagram = trim(Sanitize($instagram));
        }

        //linkedin
        if (empty($linkedin)) {
            $datamissing['linkedin'] = "Missing Linkedin page";
        } else {
            $linkedin = trim(Sanitize($linkedin));
        }

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

            addRegistered($firstname, $lastname, $email, $password, $facebook, $twitter, $linkedin, $instagram);
        } else {
            return $datamissing;
        }
    }
}

function addRegistered($fname, $lname, $em, $pass, $facebook, $twitter, $linkedin, $instagram)
{
    //This simply adds the filtered and cleansed data into the database 
    global $db;
    $sql = "INSERT INTO admins(  	firstname, 	lastname,	email, 	password, 	facebook, 	twitter, 	linkedin, 	instagram 	) VALUES ('$fname', '$lname', '$em', '$pass', '$facebook', '$twitter', '$linkedin', '$instagram')";

    if (mysqli_query($db, $sql)) {
        $_SESSION['registered'] = "true";
        gotoPage("login.php");
        //echo "New record created successfully";
    } else {
        //echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
    }
    mysqli_close($db);
}

function processLogin($formstream)
{
    //This simply queries the database to see if the users data is really available then sets the users data to a session to show theyve logged in
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
            }

            setcookie("mem_mail",  $_SESSION['email'], time() + (10 * 365 * 24 * 60 * 60));

            // echo "<pre>";
            // print_r($_COOKIE);
            // die;

            // echo "<br>";
            // echo 'Logged In';
            // echo "<pre>";
            // print_r($result);
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

function getAdminName()
{
    $id = $_SESSION['admin_id'];
    global $db;

    $query = "SELECT lastname, firstname FROM admins WHERE id = $id";
    $result = mysqli_query($db, $query);
    if (!$result) {
        echo  "<br>" . "Error: " . "<br>" . mysqli_error($db);
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

function loadAdmins()
{
    //This loads up all the courses available and fills their links/options with the required items so they can be worked on and used to get more data on that particular course
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


            if ($row['id'] == 1) {
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
    mysqli_close($db);
}

function findActivePage($pages){
    for ($i = 0; $i < count($pages); $i++) {

    if (strpos($_SERVER["PHP_SELF"], $pages[$i])) {
        echo 'active';
    }
}
}
