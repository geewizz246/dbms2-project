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
	
	/*$collection = (new MongoDB\Client)->Original_Video->Movies;
	$collection->drop();


	$deleteResult = $collection->deleteOne(['imdbId' => '']);
	printf($deleteResult->getDeletedCount(),\n " Has Been Deleted from the Movies Collection\n");
	*/
	?>
	<div class="container_80">
		<div id='title'>
			<a href='index.html'> <<&nbsp;&nbsp;&nbsp;&nbsp;</a>Delete Movies from Collection		
		</div>
		<div class="inner">
			<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" style="margin-bottom: 40px;" >
				<div class="row">
					<div class="col-75">
						<div class="col-25">
							<label for="iUser">&nbsp;Enter IMDBID ID</label>      
						</div>
						<div class="col-75">
							<input type="text" id="identity" name="imdb" placeholder="IMDB ID..."  autofocus>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-75">			
						<br><input type="submit" value="Delete">
					</div>
				</div>
			</form>

			<?php
				require_once "vendor/autoload.php";
				$id = (isset($_POST['imdb']) ? $_POST['imdb'] : null );

				if ((strlen(trim($id)) != 0) && (!empty($id)))
				{
					$collection = (new MongoDB\Client)->Original_Video->Movies;
					$result=$collection->findOne(["imdbId"=>"$id"]);
					$name=$result['title'];
					$collection->deleteOne(["imdbId"=>"$id"]);
						
					echo "<strong>$name</strong> has been deleted from the movies collection";
				}
			?>
		</div>
	</div>
</body>

</html>
