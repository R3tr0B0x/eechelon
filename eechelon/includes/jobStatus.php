<!DOCTYPE html>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="./taskList_files/css" rel="stylesheet" type="text/css">
<link href="./taskList_files/css(1)" rel="stylesheet" type="text/css">
    
<title>Task List</title>

<link rel="stylesheet" type="text/css" href="./taskList_files/style.css">
<link rel="stylesheet" type="text/css" href="./taskList_files/skin.css">
<link rel="stylesheet" type="text/css" href="./taskList_files/framework.css">
<link rel="stylesheet" type="text/css" href="./taskList_files/font-awesome.css">
    
<script type="text/javascript" src="./taskList_files/jquery.js.download"></script><style></style>
<script type="text/javascript" src="./taskList_files/plugins.js.download"></script>
<script type="text/javascript" src="./taskList_files/custom.js.download"></script>
</head>

<body>
<div id="page-transitions">
    
<div class="page-preloader page-preloader-dark">
    <img class="page-preload" src="./taskList_files/preload.gif">
</div>
    

            
<div id="page-content" class="page-content header-clear fadeIn show-containers">
    <div id="page-content-scroll" style="right: 0px;">
        
        <div class="heading-strip bg-1">
            <h3>Tasklists</h3>
            <p>Job Title: <?php echo $result['job_title']; ?></p>
            <i class="fa fa-check-circle"></i>
            <div class="overlay dark-overlay"></div>
        </div>
        <div class="decoration decoration-margins"></div>

        <div class="content no-bottom material-full-top">
            <div class="container no-bottom">
                <div class="one-half-responsive">
                    <a href="#" class="tasklist-item tasklist-red tasklist-completed">
                        <i class="fa fa-check"></i>
                        <h5>Accepted Job</h5>
                    </a>     
                                   
                    <a href="#" class="tasklist-item tasklist-green <?php if($result['status']=='e' || $result['status']=='g') echo 'tasklist-completed'; ?>">             
                        <i class="fa fa-check"></i>
                        <h5>Item Purchased/Picked Up</h5>
                    </a>
                                        
                    <a href="#" class="tasklist-item tasklist-blue <?php if($result['status']=='g') echo 'tasklist-completed'; ?>">
                        <i class="fa fa-check"></i>
                        <h5>Deliveried</h5>
                    </a>
                   
                    <div class="decoration"></div>
                </div>
            </div>
        </div>
       <?php if($result['start_coord']!=NULL){ ?>
        <a href="qrDisplay?jobID=<?php echo $jobID; ?>&ctype=p" target="_blank" class="button button-round button-green">View Pickup QR</a>
       <?php }?>
        <a href="qrDisplay?jobID=<?php echo $jobID; ?>&ctype=c" target="_blank" class="button button-round button-green">View Completion QR</a>
        <a href="myJobs" class="button button-round button-red">Back</a>
        <div class="decoration decoration-margins"></div>
    </div>  
</div>


    
</div>
<div class="share-bottom-tap-close"></div></body></html>