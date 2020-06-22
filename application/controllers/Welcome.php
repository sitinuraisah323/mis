<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Controller.php';
class Welcome extends Controller
{
	/**
	 * @var string
	 */

	public $menu = 'WELCOME';

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
		$this->load->view('index');
	}
}
