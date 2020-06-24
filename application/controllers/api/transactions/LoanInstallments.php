<?php

require_once APPPATH.'controllers/api/ApiController.php';
class LoanInstallments extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoanInstallmentsModel', 'installment');
		$this->load->model('CustomersModel', 'customers');
	}

	public function index()
	{
		$this->installment->db->select('customers.name')->join('customers','customers.id = units_loaninstallments.id_customer');
		$data = $this->installment->all();
		if($post = $this->input->post()){
			if(is_array($post['query'])){
				$value = $post['query']['generalSearch'];
				$this->installment->db->select('customers.name')->join('customers','customers.id = units_loaninstallments.id_customer');
				$this->installment->db
					->or_like('no_sbk',$value)
					->or_like('nic',$value)
					->or_like('description_1',$value)
					->or_like('description_2',$value)
					->or_like('description_3',$value)
					->or_like('description_4',$value)
					->or_like('name',$value);
				$data = $this->installment->all();
			}
		}
		foreach ($data as $datum){
			$datum->detail = json_decode($datum->detail);
		}
		echo json_encode(array(
			'data'	=> $data,
			'message'	=> 'Successfully Get Data Users'
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
		$config['upload_path']          = 'storage/transactions/installment/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		if(!is_dir('storage/transactions/installment/')){
			mkdir('storage/transactions/installment/',0777,true);
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
							'name'	=> $transaction['B']
						));
						$detail = array(
							'angsuran' => array(
								1	=> (int) $transaction['L'],
								2	=> (int) $transaction['M'],
								3	=> (int) $transaction['N'],
								4	=> (int) $transaction['O'],
								5	=> (int) $transaction['P'],
								6	=> (int) $transaction['Q'],
								7	=> (int) $transaction['R'],
								8	=> (int) $transaction['S'],
								9	=> (int) $transaction['T'],
								10	=> (int) $transaction['U'],
								11	=> (int) $transaction['V'],
								12	=> (int) $transaction['W'],
							),
							'wallet_begin'	=>(int) $transaction['X'],
							'wallet_end'	=>(int) $transaction['Y'],
							'volo_begin'	=>(int) $transaction['Z'],
							'volo_end'	=> $transaction['AA'],
							'sm'	=> array(
								1	=> (int) $transaction['AB'],
								2	=> (int) $transaction['AC'],
								3	=> (int) $transaction['AD'],
								4	=> (int) $transaction['AE'],
								5	=> (int) $transaction['AF'],
								6	=> (int) $transaction['AG'],
								7	=> (int) $transaction['AH'],
								8	=> (int) $transaction['AI'],
								9	=> (int) $transaction['AJ'],
								10	=> (int) $transaction['AK'],
								11	=> (int) $transaction['AL'],
								12	=> (int) $transaction['AM'],
							),
							'sm_begin'	=> (int) $transaction['AN'],
							'sm_end'	=> (int) $transaction['AO'],
						);
						$data = array(
							'no_sbk'	=> zero_fill( $transaction['A'], 5),
							'nic'	=> $customer->no_cif,
							'date_sbk'	=> $transaction['C'] ? date('Y-m-d', strtotime($transaction['C'])): null,
							'amount_loan'	=> (int) $transaction['D'],
							'description_1'	=>  $transaction['E'],
							'description_2'	=>  $transaction['F'],
							'description_3'	=>  $transaction['G'],
							'capital_lease'	=>  $transaction['H'],
							'date_repayment'	=>  $transaction['I'],
							'periode'	=>  $transaction['J'],
							'id_customer'	=> $customer->id,
							'id_unit'	=> $this->input->post('id_unit'),
							'user_create'	=> $this->session->userdata('user')->id,
							'user_update'	=> $this->session->userdata('user')->id,
							'detail'	=> json_encode($detail)
						);

						if($findTransaction = $this->installment->find(array(
							'no_sbk'	=>zero_fill( $transaction['A'], 5),
							'id_unit'	=> $this->input->post('id_unit'),
						))){
							if($this->installment->update($data, array(
								'id'	=>  $findTransaction->id
							)));
						}else{
							$this->installment->insert($data);
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
		if($data = $this->installment->find($id)){
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

			$this->form_validation->set_rules('estimation', 'Estimation', 'required|numeric');
			$this->form_validation->set_rules('amount_loan', 'Amount Loan', 'required|numeric');
			$this->form_validation->set_rules('amount_admin', 'Amount Admin', 'required|numeric');
			$this->form_validation->set_rules('capital_lease', 'Capital Lease', 'required|numeric');
			$this->form_validation->set_rules('periode', 'Periode', 'required|numeric');
			$this->form_validation->set_rules('installment', 'Installment', 'required|numeric');
			$this->form_validation->set_rules('interest', 'Interest', 'required|numeric');
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
				if($this->installment->update($post,$id)){
					echo json_encode(array(
						'data'	=> 	true,
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
