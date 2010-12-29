<?php

/**
 * @author:  Eugene Serkin <jserkin@gmail.com>
 * @version: $Id$
 */
class Validation
{
	/**
	 * Compares passed values with each other.
	 *
	 * @access	public
	 * @param	bool	Set debug on or off. Default off.
	 * @return	bool
	 */
	public function compareVals($debug = false) {
		$amountOfVals = func_num_args();
		$valsArr = func_get_args();

		if($amountOfVals == 0) {
			if($debug) {
				echo "No arguments or nothing to compare with.";
			}
			return false;
		}

		for($i = 0; $i < $amountOfVals; $i++) {
			for($j = 0; $j < $amountOfVals; $j++) {
				if($valsArr[$i] != $valsArr[$j]) return false;
			}
		}

		return true;
	}

	/**
	 * Checks for emptyness.
	 *
	 * @access	public
	 * @param	bool	Set debug on or off. Default off.
	 * @return	bool
	 */
	public function required($debug = false) {
		$amountOfVals = func_num_args();
		$valsArr = func_get_args();

		if($amountOfVals == 0) {
			if($debug) {
				echo "No arguments or nothing to compare with.";
			}
			return false;
		}

		foreach($valsArr as $val) {
			if(empty($val)) return false;
		}

		return true;
	}

	/**
	 * Eliminate unwanted tags from specified string.
	 *
	 * @access	public
	 * @param	string	String which needs parsing.
	 * @return	string
	 */
	public function eliminateTags($msg) {
		$decodeHTML = htmlspecialchars_decode($msg);
		$withoutTags = strip_tags($decodeHTML);
		$setBrakes = nl2br($withoutTags);

		return $setBrakes;
	}
	/*
	public function eliminateTags($msg) {
		$setBrakes = nl2br($msg);
		$decodeHTML = htmlspecialchars_decode($setBrakes);

		# Check PHP version
		if((double)phpversion() > 5.2) $withoutTags = strip_tags($decodeHTML, "<br />");
		else $withoutTags = strip_tags($decodeHTML, "<br>");

		return $withoutTags;
	}
	*/
}