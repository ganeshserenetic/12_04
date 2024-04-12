<?php 

include_once __DIR__ ."/include/connect.php";

session_start();
if(isset($_SESSION["user"])){
    header('Location: home.php');
    exit();
}


$template = "register.inc.php";
$layout = "main.layout.php";

include_once ("layout/end.inc.php");


?>

