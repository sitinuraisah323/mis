<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Summaryrate extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Summaryrate';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AreasModel', 'areas');
		$this->load->model('MappingcaseModel', 'm_casing');
		$this->load->model('UnitsdailycashModel', 'unitsdailycash');
		$this->load->model('RegularPawnsModel', 'regulars');
		$this->load->model('CustomersModel', 'customers');
		$this->load->model('UnitsModel', 'units');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/summaryrate/index',$data);
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Area');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Kode Unit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Unit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'UP');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Noa');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Jumlah Rate');		
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Average Rate(%)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Min Rate(%)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Max Rate(%)');

		if($area = $this->input->post('area')){
			$this->units->db->where('id_area', $area);
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->post('unit')){
			$this->units->db->where('units.id', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}

		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->order_by('areas.id','asc')
			->get('units')->result();
		foreach ($units as $unit){
			 $unit->summary = $this->regulars->getSummaryRate($unit->id);			
		}
				
		$no=2;
		$average=0;
		$minrate=0;
		$maxrate=0;
		foreach ($units as $row) 
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->area);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->id);	
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->name);				 
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->summary->up);	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->summary->noa);			 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->summary->rate);				 
			$average = $row->summary->rate/$row->summary->noa;
			$minrate = $row->summary->min_rate*100;
			$maxrate = $row->summary->max_rate*100;
			if(!is_nan($average)){$average=$average;}else{$average=0;}
			//echo $average;
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $average);				 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $minrate);				 
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $maxrate);				 
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Summary Rate_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}
	
}
