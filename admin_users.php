<?php
include 'config.php';
session_start();
$admin_id=$_SESSION['admin_id'];
if(!isset($admin_id)){
    header('location:login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    // $update_payment=$_POST['update_payment'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id='$delete_id'") or die('query failed');
    header('location:admin_users.php');

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Users</title>
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
<section class="users">
    <h1 class="title">User accounts</h1>
    <div class="box-container">
        <?php
        $select_users = mysqli_query($conn, "SELECT * FROM `users` ") or die ('query failed');
        while($fetch_users = mysqli_fetch_assoc($select_users)){
            ?>
            <div class="box">
                <p> Name: <span> <?php echo $fetch_users['name'];?></span></p>
                <p> Email: <span> <?php echo $fetch_users['email'];?></span></p>
                <p> User type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--red)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">delete user</a>
            </div>
              <?php
        
        }
      
        ?>
    </div>

</section>

</section>

<script src="admin_script.js"></script>
</body>
</html>