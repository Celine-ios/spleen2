<?php
class usuarios extends gral
{
	public $bd;
	public $error;
	
	public function usuarios($bd){
		$this->bd=$bd;
		$this->error = "";
	}
	
	public function obtenerUsuario($id){
		$sql = "SELECT * FROM abm_usuario WHERE id_usuario = '".$id."'";
		$r = $this->bd->bbdd_query($sql);
		$row = $this->bd->bbdd_fetch($r);
		return $row;
	}
	
	public function obtenerPermisos($id){
		$sql = "SELECT id_menu FROM abm_permisos WHERE id_usuario = '".$id."'";
		$r = $this->bd->bbdd_query($sql);
		$permisos = array();
		while(list($permisos[]) = $this->bd->bbdd_fetch($r));
		array_pop($permisos);
		$sql = "SELECT  * 
				FROM abm_menus m
				INNER  JOIN abm_menus_permisos mp ON m.id_menu = mp.idMenu && mp.idPermiso = '".$_SESSION["wm_user_id_perfil"]."'
				WHERE m.id_padre =  '0' && m.publico =  '1' ORDER BY m.nombre ASC";
		
		//echo $sql;
		$sql_perfil = "SELECT id_perfil FROM abm_usuario WHERE id_usuario = '".$id."'";
		$r_perfil = $this->bd->bbdd_query($sql_perfil);
		$row_perfil = $this->bd->bbdd_fetch($r_perfil);
		
		if(!empty($row_perfil['id_perfil'])) {
		$sql = "SELECT * FROM abm_menus m INNER JOIN abm_menus_permisos mp ON m.id_menu = mp.idMenu && mp.idPermiso = ".$row_perfil['id_perfil']." WHERE m.id_padre = '0' && m.publico = '1' ORDER BY m.nombre ASC";
		}
		//echo $sql;
		
		$r = $this->bd->bbdd_query($sql);
		while($row = $this->bd->bbdd_fetch($r)){
		?>
			<input type="Checkbox" name="permisos[]" value="<?php echo $row["id_menu"]?>" class="checks" <?php if(in_array($row["id_menu"],$permisos)){?>checked="checked"<?php }?>/>&nbsp;&nbsp;<?php echo $row["nombre"];?><br/>
			<?php
			//$sql = "SELECT * FROM menus WHERE id_padre ='".$row["id_menu"]."' && publico = '1'";
			$sql = "SELECT  * 
					FROM abm_menus m INNER JOIN abm_menus_permisos mp ON m.id_menu = mp.idMenu && mp.idPermiso = '".$_SESSION["wm_user_id_perfil"]."'
					WHERE id_padre =  '".$row["id_menu"]."' && publico =  '1'";
			//echo $sql;exit();
			$r2 = $this->bd->bbdd_query($sql);
			while($row2 = $this->bd->bbdd_fetch($r2)){
			?>
				&nbsp;&nbsp;&nbsp;<input type="Checkbox" name="permisos[]" value="<?php echo $row2["id_menu"];?>" class="checks" <?php if(in_array($row2["id_menu"],$permisos)){?>checked="checked"<?php }?>/>&nbsp;&nbsp;<?php echo $row2["nombre"];?><br/>
		<?php
			}
		}
		$permisos = array();
	}
	
	
	public function procesarInformacion($tipo,$id){
		/*
		tipo 1: cargo/actualizo al usuario
		tipo 2: borrar
		*/
		switch($tipo){
			case 1: $this->cargarActualizarUsuario($id);break;
			case 2: $this->borrarUsuario($id);break;
			case 3: $this->cambiarClave($id,$_GET["volver"]);break;
		}
	}
	
	public function cargarActualizarUsuario($id){
		
		if($this->verificar($id)){
			parent::error($this->error);
			return false;
		}else{
			if($id){
				//borro todos los permisos de este usuario 
				$sql = "DELETE FROM abm_permisos WHERE id_usuario = '".$id."' and id_menu != '3'";
				$this->bd->bbdd_query($sql);
				$sql = "UPDATE abm_usuario SET id_perfil = '".$_POST["id_perfil"]."', email = '".$this->bd->bbdd_seguridad($_POST["email"])."', nombre = '".$this->bd->bbdd_seguridad($_POST["nombre"])."', apellido = '".$this->bd->bbdd_seguridad($_POST["apellido"])."', email_alt = '".$this->bd->bbdd_seguridad($_POST["email_alt"])."', sexo = '".$this->bd->bbdd_seguridad($_POST["sexo"])."', fecha_nacimiento = '".$this->bd->bbdd_seguridad($_POST["fecha_nacimiento"])."', tel_fijo = '".$this->bd->bbdd_seguridad($_POST["tel_fijo"])."', tel_fax = '".$this->bd->bbdd_seguridad($_POST["tel_fax"])."', tel_celu = '".$this->bd->bbdd_seguridad($_POST["tel_cel"])."' WHERE id_usuario = '".$id."'";
			}else{
				$sql = "INSERT INTO abm_usuario (usuario, clave, email, nombre, apellido,email_alt,sexo,fecha_nacimiento,tel_fijo,tel_fax,tel_celu,id_perfil) VALUEs ('".$this->bd->bbdd_seguridad($_POST["usuario"])."', '".$this->bd->bbdd_seguridad(md5($_POST["clave1"]))."','".$this->bd->bbdd_seguridad($_POST["email"])."', '".$this->bd->bbdd_seguridad($_POST["nombre"])."', '".$this->bd->bbdd_seguridad($_POST["apellido"])."','".$this->bd->bbdd_seguridad($_POST["email_alt"])."','".$this->bd->bbdd_seguridad($_POST["sexo"])."','".$this->bd->bbdd_seguridad($_POST["fecha_nacimiento"])."','".$this->bd->bbdd_seguridad($_POST["tel_fijo"])."','".$this->bd->bbdd_seguridad($_POST["tel_fax"])."','".$this->bd->bbdd_seguridad($_POST["tel_cel"])."','".$_POST["id_perfil"]."')";
			}
			
			$this->bd->bbdd_query($sql);
			
			if(!$id)
				$id = $this->bd->bbdd_id();
			
			//cargo los permisos por defecto
			//salir
			$sql = "INSERT INTO abm_permisos (id_usuario, id_menu) VALUES ('".$id."','2')";
			$this->bd->bbdd_query($sql);
			//cargo los permisos
			foreach($_POST["permisos"] as $valor){
				$sql = "INSERT INTO abm_permisos (id_usuario, id_menu) VALUES ('".$id."','".$valor."')";
				$this->bd->bbdd_query($sql);
			}
			parent::redireccionar("usuariosListar.php");
		}
	}
	
	public function borrarUsuario($id){
		//borro los permisos de este usuario
		$sql = "DELETE FROM abm_permisos WHERE id_usuario = '".$id."'";
		$this->bd->bbdd_query($sql);
		//borro al usuario
		$sql = "DELETE FROM abm_usuario WHERE id_usuario = '".$id."'";
		$this->bd->bbdd_query($sql);
		parent::redireccionar("usuariosListar.php");
	}
	
	public function verifPass($pass1,$pass2){
		return ($pass1 == $pass2);
	}
	
	public function verifUsuario($usuario){
		$sql = "SELECT * FROM abm_usuario WHERE usuario = '".$usuario."'";
		$r = $this->bd->bbdd_query($sql);
		return $this->bd->bbdd_num($r);
	}
	
	public function verificar($id){
		include 'class.validaciones.php';
		$val = new validaciones($this->bd);
		
		if(!$id){
			if($val->verifPass($_POST["clave1"],$_POST["clave2"]))
				$this->error .= "- Las claves ingresadas son distintas<br/>";
			if($val->verifUsuario($_POST["usuario"]))
				$this->error .= "- El nombre de usuario seleccionado ya esta en uso<br/>";
			if($val->verifVacio($_POST["usuario"]))
				$this->error .= "No completo el campo usuario<br/>";
			if($val->verifVacio($_POST["usuario"]))
				$this->error .= "No completo el campo clave<br/>";
			if($val->verifVacio($_POST["clave1"]))
				$this->error .= "No completo el campo clave<br/>";
			if($val->verifVacio($_POST["clave2"]))
				$this->error .= "No completo el campo repetir clave<br/>";
		}
		
		$vacios = array("email"=>"email","nombre"=>"nombre","apellido"=>"apellido");
		
		foreach($vacios as $clave=>$valor){
			if($val->verifVacio($_POST[$clave]))
				$this->error .= "- No se completo el campo ".$valor."<br/>";
		}
		
		if($val->verifSelect($_POST["id_perfil"]))
				$this->error .= "- No se completo el campo perfil<br/>";
		
		if($this->error != "")
			return true;
		else
			return false;
	}
	
	public function cambiarClave($id,$volver){
		include 'class.validaciones.php';
		$val = new validaciones($this->bd);
		
		if($val->verifPass($_POST["clave1"],$_POST["clave2"])){
			$this->error .= "- Las claves ingresadas son distintas<br/>";
			parent::error($this->error);
		}else{
			$sql = "UPDATE abm_usuario SET clave = '".$this->bd->bbdd_seguridad(md5($_POST["clave1"]))."' WHERE id_usuario = '".$id."'";
			$this->bd->bbdd_query($sql);
			switch($volver)
			{
				case 1:parent::redireccionar("usuariosAgregar.php",array("id"=>$id));break;
				case 2:parent::redireccionar("depositosAgregar.php",array("id"=>$id));break;
				case 3:parent::redireccionar("vendedorAgregar.php",array("id"=>$id));break;
				case 4:parent::redireccionar("proveedorAgregar.php",array("id"=>$id));break;
			}
		}
	}
}
?>