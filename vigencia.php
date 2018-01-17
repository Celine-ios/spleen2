<?php 
session_start(); 
include("app/config.php");
$ob_user = new user();
$user = $ob_user->get_data_user();

$_title = "BeMarketing";
$_page = "vigencia";
include("_head_html.inc.php");
?>
	<div class="cont2">
		<div class="cont_kits">
			<?php include("_header.inc.php");?>
			<img id="pizarra_min" src="images/pizar1.png" alt="" />
			<div id="bg_confirm">
				<p>Sus créditos han caducado.</p>
			</div>
		</div>
	</div>
	
<script type="text/javascript" src="js/jquery.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="js/fixpng.js"></script>
<![endif]-->
</body>
</html>