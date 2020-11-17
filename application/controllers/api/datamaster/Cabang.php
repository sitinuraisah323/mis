<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Cabang extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('CabangModel', 'cabang');
	}

	public function index()
	{
        //$data = $this->groups->all();
        $data = $this->db->select('cabang.id,cabang.cabang,cabang.status,areas_group.group,areas.area')
                         ->from('cabang')
                         ->join('areas_group','areas_group.id=cabang.id_group')
                         ->join('areas','areas.id=areas_group.id_area')
                         ->get()->result();
		if($post = $this->input->post()){
			if(is_array($post['query'])){
				$value = $post['query']['generalSearch'];
                $this->cabang->db
                ->or_like('name', $value)
                ->or_like('name',strtoupper($value));					
				$data = $this->cabang->all();
			}
		}        
		echo json_encode(array(
            'data'	 => $data,
            'status' => true,
			'message'=> 'Successfully Get Data Users'
		));
    }

    public function get_byid()
	{
		echo json_encode(array(
			'data'	=> 	$this->cabang->find($this->input->get("id")),
			'status'	=> true,
			'message'	=> 'Successfully Get Data Users'
		));
    }

	public function insert()
	{
		if($post = $this->input->post()){

            $data['id_group'] = $this->input->post('group');	
            $data['cabang'] = $this->input->post('cabang');	

            $db = false;
            $db = $this->cabang->insert($data);
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

            $id = $this->input->post('id');	
            $data['id_group'] = $this->input->post('group');	
            $data['cabang'] = $this->input->post('cabang');

            $db = false;
            $db = $this->cabang->update($data,$id);
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
            $db = $this->cabang->delete($data);
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
