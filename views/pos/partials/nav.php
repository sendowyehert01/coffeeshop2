    <!-- Navbar Start -->
    <nav>
        <h2>POS
        <?php echo " (" . $_SESSION['user']['email'] . " the " . $_SESSION['user']['role'] . ") " ?>
        </h2>
        <ul>
        <li><a href="#">Sales</a></li>
        <li><a href="#">+</a></li>
        <li><a href="#">Tunnel</a></li>
        <li><a href="#">Surf</a></li>
        <li><a href="#">Parties</a></li>
        </ul>

        <div class="search">
        <input type="Search" placeholder="Search..." />
        </div>
        <a href="../Dashboard/logout.php" class="login-button">Logout</a>
    </nav>
    <!-- Navbar End -->

    