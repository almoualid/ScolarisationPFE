<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["admin_login"]) || empty($_SESSION["admin_login"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file or handle it as per your setup
include('conn.php');
// Fetch the list of all communes
$all_commune_query = "SELECT CodeCommune, NomArabeCommune FROM Commune";
$all_commune_result = $conn->query($all_commune_query);

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
    $selectedInstitute = $_POST['selectedInstitute'];
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
        $stmt->bindParam(12, $selectedInstitute); 

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
        img{
            width: 300px;
            height: auto;
            margin-bottom: 20px;
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
        .header-log{
            margin-right: 409px;
        }
    
    </style>
</head>

<body>
    <div class="container">
    <img class="header-log " id="logo-men" src="./images/LogoMenAr.png" style="max-width: 100%;">
        
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
           
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h4 class='text text-center'>  إضافة تلميذ(ة) جديد(ة)   </h4> <br>

            

        <div class="float-start mt-3">
            <button class="btn btn-primary"><a href="acceuilAdmin.php" class="text-white">رجوع <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5"/>
                   </svg></a></button>
        </div>
        <div style="display: flex;">
            <div class="form-group">
            <label for="allCommuneDropdown">اختر الجماعة (الكل):</label>
            <select class="form-select" id="allCommuneDropdown">
                <?php
                while ($row = $all_commune_result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row["CodeCommune"]}'>{$row["NomArabeCommune"]}</option>";
                }
                ?>
            </select>
            </div>
            &nbsp; &nbsp;
            <!-- Dropdown for Institutes -->
            <div class="form-group">
                <label for="instituteDropdown">اختر المؤسسة:</label>
                <select class="form-select" id="instituteDropdown" name="selectedInstitute"></select>
            </div>
        </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                <label for="NumInscription" class="form-label">رقم التسجيل </label>
                    <input type="text" class="form-control" id="NumInscription" name="NumInscription" required>
                </div>
                <div class="col-md-6">
                    <label for=" NiveauScolaire" class="form-label">المستوى الدراسي</label>
                    <input type="text" class="form-control" id=" NiveauScolaire" name=" NiveauScolaire" required>
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

            <div class="mb-3">
                <label for="Remarque" class="form-label">ملاحظة</label>
                <textarea class="form-control" id="Remarque" name="Remarque" rows="3"></textarea>
            </div>

            
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary w-100">إرسال</button>
                </div>
                
            
        </form>
        
        <script>
    // JavaScript to dynamically update the institute dropdown and table based on the selected commune
    document.getElementById('allCommuneDropdown').addEventListener('change', function () {
        var selectedCommune = this.value;
        var instituteDropdown = document.getElementById('instituteDropdown');

        // Clear existing options
        instituteDropdown.innerHTML = '';

        // Fetch and populate the institute dropdown based on the selected commune (adjust the query accordingly)
        var instituteOptions = {
            <?php
            $institute_query = "SELECT CodeGresa, NomArabeInst FROM Institution WHERE id_commune = :selected_commune_id";
            $institute_stmt = $conn->prepare($institute_query);

            $all_commune_result->execute();
            while ($row = $all_commune_result->fetch(PDO::FETCH_ASSOC)) {
                $selected_commune_id = $row['CodeCommune'];
                $institute_stmt->bindParam(':selected_commune_id', $selected_commune_id);
                $institute_stmt->execute();
                $institute_result = $institute_stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "'{$selected_commune_id}': " . json_encode($institute_result) . ",";
            }

            $institute_stmt->closeCursor();
            ?>
        };

        var selectedInstitute = instituteOptions[selectedCommune];

        // Populate the institute dropdown
        for (var i = 0; i < selectedInstitute.length; i++) {
            var option = document.createElement('option');
            option.value = selectedInstitute[i].CodeGresa;
            option.text = selectedInstitute[i].NomArabeInst;
            instituteDropdown.add(option);
        }

        // Trigger the change event for the institute dropdown
        var event = new Event('change');
        instituteDropdown.dispatchEvent(event);
    });

    document.getElementById('instituteDropdown').addEventListener('change', function () {
        var selectedInstitute = this.value;

        // Log the selected institute to the console for testing
        console.log('Selected Institute:', selectedInstitute);
    });
</script>
     

    
</body>

</html>