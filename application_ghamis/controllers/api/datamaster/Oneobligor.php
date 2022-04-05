<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Customers extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('CustomersModel', 'customers');
		$this->load->model('CustomersrepairModel', 'customersrepair');
	}

	public function index()
	{
		
		if(is_array($this->input->post('query'))){
			if(array_key_exists("generalSearch",$this->input->post('query'))){
				$this->customers->db->like('customers.name', $this->input->post('query')['generalSearch']);
			}			
			if(array_key_exists("limit",$this->input->post('query'))){
				if($this->input->post('query')['limit'] !== 'all'){
					$this->customers->db->limit($this->input->post('query')['limit']);
				}
			}
			if(array_key_exists("area",$this->input->post('query'))){
				if($this->input->post('query')['area']){
					$this->customers->db->where('units.id_area',$this->input->post('query')['area']);
				}
			}
			if(array_key_exists("unit",$this->input->post('query'))){
				if($this->input->post('query')['unit']){
					$this->customers->db->where('units.id',$this->input->post('query')['unit']);
				}
			}
			if(array_key_exists("cabang",$this->input->post('query'))){
				if($this->input->post('query')['cabang']){
					$this->customers->db->where('units.id_cabang',$this->input->post('query')['cabang']);
				}
			}
			if(array_key_exists("usiadari",$this->input->post('query'))){
				if($this->input->post('query')['usiadari']){
					$now = date('Y-m-d');
					$unit = $this->session->userdata('user')->id_unit;
					$this->customers->db->where("floor(datediff('$now', birth_date)/365) >=",$this->input->post('query')['usiadari'])
										->where('units.id', $unit);
				}
				
			}
			if(array_key_exists("usiasampai",$this->input->post('query'))){
				if($this->input->post('query')['usiasampai']){
					$unit = $this->session->userdata('user')->id_unit;
					$now = date('Y-m-d');
					$this->customers->db->where("floor(datediff('$now', birth_date)/365) <=",$this->input->post('query')['usiasampai'])
										->where('units.id', $unit);
				}
			}
		}else{
			if((int) $this->input->get('cabang')){
				$this->customers->db->where('units.id_cabang', $this->input->get('cabang') );
			}
			if((int) $this->input->get('unit')){
				$this->customers->db->where('units.id',$this->input->get('unit'));
			}
			if((int) $this->input->get('area')){
				$this->customers->db->where('units.id_area',$this->input->get('area'));
			}
			if((int) $this->input->get('usiadari')){
				$unit = $this->session->userdata('user')->id_unit;
				$now = date('Y-m-d');
				$this->customers->db->where("floor(datediff('$now', birth_date)/365) >=",$this->input->get('usiadari'))
									->where('units.id', $unit);
			}
			if((int) $this->input->get('usiasampai')){
				$unit = $this->session->userdata('user')->id_unit;
				$now = date('Y-m-d');
				$this->customers->db->where("floor(datediff('$now', birth_date)/365) <=",$this->input->get('usiasampai'))
									->where('units.id', $unit);
			}
			$this->customers->db->limit(100);
		}
		// $age = $this->customers->getUsia();
		if ( $this->session->userdata( 'user' )->level == 'unit' ){
			$unit = $this->session->userdata('user')->id_unit;
			$now = date('Y-m-d');
			$this->customers->db
			->select("datediff('$now', birth_date) as age_customer")
			->join('units','units.id = customers.id_unit')
			->where('units.id', $unit);
			$data =  $this->customers->all();
			echo json_encode(array(
				'data'	=> $data,
				'message'	=> 'Successfully Get Data Regular Pawns'
			));
		}else{
			$now = date('Y-m-d');
		$this->customers->db
		->select("datediff('$now', birth_date) as age_customer")
		->join('units','units.id = customers.id_unit');
		$data =  $this->customers->all();
		echo json_encode(array(
			'data'	=> $data,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
		}
	}

	// public function get_customers_usiadari($usiadari)
	// {
	// 	echo json_encode(array(
	// 		'data'	    => 	$this->customers->usiadari($usiadari),
	// 		'status'	=> true,
	// 		'message'	=> 'Successfully Get Data Cusotomers'
	// 	));
    // }

	// public function get_customers_usiadari($usiasampai)
	// {
	// 	echo json_encode(array(
	// 		'data'	    => 	$this->customers->usiasampai($usiasampai),
	// 		'status'	=> true,
	// 		'message'	=> 'Successfully Get Data Customers'
	// 	));
    // }

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

	public function current()
	{
		$permit = $this->input->get('permit');
		$area = $this->input->get('area');
		if(!$permit && !$area){
			return $this->sendMessage(false, 'permit and area should request',400);
		}
		$data = $this->customers->current($permit, $area);
		return $this->sendMessage($data, 'Successfully get customer current');
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
				$id  = $post['id'];
				$ktp = $post['nik'];

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

				$iddata['reff_customers'] 		=  $id;
				$cusrepair['reff_customers'] 	=  $id;
				$cusrepair['ktp_customers'] 	= $ktp;
				//$this->customersrepair->insert($cusrepair);
				$updt = $this->customersrepair->db->where('reff_customers',$id)->from('customers_history')->get()->row();
				if($updt){
					$this->customersrepair->update($cusrepair,$iddata);
				}else{
					$this->customersrepair->insert($cusrepair);
				}
			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'message'	=> 'Request Error Should Method POst'
			));
		}

	}
	
	public function performances()
	{
		$area = $this->input->get('area') ;
		$queryArea = $area ? " and units.id_area = '$area' " : '';

		$unit = $this->input->get('unit') ;
		$queryUnit = $unit ? " and units.id = '$unit' " : '';

		$permit = $this->input->get('permit') ;
		$queryPermit = $permit ? " and ur2.permit = '$permit' " : '';

		$dateStart = $this->input->get('dateStart') ?  $this->input->get('dateStart') : '';
		$dateEnd = $this->input->get('dateEnd') ?  $this->input->get('dateEnd') : '';
		$query = "select (1) as kode_nasabah, c2.id, c2.name, c2.birth_place ,c2.birth_date, 
			concat(c2.address,' RT ',c2.rt,' RW ',c2.rw, ' KEC ', c2.kecamatan,' KOTA ', c2.city, ' ',c2.province ) as address,
			c2.nik, (0) as number_identitas, c2.no_cif, (0) as npwp, areas.area, units.name as unit
			FROM customers c2 
			join units on units.id = c2.id_unit 
			join areas on areas.id = units.id_area 
			where c2.id in(select ur2.id_customer from units_regularpawns ur2
			join units on units.id = ur2.id_unit
			join areas on areas.id = units.id_area
			where date_sbk >= '$dateStart' and date_sbk <= '$dateEnd' $queryPermit $queryArea $queryUnit) 
			and c2.id not in ( select ur2.id_customer from units_regularpawns ur2
			join units on units.id = ur2.id_unit
			join areas on areas.id = units.id_area
			where date_sbk <'$dateStart' $queryPermit $queryArea $queryUnit)
			$queryArea
		";
		$data = $this->customers->db->query($query)->result();

		echo json_encode(array(
				'data'	=> 	$data,
				'message'	=> 'Successfully get performance editeed'
			));
		
	}

	

}
