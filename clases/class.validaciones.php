<?php

class validaciones {

  private $bd;

  public function __construct( $bd ) {

    $this->bd = $bd;
  }

  /****************
	validaciones grales
   *****************/
  public function verifVacio( $dato ) {

    return ($dato == "");
  }

  public function verifSelect( $dato ) {

    return ($dato == '0');
  }

  public function verifEnteroPositivo( $valor ) {

    if (strlen ( $valor ) == 1 && intval ( ord ( $valor ) ) == 48) {return false;}
    
    for($i = 0; $i < strlen ( $valor ); $i ++) {
      $ascii = ord ( $valor [$i] );
      if (intval ( $ascii ) >= 48 && intval ( $ascii ) <= 57) continue;
      else return false;
    }
    return true;
  }

  public function verifEnteroPositivoConCero( $valor ) {

    for($i = 0; $i < strlen ( $valor ); $i ++) {
      $ascii = ord ( $valor [$i] );
      if (intval ( $ascii ) >= 48 && intval ( $ascii ) <= 57) continue;
      else return false;
    }
    return true;
  }

  public function verifExiste( $valor ) {

    return isset ( $_POST [$valor] );
  }

  /*********************
	verificacion usuario
   *********************/
  
  public function verifPass( $pass1, $pass2 ) {

    return ($pass1 != $pass2);
  }

  public function verifUsuario( $usuario ) {

    $sql = "SELECT * FROM abm_usuario WHERE usuario = '" . $usuario . "'";
    $r = $this->bd->bbdd_query ( $sql );
    return $this->bd->bbdd_num ( $r );
  }
}
?>