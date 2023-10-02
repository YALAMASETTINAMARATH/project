<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add any additional CSS styles here if needed */
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
            width: 100%; /* Full width */
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
    <title>Complement Management System - Register Complaint</title>
</head>
<body>
    <div class="container">
        <h2>COMPLAINT MANAGEMENT SYSTEM<br>REGISTER COMPLAINT</h2>
        <form id="complaint-form" method="post">
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="number" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="date-of-issue">Date of Issue:</label>
                <input type="date" id="date-of-issue" name="date-of-issue" required>
            </div>
            <div class="form-group">
                <label for="issue">Issue:</label>
                <input type="text" id="issue" name="issue" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <button type="submit" name="submit">Register Complaint</button>
        </form>
        <button onclick="goToDashboard()">Back to Dashboard</button>
    </div>
    
    <?php
    if (isset($_POST['submit'])) {
        // Database connection settings (update with your credentials)
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'complaint';

        // Create a database connection
        $mysqli = new mysqli($host, $username, $password, $database);

        // Check if the connection is successful
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Retrieve user input from the form
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $dateOfIssue = $_POST['date-of-issue'];
        $issue = $_POST['issue'];
        $description = $_POST['description'];

        // Prepare and execute an SQL query to insert the complaint into the database
        $query = "INSERT INTO data (id, name, address, date_of_issue, issue, description, status1) VALUES (?, ?, ?, ?, ?, ?, 'Complaint registered successfully')";
        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            die("Error in preparing statement: " . $mysqli->error);
        }

        $stmt->bind_param("isssss", $id, $name, $address, $dateOfIssue, $issue, $description);

        if ($stmt->execute()) {
            echo "Complaint registered successfully!";
            
            // Update the 'status1' variable to "Complaint registered successfully" in the database
                        $updateStatusQuery = "UPDATE data SET status1 = 'Complaint registered successfully' WHERE id = ?";
            $updateStatusStmt = $mysqli->prepare($updateStatusQuery);

            if ($updateStatusStmt === false) {
                die("Error in preparing update statement: " . $mysqli->error);
            }

            $updateStatusStmt->bind_param("i", $id);

            if ($updateStatusStmt->execute()) {
                // Status updated successfully
            } else {
                echo "Error updating status: " . $updateStatusStmt->error;
            }

            // Close the update statement
            $updateStatusStmt->close();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the database connection
        $stmt->close();
        $mysqli->close();
    }
    ?>

    <script>
        // JavaScript function to redirect to dashboard.html
        function goToDashboard() {
            window.location.href = "dashboard.html"; // Update this to the correct dashboard URL
        }
    </script>
</body>
</html>