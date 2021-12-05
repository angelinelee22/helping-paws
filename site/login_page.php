<?php
    require 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db);
    
    echo '<head><script type="text/JavaScript"></script></head>
        <form style="text-align: center" method="post" enctype="multipart/form-data" onsubmit="return validateLogin(this)">
            <h1>Login</h1>
            <p>Please login</p>

            <input size="36" type="text" placeholder="Username" name="username" required>

            <br><br>
            <input size="36" type="password" placeholder="Password" name="password" required>

            <br><br>
            <input type="checkbox" name="admin">Administrator Login<br />

            <br>
            <button type="submit" class="loginbtn">Login</button> Don\'t have an account? <a href="signup_page.php">Sign Up</a>

            <br><br>
            <p>Admin? <a href="admin.php">Click Here</a></p>
        </form>';

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = get_post($connection, 'username');
        $password = get_post($connection, 'password');

        $un_temp = htmlentities($username);
        $pw_temp = htmlentities($password);

        $fail = "";
        if ($un_temp == "") {
            $fail = $fail . "No username was entered<br>";
        }
        if ($pw_temp == "") {
            $fail = $fail . "No password was entered<br>";
        }
        if($fail != "") {
            echo die($fail);
        }

        if(isset($_POST['admin'])) {
            $query = "SELECT * FROM employees WHERE username='$un_temp'";
            $result = $connection->query($query); 
            if (!$result) die($connection->error);
            elseif ($result->num_rows) {
                $row = $result->fetch_array(MYSQLI_NUM);
                $result->close();
                if ($pw_temp == $row[2]) {
                    session_start();
                    $_SESSION['adminname'] = $un_temp;
                    $_SESSION['password'] = $pw_temp;
                    header('Location:admin.php');
                } else die("Invalid username/password combination");
            } else die("Invalid username/password combination");
        } else {
            $query = "SELECT * FROM customers WHERE username='$un_temp'";
            $result = $connection->query($query); 
            if (!$result) die($connection->error);
            elseif ($result->num_rows) {
                $row = $result->fetch_array(MYSQLI_NUM);
                $result->close();
                if ($pw_temp == $row[2]) {
                    session_start();
                    $_SESSION['username'] = $un_temp;
                    $_SESSION['password'] = $pw_temp;
                    header('Location:user.php');
                } else die("Invalid username/password combination");
            } else die("Invalid username/password combination");
        }
    }
    $connection->close();

    function get_post($conn, $var) {
        return $conn->real_escape_string($_POST[$var]);
    }
?>