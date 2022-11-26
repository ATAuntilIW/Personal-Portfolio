<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'cart quantity updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cart</title>
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <link rel="stylesheet" href="styleshop.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
        rel="stylesheet"  type='text/css'>
    <script src="https://kit.fontawesome.com/d48363bb3a.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="images/Logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital@0;1&family=Quicksand:wght@300;400;500&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

</head>

<body>
    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>MMBRD's SHOP</h3>
        <h1>Damn, you have great taste!</h1>
        <p><a href="home.php">Home</a></p>

    </div>

    <section class="shopping-cart">
        <h1 class="title">Products added</h1>
        <div class="box-container">
            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'");
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            ?>

                    <div class="box">
                        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                        <div class="imgbox"><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt=""></div>
                        <div class="name"><?php echo $fetch_cart['name']; ?></div>
                        <div class="price"><?php echo $fetch_cart['price']; ?>€</div>
                        <form action="" method="post">
                            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                            <input type="submit" name="update_cart" value="update" class="btn">
                        </form>
                        <div class="sub-total"> Sub total : <span><?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>€</span> </div>
                        
                    </div>
            <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="empty">your cart is empty</p>';
            }
            ?>

    
        </div>
       
            
        <div class="cart-total">
            <div class="topt">
            <p>grand total : <span><?php echo $grand_total; ?>€</span></p>

            <a href="cart.php?delete_all" >
            <i class="fa-sharp fa-solid fa-trash <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('delete all from cart?');"></i>delete all</a>
            </div>
            <div class="flex">
                <a href="shop.php">
                <i class="fa-sharp fa-solid fa-bag-shopping"></i><p>Continue Shopping</p></a>
                <a href="checkout.php">
                    <i class="fa-sharp fa-solid fa-arrow-right <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>"></i><p>Proceed to checkout</p></a>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src='script_shop.js'></script>
</body>

</html>