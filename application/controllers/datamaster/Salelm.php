<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Salelm extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Units';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LmTransactionsModel','model');
		$this->load->model('LmTransactionsGramsModel','modelgrams');
		$this->load->model('LmGramsModel','grams');
		$this->load->model('AreasModel','areas');

	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('datamaster/salelm/index',array(
			'areas'	=>  $this->areas->all(),
			'grams'	=> $this->grams->all()
		));
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Tanggal');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Unit');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Pembeli');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Series');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Jumlah');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Harga');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Total');

		$dateStart = $this->input->post('date_start');
		$dateEnd = $this->input->post('date_end');
		$idUnit = $this->input->post('id_unit');
		$idArea = $this->input->post('area');

		$no=2;
		$sales = $this->model->sales($idArea,$idUnit,$dateStart,$dateEnd);
		foreach ($sales as $row)
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->date);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->unit);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->pembeli);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->series);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->amount);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->price_perpcs);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->total);
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Report  Penjualan Dari ".$dateStart.' sampai'.$dateEnd;
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		// if($post = $this->input->post()){
		// 	echo $post['area'];
		// }
	}

}
