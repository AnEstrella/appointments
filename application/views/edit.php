<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit</title>
</head>
<body>
<h1>Edit Appointment</h1>
<form action="/update" method="post">
Tasks: <input type="text" name="tasks" value="<?= $edit_appt['tasks'] ?>">
Time: <input type="time" name="time" value="<?= $edit_appt['time'] ?>">
Status: 
<select name="status">
	<option>Pending</option>
	<option>Done</option>
	<option>Missed</option>
</select>
<input type="hidden" name="id" value="<?= $edit_appt['id']?>">
<input type="submit" value="Submit">
</form>
</body>
</html>