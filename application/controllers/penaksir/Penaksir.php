<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Penaksir extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Mortages';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MortagesModel', 'mortages');
		$this->load->model('UnitsModel', 'units');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		// $this->load->view('transactions/mortages/index',array(
		// 	'units'	=> $this->units->all()
		// ));
	}

	public function regular()
	{
		$this->load->view('penaksir/regular/index');
    }
    
    public function mortages()
	{
		$this->load->view('penaksir/mortages/index');
	}


}
