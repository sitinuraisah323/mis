<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Outstanding extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Outstanding';

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
        $this->load->model('RegularPawnsModel', 'regular');
        $this->load->model('BookCashModel', 'model');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/os/index',$data);
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
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Unit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Area');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Noa');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Outstanding');

		if($post = $this->input->post()){
			if($post['area']!='all'){
				$this->units->db->where('id_area', $post['area']);
			}
			if($post['date']){
				$date = $post['date'];
			}else{
				$date = date('Y-m-d');
			}
			$units = $this->units->db->select('units.id, units.name, area')
				->join('areas','areas.id = units.id_area')
				->get('units')->result();
			foreach ($units as $unit){
				 $unit->noa = $this->regular->getOstYesterday_($unit->id, $date)->noa;			
				 $unit->up = $this->regular->getOstYesterday_($unit->id, $date)->up;			
			}
		}
		$no=2;
		foreach ($units as $row) 
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->name);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->area);	
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->noa);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->up);				  	
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="OS_Nasional_GR_".date('Y-m-d H:i:s');
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
