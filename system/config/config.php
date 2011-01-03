<?php
// Error reporting level by default it is set to ALL.
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', 1 );
/**
 * Use strictly for debuging purposes
 * error_reporting(E_ALL | E_STRICT);
 */
error_reporting( E_ALL | E_STRICT );

date_default_timezone_set( 'Europe/Tallinn' );

/* Default language */
$config['language'] = 'english';

/* Default Character Set */
$config['charset'] = 'utf-8';

/* Error log file name */
$config['error_log'] = 'error_log.txt';

/* Name of the default folder with theme */
$config['default_theme'] = 'default_theme';