<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');

// Fetch data from the Eleve table
try {
    $sql = "SELECT * FROM Eleve WHERE id_Inst = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
</head>


<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: rtl;
        }

        .container {
            margin-top: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #343a40;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <!-- Display data in a table -->
        <h3 class="mb-4 text-center">عرض البيانات</h3>
        <a href="acceuil.php" class="btn btn-primary">العودة إلى الصفحة الرئيسية</a>
        <table class="table">
            <thead class="thead-dark">
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
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?php echo $row["NumInscription"]; ?></td>
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
                            <!-- Edit and Delete links with Bootstrap styling -->
                            <a href="edit_data.php?NumInscription=<?php echo $row["NumInscription"]; ?>" class="btn btn-warning btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brush-fill" viewBox="0 0 16 16">
                                    <path d="M15.825.12a.5.5 0 0 1 .132.584c-1.53 3.43-4.743 8.17-7.095 10.64a6.067 6.067 0 0 1-2.373 1.534c-.018.227-.06.538-.16.868-.201.659-.667 1.479-1.708 1.74a8.118 8.118 0 0 1-3.078.132 3.659 3.659 0 0 1-.562-.135 1.382 1.382 0 0 1-.466-.247.714.714 0 0 1-.204-.288.622.622 0 0 1 .004-.443c.095-.245.316-.38.461-.452.394-.197.625-.453.867-.826.095-.144.184-.297.287-.472l.117-.198c.151-.255.326-.54.546-.848.528-.739 1.201-.925 1.746-.896.126.007.243.025.348.048.062-.172.142-.38.238-.608.261-.619.658-1.419 1.187-2.069 2.176-2.67 6.18-6.206 9.117-8.104a.5 .5 0 0 1 .596.04z" />
                                </svg>
                            </a>
                            <a onclick="return confirm('هل أنت متأكد أنك تريد حقًا حذف التلميذ؟')" href="delete_data.php?NumInscription=<?php echo $row["NumInscription"]; ?>" class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                </svg>
                            </a>
                            <a href="#"class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                            </a>
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
       
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
