<?php
// Include the database connection file
require_once 'Database/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $ssn = $_POST['ssn'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];

    // Validate and sanitize input (implement your own validation logic)

    // Check if SSN already exists in the database for editing
    $existingUserQuery = "SELECT * FROM users WHERE SSN = '$ssn'";
    $existingUserResult = $conn->query($existingUserQuery);

    if ($existingUserResult->num_rows > 0) {
        // User exists, perform update
        $updateQuery = "UPDATE users SET
            Firstname = '$firstname',
            Lastname = '$lastname',
            Gender = '$gender',
            Emailaddress = '$email'
            WHERE SSN = '$ssn'";
        
        if ($conn->query($updateQuery) === TRUE) {
            // Display success message and redirect to users.php after a short delay
            echo "User updated successfully. Redirecting...";
            echo "<script>setTimeout(function(){ window.location.href = 'users.php'; }, 2000);</script>";
        } else {
            echo "Error updating user: " . $conn->error;
        }
    } else {
        // User doesn't exist, perform insert
        $insertQuery = "INSERT INTO users (SSN, Firstname, Lastname, Gender, Emailaddress)
            VALUES ('$ssn', '$firstname', '$lastname', '$gender', '$email')";
        
        if ($conn->query($insertQuery) === TRUE) {
            // Display success message and redirect to users.php after a short delay
            echo "User added successfully. Redirecting...";
            echo "<script>setTimeout(function(){ window.location.href = 'users.php'; }, 2000);</script>";
        } else {
            echo "Error adding user: " . $conn->error;
        }
    }
} else {
    // Redirect to the form page if accessed directly without a POST request
    header("Location: users.php");
    exit();
}

// Close the database connection
$conn->close();
?>
