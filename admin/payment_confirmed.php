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
        body {
            /* background-color: greenyellow; */
            text-align: center;
            padding: 1rem;
        }

        form {
            background-color: skyblue;
            padding: 2rem;
        }

        form input {
            width: 100%;
            margin: 10px;
            height: 18px;
        }

        .redeem {
            margin: 5px;
            background-color: greenyellow;
            font-size: 2rem;
        }

        .warning {
            color: red;
        }

        form {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <h1>Thanks for patronizing us. Below is your redeem code, present it at any of our branches to receive your goods. </h1>
    <h3 class="redeem"><?php echo $_GET['redeem_code'] ?></h3>
    <h3 class="warning">Please do not loose this code, without it, it'll be really difficult to confirm if you own the goods.</h3>
    <h3>Click <a href="../product_summary.php?fin=true">Here</a> to continue shopping.</h3>


    <form action="" method="post">
        <h1>Optional Info Form</h1>
        <label for="name">Full Name</label>
        <input name="name" type="text" placeholder="John Doe">

        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" placeholder="08122401507">

        <input type="submit" value="Submit">
    </form>
    <p>Though the above form is optional, filling these details will help us be able to contact you if need be.</p>
</body>

</html>