<?php 
session_start(); 
include("app/config.php");
$obj_cesta = new cesta();
$obj_cesta->del($_POST["id_producto"]);
?>