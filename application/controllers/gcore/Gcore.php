<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Middleware/Authenticated.php';
class Gcore extends Authenticated
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
	}

	/**
	 * Welcome Index()
	 */
	public function index()
	{
        //$data['areas'] = $this->areas->all();
		//$this->load->view('report/yogadai/outstanding/index');
    }
    
    public function outstanding()
	{
		$this->load->view('report/gcore/outstanding/index');
	}

	
    public function pendapatan()
	{
		$this->load->view('report/gcore/pendapatan/index');
	}

	 public function rate()
	{
		$this->load->view('report/gcore/rate/index');
	}

	 public function dpd()
	{
		
// // 			//$deadline = new DateTime($row->deadline);
// // 			//$interval =  $currdate->diff($deadline);
// 			$date1 = '2022-09-01';
// 			$date2 = date('Y-m-d');
// // 			//var_dump($date1);
// // 			//var_dump($date2);
			
			
// 			$interval = dateDiff($date1,$date2);

			$tgl1 = new DateTime("2022-09-23");
	$tgl2 = new DateTime("2022-09-20");
	$d = $tgl2->diff($tgl1)->days + 1;
	echo $d." hari";
// 			$dpd =  round(abs(strtotime($date1) - strtotime($date2))/86400);
			// var_dump($interval); exit;
				
		
		$this->load->view('report/gcore/dpd/index');

	}

	public function pencairan_excel()
	{
		//load our new PHPExcel library
		$this->load->library('PHPExcel');
		
		$this->load->library('gcore');

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
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Unit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'SGE');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Tanggal SGE');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Jatuh Tempo');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Tanggal Lunas');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Nasabah');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Sewa Modal');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Taksiran');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Admin');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Up');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Status');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Deskirpsi');
		$dateStart = $this->input->post('date_start');
		$dateEnd = $this->input->post('date_end');
		$unitName = $this->input->post('unit_id');
		$transactionStatus = $this->input->post('transaction_status');
		$buildData = [];
	    for($i = 1; $i<10000;$i++){
	    	$data = $this->myyogadai->transaction_detail($dateStart, $dateEnd, $unitName, $transactionStatus, $i);
	    	if($data->data){
	    	    foreach($data->data as $dat){
	    	        $buildData[] = $dat;
	    	    }
	    	}
	        
	        if($data->pagination->last_page){
	            $i = 10000;
	        }
	    }
	    	
		$no=2;
		$status="";
		$i = 0;
		foreach ($buildData as $row) 
		{
			$i++;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $i);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->unit_name );				 
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->sbg_number );				 
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->sbk_date );				 
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->due_date);			 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->payment_date);			 
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->customer_name);			 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $row->deposit_rate);			 
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $row->foreacast);			
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $row->admin_fee);			 
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $row->up_value);			 
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $row->status_text);			 
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $row->description);			 
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Yogadai_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}


    public function pdf()
	{
		// exit;
		// $this->load->library('pdf');
		$this->load->library('gcore');
		// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// require_once APPPATH.'controllers/pdf/header.php';
		// $pdf->AddPage('L', 'A3');
		// $date = $this->input->get('date') ? $this->input->get('date') : date('Y-m-d');
		// $os =  $this->gcore->transaction($date,$this->input->get('area_id'),$this->input->get('branch_id'), $this->input->get('unit_id'));
		// $view = $this->load->view('report/gcore/pdf',['outstanding'=>$os,'datetrans'=>$date],true);
		// $pdf->writeHTML($view);
		// $pdf->Output('GHAnet_Summary_'.$date.'.pdf', 'D');
	}

	// public function pdf()
	// {
    //     // echo "Yes"; exit;
	// 	$this->load->library('pdf');
	// 	$this->load->library('gcore');
	// 	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// 	require_once APPPATH.'controllers/pdf/header.php';
	// 	$pdf->AddPage('L', 'A3');
	// 	$date = $this->input->get('date') ? $this->input->get('date') : date('Y-m-d');
    //     $area = $this->input->get('area_id') ? $this->input->get('area_id') : '60c6befbe64d1e2428630162';
    //     $cabang = $this->input->get('branch_id') ? $this->input->get('branch_id') : '';
    //     $unit = $this->input->get('unit_id') ? $this->input->get('unit_id') : '';

    //     $os =  $this->gcore->transaction($date, $area, $cabang, $unit);
	// 	$view = $this->load->view('report/gcore/pdf',['outstanding'=>$os,'datetrans'=>$date],true);
	// 	$pdf->writeHTML($view);
	// 	$pdf->Output('GHAnet_Summary_'.$date.'.pdf', 'D');
	// }

	public function excel()
	{
		//load our new PHPExcel library
		$this->load->library('PHPExcel');
		
		$this->load->library('gcore');

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
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Unit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Gadai Regular');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Gadai Cicilan');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Total Ost');
		$objPHPExcel->getActiveSheet()->getColumnDimension('N');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Disburse');


		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Noa');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Ost Kemarin');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Noa');
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Kredit');
		$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Noa');
		$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Pelunasan');

		$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Noa');
		$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Kredit');

		$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Noa');
		$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Pelunasan');

		$objPHPExcel->getActiveSheet()->setCellValue('N2', 'Noa');
		$objPHPExcel->getActiveSheet()->setCellValue('O2', 'Total Disburse');
		$objPHPExcel->getActiveSheet()->setCellValue('P2', 'Tiket Size');

		$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
		$objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
		$objPHPExcel->getActiveSheet()->mergeCells('C1:H1');
		$objPHPExcel->getActiveSheet()->mergeCells('I1:L1');
		$objPHPExcel->getActiveSheet()->mergeCells('I1:L1');
		$objPHPExcel->getActiveSheet()->mergeCells('M1:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('N1:P1');


		$date = $this->input->get('date') ? $this->input->get('date') : date('Y-m-d');
		$data =  $this->myyogadai->transaction($date, $this->input->get('unit_id'));
		$no=3;
		$status="";
		$i = 0;
		foreach ($data->data as $row) 
		{
			$i++;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $i);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->unit_name );				 
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->ost_yesterday->noa);				 
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->ost_yesterday->up );				 
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->credit_today->noa_reguler);			 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->credit_today->up_reguler);			 
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, $row->repayment_today->noa_reguler);			 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, $row->repayment_today->up_reguler);			 
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no, $row->credit_today->noa_mortages);			 
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $row->credit_today->up_mortages);			 
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $row->repayment_today->noa_mortages);			 
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $row->repayment_today->up_mortages);			 
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $row->total_outstanding->up);			 
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$no, $row->total_disburse->noa);			 
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$no, $row->total_disburse->credit);	
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$no, $row->total_disburse->tiket);			 
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Yogadai_OS_".$date;
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function export_dpd()
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
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'No SGE');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Nasabah');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Phone');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Address');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Tanggal Kredit');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Tanggal Jatuh Tempo');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Tanggal Lunas');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Sewa Modal');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Taksiran');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Admin');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'UP');
		$objPHPExcel->getActiveSheet()->getColumnDimension('N');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'DPD');
		$objPHPExcel->getActiveSheet()->getColumnDimension('O');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Sewa Modal(4-Bulanan)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('P');
		$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Denda');
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q');
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Pelunasan');
		$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Deskripsi Barang');
		
	        $satu = 0;
	        $dua = 0;
			$date = date('Y-m-d');
			 $area_id = $this->input->post('area_id');
			 $branch_id = $this->input->post('branch_id');
			 $unit_id = $this->input->post('unit_id');			 
			 $dateEnd = $this->input->post('date-end');
			
	
			$date = date('Y-m-d');

			if($get['area_id']!='all'){
						$this->pawn->db2->where('pawn_transactions.area_id',$area_id);
					}
					if($get['branch_id']!='all' and $get['branch_id']!=''){
						$this->pawn->db2->where('pawn_transactions.branch_id',$branch_id);
					}
					if($get['unit_id']!='all' and $get['unit_id']!=''){
						$this->pawn->db2->where('pawn_transactions.office_id',$unit_id);
					}
					
												
			$this->pawn->db2
					->select("pawn_transactions.product_name, pawn_transactions.office_name,pawn_transactions.sge, pawn_transactions.contract_date, pawn_transactions.due_date, pawn_transactions.repayment_date,pawn_transactions.interest_rate,pawn_transactions.estimated_value,pawn_transactions.admin_fee, pawn_transactions.loan_amount,pawn_transactions.payment_status,  ROUND(pawn_transactions.interest_rate/100 * 4 * pawn_transactions.loan_amount) as tafsiran_sewa,
						pawn_transactions.payment_status,
						'$date' - pawn_transactions.due_date as dpd,
						(select identity_address from customer_contacts where customer_contacts.customer_id = pawn_transactions.customer_id limit 1 ) as address,
						(select phone_number from customer_contacts where pawn_transactions.customer_id = customer_contacts.customer_id limit 1 ) as phone_number,				
						(select name from customers where pawn_transactions.customer_id = customers.id limit 1 ) as customer_name
						")
					->from('pawn_transactions ')
					->where('pawn_transactions.payment_status', false)
					->where("pawn_transactions.due_date <", $dateEnd)						
					->where('pawn_transactions.status !=', 5)
					->where('pawn_transactions.status !=', 4)
					->where('pawn_transactions.transaction_type !=', 4)
					->where('pawn_transactions.deleted_at', null);

					if($get['dateEnd'] == date('Y-m-d')){
						$this->pawn->db2->where("'$date' - pawn_transactions.due_date >", 7 );
					}
					$this->pawn->db2
					->order_by('pawn_transactions.office_name', 'asc')
					->order_by('dpd', 'desc');
		}
		
		$no=2;
		$status="";
		$totalDPD=0;
		$currdate = date('Y-m-d H:i:s');
		//$currdate = new DateTime($currdate); 

		foreach ($data as $row) 
		{
			

			$date1 = strtotime($row->due_date);
			$date2 = strtotime($currdate);
			$dpd = $date2 - $date1;
			$dpd = $dpd / 60 / 60 / 24 - 7;


			//$totalDPD = $currdate->diff($deadline);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$no, $row->office_code);	
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$no, $row->office_name);	
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$no, $row->sge);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$no, $row->customer_name);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$no, $row->phone_number);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$no, $row->address);				  	
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$no, date('d/m/Y',strtotime($row->contract_date)));				 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$no, date('d/m/Y',strtotime($row->due_date)));				 
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$no,  '-');				 
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$no, $row->interest_rate);				 
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$no, $row->estimated_value);				 
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$no, $row->admin_fee);				 
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$no, $row->loan_amount);				 
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$no, $dpd);				 
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$no, $row->tafsiran_sewa );				 
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$no, $this->calculateDenda1($row->loan_amount,$dpd));
			$calcup =  $row->tafsiran_sewa + $this->calculateDenda1($row->loan_amount,$dpd) + $row->loan_amount;				 
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$no, $calcup);	
			// $objPHPExcel->getActiveSheet()->setCellValue('R'.$no, $row->description_1.' '.$row->description_2.' '.$row->description_3.' '.$row->description_4);	
			$no++;
		}

		//Redirect output to a client’s WBE browser (Excel5)
		$filename ="Nasabah_DPD_".date('Y-m-d H:i:s');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}
	
	function calculateDenda1($up, $dpd, $rate) {
		$sumDay = $dpd;

		if($sumDay > 0){
						
			$lebih = $sumDay % 30;
			$bulan = $sumDay - $data / 30 ;			
			$calculate1 = $up * $rate/100 / $lebih;
			$calculate2 = $up * $rate/100 * $bulan;

			// $modusCalculate = $calculate % 500;

			$data = round($calculate1 + $calculate2);
			
			// var_dump($data); exit;
			return $data;

		}
		return 0;
	}
}