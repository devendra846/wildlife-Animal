<?php
session_start();  // Start the session

// Database configuration
$servername = "localhost";
$username = "root";           // Replace with your database username
$password = "";               // Replace with your database password
$dbname = "register";          // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Prepare SQL query to check if the user exists
    $sql = "SELECT password FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch stored password from the database
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        // Compare the entered password with the stored password (without hashing)
        if ($password === $stored_password) {
            // Set session variables after successful login
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;

            // Redirect to home page (index.html)
            echo "<script>alert('Logged in successfully!'); window.location.href='index.html';</script>";
            exit();  // Stop further script execution
        } else {
            // Incorrect password
            echo "<script>alert('Incorrect password!'); window.location.href='login.html';</script>";
        }
    } else {
        // Email not found
        echo "<script>alert('Email not found!'); window.location.href='login.html';</script>";
    }
}

// Close the connection
$conn->close();
?>
