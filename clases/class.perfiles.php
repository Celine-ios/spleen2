<?php

class perfiles extends gral {

  private $bd;
  private $tipo;

  public function __construct( $bd ) {

    $this->bd = $bd;
    $this->tipo = (isset ( $_GET ["tipo"] )) ? $_GET ["tipo"] : 0;
  }

  public function obtenerDatos( $id ) {

    $sql = "SELECT * FROM abm_menus_perfil WHERE id_perfil = '" . $id . "'";
    $r = $this->bd->bbdd_query ( $sql );
    $row = $this->bd->bbdd_fetch ( $r );
    return $row;
  }

  public function procesar() {

    switch ($this->tipo) {
      case 1 :
        $this->cargarActualizarDatos ();
        break;
      case 2 :
        $this->borrarDatos ();
        break;
    }
  }

  public function cargarActualizarDatos() {

    if ($this->verificar ( $id )) {
      parent::error ( $this->error );
      return false;
    } else {
      if ($_GET ["id"]) {
        $sql = "UPDATE abm_menus_perfil SET descripcion_perfil = '" . $this->bd->bbdd_seguridad ( $_POST ["descripcion_perfil"] ) . "' WHERE id_perfil = '" . $_GET ["id"] . "'";
      } else {
        $sql = "INSERT INTO abm_menus_perfil (descripcion_perfil) VALUES ('" . $this->bd->bbdd_seguridad ( $_POST ["descripcion_perfil"] ) . "')";
      }
      
      $this->bd->bbdd_query ( $sql );
      
      parent::redireccionar ( "perfilesListar.php" );
    }
  }

  public function verificar() {

    include 'class.validaciones.php';
    $val = new validaciones ( $this->bd );
    
    if ($val->verifVacio ( $_POST ["descripcion_perfil"] )) $this->error .= "No completo el campo Nombre<br/>";
    
    if ($this->error != "") return true;
    else return false;
  }

  public function borrarDatos() {

    $sql = "DELETE FROM abm_menus_perfil WHERE id_perfil = '" . $_GET ["id"] . "'";
    $this->bd->bbdd_query ( $sql );
    parent::redireccionar ( "perfilesListar.php" );
  }
}
?>