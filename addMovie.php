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
    
    <?php
        require_once "vendor/autoload.php";
        $id = (isset($_POST['id']) ? $_POST['id'] : null );
        $title = (isset($_POST['title']) ? $_POST['title'] : null );
        $releaseYear= (isset($_POST['rYear']) ? $_POST['rYear'] : null );
        $rating=(isset($_POST['rating']) ? $_POST['rating'] : null );
        $genre=(isset($_POST['genre']) ? $_POST['genre'] : null );
        $votes=(isset($_POST['votes']) ? $_POST['votes'] : null );
        $runTime=(isset($_POST['runTime']) ? $_POST['runTime'] : null );
        $director=(isset($_POST['director']) ? $_POST['director'] : null );
        $cast=(isset($_POST['cast']) ? explode(', ', $_POST['cast']) : null );
        $postPath=(isset($_POST['postPath']) ? $_POST['postPath'] : null );
        $moviePlot=(isset($_POST['moviePlot']) ? $_POST['moviePlot'] : null );

        if ((!empty($id)) &&(!empty($title)) && (!empty($releaseYear)) && (!empty($genre)) && (!empty($runTime)) &&(!empty($director)) && (!empty($cast)))
        { 
            $collection = (new MongoDB\Client)->Original_Video->Movies;
            $result = $collection->insertOne(["title"=>"$title", "year"=> "$releaseYear","imdbId"=>"$id","mpaaRating"=>"$rating","genre"=>"$genre","viewerVotes"=>"$votes","runtime"=>"$runTime","director"=>"$director","cast"=> $cast,"PosterPath"=>"$postPath","plot"=>"$moviePlot"]);
        }

    
    ?>
	<div class="container_70">
    <div id='title'>
    <a href='index.html'> <<&nbsp;&nbsp;&nbsp;&nbsp;</a>Add Movie Document   
  </div>
    <div class="center">
        <?php if (!empty($result)): ?>
        <div class="row">
            <div class="col-25"></div>
            <div class="col-75">
                <?php if ($result->getInsertedCount() > 0) {
                    echo "<h3>Successfully added movie <strong>$title</strong>!</h3>";
                } else {
                    echo "<h3>Something went wrong when trying to add movie <strong>$title</strong></h3>!";
                }
                ?>
            </div>
        </div>
        <?php endif; ?>
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
           <div class="row">
                <div class="col-25">
                    <p>Title</p>
                </div>
                <div class="col-75">
                    <input name="title" placeholder="Movie Title" type="text" required>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Release Year</p>
                </div>
                <div class="col-75">
                    <input name="rYear" placeholder="Release Year" type="text" required>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>IMDB ID</p>
                </div>
                <div class="col-75">
                    <input name="id" placeholder="IMDB ID"  type="text" required>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>MPAA Rating </p>
                </div>
                <div class="col-75">
                <select name="rating" id="rate" style="padding: 0px;">
                    <option value="G">G</option>
                    <option value="PG">PG</option>
                    <option value="PG-13">PG-13</option>
                    <option value="R">Rated R</option>
                </select>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Genre</p>
                </div>
                <div class="col-75">
                <select name="genre" style="padding: 0px;" id="gen" required>
                    <option value="Comedy">Comedy</option>
                    <option value="Action">Action</option>
                    <option value="Horror">Horror</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Crime">Crime</option>
                    <option value="Family">Family</option>
                </select>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Viewer Votes</p>
                </div>
                <div class="col-75">
                    <input name="votes" placeholder="Viewer Votes" type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Run Time </p>
                </div>
                <div class="col-75">
                    <input name="runTime" placeholder="Run Time" type="text" required>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Director </p>
                </div>
                <div class="col-75">
                    <input name="director" placeholder="Director" type="text" required>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Cast (Comma seperated list)</p>
                </div>
                <div class="col-75">
                    <input name="cast" placeholder="Cast" type="text" required>
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Poster Path</p>
                </div>
                <div class="col-75">
                    <input name="postPath" placeholder="Post Path" type="text">
                </div>
           </div>
           <div class="row">
                <div class="col-25">
                    <p>Movie Plot</p>
                </div>
                <div class="col-75">
                    <input name="moviePlot" style="padding-bottom:100px;" type="text" placeholder="Write something..">
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