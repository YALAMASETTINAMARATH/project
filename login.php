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
        h1 {
            font-size: 36px;
            color: #333; /* Change color to your preference */
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
        .register-button {
            background-color: #4CAF50; /* Green color for Register button */
        }
    </style>
    <title> STUDENT COMPLAINT MANAGEMENT SYSTEM</title>
</head>
<body>
    <div class="container">
        <h1> STUDENT COMPLAINT MANAGEMENT SYSTEM</h1>
        <h2 id="loginType">USER LOGIN</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="user">Username:</label>
                <input type="text" id="user" name="user" required>
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" id="pass" name="pass" required>
            </div>
            <button type="submit" name="user_login">Login</button>
            <button type="button" name="toggle_login" onclick="toggleLoginType(event)">Admin Login</button>
            <a href="registration.php" id="registrationLink"><button class="register-button" type="button">Register</button></a>
            <input type="hidden" name="login_type" value="user"> <!-- Hidden input for login type -->
        </form>
    </div>

    <?php
    // Database connection settings (update with your credentials)
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'complaint';

    // Create a database connection
    $con = mysqli_connect($host, $username, $password, $db_name);

    // Check if the connection is successful
    if (mysqli_connect_errno()) {
        die("Failed to connect with MySQL: " . mysqli_connect_error());
    }

    // Form submission handling (you can add your validation code here)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $loginType = isset($_POST["login_type"]) ? $_POST['login_type'] : 'user';

        if ($loginType === 'user') {
            // Handle regular user login
            $username = isset($_POST["user"]) ? $_POST['user'] : '';
            $password = isset($_POST["pass"]) ? $_POST['pass'] : '';

            // Query the "users" table for user login (fixed typo in table name)
            $sql = "SELECT * FROM uers WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($con, $sql);
            $count = mysqli_num_rows($result);

            if ($count == 1) {
                // Successful user login, you can redirect to user dashboard or perform user-specific actions
                echo "<h3>User Login Successful.</h3>";
                echo '<script>window.location.href = "dashboard.html";</script>'; // Redirect to dashboard.html
            } else {
                echo "<h3>User Login failed. Invalid username or password.</h3>";
            }
        } elseif ($loginType === 'admin') {
            // Handle admin login
            $adminUsername = isset($_POST["user"]) ? $_POST['user']:'';
            $adminPassword = isset($_POST["pass"]) ? $_POST['pass']:'';

            // Query the "authority" table for admin login
            $sql = "SELECT * FROM authority WHERE username = '$adminUsername' AND password = '$adminPassword'";
            $result = mysqli_query($con, $sql);
            $count = mysqli_num_rows($result);

            if ($count == 1) {
                // Successful admin login, you can redirect to admin dashboardnew.html
                echo "<h3>Admin Login Successful.</h3>";
                echo '<script>window.location.href = "dashboardnew.html";</script>'; // Redirect to dashboardnew.html
            } else {
                echo "<h3>Admin Login failed. Invalid username or password.</h3>";
            }
        }
    }

    mysqli_close($con);
    ?>

    <script>
        function toggleLoginType(event) {
            event.preventDefault();
            const loginTypeText = document.getElementById('loginType');
            const loginTypeInput = document.querySelector('input[name="login_type"]');
            const registrationLink = document.getElementById('registrationLink');
            const loginButton = document.querySelector('button[name="user_login"]');
            const toggleLoginButton = document.querySelector('button[name="toggle_login"]');

            if (loginTypeText.textContent === "USER LOGIN") {
                // Switch to Admin Login
                loginTypeText.textContent = "ADMIN LOGIN";
                loginTypeInput.value = "admin"; // Set login type to admin
                registrationLink.style.display = "none"; // Hide the registration link
                loginButton.textContent = "Login"; // Change the text of the "Login" button
                toggleLoginButton.textContent = "User Login"; // Change the text of the toggle button
            } else {
                // Switch to User Login
                loginTypeText.textContent = "USER LOGIN";
                loginTypeInput.value = "user"; // Set login type to user
                registrationLink.style.display = "block"; // Show the registration link
                loginButton.textContent = "Login"; // Change the text of the "Login" button
                toggleLoginButton.textContent = "Admin Login"; // Change the text of the toggle button
            }
        }
    </script>
</body>
</html>