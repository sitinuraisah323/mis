<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Customers extends Controller
{
	/**
	 * @var string
	 */

	public $menu = 'Customer';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('CustomersModel', 'customers');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('customers/index', array(
			'customers'	=> $this->customers->all()
		));
	}
}
