<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class BookCash extends Authenticated
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
		$this->load->view('datamaster/bookcash/index');
	}

	public function form($id = null)
	{
		$this->load->view('datamaster/bookcash/form', array(
			'units'	=> $this->units->all(),
			'id'	=> $id,
			'fractions'	=> $this->fraction->all(),
		));
	}

}
