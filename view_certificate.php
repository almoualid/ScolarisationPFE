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
        $sql = "SELECT * FROM Eleve WHERE NumInscription = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $numInscription);
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
        $mpdf = new Mpdf(['mode' => 'utf8mb4_general_ci', 'format' => 'A2']);
        // Customize PDF content based on your requirements
        // ...

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
            margin-left: 100px;
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

        .footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<!-- ... (your HTML head and body tags) ... -->

<body class="body">
    <div class="container">
        <div class="letter">
        <header>
                <table cellpadding="30px">
                    <thead>
                        <tr>
                            <th>
                                الأكاديمية الجهوية للتربية والتكوين <br><br>
                                المديرية الإقليمية ورزازات <br><br>
                                جهة درعة تافيلالت
                            </th>
                            <th rowspan=3><img src="./images/LogoMenAr.png" alt="" srcset=""></th>
                        </tr>
                    </thead>
                </table>
            </header>
            <div class="header">
                <h1> شهادة مدرسية رقم <strong id="point">:</strong> ........................</h1>
            </div>

            <div class="content">
                <table cellpadding="15px" width="990px">
                    <thead>
                        <tr style="font-size: 20px;" >
                            <th>
                                <p>ت يشهد الموقع اسفله أن التلميذ    <strong id="point">:</strong>
                            </th>
                            <th>

                            </th>
                            <th>
                            رقم التسجيل <strong id="point">:</strong><?php echo $studentDetails['NumInscription']; ?>
                            </th>
                        </tr>
                        <tr style="font-size: 20px;">
                        <th>
                           <p> الإسم العائلي<strong id="point">:</strong><?php echo $studentDetails['NomArabeEleve']; ?></p>
                        </th>
                            <th>

                            </th>
                            <th>
                                <p>الاسم الشخصي<strong id="point">:</strong> <?php echo $studentDetails['PrenomArabeEleve']; ?></p>
                            </th>
                        </tr>
                        <tr style="font-size: 20px;">
                            <th>
                                <p> الاسم العائلي بالفرنسية <strong id="point">:</strong> <?php echo $studentDetails['NomFrancaisEleve']; ?></p>
                            </th>
                            <th>

                            </th>
                            <th>
                                <p> الاسم الشخصي بالفرنسية <strong id="point">:</strong><?php echo $studentDetails['PrenomFrancaisEleve']; ?></p>
                            </th>
                        </tr>
                        <tr style="font-size: 20px;">
                            <th>
                                <p>تاريخ الازدياد <strong id="point">:</strong><?php echo $studentDetails['DateNaissance']; ?></p>
                            </th>
                            <th>

                            </th>
                            <th>
                                <p>مكان الازدياد <strong id="point">:</strong> <?php echo $studentDetails['LieuNaissance']; ?></p>
                            </th>
                        </tr>
                        <tr style="font-size: 20px;">
                            <th>
                                <p>کان/ت ت/يتابع دراسته (ها) بهذه المؤسسة موسم <strong id="point">:</strong>  <?php echo $studentDetails['AnneeScolaire']; ?></p>
                            </th>
                            <th>
                            </th>
                            <th>
                            بمستوى <strong id="point">:</strong> <?php echo $studentDetails['NiveauScolaire']?>
                            </th>
                        </tr>
                        <tr style="font-size: 20px;">
                            <th>
                                <p>تاريخ الانقطاع عن الدراسة <strong id="point">:</strong>  <?php echo $studentDetails['DateAbandonnement']; ?></p>
                            </th>
                            <th>

                            </th>
                        </tr>
                        <tr style="font-size: 20px;">
                            <th>
                                <p> ملاحظة <strong id="point">:</strong> <?php echo $studentDetails['Remarque']; ?></p>
                            </th>
                            <th>

                            </th>
                            <th>
                                حرر ب ورزازات في <?php echo date('d/m/Y'); ?> <br><br>
                                خاتم و توقيع رئيس المؤسسة
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
        </div>

            <div class="footer">
                <form method="post">
                    <button class="btn btn-success" name="download" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                         <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z"/>
                          <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103"/>
                    </svg>
                        تحميل الشهادة بصيغة PDF
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include html2pdf.js library -->
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <script>
    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission
        var element = document.querySelector('.container');
        element.style.marginTop = '-100px';
        element.style.height = '1000px';
        point=document.getElementById('point');
        point.style.textAlign='left';

       


        html2pdf(element, {
            margin: 10,
            filename: 'certificate.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a3', orientation: 'portrait' },
            font: [
                { family: 'Sherif' },
            ],
            onBeforeSaveAs: (pdf, name) => {
                // Customize the styles for th and td elements
                pdf.output('datauristring', (dataUri) => {
                    const div = document.createElement('div');
                    div.innerHTML = '<style>' +
                        'th, td { text-align: left !important; }' +
                        '</style>' +
                        '<img src="' + dataUri + '">';
                    const pdfElement = div.firstElementChild;
                    
                    // Remove previous styles
                    pdfElement.removeAttribute('style');
                    
                    // Add additional styles if needed
                    
                    // Save the modified PDF
                    pdf.save(name);
                });
            },
        });
    });
</script>

</body>

</html>