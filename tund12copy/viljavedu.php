<?php
 require("usersession.php");
 require("../../../config.php");
 require("fnc_common.php");
 $sisenemismass ="";
 $sisenemismasserror ="";
 $autoregnr ="";
 $autoregnrerror ="";
 $väljumismass ="";
 $väljumismasserror ="";
 $database = "if20_hans_li_1";
 $selectedvedu = "";
 
 
 $notice = "";
  function readvedutoselect($selectedvedu){
	  $notice = "<p>Kahjuks väljumismassita veoseid ei leitud!</p> \n";
	  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("SELECT viljavedu_id, autonr, sisenemismass FROM viljavedu WHERE valjumismass IS NULL");
	  echo $conn->error;
	  $stmt->bind_result($idfromdb, $autonrfromdb, $sisenemismassfromdb);
	  $stmt->execute();
	  $vedu = "";
	  while($stmt->fetch()){
		  $vedu .= '<option value="' .$idfromdb .'"';
		  if($idfromdb == $selectedvedu){
			  $vedu .= " selected";
		  }
		  $vedu .= ">" .$autonrfromdb ." ja sisenemismass " .$sisenemismassfromdb ."</option> \n";
	  }
	  if(!empty($vedu)){
		  $notice = '<select name="valjumismasshiljeminput" id="valjumismasshiljeminput">' ."\n";
		  $notice .= '<option value="" selected disabled>Vali vedu</option>' ."\n";
		  $notice .= $vedu;
		  $notice .= "</select> \n";
	  }
	  $stmt->close();
	  $conn->close();
	  return $notice;
  }

function storenewviljaveovaljumine($selectedvedu, $lisatudvaljumismass){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	//"INSERT INTO viljavedu (valjumismass) VALUES(?) WHERE viljavedu_id = ?"
	//"UPDATE viljavedu SET valjumismass = ? WHERE viljavedu_id = ?"
	$stmt = $conn->prepare("UPDATE viljavedu SET valjumismass = ? WHERE viljavedu_id = ?");
	echo $conn->error;
	$stmt->bind_param("di", $lisatudvaljumismass, $selectedvedu);
	if($stmt->execute()){
		$notice = "Uus seos edukalt salvestatud!";
	} else {
		$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

  if(isset($_POST["viljaveovaljumissumbit"])){
	  $selectedvedu = intval($_POST["valjumismasshiljeminput"]);
	  echo $selectedvedu;
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["valjumismasshiljeminput"])){
		$selectedvedu = intval($_POST["valjumismasshiljeminput"]);
	} else {
		$notice = " Vali väljumisvedu!";
	}
	if(!empty($_POST["väljumismassinput"])){
		$lisatudvaljumismass = ($_POST["väljumismassinput"]);
	} else {
		$notice .= " Lisa väljumismass!";
	}
	if(!empty($selectedvedu) and !empty($lisatudvaljumismass)){
		$notice = storenewviljaveovaljumine($selectedvedu, $lisatudvaljumismass);
	}
  }


 
 if(isset($_POST["viljaveosumbit"])){
	  
	  if (!empty($_POST["autoregnrinput"])){
		$autoregnr = test_input($_POST["autoregnrinput"]);
	  } else {
		  $autoregnrerror = "Sisesta autonr!";
	  }
	  
	  if(!empty($_POST["sisenemismassinput"])){
		  $sisenemismass = ($_POST["sisenemismassinput"]);
	  } else {
		  $sisenemismasserror = "Sisestage sisenemismass!";
	  }
	  if(!empty($_POST["väljumismassinput"])){
		  $väljumismass = ($_POST["väljumismassinput"]);
	  }
	  if(empty($autoregnrerror)and empty($sisenemismasserror)){
		  if(empty($väljumismass)){
			  echo $väljumismass;
			  $notice = "";
			  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
			  $stmt = $conn->prepare("INSERT INTO viljavedu (autonr, sisenemismass) VALUES(?,?)");
			  echo $conn->error;
			  $stmt->bind_param("sd", $autoregnr, $sisenemismass);
			  if($stmt->execute()){
				  $notice = "ok";
			  } else {
				  $notice = "andmete salvestamisel tekkis tehniline tõrge: " .$stmt->error;
			  }
			  $stmt->close();
			  $conn->close();
		  }else{
			  $notice = "";
			  echo $väljumismass;
			  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
			  $stmt = $conn->prepare("INSERT INTO viljavedu (autonr, sisenemismass, valjumismass) VALUES(?,?,?)");
			  echo $conn->error;
			  $stmt->bind_param("sdd", $autoregnr, $sisenemismass, $väljumismass);
			  if($stmt->execute()){
				  $notice = "ok";
			  } else {
				  $notice = "andmete salvestamisel tekkis tehniline tõrge: " .$stmt->error;
			  }
			  $stmt->close();
			  $conn->close();
		  }
	  }
 }
 
 
 
 
 
 
 
  $filmselecthtml = readvedutoselect($selectedvedu);
 
 require("header.php");
 ?>
 <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 <h1>Viljaveo sisestamine</h1>   
 <a href="home.php">Tagasi koju</a>
 <p><a href="?logout=1">Logi välja</a>!</p>
 <hr>
 <body>
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
 <label for="autoregnrinput">auto reg nr:</label>
 <input name="autoregnrinput" id="autoregnrinput" type="text" value="<?php echo $autoregnr; ?>"><span><?php echo $autoregnrerror; ?></span>
 <br>
 <label for="sisenemismassinput">Sisenemismass:(Kilogrammides)</label>
 <input name="sisenemismassinput" id="sisenemismassinput" type="text" value="<?php echo $sisenemismass; ?>"><span><?php echo $sisenemismasserror; ?></span>
 <br>
 <label for="väljumismassinput">Väljumismass:(Kilogrammides) See võib algul tühjaks jääda!</label>
 <input name="väljumismassinput" id="väljumismassinput" type="text" value="<?php echo $väljumismass; ?>"><span><?php echo $väljumismasserror; ?></span>
 <br>
 
 <input name="viljaveosumbit" type="submit" value="Salvesta viljaveo info"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
 <br>
 </form>
 <hr>
 
 
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
 <br>
 <?php
	echo $filmselecthtml;
?>

 <label for="väljumismassinput">Väljumismass:(Kilogrammides)</label>
 <input name="väljumismassinput" id="väljumismassinput" type="text" value="<?php echo $väljumismass; ?>"><span><?php echo $väljumismasserror; ?></span>
 <br>
 
 <input name="viljaveovaljumissumbit" type="submit" value="Lisa viljaveo väljumismass"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
 <br>
 </form>
 </html>