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

if (isset($_SESSION['adminname'])) {
    $admin = $_SESSION['adminname'];
    $password = $_SESSION['password'];
    echo "<h1 style='text-align:center;'>Employee Profile</h1>";

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
    $username = htmlentities($_SESSION['adminname']);
    if ($result = $connection -> query("SELECT * FROM Employees WHERE Username='$username'")) {
        echo "<h2 style='text-align: left'>Personal Information</h1>
        <p>Please contact your IT administrator at angeline.lee01@sjsu.edu to modify this information.</p>
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
    $username = htmlentities($_SESSION['adminname']);
    if ($result = $connection -> query("SELECT * FROM Employment INNER JOIN Employees WHERE Employees.EmployeeID = Employment.EmployeeID AND Employees.Username = '$username'")) {
        echo "<h2 style='text-align: left'>Employment Status</h1>
        <table border='1'>
        <tr>
        <th>Occupation</th>
        <th>Pay</th>
        <th>Hours Worked</th>
        <th>Status</th>
        </tr>";

        $row_count = 1;
        while($row = mysqli_fetch_array($result)) {
            echo "<tr><td>" . $row['Occupation'] . "</td><td>" . $row['Pay'] . "</td><td>" . $row['TimeWorking'] . "</td><td>". $row['EmploymentStatus'] . "</td></tr>";
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

?>