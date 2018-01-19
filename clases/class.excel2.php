<?php
class excel2 extends gral {
	private $bd;
	private $tipo;
	public $error;
	private $images = Array();
	private $dirImg = "../images/banners/";

	public function __construct( $bd ) {
		$this->bd = $bd;
		$this->tipo = (isset ( $_GET ["tipo"] )) ? $_GET ["tipo"] : 0;
	}

	public function obtenerDatos( $id ) {
		$sql = "SELECT * FROM banners WHERE id = '" . $id . "'";
		$r = $this->bd->bbdd_query ( $sql );
			$row = $this->bd->bbdd_fetch ( $r );
		return $row;
	}

	public function procesar() {
		switch ($this->tipo) {
			case 1: $this->cargarActualizarDatos();break;
		}
	}

	public function cargarActualizarDatos() {
         
		if($this->verificar()) {
			parent::error($this->error);
			return false;
		} else {
		     //-----------------------------------------------------------------
			    $sql="";
			    $totsql="";
				require_once 'phpexcelreader/reader.php';
				require_once 'phpexcelreader/oleread.inc.php';
                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('CP1251');
				$data->setUTFEncoder('mb');
				$data->read($_FILES["excel"]["tmp_name"]);
				error_reporting(E_ALL ^ E_NOTICE);
                $_tmp_id_empresa = "";
                $_tmp_user = "";
				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
					$cont = 1;
					$cont2 = 0;
					$icono = "";
					$sql ="";
				    $sql.= "INSERT INTO empleados SET ";
	                for ($j = 1; $j <= 7; $j++) {
						if($cont == 1){
							$_tmp_id_empresa = $this->detectaEmpresa( $data->sheets[0]['cells'][$i][$j] );
		                    $sql.=  '  id_empresa ="'.$_tmp_id_empresa.'"';
							$cont++;
							if( !empty($data->sheets[0]['cells'][$i][$j]) ){
								$cont2++;
							}
						}elseif($cont == 2){
							$_tmp_user = $data->sheets[0]['cells'][$i][$j];
		                    $sql.=  ' , user ="'.$_tmp_user.'"';
							$cont++;
							if( !empty($data->sheets[0]['cells'][$i][$j]) ){
								$cont2++;
							}
						}elseif($cont == 3 ){
		                    $sql.=  ' , pass ="'.base64_encode($data->sheets[0]['cells'][$i][$j]).'"';
							$cont++;
							if( !empty($data->sheets[0]['cells'][$i][$j]) ){
								$cont2++;
							}
						}elseif($cont == 4 ){
		                    $sql.=  ' , nombre ="'.$data->sheets[0]['cells'][$i][$j].'"';
							$cont++;
							if( !empty($data->sheets[0]['cells'][$i][$j]) ){
								$cont2++;
							}
						}elseif($cont == 5 ){
		                    $sql.=  ' , apellido ="'.$data->sheets[0]['cells'][$i][$j].'"';
							$cont++;
							if( !empty($data->sheets[0]['cells'][$i][$j]) ){
								$cont2++;
							}
						}elseif($cont == 6 ){
		                    $sql.=  ' , cantidad_kits ="'.$data->sheets[0]['cells'][$i][$j].'"';
							$cont++;
							if( !empty($data->sheets[0]['cells'][$i][$j]) ){
								$cont2++;
							}
						}elseif($cont == 7 ){
		                    $sql.=  ' ,  direccion_entrega = "'.$data->sheets[0]['cells'][$i][$j].'"';
							$cont++;
							if( !empty($data->sheets[0]['cells'][$i][$j]) ){
								$cont2++;
							}
						}
	                }
				    $sql.= ";;;; \n";
					if( $cont2 > 0 && !$this->check_duplica($_tmp_id_empresa,$_tmp_user ) ){
						$totsql .= $sql;
					}
					
                }
				
				
				
				$totsql=explode(';;;;',$totsql);
				foreach($totsql as $clave ){
					mysql_query($clave);
				}
				
				
				/*
				$totsql=explode(';;;;',$totsql);
				foreach($totsql as $clave ){
					echo  $clave."<br /><br /><br />\n";
				}*/
				
		      parent::redireccionar("empleados.php");
		     //-----------------------------------------------------------------
		}
	}
public function check_duplica($id_empresa, $user){
	$sql ="SELECT id_empleado FROM empleados WHERE id_empresa='".$id_empresa."' AND user='".$user."'";
	$q = mysql_query($sql);
	if( mysql_num_rows($q) > 0 ){
		return true;
	}
	return false;
}	

	public function verificar() {
		include 'class.validaciones.php';
		$val = new validaciones($this->bd);

		if($val->verifVacio($_FILES["excel"]["name"]))
			$this->error .= "No Subio ningun archivo<br/>";


		if($this->error != "")
			return true;
		else
			return false;
	}



public function detectaEmpresa($strNombre){
	$sql = "SELECT id_empresa FROM empresas WHERE empresa='".$strNombre."'";
	$q = mysql_query($sql);
	if( mysql_num_rows($q) > 0){
		$a = mysql_fetch_array($q);
		return $a["id_empresa"];
	}
	return null;
}

public function igualaCaracter($cadena){
    $res = str_replace('&aacute;','a', $cadena);  
    $res = str_replace('&Aacute;','A', $res);  
    $res = str_replace('&eacute;','e', $res);  
    $res = str_replace('&Eacute;','E', $res);
    $res = str_replace('&iacute;','i', $res);  
    $res = str_replace('&Iacute;','I', $res);
    $res = str_replace('&oacute;','o', $res);  
    $res = str_replace('&Oacute;','O', $res);
    $res = str_replace('&uacute;','u', $res);  
    $res = str_replace('&Uacute;','U', $res);  
    $res = str_replace('&ntilde;','ñ', $res);  
    $res = str_replace('&Ntilde;','Ñ', $res);  
    $res = $this->eliminaAcentos($res);
    $res = trim(strtoupper($res));
	return $res;
}
public function eliminaAcentos($cadena){
    $tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿ";
    $replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuy";
	
   return(strtr($cadena,$tofind,$replac));
}
public function detectaCategoria($x){
    $query=mysql_query("SELECT * FROM categorias");
	    while($array=mysql_fetch_array($query)){
			if($this->igualaCaracter($array['asoc']) == $this->igualaCaracter($x)){
			    return $array['id'];
			}
	    } 
	return "null";	
}	
public function detectaSubcategoria($x,$categoria){
    $query=mysql_query("SELECT * FROM subcategorias");
	    while($array=mysql_fetch_array($query)){
			if($this->igualaCaracter($array['subcategoria']) == $this->igualaCaracter($x) && $array['id_categoria'] == $categoria ){
			    return $array['id'];
			}
	    } 
	return "null";	
}	
public function detectaSubcategoria2($x,$subcategoria){
    $query=mysql_query("SELECT * FROM sub_subcategorias");
	    while($array=mysql_fetch_array($query)){
			if($this->igualaCaracter($array['sub_subcate']) == $this->igualaCaracter($x) && $array['id_subcate'] == $subcategoria ){
			    return $array['id'];
			}
	    } 
		return 'null';
}	
public function detectaComarca($x){
    $query=mysql_query("SELECT * FROM comarcas");
	    while($array=mysql_fetch_array($query)){
			if($this->igualaCaracter($array['asociacion']) == $this->igualaCaracter($x)){
			    return $array['id'];
			}
	    } 
		return 'null';
}	
public function detectaEje($x){
    $query=mysql_query("SELECT * FROM ejes WHERE eje='".$x."'");
	if(mysql_num_rows($query) > 0){
		$array=mysql_fetch_array($query);
		return $array['id'];
	} 
	return 'null';
}			
public function bbdd_seguridad($valor){
       $buscar = '¤'; 
       $reemplazar =  "€";  
       $cadena1 = str_replace($buscar, $reemplazar, $valor);  
		return mysql_real_escape_string($cadena1);
		
//mysql_real_escape_string(stripslashes($valor)
}
public function get_icon_sub($id){
     $qCat=mysql_query("SELECT * FROM subcategorias WHERE id=".$id);
	 $aCat=mysql_fetch_array($qCat);
	return $aCat["iconm"];
}
public function get_icon_sub2($id){
     $qCat=mysql_query("SELECT * FROM sub_subcategorias WHERE id=".$id);
	 $aCat=mysql_fetch_array($qCat);
	return $aCat["iconm"];
}

}
?>