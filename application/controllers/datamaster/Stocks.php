<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Stocks extends Authenticated
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
		$this->load->model('LmStocksModel','stock');
		$this->load->model('LmGramsModel','grams');
		$this->load->model('AreasModel','area');
		$this->load->model('UnitsModel','units');

	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('datamaster/stocks/index',array(
			'areas'	=> $this->area->all()
		));
	}

	public function export()
	{
		//load our new PHPExcel library
		$date3 = date('Y-m-d', strtotime($this->input->get('date_end').' -2 days'));
		$date2 = date('Y-m-d', strtotime($this->input->get('date_end').' -1 days'));
		$date1 = date('Y-m-d', strtotime($this->input->get('date_end')));
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
		if($idArea !== null){
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Unit');
			if($idUnit){
				$this->units->db->where('id', $idUnit);
			}
			if($idArea){
				$this->units->db->where('id_area', $idArea);
			}
			$cel = ['C','D','E','F', 'G','H','I'];
			foreach ($grams  as $index => $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue($cel[$index].'1', $row->weight);
			}
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Total');
			$units = $this->units->all();
			foreach($units as $unit){
				$i = $no+1;
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$no,$i);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $unit->name);
				$total = 0;
				foreach ($grams  as $index => $row)
				{
					$stock =  $this->stock->byGrams($row->id, $unit->id,$date1);
					$total += $stock;
					$objPHPExcel->getActiveSheet()->setCellValue($cel[$index].$no, $stock);
				}
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $total);
				$no++;
			}
		}else{
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Unit');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Weight');
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
			$objPHPExcel->getActiveSheet()->setCellValue('C1', $date1);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$objPHPExcel->getActiveSheet()->setCellValue('D1', $date2);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$objPHPExcel->getActiveSheet()->setCellValue('E1', $date3);
			foreach ($grams  as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->unit);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->weight.' grams');
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $this->stock->byGrams($row->id, $idUnit,$date1));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $this->stock->byGrams($row->id, $idUnit, $date1));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $this->stock->byGrams($row->id, $idUnit, $date1));
				$no++;
			}
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Report Transaksi Logam Mulya ".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		// if($post = $this->input->post()){
		// 	echo $post['area'];
		// }
	}

	public function grams()
	{
		$this->load->view('datamaster/stocks/grams',array(
			'areas'	=> $this->area->all()
		));
	}
}
