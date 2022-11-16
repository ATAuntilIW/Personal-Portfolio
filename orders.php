<?php
include 'config.php';
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>About</title>
        <meta name = "viewport" content = "width=device-width, intial-scale=1.0">
        <link rel="stylesheet" href="styleshop.css">
        <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" sizes="32x32" href="images/Logo.png">
        <href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital@0;1&family=Quicksand:wght@300;400;500&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300;1,400&display=swap"
        rel="stylesheet">

</head> 
<body>
    <?php include 'header.php'; ?>
    <div class="heading">
        <h3>MMBRD's SHOWCASE</h3>
        <p>Placed orders</p>
    </div>
    <section class="placed-orders">
        <h1 class="title">Place orders</h1>
        <div class="box-container">
            <?php
            $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$user_id'") or die('query failed');
            if(mysqli_num_rows($order_query)>0){
                while($fetch_orders=mysqli_fetch_assoc($order_query)){

            ?>
            <p> Placed on: <span><?php echo $fetch_orders['placed_on'];?></span></p>
            <p> Name: <span><?php echo $fetch_orders['name'];?></span></p>
            <p> Number: <span><?php echo $fetch_orders['number'];?></span></p>
            <p>Email: <span><?php echo $fetch_orders['email'];?></span></p>
            <p>Address: <span><?php echo $fetch_orders['address'];?></span></p>
            <p>Payment method: <span><?php echo $fetch_orders['method'];?></span></p>
            <p>Your orders: <span><?php echo $fetch_orders['total_products'];?></span></p>
            <p>total price: <span><?php echo $fetch_orders['total_price'];?>€</span></p>
            <p>Payment status: <span style="color: <?php if($fetch_orders['payment_status']=='pending'){echo 'red';}else {echo 'green';} ?>"><?php  echo $fetch_orders['payment_status'];?></span></p>

              <?php 
       
                    
                }

            }else {
                echo '<p class="empty">No orders placed/p>';

            }
            ?>
        </div>

    </section>


   <?php include 'footer.php'; ?>
    <script src='script_shop.js'></script>
</body>
</html>