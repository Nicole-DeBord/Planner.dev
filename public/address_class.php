<?php

require_once('model_class.php');


Class Address extends Model {
	
	public $streetAdd = '';
	public $aptAdd = '';
	public $cityAdd = '';
	public $stateAdd = '';
	public $zipAdd = '';
	public $fourAdd = '';
	public $personId = 1;

	public function insert() {

		$query = "INSERT INTO address (street, apt, city, state, zip, plus_four, person_id) VALUES (:street, :apt, :city, :state, :zip, :plus_four, :person_id)";

		$stmt = $this->dbc->prepare($query);

    	$stmt->bindValue(':street', $this->streetAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':apt', $this->aptAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':city', $this->cityAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':state', $this->stateAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':zip', $this->zipAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':plus_four', $this->fourAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':person_id', $this->personId, PDO::PARAM_INT);

    	 $stmt->execute();
	}

	// protected function update() {

	// 	SELECT * from address_book WHERE street = $this->streetAdd, apt = $this->aptAdd, 

	// 	$query = "UPDATE address_book "

	// }

}




// if(!empty($_POST)) {
// 	// Create new address model instance
// 	// Validate $_POST data
// 	// Set properties from $_POST
// 	// Save
// }




