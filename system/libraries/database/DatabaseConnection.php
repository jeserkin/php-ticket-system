<?php

/**
 * @author:  Eugene Serkin <jserkin@gmail.com>
 * @version: $Id$
 */
class DatabaseConnection
{
	/**
	 * Database host.
	 * e.g. localhost
	 * @var string
	 */
	protected $DB_HOST = "localhost";

	/**
	 * Database name.
	 * @var string
	 */
	protected $DB_NAME = "ticket_system";

	/**
	 * Database user name.
	 * @var string
	 */
	protected $DB_USER = "root";

	/**
	 * Database user password.
	 * @var string
	 */
	protected $DB_PASS = "toor";

	/**
	 * Database table prefix.
	 * (OPTIONAL) - Database table prefix. (NOT USED AT THE MOMENT)
	 * @var string
	 */
	protected $DB_PREFIX = "";

}