<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add any additional CSS styles here if needed */
        /* Your existing CSS styles */

        /* Additional styles for the Resolve Complaint form */
        .container {
            width: 450px;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
        }

        h2 {
            font-size: 24px;
            color: #007bff;
        }

        label, input, textarea {
            display: block;
            margin-bottom: 15px;
            width: 100%;
        }

        .form-group {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .form-group label {
            flex: 1;
            margin-right: 10px;
            text-align: right;
            font-weight: bold;
        }

        .form-group input, .form-group textarea {
            flex: 2;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            margin-top: 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
    <title>Complement Management System - Resolve Complaint</title>
</head>
<body>
    <div class="container">
        <h2>COMPLAINT MANAGEMENT SYSTEM<br>RESOLVE COMPLAINT</h2>
        <form id="resolve-complaint-form" method="post">
            <div class="form-group">
                <label for="id">ID Number:</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="resolution">Resolution:</label>
                <textarea id="resolution" name="resolution" required></textarea>
            </div>
            <button type="submit" name="submit">Resolve Complaint</button>
        </form>
        
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

            // Retrieve data from the HTML form
            $id = $_POST['id'];
            $resolution = $_POST['resolution'];

            // Prepare and execute an SQL query to update the resolution and status based on the ID number
            $updateQuery = "UPDATE data SET resolution = ?, status = 'Complaint resolved successfully' WHERE id = ?";
            $stmt = $mysqli->prepare($updateQuery);

            if ($stmt === false) {
                die("Error in preparing statement: " . $mysqli->error);
            }

            $stmt->bind_param("ss", $resolution, $id);

            if ($stmt->execute()) {
                echo "<p>Complaint resolved successfully!</p>";
                // Redirect to the dashboard page after a short delay (e.g., 2 seconds)
                echo "<script>setTimeout(function() { window.location.href = 'dashboardnew.html'; }, 2000);</script>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }

            // Close the database connection
            $stmt->close();
            $mysqli->close();
        }
        ?>

        <button onclick="goToDashboard()">Back to Dashboard</button>
    </div>

    <script>
        // JavaScript function to redirect to dashboard.html
        function goToDashboard() {
            window.location.href = "dashboardnew.html";
        }
    </script>
</body>
</html>