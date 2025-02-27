<?php
require 'db.php';

function deleteUser($user_id) {
    global $conn;

    // Supprimer tous les rendez-vous associés à l'utilisateur
    $sql = "DELETE FROM rendezvous WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Supprimer l'utilisateur
    $sql = "DELETE FROM utilisateurs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    return $stmt->execute();
}
?>
