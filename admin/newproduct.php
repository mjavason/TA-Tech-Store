<?php
require_once "config/connect.php";
require_once "functions/functions.php";

if (!isset($_SESSION['log'])) {
    gotoPage("login.php");
}

if (isset($_GET['edit'])) {
    $_SESSION['editpost'] = true;
    $_SESSION['editId'] = $_GET['id'];
    $_SESSION['editImage1'] = $_GET['image1'];
    $_SESSION['editImage2'] = $_GET['image2'];
    $_SESSION['editImage3'] = $_GET['image3'];
    $_SESSION['editImage4'] = $_GET['image4'];
}

if (isset($_SESSION['editpost'])) {
    $datamissing = processNewProduct($_POST, $_SESSION['editId']);
    // print_r($datamissing);
    //  die;
} else {
    $datamissing = processNewProduct($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>CREATE NEW POST TATB</title>
    <meta name="description" content="<?= 'Create new post on TATB' ?>">
    <!-- <meta property='og:title' content="TATB HOME"> -->
    <meta property='og:url' content="https://techac.net/tatb">
    <!-- <meta property='og:image' itemprop="image" content="https://techac.net/tatb/assets/images/mike.jpg"> -->
    <meta property='keywords' content="Tech Acoustic, TA, TATB, Tech Blog, Tech, Science, Computers">
    <!-- <meta property='og:locale' content="">
	<meta property='og:type' content=""> -->

    <?php
    require_once('includes/head.php');
    ?>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/ckeditor/ckeditor.js"></script>

    <style>
        .jsonformatted,
        .jsondiv {
            /* display: none; */
            background-color: white;
            color: white;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        require_once('includes/sidebar.php');
        ?>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                require_once('includes/topbar.php');
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Create New Product</h1>
                    </div>


                    <main>

                        <div class="centered p-4">
                            <?php
                            //showDataMissing($datamissing);
                            ?>
                            <!--  -->
                            <!-- "functions/test.php" <?= $_SERVER['PHP_SELF'] ?>-->
                            <form action="" method="post" enctype="multipart/form-data">

                                <!-- title -->
                                <div class="mb-5">
                                    <label for="title">Product Title</label>
                                    <input type="text" name="title" id="title" class="container" required <?php
                                                                                                            if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                                                                echo 'value="';
                                                                                                                echo $_GET['title'];
                                                                                                                echo '"';
                                                                                                            }
                                                                                                            ?>>
                                </div>

                                <!-- price -->
                                <div class="mb-5">
                                    <label for="price">Product Price</label>
                                    <input type="number" name="price" id="price" class="container" required <?php
                                                                                                            if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                                                                echo 'value="';
                                                                                                                echo $_GET['price'];
                                                                                                                echo '"';
                                                                                                            }
                                                                                                            ?>>
                                </div>

                                <!-- stock -->
                                <div class="mb-5">
                                    <label for="price">Product Stock</label>
                                    <input type="number" name="stock" id="stock" class="container" required <?php
                                                                                                            if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                                                                echo 'value="';
                                                                                                                echo $_GET['stock'];
                                                                                                                echo '"';
                                                                                                            }
                                                                                                            ?>>
                                </div>

                                <!-- discount -->
                                <div class="mb-5">
                                    <label for="discount">Product Price Discount</label>
                                    <input type="number" name="discount" id="discount" class="container" required <?php
                                                                                                                    if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                                                                        echo 'value="';
                                                                                                                        echo $_GET['discount'];
                                                                                                                        echo '"';
                                                                                                                    }
                                                                                                                    ?>>
                                </div>

                                <!-- tax -->
                                <div class="mb-5">
                                    <label for="tax">Product Tax Rate</label>
                                    <input type="number" name="tax" id="tax" class="container" required <?php
                                                                                                        if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                                                            echo 'value="';
                                                                                                            echo $_GET['tax'];
                                                                                                            echo '"';
                                                                                                        }
                                                                                                        ?>>
                                </div>

                                <!-- spec summary -->
                                <div class="mb-5">
                                    <label for="specsummary">Product Spec Summary</label>
                                    <input type="text" name="specsummary" id="specsummary" class="container" required <?php
                                                                                                                        if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                                                                            echo 'value="';
                                                                                                                            echo $_GET['specsummary'];
                                                                                                                            echo '"';
                                                                                                                        }
                                                                                                                        ?>>
                                </div>

                                <!-- full specs -->
                                <div class="mb-5">
                                    <label for="fullspecs">Product Specs <?php
                                                                            // if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                            //     echo '(Leave blank if you dont want to change the old values.)';
                                                                            // } 
                                                                            ?></label>

                                    <div class="mb-1"><input placeholder="E.g RAM" type="text" name="fullspecs" id="fullspecs" class="container"></div>
                                    <div class="mb-1"> <input type="text" placeholder="E.g 4 Gigabytes" name="fullspecs" id="fullspecs2" class="container"></div>
                                    <button type="button" onclick="createProductData('fullspecs','fullspecs2','spec');" class="btn-primary m-1" id="addSpec">Add</button>
                                    <div class="items_preview" id="specItems">
                                        <table class="table" id="spectable">
                                            <!-- <tr>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th>Delete</th>
                                            </tr> -->
                                            <tr>
                                            </tr>
                                        </table>
                                    </div>

                                </div>

                                <!-- colors -->
                                <div class="mb-5">
                                    <label for="colors">Product Colours <?php
                                                                        // if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                        //     echo '(Leave blank if you dont want to change the old values.)';
                                                                        // } 
                                                                        ?></label>
                                    <input type="text" name="colors" id="colors" class="container">
                                    <button onclick="createProductData('colors','-','color');" type="button" class="btn-primary m-1" id="addcolor" onclick="">Add</button>
                                    <div class="items_preview" id="colorItems">
                                        <table class="table" id="colortable">
                                            <!-- <tr>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th>Delete</th>
                                            </tr> -->
                                            <tr>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- categories -->
                                <div class="mb-5">
                                    <label for="categories">Product Categories <?php
                                                                                // if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                                //     echo '(Leave blank if you dont want to change the old values.)';
                                                                                // } 
                                                                                ?></label>
                                    <input type="text" name="categories" id="categories" class="container">
                                    <button type="button" class="btn-primary m-1" id="addcategory" onclick="createProductData('categories','-','category');">Add</button>
                                    <div class="items_preview" id="categoryItems">
                                        <table class="table" id="categorytable">
                                            <!-- <tr>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th>Delete</th>
                                            </tr> -->
                                            <tr>
                                            </tr>
                                        </table>
                                    </div>

                                </div>

                                <!-- features -->
                                <div class="">
                                    <label for="features">Product Features</label>
                                    <!-- <div id="editor" class="edit"></div>
                                    <input type="text" name="rbp" id="editor" class="invisible"> -->
                                    <p>To add code to the text or change classes, just click source after your done and submit. if you undo source before submitting, the changes you make will be removed</p>
                                    <textarea name="features" id="editor"> <?php
                                                                            if (isset($_GET['edit']) && $_GET['edit'] == 1) {
                                                                                echo $_GET['features'];
                                                                            }
                                                                            ?>
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('editor', {
                                            //filebrowserBrowseUrl: 'browse.php?type=Files',
                                            //filebrowserUploadUrl: 'upload.php?type=Files'
                                        });
                                        // var editor = CKEDITOR.replace('ckfinder');
                                        // CKFINDER.setupCKEDITOR(editor);
                                    </script>
                                </div>

                                <!-- main image -->
                                <div class="mb-5 mt-5">
                                    <label for="mi">Main Product Image</label>
                                    <input type="file" name="mi" id="image" class="container" required>
                                </div>

                                <!-- side image 1 -->
                                <div class="mb-5 mt-5">
                                    <label for="si1">Side Product Image 1</label>
                                    <input type="file" name="si1" id="image" class="container" required>
                                </div>

                                <!-- side image 2 -->
                                <div class="mb-5 mt-5">
                                    <label for="si2">Side Product Image 2</label>
                                    <input type="file" name="si2" id="image" class="container" required>
                                </div>

                                <!-- side image 3 -->
                                <div class="mb-5 mt-5">
                                    <label for="si3">Side Product Image 3</label>
                                    <input type="file" name="si3" id="image" class="container" required>
                                </div>


                                <span>Do not edit these values. they are used by the system.</span>
                                <div class="jsondiv">
                                    <input class="jsonformatted" type="text" id="productspecjson" name="specsjson" required>
                                    <input class="jsonformatted" type="text" id="productcolorjson" name="colorsjson" required>
                                    <input class="jsonformatted" type="text" id="productcategoryjson" name="categoriesjson" required>
                                </div>


                                <!-- <a href="" onclick="showMissingItems()" class="btn btn-danger btn-user btn-block invisible">Process</a> -->
                                <button type="submit" class="btn btn-primary btn-user btn-block" id="submit" name="submit">Submit</button>
                                <!-- <input type="submit" name="Submit" class="btn btn-primary btn-user btn-block"> -->

                            </form>

                        </div>

                    </main>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            require_once('includes/footer.php');
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php
    require_once('includes/logout_modal.php');
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
	ClassicEditor
		.create( document.querySelector( '#editor' ), {
			toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'specialCharacters' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>
    <script src="functions/functions.js"></script>

</body>