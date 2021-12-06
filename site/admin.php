<?php
session_start();
include('navbar.php');
echo "<style>";
include_once('style/navbar.css');
echo "</style>";

if (isset($_SESSION['adminname'])) {
    $admin = $_SESSION['adminname'];
    $password = $_SESSION['password'];
    echo "Welcome back $admin.";

    echo "
    <form method='POST'>
        <input type='submit' name='logout' class='button' value='Logout' />
    </form>
    <br>";
    //onsubmit='return validateInput(this)'

displayTable(TRUE);
}

function fileHandler($filename) {
    require 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db) or die ("Unable to connect");

    $name = htmlentities(strval($_POST['user_input']), ENT_QUOTES);
    if($name == "") {
        echo die("No file name entered.");
    }
    $data = htmlentities(file_get_contents($filename), ENT_QUOTES);
    $adminname = htmlentities($_SESSION['adminname']);
    $sql = "INSERT INTO files (Content_Name, File_Content, Username) VALUES ('$name', '$data', '$username')";

    if($connection -> query($sql) == TRUE) {
        echo "Added";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }

    $connection -> close();
}

function displayTable($first) {
    if($first == TRUE) {
        ob_start();
    } else {
        ob_end_clean();
        ob_start();
    }

    require 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db) or die ("Unable to connect");

    if ($connection -> connect_errno) {
        echo "Failed to connect to MySQL: " . $connection -> connect_error;
        exit();
    }
    
    // Perform query
    $username = htmlentities($_SESSION['adminname']);
    if ($result = $connection -> query("SELECT * FROM Employees WHERE Username=$username")) {
        echo "<h1 style='text-align: left'>Personal Information</h1>
        <table border='1'>
        <tr>
        <th>EmployeeID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email Address on File</th>
        <th>Age</th>
        <th>Phone Number</th>
        </tr>";

        $row_count = 1;
        while($row = mysqli_fetch_array($result)) {
            echo "<tr><td>" . $row['EmployeeID'] . "</td><td>" . $row['FirstName'] . "</td><td>" . $row['LastName'] . "</td><td>" . $row['EmailAddress'] . "</td><td>". $row['Age'] . "</td><td>". $row['PhoneNumber'] . "</td></tr>";
            $row_count++;    
        }
        echo "</table>";
        // Free result set
        $result -> free_result();
    }
    
    $connection -> close();
}

if(htmlentities(isset($_POST['submit']), ENT_QUOTES))
{
    submitFile();
} 

function strposX($haystack, $needle, $number = 0)
{
    return strpos($haystack, $needle,
        $number > 1 ?
        strposX($haystack, $needle, $number - 1) + strlen($needle) : 0
    );
}
?>