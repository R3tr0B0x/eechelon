<?php
require_once('APP_START.php');
if(isset($_GET['jobID'])){
    $jobID = sanitizeData($_GET['jobID']);
    purchasePackage($jobID);
    header('Location: onGoingJobs');
    die();
}
header('Location: onGoingJobs');
die();

?>