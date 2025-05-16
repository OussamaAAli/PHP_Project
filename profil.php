<?php
session_start();
include 'config.php';

if (!isset($_SESSION['usermail'])) {
    header("Location: index.php");
    exit();
}

$usermail = $_SESSION['usermail'];

// Récupérer les infos utilisateur
$userQuery = mysqli_query($conn, "SELECT Username, Email FROM signup WHERE Email = '$usermail'");
$user = mysqli_fetch_assoc($userQuery);

// Récupérer les réservations

$resQuery = mysqli_query($conn, "SELECT id, RoomType, stat FROM roombook WHERE Email = '$usermail'");

$reservations = [];
while ($row = mysqli_fetch_assoc($resQuery)) {
    $reservations[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
</head>
<body>
<div class="container">
    <h2>Profil de l'utilisateur</h2>
    <p><strong>Nom :</strong> <?= htmlspecialchars($user['Username']) ?></p>
    <p><strong>Adresse mail :</strong> <?= htmlspecialchars($user['Email']) ?></p>

    <h3>Mes réservations</h3>
    <table>
        <tr>

            <th>Type de chambre</th>
            <th>Statut</th>
            <th>Action</th>

        </tr>
        <?php foreach ($reservations as $res): ?>
            <tr>

                <td><?= htmlspecialchars($res['RoomType']) ?></td>
                <td><?= htmlspecialchars($res['stat']) ?></td>

                <td>
                    <?php if (strcasecmp($res['stat'], 'Confirm') == 0): ?>
                        <a href="payer.php?id=<?= $res['id'] ?>" class="btn btn-success">Payer</a>
                    <?php else: ?>
                        <span style="color: gray;">En attente</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>



</div>
</body>
</html>
