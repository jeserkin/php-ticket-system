<?php
/*
*	PUBLIC FOLDER NAME
*	There should be all *.css, *.js and image files.
*	Use it only if neccesary.
*/
$public_folder = "public";

/*
*	SYSTEM FOLDER NAME
*	The main folder of the system.
*/
$system_folder = "system";

/*
*	APPLICATION FOLDER NAME
*	Folder where application files will be stored.
*/
$application_folder = "application";

/* Setting up main constants */
# Name of main file. Usually "index.php".
defined('SELF') or define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
# Mainly used file extension ".php".
defined('EXT') or define('EXT', ".php");
# Path to the main file. Usually "index.php".
defined('ROOT') or define('ROOT', str_replace(SELF, "", __FILE__));

# Path to application folder.
defined('APPPATH') or define('APPPATH', realpath(ROOT."/".$application_folder));
# Path to system folder.
defined('SYSPATH') or define('SYSPATH', realpath(ROOT."/".$system_folder));

# Getting all needed classes
function __autoload($class) {
	if(file_exists(realpath(APPPATH.'/libraries/'.$class.EXT))) {
		require_once(realpath(APPPATH.'/libraries/'.$class.EXT));
	} else if(file_exists(realpath(SYSPATH.'/libraries/'.$class.EXT))) {
		require_once(realpath(SYSPATH.'/libraries/'.$class.EXT));
	} else {
		require_once(realpath(SYSPATH.'/libraries/database/'.$class.EXT));
	}
}

# Create MySQL DB instance
$db = new MySQLDatabase();

$quoter = new Quotes($db, APPPATH.'/cache');

$quoter->writeQuoteToFile();

# Closes connection to server and currently opened DB.
$db->closeConnection();
?>