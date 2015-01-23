<?php 

	$items = [];
	// 'Get KAF yellow cake mix', 
	// 'Get KAF chocolate cake mix - if it exists', 
	// 'Get two boxes KAF yellow cake mix if chocolate is a figment of my imagination',
	// 'Check pantry, make sure we have cocoa',
	// 'Check pantry, make sure we have cupcake liners', 
	// 'Get two lbs butter',
	// 'Get 1 large bag icing sugar',
	// 'Get blue food coloring, preferably with glitter, OR',
	// 'Find some way to make cupcakes literary themed - I know, challenging'


	function overwriteFile($userDefinedFile, $array) {
    $handle = fopen($userDefinedFile, 'w');
    	foreach($array as $item) {
    		fwrite($handle, $item . PHP_EOL);
    	}
    fclose($handle);
    return "your task was saved successfully!";
}

	// $userDefinedFile = 'todo_list/todo.txt';
	// $handle = fopen($userDefinedFile, 'r');
	//    $contents = (fread($handle, filesize($userDefinedFile)));
	//    $items = explode(PHP_EOL, $contents);
	//    fclose($handle);


    function addFromFile($userDefinedFile) {
    	$contentsArray = []; 
    	if(filesize($userDefinedFile) > 0) {   
	        $handle = fopen($userDefinedFile, 'r');
	        $contents = trim(fread($handle, filesize($userDefinedFile)));
	        $contentsArray = explode("\n", $contents);
	        fclose($handle);
    	}
        return $contentsArray;
    }

	$items = addFromFile('todo_list/todo.txt');


	// if posted, add to array
	if (isset($_GET['addtodo'])) {
		$items[] = $_GET['addtodo'];

		// then save changes to txt file
		echo overwriteFile('todo_list/todo.txt', $items);
	}

	// if get 'remove', and we do get it because we hard-coded this query string
	if (isset($_GET['remove'])) {
		// capture the key of the item
		$removeItem = $_GET['remove'];
		// then remove the item
		unset($items[$removeItem]);

		$items = array_values($items);
		// then save changes to txt file
		echo overwriteFile('todo_list/todo.txt', $items);
	}

?>

<html>
<head>
	<title>To-do list, rainbow power</title>
	<link rel="stylesheet" href="/css/todo3_style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

</head>
<body>
	<div class="container">

	<div class="row">

		<div class="col-md-12">
			<div class="red"></div>
	
			<div class="orange"></div>
				
			<div class="yellow"></div>
			
			<div class="green"></div>
			
			<div class="blue"></div>
		
			<div class="violet"></div>
		</div>	
	</div>
	<div class="row">
		<div class="col-md-6">
			<h1>to-do list</h1>
			<ul class="list">
				<?php
				foreach($items as $key => $value) {
	           		echo "<li><a href=\"/todo_bootstrap_vertical.php?remove={$key}\">X</a> | {$value}</li>";
	        		}
				?>
			</ul>

		<form method="POST" action="http://requestb.in/xv3dbzxv">
			<label for="addtodo">new to-do:</label>
			<input id="addtodo" name="addtodo" type="text" placeholder="your task here" />
			<button class="button" name="submitlist" type="submit">do the thing!</button>
		</form>
	<hr>
		</div>
		<div class="col-md-6">
			<?php

			print_r($_FILES);

			// Verify there were uploaded files and no errors using the UPLOAD_ERR_OK constant
			if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {

			    // Set the destination directory for uploads - this is a server path that takes us
			    // to the root of the server, which is denoted by the beginning /  - it is saved to
			    // a variable so we can use it later
			    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

			    // Grab the filename from the uploaded file by using basename - basename 
			    $filename = basename($_FILES['file1']['name']);

			    // $filename = strtotime("now") . '-' . basename($_FILES[file1]['name']);
		    	// ^ this can be used to give a unique identifying number to the file so 
		    	// if a same-named file is uploaded it won't be overwritten


		    	// Create the saved filename using the file's original name and our upload directory
		    	$savedFilename = $uploadDir . $filename;

				// if (file_exists($filename)) {
			 //   		echo "The file $filename exists";
				// } else {
			 //    	echo "The file $filename does not exist";
				// }

				$itemsFromUpload = addFromFile($savedFilename);
				
				// MERGE WITH EXISTING $ITEMS ARRAY
				// THEN SAVE IT

				$items = array_merge($itemsFromUpload, $items);
				var_dump($items);


				// if posted, add to array
				// if (isset($_FILES['file1'])) {
					// $items[] = $_FILES['file1'];
					// then save changes to txt file
				echo overwriteFile(, $items);
				// }

			    // Move the file from the temp location to our uploads directory
			    // move_uploaded_file(move from ['here'], to here);
			    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
			}

			// Check if we saved a file
			if (isset($savedFilename)) {
			    // If we did, show a link to the uploaded file
			    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
			}


   		
	

		?>

		<h1>upload new file</h1>

	   <form method="POST" enctype="multipart/form-data" action="/todo_bootstrap_horizontal.php">
	        <p>
	            <label for="file1"> select file: </label>
	            <input type="file" id="file1" name="file1">
	        </p>
	        <p>
	            <input type="submit" value="upload">
	        </p>
   		</form>	

	</div>
</body>
</html>