<?php
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
    checkDatabase();
?>
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
<div class="topnav">
    <a <?php if($curPageName == 'index.php') { echo 'class="active"';} ?> href="index.php">Home</a>
    <?php if(isset($_SESSION['username']) || isset($_SESSION['adminname'])): ?>
        <?php if(isset($_SESSION['adminname'])): ?>
            <a <?php if($curPageName == 'admin.php') { echo 'class="active"';} ?> href="admin_dogs.php">Dogs (A)</a>
            <a <?php if($curPageName == 'admin.php') { echo 'class="active"';} ?> href="admin_cust.php">Customers (A)</a>
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
    echo "<script>window.location.replace('./login_page.php');</script>";
}

function get_post($conn, $var) {
    return $conn->real_escape_string($_POST[$var]);
}

function checkDatabase() {
    require 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db) or die ("Unable to connect");

    // Reference: https://stackoverflow.com/questions/1012870/sql-to-check-if-database-is-empty-no-tables
    if($result = $connection -> query("SELECT count(*) FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'cs157afinalproj';")) {
        $response = mysqli_fetch_array($result);

        if (!$response) {
            die($connection->error);
        } else {
            if($response[0] == 0) {
                $sql = file_get_contents('./components/157finalproject.sql');
                $connection -> multi_query($sql);
                // echo '<meta http-equiv="refresh" content="0">';
                echo "<script>window.location.replace('./login_page.php');</script>";
            }
        }

        $result -> free_result();
    }
}
?>