<?php
include 'connect.php';

$edit_data = null; // Initialize the variable for editing

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Insert new address logic
        $userInfoID = $conn->real_escape_string($_POST['userInfoID']);
        $cityID = $conn->real_escape_string($_POST['cityID']);
        $provinceID = $conn->real_escape_string($_POST['provinceID']);

        $insert_sql = "INSERT INTO address (userInfoID, cityID, provinceID) VALUES ('$userInfoID', '$cityID', '$provinceID')";
        
        if ($conn->query($insert_sql) === TRUE) {
            echo "<p style='color: green;'>Address added successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    } elseif (isset($_POST['delete'])) {
        // Delete address logic
        $addressID = $conn->real_escape_string($_POST['addressID']);
        $delete_sql = "DELETE FROM address WHERE addressID = '$addressID'";
        
        if ($conn->query($delete_sql) === TRUE) {
            echo "<p style='color: green;'>Address deleted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    } elseif (isset($_POST['edit'])) {
        // Fetch address data for editing
        $addressID = $conn->real_escape_string($_POST['addressID']);
        $edit_sql = "SELECT * FROM address WHERE addressID = '$addressID'";
        $edit_result = $conn->query($edit_sql);
        
        if ($edit_result->num_rows > 0) {
            $edit_data = $edit_result->fetch_assoc();
        } else {
            echo "<p style='color: red;'>Error: No record found for editing.</p>";
        }
    } elseif (isset($_POST['update'])) {
        // Update address data logic
        $addressID = $conn->real_escape_string($_POST['addressID']);
        $userInfoID = $conn->real_escape_string($_POST['userInfoID']);
        $cityID = $conn->real_escape_string($_POST['cityID']);
        $provinceID = $conn->real_escape_string($_POST['provinceID']);

        $update_sql = "UPDATE address SET userInfoID='$userInfoID', cityID='$cityID', provinceID='$provinceID' WHERE addressID='$addressID'";
        
        if ($conn->query($update_sql) === TRUE) {
            echo "<p style='color: green;'>Address updated successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    }

}

$sql = "SELECT * FROM address"; 
$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Records</title>
    <style>
      * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 2.5em;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .intro {
            text-align: center;
            margin-bottom: 20px;
            color: #7f8c8d;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #2c3e50;
        }

        input[type="text"], input[type="submit"] {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #3498db;
            color: #fff;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:nth-child(even) {
            background-color: #fff;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .edit-btn {
            background-color: #f1c40f;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-btn:hover {
            background-color: #d4ac0d;
        }


        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th, td {
                padding: 10px;
                text-align: left;
            }

            tbody tr {
                margin-bottom: 10px;
                border-bottom: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Address Records</h1>
    <p class="intro">Manage address data effectively with this interactive table. Add or delete records as needed.</p>

    <h2>Add New Address</h2>
    <form action="" method="POST">
        <label for="userInfoID">User Info ID:</label>
        <input type="text" name="userInfoID" id="userInfoID" required>

        <label for="cityID">City ID:</label>
        <input type="text" name="cityID" id="cityID" required>

        <label for="provinceID">Province ID:</label>
        <input type="text" name="provinceID" id="provinceID" required>

        <input type="submit" name="submit" value="Add Address">
    </form>

    <?php if (isset($edit_data)): ?>
        <h2>Edit Address</h2>
        <form action="" method="POST">
            <input type="hidden" name="addressID" value="<?php echo htmlspecialchars($edit_data['addressID']); ?>">

            <label for="userInfoID">User Info ID:</label>
            <input type="text" name="userInfoID" id="userInfoID" value="<?php echo htmlspecialchars($edit_data['userInfoID']); ?>" required>

            <label for="cityID">City ID:</label>
            <input type="text" name="cityID" id="cityID" value="<?php echo htmlspecialchars($edit_data['cityID']); ?>" required>

            <label for="provinceID">Province ID:</label>
            <input type="text" name="provinceID" id="provinceID" value="<?php echo htmlspecialchars($edit_data['provinceID']); ?>" required>

            <input type="submit" name="update" value="Update Address">
        </form>
    <?php endif; ?>

    <h2>Address Table</h2>
    <table>
        <thead>
            <tr>
                <th>Address ID</th>
                <th>User Info ID</th>
                <th>City ID</th>
                <th>Province ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['addressID']); ?></td>
                        <td><?php echo htmlspecialchars($row['userInfoID']); ?></td>
                        <td><?php echo htmlspecialchars($row['cityID']); ?></td>
                        <td><?php echo htmlspecialchars($row['provinceID']); ?></td>
                        <td>
                            <form action="" method="POST" style="display: inline;">
                                <input type="hidden" name="addressID" value="<?php echo htmlspecialchars($row['addressID']); ?>">
                                <input type="submit" name="delete" value="Delete" class="delete-btn">
                            </form>
                            <form action="" method="POST" style="display: inline;">
                                <input type="hidden" name="addressID" value="<?php echo htmlspecialchars($row['addressID']); ?>">
                                <input type="submit" name="edit" value="Edit" class="edit-btn">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No data available in the database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>