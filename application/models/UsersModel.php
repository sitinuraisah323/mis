<?php
require_once 'Master.php';
class UsersModel extends Master
{
	public $table = 'users';

	public $primary_key = 'id';

	public function find($condition = array())
	{
		if(is_array($condition)){
			foreach ($condition as $item => $value){
				$this->db->or_where($item, $value);
			}
		}else{
			$this->db->where($this->primary_key, $condition);
		}
		return $this->db->select($this->table.'.*')->from($this->table)->get()->row();
	}

	public function login_verify($username, $password)
	{
		$this->db
			->select('levels.level,units.id_area')
			->join('levels','levels.id = users.id_level')
			->join('units','units.id = users.id_unit');
		if($user = $this->find(array('username'=>$username,'email'=>$username))){
			if(password_verify($password,$user->password)){
				$privileges = array();
				$levels_privileges = $this->db
					->select('can_access, name, dept')
					->join('menus','menus.id = levels_privileges.id_menu')
					->where('id_level', $user->id_level)
					->get('levels_privileges')->result();
				if($levels_privileges){
					foreach ($levels_privileges as $privilege){
						$privileges[$privilege->dept][strtolower($privilege->name)] = $privilege->can_access;
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
