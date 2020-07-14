<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Dashboards extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('RegularPawnsModel', 'regular');
		$this->load->model('UnitsModel', 'units');
	}

	public function outstanding()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$units = $this->units->db->select('units.id, units.name')->get('units')->result();
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
			$unit->percentage = $unit->total_dpd->ost > 0 ? $unit->total_dpd->ost / $unit->total_dpd->noa : 0;
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function disburseytd()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}
		if($this->input->get('year')){
			$year = $this->input->get('year');
		}else{
			$year = date('Y');
		}
		$units = $this->units->db->select('units.id, units.name')->get('units')->result();
		foreach ($units as $unit){
			$unit->amount = $this->regular->getTotalDisburse($unit->id, $year)->credit;
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}


	public function disbursemtd()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}
		if($this->input->get('year')){
			$year = $this->input->get('year');
		}else{
			$year = date('Y');
		}

		if($this->input->get('month')){
			$month = $this->input->get('month');
		}else{
			$month = date('n');
		}

		$units = $this->units->db->select('units.id, units.name')->get('units')->result();
		foreach ($units as $unit){
			$unit->amount = $this->regular->getTotalDisburse($unit->id, $year, $month)->credit;
		}
		$this->sendMessage($units, 'Get Data Outstanding');
	}

	public function pencairan()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$begin = new DateTime( $date );
		$end = new DateTime($date);
		$end = $end->modify( '-6 day' );
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($end, $interval ,$begin);

		$dates = array();
		foreach($daterange as $date){
			$dates[] =  $date->format('Y-m-d');
		}

		$result[] = array('no' => 'No','unit'=> 'Unit','area'=>'Area','dates'=>$dates);
		$units = $this->units->db->select('units.id, units.name, areas.area as area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$dates = array();
			foreach($daterange as $date){
				$dates[] =  $this->regular->getUpByDate($unit->id, $date->format('Y-m-d'));
			}
			$unit->dates = $dates;
			$result[] = $unit;
		}
		$this->sendMessage($result, 'Get Data Outstanding');
	}

	public function pelunasan()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$begin = new DateTime( $date );
		$end = new DateTime($date);
		$end = $end->modify( '-6 day' );
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($end, $interval ,$begin);

		$dates = array();
		foreach($daterange as $date){
			$dates[] =  $date->format('Y-m-d');
		}

		$result[] = array('no' => 'No','unit'=> 'Unit','area'=>'Area','dates'=>$dates);
		$units = $this->units->db->select('units.id, units.name, areas.area as area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$dates = array();
			foreach($daterange as $date){
				$dates[] =  $this->repayments->getUpByDate($unit->id, $date->format('Y-m-d'));
			}
			$unit->dates = $dates;
			$result[] = $unit;
		}
		$this->sendMessage($result, 'Get Data Outstanding');
	}
}
