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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <img src="./LogoMenAr.png" alt="" srcset="">
    
    <h3>مرحبا بكم , <?php echo $_SESSION["user_name"]; ?> <br> 
    جماعة <?php echo $_SESSION["commune"]; ?>
    </h3> 
    
    <div style="display: flex;">
    <select class="form-select" aria-label="Disabled select example" style="width: 30%;" disabled>
       <option selected> <?php echo $_SESSION["user_name"]; ?></option>
    </select>
     &nbsp; &nbsp;
    <select class="form-select" aria-label="Disabled select example" style="width: 30%;" disabled>
       <option selected>جماعة  <?php echo $_SESSION["commune"]; ?></option>
    </select>
    </div>
    <br>

    <a href="logout.php">Logout</a>
</body>
</html>
