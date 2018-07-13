<?php
class imagen
{
	var $ruta;
	var $gd;
	var $tipo;
	var $extension;
	var $mime;
	var $ancho;
	var $alto;
	var $md5;
	var $peso;

	function __construct($ruta = null)
	{
		if($ruta)
		{
			$this->abrir($ruta);
		}
	}

	function abrir($ruta)
	{
		$this->ruta = $ruta;
		$info = getimagesize($this->ruta);
		$this->ancho = $info[0];
		$this->alto = $info[1];
		$this->tipo = $info[2];
		$this->extension = image_type_to_extension($this->tipo, false);
		$this->mime = $info['mime'];
		$this->md5 = md5_file($this->ruta);
		$this->peso = filesize($ruta);

		switch($this->tipo)
		{
			case IMAGETYPE_GIF:
				$this->gd = imagecreatefromgif($this->ruta);
			break;
			case IMAGETYPE_JPEG:
				$this->gd = imagecreatefromjpeg($this->ruta);
			break;
			case IMAGETYPE_BMP:
				$this->gd = imagecreatefromwbmp($this->ruta);
			break;
			case IMAGETYPE_PNG:
				$this->gd = imagecreatefrompng($this->ruta);
			break;
		}
	}

	function guardar($directorio, $nombre, $ancho = null, $alto = null, $proporcionar = false)
	{
		if(is_null($ancho) || is_null($alto))
		{
			$redimensionada = $this->gd;
		}
		elseif(!$proporcionar)
		{
			$redimensionada = imagecreatetruecolor($ancho, $alto);
			imagecopyresampled($redimensionada, $this->gd, 0, 0, 0, 0, $ancho, $alto, $this->ancho, $this->alto);
		}
		else
		{
			$dimensiones = $this->imagen_redimensionar_medidas($this->alto, $this->ancho, $alto, $ancho);

			$redimensionada = imagecreatetruecolor($dimensiones['ancho'], $dimensiones['alto']);
			imagecopyresampled($redimensionada, $this->gd, 0, 0, 0, 0, $dimensiones['ancho'], $dimensiones['alto'], $this->ancho, $this->alto);
		}

		umask(0);

		switch($this->tipo)
		{
			case IMAGETYPE_GIF:
				$i = imagegif($redimensionada, $directorio."/".$nombre.".".$this->extension);
			break;
			case IMAGETYPE_JPEG:
				$i = imagejpeg($redimensionada, $directorio."/".$nombre.".".$this->extension);
			break;
			case IMAGETYPE_PNG:
				$i = imagepng($redimensionada, $directorio."/".$nombre.".".$this->extension);
			break;
		}

		imagedestroy($redimensionada);

		return $i;
	}

	function imagen_redimensionar_medidas($alto, $ancho, $alto_tope, $ancho_tope)
	{
		if($ancho_tope > $ancho || $alto_tope > $alto)
		{
			return array("ancho" => $ancho, "alto" => $alto);
		}

		$proporcion = $alto/$alto_tope;
		$nuevo_ancho = round($ancho/$proporcion);
		$nuevo_alto = round($alto/$proporcion);

		if($nuevo_alto > $alto_tope)
		{
			$proporcion = $alto_tope/$nuevo_alto;
			$nuevo_ancho = round($proporcion*$nuevo_ancho);
			$nuevo_alto =  round($proporcion*$nuevo_alto);
		}

		if($nuevo_ancho > $ancho_tope)
		{
			$proporcion = $ancho_tope/$nuevo_ancho;
			$nuevo_ancho = round($proporcion*$nuevo_ancho);
			$nuevo_alto =  round($proporcion*$nuevo_alto);
		}

		return array("ancho" => $nuevo_ancho, "alto" => $nuevo_alto);

	}

	function destruir()
	{
		imagedestroy($this->gd);
	}
}

/* {FIN} */
?>