<?php

/**
 * @author:  Eugene Serkin <jserkin@gmail.com>
 * @version: $Id$
 */
class Cache
{
	/**
	 * Database instance.
	 * @var MySQLDatabase
	 */
	private $db;

	/**
	 * File name.
	 * @var string
	 */
	private $fileName;

	/**
	 * Path to cache file.
	 * @var string
	 */
	private $path;

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	string	Name of the file where to store cache.
	 * @param	string	Shows what needs caching.
	 * @param	MySQLDatabase	Instance of MySQLDatabase object.
	 */
	public function __construct($file_name = '', $path = '', MySQLDatabase $db) {
		$this->fileName = $file_name;
		$this->path = $path;
		$this->db = $db;
	}

	/**
	 * Get settings data from DB.
	 *
	 * @access	private
	 * @return	array
	 */
	private function getDataFromDB() {
		$data = array();
		$query = $this->db->query("
			SELECT setting_name, setting_value
			FROM ts_system_settings
			ORDER BY id
		");
		while(($row = $this->db->fetchAssoc($query)) != NULL) {
			$data[$row['setting_name']] = $row['setting_value'];
		}
		return $data;
	}

	/**
	 * Write serialized data to file.
	 *
	 * @access	public
	 */
	public function writeDataToFile() {
		$data = serialize($this->getDataFromDB());
		file_put_contents($this->path.$this->fileName, $data);
	}

	/**
	 * Reads serialized data from file and unserialize it.
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function getDataFromFile() {
		return unserialize(file_get_contents($this->path.$this->fileName));
	}
}
//	END Cache Class

/* End of file Cache.php */
/* Location: ./system/libraries/Cache.php */
?>