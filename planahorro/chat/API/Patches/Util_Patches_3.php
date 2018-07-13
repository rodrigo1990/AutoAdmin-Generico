<?php
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
	if ( !is_file( "$CONF[CONF_ROOT]/patches/93" ) )
	{ $patched = 93 ;
		$query = "ALTER TABLE p_footstats DROP mdfive" ; // safety check
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_referstats DROP mdfive" ; // safety check
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_transcripts CHANGE question question MEDIUMTEXT $charset_string NOT NULL , CHANGE formatted formatted MEDIUMTEXT $charset_string NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_operators CHANGE smsnum smsnum VARCHAR( 155 ) NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.4" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/94" ) )
	{ $patched = 94 ; Util_Vals_WriteVersion( "4.4.5" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/95" ) )
	{ $patched = 95 ; Util_Vals_WriteVersion( "4.4.6" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/96" ) )
	{ $patched = 96 ; Util_Vals_WriteVersion( "4.4.7" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/97" ) )
	{ $patched = 97 ;
		$query = "CREATE TABLE IF NOT EXISTS p_dept_vars ( deptID int(11) NOT NULL, greeting_title varchar(255) $charset_string NOT NULL, greeting_body varchar(255) $charset_string NOT NULL, PRIMARY KEY (deptID) )" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.8" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/98" ) )
	{ $patched = 98 ;
		$query = "ALTER TABLE p_operators DROP curc" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints_u DROP PRIMARY KEY" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints_u ADD footprintID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints_u DROP INDEX md5_vis" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_messages ADD md5_vis VARCHAR(32) NOT NULL AFTER vemail, ADD INDEX ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints_u ADD UNIQUE ( md5_vis )" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.9" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/99" ) )
	{ $patched = 99 ;
		$query = "ALTER TABLE p_transcripts DROP INDEX deptID" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_transcripts DROP INDEX op2op" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_transcripts ADD INDEX( deptID )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_transcripts ADD INDEX( op2op )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints_u DROP footprintID" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.91" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/100" ) )
	{ $patched = 100 ;
		$query = "ALTER TABLE p_req_log DROP INDEX created" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_req_log ADD status_msg TINYINT(1) NOT NULL AFTER status" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_messages ADD ces VARCHAR(32) NOT NULL AFTER vemail" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_req_log ADD INDEX( created )" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.92" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/101" ) )
	{ $patched = 101 ; Util_Vals_WriteVersion( "4.4.93" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/102" ) )
	{ $patched = 102 ; Util_Vals_WriteVersion( "4.4.94" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ; }
	if ( !is_file( "$CONF[CONF_ROOT]/patches/103" ) )
	{ $patched = 103 ;
		$query = "ALTER TABLE p_departments ADD emailt VARCHAR(160) NOT NULL AFTER email" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.95" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/104" ) )
	{ $patched = 104 ;
		$query = "ALTER TABLE p_operators ADD canID TINYINT NOT NULL AFTER maxc" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.96" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/105" ) )
	{ $patched = 105 ;
		$query = "ALTER TABLE p_departments ADD emailt_bcc TINYINT(1) NOT NULL AFTER emailt" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.97" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/106" ) )
	{ $patched = 106 ;
		Util_Vals_WriteVersion( "4.4.98" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/107" ) )
	{ $patched = 107 ;
		Util_Vals_WriteVersion( "4.4.99" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/108" ) )
	{ $patched = 108 ;
		$query = "ALTER TABLE p_canned ADD auto_select TINYINT(1) NOT NULL AFTER deptID" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.99.1" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/109" ) )
	{ $patched = 109 ;
		Util_Vals_WriteVersion( "4.4.99.2" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/110" ) )
	{ $patched = 110 ;
		Util_Vals_WriteVersion( "4.4.99.3" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/111" ) )
	{ $patched = 111 ;
		$query = "ALTER TABLE p_req_log DROP INDEX archive" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_refer DROP INDEX archive" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints DROP INDEX archive" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_req_log ADD archive TINYINT(1) NOT NULL AFTER status" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_req_log ADD INDEX ( archive )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_refer ADD archive TINYINT(1) NOT NULL AFTER created" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_refer ADD INDEX ( archive )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints ADD archive TINYINT(1) NOT NULL AFTER created" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints ADD INDEX ( archive )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "TRUNCATE TABLE p_footprints_u" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_footprints_u ADD footID INT UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (footID)" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_dept_vars ADD idle_o TINYINT UNSIGNED NOT NULL AFTER deptID, ADD idle_v TINYINT UNSIGNED NOT NULL AFTER idle_o" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_req_log ADD idle_disconnect TINYINT NOT NULL AFTER browser" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "CREATE TABLE IF NOT EXISTS p_op_vars (opID int(10) unsigned NOT NULL, sound tinyint(1) NOT NULL, blink tinyint(1) NOT NULL, blink_r tinyint(1) NOT NULL, dn_response tinyint(1) NOT NULL, dn_always tinyint(1) NOT NULL, PRIMARY KEY (opID))" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_req_log CHANGE custom custom TEXT NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_requests CHANGE custom custom TEXT NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.99.4" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/112" ) )
	{ $patched = 112 ;
		Util_Vals_WriteVersion( "4.4.99.5" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/113" ) )
	{ $patched = 113 ;
		$query = "CREATE TABLE IF NOT EXISTS p_lang_packs ( lang varchar(15) NOT NULL, lang_vars TEXT $charset_string NOT NULL, UNIQUE KEY lang (lang) )" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_messages CHANGE custom custom TEXT $charset_string NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.99.6" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/114" ) )
	{ $patched = 114 ;
		Util_Vals_WriteVersion( "4.4.99.7" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/115" ) )
	{ $patched = 115 ;
		Util_Vals_WriteVersion( "4.4.99.8" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/116" ) )
	{ $patched = 116 ;
		$query = "ALTER TABLE p_transcripts CHANGE plain plain MEDIUMTEXT $charset_string NOT NULL" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.99.9" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	if ( !is_file( "$CONF[CONF_ROOT]/patches/117" ) )
	{ $patched = 117 ;
		$query = "ALTER TABLE p_dept_vars ADD trans_f_dept TINYINT UNSIGNED NOT NULL AFTER idle_v" ;
		database_mysql_query( $dbh, $query ) ;
		$query = "ALTER TABLE p_requests ADD ended INT UNSIGNED NOT NULL AFTER created" ;
		database_mysql_query( $dbh, $query ) ;
		Util_Vals_WriteVersion( "4.4.99.91" ) ; touch( "$CONF[CONF_ROOT]/patches/$patched" ) ;
	}
	/* end auto patch area */
?>