<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['add_to_cart'])){
    $product_name=$_POST['product_name'];
    $product_price=$_POST['product_price'];
    $product_image=$_POST['product_image'];
    $product_quantity=$_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn ,"SELECT * FROM `cart` WHERE name = '$product_name' AND user_id='$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers)>0){
        $message[]='Already added to cart';

    }else {
        mysqli_query($conn,"INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id','$product_name','$product_price','$product_quantity','$product_image') ") or die('query failed');
        $message[]='Product added to cart';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <link rel="stylesheet" href="styleshop.css">
    <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="images/Logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital@0;1&family=Quicksand:wght@300;400;500&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">
       
</head>

<body>
    <?php include 'header.php'; ?>

    <section class="home">
        <div class="content">
            <h3>A new ornement to lighten your home</h3>
            <p>Hang a piece of the world and set the atmosphere.</p>
            <a href="index.html" class="white-btn">Discover more</a>
            <!-- <img src="images/LIghtplay/image (3).jpg" alt=""> -->
        </div>
    </section>
    <section class="products">
        <h1 class="title">Latest products</h1>
        <div class="box-container">
            <?php
                $select_products=mysqli_query($conn, "SELECT * FROM `products` LIMIT 4") or die('query failed');
                if(mysqli_num_rows($select_products)>0){
                    while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
           <form action="" method="post" class="box">
           <div class="imgbox"><img src="uploaded_img/<?php echo $fetch_products['image'];?>" alt=""></div>
                <div class="name"><?php echo $fetch_products['name'];?></div>
                <div class="price">From <?php echo $fetch_products['price'];?>???</div>
                <input type="number", min="1" name="product_quantity" value="1" class="qty">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'];?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price'];?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image'];?>">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
            <?php
                    }
                }else{
                    echo '<p class="empty"> No products </p>';
                }
            ?>
        </div>
        <div class="load-more" style="margin-top: 1rem; text-align: center">
            <a href="shop.php" class="btn-load">Load more</a>

        </div>
    </section>
    
    <!-- <div class="about">
        <div class="flex">
            <div class="image">
                <img src="" alt="">
            </div>
            <div class="content">
                <h3>

                </h3>
            </div>
        </div>
    </div> -->


    <?php include 'footer.php'; ?>
    <script src='script_shop.js'></script>
</body>

</html>