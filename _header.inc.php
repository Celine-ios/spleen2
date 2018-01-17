			<div id="header">
				<?php
				if( isset( $user->logo ) && !empty( $user->logo ) ){
				?>
				<a href="bienvenida.php"><img src="images/empresas/<?php echo $user->logo;?>" id="logo" alt="" /></a>
				<?php
				}
				?>
				<div class="text_user"><img src="images/t1.png" alt="" /> <span><?php echo $user->nombre." ".$user->apellido;?></span></div>
				<div class="text_vigencia_puntos">Vigencia: <?php echo $user->vencimiento;?></div>
				<div class="puntos" id="ajax_creditos"><?php echo $user->creditos_r;?></div>
				<?php
				if( $_page <> "vigencia" ){
				?>
				<a href="carrito.php" id="btn_carrito">Tu Kit Escolar</a>
				<?php
				}
				?>
				<?php
				if( $_page == "carrito" ){
				?>
				<img src="images/tit_carrito.jpg" alt="" id="tit_carrito" />
				<?php
				}
				?>
				<?php
				if( $_page <> "confirm" && $_page <> "carrito"  && $_page <> "vigencia"  ){
				?>
				<div id="categorias">
					<a href="kits.php?category=1" id="c1">Kits Preescolar<br /> 1 y 2º grado</a>
					<a href="kits.php?category=2" id="c2">Kits Primaria<br /> 3º a 7º grado</a>
					<a href="kits.php?category=3" id="c3">Kits<br /> Secundaria</a>
					<a href="kits.php?category=4" id="c4">Mochilas</a>
				</div>
				<?php
				}
				?>
			</div>