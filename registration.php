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
        label, input {
            display: block;
            margin-bottom: 15px;
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
        .form-group input {
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
        .back-to-login-button {
            background-color: #FF5733; /* Red color for Back to Login button */
        }
    </style>
    <title>Complaint Management System Registration Form</title>
</head>
<body>
    <div class="container">
        <h2>COMPLAINT MANAGEMENT SYSTEM<br>REGISTRATION FORM</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phno">Phone Number:</label>
                <input type="text" id="phno" name="phno" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
            <a href="login.php"><button class="back-to-login-button" type="button">Back to Login</button></a>
        </form>
    </div>

    <?php
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

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user input from the form
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phno = $_POST['phno'];
        $username = $_POST['username'];
        $password = ($_POST['password']); // Hash the password for security

        // Prepare and execute an SQL query to insert the user into the database
        $query = "INSERT INTO uers (first_name, last_name, address, email, phone_number, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);

        if ($stmt === false) {
            die("Error in preparing statement: " . $mysqli->error);
        }

        $stmt->bind_param("sssssss", $firstName, $lastName, $address, $email, $phno, $username, $password);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the database connection
        $stmt->close();
    }
    $mysqli->close();
    ?>
</body>
</html>