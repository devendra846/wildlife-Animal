<?php
// Database configuration
$servername = "localhost";  // Replace with your database server name
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "register";        // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $conn->real_escape_string($_POST['password']);

    // Hash the password for security (recommended)
    // $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Prepare SQL query to insert data into the users table
    $sql = "INSERT INTO users (username, email, phone, password) 
            VALUES ('$username', '$email', '$phone', '$password')";

    // Execute the query and check if successful
    if ($conn->query($sql) === TRUE) {
        // Use JavaScript to display a pop-up message and then redirect
        echo "<script>
                alert('Sign-up successful!');
                window.location.href = 'login.html';
              </script>";
        exit();  // Ensure script execution stops after the redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
