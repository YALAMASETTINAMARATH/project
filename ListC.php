<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Additional CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
        }

        h2 {
            font-size: 24px;
            color: #007bff;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        button#search-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
    <title>Complement Management System - Search Complaint by ID</title>
</head>
<body>
    <div class="container">
        <h2>COMPLAINT MANAGEMENT SYSTEM<br>Search Complaint by ID</h2>
        
        <!-- Add a search bar for ID number -->
        <form method="post">
            <input type="text" id="search-id" name="id" placeholder="Enter ID Number">
            <button id="search-button" type="submit" name="submit">Search</button>
        </form>
        
        <table id="complaint-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Date of Issue</th>
                <th>Issue</th>
                <th>Description</th>
                <th>Status1</th> <!-- Display status1 before status -->
                <th>Status</th> <!-- Display status after status1 -->
            </tr>
            <?php
            if (isset($_POST['submit'])) {
                // Database connection settings
                $host = 'localhost'; // The hostname of your MySQL server (usually 'localhost' for XAMPP)
                $username = 'root'; // Your MySQL username
                $password = ''; // Your MySQL password (leave it empty if there's no password)
                $database = 'complaint'; // The name of the database you created

                // Create a database connection
                $mysqli = new mysqli($host, $username, $password, $database);

                // Check if the connection is successful
                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }

                // Retrieve user input from the form
                $id = $_POST['id'];

                // Prepare and execute an SQL query to search for a complaint by ID
                $query = "SELECT id, name, address, date_of_issue, issue, description, status1, status FROM data WHERE id = ?";
                $stmt = $mysqli->prepare($query);

                if ($stmt === false) {
                    die("Error in preparing statement: " . $mysqli->error);
                }

                $stmt->bind_param("i", $id);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['date_of_issue'] . "</td>";
                        echo "<td>" . $row['issue'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['status1'] . "</td>"; // Display status1 before status
                        echo "<td>" . $row['status'] . "</td>"; // Display status after status1
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No complaints found with this ID.</td></tr>";
                }

                // Close the database connection
                $stmt->close();
                $mysqli->close();
            }
            ?>
        </table>

        <button onclick="goToDashboard()">Back to Dashboard</button>
    </div>

    <script>
        // JavaScript function to redirect to dashboard.html
        function goToDashboard() {
            window.location.href = "dashboard.html";
        }
    </script>
</body>
</html>