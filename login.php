<?php
include_once('conn.php');

session_start();

$error_message = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codeGresa = $_POST["CodeGresa"];
    $password = $_POST["mdp"];

    // Check if input fields are empty
    if (empty($codeGresa) || empty($password)) {
        $error_message = "يرجى ملء جميع الحقول.";
    } else {
        // Validate and sanitize input if needed

        $query = "SELECT * FROM Institution WHERE CodeGresa = :codeGresa AND MotDePasse = :password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':codeGresa', $codeGresa);
        $stmt->bindParam(':password', $password);

        try {
            $stmt->execute();
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user_info) {
                // Your existing code for successful login...

                // Redirect to acceuil.php
                header("Location: acceuil.php");
                exit();
            } else {
                $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
            }
        } catch(PDOException $e) {
            $error_message = "خطأ أثناء تسجيل الدخول. الرجاء المحاولة مرة أخرى.";
            // Log the error to a secure log file
            error_log("Database error during login: " . $e->getMessage());
        }
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
                                    <input type="text" name="CodeGresa" class="form-control _ge_de_ol" placeholder=" اسم المستخدم:" >
                                </div>
                                <div class="form-group">
                                    <input type="password" name="mdp" class="form-control _ge_de_ol" placeholder="كلمة المرور:" >
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="_btn_04">تسجيل الدخول</button>
                                </div>
                                <?php if (!empty($error_message)) : ?>
                                    <div class="alert alert-danger text-center">
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
