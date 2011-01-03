<?php

/**
 * @author:  Eugene Serkin <jserkin@gmail.com>
 * @version: $Id$
 */
class Error
{
	/**
	 * Webpage main address.
	 * @var string
	 */
	private $baseUrl;

	/**
	 * Path to directory where to store error_log.
	 * @var string
	 */
	private $rootPath;

	/**
	 * Name of the error log file.
	 * @var string
	 */
	private $fileName;

	/**
	 * Code of error.
	 * @var int
	 */
	private $errorCode;

	/**
	 * Message provided for specified error code.
	 * @var string
	 */
	private $errorMsg;

	/**
	 * Current date and time.
	 * @var string
	 */
	private $curTimeDate;

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	string	Webpage main address.
	 * @param	string	Path to directory where to store error_log.
	 * @param	string	Name of the error log file.
	 */
	public function __construct( $base_url, $root_path, $file_name )
	{
		$this->baseUrl  = $base_url;
		$this->rootPath = $root_path;
		$this->fileName = $file_name;
	}

	/* Standart Page Errors. */

	/**
	 * Error 404.
	 *
	 * @access	public
	 */
	public function notFound()
	{
		$this->errorCode   = 404;
		$this->curTimeDate = date( 'Y-m-d H:i' );
		$reqPage           = $this->baseUrl . $_SERVER['REQUEST_URI'];
		$this->errorMsg    = "Error: " . $this->errorCode . "\r\n\tThe requested page at this address: " . $reqPage . " was not found.\r\n\n";

		require_once( SYSPATH.'/errors/notfound.php' );
		$this->outputError( $this->curTimeDate, $this->errorMsg );
	}

	/**
	 * Error 403.
	 *
	 * @access	public
	 */
	public function forbidden()
	{
		$this->errorCode   = 403;
		$this->curTimeDate = date( 'Y-m-d H:i' );
		$reqPage           = $this->baseUrl . $_SERVER['REQUEST_URI'];
		$this->errorMsg    = "Error: " . $this->errorCode . "\r\n\tThe requested page at this address: " . $reqPage . " is forbidden.\r\n\n";

		require_once( SYSPATH.'/errors/forbidden.php' );
		$this->outputError( $this->curTimeDate, $this->errorMsg );
	}

	/**
	 * Writing the error to file.
	 *
	 * @access	private
	 * @param	string	Current date and time.
	 * @param	string	Message generated by occured error.
	 */
	private function outputError( $ctdate, $msg )
	{
		$type  = 3;
		$pfile = $this->rootPath.'/'.$this->fileName;

		if ( ! file_exists( $pfile ) )
		{
			fopen( $pfile, 'w' );
		}
		error_log( $ctdate.' '.$msg, $type, realpath( $pfile ) );
	}
}