<?php	
	session_start();
	function searchDatabase($searchParam, $dbCollection, $pos, $limit, $skip){
		if(is_string($searchParam)){
			$cast='cast';
			if($pos != 'Any'){
				$cast= 'cast.'.$pos;
			}
			$result = $dbCollection->find( 
				[$cast => ['$regex' => $searchParam]],
				['limit' => $limit, 'skip' => $skip] 
			);
			$_SESSION['count'] = $dbCollection->count( [$cast => ['$regex' => $searchParam]]);
			$_SESSION['cast'] = $searchParam;
			$_SESSION['position'] = $pos;
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

	if(isset($_GET['cast']) && isset($_GET['position'])){
		$result = searchDatabase($_GET['cast'], $collection, $_GET['position'], $limit, $skip);
	}
	if(isset($_SESSION['cast']) && isset($_SESSION['position'])){
		$result = searchDatabase($_SESSION['cast'], $collection, $_SESSION['position'], $limit, $skip);
	}
	
	if (isset($_SESSION['count'])) {
		$total = $_SESSION['count'];
		$total_num_pages = ceil($total / $limit);
	}
?>
<div class="container_70">
	<div id='title'>
		<?php				
			$back = str_replace(" ","%20",$_SERVER['HTTP_REFERER']);
			if(isset($_SESSION['cast']) && isset($_SESSION['position'])){
				//code to fix the back button when page had query string
				$url = explode('/', $back );
				array_pop($url);
				$back = implode('/', $url);
			}
			echo "<a href=index.html>&lt;&lt;&nbsp;&nbsp;&nbsp;&nbsp;</a>Star Search (Partial Name...)";
		?>
	</div>
	<div class="center">
		<form action="starSearch.php" method="get">
			<div class="row">
                <div class="col-25">
                    <p>Title</p>
                </div>
                <div class="col-75">
                    <input placeholder="Actor Name" id="castname" name="cast" type="text" required>
                </div>
			</div>
			<div class="row">
                <div class="col-25">
                    <p>Position in cast list</p>
                </div>
                <div class="col-75">
                    <table>
						<tr>
						<th> <input type="radio" id="position" name="position" value="Any" checked>Any </th>
						<th> <input type="radio" id="position" name="position" value="0">First</th>
						<th> <input type="radio" id="position" name="position" value="1">Second</th>
						</tr>
						<tr>
						<th> <input type="radio" id="position" name="position" value="2">third </th>
						<th> <input type="radio" id="position" name="position" value="3">forth</th>
						<th> <input type="radio" id="position" name="position" value="4">fifth</th>
						</tr>
					</table>
                </div>
			</div>
			<div class="row">
				<?php
					if(!empty($_SESSION['cast']) && !empty($_SESSION['position']) && !empty($_SESSION['count'])){
						echo "<p>Star Name Includes: ".$_SESSION['cast']."</p>";
						if($_SESSION['position'] == 'Any'){
							echo "<p>Star in".$_SESSION['position']."position in the cast list</p>";
						}
						else{
							echo "<p>Star in Position " , $_SESSION['position'] + 1 , " in the cast list</p>";
						}
						
						echo "<p>Number of Movies Found <strong>". $_SESSION['count']."</strong></p>";
					}
				?>
			</div>

			<div class="col-100">
				<input type="submit">
			</div>
		</form>
	</div>

	<div class="inner" id="MovieTable" style="margin-top: 40px;">
	<?php
		if(!empty($result)){
			echo "<table>";
				echo "<thead>";
					echo "<tr>";
					echo "<th>ImdbId</th><th>Movie Title</th><th>cast</th><th>Year</th>";
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
					foreach ($result as $entry) {
						echo "<tr>";
						$id = $entry['imdbId'];
						$title = $entry['title'];
						$cast = $entry['cast'];
						$year = $entry['year'];
						$people = "";
						foreach ($cast as $person){
							$people = $people.$person.", ";
						}
						$people = rtrim($people, ', ');
						echo "<td>$id</td><td>$title</td><td>$people</td><td>$year</td>";
						echo "</tr>";
					}
				echo "</tbody>";
			echo "</table>";

			if (isset($total_num_pages)) {
				include "pagenation.php";
			}
		}
	?>
	</div>
</div>
</body>
</html>
