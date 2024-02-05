<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');


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
} else {
    echo "NumInscription parameter is missing.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <style>
         fieldset {
            border: 4px solid #000; /* Adjust the border properties as needed */
            padding: 20px; /* Optional: Add padding for better visual appearance */
        }

    
        .two {
            border: solid 2px black;
            width: 400px;

        }
    </style>
</head>

<body style="width: 100%;"><br>
    <fieldset class='container'>

        <div class="container text-center">

            <div class="row">
                <div class="col-6 col-md-4">
                    <div class="trois" style="text-align: right; margin-top: 20px; ">
                        <h6> الجماعة<strong id="point">:</strong> <?php echo $_SESSION["commune"]; ?>             
                        <br>المؤسسة<strong id="point">:</strong> <?php echo $_SESSION["user_name"]; ?>
                        <br>
                             الهاتف<strong id="point">:</strong> 
                            </h6>

                    </div>
                </div>


                <div class="col-6 col-md-4">
                    <div class="deux" style="margin-left: 20px;">
                        <img src="./images/LogoMenAr.png" alt="" height="auto" width="260px" style="margin-top: 20px; margin-left:20px;">
                    </div>
                </div>



                <div class="col-6 col-md-4">
                    <div class="un" style="text-align: right; margin-top: 20px;">
                        <h6> الجهة:درعة تافيلالت
                            <br>
                            المديرية الاقليمية: اقليم ورزازات
                        </h6>
                    </div>
                </div>

            </div>
        </div>


        <div class="container text-center">

            <div class="row">

                <div class="col">

                </div>

                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div class="two">
                                <h4>شهادة مدرسية رقم <strong id="point">:</strong>.........................</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">

                </div>

            </div>
        </div>
        <br>

        <div class="container text-center">

            <div class="row">

                <div class="col-6" style="text-align: right;">
                    <h3 style="font-size: 15px"> ت/يشهد الموقع (ة) اسفله </h3>
                    <h3 style="font-size: 15px;"> الإسم <strong id="point">:</strong><?php echo $studentDetails['NomArabeEleve'];?> <?php echo $studentDetails['PrenomArabeEleve']; ?></h3>
                    <h3 style="font-size: 15px">المولود(ة) في <strong id="point">:</strong> <?php echo $studentDetails['LieuNaissance']; ?></h3>
                    <h3 style="font-size: 15px;"> رقم التسجيل <strong id="point">:</strong> <?php echo $studentDetails['NumInscription']; ?></h3>
                    <h3 style="font-size: 15px;">اللغة الاجنبية التانية:اللغة الانجليزية</h3>
                    <h3 style=" font-size: 15px;"> كان يتابع دراسته في المستوى <strong id="point">:</strong> <?php echo $studentDetails['NiveauScolaire']; ?></h3>
                    <h3 style=" font-size: 15px;"> و قد غادر المؤسسة بتاريخ <strong id="point">:</strong>  <?php echo $studentDetails['DateAbandonnement']; ?></h3>
                </div>

                <div class="col-6" style="text-align: justify;">
                    <br>
                    <h3 style=" font-size: 15px;"> Nom et Prénom :  <?php echo $studentDetails['NomFrancaisEleve']; ?>  <?php echo $studentDetails['PrenomFrancaisEleve']; ?></h3>
                    <h3 style="font-size: 15px ;">  بتاريخ <strong id="point">:</strong><?php echo $studentDetails['DateNaissance']; ?></h3>
                    <br>
                    <br>
                    <h3 style=" font-size: 15px;"> للموسم الدراسي <strong id="point">:</strong>  <?php echo $studentDetails['AnneeScolaire']; ?></h3>
                </div>

            </div>
        </div>

        <br>

        <div class="container text-center">
            <!-- Stack the columns on mobile by making one full-width and the other half-width -->
            <div class="row">
                <div class="col-md-8">
                    <h3 style="font-size: 15px; text-align: right;">  ملاحظات <strong id="point">:</strong> <?php echo $studentDetails['Remarque']; ?></h3>
                </div>
                <div class="col-6 col-md-4"></div>
            </div>
        </div>
        <br>
        <div class="container text-center">
            <!-- Stack the columns on mobile by making one full-width and the other half-width -->
            <div class="row">
                <div class="col-6"></div>

                <div class="col-6 " style="text-align: justify;">
                    <h3 style="font-size: 16px;"> حرر ب <strong id="point">:</strong> <?php echo $_SESSION["commune"]; ?>  </h3>
                    <h3 style="font-size: 16px;"> في <strong id="point">:</strong> <?php echo date('d/m/Y'); ?> </h3>
                    <br>
                    <h3 style="font-size: 16px; "> :خاتم و توقيع رئيس المؤسسة </h3>
                </div>
            </div>
        </div>




        <br><br><br>
    </fieldset>
    <br><br><br>
    <fieldset class='container'>

<div class="container text-center">

    <div class="row">
        <div class="col-6 col-md-4">
            <div class="trois" style="text-align: right; margin-top: 20px; ">
                <h6> الجماعة<strong id="point">:</strong> <?php echo $_SESSION["commune"]; ?>             
                <br>المؤسسة<strong id="point">:</strong> <?php echo $_SESSION["user_name"]; ?>
                <br>
                     الهاتف<strong id="point">:</strong> 
                    </h6>

            </div>
        </div>


        <div class="col-6 col-md-4">
            <div class="deux" style="margin-left: 20px;">
                <img src="./images/LogoMenAr.png" alt="" height="auto" width="260px" style="margin-top: 20px; margin-left:20px;">
            </div>
        </div>



        <div class="col-6 col-md-4">
            <div class="un" style="text-align: right; margin-top: 20px;">
                <h6> الجهة:درعة تافيلالت
                    <br>
                    المديرية الاقليمية: اقليم ورزازات
                </h6>
            </div>
        </div>

    </div>
</div>


<div class="container text-center">

    <div class="row">

        <div class="col">

        </div>

        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="two">
                        <h4>شهادة مدرسية رقم <strong id="point">:</strong>.........................</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">

        </div>

    </div>
</div>
<br>

<div class="container text-center">

    <div class="row">

        <div class="col-6" style="text-align: right;">
            <h3 style="font-size: 15px"> ت/يشهد الموقع (ة) اسفله </h3>
            <h3 style="font-size: 15px;"> الإسم <strong id="point">:</strong><?php echo $studentDetails['NomArabeEleve'];?> <?php echo $studentDetails['PrenomArabeEleve']; ?></h3>
            <h3 style="font-size: 15px">المولود(ة) في <strong id="point">:</strong> <?php echo $studentDetails['LieuNaissance']; ?></h3>
            <h3 style="font-size: 15px;"> رقم التسجيل <strong id="point">:</strong> <?php echo $studentDetails['NumInscription']; ?></h3>
            <h3 style="font-size: 15px;">اللغة الاجنبية التانية:اللغة الانجليزية</h3>
            <h3 style=" font-size: 15px;"> كان يتابع دراسته في المستوى <strong id="point">:</strong> <?php echo $studentDetails['NiveauScolaire']; ?></h3>
            <h3 style=" font-size: 15px;"> و قد غادر المؤسسة بتاريخ <strong id="point">:</strong>  <?php echo $studentDetails['DateAbandonnement']; ?></h3>
        </div>

        <div class="col-6" style="text-align: justify;">
            <br>
            <h3 style=" font-size: 15px;"> Nom et Prénom :  <?php echo $studentDetails['NomFrancaisEleve']; ?>  <?php echo $studentDetails['PrenomFrancaisEleve']; ?></h3>
            <h3 style="font-size: 15px ;">  بتاريخ <strong id="point">:</strong><?php echo $studentDetails['DateNaissance']; ?></h3>
            <br>
            <br>
            <h3 style=" font-size: 15px;"> للموسم الدراسي <strong id="point">:</strong>  <?php echo $studentDetails['AnneeScolaire']; ?></h3>
        </div>

    </div>
</div>

<br>

<div class="container text-center">
    <!-- Stack the columns on mobile by making one full-width and the other half-width -->
    <div class="row">
        <div class="col-md-8">
            <h3 style="font-size: 15px; text-align: right;">  ملاحظات <strong id="point">:</strong> <?php echo $studentDetails['Remarque']; ?></h3>
        </div>
        <div class="col-6 col-md-4"></div>
    </div>
</div>
<br>
<div class="container text-center">
    <!-- Stack the columns on mobile by making one full-width and the other half-width -->
    <div class="row">
        <div class="col-6"></div>

        <div class="col-6 " style="text-align: justify;">
            <h3 style="font-size: 16px;"> حرر ب <strong id="point">:</strong> <?php echo $_SESSION["commune"]; ?>  </h3>
            <h3 style="font-size: 16px;"> في <strong id="point">:</strong> <?php echo date('d/m/Y'); ?> </h3>
            <br>
            <h3 style="font-size: 16px; "> خاتم و توقيع رئيس المؤسسة: </h3>
        </div>
    </div>
</div>




<br><br><br>
</fieldset>
    
</body>
</html>