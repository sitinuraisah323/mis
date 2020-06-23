<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Controller.php';
class Login extends Controller
{
	/**
	 * @var string
	 */

	public $menu = 'Login';

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
		$this->load->view('login');
	}
	
}
