<?php

class Master extends CI_Model
{
	public $table;

	public $primary_key = 'id';

	public function insert(array $data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function all($limit = null)
	{
		if(!is_null($limit)){
			$this->db->limit($limit);
		}
		return $this->db->get($this->table)->result();
	}


	public function update(array $data, $condition = array())
	{
		if(is_array($condition)){
			$this->db->where($condition);
		}else{
			$this->db->where($this->primary_key, $condition);
		}
		return $this->db->update($this->table, $data);
	}

	public function find($condition = array())
	{
		if(is_array($condition)){
			$this->db->where($condition);
		}else{
			$this->db->where($this->primary_key, $condition);
		}
		return $this->db->get($this->table)->row();
	}

	public function findWhere($condition = array())
	{
		if(is_array($condition)){
			$this->db->where($condition);
		}
		return $this->db->get($this->table)->result();
	}

	public function delete($condition = array())
	{
		return $this->db->delete($this->table, $condition);
	}


}
