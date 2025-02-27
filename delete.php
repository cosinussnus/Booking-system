<?php
require 'db.php';

function deleteUser($id) {
    global $conn;
    $sql = "DELETE FROM utilisateurs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
