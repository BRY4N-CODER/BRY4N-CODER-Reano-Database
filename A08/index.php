<?php
include 'connect.php';

// Ensure the connection is valid
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the search term securely
$search = isset($_GET['search']) ? trim($conn->real_escape_string($_GET['search'])) : '';

// Build SQL query to search by flight number
$sql = "SELECT flightNumber, departureAirportCode, arrivalAirportCode, departureDatetime, arrivalDatetime FROM flightLogs";
if (!empty($search)) {
    $sql .= " WHERE flightNumber LIKE '%$search%'";
}

// Execute the query
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("Query Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Logs Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f7;
        }

        h1 {
            text-align: center;
            color: #34495e;
            margin-top: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .search-bar {
            margin: 20px 0;
            display: flex;
            justify-content: flex-end;
        }

        .search-bar input {
            padding: 8px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .search-bar button {
            background-color: #3498db;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        tr:hover {
            background-color: #ecf0f1;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h2>Tueng Lipad Airlines</h2>
        <div>
            <a href="#">Home</a>
            <a href="#">Logs</a>
            <a href="#">Settings</a>
        </div>
    </div>

    <div class="container">
        <h1>Flight Logs</h1>
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by flight number..." value="<?= htmlspecialchars($search) ?>" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Flight Number</th>
                            <th>Departure Airport</th>
                            <th>Arrival Airport</th>
                            <th>Departure Time</th>
                            <th>Arrival Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['flightNumber'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['departureAirportCode'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['arrivalAirportCode'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['departureDatetime'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['arrivalDatetime'] ?? 'N/A') ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No flight logs found.</p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>&copy; 2024 Airport Management System | Admin Panel</p>
    </div>
</body>

</html>

<?php
$conn->close();
?>
