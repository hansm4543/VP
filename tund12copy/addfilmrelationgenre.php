<?php

  //loeme andmebaasi login ifo muutujad
  require("usersession.php");
  require("../../../config.php");
  require("fnc_filmrelations.php");
  
  $notice = "";
  $selectedfilm = "";
  $selectedgenre = "";
  if(isset($_POST["filmrelationsubmit"])){
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$notice = " Vali film!";
	}
	if(!empty($_POST["filmgenreinput"])){
		$selectedgenre = intval($_POST["filmgenreinput"]);
	} else {
		$notice .= " Vali žanr!";
	}
	if(!empty($selectedfilm) and !empty($selectedgenre)){
		$notice = storenewgenrerelation($selectedfilm, $selectedgenre);
	}
  }
  
  $filmselecthtml = readmovietoselect($selectedfilm);
  $filmgenreselecthtml = readgenretoselect($selectedgenre);
  

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
  <h2>Määrame filmile žanri</h2>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmgenreselecthtml;
	?>
	
	<input type="submit" name="filmrelationsubmit" value="Salvesta filmiinfo"><span><?php echo $notice; ?></span>
  </form>
  
</body>
</html>