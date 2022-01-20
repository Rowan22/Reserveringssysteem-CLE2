<?php

session_start();

//Ingelogd zijn voor dat je op de pagina mag komen.
if(isset($_SESSION['loggedInAdmin'])) {
    $login = true;
} else {
    $login = false;
}
$email = $_SESSION['loggedInAdmin']['email'];
/** @var mysqli $db */

//Connectie met database
require_once "database.php";

//Krijg de informatie uit de database met een SQL query
$query = "SELECT * FROM bookings";
$result = mysqli_query($db, $query) or die ('Error: ' . $query );

//Door de resultate gaan om een custom array aan te maken
$bookings = [];
while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
}

//Eindig verbinding
mysqli_close($db);
?>

<!doctype html>
<html lang="en">
<head>
    <title>Afspraken overzicht</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="afsprakenoverzicht.css"/>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<style>
    body {
        background-color: white;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        font-family: 'Lato';font-size:
    }
</style>
<body>
<h1>Afspraken overzicht</h1>

<table>
    <thead>
    <tr>

        <th>Email</th>
        <th>Datum</th>
        <th>Tijd</th>

        <th colspan="3"></th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($bookings as $booking) { ?>
        <tr>
            <td><?= $booking['name'] ?></td>
            <td><?= $booking['date'] ?></td>
            <td><?= $booking['time'] ?></td>

<!--Edit en delete knoppen maken-->
            <td><a href="edit.php?id=<?= $booking['id'] ?>">Edit</a></td>
            <td><a href="delete.php?id=<?= $booking['id'] ?>">Delete</a></td>
        </tr>

    <?php } ?>
    </tbody>
   <div class="uitloggen">
    <a href="logout.php">Uitloggen</a>
   </div>
</table>
</body>
</html>

