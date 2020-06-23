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
		return $this->db
			->select($this->table.'.*')
			->from($this->table)
			->get()->result();
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
		return $this->db->select($this->table.'.*')->from($this->table)->get()->row();
	}

	public function insertOrUpdate($data, $condition = array())
	{
		if($this->find($condition)){
			return $this->update($data,$condition);
		}else{
			return $this->insert($data);
		}
	}

	public function updateOrInsert($data, $condition = array())
	{
		return $this->insertOrUpdate($data, $condition);
	}

	public function findWhere($condition = array())
	{
		if(is_array($condition)){
			$this->db->where($condition);
		}
		return $this->db->select($this->table.'.*')->from($this->table)->get()->result();
	}

	public function delete($condition = array())
	{
		return $this->db->delete($this->table, $condition);

	}


}
