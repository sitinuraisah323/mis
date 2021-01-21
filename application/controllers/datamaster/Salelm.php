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
		$this->load->model('UnitsModel','units');

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

	public function _export()
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
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Gramasi');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Series');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Jumlah');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Harga');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Total');

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
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->weight);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->series);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->amount);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->price_perpcs);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $row->total);
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

	public function export()
	{
		$this->load->library('pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		require_once APPPATH.'controllers/pdf/header.php';
		$idArea = $this->input->post('area') ?  $this->input->post('area') : null;
		$idUnit = $this->input->post('id_unit') ?  $this->input->post('id_unit') : null;
		$dateStart = $this->input->post('date_start');
		$dateEnd = $this->input->post('date_end');
		$units = $this->model->saleByDateUnit($idArea, $idUnit, $dateStart, $dateEnd);
	
		$pdf->AddPage('L');
		$grams = $this->model->db->select('id, weight')->from('lm_grams')->get()->result();
		$view = $this->load->view('datamaster/salelm/pdf.php',[
			'units'=>$units	,
			'dateStart'=>$dateStart,
			'dateEnd'=>$dateEnd,
			'grams'	=> $grams
		],true);
		$pdf->writeHTML($view);
		//download
		$pdf->Output('Ghanet Penjualan Lm'.$dateStart.' sampani '.$dateEnd.'.pdf', 'D');
	}

	public function export_excel()
	{
		//load our new PHPExcel library
		$dateStart = $this->input->get('date_start');
		$dateEnd = $this->input->get('date_end');
		$idArea = $this->input->get('id_area');
		$idUnit = $this->input->get('id_unit');

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


		$this->grams->db->order_by('weight', 'asc');
		$grams = $this->grams->all();
		$no=2;
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Unit');

		$cel = ['C','D','E','F', 'G','H','I'];
		foreach ($grams  as $index => $row)
		{
			$objPHPExcel->getActiveSheet()->setCellValue($cel[$index].'1', $row->weight);
		}
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Total');
		if($idUnit){
			$this->units->db->where('units.id', $idUnit);
		}
		if($idArea){
			$this->units->db
				->join('areas','areas.id = units.id_area')
				->where('areas.id', $idArea);
		}
		$units = $this->units->all();
		foreach($units as $unit){
			$i = $no+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no,$i);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $unit->name);
			$total = 0;
			foreach ($grams  as $index => $row)
			{
				$amount =  $this->model->saleGrams($row->id, $unit->id,$dateStart, $dateEnd);
				$total += $amount;
				$objPHPExcel->getActiveSheet()->setCellValue($cel[$index].$no, $amount);
			}
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $total);
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ='Ghanet Penjualan Lm'.$dateStart.' sampani '.$dateEnd.'.pdf';
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
