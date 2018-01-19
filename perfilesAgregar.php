<?php 
include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
<div id="main">
<div id="copete">
	<span>Agregar/Modificar perfiles</span>
	<p>&nbsp;</p>
</div>
<?php 
$id = (isset($_GET["id"]))?$_GET["id"]:0;
include "clases/class.perfiles.php";
$obj = new perfiles($bd);
if($id){
	$row = $obj->obtenerDatos($id);
}

if(count($_SESSION["atras"])){
	$row = array();
	$atras = $_SESSION["atras"];
}

$_SESSION["atras"] = array();
?>
<form action="<?php echo $seguridad->obternerUrl("perfilesProcesar.php",array("id"=>$id,"tipo"=>1))?>" method="POST">
	<div>
		<label>Nombre:</label>
		<input type="text" name="descripcion_perfil" value="<?php echo (isset($atras["descripcion_perfil"]))?$atras["descripcion_perfil"]:$row["descripcion_perfil"]?>"/>
	</div>
	<div class="enviar">
		<input type="Submit" value="Cargar">
	</div>
</form>