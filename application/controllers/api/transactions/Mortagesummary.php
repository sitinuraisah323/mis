<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Mortagesummary extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MortagesSummaryModel', 'mortageSummary');
	}

	public function index()
	{
        $this->mortageSummary->db->select('*,units.name as unit_name,customers.name as customer')
			 ->join('units','units.id=units_mortages_summary.id_unit')
			 ->join('customers','customers.id=units_mortages_summary.id_customer')
             ->join('units_mortages', 'units_mortages_summary.id_unit=units_mortages.id_unit AND units_mortages_summary.no_sbk=units_mortages.no_sbk AND units_mortages_summary.nic=units_mortages.nic');
             
            if($area = $this->input->get('area')){
				$this->mortageSummary->db->where('id_area', $area);
			}else if($this->session->userdata('user')->level == 'area'){
				$this->mortageSummary->db->where('id_area', $this->session->userdata('user')->id_area);
            }
            
            if($cabang = $this->input->get('cabang')){
				$this->mortageSummary->db->where('id_cabang', $cabang);
			}else if($this->session->userdata('user')->level == 'cabang'){
				$this->mortageSummary->db->where('id_cabang', $this->session->userdata('user')->id_cabang);
            }
            
            if($unit = $this->input->get('unit')){
				$this->mortageSummary->db->where('id_unit', $unit);
			}else if($this->session->userdata('user')->level == 'unit'){
				$this->mortageSummary->db->where('units.id', $this->session->userdata('user')->id_unit);
            }
            
            if($penaksir = $this->input->get('penaksir')){
				$this->mortageSummary->db->where('id_unit', $unit);
			}else if($this->session->userdata('user')->level == 'unit'){
				$this->mortageSummary->db->where('units.id', $this->session->userdata('user')->id_unit);
            }
            
            if($permit =  $this->input->get('permit')){
				$this->mortageSummary->db->where('units_mortages.permit', $permit);
            }
            
            if($sdate =  $this->input->get('dateStart')){
				$this->mortageSummary->db->where('units_mortages.date_sbk >=', $sdate);
            }
            
            if($edate =  $this->input->get('dateEnd')){
				$this->mortageSummary->db->where('units_mortages.date_sbk <=', $edate);
            }

            // if($nasabah =  $this->input->get('nasabah')){
			// 	$this->mortageSummary->db->where('customers.nik ', $nasabah);
            // }
            
            if($sortBy = $this->input->get('sort_by')){
				$this->mortageSummary->db->order_by('units_mortages.'.$sortBy, $this->input->get('sort_method'));
			}

		$data = $this->mortageSummary->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Mortages'
		));
    }

    public function get_byid()
	{
		// echo json_encode(array(
		// 	'data'	=> 	$this->areas->find($this->input->get("id")),
		// 	'status'	=> true,
		// 	'message'	=> 'Successfully Get Data Users'
		// ));
    }

	public function insert()
	{
		if($post = $this->input->post()){

            $data['no_sbk']     = $this->input->post('no_sbk');	
            $data['id_unit']    = $this->input->post('id_unit');
            $data['nic']     = $this->input->post('nic');	
            $data['id_customer']= $this->input->post('id_customer');	
            $data['model']      = $this->input->post('jenis');	
            $data['type']       = $this->input->post('tipe');	
            $data['qty']       = $this->input->post('qty');	
            $data['karatase']   = $this->input->post('karatase');	
            $data['bruto']      = $this->input->post('bruto');
            $data['net']        = $this->input->post('net');
            $data['stle']       = $this->input->post('stle');
            $data['user_create']= $this->session->userdata('user')->id;

            if($find = $this->mortageSummary->find(array(
                'no_sbk'	    =>$data['no_sbk'],
                'id_unit'	    =>$data['id_unit'],
                'nic'	        =>$data['nic'],
                'id_customer'   =>$data['id_customer'],
            )));

            if($find){
                echo json_encode(array(
                    'data'	    => false,
                    'status'    => false,
                    'message'	=> 'Data already exist'
                ));
            }else{
                $db = false;
                $db = $this->mortageSummary->insert($data);    
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
    }
    
    public function update()
	{
		if($post = $this->input->post()){

            $id                 = $this->input->post('id');	
            $data['no_sbk']     = $this->input->post('no_sbk');	
            $data['id_unit']    = $this->input->post('id_unit');	
            $data['nic']        = $this->input->post('nic');	
            $data['id_customer']= $this->input->post('id_customer');
            $data['model']      = $this->input->post('jenis');	
            $data['type']       = $this->input->post('tipe');	
            $data['qty']       = $this->input->post('qty');	
            $data['karatase']   = $this->input->post('karatase');	
            $data['bruto']      = $this->input->post('bruto');
            $data['net']        = $this->input->post('net');
            $data['stle']       = $this->input->post('stle');
            $data['user_update']= $this->session->userdata('user')->id;

            $db = false;
            $db = $this->mortageSummary->update($data,$id);
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
            $db = $this->mortageSummary->delete($data);
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
