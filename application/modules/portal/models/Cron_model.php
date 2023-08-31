<?php 
class Cron_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function dlt_timeout_reservations()
	{
		$current_date = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('reservations');
		$this->db->where('reserve_date', $current_date);
		$reservations = $this->db->get()->result_array();

		foreach ($reservations as $record) {
			$now = date('Y-m-d H:i:s', strtotime($record['created_at']));
			$new_time = date("Y-m-d H:i:s", strtotime('+1 hours', strtotime($now)));
			$date1 = new DateTime($new_time);
			$date2 = new DateTime(date('Y-m-d H:i:s'));

			if ($date2 >= $date1) {
				$this->db->where('id', $record['id']);
				$query = $this->db->delete('reservations');
			}
		}

		return true;
	}
}

?>