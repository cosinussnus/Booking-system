<?php
require 'database/csrf.php';
require 'database/create.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du token CSRF
    if (!validateCSRFToken($_POST['csrf_token'])) {
        echo "<div class='alert alert-danger mt-3' role='alert'>Token CSRF invalide.</div>";
        exit();
    }

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    if (createUser($nom, $prenom, $date_naissance, $adresse, $telephone, $email, $mot_de_passe)) {
        echo "<div class='alert alert-success mt-3' role='alert'>Inscription réussie !</div>";
    } else {
        echo "<div class='alert alert-danger mt-3' role='alert'>Erreur lors de l'inscription : " . $conn->error . "</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="bg-light py-4">
        <div class="container text-center">
            <h1 class="mb-4">Système de Réservation en Ligne</h1>
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Connexion</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container my-5">
        <section class="register text-center">
            <h2 class="mb-4">Créer un compte</h2>
            <form action="register.php" method="POST" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                    <div class="invalid-feedback">Veuillez entrer votre nom.</div>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" required>
                    <div class="invalid-feedback">Veuillez entrer votre prénom.</div>
                </div>
                <div class="form-group">
                    <label for="date_naissance">Date de naissance :</label>
                    <input type="date" id="date_naissance" name="date_naissance" class="form-control" required>
                    <div class="invalid-feedback">Veuillez entrer votre date de naissance.</div>
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse postale :</label>
                    <input type="text" id="adresse" name="adresse" class="form-control" required>
                    <div class="invalid-feedback">Veuillez entrer votre adresse postale.</div>
                </div>
                <div class="form-group">
                    <label for="telephone">Numéro de téléphone :</label>
                    <input type="tel" id="telephone" name="telephone" class="form-control" required pattern="[0-9]{10}">
                    <div class="invalid-feedback">Veuillez entrer un numéro de téléphone valide.</div>
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                    <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe :</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required>
                    <div class="invalid-feedback">Veuillez entrer un mot de passe.</div>
                </div>
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
        </section>
    </main>
    <footer class="bg-light py-3">
        <div class="container text-center">
            <p>&copy; 2023 Système de Réservation en Ligne</p>
        </div>
    </footer>
    <!-- Lien vers Bootstrap JS et ses dépendances -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Validation du formulaire
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

</body>
</html>