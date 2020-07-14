<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Pendapatan extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Pendapatan';

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
		$data['pendapatan']=$this->m_casing->get_list_pendapatan();
		$this->load->view('report/pendapatan/index',$data);
	}	
	
	public function get_pendapatan(){
		$this->m_casing->db
		->where('type =','CASH_IN');
		$data =$this->m_casing->all();
		$arr=array();
		foreach ($data as $value) {
			//echo $value->no_perk;
			//$arr=$value->no_perk;
			array_push($arr, $value->no_perk);
		}
		print_r($arr);
	    //$data = $this->m_casing->where('type=','CASH_IN');
		// echo json_encode(array(
		// 	'data'	=> $data,
		// 	'status'	=> true,
		// 	'message'	=> 'Successfully Get Data Regular Pawns'
		// ));
	}
	
}
