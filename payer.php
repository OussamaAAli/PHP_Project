<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("❌ ID de réservation manquant.");
}

$id = $_GET['id'];
echo "✅ ID reçu : $id<br>";

$sql = "SELECT * FROM roombook WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("❌ Réservation introuvable.");
}

$row = mysqli_fetch_assoc($result);
$Name = $row['Name'];
$Email = $row['Email'];
$RoomType = $row['RoomType'];
$Bed = $row['Bed'];
$NoofRoom = (int)$row['NoofRoom'];
$Meal = $row['Meal'];
$cin = $row['cin'];
$cout = $row['cout'];
$noofday = (int)$row['nodays'];

$room_prices = ["Superior Room" => 3000, "Deluxe Room" => 2000, "Guest House" => 1500, "Single Room" => 1000];
$bed_percent = ["Single" => 1, "Double" => 2, "Triple" => 3, "Quad" => 4, "None" => 0];
$meal_multipliers = ["Room only" => 0, "Breakfast" => 2, "Half Board" => 3, "Full Board" => 4];

$type_of_room = $room_prices[$RoomType] ?? 0;
$type_of_bed = ($type_of_room * ($bed_percent[$Bed] ?? 0)) / 100;
$type_of_meal = $type_of_bed * ($meal_multipliers[$Meal] ?? 0);

$ttot = $type_of_room * $noofday * $NoofRoom;
$btot = $type_of_bed * $noofday;
$mepr = $type_of_meal * $noofday;
$fintot = $ttot + $btot + $mepr;

$check = mysqli_query($conn, "SELECT * FROM payment WHERE id = '$id'");
if (mysqli_num_rows($check) > 0) {
    die("❗ Paiement déjà existant pour l’ID : $id");
}

$insert_sql = "INSERT INTO payment(id, Name, Email, RoomType, Bed, NoofRoom, cin, cout, noofdays, roomtotal, bedtotal, meal, mealtotal, finaltotal)
VALUES ('$id', '$Name', '$Email', '$RoomType', '$Bed', '$NoofRoom', '$cin', '$cout', '$noofday', '$ttot', '$btot', '$Meal', '$mepr', '$fintot')";

if (mysqli_query($conn, $insert_sql)) {
    echo "✅ Paiement enregistré avec succès.";
    header("Location: home.php?success=paiement");
    exit;

    // header("Location: roombook.php?message=success"); // Tu peux le remettre si tout est ok
} else {
    echo "❌ Erreur SQL : " . mysqli_error($conn);
}
?>
