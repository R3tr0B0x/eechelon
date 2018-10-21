<?php

require_once('functions/functions.php');
if(!isLoggedIn()){
    header('Location: login');
    die();
}



?>