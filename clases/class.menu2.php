<?php

class menu2 {
  
	private $bd;
	private $seg;
	
	public function __construct( $bd, $seguridad ) {
	  
		$this->bd = $bd;
		$this->seg = $seguridad; ?>
		<div id="menu">
			<div class="sub"><?php $this->cargarMenu(); ?></div>
			<div class="sub" id="opciones"><?php $this->mostrarOpciones(); ?></div>
		</div><?php
		
	}
	
	public function cargarMenu() {
  	if( !isset( $_SESSION[ 'wm_user_id' ] ) ) return false; ?>
  	
		<ul id="menu"><?php
			//permisos de este usuario
			$sql = 'SELECT id_menu FROM abm_permisos WHERE id_usuario = "' . $_SESSION[ 'wm_user_id' ] . '"';
			
			$r = $this->bd->bbdd_query($sql);
			
			$permisos = array();
			
			while( list( $permisos[] ) = $this->bd->bbdd_fetch( $r ) );
			
			array_pop( $permisos );
			
			$sql = 'SELECT * FROM abm_menus WHERE id_padre = "0" order by orden asc';
			$sql = 'SELECT * FROM abm_menus m 
					INNER  JOIN abm_menus_permisos mp ON m.id_menu = mp.idMenu && mp.idPermiso = "' . $_SESSION[ 'wm_user_id_perfil' ] . '"
					WHERE id_padre = "0" order by orden asc';
			//echo $sql;
			
			$r = $this->bd->bbdd_query($sql);
			
			$cant = 1;
			$ids = array();
			
			while( $row = $this->bd->bbdd_fetch( $r ) ){
			  
				$link = isset( $row[ 'referencia' ]{ 0 } ) ? $this->seg->obternerUrl( $row[ 'referencia' ] ) : '#';
				
				if( in_array( $row[ 'id_menu' ], $permisos ) ) { ?>
					<li><a href="<?php echo $link; ?>" class="mop" id="op_<?php echo $cant; ?>"><?php echo $row[ 'nombre' ]; ?></a></li><?php
					$ids[] = $row[ 'id_menu' ];
					$cant++;
				}
				
			} ?>
		</ul><?php
		
		$cant = 1;
		
		foreach( $ids as $id ) {
		  
			$sql = 'SELECT * FROM abm_menus m 
					INNER  JOIN abm_menus_permisos mp ON m.id_menu = mp.idMenu && mp.idPermiso = "' . $_SESSION[ 'wm_user_id_perfil' ] . '"
					WHERE id_padre = "' . $id . '" ORDER BY orden ASC';
			
			$r = $this->bd->bbdd_query( $sql );
			
			if( $this->bd->bbdd_num( $r ) ) { ?>
				<div class="dop" id="op<?php echo $cant; ?>">
					<ul><?php
					
    				while( $row = $this->bd->bbdd_fetch( $r ) ) {
    					if( in_array( $row[ 'id_menu' ], $permisos ) ) { ?>
						    <li>
                  <a href="<?php echo $this->seg->obternerUrl( $row[ 'referencia' ] ); ?>">
                  &nbsp;<img src="images/iconosMenu/<?php if( empty( $row[ 'icono' ] ) ) echo 'spacer.gif'; else echo $row[ 'icono' ]; ?>" alt="" width="16" height="16" />&nbsp;<?php echo $row[ 'nombre' ]; ?></a></li><?php
					    }
				    } ?>
					</ul>
				</div><?php
			}
			
			$cant++;
			
		}
		
	}
	
	public function mostrarOpciones() {
	  
    if( !isset( $_SESSION[ 'blog_user' ] ) ) return false; ?>
  
<!--		<a href=""><img src="images/ico-mail-op.gif" title="Ver mensajes privados"/></a>
		<a href=""><img src="images/ico-user-op.gif" title="Ver mis opciones "/></a>-->
		&nbsp;
		<?php echo $_SESSION[ 'blog_user' ]; ?>
		&nbsp;&nbsp;<strong>[<a href="<?php echo $this->seg->obternerUrl( '_include-salir.php'); ?>" title="Logout">LOGOUT</a>]</strong>&nbsp;&nbsp;<?php
		
	}
	
}
?>