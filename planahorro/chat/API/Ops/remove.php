<?php
	if ( defined( 'API_Ops_remove' ) ) { return ; }
	define( 'API_Ops_remove', true ) ;

	FUNCTION Ops_remove_Op( &$dbh,
						$opid )
	{
		if ( $opid == "" )
			return false ;

		LIST( $opid ) = database_mysql_quote( $dbh, $opid ) ;

		$query = "DELETE FROM p_canned WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "DELETE FROM p_dept_ops WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "DELETE FROM p_ext_ops WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "DELETE FROM p_transcripts WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "DELETE FROM p_operators WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "DELETE FROM p_opstatus_log WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "DELETE FROM p_rstats_ops WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "DELETE FROM p_req_log WHERE opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;

		return true ;
	}

	FUNCTION Ops_remove_CleanStats( &$dbh )
	{
		$query = "SELECT p_rstats_ops.opID FROM p_rstats_ops INNER JOIN p_operators ON p_rstats_ops.opID != p_operators.opID" ;
		database_mysql_query( $dbh, $query ) ;

		if ( $dbh[ 'ok' ] )
		{
			$opids = Array() ;
			while ( $data = database_mysql_fetchrow( $dbh ) )
				$opids[] = $data["opID"] ;
			
			for ( $c = 0; $c < count( $opids ); ++$c )
			{
				$opid = $opids[$c] ;
				$query = "DELETE FROM p_rstats_ops WHERE opID = $opid" ;
				database_mysql_query( $dbh, $query ) ;
			}
		}
	}

	FUNCTION Ops_remove_OpDept( &$dbh,
						$opid,
						$deptid )
	{
		if ( ( $opid == "" ) || ( $deptid == "" ) )
			return false ;

		LIST( $opid, $deptid ) = database_mysql_quote( $dbh, $opid, $deptid ) ;

		$query = "SELECT * FROM p_dept_ops WHERE deptID = $deptid AND opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;
		$data = database_mysql_fetchrow( $dbh ) ;

		$query = "DELETE FROM p_dept_ops WHERE deptID = $deptid AND opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "UPDATE p_dept_ops SET display = display-1 WHERE deptID = $deptid AND display >= $data[display]" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "DELETE FROM p_canned WHERE deptID = $deptid AND opID = $opid" ;
		database_mysql_query( $dbh, $query ) ;

		return true ;
	}
?>