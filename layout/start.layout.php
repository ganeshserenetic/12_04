<?php
include_once dirname(__DIR__) . '/includes/connect.php';

if(!isset($_SESSION['customer']['id'])){
	
    header('Location:login.php');
    exit;
}

?>