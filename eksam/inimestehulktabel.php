<?php

  require("../../../config.php");
  
  $database = "if20_hans_li_1";
  
  

 $vastus = "";
 $inimesetyyperror = "";
 $inimesetyyp = "";
 $sissevaljaerror = "";
 $sissevalja = "";
 $inimestearvfromdb = "";
 

$notice = "<p>Inimesi hoones ei leitud!</p> \n";
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(*) FROM inimestehulkhoones WHERE valjunud = 2");
echo $conn->error;
$stmt->bind_result($inimestearvfromdb);
if($stmt->execute()){
	$notice = "ok";
	} else {
		$notice .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
	}
if($stmt->fetch()){
	$notice = "inimest hoones";
}else{
	$notice .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(*) FROM inimestehulkhoones WHERE valjunud = 1");
echo $conn->error;
$stmt->bind_result($inimestevaljumisarvfromdb);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();
$inimestekoguarvpealetehet = ($inimestearvfromdb - $inimestevaljumisarvfromdb);
if($inimestekoguarvpealetehet < 0){
	$inimestekoguarvpealetehet = 0;
}




$notice1 = "<p>Inimesi hoones ei leitud!</p> \n";
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 1 AND valjunud = 2");
echo $conn->error;
$stmt->bind_result($inimestearvfromdb1);
if($stmt->execute()){
	$notice1 = "ok";
	} else {
		$notice1 .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
	}
if($stmt->fetch()){
	$notice1 = "inimest hoones";
}else{
	$notice1 .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 1 AND valjunud = 1");
echo $conn->error;
$stmt->bind_result($inimestevaljumisarvfromdb1);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();
$inimestekoguarvpealetehet1 = ($inimestearvfromdb1 - $inimestevaljumisarvfromdb1);
if($inimestekoguarvpealetehet1 < 0){
	$inimestekoguarvpealetehet1 = 0;
}


$notice2 = "<p>Inimesi hoones ei leitud!</p> \n";
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 2 AND valjunud = 2");
echo $conn->error;
$stmt->bind_result($inimestearvfromdb2);
if($stmt->execute()){
	$notice2 = "ok";
	} else {
		$notice2 .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
	}
if($stmt->fetch()){
	$notice2 = "inimest hoones";
}else{
	$notice2 .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 2 AND valjunud = 1");
echo $conn->error;
$stmt->bind_result($inimestevaljumisarvfromdb2);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();
$inimestekoguarvpealetehet2 = ($inimestearvfromdb2 - $inimestevaljumisarvfromdb2);
if($inimestekoguarvpealetehet2 < 0){
	$inimestekoguarvpealetehet2 = 0;
}




$notice3 = "<p>Inimesi hoones ei leitud!</p> \n";
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 3 AND valjunud = 2");
echo $conn->error;
$stmt->bind_result($inimestearvfromdb3);
if($stmt->execute()){
	$notice3 = "ok";
	} else {
		$notice3 .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
	}
if($stmt->fetch()){
	$notice3 = "inimest hoones";
}else{
	$notice3 .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 3 AND valjunud = 1");
echo $conn->error;
$stmt->bind_result($inimestevaljumisarvfromdb3);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();
$inimestekoguarvpealetehet3 = ($inimestearvfromdb3 - $inimestevaljumisarvfromdb3);
if($inimestekoguarvpealetehet3 < 0){
	$inimestekoguarvpealetehet3 = 0;
}


$notice4 = "<p>Inimesi hoones ei leitud!</p> \n";
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 4 AND valjunud = 2");
echo $conn->error;
$stmt->bind_result($inimestearvfromdb4);
if($stmt->execute()){
	$notice4 = "ok";
	} else {
		$notice4 .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
	}
if($stmt->fetch()){
	$notice4 = "inimest hoones";
}else{
	$notice4 .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 4 AND valjunud = 1");
echo $conn->error;
$stmt->bind_result($inimestevaljumisarvfromdb4);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();
$inimestekoguarvpealetehet4 = ($inimestearvfromdb4 - $inimestevaljumisarvfromdb4);
if($inimestekoguarvpealetehet3 < 0){
	$inimestekoguarvpealetehet3 = 0;
}






//leiame kategooriate max arvu
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT MAX(inimesikokku) FROM inimesikorragahoones");
echo $conn->error;
$stmt->bind_result($inimestemaxkoguarv);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();

$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT MAX(meesopetajad) FROM inimesikorragahoones");
echo $conn->error;
$stmt->bind_result($meesopetajatemaxkoguarv);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();

$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT MAX(naisopetajad) FROM inimesikorragahoones");
echo $conn->error;
$stmt->bind_result($naisopetajatemaxkoguarv);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();

$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT MAX(meesopilased) FROM inimesikorragahoones");
echo $conn->error;
$stmt->bind_result($meesopilastemaxkoguarv);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();

$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT MAX(naisopilased) FROM inimesikorragahoones");
echo $conn->error;
$stmt->bind_result($naisopilastemaxkoguarv);
$stmt->execute();
$stmt->fetch();
$stmt->close();
$conn->close();






?>

<body>
 <h1>Hans-Märten Liiu</h1> 
  <ul>
    <li><a href="inimestehulkhoones.php">Inimeste sisenemine ja väljumine hoonesse!</a></li>
  </ul> 

<p>MAX erinevaid inimesi hoones korraga: </p>
  <?php
	echo $inimestemaxkoguarv;
  ?>
<hr>

<p>MAX mees õppejõudusid korraga hoones: </p>
  <?php
	echo $meesopetajatemaxkoguarv;
  ?>
<p>MAX nais õppejõudusid korraga hoones: </p>
  <?php
	echo $naisopetajatemaxkoguarv;
  ?>
<p>MAX mees üliõpilasi korraga hoones:</p>
  <?php
	echo $meesopilastemaxkoguarv;
  ?>
<p>MAX nais üliõpilasi korraga hoones: </p>
  <?php
	echo $naisopilastemaxkoguarv;
  ?>





<hr>
<p>Kokku inimesi hoones: </p>
  <?php
	echo $inimestekoguarvpealetehet;
  ?>

  <?php
	echo $notice;
  ?>  
<hr>
<p>Mees õppejõudusid hoones: </p>
  <?php
	echo $inimestekoguarvpealetehet1;
  ?>

  <?php
	echo $notice1;
  ?>
<p>Nais õppejõudusid hoones: </p>
  <?php
	echo $inimestekoguarvpealetehet2;
  ?>

  <?php
	echo $notice2;
  ?>
  
<p>Mees üliõpilasi hoones: </p>
  <?php
	echo $inimestekoguarvpealetehet3;
  ?>
  <?php
	echo $notice3;
  ?>
  
<p>Nais üliõpilasi hoones: </p>
  <?php
	echo $inimestekoguarvpealetehet4;
  ?>

  <?php
	echo $notice4;
  ?>
  
</body>
</html>




