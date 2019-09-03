<?php

class gral {
  public $errr;
  private $paginaIndex = 'index.php?link=';

  public function __construct() {

    $this->paginaIndex = 'index.php?link=';
    
  }

  public function redireccionar() {

    $query = base64_encode( func_get_arg( 0 ) );
    if( func_num_args() == 2) {
      $aux = func_get_arg( 1 );
      foreach( $aux as $clave => $valor )
        $query .= '&' . $clave . '=' . $valor;
    }
    
    header( 'location: ' . $this->paginaIndex . $query );
    
  }

  public function error( $texto ) { 
	$html='<div id="error">
      <strong>Errores:</strong><br />'.$texto.'
		</div>
    <form>
      <div class="enviar">
       <input type="button" value="Volver" onclick="window.history.back();" />
      </div>
    </form>';
    $this->errr=$html;
  }

  public function validate_email_format( $email ) {

    if( !preg_match( '/^(.+)@[a-zA-Z0-9-] +\.[a-zA-Z0-9.-] +$/si', $email ) || strpos( $email, ' ' ) !== false ) {
      return false;
    } else {
      return true;
    }
    
  }

  public function verArray( $matriz ) {

    echo '<pre>';
    print_r( $matriz );
    echo '</pre>';
    
  }

}
?>