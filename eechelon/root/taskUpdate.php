<?php
require 'functions/functions.php';

if(!isset($_POST['jobID']) || !isset($_POST['status']) || !isset($_SESSION['userID'])){
die();
}else{

$jobID= sanitizeData($_POST['jobID']);
$status= sanitizeData($_POST['status']);

updateJobStatus($jobID,$status);
die();


}


?>