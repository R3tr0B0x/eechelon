<?php

require_once('APP_START.php');
if(isset($_POST['jobID'])){
    acceptJob($_POST['jobID']);
    $jobID = $_POST['jobID'];
    header("Location: onGoingJobs");
    die();
}elseif(isset($_GET['jobID'])){
    $jobID = sanitizeData($_GET['jobID']);
    global $con;
    $sql = mysqli_query($con, "SELECT job_title, status, details, timeLimit, packageWorth, deliveryFee, start_coord, end_coord FROM job_list WHERE status='a' AND jobID='$jobID'");
    if (mysqli_num_rows($sql)  == 1) 
    {
        $result = mysqli_fetch_assoc($sql);
        require_once('includes/jobListingDetails.php');
    }else{
          header('Location: jobListing');
    }
    
    die();
}else{
    require_once('includes/jobListing.php');
    die();
}

?>