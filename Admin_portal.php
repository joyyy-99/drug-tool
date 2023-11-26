<!DOCTYPE html>
<html>
<head>
    <title>Admin Portal</title>
    <link rel="stylesheet" href="CSS/admin_portal.css">
</head>
<body>
    <header>
        <h1>Welcome to My Afya Drug Dispensing Tool</h1>
        <?php
        session_start();
        require_once 'Database/connect.php';

        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $username = $_SESSION['username'];
            echo '<div class="profile-info">';
            echo '<img class="profile-image" src="Images/profile.png" alt="Profile Picture">';
            echo 'Logged in as: ' . $username;
            echo '<br>';
            echo 'Admin';
            echo '<br>';
            echo '<a href ="logout.php"><button>Log Out </button></a>';
            echo '</div>';
        } else {
            header('Location: login.html');
            exit();
        }

        $db = $conn;

        $tableNameDoctors = "doctors";
        $columnsDoctors = ['SSN', 'Firstname', 'Lastname', 'Homeaddress', 'Age', 'Gender', 'Emailaddress', 'Phonenumber', 'Dateofbirth', 'Speciality', 'Yearsofexperience', 'Username', 'Passwords'];
        $fetchDataDoctors = fetch_data($db, $tableNameDoctors, $columnsDoctors);

        $tableNamePatients = "patients";
        $columnsPatients = ['SSN', 'Firstname', 'Lastname', 'Homeaddress', 'Age', 'Gender', 'Emailaddress', 'Phonenumber', 'Dateofbirth', 'Username', 'Passwords'];
        $fetchDataPatients = fetch_data($db, $tableNamePatients, $columnsPatients);

        $tableNamePharmacists = "pharmacists";
        $columnsPharmacists = ['SSN', 'Firstname', 'Lastname', 'Homeaddress', 'Age', 'Gender', 'Emailaddress', 'Phonenumber', 'Dateofbirth','PlaceofWork','Username', 'Passwords'];
        $fetchDataPharmacists = fetch_data($db, $tableNamePharmacists, $columnsPharmacists);

        function fetch_data($db, $tableName, $columns)
        {
            if (empty($db)) {
                $msg = "Database connection error";
            } elseif (empty($columns) || !is_array($columns)) {
                $msg = "Columns name must be defined in an indexed array";
            } elseif (empty($tableName)) {
                $msg = "Table name is empty";
            } else {
                $columnName = implode(", ", $columns);
                $query = "SELECT $columnName FROM $tableName";
                $result = $db->query($query);

                if ($result == true) {
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_all(MYSQLI_ASSOC);
                        $msg = $row;
                    } else {
                        $msg = "No data found";
                    }
                } else {
                    $msg = mysqli_error($db);
                }
            }
            return $msg;
        }
        ?>
    </header>
    <div class="navbar">
        <ul>
            <li>
                <a href="Users.php">User Details</a>
            </li>
            <li>
                <a href="drug_display.php">Drug details</a>
            </li>
            <li>
                <a href="edit_drugs.php">Edit drugs</a>
            </li>
        </ul>
    </div>
    
    <main>
        <h4>Doctor's Table</h4>
        <table id="table">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Homeaddress</th>
                    <th>Age</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($fetchDataDoctors)) {
                    foreach ($fetchDataDoctors as $data) {
                        ?>
                        <tr>
                            <td><?php echo $data['Firstname'] ?? ''; ?></td>
                            <td><?php echo $data['Lastname'] ?? ''; ?></td>
                            <td><?php echo $data['Homeaddress'] ?? ''; ?></td>
                            <td><?php echo $data['Age'] ?? ''; ?></td> 
                            <td><?php echo $data['Gender'] ?? ''; ?></td> 
                        </tr>
                        <?php
                    }
                } else { 
                    ?>
                    <tr>
                        <td colspan="5">
                            <?php echo $fetchDataDoctors; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>                 
            </tbody>
        </table>

        <h4>Patients Table</h4>
        <table id="table">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($fetchDataPatients)) {
                    foreach ($fetchDataPatients as $data) {
                        ?>
                        <tr>
                            <td><?php echo $data['Firstname'] ?? ''; ?></td>
                            <td><?php echo $data['Lastname'] ?? ''; ?></td>
                            <td><?php echo $data['Age'] ?? ''; ?></td>
                            <td><?php echo $data['Gender'] ?? ''; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">
                            <?php echo $fetchDataPatients; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <h4>Pharmacists Table</h4>
        <table id="table">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($fetchDataPharmacists)) {
                    foreach ($fetchDataPharmacists as $data) {
                        ?>
                        <tr>
                            <td><?php echo $data['Firstname'] ?? ''; ?></td>
                            <td><?php echo $data['Lastname'] ?? ''; ?></td>
                            <td><?php echo $data['Age'] ?? ''; ?></td>
                            <td><?php echo $data['Gender'] ?? ''; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">
                            <?php echo $fetchDataPharmacists; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </main>
    <script src="JS/admin_portal.js"></script>
</body>
</html>
