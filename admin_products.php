<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' .$image;

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name ='$name'") or die('query failed');
    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already exists';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name,price,image) VALUES ('$name','$price','$image')") or die('query failed');

        if ($add_product_query) {
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Product uploaded successfully';
            }
        } else {
            $message[] = 'Product could not be uploaded';
        }
    }
}
if (isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('uploaded_img/'.$fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id ='$delete_id'") or die('query failed');
    header('location:admin_products.php');
}
if (isset($_POST['update_product'])){
    $update_p_id=$_POST['update_p_id'];
    $update_name=$_POST['update_name'];
    $update_price=$_POST['update_price'];

    mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price='$update_price' WHERE id = '$update_p_id'") or die('query failed');
    $update_image= $_FILES['update_image']['name'];
    $update_image_tmp_name= $_FILES['update_image']['tmp_name'];
    $update_image_size= $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];
    
    if(!empty($update_image)){
        if($update_image_size>2000000){
            $message[]= 'image file size is too large';
        }else{
            mysqli_query($conn, "UPDATE `products` SET IMAGE = '$update_image' WHERE id='$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/'.$update_old_image);
        }
    }
    header('location:admin_products.php');
}   

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Products</title>
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

    <!-- product CRUD section starts -->
    <section class="add-products">
        <h1 class="title">Shop products</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Add product</h3>
            <input type="text" name="name" class="box" placeholder="Enter product name" required>
            <input type="number" min="0" name="price" class="box" placeholder="Enter product price" required>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="upload" required>
            <input type="submit" value="Add product" name="add_product" class="btn" required>

        </form>


    </section>
    <section class="show-products">

        <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <div class="box">
                        <div class="imgbox"><img src="uploaded_img/<?php echo $fetch_products['image'] ?>" alt=""></div>
                        <div class="name"><?php echo $fetch_products['name']; ?> </div>
                        <div class="price"><?php echo 'From '; 
                        echo $fetch_products['price'];
                        echo '€'; ?> </div>
                        <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
                        <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('You sure you want to remove this item?');">Remove</a>
                    </div>

            <?php
                }
            }else {
                    echo '<p class= "empty"">No product added yet.</p>';
            }

            ?>
        </div>
    </section>

    <!-- product CRUD section ends -->
    <section class="edit-product-form">

    <?php
    if(isset($_GET['update'])){
        $update_id=$_GET['update'];
        $update_query=mysqli_query($conn, "SELECT* FROM `products`WHERE id='$update_id'") or die('query failed');

        if (mysqli_num_rows($update_query)>0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
                ?>
                <form action="" method="post" enctype = "multipart/form-data">
                    <input type="hidden" name="update_p_id" value ="<?php echo $fetch_update['id'];?>">
                    <input type="hidden" name="update_old_image" value ="<?php echo $fetch_update['image'];?>">
                    <img src="uploaded_img/<?php echo $fetch_update['image'];?>" alt="">
                    <input type="text" name="update_name" value="<?php echo $fetch_update['name'];?>" class="box" required placeholder="Enter product name">
                    <input type="number" name="update_price" value="<?php echo $fetch_update['price'];?>" class="box" required placeholder="Enter product price">
                    <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                    <input type="submit" value="update" name="update_product" class="btn">
                    <input type="reset" value="cancel" id="close-update" name="cancel" class="btn">
                </form>
                <?php
            }
        }
    }else{
        echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
    }
    ?>


    </section>
    <script src="admin_script.js"></script>
</body>

</html>