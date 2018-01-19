<?php

/*********************************************************************************
class UPFILE
$directorio --> directorio donde se va a subir el archivo
$nombreArchivo --> nombre final del archivo
$sobreescribir --> 0 - no permite sobreescibir (x defecto)
				   1 - permite sobreescribir el archivo
				   2 - le cambia el nombre al archivo por uno random para poder subirlo
$tiposValidos --> array con los tipos de archivos permitidos
$creaDirecotorios --> 0 - no permite crear directorios
					  1 - permite crear directorios (x defecto)
$permisosDirectorios --> indica el permiso q va a tener el directorio al crearse (x defecto es 0777)
$pesoMax --> peso maximo permitido (x defecto es 2 MB)
$pesoMin --> peso minimo permitido (x defecto es 1 byte)
$errores --> array q contendra todos los errores
$archivo --> nombre del campo q contiene el file
 *********************************************************************************/

class upfile {

  private $PESO_MAX = 2097152;
  private $PESO_MIN = 1;

  //private $TIPOS_VALIDOS = array("bmp","gif","jpg","zip","doc","rar","xls");
  private $TIPOS_VALIDOS = array (
    "png", "gif", "jpg" 
  );

  private $directorio;
  private $nombreArchivo;
  private $sobreescribir;
  private $tiposValidos;
  private $creaDirecotorios;
  private $permisosDirectorios;
  private $pesoMax;
  private $pesoMin;
  private $errores;
  private $archivo;

  public function __construct() {

    $this->errores = array ();
    $this->tiposValidos = $this->TIPOS_VALIDOS;
    $this->pesoMax = $this->PESO_MAX;
    $this->pesoMin = $this->PESO_MIN;
    $this->permisosDirectorios = 0777;
    $this->creaDirecotorios = 1;
    $this->directorio = "";
    $this->nombreArchivo = "";
    $this->sobreescribir = 0;
  }

  public function agregarError( $error ) {

    $this->errores [] = $error;
  }

  /************************************************
	crear directorios:
	- se le pasa la ruta del directorio a crear y los permisos q va a tener
   *************************************************/
  public function creaDirectorioRecursivo( $dir, $permisos ) {

    if (file_exists ( $dir )) return false;
    preg_match_all ( '/([^\/]*)\/?/i', $dir, $atmp );
    $base = '';
    foreach ( $atmp [0] as $directorio ) {
      $base .= $directorio;
      if ((! file_exists ( $base )) && (! mkdir ( $base, $permisos ))) return false;
    }
    return true;
  }

  /******************************************************
	metodo q especifica si se puede crear directorios o no
   ******************************************************/
  public function permitirCrearDirectorios( $crear ) {

    $this->creaDirecotorios = $crear;
  }

  /********************************************************
	metodo q define el permiso q van a tener los directorios creados
   *********************************************************/
  public function definirPermisos( $pemisos = 0777 ) {

    $this->permisosDirectorios = $permisos;
    return true;
  }

  /*******************************************************
	define el directorio en donde se va a subir el archivo
   *******************************************************/
  public function definirDirectorio( $dir = "" ) {

    if (! file_exists ( $dir ) && $this->creaDirecotorios) {
      if ($this->creaDirectorioRecursivo ( $dir, $this->permisosDirectorios )) {
        $this->directorio = $dir;
        return true;
      } else {
        $this->agregarError ( "El directorio de subida no existia y no se pudo crear" );
        return false;
      }
    } else if (is_dir ( $dir ) && ! is_writable ( $dir )) {
      $this->agregarError ( "Es directorio pero no tiene el permiso de escritura" );
      return false;
    } else {
      $this->directorio = $dir;
      return true;
    }
  }

  /****************************************************
	define el nombre del archivo q se va a subir
   *****************************************************/
  public function nombreDelArchivo( $nombre, $extencion = "" ) {

    //echo $extencion;exit();
    if (! file_exists ( $this->directorio . "/" . $nombre . $extencion )) {
      $this->nombreArchivo = $nombre;
      return true;
    } else {
      switch ($this->sobreescribir) {
        case 0 :
          $this->agregarError ( "No se puede sobreescribir el archivo ni guardarlo con otro nombre" );
          return false;
          break;
        case 1 :
          $this->nombreArchivo = $nombre;
          return true;
          break;
        case 2 :
          $this->nombreArchivo = $this->nuevoNombre ( $nombre );
          return true;
          break;
      }
    }
  }

  public function nuevoNombre( $nombre ) {

    $rand = "";
    srand ();
    for($i = 0; $i < 5; $i ++)
      $rand .= rand ( 0, 9 );
    return $rand . $nombre;
  }

  /******************************************************
	define como va a actuar con archivos sobreescribirs
   ******************************************************/
  public function permitirSobreescribir( $rep ) {

    /******************************************
		0= no se permite
		1= sobreescribir
		2= guarda con nombre nuevo
     *******************************************/
    $this->sobreescribir = $rep;
    return true;
  }

  /*******************************************************
	define los tipos de archivos permitidos para subir
   *******************************************************/
  public function permitirTipos( $tipos ) {

    foreach ( $tipos as $tipo ) {
      if (! in_array ( $tipo, $this->tiposValidos )) $this->tiposValidos [] = $tipo;
    }
    return true;
  }

  /********************************************************
	define el peso maxino de los archivos a subir
   ********************************************************/
  public function maxPeso( $peso = 2048 ) {

    $this->pesoMax = $peso;
    return true;
  }

  /********************************************************
	define el peso minimo de los archivos a subir
   ********************************************************/
  public function minPeso( $peso = 10 ) {

    $this->pesoMin = $peso;
    return true;
  }

  /*******************************************************
	metodos para verificar la subida
   *******************************************************/
  public function verif_subioPorPost() {

    if (is_uploaded_file ( $_FILES [$this->archivo] ['tmp_name'] )) return true;
    else {
      $this->agregarError ( "El archivo no subio por post.<br>" );
      return false;
    }
  }

  public function verif_tamanoAdecuado() {

    if ($_FILES [$this->archivo] ['size'] < $this->pesoMax) return true;
    else {
      $this->agregarError ( "El tamaño del archivo no esta permitido.<br>" );
      return false;
    }
  }

  public function verif_estaVacio() {

    if (! empty ( $_FILES [$this->archivo] ['name'] )) return true;
    else {
      $this->agregarError ( "No existe el archivo para subir.<br>" );
      return false;
    }
  }

  public function verif_puedoEscribir() {

    if (is_writable ( $this->directorio )) return true;
    else {
      $this->agregarError ( "No tenes permiso para escribir en este directorio.<br>" );
      return false;
    }
  }

  public function verif_errorEnArchivo() {

    if ($_FILES [$this->archivo] ['error'] == 0) return true;
    else {
      $this->AgregarError ( 'El archivo no se ha recibido correctamente.<br>' );
      return false;
    }
  }

  public function verif_tipoValido() {

    if (in_array ( substr ( $_FILES [$this->archivo] ['name'], - 3 ), $this->tiposValidos )) return true;
    else {
      $this->AgregarError ( 'El tipo del archivo subido no esta permitido.<br>' );
      return false;
    }
  }

  /**************************************************************
	metodo q realiza la cargar del archivo
   **************************************************************/
  public function guardarArchivo( $archivo, $nombre = "" ) {

    //guardo el nombre del campo
    $this->archivo = $archivo;
    //extencion
    $extencion = substr ( $_FILES [$this->archivo] ['name'], - 4 );
    //defino el nombre del archivo
    if ($nombre != "") $s = $this->nombreDelArchivo ( $nombre, $extencion );
    else if ($this->nombreArchivo == "") $s = $this->nombreDelArchivo ( substr ( $_FILES [$this->archivo] ['name'], 0, strlen ( $_FILES [$this->archivo] ['name'] ) - 4 ), $extencion );
    
    $this->nombreArchivo .= substr ( $_FILES [$this->archivo] ['name'], - 4 );
    
    if ($s && $this->verif_subioPorPost () && $this->verif_tamanoAdecuado () && $this->verif_estaVacio () && $this->verif_puedoEscribir () && $this->verif_errorEnArchivo () && $this->verif_tipoValido () && $this->verif_tipoValido ()) {
      if (move_uploaded_file ( $_FILES [$this->archivo] ['tmp_name'], $this->directorio . "/" . $this->nombreArchivo )) return true;
      else {
        $this->agregarError ( "No se subio el archivo, no se pudo copiar la imagen" );
        return false;
      }
    } else {
      $this->agregarError ( "No se subio el archivo, algo no se valido" );
      return false;
    }
  }
}
?>