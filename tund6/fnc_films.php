<?php

  $database = "if20_hans_li_1";
  //$database = "if20_inga_filmibaas_E";

    //var_dump($GLOBALS);

//funktsioon, mis loeb kõikide filmide infot


  function readfilms(){
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	//$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, tootja, lavastaja FROM film");
	$stmt = $conn->prepare("SELECT * FROM film");
	echo $conn->error;
	//seome tulemuse muutujaga
	$stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $genrefromdb, $studiofromdb, $directorfromdb);
	$stmt->execute();
	$filmhtml = "\t <ol> \n";
	while($stmt->fetch()){
	  $filmhtml .= "\t \t <li>" .$titlefromdb ."\n";
	  $filmhtml .= "\t \t \t <ul> \n";
	  $filmhtml .= "\t \t \t \t <li> Valmimisaasta: " .$yearfromdb ."</li> \n";
	  $filmhtml .= "\t \t \t \t <li> Kestus minutites: " .$durationfromdb ." minutit</li> \n";
	  $filmhtml .= "\t \t \t \t <li> Žanr: " .$genrefromdb ."</li> \n";
	  $filmhtml .= "\t \t \t \t <li> Tootja/stuudio: " .$studiofromdb ."</li> \n";
	  $filmhtml .= "\t \t \t \t <li> Lavastaja: " .$directorfromdb ."</li> \n";
	  
	  $filmhtml .= "\t \t \t </ul> \n";
	  $filmhtml .= "\t \t </li> \n";
  }
  
  $filmhtml .= "\t </ol> \n";
  $stmt->close();
  $conn->close();
  return $filmhtml;
} //readfunktsioon lõppeb



  function savefilm($titleinput, $yearinput, $durationinput, $genreinput, $studioinput, $directorinput){
	  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
	  echo $conn->error;
	  $stmt->bind_param("siisss", $titleinput, $yearinput, $durationinput, $genreinput, $studioinput, $directorinput);
	  $stmt->execute();
	  $stmt->close();
	  $conn->close();
  }//SAvefilm info lõppeb
  
  
  function readgenre(){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	//$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, tootja, lavastaja FROM film");
	$stmt = $conn->prepare("SELECT genre_id, genre_name FROM genre");
	echo $conn->error;
	//seome tulemuse muutujaga
	$stmt->bind_result($genreidfromdb, $genrefromdb);
	$stmt->execute();
	$filmgenredropdown = "\t <ol> \n";
	while($stmt->fetch()){
	  $filmgenredropdown .= "\n \t \t" .'<option value="' .$genreidfromdb .'">' .$genrefromdb .'</option>';
	  $filmgenredropdown .= "\t \t \t </ul> \n";
	  $filmgenredropdown .= "\t \t </li> \n";
	}
	$filmgenredropdown .= "\t </ol> \n";
	$stmt->close();
	$conn->close();
	return $filmgenredropdown;
  }
  
    function readfilmtitle(){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	//$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, tootja, lavastaja FROM film");
	$stmt = $conn->prepare("SELECT movie_id, title FROM movie");
	echo $conn->error;
	//seome tulemuse muutujaga
	$stmt->bind_result($movieidfromdb, $titlefromdb);
	$stmt->execute();
	$filmtitledropdown = "\t <ol> \n";
	while($stmt->fetch()){
	  $filmtitledropdown .= "\n \t \t" .'<option value="' .$movieidfromdb .'">' .$titlefromdb .'</option>';
	  $filmtitledropdown .= "\t \t \t </ul> \n";
	  $filmtitledropdown .= "\t \t </li> \n";
	}
	$filmtitledropdown .= "\t </ol> \n";
	$stmt->close();
	$conn->close();
	return $filmtitledropdown;
  }
  
/*
  
  function titlegenreconnection($description, $bgcolor, $txtcolor){
	
	$notice = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT movie_genre_id, movie_id, genre_id FROM movie_genre WHERE movie_genre_id = ?");
	echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userid"]);
	$stmt->execute();
	if($stmt->fetch()){
		$stmt->close();
		//uuendame profiili
		$stmt= $conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("sssi", $description, $bgcolor, $txtcolor, $_SESSION["userid"]);
  
	}
   }
    
  */
   
  function titlegenreconnection($filmtitledropdown, $filmgenredropdown){
	  $notice = "";
	  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("INSERT INTO movie_genre (movie_id, genre_id) VALUES (?,?)");
	  echo $conn->error;
	  $stmt->bind_param("ii", $filmtitledropdown, $filmgenredropdown);
	  if($stmt->execute()){
			$notice = "Uus seos edukalt salvestatud!";
	  } else {
		  $notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	  $stmt->close();
	  $conn->close();
	  return $notice;
 
  }
  
  
  
  
  
  

?>