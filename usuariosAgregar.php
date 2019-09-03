<?php 
include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
<div id="main">
<div id="copete">
	<span>Agregar/Modificar usuario</span>
	<p>&nbsp;</p>
</div>
<?php

if(isset($_GET["id"])){
$id = $_GET["id"];
}else{
$id = 0;
}
include "clases/class.usuarios.php";
$usu = new usuarios($bd);
if($id){
	$row = $usu->obtenerUsuario($id);
}


?>
<form action="<?php echo $seguridad->obternerUrl("usuariosProcesar.php",array("id"=>$id,"tipo"=>1))?>" method="POST">
	<div>
		<label>Usuario:</label>
		<?php if($id){?>
		<?php echo $row["usuario"]?>
		<?php }else{?>
		<input type="text" name="usuario" value="<?php if(isset($atras["usuario"])){echo $atras["usuario"];}?>" maxlength="20"/>
		<?php }?>
	</div>
	<?php
	if(!$id){
	?>
	<div>
		<label>Clave:</label>
		<input type="Password" name="clave1" value="" maxlength="10"/>
	</div>
	<div>
		<label>Repetir Clave:</label>
		<input type="Password" name="clave2" value="" maxlength="10"/>
	</div>
	<?php }else{?>
	<div>
		<label>Clave:</label>
		<a href="<?php echo $seguridad->obternerUrl("usuariosCambiarClave.php",array("id"=>$id,"volver"=>1))?>">Cambiar clave</a>
	</div>
	<?php } ?>
	<div>
		<label>Email:</label>
		<input type="text" name="email" value="<?php echo (isset($atras["email"]))?$atras["email"]:$row["email"]?>" maxlength="255"/>
	</div>
	<div>
		<label>Email alternativo:</label>
		<input type="text" name="email_alt" value="<?php echo (isset($atras["email_alt"]))?$atras["email_alt"]:$row["email_alt"]?>" maxlength="255"/>
	</div>
	<div>
		<label>Nombre:</label>
		<input type="text" name="nombre" value="<?php echo (isset($atras["nombre"]))?$atras["nombre"]:$row["nombre"]?>" maxlength="100"/>
	</div>
	<div>
		<label>Apellido:</label>
		<input type="text" name="apellido" value="<?php echo (isset($atras["apellido"]))?$atras["apellido"]:$row["apellido"]?>" maxlength="100"/>
	</div>
	<div>
		<label>Sexo:</label>
		<select name="sexo">
			<option value="f" <?php if($row["sexo"]=="f" || $atras["sexo"]=="f"){?>selected="selected"<?php }?>>Femenino</option>
			<option value="m" <?php if($row["sexo"]=="m" || $atras["sexo"]=="m"){?>selected="selected"<?php }?>>Masculino</option>
		</select>
	</div>
	<div>
		<label>Nacimiento:</label>
		<input type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $row["fecha_nacimiento"]?>" maxlength="100" readonly="readonly"/>&nbsp;<img src="images/ico-fecha.gif" id="fecha_nacimiento2" border="0" class="cal";/>
		<script type="text/javascript">
		    Calendar.setup({
	        inputField     :    "fecha_nacimiento",     // id of the input field
	        ifFormat	   :    "%Y%m%d",      // format of the input field
	        button         :    "fecha_nacimiento2",  // trigger for the calendar (button ID)
	        align          :    "Tl",           // alignment (defaults to "Bl")
	        singleClick    :    true
		    });
		</script>
	</div>	
	<div>
		<label>Tel fijo:</label>
		<input type="text" name="tel_fijo" value="<?php echo (isset($atras["tel_fijo"]))?$atras["tel_fijo"]:$row["tel_fijo"]?>" maxlength="16"/>
	</div>
	<div>
		<label>Fax:</label>
		<input type="text" name="tel_fax" value="<?php echo (isset($atras["tel_fax"]))?$atras["tel_fax"]:$row["tel_fax"]?>" maxlength="16"/>
	</div>
	<div>
		<label>Celular:</label>
		<input type="text" name="tel_cel" value="<?php echo (isset($atras["tel_celu"]))?$atras["tel_celu"]:$row["tel_celu"]?>" maxlength="16"/>
	</div>
	<div>
		<label>Perfil:</label>
		<?php
		$sql = "SELECT * FROM abm_menus_perfil ORDER BY descripcion_perfil DESC";
		$r = $bd->bbdd_query($sql);
		?>
		<select name="id_perfil">
			<option value="0">Elegir...</option>
		<?php
		while($row2 = $bd->bbdd_fetch($r)){
		?>
			<option value="<?php echo $row2["id_perfil"]?>" <?php if($row2["id_perfil"]==$row["id_perfil"] || $atras["id_perfil"]==$row2["id_perfil"]){?>selected="selected"<?php }?>><?php echo $row2["descripcion_perfil"]?></option>
		<?php }?>
		</select>
	</div>
	<div>
		<label>Permisos:</label>
		<div class="opciones">
			<?php $usu->obtenerPermisos($id);?>
		</div>
	</div>
	<div class="enviar">
		<input type="Submit" value="Cargar">
	</div>
</form>