<?php
// Include the database connection file
require_once 'Database/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_drug'])) {
    $tradename = $_POST['tradename'];
    $expirationdate = $_POST['expirationdate'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Validate and sanitize the input as needed

    $sql = "INSERT INTO drugs (tradename, expirationdate, price, category) VALUES ('$tradename', '$expirationdate', '$price', '$category')";
    $result = $conn->query($sql);

    if ($result) {
        echo "Drug added successfully! Redirecting...";
        echo "<script>setTimeout(function(){ window.location.href = 'edit_drugs.php'; }, 2000);</script>";
    } else {
        echo "Error adding drug: " . $conn->error;
    }
} else {
    // Redirect to the main page if accessed directly without a POST request
    header("Location: edit_drugs.php");
    exit();
}

// Close the database connection
$conn->close();
?>
