<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Regularpawnssummary extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('RegularpawnsSummaryModel', 'regularSummary');
		$this->load->model('RegularpawnsHeaderModel', 'regularHeader');
		$this->load->model('RegularpawnsVerifiedModel', 'regularVerified');
		$this->load->model('RegularPawnsModel', 'regulars');
		$this->load->model('CustomersModel', 'customers');
		$this->load->model('regularpawnshistoryModel', 'customerrepair');
		$this->load->model('UnitsModel', 'units');
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
            
            // if($sortBy = $this->input->get('sort_by')){
			// 	$this->regularSummary->db->order_by('units_regularpawns.'.$sortBy, $this->input->get('sort_method'));
			// }

		$data = $this->regularSummary->all();
		echo json_encode(array(
			'data'	=> $data,
			'status'	=> true,
			'message'	=> 'Successfully Get Data Regular Pawns'
		));
    }

    public function get_transaction()
	{
        $idUnit = $this->session->userdata('user')->id_unit;
        $this->regulars->db->select('units_regularpawns.id, units_regularpawns.no_sbk,units_regularpawns.date_sbk,units_regularpawns.permit,units_regularpawns.amount,units_regularpawns.deadline,
                                units_regularpawns.nic,description_1,
                                units.name as unit_name,customers.name as customer,units_regularpawns_header.id_unit as unit')
                           ->from('units_regularpawns')
                           ->join('units','units.id=units_regularpawns.id_unit')
                           ->join('customers','customers.id=units_regularpawns.id_customer')
                           ->join('units_regularpawns_header', 'units_regularpawns_header.id_unit=units_regularpawns.id_unit AND units_regularpawns_header.no_sbk=units_regularpawns.no_sbk AND units_regularpawns_header.permit=units_regularpawns.permit' ,'left')
                           ->where(' NOT EXISTS (
                                    SELECT 1 FROM units_repayments WHERE units_repayments.id = units_regularpawns.id_repayment 
                                    AND units_repayments.date_repayment <= "2021-03-31")')
                           ->where('units_regularpawns.date_sbk <=',"2021-03-31")       
                           ->where('units_regularpawns_header.id_unit ',null)                  
                           ->where('units_regularpawns.id_unit ',$idUnit)
                           ->limit(5);               
        
            if($post = $this->input->post()){
                if(is_array($post['query'])){
                    $value = $post['query']['generalSearch'];
                    $this->regulars->db->like('customers.name',$value);
                }
            }
            $data =  $this->regulars->db->get()->result();
            echo json_encode(array(
                'data'		=> $data,
                'message'	=> 'Successfully Get Data Regular Pawns'
            ));
    }

    public function getbjreguler()
    {
            $this->regularVerified->db->select('areas.area as area,units_regularpawns_verified.id_unit,units.name as unit_name,units_regularpawns.nic,customers.name as customer,units_regularpawns.no_sbk,units_regularpawns.date_sbk,units_regularpawns.amount,units_regularpawns.estimation,units_regularpawns.permit')
                                      ->join('units_regularpawns', 'units_regularpawns_verified.id_unit=units_regularpawns.id_unit AND units_regularpawns_verified.no_sbk=units_regularpawns.no_sbk AND units_regularpawns_verified.permit=units_regularpawns.permit')
                                      ->join('customers','customers.id=units_regularpawns.id_customer')
                                      ->join('units','units.id=units_regularpawns_verified.id_unit')
                                      ->join('areas','areas.id = units.id_area');
        
                    if($this->input->get('area')){
                        $area = $this->input->get('area');
                        $this->regularVerified->db->where('units.id_area', $area);
                    }else if($this->session->userdata('user')->level == 'area'){
                        $this->units->db->where('units.id_area', $this->session->userdata('user')->id_area);
                    }
            
                    if($this->input->get('unit')){
                        $unitId = $this->input->get('unit');
                        $this->regularVerified->db->where('units.id', $unitId);
                    }else if($this->session->userdata('user')->level == 'unit'){
                        $this->regularVerified->db->where('units.id', $this->session->userdata('user')->id_unit);
                    }
        
                    if($dateStart = $this->input->get('dateStart')){
                        $this->regularVerified->db->where('units_regularpawns.date_sbk >=', $dateStart);
                    }

                    if($dateEnd = $this->input->get('dateEnd')){
                        $this->regularVerified->db->where('units_regularpawns.date_sbk <=', $dateEnd);
                    }

                    if($permit = $this->input->get('permit')){
                        $this->regularVerified->db->where('units_regularpawns.permit', $permit);
                    }

                $units =  $this->regularVerified->all();    
                
                foreach ($units as $unit) {
                    $unit->items = $this->regularSummary->getSummaryGramation($unit->id_unit,$unit->no_sbk,$unit->permit);
                }
                return $this->sendMessage($units,'Successfully get barang jaminan');
    }

    public function getSummaryBJ()
    {

        if($this->input->get('area')){
            $area = $this->input->get('area');
            $this->units->db->where('units.id_area', $area);
        }else if($this->session->userdata('user')->level == 'area'){
            $this->units->db->where('units.id_area', $this->session->userdata('user')->id_area);
        }

        if($this->input->get('unit')){
            $unitId = $this->input->get('unit');
            $this->units->db->where('units.id', $unitId);
        }else if($this->session->userdata('user')->level == 'unit'){
            $this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
        }

		$units = $this->units->db->select('units.id, units.name as unit_name, units.id_area,areas.area')
								 ->join('areas','areas.id = units.id_area')
								 ->get('units')->result();

		foreach ($units as $unit){
			$unit->total = $this->regularSummary->getTotalGramation($unit->id);
		}
		$this->sendMessage($units, 'Get Data Outstanding');
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
            if($this->regularSummary->get_count($this->input->post('id_unit'),$this->input->post('no_sbk'),$this->input->post('permit')) >0){
                echo json_encode(array(
                    'data'	    => true,
                    'status'    => false,
                    'message'	=> 'Data Sudah terverifikasi'
                ));
            }else{
                $CountData = count($this->input->post('jenis'));
                for($i=0; $i < $CountData; $i++){
                    if(!empty($this->input->post('jenis')[$i])){
                        $data['no_sbk']         = $this->input->post('no_sbk');	
                        $data['id_unit']        = $this->input->post('id_unit');	
                        $data['nic']            = $this->input->post('nic');	
                        $data['permit']         = $this->input->post('permit');	
                        $data['id_customer']    = $this->input->post('id_customer');
                        $data['status_sbk']     = $this->input->post('status');
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

                $header['id_unit']  = $this->input->post('id_unit');
                $header['no_sbk']   = $this->input->post('no_sbk');
                $header['permit']   = $this->input->post('permit');                
                $db     = $this->regularHeader->insert($header);
                
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

    public function updatedata(){
        $units =  $this->regularVerified->all();    
                
                // foreach ($units as $unit) {
                //     $unit->items = $this->regularSummary->getSummaryGramation($unit->id_unit,$unit->no_sbk,$unit->permit);
                // }
        return $this->sendMessage($units,'Successfully get barang jaminan');
    }

}
