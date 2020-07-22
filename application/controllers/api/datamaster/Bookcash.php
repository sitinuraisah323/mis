<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Bookcash extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('BookCashModel', 'model');
		$this->load->model('BookCashModelModel', 'money');
	}

	public function index()
	{
		$this->model->db
			->select('units.name as unit_name')
			->join('units','units.id = units_cash_book.id_unit');
		if($this->session->userdata('user')->level != 'administrator'){
			$this->model->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		$data = $this->model->all();
		if($post = $this->input->post()){
			if(is_array($post['query'])){
				$value = $post['query']['generalSearch'];
				$this->model->db
					->select('units.name as unit_name')
					->join('units','units.id = units_cash_book.id_unit')
					->or_like('units.name', $value);
				$data = $this->model->all();
			}
		}
		echo json_encode(array(
			'data'	=> 	$data,
			'message'	=> 'Successfully Get Data Menu'
		));
	}

	public function insert()
	{
		if($post = $this->input->post()){
			$this->load->library('form_validation');

			$this->form_validation->set_rules('id_unit', 'Unit', 'required');


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
					'total'	=> $post['total'],
					'id_unit'	=> $post['id_unit'],
					'timestamp'	=> date('Y-m-d H:i:s'),
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->model->insert($data)){
					$idUnitCashBook = $this->model->last()->id;
					foreach ($post['fraction'] as $fraction){
						$this->money->insert(array(
							'id_unit_cash_book'	=> $idUnitCashBook,
							'id_fraction_of_money'	=> $fraction['id_fraction_of_money'],
							'amount'	=> $fraction['amount'],
							'summary'	=> $fraction['summary'],
							'user_create'	=> $this->session->userdata('user')->id,
							'user_update'	=> $this->session->userdata('user')->id,
						));
					}
					echo json_encode(array(
						'data'	=> 	true,
						'status'	=> true,
						'message'	=> 'Successfull Insert Data Menu'
					));
				}else{
					echo json_encode(array(
						'data'	=> 	false,
						'status'	=> false,
						'message'	=> 'Failed Insert Data Menu')
					);
				}

			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> 	false,
				'message'	=> 'Request Error Should Method POst'
			));
		}

	}

	public function update()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_unit', 'Unit', 'required');
			$this->form_validation->set_rules('id', 'Id', 'required');



			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	false,
					'status'	=> false,
					'message'	=> 'Failed Insert Data Level'
				));
			}
			else
			{
				$id = $post['id'];
				$data = array(
					'total'	=> $post['total'],
					'id_unit'	=> $post['id_unit'],
					'timestamp'	=> date('Y-m-d H:i:s'),
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->model->update($data, $id)){
					$idUnitCashBook = $id;
					$this->money->delete(array(
						'id_unit_cash_book'	=> $idUnitCashBook
					));
					foreach ($post['fraction'] as $fraction){
						$this->money->insert(array(
							'id_unit_cash_book'	=> $idUnitCashBook,
							'id_fraction_of_money'	=> $fraction['id_fraction_of_money'],
							'amount'	=> $fraction['amount'],
							'summary'	=> $fraction['summary'],
							'user_create'	=> $this->session->userdata('user')->id,
							'user_update'	=> $this->session->userdata('user')->id,
						));
					}
					echo json_encode(array(
						'data'	=> 	true,
						'status'	=> true,
						'message'	=> 'Successfull Update Data Level'
					));
				}else{
					echo json_encode(array(
							'data'	=> 	false,
							'status'	=> false,
							'message'	=> 'Failed Update Data Level')
					);
				}

			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'status'	=> false,
				'message'	=> 'Request Error Should Method POst'
			));
		}

	}

	public function show($id)
	{
		$this->model->db
			->select('name as unit_name')
			->join('units','units.id = units_cash_book.id_unit');
		if($data = $this->model->find(array(
			'units_cash_book.id'	=> $id
		))){
			$this->money->db
				->select('fraction_of_money.read')
				->join('fraction_of_money','fraction_of_money.id = units_cash_book_money.id_fraction_of_money');
			$data->detail = $this->money->findWhere(array(
				'id_unit_cash_book'	=> $data->id
			));
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
			$this->model->buildHirarki();
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


}
