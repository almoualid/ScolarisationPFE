<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Archive_CS";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurer PDO pour rapporter les erreurs.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "La connexion à la base de données a échoué : " . $e->getMessage();
    // Handle the error appropriately (e.g., log it and show a user-friendly message)
    die();
}
?>
