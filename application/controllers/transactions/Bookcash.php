<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Bookcash extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Levels';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('BookCashModel', 'bookcash');
		$this->load->model('BookCashMoneyModel', 'money');
		$this->load->model('FractionOfMoneyModel', 'fraction');
		$this->load->model('UnitsModel', 'units');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('transactions/bookcash/index',array(
			'units'	=> $this->units->all(),
		));
	}

	public function form($id = null)
	{
		$this->fraction->db
			->order_by('type','ASC')
			->order_by('amount','DESC');
		$this->load->view('transactions/bookcash/form', array(
			'fractions'	=> $this->fraction->all(),
			'units'	=> $this->units->all(),
			'id'	=> $id,
		));
	}

}
