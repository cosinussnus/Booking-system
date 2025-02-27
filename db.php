<?php
// Informations de connexion à la base de données
$servername = "localhost"; // Laragon utilise "localhost" par défaut
$username = "root"; // Nom d'utilisateur par défaut pour MySQL dans Laragon
$password = ""; // Mot de passe par défaut pour MySQL dans Laragon
$dbname = "reservation"; // Nom de la base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>
