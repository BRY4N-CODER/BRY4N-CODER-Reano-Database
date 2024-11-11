<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $userInfoID = $conn->real_escape_string($_POST['userInfoID']);
    $cityID = $conn->real_escape_string($_POST['cityID']);
    $provinceID = $conn->real_escape_string($_POST['provinceID']);

    $insert_sql = "INSERT INTO address (userInfoID, cityID, provinceID) VALUES ('$userInfoID', '$cityID', '$provinceID')";
    
    if ($conn->query($insert_sql) === TRUE) {
        echo "<p style='color: green;'>New address added successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 2.5em;
            color: #007bff;
            margin-bottom: 0.5em;
        }
        h2 {
            font-size: 2em;
            color: #555;
            margin-top: 1em;
        }
        .intro {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 2em;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            color: #007bff;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 1em;
            color: #333;
        }

        .no-data {
            font-size: 1.2em;
            color: #888;
            margin-top: 1em;
        }

        form {
            margin-bottom: 2em;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            font-size: 1em;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            max-width: 300px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        @media (min-width: 600px) {
            .card {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .card h3, .card p {
                margin: 0;
            }
            .card p {
                margin-left: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Address Records</h1>
    <p class="intro">This is a list of address entries that are kept in our database. Essential information regarding a particular address is displayed in each entry.</p>

 
    <h2>Add New Address</h2>
    <form action="" method="POST">
        <label for="userInfoID">User Info ID:</label>
        <input type="text" name="userInfoID" id="userInfoID" required><br>

        <label for="cityID">City ID:</label>
        <input type="text" name="cityID" id="cityID" required><br>

        <label for="provinceID">Province ID:</label>
        <input type="text" name="provinceID" id="provinceID" required><br>

        <input type="submit" name="submit" value="Add Address">
    </form>


    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card">
                <h3>Address ID: <?php echo htmlspecialchars($row['addressID']); ?></h3>
                <p><strong>User Info ID:</strong> <?php echo htmlspecialchars($row['userInfoID']); ?></p>
                <p><strong>City ID:</strong> <?php echo htmlspecialchars($row['cityID']); ?></p>
                <p><strong>Province ID:</strong> <?php echo htmlspecialchars($row['provinceID']); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="no-data">No data available in the database.</p>
    <?php endif; ?>

</div>

</body>
</html>
