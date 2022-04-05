<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Outstanding extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('myyogadai');
	}

	public function index()
	{
		return $this->sendMessage($this->myyogadai->transaction()->data,'Successfull');            
    }



}
