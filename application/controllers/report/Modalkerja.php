<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Modalkerja extends Authenticated
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
        
    }
    
    public function pusat()
	{
        $data['units'] = $this->units->all();
        $data['areas'] = $this->areas->all();
		$this->load->view('report/modalkerja/pusat',$data);
    }
    
    public function antarunit()
	{
        $data['units'] = $this->units->all();
        $data['areas'] = $this->areas->all();
		$this->load->view('report/modalkerja/antarunit',$data);
	}

	
	
}
