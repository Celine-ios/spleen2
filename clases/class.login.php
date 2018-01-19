<?php

class login {

  private $bd;
  
  public function __construct() {
    
  }

  public function ingresar( $usuario, $pass, $bbdd ) {

    $this->bd = $bbdd;
    
    $sql = 'SELECT * FROM abm_usuario WHERE usuario = "' . $usuario . '" and clave = "' . md5 ( $pass ) . '"';
    $r = $this->bd->bbdd_query ( $sql );
    if ($this->bd->bbdd_num ( $r )) {
      $row = $this->bd->bbdd_fetch ( $r );
      $_SESSION ['wm_user'] = $usuario;
      $_SESSION ['wm_user_id'] = $row ['id_usuario'];
      $_SESSION ['wm_user_mail'] = $row ['email'];
      $_SESSION ['wm_user_id_perfil'] = $row ['id_perfil'];
      return true;
    } else {
		$q = mysql_query("SELECT * FROM usuarios WHERE usuario ='".$usuario."' AND pass='".md5($pass)."' AND tipo_usuario='1'");
		//$r2 = $this->bd->bbdd_query ( $q );
		if ($this->bd->bbdd_num ( $q )) {
			$row = $this->bd->bbdd_fetch ( $r );
			$_SESSION ['wm_user'] = $usuario;
			$_SESSION ['wm_user_id'] = "1";
			$_SESSION ['wm_user_mail'] = $row ['email'];
			$_SESSION ['wm_user_id_perfil'] = "1";
			return true;
		}else{
			return false;
		}
	}
  
  }

  public function ingresarSitio( $usuario, $pass, $bbdd ) {

    $this->bd = $bbdd;
    
    $sql = 'SELECT * FROM clientes WHERE usuario = "'.$usuario.'" and clave = MD5("'.$pass.'")';
    $r = $this->bd->bbdd_query ( $sql );
    if ($this->bd->bbdd_num ( $r )) {
      $row = $this->bd->bbdd_fetch ( $r );
      $_SESSION ['usuarioSitio'] = $row ['usuario'];
      $_SESSION ['usuarioSitio_id'] = $row ['id'];
      //$_SESSION['wm_user_mail']=$row['email'];
      //$_SESSION['wm_user_id_perfil']=$row['id_perfil'];
      return true;
    } else
      return false;
  }

  public function salir() {

    $_SESSION = array ();
    if (session_destroy ()) return true;
    else return false;
  }
  
}
?>