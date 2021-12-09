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

    function submitFile() {
    if ($_FILES)
    {
        $filename = htmlentities($_FILES['filename']['name'], ENT_QUOTES);
        if(htmlentities($_FILES['filename']['type'] == 'text/plain', ENT_QUOTES)) {
            $n = "test.txt";
            htmlentities(move_uploaded_file($_FILES['filename']['tmp_name'], $n), ENT_QUOTES);
            echo "Uploaded text file '$filename' as '$n':<br>";
            fileHandler($n);
        } else {
        echo die("Only TXT files are accepted. <br>");
        }
    } else {
        echo die("No file has been uploaded. <br>");
    };
    displayTable(FALSE);
    }

function fileHandler($filename) {
    require 'login.php';
    $connection = new mysqli($hn, $un, $pw, $db) or die ("Unable to connect");

    $name = htmlentities(strval($_POST['user_input']), ENT_QUOTES);
    if($name == "") {
        echo die("No file name entered.");
    }
    $data = htmlentities(file_get_contents($filename), ENT_QUOTES);
    $username = htmlentities($_SESSION['username']);
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