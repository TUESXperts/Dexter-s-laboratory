<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <h3 class="navbar-brand text-white">Dexter's Lab Control System</h3>


    <div class="mr-auto"></div>

    <ul class="navbar-nav">
        <?php if(isset($_SESSION['user_id'])){ ?>
            <li class="nav-item">
                <a href="#" class="nav-link"><?php echo "Hello, " . $_SESSION['username'] . "!"; ?></a>
            </li>
            <li class="nav-item">
                <a href="profile.php" class="nav-link">Profile</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link">Logout</a>
            </li>
        <?php }
        else { ?>
            <li class="nav-item">
                <a href="index.php" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
                <a href="register.php" class="nav-link">Register</a>
            </li>
        <?php } ?>
    </ul>
</nav>