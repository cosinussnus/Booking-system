<?php
require 'db.php';

function createUser($nom, $prenom, $date_naissance, $adresse, $telephone, $email, $mot_de_passe) {
    global $conn;
    $sql = "INSERT INTO utilisateurs (nom, prenom, date_naissance, adresse, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nom, $prenom, $date_naissance, $adresse, $telephone, $email, $mot_de_passe);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
