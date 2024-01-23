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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Znp0nRUUru8jT9hj1ZZJo2q8WcA0SzE9APWbHoGwZ7D5qUgTbY7w+V5et3+dzojY7o8K3oi/Op7MR1iQ6zDbkA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
         
        body {
            background-color: #f8f9fa;
            margin: 20px;
        }

        
        a {
            text-decoration: none; 
            color: white; 
        }
        img{
            width: 300px;
            height: auto;
            margin-bottom: 20px;
            margin-right: 500px;
        }
        #view-data{
            text-decoration: none; 
            color: white; 

        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
        }
        able {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Add styles for the actions icons */
    .action-icons {
        display: flex;
        justify-content: space-around;
    }

    .action-icons a {
        text-decoration: none;
        color: #007bff;
        margin: 0 5px;
    }

    </style>
    </style>
</head>
<body>
    <img class="header-log img-fluid" id="logo-men" src="./images/LogoMenAr.png" style="max-width: 100%;">
   
    <h3>مرحبا بكم , <?php echo $_SESSION["admin_nom"]; ?> <?php echo $_SESSION["admin_prenom"] ?></h3>
    <br>
 
    <form style="display:flex;">
        <!-- Dropdown for All Communes -->
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
            <select class="form-select" id="instituteDropdown"></select>
        </div>
 
        <!-- Your existing content -->
 
        
        
    </form>
    
    <div class="float-start mt-3">
            <button class="btn btn-danger" style="margin-top: -100px;"><a href="logoutAdmin.php" class="text-white">تسجيل الخروج</a></button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">رقم التسجيل</th>
                <th scope="col">الاسم العائلي باللغة العربية</th>
                <th scope="col">الاسم العائلي باللغة الفرنسية</th>
                <th scope="col">الاسم الشخصي باللغة العربية</th>
                <th scope="col">الاسم الشخصي باللغة الفرنسية</th>
                <th scope="col">تاريخ الازدياد</th>
                <th scope="col">مكان الازدياد</th>
                <th scope="col">السنة الدراسية</th>
                <th scope="col">تاريخ الانقطاع عن الدراسة</th>
                <th scope="col">ملاحظة</th>
                <th scope="col">إجراءات</th>
            </tr>
        </thead>
        <tbody id="studentsTableBody"></tbody>
    </table>

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
            updateStudentsTable(selectedInstitute);
        });

        function updateStudentsTable(selectedInstitute) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            console.log('Response:', this.responseText); // Log the response
            console.log('Status:', this.status); // Log the status

            if (this.status == 200) {
                try {
                    var studentsData = JSON.parse(this.responseText);
                    displayStudentsTable(studentsData);
                } catch (error) {
                    console.error('JSON parsing error:', error);
                }
            } else {
                console.error('Error:', this.status);
            }
        }
    };

    xhttp.open("GET", "fetch_students.php?institute=" + selectedInstitute, true);
    xhttp.send();
}


        function displayStudentsTable(studentsData) {
            var studentsTableBody = document.getElementById('studentsTableBody');
            studentsTableBody.innerHTML = '';
            
            for (var i = 0; i < studentsData.length; i++) {
                var row = document.createElement('tr');
                row.innerHTML = '<td>' + studentsData[i].NumInscription+ '</td>' +
                                 '<td>' + studentsData[i].NomArabeEleve+ '</td>' +
                                 '<td>' + studentsData[i].PrenomFrancaisEleve+ '</td>' +
                                 '<td>' + studentsData[i].PrenomArabeEleve+ '</td>' +
                                 '<td>' + studentsData[i].NomFrancaisEleve+ '</td>' +
                                 '<td>' + studentsData[i].DateNaissance + '</td>' +
                                 '<td>' + studentsData[i].LieuNaissance+ '</td>' +
                                 '<td>' + studentsData[i].AnneeScolaire+ '</td>' +
                                 '<td>' + studentsData[i].DateAbandonnement+ '</td>' +
                                 '<td>' + studentsData[i].Remarque+ '</td>' +
                                 '<td class="action-icons">' +
                                   '<a href="#" title="تعديل"><i class="fas fa-edit"></i></a>' +
                                   '<a href="#" title="حذف"><i class="fas fa-trash"></i></a>' +
                                   '<a href="#" title="عرض"><i class="fas fa-eye"></i></a>' +
                                   '</td>';  
                studentsTableBody.appendChild(row);
            }
        }
    </script>
</body>
</html>
