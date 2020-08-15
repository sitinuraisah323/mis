<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class Outstanding extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Outstanding';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
        parent::__construct();
        $this->load->library('pdf');
		$this->load->model('UsersModel','model');
		$this->load->model('RegularPawnsModel', 'regular');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('RepaymentModel','repayments');
		$this->load->model('MappingcaseModel', 'm_casing');
		$this->load->model('OutstandingModel', 'outstanding');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';
		$pdf->AddPage('L');
		$users = $this->model->all();
		$view = $this->load->view('dailyreport/outstanding/index.php',['outstanding'=> $this->data()],true);
		$pdf->writeHTML($view);
		//download
		//$pdf->Output('GHAnet_'.date('d_m_Y').'.pdf', 'D');
		//view
		$pdf->Output('GHAnet_Summary_'.date('d_m_Y').'.pdf', 'I');
	}
	
	public function data()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($id_unit = $this->input->get('id_unit')){
			$this->units->db->where('units.id', $id_unit);
		}else if($code = $this->input->get('code')){
			$this->units->db->where('code', zero_fill($code, 3));
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$unit->ost_yesterday = $this->regular->getOstYesterday($unit->id, $date);
			$unit->credit_today = $this->regular->getCreditToday($unit->id, $date);
			$unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $date);
			$totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa - $unit->repayment_today->noa;
			$totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up - $unit->repayment_today->up;
			$unit->total_outstanding = (object) array(
				'noa'	=> $totalNoa,
				'up'	=> $totalUp,
				'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
			);
			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id);
			$unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id, $date);
			$unit->dpd_today = $this->regular->getDpdToday($unit->id, $date);
			$unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id,$date);
			$unit->total_dpd = (object) array(
				'noa'	=> $unit->dpd_today->noa + $unit->dpd_yesterday->noa - $unit->dpd_repayment_today->noa,
				'ost'	=> $unit->dpd_today->ost + $unit->dpd_yesterday->ost - $unit->dpd_repayment_today->ost,
			);
			$unit->percentage = ($unit->total_dpd->ost > 0) && ($unit->total_outstanding->up > 0) ? round($unit->total_dpd->ost / $unit->total_outstanding->up, 4) : 0;
		}
		return $units;
	}

}
