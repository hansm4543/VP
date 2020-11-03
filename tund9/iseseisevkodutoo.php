<?php

  //loeme andmebaasi login ifo muutujad
  require("usersession.php");
  require("../../../config.php");
  require("fnc_filmrelations.php");
  
  
  $personnotice = "";
  $selectedperson = "";
  $selectedposition = "";
  $selectedrole = "";
  $selectedpersoninfilm = "";
  $personquotenotice = "";
  $personquote = "";
  
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
	} else {
		$personnotice .= " Vali positsioon!";
	}
	$selectedrole = ($_POST["roleinput"]);

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
  
  //funktsioonid
  
  function storenewpersonquoterelation($personquote, $selectedpersoninfilm){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT quote_id FROM quote WHERE quote_text = ? AND person_in_movie_id = ?");
	echo $conn->error;
	$stmt->bind_param("si", $personquote, $selectedpersoninfilm);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline seos on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO quote (quote_text, person_in_movie_id) VALUES(?,?)");
		echo $conn->error;
		$stmt->bind_param("si", $personquote, $selectedpersoninfilm);
		if($stmt->execute()){
			$notice = "Uus seos edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

function storenewpersonrelation($selectedperson, $selectedfilm, $selectedposition, $selectedrole){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT person_in_movie_id FROM person_in_movie WHERE person_id = ? AND movie_id = ? AND position_id = ? AND role = ?");
	echo $conn->error;
	$stmt->bind_param("iiis", $selectedperson, $selectedfilm, $selectedposition, $selectedrole);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline seos on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO person_in_movie (person_id, movie_id, position_id, role) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("iiis", $selectedperson, $selectedfilm, $selectedposition, $selectedrole);
		if($stmt->execute()){
			$notice = "Uus seos edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

function readpersoninfilmtoselect($selectedpersoninfilm){
	$notice = "<p>Kahjuks filmi tegelasi ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT person_in_movie_id, role FROM person_in_movie");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $personinfilmfromdb);
	$stmt->execute();
	$roles = "";
	while($stmt->fetch()){
		$roles .= '<option value="' .$idfromdb .'"';
		if(intval($idfromdb) == $selectedpersoninfilm){
			$roles .=" selected";
		}
		$roles .= ">" .$personinfilmfromdb ."</option> \n";
	}
	if(!empty($roles)){
		$notice = '<select name="roleinfilminput" id="roleinfilminput">' ."\n";
		$notice .= '<option value="" selected disabled>Vali filmi tegelane</option>' ."\n";
		$notice .= $roles;
		$notice .= "</select> \n";
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

function readpositiontoselect($selectedposition){
	$notice = "<p>Kahjuks positsioone ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT position_id, position_name FROM position");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $positionfromdb);
	$stmt->execute();
	$positions = "";
	while($stmt->fetch()){
		$positions .= '<option value="' .$idfromdb .'"';
		if(intval($idfromdb) == $selectedposition){
			$positions .=" selected";
		}
		$positions .= ">" .$positionfromdb ."</option> \n";
	}
	if(!empty($positions)){
		$notice = '<select name="positioninput" id="positioninput">' ."\n";
		$notice .= '<option value="" selected disabled>Vali positsioon</option>' ."\n";
		$notice .= $positions;
		$notice .= "</select> \n";
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

function readpersontoselect($selectedperson){
	$notice = "<p>Kahjuks persoone ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT person_id, first_name, last_name FROM person");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $personfirstfromdb, $personlastfromdb);
	$stmt->execute();
	$persons = "";
	while($stmt->fetch()){
		$persons .= '<option value="' .$idfromdb .'"';
		if(intval($idfromdb) == $selectedperson){
			$persons .=" selected";
		}
		$persons .= ">" .$personfirstfromdb ." " .$personlastfromdb ."</option> \n";
	}
	if(!empty($persons)){
		$notice = '<select name="personinput" id="personinput">' ."\n";
		$notice .= '<option value="" selected disabled>Vali persoon</option>' ."\n";
		$notice .= $persons;
		$notice .= "</select> \n";
	}
	$stmt->close();
	$conn->close();
	return $notice;
}


  function readmovietoselect($selectedfilm){
	$notice = "<p>Kahjuks filme ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT movie_id, title FROM movie");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $titlefromdb);
	$stmt->execute();
	$films = "";
	while($stmt->fetch()){
		$films .= '<option value="' .$idfromdb .'"';
		if(intval($idfromdb) == $selectedfilm){
			$films .=" selected";
		}
		$films .= ">" .$titlefromdb ."</option> \n";
	}
	if(!empty($films)){
		$notice = '<select name="filminput">' ."\n";
		$notice .= '<option value="" selected disabled>Vali film</option>' ."\n";
		$notice .= $films;
		$notice .= "</select> \n";
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

  
  
  
  $filmselecthtml = readmovietoselect($selectedfilm);
  $filmpersonselecthtml = readpersontoselect($selectedperson);
  $filmpersonpositionselecthtml = readpositiontoselect($selectedposition);
  $personinfilmselecthtml = readpersoninfilmtoselect($selectedpersoninfilm);


  require("header.php");
?> 




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


</body>
</html>