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
	}

	/**
	 * Welcome Index()
	 */
	public function current()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/nasabah/current',$data);
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
