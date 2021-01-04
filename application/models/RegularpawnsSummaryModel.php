<?php
require_once 'Master.php';
class RegularpawnsSummaryModel extends Master
{
	public $table = 'units_regularpawns_summary';
	public $primary_key = 'id';

	public function getKaratase($idUnit, $karatase)
	{
		$karataseaMortages = (int) $this->db->select('count(*) as karatase')->from('units_mortages_summary')
							->where('id_unit', $idUnit)
							->where('karatase', $karatase)
							->get()->row()->karatase;

		$karataseRegular = (int) $this->db->select('count(*) as karatase')->from($this->table)
							->where('id_unit', $idUnit)
							->where('karatase', $karatase)
							->get()->row()->karatase;
		return $karataseaMortages + $karataseRegular;
	}


}


