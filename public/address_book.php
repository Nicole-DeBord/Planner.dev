<?php

// $addressBook = [];
	// ['Princess Sparkle Kitty', 'P.O. Box 1', 'Heaven', 'NC', '111111'],
	// ['Magical Rainbow Unicorn', '9943 Wishes Grove', 'The Land of Eternal Hopes and Dreams', 'OK', '22222'],
	// ['Yoga Pants, Ponytail, and Turquoise Earring Man', '0000 Enlightened Awareness', 'The Metaphysical Plane', 'WA', '345345345']

$showAlert = false;

function openCSV($filename) {
	$handle = fopen($filename, 'r');
	$contentsArray = [];
	while(!feof($handle)) {
		$row = fgetcsv($handle);

		if(!empty($row)) {
			$contentsArray[] = $row;
		}
	}
	fclose($handle);
	return $contentsArray;
}


function saveToFile ($filename, $array) {
	$handle = fopen($filename, 'w');
	foreach ($array as $row) {
		fputcsv($handle, $row);
		}
	fclose($handle);
}


function sanitize($array) {
    foreach ($array as $key => $value) {
        $array[$key] = htmlspecialchars(strip_tags($value));  // Overwrite each value.
    }
    return $array;
}


$addressBook = openCSV('address_book.csv');


if (!empty($_POST)) {
	var_dump($_POST);

	if (!empty($_POST['name']) && !empty($_POST['address']) && 
		!empty($_POST['city']) && !empty($_POST['state']) && 
		!empty($_POST['zip']) && !empty($_POST['phone'])) {
		$sanitizedPOST = sanitize($_POST);
		array_push($addressBook, $sanitizedPOST);
		saveToFile('address_book.csv', $addressBook);

	} else {
		$showAlert = true;
	}
}
var_dump($showAlert);

var_dump($addressBook);


	if (isset($_GET['delete'])) {
		// capture the key of the item
		$removeRow = $_GET['delete'];
		// then remove the item
		unset($addressBook[$removeRow]);

		$addressBook = array_values($addressBook);
		// then save changes to txt file
		echo saveToFile('address_book.csv', $addressBook);
	}

// This is an alternative way to achieve what I did above - it eliminates
// the use of a cumbersome if statement for validation. This method requires
// some logic placed near the form to echo $message to the user if the
// conditional is not met. 

// if (!empty($_POST)) {

// 	foreach ($_POST as $key => $value) {
// 		$_POST[$key] = strip_tags($value);

// 		$error = false

// 		if (empty($value)) {
// 			$error = true;
// 		}
// 	}
// 		if ($error) {
// 		$message = "Please fill out all fields.";
// 		} else {
// 			array_push($addressBook, $_POST);
// 			saveToFile('address_book.csv', $addressBook);
// 	}
// }


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
				<h1>Address Book</h1>
				<table class="table">
					<thead>
					<tr>
						<th>Name</th>
						<th>Address</th>
						<th>City</th>
						<th>State</th>
						<th>Zip</th>
						<th>Phone</th>
					</tr>
				</thead>

					<? foreach ($addressBook as $key => $row): ?>
						<tr>
						<? foreach ($row as $value): ?>
							<td><?= $value;?></td>
						<? endforeach; ?>
							<td><a href="address_book.php?delete=<?=$key?>" class="btn btn-danger"><i class="icon-white icon-remove-circle"></i> Delete</a></td>
						</tr>
					<? endforeach; ?>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<br>
				<h1>Add New Contact</h1>
				<br>
				<form role="form" method="POST" action="address_book.php">

					<div class="form-group">
					<label for="name">Name:   </label>
					<input id="name" name="name" class="form-control" type="text" placeholder="your name here" />
					</div>

					<div class="form-group">
					<label for="address">Address:</label>
					<input id="address" name="address" class="form-control" type="text" placeholder="your address here" />
					</div>

					<div class="form-group">
					<label for="city">City:</label>
					<input id="city" name="city" class="form-control" type="text" placeholder="your city here" />
					</div>

					<div class="form-group">
					<label for="state">State:</label>
					<input id="state" name="state" class="form-control" type="text" placeholder="your state here" />
					</div>

					<div class="form-group">
					<label for="zip">Zip Code:</label>
					<input id="zip" name="zip" class="form-control" type="text" placeholder="your zip code here" />
					</div>

					<div class="form-group">
					<label for="phone">Phone Number:</label>
					<input id="phone" name="phone" class="form-control" type="text" placeholder="your phone number here" />
					</div>

					<div class="form-group">
					<button class="button" type="submit">submit</button>
				    </div>
			</form>
		
			</div>
		</div>
	</div>
		<script>
		<?php 
			if($showAlert) {
				echo "alert('Unable to add new contact. Please make sure all fields are complete before submitting!')";
			}
		?>
	</script>
</body>
</html>