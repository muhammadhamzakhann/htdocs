<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>CSV to SQL Converter</title>
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .container {
            text-align: center;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CSV to SQL Converter</h1>
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
            <button type="button" id="uploadButton">Upload File</button>
        </form>
        <textarea id="sqlOutput" rows="10" cols="50" readonly></textarea>
    </div>
    <div>
        <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </p>
    </div>
    <script src="convert.js"></script>
</body>
</html>