<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Users extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UsersModel', 'users');
	}

	public function index()
	{
		echo json_encode(array(
			'data'	=> 	$this->user->all(),
			'message'	=> 'Successfully Get Data Users'
		));
	}

	public function insert()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');


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

	public function update()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');


			if ($this->form_validation->run() == FALSE)
			{
				echo json_encode(array(
					'data'	=> 	false,
					'message'	=> 'Failed Insert Data Users'
				));
			}
			else
			{
				if($this->users->update($post, $post['id'])){
					echo json_encode(array(
						'data'	=> 	true,
						'message'	=> 'Successfull Update Data Users'
					));
				}else{
					echo json_encode(array(
							'data'	=> 	false,
							'message'	=> 'Failed Update Data Users')
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

	public function login_verify()
	{
		if($post = $this->input->post()){
			if($this->users->login_verify($post['username'],$post['password'])){
				echo json_encode(array(
					'data'	=> 	true,
					'message'	=> 'Successfully Login'
				));
			}else{
				echo json_encode(array(
					'data'	=> 	false,
					'message'	=> 'Wrong Password Or Username'
				));
			}
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'message'	=> 'Request Error Should Method POst'
			));
		}
	}

	public function delete($id)
	{
		if($this->users->delete($id)){
			echo json_encode(array(
				'data'	=> 	true,
				'message'	=> 'Successfully Delete Data User'
			));
		}else{
			echo json_encode(array(
				'data'	=> 	false,
				'message'	=> 'Request Error Should Method Post'
			));
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		echo json_encode(array(
			'data'	=> 	true,
			'message'	=> 'Successfully Logout'
		));
	}
}
