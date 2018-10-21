<!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">


<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
    
<title>EECHELON</title>

<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="styles/skin.css">
<link rel="stylesheet" type="text/css" href="styles/framework.css">
<link rel="stylesheet" type="text/css" href="styles/font-awesome.css">
    
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/plugins.js"></script>
<script type="text/javascript" src="scripts/customlogin.js"></script>
</head>

<body>
<div id="page-transitions">
    
<div class="page-preloader page-preloader-dark">
    <img class="page-preload" src="images/preload.gif">
</div>
    
   
<div class="bg bg-full bg-cover"></div>
            
<div id="page-content" class="page-content header-clear bg bg-cover bg-transparent">
    <div id="page-content-scroll">        
                
    <div class="landing-homepage">
        <div class="landing-page landing-dark">
            <div class="landing-wrapper">
                <div class="landing-header no-bottom">
                <?php 
                $userID= $_SESSION['userID'];
                $sql = mysqli_query($con, "SELECT email, balance FROM user_accounts WHERE userID='$userID'");
                $result = mysqli_fetch_assoc($sql);
                $balance = $result['balance'];
                $email = $result['email'];
                
                ?>
                    <a class="landing-header-logo" href="#"><?php echo $email; ?></a>
                     <div class="landing-header-icons">
                        <a href="#">Balance: <?php echo $balance; ?> </a>
                    </div>

                    <div class="clear"></div>
                </div>
                
                <div class="content no-material no-bottom"><div class="deco"></div></div>
                <!-- Left Top Menu -->
                <ul>
                    <li>
                        <a href="myJobs">
                            <i class="fa fa-home bg-red-dark"></i>
                            <em>My Requests</em>
                        </a>
                    </li>        
                    <li>
                        <a href="jobPosting">
                            <i class="fa fa-cog bg-green-dark"></i>
                            <em>New Request</em>
                        </a>
                    </li>        
                    <li>
                        <a href="onGoingJobs">
                            <i class="fa fa-camera bg-blue-dark"></i>
                            <em>Ongoing Jobs</em>
                        </a>
                    </li>        
                    <li>
                        <a href="jobListing">
                            <i class="fa fa-image bg-magenta-dark"></i>
                            <em>Available Job</em>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-image bg-magenta-dark"></i>
                            <em>Deposit Balance</em>
                        </a>
                    </li>          
                    <li>
                        <a href="logout">
                            <i class="fa fa-mobile bg-orange-dark"></i>
                            <em>Logout</em>
                        </a>
                    </li>        
                    
                </ul>    
                <div class="clear"></div>
                <div class="content no-material no-bottom"><div class="deco"></div></div>
                
            </div>
            <div class="landing-overlay"></div>
            <div class="background"></div>
        </div>
    </div>

        
    </div>  
</div>
    


    
</div>
</body>