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
	$notice = "inimene hoones";
}else{
	$notice .= "Inimesi hoones ei leitud!";
}

$stmt->close();
$conn->close();

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
	$notice1 = "inimene hoones";
}else{
	$notice1 .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();



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
	$notice2 = "inimene hoones";
}else{
	$notice2 .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();




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
	$notice3 = "inimene hoones";
}else{
	$notice3 .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();


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
	$notice4 = "inimene hoones";
}else{
	$notice4 .= "Inimesi hoones ei leitud!";
}
$stmt->close();
$conn->close();


?>

<body>
  <ul>
    <li><a href="inimestehulkhoones.php">Inimeste sisenemine ja väljumine hoonesse!</a></li>
  </ul> 
  
<p>Kokku inimesi hoones: </p>
  <?php
	echo $inimestearvfromdb;
  ?>

  <?php
	echo $notice;
  ?>  
<hr>
<p>Mees õpetajaid hoones: </p>
  <?php
	echo $inimestearvfromdb1;
  ?>

  <?php
	echo $notice1;
  ?>
<p>Nais õpetajaid hoones: </p>
  <?php
	echo $inimestearvfromdb2;
  ?>

  <?php
	echo $notice2;
  ?>
  
<p>Mees üliõpilasi hoones: </p>
  <?php
	echo $inimestearvfromdb3;
  ?>
  <?php
	echo $notice3;
  ?>
  
<p>Nais Üliõpilasi hoones: </p>
  <?php
	echo $inimestearvfromdb4;
  ?>

  <?php
	echo $notice4;
  ?>
  
</body>
</html>




