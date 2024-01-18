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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        img {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
        }

        select {
            width: 30%;
            margin-bottom: 10px;
        }

        form {
            margin-top: 20px;
        }

        button {
            margin-top: 10px;
        }

        .btn-logout {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="./LogoMenAr.png" alt="">
        <h3>مرحبا بكم , <?php echo $_SESSION["user_name"]; ?> <br> جماعة <?php echo $_SESSION["commune"]; ?></h3>

        <div style="display: flex;">
            <select class="form-select" aria-label="Disabled select example" disabled>
                <option selected><?php echo $_SESSION["user_name"]; ?></option>
            </select>
                     &nbsp; &nbsp;
            <select class="form-select" aria-label="Disabled select example" disabled>
                <option selected>جماعة <?php echo $_SESSION["commune"]; ?></option>
            </select>
        </div>

        <form action="process_form.php" method="post">
            <h4 class='text text-center'>  إضافة تلميذ(ة) جديد(ة) </h4> <br>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="NomArabeEleve" class="form-label">الاسم العائلي باللغة العربية</label>
                    <input type="text" class="form-control" id="NomArabeEleve" name="NomArabeEleve" required>
                </div>
                <div class="col-md-6">
                    <label for="NomFrancaisEleve" class="form-label">الاسم العائلي باللغة الفرنسية</label>
                    <input type="text" class="form-control" id="NomFrancaisEleve" name="NomFrancaisEleve" required>
                </div>

                
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                        <label for="PrenomArabeEleve" class="form-label">الاسم الشخصي باللغة العربية</label>
                        <input type="text" class="form-control" id="PrenomArabeEleve" name="PrenomArabeEleve" required>
                </div>
                <div class="col-md-6">
                        <label for="PrenomFrancaisEleve" class="form-label">الاسم الشخصي باللغة الفرنسية</label>
                        <input type="text" class="form-control" id="PrenomFrancaisEleve" name="PrenomFrancaisEleve"
                            required>
                </div>

            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="DateNaissance" class="form-label">تاريخ الازدياد</label>
                    <input type="date" class="form-control" id="DateNaissance" name="DateNaissance">
                </div>

                <div class="col-md-6">
                    <label for="LieuNaissance" class="form-label">مكان الازدياد</label>
                    <input type="text" class="form-control" id="LieuNaissance" name="LieuNaissance">
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="AnneeScolaire" class="form-label">السنة الدراسية</label>
                    <input type="text" class="form-control" id="AnneeScolaire" name="AnneeScolaire">
                </div>

                <div class="col-md-6">
                    <label for="DateAbandonnement" class="form-label">تاريخ الانقطاع عن الدراسة</label>
                    <input type="date" class="form-control" id="DateAbandonnement" name="DateAbandonnement">
                </div>
            </div>

            <div class="mb-3">
                <label for="Remarque" class="form-label">ملاحظة</label>
                <textarea class="form-control" id="Remarque" name="Remarque" rows="3"></textarea>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                <a href="#" class="btn btn-primary w-100 ">إرسال</a>
                </div>
                <div class="col-md-6">
                   <a href="logout.php" class="btn btn-danger w-100 ">تسجيل الخروج</a>
                </div>
                
                
                </div>


            
            
        </form>

       
   
</body>

</html>
