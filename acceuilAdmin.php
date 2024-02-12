<?php
session_start();
include_once('conn.php');
 
// Check if the user is logged in
if (!isset($_SESSION["admin_login"]) || empty($_SESSION["admin_login"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}
$sql = "SELECT * FROM Eleve";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            margin-left: 60px;
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
    .btn{
        color:white;
    }
    .pass{
        color:white;
        height:40px;
        background-color:#ffd11a;
        border-radius:10px;
        border-color:#ffd11a;
        margin-top:23px;
    }
    .pass:hover{
        color:black;
    }
 
    </style>
    </style>
</head>
<body>
    <img class="header-log img-fluid" id="logo-men" src="./images/LogoMenAr.png" style="max-width: 100%;">
   
    <h3> مرحبا بكم , المديرية الإقليمية ورزازات</h3>
    <br>
 
    <div class="float-start mt-3">
            <button class="btn btn-warning" id="resetAllPasswordsButton" style="margin-top: -75px; " >إعادة ضبط الجميع كلمة المرور<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
  <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
</svg></button>
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
        <div class="form-group">
    <label for="instituteDropdown">اختر المؤسسة:</label>
    <select class="form-select" id="instituteDropdown">
    </select>
</div>

<div class="float-start mt-3 mt-right">
            <button class='btn btn-primary' id="filter" style="margin-top: 7px;margin-left:2px; margin-right:10px;" onclick="filterStudents()">Filter</button>
        </div>
&nbsp; &nbsp; &nbsp; 
<button  id="resetPasswordButton" class="pass">إعادة تعيين كلمة مرور هذه المؤسسة<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
  <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
</svg></button>
<div class="float-start mt-3 mt-right">
    <button class="btn btn-success" id="exportToExcel2" style="margin-top: 9px; margin-right:30px">
        <a href="exportExcelAll.php" style="color: inherit; text-decoration: none;">تصدير إلى Excel</a>
    </button>
</div>
 
       
       
    </form>
   
   
    <table class="table1" style="display: none;">
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
                <th scope="col">رقم التسجيل</th>
                <th scope="col">ملاحظة</th>
                <th scope="col">إجراءات </th>
            </tr>
        </thead>
        <tbody id="studentsTableBody"></tbody>

    </table>
    <table class="table2">
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
                <th scope="col">رقم التسجيل</th>
                <th scope="col">إجراءات </th>
            </tr>
        </thead>
        <tbody id="studentsTable">
            <?php foreach ($students as $student) : ?>
                <tr>
                    <td><?php echo $student['NumInscription']; ?></td>
                    <td><?php echo $student['NomArabeEleve']; ?></td>
                    <td><?php echo $student['NomFrancaisEleve']; ?></td>
                    <td><?php echo $student['PrenomArabeEleve']; ?></td>
                    <td><?php echo $student['PrenomFrancaisEleve']; ?></td>
                    <td><?php echo $student['NiveauScolaire']; ?></td>
                    <td><?php echo $student['DateNaissance']; ?></td>
                    <td><?php echo $student['LieuNaissance']; ?></td>
                    <td><?php echo $student['AnneeScolaire']; ?></td>
                    <td><?php echo $student['DateAbandonnement']; ?></td>
                    <td><?php echo $student['Remarque']; ?></td>
                    <td><?php echo $student['id_Inst']; ?></td>

                    <td class="action-icons">
                        <a href="EditDataAdmin.php?NumInscription=<?php echo $student['NumInscription']; ?>" title="تعديل"><i class="fas fa-edit"></i></a>
                        <a href="viewCertificatAdmin.php?NumInscription=<?php echo $student['NumInscription']; ?>" title="عرض"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
<div class="float-start mt-3 mt-right">
<button class="btn btn-success" id="exportToExcel" >
        <a href="exportExcelAdmin.php?id_Inst=<?php echo $student['id_Inst']; ?>" style="color: inherit; text-decoration: none;">تصدير إلى Excel</a>
    </button>
</div>
<script>
       var selectedCommune; // Déclarer la variable au niveau global

document.getElementById('allCommuneDropdown').addEventListener('change', function() {
    selectedCommune = this.value; // Affecter la valeur à la variable globale
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

document.getElementById('instituteDropdown').addEventListener('change', function() {
    var selectedInstitute = this.value;
    updateStudentsTable(selectedInstitute);
});



document.addEventListener('DOMContentLoaded', function() {
var filterButton = document.getElementById('filter');
filterButton.addEventListener('click', filterStudents);
var table1 = document.querySelector('.table1');
var table2 = document.querySelector('.table2');
var button1 = document.getElementById('exportToExcel');
var button2 = document.getElementById('exportToExcel2');

button1.style.display = 'none';
filterButton.addEventListener('click', function() {
    table1.style.display = 'block';
    button1.style.display='block'
    table2.style.display = 'none';
    button2.style.display='none'
    

    var selectedInstitute = document.getElementById('instituteDropdown').value;
    updateStudentsTable(selectedInstitute);
});
});

function filterStudents(event) {
    
        event.preventDefault();

        // Récupérer et traiter les données du formulaire, si nécessaire
        var selectedInstitute = document.getElementById('instituteDropdown').value;

        // Appeler la fonction de mise à jour du tableau d'étudiants
        updateStudentsTable(selectedInstitute);
    };


function updateStudentsTable(selectedInstitute) {
    sessionStorage.setItem('selectedInstitute', selectedInstitute);
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            console.log('Response:', this.responseText);
            console.log('Status:', this.status);

            if (this.status == 200) {
                try {
                    var studentsData = JSON.parse(this.responseText);
                    displayStudentsTable(studentsData, selectedInstitute); // Pass selectedInstitute as a parameter
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
};

function displayStudentsTable(studentsData, selectedInstitute) {
    var studentsTableBody = document.getElementById('studentsTableBody');
    studentsTableBody.innerHTML = '';

    for (var i = 0; i < studentsData.length; i++) {
        var row = document.createElement('tr');
        row.innerHTML = '<td>' + studentsData[i].NumInscription + '</td>' +
            '<td>' + studentsData[i].NomArabeEleve + '</td>' +
            '<td>' + studentsData[i].PrenomFrancaisEleve + '</td>' +
            '<td>' + studentsData[i].PrenomArabeEleve + '</td>' +
            '<td>' + studentsData[i].NomFrancaisEleve + '</td>' +
            '<td>' + studentsData[i].NiveauScolaire + '</td>' +
            '<td>' + studentsData[i].DateNaissance + '</td>' +
            '<td>' + studentsData[i].LieuNaissance + '</td>' +
            '<td>' + studentsData[i].AnneeScolaire + '</td>' +
            '<td>' + studentsData[i].DateAbandonnement + '</td>' +
            '<td>' + studentsData[i].id_Inst + '</td>' +
            '<td>' + studentsData[i].Remarque + '</td>' +
            '<td class="action-icons">' +
            '<a href="EditDataAdmin.php?NumInscription=' + studentsData[i].NumInscription + '" title="تعديل"><i class="fas fa-edit"></i></a>' +
            '<a href="viewCertificatAdmin.php?NumInscription=' + studentsData[i].NumInscription + '&commune=' + selectedCommune + '&institute=' + selectedInstitute + '" title="عرض"><i class="fas fa-eye"></i></a>' +
            '</td>';
        studentsTableBody.appendChild(row);
    }
}
        </script>
    
    <script>
    document.getElementById('resetPasswordButton').addEventListener('click', function () {
        var selectedInstitute = document.getElementById('instituteDropdown').value;
        resetPasswords(selectedInstitute);
    });

    function resetPasswords(selectedInstitute) {
        // Effectuez une requête AJAX pour réinitialiser les mots de passe pour l'institution sélectionnée
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    alert("تمت إعادة تعيين كلمات المرور للمؤسسة المحددة بنجاح.");
                } else {
                    alert("خطأ في إعادة تعيين كلمات المرور.");
                }
            }
        };
        xhttp.open("GET", "reset_password.php?institute=" + selectedInstitute, true);
        xhttp.send();
    }
</script>
<script>
    document.getElementById('resetAllPasswordsButton').addEventListener('click', function () {
        resetAllPasswords();
    });

    function resetAllPasswords() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    alert("تمت إعادة تعيين كلمات المرور لجميع المؤسسات بنجاح.");
                } else {
                    alert("خطأ في إعادة تعيين كلمات المرور.");
                }
            }
        };
        xhttp.open("GET", "reset_all_passwords_no_hash.php", true);
        xhttp.send();
    }
</script>

</body>
</html>