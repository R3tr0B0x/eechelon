<?php

require_once('APP_START.php');

if(isset($_GET['jobID'])){
    $jobID = sanitizeData($_GET['jobID']);
    global $con;
    $acceptedBy=$_SESSION['userID'];
    $sql = mysqli_query($con, "SELECT job_title, status, start_coord FROM job_list WHERE jobID='$jobID' AND acceptedBy='$acceptedBy'");
    if (mysqli_num_rows($sql)  == 1) 
    {
        $result = mysqli_fetch_assoc($sql);
        require_once('includes/tasklist.php');
    }else{
          header('Location: onGoingJobs');
    }
    
    die();
}else{
        
    require_once('includes/onGoingJobs.php');
    die();
}

?>