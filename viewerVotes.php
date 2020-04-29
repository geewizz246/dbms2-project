<?php
session_start();
function getViewerVotes($dbCollection){
	$result = $dbCollection->find( ['viewerVotes'=> ['$gt' => 1000000]]);
	return $result;
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
	$result = [];
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
	$result = getViewerVotes($collection);

if(!empty($result)){
		echo "<table>";
			echo "<thead>";
				echo "<tr>";
				echo "<th>ImdbId</th><th>Movie Title</th><th>Genre</th><th>Year</th><th>Viewer Votes </th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				foreach ($result as $entry) {
					echo "<tr>";
					$id = $entry['imdbId'];
					$title = $entry['title'];
					$genre = $entry['genre'];
					$year = $entry['year'];
					$votes = $entry['viewerVotes'];
					echo "<td>$id</td><td>$title</td><td>$genre</td><td>$year</td><td>$votes</td>";
					echo "</tr>";
				}
			echo "</tbody>";
		echo "</table>";
}



?>

</body>

</html>
