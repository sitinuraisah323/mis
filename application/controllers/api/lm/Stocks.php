<?php
require_once APPPATH.'controllers/api/ApiController.php';
class Stocks extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LmStocksModel', 'model');
		$this->load->model('UnitsModel', 'units');
	}

	public function index()
	{
		$this->model->db->join('lm_grams','lm_grams.id = lm_stocks.id_lm_gram')
						->join('units','units.id = lm_stocks.id_unit')
						->select('lm_grams.image, lm_grams.weight, units.name as unit');
		if($this->session->userdata('user')->level == 'unit'){
			$this->model->db->where('id_unit', $this->session->userdata('user')->id_unit);
		}
		$data =  $this->model->all();
		$this->sendMessage($data,'Successfully get Grams',200);
	}

	public function insert()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('id_unit', 'id lm gram', 'required|integer');
			$this->form_validation->set_rules('id_lm_gram', 'id lm gram', 'required|integer');
			$this->form_validation->set_rules('amount', 'Amount', 'required|integer');
			$this->form_validation->set_rules('type', 'Type', 'required');
			$this->form_validation->set_rules('date_receive', 'Date receive', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');


			if ($this->form_validation->run() == FALSE)
			{
				return $this->sendMessage(false, validation_errors());
			}
			else
			{
				if($this->model->insert($post)){
					return $this->sendMessage(true,'Successfull Insert Data Menu');
				}else{
					return $this->sendMessage(false,'Failed Insert Data Menu');
				}

			}
		}else{
			return $this->sendMessage(false,'Request Error Should Method POst');
		}

	}

	public function update()
	{
		if($post = $this->input->post()){

			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_unit', 'id lm gram', 'required|integer');
			$this->form_validation->set_rules('id', 'id', 'required|integer');
			$this->form_validation->set_rules('id_lm_gram', 'id lm gram', 'required|integer');
			$this->form_validation->set_rules('amount', 'Amount', 'required|integer');
			$this->form_validation->set_rules('type', 'Type', 'required');
			$this->form_validation->set_rules('date_receive', 'Date receive', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');



			if ($this->form_validation->run() == FALSE)
			{
				return $this->sendMessage(false, validation_errors());
			}
			else
			{
				$id = $post['id'];
				$data = $post;
				if($this->model->update($data, $id)){
					return $this->sendMessage(true,'Successfully update',500 );
				}else{
					return $this->sendMessage(false,'Failed Updated',500 );
				}

			}
		}else{
			return $this->sendMessage(false,'Request Should Post',500 );
		}

	}

	public function show($id)
	{
		if($data = $this->model->find($id)){
			return $this->sendMessage($data, 'successfully show gram' ,200);
		}else{
			return  $this->sendMessage(false, 'message'. $id.' Not Found', 500);
		}
	}
	public function delete()
	{
		$id = $this->input->get('id');
		if($this->model->delete($id)){
			return $this->sendMessage(true, 'Successfully delete gram',200);
		}else{
			return $this->sendMessage(false,'Data Not Found',500 );
		}
	}

	public function grams()
	{
		$result = [];
		
		$dateStart = $this->input->get('date_start');
		$dateEnd = $this->input->get('date_end');
		$idUnit = $this->input->get('id_unit');
		$idArea = $this->input->get('id_area');
		if($idArea !== null){
			if($idUnit){
				$this->units->db->where('id', $idUnit);
			}
			if($idArea){
				$this->units->db->where('id_area', $idArea);
			}
			$units = $this->units->all();
			foreach($units as $unit){
				$grams =  $this->model->gramsUnits($unit->id, $dateStart, $dateEnd);
				if($grams){
					foreach($grams as $gram){
						$gram->unit = $unit->name;
						$result[] = $gram;
					}
				}
			}
		}else{
			$result = $this->model->gramsUnits($idUnit, $dateStart, $dateEnd);
		}



		return $this->sendMessage($result,'Successfully get stocks',200);
	}


}
