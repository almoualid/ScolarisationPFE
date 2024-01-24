<?php
session_start();
// Include your database connection file or handle it as per your setup
include('conn.php');

// Include PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    // Fetch data from the Eleve table
    $sql = "SELECT * FROM Eleve WHERE id_Inst = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Create a new PhpSpreadsheet instance
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers to the Excel sheet
    $headers = array(
        'رقم التسجيل',
        'الاسم العائلي باللغة العربية',
        'الاسم العائلي باللغة الفرنسية',
        'الاسم الشخصي باللغة العربية',
        'الاسم الشخصي باللغة الفرنسية',
        'تاريخ الازدياد',
        'مكان الازدياد',
        'السنة الدراسية',
        'تاريخ الانقطاع عن الدراسة',
        'ملاحظة'
        
    );

    $column = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($column . '1', $header);
        $column++;
    }

    // Add data to the Excel sheet
    $row = 2;
    foreach ($result as $data) {
        $column = 'A';
        foreach ($data as $value) {
            $sheet->setCellValue($column . $row, $value);
            $column++;
        }
        $row++;
    }

    // Set the appropriate content type for Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="exported_data.xlsx"');
    header('Cache-Control: max-age=0');

    // Create Excel file
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
