<?php
    require 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db);

    echo<<<_END
    <head><script type="text/JavaScript"></script></head>
    <body>
        <form style="text-align: center" method="post" enctype="multipart/form-data" onsubmit="return validateSignup(this)">
            <h1>Create an Account</h1>

            <input size="36" type="text" placeholder="Email" name="email" required>

            <br><br>
            <input size="36" type="text" placeholder="Username" name="username" required>

            <br><br>
            <input size="36" type="password" placeholder="Password" name="password" required>

            <br><br>
            <button type="submit" name="signupbtn">Sign Up</button>
            Have an account? <a href="login_page.php">Login</a>
        </form>
    </body>
_END;

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
        $username = get_post($connection, 'username');
        $password = get_post($connection, 'password');
        $email = get_post($connection, 'email');
        
        $username = htmlentities($username);
        $password = htmlentities($password);
        $email = htmlentities($email);

        $fail = "";
        if ($username == "") {
            $fail = $fail . "No username was entered<br>";
        }
        if ($password == "") {
            $fail = $fail . "No password was entered<br>";
        }
        if ($email == "") {
            $fail = $fail . "No email was entered<br>";
        }
        if (!preg_match('/^[a-zA-Z0-9-_]{5,}+$/', $username)) {
            $fail = $fail . "Username does not meet requirements<br>";
        }
        if (!preg_match('/^^[a-zA-Z0-9]{6,}$/', $password)) {
            $fail = $fail . "Password does not meet requirements<br>";
        }
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        if (!preg_match($pattern, $email) === 1) {
            $fail = $fail . "Email does not meet requirements";
        }
        if($fail != "") {
            echo die($fail);
        }

        add_user($connection, $email, $username, $password);
    }

    function add_user($connection, $em, $un, $pw) {
        $query = "INSERT INTO customers VALUES('$em', '$un', '$pw')";
        $result = $connection->query($query);
        if (!$result) {
            die($connection->error);
        } else {
            echo "User created. Please login.";
        }
    }

    $connection->close();

    function get_post($conn, $var) {
        return $conn->real_escape_string($_POST[$var]);
    }

?>