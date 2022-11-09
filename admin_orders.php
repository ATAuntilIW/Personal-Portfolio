<?php
include 'config.php';
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:login.php');
}

if(isset($_POST['update_order'])){
    $order_update_id = $_POST['order_id'];
    $update_payment=$_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status='$update_payment'") or die('query failed');
    $message[]='Payment status has been updated';
}
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    // $update_payment=$_POST['update_payment'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id='$delete_id'") or die('query failed');
    header('location:admin_orders.php');

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orders</title>
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/Logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d48363bb3a.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital@0;1&family=Quicksand:wght@300;400;500&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

</head>
<body>
<?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
       <div class="message">
          <span>' . $message . '</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
       </div>
       ';
        }
    }
    ?>
<?php include 'admin_header.php'   ?>

<section class="orders">
    <h1 class="title"> Placed orders</h1>
    <div class="box-container">

    <?php
    $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die ('query failed');
    if(mysqli_num_rows($select_orders)>0){
        while($fetch_orders = mysqli_fetch_assoc($select_orders)){
        ?>
        <div class="box">
          <p> User id : <span> <?php echo $fetch_orders['user_id'];?></span></p>
          <p> Placed on: <span> <?php echo $fetch_orders['placed_on'];?></span></p>
          <p> Name: <span> <?php echo $fetch_orders['name'];?></span></p>
          <p> Email: <span> <?php echo $fetch_orders['email'];?></span></p>
          <p> Address: <span> <?php echo $fetch_orders['address'];?></span></p>
          <p> Total products: <span> <?php echo $fetch_orders['total_products'];?></span></p>
          <p> Total price: <span> <?php echo $fetch_orders['total_price'];?>€</span></p>
          <p> Payment method: <span> <?php echo $fetch_orders['method'];?></span></p>
          <form action="" method="post">

          <input type="hidden" name="order_id" value="<?php echo $fetch_orders['method'];?>">
          <select name="update_payment" >
            <option value="" selected disabled>
                <?php echo $fetch_orders['payment_status'];?>
            </option>
            <option value="pending">Pending</option>
            <option value="completed">Complete</option>

        </select>
            <input type="submit" value="Update order" name="update_order" class ="btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id'];?>" onclick="return confirm(Delete this order?);"
        class="btn"> Delete </a>
          </form>

        </div>
        <?php
        }

    }else{
        echo '<p class="empty"> No orders </p>';

    }

     ?>

    </div>

</section>

</section>

<script src="admin_script.js"></script>
</body>
</html>