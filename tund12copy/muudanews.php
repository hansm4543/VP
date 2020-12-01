<?php

  require("usersession.php");
  require ("../../../config.php");
  $database = "if20_hans_li_1";
	
	//uudise lugemine
   $newshtml = "";
   
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], "if20_hans_li_1");
	$stmt = $conn->prepare("SELECT vpnews_id, title, content, firstname, lastname, added, expire, filename FROM vpnews JOIN vpusers ON vpusers.vpusers_id = vpnews.userid LEFT JOIN vpnewsphotos ON vpnews.vpnewsphotos_id = vpnewsphotos.vpnewsphotos_id WHERE expire IS NULL OR expire > CURDATE() ORDER BY vpnews_id DESC");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $newstitlefromdb, $newscontentfromdb, $authorfirstnamefromdb, $authorlastnamefromdb, $uploaddate, $expiredate, $filename);
	$stmt->execute();
	while($stmt->fetch()) {
		if($expiredate == null and $filename != null) {
			$newshtml .= "\t" ."<h3>" .$newstitlefromdb ."</h3> \n \t" ."<p>Autor: <strong>" .$authorfirstnamefromdb ." " .$authorlastnamefromdb ."</strong></p>" ."\n \t" ."<p>Lisatud: <strong>" .$uploaddate ."</strong></p>" ."\n \t" .'<img src="../photoupload_normal/' .$filename .'">' ."\n \t" .htmlspecialchars_decode($newscontentfromdb) ."\n";
			$newshtml .= "\n \t" .'<a href="muutmine.php?news=' .$idfromdb .'">Muuda uudist!</a>';
			$newshtml .= "\n \t" .$idfromdb;
		} elseif($expiredate == null and $filename == null) {
			$newshtml .= "\t" ."<h3>" .$newstitlefromdb ."</h3> \n \t" ."<p>Autor: <strong>" .$authorfirstnamefromdb ." " .$authorlastnamefromdb ."</strong></p>" ."\n \t" ."Lisatud: <strong>" .$uploaddate ."</strong>" ."\n \t" .htmlspecialchars_decode($newscontentfromdb) ."\n";
			$newshtml .= "\n \t" .'<a href="muutmine.php?news=' .$idfromdb .'">Muuda uudist!</a>';
			$newshtml .= "\n \t" .$idfromdb;
		} elseif($expiredate != null and $filename == null) {
			$newshtml .= "\t" ."<h3>" .$newstitlefromdb ."</h3> \n \t" ."<p>Autor: <strong>" .$authorfirstnamefromdb ." " .$authorlastnamefromdb ."</strong></p>" ."\n \t" ."<p>Lisatud: <strong>" .$uploaddate ."</strong></p>" ."\n \t" ."Aegub: <strong>" .$expiredate ."</strong>" ."\n \t" .htmlspecialchars_decode($newscontentfromdb) ."\n";
			$newshtml .= "\n \t" .'<a href="muutmine.php?news=' .$idfromdb .'">Muuda uudist!</a>';
			$newshtml .= "\n \t" .$idfromdb;
		} elseif($expiredate != null and $filename != null) {
			$newshtml .= "\t" ."<h3>" .$newstitlefromdb ."</h3> \n \t" ."<p>Autor: <strong>" .$authorfirstnamefromdb ." " .$authorlastnamefromdb ."</strong></p>" ."\n \t" ."<p>Lisatud: <strong>" .$uploaddate ."</strong></p>" ."\n \t" ."<p>Aegub: <strong>" .$expiredate ."</strong></p>" ."\n \t" .'<img src="../photoupload_normal/' .$filename .'">' ."\n \t" .htmlspecialchars_decode($newscontentfromdb) ."\n";
			$newshtml .= "\n \t" .'<a href="muutmine.php?news=' .$idfromdb .'">Muuda uudist!</a>';
			$newshtml .= "\n \t" .$idfromdb;
		}
	}
	if(!empty($newshtml)) {
		$newshtml = "<div> \n" .$newshtml ."\n  </div> \n";
	} else {
		$newshtml = "<p>Kahjuks uudiseid ei leitud!</p> \n";
	}
	$stmt->close();
	$conn->close();
	
	
  if(isset($_GET["muuda"])){
	  //jõuga suunatakse sisselogimise lehele
	  header("Location: muutmine.php");
	  exit();
  }
	
  require("header.php");
	
?>

<body>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>
  
  
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="home.php">Avaleht</a></li>
	<li><a href="addnews.php">Uudiste lisamine</a></li>
  </ul>
  
  
  
  
  <hr>
  
  <?php echo $newshtml; ?>