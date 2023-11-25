<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users Table</title>
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
    ?>
</header>

<main>
    <h4>Users Table</h4>

    <!-- Add/Edit User Form -->
    <form action="process_user.php" method="post">
        <label for="ssn">SSN:</label>
        <input type="text" name="ssn" required>

        <label for="firstname">Firstname:</label>
        <input type="text" name="firstname" required>

        <label for="lastname">Lastname:</label>
        <input type="text" name="lastname" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <button type="submit">Add/Edit User</button>
    </form>

    <!-- Display Users Table -->
    <?php
    // Include the database connection file
    require_once 'Database/connect.php';

    // SQL query to retrieve data from the users table
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output table header
        echo "<table><tr><th>SSN</th><th>Firstname</th><th>Lastname</th><th>Gender</th><th>Email</th><th>Last Login</th></tr>";

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["SSN"] . "</td><td>" . $row["Firstname"] . "</td><td>" . $row["Lastname"] . "</td><td>" . $row["Gender"] . "</td><td>" . $row["Emailaddress"] . "</td><td>" . $row["Lastlogin"] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }

    // Close the connection
    $conn->close();
    ?>
</main>

</body>
</html>
