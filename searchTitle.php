<?php	
	session_start();

	function searchDatabase($searchParam, $dbCollection, $limit, $skip){
		if(is_string($searchParam)){
			$result = $dbCollection->find( ['title' => ['$regex' => $searchParam]], ['limit'=> $limit, 'skip'=>$skip]);
			$_SESSION['movieCount'] = $dbCollection->count( ['title' => ['$regex' => $searchParam]]);
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
<div class="container_70">
    	<div id='title'>
			<?php				
				$back = str_replace(" ","%20",$_SERVER['HTTP_REFERER']);
				echo "<a href=$back>&lt;&lt;&nbsp;&nbsp;&nbsp;&nbsp;</a>Movie Name Search (Title Includes)";
			?>
		</div>
		<div class="center">
        	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
          		<div class="row">
			  		<div class="col-25">
						<p>Enter IMDB ID</p>
			  		</div>
			  		<div class="col-75">
						<input type="text" placeholder="Enter Movie Title" name="movieTitle">
			  		</div>
				</div>
		  		<div class="row"style="margin-top: 20px;">
			  		<input type="submit" value="Search" name="btnDisplay">
				</div>
				<div class="row" style="margin-top: 20px;">
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
	if (isset($_SESSION['search'])){
		$result = searchDatabase($_SESSION['search'], $collection, $limit, $skip);
		$total = $_SESSION['movieCount'];
		$total_num_pages = ceil($total / $limit);
	}
	if(isset($_POST['btnDisplay'])){
		$_SESSION['search'] = $_POST['movieTitle'];
		$result = searchDatabase($_SESSION['search'], $collection, $limit, $skip);
		$total = $_SESSION['movieCount'];
		$total_num_pages = ceil($total / $limit);
	}

	
?>
<?php
if(!empty($_SESSION['movieTitle'])){
	echo "<p>Movie Title Includes: ".$_SESSION['search']."</p>";
	echo "<p>Number of Movies Found <strong>". $_SESSION['movieCount']."</strong></p>";
	}

	if(!empty($result)){
		echo "<table>";
			echo "<thead>";
				echo "<tr>";
				echo "<th>ImdbId</th><th>Movie Title</th><th>Genre</th><th>Year</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
				foreach ($result as $entry) {
					echo "<tr>";
					$id = $entry['imdbId'];
					$title = $entry['title'];
					$genre = $entry['genre'];
					$year = $entry['year'];
					echo "<td>$id</td><td>$title</td><td>$genre</td><td>$year</td>";
					echo "</tr>";
				}
			echo "</tbody>";
		echo "</table>";
}


?>
				</div>
</form>
		</div>
</div>
				<?php
include "pagenation.php";
				?>
</body>
</html>
