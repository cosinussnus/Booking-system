<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Lien vers Bootstrap CSS -->
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
        <section class="login text-center">
            <h2 class="mb-4">Connexion</h2>
            <form action="login.php" method="POST" class="needs-validation" novalidate>
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
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                require 'read.php';

                $email = htmlspecialchars($_POST['email']);
                $mot_de_passe = $_POST['mot_de_passe'];

                $user = getUserByEmail($email);

                if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: calendar.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger mt-3' role='alert'>Email ou mot de passe incorrect.</div>";
                }
            }
            ?>
        </section>
    </main>
    <footer class="bg-light py-3">
        <div class="container text-center">
            <p>&copy; 2023 Système de Réservation en Ligne</p>
        </div>
    </footer>
    

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
