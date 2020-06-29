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
				$privileges = array();
				$levels_privileges = $this->db
					->select('can_access, name')
					->join('menus','menus.id = levels_privileges.id_menu')
					->where('id_level', $user->id_level)
					->get('levels_privileges')->result();
				if($levels_privileges){
					foreach ($levels_privileges as $privilege){
						$privileges[strtolower($privilege->name)] = $privilege->can_access;
					}
				}
				$this->session->set_userdata(array(
					'logged_in'	=> true,
					'user'	=> $user,
					'privileges'	=> $privileges
				));
				return true;
			}
		}
		return false;
	}
}
