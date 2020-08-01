<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Unitsdailycash extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UnitsdailycashModel', 'unitsdailycash');
		$this->load->model('MappingcaseModel', 'm_casing');
	}

	public function index()
	{
		// $data = $this->customers->all();
		// if($post = $this->input->post()){
		// 	if(is_array($post['query'])){
		// 		$value = $post['query']['generalSearch'];
		// 		$this->customers->db
		// 			->or_like('name', $value)
		// 			->or_like('city', strtoupper($value))
		// 			->or_like('province', strtoupper($value))
		// 			->or_like('mother_name', strtoupper($value))
		// 			->or_like('sibling_name', strtoupper($value))
		// 			->or_like('marital', strtoupper($value))
		// 			->or_like('gender', strtoupper($value))
		// 			->or_like('city', $value)
		// 			->or_like('mother_name', $value)
		// 			->or_like('marital', $value)
		// 			->or_like('sibling_name', $value)
		// 			->or_like('gender', $value)
		// 			->or_like('province', $value)
		// 			->or_like('name', strtoupper($value));
		// 		$data = $this->customers->all();
		// 	}
		// }
		// echo json_encode(array(
		// 	'data'	=> $data,
		// 	'message'	=> 'Successfully Get Data Users'
		// ));
	}

	public function get_unitsdailycash()
	{
		echo json_encode(array(
			'data'	=> 	$this->unitsdailycash->get_unitsdailycash(),
			'status'	=> true,
			'message'	=> 'Successfully Get Data Users'
		));
    }

	public function upload()
	{
		$config['upload_path']          = 'storage/unitsdailycash/data/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		if(!is_dir('storage/unitsdailycash/data/')){
			mkdir('storage/unitsdailycash/data/',0777,true);
		}

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			echo json_encode(array(
				'data'	=> 	$error,
				'message'	=> 'Request Error Should Method Post'
			));
		}
		else
		{
            $unit       = $this->input->post('unit');
            $date       = date('Y-m-d',strtotime($this->input->post('datetrans'))); 
            $cashcode   = $this->input->post('kodetrans');

			$data = $this->upload->data();
			$path = $config['upload_path'].$data['file_name'];

			include APPPATH.'libraries/PHPExcel.php';

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load($path); // Load file yang telah diupload ke folder excel
			$unitsdailycash = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

			if($unitsdailycash){
				// foreach ($unitsdailycash as $key => $udc){
				// 	if($key > 1){
				// 		$data = array(
				// 			'no_cif'	=> zero_fill($udc['A'], 4),
				// 			'name'	=> $udc['B'],
				// 			'birth_date'	=> date('Y-m-d', strtotime($customer['E'])),
				// 			'mobile'	=>  "0".$customer['C'],
				// 			'birth_place'	=>  $customer['F'],
				// 			'address'	=> $customer['G'],
				// 			'nik'	=> $customer['I'],
				// 			'city'	=> $customer['F'],
				// 			'sibling_name'	=> $customer['N'],
				// 			'sibling_address_1'	=> $customer['O'],
				// 			'sibling_address_2'	=> $customer['P'],
				// 			'sibling_relation'	=> $customer['AB'],
				// 			'province'	=> $customer['T'],
				// 			'job'	=> $customer['U'],
				// 			'mother_name'	=> $customer['V'],
				// 			'citizenship'	=> $customer['W'],
				// 			'sibling_birth_date'	=> date('Y-m-d', strtotime($customer['K'])),
				// 			'sibling_birth_place'	=> $customer['J'],
				// 			'gender'	=> $customer['Z'] == 'L' ? 'MALE' : 'FEMALE',
				// 			'user_create'	=> 1,
				// 			'user_update'	=> 1
				// 		);
				// 		if($findCustomer = $this->customers->find(array(
				// 			'nik'	=> $customer['I']
				// 		))){
				// 			if($this->customers->update($data, array(
				// 				'id'	=>  $findCustomer->id
				// 			)));
				// 		}else{
				// 			$this->customers->insert($data);
				// 		}
				// 	}
				// }
				echo json_encode(array(
					'data'	    => $unit,
					'status'	=> 	true,
					'message'	=> 'Successfully Updated Upload'
				));
			}
			// if(is_file($path)){
			// 	unlink($path);
			// }
		}
	}
	
	public function delete()
	{
		if($post = $this->input->get()){

            $data['id'] = $this->input->get('id');	
            $db = false;
            $db = $this->unitsdailycash->delete($data);
            if($db=true){
                echo json_encode(array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Delete Data Area'
                ));
            }else{
                echo json_encode(array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Delete Data Area'
                ));
            }
        }	
	}
	
	public function report()
	{
		if($get = $this->input->get()){
			$this->unitsdailycash->db
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd']);
			if($get['id_unit']!='all'){
				$this->unitsdailycash->db->where('id_unit', $get['id_unit']);
			}
		}
		$this->unitsdailycash->db->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	  => $data,
			'status'  => true,
			'message' => 'Successfully Get Data Regular Pawns'
		));
	}

	public function bukubank()
	{
		if($get = $this->input->get()){
			$this->unitsdailycash->db
				->where('SUBSTRING(no_perk,1,5) =','11100')
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd'])
				->where('id_unit', $get['id_unit']);
		}
		$this->unitsdailycash->db->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	  => $data,
			'status'  => true,
			'message' => 'Successfully Get Data Regular Pawns'
		));
	}

	public function modal_kerja_pusat()
	{
		$ignore = array('1110000');
		if($get = $this->input->get()){
			$category = $get['category'];
			$this->unitsdailycash->db				
				//->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd'])
				->where('id_unit', $get['id_unit']);
				if($category=='0'){
					$this->unitsdailycash->db->where('no_perk', '1110000');
				}
				if($category=='1'){
					$this->unitsdailycash->db
					->where('SUBSTRING(no_perk,1,5) =','11100')
					->where('type =', 'CASH_IN')
					->where_not_in('no_perk', $ignore);
				}
		}
		$this->unitsdailycash->db->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function modal_kerja_mutasi_unit()
	{
		$ignore = array('1110000');
		$this->unitsdailycash->all();
		if($get = $this->input->get()){
			$this->unitsdailycash->db
				->where('SUBSTRING(no_perk,1,5) =','11100')
				->where('type =', 'CASH_IN')
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd'])
				->where('id_unit', $get['id_unit'])
				->where_not_in('no_perk', $ignore);
		}
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully get data modal kerja mutasi antar unit'
		));
	}

	public function pendapatan()
	{
		if($get = $this->input->get()){
			$category =null;
			if($get['category']=='all'){
				$data = $this->m_casing->get_list_pendapatan();
				$category=array();
				foreach ($data as $value) {
					array_push($category, $value->no_perk);
				}
			}else{
				$category=array($get['category']);
			}
			$this->unitsdailycash->db
				->where('type =', 'CASH_IN')
				->where_in('no_perk', $category)
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd'])
				->where('id_unit', $get['id_unit']);
		}
		$this->unitsdailycash->db->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

	public function pengeluaran()
	{
		if($get = $this->input->get()){
			$category =null;
			if($get['category']=='all'){
				$data = $this->m_casing->get_list_pengeluaran();
				$category=array();
				foreach ($data as $value) {
					array_push($category, $value->no_perk);
				}
			}else{
				$category=array($get['category']);
			}
			$this->unitsdailycash->db
				->where('type =', 'CASH_OUT')
				->where_in('no_perk', $category)
				->where('date >=', $get['dateStart'])
				->where('date <=', $get['dateEnd'])
				->where('id_unit', $get['id_unit']);
		}
		$this->unitsdailycash->db->join('units','units.id = units_dailycashs.id_unit');
		$data = $this->unitsdailycash->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
	}

}
