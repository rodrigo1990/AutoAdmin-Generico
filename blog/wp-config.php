<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'arg_wordpress');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'arg_fr');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'Argen2017');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'eyk@xnaUO9k v$C^{(X@?D@)Dqde&|7kz%(e;lLyEAZi(=?bL/Im1KYlAZ7|k]i_');
define('SECURE_AUTH_KEY', 'a5#{J?>qQQJ7w@e[K&@BmG>)8<09X+bT7#&PLh7#b.Vk]GcV75#LS=<)P*2W{a|-');
define('LOGGED_IN_KEY', '>p0[M:yAae)W?` ^}#>!_PNO]/vRhN2UV!l+pfk|FWQWaNqL#6^n,2cW@DC,0OTh');
define('NONCE_KEY', '%[zePj&Xv% ZK}aO2e|m^~a!(I0nn*Elg-!JzA{ ?`]-[jfD}Id[I0_:k}>d)$Y(');
define('AUTH_SALT', 'H/<8w%FXj9ppS~v!aOz/tU} !75FcrOs^Q;o<-4uLr>f&LXY3Lo?`$H}U{B<G0}X');
define('SECURE_AUTH_SALT', 'gP@33j/fl<iw=qKAsAr9Q0x(ci;XfTwt(vIBYx,v; P]>QY5<N8,Fd8b`?aHTfD|');
define('LOGGED_IN_SALT', '6$yPQ.g+BNo_q; R9K[jrxf4*gFD*>e9.vb9mbStC?mojQ5f,p@#tgNa(8cdjynz');
define('NONCE_SALT', 'j&6Qd=8(n,<C ;u2-=&.Wj<nErYEVnI82zCNo9F,EdZYEBr~zBSz~EL rH-h5{ar');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

