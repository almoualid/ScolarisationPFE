<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');

// Initialize variables
$successMessage = "";
$errorMessage = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validate and sanitize the data as needed

    // Check if new password and confirm password match
    if ($newPassword == $confirmPassword) {
        try {
            // Check if the current password matches the one in the database
            $checkPasswordSql = "SELECT * FROM Admin WHERE Login = ?";
            $checkPasswordStmt = $conn->prepare($checkPasswordSql);
            $checkPasswordStmt->bindParam(1, $_SESSION["admin_login"]);
            $checkPasswordStmt->execute();
            $admin = $checkPasswordStmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && $currentPassword == $admin['MotDePasse']) {
                // Update password in the database without hashing
                $updatePasswordSql = "UPDATE Admin SET MotDePasse = ? WHERE Login = ?";
                $updatePasswordStmt = $conn->prepare($updatePasswordSql);

                $updatePasswordStmt->bindParam(1, $newPassword);
                $updatePasswordStmt->bindParam(2, $_SESSION["admin_login"]);
                $updatePasswordStmt->execute();

                // Set the success message
                $successMessage = "تم تغيير كلمة المرور بنجاح";

                // Redirect to the success page
                header("Location: motDePasseChanged.php");
                exit();
            } else {
                $errorMessage = "كلمة المرور الحالية غير صحيحة";
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $errorMessage = "حدث خطأ أثناء تحديث كلمة المرور. يرجى المحاولة مرة أخرى.";
        }
    } else {
        $errorMessage = "كلمة المرور الجديدة وتأكيد كلمة المرور غير متطابقين";
    }
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تغيير كلمة المرور</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 400px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
        }

        .col-md-12  {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h3>تغيير كلمة المرور</h3>

            <?php if (!empty($errorMessage)) : ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($successMessage)) : ?>
                <div class="alert alert-success text-center" role="alert">
                    <?php echo $successMessage; ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="currentPassword" class="col-md-12 col-form-label text-md-right">كلمة المرور الحالية</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                </div>

                <div class="mb-3">
                    <label for="newPassword" class="col-md-12 col-form-label text-md-right">كلمة المرور الجديدة</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="col-md-12 col-form-label text-md-right">تأكيد كلمة المرور</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary w-100">تغيير كلمة المرور</button>
                </div>
                <div class="login-link">
                    <a href="javascript:history.back()">العودة إلى الصفحة السابقة</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

