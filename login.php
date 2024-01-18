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
<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <title>صفحة الإدارة</title>
  </head>
  <body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <section class="form-02-main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="_lk_de">
              <div class="form-03-main">
                <h2 class="card-title text-center"> تسجيل الدخول إلى صفحة بالمؤسسات </h2>
                <div class="logo">
                  <img src="assets/images/user.png">
                </div>
                <div class="form-group">
                  <input type="text" name="CodeGresa" class="form-control _ge_de_ol" type="text" placeholder=" اسم المستخدم:" required="" aria-required="true">
                </div>

                <div class="form-group">
                  <input type="password" name="mdp" class="form-control _ge_de_ol" type="text" placeholder="كلمة المرور:" required="" aria-required="true">
                </div>



                <div class="form-group">
                  <button type="submit" class="_btn_04">تسجيل الدخول</button>
                </div>
                <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger">
                <?php echo $error_message; ?>
                </div>
               <?php endif; ?>


                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </form>
  </body>
</html>