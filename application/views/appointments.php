<html>
<head>
	<title>Appointments</title>
	<link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  	<script>
	  $(function() {
	    $( "#datepicker" ).datepicker({altField: '#datepicker_send'});
	  });
	</script>
</head>		
<body>
<div id="header">
	<h1>Hello, <?= $this->session->userdata('name') ?>! </h1><a href="process/logout">Log Out</a>
	</div>
<div>
	<h3>Here are your appointments for today, <?= date("m/d/Y") ?>:</h3>
	<table>
		<thead>
			<th>Tasks</th>
			<th>Time</th>
			<th>Status</th>
			<th>Action</th>
		</thead>
			<?php 
			foreach(array_reverse($todays_appts) as $todays_appt) {?>
				<tr>
					<td><?= $todays_appt['tasks'] ?></td>
					<td><?= $todays_appt['time'] ?></td>
					<td><?= $todays_appt['status'] ?></td>
					<td><a href="/edit/<?= $todays_appt['id'] ?>"> Edit </a> <a href="/delete/<?= $todays_appt['id'] ?>"> Delete </a></td>
				</tr>
			<?}?> 
	</table>
</div>
<div>
	<h3>Your Other appointments:</h3>
	<table>
		<thead>
			<th>Tasks</th>
			<th>Date</th>
			<th>Time</th>
		</thead>
		<?php 
		foreach(array_reverse($other_appts) as $other_appt) {?>
			<tr>
				<td><?= $other_appt['tasks'] ?></td>
				<td><?= $other_appt['date'] ?></td>
				<td><?= $other_appt['time'] ?></td>
			</tr>
		<?}?>
	</table>
</div>
<div>
	<h3>Add Appointment</h3>
	<form method="post" action="add_appointment">
		<p>Date: <div id='datepicker' name='date'></div></p>
		<input type="hidden" id="datepicker_send" name="datepicker_send">
		<p>Time: <input type="time" name="time"></p>
		<p>Tasks: <input type="text" name="tasks"></p>
		<input type="submit" value="Add">
		<input type="hidden" name="action" value="add">
	</form>
</div>

</body>
</html>