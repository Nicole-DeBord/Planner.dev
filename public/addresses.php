<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'address_book');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require('db_connect.php');

require('address_model.php');

var_dump($_POST);

$address = new Address($dbc);

if (!empty($_POST['street']) && 
	!empty($_POST['city']) && 
	!empty($_POST['state']) && 
	!empty($_POST['zip'])) {

	$address->streetAdd = htmlspecialchars(strip_tags($_POST['street']));
	$address->aptAdd = htmlspecialchars(strip_tags($_POST['apt']));
	$address->cityAdd = htmlspecialchars(strip_tags($_POST['city']));
	$address->stateAdd = htmlspecialchars(strip_tags($_POST['state']));
	$address->zipAdd = htmlspecialchars(strip_tags($_POST['zip']));
	$address->fourAdd = htmlspecialchars(strip_tags($_POST['four']));

	$address->insert();

}



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
				<h1>Addresses</h1>
				<table class="table">
					<thead>
					<tr>
						<th>Street</th>
						<th>Apt #</th>
						<th>City</th>
						<th>State</th>
						<th>Zip</th>
						<th>+ 4</th>
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
				<h1>Add New Address</h1>
				<br>
				<form role="form" method="POST" action="addresses.php">

				<div class="form-group">
					<label for="street">Street:</label>
					<input id="street" name="street" class="form-control" type="text" placeholder="your address here" />
					</div>

					<div class="form-group">
					<label for="apt">Apt Number:</label>
					<input id="apt" name="apt" class="form-control" type="text" placeholder="your city here" />
					</div>

					<div class="form-group">
					<label for="city">City:</label>
					<input id="city" name="city" class="form-control" type="text" placeholder="your state here" />
					</div>

					<div class="form-group">
					<label for="state">State:</label>
					<input id="state" name="state" class="form-control" type="text" placeholder="your zip code here" />
					</div>

					<div class="form-group">
					<label for="zip">Zip:</label>
					<input id="zip" name="zip" class="form-control" type="text" placeholder="your zip code here" />
					</div>

					<div class="form-group">
					<label for="four">Plus Four:</label>
					<input id="four" name="four" class="form-control" type="text" placeholder="last four digits here" />
					</div>

					<div class="form-group">
					<button class="button" type="submit">submit</button>
				    </div>
			</form>		
			</div>
		</div>
	</div>