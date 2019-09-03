<?php
include("clases/class.img.php");
class empresas extends gral {
	private $bd;
	private $tipo;
	private $error="";
	private $dirImg = "../images/empresas/";
	private $images = Array();

	public function __construct( $bd ) {
		$this->bd = $bd;
		$this->tipo = (isset ( $_GET ["tipo"] )) ? $_GET ["tipo"] : 0;
	}

	public function obtenerDatos( $id ) {
		$sql = "SELECT * FROM empresas WHERE id_empresa = '" . $id . "'";
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
		
		if(!empty($_FILES["logo"]["name"])){
			$this->images["logo"]= $this->generaNombreImage().".jpg";
			$this->subirFoto("logo");
		}
		
		if ($this->verificar ()){
			parent::error( $this->error );
			return false;
		}else{
		if ($_GET ["id"]){
			$sql = "UPDATE empresas SET ";
			$sql .= "  empresa = '" .  $this->bd->bbdd_seguridad ( $_POST ["empresa"] )  . "' ";
			$sql .= " , descripcion = '" .   $this->bd->bbdd_seguridad ( $_POST ["descripcion"] )  . "' ";
			$sql .= " , credito_inicial = '" .   $this->bd->bbdd_seguridad ( $_POST ["credito_inicial"] )  . "' ";
			$sql .= " , vencimiento = '" .   $this->bd->bbdd_seguridad ( $_POST ["vencimiento"] )  . "' ";
			if(!empty($_FILES["logo"]["name"])) {
				$sql .= ",  logo = '" .  $this->images["logo"] . "'  ";
			}
			$sql .= " WHERE id_empresa = '" . $_GET ["id"] . "'";
		}else{
			$sql = "INSERT INTO empresas SET ";
			$sql .= "  empresa = '" .  $this->bd->bbdd_seguridad ( $_POST ["empresa"] )  . "' ";
			$sql .= " , descripcion = '" .   $this->bd->bbdd_seguridad ( $_POST ["descripcion"] )  . "' ";
			$sql .= " , credito_inicial = '" .   $this->bd->bbdd_seguridad ( $_POST ["credito_inicial"] )  . "' ";
			$sql .= " , vencimiento = '" .   $this->bd->bbdd_seguridad ( $_POST ["vencimiento"] )  . "' ";
			if(!empty($_FILES["logo"]["name"])) {
				$sql .= ",  logo = '" .  $this->images["logo"] . "'  ";
			}
		}
			$this->bd->bbdd_query ( $sql );
			parent::redireccionar ( "empresas.php" );
		}
	}

	public function verificar() {

		include 'class.validaciones.php';
		$val = new validaciones ( $this->bd );
		if ($val->verifVacio ( $_POST["empresa"] )) $this->error .= "No completo el campo empresa <br />";
    
		if ($this->error != ""){
			return true;
		}else{
			return false;
		}
	}

	public function borrarDatos() {
		$sql = "DELETE FROM empresas WHERE id_empresa = '" . $_GET ["id"] . "'";
		$this->bd->bbdd_query ( $sql );
		parent::redireccionar ( "empresas.php" );
	}
	
	public function generaNombreImage(){
		$rand = date('d').date('m').date('Y').date('H').date('i').date('s').rand(0,999).rand(0,999).rand(0,999).rand(0,999).rand(0,999);
		return $rand;
	}
	
	public function subirFoto($campo) {
		$img = new img($_FILES[$campo]["tmp_name"],181,75,90,$this->dirImg.$this->images[$campo]);
	}
	
	public function borrarFoto( $imagen) {
		$rowImagen = $this->obtenerDatos ( $_GET ["id"] );
		$sql = "UPDATE empresas SET " . $imagen . " = ''  WHERE id_empresa = '" . $_GET ["id"] . "'";
		$this->bd->bbdd_query ( $sql );
		unlink ( $this->dirImg . $rowImagen [$imagen] );
		parent::redireccionar ( "empresas.php" );
	}

}
?>