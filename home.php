<?php
  $username = "Hansm4543";
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday ="lihtsalt aeg";
  if($hournow < 6){
	  $partofday = "uneaeg";
  } //enne 6
  if($hournow >= 8 and $hournow <= 18){
	  $partofday = "õppimise aeg";
  }//peale 8-18, kasutatud kaasaarvatud märki
  
  //vaatame semestri kulgemist
  $semesterstart = new DateTime("2020-8-31");
  $semesterend = new DateTime("2020-12-13");
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a");
  $today = new Datetime("now");
  
  
  
?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title><?php echo $username; ?> programeerib veebi</title>

</head>
<body style="background-color:Tomato;">
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>
  <p style="background-color:DodgerBlue;"> KODUS KIRJUTATUD TEXT :P</p>
  <p>Lehe avamise hetk:<?php echo $fulltimenow; ?>.</p>
  <p><?php echo "Praegu on " .$partofday ."."; ?></p>
</body>
</html>