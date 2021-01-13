<?php
require_once APPPATH.'controllers/api/ApiController.php';
class Series extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('SeriesModel', 'model');
	}

	public function index()
	{
		$this->sendMessage($this->model->all(),'Successfully get Grams',200);
	}


}
