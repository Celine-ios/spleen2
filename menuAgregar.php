<?php 
include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
<div id="main">
<div id="copete">
	<span>Agregar/Modificar menús</span>
	<p>&nbsp;</p>
</div>
<?php
$id = (isset($_GET["id"]))?$_GET["id"]:0;
include "clases/class.menu.php";
$menu = new menu($bd);
if($id){
	$row = $menu->obtenerMenu($id);
}


?>
<form action="<?php echo $seguridad->obternerUrl("menuProcesar.php",array("id"=>$id,"tipo"=>1))?>" method="POST">
	<div>
		<label>Nombre:</label>
		<input type="text" name="nombre" value="<?php  if(isset($row)){echo $row["nombre"];}?>"/>
	</div>
	<div>
		<label>Referencia:</label>
		<input type="text" name="referencia" value="<?php  if(isset($row)){echo $row["referencia"];}?>"/>
	</div>
	
	<div>
		<label>Icono:</label>
		<input type="text" name="icono" value="<?php  if(isset($row)){echo $row["icono"];}?>"/>
	</div>
	
	<div>
		<label>Padre:</label>
		<select name="id_padre">
			<option value="0" <?php if(isset($row["id_padre"])){?>selected="selected"<?php }?>>Ninguno</option>
			<?php
			$sql = "SELECT * FROM abm_menus WHERE id_padre = '0' and publico = '1' ORDER BY nombre ASC";
			$r2 = $bd->bbdd_query($sql);
			while($row2 = $bd->bbdd_fetch($r2)){
			?>
				<option value="<?php if(isset($row2)){echo $row2["id_menu"];}?>" <?php if(isset($row2) && isset($row)){if($row2["id_menu"] == $row["id_padre"] ){?>selected="selected"<?php }}?>><?php echo $row2["nombre"];?></option>
			<?php }?>
		</select>
	</div>
	<div>
		<label>Perfil:</label>
		<?php
		if(isset($row)){
			$sql = "SELECT idPermiso FROM abm_menus_permisos WHERE idMenu = '".$row["id_menu"]."'";
			$r = $bd->bbdd_query($sql);
			$p = array();
			while($roww = $bd->bbdd_fetch($r)){
				$p[] = $roww["idPermiso"];
			}
		}	
		?>
		<select name="id_permiso[]" multiple="multiple">
			<?php
			$sql = "SELECT id_perfil,descripcion_perfil FROM abm_menus_perfil ORDER BY descripcion_perfil ASC";
			$r2 = $bd->bbdd_query($sql);
			$menus = array();
			while(list($clave,$valor) = $bd->bbdd_fetch($r2)){
			?>
			<option value="<?php echo $clave?>" <?php if(isset($row)){ if(in_array($clave, $p)){?>selected="selected"<?php }}?>><?php echo $valor?></option>
			<?php }?>
		</select>
	</div>
	<div class="enviar">
		<input type="Submit" value="Cargar">
	</div>
</form>