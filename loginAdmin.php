<?php
session_start();
 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here
 
    // Get user input
    $login = $_POST["login"];
    $mdp = $_POST["mdp"];
 
    // Validate login credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Archive_CS";
 
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM Admin WHERE Login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
   
    // Check if a user with the provided login exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
 
        // Verify the entered password against the stored password
        if ($mdp == $row["MotDePasse"]) {
            // Password is correct
            // Set session variables or perform other actions (e.g., redirect to the admin page)
           
            $_SESSION["admin_login"] = $row["Login"];
            $_SESSION["admin_nom"] = $row["Nom"];
            $_SESSION["admin_prenom"] = $row["Prenom"];
 
            // Redirect to the admin page
            header("Location: acceuilAdmin.php");
            exit();
        } else {
            // Incorrect password
            $error_message = "كلمة المرور غير صحيحة";
        }
    } else {
        // No user found with the provided login
        $error_message = "اسم المستخدم غير صحيح";
    }
 
    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>صفحة الإدارة</title>
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .card {
           
            width: 50%;
            margin: auto;
            margin-top: 2%;
        }
 
        .image-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
 
        .img-fluid {
            width: 395px;
            height: 90px;
 
        }
        ._btn_retour {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 10px 0;
        cursor: pointer;
      }
 
      ._btn_retour:hover {
        background-color: #2980b9;
      }
 
      ._btn_retour i {
        margin-left: 5px;
      }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="./images/LogoMenAr.png" alt="Ministère de l'Éducation Nationale" class="img-fluid">
    </div>
 
    <div class="card text-right">
        <div class="card-body">
            <h2 class="card-title text-center">تسجيل الدخول إلى صفحة المديرية</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="login" class="col-form-label">اسم المستخدم:</label>
                    <input type="text" class="form-control" name="login" >
                </div>
                <div class="form-group">
                    <label for="motDePasse" class="col-form-label">كلمة المرور:</label>
                    <input type="password" class="form-control" name="mdp">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول</button>
                    <a href="index.php" class="_btn_retour">رجوع <i>&rarr;</i></a>
                </div>
               
            </form>
        </div>
    </div>