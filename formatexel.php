<?php
session_start();

// Inclure votre fichier de connexion à la base de données ou le gérer selon votre configuration
include('conn.php');
require 'vendor/autoload.php'; // Inclure l'autoloader de Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Vérifier si NumInscription est fourni dans l'URL
if (isset($_GET['NumInscription'])) {
    $numInscription = $_GET['NumInscription'];

    // Récupérer les détails de l'élève en fonction de NumInscription
    try {
        $sql = "SELECT * FROM Eleve WHERE id_Inst = ? AND NumInscription = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $_SESSION["user_id"]);
        $stmt->bindParam(2, $numInscription);
        $stmt->execute();
        $studentDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'élève existe
        if (!$studentDetails) {
            echo "Student not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Fonction pour générer et télécharger le fichier Excel
    function generateExcel($studentDetails)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Définir les champs pour le certificat
        $sheet->setCellValue('A1', 'رقم التسجيل');
        $sheet->setCellValue('B1', $studentDetails['NumInscription']);
        $sheet->setCellValue('A2', 'الاسم');
        $sheet->setCellValue('B2', $studentDetails['NomArabeEleve']);
        $sheet->setCellValue('A3', 'الاسم الشخصي');
        $sheet->setCellValue('B3', $studentDetails['PrenomArabeEleve']);
        $sheet->setCellValue('A4', 'الاسم الفرنسي');
        $sheet->setCellValue('B4', $studentDetails['NomFrancaisEleve']);
        $sheet->setCellValue('A5', 'الاسم الشخصي الفرنسي');
        $sheet->setCellValue('B5', $studentDetails['PrenomFrancaisEleve']);
        $sheet->setCellValue('A6', 'تاريخ الازدياد');
        $sheet->setCellValue('B6', $studentDetails['DateNaissance']);
        $sheet->setCellValue('A7', 'مكان الازدياد');
        $sheet->setCellValue('B7', $studentDetails['LieuNaissance']);
        $sheet->setCellValue('A8', 'کان/ت ت/يتابع دراسته (ها) بهذه المؤسسة موسم');
        $sheet->setCellValue('B8', $studentDetails['AnneeScolaire']);
        $sheet->setCellValue('A9', 'تاريخ الانقطاع عن الدراسة');
        $sheet->setCellValue('B9', $studentDetails['DateAbandonnement']);
        $sheet->setCellValue('A10', 'ملاحظة');
        $sheet->setCellValue('B10', $studentDetails['Remarque']);
        $sheet->setCellValue('A11', 'حررب ورزازات في ' . date('d/m/Y'));

        // Enregistrer le fichier Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save('certificate_' . $studentDetails['NumInscription'] . '.xlsx');

        // Télécharger le fichier Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="certificate_' . $studentDetails['NumInscription'] . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    // Vérifier si le bouton de téléchargement est cliqué
    if (isset($_POST['download'])) {
        generateExcel($studentDetails);
    }
} else {
    echo "NumInscription parameter is missing.";
    exit;
}
?>
