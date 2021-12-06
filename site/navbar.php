<div class="topnav">
    <a class="active" href="home.php">Home</a>
    <?php if(isset($_SESSION['username']) || isset($_SESSION['adminname'])): ?>
        <div class="topnav-right" id="login">
            <form method='POST'>
                <a href="admin.php">Profile</a>
                <input type='submit' name='logout' value='Logout' />
            </form>
        </div>
    <?php else: ?>
        <div class="topnav-right" id="login">
            <a href="login_page.php">Login</a>
            <a href="signup_page.php">Sign Up</a>
        </div>
    <?php endif; ?> 
</div>

<?php if(htmlentities(isset($_POST['logout']), ENT_QUOTES)) {
    $_SESSION = array(); // Delete all the information in the array
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
    header("Location: login_page.php");
}
?>