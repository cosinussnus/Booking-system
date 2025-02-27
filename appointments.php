<?php
require 'db.php';

function bookAppointment($user_id, $date, $time) {
    global $conn;
    $sql = "INSERT INTO rendezvous (user_id, date, time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $date, $time);
    return $stmt->execute();
}

function getUserAppointments($user_id) {
    global $conn;
    $sql = "SELECT * FROM rendezvous WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function cancelAppointment($appointment_id) {
    global $conn;
    $sql = "DELETE FROM rendezvous WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    return $stmt->execute();
}

function getAllAppointments() {
    global $conn;
    $sql = "SELECT * FROM rendezvous";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
