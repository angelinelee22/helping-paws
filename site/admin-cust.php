<?php 
    session_start();
    include('components/navbar.php');
    echo "<style>";
    include_once('style/navbar.css');
    include_once('style/admin.css');
    echo "</style>";
    
    if (isset($_SESSION['adminname'])) {
        $admin = $_SESSION['adminname'];
        $password = $_SESSION['password'];
        echo "<h1 style='text-align:center;'>Admin Panel</h1>";
    
        displayCustomers(TRUE);
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
            echo "<form name='selectable-form' id='selectable-form' method='post'>";
            echo "<h2 style='text-align: left'>Customers</h1>
            <table border='1' id='selectable-table'>
            <tr>
            <th style='display: none'>Customer ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Password</th>
            <th>Age</th>
            <th>Email on File</th>
            <th>Phone Number</th>
            </tr>";
    
            $row_count = 1;
            while($row = mysqli_fetch_array($result)) {
                echo "<tr><td style='display: none'>" . $row['CustomerID'] . "</td><td>" . $row['FirstName'] . "</td><td>" . $row['LastName'] . "</td><td>" . $row['Username'] . "</td><td>". $row['Password'] . "</td><td>". $row['Age'] . "</td><td>". $row['Email'] . "</td><td>". $row['PhoneNumber'] . "</td></tr>";
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
            $cust_id = htmlentities($search_id);

            echo "<div id='edit-form'>";
            echo "<div id='form-info'>";
            // TODO: Fix if address null
            if ($result = $connection -> query("SELECT * FROM Customer INNER JOIN `Address` ON Customer.CustomerID = Address.CustomerID WHERE Customer.CustomerID = $cust_id;" )) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<h3>" . $row['FirstName'] . " " . $row['LastName'] . "</h3>"; 

                echo "<p><u>Information</u>";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'First Name: <input type="text" value="' . $row['FirstName'] . '" name="name" readonly><br>';
                    echo 'Last Name: <input type="text" value="' . $row['LastName'] . '" name="age" readonly><br>';
                    echo 'Username: <input type="text" value="' . $row['Username'] . '" name="age" readonly><br>';
                    echo 'Password: <input type="text" value="' . $row['Password'] . '" name="sex" readonly><br>';
                    echo 'Age: <input type="text" value="' . $row['Age'] . '" name="weight" readonly><br>';
                    echo 'Email on File: <input type="text" value="' . $row['Email'] . '" name="color" readonly><br>';
                    echo 'Phone Number: <input type="text" value="' . $row['PhoneNumber'] . '" name="trained" readonly><br>';
                echo "</form></p>";

                echo "<p>Address";
                    echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Street: <input type="text" value="' . $row['Street'] . '" name="pastorg" readonly><br>';
                    echo 'City: <input type="text" value="' . $row['City'] . '" name="pastowner" readonly><br>';
                    echo 'State: <input type="text" value="' . $row['State'] . '" name="pastorg" readonly><br>';
                    echo 'Country: <input type="text" value="' . $row['Country'] . '" name="pastowner" readonly><br>';
                    echo 'Zip Code: <input type="text" value="' . $row['ZipCode'] . '" name="pastowner" readonly><br>';
                echo "</form></p>";
                // Free result set
                $result -> free_result();
            }
            
            echo "</div><div id='form-bg'>";

            if ($result = $connection -> query("SELECT * FROM Customer INNER JOIN CustomerBackground ON Customer.CustomerID = CustomerBackground.CustomerID INNER JOIN CriminalRecord ON Customer.CustomerID = CriminalRecord.CustomerID WHERE Customer.CustomerID = $cust_id;" )) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<p><u>Background</u>";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Salary: <input type="text" value="' . $row['Salary'] . '" name="pastorg" readonly><br>';
                    echo '# in Household: <input type="text" value="' . $row['NumPeopleHousehold'] . '" name="pastowner" readonly><br>';
                    echo '# Kids: <input type="text" value="' . $row['NumKids'] . '" name="pastorg" readonly><br>';
                    echo '# Current Pets: <input type="text" value="' . $row['NumCurrPets'] . '" name="pastowner" readonly><br>';
                    echo 'Budget: <input type="text" value="' . $row['BUDGET'] . '" name="pastowner" readonly><br>';
                echo "</form></p>";
                echo "<p>Criminal History  <a class='plus-sign' id='add-crim'>&plus;</a>";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Crime Record: <input type="text" value="' . $row['CriminalRecordName'] . '" name="pastorg" readonly><br>';
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
