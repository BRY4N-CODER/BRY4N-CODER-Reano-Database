<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
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
        $addressID = $conn->real_escape_string($_POST['addressID']);
        $delete_sql = "DELETE FROM address WHERE addressID = '$addressID'";
        
        if ($conn->query($delete_sql) === TRUE) {
            echo "<p style='color: green;'>Address deleted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
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
