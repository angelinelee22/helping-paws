<?php
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
?>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
<div class="topnav">
    <a <?php if($curPageName == 'home.php') { echo 'class="active"';} ?> href="home.php">Home</a>
    <?php if(isset($_SESSION['username']) || isset($_SESSION['adminname'])): ?>
        <?php if(isset($_SESSION['adminname'])): ?>
            <a <?php if($curPageName == 'admin.php') { echo 'class="active"';} ?> href="admin.php">Admin Panel</a>
            <div class="topnav-right" id="login">
            <form method='POST'>
                <a <?php if($curPageName == 'admin_profile.php') { echo 'class="active"';} ?> href="admin_profile.php">Profile</a>
                <input type='submit' class='button' name='logout' value='Logout' />
        <?php else: ?>
            <div class="topnav-right" id="login">
            <form method='POST'>
                <a <?php if($curPageName == 'user_profile.php') { echo 'class="active"';} ?> href="user_profile.php">Profile</a>
                <input type='submit' class='button' name='logout' value='Logout' />
        <?php endif; ?> 
        </form>
        </div>
    <?php else: ?>
        <div class="topnav-right" id="login">
            <a href="login_page.php">Login</a>
            <a href="signup_page.php">Sign Up</a>
        </div>
    <?php endif; ?> 
</div>
<br><br>

<?php 

if(htmlentities(isset($_POST['logout']), ENT_QUOTES)) {
    $_SESSION = array(); // Delete all the information in the array
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
    header("Location: login_page.php");
}

function get_post($conn, $var) {
    return $conn->real_escape_string($_POST[$var]);
}

?>