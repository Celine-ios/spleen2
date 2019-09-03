<?php

class seguridad {

  private $bd;
  public $estado;

  public function __construct( $bd ) {

    $this->bd = $bd;
    $this->estado = 0;
    
  }

  public function verificar() {

    /*********************************************************************************
	estado = 1 -- esta ok y muestro el admin
	estado = 2 -- Nok, no me llegaron los datos x post, muestro el login
	estado = 3 -- Nok, me llegaron mal los datos x post, muestro el login y aviso
     ***********************************************/
    if( !isset( $_SESSION[ 'wm_user' ] ) ) {
      if( isset( $_POST[ 'usuario' ] ) && isset( $_POST[ 'pass' ] ) ) {
        $logeo = new login();
        if( $logeo->ingresar( $_POST[ 'usuario' ], $_POST[ 'pass' ], $this->bd ) ) $this->estado = 1;
        else $this->estado = 3;
      } else {
        $this->estado = 2;
      }
    } else {
      $this->estado = 1;
    }
    
  }

  public function verificarSitio() {

    /*********************************************************************************
	estado = 1 -- esta ok y muestro el admin
	estado = 2 -- Nok, no me llegaron los datos x post, muestro el login
	estado = 3 -- Nok, me llegaron mal los datos x post, muestro el login y aviso
     ***********************************************/
    if( !isset( $_SESSION[ 'usuarioSitio' ] ) ) {
      if( isset( $_POST[ 'usuario' ] ) && isset( $_POST[ 'clave' ] ) ) {
        $logeo = new login();
        if( $logeo->ingresarSitio( $_POST[ 'usuario' ], $_POST[ 'clave' ], $this->bd ) ) $this->estado = 1;
        else $this->estado = 3;
      } else {
        $this->estado = 2;
      }
    } else {
      $this->estado = 1;
    }
    
  }

  public function estoyLogueado() {

    if( !isset( $_SESSION[ 'wm_user' ] ) ) {
      header( 'location: index.php' );
      exit();
    }
    
  }

  public function mysql_seguridad( $valor ) {

          $db_server = '127.0.0.1:3306';
          $db_user = 'root';


          $conex = mysqli_connect($db_server,$db_user);

    return mysqli_real_escape_string( $valor,$conex);
    
  }

  public function obternerUrl() {

    $link = $_SERVER[ 'PHP_SELF' ] . '?link=';
    $link .= base64_encode( func_get_arg( 0 ) );
    $num_args = func_num_args();
    if( func_num_args() == 2 ) $link .= '&' . $this->obtener_query( func_get_arg( 1 ) );
    /*for( $i=1; $i<$num_args; $i++ ){
			$link .= '&'.func_get_arg( $i ).'='.func_get_arg( ++$i );
		}*/
    return $link;
    
  }

  public function decodificarURL() {

    $include =( isset( $_GET[ 'link' ] ) ) ? base64_decode( $_GET[ 'link' ] ) : '_include-home.php';
    return $include;
    
  }

  public function obtener_query( $vec ) {

    $query = array();
    foreach( $vec as $clave => $valor ) {
      $query[] = $clave . '=' . $valor;
    }
    return implode( '&', $query );
    
  }
  
}

$seguridad = new seguridad( $bd );
?>