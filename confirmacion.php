<?php 
session_start(); 
include("app/config.php");
$ob_user = new user();
$ob_user->check_vigencia();
$user = $ob_user->get_data_user();

$_title = "BeMarketing";
$_page = "confirm";
include("_head_html.inc.php");
?>
	<div class="cont2">
		<div class="cont_kits">
			<?php include("_header.inc.php");?>
			<img id="pizarra_min" src="images/pizar1.png" alt="" />
			<div id="bg_confirm">
				<p>Su Kit ha sido cargado exitosamente.<br /> Por cualquier duda o consulta, por favor comunicarse al 5811 4400 de 9 a 18hs.</p>
			</div>
		</div>
	</div>
<?php 
$ob_user->confirma_pedido();
?>
<script type="text/javascript" src="js/jquery.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="js/fixpng.js"></script>
<![endif]-->
</body>
</html>