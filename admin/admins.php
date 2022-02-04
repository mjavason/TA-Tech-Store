<?php
require_once "config/connect.php";
require_once "functions/functions.php";

if (!isset($_SESSION['log'])) {
    gotoPage("login.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    echo loadPageMetaTitle('admins');
    echo loadPageMetaDescription('admins');
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
                        <h1 class="h3 mb-0 text-gray-800">Admins</h1>
                        <!-- <a href="newproduct.php" class="btn btn-primary btn-user">
                            <i class="fa fa-plus fa-fw"></i>
                        </a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="container-fluid">
                            <!-- DataTables Example -->
                            <div class="card shadow mb-4">
                                <!-- <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                                </div> -->
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>

                                                <tr>
                                                    <th>ID</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>

                                                    <th>Email</th>
                                                    <th>Date Joined</th>
                                                    <!-- <th>Edit</th> -->
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>

                                                    <th>Email</th>
                                                    <th>Date Joined</th>
                                                    <!-- <th>Edit</th> -->
                                                    <th>Delete</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>

                                                <?php loadadmins(); ?>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


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

    <!-- DataTable plugins -->
    <!-- <script src="js/jquery.js"></script> -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>