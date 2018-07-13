<?php
	//
	// Auto patching of PHP Live! system
	//

	$charset_string = ( database_mysql_old( $dbh ) ) ? "" : "CHARACTER SET utf8 COLLATE utf8_general_ci" ;

	/* auto patch of versions and needed modifications */
	if ( !is_file( "$CONF[CONF_ROOT]/patches/86" ) )
	{ $patched = 86 ; Util_Vals_WriteVersion( "4.3.7" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/87" ) )
	{ $patched = 87 ; Util_Vals_WriteVersion( "4.3.8" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/88" ) )
	{ $patched = 88 ; Util_Vals_WriteVersion( "4.3.9" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/89" ) )
	{ $patched = 89 ;
		$query = "ALTER TABLE p_departments ADD rquestion TINYINT NOT NULL AFTER texpire" ;
		database_mysql_query( $dbh, $query ) ;
		if ( $dbh["error"] == "None" )
		{
			$query = "UPDATE p_departments SET rquestion = 1" ;
			database_mysql_query( $dbh, $query ) ;
		}

		$query = "ALTER TABLE p_vars ADD ts_clear INT UNSIGNED NOT NULL AFTER ts_clean" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "TRUNCATE TABLE p_footstats" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footstats CHANGE mdfive md5_page VARCHAR( 32 ) NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "TRUNCATE TABLE p_referstats" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_referstats CHANGE mdfive md5_page VARCHAR( 32 ) NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "TRUNCATE TABLE p_footprints" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints ADD md5_vis VARCHAR( 32 ) NOT NULL AFTER browser, ADD INDEX ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints DROP INDEX mdfive" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints CHANGE mdfive md5_page VARCHAR( 32 )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints ADD INDEX ( md5_page )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "TRUNCATE TABLE p_refer" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_refer DROP ip" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_refer ADD md5_vis VARCHAR( 32 ) NOT NULL FIRST, ADD PRIMARY KEY ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_refer CHANGE mdfive md5_page VARCHAR( 32 ) NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_refer DROP INDEX mdfive, ADD INDEX md5_page ( md5_page )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "TRUNCATE TABLE p_footprints_u" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints_u DROP INDEX ip" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints_u DROP INDEX created" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints_u DROP hostname" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints_u DROP agent" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints_u ADD INDEX ( created )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_footprints_u ADD md5_vis VARCHAR( 32 ) NOT NULL FIRST, ADD PRIMARY KEY ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "TRUNCATE TABLE p_ips" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_ips DROP INDEX ip" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_ips DROP PRIMARY KEY" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_ips CHANGE ip ip VARCHAR( 45 ) NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_ips ADD INDEX ( ip )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_ips ADD md5_vis VARCHAR( 32 ) NOT NULL FIRST, ADD PRIMARY KEY ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_requests DROP agent_md5" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_requests DROP hostname" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_requests DROP agent" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_requests ADD md5_vis VARCHAR( 32 ) NOT NULL AFTER ip, ADD INDEX ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_requests ADD md5_vis_ VARCHAR( 32 ) NOT NULL AFTER md5_vis" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_req_log DROP hostname" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_req_log DROP agent" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_req_log DROP INDEX created" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_req_log DROP INDEX ip" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_req_log ADD md5_vis VARCHAR( 32 ) NOT NULL AFTER ip, ADD INDEX ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_transcripts DROP INDEX ip" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_transcripts ADD md5_vis VARCHAR( 32 ) NOT NULL AFTER ip, ADD INDEX ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;

		$query = "ALTER TABLE p_messages DROP agent" ;
		database_mysql_query( $dbh, $query ) ;

		Util_Vals_WriteVersion( "4.4" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/90" ) )
	{ $patched = 90 ; Util_Vals_WriteVersion( "4.4.1" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/91" ) )
	{ $patched = 91 ; Util_Vals_WriteVersion( "4.4.2" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/92" ) )
	{ $patched = 92 ; Util_Vals_WriteVersion( "4.4.3" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	/* end auto patch area */
?>