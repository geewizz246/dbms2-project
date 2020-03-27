<?php	
	session_start();	
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
        <form action="">
          <div class="row">
			  <div class="col-25">
					<p>Enter IMDB ID </p>
			  </div>
			  <div class="col-75">
					<input type="text" placeholder="Enter IMDB ID">
			  </div>
		  </div>
		  <div class="row"style="margin-top: 20px;">
			  <input type="submit" value="Display Movie Document ">
		  </div>
		  <div class="row" style="margin-top: 20px;">
			  <div class="col-25">
					<p style="float:right;">Field Name </p>
			  </div>
			  <div class="col-25">
					<input type="text" placeholder="Field Name">
			  </div>
			  <div class="col-25">
					<p style="float:right;">New field value </p>
			  </div>
			  <div class="col-25">
					<input type="text" placeholder="New Value">
			  </div>
		  </div>
		  <div class="row"style="margin-top: 20px;">
			  <input type="submit" value="Display Movie Document ">
		  </div>
        </form>
    </div>
    </div>
</body>
</html>