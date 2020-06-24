<?php

require_once APPPATH.'controllers/api/ApiController.php';
class RegularPawns extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('RegularPawnsModel', 'regulars');
		$this->load->model('CustomersModel', 'customers');
	}

	public function index()
	{
		$this->regulars->db->select('customers.name')->join('customers','customers.id = units_regularpawns.id_customer');
		$data = $this->regulars->all();
		if($post = $this->input->post()){
			if(is_array($post['query'])){
				$value = $post['query']['generalSearch'];
				$this->regulars->db->select('customers.name')->join('customers','customers.id = units_regularpawns.id_customer');
				$this->regulars->db
					->or_like('no_sbk',$value)
					->or_like('nic',$value)
					->or_like('description_1',$value)
					->or_like('description_2',$value)
					->or_like('description_3',$value)
					->or_like('description_4',$value)
					->or_like('name',$value)
					->order_by('name','ASC');
				$data = $this->regulars->all();
			}
		}
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
		$config['upload_path']          = 'storage/transactions/regular-pawns/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		if(!is_dir('storage/transactions/regular-pawns/')){
			mkdir('storage/transactions/regular-pawns/',0777,true);
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
			$transactions = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

			if($transactions){
				foreach ($transactions as $key => $transaction){
					if($key > 1){
						$customer = $this->customers->find(array(
							'nik'	=> $transaction['M']
						));
						if(!is_null($customer)){
							$data = array(
								'no_sbk'	=> zero_fill( $transaction['A'], 5),
								'nic'	=> $customer->no_cif,
								'date_sbk'	=> $transaction['D'] ? date('Y-m-d', strtotime($transaction['D'])): null,
								'deadline'	=> $transaction['E'] ? date('Y-m-d', strtotime($transaction['E'])) : null,
								'date_auction'	=> $transaction['F'] ? date('Y-m-d', strtotime($transaction['F'])) : null,
								'estimation'	=> (int) $transaction['G'],
								'amount'	=> (int) $transaction['H'],
								'admin'	=> (int) $transaction['I'],
								'description_1'	=>  $transaction['J'],
								'description_2'	=>  $transaction['K'],
								'description_3'	=>  $transaction['L'],
								'description_4'	=>  $transaction['S'],
								'type_item'	=> $transaction['Q'],
								'capital_lease'	=>  $transaction['T'],
								'periode'	=>  $transaction['U'],
								'installment'	=>  $transaction['V'],
								'status_transaction'	=>  $transaction['W'],
								'id_customer'	=> $customer->id,
								'type_bmh'	=> $transaction['X'],
								'id_unit'	=> $this->input->post('id_unit'),
								'user_create'	=> $this->session->userdata('user')->id,
								'user_update'	=> $this->session->userdata('user')->id,
							);
							if($findTransaction = $this->regulars->find(array(
								'no_sbk'	=>zero_fill( $transaction['A'], 5),
								'id_unit'	=> $this->input->post('id_unit')
							))){
								if($this->regulars->update($data, array(
									'id'	=>  $findTransaction->id,
									'id_unit'	=> $this->input->post('id_unit')
								)));
							}else{
								$this->regulars->insert($data);
							}
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
		if($data = $this->regulars->find($id)){
			echo json_encode(array(
				'data'	=> $data,
				'status'	=> true,
				'message'	=> 'Successfully Get Data Regular Pawns'
			));
		}else{
			echo json_encode(array(
				'data'	=> false,
				'status'	=> false,
				'message'	=> 'Successfully Get Data Regular Pawns'
			));
		}
	}

	public function update()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('estimation', 'Estimation', 'required|numeric');
			$this->form_validation->set_rules('amount', 'Amount Loan', 'required|numeric');
			$this->form_validation->set_rules('admin', 'Amount Admin', 'required|numeric');
			$this->form_validation->set_rules('capital_lease', 'Capital Lease', 'required|numeric');
			$this->form_validation->set_rules('periode', 'Periode', 'required|numeric');
			$this->form_validation->set_rules('installment', 'Installment', 'required|numeric');
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
				if($this->regulars->update($post,$id)){

					echo json_encode(array(
						'data'	=> 	$this->regulars->db->last_query(),
						'message'	=> 'Successfull Updated Data Users'
					));
				}else{
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
