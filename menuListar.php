<?php 
include('_include-index.php');	
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
		<div id="main">
		<div id="copete">
	<span>Menús</span>
	<p>&nbsp;</p>
</div>
<p class="agregar"><a href="<?php echo $seguridad->obternerUrl("menuAgregar.php")?>"><img src="images/ico-agregar.gif" border="0"/></a>&nbsp;&nbsp;<a href="<?php echo $seguridad->obternerUrl("menuAgregar.php")?>">Agregar</a> <a href="<?php echo $seguridad->obternerUrl("perfilesListar.php")?>"><img src="images/ico-agregar.gif" border="0"/></a>&nbsp;&nbsp;<a href="<?php echo $seguridad->obternerUrl("perfilesListar.php")?>">Perfiles</a></p>
<table class="listados" cellpadding="0" cellspacing="0">
	<tr class="cabecera">
		<td class="delmod">&nbsp;</td>
		<td class="delmod">&nbsp;</td>
		<td>Menú</td>
		<td class="delmod">&nbsp;</td>
		<td class="delmod">&nbsp;</td>
	</tr>
	<?php 
	$sql = "SELECT * from abm_menus WHERE id_padre = '0' and publico = '1' ORDER BY orden ASC";
	$r = $bd->bbdd_query($sql);
	$i=0;
	$tot = $bd->bbdd_num($r);
	$tot--;
	while($row = $bd->bbdd_fetch($r)){
	?>
		<tr class="claro">
			<td class="delmod"><?php if($i!=0){?><a href="<?php echo $seguridad->obternerUrl("menuProcesar.php",array("ord"=>"asc","id"=>$row["id_menu"],"pos"=>$row["orden"],"idPadre"=>$row["id_padre"]))?>"><img src="images/arriba.gif" title="Subir"/></a><?php }else{?>&nbsp;<?php }?></td>
			<td class="delmod"><?php if($i!=$tot){?><a href="<?php echo $seguridad->obternerUrl("menuProcesar.php",array("ord"=>"desc","id"=>$row["id_menu"],"pos"=>$row["orden"],"idPadre"=>$row["id_padre"]))?>"><img src="images/abajo.gif" title="Bajar"/></a><?php }else{?>&nbsp;<?php }?></td>
			<td><?php echo $row["nombre"]?></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("menuAgregar.php",array("id"=>$row["id_menu"]))?>"><img src="images/ico-editar.gif"/></a></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("menuProcesar.php",array("id"=>$row["id_menu"],"tipo"=>2))?>" onclick="return SEGURIDAD.verifBorrar();"><img src="images/ico-borrar.gif"/></a></td>
		</tr>
		<?php 
		$sql = "SELECT * from abm_menus WHERE id_padre = '".$row["id_menu"]."' ORDER BY orden ASC";
		$r2 = $bd->bbdd_query($sql);
		$tot2 = $bd->bbdd_num($r2);
		$tot2--;
		$t = 0;
		while($row2 = $bd->bbdd_fetch($r2)){
		?>
		<tr class="oscuro">
			<td class="delmod"><?php if($t!=0){?><a href="<?php echo $seguridad->obternerUrl("menuProcesar.php",array("ord"=>"asc","id"=>$row2["id_menu"],"pos"=>$row2["orden"],"idPadre"=>$row2["id_padre"]))?>"><img src="images/arriba.gif" title="Subir"/></a><?php }else{?>&nbsp;<?php }?></td>
			<td class="delmod"><?php if($t!=$tot2){?><a href="<?php echo $seguridad->obternerUrl("menuProcesar.php",array("ord"=>"desc","id"=>$row2["id_menu"],"pos"=>$row2["orden"],"idPadre"=>$row2["id_padre"]))?>"><img src="images/abajo.gif" title="Bajar"/></a><?php }else{?>&nbsp;<?php }?></td>
			<td>&nbsp;&nbsp;&nbsp;<?php echo $row2["nombre"]?></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("menuAgregar.php",array("id"=>$row2["id_menu"]))?>"><img src="images/ico-editar.gif"/></a></td>
			<td class="delmod"><a href="<?php echo $seguridad->obternerUrl("menuProcesar.php",array("id"=>$row2["id_menu"],"tipo"=>2))?>" onclick="return SEGURIDAD.verifBorrar();"><img src="images/ico-borrar.gif"/></a></td>
		</tr>
	<?php 
		$t++;
		}
		$i++;
	}
	if(!$bd->bbdd_num($r)){
	?>
	<tr>
		<td colspan="6">No ingreso ningún menú aún.</td>					
	</tr>
	<?php }?>
</table>