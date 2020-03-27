<?php

// Show PHP errors (to make sure code is working)

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 2);
    
// Create a MongoDB connection

$mongodb = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    
// Choose the database and collection
$db = $mongodb->Original_Video->Movies;




?>
<Doctype html>
<html>
<body>
    <h1>ef</h1>
</body>
</html>

