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
          $error_message = "فشل التسجيل. يرجى التحقق من معلومات الدخول الخاصة بك";
        }
    } catch(PDOException $e) {
        // Log the error to a secure log file
        error_log("Database error during login: " . $e->getMessage());
        // Display a generic error message to the user
        $error_message = "Error during login. Please try again.";
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
    <style>
      ._btn_retour {
        background-color: #3652AD; 
        color: white; 
        padding: 10px 20px; 
        border: none; 
        border-radius: 60px; 
        text-align: center; 
        text-decoration: none; 
        display: inline-block; 
        font-size: 16px; 
        margin: 10px 0; 
        cursor: pointer; 
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      }

      ._btn_retour:hover {
        background-color: #2980b9; 
      }

      ._btn_retour i {
        margin-left: 5px;
      }
      .alert { 
        margin-top: 20px;
        padding: 15px;
        background-color: #f8d7da; 
        border: 1px solid #f5c6cb; 
        color: #721c24;
        border-radius: 5px; 
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
      }
    </style>
  </head>
  <body>
    
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  
    <section class="form-02-main">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="_lk_de">
              <div class="form-03-main">
                <h2 class="card-title text-center"> تسجيل الدخول إلى صفحة المؤسسات </h2>
                <div class="logo">
                  <img src="assets/images/user.png">
                </div>
                <div class="form-group">
                  <input type="text" name="CodeGresa" class="form-control _ge_de_ol" type="text" placeholder=" اسم المستخدم:" required="" oninvalid="this.setCustomValidity('المرجو ملء هذه الخانة')" oninput="this.setCustomValidity('')" aria-required="true">
                </div>

                <div class="form-group">
                  <input type="password" name="mdp" class="form-control _ge_de_ol" type="text" placeholder="كلمة المرور:" required="" oninvalid="this.setCustomValidity('المرجو ملء هذه الخانة')" oninput="this.setCustomValidity('')" aria-required="true">
                </div>



                <div class="form-group">
                  <button type="submit" class="_btn_04">تسجيل الدخول</button>
                  <?php if (!empty($error_message)) : ?>
                      <div class="alert ">
                       <?php echo $error_message; ?>
                     </div>
                  <?php endif; ?>
                        <a href="index.php" class="_btn_retour">رجوع <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5"/>
                   </svg></a>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </form>
  </body>
</html>