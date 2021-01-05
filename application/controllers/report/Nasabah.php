<?php
//error_reporting(0);
defined('BASEPATH');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Nasabah extends Authenticated
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
		$this->load->model('UnitsSaldo', 'saldo');
		$this->load->model('CustomersModel', 'model');
		$this->load->model('RegularPawnsModel', 'regulars');
	}

	/**
	 * Welcome Index()
	 */
	public function current()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/nasabah/current',$data);
	}

	public function transaksi()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/nasabah/transaksi',$data);
	}

	public function transaksi_excel()
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Unit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'CIF');		
		$objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'KTP');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Nasabah');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'No. SGE');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'UP');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Pekerjaan');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		
		$objPHPExcel->getActiveSheet()
			->getStyle('A1:H1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('FFC000');

			$this->regulars->db->select('*,units.name as unit_name,customers.name as customer')
			->join('units','units.id=units_regularpawns.id_unit')
			->join('customers','customers.id=units_regularpawns.id_customer')
			->where('units_regularpawns.amount !=','0')
			->where('units_regularpawns.status_transaction ','N')
			->order_by('units_regularpawns.ktp','asc');

			if($area = $this->input->get('area')){
				$this->regulars->db->where('units.id_area', $area);
			}else if($this->session->userdata('user')->level == 'area'){
				$this->regulars->db->where('units.id_area', $this->session->userdata('user')->id_area);
			}

			if($permit = $this->input->get('permit')){
				$this->regulars->db->where('units_regularpawns.permit', $permit);
			}	
	   
	   	   	$data =  $this->regulars->all();

		$no = 2;		
		foreach ($data as $row){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $no);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->unit_name);							
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->no_cif);	
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->ktp);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->customer);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->no_sbk);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->amount);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $row->job);
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Nasabah_Transaksi".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}

	public function current_excel()
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Jenis dan jumlah nasabah');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Transaksi diatas nominal 100jt');		
		$objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Transaksi dibawah nominal 100jt');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		
		$objPHPExcel->getActiveSheet()
			->getStyle('A1:D1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('FFC000');

		$data = $this->model->current($this->input->get('permit'), $this->input->get('area'));	
		$no = 2;

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, 1);	
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, 'Nasabah Perorangan '.$data['customer_per_person'].' Orang');							
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $data['transaction_bigger']);	
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $data['transaction_smaller']);	

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Nasabah_pengkinian".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}

	
}
