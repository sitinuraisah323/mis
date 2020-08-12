<?php
require_once APPPATH.'controllers/api/ApiController.php';
class Grams extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LmGramsModel', 'model');
		$this->load->model('LmGramsPricesModel', 'prices');
	}

	public function index()
	{
		$grams = $this->model->all();
		if($grams){
			foreach ($grams as $gram){
				$this->prices->db->order_by('lm_grams_prices.id','desc');
				$prices = $this->prices->find(array(
					'id_lm_gram'	=> $gram->id
				));
				if($prices){
					$gram->price_perpcs = $prices->price_perpcs;
					$gram->price_buyback_perpcs = $prices->price_buyback_perpcs;
				}
			}
		}
		$this->sendMessage($grams,'Successfully get Grams',200);
	}

	public function insert()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('name', 'Nama', 'required');
			$this->form_validation->set_rules('id_parent', 'Menu Utama', 'required');


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
					'id_parent'	=> $post['id_parent'],
					'name'	=> $post['name'],
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->menu->insert($data)){
					$this->menu->buildHirarki();
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
			$this->form_validation->set_rules('name', 'Nama', 'required');
			$this->form_validation->set_rules('id_parent', 'Menu Utama', 'required');
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
					'name'	=> $post['name'],
					'id_parent'	=> $post['id_parent'],
				);
				if($this->menu->update($data, $id)){
					$this->menu->buildHirarki();
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
		if($data = $this->menu->find($id)){
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
		if($this->menu->delete($id)){
			$this->menu->buildHirarki();
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
