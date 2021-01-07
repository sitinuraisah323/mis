<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Regularpawnssummary extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('RegularpawnsSummaryModel', 'regularSummary');
		$this->load->model('RegularpawnsModel', 'regulars');
	}

	public function index()
	{

        $this->regularSummary->db->select('*,units.name as unit_name,customers.name as customer')
			 ->join('units','units.id=units_regularpawns_summary.id_unit')
			 ->join('customers','customers.id=units_regularpawns_summary.id_customer')
             ->join('units_regularpawns', 'units_regularpawns_summary.id_unit=units_regularpawns.id_unit AND units_regularpawns_summary.no_sbk=units_regularpawns.no_sbk AND units_regularpawns_summary.nic=units_regularpawns.nic');
             
            if($area = $this->input->get('area')){
				$this->regularSummary->db->where('id_area', $area);
			}else if($this->session->userdata('user')->level == 'area'){
				$this->regularSummary->db->where('id_area', $this->session->userdata('user')->id_area);
            }
            
            if($cabang = $this->input->get('cabang')){
				$this->regularSummary->db->where('id_cabang', $cabang);
			}else if($this->session->userdata('user')->level == 'cabang'){
				$this->regularSummary->db->where('id_cabang', $this->session->userdata('user')->id_cabang);
            }
            
            if($unit = $this->input->get('unit')){
				$this->regularSummary->db->where('id_unit', $unit);
			}else if($this->session->userdata('user')->level == 'unit'){
				$this->regularSummary->db->where('units.id', $this->session->userdata('user')->id_unit);
            }
            
            if($penaksir = $this->input->get('penaksir')){
                $this->regularSummary->db->where('id_unit', $unit);
			}else if($this->session->userdata('user')->level == 'unit'){
				$this->regularSummary->db->where('units.id', $this->session->userdata('user')->id_unit);
            }
            
            if($permit =  $this->input->get('permit')){
				$this->regularSummary->db->where('units_regularpawns.permit', $permit);
            }
            
            if($sdate =  $this->input->get('dateStart')){
				$this->regularSummary->db->where('units_regularpawns.date_sbk >=', $sdate);
            }
            
            if($edate =  $this->input->get('dateEnd')){
				$this->regularSummary->db->where('units_regularpawns.date_sbk <=', $edate);
            }

            // if($nasabah =  $this->input->get('nasabah')){
			// 	$this->regularSummary->db->where('customers.nik ', $nasabah);
            // }
            
            if($sortBy = $this->input->get('sort_by')){
				$this->regularSummary->db->order_by('units_regularpawns.'.$sortBy, $this->input->get('sort_method'));
			}

		$data = $this->regularSummary->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
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

    public function get_customers()
	{
        $idunit     = $this->input->get('idunit');
        $customer   = $this->input->get('customer');
        $data = $this->regularSummary->db->distinct('units_regularpawns_summary.no_sbk,units_regularpawns_summary.id_unit')
                                         ->select('units_regularpawns_summary.no_sbk,units_regularpawns_summary.id_unit,customers.name as customer')
                                         ->from('units_regularpawns_summary')
                                         ->join('units_regularpawns','units_regularpawns.no_sbk=units_regularpawns_summary.no_sbk AND units_regularpawns.id_unit=units_regularpawns_summary.id_unit')
                                         ->join('customers','customers.id=units_regularpawns.id_customer')
                                         ->where('units_regularpawns_summary.id_unit',$idunit)
                                         ->where('customers.id',$customer)
                                         ->get()->result();
		echo json_encode(array(
			'data'	=> 	$data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Users'
		));
    }

    public function get_regularpawns(){

        $no_sbk = $this->input->get('no_sbk');
        $idunit = $this->input->get('idunit');

        $units = $this->regulars->db->select('*')
                          ->from('units_regularpawns')
                          ->join('customers','customers.id = units_regularpawns.id_customer')
                          ->where('units_regularpawns.id_unit',$idunit)
                          ->where('units_regularpawns.no_sbk',$no_sbk)
                          ->get('units')->row();
         $units->summary = $this->regularSummary->get_regularssummary($idunit,$no_sbk);
        
        echo json_encode(array(
        'data'	=> 	$units,
        'status'	=> true,
        'message'	=> 'Successfully Get Data Users'
        ));

    }

	public function insert()
	{
		if($post = $this->input->post()){            
            $db = false;
            $CountData = count($this->input->post('jenis'));
            for($i=0; $i < $CountData; $i++){
                if(!empty($this->input->post('jenis')[$i])){
                    $data['no_sbk']         = $this->input->post('no_sbk');	
                    $data['id_unit']        = $this->input->post('id_unit');	
                    $data['nic']            = $this->input->post('nic');	
                    $data['id_customer']    = $this->input->post('id_customer');
                    $data['status_sbk']    = $this->input->post('status');
                    $data['ref_sbk']        = $this->input->post('no_referensi');
                    $data['model']          = $this->input->post('jenis')[$i];	
                    $data['type']           = $this->input->post('tipe')[$i];	
                    $data['qty']            = $this->input->post('qty')[$i];	
                    $data['karatase']       = $this->input->post('karatase')[$i];	
                    $data['bruto']          = $this->input->post('bruto')[$i];
                    $data['net']            = $this->input->post('net')[$i];
                    //$data['stle']           = $this->input->post('stle')[$i];
                    $data['description']    = $this->input->post('description')[$i];
                    $data['user_create']= $this->session->userdata('user')->id;               
                    $db = $this->regularSummary->insert($data);         
                }          
            } 
            
            if($db=true){
                echo json_encode(array(
                    'data'	=> 	true,
                    'status'=>true,
                    'message'	=> 'Successfull Insert Data regular'
                ));
            }else{
                echo json_encode(array(
                    'data'	=> 	false,
                    'status'=>false,
                    'message'	=> 'Failed Insert Data regular'
                ));
            }

            // echo json_encode(array(
            //     'data'	=> 	$data,
            //     'status'=>false,
            //     'message'	=> 'Failed Insert Data Area'
            // ));

            // if($find = $this->regularSummary->find(array(
            //     'no_sbk'	    =>$data['no_sbk'],
            //     'id_unit'	    =>$data['id_unit'],
            //     'nic'	        =>$data['nic'],
            //     'id_customer'   =>$data['id_customer'],
            // )));

            // if($find){
            //     echo json_encode(array(
            //         'data'	=> 	false,
            //         'status'=>false,
            //         'message'	=> 'Data already exist'
            //     ));
            // }else{
            //     $db = false;
            //     $db = $this->regularSummary->insert($data);    
            //     if($db=true){
            //         echo json_encode(array(
            //             'data'	=> 	true,
            //             'status'=>true,
            //             'message'	=> 'Successfull Insert Data Area'
            //         ));
            //     }else{
            //         echo json_encode(array(
            //             'data'	=> 	false,
            //             'status'=>false,
            //             'message'	=> 'Failed Insert Data Area'
            //         ));
            //     }
            // }            
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
            $db = $this->regularSummary->update($data,$id);
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
            $db = $this->regularSummary->delete($data);
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
