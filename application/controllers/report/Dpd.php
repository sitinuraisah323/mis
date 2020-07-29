<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Dpd extends Authenticated
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
		$this->load->model('RegularPawnsModel', 'regulars');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['units'] = $this->units->all();
        $data['areas'] = $this->areas->all();
		$this->load->view('report/nasabahdpd/index',$data);
	}

	public function export()
	{		
		//load our new PHPExcel library
		$this->load->library('PHPExcel');

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
		$objPHPExcel->getActiveSheet()->getColumnDimension('A');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Kode Unit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Unit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'No SGE');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Nasabah');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Tanggal Kredit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Tanggal Jatuh Tempo');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Tanggal Lunas');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Sewa Modal');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Taksiran');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Admin');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'UP');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'DPD');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Sewa Modal(4-Bulanan)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('N');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Denda');
		$objPHPExcel->getActiveSheet()->getColumnDimension('O');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Pelunasan');
		
		if($post = $this->input->post()){
			$this->regulars->db
			->select("customers.name as customer_name, ROUND(units_regularpawns.capital_lease * 4 * amount) as tafsiran_sewa,
				CASE WHEN amount <=1000000 THEN 9000
				WHEN amount <= 2500000 THEN 20000
				WHEN amount <= 5000000 THEN 27000
				WHEN amount <= 10000000 THEN 37000
				WHEN amount <= 15000000 THEN 72000
				WHEN amount <= 20000000 THEN 82000
				WHEN amount <= 25000000 THEN 102000
				WHEN amount <= 50000000 THEN 122000
				WHEN amount <= 75000000 THEN 137000
				ELSE '152000'
				END AS new_admin
				
				")
			->join('customers','units_regularpawns.id_customer = customers.id')
			->select('units_repayments.date_repayment as date_repayment')
			->join('units_repayments','units_regularpawns.no_sbk = units_repayments.no_sbk','left')
			->select('units.code,units.name as unit_name')
			->join('units','units_regularpawns.id_unit = units.id')
			->where('deadline <',date('Y-m-d'));
			$this->regulars->db
				->where('units_regularpawns.date_sbk >=', $post['date-start'])
				->where('units_regularpawns.date_sbk <=', $post['date-end'])
				->where('units_regularpawns.status_transaction ', 'N')
				->where('units_regularpawns.id_unit', $post['id_unit']);
			if($permit = $post['permit']){
				$this->regulars->db->where('units_regularpawns.permit', $permit);
			}
			$data = $this->regulars->all();
		}
		$no=2;
		$status="";
		$totalDPD=0;
		$currdate = date('Y-m-d H:i:s');
		$currdate = new DateTime($currdate); 

		foreach ($data as $row) 
		{
			$deadline = new DateTime($row->deadline);
			$interval =  $deadline->diff($currdate);
			//$totalDPD = $currdate->diff($deadline);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->code);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->unit_name);	
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->no_sbk);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->customer_name);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, date('d/m/Y',strtotime($row->date_sbk)));				 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, date('d/m/Y',strtotime($row->deadline)));				 
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no,  date('d/m/Y',strtotime($row->date_repayment)));				 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $row->capital_lease);				 
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $row->estimation);				 
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $row->new_admin);				 
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $row->amount);				 
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $interval->d);				 
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $this->calculateDenda($interval->d,$row->amount));				 
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$no, $row->amount);				 
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$no, $row->amount);				 	 
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Nasabah_DPD_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}

	function calculateDenda($up, $dpd) {
		$sumDay = intval($dpd - 15);
		if($sumDay > 0){
			$rate=0;
			if(intval($up) < 10000000){
				$rate = 0.0583/100;
			}else{
				$rate = 0.0433/100;
			}
			$calculate = round($sumDay * $rate * $up);
			$modusCalculate = $calculate % 500;
			if($modusCalculate > 0){
				$round = 500;
			}else{
				$round = 0;
			}
			return $calculate - $modusCalculate + $round;
		}
		return 0;
	}

}
