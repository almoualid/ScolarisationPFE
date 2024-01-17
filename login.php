<?php
include_once('conn.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codeGresa = $_POST["CodeGresa"];
    $password = $_POST["mdp"];

    // Validate and sanitize input if needed

    $query = "SELECT * FROM Institution WHERE CodeGresa = :codeGresa AND MotDePasse = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codeGresa', $codeGresa);
    $stmt->bindParam(':password', $password);

    try {
        $stmt->execute();
        $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_info) {
            $_SESSION["user_id"] = $user_info["CodeGresa"];
            $_SESSION["user_name"] = $user_info["NomArabeInst"];

            // Fetch commune information based on the retrieved user's institution ID
            $queryCommune = "SELECT * FROM Commune WHERE CodeCommune = :id_commune";
            $stmtCommune = $conn->prepare($queryCommune);
            $stmtCommune->bindParam(':id_commune', $user_info['id_commune']);
            $stmtCommune->execute();
            $commune_info = $stmtCommune->fetch(PDO::FETCH_ASSOC);

            if ($commune_info) {
                $_SESSION["commune"] = $commune_info["NomArabeCommune"];
            } else {
                // Log the error to a secure log file
                error_log("Error fetching commune information for user: " . $_SESSION["user_id"]);
                // Display a generic error message to the user
                echo "Error during login. Please try again.";
            }

            // Redirect to acceuil.php
            header("Location: acceuil.php");
            exit();
        } else {
            echo "Invalid Code Gresa or password.";
        }
    } catch(PDOException $e) {
        // Log the error to a secure log file
        error_log("Database error during login: " . $e->getMessage());
        // Display a generic error message to the user
        echo "Error during login. Please try again.";
    }
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
            width: 250px;
        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="./Men_2021-removebg.png" alt="Ministère de l'Éducation Nationale" class="img-fluid">
    </div>

    <div class="card text-right">
        <div class="card-body">
            <h2 class="card-title text-center"> تسجيل الدخول إلى صفحة بالمؤسسات </h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="codeGresa" class="col-form-label">اسم المستخدم:</label>
                    <input type="text" class="form-control" name="CodeGresa" >
                </div>
                <div class="form-group">
                    <label for="motDePasse" class="col-form-label">كلمة المرور:</label>
                    <input type="password" class="form-control" name="mdp">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Ajouter les scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>