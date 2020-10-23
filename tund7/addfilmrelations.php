<?php

  //loeme andmebaasi login ifo muutujad
  require("usersession.php");
  require("../../../config.php");
  require("fnc_filmrelations.php");
  
  $genrenotice = "";
  $selectedfilm = "";
  $selectedgenre = "";
  $studionotice = "";
  $selectedstudio = "";
  $personnotice = "";
  $selectedperson = "";
  $selectedposition = "";
  $selectedrole = "";
  $selectedpersoninfilm = "";
  $personquotenotice = "";
  $personquote = "";
  
  
  if(isset($_POST["filmstudiorelationsubmit"])){
	  //$selectedfilm = $_POST["filminput"];
	  if(!empty($_POST["filminput"])){
		  $selectedfilm = intval($_POST["filminput"]);
	  } else {
		  $studionotice = " Vali film!";
	  }
	  if(!empty($_POST["filmstudioinput"])){
		  $selectedstudio = intval($_POST["filmstudioinput"]);
	  } else {
		  $studionotice .= " Vali Stuudio!";
	  }
	  if(!empty($selectedfilm) and !empty($selectedgenre)){
		  $studionotice = storenewstudiorelation($selectedfilm, $selectedstudio);
	  }
  }
  
  
  if(isset($_POST["filmgenrerelationsubmit"])){
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$genrenotice = " Vali film!";
	}
	if(!empty($_POST["filmgenreinput"])){
		$selectedgenre = intval($_POST["filmgenreinput"]);
	} else {
		$genrenotice .= " Vali žanr!";
	}
	if(!empty($selectedfilm) and !empty($selectedgenre)){
		$genrenotice = storenewgenrerelation($selectedfilm, $selectedgenre);
	}
  }
  
  if(isset($_POST["filmpersonrelationsubmit"])){
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$personnotice = " Vali film!";
	}
	if(!empty($_POST["personinput"])){
		$selectedperson = intval($_POST["personinput"]);
	} else {
		$personnotice .= " Vali persoon!";
	}
	if(!empty($_POST["positioninput"])){
		$selectedposition = intval($_POST["positioninput"]);
		if($selectedposition == 1){
			$selectedrole = ($_POST["roleinput"]);
		}
	} else {
		$personnotice .= " Vali positsioon!";
	}

	if(!empty($selectedfilm) and !empty($selectedperson) and !empty($selectedposition)){
		$personnotice = storenewpersonrelation($selectedperson, $selectedfilm, $selectedposition, $selectedrole);
	}
  }
  
  
  
  if(isset($_POST["personquoterelationsubmit"])){
	if(!empty($_POST["quoteinput"])){
		$personquote = ($_POST["quoteinput"]);
	} else {
		$personquotenotice = " Sisesta tsitaat!";
	}
	if(!empty($_POST["roleinfilminput"])){
		$selectedpersoninfilm = intval($_POST["roleinfilminput"]);
	} else {
		$personquotenotice .= " Vali filmi tegelane!";
	}
	if(!empty($personquote) and !empty($selectedpersoninfilm)){
		$personquotenotice = storenewpersonquoterelation($personquote, $selectedpersoninfilm);
	}
  }
  
  
  
  
  $filmselecthtml = readmovietoselect($selectedfilm);
  $filmgenreselecthtml = readgenretoselect($selectedgenre);
  $filmstudioselecthtml = readstudiotoselect($selectedstudio);
  $filmpersonselecthtml = readpersontoselect($selectedperson);
  $filmpersonpositionselecthtml = readpositiontoselect($selectedposition);
  $personinfilmselecthtml = readpersoninfilmtoselect($selectedpersoninfilm);

  //$username = "Andrus Rinde";

  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
    
  <ul>
    <li><a href="home.php">Avalehele</a></li>
	<li><a href="?logout=1">Logi välja</a>!</li>
  </ul>
  
  <hr>
  <h2>Määrame persoonile filmis quote</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  
	<textarea rows="10" cols="80" name="quoteinput" id="quoteinput" placeholder="Filmitegelase tsitaat!"></textarea>
	<?php
		echo $personinfilmselecthtml;
	?>
	<input type="submit" name="personquoterelationsubmit" value="Salvesta filmi tegelase tsitaat"><span><?php echo $personquotenotice; ?></span><span>
  </form>
  
  <hr>
  <h2>Määrame filmile persoon</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmpersonselecthtml;
		echo $filmselecthtml;
		echo $filmpersonpositionselecthtml;
	?>
    <input type ="text" name="roleinput" placeholder="Roll filmis!">
	<input type="submit" name="filmpersonrelationsubmit" value="Salvesta seos persooniga"><span><?php echo $personnotice; ?></span>
  </form>
  
  <hr>
  <h2>Määrame filmile stuudio</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmstudioselecthtml;
	?>    
	<input type="submit" name="filmstudiorelationsubmit" value="Salvesta seos stuudioga"><span><?php echo $studionotice; ?></span>
  </form>
  
  
  <hr>
  <h2>Määrame filmile žanri</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmgenreselecthtml;
	?>
	
	<input type="submit" name="filmgenrerelationsubmit" value="Salvesta genre seos"><span><?php echo $genrenotice; ?></span>
  </form>
  
</body>
</html>