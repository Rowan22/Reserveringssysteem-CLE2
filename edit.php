<?php

session_start();

//Ingelogd zijn voor dat je op de pagina mag komen.
if(isset($_SESSION['loggedInAdmin'])) {
    $login = true;
} else {
$login = false;
}

/** @var mysqli $db */

//Database connectie
require_once "database.php";

$bookingId = mysqli_escape_string($db, $_GET['id']);

//Krijg de reservering van de database
$query = "SELECT * FROM bookings WHERE id = '$bookingId'";
$result = mysqli_query($db, $query)
or die ('Error: ' . $query );



$booking = mysqli_fetch_assoc($result);

$bookingId = mysqli_escape_string($db, $_GET['id']);

if (isset($_POST['updatedate'])) {
    $query = "UPDATE bookings SET date='$_POST[date]' WHERE id= $bookingId";
    $query_run = mysqli_query($db, $query);

//Fout en goed meldingen opstellen

    if ($query_run){
        $datesucces = 'Het is gelukt, je aanpassingen zijn opgeslagen';
    }else{
        echo "Oeps er is iets mis gegaan";
    }
}
if (isset($_POST['updatetime'])) {
    $query = "UPDATE bookings SET time='$_POST[time]' WHERE id= $bookingId";
    $query_run = mysqli_query($db, $query);

    if ($query_run){
        $succes = 'Het is gelukt, je aanpassingen zijn opgeslagen';
    }else{
        echo "Oeps er is iets mis gegaan";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <title>Afsprakenoverzicht bewerken</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<h1>Edit</h1>

<!--Formulier aanmaken-->
<form class="box" action="" method="post">       Datum wijzigen van: <?= $booking['date'] ?> naar:<br><br>
    <input type="date" name="date" placeholder="Datum wijzigen naar:"/>
    <input type="submit" name="updatedate" value="Datum wijzigen"/>
    <span><?= $datesucces ?? '' ?></span><br>
    <br>     tijd wijzigen van: <?= $booking['time'] ?> naar:     <input type="text" name="time" placeholder="Tijd wijzigen naar:"/>
    <input type="submit" name="updatetime" value="Tijd wijzigen"/>
    <span><?= $succes ?? '' ?></span><br>
    <br> </form>
<div>
    <a href="afsprakenoverzicht.php">Ga terug naar het overzicht</a>
</div>
</body>
</html>
