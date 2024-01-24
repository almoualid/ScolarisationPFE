<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');
require 'vendor/autoload.php'; // Include Composer's autoloader


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;

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

    // Function to generate PDF and output it
    function generateAndOutputPDF($studentDetails)
    {
        $mpdf = new Mpdf();
        // Customize PDF content based on your requirements
            // Activer la prise en charge automatique de la police en fonction de la langue
    $mpdf->autoLangToFont = true;

    // Définir la police et l'encodage si nécessaire
    $mpdf->SetFont('Arial Unicode MS', '', 26);

        $mpdf->WriteHTML('
            <html lang="ar" dir="rtl">
            <head>
                <meta charset="UTF-8">
                <title>شهادة مدرسية</title>
                <style>
                .letter {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 10px;
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
                .content p {
                    font-size: 20px; /* Taille de police pour les paragraphes */
                }

                .content th, .content td {
                    font-size: 24px; /* Taille de police pour les cellules de tableau */
                }
            </style>
            </head>
            <body>
            <div class="letter">
            <header>
            <table cellpadding="30px">
                <thead>
                    <tr>

                        <th rowspan=3><img src="./images/LogoMenAr.png" alt="" srcset=""></th>
                    </tr>
                </thead>
            </table>
        </header>
        <div class="header">
             <h1> شهادة مدرسية رقم : ' . $studentDetails['NumInscription'] . '</h1>
        </div>
        <div class="content">

                <table cellpadding="15px" width="990px">
                    <thead>
                        <tr>
                            <th>
                                <p><strong>ت / يشهد الموقع اسفله أن التلميذ :</strong>
                            </th>
                            <th>

                            </th>
                        </tr>
                        <tr>
                            <th>
                                <p><strong>الاسم:</strong> ' . $studentDetails['NomArabeEleve'] . '</p>
                            </th>
                            <th>

                            </th>
                            <th>
                                <p><strong>الاسم الشخصي:</strong> ' . $studentDetails['PrenomArabeEleve'] . '</p>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <p><strong>الاسم الفرنسي:</strong> ' . $studentDetails['NomFrancaisEleve'] . '</p>
                            </th>
                            <th>

                            </th>
                            <th>
                                <p><strong>الاسم الشخصي الفرنسي:</strong> ' . $studentDetails['PrenomFrancaisEleve'] . '</p>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <p><strong>تاريخ الازدياد:</strong> ' . $studentDetails['DateNaissance'] . '</p>
                            </th>
                            <th>

                            </th>
                            <th>
                                <p><strong>مكان الازدياد:</strong> ' . $studentDetails['LieuNaissance'] . '</p>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <p><strong>کان/ت ت/يتابع دراسته (ها) بهذه المؤسسة موسم :</strong> </p>
                            </th>
                            <th>

                            </th>
                            <th>
                                ' . $studentDetails['AnneeScolaire'] . '
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <p><strong>تاريخ الانقطاع عن الدراسة:</strong> ' . $studentDetails['DateAbandonnement'] . '</p>
                            </th>
                            <th>

                            </th>
                        </tr>
                        <tr>
                            <th>
                                <p><strong>ملاحظة:</strong> ' . $studentDetails['Remarque'] . '</p>
                            </th>
                            <th>

                            </th>
                            <th>
                                حررب ورزازات في ' . date('d/m/Y') . ' <br><br>
                                خاتم و توقيع رئيس المؤسسة
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                </div>
                </div>
            </body>
        </html>
        ');

        // Output PDF as a download
        $mpdf->Output('certificate_' . $studentDetails['NumInscription'] . '.pdf', 'D');
    }

    // Check if download button is clicked
    if (isset($_POST['download'])) {
        generateAndOutputPDF($studentDetails);
        exit; // Ensure that no further output is sent after generating the PDF
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
            background-color: silver;
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
                <table cellpadding="30px">
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
                <table cellpadding="15px" width="990px">
                    <thead>
                        <tr>
                            <th>
                                <p><strong>ت / يشهد الموقع اسفله أن التلميذ :</strong>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                     <path d="M4.603 14.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.7 7.7 0 0 1 1.482-.645 20 20 0 0 0 1.062-2.227 7.3 7.3 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a11 11 0 0 0 .98 1.686 5.8 5.8 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.86.86 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.7 5.7 0 0 1-.911-.95 11.7 11.7 0 0 0-1.997.406 11.3 11.3 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.8.8 0 0 1-.58.029m1.379-1.901q-.25.115-.459.238c-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361q.016.032.026.044l.035-.012c.137-.056.355-.235.635-.572a8 8 0 0 0 .45-.606m1.64-1.33a13 13 0 0 1 1.01-.193 12 12 0 0 1-.51-.858 21 21 0 0 1-.5 1.05zm2.446.45q.226.245.435.41c.24.19.407.253.498.256a.1.1 0 0 0 .07-.015.3.3 0 0 0 .094-.125.44.44 0 0 0 .059-.2.1.1 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a4 4 0 0 0-.612-.053zM8.078 7.8a7 7 0 0 0 .2-.828q.046-.282.038-.465a.6.6 0 0 0-.032-.198.5.5 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822q.036.167.09.346z"/>
                      </svg>
                        تحميل الشهادة بصيغة PDF
                    </button>
                </form>
                <form method="post" action="formatexel.php?NumInscription=<?php echo $studentDetails['NumInscription']; ?>">
                   <button type="submit" class="btn btn-success" name="download">
                   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-ruled" viewBox="0 0 16 16">
                     <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h7v1a1 1 0 0 1-1 1zm7-3H6v-2h7z"/>
                   </svg>
                   تحميل الشهادة بصيغة Exel
    </button>
</form>
            </div>
        </div>
    </div>
</body>

</html>
