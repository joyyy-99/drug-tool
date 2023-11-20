<?php
require_once 'Database/connect.php';
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernames = $_POST['username'];
    $passwords = $_POST['password'];
    $role = $_POST['role'];

   
      // Perform authentication based on the role
if ($role === 'patient') {
    // Authenticate patient
    $sql = "SELECT * FROM patients WHERE username = '$usernames' AND passwords = '$passwords'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Authentication successful
        // Set session variables
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $usernames;

        // Redirect to patient page
        header('Location: patient_view.php');
        exit();
    } else {
        // Invalid credentials
        echo "Invalid username or password for the patient role.";
    }


    } elseif ($role === 'doctor') {

            // Authenticate doctor
            $sql = "SELECT * FROM doctors WHERE username = '$usernames' AND passwords = '$passwords'";
            $result = $conn->query($sql);
        
            if ($result->num_rows == 1) {
                // Authentication successful
                // Set session variables
                $_SESSION['role'] = $role;
                $_SESSION['username'] = $usernames;
        
                // Redirect to doctor page
                header('Location: doctor_view.php');
                exit();
            } else {
                // Invalid credentials
                echo "Invalid username or password for the doctor role.";
            }
        
        
    } elseif ($role === 'pharmacist') {
        // Authenticate pharmacist
        $sql = "SELECT * FROM pharmacists WHERE username = '$usernames' AND passwords = '$passwords'";
        $result = $conn->query($sql);
    
        if ($result->num_rows == 1) {
            // Authentication successful
            // Set session variables
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $usernames;
    
            // Redirect to pharmacist page
            header('Location: pharmacist_view.php');
            exit();
        } else {
            // Invalid credentials
            echo "Invalid username or password for the doctor role.";
        }
    } elseif ($role === 'admin') {
        // Authenticate pharmaceutical company
        $sql = "SELECT * FROM admins WHERE username = '$usernames' AND passwords = '$passwords'";
        $result = $conn->query($sql);
    
        if ($result->num_rows == 1) {
            // Authentication successful
            // Set session variables
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $usernames;
    
            // Redirect to admin page
            header('Location: admin_view.php');
            exit();
        } else {
            // Invalid credentials
            echo "Invalid username or password for the doctor role.";
        }
    } elseif ($role === 'company') {
        // Authenticate company
        $sql = "SELECT * FROM companies WHERE username = '$usernames' AND passwords = '$passwords'";
        $result = $conn->query($sql);
    
        if ($result->num_rows == 1) {
            // Authentication successful
            // Set session variables
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $usernames;
    
            // Redirect to doctor page
            header('Location: doctor_table.php');
            exit();
        } else {
            // Invalid credentials
            echo "Invalid username or password for the doctor role.";
        }
    } else {
        // Invalid role
        echo "Invalid role selected.";
    }
}
?>

