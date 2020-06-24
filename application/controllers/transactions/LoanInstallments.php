<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class LoanInstallments extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'units_loaninstallments';

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
		$this->load->view('transactions/loaninstallments/index',array(
			'units'	=> $this->units->all()
		));
	}
}
