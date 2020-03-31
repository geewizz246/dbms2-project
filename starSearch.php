<?php?>
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
				echo "<a href=$back>&lt;&lt;&nbsp;&nbsp;&nbsp;&nbsp;</a>Star Search (Partial Name...)";
			?>
		</div>
<div class="center">
<form action="">

<div class="row">
                <div class="col-25">
                    <p>Title</p>
                </div>
                <div class="col-75">
                    <input placeholder="Movie Title" type="text">
                </div>
</div>
<div class="row">
                <div class="col-25">
                    <p>Position in cast list</p>
                </div>
                <div class="col-75">
                    <table>
							<tr>
							<th> <input type="radio" id="position" name="position" value="Any">Any </th>
							<th> <input type="radio" id="position" name="position" value="First">First</th>
							<th> <input type="radio" id="position" name="position" value="Second">Second</th>
							</tr>
							<tr>
							<th> <input type="radio" id="position" name="position" value="Third">third </th>
							<th> <input type="radio" id="position" name="position" value="Forth">forth</th>
							<th> <input type="radio" id="position" name="position" value="Fifth">fifth</th>
							</tr>
					</table>
                </div>
</div>
<div class="row">
<div class="col-100">
<input type="submit">
</div>
</div>

</form>
</div>
</div>



</body>
</html>
