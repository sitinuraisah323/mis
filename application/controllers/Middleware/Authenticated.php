<?php

require_once APPPATH.'controllers/Controller.php';
class Authenticated extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$session = $this->session->userdata();
		if($session['logged_in'] == false){
			redirect(base_url('login'));
		}
		if($privileges = $session['privileges']){
			if(array_key_exists($this->uri->segment(2),$privileges)){
				$privilege = $privileges[$this->uri->segment(2)];
				if($privilege === 'DENIED'){
					redirect(base_url('denied'));
				}
			}
		}
	}

}
