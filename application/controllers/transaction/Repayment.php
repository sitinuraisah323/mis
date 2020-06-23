<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Repayment extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Units Daily Cash';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('RepaymentModel', 'repayment');
		$this->load->model('UnitsModel', 'units');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['units'] = $this->units->all();
		$this->load->view('transaction/repayment/index',$data);
	}


}
