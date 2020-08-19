<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class LogamMulya extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Units';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LmTransactionsModel','model');
		$this->load->model('LmGramsModel','grams');
		$this->load->model('AreasModel','areas');

	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('datamaster/logammulya/index',array(
			'areas'	=>  $this->areas->all(),
			'grams'	=> $this->grams->all()
		));
	}

}
