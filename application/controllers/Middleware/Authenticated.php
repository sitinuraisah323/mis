<?php

require_once APPPATH.'controllers/Controller.php';
class Authenticated extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$session = $this->session->userdata();
		if($session['logged_in'] == false){
			redirect('login');
		}
	}

}
