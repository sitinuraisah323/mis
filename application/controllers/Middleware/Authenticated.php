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
			if($segments =$this->uri->segment_array()){
				foreach ($segments as $index => $segment){
					if(key_exists($index-1,$privileges)){
						if(key_exists($segment, $privileges[$index-1])){
							if($privileges[$index-1][$segment] == 'DENIED'){
								redirect(base_url('denied'));
							}
						}
					}
				}
			}
		}
	}

}
