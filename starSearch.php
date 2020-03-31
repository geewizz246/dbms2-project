<?php	
	session_start();

	function searchDatabase($searchParam, $dbCollection, $pos){
		if(is_string($searchParam)){
			$cast='cast';
			if($pos != '$'){
				$cast= 'cast.'.$pos;
			}
			$result = $dbCollection->find( [$cast => ['$regex' => $searchParam]]);
			return $result;
		}
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="mystyle.css">
	
</head>
<body>
<?php
	
	require_once "vendor/autoload.php";
	$page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
	$limit = 20; 	
	$start_movement = 7; 
	$skip  = ($page - 1) * $limit; 
	$next  = ($page + 1);
	$prev  = ($page - 1);
	$range = 10; 		
	$start_offset = ceil($range / 2); 	
	$_SESSION["BackLink"] = "searchTitle.php?page=$page";

	$collection = (new MongoDB\Client)->Original_Video->Movies;

	// $result = searchDatabase('Denzel', $collection, '$');
	// foreach ($result as $entry) {
	// 	echo '<pre>', var_dump($entry['cast']) ,'</pre>';
	// }

?>


</body>
</html>
