<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Pelunasan extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('gcore');
		$this->db2 = $this->load->database('db2',TRUE);
		$this->db3 = $this->load->database('db3',TRUE);
		$this->load->model('Pawn_transactionsModel', 'pawn');
		// $this->load->model('Pawn_insuranceitemsModel', 'ins_items');		
		$this->load->model('GCustomersModel', 'gcustomers');
		$this->load->model('GCustomerContactsModel', 'gcc');
		$this->load->model('UnitsModel', 'units');
		$this->load->model('AreasModel', 'areas');
		$this->load->model('CabangModel', 'cabang');
		set_time_limit(0);

	}

	public function index()
	{
		if($get = $this->input->get()){

			$this->pawn->db2
					->select("office_name,product_name,customers.name as customer,sge,contract_date,due_date,auction_date,repayment_date,estimated_value,loan_amount,admin_fee, monthly_fee,transaction_payment_details.rental_amount,transaction_payment_details.fine_amount,transaction_payment_details.payment_amount,interest_rate,insurance_item_name,created_by,approved_by,
								")
					->from('pawn_transactions')
					->join('customers','customers.id = pawn_transactions.customer_id')
					->join('transaction_payment_details','transaction_payment_details.pawn_transaction_id = pawn_transactions.id')
					->where('repayment_date >=', $get['dateStart'])
					->where('repayment_date <=', $get['dateEnd'])
					->where('pawn_transactions.payment_status ', TRUE)
					->where('pawn_transactions.deleted_at ', null)
					->where('transaction_payment_details.deleted_at ', null)
					->where('pawn_transactions.status !=', 5);
					
					if($get['area_id']!='all'){
						$this->pawn->db2->where('pawn_transactions.area_id',$get['area_id']);
					}
					if($get['branch_id']!='all' and $get['branch_id']!=''){
						$this->pawn->db2->where('pawn_transactions.branch_id',$get['branch_id']);
					}
					if($get['unit_id']!='all' and $get['unit_id']!=''){
						$this->pawn->db2->where('pawn_transactions.office_id',$get['unit_id']);
					}
					if($get['product']){
						$this->pawn->db2->where('pawn_transactions.product_name',$get['product']);
					}
			$data = $this->pawn->db2->order_by('pawn_transactions.contract_date','asc')->get()->result();

			echo json_encode(array(
				'data'		=> $data,
				'status'	=> true,
				'message'	=> 'Successfully Get Data Regular Pawns'
			));
		}		
	}
}