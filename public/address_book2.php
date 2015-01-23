<?php

$showAlert = false;

class AddressDataStore {

	public $filename = '';
	public $contacts = [];

	public function __construct($input = 'address_book.csv') {
		$this->filename = $input;
		$this->contacts = $this->openCSV();
	}

	public function __destruct() {
		echo "Class Dismissed!";
	}

	public function openCSV() {
		$handle = fopen($this->filename, 'r');
		$array = [];
		while(!feof($handle)) {
			$row = fgetcsv($handle);

			if(!empty($row)) {
				$array[] = $row;
			}
		}
		fclose($handle);
		return $array;
	}

	public function saveCSV ($array) {
		$handle = fopen($this->filename, 'w');
		foreach ($array as $row) {
			fputcsv($handle, $row);
			}
		fclose($handle);
	}
}

function sanitize($array) {
    foreach ($array as $key => $value) {
        $array[$key] = htmlspecialchars(strip_tags($value));  // Overwrite each value.
    }
    return $array;
}

$addressBookData = new AddressDataStore();
$addressBook = $addressBookData->openCSV();

if (!empty($_POST)) {
	var_dump($_POST);

	if (!empty($_POST['name']) && !empty($_POST['address']) && 
		!empty($_POST['city']) && !empty($_POST['state']) && 
		!empty($_POST['zip']) && !empty($_POST['phone'])) {
		$sanitizedPOST = sanitize($_POST);
		array_push($addressBook, $sanitizedPOST);
		$addressBookData->saveCSV($addressBook);

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
		$addressBookData->saveCSV($addressBook);
	}


	if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {

		// set the destination directory for file uploads
	    $uploadDir = '/vagrant/sites/planner.dev/public/';

	    // Grab the filename from the uploaded file by using basename - basename 
	    $filename = basename($_FILES['file1']['name']);

    	// Create the saved filename using the file's original name and our upload directory
    	$savedFilename = $uploadDir . $filename;

	    // Move the file from the temp location to our uploads directory
	    // move_uploaded_file(move from ['here'], to here);
	    if(substr($savedFilename, -3) == 'csv') {
	    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

		$addressBookDataNew = new AddressDataStore($savedFilename);
		$itemsFromUpload = $addressBookDataNew->openCSV();
		} else {
			echo 'There was an error processing this file.';
		}
		
		// MERGE WITH EXISTING $ITEMS ARRAY
		// THEN SAVE IT
		$addressBook = array_merge_recursive($addressBook, $itemsFromUpload);

		$addressBookData->saveCSV($addressBook);
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
							<td><a href="address_book2.php?delete=<?=$key?>" class="btn btn-danger"><i class="icon-white icon-remove-circle"></i> Delete</a></td>
						</tr>
					<? endforeach; ?>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<br>
				<h1>Add Contacts From File</h1>
				<br>
				<form method="POST" enctype="multipart/form-data" action="address_book2.php">
		        	<div class="form-group">
			            <label for="file1">Upload New Contact File: </label>
			            <input type="file" id="file1" name="file1">
		        	</div>
		        
		        	<div class="form-group">
		            	<input type="submit" value="upload">
		        	</div>
	   			</form>	
	   		</div>
	   	</div>

		<div class="row">
			<div class="col-md-12">
				<br>
				<h1>Add New Contact</h1>
				<br>
				<form role="form" method="POST" action="address_book2.php">

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
			
		<? unset($addressBookData); ?>

</body>
</html>