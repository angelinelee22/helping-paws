<?php
    session_start();
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        echo "Welcome back $username.";

        echo "
        <form method='POST'>
            <input type='submit' name='logout' class='button' value='Logout' />
        </form>
        <br>";
        //onsubmit='return validateInput(this)'

    displayTable(TRUE);
    }

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
    $db = 'testdb';
    $connection = new mysqli('localhost', 'root', '', $db) or die ("Unable to connect");

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

    $db = 'testdb';
    $connection = new mysqli('localhost', 'root', '', $db) or die ("Unable to connect");

    if ($connection -> connect_errno) {
        echo "Failed to connect to MySQL: " . $connection -> connect_error;
        exit();
    }
    
    // Perform query
    $username = htmlentities($_SESSION['username']);
    if ($result = $connection -> query("SELECT * FROM dogs")) {
        echo "<h1 style='text-align: left'>Looking for a home</h1>
        <table border='1'>
        <tr>
        <th>Favorite</th>
        <th>Name</th>
        <th>Photo</th>
        <th>Age</th>
        <th>Breed</th>
        <th>Notes</th>
        </tr>";

        $row_count = 1;
        while($row = mysqli_fetch_array($result)) {
            echo "<tr><td>" . "<button onclick='makeFavorite()'>Favorite</button>" . "</td><td>" . $row['Name'] . "</td><td>" . "<img style='height: 150px; width: 150px;' src='data:image/jpeg;base64,".base64_encode( $row['Photo'] )."'/>" . "</td><td>" . $row['Age'] . "</td><td>" . $row['Breed'] . "</td><td>" . $row['Notes'] . "</td></tr>";
            $row_count++;    
        }
        echo "</table>";
        // Free result set
        $result -> free_result();
    }

    // if ($result = $connection -> query("SELECT * FROM files WHERE username='$username' AND favorite='1'")) {
    //     echo "<h1 style='text-align: left'>Favorites</h1>
    //     <table border='1'>
    //     <tr>
    //     <th>Content Name</th>
    //     <th>File Content</th>
    //     <th>Show More</th>
    //     </tr>";

    //     $row_count = 1;
    //     while($row = mysqli_fetch_array($result)) {
    //         $get = nl2br($row['File_Content']);
    //         $content = "<p>" . substr($get, 0, strposX($get, "\n", 3)) . "<span id='show_more" . $row_count . "' style='display: none'>" . substr($get, strposX($get, "\n", 3)) . "</span></p>";
    //         // $content = "<p>" . substr($get, strpos($get, "\n")) . "</p>";
    //         echo "<tr><td>" . $row['Content_Name'] . "</td><td>" . $content. "</td><td>" . "<button onclick='expandBox(" . $row_count .")'>Expand</button>" . "</td></tr>";
    //         $row_count++;    
    //     }
    //     echo "</table>";
    //     // Free result set
    //     $result -> free_result();
    // }

    $connection -> close();
}

if(htmlentities(isset($_POST['submit']), ENT_QUOTES))
{
    submitFile();
} 

if(htmlentities(isset($_POST['logout']), ENT_QUOTES)) {
    $_SESSION = array(); // Delete all the information in the array
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
    header("Location: login_page.php");
}

function strposX($haystack, $needle, $number = 0)
{
    return strpos($haystack, $needle,
        $number > 1 ?
        strposX($haystack, $needle, $number - 1) + strlen($needle) : 0
    );
}
?>