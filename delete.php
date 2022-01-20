<?php

session_start();

//Ingelogd zijn voor dat je op de pagina mag komen.
if(isset($_SESSION['loggedInAdmin'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */

//Connectie met database
require_once "database.php";


if (isset($_POST['submit'])) {

    //Krijg de reservering van de database
    $bookingId = mysqli_escape_string($db, $_POST['id']);
    $query = "SELECT * FROM bookings WHERE id = '$bookingId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    $album = mysqli_fetch_assoc($result);

    if (!empty($booking['image'])) {
        deleteImageFile($booking['image']);
    }

    //Data verwijderen van het gekozen reserverings ID
    $query = "DELETE FROM bookings WHERE id = '$bookingId'";
    mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db));

    //Connectie eindigen
    mysqli_close($db);

    //Terug naar overzicht na het verwijderen afspraak
    header("Location: afsprakenoverzicht.php");
    exit;

} else if (isset($_GET['id']) || $_GET['id'] != '') {

    $bookingId = mysqli_escape_string($db, $_GET['id']);

    //Krijg de reservering van de database
    $query = "SELECT * FROM bookings WHERE id = '$bookingId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    if (mysqli_num_rows($result) == 1) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        // redirect when db returns no result
        header('Location: afsprakenoverzicht.php');
        exit;
    }
} else {


    //Terug naar afsprakenoverzicht
    header('Location: afsprakenoverzicht.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete - <?= $booking['name'] ?></title>
</head>
<style>
    body {
        font-family: 'Lato';font-size:
    }
</style>
<body>
<h2>Delete - <?= $booking['name'] ?></h2>
<form action="" method="post">
    <p>
        Weet u zeker dat u de afspraak van "<?= $booking['name'] ?>" wilt verwijderen?
    </p>
    <input type="hidden" name="id" value="<?= $booking['id'] ?>"/>
    <input type="submit" name="submit" value="Verwijderen"/>
</form>
</body>
</html>
