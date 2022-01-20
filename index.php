<?php
session_start();

//Als je ingelogd ben kan je door.
if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */
require_once "database.php";

if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

//Foutmeldingen opstellen
    $errors = [];
    if($email == '') {
        $errors['email'] = 'Voer een email adress in';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in';
    }

    if(empty($errors))
    {
        //Krijg reservering op basis van e-mail
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'email' => $user['email'],
                    'id' => $user['id']
                ];
                //Error melding opstellen
            } else {
                $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
            }
        } else {

            $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/721490cecd.js" crossorigin="anonymous"></script>
</head>
<header>
    <img class= "logo" src="logo-loes.png" width="9%" height="auto">
</header>
<style>
    body {
        background-color: white;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        font-family: 'Lato';font-size:
    }

    input[type=submit] {
        width: 100%;
        background-color: #7A7A7A;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover{
    background-color: #545454;
    }

    input[type="text"], .box input[type = "password"] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

</style>
<body>

<form class="box" action="" method="post">
    <div class="login">
        <h1>Login</h1>
    </div>
    <?php if ($login) { ?>
        <p>Je bent ingelogd!</p>
        <p><a href="logout.php">Uitloggen</a> / <a href="kalender.php">Een reservering maken</a></p>
    <?php } else { ?>
            <!--Formulier aanmaken-->
        <div>
            <label for="email">Email</label>
            <input id="email" type="text" name="email" value="<?= $email ?? '' ?>" placeholder="Email"/>
            <span class="errors"><?= $errors['email'] ?? '' ?></span>

            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" value="<?= $password ?? '' ?>" placeholder="Wachtwoord"/>
            <span class="errors"><?= $errors['password'] ?? '' ?></span>

            <p class="errors"><?= $errors['loginFailed'] ?? '' ?></p>
            <input type="submit" name="submit" value="Login"/>
        </div>

        <div>
            <a href="register.php">Maak nieuw account</a>
        </div>
        <div>
        <a href="adminlogin.php">Admin login</a>
        </div>
    <?php } ?>

</form>

</body>
</html>
