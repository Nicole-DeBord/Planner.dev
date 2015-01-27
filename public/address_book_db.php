<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'address_book');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require('db_connect.php');

require('contacts_class.php');

var_dump($_POST);

$person = new People($dbc);

if (!empty($_POST['fname']) && 
	!empty($_POST['lname']) && 
	!empty($_POST['phone'])) {

	$person->fnameAdd = htmlspecialchars(strip_tags($_POST['fname']));
	$person->lnameAdd = htmlspecialchars(strip_tags($_POST['lname']));
	$person->phoneAdd = htmlspecialchars(strip_tags($_POST['phone']));


	$person->insert();

}

// $showAddresses = $dbc->query('SELECT * FROM address')->fetchAll(PDO::FETCH_ASSOC);

$offset = 0;

$stmt = $dbc->prepare('SELECT first_name, last_name, phone FROM people LIMIT 10 OFFSET :offset');
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$stmts = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
						<th>First Name:</th>
						<th>Last Name:</th>
						<th>Phone:</th>
					</tr>
				</thead>




					<!-- Loop through each of the contacts and output -->
    			<?php foreach($stmts as $key => $row): ?>
       			 <tr>
            <!-- Loop through each value, in each address -->
           		<?php foreach ($row as $value): ?>
               	<td>
                	<?= $value ?>
               	</td>
            	<?php endforeach ?>
            	<td>
                <a href="/address_book_db.php?remove=<?= $key ?>" class="btn btn-default btn-danger btn-center">X</a>
           		</td>
        		</tr>
        		<?php endforeach ?>


<!-- 				<? foreach ($showAddresses as $showAddress): ?>

           			<tr><?= $showAddress['street'] ?></tr>

				<? endforeach; ?> -->



<!-- 				<? foreach ($showAddresses as $key => $row): ?>
						<tr>
						<? foreach ($row as $value): ?>
							<td><?= $value;?></td>
						<? endforeach; ?>
							<td><a href="address_book3.php?delete=<?=$key?>" class="btn btn-danger"><i class="icon-white icon-remove-circle"></i> Delete</a></td>
						</tr>
					<? endforeach; ?> -->


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
					<label for="fname">First Name:</label>
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

					</div>
			</form>		
			</div>
		</div>
	</div>
</body>
</html>