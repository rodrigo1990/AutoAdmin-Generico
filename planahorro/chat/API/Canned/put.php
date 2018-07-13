<?php
	if ( defined( 'API_Canned_put' ) ) { return ; }
	define( 'API_Canned_put', true ) ;

	FUNCTION Canned_put_Canned( &$dbh,
					$canid,
					$opid,
					$deptid,
					$title,
					$message )
	{
		if ( ( $opid == "" ) || ( $deptid == "" )  || ( $title == "" )
			|| ( $message == "" ) )
			return false ;

		LIST( $canid, $opid, $deptid, $title, $message ) = database_mysql_quote( $dbh, $canid, $opid, $deptid, $title, $message ) ;

		if ( $canid )
			$query = "UPDATE p_canned SET deptID = $deptid, title = '$title', message = '$message' WHERE canID = $canid AND opID = $opid" ;
		else
			$query = "INSERT INTO p_canned VALUES( $canid, $opid, $deptid, 0, '$title', '$message' )" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			if ( !$canid )
				$id = database_mysql_insertid ( $dbh ) ;
			else
				$id = $canid ;
			return $id ;
		}

		return false ;
	}

	FUNCTION Canned_put_Auto_Canned( &$dbh,
					$opid,
					$canid,
					$value )
	{
		if ( ( $opid == "" ) || ( $canid == "" ) )
			return false ;

		LIST( $opid, $canid, $value ) = database_mysql_quote( $dbh, $opid, $canid, $value ) ;

		$query = "UPDATE p_canned SET auto_select = 0 WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] && $value )
		{
			$query = "UPDATE p_canned SET auto_select = 1 WHERE canID = $canid AND opID = $opid" ;
			database_mysql_query( $dbh, $query ) ;
			return true ;
		}

		return false ;
	}
?>