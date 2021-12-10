<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
include('components/navbar.php');
echo "<style>";
include_once('style/navbar.css');
include_once('style/home.css');
echo "</style>";
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    echo "Welcome back $username.";
} elseif (isset($_SESSION['adminname'])) {
    $username = $_SESSION['adminname'];
    $password = $_SESSION['password'];
    echo "Welcome back $username (admin).";
}

displayTable(TRUE);

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
    if ($result = $connection -> query("SELECT * FROM Dog INNER JOIN Breed ON Dog.BreedID = Breed.BreedID;")) {
        echo "<h1 style='text-align: left'>Looking for a home</h1>
        <table border='1'>
        <tr>
            <th>Name</th>
            <th>Breed</th>
            <th>Photo</th>
            <th>Personality</th>
            <th>Sex</th>
            <th>Age</th>
        </tr>";

        $row_count = 1;
        while($row = mysqli_fetch_array($result)) {
            echo "<tr class='dog-row'><td>" . $row['Name'] . "</td><td>" . "<img style='display: block; margin-left: auto; margin-right: auto; max-height: 150px; max-width: 180px;' src='./img/" . $row['Image'] . "'/>" . "</td><td>" . $row['BreedName'] . "</td><td>" . $row['Personality'] . "</td><td>" . $row['Sex'] . "</td><td>" . $row['Age'] . "</td></tr>";
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
    //TODO if time: Allow users to modify   
} 
?>