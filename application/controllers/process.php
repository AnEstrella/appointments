<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process extends CI_Controller {

	public function index()
	{	if ($this->session->userdata('logged_in') === TRUE)
		{
			$this->load->model('Appointment');
			$todays_appts = $this->Appointment->current_appts($this->session->userdata('id'));
			$other_appts = $this->Appointment->other_appts($this->session->userdata('id'));
			$this->load->view('appointments', array('todays_appts' => $todays_appts, 'other_appts' => $other_appts));
			//$this->Appointment->todays_appointments(date("m/d/Y"));
		}
		else {$this->load->view('main');}
	}

	public function register()
	{
//user login and registration functions		
		//required fields cannot be blank
        if( !$this->input->post('name') || 
        	!$this->input->post('email') ||
        	!$this->input->post('password') ||
        	!$this->input->post('confirm_pw')
        	){
        	$errors = array(
                   'blank_error' => 'All required fields must be filled out.'
               );
            $this->session->set_flashdata($errors);
        	redirect('/');
        }
        //email must be valid 
        if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL))
    	{
    	$errors = array(
               'email_error' => 'Email must be valid.'
           );
    	$this->session->set_flashdata($errors);
    	redirect('/');
    	}
        //password must be at least 8 characters
        if (strlen($this->input->post('password')) < 8){
        	$errors = array(
                   'password_error' => 'Password must be at least 8 characters.'
               );
            $this->session->set_flashdata($errors);
        	redirect('/');
        }
        //password must match confirmed password 
        if ($this->input->post('password') != $this->input->post('confirm_pw')){
        	$errors = array(
                   'confirmpw_error' => 'Confirmed passwords must match'
               );
            $this->session->set_flashdata($errors);
        	redirect('/');
        }
        else{ //save user into DB
            $this->load->model("User");
            $user_data = array(
                   'name' => $this->input->post('name'),
                   'email' => $this->input->post('email'),
                   'password' => $this->input->post('password'),
                   'dob' => $this->input->post('dob')
            ); 
            $add_user = $this->User->add_user($user_data);
            if($add_user === TRUE)
            {
            	$this->session->unset_userdata($user_data);
            	$this->load->view('register_success');
            };
        }
    }

	public function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$this->load->model('User');
		$user = $this->User->get_user_by_email($email);
		if($user['password'] === $password)
		{
			$current_user = array(
				'name' => $user['name'],
				'email' => $user['email'],
				'id' => $user['id'],
				'logged_in' => TRUE
				);
			$this->session->set_userdata($current_user);
			redirect('/');
		}
		else
		{
			$this->session->set_flashdata("login_error", "Invalid email or password.");
			redirect('/');
		}
	}
	public function logout()
	{
		$this->session->set_userdata('logged_in', FALSE);
		$this->session->unset_userdata();
		redirect('/');
	}
//appointment functions
	public function add_appointment()
	{
		$date = strtotime($_REQUEST['datepicker_send']);
		$ymd_format = date('Y-m-d',$date);
		//all fields are required
		if(
		   !$date || 
		   !$this->input->post('tasks') ||
		   !$this->input->post('time') 
		   )
		{
            echo 'All fields are required.' . '<br>';
        }
        //date cannot be before today
        elseif($ymd_format < date('Y-m-d'))
        {
        	echo 'Appointment must be today or a future date.';
        }
        else
        {
			$appointment = array(
				'date' => $ymd_format,
				'time' => $this->input->post('time'),
				'tasks' => $this->input->post('tasks'),
				'users_id' => $this->session->userdata('id')
				);
			$this->load->model("Appointment");
			$add_appointment = $this->Appointment->add_appointment($appointment);
			if($add_appointment == TRUE)
			{
				redirect('/');
			}
			else{
				echo 'Appointment could not be added.';
			}
		}
	}

	public function delete($appt_id)
	{
		$this->load->model("Appointment");
		$this->Appointment->delete($appt_id);
		redirect('/');
	}

	public function edit($appt_id)
	{
		$this->load->model('Appointment');
		$edit_appt = $this->Appointment->get_appt($appt_id);
		$this->load->view("edit", array('edit_appt' => $edit_appt));
	}

	public function update()
	{
		$appt_info = array(
			'status' => $this->input->post('status'),
			'time' => $this->input->post('time'),
			'tasks' => $this->input->post('tasks'),
			'id' => $this->input->post('id')
			);
		$this->load->model('Appointment');
		$update = $this->Appointment->update($appt_info);
		redirect('/');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */