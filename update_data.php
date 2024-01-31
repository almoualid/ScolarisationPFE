<?php
session_start();

// Include your database connection file or handle it as per your setup
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all necessary fields are set
    if (
        isset($_POST['NumInscription']) &&
        isset($_POST['NiveauScolaire']) &&
        isset($_POST['NomArabeEleve']) &&
        isset($_POST['NomFrancaisEleve']) &&
        isset($_POST['PrenomArabeEleve']) &&
        isset($_POST['PrenomFrancaisEleve']) &&
        isset($_POST['DateNaissance']) &&
        isset($_POST['LieuNaissance']) &&
        isset($_POST['AnneeScolaire'])
    ) {
        try {
            // Prepare the SQL UPDATE statement
            $sql = "UPDATE Eleve SET 
                    NiveauScolaire = :NiveauScolaire,
                    NomArabeEleve = :NomArabeEleve,
                    NomFrancaisEleve = :NomFrancaisEleve,
                    PrenomArabeEleve = :PrenomArabeEleve,
                    PrenomFrancaisEleve = :PrenomFrancaisEleve,
                    DateNaissance = :DateNaissance,
                    LieuNaissance = :LieuNaissance,
                    AnneeScolaire = :AnneeScolaire,
                    DateAbandonnement = :DateAbandonnement,
                    Remarque = :Remarque
                    WHERE NumInscription = :NumInscription AND id_Inst = :id_Inst";

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':NiveauScolaire', $_POST['NiveauScolaire']);
            $stmt->bindParam(':NomArabeEleve', $_POST['NomArabeEleve']);
            $stmt->bindParam(':NomFrancaisEleve', $_POST['NomFrancaisEleve']);
            $stmt->bindParam(':PrenomArabeEleve', $_POST['PrenomArabeEleve']);
            $stmt->bindParam(':PrenomFrancaisEleve', $_POST['PrenomFrancaisEleve']);
            $stmt->bindParam(':DateNaissance', $_POST['DateNaissance']);
            $stmt->bindParam(':LieuNaissance', $_POST['LieuNaissance']);
            $stmt->bindParam(':AnneeScolaire', $_POST['AnneeScolaire']);
            $stmt->bindParam(':DateAbandonnement', $_POST['DateAbandonnement']);
            $stmt->bindParam(':Remarque', $_POST['Remarque']);
            $stmt->bindParam(':NumInscription', $_POST['NumInscription']);
            $stmt->bindParam(':id_Inst', $_SESSION["user_id"]);

            // Execute the query
            $stmt->execute();

            // Redirect to the view_data.php page after a successful update
            header("Location: view_data.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "All fields are required.";
    }
}
?>
