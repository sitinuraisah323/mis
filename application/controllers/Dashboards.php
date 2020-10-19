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
	
	public function pelunasan()
	{
        $this->load->view("dashboard/pelunasan/index",array(
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
	
	//report
	public function outstandingreport(){
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
		$sheets->setCellValue('E1', 'Outstanding Kemarin')
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
		$sheets->setCellValue('G1', 'Kredit Hari Ini')
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
		$sheets->setCellValue('I1', 'Pelunasan & Cicilan')
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
		$sheets->setCellValue('K1', 'Total Outstanding')
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
		$sheets->setCellValue('M2', 'Ticket Size')
				->getStyle('M2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('M2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('ffbf00');
		//end Total Outstanding

		//Total Disburse
		$sheet->setActiveSheetIndex(0)->mergeCells('N1:P1');
		$sheets->getColumnDimension('N')->setWidth(15);
		$sheets->getColumnDimension('O')->setWidth(15);
		$sheets->getColumnDimension('P')->setWidth(15);
		$sheets->setCellValue('N1', 'Total Disburse')
				->getStyle('N1')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheets->getStyle('N1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('669999');
		
		$sheets->getColumnDimension('N')->setWidth(15);
		$sheets->setCellValue('N2', 'Noa')
				->getStyle('N2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('N2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('669999');

		$sheets->getColumnDimension('O')->setWidth(15);
		$sheets->setCellValue('O2', 'Outstanding')
				->getStyle('O2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('O2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('669999');
		
		$sheets->getColumnDimension('P')->setWidth(15);
		$sheets->setCellValue('P2', 'Ticket Size')
				->getStyle('P2')
				->getAlignment()				
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheets->getStyle('P2')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setRGB('669999');
		//end Total Disburse
				
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
			$ticketsize = round($totalUp > 0 ? $totalUp /$totalNoa : 0);

			$unit->total_disburse = $this->regular->getTotalDisburse($unit->id);

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $unit->name);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $unit->area);	
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, "-");				  	
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, "-");	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $unit->ost_yesterday->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $unit->ost_yesterday->up);				 
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $unit->credit_today->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $unit->credit_today->up);				 
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $unit->repayment_today->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $unit->repayment_today->up);				 
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $totalNoa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $totalUp);				 
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $ticketsize);				 
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$no, $unit->total_disburse->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$no, $unit->total_disburse->credit);				 
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$no, $unit->total_disburse->tiket);				 
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="OUTSTANDING_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

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
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $unit->percentage);				 				 
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
    

}
