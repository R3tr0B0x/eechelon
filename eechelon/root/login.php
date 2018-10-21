<?php
require_once('functions/functions.php');

if(isLoggedIn()){
    header('Location: ./');
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	
	$email = $_POST["email"];
	$password = $_POST["password"];
	if(login($email, $password)){
		header('Location: ./');
	   	die();
	}else{
		require_once('includes/loginPage.php');
		die();
	}
}else{
	require_once('includes/loginPage.php');
	die();
}

