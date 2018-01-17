<?php 
session_start(); 
include("app/config.php");
$obj_cesta = new cesta();
echo $obj_cesta->change($_POST["id_producto"],$_POST["cantidad"]);
?>