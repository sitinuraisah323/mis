<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class Transactions extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Dashboards';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LmTransactionsModel','model');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view("lm/transactions/index");
	}

}
