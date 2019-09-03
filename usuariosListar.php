
<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
		<div id="copete">
	<span>Usuarios</span>
	<p>&nbsp;</p>
</div>
<p class="agregar"><a href="<?php echo $seguridad->obternerUrl("usuariosAgregar.php")?>"><img src="images/ico-agregar.gif" border="0"/></a>&nbsp;&nbsp;<a href="<?php echo $seguridad->obternerUrl("usuariosAgregar.php")?>">Agregar</a></p>
<table class="listados" cellpadding="0" cellspacing="0">
	<tr class="cabecera">
		<td>Usuario</td>
		<td>Mail</td>
		<td class="delmod">&nbsp;</td>
		<td class="delmod">&nbsp;</td>
	</tr>
	<?php 
	$sql = "SELECT  * FROM abm_usuario ORDER  BY id_usuario DESC";
	$r = $bd->bbdd_query($sql);
	$i=0;
	while($row = $bd->bbdd_fetch($r)){
	?>
	<tr class="<?php if($i%2){?>oscuro<?php }else{?>claro<?php }?>">
		<td><?php echo $row["usuario"]?></td>
		<td><?php echo $row["email"]?></td>
		<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("usuariosAgregar.php",array("id"=>$row["id_usuario"]))?>"><img src="images/ico-editar.gif"/></a></td>
		<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("usuariosProcesar.php",array("id"=>$row["id_usuario"],"tipo"=>2))?>" onclick="return SEGURIDAD.verifBorrar();"><img src="images/ico-borrar.gif"/></a></td>
	</tr>
	<?php 
		$i++;
	}
	if(!$bd->bbdd_num($r)){
	?>
	<tr>
		<td colspan="4">No ingreso ningún usuario aún.</td>					
	</tr>
	<?php }?>
</table>
