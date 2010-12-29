<?php

/**
 * @author:  Eugene Serkin <jserkin@gmail.com>
 * @version: $Id$
 */
class User
{
	/**
	 * Users ID.
	 * @var int
	 */
	public $id;

	/**
	 * User login name.
	 * @var sting
	 */
	public $username;

	/**
	 * User encrypted password.
	 * @var string
	 */
	public $userpass;

	/**
	 * User email.
	 * @var	string
	 */
	public $email;

	/**
	 * User group.
	 * @vat int
	 */
	public $ugroup;

}