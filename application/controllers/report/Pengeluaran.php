<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Pengeluaran extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Pengeluaran';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AreasModel', 'areas');
		$this->load->model('MappingcaseModel', 'm_casing');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$data['areas'] = $this->areas->all();
		$data['pengeluaran']=$this->m_casing->get_list_pengeluaran();
		$this->load->view('report/pengeluaran/index',$data);
    }	
	
}