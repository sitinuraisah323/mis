<?php
require_once APPPATH.'controllers/api/ApiController.php';
class Transactions extends ApiController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('LmTransactionsModel', 'model');
		$this->load->model('LmTransactionsGramsModel', 'gram');
		$this->load->model('LmTransactionsLogsModel', 'logs');
		$this->load->model('LmStocksModel', 'stock');
		$this->load->model('LmGramsModel', 'master');
	}

	public function index()
	{
		if($get = $this->input->get()){
			if($idArea = $this->input->get('area')){
				$this->model->db->where('units.id_area', $idArea);
			}
			if($idUnit = $this->input->get('id_unit')){
				$this->model->db->where('id_unit', $idUnit);
			}
			if($log =  $this->input->get('statusrpt')){
				$this->model->db->where('last_log', $log);
			}
			$this->model->db->join('units','units.id = lm_transactions.id_unit');
		}
		$this->model->db
			->order_by('lm_transactions.id','desc');
		$data = $this->model->all();
		$this->master->db->order_by('weight','asc');
		$grams = $this->master->all();
		if($data){
			foreach ($data as $datum){
				if($datum->id_employee){
					$getEmployee = $this->model->db
						->select('fullname as name, position, units.name as unit')
						->from('employees')
						->join('units','units.id = employees.id_unit')
						->where('employees.id',$datum->id_employee)
						->get()->row();
					$datum->name = $getEmployee->name;
					$datum->position = $getEmployee->position;
					$datum->unit = $getEmployee->unit;
				}else{
					$datum->position = '';
					$datum->unit = '';
				}
				foreach ($grams as $gram){
					$find = $this->gram->find(array(
						'id_lm_transaction'	=> $datum->id,
						'id_lm_gram'	=> $gram->id
					));
					if($find){
						$datum->grams[] = $find->amount;
					}else{
						$datum->grams[] = 0;
					}
				}
			}
		}
		return $this->sendMessage($data,'Successfully Get Data Levels');
	}

	public function insert()
	{
		if($post = $this->input->post()){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('date', 'date', 'required');
			$this->form_validation->set_rules('code', 'code', 'required');
			$this->form_validation->set_rules('total', 'total', 'required');
			$this->form_validation->set_rules('method', 'method', 'required');


			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	false,
					'status'	=> false,
					'message'	=> validation_errors()
				));
			}
			else
			{
				$data = array(
					'id_unit'	=> $post['id_unit'],
					'id_employee'	=> $post['id_employee'],
					'date'	=> $post['date'],
					'code'	=> $post['code'],
					'total'	=> $post['total'],
					'tenor'	=> $post['tenor'],
					'method'	=> $post['method'],
					'name'	=> $post['name'],
					'nik'	=> $post['nik'],
					'mobile'	=> $post['mobile'],
					'address'	=> $post['address'],
					'type_buyer'	=> $post['type_buyer'],
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				$this->model->db->trans_begin();
				$this->model->insert($data);
				$this->model->db->order_by('id','desc');
				$find = $this->model->all()[0];
				if($find){
					$data = array();
					foreach ($post['gram'] as $index => $value){
						$data[$index] = array(
							'id_lm_transaction'	=> $find->id,
							'id_lm_gram'	=> $value['id_lm_gram'],
							'price_perpcs'	=> $value['price_perpcs'],
							'price_buyback_perpcs'	=> $value['price_buyback_perpcs'],
							'amount'	=> $value['amount'],
							'total'	=> $value['total'],
						);
					}
					$this->model->db->insert_batch('lm_transactions_grams', $data);
				}

				if($this->model->db->trans_status()){
					$this->model->db->trans_commit();
					return $this->sendMessage($find, 'successfully insert data');
				}else{
					$this->model->db->trans_rollback();
					return $this->sendMessage($this->model->db->last_query(), 'failed insert data');
				}
			}
		}else{
			return  $this->sendMessage(false,'Request Error Should Method POst', 500);
		}

	}

	public function update()
	{
		if($post = $this->input->post()){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_employee', 'id_employee', 'required');
			$this->form_validation->set_rules('date', 'date', 'required');
			$this->form_validation->set_rules('code', 'code', 'required');
			$this->form_validation->set_rules('total', 'total', 'required');
			$this->form_validation->set_rules('method', 'method', 'required');
			$this->form_validation->set_rules('id', 'Id', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				return $this->sendMessage(false,validation_errors(),500);
			}
			else
			{
				$data = array(
					'id_unit'	=> $post['id_unit'],
					'id_employee'	=> $post['id_employee'],
					'date'	=> $post['date'],
					'code'	=> $post['code'],
					'total'	=> $post['total'],
					'method'	=> $post['method'],
					'tenor'	=> $post['tenor'],
					'name'	=> $post['name'],
					'nik'	=> $post['nik'],
					'mobile'	=> $post['mobile'],
					'address'	=> $post['address'],
					'type_buyer'	=> $post['type_buyer'],
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->model->update($post['id'], $data)){
					$find = $this->model->find($post['id']);
					return $this->sendMessage($find, 'successfully Update data');
				}
				return $this->sendMessage(false, 'failed Update data');
			}
		}else{
			return  $this->sendMessage(false,'Request Error Should Method POst', 500);
		}

	}

	public function show($id)
	{
		if($data = $this->model->find($id)){
			echo json_encode(array(
				'data'	=> 	$data,
				'status'	=> true,
				'message'	=> 'Successfully Delete Data Level'
			));
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> 	false,
				'message'	=> $id. ' Not Found'
			));
		}
	}
	public function delete($id)
	{
		if($this->model->delete($id)){
			echo json_encode(array(
				'data'	=> 	true,
				'status'	=> true,
				'message'	=> 'Successfully Delete Data Level'
			));
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> false,
				'message'	=> 'Request Error Should Method Post'
			));
		}
	}

	public function change()
	{
		if($post= $this->input->post()){
			if($findTransaction = $this->model->find(array(
				'code'	=>  $this->input->post('code')
			))){
			
				// if($this->input->post('status') === 'APPROVED'){
				// 	$grams = $this->gram->findWhere(array(
				// 		'id_lm_transaction'	=> $findTransaction->id
				// 	));
				// 	foreach($grams as $gram){
				// 		$stock = $this->stock->find(array(
				// 			'reference_id'	=> $findTransaction->code,
				// 			'id_lm_gram'	=> $gram->id_lm_gram
				// 		));
				// 		if($stock == null){
				// 			$this->stock->insert(array(
				// 				'id_unit'	=> $findTransaction->id_unit,
				// 				'id_lm_gram'	=> $gram->id_lm_gram,
				// 				'amount'	=> $gram->amount,
				// 				'reference_id'	=> $findTransaction->code,
				// 				'status'	=> 'PUBLISH',
				// 				'type'	=> 'CREDIT',
				// 				'date_receive'	=> $findTransaction->date,
				// 				'description'	=> 'pembelian'
				// 			));
				// 		}else{
				// 			$this->stock->update(array(
				// 				'status'	=> 'PUBLISH',
				// 			), $stock->id);
				// 		}
				// 	}
				// }else{
				// 	$grams = $this->gram->findWhere(array(
				// 		'id_lm_transaction'	=> $findTransaction->id
				// 	));
				// 	foreach($grams as $gram){
				// 		$stock = $this->stock->find(array(
				// 			'reference_id'	=> $findTransaction->code,
				// 			'id_lm_gram'	=> $gram->id_lm_gram
				// 		));
				// 		if($stock){
				// 			$this->stock->update(array(
				// 				'status'	=> 'UNPUBLISH',
				// 			), $stock->id);
				// 		}
				// 	}
				// }
				$this->model->db->trans_start();
				$this->model->update(array(
					'last_log'	=> $this->input->post('status')
				), $findTransaction->id);

				$this->logs->insert(array(
					'id_lm_transaction'	=> $findTransaction->id,
					'status'	=> $this->input->post('status')
				));

				if($this->model->db->trans_status()){
					$this->model->db->trans_commit();
					return $this->sendMessage($findTransaction,'successfully change status', 500);

				}else{
					$this->model->db->trans_rollback();
					return $this->sendMessage(false,$this->model->db->last_query(), 500);
				}
			}
			return $this->sendMessage(false,'code transaction not found', 500);
		}
		return $this->sendMessage(false,'method should post', 500);
	}

}
