<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');



// Check if NumInscription is provided in the URL
if (isset($_GET['NumInscription'])) {
    $numInscription = $_GET['NumInscription'];

    // Fetch student details based on NumInscription
    try {
        $sql = "SELECT * FROM Eleve WHERE id_Inst = ? AND NumInscription = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $_SESSION["user_id"]);
        $stmt->bindParam(2, $numInscription);
        $stmt->execute();
        $studentDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the student exists
        if (!$studentDetails) {
            echo "Student not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Function to generate and download PDF
    function generatePDF($studentDetails)
    {
        $pdf = new TCPDF();
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();

        // Customize PDF content based on your requirements
        $pdf->SetFont('times', '', 12);
        $pdf->Cell(0, 10, 'بيانات الطالب', 0, 1, 'C');
        $pdf->Cell(0, 10, 'رقم التسجيل: ' . $studentDetails['NumInscription'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'الاسم: ' . $studentDetails['NomArabeEleve'], 0, 1, 'L');

        // Add more details as needed

        // Output PDF as a download
        $pdf->Output('certificate_' . $studentDetails['NumInscription'] . '.pdf', 'D');
    }

    // Check if download button is clicked
    if (isset($_POST['download'])) {
        generatePDF($studentDetails);
    }
} else {
    echo "NumInscription parameter is missing.";
    exit;
}
?>

<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الشهادة</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your additional styles or certificates styling here -->
    <style>
               body {
            font-family: 'times', serif;
            background-color:silver;
        }

        .container {
            margin-top: 50px;
        }

        .letter {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            border-style: solid;
        }

        .content {
            font-size: 26px;
            text-align: right; 
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="letter">
        <header>
            <table  cellpadding="30px" >
                <thead>
                    <tr>
                        <th>
                             الأكاديمية الجهوية للتربية والتكوين <br><br>
                             المديرية الإقليمية : ورزازات <br><br>
                             الجهة درعة تافيلالت  
                        </th>
                    <th rowspan=3><img src="./images/LogoMenAr.png" alt="" srcset=""></th>
                    </tr>
              </thead>
            </table>
        </header>
            <div class="header">
                 <h1> شهادة مدرسية رقم : <?php echo $studentDetails['NumInscription']; ?></h1>
            </div>

            <div class="content">
                <table  cellpadding="15px" width="990px">
                    <thead>
                        <tr>
                            <th>
                            <p><strong>ت / يشهد الموقع  اسفله أن التلميذ :</strong> 
                            </th>
                            <th>

                            </th>
                        </tr>
                        <tr>
                            <th>
                            <p><strong>الاسم:</strong> <?php echo $studentDetails['NomArabeEleve']; ?></p>
                            </th>
                            <th>

                            </th>
                            <th>
                            <p><strong>الاسم الشخصي:</strong> <?php echo $studentDetails['PrenomArabeEleve']; ?></p>
                            </th>
                        </tr>
                        <tr>
                            <th>
                            <p><strong>الاسم الفرنسي:</strong> <?php echo $studentDetails['NomFrancaisEleve']; ?></p>
                            </th>
                            <th>

                            </th>
                            <th>
                            <p><strong>الاسم الشخصي الفرنسي:</strong> <?php echo $studentDetails['PrenomFrancaisEleve']; ?></p>
                            </th>
                        </tr>
                        <tr>
                            <th>
                            <p><strong>تاريخ الازدياد:</strong> <?php echo $studentDetails['DateNaissance']; ?></p>
                            </th>
                            <th>

                            </th>
                            <th>
                            <p><strong>مكان الازدياد:</strong> <?php echo $studentDetails['LieuNaissance']; ?></p>
                            </th>
                        </tr>
                        <tr>
                            <th>
                            <p><strong>کان/ت ت/يتابع دراسته (ها) بهذه المؤسسة موسم :</strong> </p>
                            </th>
                            <th>

                            </th>
                            <th>
                            <?php echo $studentDetails['AnneeScolaire']; ?>
                            </th>
                        </tr>
                        <tr>
                            <th>
                            <p><strong>تاريخ الانقطاع عن الدراسة:</strong> <?php echo $studentDetails['DateAbandonnement']; ?></p>
                           </th>
                           <th>

                           </th>
                        </tr>
                        <tr>
                            <th>
                            <p><strong>ملاحظة:</strong> <?php echo $studentDetails['Remarque']; ?></p>
                            </th>
                            <th>

                            </th>
                            <th>
                            حررب ورزازات في <?php echo date('d/m/Y'); ?> <br><br>
                            خاتم و توقيع رئيس المؤسسة  
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div><br><br>

            <div class="footer">
                <form method="post" action="">
                    <button type="submit" class="btn btn-success" name="download">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M7 11a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 0-1H8a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-1a.5.5 0 0 0 0 1h1a2 2 0 0 0 2-2V1a2 2 0 0 0-2-2H1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h1a.5.5 0 0 0 0-1H2a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-1a.5.5 0 0 0 0 1h1a2 2 0 0 0 2-2V1a2 2 0 0 0-2-2z"/>
                            <path d="M5 15.5a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5z"/>
                        </svg>
                        تحميل الشهادة بصيغة PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
