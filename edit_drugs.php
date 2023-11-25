<!DOCTYPE html>
<html>
<head>
    <title>Drug Portal</title>
    <link rel="stylesheet" href="CSS/admin_portal.css">
</head>
<body>
    <header>
        <h1>Welcome to My Afya Drug Dispensing Tool</h1>
        <?php
        session_start();
        require_once 'connect.php';

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

        // Add/Edit Drug Category
        if (isset($_POST['add_category'])) {
            $new_category = $_POST['new_category'];

            // Validate and sanitize the input as needed

            $sql = "INSERT INTO categories (category_name) VALUES ('$new_category')";
            $result = $conn->query($sql);

            if ($result) {
                echo "Category added successfully!";
            } else {
                echo "Error adding category: " . $conn->error;
            }
        }

        // Add/Edit Drug
        if (isset($_POST['add_drug'])) {
            $tradename = $_POST['tradename'];
            $expirationdate = $_POST['expirationdate'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // Validate and sanitize the input as needed

            $sql = "INSERT INTO drugs (tradename, expirationdate, price, category) VALUES ('$tradename', '$expirationdate', '$price', '$category')";
            $result = $conn->query($sql);

            if ($result) {
                echo "Drug added successfully!";
            } else {
                echo "Error adding drug: " . $conn->error;
            }
        }
        ?>
    </header>

    <main>
        <table id="table">
            <thead>
                <th>Tradename</th>
                <th>Expirationdate</th>
                <th>Price</th>
                <th>Category</th>
            </thead>
            <tbody>
                <!-- Fetch and display drugs from the database -->
                <?php
                $fetch_drugs_query = "SELECT Tradename,Expirationdate,Price,Category FROM drugs";
                $fetch_drugs_result = $conn->query($fetch_drugs_query);

                while ($row = $fetch_drugs_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['Tradename']}</td>";
                    echo "<td>{$row['Expirationdate']}</td>";
                    echo "<td>{$row['Price']}</td>";
                    echo "<td>{$row['Category']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add the form for adding/editing drug category and drug -->
        <form method="post" action="process_category.php">
            <label for="new_category">New Category:</label>
            <input type="text" name="new_category" required>
            <button type="submit" name="add_category">Add Category</button>
        </form>

        <form method="post" action="process_drugs.php">
            <label for="tradename">Tradename:</label>
            <input type="text" name="tradename" required>
            <label for="expirationdate">Expiration Date:</label>
            <input type="date" name="expirationdate" required>
            <label for="price">Price:</label>
            <input type="number" name="price" required>
            <label for="category">Category:</label>
            <!-- Populate the category dropdown from the database -->
            <select name="category">
                <?php
                $category_query = "SELECT * FROM categories";
                $category_result = $conn->query($category_query);

                while ($row = $category_result->fetch_assoc()) {
                    echo "<option value='" . $row['category_name'] . "'>" . $row['category_name'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="add_drug">Add Drug</button>
        </form>
    </main>
   
</body>
</html>


