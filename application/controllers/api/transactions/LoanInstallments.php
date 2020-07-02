<?php

require_once APPPATH.'controllers/api/ApiController.php';
class LoanInstallments extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoanInstallmentsModel', 'installment');
		$this->load->model('CustomersModel', 'customers');
		$this->load->model('MortagesModel', 'mortages');
		$this->load->model('RegularPawnsModel', 'regulars');
		$this->load->model('UnitsdailycashModel', 'unitsdailycash');
		$this->load->model('RepaymentModel', 'repayments');
		include APPPATH.'libraries/PHPExcel.php';

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

			$this->data_transaction($this->input->post('id_unit'), $path);
		}
	}

	public function data_transaction($id_unit, $path)
	{
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load($path); // Load file yang telah diupload ke folder excel
		$transactions = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		if($transactions){
			foreach ($transactions as $key => $transaction){
				if($key > 1){
					$customer = $this->customers->find(array(
						'name'	=> $transaction['B']
					));
					if($customer){
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
							'id_unit'	=> $id_unit,
							'user_create'	=> $this->session->userdata('user')->id,
							'user_update'	=> $this->session->userdata('user')->id,
							'detail'	=> json_encode($detail)
						);
						$this->installment->insertOrUpdate($data, array(
							'no_sbk'	=>zero_fill( $transaction['A'], 5),
							'id_unit'	=> $id_unit,
						));
					}

				}
			}
		}
		if(is_file($path)){
			unlink($path);
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

	public function extractall()
	{
		if($this->input->post('id_unit')){
			$idUnit = $this->input->post('id_unit');
		}else{
			$idUnit = $this->session->userdata('user')->id_unit;
		}
		$config['upload_path']          = 'storage/'.$idUnit.'/transactions/'.date('Y-m-d/');
		$config['allowed_types']        = '*';
		if(!is_dir($config['upload_path'])){
			mkdir($config['upload_path'],0777,true);
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
			$pathExtract = $config['upload_path'] .'extract-all/'.date('Y-m-d/');
			if(!is_dir($pathExtract)){
				mkdir($pathExtract,0777,true);
			}
			$zip = new ZipArchive();
			if ($zip->open($path) === TRUE) {
				$zip->extractTo($pathExtract);
				$zip->close();
				$files = scandir($pathExtract);
				$key = 10000;
				foreach ($files as $index => $file){
					if(strtoupper(substr($file,0, 2)) == 'MS'){
						$key = $index;
					}
				}
				if($key != 10000){
					$this->process_transaction($idUnit,$pathExtract, $files[$key]);
					unset($files[$key]);
				}

				foreach ($files as $index => $file){
					if($index > 1){
						$this->process_transaction($idUnit,$pathExtract, $file);
					}
				}

				echo json_encode($data['file_name']);
			} else {
				echo json_encode(array(
					'status'	=> false,
					'data'	=> 	false,
					'message'	=> 'Failed Updated Upload'
				));
			}
		}
	}

	public function process_transaction($id_unit, $path, $name)
	{
		switch(substr($name,0, 2)){
			case 'AN':
				$this->data_transaction($id_unit, $path.$name);
				break;
			case 'PC':
				$this->data_transaction_mortages($id_unit, $path.$name);
				break;
			case 'PN':
				$this->data_transaction_regular($id_unit, $path.$name);
				break;
			case 'KS':
				$this->data_transaction_cash($id_unit, $path.$name);
			break;
			case 'MS':
				$this->data_customer($id_unit,$path.$name);
			break;
			case 'LN':
				$this->data_transaction_repayment($id_unit, $path.$name);
			break;
		}
	}

	public function data_customer($id_path, $path)
	{
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
		}
		if(is_file($path)){
			unlink($path);
		}
	}

	public function data_transaction_repayment($id_unit, $path)
	{
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load($path); // Load file yang telah diupload ke folder excel
		$repayments = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		$unit = $id_unit;
		if($repayments){
			foreach ($repayments as $key => $repayment){
				if($key > 1){
					$findcustomer = $this->customers->find(array('name'=> $repayment['B']));
					$data = array(
						'no_sbk'		=> zero_fill($repayment['A'], 5),
						'id_unit'		=> $unit,
						'id_customer'	=> $findcustomer->id,
						'nic'			=> $findcustomer->no_cif,
						'date_sbk'		=> date('Y-m-d', strtotime($repayment['C'])),
						'money_loan'	=> $repayment['D'],
						'capital_lease'	=> $repayment['H'],
						'date_repayment'=> date('Y-m-d', strtotime($repayment['I'])),
						'periode'		=> $repayment['J'],
						'description_1'	=> $repayment['E'],
						'description_2'	=> $repayment['F'],
						'description_3'	=> $repayment['G']
					);
					if($findrepayment = $this->repayments->find(array(
						'id_unit'		=> $unit,
						'id_customer'	=> $findcustomer->id,
						'no_sbk'		=> zero_fill($repayment['A'], 5),
						'date_sbk'		=> date('Y-m-d', strtotime($repayment['C'])),
						'money_loan'	=> $repayment['D'],
						'capital_lease'	=> $repayment['H'],
						'date_repayment'=> date('Y-m-d', strtotime($repayment['I'])),
						'periode'		=> $repayment['J'],
						'description_1'	=> $repayment['E'],
						'description_2'	=> $repayment['F'],
						'description_3'	=> $repayment['G']
					))){
						$this->repayments->update($data, array('id'	=>  $findrepayment->id));
					}else{
						//echo "<pre/>";
						//print_r($data);
						$this->repayments->insert($data);
					}
				}
			}
		}
		if(is_file($path)){
			unlink($path);
		}
	}

	public function data_transaction_cash($id_unit, $path)
	{
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load($path); // Load file yang telah diupload ke folder excel
		$unitsdailycash = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		$date = date('Y-m-d');
		$cashcode = 'KS';
		$unit = $id_unit;
		if($unitsdailycash){
			foreach ($unitsdailycash as $key => $udc){
				if($key > 1){
					$datetrans 	= date('Y-m-d', strtotime($udc['E']));
					$kdkas		= $udc['F'];
					if($datetrans>=$date && $datetrans<=$date){
						if($kdkas==$cashcode){
							$data = array(
								'id_unit'		=> $unit,
								'cash_code'		=> $udc['F'],
								'date'			=> $datetrans,
								'amount'		=> $udc['B'],
								'description'	=> $udc['C'],
								'type'			=> null,
								'status'		=> "DRAFT"
							);
							//echo "<pre/>";
							//print_r($data);
							if($findudc = $this->unitsdailycash->find(array(
								'id_unit'		=> $unit,
								'cash_code'		=> $kdkas,
								'date'			=> $datetrans,
								'description' 	=> $udc['C']
							))){
								if($this->unitsdailycash->update($data, array(
									'id'	=>  $findudc->id
								)));
							}else{
								$this->unitsdailycash->insert($data);
							}
						}
					}

				}
			}
		}
		if(is_file($path)){
			unlink($path);
		}
	}

	public function data_transaction_regular($id_unit, $path)
	{
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
							'id_unit'	=> $id_unit,
							'user_create'	=> $this->session->userdata('user')->id,
							'user_update'	=> $this->session->userdata('user')->id,
						);
						if($findTransaction = $this->regulars->find(array(
							'no_sbk'	=>zero_fill( $transaction['A'], 5),
							'id_unit'	=> $id_unit
						))){
							if($this->regulars->update($data, array(
								'id'	=>  $findTransaction->id,
								'id_unit'	=> $id_unit
							)));
						}else{
							$this->regulars->insert($data);
						}
					}
				}
			}
		}
		if(is_file($path)){
			unlink($path);
		}
	}

	public function data_transaction_mortages($id_unit, $path)
	{

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load($path); // Load file yang telah diupload ke folder excel
		$transactions = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

		if($transactions){
			foreach ($transactions as $key => $transaction){
				if($key > 1){
					$customer = $this->customers->find(array(
						'nik'	=> $transaction['M']
					));
					$data = array(
						'no_sbk'	=> zero_fill( $transaction['A'], 5),
						'nic'	=> $customer->no_cif,
						'date_sbk'	=> $transaction['D'] ? date('Y-m-d', strtotime($transaction['D'])): null,
						'deadline'	=> $transaction['E'] ? date('Y-m-d', strtotime($transaction['E'])) : null,
						'date_auction'	=> $transaction['F'] ? date('Y-m-d', strtotime($transaction['F'])) : null,
						'estimation'	=> (int) $transaction['G'],
						'amount_loan'	=> (int) $transaction['H'],
						'amount_admin'	=> (int) $transaction['I'],
						'description_1'	=>  $transaction['J'],
						'description_2'	=>  $transaction['K'],
						'description_3'	=>  $transaction['L'],
						'description_4'	=>  $transaction['S'],
						'capital_lease'	=>  $transaction['T'],
						'periode'	=>  $transaction['U'],
						'installment'	=>  $transaction['V'],
						'status_transaction'	=>  $transaction['W'],
						'interest'	=>  $transaction['X'],
						'id_customer'	=> $customer->id,
						'id_unit'	=> $id_unit,
						'user_create'	=> $this->session->userdata('user')->id,
						'user_update'	=> $this->session->userdata('user')->id,
					);
					if($findTransaction = $this->mortages->find(array(
						'no_sbk'	=>zero_fill( $transaction['A'], 5),
					))){
						if($this->mortages->update($data, array(
							'id'	=>  $findTransaction->id
						)));
					}else{
						$this->mortages->insert($data);
					}

				}
			}
		}
		if(is_file($path)){
			unlink($path);
		}
	}

}
