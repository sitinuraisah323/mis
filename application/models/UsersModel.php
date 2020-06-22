<?php
require_once 'Master.php';
class UsersModel extends Master
{
	public $table = 'users';

	public $primary_key = 'id';

	public function login_verify($username, $password)
	{
		if($user = $this->find(array('username'=>$username))){
			if(password_verify($password,$user->password)){
				$this->session->set_userdata(array(
					'logged_in'	=> true,
					'user'	=> $user
				));
				return true;
			}
		}
		return false;
	}
}
