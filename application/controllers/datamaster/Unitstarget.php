<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Unitstarget extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'UnitsTarget';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UnitsModel', 'units');
		$this->load->model('unitstargetModel', 'u_target');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['units'] = $this->units->all();
		$this->load->view('datamaster/unitstarget/index',$data);
	}

}
