<?php 
session_start(); 
include("app/config.php");
$obj_prod = new productos();
$obj_cesta = new cesta();
echo $obj_cesta->agrega($_POST["id_producto"],$_POST["catidad"]);
?>