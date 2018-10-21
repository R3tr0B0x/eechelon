<?php

require_once('APP_START.php');

if(isset($_GET['jobID'])){
    $jobID = sanitizeData($_GET['jobID']);
    global $con;
    $acceptedBy=$_SESSION['userID'];
    $sql = mysqli_query($con, "SELECT status FROM job_list WHERE jobID='$jobID' AND acceptedBy='$acceptedBy'");
    if (mysqli_num_rows($sql)  == 1) 
    {
        $result = mysqli_fetch_assoc($sql);
        if($result['status']=='e' || $result['status']=='c'){
        	require_once('includes/qrInput.php');
        	die();
        }
        
    }else{
          header('Location: onGoingJobs');
            die();
    }
     
  
}elseif(isset($_GET['qrcode']) && isset($_GET['jobIDforQR'])){
     $qrCode = sanitizeData($_GET['qrcode']);
     $jobID = sanitizeData($_GET['jobIDforQR']);
     $acceptedBy=$_SESSION['userID'];
     $sql = mysqli_query($con, "SELECT status, start_coord FROM job_list WHERE jobID='$jobID' AND acceptedBy='$acceptedBy'");
     if (mysqli_num_rows($sql)  == 1) 
     {
        $result = mysqli_fetch_assoc($sql);       
        
        if($result['status'] == 'e'){
        	completeDelivery($jobID, $qrCode);
        }elseif($result['status'] == 'c' && $result['start_coord']!=NULL ){
        	pickupPackage($jobID, $qrCode);
        }
        header('Location: onGoingJobs');
        die();
     }
	

}else{
        
    require_once('includes/onGoingJobs.php');
    die();
}

?>