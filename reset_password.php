<?php
include_once('conn.php'); // Assurez-vous que votre connexion à la base de données est déjà incluse

if (isset($_GET['institute'])) {
    $selectedInstitute = $_GET['institute'];

    // Réinitialisez les mots de passe pour cette institution
    $passwordToSet = "12345"; // Remplacez "12345" par le mot de passe souhaité

    $resetPasswordQuery = "UPDATE institution SET MotDePasse = :password WHERE CodeGresa = :selectedInstitute";

    // Exécutez la requête avec les paramètres
    $resetPasswordStmt = $conn->prepare($resetPasswordQuery);
    $resetPasswordStmt->bindParam(':password', $passwordToSet);
    $resetPasswordStmt->bindParam(':selectedInstitute', $selectedInstitute);

    // Exécutez la requête
    if ($resetPasswordStmt->execute()) {
        echo "تمت إعادة تعيين كلمات المرور للمؤسسة المحددة بنجاح.";
    } else {
        echo "خطأ في إعادة تعيين كلمات المرور.";
    }
}
?>