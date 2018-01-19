<?php 
include('_include-index.php');
include 'clases/class.menu2.php'; 
$menu = new menu2( $bd, $seguridad ); ?>
    
<div id="main">
<div id="copete">
	<span>Agregar/Modificar Empresas </span>
	<p>&nbsp;</p>
</div>
<?php 
$id = (isset($_GET["id"]))?$_GET["id"]:0;
include "clases/class.empresas.php";
$obj = new empresas($bd);
if($id){
	$row = $obj->obtenerDatos($id);
}

?>
<form name="carga" action="<?php echo  $seguridad->obternerUrl("empresasProcesar.php",array("id"=>$id,"tipo"=>1)) ?>" method="post" enctype="multipart/form-data">
	<div>
		<label>Nombre Empresa:</label>
		<input type="text" name="empresa" value="<?php if(isset($row)){echo $row["empresa"];}?>" style="width:400px;" />
	</div>
	<div>
		<label>Descripción:</label>
		<textarea name="descripcion"><?php if(isset($row)){echo $row["descripcion"];}?></textarea>
	</div>
	<div>
		<label>Crédito inicial:</label>
		<input type="text" name="credito_inicial" value="<?php if(isset($row)){echo $row["credito_inicial"];}?>" style="width:400px;" />
	</div>
	<div>
		<label>Fecha de Vencimeinto:</label>
		<input type="text" name="vencimiento" id="vencimiento" value="<?php if(isset($row)){echo $row["vencimiento"];}?>" style="width:100px;" maxlength="100" readonly="readonly" />
		&nbsp;<img src="images/ico-fecha.gif" id="fecha_nacimiento2" border="0" class="cal" />
		<script type="text/javascript"> 
		    Calendar.setup({
	        inputField     :    "vencimiento",     // id of the input field
	        ifFormat	   :    "%Y-%m-%d",      // format of the input field
	        button         :    "fecha_nacimiento2",  // trigger for the calendar (button ID)
	        align          :    "Tl",           // alignment (defaults to "Bl")
	        singleClick    :    true
		    });
		</script>
	</div>
	<div>		
		<label>Logo:</label>
		<input type="file" name="logo" value="<?php if( isset($row["logo"]) && !empty($row["logo"]) ){ $row["logo"];} ?>" />
		<?php 
		if( isset($row["logo"]) && !empty($row["logo"])) {
		echo ' &nbsp; &nbsp; <a href="'.$seguridad->obternerUrl("empresasProcesar.php", array("id"=>$row["id_empresa"], "tipo"=>3)).'" onclick="return SEGURIDAD.verifBorrar();"><img src="images/ico-borrar.gif"/></a>
		<br /><br />
		<div align="center"><img src="../images/empresas/'.$row["logo"].'" border="0" /></div>'; }
		
		?>
	</div>
	
	<div class="enviar">
		<input type="Submit" value="Cargar">
	</div>
</form>