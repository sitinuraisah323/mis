<?php

require_once APPPATH.'controllers/api/ApiController.php';
class Outstanding extends ApiController
{

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('AreasModel', 'areas');
	}

	public function index()
	{
        $data = $this->get_data();
        echo json_encode($data);
        
    }

    private function get_data()
	{
        $this->load->helper("curl_helper");
		$url 		= $this->config->item('url_outstanding');
		$username 	= $this->config->item('api_username');
		$password 	= $this->config->item('api_password');

        $response = basic_auth_post($url,$username,$password,array());
        return json_decode($response);
    }



}
