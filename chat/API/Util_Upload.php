<?php
	if ( defined( 'API_Util_Upload' ) ) { return ; }	
	define( 'API_Util_Upload', true ) ;

	function Util_Upload_File( $icon, $deptid )
	{
		global $upload_dir ;
		global $CONF ;
		$now = time() ;
		$extension = $error = $filename = "" ;

		if ( !defined( 'API_Util_Vals' ) )
			include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vals.php" ) ;

		if ( isset( $_SERVER['CONTENT_LENGTH'] ) && ( $_SERVER['CONTENT_LENGTH'] > 200000 ) )
			$error = "The uploaded file exceeds the allowed size of 200kb." ;
		else if ( isset( $_FILES[$icon]['size'] ) )
		{
			$filename = $_FILES[$icon]['name'] ;
			$filetype = $_FILES[$icon]['type'] ;
			$errorno = $_FILES[$icon]['error'] ;
			$filesize = $_FILES[$icon]['size'] ;

			$filename_parts = explode( ".", $filename ) ;

			if ( $errorno == UPLOAD_ERR_NO_FILE )
				$error = "Nothing to upload." ;
			else if ( !is_uploaded_file( $_FILES[$icon]['tmp_name'] ) )
				$error = "Invalid file." ;
			else if ( !getimagesize( $_FILES[$icon]['tmp_name'] ) )
				$error = "Please provide a valid image file.  Accepted formats are GIF, PNG, JPG or JPEG formats." ;
			else if ( count( $filename_parts ) == 1 )
				$error = "File name format is invalid.  Could not detect the image type extension." ;
			else if ( count( $filename_parts ) > 2 )
				$error = "File name format is invalid.  File name should contain only one dot within the name. (example: image.jpg)" ;
			else if ( !preg_match( "/(gif)|(jpeg)|(jpg)|(png)/i", $filename_parts[1] ) )
				$error = "Please provide a valid image file.  Accepted formats are GIF, PNG, JPG or JPEG." ;
			else if ( $errorno == UPLOAD_ERR_OK )
			{
				if ( preg_match( "/gif/i", $filetype ) )
					$extension = "GIF" ;
				else if ( preg_match( "/(jpeg)|(jpg)/i", $filetype ) )
					$extension = "JPEG" ;
				else if ( preg_match( "/png/i", $filetype ) )
					$extension = "PNG" ;

				if ( $extension )
				{
					if ( preg_match( "/(online)|(offline)|(initiate)|(logo)/", $icon ) )
					{
						$filename = $icon."_$deptid" ;

						if ( is_file( "$upload_dir/$filename.PNG" ) )
							unlink( "$upload_dir/$filename.PNG" ) ;
						else if ( is_file( "$upload_dir/$filename.JPEG" ) )
							unlink( "$upload_dir/$filename.JPEG" ) ;
						else if ( is_file( "$upload_dir/$filename.GIF" ) )
							unlink( "$upload_dir/$filename.GIF" ) ;

						$filename = $icon."_$deptid.$extension" ;
					}
					else
						$filename = "$icon.$extension" ;

					if( move_uploaded_file( $_FILES[$icon]['tmp_name'], "$upload_dir/$filename" ) )
					{
						if ( preg_match( "/(online)|(offline)|(logo)|(initiate)/", $icon ) && !$deptid )
							$error = ( Util_Vals_WriteToConfFile( $icon, $filename ) ) ? "" : "Could not write to config file." ;
					}
					else
						$error = "Could not process uploading of files." ;
				}
				else
					$error = "Please provide a valid image file.  GIF, PNG, JPG or JPEG formats only." ;
			}
			else if ( $errorno == UPLOAD_ERR_NO_TMP_DIR )
				$error = "Upload temp dir not set or not writeable.  Check the value of \"upload_tmp_dir\" in the php.ini file." ;
			else if ( $errorno == UPLOAD_ERR_FORM_SIZE )
				$error = "The uploaded file exceeds the allowed size of 200kb." ;
			else if ( $errorno == UPLOAD_ERR_INI_SIZE )
				$error = "The uploaded file exceeds the upload_max_filesize directive." ;
			else if ( $errorno )
				$error = "Error in uploading. [errorno: $errorno]" ;
			else
				$error = "Error in uploading." ;
		}
		else
			$error = "Please provide a valid image file.  GIF, PNG or JPEG formats only." ;

		return $error ;
	}

	function Util_Upload_GetChatIcon( $base_url, $prefix, $deptid )
	{
		global $CONF ;
		global $upload_dir ;

		$now = time() ;
		if ( is_file( "$upload_dir/$prefix"."_$deptid.GIF" ) )
			return "$base_url/$prefix"."_$deptid.GIF?".$now ;
		else if ( is_file( "$upload_dir/$prefix"."_$deptid.JPEG" ) )
			return "$base_url/$prefix"."_$deptid.JPEG?".$now ;
		else if ( is_file( "$upload_dir/$prefix"."_$deptid.PNG" ) )
			return "$base_url/$prefix"."_$deptid.PNG?".$now ;
		else if ( is_file( "$upload_dir/$CONF[$prefix]" ) && $CONF["$prefix"] )
			return "$base_url/$CONF[$prefix]?".$now ;
		else
			return "$CONF[BASE_URL]/pics/icons/$prefix".".gif" ;
	}

	function Util_Upload_GetLogo( $base_url, $deptid )
	{
		global $CONF ;
		global $upload_dir ;
		global $theme ;

		if ( isset( $theme ) && $theme )
			$local_theme = $theme ;
		else
			$local_theme = $CONF["THEME"] ;

		$now = time() ;
		if ( is_file( "$upload_dir/logo"."_$deptid.GIF" ) )
			return "$base_url/logo"."_$deptid.GIF?".$now ;
		else if ( is_file( "$upload_dir/logo"."_$deptid.JPEG" ) )
			return "$base_url/logo"."_$deptid.JPEG?".$now ;
		else if ( is_file( "$upload_dir/logo"."_$deptid.PNG" ) )
			return "$base_url/logo"."_$deptid.PNG?".$now ;
		else if ( is_file( "$upload_dir/logo_0.GIF" ) )
			return "$base_url/logo_0.GIF?".$now ;
		else if ( is_file( "$upload_dir/logo_0.JPEG" ) )
			return "$base_url/logo_0.JPEG?".$now ;
		else if ( is_file( "$upload_dir/logo_0.PNG" ) )
			return "$base_url/logo_0.PNG?".$now ;
		else if ( is_file( "$CONF[DOCUMENT_ROOT]/themes/$local_theme/logo.png" ) )
			return "$CONF[BASE_URL]/themes/$local_theme/logo.png?".$now ;
		else
			return "$CONF[BASE_URL]/pics/logo.png" ;
	}

	function Util_Upload_GetInitiate( $base_url, $deptid )
	{
		global $CONF ;

		$now = time() ;
		if ( isset( $CONF["icon_initiate"] ) && $CONF["icon_initiate"] && is_file( "$CONF[CONF_ROOT]/$CONF[icon_initiate]" ) )
			return "$base_url/$CONF[icon_initiate]?".$now ;
		else if ( is_file( "$CONF[DOCUMENT_ROOT]/themes/initiate/initiate.gif" ) )
			return "$CONF[BASE_URL]/themes/initiate/initiate.gif?".$now ;
		else
			return "$CONF[BASE_URL]/pics/icons/initiate.gif" ;
	}

?>
