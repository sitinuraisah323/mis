<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Outstanding extends ApiController
{

	public function __construct()
	{
		parent::__construct();
        $this->load->model('UnitsdailycashModel', 'unitsdailycash');
        $this->load->model('RegularPawnsModel', 'regular');
		$this->load->model('UnitsModel', 'units');
	}

	public function index()
	{
		if($area = $this->input->get('area')){
			if($area!='all'){
				$this->units->db->where('id_area', $area);
			}
		}else if($this->session->userdata('user')->level == 'area'){
			$this->units->db->where('id_area', $this->session->userdata('user')->id_area);
		}
		if($code = $this->input->get('code')){
			$this->units->db->where('code', $code);
		}else if($this->session->userdata('user')->level == 'unit'){
			$this->units->db->where('units.id', $this->session->userdata('user')->id_unit);
		}
		if($this->input->get('date')){
			$date = $this->input->get('date');
		}else{
			$date = date('Y-m-d');
		}
		$units = $this->units->db->select('units.id, units.name, area')
			->join('areas','areas.id = units.id_area')
			->get('units')->result();
		foreach ($units as $unit){
			 $unit->noa = $this->regular->getOstYesterday_($unit->id, $date)->noa;			
			 $unit->up = $this->regular->getOstYesterday_($unit->id, $date)->up;			
		}
        $this->sendMessage($units, 'Get Data Outstanding');
        
	}
	
}
