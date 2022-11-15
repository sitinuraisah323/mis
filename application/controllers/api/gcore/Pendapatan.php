<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Pendapatan extends ApiController
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
		$this->load->model('Non_transactional_transactionsModel', 'nonTransactional');

	}

	public function index()
	{
		$data = '';

		$date = date('Y-m-d');
		$input = [];
		if($get = $this->input->get()){
			$input['area_id'] = $this->input->get('area_id');
			$input['branch_id'] = $this->input->get('branch_id');
			$input['unit_id'] = $this->input->get('unit_id');
			$input['dateStart'] = $this->input->get('dateStart');
			$input['dateEnd'] = $this->input->get('dateEnd');
			$input['kategori'] = $this->input->get('kategori');
				
		}

		if($get['kategori']=='Admin'){
			$data = $this->getAdmin($input);			
		}else if($get['kategori']=='Sewa'){
			$data = $this->getSewa($input);			
		}else if($get['kategori']=='Denda'){
			$data = $this->getDenda($input);			
		}else if($get['kategori']=='Lainnya'){
			$data = $this->getLainnya($input);			
		}else{
			$admin = $this->getAdmin($input);		
			$sewa = $this->getSewa($input);		
			$denda = $this->getDenda($input);		
			$lain = $this->getLainnya($input);	

			$data = array_merge($admin, $sewa, $denda, $lain);
			
			

		}
		

		// var_dump($data); exit;
		echo json_encode(array(
			'data'	=> $data,
			// 'pelunasan' => $pelunasan,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	function getAdmin($input){
		if($input['area_id']!='all'){
						$this->pawn->db2->where('pawn_transactions.area_id',$input['area_id']);
					}
					if($input['branch_id']!='all' and $input['branch_id']!=''){
						$this->pawn->db2->where('pawn_transactions.branch_id',$input['branch_id']);
					}
					if($input['unit_id']!='all' and $input['unit_id']!=''){
						$this->pawn->db2->where('pawn_transactions.office_id',$input['unit_id']);
					}
					
												
		$this->pawn->db2
					->select(" 'Admin' as kategori, pawn_transactions.id as pawn_id, office_name as unit, sge, contract_date as Tgl_Kredit,EXTRACT(MONTH FROM contract_date) as month, EXTRACT(YEAR FROM contract_date) as year,  admin_fee as admin")
					->from('pawn_transactions')
					->where('pawn_transactions.contract_date >=', $input['dateStart'])
					->where('pawn_transactions.contract_date <=', $input['dateEnd'])
					->where('pawn_transactions.status !=', 5)
					->where('pawn_transactions.transaction_type !=', 4)
					->where('pawn_transactions.deleted_at', null);
										
		$data = $this->pawn->db2->get()->result();

		return $data;
	}

	function getSewa($input){
		if($input['area_id']!='all'){
						$this->pawn->db2->where('pawn_transactions.area_id',$input['area_id']);
					}
					if($input['branch_id']!='all' and $input['branch_id']!=''){
						$this->pawn->db2->where('pawn_transactions.branch_id',$input['branch_id']);
					}
					if($input['unit_id']!='all' and $input['unit_id']!=''){
						$this->pawn->db2->where('pawn_transactions.office_id',$input['unit_id']);
					}
					
												
		$this->pawn->db2
					->select("'Sewa' as kategori, pawn_transactions.id as pawn_id, office_name as unit, sge, repayment_date as Tgl_Kredit,EXTRACT(MONTH FROM repayment_date) as month, EXTRACT(YEAR FROM repayment_date) as year,  rental_amount as admin")
					->from('pawn_transactions')
					->join('transaction_payment_details', 'transaction_payment_details.pawn_transaction_id = pawn_transactions.id')
					->where('pawn_transactions.repayment_date >=', $input['dateStart'])
					->where('pawn_transactions.repayment_date <=', $input['dateEnd'])
					->where('pawn_transactions.status !=', 5)
					->where('pawn_transactions.transaction_type !=', 4)
					->where('pawn_transactions.deleted_at', null);
										
		$data = $this->pawn->db2->get()->result();

		return $data;
	}

	function getDenda($input){
		if($input['area_id']!='all'){
						$this->pawn->db2->where('pawn_transactions.area_id',$input['area_id']);
					}
					if($input['branch_id']!='all' and $input['branch_id']!=''){
						$this->pawn->db2->where('pawn_transactions.branch_id',$input['branch_id']);
					}
					if($input['unit_id']!='all' and $input['unit_id']!=''){
						$this->pawn->db2->where('pawn_transactions.office_id',$input['unit_id']);
					}
					
												
		$this->pawn->db2
					->select(" 'Denda' as kategori, pawn_transactions.id as pawn_id, office_name as unit, sge, repayment_date as Tgl_Kredit,EXTRACT(MONTH FROM repayment_date) as month, EXTRACT(YEAR FROM repayment_date) as year,  fine_amount as admin")
					->from('pawn_transactions')
					->join('transaction_payment_details', 'transaction_payment_details.pawn_transaction_id = pawn_transactions.id')
					->where('pawn_transactions.repayment_date >=', $input['dateStart'])
					->where('pawn_transactions.repayment_date <=', $input['dateEnd'])
					->where('pawn_transactions.status !=', 5)
					->where('pawn_transactions.transaction_type !=', 4)
					->where('fine_amount !=', 0)
					->where('pawn_transactions.deleted_at', null);
										
		$data = $this->pawn->db2->get()->result();

		return $data;
	}

	function getLainnya($input){

		$dateEnd = date('Y-m-d', strtotime('+1 days', strtotime($input['dateEnd'])));
		if($input['area_id']!='all'){
						$this->nonTransactional->db3->where('non_transactional_transactions.area_id',$input['area_id']);
					}
					if($input['branch_id']!='all' and $input['branch_id']!=''){
						$this->nonTransactional->db3->where('non_transactional_transactions.branch_id',$input['branch_id']);
					}
					if($input['unit_id']!='all' and $input['unit_id']!=''){
						$this->nonTransactional->db3->where('non_transactional_transactions.office_id',$input['unit_id']);
					}
					
												
				$this->nonTransactional->db3
					->select(" 'Lainnya' as kategori, non_transactional_transactions.office_name as unit, non_transactional_transactions.publish_time, non_transactionals.transaction_type, EXTRACT(MONTH FROM non_transactional_transactions.publish_time) as month, EXTRACT(YEAR FROM non_transactional_transactions.publish_time) as year,non_transactional_transactions.description as sge,non_transactional_transactions.amount as admin")
					->from('non_transactional_transactions')
					->join('non_transactionals', 'non_transactionals.id = non_transactional_transactions.non_transactional_id')
					->where('non_transactional_transactions.created_at >=', $input['dateStart'])
					->where('non_transactional_transactions.created_at <=', $dateEnd)
					->where('non_transactionals.transaction_type ', 0)
					->group_start()
					->like('non_transactional_transactions.description', 'BTE')
					->or_like('non_transactional_transactions.description', 'SGE')
					->group_end();
									
					
		$data = $this->nonTransactional->db3->get()->result();

// print_r($data); exit;
		return $data;
	}

}