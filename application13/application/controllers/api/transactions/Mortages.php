<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Mortages extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MortagesModel', 'mortages');
		$this->load->model('CustomersModel', 'customers');
		$this->load->model('UnitsModel', 'units');
	}

	public function index()
	{
		if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}

		if($this->session->userdata('user')->level == 'cabang'){
			$this->units->db->where('units.id_cabang', $this->session->userdata('user')->id_cabang);
		}

		$units = $this->units->db->select('*')
					  ->from('units')
					  ->join('areas','areas.id=units.id_area')
					  ->join('units_mortages','units_mortages.id_unit=units.id')
					  ->get()->result();

		// $this->mortages->db->select('customers.name, units.name as unit')
		// 	->join('customers','customers.id = units_mortages.id_customer')
		// 	->join('units','units.id = units_mortages.id_unit');
		// if($post = $this->input->post()){
		// 	if(is_array($post['query'])){
		// 		$value = $post['query']['generalSearch'];
		// 		$this->mortages->db
		// 			->or_like('no_sbk',$value)
		// 			->or_like('nic',$value)
		// 			->or_like('description_1',$value)
		// 			->or_like('description_2',$value)
		// 			->or_like('description_3',$value)
		// 			->or_like('description_4',$value)
		// 			->or_like('name',$value);
		// 	}
		// }		
		// $data = $this->mortages->all();

		echo json_encode(array(
			'data'	=> $units,
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
		$config['upload_path']          = 'storage/transactions/mortages/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		if(!is_dir('storage/transactions/mortages/')){
			mkdir('storage/transactions/mortages/',0777,true);
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
			echo json_encode(array(
				'data'	=> 	true,
				'message'	=> 'Successfully Updated Upload'
			));
		}
		if(is_file($path)){
			unlink($path);
		}
	}

	public function show($id)
	{
		if($data = $this->mortages->find($id)){
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
				if($this->mortages->update($post,$id)){
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

	public function report()
	{
		$this->mortages->db
			->select('units.name as unit_name, customers.name as customer_name,customers.nik as nik, (select count(distinct(date_kredit)) from units_repayments_mortage where units_repayments_mortage.no_sbk =units_mortages.no_sbk and units_repayments_mortage.id_unit =units_mortages.id_unit  ) as cicilan')
			->join('customers','units_mortages.id_customer = customers.id')			
			->join('units','units.id = units_mortages.id_unit');
		if($get = $this->input->get()){
			$status =null;
			$nasabah = $get['nasabah'];
			if($get['statusrpt']=="0"){$status=["N","L"];}
			if($get['statusrpt']=="1"){$status=["N"];}
			if($get['statusrpt']=="2"){$status=["L"];}
			if($get['statusrpt']=="3"){$status=[""];} 
			$this->mortages->db
				//->where('units_mortages.date_sbk >=', $get['dateStart'])
				->where('units_mortages.date_sbk <=', $get['dateEnd'])
				->where_in('units_mortages.status_transaction ', $status);

			// if($idUnit = $this->input->get('id_unit')){
			// 	$this->mortages->db->where('units_mortages.id_unit', $idUnit);
			// }
			// if($area = $this->input->get('area')){
			// 	$this->mortages->db->where('id_area', $area);
			// }
			if($area = $this->input->get('area')){
				$this->mortages->db->where('id_area', $area);
			}else if($this->session->userdata('user')->level == 'area'){
				$this->mortages->db->where('id_area', $this->session->userdata('user')->id_area);
			}
	
			
			if($cabang = $this->input->get('cabang')){
				$this->mortages->db->where('id_cabang', $cabang);
			}else if($this->session->userdata('user')->level == 'cabang'){
				$this->mortages->db->where('id_cabang', $this->session->userdata('user')->id_cabang);
			}
	
			if($unit = $this->input->get('unit')){
				$this->mortages->db->where('id_unit', $unit);
			}else if($this->session->userdata('user')->level == 'unit'){
				$this->mortages->db->where('units.id', $this->session->userdata('user')->id_unit);
			}

			if($permit = $get['permit']){
				$this->mortages->db->where('permit', $permit);
			}
			if($nasabah != "all" && $nasabah != null){
				$this->mortages->db->where('customers.nik', $nasabah);
			}
			if($sortBy = $this->input->get('sort_by')){
				$this->mortages->db->order_by('units_mortages.'.$sortBy, $this->input->get('sort_method'));
			}
		}
		$data = $this->mortages->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

}
