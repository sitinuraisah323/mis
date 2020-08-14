<?php
require_once APPPATH.'controllers/api/ApiController.php';
class Transactions extends ApiController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('LmTransactionsModel', 'model');
	}

	public function index()
	{
		$data = $this->model->all();
		if($post = $this->input->post()){
			if(is_array($post['query'])){
				$value = $post['query']['generalSearch'];
				$this->model->db->like('level', $value);
				$data = $this->model->all();
			}
		}
		echo json_encode(array(
			'data'	=> 	$data,
			'message'	=> 'Successfully Get Data Levels'
		));
	}

	public function insert()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('level', 'Level', 'required');


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
					'level'	=> $post['level'],
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->model->insert($data)){
					echo json_encode(array(
						'data'	=> 	true,
						'status'	=> true,
						'message'	=> 'Successfull Insert Data Level'
					));
				}else{
					echo json_encode(array(
							'data'	=> 	false,
							'status'	=> false,
							'message'	=> 'Failed Insert Data Level')
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
			$this->form_validation->set_rules('level', 'Level', 'required');
			$this->form_validation->set_rules('id', 'Id', 'required|numeric');


			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	false,
					'message'	=> 'Failed Insert Data Level'
				));
			}
			else
			{
				$id = $post['id'];
				$data = array(
					'level'	=> $post['level'],
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->model->update($data, $id)){
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

}
