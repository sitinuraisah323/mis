<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Users extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Users';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('datamaster/users/index');
	}

}
