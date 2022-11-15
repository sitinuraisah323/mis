<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Bapkas extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'BAPKas';

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
        $this->load->model('RegularPawnsModel', 'regulars');
        $this->load->model('BookCashModel', 'model');
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        $data['areas'] = $this->areas->all();
		$this->load->view('report/bapkas/index',$data);
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
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Kasir');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Tanggal');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Saldo Awal');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Penerimaan Operasional');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Penerimaan Moker');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Total Penerimaan');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Pengeluaran Transaksioanl');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Pengeluaran Non Transaksional');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Total Pengeluaran');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Saldo Akhir');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'NOA Regular');
		$objPHPExcel->getActiveSheet()->getColumnDimension('N');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'OS Regular');
		$objPHPExcel->getActiveSheet()->getColumnDimension('O');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'NOA Cicilan');
		$objPHPExcel->getActiveSheet()->getColumnDimension('P');
		$objPHPExcel->getActiveSheet()->setCellValue('P1', 'OS Cicilan');
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q');
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'NOA Total');		
		$objPHPExcel->getActiveSheet()->getColumnDimension('R');
		$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Total OS');	
		$objPHPExcel->getActiveSheet()->getColumnDimension('S');
		$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Nominal Selisih');	
		$objPHPExcel->getActiveSheet()->getColumnDimension('T');
		$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Deskripsi');
		if($post = $this->input->post()){
			$this->model->db
			->select('units.code,units.name as unit_name')
			->join('units','units_cash_book.id_unit = units.id')
            ->where('units_cash_book.date =', $post['date-start']);
			// ->where('units_cash_book.date <=', $post['date-end']);
			if($post['id_unit']!=0){
				$this->model->db->where('units_cash_book.id_unit', $post['id_unit']);
			}
			$data = $this->model->all();
		}
		$no=2;
		$oscicilan=0;
		foreach ($data as $row) 
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->code);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->unit_name);	
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->kasir);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, date('d/m/Y',strtotime($row->date)));				  	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->amount_balance_first);				 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->amount_in);				 				 
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->amount_inmoker);			 				 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $row->total_amountin);		
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $row->amount_out);	
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $row->amount_outnon);				
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $row->total_amountout);			 
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $row->amount_balance_final);	
			if($row->os_cicilan!=null){$oscicilan= $row->os_cicilan;}else{$oscicilan=0;}	
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $row->noa_regular);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$no, $row->os_unit);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$no, $row->noa_cicilan);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$no, $oscicilan);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$no, $row->noa_regular + $row->noa_cicilan);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$no, $row->os_unit + $oscicilan);		
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$no, $row->amount_gap);	

			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="BAP_KAS_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}

}
