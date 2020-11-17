<?php
require_once 'Master.php';
class LmStocksModel extends Master
{
	/**
	 * @var string
	 */

	public $table = 'lm_stocks';

	/**
	 * @var string
	 */

	public $primary_key = 'id';

	public $hirarki = false;

	public function grams($dateStart,  $dateEnd)
	{
		$this->db->select('lg.*')
			->select('(select COALESCE(( 
				sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END) - 	sum(CASE WHEN type = "CREDIT" THEN `amount` ELSE 0 END)
			),0) from lm_stocks where date_receive < "'.$dateStart.'" and lm_stocks.id_lm_gram = lg.id and status="PUBLISH" ) as stock_begin')
			 ->select('(select COALESCE(  ( 
				sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END)
			 ), 0) from lm_stocks where date_receive >= "'.$dateStart.'" and date_receive <= "'.$dateEnd.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH") as stock_in')
			 ->select('(select COALESCE( ( 
				sum(CASE WHEN lm_stocks.type = "CREDIT" THEN `amount` ELSE 0 END)
			 ), 0) from lm_stocks where date_receive >= "'.$dateStart.'" and date_receive <= "'.$dateEnd.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH") as stock_out')
			 ->select('(
				(select COALESCE(( 
					sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END) - 	sum(CASE WHEN type = "CREDIT" THEN `amount` ELSE 0 END)
				),0) from lm_stocks where date_receive < "'.$dateStart.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH") + 
				(select COALESCE(  ( 
					sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END)
				 ), 0) from lm_stocks where date_receive >= "'.$dateStart.'" and date_receive <= "'.$dateEnd.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH") -
				 (select COALESCE( ( 
					sum(CASE WHEN lm_stocks.type = "CREDIT" THEN `amount` ELSE 0 END)
				 ), 0) from lm_stocks where date_receive >= "'.$dateStart.'" and date_receive <= "'.$dateEnd.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH")
			 ) as total')
			->from('lm_grams  as lg');

		return $this->db->get()->result();
	}

	public function gramsUnits($idUnit, $dateStart, $dateEnd)
	{
		$this->db->select('lg.*')
		->select('(select price_perpcs from lm_grams_prices where  lm_grams_prices.id_lm_gram = lg.id order by date desc limit 1) as price')
		->select('(select COALESCE(( 
			sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END) - 	sum(CASE WHEN type = "CREDIT" THEN `amount` ELSE 0 END)
		),0) from lm_stocks where date_receive < "'.$dateStart.'" and lm_stocks.id_lm_gram = lg.id and status="PUBLISH" and id_unit = "'.$idUnit.'") as stock_begin')
		 ->select('(select COALESCE(  ( 
			sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END)
		 ), 0) from lm_stocks where date_receive >= "'.$dateStart.'" and date_receive <= "'.$dateEnd.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH" and id_unit = "'.$idUnit.'") as stock_in')
		 ->select('(select COALESCE( ( 
			sum(CASE WHEN lm_stocks.type = "CREDIT" THEN `amount` ELSE 0 END)
		 ), 0) from lm_stocks where date_receive >= "'.$dateStart.'" and date_receive <= "'.$dateEnd.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH" and id_unit = "'.$idUnit.'") as stock_out')
		 ->select('(
			(select COALESCE(( 
				sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END) - 	sum(CASE WHEN type = "CREDIT" THEN `amount` ELSE 0 END)
			),0) from lm_stocks where date_receive < "'.$dateStart.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH" and id_unit = "'.$idUnit.'") + 
			(select COALESCE(  ( 
				sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END)
			 ), 0) from lm_stocks where date_receive >= "'.$dateStart.'" and date_receive <= "'.$dateEnd.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH" and id_unit = "'.$idUnit.'") -
			 (select COALESCE( ( 
				sum(CASE WHEN lm_stocks.type = "CREDIT" THEN `amount` ELSE 0 END)
			 ), 0) from lm_stocks where date_receive >= "'.$dateStart.'" and date_receive <= "'.$dateEnd.'"  and lm_stocks.id_lm_gram = lg.id and status="PUBLISH" and id_unit = "'.$idUnit.'")
		 ) as total')
		->from('lm_grams  as lg');

	return $this->db->get()->result();
	}

	public function byGrams($idGrams, $idUnit = 0, $date = null)
	{
		if($date == null){
			$date = date('Y-m-d');
		}
		$query = $this->db->query('select COALESCE(( 
			sum(CASE WHEN lm_stocks.type = "DEBIT" THEN `amount` ELSE 0 END) - 	sum(CASE WHEN type = "CREDIT" THEN `amount` ELSE 0 END)
		),0) as total from lm_stocks where date_receive <= "'.$date.'" and id_unit = "'.$idUnit.'" and status="PUBLISH" and id_lm_gram = "'.$idGrams.'" ');
		return $query->row()->total;
	}
}
