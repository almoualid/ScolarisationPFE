<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
       <h1><?php echo $_SESSION["user_name"]; ?></h1>
       <h1><?php echo $_SESSION["commune"]; ?></h1>
    
    

    <a href="logout.php">Logout</a>
</body>
</html>
