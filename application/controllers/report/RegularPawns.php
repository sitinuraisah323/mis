<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Regularpawns extends Authenticated
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
        $data['units'] = $this->units->all();
        $data['areas'] = $this->areas->all();
		$this->load->view('report/regularpawns/index',$data);
	}

	public function pencairan()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/regularpawns/pencairan',$data);
    }
	
	public function pelunasan()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/regularpawns/pelunasan',$data);
	}
	
	public function perpanjangan()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/regularpawns/perpanjangan',$data);
    }

}
