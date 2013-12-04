<?
session_start();
unset($_SESSION['authenticated']);
unset($_SESSION['sessionBackground']);
unset($_SESSION['url']);
setcookie ("cachedWeather", "", time() - 3600);
session_destroy();
header("Location: login.php");
?>