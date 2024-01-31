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
</head>

<body>
    <div class="container mt-4">
        <!-- Form to edit data -->
        <h3 class="mb-4 text-center">تعديل البيانات</h3>
        <form action="update_data.php" method="post">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="NumInscription" class="col-md-3 col-form-label text-md-right">رقم التسجيل:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="NumInscription" name="NumInscription" value="<?php echo $row["NumInscription"]; ?>" required readonly>
                        </div>
                        <input type="hidden" name="NumInscription" value="<?php echo $row["NumInscription"]; ?>">
                    </div>
                    <div class="form-group row">
                        <label for="NiveauScolaire" class="col-md-3 col-form-label text-md-right">المستوى الدراسي</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="NiveauScolaire" name="NiveauScolaire" value="<?php echo $row["NiveauScolaire"]; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="NomArabeEleve" class="col-md-3 col-form-label text-md-right">الاسم العائلي باللغة العربية:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="NomArabeEleve" name="NomArabeEleve" value="<?php echo $row["NomArabeEleve"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="NomFrancaisEleve" class="col-md-3 col-form-label text-md-right">الاسم العائلي باللغة الفرنسية:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="NomFrancaisEleve" name="NomFrancaisEleve" value="<?php echo $row["NomFrancaisEleve"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="PrenomArabeEleve" class="col-md-3 col-form-label text-md-right">الاسم الشخصي باللغة العربية:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="PrenomArabeEleve" name="PrenomArabeEleve" value="<?php echo $row["PrenomArabeEleve"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="PrenomFrancaisEleve" class="col-md-3 col-form-label text-md-right">الاسم الشخصي باللغة الفرنسية:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="PrenomFrancaisEleve" name="PrenomFrancaisEleve" value="<?php echo $row["PrenomFrancaisEleve"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="DateNaissance" class="col-md-3 col-form-label text-md-right">تاريخ الازدياد:</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" id="DateNaissance" name="DateNaissance" value="<?php echo $row["DateNaissance"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="LieuNaissance" class="col-md-3 col-form-label text-md-right">مكان الازدياد:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="LieuNaissance" name="LieuNaissance" value="<?php echo $row["LieuNaissance"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="AnneeScolaire" class="col-md-3 col-form-label text-md-right">السنة الدراسية:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="AnneeScolaire" name="AnneeScolaire" value="<?php echo $row["AnneeScolaire"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="DateAbandonnement" class="col-md-3 col-form-label text-md-right">تاريخ الانقطاع عن الدراسة:</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" id="DateAbandonnement" name="DateAbandonnement" value="<?php echo $row["DateAbandonnement"]; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Remarque" class="col-md-3 col-form-label text-md-right">ملاحظة:</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="Remarque" name="Remarque"><?php echo $row["Remarque"]; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
