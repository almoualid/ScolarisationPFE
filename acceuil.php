<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file or handle it as per your setup
include('conn.php');

// Initialize a variable to track success
$successMessage = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $numInscription = $_POST["NumInscription"];
    $NiveauScolaire = $_POST["NiveauScolaire"];
    $nomArabeEleve = $_POST["NomArabeEleve"];
    $nomFrancaisEleve = $_POST["NomFrancaisEleve"];
    $prenomArabeEleve = $_POST["PrenomArabeEleve"];
    $prenomFrancaisEleve = $_POST["PrenomFrancaisEleve"];
    $dateNaissance = $_POST["DateNaissance"];
    $lieuNaissance = $_POST["LieuNaissance"];
    $anneeScolaire = $_POST["AnneeScolaire"];
    $dateAbandonnement = $_POST["DateAbandonnement"];
    $remarque = $_POST["Remarque"];
    // Add more fields as needed

    // Validate and sanitize the data as needed

    try {
        // Insert data into Eleve table
        $sql = "INSERT INTO Eleve (NumInscription,NiveauScolaire,NomArabeEleve, PrenomFrancaisEleve, PrenomArabeEleve, NomFrancaisEleve, DateNaissance, LieuNaissance, AnneeScolaire, DateAbandonnement, Remarque, id_Inst)
                VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(1, $numInscription);
        $stmt->bindParam(2, $NiveauScolaire);
        $stmt->bindParam(3, $nomArabeEleve);
        $stmt->bindParam(4, $prenomFrancaisEleve);
        $stmt->bindParam(5, $prenomArabeEleve);
        $stmt->bindParam(6, $nomFrancaisEleve);
        $stmt->bindParam(7, $dateNaissance);
        $stmt->bindParam(8, $lieuNaissance);
        $stmt->bindParam(9, $anneeScolaire);
        $stmt->bindParam(10, $dateAbandonnement);
        $stmt->bindParam(11, $remarque);
        $stmt->bindParam(12, $_SESSION["user_id"]); 

        // Execute the statement
        $stmt->execute();

        // Set the success message
        $successMessage = "تم التسجيل بنجاح";
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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
        a {
            text-decoration: none; 
            color: white; 
        }
        #view-data{
            text-decoration: none; 
            color: white; 

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
        .custom-success-alert {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
    
    </style>
</head>

<body>
    <div class="container">
        <div class="position-absolute top-0 start-50 translate-middle-x">
        <img src="./images/LogoMenAr.png" alt="">
    </div><br><br> <br>
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
        <?php if (!empty($successMessage)) : ?>
        <div id="success-alert" class="alert alert-success custom-success-alert text-center" role="alert">
            <?php echo $successMessage; ?>
        </div>

        <script>
            setTimeout(function () {
                document.getElementById('success-alert').style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>
    <div class="float-LEFT mt-3">
            <button class="btn btn-primary w-10"><a href="change_password.php">تغيير كلمة المرور</a></button>
        </div>
        <div class="float-start mt-3">
            <button class="btn btn-danger" style="margin-top:-108px;"><a href="logout.php" class="text-white">تسجيل الخروج</a></button>
        </div>
        
    
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h4 class='text text-center'>  إضافة تلميذ(ة) جديد(ة) </h4> <br>
            <div class="">
                <div class="mb-3">
                 <label for="NumInscription" class="form-label">رقم التسجيل </label>
                    <input type="text" class="form-control" id="NumInscription" name="NumInscription" required>
                </div>
                
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

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for=" NiveauScolaire" class="form-label">المستوى الدراسي</label>
                    <input type="text" class="form-control" id=" NiveauScolaire" name=" NiveauScolaire" required>
                </div>
                <div  class="col-md-6">
                    <label for="Remarque" class="form-label">ملاحظة</label>
                    <input class="form-control" id="Remarque" name="Remarque" rows="3"></input>
                </div>
                
            
        </div>

            
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary w-100">إرسال</button>
                </div>
                <div class="col-md-12 mt-3">
                    <a href="view_data.php" class="btn btn-info w-100" id='view-data'>عرض البيانات</a>
                </div>
            
        </form>
     

    
</body>

</html>