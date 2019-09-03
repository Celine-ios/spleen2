<?php 
include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
<div id="main">
<div id="copete">
	<span>Agregar/Modificar Productos </span>
	<p>&nbsp;</p>
</div>
<?php 
$id = (isset($_GET["id"]))?$_GET["id"]:0;
include "clases/class.productos.php";
$obj = new productos($bd);
if($id){
	$row = $obj->obtenerDatos($id);
}

?>
<form name="carga" action="<?php echo  $seguridad->obternerUrl("productosProcesar.php",array("id"=>$id,"tipo"=>1)) ?>" method="post" enctype="multipart/form-data">
	<div>
		<label>Producto:</label>
		<input type="text" name="descripcion" value="<?php if(isset($row)){echo $row["descripcion"];}?>" style="width:400px;" />
	</div>
	<div>
		<label>Créditos:</label>
	<?php
	$coubtp = 0;
	if( isset($_GET["id"])   ){
		$q = mysql_query("SELECT id_orden FROM carrito WHERE id_producto='".$_GET ["id"]."'");
		$coubtp = mysql_num_rows($q);
	}
	if( $coubtp > 0 ){
	?>
		<input type="text" name="creditos_d" value="<?php if(isset($row)){echo $row["creditos"];}?>" style="width:400px;" disabled />
		<input type="hidden" name="creditos" value="<?php if(isset($row)){echo $row["creditos"];}?>"  />
	<?php
	}else{
	?>
		<input type="text" name="creditos" value="<?php if(isset($row)){echo $row["creditos"];}?>" style="width:400px;" />
	<?php
	}
	?>
	</div>
	<div>
		<label>Código:</label>
		<input type="text" name="codigo" value="<?php if(isset($row)){echo $row["codigo"];}?>" style="width:400px;" />
	</div>
	<div>
		<label>Categoria:</label>
		<select name="id_categoria">
			<option value="">Seleccione</option>
			<?php
			$q = mysql_query("SELECT * FROM categorias");
			while( $a = mysql_fetch_array($q) ){
				if( isset($row) && $row["id_categoria"] == $a["id_categoria"]  ){
					echo '<option value="'.$a["id_categoria"].'" selected>'.$a["categoria"].'</option>';
				}else{
					echo '<option value="'.$a["id_categoria"].'">'.$a["categoria"].'</option>';
				}
			}
			?>
		</select>
	</div>
	<div>		
		<label>Imágen:</label>
		<input type="file" name="image" value="<?php if( isset($row["image"]) && !empty($row["image"]) ){ $row["image"];} ?>" />
		<?php 
		if( isset($row["image"]) && !empty($row["image"])) {
		echo '
		<br /><br />
		<div align="center"><img src="../images/productos/'.$row["image"].'" border="0" /></div>'; 
		}
		
		?>
	</div>
	<div>		
		<label>Activo:</label>
		<input type="checkbox" name="state" value="1" <?php if( isset($row["state"]) && $row["state"]==1 ){ echo " checked";} ?> />
	</div>
	
	<div class="enviar">
		<input type="Submit" value="Cargar">
	</div>
</form>