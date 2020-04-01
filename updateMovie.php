<?php
	session_start();

	/** Show the document in JSON format. */
	function showDocument($docId) {
		if (!empty($docId))
		{
			$collection = (new MongoDB\Client)->Original_Video->Movies;
			$result = $collection->findOne(['imdbId' => $docId]);

			if (!empty($result)) {
				// Convert data to JSON representation and display it
				$data = $result->jsonSerialize();
				$json = json_encode($data, JSON_PRETTY_PRINT);

				echo "<h3>IMDB ID: $docId </h3><br>";
				echo $json;

				// Save it to the session
				$_SESSION['imdbId'] = $docId;
				$_SESSION['originalDoc'] = $json;
				return $json;
			} else {
				echo "<h3>No documents with ID $docId exist!</h3>";
			}
		} else {
			echo "<h3>You have not entered a valid ID!</h3>";
		}
	}

	/** Perform the update on the document. */
	function updateDocument($docId) {
		if (!empty($docId)) {
			$field = (isset($_POST['fieldName']) ? $_POST['fieldName'] : null);
			$value = (isset($_POST['newValue']) ? $_POST['newValue'] : null);

			if (!empty($field)) {
				$collection = (new MongoDB\Client)->Original_Video->Movies;

				$oldDoc = $collection->findOne(['imdbId' => $docId]);

				// Update the document
				$result = $collection->updateOne(
					[ 'imdbId' => $docId ], 
					[ '$set' => [ $field => $value ] ],
				);

				if ($result->getModifiedCount() != 0) {
					// Get the modified document
					$doc = $collection->findOne([ '_id' => $oldDoc['_id'] ]);

					// Convert data to JSON representation and display it
					$data = $doc->jsonSerialize();
					$json = json_encode($data, JSON_PRETTY_PRINT);
	
					// Save it to the session
					$_SESSION['updatedDoc'] = $json;
					return $json;
				}
			}
		}
	}
	
	require_once "vendor/autoload.php";

	$id = isset($_SESSION['imdbId']) ? $_SESSION['imdbId'] : null;
	if (isset($_POST['btnDisplay'])) {
		$id = $_POST['imdbId'];
	}
	$originalDoc = isset($_SESSION['originalDoc']) ? $_SESSION['originalDoc'] : null;
	$updatedDoc = isset($_SESSION['updatedDoc']) ? $_SESSION['updatedDoc'] : null;
?>
<!DOCTYPE html>

<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="mystyle.css"> 
</head>
<body >
	<div class="container_70">
    	<div id='title'>
			<?php				
				$back = str_replace(" ","%20",$_SERVER['HTTP_REFERER']);
				echo "<a href=$back>&lt;&lt;&nbsp;&nbsp;&nbsp;&nbsp;</a>Update movies in collection";
			?>
		</div>
		<div class="center">
        	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
          		<div class="row">
			  		<div class="col-25">
						<p>Enter IMDB ID</p>
			  		</div>
			  		<div class="col-75">
						<input type="text" placeholder="Enter IMDB ID" name="imdbId">
			  		</div>
				</div>
		  		<div class="row"style="margin-top: 20px;">
			  		<input type="submit" value="Display Movie Document" name="btnDisplay">
				</div>
				<div class="row" style="margin-top: 20px;">
					<?php 
						// If btnDisplay is clicked...
						if (array_key_exists('btnDisplay', $_POST) && empty($updatedDoc)) {
							$originalDoc = showDocument($id);
						}
					?>
				</div>

				<div class="row" style="margin-top: 20px;">
					<?php		
						// If btnUpdate is clicked...
						if (isset($_POST['btnUpdate'])) {
							$updatedDoc = updateDocument($id);
							
							if (empty($updatedDoc)) {
								echo "<h3>Must provide a valid field to update</h3>";
							}
						}
					?>
				</div>

				<!-- Show the prompt for updating document fields -->
				<?php if (!empty($originalDoc) && empty($updatedDoc)): ?>
				<div id="update-container" style="margin-top: 40px;">		
					<div class="row" style="margin-top: 20px;">
						<div class="col-25">
							<p style="float:right;">Field Name </p>
						</div>
						<div class="col-25">
							<input type="text" placeholder="Field Name" name="fieldName">
						</div>
						<div class="col-25">
							<p style="float:right;">New field value </p>
						</div>
						<div class="col-25">
							<input type="text" placeholder="New Value" name="newValue">
						</div>
					</div>
					<div class="row" style="margin-top: 20px;">
						<input type="submit" value="Update Movie" name="btnUpdate">
					</div>
				</div>
				<?php endif; ?>

				<!-- Display the before and after of the update -->
				<?php if (!empty($originalDoc) && !empty($updatedDoc)): ?>
				<div id="result-container" style="margin-top: 40px">
					<div class="row">
						<h2>ORIGINAL DOCUMENT</h2>
						<h3><?php echo "IMDB ID: $id"; ?></h3>
						
						<p><?php echo $originalDoc; ?></p>
					</div>

					<div class="row">
					<h2>UPDATED DOCUMENT</h2>
						<h3>
							<?php 
								echo "IMDB ID: " . (new MongoDB\Model\BSONDocument(json_decode($updatedDoc)))['imdbId'];
							?>
						</h3>
						<div>
							<?php
								echo $updatedDoc;

								// Reset session variables
								$id = $originalDoc = $updatedDoc = null;
								$_SESSION['imdbId'] = $_SESSION['originalDoc'] = $_SESSION['updatedDoc'] = null;
							?>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</form>
		</div>
	</div>
</body>
</html>