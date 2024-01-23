<?php
include_once('conn.php');

try {
    // Example: Replace CodeGresa with the correct column name
    $institute_query = "SELECT * FROM eleve WHERE id_Inst = :selected_institute";

    $stmt = $conn->prepare($institute_query);
    $stmt->bindParam(':selected_institute', $_GET['institute']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    // Handle the exception gracefully
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
