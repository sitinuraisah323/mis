<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class ExtractAll extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'ExtractAll';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoanInstallmentsModel', 'installment');
		$this->load->model('UnitsModel', 'units');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('transactions/extractall/index',array(
			'units'	=> $this->units->all()
		));
	}
}
