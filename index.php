<?php 
session_start(); 
include("app/config.php");
if( isset($_POST["log_user"]) &&  isset($_POST["log_pass"]) ){
	$ob_user = new user();
	$resp = $ob_user->login($_POST["log_user"],$_POST["log_pass"]);
}
$_title = "BeMarketing";
$_page = "";
include("_head_html.inc.php");
?>
<div id="table">
<div id="cell">
	<div class="cont">
		<div class="cont_login">
			<div id="pizarra">
				<form method="post" action="">
					<input type="text" name="log_user" id="inp1" />
					<input type="password" name="log_pass" id="inp2" />
					<input type="submit" name="" value="" id="btn1" />
				</form>
			</div>
			<?php
			if( isset($resp) && !empty($resp ) ){
			?>
			<div id="resp_login">El usuario y/o la contraseña no son correctos.</div>
			<?php
			}
			?>
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