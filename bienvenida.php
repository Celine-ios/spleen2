<?php 
session_start(); 
include("app/config.php");
$ob_user = new user();
$ob_user->check_vigencia();
$user = $ob_user->get_data_user();

$_title = "BeMarketing";
$_page = "";
include("_head_html.inc.php");
?>
<div id="table">
<div id="cell">
	<div class="cont">
		<div class="cont_bienvenida">
			<?php include("_header.inc.php");?>
			<img id="pizarra_min" src="images/pizar1.png" alt="" />
			<div id="text_bienvenida">
				<p><?php echo $user->descripcion; ?></p>
			</div>
			<a href="kits.php" id="btn_catalogo">ver catálago</a>
		</div>
	</div>
</div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="js/fixpng.js"></script>
<![endif]-->
</body>
</html>