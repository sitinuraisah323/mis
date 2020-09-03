<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Pendapatan extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Pendapatan';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AreasModel', 'areas');
		$this->load->model('MappingcaseModel', 'm_casing');
		$this->load->model('UnitsdailycashModel', 'unitsdailycash');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['areas'] = $this->areas->all();
		$data['pendapatan']=$this->m_casing->get_list_pendapatan();
		$this->load->view('report/pendapatan/index',$data);
	}	

	public function sewamodal()
	{
        $data['areas'] = $this->areas->all();
		$data['pendapatan']=$this->m_casing->get_list_pendapatan();
		$this->load->view('report/pendapatan/sewamodal',$data);
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
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Tanggal');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Bulan');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Tahun');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Uraian');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Jumlah');

		if($post = $this->input->post()){
			$category =null;
			if($post['category']=='all'){
				$data = $this->m_casing->get_list_pendapatan();
				$category=array();
				foreach ($data as $value) {
					array_push($category, $value->no_perk);
				}
			}else{
				$category=array($post['category']);
			}
			$this->unitsdailycash->db
				->select('units.code,units.name as unit_name')
				->join('units','units.id = units_dailycashs.id_unit')
				->where('type =', 'CASH_IN')
				->where_in('no_perk', $category)
				->where('date >=', $post['date-start'])
				->where('date <=', $post['date-end'])
				->where('id_unit', $post['id_unit'])
				->order_by('date', 'asc');

			//$this->unitsdailycash->db->join('units','units.id = units_dailycashs.id_unit');
			$data = $this->unitsdailycash->all();
		}
				
		$no=2;
		foreach ($data as $row) 
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->code);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->unit_name);	
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, date('d/m/Y',strtotime($row->date)));				  	
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, date('F',strtotime($row->date)));				  	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, date('Y',strtotime($row->date)));				 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->description);				 
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->amount);				 
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Pendapatan_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}
	
}
