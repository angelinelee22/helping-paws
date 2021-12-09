<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
include('components/navbar.php');
echo "<style>";
include_once('style/navbar.css');
include_once('style/admin_profile.css');
echo "</style>";

if (isset($_SESSION['username'])) {
    $admin = $_SESSION['username'];
    $password = $_SESSION['password'];
    echo "<h1 style='text-align:center;'>User Profile</h1>";

    displayInfo(TRUE);
    displayEmployment(TRUE);
}

function displayInfo($first) {
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
    $username = htmlentities($_SESSION['username']);
    if ($result = $connection -> query("SELECT * FROM Customer WHERE Username='$username'")) {
        echo "<h2 style='text-align: left'>Personal Information</h1>
        <p>Please contact an employee to modify this information.</p>
        <table border='1'>
        <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email Address on File</th>
        <th>Age</th>
        <th>Phone Number</th>
        </tr>";

        $row_count = 1;
        while($row = mysqli_fetch_array($result)) {
            echo "<tr><td>"  . $row['FirstName'] . "</td><td>" . $row['LastName'] . "</td><td>" . $row['Email'] . "</td><td>". $row['Age'] . "</td><td>". $row['PhoneNumber'] . "</td></tr>";
            $row_count++;    
        }
        echo "</table>";
        // Free result set
        $result -> free_result();
    }
    
    $connection -> close();
}

function displayEmployment($first) {
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
    $username = htmlentities($_SESSION['username']);
    if ($result = $connection -> query("SELECT * FROM Customer INNER JOIN CustomerBackground WHERE Customer.CustomerID = CustomerBackground.CustomerID AND Customer.Username = '$username'")) {
        echo "<h2 style='text-align: left'>Background</h1>
        <table border='1'>
        <tr>
        <th>Salary</th>
        <th># of People in Household</th>
        <th># of Kids</th>
        <th># of Current Pets</th>
        <th>Budget</th>
        </tr>";

        $row_count = 1;
        while($row = mysqli_fetch_array($result)) {
            echo "<tr><td>" . $row['Salary'] . "</td><td>" . $row['NumPeopleHousehold'] . "</td><td>" . $row['NumKids'] . "</td><td>". $row['NumCurrPets'] . "</td><td>". $row['BUDGET'] . "</td></tr>";
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