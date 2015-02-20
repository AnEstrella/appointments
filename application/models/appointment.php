<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends CI_Model {

	function add_appointment($appointment)
	{	//add appointment with default status "pending"
		 $query = "INSERT INTO appointments (date, time, tasks, status, users_id) VALUES (?,?,?,?,?)";
         $values = array($appointment['date'], $appointment['time'], $appointment['tasks'], "Pending", $appointment['users_id']); 
         return $this->db->query($query, $values);
	}
	function current_appts($user_id)
	{	
		$date = date('Y-m-d');
		return $this->db->query("SELECT * FROM appointments_db.appointments WHERE users_id = {$user_id} && date = '{$date}'")->result_array();
	}
	function other_appts($user_id)
	{
		$todays_date = date('Y-m-d');
		return $this->db->query("SELECT * FROM appointments WHERE date > '{$todays_date}' AND users_id = {$user_id}")->result_array();
	}
	function delete($appt_id)
	{
	 	return $this->db->query("DELETE FROM appointments_db.appointments WHERE id={$appt_id}");
	}
	function get_appt($appt_id)
	{
		return $this->db->query("SELECT * FROM appointments_db.appointments WHERE id = {$appt_id}")->row_array();
	}

	function update($appt_info)
	{
		return $this->db->query("UPDATE appointments_db.appointments SET tasks='{$appt_info['tasks']}', time='{$appt_info['time']}', status='{$appt_info['status']}' WHERE id={$appt_info['id']}");
	}
}