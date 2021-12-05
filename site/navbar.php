<div class="topnav">
    <a class="active" href="#home">Home</a>
    <?php if(isset($_SESSION['adminname']) || isset($_SESSION['username'])): ?>
        <div class="topnav-right" id="login">
            <form method='POST'>
                <input type='submit' name='logout' class='button' value='Logout' />
            </form>
            <a href="login_page.php">Log Out</a>
        </div>
    <?php else: ?>
        <div class="topnav-right" id="login">
            <a href="login_page.php">Login</a>
            <a href="signup_page.php">Sign Up</a>
        </div>
    <?php endif; ?>
</div>