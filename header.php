<header class="header">

    <div class="header-1">

        <div class="flex">
            <div class="share">
                <a href="#" class="fab fa-facebook-f"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
            <p>New <a href="login.php">Sign-in</a> |<a href="register.php">Sign-up</a> </p>
        </div>
    </div>
    <div class="header-2">
        <div class="flex">
            <!-- <a href="home.php" class=logo> Picturiiies </a> -->
            <a href="home.php" class=logo> <img src="images/Logo.png" alt=""></a>

            <nav class="navbar">
                <a href="home.php">Home</a>
                <a href="about.php">About</a>
                <a href="shop.php">Shop</a>
                <a href="contact.php">Contact</a>
                <a href="orders.php">Orders</a>
            </nav>
            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                    <a href="search_page.php" class="fas fa-search"></a>
                    <div id="user_btn" class="fas fa-user"></div>
                    <a href="cart.php"> <i class="fas fa-shopping-cart"></i><span>(0)</span></a>
                
            </div>
            <div class="user-box">
                <p>Bienvenue<span> <?php echo $_SESSION['user_name'] ?></span> !</p>
                <!-- <p>Email: <span> <?php //$_SESSION['user_email'] ?></span></p> -->
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>

    </div>
</header>
