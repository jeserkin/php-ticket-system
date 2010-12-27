<?php

# Check was this fil linked directly
if(!defined('SYSPATH')) exit('No direct script access allowed!');

/**
 * Ticket System
 * 
 * Non-commercial application.
 * 
 * @package			Ticket System
 * @author			Eugene Serkin
 * @copyright		Copyright (c) 2010, Art-Coder
 * @license			http://#
 * @link			http://art-coder.com
 * @since			Version 0.2
 */

//------------------------------------------------

/**
 * Quotes class. TEMPORARY FILE.
 * 
 * @package			Ticket System
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Eugene Serkin
 * @link			http://art-coder.com
 */

class Quotes {
	
	/**
	 * Database instance.
	 * @var MySQLDatabase
	 */
	private $db;
	
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
	public function __construct(MySQLDatabase $db, $path) {
		$this->db = $db;
		$this->path = $path;
	}
	
	
	private function getQuotesAmount() {
		$countQuotes = $this->db->fetchAssoc1("SELECT COUNT(1) as total FROM ts_quotes");
		return $countQuotes[0]['total'];
	}
	
	private function chooseQuote() {
		$amount = (int)$this->getQuotesAmount();
		$startFrom = 1;
		$getRandom = mt_rand($startFrom, $amount);
		return $getRandom;
	}
	
	private function getSelectedQuote() {
		$selectedQuotes = $this->db->fetchAssoc1("SELECT quote FROM ts_quotes WHERE id = ".$this->chooseQuote());
		return $selectedQuotes[0]['quote'];
	}
	
	public function writeQuoteToFile() {
		#$quote = $this->getSelectedQuote();
		file_put_contents($this->path.'/quotes.txt', $this->getSelectedQuote());
	}
	
	public function readQuotesFromFile() {
		return file_get_contents($this->path.'/quotes.txt');
	}
}
//	END Quotes Class

/* End of file Quotes.php */
/* Location: ./system/libraries/Quotes.php */
?>