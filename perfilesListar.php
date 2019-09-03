<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
		<div id="copete">
	<span>Perfiles</span>
	<p>&nbsp;</p>
</div>
<p class="agregar"><a href="<?php echo $seguridad->obternerUrl("perfilesAgregar.php")?>"><img src="images/ico-agregar.gif" border="0"/></a>&nbsp;&nbsp;<a href="<?php echo $seguridad->obternerUrl("perfilesAgregar.php")?>">Agregar</a></p>
<table class="listados" cellpadding="0" cellspacing="0">
	<tr class="cabecera">
		<td>Nombre perfil</td>
		<td class="delmod">&nbsp;</td>
		<td class="delmod">&nbsp;</td>
	</tr>
	<?php 
	$sql = "SELECT * from abm_menus_perfil ORDER BY descripcion_perfil ASC";
	$r = $bd->bbdd_query($sql);
	$i=0;
	while($row = $bd->bbdd_fetch($r)){
	?>
		<tr class="<?php if($i%2){?>oscuro<?php }else{?>claro<?php }?>">
			<td><?php echo $row["descripcion_perfil"]?></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("perfilesAgregar.php",array("id"=>$row["id_perfil"]))?>"><img src="images/ico-editar.gif"/></a></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("perfilesProcesar.php",array("id"=>$row["id_perfil"],"tipo"=>2))?>" onclick="return SEGURIDAD.verifBorrar();"><img src="images/ico-borrar.gif"/></a></td>
		</tr>		
	<?php 
		$i++;
	}
	if(!$bd->bbdd_num($r)){
	?>
	<tr>
		<td colspan="3">No ingreso ningún perfil.</td>					
	</tr>
	<?php }?>
</table>