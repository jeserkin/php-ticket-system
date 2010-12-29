<style type="text/css">
	#container {width:700px; font-size:17px;}
</style>
<?php

phpinfo(); exit;

function createBlocker()
{
	$sentence = '//This is blocker file.';
	file_put_contents( APPPATH . '/cache/blocker', $sentence );
}

function removeBlocker()
{
	unlink( APPPATH . '/cache/blocker' );
}

function doesBlockerExist()
{
	if ( file_exists( APPPATH . '/cache/blocker' ) )
	{
		return true;
	}

	return false;
}

if ( ! doesBlockerExist() )
{
	// Will be finished later
	$cache->writeDataToFile();
	createBlocker();
}
else
{
	echo 'Settings already set.';
}

?>