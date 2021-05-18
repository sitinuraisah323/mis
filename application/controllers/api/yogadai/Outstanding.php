<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Outstanding extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('yogadai');
	}

	public function index()
	{
        return json_encode($this->yogadai->transaction());
        
    }



}
