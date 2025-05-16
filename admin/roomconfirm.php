<?php
include '../config.php';

$id = $_GET['id'];

// Mettre à jour simplement le statut
$sql = "UPDATE roombook SET stat = 'Confirm' WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location:roombook.php"); // rediriger après confirmation
} else {
    echo "Erreur lors de la confirmation";
}
?>
