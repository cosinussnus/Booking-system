<?php
require 'db.php';

function getUserByEmail($email) {
    global $conn;
    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getAllUsers() {
    global $conn;
    $sql = "SELECT * FROM utilisateurs";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
