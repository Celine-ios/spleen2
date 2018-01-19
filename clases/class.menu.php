<?php

class menu extends gral {

  private $bd;
  private $tipo;

  public function __construct( $bd ) {

    $this->bd = $bd;
    $this->tipo = (isset ( $_GET ["tipo"] )) ? $_GET ["tipo"] : 0;
  }

  public function procesar() {

    switch ($this->tipo) {
      case 0 :
        $this->ordenar ();
        break;
      case 1 :
        $this->cargarMenu ();
        break;
      case 2 :
        $this->borrarMenu ();
        break;
    }
  }

  public function ordenar() {

    include "clases/class.ordenar.php";
    $ord = new ordenarMenu ( $this->bd );
  }

  public function cargarMenu() {

    if ($_GET ["id"]) {
      $sql = "UPDATE abm_menus SET nombre = '" . htmlentities ( $_POST ["nombre"] ) . "', referencia = '" . $_POST ["referencia"] . "', id_padre = '" . $_POST ["id_padre"] . "', icono='" . $_POST ["icono"] . "' WHERE id_menu = '" . $_GET ["id"] . "'";
      $this->bd->bbdd_query ( $sql );
      $id = $_GET ["id"];
    } else {
      $sql = "INSERT INTO abm_menus (nombre, referencia, id_padre, icono) VALUES ('" . htmlentities ( $_POST ["nombre"] ) . "','" . $_POST ["referencia"] . "','" . $_POST ["id_padre"] . "','" . $_POST ["icono"] . "')";
      $this->bd->bbdd_query ( $sql );
      $id = $this->bd->bbdd_id ();
      $sql = "SELECT max(orden) maximo FROM abm_menus WHERE id_padre = '" . $_POST ["id_padre"] . "' and publico = '1'";
      $r = $this->bd->bbdd_query ( $sql );
      list ( $max ) = $this->bd->bbdd_fetch ( $r );
      $max ++;
      $sql = "UPDATE abm_menus SET orden = '" . $max . "' WHERE id_menu = '" . $id . "'";
      $this->bd->bbdd_query ( $sql );
    }
    
    //borro los permisos del menu
    $sql = "DELETE FROM abm_menus_permisos WHERE idMenu = '" . $id . "'";
    $this->bd->bbdd_query ( $sql );
    
    foreach ( $_POST ["id_permiso"] as $clave ) {
      $sql = "INSERT INTO abm_menus_permisos (idMenu,idPermiso) VALUES ('" . $id . "','" . $clave . "')";
      $this->bd->bbdd_query ( $sql );
    }
    
    parent::redireccionar ( "menuListar.php" );
  }

  public function obtenerMenu( $id ) {

    $sql = "SELECT * FROM abm_menus WHERE id_menu = '" . $id . "'";
    $r = $this->bd->bbdd_query ( $sql );
    $row = $this->bd->bbdd_fetch ( $r );
    return $row;
  }

  public function borrarMenu() {

    $sql = "DELETE FROM abm_menus WHERE id_menu = '" . $_GET ["id"] . "'";
    $this->bd->bbdd_query ( $sql );
    parent::redireccionar ( "menuListar.php" );
  }
}
?>