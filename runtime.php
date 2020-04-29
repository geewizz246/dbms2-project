<?php
	session_start();
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
	$_SESSION["BackLink"] = "runtime.php?page=$page";


	$collection = (new MongoDB\Client)->Original_Video->Movies;
	$result = $collection->find( 
		['runtime' => ['$gt' => 500, '$lte' => 650]], 
		['sort' => ['runtime' => 1], 'limit' => $limit, 'skip' => $skip] 
	);
	$total = $collection->count( ['runtime' => ['$gt' => 500, '$lte' => 650]] );

	$total_num_pages = ceil($total / $limit);
	?>

	<div class='container_80'>
		<div id='title'>
			<a href='index.html'> <<&nbsp;&nbsp;&nbsp;&nbsp;</a>Movies with runtime between 500 and 650 minutes
		</div>

		<div class="inner">
			<table>
				<thead>
					<tr>
					<th>ImdbId</th><th>Movie Title</th><th>Genre</th><th>Year</th><th>Runtime</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($result as $entry) {
							echo "<tr>";
							$id = $entry['imdbId'];
							$title = $entry['title'];
							$genre = $entry['year'];
							$year = $entry['year'];
							$runtime = $entry['runtime'];

							echo "<td>$id</td><td>$title</td><td>$genre</td><td>$year</td><td>$runtime</td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>

		<?php include "pagenation.php"; ?>
	</div>

</body>
</html>
