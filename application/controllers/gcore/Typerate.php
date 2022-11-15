<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Typerate extends Authenticated
{
	/**
	 * @var string
	 */

	public $menu = 'BAPKas';

	/**
	 * Welcome constructor.
	 */

	public function __construct() {

		parent::__construct();
		$this->load->library('session');
		// $this->load->model('Chat_model');
		$this->db2 = $this->load->database('db2',TRUE);
		$this->db3 = $this->load->database('db3',TRUE);
		$this->load->model('Pawn_transactionsModel', 'pawn');
		$this->load->model('GCustomersModel', 'gcustomers');
		$this->load->model('GCustomerContactsModel', 'gcc');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('AreasModel', 'areas');
		$this->load->model('CabangModel', 'cabang');
		//new add
		// $this->load->model('Pawn_insuranceitemsModel', 'ins_items');		
		// $this->load->model('Pawn_installmentitemsModel', 'inst_items');		


	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
		$this->load->view('report/kp/typerate/index');
    } 

	public function exp(){ echo "test";}

	

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
					//title name
					$objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
					$objPHPExcel->getActiveSheet()->getStyle("A1:S1")->getFont()->setSize(18);
					$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Booking');
					$objPHPExcel->getActiveSheet()->mergeCells('A2:S2');
					$objPHPExcel->getActiveSheet()->setCellValue('A2', "Download at ".date('F, d Y'));

					$objPHPExcel->getActiveSheet()->getStyle('A4:U4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle('A4:U4')->getFill()->getStartColor()->setARGB('00FF00');
					// Add some data
					$objPHPExcel->getActiveSheet()->getStyle("A4:U4")->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('A4:U4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					//table coulumn name
					$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(25);
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
					$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Produk');
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
					$objPHPExcel->getActiveSheet()->setCellValue('B4', 'Kategori barang Jaminan');
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
					$objPHPExcel->getActiveSheet()->setCellValue('C4', 'No. SGE');
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
					$objPHPExcel->getActiveSheet()->setCellValue('D4', 'Unit');
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
					$objPHPExcel->getActiveSheet()->setCellValue('E4', 'Jenis');
					
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
					$objPHPExcel->getActiveSheet()->setCellValue('F4', 'No CIF');
					$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
					$objPHPExcel->getActiveSheet()->setCellValue('G4', 'Nasabah');
					$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
					$objPHPExcel->getActiveSheet()->setCellValue('H4', 'Taksiran');
					$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
					$objPHPExcel->getActiveSheet()->setCellValue('I4', 'Pinjaman');
					$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('J4', 'Rasio');
					$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('K4', 'Admin');
					$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('L4', 'Sewa');
					$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('M4', 'Rate');
					$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('N4', 'Gramasi');
					$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('O4', 'Karatse');
					$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('P4', 'Tanggal Akad');
					$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('Q4', 'Tanggal Jatuh Tempo');
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('R4', 'Tanggal Lelang');
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('S4', 'Created By');
					$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
					$objPHPExcel->getActiveSheet()->setCellValue('T4', 'Approved By');
					$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(100);
					// $objPHPExcel->getActiveSheet()->setCellValue('U4', 'Deskripsi Barang');
					
					if($get = $this->input->post()){
						
						$this->pawn->db2
									->select(" customers.cif_number as cif, office_name,product_name,customers.name as customer,sge,contract_date,due_date,auction_date,estimated_value,maximum_loan_percentage,loan_amount,admin_fee,monthly_fee,transaction_type,interest_rate,insurance_item_name,created_by,approved_by,
												")
									->from('pawn_transactions')
									->join('customers','customers.id = pawn_transactions.customer_id')
									->where('contract_date >=', $get['date-start'])
									->where('contract_date <=', $get['date-end'])
									->where('pawn_transactions.deleted_at ', null)
									->where('pawn_transactions.status !=', 5);
									
									if($get['area_id']!='all'){
										$this->pawn->db2->where('pawn_transactions.area_id',$get['area_id']);
									}
									if($get['branch_id']!='all'){
										$this->pawn->db2->where('pawn_transactions.branch_id',$get['branch_id']);
									}
									if($get['unit_id']!='all'){
										$this->pawn->db2->where('pawn_transactions.office_id',$get['unit_id']);
									}
									if($get['product']){
										$this->pawn->db2->where('pawn_transactions.product_name',$get['product']);
									}

									$data = $this->pawn->db2->order_by('pawn_transactions.contract_date','asc')->get()->result();
								$no=5;
								$type=null;
								foreach($data as $row){
									$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->product_name);			//Product	  	
									$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->insurance_item_name );			//Kategori BJ	 
									$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->sge);	//No SGE 			 
									$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->office_name);				//Unit
									$type = ($row->transaction_type ==0) ? "Pencairan" : "Perpanjangan";
									//$denda = ($dpddays < 0) ? (Float)($dpddays/31) * (int)$row->monthly_fee : $denda=0; 
									$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $type);			 		//Jenis
									
									$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->cif);	
									$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->customer);					//Nasabah
									$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $row->estimated_value);
									$objPHPExcel->getActiveSheet()->getStyle('H'.$no)->getNumberFormat()->setFormatCode('#,##0');				//Taksiran 

									$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $row->loan_amount);			    //Pinjaman
									$objPHPExcel->getActiveSheet()->getStyle('I'.$no)->getNumberFormat()->setFormatCode('#,##0');	

									$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $row->maximum_loan_percentage);			 		//Rasio
									$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $row->admin_fee);			//Admin	 
									$objPHPExcel->getActiveSheet()->getStyle('K'.$no)->getNumberFormat()->setFormatCode('#,##0');	

									$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $row->monthly_fee);	//			//Sewa	
									$objPHPExcel->getActiveSheet()->getStyle('L'.$no)->getNumberFormat()->setFormatCode('#,##0');	

									$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $row->interest_rate); 	//Rate		 
									$objPHPExcel->getActiveSheet()->setCellValue('N'.$no, $row->gramasi);			//Gramasi	
									$objPHPExcel->getActiveSheet()->getStyle('N'.$no)->getNumberFormat()->setFormatCode('#,##0');	

									$objPHPExcel->getActiveSheet()->setCellValue('O'.$no, $row->carats);			//carats	

									$objPHPExcel->getActiveSheet()->setCellValue('P'.$no, $row->contract_date);							//Tanggal Akad		 
									$objPHPExcel->getActiveSheet()->setCellValue('Q'.$no, $row->due_date);	//Tanggal Jatuh Tempo
											 
									$objPHPExcel->getActiveSheet()->setCellValue('R'.$no, $row->auction_date);	//Tanggal Jatuh Tempo
									$objPHPExcel->getActiveSheet()->setCellValue('S'.$no, $row->created_by);	//Tanggal Jatuh Tempo									
									$objPHPExcel->getActiveSheet()->setCellValue('T'.$no, $row->approved_by);	//Tanggal Jatuh Tempo	
									// $objPHPExcel->getActiveSheet()->setCellValue('U'.$no, $row->description);				//Deskripsi BJ		 
									$no++;
								}						
					}	

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Rate ".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
	}

}