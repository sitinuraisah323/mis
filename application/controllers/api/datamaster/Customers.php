<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Customers extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('CustomersModel', 'customers');
	}

	public function index()
	{
		$level = $this->session->userdata('user')->level;
		$idunit = $this->session->userdata('user')->id_unit;
		$this->customers->db->join('units','units.id=customers.id_unit')->order_by('customers.id','asc');

			if($level == 'unit'){
				$this->customers->db->where('units.id', $this->session->userdata('user')->id_unit);
			}

			if($level == 'cabang'){
				$this->customers->db->where('units.id_cabang', $this->session->userdata('user')->id_cabang);
			}

		if($post = $this->input->post()){
			if(is_array($post['query'])){
				$value = $post['query']['generalSearch'];
					$this->customers->db->like('customers.name', $value);												
			}
		}

		$data =  $this->customers->all();				
		echo json_encode(array(
			'data'	=> $data,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function insert()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required',
				array('required' => 'You must provide a %s.')
			);
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');


			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	false,
					'message'	=> 'Failed Insert Data Users'
				));
			}
			else
			{
				if($this->users->insert($post)){
					echo json_encode(array(
						'data'	=> 	true,
						'message'	=> 'Successfull Insert Data Users'
					));
				}else{
					echo json_encode(array(
						'data'	=> 	false,
						'message'	=> 'Failed Insert Data Users')
					);
				}

			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'message'	=> 'Request Error Should Method POst'
			));
		}

	}

	public function upload()
	{
		$config['upload_path']          = 'storage/customers/data/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		if(!is_dir('storage/customers/data/')){
			mkdir('storage/customers/data/',0777,true);
		}

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			echo json_encode(array(
				'data'	=> 	$error,
				'message'	=> 'Request Error Should Method POst'
			));
		}
		else
		{
			$data = $this->upload->data();
			$path = $config['upload_path'].$data['file_name'];

			include APPPATH.'libraries/PHPExcel.php';

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load($path); // Load file yang telah diupload ke folder excel
			$customers = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

			if($customers){
				foreach ($customers as $key => $customer){
					if($key > 1){
						$data = array(
							'no_cif'	=> zero_fill($customer['A'], 5),
							'name'	=> $customer['B'],
							'birth_date'	=> date('Y-m-d', strtotime($customer['E'])),
							'mobile'	=>  "0".$customer['C'],
							'birth_place'	=>  $customer['F'],
							'address'	=> $customer['G'],
							'nik'	=> $customer['I'],
							'city'	=> $customer['F'],
							'sibling_name'	=> $customer['N'],
							'sibling_address_1'	=> $customer['O'],
							'sibling_address_2'	=> $customer['P'],
							'sibling_relation'	=> $customer['AB'],
							'province'	=> $customer['T'],
							'job'	=> $customer['U'],
							'mother_name'	=> $customer['V'],
							'citizenship'	=> $customer['W'],
							'sibling_birth_date'	=> date('Y-m-d', strtotime($customer['K'])),
							'sibling_birth_place'	=> $customer['J'],
							'gender'	=> $customer['Z'] == 'L' ? 'MALE' : 'FEMALE',
							'user_create'	=> $this->session->userdata('user')->id,
							'user_update'	=> $this->session->userdata('user')->id,
						);
						if($findCustomer = $this->customers->find(array(
							'nik'	=> $customer['I']
						))){
							if($this->customers->update($data, array(
								'id'	=>  $findCustomer->id
							)));
						}else{
							$this->customers->insert($data);
						}

					}
				}
				echo json_encode(array(
					'data'	=> 	true,
					'message'	=> 'Successfully Updated Upload'
				));
			}
			if(is_file($path)){
				unlink($path);
			}
		}
	}

	public function show($id)
	{
		if($data = $this->customers->find($id)){
			echo json_encode(array(
				'data'	=> $data,
				'status'	=> true,
				'message'	=> 'Successfully Get Data Customer'
			));
		}else{
			echo json_encode(array(
				'data'	=> $data,
				'status'	=> true,
				'message'	=> 'Successfully Get Data Customer'
			));
		}
	}

	public function update()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('name', 'name', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	validation_errors(),
					'message'	=> 'Failed Updated Data Users'
				));
			}
			else
			{
				$id = $post['id'];
				unset($post['id']);
				if($this->customers->update($post,$id)){
					echo json_encode(array(
						'data'	=> 	true,
						'message'	=> 'Successfull Updated Data Users'
					));
				}else{
					var_dump($this->customers->db->last_query());
					exit;
					echo json_encode(array(
							'data'	=> 	false,
							'message'	=> 'Failed Updated Data Users')
					);
				}

			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'message'	=> 'Request Error Should Method POst'
			));
		}

	}

}
