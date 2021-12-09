<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    include('components/navbar.php');
    echo "<style>";
    include_once('style/navbar.css');
    echo "</style>";

    if(isset($_SESSION['username']) || isset($_SESSION['adminname'])) {
        header('Location:home.php');
    }

    require 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db);

    echo<<<_END
    <head><script type="text/JavaScript"></script></head>
    <body>
        <form style="text-align: left" method="post" enctype="multipart/form-data" onsubmit="return validateSignup(this)">
            <h1>Create an Account</h1>
            <p>For admin accounts, please make them directly on the SQL DBMS.</p>

            Email <br>
            <input size="36" type="text" placeholder="Email" name="email" required>

            <br><br> First Name <br>
            <input size="36" type="text" placeholder="First Name" name="firstname" required>

            <br><br> Last Name <br>
            <input size="36" type="text" placeholder="Last Name" name="lastname" required>

            <br><br> Age <br>
            <select name="age">
_END;
            for ($i = 21; $i <= 99; $i++) {
                echo '<option value="' . $i . '">'. $i . '</option>';
            }
    echo<<<_END
            </select>

            <br><br> Phone Number <br>
            <input size="36" type="text" placeholder="Phone Number" name="phonenumber" required>

            <br><br> Username <br>
            <input size="36" type="text" placeholder="Username" name="username" required>

            <br><br> Password <br>
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
        $firstname = get_post($connection, 'firstname');
        $lastname = get_post($connection, 'lastname');
        $age = get_post($connection, 'age');
        $phonenumber = get_post($connection, 'phonenumber');
        
        $username = htmlentities($username);
        $password = htmlentities($password);
        $email = htmlentities($email);
        $firstname = htmlentities($firstname);
        $lastname = htmlentities($lastname);
        $age = htmlentities($age);
        $phonenumber = htmlentities($phonenumber);

        $fail = "";

        if (!preg_match('/^[a-zA-Z0-9-_]{5,}+$/', $username)) {
            $fail = $fail . "Username must be at least 5 characters<br>";
        }
        if (!preg_match('/^^[a-zA-Z0-9]{6,}$/', $password)) {
            $fail = $fail . "Password must be at least 6 characters and have a lowercase character, uppercase character, and a number<br>";
        }        
        $pattern = '#^(1-)?\d{3}-\d{3}-\d{4}$#';
        if (!preg_match($pattern, $phonenumber)) {
            $fail = $fail . "Phone number does not meet requirements (###-###-####)<br>";
        }

        $pattern = '#^[a-zA-Z0-9.!\#$%&\'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$#';
        if (!preg_match($pattern, $email)) {
            $fail = $fail . "Email does not meet requirements (XXXX@XXXX.XXX)<br>";
        }
        
        if($fail != "") {
            echo die($fail);
        }

        add_user($connection, $email, $username, $password, $firstname, $lastname, $age, $phonenumber);
    }

    function add_user($connection, $em, $un, $pw, $fn, $ln, $age, $pn) {
        $query = "INSERT INTO Customer (Username, Password, FirstName, LastName, Age, Email, PhoneNumber) VALUES ('$un', '$pw', '$fn', '$ln', '$age', '$em', '$pn');";
        $result = $connection->query($query);
        if (!$result) {
            die($connection->error);
        } else {
            echo "User created. Please login.";
        }
    }

    $connection->close();
?>