<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
 <?php
	date_default_timezone_set('America/Barbados');
	$theID = $_GET['id'];
	require_once "vendor/autoload.php";
	/*<<MONGODB PHP LIBRARY CODE GOES HERE>>
		1.	Connect to the "Movies" collection in the "Original_Video" database
		2.	Find one record with "_id" field equals to "new MongoDB\BSON\ObjectID($theID)"
		3.	Get "comments" value and store it in "$comCount"
	*/
	$collection = (new MongoDB\Client)->Original_Video->Movies;
	$item = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($theID)]);	
	if (isset($item['comments'])){
		$comCount = $item['comments'];
	}
	else
	{
		$comCount = 0;
	}
?>
<div class="container_50">
	<div id='title'>
		<a href='details.php?id=<?php echo $theID; ?>'>&lt;&lt;&nbsp;&nbsp;&nbsp;&nbsp;</a>Add or View Comments		
	</div>
   <div class="inner">
   <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" >
    <div class="row">
	  <div class="col-25">
	  <?php
			if (isset($item['PosterPath']))
		{
			$img = $item['PosterPath'];
			echo "<img src=$img width='90%' height='225'/>";
		}
		else
		{
			echo "<img src='no_poster.png' width='90%' height='225'/>";
			$title = $item['title'];
			echo "<font color='green' size='6'>$title</b></font>";
		}
			
		?>
	  </div>
	<div class="col-75">
	  <div class="col-25">
		<label for="iUser">Your Name</label>      
	  </div>
	  <div class="col-75">
		 <input type="text" id="iUser" name="User" placeholder="Your Name..."  autofocus>
	  </div>
	  <div class="row">				
	  </div>
	  <div class="col-25">
		<label for="iComment">Your Comment</label> 		
	  </div>
	  <div class="col-75">
		<textarea name="comment" rows="9"> </textarea>
	  </div>
	</div>
	  
  </div>
	  <div class="row">				
		<br><input type="submit" value="Submit">
	   </div>
    
  </form>
   </div>
  </div>
  <?php
		require_once "vendor/autoload.php";		
		$comment = (isset($_POST['comment']) ? $_POST['comment'] : null );
		$username = (isset($_POST['User']) ? $_POST['User'] : null );
		if ((strlen(trim($comment)) != 0) && (!empty($username)))
		{
			$theArr = ['userName' => $username]; 
			$theArr['comment'] = $comment; 		
			$theArr['parentID'] = new MongoDB\BSON\ObjectID($theID); 	
			$theArr['dateTime'] = date('M,d,Y h:i:s A');
			
			/*<<MONGODB PHP LIBRARY CODE GOES HERE>>
				1.	Connect to the "Comments" collection in the "Original_Video" database
				2.	Insert the "$theArr" into the "Comments" collection
				3.	Increment the "comments" field of the "Movies" collection form "_id" field equals "new MongoDB\BSON\ObjectID($theID)"
				4.	Get the "comments" value from "Movies" collection after the update, store the amount in "$comCount"
			*/
			$commentCollection = (new MongoDB\Client)->Original_Video->Comments;
			$commentCollection->insertOne($theArr);
			$collection->updateOne(['_id' => new MongoDB\BSON\ObjectID($theID)],['$inc'=>['comments'=> 1]]);
			$item = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($theID)]);	
			if (isset($item['comments'])){
				$comCount = $item['comments'];
			}
			else
			{
				$comCount = 0;
			}
		}			
		if ($comCount > 0)	
		{
		    
			$page  = isset($_GET['zpage']) ? (int) $_GET['zpage'] : 1;
			$limit = 10; 	
			$start_movement = 5; 
			$skip  = ($page - 1) * $limit; 
			$next  = ($page + 1);
			$prev  = ($page - 1);
			$range = 5; 	
			$start_offset = ceil($range / 2); 
			
			
			
			
			/*<<MONGODB PHP LIBRARY CODE GOES HERE>>
				1.	Connect to the "Comments" collection in the "Original_Video" database
				2.	Get all records with "parentID" field equals to "new MongoDB\BSON\ObjectID($theID)]" sorted by "_id" in descending order, limit by "$limit" and skip by "$skip"
				3.	Count number of records for "parentID" field equals to "new MongoDB\BSON\ObjectID($theID)" and store value in "$total"			
			*/
			$commentCollection = (new MongoDB\Client)->Original_Video->Comments;
			$result = $commentCollection->find(['parentID'=>new MongoDB\BSON\ObjectID($theID)], ['$limit' => $limit, '$skip'=> $skip]);		
			$total = $commentCollection->count(['parentID'=>new MongoDB\BSON\ObjectID($theID)]);
			
			
			
			$total_num_pages = ceil($total / $limit); 				
			echo "<div class='bar'><b>".$comCount." Previous Comments</b><br><br><br>";
			foreach ($result as $entry) 
			{
				$id =  $entry['_id'];
				$userName = isset($entry['userName']) ? $entry['userName'] : '';
				$comment = isset($entry['comment']) ? $entry['comment'] : '';
				$date = isset($entry['dateTime']) ? $entry['dateTime'] : '';
				echo "<div class='comm_title'>";
				echo "<font size='4'><b>$userName</b></font>";
				echo "<div style='float: right'>";
					echo "<font size='2'>".$date."</font>";
				echo "</div>";
				echo "</div>";
				echo "<div class='comm'>";
					echo "$comment";			
				echo "</div>";
				echo "<br>";
			}	
			echo "</div>";
			echo "<div class='pagination'>";	
			if ($page >= $start_movement)
			{
				$start = $page-$start_offset;
			}
			else
			{
				$start = 1;
			}
			if ($page != 1)
			{
				echo '<a href="?zpage='.$prev.'&id='.$theID.'">Previous</a>';
			}
			if (($page < $total_num_pages - $start_offset) && ($total_num_pages > $start+$range))
			{
				for ($x=$start;$x<=$start+$range;$x++)
				{	
					if ($x > 0)
					{
						echo ' <a href="?zpage='.$x.'&id='.$theID.'" class = '. ($page == $x ? "active" : "").'>'.$x.'</a>';
					}
				}
			}
			else
			{
				for ($x=$total_num_pages-$range;$x<=$total_num_pages;$x++)
				{
					if ($x > 0)
					{
						echo ' <a href="?zpage='.$x.'&id='.$theID.'"  class = '. ($page == $x ? "active" : "").'>'.$x.'</a>';
					}
				}	
			}
			if($page * $limit < $total) 
			{
				echo ' <a href="?zpage='.$next.'&id='.$theID.'">Next</a>';
			}
			echo "</div>";
			
		}	
  ?>
</body>
</html>
