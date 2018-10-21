<?php

require_once('APP_START.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
   if($_POST['startcoordinate']!='0'){
       postJob( $_POST['jobtitle'], $_POST['details'], $_POST['timelimit'], $_POST['startcoordinate'], $_POST['endcoordinate'], $_POST['packageworth'], $_POST['deliveryfee']) ;
       
   }else{
      postJob($_POST['jobtitle'], $_POST['details'], $_POST['timelimit'], NULL, $_POST['endcoordinate'], $_POST['packageworth'], $_POST['deliveryfee']) ;
       
   }
   header('Location: ./');
   die();
}
else
require_once('includes/jobPosting.php');


?>