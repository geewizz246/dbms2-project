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
				echo "<a href=$back>&lt;&lt;&nbsp;&nbsp;&nbsp;&nbsp;</a>Add Movie Document";
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
                    <p>Release Year</p>
                </div>
                <div class="col-75">
                    <input placeholder="Release Year" type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>IMDB ID</p>
                </div>
                <div class="col-75">
                    <input placeholder="IMDB ID"  type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>MPAA Rating </p>
                </div>
                <div class="col-75">
                <select id="cars">
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Genre</p>
                </div>
                <div class="col-75">
                <select style="padding: 20px;" id="cars">
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                </select>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Viewer Votes</p>
                </div>
                <div class="col-75">
                    <input placeholder="Viewer Votes" type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Run Time </p>
                </div>
                <div class="col-75">
                    <input placeholder="Run Time" type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Director </p>
                </div>
                <div class="col-75">
                    <input placeholder="Director" type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Cast (Comma seperated list)</p>
                </div>
                <div class="col-75">
                    <input placeholder="Cast" type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Post Path</p>
                </div>
                <div class="col-75">
                    <input placeholder="Post Path" type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Movie Plot</p>
                </div>
                <div class="col-75">
                    <input style="padding-bottom:100px;" type="text" placeholder="Write something..">
                </div>
           </div>
         <div class="row" style="margin: 20px; ">
         <input type="submit" value="Submit">
         </div>
        </form>
    </div>
    </div>
</body>
</html>