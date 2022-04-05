<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Smartphone extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Smartphone';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('UnitsdailycashModel', 'unitsdailycash');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('AreasModel', 'areas');
		// $this->load->model('MapingcategoryModel', 'm_category');
        $this->load->model('RegularPawnsModel', 'regulars');
        // $this->load->model('BookCashModel', 'model');
	}

	/**
	 * Welcome Index()
	 */

     public function index(){

		if($this->session->userdata('user')->level=='unit'){
			$data['customers'] = $this->units->get_customers_gadaireguler_byunit($this->session->userdata('user')->id_unit);
		}
        $data['areas'] = $this->areas->all();
         $this->load->view('report/smartphone/index', $data);

     }

	//  public function pdf() {

	// 	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// 	require_once APPPATH.'controllers/pdf/header.php';

	// 	$smartphone = $this->

	// 	$pdf->addPage('L', 'A4');
	// 	$view = $this->load->view('report/smartphone/pdf.php', ['smartphone' => $smartphone], true);
	// 	$pdf->writeHTML($view);

	//  }

	//  public function merek_hp(){
	// 	$data['customers'] = $this->areas->units->getcustomers_gadairegular_byunit($this->session->serdata('user')->id_unit);
	// 	$data['areas']=>$this->areas->all();

	// 	if($data!=NULL){
	// 	$this->load->view('report/smartphone/index', $data);
	// 	echo json_encode(array(
	// 		'data'=>
	// 		'status'=>'true',
	// 		'message'=>'Data Berhasil di tampilkan'
	// 	));
	// 	}
	//  }

	//  public function type(){
	// 	$this->units->db->select('units.name, units_regularpawns.no_sbk, units_regularpawns.date_sbk, units_regularpawns.amount, units_regularpawns.permit,')
	// 	->from('units_regularpawns')
	// 	->join('units ')
	// 	->join('units_repayments')
	// 	->join('customers')
	// 	->where('regid_unit', '')
	//  }

	

}