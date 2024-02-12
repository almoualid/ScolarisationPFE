<?php
include_once('conn.php'); // Assurez-vous que votre connexion à la base de données est déjà incluse

// Réinitialisez les mots de passe pour toutes les institutions
$passwordToSet = "12345"; // Remplacez "12345" par le mot de passe souhaité

$resetAllPasswordsQuery = "UPDATE institution SET MotDePasse = :password";

// Exécutez la requête avec les paramètres
$resetAllPasswordsStmt = $conn->prepare($resetAllPasswordsQuery);
$resetAllPasswordsStmt->bindParam(':password', $passwordToSet);

// Exécutez la requête
if ($resetAllPasswordsStmt->execute()) {
    echo "تمت إعادة تعيين كلمات المرور لجميع المؤسسات بنجاح.";
} else {
    echo "خطأ في إعادة تعيين كلمات المرور.";
}
?>
