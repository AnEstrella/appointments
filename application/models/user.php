<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

	function add_user($user_data)
	{
		$query = "INSERT INTO users (name, email, password, dob) VALUES (?,?,?,?)";
		$values = array($user_data['name'], $user_data['email'], $user_data['password'], $user_data['dob']);
		return $this->db->query($query, $values);
	}

	function get_user_by_email($email)
	{
		return $this->db->query("SELECT * FROM users WHERE email = ?", array($email))->row_array();
	}
	//function user
}