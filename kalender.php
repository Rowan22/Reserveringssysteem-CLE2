<?php

session_start();

//Ingelogd zijn voor dat je op de pagina mag komen.
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}


//Krijg e-mail uit sessie
$email = $_SESSION['loggedInUser']['email'];

if(isset($_POST['submit'])) {
    require_once "database.php";

    /** @var mysqli $db */

    $date = $_POST['date'];
    $time = $_POST['time'];
    $name = $_POST['name'];

    $checkDate = "SELECT date, time FROM bookings WHERE date = '$date' AND time = '$time'";

    $result = mysqli_query($db, $checkDate);

    $dateCheck = mysqli_num_rows($result);

    //Error melding opstellen
    $errors = [];
    if($date == '') {
        $errors['date'] = 'Selecteer een datum';
    }
    if($time == '') {
        $errors['time'] = 'Selecteer een tijd';
    }
    if($name == '') {
        $errors['name'] = 'Voer een email in';
    }
    if($dateCheck > 0) {
        $errors['time'] = "Deze tijd is niet beschikbaar";
    }

    //Versturen naar de database
    if(empty($errors)) {
        $query = "INSERT INTO bookings (date, time, name) VALUES ('$date', '$time', '$name')";

        $result = mysqli_query($db, $query)
        or die('Db Error: '.mysqli_error($db).' with query: '.$query);

        if ($result) {
          echo "Uw reservering is ontvangen!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="kalender.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/721490cecd.js" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<style>
    body {
        font-family: 'Lato';font-size:
    }

    input[type=text], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type=submit] {
        width: 100%;
        background-color: #7a7a7a;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #545454;
    }

</style>
<body>

<header>
<img class= "logo" src="logo-loes.png" width="9%" height="auto">
</header>

<div class="box">
<form action="" method="post">
<div class="data-field">

    <!--Datum formulier-->
    <label for="date">Kies een datum:</label>
   <br> <input id="date" type="date" name="date" value="<?= $date ?? '' ?>" placeholder="date"/>
    <span class="errors"><?= $errors['date'] ?? '' ?></span>
</div><br>

    <!--Tijd kunnen selecteren-->
    <div>
        <label for="time">Kies een tijd:</label>
<select id="time" name="time" value="<?= $time ?? '' ?>">
    <option value="09:00-10:00">09:00-10:00</option>
    <option value="10:00-11:00">11:00-12:00</option>
    <option value="11:00-12:00">13:00-14:00</option>
    <option value="12:00-13:00">15:00-16:00</option>
    <option value="13:00-14:00">17:00-18:00</option>
</select>
        <span class="errors"><?= $errors['time'] ?? '' ?></span>
    </div><br>

    <!--De klant kan e-mail invoeren-->
    <div class="data-field">
        <label for="name">Email:</label>
        <input id="name" type="text" name="name" placeholder="Uw e-mailadres" value="<?= $name ?? '' ?>"/>
        <span class="errors"><?= $errors['name'] ?? '' ?></span>
    </div>
<br>

<div class="data-submit">
    <input type="submit" name="submit" value="Reserveren"/>
</div>
    <div>
        <a href="logout.php">Uitloggen</a>
    </div>
</div>
</form>
</body>
</html>