<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');

// Check if NumInscription is provided in the URL
if (isset($_GET['NumInscription'])) {
    $NumInscription = $_GET['NumInscription'];

    // Delete data for the specified NumInscription
    try {
        $sql = "DELETE FROM Eleve WHERE NumInscription = ? AND id_Inst = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $NumInscription);
        $stmt->bindParam(2, $_SESSION["user_id"]);
        $stmt->execute();

        header("Location: View_data.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "NumInscription not provided.";
    exit();
}
?>
