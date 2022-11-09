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
    mysqli_query($conn, "DELETE FROM `message` WHERE id='$delete_id'") or die('query failed');
    header('location:admin_contacts.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contacts</title>
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

<section class="messages">
<h1 class="title">Messages</h1>
<div class="box-container">
<?php
        $select_message = mysqli_query($conn, "SELECT * FROM `message` ") or die ('query failed');
        if(mysqli_num_rows($select_message)>0){
        while($fetch_message = mysqli_fetch_assoc($select_message)){
            ?>
            <div class="box">
                <p> Name: <span> <?php echo $fetch_message ['name'];?></span></p>
                <p> Number: <span> <?php echo $fetch_message ['number'];?></span></p>
                <p> Email: <span> <?php echo $fetch_message ['email'];?></span></p>
                <p> Message: <span> <?php echo $fetch_message ['message'];?></span></p>
         <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('Delete this message?');" class="delete-btn">Delete message</a>
            </div>
              <?php
        
        };
    }else{echo '<p class="empty"> No new messages </p>';

    }
      
        ?>
</div>
</section>

<script src="admin_script.js"></script>
</body>
</html>