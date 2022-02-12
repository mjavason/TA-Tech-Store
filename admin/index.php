<?php
require_once "config/connect.php";
require_once "functions/functions.php";
include 'includes/cache_top.php';


if (!isset($_SESSION['log'])) {
    gotoPage("login.php"); 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <?php
    echo loadPageMetaTitle('dashboard');
    echo loadPageMetaDescription('dashboard');
    echo loadPageMetaUrl('home');
    echo loadPageMetaImage('home');
    echo loadPageMetaKeywords('register');
    echo loadPageMetaType('home');

    require_once('includes/head.php');
    ?>

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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- include earnings.php -->
                    <?php require_once('includes/earnings.php'); ?>

                    <!-- include charts.php -->
                    <?php require_once('includes/charts.php'); ?>



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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <?php include_once('includes/chart-area-demo.php') ?>
    <?php include_once('includes/chart-pie-demo.php') ?>

</body>

</html>

<?php include 'includes/cache_bottom.php';
 ?>