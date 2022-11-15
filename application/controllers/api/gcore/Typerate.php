<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Typerate extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('gcore');
		$this->db2 = $this->load->database('db2',TRUE);
		$this->db3 = $this->load->database('db3',TRUE);
		$this->load->model('Pawn_transactionsModel', 'pawn');
		$this->load->model('GCustomersModel', 'gcustomers');
		$this->load->model('GCustomerContactsModel', 'gcc');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('AreasModel', 'areas');
		$this->load->model('CabangModel', 'cabang');
		$this->load->model('InstallmentModel', 'install');

	}

	public function index()
	{
		$cicilan = '';
		$data = '';

		$date = date('Y-m-d');
		if($get = $this->input->get()){
			$area_id = $this->input->get('area_id');
			$branch_id = $this->input->get('branch_id');
			$unit_id = $this->input->get('unit_id');
			$dateEnd = $this->input->get('dateEnd');
			$produk = $this->input->get('produk');
				
		}

					if($get['area_id']!='all'){
						$units = $this->pawn->db2->from('pawn_transactions')->where('pawn_transactions.area_id',$area_id)->get()->result();
					}
					if($get['branch_id']!='all' and $get['branch_id']!=''){
						$units = $this->pawn->db2->from('pawn_transactions')->where('pawn_transactions.branch_id',$branch_id)->get()->result();
					}
					if($get['unit_id']!='all' and $get['unit_id']!=''){
						$units = $this->pawn->db2->from('pawn_transactions')->where('pawn_transactions.office_id',$unit_id)->get()->result();
					}
					
						
					foreach($units as $data){
						// echo $data->office_name; exit;
						$this->pawn->db2
							->select("select office_name, area_id, sum(loan_amount) as up,
							(select count(pawn_transactions.id) from pawn_transactions where pawn_transactions.payment_status = false and pawn_transactions.office_id = $data->office_id and interest_rate < 1.5 and pawn_transactions.status != 5 and pawn_transactions.transaction_type != 4 pawn_transactions.transaction_type != 5 and pawn_transactions.deleted_at = null ) as noaMin,
							(select sum(pawn_transactions.loan_amount) from pawn_transactions where pawn_transactions.payment_status = false and pawn_transactions.office_id = $data->office_id and interest_rate < 1.5 and pawn_transactions.status != 5 and pawn_transactions.transaction_type != 4 pawn_transactions.transaction_type != 5 and pawn_transactions.deleted_at = null ) as noaMin,
							(select count(pawn_transactions.id) from pawn_transactions where pawn_transactions.payment_status = false and pawn_transactions.office_id = $data->office_id and interest_rate >= 1.5 and pawn_transactions.status != 5 and pawn_transactions.transaction_type != 4 pawn_transactions.transaction_type != 5 and pawn_transactions.deleted_at = null ) as noaMin,
							(select sum(pawn_transactions.loan_amount) from pawn_transactions where pawn_transactions.payment_status = false and pawn_transactions.office_id = $data->office_id and interest_rate >= 1.5 and pawn_transactions.status != 5 and pawn_transactions.transaction_type != 4 pawn_transactions.transaction_type != 5 and pawn_transactions.deleted_at = null ) as noaMin,
						")
							->from('pawn_transactions')
							->where('pawn_transactions.payment_status', false)
							->where('pawn_transactions.contract_date <=', $dateEnd)
							->where('pawn_transactions.status !=', 5)
							->where('pawn_transactions.transaction_type !=', 4)
							->where('pawn_transactions.transaction_type !=', 5)
							->where('pawn_transactions.deleted_at', null);
												
						$aktif = $this->pawn->db2->get()->result();

						$data = merge($data,$aktif);
					}
		

		// 			if($get['area_id']!='all'){
		// 				$this->pawn->db2->where('pawn_transactions.area_id',$area_id);
		// 			}
		// 			if($get['branch_id']!='all' and $get['branch_id']!=''){
		// 				$this->pawn->db2->where('pawn_transactions.branch_id',$branch_id);
		// 			}
		// 			if($get['unit_id']!='all' and $get['unit_id']!=''){
		// 				$this->pawn->db2->where('pawn_transactions.office_id',$unit_id);
		// 			}
		// 			if($get['produk']!='all' and $get['produk']!=''){
		// 				$this->pawn->db2->where('pawn_transactions.product_name',$produk);
		// 			}

					
		// 	$pelunasan = $this->pawn->db2
		// 			->select("pawn_transactions.id as pawn_id, office_name as unit, cif_number, name as customer_name, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
		// 		")
		// 			->from('pawn_transactions')
		// 			->join('customers','customers.id = pawn_transactions.customer_id')
					
		// 			->where('pawn_transactions.payment_status', true)
		// 			->where('pawn_transactions.repayment_date >', $dateEnd)
		// 			->where('pawn_transactions.contract_date <=', $dateEnd)
		// 			->where('pawn_transactions.status !=', 5)
		// 			->where('pawn_transactions.transaction_type !=', 4)					
		// 			->where('pawn_transactions.transaction_type !=', 5)
		// 			->where('pawn_transactions.deleted_at', null)->get()->result();

		// 			if($get['area_id']!='all'){
		// 				$this->pawn->db2->where('pawn_transactions.area_id',$area_id);
		// 			}
		// 			if($get['branch_id']!='all' and $get['branch_id']!=''){
		// 				$this->pawn->db2->where('pawn_transactions.branch_id',$branch_id);
		// 			}
		// 			if($get['unit_id']!='all' and $get['unit_id']!=''){
		// 				$this->pawn->db2->where('pawn_transactions.office_id',$unit_id);
		// 			}
					
		// 			if($get['produk']!='all' and $get['produk']!=''){
						
		// 				$this->pawn->db2->where('pawn_transactions.product_name',$produk);
		// 			}
												
		// $this->pawn->db2
		// 			->select("pawn_transactions.id as pawn_id, office_name as unit, cif_number, name as customer_name, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
		// 		(select sum(installment_amount) from installment_items where pawn_transactions.id=installment_items.pawn_transaction_id and payment_date <= '$dateEnd' limit 1) as angsuran,
		// 		")
		// 			->from('pawn_transactions')
		// 			->join('customers','customers.id = pawn_transactions.customer_id')
		// 			->where('pawn_transactions.payment_status', false)
		// 			->where('pawn_transactions.contract_date <=', $dateEnd)
		// 			->where('pawn_transactions.status !=', 5)
		// 			->where('pawn_transactions.transaction_type !=', 4)
		// 			->where('pawn_transactions.transaction_type ', 5)
		// 			->where('pawn_transactions.deleted_at', null);
										
		// 	$aktifCicilan = $this->pawn->db2->get()->result();

		// 			if($get['area_id']!='all'){
		// 				$this->pawn->db2->where('pawn_transactions.area_id',$area_id);
		// 			}
		// 			if($get['branch_id']!='all' and $get['branch_id']!=''){
		// 				$this->pawn->db2->where('pawn_transactions.branch_id',$branch_id);
		// 			}
		// 			if($get['unit_id']!='all' and $get['unit_id']!=''){
		// 				$this->pawn->db2->where('pawn_transactions.office_id',$unit_id);
		// 			}

		// 			if($get['produk']!='all' and $get['produk']!=''){
		// 				$this->pawn->db2->where('pawn_transactions.product_name',$produk);
		// 			}

					
					
		// 			$pelunasanCicilan = $this->pawn->db2
		// 				->select("pawn_transactions.id as pawn_id, office_name as unit, cif_number, name as customer_name, sge, contract_date as Tgl_Kredit, due_date as Tgl_Jatuh_Tempo, auction_date as Tgl_Lelang, repayment_date as Tgl_Lunas, estimated_value as taksiran, loan_amount as up, admin_fee as admin, maximum_loan_percentage as ltv, interest_rate as sewa_modal, stle , product_name, insurance_item_name as bj, notes as catatan,
		// 				(select sum(installment_amount) from installment_items where pawn_transactions.id=installment_items.pawn_transaction_id and payment_date <= '$dateEnd' limit 1) as angsuran,				
		// 				")
		// 					->from('pawn_transactions')
		// 					->join('customers','customers.id = pawn_transactions.customer_id')
							
		// 					->where('pawn_transactions.payment_status', true)
		// 					// ->where('pawn_transactions.repayment_date >', $dateEnd)
		// 					->where('pawn_transactions.contract_date <=', $dateEnd)
		// 					->where('pawn_transactions.status !=', 5)
		// 					->where('pawn_transactions.transaction_type !=', 4)					
		// 					->where('pawn_transactions.transaction_type ', 5)
		// 					->where('pawn_transactions.deleted_at', null)->get()->result();
							
		// 	// $pelunasan = $this->pawn->db2->get()->result();


			// $data = array_merge($aktif,$pelunasan, $aktifCicilan,$pelunasanCicilan);
		

		var_dump($data); exit;
		echo json_encode(array(
			'data'	=> $data,
			// 'pelunasan' => $pelunasan,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	function cicilan(){
		$dateEnd = $this->input->get('dateEnd');
		$pawn_id = $this->input->get('pawn_id');	
		$data = $this->install->db2
					->select('*')
					->from('installment_items')
					->where('pawn_transaction_id', $pawn_id )
					// ->where('installment_items.payment_date <=', $dateEnd )
					->order_by('installment_order', 'asc')
					->get()->result();

		echo json_encode(array(
			'data'		=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Users'
		));
	}

}