<?php 
session_start(); 
include("app/config.php");
$ob_user = new user();
$user = $ob_user->get_data_user();
echo $user->creditos_r;
?>