<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Profile extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UsersModel', 'user');
	}

	public function index()
	{
        if($get = $this->input->get()){	
			$data = $this->user->db
				->from('users')
				->select('users.id as userid,users.id_unit,users.id_area,users.email,users.id_level,users.username,employees.*,areas.area,units.name as unit_name')
				->join('employees','users.id_employee=employees.id')
				->join('areas','users.id_area=areas.id','left')
				->join('units','users.id_unit=units.id','left')
				->where('users.id', $get['id']);
        }
		echo json_encode(array(
			'data'	=> $data->get()->row(),
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
		
    }
    
    public function update(){

        if($post = $this->input->post()){

            $id = $post['userid'];	
            $data['password'] = password_hash($post['new_pwd'],PASSWORD_DEFAULT);

            $db = false;
            $db = $this->user->update($data,$id);
            if($db=true){
                echo json_encode(array(
                    'data'	 => true,
                    'status' => true,
                    'message'	=> 'Successfull Update Password'
                ));
            }else{
                echo json_encode(array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Update Password'
                ));
            }
        }	
    }

}
