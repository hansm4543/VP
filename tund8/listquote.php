<?php

  require("usersession.php");
  require("../../../config.php");
  
  $database = "if20_hans_li_1";
  
  
  //$filmhtml = readpersonsinfilm ();

  
  /* <?php echo readfilms(); ?>  VÕIB PANNA ALLA KOODI LÕPPI FILMHTML ASEMEL*/
  
  $sortby = 0;
  $sortorder = 0;
  $sortby1 = 0;
  $sortorder1 = 0;
  $sortby2 = 0;
  $sortorder2 = 0;  
  $sortby3 = 0;
  $sortorder3 = 0;    

function readpersonsinfilm ($sortby, $sortorder, $sortby1, $sortorder1, $sortby2, $sortorder2, $sortby3, $sortorder3){
	echo $sortby;
	echo $sortorder;
	$notice = "<p>Kahjuks filmitegelasi ei leitud!</p> \n";
	
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	$SQLsentence = "SELECT first_name, last_name, role, title, quote_text FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id JOIN quote ON quote.person_in_movie_id = person_in_movie.person_in_movie_id";
	
	if($sortby == 0 and $sortorder == 0){
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby1 == 0 and $sortorder1 == 0){
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby2 == 0 and $sortorder2 == 0){
		$stmt = $conn->prepare($SQLsentence);
	}
	if($sortby3 == 0 and $sortorder3 == 0){
		$stmt = $conn->prepare($SQLsentence);
	}
	
	if($sortby == 4){
		if($sortorder == 2){
			$stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC");
	    }else{
			$stmt = $conn->prepare($SQLsentence ." ORDER BY title");
		}
	}
	if($sortby1 == 4){
		if($sortorder1 == 2){
			$stmt = $conn->prepare($SQLsentence ." ORDER BY quote_text DESC");
	    }else{
			$stmt = $conn->prepare($SQLsentence ." ORDER BY quote_text");
		}
	}
	if($sortby2 == 4){
		if($sortorder2 == 2){
			$stmt = $conn->prepare($SQLsentence ." ORDER BY role DESC");
	    }else{
			$stmt = $conn->prepare($SQLsentence ." ORDER BY role");
		}
	}
	if($sortby3 == 4){
		if($sortorder3 == 2){
			$stmt = $conn->prepare($SQLsentence ." ORDER BY first_name DESC");
	    }else{
			$stmt = $conn->prepare($SQLsentence ." ORDER BY first_name");
		}
	}
	
	
	echo $conn->error;
	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb, $quotefromdb);
	$stmt->execute();
	$lines = "";
	while($stmt->fetch()){
		$lines .= "<tr> \n";
		$lines .= "\t <td>" .$firstnamefromdb ." " .$lastnamefromdb ."</td>";
		$lines .= "<td>" .$rolefromdb ."</td>";
		$lines .= "<td>" .$titlefromdb ."</td>";
		$lines .= "<td>" .$quotefromdb ."</td> \n";
		$lines .= "</tr> \n";
	}
	if(!empty($lines)){
		$notice = "<table> \n";
		$notice .= "<tr> \n";
		$notice .= '<th>Isiku nimi &nbsp;<a href="?sortby3=4&sortorder3=1">&uarr;</a> &nbsp;<a href="?sortby3=4&sortorder3=2">&darr;</a></th>';
		$notice .= '<th>Roll filmis &nbsp;<a href="?sortby2=4&sortorder2=1">&uarr;</a> &nbsp;<a href="?sortby2=4&sortorder2=2">&darr;</a></th>';
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
	if(isset($_GET["sortby2"]) and isset($_GET["sortorder2"])){
		if($_GET["sortby2"] >= 1 and $_GET["sortby2"] <= 4) {
			$sortby2 = $_GET["sortby2"];
		}
		if($_GET["sortorder2"] == 1 or $_GET["sortorder2"] == 2){
			$sortorder2 = $_GET["sortorder2"];
		}
	}
	if(isset($_GET["sortby3"]) and isset($_GET["sortorder3"])){
		if($_GET["sortby3"] >= 1 and $_GET["sortby3"] <= 4) {
			$sortby3 = $_GET["sortby3"];
		}
		if($_GET["sortorder3"] == 1 or $_GET["sortorder3"] == 2){
			$sortorder3 = $_GET["sortorder3"];
		}
	}
	
	echo readpersonsinfilm($sortby, $sortorder, $sortby1, $sortorder1, $sortby2, $sortorder2, $sortby3, $sortorder3);
	
  ?>
  
</body>
</html>

