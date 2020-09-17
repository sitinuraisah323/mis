<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Bukukas extends Authenticated
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
		$this->load->model('AreasModel', 'areas');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('UnitsSaldo', 'saldo');
		$this->load->model('UnitsdailycashModel', 'unitsdailycash');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/bukukas/index',$data);
	}

	public function getDailyCash($unit, $dateEnd)
	{
		return $this->unitsdailycash->getSaldo($unit,$dateEnd)->saldo;
	}

	public function export()
	{		
		//load our new PHPExcel library
		$this->load->library('PHPExcel');
		$year = date('Y', strtotime($this->input->post('date-start')));
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Tahun');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', $year);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', $year);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', $year);

		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'BULAN');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 1);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 2);
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 3);
		$objPHPExcel->getActiveSheet()->setCellValue('E2', 4);
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 5);
		$objPHPExcel->getActiveSheet()->setCellValue('G2', 6);
		$objPHPExcel->getActiveSheet()->setCellValue('H2', 7);
		$objPHPExcel->getActiveSheet()->setCellValue('I2', 8);
		$objPHPExcel->getActiveSheet()->setCellValue('J2', 9);
		$objPHPExcel->getActiveSheet()->setCellValue('K2', 10);
		$objPHPExcel->getActiveSheet()->setCellValue('L2', 11);
		$objPHPExcel->getActiveSheet()->setCellValue('M2', 12);
		$no=3;

		if($area = $this->input->post('area')){
			$this->units->db->where('id_area', $area);
		}

		if($area = $this->input->post('id_unit')){
			$this->units->db->where('id', $area);
		}
		
		$this->units->db->order_by('id_area', 'ASC')->order_by('id', 'ASC');
		$units = $this->units->all();
		foreach ($units as $row){
			$this->units->db
				->select('cut_off, amount')
				->from('units_saldo')
				->where('id_unit', $row->id)
				->order_by('units_saldo.id_unit','DESC');
			$getCutOffUnit = $this->units->db->get()->row();
			if($getCutOffUnit){
				$dateEndJanuary = implode('-',[$year, '01',days_in_month(1, $year)]);
				$dateEndFebruari = implode('-',[$year, '02',days_in_month(2, $year)]);
				$dateEndMaret = implode('-',[$year, '03',days_in_month(3, $year)]);
				$dateEndApril = implode('-',[$year, '04',days_in_month(4, $year)]);
				$dateEndMei = implode('-',[$year, '05',days_in_month(5, $year)]);
				$dateEndJuni = implode('-',[$year, '06',days_in_month(6, $year)]);
				$dateEndJuli = implode('-',[$year, '07',days_in_month(7, $year)]);
				$dateEndAgustus = implode('-',[$year, '08',days_in_month(8, $year)]);
				$dateEndSeptembar = implode('-',[$year, '09',days_in_month(9, $year)]);
				$dateEndOktober = implode('-',[$year, '10',days_in_month(10, $year)]);
				$dateEndNovember = implode('-',[$year, '11',days_in_month(11, $year)]);
				$dateEndDesember = implode('-',[$year, '12',days_in_month(12, $year)]);
				$this->units->db
					->select("id_unit, 
					(select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
					 from units_dailycashs where units_dailycashs.id_unit = $row->id
					and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndAgustus'
					limit 1)
					as agustus,
					(select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
					 from units_dailycashs where units_dailycashs.id_unit = $row->id
					and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndSeptembar'
					limit 1)
					as september,
					(select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
					 from units_dailycashs where units_dailycashs.id_unit = $row->id
					and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndJanuary'
					limit 1)
					as januari,
					(select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
					from units_dailycashs where units_dailycashs.id_unit = $row->id
				   and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndFebruari'
				   limit 1)
				   as februari,
				   (select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
					from units_dailycashs where units_dailycashs.id_unit = $row->id
				   and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndMaret'
				   limit 1)
				   as maret,
				   (select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
				   from units_dailycashs where units_dailycashs.id_unit = $row->id
				  and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndApril'
				  limit 1)
				  as april,
				  (select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
				   from units_dailycashs where units_dailycashs.id_unit = $row->id
				  and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndMei'
				  limit 1)
				  as mei,
				  (select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
				   from units_dailycashs where units_dailycashs.id_unit = $row->id
				  and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndJuni'
				  limit 1)
				  as juni,
				  (select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
				  from units_dailycashs where units_dailycashs.id_unit = $row->id
				 and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndJuli'
				 limit 1)
				 as juli,
				 (select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
				 from units_dailycashs where units_dailycashs.id_unit = $row->id
				and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndOktober'
				limit 1)
				as oktober,
				(select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
				 from units_dailycashs where units_dailycashs.id_unit = $row->id
				and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndNovember'
				limit 1)
				as november,
				(select ($getCutOffUnit->amount + sum(CASE WHEN type = 'CASH_IN' THEN `amount` ELSE 0 END) - sum(CASE WHEN type = 'CASH_OUT' THEN `amount` ELSE 0 END)) as amount
				 from units_dailycashs where units_dailycashs.id_unit = $row->id
				and units_dailycashs.date > '$getCutOffUnit->cut_off' and units_dailycashs.date <= '$dateEndDesember'
				limit 1)
				as desember
					")
					->from('units_dailycashs ud')
					->limit(1);				
				$summary = $this->units->db->get()->row();
				$this->units->db
					->select("id_unit,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '01' and YEAR(date) = '$year' limit 1
					) as januari ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '02' and YEAR(date) = '$year' limit 1
					) as februari ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '03' and YEAR(date) = '$year' limit 1
					) as maret ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '04' and YEAR(date) = '$year' limit 1
					) as april ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '05' and YEAR(date) = '$year' limit 1
					) as mei ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '06' and YEAR(date) = '$year' limit 1
					) as juni ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '07' and YEAR(date) = '$year' limit 1
					) as juli ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '08' and YEAR(date) = '$year' limit 1
					) as agustus ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '09' and YEAR(date) = '$year' limit 1
					) as september ,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '10' and YEAR(date) = '$year' limit 1
					) as oktober,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '11' and YEAR(date) = '$year' limit 1
					) as november,
					(select amount from units_dailycashs where units_dailycashs.id_unit = $row->id and
					MONTH(date) = '12' and YEAR(date) = '$year' limit 1
					) as desember
					")
					->from('units_dailycashs ud')
					->limit(1);
				$cekInMonth =  $this->units->db->get()->row();
		
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->name);	
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $cekInMonth->januari ? $summary->januari : '-');	
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$no,$cekInMonth->februari ? $summary->februari : '-');				  	
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$no,$cekInMonth->maret ?  $summary->maret : '-');				  	
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$no,$cekInMonth->april ? $summary->april : '-');				 
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$no,$cekInMonth->mei ?  $summary->mei : '-');
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$no,$cekInMonth->juni ?  $summary->juni : '-');				 
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$no,$cekInMonth->juli ?  $summary->juli : '-');				 
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $cekInMonth->agustus ?  $summary->agustus : '-');	
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$no,  $cekInMonth->september ?  $summary->september : '-');	
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$no,  $cekInMonth->oktober ?  $summary->oktober : '-');	
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$no,  $cekInMonth->november ?  $summary->november : '-');	
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $cekInMonth->desember ?  $summary->desember : '-');	
			}
			$no++;
		}


		// if($post = $this->input->post()){
		// 		$this->unitsdailycash->db
		// 			->select('units.code,units.name as unit_name')
		// 			->join('units','units.id = units_dailycashs.id_unit')
		// 			->where('date >=', $post['date-start'])
		// 			->where('date <=', $post['date-end']);
		// 		if($post['id_unit']!='all'){
		// 			$this->unitsdailycash->db->where('id_unit', $post['id_unit']);
		// 		}
		// 	$data = $this->unitsdailycash->all();
		// }				
		// $no=2;
		// $cashin=0;
		// $cashout=0;
		// $currentSaldo=0;
		// $TotSaldoIn =0;
		// $TotSaldoOut =0;		
		// foreach ($data as $row) 
		// {
		// 	$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->code);	
		// 	$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->unit_name);	
		// 	$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, date('d/m/Y',strtotime($row->date)));				  	
		// 	$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, date('F',strtotime($row->date)));				  	
		// 	$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, date('Y',strtotime($row->date)));				 
		// 	$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->description);
		// 	if($row->type =="CASH_IN"){$cashin= $row->amount; $currentSaldo += $row->amount; $TotSaldoIn +=  $row->amount;}else{$cashin=0;}
		// 	if($row->type =="CASH_OUT"){$cashout= $row->amount; $currentSaldo -=  $row->amount; $TotSaldoOut +=  $row->amount;}else{$cashout=0;}		 
		// 	$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $cashin);				 
		// 	$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $cashout);				 
		// 	$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $currentSaldo);				 
		// 	$no++;
		// }

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Buku_Kas_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');

	}

	
	
}
