<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'csrf.php';
require 'appointments.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du token CSRF
    if (!validateCSRFToken($_POST['csrf_token'])) {
        echo "<div class='alert alert-danger mt-3' role='alert'>Token CSRF invalide.</div>";
        exit();
    }

    $action = $_POST['action'];
    if ($action == 'book') {
        $date = $_POST['date'];
        $time = $_POST['time'];
        $user_id = $_SESSION['user_id'];
        if (bookAppointment($user_id, $date, $time)) {
            echo "<div class='alert alert-success mt-3' role='alert'>Rendez-vous enregistré !</div>";
        } else {
            echo "<div class='alert alert-danger mt-3' role='alert'>Erreur lors de l'enregistrement du rendez-vous.</div>";
        }
    } elseif ($action == 'cancel') {
        $appointment_id = $_POST['appointment_id'];
        if (cancelAppointment($appointment_id)) {
            echo "<div class='alert alert-success mt-3' role='alert'>Rendez-vous annulé !</div>";
        } else {
            echo "<div class='alert alert-danger mt-3' role='alert'>Erreur lors de l'annulation du rendez-vous.</div>";
        }
    }
}

$appointments = getUserAppointments($_SESSION['user_id']);
$allAppointments = getAllAppointments();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        .calendar-day {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            cursor: pointer;
        }
        .calendar-day.disabled {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        .calendar-day.selected {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <header class="bg-light py-4">
        <div class="container text-center">
            <h1 class="mb-4">Système de Réservation en Ligne</h1>
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container my-5">
        <section class="text-center">
            <h2 class="mb-4">Calendrier de Réservation</h2>
            <div class="calendar" id="calendar"></div>
            <h3 class="mt-5">Vos Rendez-vous</h3>
            <?php if (!empty($appointments)): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($appointment['date']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['time']); ?></td>
                                <td>
                                    <form action="calendar.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCSRFToken()); ?>">
                                        <input type="hidden" name="action" value="cancel">
                                        <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['id']); ?>">
                                        <button type="submit" class="btn btn-danger">Annuler</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun rendez-vous trouvé.</p>
            <?php endif; ?>
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
        // Génération du calendrier
        document.addEventListener('DOMContentLoaded', function() {
            const calendar = document.getElementById('calendar');
            const today = new Date();
            const year = today.getFullYear();
            const month = today.getMonth();

            // Fonction pour générer le calendrier
            function generateCalendar(year, month) {
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startingDay = firstDay.getDay();

                // Effacer le contenu précédent du calendrier
                calendar.innerHTML = '';

                // Ajouter les jours de la semaine
                const weekdays = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
                weekdays.forEach(day => {
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('calendar-day');
                    dayElement.textContent = day;
                    calendar.appendChild(dayElement);
                });

                // Ajouter les jours du mois
                for (let i = 0; i < startingDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.classList.add('calendar-day', 'disabled');
                    calendar.appendChild(emptyDay);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('calendar-day');
                    dayElement.textContent = day;
                    dayElement.dataset.date = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                    // Vérifier si le jour est déjà réservé
                    const isBooked = <?php echo json_encode(array_column($allAppointments, 'date')); ?>.includes(dayElement.dataset.date);
                    if (isBooked) {
                        dayElement.classList.add('disabled');
                    }

                    dayElement.addEventListener('click', function() {
                        if (!dayElement.classList.contains('disabled')) {
                            const selectedDate = dayElement.dataset.date;
                            const time = prompt("Veuillez entrer l'heure de réservation (HH:MM):");
                            if (time) {
                                const form = document.createElement('form');
                                form.action = "calendar.php";
                                form.method = "POST";
                                form.innerHTML = `
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCSRFToken()); ?>">
                                    <input type="hidden" name="action" value="book">
                                    <input type="hidden" name="date" value="${selectedDate}">
                                    <input type="hidden" name="time" value="${time}">
                                `;
                                document.body.appendChild(form);
                                form.submit();
                            }
                        }
                    });

                    calendar.appendChild(dayElement);
                }
            }

            // Générer le calendrier pour le mois en cours
            generateCalendar(year, month);
        });
    </script>
</body>
</html>
