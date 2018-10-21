<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
    
<title>Available Jobs</title>

<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="styles/skin.css">
<link rel="stylesheet" type="text/css" href="styles/framework.css">
<link rel="stylesheet" type="text/css" href="styles/font-awesome.css">
<style>
    #map {
        height: 50%;
    }
</style>
    
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/plugins.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</head>

<body>
<div id="map"></div>
<div id="page-transitions">
    
<div class="page-preloader page-preloader-dark">
    <img class="page-preload" src="images/preload.gif">
</div>

<div class="bg bg-full bg-blur"></div>
            
<div id="page-content" class="page-content bg bg-cover bg-transparent header-clear">
    <div id="page-content-scroll">
        
        <div class="store-menu-cards">
        <?php
        	global $con;
			$postedBy = $_SESSION['userID'];
			$sql = mysqli_query($con, "SELECT * FROM job_list WHERE postedBy='$postedBy'");		
	        while($result = mysqli_fetch_array($sql)){
	    ?>
	           
       
            <a href="checkJobStatus?jobID=<?php echo $result['jobID'] ?>" class="store-menu-card">
                <h1>
                    <i class="color-red-dark fa fa-dollar"></i>
                    <i class="fa fa-dollar"></i>
                    <i class="fa fa-dollar"></i>
                    <i class="fa fa-dollar"></i>
                    <i class="fa fa-dollar"></i>
                </h1>
                <h2 id="job1"><?php echo $result['job_title'] ?></h2>
                <h3>$<?php echo $result['deliveryFee'] ?></h3>
                <h4 class="bg-green-dark">5.0 <i class="fa fa-star"></i></h4>
                <img class="preload-image" data-original="images/pictures/1t.jpg" alt="img">
            </a>

        <?php
             	}
        ?>        
            
            <div class="clear"></div>
        </div>
        <a href="./" class="button button-round button-red">Back</a>
    </div>  
</div>     

<div class="sidebar-tap-close"></div>
<a href="#" class="back-to-top-badge"><i class="fa fa-caret-up"></i>Back to Top</a>
    
</div>

<script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZvzIT0eFXWoLRX09BKUSQ8ATTR1oXRZQ&callback=initMap" async defer>
</script>
</body>
</html>