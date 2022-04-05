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
		$this->load->model('LmStocksModel','stock');
		$this->load->model('LmGramsModel','grams');
		$this->load->model('RepaymentSummaryModel','repayments_summaries');
	}

	public function target($date)
	{		
		$this->units->db
					->select('units.id, units.name, area')
					->select('(
						select COALESCE(t.amount_booking,0) from units_targets t where units.id = t.id_unit
						and month = "'.date('n', strtotime($date)).'"
						and year = "'.date('Y', strtotime($date)).'"
						limit 1
					) as up')
					->select('
					(
						(
							(
								select COALESCE(sum(amount),0) from units_regularpawns ur where ur.id_unit = units.id
								and year(date_sbk) = "'.date('Y', strtotime($date)).'"
								and month(date_sbk) = "'.date('n', strtotime($date)).'"
							) +
							(
								select COALESCE(sum(amount_loan),0) from units_mortages um where um.id_unit = units.id
								and year(date_sbk) = "'.date('Y', strtotime($date)).'"
								and month(date_sbk) = "'.date('n', strtotime($date)).'"
							)
						) /						
						(select COALESCE(t.amount_booking,0) from units_targets t where units.id = t.id_unit
						and month = "'.date('n', strtotime($date)).'"
						and year = "'.date('Y', strtotime($date)).'"
						limit 1)
					) as persentase')
					->select('(
						(
							select COALESCE(sum(amount),0) from units_regularpawns ur where ur.id_unit = units.id
							and year(date_sbk) = "'.date('Y', strtotime($date)).'"
							and month(date_sbk) = "'.date('n', strtotime($date)).'"
						) +
						(
							select COALESCE(sum(amount_loan),0) from units_mortages um where um.id_unit = units.id
							and year(date_sbk) = "'.date('Y', strtotime($date)).'"
							and month(date_sbk) = "'.date('n', strtotime($date)).'"
						)
					) as booking')
					->select('(
						(
							select COALESCE(count(amount),0) from units_regularpawns ur where ur.id_unit = units.id
							and year(date_sbk) = "'.date('Y', strtotime($date)).'"
							and month(date_sbk) = "'.date('n', strtotime($date)).'"
						) +
						(
							select COALESCE(count(amount_loan),0) from units_mortages um where um.id_unit = units.id
							and year(date_sbk) = "'.date('Y', strtotime($date)).'"
							and month(date_sbk) = "'.date('n', strtotime($date)).'"
						)
					) as noa')
					->join('areas','areas.id = units.id_area')
					->order_by('booking', 'desc');
		return $this->units->db->get('units')->result();
	}

	public function grouped($os)
	{
		$result = [];
		foreach($os as $index =>  $data){
			$result[$data->area][$index] = $data;
		}
		return $result;
	}

	public function calculate_repayment($date)
	{
		$units = $this->units->db->select('id, name')->from('units')
			->get()->result();
		$dateStart = date('Y-m-d', strtotime(date('Y-m-01', strtotime($date))));
		$date = date('Y-m-d', strtotime($date));
		$insert = [];
		$update = [];
		$data = [];
		foreach($units as $index => $unit){
			$akumulasiUp = (int) $this->repayments->db->select('sum(urm.money_loan) as up,
			count(id) as noa
			')
				->from('units_repayments urm')
				->where('urm.date_repayment >=', $dateStart)
				->where('urm.date_repayment <=', $date)
				->where('urm.id_unit', $unit->id)
				->get();
			$akumulasiOver = (int) $this->repayments->db->select('sum(urm.money_loan) as up,
			count(id) as noa
			')
				->from('units_repayments urm')
				->where('urm.date_repayment >=', $dateStart)
				->where('urm.date_repayment <=', $date)
				->where("DATEDIFF( urm.date_repayment, urm.date_sbk) >", 120)
				->where('urm.id_unit', $unit->id)
				->get()->row()->up;
			$akumulasiPrev = (int) $this->repayments->db->select('sum(urm.money_loan) as up,
				count(id) as noa
				')
					->from('units_repayments urm')
					->where('urm.date_repayment >=', $dateStart)
					->where('urm.date_repayment <=', $date)
					->where("DATEDIFF(urm.date_repayment, urm.date_sbk) <=", 120)
					->where('urm.id_unit', $unit->id)
					->get()->row()->up;

			$todayUp = (int) $this->repayments->db->select('sum(urm.money_loan) as up,
				count(id) as noa
				')
				->from('units_repayments urm')
				->where('urm.date_repayment', $date)
				->where('urm.id_unit', $unit->id)
				->get();
			$todayOver = (int) $this->repayments->db->select('sum(urm.money_loan) as up,
				count(id) as noa
				')
				->from('units_repayments urm')
				->where('urm.date_repayment', $date)
				->where("DATEDIFF( urm.date_repayment, urm.date_sbk) >", 120)
				->where('urm.id_unit', $unit->id)
				->get()->row()->up;
			
			$todayPrev =  (int) $this->repayments->db->select('sum(urm.money_loan) as up,
				count(id) as noa
				')
				->from('units_repayments urm')
				->where('urm.date_repayment', $date)
				->where("DATEDIFF(urm.date_repayment, urm.date_sbk) <=", 120)
				->where('urm.id_unit', $unit->id)
				->get()->row()->up;
			$mortagesTodayUp = (int) $this->repayments->db->select('sum(urm.amount) as up,
				count(id) as noa
				')
				->from('units_repayments_mortage urm')
				->where('urm.date_kredit', $date)
				->where('urm.id_unit', $unit->id)
				->get()->row()->up;

			$wherePrev = "
			(select deadline  from units_mortages um
			where um.id_unit = urm.id_unit
			and um.no_sbk = urm.no_sbk
			and um.permit = urm.permit
			limit 1)
			>= urm.date_kredit";

			$whereOver = "
			(select deadline  from units_mortages um
			where um.id_unit = urm.id_unit
			and um.no_sbk = urm.no_sbk
			and um.permit = urm.permit
			limit 1)
			<= urm.date_kredit";
			
			$mortagesTodayPrev = (int) $this->repayments->db->select('sum(amount) as up
			')
				->from('units_repayments_mortage urm')
				->where('urm.date_kredit', $date)
				->where($wherePrev)
				->where('urm.id_unit', $unit->id)
				->get()->row()->up;
			$mortagesTodayOver = (int) $this->repayments->db->select('sum(amount) as up
			')
				->from('units_repayments_mortage urm')
				->where('urm.date_kredit', $date)
				->where($whereOver)
				->where('urm.id_unit', $unit->id)
				->get()->row()->up;

		

			$check = $this->repayments_summaries->find([
				'date'	=> $date,
				'id_unit'	=> $unit->id
			]);

			if($check){
				$update[$index] = [
					'id'	=> $check->id,
					'id_unit'	=> $unit->id,
					'date'	=> $date,
					'no_ak'	=>  $akumulasiUp->noa,
					'akumulasi_up'	=>  $akumulasiUp->up,
					'akumulasi_over'	=> $akumulasiOver > 0 ? (($akumulasiOver / $akumulasiUp->up) *100) : 0,
					'akumulasi_prev'	=>  $akumulasiPrev > 0 ? (($akumulasiPrev / $akumulasiUp->up) * 100) : 0,
					'noa_to'	=> $todayUp->noa,
					'today_up'	=> $todayUp->up,
					'today_over'	=> $todayOver > 0 ? (($todayOver / $todayUp->up) * 100) : 0,
					'today_prev'	=> $todayPrev > 0 ? (($todayPrev / $todayUp->up) * 100) : 0,
					'today_up_loan'	=> $mortagesTodayUp,
					'today_over_loan'	=> $mortagesTodayOver > 0 ? (($mortagesTodayOver / $mortagesTodayUp) * 100) : 0,
					'today_prev_loan'	=> $mortagesTodayPrev > 0 ? (($mortagesTodayPrev / $mortagesTodayUp) * 100) : 0,
			
				];
			}else{			
				$insert[$index] = [
					'id_unit'	=> $unit->id,
					'date'	=> $date,
					'noa_to'	=> $todayUp->noa,
					'today_up'	=> $todayUp->up,
					'today_over'	=> $todayOver > 0 ? (($todayOver / $todayUp->up) * 100) : 0,
					'today_prev'	=> $todayPrev > 0 ? (($todayPrev / $todayUp->up) * 100) : 0,
					'noa_ak'	=> $akumulasiUp->noa,
					'akumulasi_up'	=>  $akumulasiUp->up,
					'akumulasi_over'	=> $akumulasiOver > 0 ? (($akumulasiOver / $akumulasiUp->up) *100) : 0,
					'akumulasi_prev'	=>  $akumulasiPrev > 0 ? (($akumulasiPrev / $akumulasiUp->up) * 100) : 0,
					'today_up_loan'	=> $mortagesTodayUp,
					'today_over_loan'	=> $mortagesTodayOver > 0 ? (($mortagesTodayOver / $mortagesTodayUp) * 100) : 0,
					'today_prev_loan'	=> $mortagesTodayPrev > 0 ? (($mortagesTodayPrev / $mortagesTodayUp) * 100) : 0,
				];
			}
			$data[$index] = (object) [
				'id_unit'	=> $unit->id,
				'date'	=> $date,
				'noa_ak'	=> $akumulasiUp->noa,
				'akumulasi_up'	=>  $akumulasiUp->up,
				'akumulasi_over'	=> $akumulasiOver > 0 ? (($akumulasiOver / $akumulasiUp->up) *100) : 0,
				'akumulasi_prev'	=>  $akumulasiPrev > 0 ? (($akumulasiPrev / $akumulasiUp->up) * 100) : 0,
				'noa_to'	=> $todayUp->noa,
				'today_up'	=> $todayUp->up,
				'today_over'	=> $todayOver > 0 ? (($todayOver / $todayUp->up) * 100) : 0,
				'today_prev'	=> $todayPrev > 0 ? (($todayPrev / $todayUp->up) * 100) : 0,
				'today_up_loan'	=> $mortagesTodayUp,
				'today_over_loan'	=> $mortagesTodayOver > 0 ? (($mortagesTodayOver / $mortagesTodayUp) * 100) : 0,
				'today_prev_loan'	=> $mortagesTodayPrev > 0 ? (($mortagesTodayPrev / $mortagesTodayUp) * 100) : 0,
			];
		}
		if(count($insert)){
			$this->repayments->db->insert_batch('units_repayments_summaries', $insert);
		}
		if(count($update)){
			$this->repayments->db->update_batch('units_repayments_summaries', $update, 'id');
		}
		return (object) $data;
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';

		$curr = $this->datetrans();

		$repayments = $this->repayments_summaries->db
			->select('units.name as unit, areas.area, units_repayments_summaries.*')
			->from('units_repayments_summaries')
			->join('units','units.id =units_repayments_summaries.id_unit ')
			->join('areas','areas.id = units.id_area')
			->where('date', date('Y-m-d', strtotime($curr)) )
			->get()->result();

		if(count($repayments) <= 0){
			$this->calculate_repayment($this->datetrans());
			$repayments = $this->repayments_summaries->db
				->select('units.name as unit, areas.area,units_repayments_summaries.*')
				->from('units_repayments_summaries')
				->join('units','units.id = units_repayments_summaries.id_unit ')
				->join('areas','areas.id = units.id_area')
				->where('date', date('Y-m-d', strtotime($curr)) )
				->get()->result();
		}

		

		//$os = $this->data();
		// $grouped = $this->grouped($os);
		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/index.php',['outstanding'=>$grouped,'datetrans'=> $this->datetrans()],true);
		// $pdf->writeHTML($view);

		$newos = $this->reportoutstanding();
		$grouped = $this->grouped($newos);
		$pdf->AddPage('L', 'A3');
		$view = $this->load->view('dailyreport/outstanding/generate.php',['outstanding'=>$grouped,'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		// $osmortages = $this->dataMortages();
		// $groupedMortages = $this->grouped($osmortages);
		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/mortages.php',['outstanding'=>$groupedMortages,'datetrans'=> $this->datetrans()],true);
		// $pdf->writeHTML($view);

		$pdf->AddPage('L','A4');
		$view = $this->load->view('dailyreport/outstanding/repayments.php',['repayments'=>$repayments,'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);	

		$os = $this->model->db
			->select('units.name, areas.area, units_dpd.*')
			->from('units_dpd')
			->join('units','units.id = units_dpd.id_unit')
			->join('areas','areas.id = units.id_area')
			->where('date', date('Y-m-d', strtotime($curr)))->get()->result();
		$pdf->AddPage('L','A3');
		$view = $this->load->view('dailyreport/outstanding/dpd.php',['dpd'=>$os,'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);		

		$pdf->AddPage('L','A4');
		$view = $this->load->view('dailyreport/outstanding/target.php',['data'=>$this->target($this->datetrans()),'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		$pdf->AddPage('L','A4');
		$view = $this->load->view('dailyreport/outstanding/target_os.php',['data'=>$newos,'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/pencairan.php',['pencairan'	=> $this->pencairan()],true);
		// $pdf->writeHTML($view);

		// $pdf->AddPage('L');
		// $view = $this->load->view('dailyreport/outstanding/pelunasan.php',['pelunasan'	=> $this->pelunasan()],true);
		// $pdf->writeHTML($view);

		$pdf->AddPage('L','A4');
		$group = $this->grouped($this->rate());
		$view = $this->load->view('dailyreport/outstanding/rate.php',['areas'	=> $group],true);
		$pdf->writeHTML($view);

		$pdf->AddPage('L','A4');
		$view = $this->load->view('dailyreport/outstanding/saldo.php',[
			'saldo'	=> $this->saldounit($this->datetrans()),
			'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		$pdf->AddPage('L','A4');
		$view = $this->load->view('dailyreport/outstanding/pendapatan.php',['pendapatan'	=> $this->pendapatan(),
		'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		$pdf->AddPage('L','A4');
		$view = $this->load->view('dailyreport/outstanding/pengeluaran.php',['pengeluaran'	=> $this->pengeluaran(),
		'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		$coas = $this->dailycash->pengeluaran_perk($this->datetrans());

		$pdf->AddPage('L','A4');
		$view = $this->load->view('dailyreport/outstanding/pengeluaran_operasi',[
			'coas'=>$coas	,
			'datetrans'	=> $this->datetrans()
		],true);

		$pdf->writeHTML($view);
		

		$areas = $this->dailycash-> getCocCalcutation(null,  11,date('n', strtotime($this->datetrans())), date('Y', strtotime($this->datetrans())),  0,  0);
		$pdf->AddPage('L','A4');
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

		// $newos = $this->reportoutstanding();
		// $grouped = $this->grouped($newos);
		// $pdf->AddPage('L', 'A3');
		// $view = $this->load->view('dailyreport/outstanding/generate.php',['outstanding'=>$grouped,'datetrans'=> $this->datetrans()],true);
		// $pdf->writeHTML($view);

		$os = $this->data();
		$pdf->AddPage('L','A4');
		$view = $this->load->view('dailyreport/outstanding/dpd.php',['dpd'=>$os,'datetrans'=> $this->datetrans()],true);
		$pdf->writeHTML($view);

		//view
		$pdf->Output('GHAnet_Summary_'.date('d_m_Y').'.pdf', 'I');
	}

	public function generatereport()
	{
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';

		$os = $this->data();
		$pdf->AddPage('L', 'A3');
		$view = $this->load->view('dailyreport/outstanding/generate.php',['outstanding'=> $this->data()],true);
		$pdf->writeHTML($view);

		//view
		$pdf->Output('GHAnet_Summary_'.date('d_m_Y').'.pdf', 'I');
	}

	public function dataoutstanding()
	{

		$date = '2021-01-14';
		$date = date('Y-m-d');
		$lastdate = $this->regular->getLastDateTransaction()->date;
		if ($date > $lastdate){
			$date = $lastdate;
		}else{
			$date= $date;
		}

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
										'noa_regular'	=> $getOstYesterday->noa_os_regular,
										'os_regular'	=> $getOstYesterday->os_regular,
										'noa_mortages'	=> $getOstYesterday->noa_os_mortage,
										'os_mortages'	=> $getOstYesterday->os_mortage,
									);						

			$getOstToday 	= $this->regular->db
									->where('date <=', $date)
									->from('units_outstanding')
									->where('id_unit', $unit->id)
									->order_by('date','DESC')
									->get()->row();
			
			$unit->ost_today = (object) array(
										'noa_regular'			=> $getOstToday->noa_regular,
										'up_regular'			=> $getOstToday->up_regular,
										'noa_repyment_regular'	=> $getOstToday->noa_repyment_regular,
										'repyment_regular'		=> $getOstToday->repyment_regular,
										'noa_mortage'			=> $getOstToday->noa_mortage,
										'up_mortage'			=> $getOstToday->up_mortage,
										'noa_repayment_mortage'	=> $getOstToday->noa_repayment_mortage,
										'repayment_mortage'		=> $getOstToday->repayment_mortage,
									);
			$totalNoa = (int) ($getOstYesterday->noa_os_regular + $getOstYesterday->noa_os_mortage + $getOstToday->noa_regular + $getOstToday->noa_mortage) - ($getOstToday->noa_repyment_regular + $getOstToday->noa_mortage);
			$totalUp = (int) ($getOstYesterday->os_regular + $getOstYesterday->os_mortage + $getOstToday->up_regular + $getOstToday->up_mortage) - ($getOstToday->repyment_regular + $getOstToday->repayment_mortage);
			$unit->disburse = (object) array(
				'noa'	=> $totalNoa,
				'up'	=> $totalUp,
				'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
			);
						
		}	
		return $units;
	}

	public function dpd()
	{
		//$date = '2021-01-15';
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
				'up'	=> $getOstYesterday->os,
				'noa_mortages'	=> $getOstYesterday->noa_os_mortage,
				'up_mortages'	=> $getOstYesterday->os_mortage
			);
			$unit->credit_today = $this->regular->getCreditToday($unit->id, $date);
			$unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $date);
			$totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa - $unit->repayment_today->noa;
			$totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up - $unit->repayment_today->up;		
	
			$unit->total_outstanding = (object) array(
				'noa'	=> $totalNoa,
				'up'	=> $totalUp,
				'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
			);

			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id, null, null, $date);
			$unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id,  date('Y', strtotime('-1 days', strtotime($getOstYesterday->date))));
			$unit->dpd_today = $this->regular->getDpdToday($unit->id, $getOstYesterday->date);
			$unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id,$date);
			$unit->total_dpd = (object) array(
				'noa'	=> $unit->dpd_today->noa + $unit->dpd_yesterday->noa - $unit->dpd_repayment_today->noa,
				'ost'	=> $unit->dpd_today->ost + $unit->dpd_yesterday->ost - $unit->dpd_repayment_today->ost,
			);
			$unit->percentage = ($unit->total_dpd->ost > 0) && ($unit->total_outstanding->up > 0) ? round($unit->total_dpd->ost / $unit->total_outstanding->up, 4) : 0;
		}
		return $units;
	}

	public function yogadai(){
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';

		$os = $this->yg_outstanding();
		$pdf->AddPage('L');
		$view = $this->load->view('dailyreport/yogadai/index.php',['outstanding'=>$os],true);
		$pdf->writeHTML($view);

		//view
		$pdf->Output('GHAnet_Summary_'.date('d_m_Y').'.pdf', 'I');
	}

	public function yg_outstanding(){
		$this->load->helper("curl_helper");
		$url 		= $this->config->item('url_outstanding');
		$username 	= $this->config->item('api_username');
		$password 	= $this->config->item('api_password');

		$response = basic_auth_post($url,$username,$password,array());
		$response = array($response);
		//return 
		$array = json_decode(json_encode($response), true);
		echo "<pre/>";
		print_r($array);
		//var_dump($response);
		//return json_decode($response); //$response;
		//echo "<prev/>";
		//print_r($response);
		// foreach ($response as $data){
		// 	//var_dump($data);
		// 		print_r($data);
		// }
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
		//$date = '2021-01-15';
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
		//$date = date('Y-m-d', strtotime('+1 days', strtotime($date)));

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
				'noa'	=> $getOstYesterday->noa_os_regular,
				'up'	=> $getOstYesterday->os_regular,
				'noa_mortages'	=> $getOstYesterday->noa_os_mortage,
				'up_mortages'	=> $getOstYesterday->os_mortage
				);

				$getOstToday = $this->regular->db
				->where('date <=', $date)
				->from('units_outstanding')
				->where('id_unit', $unit->id)
				->order_by('date','DESC')
				->get()->row();

				$unit->ost_today = (object) array(
					'noa'					=> $getOstToday->noa_regular,
					'up'					=> $getOstToday->up_regular,
					'repayment'				=> $getOstToday->repyment_regular,
					'noa_mortages'			=> $getOstToday->noa_mortage,
					'repayment_mortatges'	=> $getOstToday->repayment_mortage,
					'up_mortages'			=> $getOstToday->up_mortage,
					'os_regular'			=> $getOstToday->os_regular,
					'os_mortage'			=> $getOstToday->os_mortage,
					);


			$unit->credit_today = $this->regular->getCreditToday($unit->id, $date);
			$unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $date);
			$totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa - $unit->repayment_today->noa;
			$totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up - $unit->repayment_today->up;
			$totalOS = (int) $unit->ost_today->os_regular + $unit->ost_today->os_mortage;
			//$totalOS = 0;
			
			//target
			$target = $this->regular->db
				->select('amount_booking, amount_outstanding')
				->where('month', date('n', strtotime($date)))
				->where('year', date('Y', strtotime($date)))
				->where('id_unit', $unit->id)
				->get('units_targets')->row();

			if($target){
				$targetos = $target->amount_outstanding;
				$unit->target_os = $targetos;
			}else{
				$targetos = 0;
				$unit->target_os = $targetos;
			}

			if($target){
				$target = $target->amount_booking;
			}else{
				$target = 0;
			}

	
			$unit->total_outstanding = (object) array(
				'noa'	=> $totalNoa,
				'up'	=> $totalUp,
				'os'	=> $totalOS,
				'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
			);

			$dpddate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id, null, null, $date);
			$unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id, $dpddate);
			$unit->dpd_today = $this->regular->getDpdToday($unit->id, $dpddate);
			$unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id,$dpddate);
			$unit->dpd_repayment_Deadline = $this->regular->getRepaymentDeadline($unit->id,$dpddate);
			
			$unit->total_dpd = (object) array(
				//'noa'	=> $unit->dpd_today->noa + $unit->dpd_yesterday->noa,
				//'ost'	=> $unit->dpd_today->ost + $unit->dpd_yesterday->ost,
				// 'noa_today'	=> $unit->dpd_today->noa + $unit->dpd_repayment_today->noa,
				// 'ost_today'	=> $unit->dpd_today->ost + $unit->dpd_repayment_today->ost,
				// 'noa'		=> ($unit->dpd_today->noa + $unit->dpd_yesterday->noa +$unit->dpd_repayment_today->noa) - $unit->dpd_repayment_today->noa,
				// 'ost'		=> ($unit->dpd_today->ost + $unit->dpd_yesterday->ost +$unit->dpd_repayment_today->ost) - $unit->dpd_repayment_today->ost,
				'noa_yesterday'	=> $unit->dpd_yesterday->noa + $unit->dpd_repayment_today->noa,
				'ost_yesterday'	=> $unit->dpd_yesterday->ost + $unit->dpd_repayment_today->ost,
				'noa_today'	=> $unit->dpd_today->noa + $unit->dpd_repayment_Deadline->noa,
				'ost_today'	=> $unit->dpd_today->ost + $unit->dpd_repayment_Deadline->ost,
				'noa_repayment'	=> $unit->dpd_repayment_today->noa,
				'ost_repayment'	=> $unit->dpd_repayment_today->ost,
				'noa'		=> ($unit->dpd_yesterday->noa + $unit->dpd_today->noa + $unit->dpd_repayment_Deadline->noa + $unit->dpd_repayment_today->noa) - $unit->dpd_repayment_today->noa,
				'ost'		=> ($unit->dpd_yesterday->ost + $unit->dpd_today->ost + $unit->dpd_repayment_Deadline->ost + $unit->dpd_repayment_today->ost) - $unit->dpd_repayment_today->ost,
			);
			$unit->percentage = ($unit->total_dpd->ost > 0) && ($unit->total_outstanding->os > 0) ? round($unit->total_dpd->ost / $unit->total_outstanding->os, 4) : 0;
		//print_r($unit->dpd_repayment_Deadline);
		}
		return $units;
	}

	public function reportoutstanding()
	{
		//$date = '2021-01-15';
		$date = date('Y-m-d');
		$lastdate = $this->regular->getLastDateTransaction()->date;
		if ($date > $lastdate){
			$date = $lastdate;
		}else{
			$date= $date;
		}

		//$nextdate = date('Y-m-d', strtotime('+1 days', strtotime($date)));
		$lasdate = date('Y-m-d', strtotime('-1 days', strtotime($date)));
		//$year = date('Y', strtotime('+1 days', strtotime($date)));
		//$month = date('n', strtotime('+1 days', strtotime($date)));

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
				'noa_os_reguler'	=> $getOstYesterday->noa_os_regular,
				'os_reguler'		=> $getOstYesterday->os_regular,
				'noa_os_mortages'	=> $getOstYesterday->noa_os_mortage,
				'os_mortages'		=> $getOstYesterday->os_mortage
			);

			$getOstToday = $this->regular->db
								->where('date <=', $date)
								->from('units_outstanding')
								->where('id_unit', $unit->id)
								->order_by('date','DESC')
								->get()->row();
			
			$unit->ost_today = (object) array(
				'noa_reguler'		=> $getOstToday->noa_regular,
				'up_reguler'		=> $getOstToday->up_regular,
				'noa_rep_reguler'	=> $getOstToday->noa_repyment_regular,
				'up_rep_reguler'	=> $getOstToday->repyment_regular,
				'noa_mortages'		=> $getOstToday->noa_mortage,
				'up_mortages'		=> $getOstToday->up_mortage,
				'noa_rep_mortages'	=> $getOstToday->noa_repayment_mortage,
				'up_rep_mortages'	=> $getOstToday->repayment_mortage
			);

			$target = $this->regular->db
					->select('amount_booking, amount_outstanding')
					->where('month', date('n', strtotime($date)))
					->where('year', date('Y', strtotime($date)))
					->where('id_unit', $unit->id)
					->get('units_targets')->row();
			$totalNoaReg = ($unit->ost_yesterday->noa_os_reguler + $unit->ost_today->noa_reguler)-($unit->ost_today->noa_rep_reguler);
			$totalUpReg = ($unit->ost_yesterday->os_reguler+ $unit->ost_today->up_reguler)-($unit->ost_today->up_rep_reguler);
			$totalNoaMor = ($unit->ost_yesterday->noa_os_mortages + $unit->ost_today->noa_mortages)-($unit->ost_today->noa_rep_mortages);
			$totalUpMor = ($unit->ost_yesterday->os_mortages+ $unit->ost_today->up_mortages)-($unit->ost_today->up_rep_mortages);
			$totalOut = $totalUpReg + $totalUpMor; 
			$totalNoa = $totalNoaReg + $totalNoaMor;
			$unit->target_os = (int) $target->amount_outstanding;
			$unit->total_outstanding = (object) [
				'up'	=> 	$totalOut,
				'noa'	=> $totalNoa
			];

			// $unit->credit_today = $this->regular->getCreditToday($unit->id, $date);
			// $unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $date);
			// $totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa - $unit->repayment_today->noa;
			// $totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up - $unit->repayment_today->up;
				
			// $unit->total_outstanding = (object) array(
			// 	'noa'	=> $totalNoa,
			// 	'up'	=> $totalUp,
			// 	'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
			// );

			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id, null, null, $date);
			// $unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id, $date);
			// $unit->dpd_today = $this->regular->getDpdToday($unit->id, $date);
			// $unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id,$date);
			// $unit->total_dpd = (object) array(
			// 	//'noa'	=> $unit->dpd_today->noa + $unit->dpd_yesterday->noa,
			// 	//'ost'	=> $unit->dpd_today->ost + $unit->dpd_yesterday->ost,
			// 	'noa_today'	=> $unit->dpd_today->noa + $unit->dpd_repayment_today->noa,
			// 	'ost_today'	=> $unit->dpd_today->ost + $unit->dpd_repayment_today->ost,
			// 	'noa'	=> ($unit->dpd_today->noa + $unit->dpd_yesterday->noa +$unit->dpd_repayment_today->noa) - $unit->dpd_repayment_today->noa,
			// 	'ost'	=> ($unit->dpd_today->ost + $unit->dpd_yesterday->ost +$unit->dpd_repayment_today->ost) - $unit->dpd_repayment_today->ost,
			// );
			// $unit->percentage = ($unit->total_dpd->ost > 0) && ($unit->total_outstanding->up > 0) ? round($unit->total_dpd->ost / $unit->total_outstanding->up, 4) : 0;
		}
		//echo "<pre/>";
		//print_r($units);
		return $units;
	}


	public function dataMortages()
	{	

		//$date = '2021-01-15';
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
				'noa'	=> $getOstYesterday->noa_os_mortage,
				'up'	=> $getOstYesterday->os_mortage
			);

			$unit->credit_today = $this->regular->getCreditToday($unit->id, $date);
			$unit->repayment_today = $this->regular->getRepaymentToday($unit->id, $date);
			$totalNoa = (int) $unit->ost_yesterday->noa + $unit->credit_today->noa_mortage - $unit->repayment_today->noa_mortage;
			$totalUp = (int) $unit->ost_yesterday->up + $unit->credit_today->up_mortage - $unit->repayment_today->up_mortage;
		
	
			$unit->total_outstanding = (object) array(
				'noa'	=> $totalNoa,
				'up'	=> $totalUp,
				'tiket'	=> round($totalUp > 0 ? $totalUp /$totalNoa : 0)
			);
			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id, null, null, $date);
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
