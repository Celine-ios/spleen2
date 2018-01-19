<?php

class ordenar {

  public function obtenerPos( $ord ) {

    $pos = ($ord == "asc") ? "<" : ">";
    return $pos;
  }

  public function obtenerOrd( $ord ) {

    $pos = ($ord == "asc") ? "desc" : "asc";
    return $pos;
  }

  public function ordenarRegistros( $pos, $id, $id2, $bd, $tabla, $nombreId ) {

    $sql = "UPDATE " . $tabla . " SET orden = '" . $id2 [1] . "' WHERE " . $nombreId . "='" . $id . "'";
    $bd->bbdd_query ( $sql );
    $sql = "UPDATE " . $tabla . " SET orden = '" . $pos . "' WHERE " . $nombreId . "='" . $id2 [0] . "'";
    $bd->bbdd_query ( $sql );
  }

  public function redireccionar( $url, $bd ) {

    $seg = new seguridad ( $bd );
    $url = $seg->obternerUrl ( $url );
    ?>
<script>
			window.location.href='<?php echo $url?>';
		</script>
<?php
  }
}
?>

<?php

class ordenarMenu extends ordenar {

  var $bd;

  var $id;

  public function ordenarMenu( $bd ) {

    $this->bd = $bd;
    $this->id = array ();
    $this->id = $this->obtenerIdDelOtroRegistro ( $_GET ["ord"], $_GET ["pos"], $_GET ["idPadre"] );
    parent::ordenarRegistros ( $_GET ["pos"], $_GET ["id"], $this->id, $this->bd, "abm_menus", "id_menu" );
    parent::redireccionar ( "menuListar.php", $this->bd );
  }

  public function obtenerIdDelOtroRegistro( $ord, $pos, $idPadre ) {

    $sql = "SELECT id_menu, orden FROM abm_menus WHERE orden " . parent::obtenerPos ( $ord ) . " '" . $pos . "' and id_padre = '" . $idPadre . "' and publico = '1' ORDER BY orden " . parent::obtenerOrd ( $ord ) . " LIMIT 1";
    $r = $this->bd->bbdd_query ( $sql );
    list ( $id [0], $id [1] ) = $this->bd->bbdd_fetch ( $r );
    return $id;
  }
}
?>

<?php

class ordenarDepositos extends ordenar {

  var $bd;

  var $id;

  public function ordenarRegistros( $pos, $id, $id2, $bd, $tabla, $nombreId ) {

    $sql = "UPDATE " . $tabla . " SET orden = '" . $id2 [1] . "' WHERE " . $nombreId . "='" . $id . "'";
    $bd->bbdd_query ( $sql );
    $sql = "UPDATE " . $tabla . " SET orden = '" . $pos . "' WHERE " . $nombreId . "='" . $id2 [0] . "'";
    $bd->bbdd_query ( $sql );
  }

  public function ordenarDepositos( $bd ) {

    $this->bd = $bd;
    $this->id = array ();
    $this->id = $this->obtenerIdDelOtroRegistro ( $_GET ["ord"], $_GET ["pos"], $_GET ["idPadre"] );
    
    $sql = "UPDATE zona_deposito_reenvio SET orden_paso = '" . $this->id [1] . "' WHERE cod_deposito_destino = '" . $_GET ["idPadre"] . "' AND cod_deposito = '" . $_GET ["id"] . "'";
    $bd->bbdd_query ( $sql );
    $sql = "UPDATE zona_deposito_reenvio SET orden_paso = '" . $_GET ["pos"] . "' WHERE cod_deposito_destino = '" . $_GET ["idPadre"] . "' AND cod_deposito = '" . $this->id [0] . "'";
    $bd->bbdd_query ( $sql );
    
    parent::redireccionar ( "depositoReenvioListar.php", $this->bd );
  }

  public function obtenerIdDelOtroRegistro( $ord, $pos, $idPadre ) {

    $sql = "SELECT cod_deposito, orden_paso FROM zona_deposito_reenvio WHERE orden_paso " . parent::obtenerPos ( $ord ) . " '" . $pos . "' and cod_deposito_destino = '" . $idPadre . "' ORDER BY orden_paso " . parent::obtenerOrd ( $ord ) . " LIMIT 1";
    $r = $this->bd->bbdd_query ( $sql );
    list ( $id [0], $id [1] ) = $this->bd->bbdd_fetch ( $r );
    return $id;
  }
}
?>