<?php
  require("usersession.php");
  require("../../../config.php");
  require("fnc_films.php");
  
  $notice = "";
  $genreerror = "";
  $filmerror = "";

  $filmgenredropdown = readgenre();
  $filmtitledropdown = readfilmtitle();
  
  if(isset($_POST["filmconnect"])){
	  
	  if(!empty($_POST["genreinput"])){
		  $genre = intval($_POST["genreinput"]);
	  } else{
		  $genreerror = "Palun vali Zanr!";
	  }
	  if(!empty($_POST["filminput"])){
		  $film = intval($_POST["filminput"]);
	  } else{
		  $filmerror = "Palun vali Film!";
	  }
		  
	  if(empty ($filmerror) and empty ($genreerror)){
		  $result = connectfilmgenre();
	  
		//$notice = "Kõik korras!";
		if($result == "ok"){
			$notice = "Kõik korras, ühendus loodud!";
			$genre = "";
			$film = "";
		} else {
			$notice = "Tekkis tehniline tõrge: " .$result;
		}
	  }
	}
  
  


  require("header.php");
?>

<body>


  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>
  <hr>

  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="home.php">Avaleht</a></li>
  </ul>
  <hr>

  <form method="POST">


	<label for="filminput">Film: </label>
	<select name="filminput" id="filminput">
		<option value="" selected disabled>Vali film</option>
	<?php
		echo $filmtitledropdown;
	?>
	</select>
	<span><?php echo $filmerror; ?></span>
	<br>
	
	<label for="genreinput">Zanr:</label>
	<select name="genreinput" id="genreinput">
		<option value="" selected disabled>Vali Zanr</option>
	<?php
		echo $filmgenredropdown;
	?>
	</select>
	<span><?php echo $genreerror; ?></span>
	<br>
	  
	<br>
	<input type="submit" name="filmconnect" value="Ühenda omavahel">
	
  </form>
  <p><?php echo $notice; ?></p>

</body>
</html>
