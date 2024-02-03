<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');

// Check if NumInscription is provided in the URL
if (isset($_GET['NumInscription'])) {
    $NumInscription = $_GET['NumInscription'];

    // Fetch data for the specified NumInscription
    try {
        $sql = "SELECT * FROM Eleve WHERE NumInscription = ? AND id_Inst = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $NumInscription);
        $stmt->bindParam(2, $_SESSION["user_id"]);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the record exists
        if (!$row) {
            echo "Record not found.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "NumInscription not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل البيانات</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Form to edit data -->
        <div class="card">
            <h3 class="mb-4 text-center">تعديل البيانات</h3>
            <form action="update_data.php" method="post">
                <div class="form-group">
                    <label for="NumInscription" class="float-right mt-3">رقم التسجيل:</label>
                    <input type="text" class="form-control" id="NumInscription" name="NumInscription" value="<?php echo $row["NumInscription"]; ?>" required readonly>
                    <input type="hidden" name="NumInscription" value="<?php echo $row["NumInscription"]; ?>">
                </div>

                <div class="form-group">
                    <label for="NomArabeEleve" class="float-right mt-3">الاسم العائلي باللغة العربية:</label>
                    <input type="text" class="form-control" id="NomArabeEleve" name="NomArabeEleve" value="<?php echo $row["NomArabeEleve"]; ?>" required>
                </div>

                <div class="form-group">
                    <label for="NomFrancaisEleve" class="float-right mt-3">الاسم العائلي باللغة الفرنسية:</label>
                    <input type="text" class="form-control" id="NomFrancaisEleve" name="NomFrancaisEleve" value="<?php echo $row["NomFrancaisEleve"]; ?>" required>
                </div>

                <div class="form-group">
                    <label for="PrenomArabeEleve" class="float-right mt-3">الاسم الشخصي باللغة العربية:</label>
                    <input type="text" class="form-control" id="PrenomArabeEleve" name="PrenomArabeEleve" value="<?php echo $row["PrenomArabeEleve"]; ?>" required>
                </div>

                <div class="form-group">
                    <label for="PrenomFrancaisEleve" class="float-right mt-3">الاسم الشخصي باللغة الفرنسية:</label>
                    <input type="text" class="form-control" id="PrenomFrancaisEleve" name="PrenomFrancaisEleve" value="<?php echo $row["PrenomFrancaisEleve"]; ?>" required>
                </div>
                

                <div class="form-group">
                    <label for="DateNaissance" class="float-right mt-3">تاريخ الازدياد:</label>
                    <input type="date" class="form-control" id="DateNaissance" name="DateNaissance" value="<?php echo $row["DateNaissance"]; ?>" required>
                </div>
                <div class="form-group">
                    <label for="LieuNaissance" class="float-right mt-3">مكان الازدياد:</label>
                    <input type="text" class="form-control" id="LieuNaissance" name="LieuNaissance" value="<?php echo $row["LieuNaissance"]; ?>" required> 
                </div>
                <div class="form-group">
                    <label for="AnneeScolaire" class="float-right mt-3">السنة الدراسية:</label>
                    <input type="text" class="form-control" id="AnneeScolaire" name="AnneeScolaire" value="<?php echo $row["AnneeScolaire"]; ?>" required>
                </div>
                <div class="form-group">
                    <label for="DateAbandonnement"class="float-right mt-3">تاريخ الانقطاع عن الدراسة:</label>
                    <input type="date" class="form-control" id="DateAbandonnement" name="DateAbandonnement" value="<?php echo $row["DateAbandonnement"]; ?>">
                </div>
                <div class="form-group">
                    <label for="NiveauScolaire" class="float-right mt-3">المستوى الدراسي:</label>
                    <input type="text" class="form-control" id="NiveauScolaire" name="NiveauScolaire" value="<?php echo $row["NiveauScolaire"]; ?>" required>
                <div class="form-group">
                    <label for="Remarque" class="float-right mt-3">ملاحظة:</label>
                    <input class="form-control" id="Remarque" name="Remarque" value="<?php echo $row["Remarque"]; ?>">
                </div>
                <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100">حفظ التغييرات</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

  

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>