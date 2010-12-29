<?php

/**
 * @author:  Eugene Serkin <jserkin@gmail.com>
 * @version: $Id$
 */
class Loader
{
	private static $paths = array();

	public function __construct()
	{
	}

	public static function load( array $paths )
	{
		foreach ( $paths as $className => $path )
		{
			self::$paths[ $className ] = $path;
		}
	}
}