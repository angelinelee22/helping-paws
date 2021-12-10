<?php 
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
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

        if ($result = $connection -> query("SELECT * FROM Customer;")) {
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
            echo '<input type="hidden" class="search-id" name="search-id" value="0">';
            echo "</form>";
            // Free result set
            $result -> free_result();
        }

        if (isset($_POST['search-id'])) {
            $search_id = get_post($connection, 'search-id');
            $cust_id = htmlentities($search_id);

            echo "<div id='edit-form'>";
            echo "<div id='form-info'>";

            $profiled = !empty(mysqli_fetch_array($connection -> query("SELECT COUNT(*) FROM Customer WHERE Customer.CustomerID = $cust_id AND EXISTS (SELECT null FROM Address WHERE Customer.CustomerID = Address.CustomerID);"))[0]) ? 1 : 0;

            if ($profiled ? $result = $connection -> query("SELECT * FROM Customer INNER JOIN `Address` ON Customer.CustomerID = `Address`.CustomerID WHERE Customer.CustomerID = $cust_id;") : $result = $connection -> query("SELECT * FROM Customer WHERE Customer.CustomerID = $cust_id;")) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<p><u>Information</u>";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'First Name: <input type="text" value="' . ((!empty($row['FirstName']) && $row['FirstName'] != null) ? $row['FirstName'] : "") . '" name="firstname" readonly><br>';
                    echo 'Last Name: <input type="text" value="' . ((!empty($row['LastName']) && $row['LastName'] != null) ? $row['LastName'] : "") . '" name="lastname" readonly><br>';
                    echo 'Username: <input type="text" value="' . ((!empty($row['Username']) && $row['Username'] != null) ? $row['Username'] : "") . '" name="uname" readonly><br>';
                    echo 'Password: <input type="text" value="' . ((!empty($row['Password']) && $row['Password'] != null) ? $row['Password'] : "") . '" name="pword" readonly><br>';
                    echo 'Age: <input type="text" value="' . ((!empty($row['Age']) && $row['Age'] != null) ? $row['Age'] : "") . '" name="age" readonly><br>';
                    echo 'Email on File: <input type="text" value="' . ((!empty($row['Email']) && $row['Email'] != null) ? $row['Email'] : "") . '" name="email" readonly><br>';
                    echo 'Phone Number: <input type="text" value="' . ((!empty($row['PhoneNumber']) && $row['PhoneNumber'] != null) ? $row['PhoneNumber'] : "") . '" name="phonenumber" readonly><br>';
                echo "</form></p>";

                echo "<p>Address";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                    echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Street: <input type="text" value="' . ((!empty($row['Street']) && $row['Street'] != null) ? $row['Street'] : "") . '" name="street" readonly><br>';
                    echo 'City: <input type="text" value="' . ((!empty($row['City']) && $row['City'] != null) ? $row['City'] : "") . '" name="city" readonly><br>';
                    echo 'State: <input type="text" value="' . ((!empty($row['State']) && $row['State'] != null) ? $row['State'] : "") . '" name="state" readonly><br>';
                    echo 'Country: <input type="text" value="' . ((!empty($row['Country']) && $row['Country'] != null) ? $row['Country'] : "") . '" name="country" readonly><br>';
                    echo 'Zip Code: <input type="text" value="' . ((!empty($row['ZipCode']) && $row['ZipCode'] != null) ? $row['ZipCode'] : "") . '" name="zipcode" readonly><br>';
                echo "</form></p>";
                // Free result set
                $result -> free_result();
            }

            if ($result = $connection -> query("SELECT * FROM Customer INNER JOIN `CustomerAvail` ON Customer.CustomerID = CustomerAvail.CustomerID WHERE Customer.CustomerID = $cust_id;")) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);
                echo "<p>Interests";  
                    echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Time Commitment: <input type="text" value="' . ((!empty($row['TimeCommitment']) && $row['TimeCommitment'] != null) ? $row['TimeCommitment'] : "") . '" name="firstname" readonly><br>';
                echo "</form></p>";

                // Free result set
                $result -> free_result();
            }
            
            if ($result = $connection -> query("SELECT * FROM Customer INNER JOIN CustomerBackground ON Customer.CustomerID = CustomerBackground.CustomerID INNER JOIN CriminalRecord ON Customer.CustomerID = CriminalRecord.CustomerID WHERE Customer.CustomerID = $cust_id;" )) {
                $row_count = 1;
                $row = mysqli_fetch_array($result);

                echo "<p><u>Background</u>";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Salary: <input type="text" value="' . ((!empty($row['Salary']) && $row['Salary'] != null) ? $row['Salary'] : "") . '" name="salary" readonly><br>';
                    echo '# in Household: <input type="text" value="' . ((!empty($row['NumPeopleHousehold']) && $row['NumPeopleHousehold'] != null) ? $row['NumPeopleHousehold'] : "") . '" name="household" readonly><br>';
                    echo '# Kids: <input type="text" value="' . ((!empty($row['NumKids']) && $row['NumKids'] != null) ? $row['NumKids'] : "") . '" name="kids" readonly><br>';
                    echo '# Current Pets: <input type="text" value="' . ((!empty($row['NumCurrPets']) && $row['NumCurrPets'] != null) ? $row['NumCurrPets'] : "") . '" name="currpets" readonly><br>';
                    echo 'Budget: <input type="text" value="' . ((!empty($row['BUDGET']) && $row['BUDGET'] != null) ? $row['BUDGET'] : "") . '" name="budget" readonly><br>';
                echo "</form></p>";
                echo "<p>Criminal History";
                echo "<form name='selectable-form' class='selectable-form' method='post'>";
                    echo 'Crime Record: <input type="text" value="' . ((!empty($row['CriminalRecordName']) && $row['CriminalRecordName'] != null) ? $row['CriminalRecordName'] : "") . '" name="pastorg" readonly><br>';
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
        //TODO if time: Allow users to modify   
    }
    echo "<script type='text/javascript' src='scripts/admin.js'></script>";
?>
