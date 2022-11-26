<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}
if (isset($_POST['order_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ' - ' . $_POST['zip_code'] . ', ' . $_POST['country']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }
    $total_products = implode(', ', $cart_products);
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');
    if ($cart_total == 0) {
        $message[] = 'your cart is empty';
    } else {
        if (mysqli_num_rows($order_query) > 0) {
            $message[] = 'order already placed!';
        } else {
            mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            $message[] = 'Order placed successfully!';
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>About</title>
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <link rel="stylesheet" href="styleshop.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>
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
        <p>Checkout</p>
    </div>
    <section class="ck-shopping-cart">
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
                        <div class="quantity"><?php echo $fetch_cart['quantity']; ?></div>
                        <div class="sub-total"> Sub total : <span><?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>€</span> </div>

                    </div>

                    <div class="qty-value">

                    </div>
            <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="empty">your cart is empty</p>';
            }
            ?>
            <div class="checkout">
            <<h1 class="title">Place your order</h1>
                <form action="" method="post">
                    
                    <div class="flex">
                        <div class="inputBox">
                            <span>Your name:</span>
                            <input type="text" name="name" required placeholder="Enter your name">
                        </div>
                        <div class="inputBox">
                            <span>Your number:</span>
                            <input type="number" name="number" required placeholder="Enter your number">
                        </div>
                        <div class="inputBox">
                            <span>Your email:</span>
                            <input type="email" name="email" required placeholder="Enter your email">
                        </div>
                        <div class="inputBox">
                            <span>Payment method</span>
                            <select name="method" id="">
                                <option value="cash on delivery">Cash on delivery</option>
                                <option value="paypal">Paypal</option>
                                <option value="credit card">Credit card</option>
                            </select>
                        </div>
                        <div class="inputBox">
                            <span>Address line 01 :</span>
                            <input type="number" min="0" name="flat" required placeholder="e.g. flat no.">
                        </div>
                        <div class="inputBox">
                            <span>Address line 01 :</span>
                            <input type="text" name="street" required placeholder="e.g. street name">
                        </div>
                        <div class="inputBox">
                            <span>City :</span>
                            <input type="text" name="city" required placeholder="e.g. Paris">
                        </div>
                        <div class="inputBox">
                            <span>Zip code :</span>
                            <input type="number" name="zip_code" required placeholder="e.g. 75015">
                        </div>
                        <div class="inputBox">
                            <span>country :</span>
                            <input type="text" name="country" required placeholder="e.g. France">
                        </div>

                    </div>
                    <input type="submit" value="order now" class="btn" name="order_btn">
                </form>
            </div>

            

        </div>



        <div class="grand-total"> Grand total: <?php echo $grand_total; ?>€</div>
    </section>


    <?php include 'footer.php'; ?>
    <script src='script_shop.js'></script>
</body>

</html>