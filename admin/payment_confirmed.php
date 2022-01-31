<?php
require_once "config/connect.php";
require_once "functions/functions.php";

// if (!isset($_SESSION['log'])) {
//     gotoPage("login.php");
// }
if (isset($_GET['redeem_code'])) {
    $_SESSION['redeem_code'] = $_GET['redeem_code'];
}

if (isset($_POST['name'])) {
    UpdateTransactionDetail($_SESSION['redeem_code'], $_POST['name'], $_POST['phone']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        } */

        body {
            /* background-color: greenyellow; */
            text-align: center;
            padding: 1rem;
        }

        form {
            /* background-color: skyblue; */
            padding: 5px;
        }

        form input {
            width: 90%;
            margin: 10px 1px 10px 1px;
            height: 2rem;
            padding-left: 10px;
        }

        form input[type=submit]{
            background-color: skyblue;
            border-radius: 10px;
        }

        #redeem {
            margin: 1px;
            padding: 5px;
            background-color: greenyellow;
            font-size: 2rem;
            width: 100%;
        }

        .warning {
            color: red;
        }

        .redeem_div{
            margin-bottom: 50px;
        }

        form {
            margin-top: 50px;
        }
    </style>
</head>

<body>


    <div class="redeem_div">
        <h2>Thanks for patronizing us. Below is your redeem code, present it at any of our branches to receive your goods. </h2>
        <h3 id="redeem"><?php echo $_GET['redeem_code'] ?></h3>
        <!-- <a href="#" class="download-pdf">Download as PDF</a> -->
        <h3 class="warning">Please do not loose this code, without it, it'll be really difficult to confirm if you own the goods.</h3>
        <!-- <h3>Click <a href="../product_summary.php?fin=true">Here</a> to continue shopping.</h3> -->
        <h3>Click <a target="_blank" href="https://wa.me/+2349059928764?text=I%20just%20made%20a%20purchase%20on%20your%20e-commerce%20store%20and%20would%20like%20them%20delivered.%20This%20is%20my%20redeem%20code:%20<?php echo $_GET['redeem_code'] ?>">Here</a> to request your items delivery for free, anywhere in Enugu Metropolis.</h3>
        <a href="../product_summary.php?fin=true">Continue shopping</a>
    </div>
    <br>
    <br>
<br>
<hr>

    <form action="" method="post">
        <h1>Optional Info Form</h1>
        <!-- <label for="name">Full Name</label> -->
        <div><input name="name" type="text" placeholder="Full Name"></div>

        <!-- <label for="phone">Phone Number</label> -->
        <div><input type="tel" name="phone" placeholder="Phone Number"></div>

        <div><input type="submit" value="Submit"></div>
    </form>
    <h3>Though the above form is optional, filling these details will help us be able to contact you if need be.</h3>

    <script>

    </script>
</body>

</html>