<?php
session_start();

//Als je ingelogd ben kan je door
if (!isset($_SESSION['loggedInAdmin'])) {
    header("Location: login.php");
    exit;
}


//Email uit de sessie opvragen
$email = $_SESSION['loggedInAdmin']['email'];
?>