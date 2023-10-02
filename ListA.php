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
    </style>
    <title>Complement Management System - List of Complaints</title>
</head>
<body>
    <div class="container">
        <h2>COMPLAINT MANAGEMENT SYSTEM<br>List of Complaints</h2>
        
        <!-- Add a search bar for ID number -->
        <input type="text" id="search-id" placeholder="Search by ID Number" onkeyup="searchComplaint()">
        
        <table id="complaint-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Date of Issue</th>
                <th>Issue</th>
                <th>Description</th>
                <th>Status1</th>
                <th>Status</th>
            </tr>
            <?php
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

            // Retrieve data from the database
            $query = "SELECT * FROM data";
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['date_of_issue'] . "</td>";
                    echo "<td>" . $row['issue'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['status1'] . "</td>";  // Print status1 first
                    echo "<td>" . $row['status'] . "</td>";   // Then print status
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No complaints found.</td></tr>";
            }

            // Close the database connection
            $mysqli->close();
            ?>
        </table>
        
        <button onclick="goToDashboard()">Back to Dashboard</button>
    </div>

    <script>
        // JavaScript function to redirect to dashboard.html
        function goToDashboard() {
            window.location.href = "dashboardnew.html";
        }

        // JavaScript function to search complaints by ID
        function searchComplaint() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search-id");
            filter = input.value.toUpperCase();
            table = document.getElementById("complaint-table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>