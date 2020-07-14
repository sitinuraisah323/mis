<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Bukukas extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Bukukas';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AreasModel', 'areas');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/bukukas/index',$data);
	}

	
	
}
