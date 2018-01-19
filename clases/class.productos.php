<?php
include("clases/class.img.php");
class productos extends gral {
	private $bd;
	private $tipo;
	private $error="";
	private $dirImg = "../images/productos/";
	private $images = Array();

	public function __construct( $bd ) {
		$this->bd = $bd;
		$this->tipo = (isset ( $_GET ["tipo"] )) ? $_GET ["tipo"] : 0;
	}

	public function obtenerDatos( $id ) {
		$sql = "SELECT * FROM productos WHERE id_producto = '" . $id . "'";
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
		case 3 :
			$this->borrarFoto ("logo");
			break;
		}
	}

	public function cargarActualizarDatos() {
	
		
		if(!empty($_FILES["image"]["name"])){
			$this->images["image"] = $this->generaNombreImage().".jpg";
			$this->subirFoto("image");
		}
		
		if ($this->verificar ()){
			parent::error( $this->error );
			return false;
		}else{
		if ($_GET ["id"]){
			
			$sql = "UPDATE productos SET ";
			$sql .= "  descripcion = '" .  $this->bd->bbdd_seguridad ( $_POST ["descripcion"] )  . "' ";
			$sql .= " , creditos = '" .   $this->bd->bbdd_seguridad ( $_POST ["creditos"] )  . "' ";
			$sql .= " , codigo = '" .   $this->bd->bbdd_seguridad ( $_POST ["codigo"] )  . "' ";
			$sql .= " , id_categoria = '" .   $this->bd->bbdd_seguridad ( $_POST ["id_categoria"] )  . "' ";
			if( isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])){
				$sql .= ",  image = '" .  $this->images["image"] . "'  ";
			}
			if( isset($_POST ["state"]) && $_POST ["state"] == 1){
				$sql .= ",  state = '1'  ";
			}else{
				$sql .= ",  state = '0'  ";
			}
			$sql .= " WHERE id_producto = '" . $_GET ["id"] . "'";
		}else{
			$sql = "INSERT INTO productos SET ";
			$sql .= "  descripcion = '" .  $this->bd->bbdd_seguridad ( $_POST ["descripcion"] )  . "' ";
			$sql .= " , creditos = '" .   $this->bd->bbdd_seguridad ( $_POST ["creditos"] )  . "' ";
			$sql .= " , codigo = '" .   $this->bd->bbdd_seguridad ( $_POST ["codigo"] )  . "' ";
			$sql .= " , id_categoria = '" .   $this->bd->bbdd_seguridad ( $_POST ["id_categoria"] )  . "' ";
			if( isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])){
				$sql .= ",  image = '" .  $this->images["image"] . "'  ";
			}
			if( isset($_POST ["state"]) && $_POST ["state"] == 1){
				$sql .= ",  state = '1'  ";
			}else{
				$sql .= ",  state = '0'  ";
			}
		}
			$this->bd->bbdd_query ( $sql );
			parent::redireccionar ( "productos.php" );
		}
	}

	public function verificar() {

		include 'class.validaciones.php';
		$val = new validaciones ( $this->bd );
		if ($val->verifVacio ( $_POST["descripcion"] )) $this->error .= "No completo el campo descripcion <br />";
		if ( empty($_GET ["id"]) && $val->verifVacio ( $_POST["codigo"] )) $this->error .= "No completo el campo codigo <br />";
		if ($val->verifVacio ( $_POST["id_categoria"] )) $this->error .= "No completo el campo categoria <br />";
    
		if ($this->error != ""){
			return true;
		}else{
			return false;
		}
	}

	public function borrarDatos() {
		$q = mysql_query("SELECT id_orden FROM carrito WHERE id_producto='".$_GET ["id"]."'");
		if( mysql_num_rows($q) > 0 ){
			parent::error( "El producto esta en uso" );
			return false;
		}
		$sql = "DELETE FROM productos WHERE id_producto = '" . $_GET ["id"] . "'";
		$this->bd->bbdd_query ( $sql );
		parent::redireccionar ( "productos.php" );
	}
	
	public function generaNombreImage(){
		$rand = date('d').date('m').date('Y').date('H').date('i').date('s').rand(0,999).rand(0,999).rand(0,999).rand(0,999).rand(0,999);
		return $rand;
	}
	
	public function subirFoto($campo) {
		new img($_FILES[$campo]["tmp_name"],223,115,90,true,$this->dirImg.$this->images[$campo]);
	}
	
	public function borrarFoto( $imagen) {
		unlink ( $this->dirImg . $rowImagen [$imagen] );
		parent::redireccionar ( "productos.php" );
	}

}
?>