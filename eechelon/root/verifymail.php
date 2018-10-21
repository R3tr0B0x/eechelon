<?php
require_once('functions/functions.php');
$vCode=$_GET['vCode'];
if (empty($_GET['vCode']))
{
	$feedback=0;
}
else
{
	$feedback=verifyMail($vCode);
}
if($feedback==1)
	echo 'Email successfully verified.';
elseif($feedback==2)
	echo 'Email already verified.';
else
	echo 'Invalid URL.';
?>