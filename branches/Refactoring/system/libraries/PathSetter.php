<?php

/**
 * @author:  Eugene Serkin <jserkin@gmail.com>
 * @version: $Id$
 */
class PathSetter
{
	private $excludedPaths = array();

	private $paths = array();

	public function __construct()
	{
	}

	public function addDirectory( $directory )
	{
		$DirIter = new DirectoryIterator( $directory );

		foreach ( $DirIter as $File )
		{
			$path = $File->getPathname();

			if ( $this->directoryAlreadyAdded( $path ) )
			{
				continue;
			}

			if ( $this->inExcludedPaths( $path ) )
			{
				continue;
			}

			if ( $File->isDir() && ! $File->isDot() )
			{
				$this->addDirectory( $path );
			}
			elseif ( ! $File->isDot() )
			{
				$name = $File->getBasename( '.php' );

				$this->paths[ $name ] = $path;
			}
		}
	}

	public function excludeDirectory( $directory )
	{
		$this->excludedPaths[] = $directory;
	}

	public function savePaths( $filename )
	{
		file_put_contents( $filename, '<?php return ' . var_export( $this->paths, true ) . ';' );
	}

	private function directoryAlreadyAdded( $directory )
	{
		if ( in_array( $directory, $this->paths ) )
		{
			return true;
		}

		return false;
	}

	private function inExcludedPaths( $directory )
	{
		foreach ( $this->excludedPaths as $path )
		{
			if ( false !== strpos( $directory, $path ) )
			{
				return true;
			}
		}

		return false;
	}
}