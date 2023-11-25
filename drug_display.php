<!DOCTYPE html>
<html>
<head>
    <title>Drug Categories</title>
    <link rel="stylesheet" type="text/css" href="CSS/drug_display.css">
</head>
<body>

<?php
require_once "Database/connect.php";

// Function to display an image from blob data
function displayImage($imageData) {
    header("Content-type: image/jpeg"); // Adjust the content type based on your image format
    echo $imageData;
}

// Query to fetch drugs from the database grouped by category
$query = "SELECT DISTINCT Category FROM drugs";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['Category'];
    echo "<h2>$category</h2>";

    // Query to fetch drugs for the current category
    $drugQuery = "SELECT * FROM drugs WHERE Category='$category'";
    $drugResult = mysqli_query($conn, $drugQuery);

    while ($drug = mysqli_fetch_assoc($drugResult)) {
        $drugId = $drug['Tradename'];
        $imageData = $drug['image_data'];

        // Set the maximum width and height for the displayed images
        $maxWidth = "500px"; // Adjust as needed
        $maxHeight = "500px"; // Adjust as needed

        // Display the drug image and link to details page with CSS for resizing
        echo "<div style='max-width: $maxWidth; max-height: $maxHeight; overflow: hidden;'>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='$drugId' style='width: 100%; height: auto;'>";
        echo "<a href='details.php?id=$drugId'>View Details</a>";
        echo "</div>";
    }
}
?>
</body>
</html>