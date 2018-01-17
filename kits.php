<?php 
session_start(); 
include("app/config.php");
$ob_user = new user();
$ob_user->check_vigencia();
$user = $ob_user->get_data_user();
if( isset($_GET["category"] ) && !empty($_GET["category"]) ){
	$category = $_GET["category"];
}else{
	$category = 1;
}	
$_title = "BeMarketing";
$_page = "";
include("_head_html.inc.php");
?>
	<div class="cont2">
		<div class="cont_kits">
			<?php include("_header.inc.php");?>
			<img id="pizarra_min" src="images/pizarr_cate<?php echo $category;?>.png" alt="" />
			<div id="bg_kits">
			</div>
		</div>
	</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
   $("#bg_kits").load("ajax_productos.php?category=<?php echo $category;?>");
});

function next( category , page){
   $("#bg_kits").load("ajax_productos.php?category="+category+"&_page="+page);
}
function add_product(x){
	var cantidad = $("#cantidad_"+x).val();
	$.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"ajax_add.php",
        data:"id_producto="+x+"&catidad="+cantidad,
        success:res,
        timeout:4000,
        error:problemas
    });	 
}
function problemas(){
	alert("error");
}
function res(x){
	switch(x){
		case "1":
			refresh_credits();
			alert("Se ha agregado el producto al carrito.");
		break;
		case "0":
			alert("No posee crédito disponible para agregar este producto.");
		break;
	}
}
function refresh_credits(){
	$("#ajax_creditos").load("ajax_puntos.php");
}
</script>
<!--[if IE 6]>
<script type="text/javascript" src="js/fixpng.js"></script>
<![endif]-->
</body>
</html>