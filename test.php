<?php

// Show PHP errors (to make sure code is working)

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 2);
    
// Create a MongoDB connection
$mongodb = new MongoClient("mongodb://localhost:8888");
    
// Choose the database and collection
$db = $mongodb->your_db_name;
$collection = $db->your_collection_name;
// Save a record to your collection
$collection->save(array(
"name" => "Chris Mallory",
"age" => 29,
"occupation" => "Web Developer"
));
// Retrieve the record and display it
$record = $collection->findOne();
echo "Hi, my name is " . $record['name'] . ". I'm " . $record['age'] . " years old and work as a " . $record['occupation'] . ".";



?>

