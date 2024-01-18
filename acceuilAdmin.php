<?php
session_start();
include_once('conn.php');
 
// Check if the user is logged in
if (!isset($_SESSION["admin_login"]) || empty($_SESSION["admin_login"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}
 
// Fetch the list of all communes
$all_commune_query = "SELECT CodeCommune, NomArabeCommune FROM Commune";
$all_commune_result = $conn->query($all_commune_query);
?>
 
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=*, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <img class="header-log img-fluid" id="logo-men" src="./images/LogoMenAr.png" style="max-width: 100%;">
   
    <h3>مرحبا بكم , <?php echo $_SESSION["admin_nom"]; ?> <?php echo $_SESSION["admin_prenom"] ?></h3>
    <br>
 
    <form style="width: 30%;">
        <!-- Dropdown for All Communes -->
        <div class="form-group">
            <label for="allCommuneDropdown">اختر الجماعة (الكل):</label>
            <select class="form-control" id="allCommuneDropdown">
                <?php
                while ($row = $all_commune_result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row["CodeCommune"]}'>{$row["NomArabeCommune"]}</option>";
                }
                ?>
            </select>
        </div>
 
        <!-- Dropdown for Institutes -->
        <div class="form-group">
            <label for="instituteDropdown">اختر المؤسسة:</label>
            <select class="form-control" id="instituteDropdown"></select>
        </div>
 
        <!-- Your existing content -->
 
        <a href="logoutAdmin.php" class="btn btn-primary">تسجيل الخروج</a>
    </form>
 
    <script>
        // JavaScript to dynamically update the institute dropdown based on the selected commune
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
        });
    </script>
</body>
</html>