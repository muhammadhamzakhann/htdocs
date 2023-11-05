<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login_email = $_POST["login_email"];
    $login_password = $_POST["login_password"];

    // Fetch the stored hashed password from the database.
    $sql = "SELECT id, email, password FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $login_email);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $stored_password_hash = $row['password'];

        if (password_verify($login_password, $stored_password_hash)) {
            // Authentication successful. You can set up a user session and redirect to a dashboard page.
            session_start();
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.html");
        } else {
            echo "Login failed. Please check your credentials.";
        }
    } else {
        echo "User not found. Please check your email.";
    }
}
?>
