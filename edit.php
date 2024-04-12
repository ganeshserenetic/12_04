<?php
include_once __DIR__ ."/include/connect.php";


$getid = $_GET['id'] ;

$sqlQry="SELECT * FROM users where id =:id";
$resQry= $pdo->selectOne($sqlQry,array(":id"=>$getid));
// $userdata = $resQry->fetch(PDO::FETCH_ASSOC);
// var_dump($resQry);






$template = "edit.inc.php";
$layout = "main.layout.php";
include_once ("layout/end.inc.php");


?>