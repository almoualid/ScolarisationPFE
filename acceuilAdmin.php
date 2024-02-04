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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
 
 
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
        table {
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
   
    <h3> مرحبا بكم , المديرية الإقليمية ورزازات</h3>
    <br>
 
    <div class="float-start mt-3">
            <button class="btn btn-danger" style="margin-top: -75px; "><a href="logoutAdmin.php" class="text-white">تسجيل الخروج</a></button>
    </div>
    <div class="float-start mt-3 mt-right">
            <button class='btn btn-primary'  style="margin-top: -75px;margin-left:10px; "><a href="ChangeMotDePasse.php">تغيير كلمة المرور</a></button>
        </div>
   &nbsp;
    <div class="float-left mt-3">
            <button class="btn btn-primary" style="margin-top: -100px; margin-right:10px"><a href="addEleveAdmin.php" class="text-white">إضافة تلميذ(ة) <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                   <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
            </svg></a></button>
    </div>
    <form style="display:flex;">
        <!-- Dropdown for All Communes -->
        <div class="form-group">
            <label for="allCommuneDropdown">اختر الجماعة (الكل):</label>
            <select class="form-select" id="allCommuneDropdown">
                <option valu="choisi">اختر الجماعة</opotion>
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
   
   
    <table class="table">
        <thead>
            <tr>
                <th scope="col">رقم التسجيل</th>
                <th scope="col">الاسم العائلي باللغة العربية</th>
                <th scope="col">الاسم العائلي باللغة الفرنسية</th>
                <th scope="col">الاسم الشخصي باللغة العربية</th>
                <th scope="col">الاسم الشخصي باللغة الفرنسية</th>
                <th scope="col">المستوى الدراسي</th>
                <th scope="col">تاريخ الازدياد</th>
                <th scope="col">مكان الازدياد</th>
                <th scope="col">السنة الدراسية</th>
                <th scope="col">تاريخ الانقطاع عن الدراسة</th>
                <th scope="col">ملاحظة</th>
                <th scope="col">إجراءات </th>
            </tr>
        </thead>
        <tbody id="studentsTableBody"></tbody>
    </table>
    
<div class="position-absolute bottom-0 end-0">
    <button class="btn btn-success" id="exportToExcel" style="margin-top: -100px; margin-right:10px">تصدير إلى Excel <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet-fill" viewBox="0 0 16 16">
  <path d="M6 12v-2h3v2z"/>
  <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3z"/>
</svg></button>
</div>
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
                                 '<td>' + studentsData[i].NiveauScolaire+ '</td>' +
                                 '<td>' + studentsData[i].DateNaissance + '</td>' +
                                 '<td>' + studentsData[i].LieuNaissance+ '</td>' +
                                 '<td>' + studentsData[i].AnneeScolaire+ '</td>' +
                                 '<td>' + studentsData[i].DateAbandonnement+ '</td>' +
                                 '<td>' + studentsData[i].Remarque+ '</td>' +
                                 '<td class="action-icons">' +
                                  '<a href="EditDataAdmin.php?NumInscription=' + studentsData[i].NumInscription + '" title="تعديل"><i class="fas fa-edit"></i></a>' +
 
                                   '<a href="viewCertificatAdmin.php?NumInscription=' + studentsData[i].NumInscription + '" title="عرض"><i class="fas fa-eye"></i></a>' +
                                   '</td>';  
                studentsTableBody.appendChild(row);
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script>

document.getElementById('exportToExcel').addEventListener('click', function () {
    exportToExcel();
});


function exportToExcel() {
    var studentsTable = document.getElementById('studentsTableBody');
    var studentsData = [];

 
    for (var i = 0; i < studentsTable.rows.length; i++) {
        var rowData = [];
        for (var j = 0; j < studentsTable.rows[i].cells.length - 1; j++) { // Exclude the last cell with action icons
            rowData.push(studentsTable.rows[i].cells[j].innerText);
        }
        studentsData.push(rowData);
    }

    var ws = XLSX.utils.aoa_to_sheet([['رقم التسجيل', 'الاسم العائلي باللغة العربية', 'الاسم العائلي باللغة الفرنسية', 'الاسم الشخصي باللغة العربية', 'الاسم الشخصي باللغة الفرنسية', 'المستوى الدراسي', 'تاريخ الازدياد', 'مكان الازدياد', 'السنة الدراسية', 'تاريخ الانقطاع عن الدراسة', 'ملاحظة']]);
    XLSX.utils.sheet_add_json(ws, studentsData, { origin: "A2" });

    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

    XLSX.writeFile(wb, 'students_data.xlsx');
}
    </script>

</body>
</html>