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
  }//peale 8-18, kasutatud suuremvõrdne märki
  if($hournow > 18 and $hournow <= 20){
	  $partofday = "trenniaeg";
  }
  if($hournow > 6 and $hournow <= 7){
	  $partofday = "ärkamiseaeg";
  }
  if($hournow > 20 and $hournow <= 22){
	  $partofday = "teleka vaatamise aeg";
  }
  
  //vaatame semestri kulgemist
  $semesterstart = new DateTime("2020-8-31");
  $semesterend = new DateTime("2020-12-13");
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a");
  $today = new Datetime("now");
  $fromsemesterstart = $semesterstart->diff($today);
  $daysfromsemesterstart = $fromsemesterstart->format("%r%a");
  
  $percentage = ( $semesterdurationdays / $semesterdurationdays ) * 100;
  
  
  //Nüüd saate IF lausetega vaadata, kas äkki on tänase ja semestri alguse erinevus negatiivne - siis pole ju semester veel peale hakanud.
  //Kui tänaseks on rohkem päevi, kui semesri pikkus, siis on semester lõpenud. Muudel juhtudel on semester täies hoos.
  if ($daysfromsemesterstart > 0){
	   $semestersituation = "pole veel alanud";
	   $percentage = "0";
  }
  if ($daysfromsemesterstart <= 0 and $daysfromsemesterstart <= $semesterdurationdays){
	   $semestersituation = "on täies hoos ja õppetööst on läbitud";
  }
  if ($daysfromsemesterstart > $semesterdurationdays){
	   $semestersituation = "on lõppenud";
	   $percentage = "100";
  }
  //Lisaks andke teada, mitu % on semestri õppetööst tehtud (kui pole semester veel alanud, siis on 0% ja kui semester läbi saab, siis 100%, mitte rohkem).
 
 
  
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
  <p><?php echo "Semester " .$semestersituation ."."; ?></p>
  <p>Õppetööst on läbitud:<?php echo $percentage; ?>%.</p>
</body>
</html>