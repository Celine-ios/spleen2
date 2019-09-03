<?php
class img extends gral
{

	public function __construct( $imagen, $ancho_max = 200, $alto_max = 200, $calidad = 80, $resize = true, $destino = "", $marca = "", $posicion_marca = 0, $margen = 4 ) {
		if ($destino == "") {
			header ( 'Content-type: image/jpeg' );
		}
		if (@$datos_img = getimagesize ( $imagen )) {
		$ancho = $datos_img [0];
		$alto = $datos_img [1];
		$ancho_orig = $ancho;
		$alto_orig = $alto;
		
		if($resize){
			if ($ancho > $ancho_max) {
				$proporcion = round ( ($ancho_max * 100) / $ancho );
				$ancho = $ancho_max;
				$alto = round ( ($alto * $proporcion) / 100 );
			}
			if ($alto > $alto_max) {
				$proporcion = round ( ($alto_max * 100) / $alto );
				$alto = $alto_max;
				$ancho = round ( ($ancho * $proporcion) / 100 );
			}
		}else{
			$ancho = $ancho_max;
			$alto = $alto_max;
		}
		$imagen_nueva = imagecreatetruecolor ( $ancho, $alto );
		ini_set ( "memory_limit", "20M" );
		        switch ($datos_img['mime']){
		            case "image/jpeg":
						if (!@$imagen_fuente = imagecreatefromjpeg($imagen)){
							return 0;
						}
						imagecopyresampled ( $imagen_nueva, $imagen_fuente, 0, 0, 0, 0, $ancho, $alto, $ancho_orig, $alto_orig );
						imagejpeg ( $imagen_nueva, $destino, $calidad );
		            break;
		            case "image/gif":
						if (!@$imagen_fuente = imagecreatefromgif($imagen)) {
							return 0;
						}
						imagealphablending($imagen_nueva, false);
						imagesavealpha($imagen_nueva,true);
						$transparent = imagecolorallocatealpha($imagen_nueva, 255, 255, 255, 127);
						imagefilledrectangle($imagen_nueva, 0, 0, $ancho, $alto, $transparent);
						
						imagecopyresampled ( $imagen_nueva, $imagen_fuente, 0, 0, 0, 0, $ancho, $alto, $ancho_orig, $alto_orig );
						imagegif($imagen_nueva,$destino );
 		            break;
 		            case "image/png":
						if (!@$imagen_fuente = imagecreatefrompng($imagen)) {
							return 0;
						}
						imagealphablending($imagen_nueva, false);
						imagesavealpha($imagen_nueva,true);
						$transparent = imagecolorallocatealpha($imagen_nueva, 255, 255, 255, 127);
						imagefilledrectangle($imagen_nueva, 0, 0, $ancho, $alto, $transparent);

						imagecopyresampled ( $imagen_nueva, $imagen_fuente, 0, 0, 0, 0, $ancho, $alto, $ancho_orig, $alto_orig );
						imagepng($imagen_nueva,$destino );
		            break;
		        }
		
		return 1;
		}
	}
	
	public function abrir_Imagen($imagen) {
    if (@$info_imagen = getimagesize($imagen)) {
        switch ($info_imagen['mime']) {
        case "image/jpeg":
            if (!@$imagen_fuente = imagecreatefromjpeg($imagen)) {
                return 0;
            }
            break;
        case "image/gif":
            if (!@$imagen_fuente = imagecreatefromgif($imagen)) {
                return 0;
            }
            break;
        case "image/png":
            if (!@$imagen_fuente = imagecreatefrompng($imagen)) {
                return 0;
            }
            break;
        }
    } else {
        return 0;
    }
    return $imagen_fuente;
	}
}
?>