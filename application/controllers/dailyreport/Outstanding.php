<?php
error_reporting(0);
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
		$this->load->model('MortagesModel', 'mortages');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('RepaymentModel','repayments');
		$this->load->model('MappingcaseModel', 'm_casing');
		$this->load->model('OutstandingModel', 'outstanding');
		$this->load->model('UnitsdailycashModel','dailycash');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';
		$os = $this->data();
		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/index.php',['outstanding'=>$os,'datetrans'=> $this->datetrans()],true);

		$pdf->writeHTML($view);

		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/dpd.php',['dpd'=>$os],true);
		$pdf->writeHTML($view);

		

		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/target.php',['data'=>$os,'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/pencairan.php',['pencairan'	=> $this->pencairan()],true);
		// $pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/pelunasan.php',['pelunasan'	=> $this->pelunasan()],true);
		// $pdf->writeHTML($view);

		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/rate.php',['rate'	=> $this->rate()],true);
		$pdf->writeHTML($view);

		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/saldo.php',[
			'saldo'	=> $this->saldounit($this->datetrans()),
			'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/pendapatan.php',['pendapatan'	=> $this->pendapatan(),
		'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/pengeluaran.php',['pengeluaran'	=> $this->pengeluaran(),
		'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		$coas = $this->dailycash->pengeluaran_perk($this->datetrans());

		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/pengeluaran_operasi',[
			'coas'=>$coas	,
			'datetrans'	=> $this->datetrans()
		],true);
		$pdf->writeHTML($view);
		

		$areas = $this->dailycash-> getCocCalcutation(null,  11,date('n', strtotime($this->datetrans())), date('Y', strtotime($this->datetrans())),  0,  0);
		$pdf->AddPage('L');
		$view = $this->load->view('report/coc/pdf.php',[
			'areas'=>$areas	,
			'datetrans'	=> $this->datetrans()
		],true);
		$pdf->writeHTML($view);
	

		//download
		$pdf->Output('GHAnet_Summary_'.date('d_m_Y').'.pdf', 'D');
		//view
		// $pdf->Output('GHAnet_Summary_'.date('d_m_Y').'.pdf', 'I');
	}

	public function test(){
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/index.php',['outstanding'=> $this->data()],true);
		// $pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/dpd.php',['dpd'=> $this->data()],true);
		// $pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/pencairan.php',['pencairan'	=> $this->pencairan()],true);
		// $pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/pelunasan.php',['pelunasan'	=> $this->pelunasan()],true);
		// $pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/saldo.php',['saldo'	=> $this->saldounit()],true);
		// $pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/pendapatan.php',['pendapatan'	=> $this->pendapatan()],true);
		// $pdf->writeHTML($view);

		// $view = $this->load->view('dailyreport/outstanding/index.php',['outstanding'=> $this->data()],true);
		// $pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/pengeluaran.php',['pengeluaran'	=> $this->pengeluaran()],true);
		// $pdf->writeHTML($view);

		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/outstanding/rate.php',['rate'	=> $this->rate()],true);
		$pdf->writeHTML($view);

		//view
		$pdf->Output('GHAnet_Summary_'.date('d_m_Y').'.pdf', 'I');
	}

	public function rate()
	{
		$units = $this->units->typerates();
		return $units;
	}
	
	public function pelunasan()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('units.id', $code);
		}
		if($id_unit = $this->input->get('id_unit')){
			$this->units->db->where('units.id', $id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$date = date('Y-m-d', strtotime($date. ' +1 days'));
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
				$dates[] =  $this->regular->getRepaymentToday($unit->id, $date->format('Y-m-d'))->up;
			}
			$unit->dates = $dates;
			$result[] = $unit;
		}
		return $result;
	}

	public function datetrans(){
		$date = date('Y-m-d');
		$lastdate = $this->regular->getLastDateTransaction()->date;
		if ($date > $lastdate){
			$date = $lastdate;
		}else{
			$date= $date;
		}

		return date('d-m-Y',strtotime($date));
	}

	public function dataNew()
	{
		
		$date = date('Y-m-d');
		$lastdate = $this->regular->getLastDateTransaction()->date;
		if ($date > $lastdate){
			$date = $lastdate;
		}else{
			$date= $date;
		}
		$nextdate = date('Y-m-d', strtotime('+1 days', strtotime($date)));
		$year = date('Y', strtotime('+1 days', strtotime($date)));
		$month = date('n', strtotime('+1 days', strtotime($date)));
		// $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$getOstYesterday = $this->regular->db
				->where('date <', $date)
				->from('units_outstanding')
				->where('id_unit', $unit->id)
				->order_by('date','DESC')
				->get()->row();
			$unit->ost_yesterday = (object) array(
				'noa'	=> $getOstYesterday->noa,
				'up'	=> $getOstYesterday->os
			);
			$unit->credit_today = $this->regular->creditToday($unit->id, $date);
			$unit->repayment_today = $this->regular->repaymentToday($unit->id, $date);
			$unit->total = (object) array(
				'noa'	=> $unit->ost_yesterday->noa + $unit->credit_today->reguler['noa'] - $unit->repayment_today->reguler['noa'],
				'up'	=> $unit->ost_yesterday->up +  $unit->credit_today->reguler['up'] +  $unit->credit_today->mortage['up'] -
				$unit->repayment_today->reguler['up'] -  $unit->repayment_today->mortage['up']
				,
			);
		}
		return $units;
	}

	public function pencairan()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('units.id', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$date = date('Y-m-d', strtotime($date.' +1 days'));
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
		return $result;
	}

	public function saldounit($date)
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('id_unit')){
			$this->units->db->where('id_unit', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}

		$this->units->db
			->select('id_unit, name, amount,areas.area, cut_off,( (
				select (sum(CASE WHEN s.type = "CASH_IN" THEN `amount` ELSE 0 END) - sum(CASE WHEN s.type = "CASH_OUT" THEN `amount` ELSE 0 END))
				from units_dailycashs as s
				where s.id_unit = units_saldo.id_unit
				and s.date > units_saldo.cut_off
			) + units_saldo.amount )as amount')
			->select('( (
				select (sum(CASE WHEN s.type = "CASH_IN" THEN `amount` ELSE 0 END) - sum(CASE WHEN s.type = "CASH_OUT" THEN `amount` ELSE 0 END))
				from units_dailycashs as s
				where s.id_unit = units_saldo.id_unit
				and s.date > units_saldo.cut_off
				and s.date <= "'.date('Y-m-d', strtotime($date.' -1 days')).'"
			) + units_saldo.amount )as amount1'
			)
			->select('( (
				select (sum(CASE WHEN s.type = "CASH_IN" THEN `amount` ELSE 0 END) - sum(CASE WHEN s.type = "CASH_OUT" THEN `amount` ELSE 0 END))
				from units_dailycashs as s
				where s.id_unit = units_saldo.id_unit
				and s.date > units_saldo.cut_off
				and s.date <= "'.date('Y-m-d', strtotime($date.' -2 days')).'"
			) + units_saldo.amount )as amount2'
			)
			->DISTINCT ('id_unit')
			->from('units_saldo')			
			->join('units','units.id = units_saldo.id_unit')
			->join('areas','areas.id = units.id_area')
			->order_by('amount', 'desc');
		$getSaldo = $this->units->db->get()->result();
		return $getSaldo;
	}

	public function data()
	{
		// if($area = $this->input->get('area')){
		// 	$this->units->db->where('id_area', $area);
		// }else if($this->session->userdata('user')->level == 'area'){
		// 	$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		// }
		// if($id_unit = $this->input->get('id_unit')){
		// 	$this->units->db->where('units.id', $id_unit);
		// }else if($code = $this->input->get('code')){
		// 	$this->units->db->where('code', zero_fill($code, 3));
		// }else if($this->session->userdata('user')->level == 'unit'){
		// 	$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		// }
		// if($this->input->get('date')){
		// 	$date = $this->input->get('date');
		// }else{
		// 	$date = date('Y-m-d');
		// }

		$date = date('Y-m-d');
		$lastdate = $this->regular->getLastDateTransaction()->date;
		if ($date > $lastdate){
			$date = $lastdate;
		}else{
			$date= $date;
		}
		$nextdate = date('Y-m-d', strtotime('+1 days', strtotime($date)));
		$year = date('Y', strtotime('+1 days', strtotime($date)));
		$month = date('n', strtotime('+1 days', strtotime($date)));
		// $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			$getOstYesterday = $this->regular->db
				->where('date <', $date)
				->from('units_outstanding')
				->where('id_unit', $unit->id)
				->order_by('date','DESC')
				->get()->row();
			$unit->ost_yesterday = (object) array(
				'noa'	=> $getOstYesterday->noa,
				'up'	=> $getOstYesterday->os
			);
			$unit->credit_today = $this->regular->getCreditToday($unit->id, $date);
			$unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $date);
			$totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa - $unit->repayment_today->noa;
			$totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up - $unit->repayment_today->up;
			
			//target
			$target = $this->regular->db
				->select('amount_booking')
				->where('month', date('n', strtotime($date)))
				->where('year', date('Y', strtotime($date)))
				->where('id_unit', $unit->id)
				->get('units_targets')->row();
			
			if($target){
				$target = $target->amount_booking;
			}else{
				$target = 0;
			}
			$booking =  $this->mortages->unitMontly($unit->id,  date('n', strtotime($date)), date('Y', strtotime($date)))->up + $this->regular->unitMontly($unit->id, date('n', strtotime($date)), date('Y', strtotime($date)))->up;

			$unit->target = (object) array(
				'up'	=> $target,
				'booking'	=> $booking,
				'persentase'	=> $target ? round($booking / $target,2) : 0
			); 
	
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

	public function pendapatan()
	{
		$listperk = $this->m_casing->get_list_pendapatan();
		$category=array();
		foreach ($listperk as $value) {
			array_push($category, $value->no_perk);
		}
		
		if($this->input->get('area')){
			$area = $this->input->get('area');
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		
		if($this->input->get('code')){
			$code = $this->input->get('code');
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('id_unit', $this->session->userdata('user')->id_unit);
		}

		if($this->input->get('date')){
			$date = $this->input->get('date');
			$this->units->db->where('date', $date);
		}

		if($this->input->get('month')){
			$month = $this->input->get('month');
			$this->units->db->where('MONTH(date)', $month);
		}

		$month = date('n', strtotime($this->datetrans()));

		$this->units->db->select('units.name,areas.area, sum(amount) as amount')
			->join('units','units.id = units_dailycashs.id_unit')
			->join('areas','areas.id = units.id_area')
			->from('units_dailycashs')
			->where('type','CASH_IN')	
			->where('MONTH(date)', $month)
			->where_in('no_perk', $category)
			->group_by('units.name')
			->group_by('areas.area')
			->order_by('amount','DESC')
			->order_by('areas.area','asc');
			//->order_by('units.id','desc');
		$data = $this->units->db->get()->result();
		//echo "<pre/>";
		//print_r($data);
		return  $data;
	}

	public function pengeluaran()
	{
		$listperk = $this->m_casing->get_list_pengeluaran();
		$category=array();
		foreach ($listperk as $value) {
			array_push($category, $value->no_perk);
		}
		
		if($this->input->get('area')){
			$area = $this->input->get('area');
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}

		if($this->input->get('code')){
			$code = $this->input->get('code');
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('id_unit', $this->session->userdata('user')->id_unit);
		}

		if($this->input->get('date')){
			$date = $this->input->get('date');
			$this->units->db->where('date', $date);
		}

		if($this->input->get('month')){
			$month = $this->input->get('month');
			$this->units->db->where('MONTH(date)', $month);
		}

		$month = date('n', strtotime($this->datetrans()));
		
		$this->units->db->select('units.name,areas.area, sum(amount) as amount')
			->join('units','units.id = units_dailycashs.id_unit')
			->join('areas','areas.id = units.id_area')
			->from('units_dailycashs')
			->where('type','CASH_OUT')
			->where('MONTH(date)', $month)
			->where_in('no_perk', $category)
			->group_by('units.name')
			->group_by('areas.area')
			->order_by('amount','DESC')
			->order_by('areas.area','asc');
		$data = $this->units->db->get()->result();
		return $data; //->sendMessage($data,'Successfully get Pendapatan');
	}
	

}
