<?php
require_once 'Master.php';

class ViaModel extends Master
 {
    public $table = 'payments_via';
    public $primary_key = 'id';

    public function get_jenis()
	{
		$this->db->select('a.id,b.jenis,a.via');
		$this->db->join('payments as b','b.id=a.id_payments');		
		$this->db->order_by('a.id','asc');		
		return $this->db->get('payments_via as a')->result();
	}
}
