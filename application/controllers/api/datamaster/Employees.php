<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Employees extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('EmployeesModel', 'employees');
		$this->load->model('UsersModel', 'users');
	}

	public function index()
	{
		$this->employees->db
			->select('name')
			->join('units','units.id = employees.id_unit');
		$data = $this->employees->all();
		if($post = $this->input->post()){
			if(is_array($post['query'])){
				$value = $post['query']['generalSearch'];
				$this->employees->db->join('units','units.id = employees.id_unit');
				$this->employees->db->like('fullname', $value);
				$data = $this->employees->all();
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

			$this->form_validation->set_rules('id_level', 'Level', 'required|numeric');
			$this->form_validation->set_rules('id_unit', 'Unit', 'required|numeric');
			$this->form_validation->set_rules('fullname', 'Nama', 'required');
			$this->form_validation->set_rules('nik', 'Nik', 'required|is_unique[employees.nik]');
			$this->form_validation->set_rules('birth_place', 'Tempat Lahir', 'required');
			$this->form_validation->set_rules('birth_date', 'Tanggal Lahir', 'required');
			$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
			$this->form_validation->set_rules('mobile', 'No Hp', 'required');
			$this->form_validation->set_rules('blood_group', 'Golongan Darah', 'required');
			$this->form_validation->set_rules('address', 'Alamat', 'required');
			$this->form_validation->set_rules('position', 'Jabatan', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');


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
					'marital'	=> $post['marital'],
					'nik'	=> $post['nik'],
					'id_unit'	=> $post['id_unit'],
					'fullname'	=> $post['fullname'],
					'birth_place'	=> $post['birth_place'],
					'birth_date'	=> $post['birth_date'],
					'gender'	=> $post['gender'],
					'mobile'	=> $post['mobile'],
					'blood_group'	=> $post['blood_group'],
					'address'	=> $post['address'],
					'position'	=> $post['position'],
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->employees->insert($data)){
					$idEmployee = $this->employees->last()->id;
					//insert to user
					$this->users->insert(array(
						'id_level'	=> $post['id_level'],
						'id_unit'	=> $post['id_unit'],
						'id_employee'	=> $idEmployee,
						'username'	=> $post['username'],
						'password'	=> password_hash($post['username'],PASSWORD_DEFAULT),
						'user_create'	=> $this->session->userdata('user')->id,
						'user_update'	=> $this->session->userdata('user')->id,
					));
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
			$this->form_validation->set_rules('nik', 'Nik', 'required');
			$this->form_validation->set_rules('id_level', 'Level', 'required|numeric');
			$this->form_validation->set_rules('id_unit', 'Unit', 'required|numeric');
			$this->form_validation->set_rules('fullname', 'Nama', 'required');
			$this->form_validation->set_rules('birth_place', 'Tempat Lahir', 'required');
			$this->form_validation->set_rules('birth_date', 'Tanggal Lahir', 'required');
			$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
			$this->form_validation->set_rules('mobile', 'No Hp', 'required');
			$this->form_validation->set_rules('blood_group', 'Golongan Darah', 'required');
			$this->form_validation->set_rules('address', 'Alamat', 'required');
			$this->form_validation->set_rules('position', 'Jabatan', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required');


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
					'id_unit'	=> $post['id_unit'],
					'fullname'	=> $post['fullname'],
					'nik'	=> $post['nik'],
					'birth_place'	=> $post['birth_place'],
					'birth_date'	=> $post['birth_date'],
					'gender'	=> $post['gender'],
					'marital'	=> $post['marital'],
					'mobile'	=> $post['mobile'],
					'blood_group'	=> $post['blood_group'],
					'address'	=> $post['address'],
					'position'	=> $post['position'],
					'user_create'	=> $this->session->userdata('user')->id,
					'user_update'	=> $this->session->userdata('user')->id,
				);
				if($this->employees->update($data, $id)){
					$idEmployee = $id;
					//insert to user
					if($post['password']){
						$this->users->update(array(
							'id_level'	=> $post['id_level'],
							'id_unit'	=> $post['id_unit'],
							'id_employee'	=> $idEmployee,
							'username'	=> $post['username'],
							'password'	=> password_hash($post['username'],PASSWORD_DEFAULT),
							'user_create'	=> $this->session->userdata('user')->id,
							'user_update'	=> $this->session->userdata('user')->id,
						), array(
							'id_employee'	=> $idEmployee
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
		$this->employees->db
			->select('username, id_level')
			->join('users','users.id_employee = employees.id');
		if($data = $this->employees->find(array(
			'employees.id'	=> $id
		))){
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
		if($this->employees->delete($id)){
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
