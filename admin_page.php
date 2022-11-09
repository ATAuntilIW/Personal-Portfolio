<?php
include 'config.php';
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administration pane</title>
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/Logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d48363bb3a.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital@0;1&family=Quicksand:wght@300;400;500&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

</head>
<body>
<?php include 'admin_header.php'   ?>

<section class="dashboard">
    <h1 class="title">Performance dashboard</h1>
    <div class="box-container">
    <div class="box">
            
        <?php
            $total_pendings=0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status ='pending' ") or die('query failed');
            if(mysqli_num_rows($select_pending)>0){
                while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                    $total_price=$fetch_pendings['total_price'];
                    $total_pendings += $total_price;
                };
            };
        ?>
            <h3>
            <?php echo $total_pendings;
             echo "€";
            ?>
            </h3>
            <p>Total pendings</p>

        </div>            
        <div class="box">
            
        <?php
            $total_completed=0;
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status ='completed' ") or die('query failed');
            if(mysqli_num_rows($select_completed)>0){
                while($fetch_completed = mysqli_fetch_assoc($select_completed)){
                    $total_price=$fetch_completed['total_price'];
                    $total_completed += $total_price;
                };
            };
        ?>
            <h3>
            <?php echo $total_completed;
            echo "€";
            ?>
            </h3>
            <p>Completed payments</p>

        </div>  
        <div class="box">
            <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die ('query failed');
                $number_of_orders = mysqli_num_rows($select_orders);

            ?>
            <h3><?php echo $number_of_orders; ?></h3>
            <p>Total Orders</p>
        </div>
        <div class="box">
            <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die ('query failed');
                $number_of_products = mysqli_num_rows($select_products);

            ?>
            <h3><?php echo $number_of_products; ?></h3>
            <p>Number of products</p>
        </div>       
        <div class="box">
            <?php
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type='user'") or die ('query failed');
                $number_of_users= mysqli_num_rows($select_users);

            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>Total users</p>
        </div>     
        <div class="box">
            <?php
                $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type='admin'") or die ('query failed');
                $number_of_admins= mysqli_num_rows($select_admins);

            ?>
            <h3><?php echo $number_of_admins; ?></h3>
            <p>Total admins</p>
        </div>  
        <div class="box">
            <?php
                $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die ('query failed');
                $number_of_account= mysqli_num_rows($select_account);

            ?>
            <h3><?php echo $number_of_account; ?></h3>
            <p>Total account</p>
        </div>
        <div class="box">
            <?php
                $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die ('query failed');
                $number_of_messages = mysqli_num_rows($select_messages );

            ?>
            <h3><?php echo $number_of_messages ; ?></h3>
            <p>New messages</p>
        </div>     
    </div>

</section>

<script src="admin_script.js"></script>
</body>
</html>