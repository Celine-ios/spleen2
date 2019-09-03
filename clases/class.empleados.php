<?php
include("clases/class.img.php");
class empleados extends gral {
	private $bd;
	private $tipo;
	public $error;

	public function __construct( $bd ) {
		$this->bd = $bd;
		$this->tipo = (isset ( $_GET ["tipo"] )) ? $_GET ["tipo"] : 0;
	}

	public function obtenerDatos( $id ) {
		$sql = "SELECT * FROM empleados WHERE id_empleado = '" . $id . "'";
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
			$this->cambiarClave($_GET ["id"],$_GET["volver"]);
			break;
		}
	}

	public function cargarActualizarDatos() {
		
		if ($this->verificar ()){
			parent::error( $this->error );
			return false;
		}else{
		if ($_GET ["id"]){
			$sql = "UPDATE empleados SET ";
			$sql .= "  id_empresa = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["id_empresa"] ) ) . "' ";
			$sql .= " , nombre = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["nombre"] ) ) . "' ";
			$sql .= " , apellido = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["apellido"] ) ) . "' ";
			$sql .= " , user = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["user"] ) ) . "' ";
			$sql .= " , cantidad_kits = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["cantidad_kits"] ) ) . "' ";
			$sql .= " , direccion_entrega = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["direccion_entrega"] ) ) . "' ";
			$sql .= " WHERE id_empleado = '" . $_GET ["id"] . "'";
		}else{
			$sql = "INSERT INTO empleados SET ";
			$sql .= "  id_empresa = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["id_empresa"] ) ) . "' ";
			$sql .= " , nombre = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["nombre"] ) ) . "' ";
			$sql .= " , apellido = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["apellido"] ) ) . "' ";
			$sql .= " , user = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["user"] ) ) . "' ";
			$sql .= " , pass = '" . base64_encode ( $this->bd->bbdd_seguridad ( $_POST ["pass"] ) ) . "' ";
			$sql .= " , cantidad_kits = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["cantidad_kits"] ) ) . "' ";
			$sql .= " , direccion_entrega = '" . htmlentities ( $this->bd->bbdd_seguridad ( $_POST ["direccion_entrega"] ) ) . "' ";
		}
			$this->bd->bbdd_query ( $sql );
			parent::redireccionar ( "empleados.php" );
		}
	}

	public function verificar() {

		include 'class.validaciones.php';
		$val = new validaciones ( $this->bd );
		if ($val->verifVacio ( $_POST["nombre"] )) $this->error .= "No completo el campo nombre <br />";
		if (  $_POST["pass"] <> $_POST["pass2"] ) $this->error .= "Las contrase&ntilde;as no coinciden <br />";
    
		if ($this->error != ""){
			return true;
		}else{
			return false;
		}
	}

	public function borrarDatos() {
		$sql = "DELETE FROM empleados WHERE id_empleado = '" . $_GET ["id"] . "'";
		$this->bd->bbdd_query ( $sql );
		parent::redireccionar ( "empleados.php" );
	}
	
	
	public function cambiarClave($id,$volver){
		include 'class.validaciones.php';
		$val = new validaciones($this->bd);
		
		if($val->verifPass($_POST["clave1"],$_POST["clave2"])){
			$this->error .= "- Las claves ingresadas son distintas<br/>";
			parent::error($this->error);
		}else{
			$sql = "UPDATE empleados SET pass = '".$this->bd->bbdd_seguridad(base64_encode($_POST["clave1"]))."' WHERE id_empleado = '".$id."'";
			$this->bd->bbdd_query($sql);
			parent::redireccionar("empleadosAgregar.php",array("id"=>$id));
		}
	}

}
?>