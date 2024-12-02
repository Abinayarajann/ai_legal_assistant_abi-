<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ai_legal_assistant";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // $action = isset($_GET['action']) ? $_GET['action'] : '';
    // $user = isset($_GET['username']) ? $_GET['username'] : '';
    // $pass = isset($_GET['password']) ? $_GET['password'] : '';

    $action = $_GET['action'];
    $user = $_GET['username'];
    $pass = $_GET['password'];
    // echo $action;
    if ($action == "register") {
        // Handle registration with hashed password
        //$hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $pass);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: index.html"); // Redirect to index.html

        } else {
            echo "Error: " . $stmt->error; // Handle registration error
        }
        $stmt->close();
    }
    if ($action == "login") {
        echo "hiii";
        // Handle login
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        // Verify the password and check if the user exists
        // if (password_verify($pass, $row['password'])) {
        if ($pass == $row['password']) {
            // echo "hiii";
            $_SESSION['username'] = $user; // Store username in session
            header("Location: index.html"); // Redirect to index.html
            exit(); // Stop script execution after redirect
        } else {
            echo "Invalid username or password."; // Handle login failure
        }
        $stmt->close();
    }
}else{
    echo "kkk";
}

$conn->close(); // Close the database connection
?>
