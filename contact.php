<?php
include 'config.php';
session_start();
$user_id=$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}


if(isset($_POST['send'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
 
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');
 
    if(mysqli_num_rows($select_message) > 0){
       $message[] = 'Message already sent!';
    }else{
       mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
       $message[] = 'Message sent successfully!';
    }
 
 }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Contact</title>
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
        <p>Contact us</p>
    </div>
    <section class="contact">
        <form action="" method="post">
            <h3>Let's get in touch! </h3>
        <!-- <input type="number", min="1" name="product_quantity" value="1" class="qty"> -->
        <input type="text" name="name" placeholder="Enter your name" class="box" required>
        <input type="email" name="email"  placeholder="Enter your email" class="box"required>
        <input type="number" name="number" placeholder="Enter your phone number" class="box">
        <textarea name="message" class="box" placeholder="Enter your message" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="send message" name="send" class="btn">        
        </form>

    </section>


   <?php include 'footer.php'; ?>
    <script src='script_shop.js'></script>
</body>
</html>