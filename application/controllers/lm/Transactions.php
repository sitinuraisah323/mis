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
		$this->load->model('LmGramsModel','grams');
		$this->load->model('AreasModel','area');

	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->grams->db->order_by('weight', 'asc');
		$this->load->view("lm/transactions/index", array(
			'grams'	=> $this->grams->all(),
			'areas'	=> $this->area->all()
		));
	}

}
