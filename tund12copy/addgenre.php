<?php
 require("usersession.php");
 require("../../../config.php");
 require("fnc_personmovies.php");
 require("fnc_common.php");
 $genreerror ="";
 $descriptionerror ="";
 $selectedgenre ="";
 $notice ="";
 
 $genre = "";
 $description = "";
 //$database = "if20_markus_ve_1";
 
 
 // genre
 
 if(isset($_POST["genresubmit"])){
	  
	  if (!empty($_POST["genreinput"])){
		$genre = test_input($_POST["genreinput"]);
	  } else {
		  $genreerror = "Sisesta zanr!";
	  }
	  if(!empty($_POST["descriptioninput"])){
		  $description = test_input($_POST["descriptioninput"]);
	  } else {
		  $descriptionerror = "Sisestage kirjeldus!";
	  }
	  
	  $selectedgenre = ($_POST["genreinput"]);
	  if(empty($genreerror)and empty($descriptionerror)){
		$result = savegenre($genre, $description);
		if($result == "ok"){
			$notice = "zanr lisatud!";
			$genre="";
			$description= "";
		} else {
			$notice = "Tekkis tehniline tõrge: " .$result;
		}
	  }
   }
 
 require("header.php");
 ?>
 <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 <h1>zanri sisestamine</h1>   
 <a href="home.php">Tagasi koju</a>
 <hr>
 <body>
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
 <label for="genreinput">žanr:</label><br>
 <input name="genreinput" id="genreinput" type="text" value="<?php echo $genre; ?>"><span><?php echo $genreerror; ?></span>
 <br>
 <label for="descriptioninput">zanri kirjeldus:</label>
 <br>
 <textarea rows="10" cols="80" name="descriptioninput" id="descriptioninput" placeholder="zanri lühikirjeldus.."><?php echo $description; ?></textarea><span><?php echo $descriptionerror; ?></span>
 <br>
 <input name="genresubmit" type="submit" value="Salvesta zanri info"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
 </form>
 <p><a href="?logout=1">Logi välja</a>!</p>
 </html>
 
 
 

   
  