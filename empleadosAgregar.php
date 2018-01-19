<?php 
include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
<div id="main">
<div id="copete">
	<span>Agregar/Modificar Empleados </span>
	<p>&nbsp;</p>
</div>
<?php 
$id = (isset($_GET["id"]))?$_GET["id"]:0;
include "clases/class.empleados.php";
$obj = new empleados($bd);
if($id){
	$row = $obj->obtenerDatos($id);
}

?>
<form name="carga" action="<?php echo  $seguridad->obternerUrl("empleadosProcesar.php",array("id"=>$id,"tipo"=>1)) ?>" method="post" enctype="multipart/form-data">
	<div>
		<label>Empresa:</label>
		<select name="id_empresa">
			<option value="">Seleccione...</option>
			<?php
			$q = mysql_query("SELECT * FROM empresas ORDER BY empresa ASC");
			while($a = mysql_fetch_array($q) ){
				if( isset($row["id_empresa"]) && $row["id_empresa"] == $a["id_empresa"] ){
					echo '<option value="'.$a["id_empresa"].'" selected>'.$a["empresa"].'</option>';
				}else{
					echo '<option value="'.$a["id_empresa"].'">'.$a["empresa"].'</option>';
				}
			}
			?>
		</select>
	</div>
	<div>
		<label>Nombre:</label>
		<input type="text" name="nombre" value="<?php if(isset($row)){echo $row["nombre"];}?>" style="width:400px;" />
	</div>
	<div>
		<label>Apellido:</label>
		<input type="text" name="apellido" value="<?php if(isset($row)){echo $row["apellido"];}?>" style="width:400px;" />
	</div>
	<div>
		<label>Usuario:</label>
		<input type="text" name="user" value="<?php if(isset($row)){echo $row["user"];}?>" style="width:400px;" />
	</div>
	<?php
	if( isset($_GET["id"]) ){
	?>
	<div>
		<label>Clave:</label>
		<a href="<?php echo $seguridad->obternerUrl("empleadosCambiarClave.php",array("id"=>$id,"volver"=>1))?>">Cambiar clave</a>
	</div>
	<?php }else{?>
	<div>
		<label>Contraseña:</label>
		<input type="password" name="pass" value="<?php if(isset($row)){echo $row["pass"];}?>" style="width:400px;" />
	</div>
	<div>
		<label>Repetir Contraseña:</label>
		<input type="password" name="pass2" value="<?php if(isset($row)){echo $row["pass"];}?>" style="width:400px;" />
	</div>
	<?php } ?>
	<div>
		<label>Cantidad de Kits:</label>
		<input type="text" name="cantidad_kits" value="<?php if(isset($row)){echo $row["cantidad_kits"];}?>" style="width:400px;" />
	</div>
	<div>
		<label>Dirección entrega del premio:</label>
		<input type="text" name="direccion_entrega" value="<?php if(isset($row)){echo $row["direccion_entrega"];}?>" style="width:400px;" />
	</div>
	
	<div class="enviar">
		<input type="Submit" value="Cargar">
	</div>
</form>