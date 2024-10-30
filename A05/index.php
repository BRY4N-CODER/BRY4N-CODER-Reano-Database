<?php
include 'connect.php';

$sql = "SELECT * FROM address"; 
$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error); // Debugging line
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Records</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and container styling */
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

        /* Header styling */
        h1 {
            font-size: 2.5em;
            color: #007bff;
            margin-bottom: 0.5em;
        }
        .intro {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 2em;
        }

        /* Card styling */
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

        /* No data message styling */
        .no-data {
            font-size: 1.2em;
            color: #888;
            margin-top: 1em;
        }

        /* Responsive styling */
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
    <p class="intro">This is a list of address entries that are kept in our database. Essential information regarding a particular address is displayed in each entry..</p>

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
