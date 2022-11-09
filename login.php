<?php
include 'config.php';
session_start();
if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));


    $select_users = mysqli_query($conn, "SELECT *  FROM `users` WHERE email ='$email' AND password = '$password'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $row=mysqli_fetch_assoc($select_users);
        if($row['user_type']=='admin'){
            $_SESSION['admin_name']=$row['name'];
            $_SESSION['admin_email']=$row['email'];
            $_SESSION['admin_id']=$row['id'];
            header('location:admin_page.php');

        }elseif($row['user_type']=='user'){
            $_SESSION['user_name']=$row['name'];
            $_SESSION['user_email']=$row['email'];
            $_SESSION['user_id']=$row['id'];
            header('location:home.php');
        }
    } else {
        $message[] = 'Incorrect Email adress or password';
       
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mohamed Mamoun Photography</title>
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <link rel="stylesheet" href="styleshop.css">
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->

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
    <div class="form-container">

        <form action="" method="post">
            <h3>Sign in</h3>
            <input type="email" name="email" placeholder="Enter your email" required class="box">
            <input type="password" name="password" placeholder="Enter your password" required class="box">
<!-- /           <select name="user_type" class="box">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select> -->
            <input type="submit" name="submit" value="Sign-in" class="btn">
            <p>Don't have an account? <a href="register.php">Sign-up</a></p>
        </form>

    </div>
</body>

</html>