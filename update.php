<?php
require 'db.php';

function updateUser($id, $nom, $prenom, $date_naissance, $adresse, $telephone, $email) {
    global $conn;
    $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, date_naissance = ?, adresse = ?, telephone = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nom, $prenom, $date_naissance, $adresse, $telephone, $email, $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
