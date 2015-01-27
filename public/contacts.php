<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'address_book');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require('db_connect.php');








?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Address Book</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Contacts</h1>
				<table class="table">
					<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone</th>
					</tr>
				</thead>
<!-- 					<? foreach ($addressBook as $key => $row): ?>
						<tr>
						<? foreach ($row as $value): ?>
							<td><?= $value;?></td>
						<? endforeach; ?>
							<td><a href="address_book3.php?delete=<?=$key?>" class="btn btn-danger"><i class="icon-white icon-remove-circle"></i> Delete</a></td>
						</tr>
					<? endforeach; ?>	 -->	
				</table>
			</div>
		</div>

		

		<div class="row">
			<div class="col-md-12">
				<br>
				<h1>Add New Contact</h1>
				<br>
				<form role="form" method="POST" action="address_book_db.php">

					<div class="form-group">
					<label for="fname">First Name:   </label>
					<input id="fname" name="fname" class="form-control" type="text" placeholder="Enter first name" />
					</div>

					<div class="form-group">
					<label for="lname">Last Name:</label>
					<input id="lname" name="lname" class="form-control" type="text" placeholder="Enter last name" />
					</div>

					<div class="form-group">
					<label for="phone">Phone Number:</label>
					<input id="phone" name="phone" class="form-control" type="text" placeholder="Enter 10 digit phone number"/>
					</div>

					<div class="form-group">
					<button class="button" type="submit">submit</button>
				    </div>
			</form>		
			</div>
		</div>
	</div>