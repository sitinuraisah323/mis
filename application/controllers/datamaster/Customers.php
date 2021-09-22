<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Customers extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'Customers';

	/**
	 * Welcome constructor.
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AreasModel', 'areas');
		$this->load->model('CustomersModel', 'customers');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('customers/index', array(
			'areas'	=> $this->areas->all()
		));
	}

	public function excel()
	{
		if($this->input->get('generalSearch')){
			$this->customers->db->like('customers.name', $this->input->get('generalSearch'));
		}
		if($this->input->get('limit') !== 'all'){
			$this->customers->db->limit($this->input->get('limit'));	
		}
		if($this->input->get('area')){
			$this->customers->db->where('units.id_area',$this->input->get('area'));
		}
		if($this->input->get('id_unit')){
			$this->customers->db->where('units.id',$this->input->get('id_unit'));
		}
	
		if($this->input->get('cabang')){
			$this->customers->db->where('units.id_cabang',$this->input->get('cabang'));
		}

		$this->customers->db
			->select('customers.*, units.name as unit')
			->join('units','units.id = customers.id_unit');
		$data =  $this->customers->all();
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Id');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Nama Nasabah');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Tempat Lahir');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Tanggal Lahir');		
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Alamat');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'NIK');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Status Kawin');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'No Cif');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'NPWP');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Jenis Kelamin');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Mobile');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Pekerjaan');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Kewarganegaraan');

		$objPHPExcel->getActiveSheet()->getColumnDimension('N');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Nama Ibu');

		$objPHPExcel->getActiveSheet()->getColumnDimension('O');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Nama Saudara');

		$objPHPExcel->getActiveSheet()->getColumnDimension('P');
		$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Tempat Lahir Saudara');

		$objPHPExcel->getActiveSheet()->getColumnDimension('Q');
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Tanggal Lahir Saudara');

		$objPHPExcel->getActiveSheet()->getColumnDimension('R');
		$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Alamat Saudara 1' );

		$objPHPExcel->getActiveSheet()->getColumnDimension('S');
		$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Alamat Saudara 2');

		
		$objPHPExcel->getActiveSheet()->getColumnDimension('T');
		$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Pekerjaan Saudara 2');

		$objPHPExcel->getActiveSheet()->getColumnDimension('U');
		$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Hubungan Keluarga');

		$objPHPExcel->getActiveSheet()->getColumnDimension('V');
		$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Unit');

		
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);

		$objPHPExcel->getActiveSheet()
			->getStyle('A1:V1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('FFC000');
		$no = 2;		
		foreach ($data as $row){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->id);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->name);							
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->birth_place);							
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->birth_date);	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->address."Rt/Rw $row->rt/$row->rw Kelurahan $row->kelurahan Kec $row->kecamatan $row->city $row->kodepos $row->province");
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->nik);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->marital);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $row->no_cif);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, '');
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $row->gender);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $row->mobile);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $row->job);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $row->citizenship);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$no, $row->mother_name);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$no, $row->sibling_name);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$no, $row->sibling_birth_place);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$no, $row->sibling_birth_date);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$no, $row->sibling_address_1);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$no, $row->sibling_address_2);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$no, $row->sibling_job);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$no, $row->sibling_relation);
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$no, $row->unit);
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Nasabah";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
	}
}
