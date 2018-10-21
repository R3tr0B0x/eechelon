<?php
require_once('APP_START.php');
$code="";

if(isset($_GET['ctype']) && isset($_GET['jobID'])){
    $jobID = sanitizeData($_GET['jobID']);
    global $con;
    $postedBy=$_SESSION['userID'];
    $sql = mysqli_query($con, "SELECT pickupCode, completionCode FROM job_list WHERE jobID='$jobID' AND postedBy='$postedBy'");
    if (mysqli_num_rows($sql)  == 1) 
    {
        $result = mysqli_fetch_assoc($sql);
        $pickupCode = $result['pickupCode'];
        $completionCode  = $result['completionCode'];
        if($_GET['ctype']=='c'){
        	$code=$completionCode;
        }else{
        	$code=$pickupCode;
        }
    }else{
    	header('Location: ./');
	die();
    }
        
}else{
	header('Location: ./');
	die();
}

?>

<html>
<head>

<title>Web QR</title>

<style type="text/css">
body{
    width:100%;
    text-align:center;
}
img{
    border:0;
}
#main{
    margin: 15px auto;
    background:white;
    overflow: auto;
	width: 750px;
}
#header{
    background:white;
}
#mainbody{
    background: white;
    width:100%;
}
#footer{
    background:white;
}
#mp1{
    text-align:center;
    font-size:35px;
}
#header ul{
    margin-bottom:0;
    margin-right:40px;
}
#header li{
    display:inline;
    padding-right: 0.5em;
    padding-left: 0.5em;
    font-weight: bold;
    border-right: 1px solid #333333;
}
#header li a{
    text-decoration: none;
    color: black;
}
p.quote1{
    
    font-weight:bold;
    margin-left:10%;
    margin-right:10%;
    color: black;
}
a{
	color: black;
}

div.button{
    border: 2px solid #333333;;
    border-radius:15px;
    width:100px;
    cursor:pointer;
    font-weight:bold;
}

</style>



</head>

<body >
<div id="main">

<div id="mainbody">

<table border="0" align="center">

<tr><td align="center">
</td></tr>
<tr><td align="center">
<div id="qrimage">
</div>
</td></tr>

</table>
</div>

</div>

<script type="text/javascript">

function create()
{
    var data="<?php echo $code; ?>";
    document.getElementById("qrimage").innerHTML="<img src='https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl="+encodeURIComponent(data)+"'/>";
}


window.onload =create();
</script>


</body>

</html>
