<?php class utils{
	public function getDescriptionByCode($code, $descriptionArray){
		
		if (count($descriptionArray)){
			foreach($descriptionArray as $description){
				if ($description["code"] == $code)
					return $description["description"];
			}
		}
		return NULL;
	}
	
	public function getProductByCode($code){
		require_once("../lib/nusoap.php");
		
		$wsdl = "http://localhost:8080/horizonte2/horizonteWS?wsdl";
		
		$client = new nusoap_client($wsdl, "wsdl");
		
		$result = $client->call("obtenerProductoXCODPROD", "codprod => HORI");

		print_r($result);
	}
	
	public function existCode($array, $code){
		$result = false;
		
		foreach($array as $elem){
			if (strcmp($elem, $code) == 0)
				$result = true;
		}
		return $result;
	}
	
	public function calculaEdad($fecha) {
		//	FECHA EN FORMATO YYYY-MM-DD
    	list($Y,$m,$d) = explode("-",$fecha);
    	return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}
	
	function daysDifference($endDate, $beginDate){
		$date_parts1 = explode("-", $beginDate);
		$date_parts2 = explode("-", $endDate);
		$start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
		$end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
		return $end_date - $start_date;
	}
	
	function createThumbs($pathToImages, $pathToThumbs, $thumbWidth ){
	  // open the directory
	  $dir = opendir( $pathToImages );

	  // loop through it, looking for any/all JPG files:
	  while (false !== ($fname = readdir( $dir ))) {
		// parse path for the extension
		$info = pathinfo($pathToImages . $fname);
		// continue only if this is a JPEG image
		if ( strtolower($info['extension']) == 'jpg' )
		{
		  echo "Creating thumbnail for {$fname} <br />";

		  // load image and get image size
		  $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );

		  // calculate thumbnail size
		  $new_width = $thumbWidth;
		  $new_height = floor( $height * ( $thumbWidth / $width ) );

		  // create a new temporary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );

		  // copy and resize old image into new image
		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

		  // save thumbnail into a file
		  imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
		}
	  }
	  // close the directory
	  closedir( $dir );
	}
	
	function resizeImageByWidth($img, $thumbWidth, $shortfilename){
	
		$info = pathinfo($img);
		
		if ($info['extension'] == "jpg" || $info['extension'] = "JPG" || $info['extension'] == "jpeg" || $info['extension'] = "JPEG")	
			$image = imagecreatefromjpeg($img);
		if ($info['extension'] == "png" || $info['extension'] = "PNG")
			$image = imagecreatefrompng($img);
		if ($info['extension'] == "gif" || $info['extension'] = "GIF")
			$image = imagecreatefromgif($img);

		$width = imagesx( $image);
		$height = imagesy( $image);
		// calculate thumbnail size
		$new_width = $thumbWidth;
		$new_height = floor( $height * ( $thumbWidth / $width ) );
		// create a new temporary image
		$tmp_img = imagecreatetruecolor( $new_width, $new_height );
		// copy and resize old image into new image
		imagecopyresized( $tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		
		// save thumbnail into a file
		if ($info['extension'] == "jpg" || $info['extension'] = "JPG" || $info['extension'] == "jpeg" || $info['extension'] = "JPEG")	
			imagejpeg($tmp_img, $shortfilename);
		if ($info['extension'] == "png" || $info['extension'] = "PNG")
			imagepng($tmp_img, $shortfilename);
		if ($info['extension'] == "gif" || $info['extension'] = "GIF")
			imagegif( $tmp_img, $shortfilename);
	}
	
	function url_exist($url){
		if (!$fp = curl_init($url)) 
			return false;
    	return true;
	}
}