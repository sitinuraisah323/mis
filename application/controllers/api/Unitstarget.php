<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Unitstarget extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('UnitstargetModel', 'u_target');
	}

	public function index()
	{
		echo json_encode(array(
            'data'	=> 	$this->u_target->get_unitstarget(),
            'status'=>true,
			'message'	=> 'Successfully Get Data Users'
		));
    }

    public function get_byid()
	{
		echo json_encode(array(
			'data'	=> 	$this->u_target->get_byid($this->input->get("id")),
			'status'	=> true,
			'message'	=> 'Successfully Get Data Users'
		));
    }

	public function insert()
	{
		if($post = $this->input->post()){

            $data['id_unit']    = $this->input->post('unit');	
            $data['month']      = $this->input->post('month');	
            $data['year']       = $this->input->post('year');	
            $data['amount']     = $this->input->post('amount');	
            $db = false;
            $db = $this->u_target->insert($data);
            if($db=true){
                echo json_encode(array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Insert Data Area'
                ));
            }else{
                echo json_encode(array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Insert Data Area'
                ));
            }
        }	
    }
    
    public function update()
	{
		if($post = $this->input->post()){

            $id                 = $this->input->post('id');	
            $data['id_unit']    = $this->input->post('unit');	
            $data['month']      = $this->input->post('month');	
            $data['year']       = $this->input->post('year');	
            $data['amount']     = $this->input->post('amount');
            $db = false;
            $db = $this->u_target->update($data,$id);
            if($db=true){
                echo json_encode(array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Update Data Area'
                ));
            }else{
                echo json_encode(array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Update Data Area'
                ));
            }
        }	
    }
    
    public function delete()
	{
		if($post = $this->input->get()){

            $data['id'] = $this->input->get('id');	
            $db = false;
            $db = $this->u_target->delete($data);
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

}
