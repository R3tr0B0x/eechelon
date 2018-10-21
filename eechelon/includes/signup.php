<?php
require_once('functions/functions.php');
$fname = $email = $mob = $dob = $password = $cpassword = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$fname = $_POST["fname"];
	$email = $_POST["email"];
	$mob = $_POST["mob"];
	$dob = $_POST["dob"];
	$password = $_POST["password"];
	$cpassword = $_POST["cpassword"];
	$return = signup($email, $password, $cpassword, $mob, $fname, $dob);
        echo $return;
        die();
}
?>
<!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
    
<title>Sign Up</title>

<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="styles/skin.css">
<link rel="stylesheet" type="text/css" href="styles/framework.css">
<link rel="stylesheet" type="text/css" href="styles/font-awesome.css">
    
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/plugins.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</head>

<body>
<div id="page-transitions">
    
<div class="page-preloader page-preloader-dark">
    <img class="page-preload" src="images/preload.gif">
</div>
            
<div id="page-content" class="page-content">
    <div id="page-content-scroll">
        
        <div class="page-fullscreen bg-2">
            <div class="page-fullscreen-content">
                <div class="pageapp-login">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="pageapp-login-input">
                            <i class="login-icon fa fa-user"></i>
                            <input name="fname" type="text" placeholder="Full Name" required>
                        </div>                   
                        <div class="pageapp-login-input">
                            <i class="login-icon fa fa-envelope"></i>
                            <input name="email" type="email" placeholder="Email Address" required>
                        </div>   
                        <div class="pageapp-login-input">
                            <i class="login-icon fa fa-mobile"></i>
                            <input name="mob" type="text" placeholder="Mobile" required>
                        </div>                     
                        <div class="pageapp-login-input">
                            <i class="login-icon fa fa-calendar-o"></i>
                            <input name="dob" class="set-today" type="date" required>                
                        </div>   
                        <div class="pageapp-login-input">
                            <i class="login-icon fa fa-lock"></i>
                            <input id="password" name="password" type="password" placeholder="Password" required>
                        </div>             
                        <div class="pageapp-login-input full-bottom">
                            <i class="login-icon fa fa-lock"></i>
                            <input id="cpassword" name="cpassword" type="password"  placeholder="Confirm Password" required>
                            <span id='message'></span>
                        </div>
                        <input type="submit" value="Sign-Up" name="submit_button" class="button button-green button-icon button-full half-top half-bottom">
                    </form>
                </div>
            </div>
            <div class="overlay dark-overlay"></div>
        </div>
        
    </div>  
</div>

</div>

</div>      

</div>
    
</div>

<script>
$('#password, #cpassword').on('keyup', function () {
    if ($('#cpassword').val()!=''){
        if ($('#password').val() == $('#cpassword').val()) {
            $('#message').html('Matched').css('color', 'green');
        }   else 
            $('#message').html('Don\'t Match').css('color', 'red');
    }
    
});

</script>
</body>