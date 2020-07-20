<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Targetunit extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Targetunit';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UnitsdailycashModel', 'unitsdailycash');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('AreasModel', 'areas');
		$this->load->model('MapingcategoryModel', 'm_category');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/targetunit/index',$data);
	}

}
