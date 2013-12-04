<?php
session_start();

//$secretpassword = 'apt122';
$secretpassword = 'demo';
$password = $_POST['password'];

if ($password == $secretpassword) {
	$_SESSION['authenticated'] = true;
	// Redirect to your secure location
	echo "success";
} else {
	return false;
}
?>