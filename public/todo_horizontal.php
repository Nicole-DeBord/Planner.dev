<?php 

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'planner');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require('db_connect.php');

require_once('../inc/filestore.php');

$showAlert = false;

if (isset($_GET['page'])) {
	var_dump($_GET);

	// Assign our current page number.
	$page = $_GET['page'];
} else {
	$page = 1;
}

$limit = 10;
$offset = $limit * ($page - 1);


// Insert into database
// if posted, add to database
if (isset($_POST['addtodo'])) {

	// Capture value from form.
	$taskAdd = htmlspecialchars(strip_tags($_POST['addtodo']));
	var_dump($taskAdd);

	// Prepare an insert statement to input that item into our database.
	$query = "INSERT INTO todo_list (task) VALUES (:task)";
	$stmt = $dbc->prepare($query);
    $stmt->bindValue(':task', $taskAdd, PDO::PARAM_STR);

	// Execute that statement.  
    $stmt->execute();
    // echo "Inserted item: " . $dbc->lastInsertId() . PHP_EOL;
}

	
	// REMOVE items from database
	// // if get 'remove', and we do get it because we hard-coded this query string
if (isset($_GET['remove'])) {

	// Capture value 
	$taskRemove = $_GET['remove'];
	var_dump($taskRemove);

	// Prepare an insert statement to input that item into our database.
	$stmt = $dbc->prepare('DELETE FROM todo_list WHERE id = :id');
	$stmt->bindValue(':id', $taskRemove, PDO::PARAM_INT);
    
	// Execute that statement.  
    $stmt->execute();
}


	// Check for a file upload
	if(count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {

		// If there is one, handle it.  Upload the file and move it to directory.
		$uploadDir = '/vagrant/sites/planner.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);

		if ($_FILES['file1']['type'] != "text/plain") {
	    		$showAlert = true;

	    } else {

		    $savedFilename = $uploadDir . $filename;

		    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

			// Read that uploaded file, $savedfilename - get your array.
			$tasksArray = []; 

	        if(filesize($savedFilename) > 0) {   
	            $handle = fopen($savedFilename, 'r');
	            $contents = trim(fread($handle, filesize($savedFilename)));
	            $tasksArray = explode("\n", $contents);
	            fclose($handle);
	        }

			// Then loop through array, prepare statements, and execute.
	        $query = "INSERT INTO todo_list (task) VALUES (:task)";

			$stmt = $dbc->prepare($query);

	        foreach($tasksArray as $taskArray) {
	        	$stmt->bindValue(':task', $taskArray, PDO::PARAM_STR);
	    		$stmt->execute();
	    		// echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;
	        }
	    }
	}


$tasks = $dbc->query('SELECT id, task FROM todo_list LIMIT ' . $limit . ' OFFSET ' . $offset)->fetchAll(PDO::FETCH_ASSOC);

$count = $dbc->query('SELECT COUNT(*) FROM todo_list')->fetchColumn();

var_dump($count);


$countRound = ceil($count / $limit);


?>

<html>
<head>
	<title>To-do list, rainbow power</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/todo3_style.css">

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
			<form method="POST" action="/todo_horizontal.php">
				<label for="addtodo">new to-do:</label>
				<input id="addtodo" name="addtodo" type="text" placeholder="your task here" />
				<button class="button" name="submitlist" type="submit">do the thing!</button>
			</form>
			<!-- <form method="POST" action="/todo_horizontal.php">
				<label for="prioritytodo">weigh task:</label>
				<input id="prioritytodo" name="prioritytodo" type="text" placeholder="priority task here" />
				<button class="button" name="submitlist" type="submit">prioritize!</button>
			</form> -->
            <ul class="list">
				<? foreach($tasks as $task) : ?>

           			<li><a href="?remove=<?=$task['id']?>">X</a> | <?= $task['task'] ?></li>

				<?endforeach?>
			</ul>
				<hr>
				<?php if($page >= 2): ?>

				<a href="?page=<?=$page - 1?>" class="btn btn-default pull-left" id="previous"> Previous </a>
				
				<?php endif; ?>

				<?php if($page < $countRound): ?>

				<a href="?page=<?=$page + 1?>" class="btn btn-default pull-right" id="next"> Next </a>
        		
        		<?php endif; ?>

        </div>
    	
    	<div class"col-md-6">


			<h1>add to-do from file</h1>

		  	<form method="POST" enctype="multipart/form-data" action="/todo_horizontal.php">
		        <p>
		            <label for="file1">select file: </label>
		            <input type="file" id="file1" name="file1">
		        </p>
		        <p>
		            <input type="submit" value="upload">
		        </p>
	   		</form>	

	    	<?php

				// Check if we saved a file
				if (isset($savedFilename)) {

				    // If we did, show a link to the uploaded file
				    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
				}
			?>

    	</div>

    </div>

    <div class="row">
    	<div class="col-md-12">
<!--     	<h1>prepare for beginning of new row</h1> -->
    	</div>
    </div>

</div>
	<script>
		<?php 
			if($showAlert) {
				echo "alert('I see what you did there. Please upload a file with the .txt extension.')";
			}
		?>
	</script>
</body>
</html>