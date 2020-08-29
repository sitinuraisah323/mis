<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Konversi extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Konversi';

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
        $this->load->model('RegularPawnsModel', 'regulars');
        $this->load->model('BookCashModel', 'model');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        
	}

	public function outstanding()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/konversi/outstanding',$data);
	}

	public function saldo()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/konversi/saldo',$data);
	}

	

}
