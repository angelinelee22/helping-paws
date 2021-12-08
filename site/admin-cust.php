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
        echo "<h1 style='text-align:center;'>Admin Panel</h1>";
    
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
        
        if ($result = $connection -> query("SELECT * FROM Dog INNER JOIN Breed WHERE Dog.BreedID = Breed.BreedID;" )) {
            echo "<form name='dog-form' id='dog-form' method='post'>";
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
            </tr>";
    
            $row_count = 1;
            while($row = mysqli_fetch_array($result)) {
                echo "<tr class='dog-row'><td>" . $row['Name'] . "</td><td>" . $row['BreedName'] . "</td><td>" . $row['Age'] . "</td><td>" . $row['Sex'] . "</td><td>". $row['Weight'] . "</td><td>". $row['Color'] . "</td><td>". $row['Trained'] . "</td><td style='display: none'>" . $row['DogID'] . "</td></tr>";
                $row_count++;    
            }
            echo "</table>";
            echo '<input type="hidden" class="search-id" name="search-id" value="0"' . $row['DogID'] . '>';
            echo "</form>";
            // Free result set
            $result -> free_result();
        }

        if (isset($_POST['search-id'])) {
            $search_id = get_post($connection, 'search-id');
            $dog_id = htmlentities($search_id);

            if ($result = $connection -> query("SELECT * FROM Dog INNER JOIN Breed ON Dog.BreedID = Breed.BreedID WHERE DogID = $dog_id;" )) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<h3>" . $row['Name'] . "</h3>"; 

                echo "<p><u>Information</u></p>";
                echo "<form name='dog-form' id='dog-form' method='post'>";
                echo 'Name: <input size="36" type="text" value="' . $row['Name'] . '" name="name" readonly><br>';
                echo 'Age: <input size="36" type="text" value="' . $row['Age'] . '" name="age" readonly><br>';
                echo 'Sex: <input size="36" type="text" value="' . $row['Sex'] . '" name="sex" readonly><br>';
                echo 'Weight: <input size="36" type="text" value="' . $row['Weight'] . '" name="weight" readonly><br>';
                echo 'Color: <input size="36" type="text" value="' . $row['Color'] . '" name="color" readonly><br>';
                echo 'Trained: <input size="36" type="text" value="' . $row['Trained'] . '" name="trained" readonly><br>';
                echo "</form>";
                // Free result set
                $result -> free_result();
            }

            if ($result = $connection -> query("SELECT * FROM Dog INNER JOIN PastHistory ON Dog.DogID = PastHistory.DogID WHERE Dog.DogID = $dog_id;" )) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<p><u>History</u></p>";
                                echo "<form name='dog-form' id='dog-form' method='post'>";
                echo 'Previous Organization: <input size="36" type="text" value="' . $row['PastOrganization'] . '" name="pastorg" readonly><br>';
                echo 'Previous Owner: <input size="36" type="text" value="' . $row['PastOwner'] . '" name="pastowner" readonly><br>';
                echo "</form>";
                // Free result set
                $result -> free_result();
            }
        }

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

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // }

?>
