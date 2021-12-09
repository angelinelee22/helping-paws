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
            echo "<form name='selectable-form' id='selectable-form' method='post'>";
            echo "<h2 style='text-align: left'>Dogs</h1>
            <table border='1' id='selectable-table'>
            <tr>
            <th style='display: none'>Dog ID</th>
            <th>Name</th>
            <th>Picture</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Weight</th>
            <th>Color</th>
            <th>Trained</th>
            </tr>";
    
            $row_count = 1;
            while($row = mysqli_fetch_array($result)) {
                echo "<tr><td style='display: none'>" . $row['DogID'] . "</td><td>" . $row['Name'] . "</td><td>" . "<img style='display: block; margin-left: auto; margin-right: auto; max-height: 150px; max-width: 180px;' src='data:image/jpeg;base64,".base64_encode( $row['Image'] )."'/>" . "</td><td>" . $row['Age'] . "</td><td>" . $row['Sex'] . "</td><td>". $row['Weight'] . "</td><td>". $row['Color'] . "</td><td>". $row['Trained'] . "</td></tr>";
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

            echo "<div id='edit-form'>";
            echo "<div id='form-info'>";
            if ($result = $connection -> query("SELECT * FROM Dog INNER JOIN Breed ON Dog.BreedID = Breed.BreedID WHERE DogID = $dog_id;" )) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<h3>" . $row['Name'] . "</h3>"; 

                echo "<p><u>Information</u>";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Name: <input type="text" value="' . $row['Name'] . '" name="name" readonly><br>';
                    echo 'Breed: <input type="text" value="' . $row['BreedName'] . '" name="age" readonly><br>';
                    echo 'Age: <input type="text" value="' . $row['Age'] . '" name="age" readonly><br>';
                    echo 'Sex: <input type="text" value="' . $row['Sex'] . '" name="sex" readonly><br>';
                    echo 'Weight: <input type="text" value="' . $row['Weight'] . '" name="weight" readonly><br>';
                    echo 'Color: <input type="text" value="' . $row['Color'] . '" name="color" readonly><br>';
                    echo 'Trained: <input type="text" value="' . $row['Trained'] . '" name="trained" readonly><br>';
                echo "</form></p>";
                // Free result set
                $result -> free_result();
            }
            
            echo "</div><div id='form-bg'>";

            if ($result = $connection -> query("SELECT * FROM Dog INNER JOIN PastHistory ON Dog.DogID = PastHistory.DogID WHERE Dog.DogID = $dog_id;" )) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<p><u>Background</u>";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Previous Organization: <input type="text" value="' . $row['PastOrganization'] . '" name="pastorg" readonly><br>';
                    echo 'Previous Owner: <input type="text" value="' . $row['PastOwner'] . '" name="pastowner" readonly><br>';
                echo "</form></p>";
                // Free result set
                $result -> free_result();
            }

            echo "</div><div id='form-med'>";

            if ($result = $connection -> query("SELECT * FROM MedicalHistory INNER JOIN Vaccination ON MedicalHistory.MedicalHistoryID = Vaccination.MedicalHistoryID INNER JOIN Ailment ON MedicalHistory.MedicalHistoryID = Ailment.MedicalHistoryID WHERE MedicalHistory.DogID = $dog_id;" )) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<p><u>Medical History</u>";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Neutered: <input type="text" value="' . $row['NeuteredStatus'] . '" name="neutered" readonly><br>';

                    echo "<p>Vaccinations <a class='plus-sign' id='add-vax'>&plus;</a></p>";
                    echo 'VaccinationName: <input type="text" value="' . $row['VaccinationName'] . '" name="name" readonly><br>';

                    echo "<p>Ailments <a class='plus-sign' id='add-ail'>&plus;</a></p>";
                    echo 'Affliction: <input type="text" value="' . $row['AilmentName'] . '" name="name" readonly><br>';
                echo "</form></p>";
                // Free result set
                $result -> free_result();
            }
            echo "</div></div>";
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
