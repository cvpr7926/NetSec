<?php
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page !== "index.php"): ?>
    <nav class="navbar">
        <div class="navbar-container">
            <ul class="nav-links">
                <li><a href="../profile/profile.inc.php">Profile</a></li>
                <?php if ($user_id): ?>
                    <li><a href="../home/logout.inc.php" class="logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="../login/login.inc.php" class="login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
