<?php 
    session_start();
    include('components/navbar.php');
    echo "<style>";
    include_once('style/navbar.css');
    include_once('style/admin.css');
    echo "</style>";
    // echo '<script>$(document).ready(function(){
    //     $("#dog-table tr:not(:first)").click(function(){
    //         $(this).addClass("selected").siblings().removeClass("selected");   
      
    //     })
    //   });</script>';

    if (isset($_SESSION['adminname'])) {
        $admin = $_SESSION['adminname'];
        $password = $_SESSION['password'];
        echo "<h1 style='text-align:center;'>Employee Profile</h1>";
    
        displayDogs(TRUE);
        displayCustomers(TRUE);
    }
    
    function fileHandler($filename) {
        require 'login.php';
        $connection = new mysqli($hn, $un, $pw, $db) or die ("Unable to connect");
    
        $name = htmlentities(strval($_POST['user_input']), ENT_QUOTES);
        if($name == "") {
            echo die("No file name entered.");
        }
        $data = htmlentities(file_get_contents($filename), ENT_QUOTES);
        $sql = "INSERT INTO files (Content_Name, File_Content, Username) VALUES ('$name', '$data', '$username')";
    
        if($connection -> query($sql) == TRUE) {
            echo "Added";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    
        $connection -> close();
    }
    
    function displayDogs($first) {
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
        
        echo "<form name='dog-form' id='dog-form' method='post'>";
        echo '';
        if ($result = $connection -> query("SELECT * FROM Dog INNER JOIN Breed WHERE Dog.BreedID = Breed.BreedID;" )) {
            echo "<h2 style='text-align: left'>Dogs</h1>
            <table border='1' id='dog-table'>
            <tr>
            <th>Name</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Weight</th>
            <th>Color</th>
            <th>Trained</th>
            <th>Dog ID</th>
            </tr>";
    
            $row_count = 1;
            while($row = mysqli_fetch_array($result)) {
                echo "<tr class='dog-row'><td>" . $row['Name'] . "</td><td>" . $row['BreedName'] . "</td><td>" . $row['Age'] . "</td><td>" . $row['Sex'] . "</td><td>". $row['Weight'] . "</td><td>". $row['Color'] . "</td><td>". $row['Trained'] . "</td><td>" . $row['DogID'] . '<input type="hidden" name="search-id" value=' . $row['DogID'] . '>' . "</td></tr>";
                $row_count++;    
            }
            echo "</table>";
            // Free result set
            $result -> free_result();
        }
        echo "</form>";

        $connection -> close();
    }

    function displayCustomers($first) {
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
        
        if ($result = $connection -> query("SELECT * FROM customer")) {
            echo "<h2 style='text-align: left'>Customers</h1>
            <table border='1'>
            <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Email</th>
            <th>Phone Number</th>
            </tr>";
    
            $row_count = 1;
            while($row = mysqli_fetch_array($result)) {
                echo "<tr><td>" . $row['Username'] . "</td><td>" . $row['FirstName'] . "</td><td>" . $row['LastName'] . "</td><td>". $row['Age'] . "</td><td>". $row['Email'] . "</td><td>". $row['PhoneNumber'] . "</td></tr>";
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
    echo "<script type='text/javascript' src='scripts/admin.js'></script>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }

?>
