<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


session_start();
date_default_timezone_set("UTC");
$servername = "localhost";
$username = "myteghiy_eechelon";
$password = "abcd1234";
$dbname = "myteghiy_eechelon";
$con = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
  die('Server overload, please try again after a few minutes.');
}

function deviceDetect(){
    require_once 'Mobile-Detect/Mobile_Detect.php';
    $detect = new Mobile_Detect;
    $device="unknown";
    if ( $detect->isMobile() ) {
     $device="mobile";
    }
    elseif( $detect->isTablet() ){
     $device="tablet";
    }else{
       $device="pc";
    }
    return $device;
}

function sanitizeData($data) {
    global $con;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($con, $data);
    return $data;
}

function isLoggedIn(){
	if(isset($_SESSION['userID'])){
		return true;
	}else{
		return false;
	}
}


function logout(){
    session_destroy();
}

function login($email, $password){
	if(isLoggedIn()){
		return false;
	}
	$email = sanitizeData($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		return false;
	}
	
	global $con;
	$sql = mysqli_query($con, "SELECT userID, password FROM user_accounts WHERE email='$email' AND isEmailVerified='1'");
	if (mysqli_num_rows($sql) == 1)
	{
		$result = mysqli_fetch_assoc($sql);
		$userid = $result['userID'];
		if($password = password_verify(trim($password),$result['password'])){
			$_SESSION['userID']=$userid;
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function hashData($data){
	$options = ['cost' => 12];
	return password_hash($data, PASSWORD_DEFAULT, $options);
}

function emailToId($email)
{
	$email = sanitizeData($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		return 0;
	}
	global $con;
	$sql = mysqli_query($con, "SELECT userID FROM user_accounts WHERE email='$email'");
	if (mysqli_num_rows($sql) == 1)
	{
		$result = mysqli_fetch_assoc($sql);
		return $result['userID'];
	}
	else
		return 0;
}

function idToEmail($userID)
{
	global $con;
	$sql = mysqli_query($con, "SELECT email FROM user_accounts WHERE userID='$userID'");
	if (mysqli_num_rows($sql) == 1)
	{
		$result = mysqli_fetch_assoc($sql);
		return $result['email'];
	}
	else
		return "0";
}
function verifyMail($vCode)
{
	$vCode=sanitizeData($vCode);
	$vCode=decryptURL($vCode);
	$vCode=substr($vCode, 0, 6);
	global $con;
	$sql = mysqli_query($con, "SELECT isEmailVerified FROM user_accounts WHERE emailVC='$vCode'");
	if (mysqli_num_rows($sql) == 1)
	{
		$result = mysqli_fetch_assoc($sql);
		if($result['isEmailVerified']==0)
		{
			$sql = mysqli_query($con,"UPDATE user_accounts SET isEmailVerified='1' WHERE emailVC='$vCode'");
			return 1;
		}
		else
			return 2;
	}
	else
		return 3;
}
function signup($email, $password, $conPassword, $mob, $name, $dob){

	if(($password != $conPassword) || (preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/", $password))===0 || strlen($email)>50 || strlen($password)>255 || strlen($name)>50 || strlen($mob)>14 ||strlen($mob)<11) {
		return 1;
	}
	$email = sanitizeData($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		return 2;
	}
	$hashedPassword = hashData(trim($password));
    $mob = sanitizeData($mob);
    $name = sanitizeData($name);
    $dob = sanitizeData($dob);
    $userStats = userStats($email, $mob); //0 email filter fail, 1 acc block, 2 unverified email, 3 unverified mob, 4 all ok and mob matched, 5 both available, 6 only email available 
    if($userStats == 5)//both available
	{
		global $con;
        $ip = $_SERVER['REMOTE_ADDR'];
		$now = getTimeStamp();
		$vCode = generateRandomString(6);
		$sql = mysqli_query($con,"INSERT INTO user_accounts (email, password, mob, signupIP, isMobVerified, isEmailVerified, isBlocked, lastverreq, emailVC) VALUES ('$email', '$hashedPassword', '$mob', '$ip', '0','0','0','$now','$vCode')");
		if ($sql === TRUE)
		{
			$userID = emailToId('$email');
			$sql = mysqli_query($con,"INSERT INTO user_info (userID, name, dob) VALUES ('$userID', '$name', '$dob')");
			$sendWithURL = generateEmailVerifyStringForMailing($email, $vCode);
			if($sendWithURL=="0")
			{
				return 3; //email filter fail
			}
			sendMail($email,'Email Verification',"http://eechelon.com/andalib/eechelon/verifymail.php?vCode=".$sendWithURL);
			return 4; //signup complete
		}
		else
		{
			return 5; //database server overload
		} 
    }
	else if($userStats == 2)
	{
		global $con;
		$ip = $_SERVER['REMOTE_ADDR'];
		$now = getTimeStamp();
		$vCode = generateRandomString(6);
		$sql = mysqli_query($con,"UPDATE user_accounts SET password='$hashedPassword', mob='$mob', signupIP='$ip', isMobVerified='0', isEmailVerified='0', isBlocked='0', lastverreq='$now', emailVC='$vCode' WHERE email='$email'");
		if ($sql === TRUE)
		{
			$userID = emailToId('$email');
			$sql = mysqli_query($con,"UPDATE user_accounts SET name='$name', dob='$dob' WHERE userID='$userID'");
			$sendWithURL = generateEmailVerifyStringForMailing($email, $vCode);
			if($sendWithURL=="0")
			{
				return 6; //email filter fail
			}
			sendMail($email,'Email Verification',"http://eechelon.com/andalib/eechelon/verifymail.php?vCode=".$sendWithURL);
			return 7; //signup complete
		}
		else
		{
			return 8; //database server overload
		} 	
	}
	else
	{
		return 9;
	}
}
//UNUSED
function sendVerifyEmailEnforced($email)
{
	$email = sanitizeData($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		return 0;
	}
}
function generateEmailVerifyStringForMailing($email, $vCode)
{
	$email = sanitizeData($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		return "0";
	}
	$vString = $vCode.$email;
	$vString = my_simple_crypt($vString, 'e');
	return $vString;
}


function my_simple_crypt($string, $action) {
    // you may change these values to your own
    $secret_key = 'fay37udmdfiw1';
    $secret_iv = 'fay37udmdfiw1_iv';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }

    return $output;
}

function decryptURL($URLcode)
{
	$decryptedString=my_simple_crypt($URLcode, 'd');
	return $decryptedString;
}


function sendVerifyEmail($email){
	global $con;
	$email = sanitizeData($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		return 0;
	}
	$sql = mysqli_query($con, "SELECT lastverreq FROM user_accounts WHERE email='$email' AND isVerified='0'");
	if (!mysqli_num_rows($sql) > 0) {
	    return 0;
	}
	$result = mysqli_fetch_assoc($sql);
	$lastverreq = $result["lastverreq"];
	$lastverreq = strtotime($lastverreq);
	$curtime = time();
	if(($curtime-$lastverreq) > 300) { 
		$vCode = generateRandomString(6);
		$now = getTimeStamp();
		$sql = mysqli_query($con,"UPDATE user_accounts SET vCode = '$vCode', lastverreq = '$now' WHERE email = '$email'");
		if($sql === TRUE){
			//email api and shit
			$sendWithURL = generateEmailVerifyStringForMailing($email, $vCode);
			if($sendWithURL=="0"){
				return 0;
			}
			return 1;
				
		}else{
			return 3; //server overload
		}
		  
	}else{
		return 2; //need to wait
	}
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function postJob($job_title, $details, $timeLimit, $start_coord, $end_coord, $packageWorth, $deliveryFee) 
{
	if(deviceDetect()!="mobile"){
		return 0;
	}
	$postedBy = $_SESSION['userID'];
	$job_title = sanitizeData($job_title);
	$details = sanitizeData($details);
	$timeLimit = sanitizeData($timeLimit);
	
        if(!isset($start_coord) || $start_coord=="" || $start_coord=="0") $start_coord='NULL';
        else {$start_coord = sanitizeData($start_coord); $start_coord = "'" . $start_coord . "'";}
	$end_coord = sanitizeData($end_coord);
	$packageWorth = sanitizeData($packageWorth);
	$deliveryFee = sanitizeData($deliveryFee);
	$balance=getUserBalance($postedBy);
	if(strlen($postedBy)>11||strlen($job_title)>60||strlen($details)>500||(($balance<$packageWorth+$deliveryFee)&&$jobType=="b")||(($balance<$deliveryFee)&&$jobType=="p"))
		return 0;
	global $con;
	$now = getTimeStamp();
	$sql = mysqli_query($con,"INSERT INTO job_list (postedBy, job_title, details, timeLimit, start_coord, end_coord, packageWorth, deliveryFee, startTime, status) VALUES ('$postedBy', '$job_title', '$details', '$timeLimit', $start_coord, '$end_coord', '$packageWorth', '$deliveryFee', '$now', 'a')");
	if ($sql === TRUE)
	{
		if($start_coord==NULL)
			balanceChange($postedBy,($deliveryFee+$packageWorth)*-1);
		else
			balanceChange($postedBy,$deliveryFee*-1);
		return 1; //signup complete
	}
	else
	{
		return 3; //database server overload
	}
	
}
function acceptJob($jobID)
{
if(deviceDetect()!="mobile"){
		return 0;
	}
	global $con;
	$acceptedBy = $_SESSION['userID'];
	$jobID = sanitizeData($jobID);
	$balance=getUserBalance($acceptedBy);
	$sql = mysqli_query($con, "SELECT start_coord, packageWorth, deliveryFee FROM job_list WHERE jobID='$jobID'");
	if (mysqli_num_rows($sql) == 1)
	{
		$result = mysqli_fetch_assoc($sql);
		if(strlen($jobID)>11||strlen($acceptedBy)>11||(($balance<$result['deliveryFee'])&&$result['start_coord']==NULL)||(($balance<$result['deliveryFee']+$result['packageWorth'])&&$result['start_coord']!=NULL))
			return 0;
		$pickupCode=$jobID.generateRandomString(8);
		$completionCode=$jobID.generateRandomString(9);
		$now = getTimeStamp();
		$deliveryFee = $result['deliveryFee'];
		$packageWorth = $result['packageWorth'];
		$sql = mysqli_query($con,"UPDATE job_list SET acceptedBy = '$acceptedBy', jobAcceptTimestamp = '$now', status = 'c', pickupCode = '$pickupCode', completionCode = '$completionCode' WHERE jobID = '$jobID' AND status='a'");
		if ($sql === TRUE)
		{
			if($result['start_coord']==NULL)
				balanceChange($acceptedBy,$deliveryFee*-1);
			else
				balanceChange($acceptedBy,($deliveryFee+$packageWorth)*-1);
			return 1; //accept complete
		}
		else
		{
			return 3; //error
		}	
	}
	else
		return 0; //no match
}
function pickupPackage($jobID, $pickupCode)
{
if(deviceDetect()!="mobile"){
		return 0;
	}
	
	$jobID = sanitizeData($jobID);
	$acceptedBy = $_SESSION['userID'];
	$acceptedBy = sanitizeData($acceptedBy);
	$pickupCode = sanitizeData($pickupCode);
	
	global $con;
	$now = getTimeStamp();
	$sql = mysqli_query($con,"UPDATE job_list SET pickupPackageTimestamp = '$now', status = 'e' WHERE acceptedBy = '$acceptedBy' AND status='c' AND pickupCode='$pickupCode' AND jobID='$jobID'");
	if ($sql === TRUE)
	{
		return 1; //pickup complete
	}
	else
	{
		return 3; //error
	}
}
function purchasePackage($jobID)
{
if(deviceDetect()!="mobile"){
		return 0;
	}
	
	$jobID = sanitizeData($jobID);
	$acceptedBy = $_SESSION['userID'];
	$acceptedBy = sanitizeData($acceptedBy);
	if(strlen($jobID)>11||$acceptedBy>11)
		return 0;
	global $con;
	$now = getTimeStamp();
	$sql = mysqli_query($con,"UPDATE job_list SET pickupPackageTimestamp = '$now', status = 'e' WHERE acceptedBy = '$acceptedBy' AND status='c' AND jobID='$jobID' AND start_coord=NULL");
	if ($sql === TRUE)
	{
		return 1; //purchase complete
	}
	else
	{
		return 3; //error
	}
}
function completeDelivery($jobID, $completionCode)
{
if(deviceDetect()!="mobile"){
		return 0;
	}
	
	$jobID = sanitizeData($jobID);
	$acceptedBy = $_SESSION['userID'];
	$acceptedBy = sanitizeData($acceptedBy);
	$completionCode = sanitizeData($completionCode);
	if(strlen($jobID)>11||strlen($completionCode)>20||$acceptedBy>11)
		return 0;
	global $con;
	$now = getTimeStamp();
	$sql = mysqli_query($con,"UPDATE job_list SET endTime = '$now', status = 'g' WHERE acceptedBy = '$acceptedBy' AND status='e' AND completionCode='$completionCode' AND jobID='$jobID'");
	if ($sql === TRUE)
	{
		$sql = mysqli_query($con, "SELECT start_coord, postedBy, packageWorth, deliveryFee FROM job_list WHERE jobID='$jobID'");
		if (mysqli_num_rows($sql) == 1)
		{
			$result = mysqli_fetch_assoc($sql);
			$postedBy = $result['postedBy'];
			$packageWorth = $result['packageWorth'];
			$deliveryFee = $result['deliveryFee'];

			if($result['start_coord']==NULL)
			{
				$total = $packageWorth + $deliveryFee;
				$sql = mysqli_query($con,"INSERT INTO transactions (userIDFrom, userIDTo, amount, description, timestamp) VALUES ('$postedBy', '$acceptedBy', '$total', 'Completed Delivery', '$now')");
			}
			else
			{
				$total = $deliveryFee;
				$sql = mysqli_query($con,"INSERT INTO transactions (userIDFrom, userIDTo, amount, description, timestamp) VALUES ('$postedBy', '$acceptedBy', '$deliveryFee', 'Completed Delivery', '$now')");
			}
		}
		balanceChange($acceptedBy,($deliveryFee*2)+$packageWorth);
		return 1; //pickup complete
	}
	else
	{
		return 3; //error
	}
}
function cancelDelivery($jobID)
{
	$jobID = sanitizeData($jobID);
	$cancelledBy = $_SESSION['userID'];
	$cancelledBy = sanitizeData($cancelledBy);
	if(strlen($jobID)>11||$cancelledBy>11)
		return 0;
	global $con;
	$now = getTimeStamp();
	$sql = mysqli_query($con,"UPDATE job_list SET endTime = '$now', status = 'b' WHERE postedBy = '$cancelledBy' AND status='a'");
	if ($sql === TRUE)
	{
		$sql = mysqli_query($con, "SELECT start_coord FROM job_list WHERE jobID='$jobID'");
		if (mysqli_num_rows($sql) == 1)
		{
			$result = mysqli_fetch_assoc($sql);
			if($result['start_coord']==NULL)
				balanceChange($cancelledBy,$deliveryFee+$packageWorth);
			else
				balanceChange($cancelledBy,$deliveryFee);
		}
		return 1; //pickup complete
	}
	else
	{
		return 3; //error
	}
}
function timeoutClaim($jobID)
{
	$jobID = sanitizeData($jobID);
	if(strlen($jobID)>11)
		return 0;
	global $con;
	$now = getTimeStamp();
	$sql = mysqli_query($con, "SELECT status, start_coord, postedBy, deliveryFee, packageWorth acceptedBy FROM job_list WHERE jobID='$jobID'");
	$result = mysqli_fetch_assoc($sql);
	$postedBy=$result['postedBy'];
	$start_coord=$result['start_coord'];
	$status=$result['status'];
	$deliveryFee=$result['deliveryFee'];
	$packageWorth=$result['packageWorth'];
	$acceptedBy=$result['acceptedBy'];
	if ($sql === TRUE)
	{
		if($status=='d')
		{
			if($start_coord==NULL)
			{
				balanceChange($postedBy,($deliveryFee*2)+$packageWorth);
			}
			else
			{
				balanceChange($postedBy,$deliveryFee*2);
				balanceChange($acceptedBy,$packageWorth);
			}
			$sql = mysqli_query($con,"UPDATE job_list SET endTime = '$now', status = 'i' WHERE status='d' AND jobID='$jobID'");
			$total = $deliveryFee;
			$sql = mysqli_query($con,"INSERT INTO transactions (userIDFrom, userIDTo, amount, description, timestamp) VALUES ('$acceptedBy', '$postedBy', '$total', 'Timeout Pre-Pickup', '$now')");
		}
		elseif($result['status']=='f')
		{
			if($start_coord==NULL)
			{
				balanceChange($postedBy,($deliveryFee*2)+$packageWorth);
				$total = $deliveryFee;
				$sql = mysqli_query($con,"INSERT INTO transactions (userIDFrom, userIDTo, amount, description, timestamp) VALUES ('$acceptedBy', '$postedBy', '$total', 'Timeout Pre-Pickup', '$now')");
			}
			else
			{
				balanceChange($postedBy,($deliveryFee*2)+$packageWorth);
				$total = $deliveryFee+$packageWorth;
				$sql = mysqli_query($con,"INSERT INTO transactions (userIDFrom, userIDTo, amount, description, timestamp) VALUES ('$acceptedBy', '$postedBy', '$total', 'Timeout Pre-Pickup', '$now')");
			}
			$sql = mysqli_query($con,"UPDATE job_list SET endTime = '$now', status = 'j' WHERE status='f' AND jobID='$jobID'");
		}
		else
			return 0; //not timeout
	}
	else
	{
		return 3; //error
	}
}
function listAvailableJobs()
{
	global $con;
	$sql = mysqli_query($con, "SELECT jobID FROM job_list WHERE status='a'");
	$result = mysqli_fetch_assoc($sql);
	if ($sql === TRUE)
		return $result;
	else
		return "0"; //error
}
function getTimeStamp(){
	return date('Y-m-d H:i:s');
}

function userStats($email, $mob)
{
    	global $con;
	$email = sanitizeData($email);
	$mob = sanitizeData($mob);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		return 0;
	}
    	$sql = mysqli_query($con, "SELECT mob, isEmailVerified, isMobVerified, isBlocked FROM user_accounts WHERE email='$email'");
	$result = mysqli_fetch_assoc($sql);
	if (mysqli_num_rows($sql)  > 0) 
	{
		if($result["isBlocked"])
		{
            return 1; //acc blocked
        }
		if(!$result["isEmailVerified"])
		{
            return 2; //unverified email
        }
        if(!$result["isMobVerified"])
		{
            return 3; //unverified mob
        }
		if($result["mob"]==$mob)
		{
			return 4; //acc all ok 
		}
    }
	else
	{
		$sql = mysqli_query($con, "SELECT isEmailVerified, isMobVerified, isBlocked FROM user_accounts WHERE mob='$mob'");
		$result = mysqli_fetch_assoc($sql);
		if (mysqli_num_rows($sql)  == 0)
			return 5; //email and mob are both available
		else
			return 6;// only email is available
	}
}	


function userStatsByID($userID)
{
    
	$userID = sanitizeData($userID);
	global $con;
    	$sql = mysqli_query($con, "SELECT isEmailVerified, isMobVerified, isBlocked FROM user_accounts WHERE userID='$userID'");
	$result = mysqli_fetch_assoc($sql);
	if (mysqli_num_rows($sql)  > 0) 
	{
		if($result["isBlocked"])
		{
            return 1; //acc blocked
        }
		if(!$result["isEmailVerified"])
		{
            return 2; //unverified email
        }
        if(!$result["isMobVerified"])
		{
            return 3; //unverified mob
        }
		if($result["mob"]==$mob)
		{
			return 4; //acc all ok 
		}
    }
	else
	{
		return 0; //user dont exist
	}
}

//return 0 = failed, returned 1 = success
function sendMail($email,$subject,$body){

	$email = sanitizeData($email);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return 0;
		}

	$mail = new PHPMailer(true);                              
	try {
	    //Server settings
	    $mail->SMTPDebug = 0;                                
	    $mail->isSMTP();                                      
	    $mail->Host = 'server190.web-hosting.com';  
	    $mail->SMTPAuth = true;                               
	    $mail->Username = 'noreply@eechelon.com';                
	    $mail->Password = 'abcd1234';                          
	    $mail->SMTPSecure = 'ssl';                            
	    $mail->Port = 465;                                    

	    //Recipients
	    $mail->setFrom('noreply@eechelon.com', 'Eechelon');
	    $mail->addAddress($email);     // Add a recipient


	    //Content
	    $mail->isHTML(true);                                 
	    $mail->Subject = $subject;
	    $mail->Body    = $body;

	    $mail->send();
	    return 1;
	} catch (Exception $e) {
	    return 0;
	}

}

function isUserExist($userID)
{
	$userID = sanitizeData($userID);
	global $con;
	$sql = mysqli_query($con, "SELECT userID FROM user_accounts WHERE userID='$userID'");
	if (mysqli_num_rows($sql) == 1)
	{
		return true;
	}
	else
		return false;
}
function getUserBalance($userID){
	$userID = sanitizeData($userID);
	global $con;
	
	
	$sql = mysqli_query($con, "SELECT balance FROM user_accounts WHERE userID='$userID'");
	$result = mysqli_fetch_assoc($sql);
	if (mysqli_num_rows($sql) == 1)
	{
		
		return $result["balance"];
	}
	else
		return -1;
}

function balanceTransfer($userIDFrom,$userIDTo,$amount,$description){
	$description = sanitizeData($description);
	if(!isUserExist($userIDFrom) || !isUserExist($userIDTo) || userStatsByID($userIDFrom)!=4 || userStatsByID($userIDTo)!=4 || FILTER_VALIDATE_FLOAT($amount))
		return -1; // either of the user dont exist
	if(getUserBalance($userIDFrom)<$amount)
		return -2;
	global $con;
	mysqli_query($con,"UPDATE user_accounts SET balance=balance-'.$amount.' WHERE userID='$userIDFrom'");
	mysqli_query($con,"UPDATE user_accounts SET balance=balance+'.$amount.' WHERE userID='$userIDTo'");
	mysqli_query($con,"INSERT INTO transactions (userIDFrom, userIDTo, amount, description) VALUES ('$userIDFrom', '$userIDTo', '$amount', '$description')");
	return 1;
}


function balanceChange($userID,$amount){
	$userID = sanitizeData($userID);
	$amount = sanitizeData($amount);
	
	global $con;
	return mysqli_query($con,"UPDATE user_accounts SET balance=balance+'$amount' WHERE userID='$userID'");
	return 1;
}
function isJobAccepted($jobID){
        $jobID= sanitizeData($jobID);
        global $con;
        $sql = mysqli_query($con, "SELECT jobID FROM job_list WHERE jobID='$jobID' AND status>'a'");
	if (mysqli_num_rows($sql) == 1)
		return true;
	else
		return false;
}

function getLastPos($jobID)
{
	global $con;
    $jobID= sanitizeData($jobID);
    $userID = $_SESSION['userID'];
    if(isJobAccepted($jobID))
	{
		$sql = mysqli_query($con, "SELECT lastPos FROM job_list WHERE jobID='$jobID' AND postedBy='$userID'");  
        if (mysqli_num_rows($sql) == 1)
	    {
			$result = mysqli_fetch_assoc($sql);
			return $result['lastPos'];
	    }
	    else
			return "N/A";
    }
	else
		return "N/A";
}
function setLastPos($jobID, $lastPos){
        $jobID= sanitizeData($jobID);
        $lastPos= sanitizeData($lastPos);
        $userID = $_SESSION['userID'];
        global $con;
        mysqli_query($con, "UPDATE job_list SET lastPos='$lastPos' WHERE jobID='$jobID' AND acceptedBy='$userID'");  
}


function updateJobStatus($jobID, $status){
        $jobID= sanitizeData($jobID);
        $userID = $_SESSION['userID'];
        $status = sanitizeData($status);
        global $con;
        mysqli_query($con, "UPDATE job_list SET status='$status' WHERE jobID='$jobID' AND acceptedBy='$userID'");  
}
function updateTimers(){
        global $con;
        mysqli_query($con, "UPDATE job_list SET status='d' WHERE TIMESTAMPDIFF(MINUTE,NOW(),jobAcceptTimestamp) > timeLimit AND status='c'");  
        mysqli_query($con, "UPDATE job_list SET status='f' WHERE TIMESTAMPDIFF(MINUTE,NOW(),jobAcceptTimestamp) > timeLimit AND status='e'"); 
}

function timeoutUpdateAndClaim(){
        updateTimers();
        global $con;
        $sql = mysqli_query($con, "SELECT jobID FROM job_list WHERE status='d' OR status='f'"); 
        if(!$sql) die();
        while($result = mysqli_fetch_array($sql)){
           timeoutClaim($result['jobID']);
        }
}

function getOngoingJobs()
{
	global $con;
	$postedBy = $_SESSION['userID'];
	$sql = mysqli_query($con, "SELECT * FROM job_list WHERE postedBy='$postedBy'");
	if (mysqli_num_rows($sql) > 0)
	{
		$result = mysqli_fetch_assoc($sql);
		return $result;
	}
	else
		return "0"; //no match
}
?>