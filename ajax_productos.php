<?php 
session_start(); 
include("app/config.php");
$obj_prod = new productos();
$id_category = $_GET["category"];

if( isset($_GET["_page"]) && !empty($_GET["_page"]) ){
	$_pagin_pagina_acutal = $_GET["_page"];
}else{
	$_pagin_pagina_acutal = 1;
}
$obj_prod->_pagi_actual = $_pagin_pagina_acutal;
$rows = $obj_prod->list_products($id_category);

$_pagin_paginas_totales = $obj_prod->_pagi_totalPags;


$_pagin_pagina_prev= $_pagin_pagina_acutal - 1;
$_pagin_pagina_next= $_pagin_pagina_acutal + 1;

$path_image = $obj_prod->path_image($id_category);
$cantidad = 30;
$count = 0;
?>
<div id="contents_products">
<?php
foreach($rows as $v){
	$count++;
?>
					<div class="products<?php if($count ==3 ){echo" sbr";$count = 0;}?>">
						<div class="cen_products<?php if($count ==4 || $count ==5 || $count==6){echo" sbb";}?>">
							<div class="cont_cen_products">
								<div class="products_image"><img src="images/productos/<?php echo $v->image;?>"<?php if($id_category == 4){echo' height="115"';}?> alt="" /></div>
								<div class="products_data">
									<div class="products_data_row">
										<div class="products_data_tit"><b><?php echo $v->codigo;?></b> - <?php echo utf8_encode($v->descripcion);?></div>
										<div class="products_data_creditos">
											<p>Cr&eacute;ditos</p>
											<div class="products_data_creditos_points"><?php echo $v->creditos;?></div>
										</div>
									</div>
									<div class="products_data_cantidad">
										Cant:
										<select id="cantidad_<?php echo $v->id_producto;?>">
										<?php
										for($x = 1;$x<=$cantidad;$x++){
											echo '<option>'.$x.'</option>';
										}
										?>
										</select>
									</div>
									<a class="btn4" href="javascript:void(0);" onclick="add_product(<?php echo $v->id_producto;?>)">Agregar</a>
								</div>
							</div>
						</div>
					</div>
<?php 
}
?>
				</div>
				<div id="pagincacion">
				<?php
				/*
				if( $_pagin_pagina_acutal > 1){
				?>
					<a href="javascript:void(0);" id="pagin_prev" onclick="next(<?php echo $id_category;?>,<?php echo $_pagin_pagina_prev;?>)">Anterior</a>
				<?php
				}
				if( $_pagin_pagina_acutal < $_pagin_paginas_totales){
				?>
					<a href="javascript:void(0);" id="pagin_next" onclick="next(<?php echo $id_category;?>,<?php echo $_pagin_pagina_next;?>)">Siguiente</a>
				<?php
				}
				*/
				?>
				</div>
