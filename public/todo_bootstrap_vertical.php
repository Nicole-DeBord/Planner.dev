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
	<link rel="stylesheet" href="/css/todo2_style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

</head>
<body>
<div class="container">
    <div clas="row">
        <div class="col-md-4">

            <div class="red"></div>
	
			<div class="orange"></div>
		
			<div class="yellow"></div>

			<div class="green"></div>
			
			<div class="blue"></div>
			
			<div class="violet"></div>
                  
        </div>    

        <div class="col-md-8">
            <h1>to-do list</h1>
				<form method="GET" action="/todo_bootstrap_vertical.php">
					<label for="addtodo">new to-do:</label>
					<input id="addtodo" name="addtodo" type="text" placeholder="your task here" />
					<button class="button" name="submitlist" type="submit">do the thing!</button>
			</form>
                <ul class="list">
					<?php
						foreach($items as $key => $value) {
	           				echo "<li><a href=\"/todo_bootstrap_vertical.php?remove={$key}\">X</a> | {$value}</li>";
	        			}
					?>
				</ul>
<!-- 
				<form method="POST" action="http://requestb.in/xv3dbzxv">
					<label for="addtodo">new to-do:</label>
					<input id="addtodo" name="addtodo" type="text" placeholder="Enter list item here" />
					<button class="button" name="submitlist" type="submit">Add to list!</button>
			</form> -->
        </div>
    </div>
    <div class="row">
    	<div class"col-md-12">
    		<?php

    		// maybe have my 'save' message display here

			?>
    	</div>
    </div>
</div>

</body>
</html>