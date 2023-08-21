<?php
$localIP = getHostByName(getHostName());
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
}
?>
