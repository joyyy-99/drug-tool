<?php
// Include the database connection file
require_once 'Database/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $new_category = $_POST['new_category'];

    // Validate and sanitize the input as needed

    $sql = "INSERT INTO categories (category_name) VALUES ('$new_category')";
    $result = $conn->query($sql);

    if ($result) {
        echo "Category added successfully! Redirecting...";
        echo "<script>setTimeout(function(){ window.location.href = 'edit_drugs.php'; }, 2000);</script>";
    } else {
        echo "Error adding category: " . $conn->error;
    }
} else {
    // Redirect to the main page if accessed directly without a POST request
    header("Location: edit_drugs.php");
    exit();
}

// Close the database connection
$conn->close();
?>
