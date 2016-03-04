<?php
//session_start();
if (!isset($_COOKIE["username"]) AND !isset($_COOKIE["userID"])) {
	header('Location: login.php');
	exit;
}
?>