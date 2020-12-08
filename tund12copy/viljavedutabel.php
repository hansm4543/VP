<?php

  require("usersession.php");
  require("../../../config.php");
  
  $database = "if20_hans_li_1";
  
  
  //$filmhtml = readpersonsinfilm ();

  
  /* <?php echo readfilms(); ?>  VÕIB PANNA ALLA KOODI LÕPPI FILMHTML ASEMEL*/
 $sisenemismass ="";
 $sisenemismasserror ="";
 $autoregnr ="";
 $autoregnrerror ="";
 $väljumismass ="";
 $väljumismasserror ="";
 $selectedvedu = "";
 $notice = "";
 
  
  
  
function readvedutoselect($selectedvedu){
  $notice = "<p>Kahjuks väljumismassita veoseid ei leitud!</p> \n";
  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
  $stmt = $conn->prepare("SELECT viljavedu_id, autonr FROM viljavedu WHERE valjumismass IS NOT NULL");
  echo $conn->error;
  $stmt->bind_result($idfromdb, $autonrfromdb);
  $stmt->execute();
  $vedu = "";
  while($stmt->fetch()){
	  $vedu .= '<option value="' .$idfromdb .'"';
	  if($idfromdb == $selectedvedu){
		  $vedu .= " selected";
	  }
	  $vedu .= ">" .$autonrfromdb ."</option> \n";
  }
  if(!empty($vedu)){
	  $notice = '<select name="autonrinput" id="autonrinput">' ."\n";
	  $notice .= '<option value="" selected disabled>Vali Autonr</option>' ."\n";
	  $notice .= $vedu;
	  $notice .= "</select> \n";
  }
  $stmt->close();
  $conn->close();
  return $notice;
}
  
  
  
  
  $sortby = 0;
  $sortorder = 0;
  $sortby1 = 0;
  $sortorder1 = 0;
  $sortby2 = 0;
  $sortorder2 = 0;  
  $sortby3 = 0;
  $sortorder3 = 0;    

function readpersonsinfilm ($sortby, $sortorder, $sortby1, $sortorder1){
	echo $sortby;
	echo $sortorder;
	$notice = "<p>Kahjuks koormaid ei leitud!</p> \n";
	
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	$SQLsentence = "SELECT autonr, (sisenemismass - valjumismass) as koorem FROM viljavedu WHERE valjumismass IS NOT NULL";
	
	if($sortby == 0 and $sortorder == 0){
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby1 == 0 and $sortorder1 == 0){
		$stmt = $conn->prepare($SQLsentence);
	}

	
	if($sortby == 4){
		if($sortorder == 2){
			$stmt = $conn->prepare($SQLsentence ." ORDER BY autonr DESC");
	    }else{
			$stmt = $conn->prepare($SQLsentence ." ORDER BY autonr");
		}
	}
	if($sortby1 == 4){
		if($sortorder1 == 2){
			$stmt = $conn->prepare($SQLsentence ." ORDER BY koorem DESC");
	    }else{
			$stmt = $conn->prepare($SQLsentence ." ORDER BY koorem");
		}
	}
	
	
	echo $conn->error;
	$stmt->bind_result($autonrfromdb, $kooremfromdb);
	$stmt->execute();
	$lines = "";
	while($stmt->fetch()){
		$lines .= "<tr> \n";
		$lines .= "<td>" .$autonrfromdb ."</td>";
		$lines .= "<td>" .$kooremfromdb ."</td> \n";
		$lines .= "</tr> \n";
	}
	if(!empty($lines)){
		$notice = "<table> \n";
		$notice .= "<tr> \n";
		$notice .= '<th>Film &nbsp;<a href="?sortby=4&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=4&sortorder=2">&darr;</a></th>';
		$notice .= '<th>Quote &nbsp;<a href="?sortby1=4&sortorder1=1">&uarr;</a> &nbsp;<a href="?sortby1=4&sortorder1=2">&darr;</a></th>' ."\n";
		$notice .= "</tr> \n";
		$notice .= $lines;
		$notice .= "</table> \n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

  
  
  
  
  
  
  $filmselecthtml = readvedutoselect($selectedvedu);
  
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
  
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
 <br>
 <?php
	echo $filmselecthtml;
?>
 <input name="sorteerimisinput" type="submit" value="Näita autonr koormaid"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
 <br>
 </form>
 </html>
  
  
  
  
  
  
  
  <hr>
  <?php
	if(isset($_GET["sortby"]) and isset($_GET["sortorder"])){
		if($_GET["sortby"] >= 1 and $_GET["sortby"] <= 4) {
			$sortby = $_GET["sortby"];
		}
		if($_GET["sortorder"] == 1 or $_GET["sortorder"] == 2){
			$sortorder = $_GET["sortorder"];
		}
	}
	if(isset($_GET["sortby1"]) and isset($_GET["sortorder1"])){
		if($_GET["sortby1"] >= 1 and $_GET["sortby1"] <= 4) {
			$sortby1 = $_GET["sortby1"];
		}
		if($_GET["sortorder1"] == 1 or $_GET["sortorder1"] == 2){
			$sortorder1 = $_GET["sortorder1"];
		}
	}
	
	echo readpersonsinfilm($sortby, $sortorder, $sortby1, $sortorder1, $sortby2, $sortorder2, $sortby3, $sortorder3);
	
  ?>
  
</body>
</html>

