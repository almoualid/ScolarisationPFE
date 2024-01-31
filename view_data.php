<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');

// Initialize variables for search
$searchNumInscription = '';
$searchResultMessage = '';

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $searchNumInscription = $_POST['searchNumInscription'];
}

// Fetch data from the Eleve table based on the search criteria
try {
    if (!empty($searchNumInscription)) {
        $sql = "SELECT * FROM Eleve WHERE id_Inst = ? AND NumInscription = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $_SESSION["user_id"]);
        $stmt->bindParam(2, $searchNumInscription);
    } else {
        $sql = "SELECT * FROM Eleve WHERE id_Inst = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $_SESSION["user_id"]);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if the result set is empty
    if (empty($result) && !empty($searchNumInscription)) {
        $searchResultMessage = 'لا يوجد نتائج للبحث عن رقم التسجيل المحدد.';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض البيانات</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    
</head>

<body>
    <div class="container mt-4">
    
    <div class="btn-container text-center">
            <a href="acceuil.php" class="btn btn-primary"> الصفحة الرئيسية <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
  <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
</svg></a>
        </div>
    <form method="post" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" id="searchNumInscription" name="searchNumInscription" value="<?php echo $searchNumInscription; ?>" placeholder="أدخل رقم التسجيل:">
            </div>
            <button type="submit" class="btn btn-primary" name="search">ابحث<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
            </button>
        </form>
        <?php if (!empty($searchResultMessage)) : ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $searchResultMessage; ?>
            </div>
        <?php endif; ?>

        <!-- Afficher les données dans un tableau -->
        <h3 class="mb-4 text-center">عرض البيانات</h3>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">رقم التسجيل</th>
                    <th scope="col">المستوى الدراسي</th>
                    <th scope="col">الاسم العائلي باللغة العربية</th>
                    <th scope="col">الاسم العائلي باللغة الفرنسية</th>
                    <th scope="col">الاسم الشخصي باللغة العربية</th>
                    <th scope="col">الاسم الشخصي باللغة الفرنسية</th>
                    <th scope="col">تاريخ الازدياد</th>
                    <th scope="col">مكان الازدياد</th>
                    <th scope="col">السنة الدراسية</th>
                    <th scope="col">تاريخ الانقطاع عن الدراسة</th>
                    <th scope="col"> ملاحظة </th>
                    <th scope="col">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?php echo $row["NumInscription"]; ?></td>
                        <td><?php echo $row["NiveauScolaire"]; ?></td>
                        <td><?php echo $row["NomArabeEleve"]; ?></td>
                        <td><?php echo $row["NomFrancaisEleve"]; ?></td>
                        <td><?php echo $row["PrenomArabeEleve"]; ?></td>
                        <td><?php echo $row["PrenomFrancaisEleve"]; ?></td>
                        <td><?php echo $row["DateNaissance"]; ?></td>
                        <td><?php echo $row["LieuNaissance"]; ?></td>
                        <td><?php echo $row["AnneeScolaire"]; ?></td>
                        <td><?php echo $row["DateAbandonnement"]; ?></td>
                        <td><?php echo $row["Remarque"]; ?></td>
                        <td>
                            <a href="edit_data.php?NumInscription=<?php echo $row["NumInscription"]; ?>" class="btn btn-warning btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                               <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                           </svg>
                                تحرير
                            </a>
                            <a href="delete_data.php?NumInscription=<?php echo $row["NumInscription"]; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-x" viewBox="0 0 16 16">
                                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                                 <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708"/>
                            </svg>
                                حذف
                            </a>
                             <!-- Add a button to view the certificate -->
                             <a href="view_certificate.php?NumInscription=<?php echo $row["NumInscription"]; ?>" class="btn btn-info btn-sm" target="_blank">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                   <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                              </svg>
                                عرض 
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="exportExcel.php" style="text-decoration: none;">
              <button type="button" name="button" style="background-color: #4caf50; color: #fff; padding: 10px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-ruled" viewBox="0 0 16 16">
                     <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h7v1a1 1 0 0 1-1 1zm7-3H6v-2h7z"/>
                </svg>
                تحميل البيانات بصيغة Excel
               </button>
        </a>
    </div>
    <script>
    function confirmDelete() {
        return confirm('هل أنت متأكد أنك تريد حذف هذا السجل؟');
    }
    </script>
</body>

</html>
