<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';

class Dashboards extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Dashboards';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AreasModel','areas');
		$this->load->model('RegularPawnsModel', 'regular');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('RepaymentModel','repayments');
		$this->load->model('MappingcaseModel', 'm_casing');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$data['permit'] = "All";
		$this->load->view("dashboard/index",$data);
	}

	public function ojk()
	{
		$data['permit'] = "OJK";
		$this->load->view("dashboard/ojk",$data);
	}

	public function nonojk()
	{
		$data['permit'] = "NON-OJK";
		$this->load->view("dashboard/nonojk",$data);
	}

	public function new()
	{
		$this->load->view("dashboard/_index",array(
			'areas'	=> $this->areas->all()
		));
	}

	public function unit()
	{
		$this->load->view("dashboard/unit/index");
	}

	public function executivesummary()
	{
		$this->load->view("dashboard/summary/index",array(
			'areas'	=> $this->areas->all()
		));
	}

	public function outstanding()
	{
		$this->load->view("dashboard/outstanding/index.php",array(
			'areas'	=> $this->areas->all(),
			'lasttransaction'	=> $this->regular->getLastDateTransaction()
		));
    }
	
	public function dpd()
	{
		$this->load->view("dashboard/dpd/index.php",array(
			'areas'	=> $this->areas->all()
		));
    }

    public function pusat()
	{
        $this->load->view("dashboards/pusat/index");
	}
	
	public function performaunit()
	{
        $this->load->view("dashboards/pusat/performaunit");
	}	
	
	public function disburse()
	{
        $this->load->view("dashboards/pusat/disburse");
	}

	public function targetbooking()
	{
        $this->load->view("dashboards/pusat/targetbooking");
	}
	
	public function targetoutstanding()
	{
        $this->load->view("dashboards/pusat/targetoutstanding");
	}
	
	public function pencairan()
	{
		
        $this->load->view("dashboard/pencairan/index",array(
        	'areas'	=> $this->areas->all()
		));
	}

	public function pencairanmonthly()
	{
		
        $this->load->view("dashboard/pencairan/monthly/index",array(
        	'areas'	=> $this->areas->all()
		));
	}
	
	public function pelunasan()
	{
        $this->load->view("dashboard/pelunasan/index",array(
        	'areas'	=> $this->areas->all()
		));
	}

	public function pelunasanmonthly()
	{
        $this->load->view("dashboard/pelunasan/monthly/index",array(
        	'areas'	=> $this->areas->all()
		));
	}

	public function pendapatan()
	{
        $this->load->view("dashboard/pendapatan/index",array(
        	'areas'	=> $this->areas->all()
		));
	}

	public function pengeluaran()
	{
        $this->load->view("dashboard/pengeluaran/index",array(
        	'areas'	=> $this->areas->all()
		));
	}
	
	public function saldokas()
	{
        $this->load->view("dashboards/pusat/saldokas");
	}
	
	public function saldobank()
	{
        $this->load->view("dashboards/pusat/saldobank");
    }

    public function area()
	{
		$this->load->view("dashboards/area/index");
    }

    public function units()
	{
		$this->load->view("dashboards/units/index");
	}

	public function penaksir()
	{
		$this->load->view("dashboards/penaksir/index");
	}

	public function realisasi()
	{
		$year = $this->input->get('year') ?  $this->input->get('year') : date('Y');
		$month = $this->input->get('month') ?  $this->input->get('month') : date('n');
		$area = $this->input->get('area') ?  $this->input->get('area') : 0;
		$this->load->view("dashboards/realisasi/index", array(
			'areas'	=> $this->areas->all(),
			'months'	=> months(),
			'years'	=> years(),
			'year'	=> $year,
			'month'	=> $month,
			'area'	=> $area
		));
	}

	public function reportoutstanding()
	{
		$currdate = date('Y-m-d');
		$max = 0;
		if($this->input->post('date')){
			$date = $this->input->post('date');
		}else{
			$date = date('Y-m-d');
		}

		$lastdate = $this->regular->getLastDateTransaction()->date;
		if ($date > $lastdate){
			$date = $lastdate;
		}else{
			$date= $date;
		}
		//$data = $this->regular->getLastDateTransaction();

		//get max
		$max = $this->db->select_max('os')
			->where('date',$date)
			->from('units_outstanding')
			->get()->row();

		if($area = $this->input->post('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}

		if($cabang = $this->input->post('cabang')){
			$this->units->db->where('id_cabang', $cabang);
		}else if($this->session->userdata('user')->level == 'cabang'){
			$this->units->db->where('id_cabang', $this->session->userdata('user')->id_cabang);
		}

		if($id_unit = $this->input->post('id_unit')){
			$this->units->db->where('units.id', $id_unit);
		}else if($code = $this->input->post('code')){
			$this->units->db->where('code', zero_fill($code, 3));
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}

		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		$today = '';
		$yesterday = '';
		foreach ($units as $unit){
			$getOstToday = $this->regular->db
						->where('date <=', $date)
						->from('units_outstanding')
						->where('id_unit', $unit->id)
						->order_by('date','DESC')
						->get()->row();

			$today = $getOstToday->date;

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
			$dateYesterday = $getOstToday->date;

			$getOstYesterday = $this->regular->db
								->where('date <', $dateYesterday)
								->from('units_outstanding')
								->where('id_unit', $unit->id)
								->order_by('date','DESC')
								->get()->row();

			$yesterday = $getOstYesterday->date;

			$unit->ost_yesterday = (object) array(
				'noa_os_reguler'	=> $getOstYesterday->noa_os_regular,
				'os_reguler'		=> $getOstYesterday->os_regular,
				'noa_os_mortages'	=> $getOstYesterday->noa_os_mortage,
				'os_mortages'		=> $getOstYesterday->os_mortage
			);		

			$totalUpReg = ($unit->ost_yesterday->os_reguler+ $unit->ost_today->up_reguler)-($unit->ost_today->up_rep_reguler);
			$totalUpMor = ($unit->ost_yesterday->os_mortages+ $unit->ost_today->up_mortages)-($unit->ost_today->up_rep_mortages);
           

			$totalOst =  $totalUpReg+$totalUpMor;

			$unit->total_outstanding = (object) [
				'up'	=> $totalOst
			];

			$unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id, $date);
			$unit->dpd_today = $this->regular->getDpdToday($unit->id, $date);
			$unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id,$date);
			$unit->total_dpd = (object) array(
				//'noa'	=> $unit->dpd_today->noa + $unit->dpd_yesterday->noa,
				//'ost'	=> $unit->dpd_today->ost + $unit->dpd_yesterday->ost,
				'noa_today'	=> $unit->dpd_today->noa + $unit->dpd_repayment_today->noa,
				'ost_today'	=> $unit->dpd_today->ost + $unit->dpd_repayment_today->ost,
				'noa'	=> ($unit->dpd_today->noa + $unit->dpd_yesterday->noa +$unit->dpd_repayment_today->noa) - $unit->dpd_repayment_today->noa,
				'ost'	=> ($unit->dpd_today->ost + $unit->dpd_yesterday->ost +$unit->dpd_repayment_today->ost) - $unit->dpd_repayment_today->ost,
			);
			$unit->percentage = ($unit->total_dpd->ost > 0) && ($unit->total_outstanding->up > 0) ? round($unit->total_dpd->ost / $unit->total_outstanding->up, 4) : 0;
	
		

			
			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id, null, null, $date);
		}
		return $units;
	}

	public function grouped($os)
	{
		$result = [];
		foreach($os as $index =>  $data){
			$result[$data->area][$index] = $data;
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
	//report
	public function outstandingreport(){
		$this->load->library('pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';

		$newos = $this->reportoutstanding();
		$grouped = $this->grouped($newos);
		$pdf->AddPage('L', 'A3');
		$view = $this->load->view('dailyreport/outstanding/generate.php',['outstanding'=>$grouped,'datetrans'=> $this->input->post('date')],true);
		$pdf->writeHTML($view);	
		//download
		$pdf->Output('GHAnet_Summary_OS'.date('d_m_Y').'.pdf', 'D');
		//view
		// $pdf->Output('GHAnet_Summary_'.date('d_m_Y').'.pdf', 'I');

	}

	public function dpdreport(){
		//load our new PHPExcel library
		$this->load->library('PHPExcel');

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$sheet = $objPHPExcel;
		$sheets = $objPHPExcel->getActiveSheet();
		$objPHPExcel->getProperties()->setCreator("O'nur")
		       		->setLastModifiedBy("O'nur")
		      		->setTitle("Reports")
		       		->setSubject("Widams")
		       		->setDescription("widams report ")
		       		->setKeywords("phpExcel")
					->setCategory("well Data");		
	
		$sheet->setActiveSheetIndex(0);
		$sheet->setActiveSheetIndex(0)->mergeCells('A1:A2');
		$sheets->getColumnDimension('A')->setWidth(20);
		$sheets->setCellValue('A1', 'Unit')
				->getStyle('A1:A2')
			   ->getAlignment()				
			   ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('A1:A2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('e0e0d1');
		
		$sheet->setActiveSheetIndex(0)->mergeCells('B1:B2');
		$sheets->getColumnDimension('B')->setWidth(15);
		$sheets->setCellValue('B1', 'Area')
				->getStyle('B1:B2')
			   ->getAlignment()				
			   ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('B1:B2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('e0e0d1');

		$sheet->setActiveSheetIndex(0)->mergeCells('C1:C2');
		$sheets->getColumnDimension('C')->setWidth(15);
		$sheets->setCellValue('C1', 'Open')
				->getStyle('C1:C2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('C1:C2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('e0e0d1');

		$sheet->setActiveSheetIndex(0)->mergeCells('D1:D2');
		$sheets->getColumnDimension('D')->setWidth(15);
		$sheets->setCellValue('D1', 'OJK')
				->getStyle('D1:D2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('D1:D2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('e0e0d1');

		//Outstanding Kemarin
		$sheet->setActiveSheetIndex(0)->mergeCells('E1:F1');
		$sheets->getColumnDimension('E')->setWidth(15);
		$sheets->getColumnDimension('F')->setWidth(15);
		$sheets->setCellValue('E1', 'DPD Kemarin')
			   ->getStyle('E1')
			   ->getAlignment()				
			   ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('E1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('FF0000');
		
		$sheets->getColumnDimension('E')->setWidth(15);
		$sheets->setCellValue('E2', 'Noa')
				->getStyle('E2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('E2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('FF0000');

		$sheets->getColumnDimension('F')->setWidth(15);
		$sheets->setCellValue('F2', 'Outstanding')
				->getStyle('F2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('F2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('FF0000');
			//End Outstanding Kemarin

		//kredit hari ini
		$sheet->setActiveSheetIndex(0)->mergeCells('G1:H1');
		$sheets->getColumnDimension('G')->setWidth(15);
		$sheets->getColumnDimension('H')->setWidth(15);
		$sheets->setCellValue('G1', 'DPD Hari Ini')
				->getStyle('G1')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('G1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ff9999');
		
		$sheets->getColumnDimension('G')->setWidth(15);
		$sheets->setCellValue('G2', 'Noa')
				->getStyle('G2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('G2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ff9999');

		$sheets->getColumnDimension('H')->setWidth(15);
		$sheets->setCellValue('H2', 'Outstanding')
				->getStyle('H2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('H2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ff9999');
		//end kredit hari ini

		//kredit Pelunasan dan Cicilan
		$sheet->setActiveSheetIndex(0)->mergeCells('I1:J1');
		$sheets->getColumnDimension('I')->setWidth(15);
		$sheets->getColumnDimension('J')->setWidth(15);
		$sheets->setCellValue('I1', 'Pelunasan DPD Hari ini')
				->getStyle('I1')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('I1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ffcc99');
		
		$sheets->getColumnDimension('I')->setWidth(15);
		$sheets->setCellValue('I2', 'Noa')
				->getStyle('I2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('I2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ffcc99');

		$sheets->getColumnDimension('J')->setWidth(15);
		$sheets->setCellValue('J2', 'Outstanding')
				->getStyle('J2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('J2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ffcc99');
		//end kredit hari ini

		//Total Outstanding
		$sheet->setActiveSheetIndex(0)->mergeCells('K1:M1');
		$sheets->getColumnDimension('K')->setWidth(15);
		$sheets->getColumnDimension('L')->setWidth(15);
		$sheets->getColumnDimension('M')->setWidth(15);
		$sheets->setCellValue('K1', 'Total DPD')
				->getStyle('K1')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('K1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ffbf00');
		
		$sheets->getColumnDimension('K')->setWidth(15);
		$sheets->setCellValue('K2', 'Noa')
				->getStyle('K2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('K2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ffbf00');

		$sheets->getColumnDimension('L')->setWidth(15);
		$sheets->setCellValue('L2', 'Outstanding')
				->getStyle('L2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('L2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ffbf00');

		$sheets->getColumnDimension('M')->setWidth(15);
		$sheets->setCellValue('M2', '%')
				->getStyle('M2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('M2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ffbf00');
		//end Total Outstanding
				
			if($area = $this->input->post('area')){
				$this->units->db->where('id_area', $area);
			}else if($this->session->userdata('user')->level == 'area'){
				$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
			}
			if($code = $this->input->post('code')){
				$this->units->db->where('code', $code);
			}else if($this->session->userdata('user')->level == 'unit'){
				$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
			}
			if($this->input->post('date')){
				$date = $this->input->post('date');
			}else{
				$date = date('Y-m-d');
			}

			$units = $this->units->db->select('units.id, units.name, area')
									 ->join('areas','areas.id = units.id_area')
									 ->get('units')->result();
		$no=3;
		foreach ($units as $unit) 
		{
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
			
			$unit->dpd_yesterday = $this->regular->getDpdYesterday($unit->id, $date);
			$unit->dpd_today = $this->regular->getDpdToday($unit->id, $date);
			$unit->dpd_repayment_today = $this->regular->getDpdRepaymentToday($unit->id,$date);
			$unit->total_dpd = (object) array(
				'noa'	=> $unit->dpd_today->noa + $unit->dpd_yesterday->noa - $unit->dpd_repayment_today->noa,
				'ost'	=> $unit->dpd_today->ost + $unit->dpd_yesterday->ost - $unit->dpd_repayment_today->ost,
			);
			$unit->percentage = ($unit->total_dpd->ost > 0) && ($unit->total_outstanding->up > 0) ? round($unit->total_dpd->ost / $unit->total_outstanding->up, 4) : 0;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $unit->name);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $unit->area);	
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, "-");				  	
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, "-");	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $unit->dpd_yesterday->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $unit->dpd_yesterday->ost);				 
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $unit->dpd_today->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $unit->dpd_today->ost);				 
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $unit->dpd_repayment_today->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $unit->dpd_repayment_today->ost);				 
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $unit->total_dpd->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $unit->total_dpd->ost);				 
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, round($unit->percentage*100, 3));				 				 
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="DPD_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}

	public function stocks()
	{
		$this->load->view('dashboard/stocks/index');
	}

	public function reach()
	{
		$this->load->view('dashboard/reach/index');
	}

	public function pendapatan_pdf()
	{
		$this->load->library('pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';
	
		$pdf->AddPage('L', 'A4');
		$view = $this->load->view('dashboard/pendapatan/pdf.php',[
			'units'=>$this->pendapatan_daily(),
		],true);
		$pdf->writeHTML($view);
	
	
		//download
		$pdf->Output('GHNet_Pendapatan'.date('d_m_Y').'.pdf', 'D');
	}

	public function pendapatan_excel()
	{
		//load our new PHPExcel library
		$this->load->library('PHPExcel');
		$columns = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V',
		'W','X','Y','Z','AA','AB','AC','AD','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AR',
		'AS','AT','AU','AV','AW','AX','AY','AZ'
			);
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("O'nur")
			->setLastModifiedBy("O'nur")
			->setTitle("Reports")
			->setSubject("Widams")
			->setDescription("widams report ")
			->setKeywords("phpExcel")
			->setCategory("well Data");

		$objPHPExcel->setActiveSheetIndex(0);
		$units = $this->pendapatan_daily();
		$no = 1;
		foreach ($units as $index => $row)
		{
			if($index == 0){		
				$i = 0;
				$objPHPExcel->getActiveSheet()->setCellValue($columns[$i].$no, $row['no']);
				$i++;
				$objPHPExcel->getActiveSheet()->setCellValue($columns[$i].$no, $row['unit']);
				$i++;
				$objPHPExcel->getActiveSheet()->setCellValue($columns[$i].$no, $row['unit']);
				$i++;
				foreach($row['dates'] as $date){
					$objPHPExcel->getActiveSheet()->setCellValue($columns[$i].$no, $date);
					$i++;
				}
			}else{
				$i = 0;
				$objPHPExcel->getActiveSheet()->setCellValue($columns[$i].$no, $row->id);
				$i++;
				$objPHPExcel->getActiveSheet()->setCellValue($columns[$i].$no, $row->name);
				$i++;
				$objPHPExcel->getActiveSheet()->setCellValue($columns[$i].$no, $row->area);
				$i++;
				foreach($row->dates as $date){
					$objPHPExcel->getActiveSheet()->setCellValue($columns[$i].$no, $date);
					$i++;
				}
			}
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Report Pendatan Ghanet ".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		// if($post = $this->input->post()){
		// 	echo $post['area'];
		// }
	}
	public function pendapatan_daily()
	{
		if($area = $this->input->get('area')){
			$this->units->db->where('id_area', $area);
		}

		if($cabang = $this->input->get('cabang')){
			$this->units->db->where('units.id_cabang', $cabang);
		}

		if($unit = $this->input->get('unit')){
			$this->units->db->where('units.id', $unit);
		}

		if($this->input->get('date-start')){
			$date = $this->input->get('date-start');
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
				$dates[] =  (int) $this->regular->getPendapatan($unit->id, $date->format('Y-m-d'), $this->input->get('method'))->up;
			}
			$unit->dates = $dates;
			$result[] = $unit;
		}
		return $result;
	}
    

}
