<?php
    
	//kõigi sisestamiste funktsioonid
	//$database = "if20_jan_ln_1";
	$database = "if20_hans_li_1";
	require("usersession.php");
    function saveperson($firstperson,$lastperson,$birthdate){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT person_id FROM person WHERE first_name = ? AND last_name = ?");
	echo $conn->error; 
	$stmt->bind_param("ss",$firstperson, $lastperson);
	$stmt->bind_result($personidfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline isik on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO person (first_name, last_name, birth_date) VALUES(?,?,?)");
		echo $conn->error;
		$stmt->bind_param("sss", $firstperson, $lastperson, $birthdate);
		if($stmt->execute()){
			$notice = "ok";
		} else {
			$notice = "Andmete salvestamisel tekkis tõrge: " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

    function savemovie($selectedtitle,$filmyear,$duration,$description){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT movie_id FROM movie WHERE title = ?");
	echo $conn->error; 
	$stmt->bind_param("s", $selectedtitle);
	$stmt->bind_result($titlefromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline film on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO movie (title, production_year, duration, description) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("siss", $selectedtitle, $filmyear, $duration, $description);
		if($stmt->execute()){
			$notice = "ok";
		} else {
			$notice = "Andmete salvestamisel tekkis tõrge: " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
}
    function saveposition($selectedposition, $description){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT position_id FROM position WHERE position_name = ?");
	echo $conn->error; 
	$stmt->bind_param("s",$selectedposition);
	$stmt->bind_result($positionidfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline positsioon on juba olemas!";
	} else {
		$stmt->close(); 
		$stmt = $conn->prepare("INSERT INTO position (position_name, description) VALUES(?,?)");
		echo $conn->error;
		$stmt->bind_param("ss", $selectedposition, $description);
		if($stmt->execute()){
			$notice = "ok";
		} else {
			$notice = "Andmete salvestamisel tekkis tõrge: " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close(); 
	return $notice;
}
?>


<?php
  //filmi sisestamise html
  $titleerror= ""; 
  $durationerror= null;
  $filmyearerror = null;
  $descriptionerror= "";
  
  $selectedtitle ="";
  $title="";
  $filmyear = null;
  $duration= null;
  $description= "";
  $notice = "";
  if(isset($_POST["moviesubmit"])){
	  
	  if (!empty($_POST["titleinput"])){
		$title = test_input($_POST["titleinput"]);
	  } else {
		  $titleeerror = "Sisesta pealkiri!";
	  }
	  
	  if($_POST["yearinput"] > date("Y") or $_POST["yearinput"] <1895){
	    $filmyearerror .= "Ebareaalne valmimisaasta!";
	  }
	  
	   if(!empty($_POST["yearinput"])){
		  $filmyear = intval($_POST["yearinput"]);
	  } else {
		  $filmyearerror = "Vali valmimisaasta!";
	  }
	  if (!empty($_POST["durationinput"])){
		$duration = intval($_POST["durationinput"]);
	  } else {
		  $durationerror = "Sisesta kestvus!";
	  }
	  
	  if(!empty($_POST["descriptioninput"])){
		  $description = test_input($_POST["descriptioninput"]);
	  } else {
		  $descriptionerror = "Sisestage kirjeldus!";
	  }
	  $selectedtitle = ($_POST["titleinput"]);
	  
	  if(empty($titleerror) and empty($durationerror) and empty($filmyearerror) and empty($descriptionerror)){
		$result = savemovie($selectedtitle, $filmyear,$duration,$description);
		if($result == "ok"){
			$notice = "Film lisatud!";
			$title="";
            $filmyear = null;
			$duration= null;
			$description= "";
		} else {
			$notice = "Tekkis tehniline tõrge: " .$result;
		}
	  }
   }
 
 
 require("header.php");
 ?>
 <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 <h1>Filmi sisestamine</h1>   
 <a href="home.php">Tagasi</a>
 <hr>
 <body>
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
 <label for="titleinput">Pealkiri:</label><br>
 <input name="titleinput" id="titleinput" type="text" value="<?php echo $title; ?>"><span><?php echo $titleerror; ?></span>
 <br>
 <label for="yearinput">Filmi valmimisaasta:</label>
 <br>
 <input type ="number" name="yearinput" id="yearinput" value="<?php echo date("Y");?>"><span><?php echo $filmyearerror; ?></span>
 <br>
 <label for="durationinput">Filmi kestvus minutites:</label>
 <br>
 <input type ="number" name="durationinput" id="durationinput" min="30" max="500"><span><?php echo $durationerror; ?></span>
 <br>
 <label for="descriptioninput">Filmi lühikirjeldus:</label>
 <br>
 <textarea rows="10" cols="80" name="descriptioninput" id="descriptioninput" placeholder="Filmi lühikirjeldus.."><?php echo $description; ?></textarea><span><?php echo $descriptionerror; ?></span>
 <br>
 <input name="moviesubmit" type="submit" value="Salvesta filmi info"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
 </form>
 <p><a href="?logout=1">Logi välja</a>!</p>
 </html>
 
 
<?php
  //inimese sisestamine html
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $firstname= "";
  $lastname = "";
  $birthday = null;
  $birthmonth = null;
  $birthyear = null;
  $birthdate = null;
  $firstperson = "";
  $lastperson = "";
 
  $firstnameerror = "";
  $lastnameerror = "";
  $birthdayerror = null;
  $birthmontherror = null;
  $birthyearerror = null;
  $birthdateerror = null;
  $notice = "";
  
  if(isset($_POST["submitpersondata"])){
	  
	  if (!empty($_POST["firstnameinput"])){
		$firstname = test_input($_POST["firstnameinput"]);
		//echo $firstname;
	  } else {
		  $firstnameerror = "Sisesta eesnimi!";
	  }
	  
	  if (!empty($_POST["lastnameinput"])){
		$lastname = test_input($_POST["lastnameinput"]);
	  } else {
		  $lastnameerror = "Sisesta perekonnanimi!";
	  }
	  
	  if(!empty($_POST["birthdayinput"])){
		  $birthday = intval($_POST["birthdayinput"]);
	  } else {
		  $birthdayerror = "Vali sünnikuupäev!";
	  }
	  
	  if(!empty($_POST["birthmonthinput"])){
		  $birthmonth = intval($_POST["birthmonthinput"]);
	  } else {
		  $birthmontherror = "Vali sünnikuu!";
	  }
	  
	  if(!empty($_POST["birthyearinput"])){
		  $birthyear = intval($_POST["birthyearinput"]);
	  } else {
		  $birthyearerror = "Vali sünniaasta!";
	  }
	  
	  //kontrollime kuupäeva kehtivust (valiidsust)
	  if(!empty($birthday) and !empty($birthmonth) and !empty($birthyear)){
		  if(checkdate($birthmonth, $birthday, $birthyear)){
			  $tempdate = new DateTime($birthyear ."-" .$birthmonth ."-" .$birthday);
			  $birthdate = $tempdate->format("Y-m-d");
		  } else {
			  $birthdateerror = "Kuupäev ei ole reaalne!";
		  }
	  }
	    $firstperson = ($_POST["firstnameinput"]);
		$lastperson = ($_POST["lastnameinput"]);
	  if(empty($firstnameerror) and empty($lastnameerror)and empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror) and empty($birthdateerror)){
		$result = saveperson($firstperson,$lastperson,$birthdate);
		//$notice = "Kõik korras!";
		if($result == "ok"){
			$notice = "Isik lisatud!";
			$firstname= "";
			$lastname = "";
			$birthday = null;
			$birthmonth = null;
			$birthyear = null;
			$birthdate = null;
		} else {
			$notice = "Tekkis tehniline tõrge: " .$result;
		}
			
	  }
  }

 require("header.php"); 
?>
<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1>Tegelase sisestamine</h1>   
  <a href="home.php">Tagasi</a>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <label for="firstnameinput">Eesnimi:</label>
	  <br>
	  <input name="firstnameinput" id="firstnameinput" type="text" value="<?php echo $firstname; ?>"><span><?php echo $firstnameerror; ?></span>
	  <br>
      <label for="lastnameinput">Perekonnanimi:</label><br>
	  <input name="lastnameinput" id="lastnameinput" type="text" value="<?php echo $lastname; ?>"><span><?php echo $lastnameerror; ?></span>
	  <br>
	  <br>
	  <label for="birthdayinput">Sünnipäev: </label>
	  <?php
		echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
		echo "\t \t" .'<option value="" selected disabled>päev</option>' ."\n";
		for ($i = 1; $i < 32; $i ++){
			echo "\t \t" .'<option value="' .$i .'"';
			if ($i == $birthday){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "\t </select> \n";
	  ?>
	  <label for="birthmonthinput">Sünnikuu: </label>
	  <?php
	    echo "\t" .'<select name="birthmonthinput" id="birthmonthinput">' ."\n";
		echo "\t \t" .'<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo "\t \t" .'<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthnameset[$i - 1] ."</option> \n";
		}
		echo "\t </select> \n";
	  ?>
	  <label for="birthyearinput">Sünniaasta: </label>
	  <?php
	    echo "\t" .'<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo "\t \t" .'<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 1; $i >= date("Y") - 125; $i --){
			echo "\t \t" .'<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected "; 
			}
			echo ">" .$i ."</option> \n";
		}
		echo "\t </select> \n";
	  ?>
	  <br>
	  <span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
	  <br>
	  <input name="submitpersondata" type="submit" value="Salvesta info"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
</form>  
</body>
<p><a href="?logout=1">Logi välja</a>!</p>
</html>


<?php
//positsiooni sisestamise html
$positionerror= ""; 
  $descriptionerror= "";
  $selectedposition = "";
  
  $position="";
  $description= "";
  $notice = ""; 
  if(isset($_POST["positionsubmit"])){
	  
	  if (!empty($_POST["positioninput"])){
		$position = test_input($_POST["positioninput"]);
	  } else {
		  $positionerror = "Sisesta positsioon!";
	  }
	  
	  if(!empty($_POST["descriptioninput"])){
		  $description = test_input($_POST["descriptioninput"]);
	  } else {
		  $descriptionerror = "Sisestage kirjeldus!";
	  }
	  
	  $selectedposition = ($_POST["positioninput"]);
	  if(empty($positionerror)and empty($descriptionerror)){
		$result = saveposition($selectedposition, $description);
		if($result == "ok"){
			$notice = "Positsioon lisatud!";
			$position="";
			$description= "";
		} else {
			$notice = "Tekkis tehniline tõrge: " .$result;
		} 
	  }
   }
 
 require("header.php");
 ?>
 <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 <h1>Positsiooni sisestamine</h1>   
 <a href="home.php">Tagasi</a>
 <hr>
 <body>
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
 <label for="positioninput">Positsioon:</label><br>
 <input name="positioninput" id="positioninput" type="text" value="<?php echo $position; ?>"><span><?php echo $positionerror; ?></span>
 <br>
 <label for="descriptioninput">Positsiooni kirjeldus:</label>
 <br>
 <textarea rows="10" cols="80" name="descriptioninput" id="descriptioninput" placeholder="Positsiooni lühikirjeldus.."><?php echo $description; ?></textarea><span><?php echo $descriptionerror; ?></span>
 <br>
 <input name="positionsubmit" type="submit" value="Salvesta positsiooni info"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
 </form>
 <p><a href="?logout=1">Logi välja</a>!</p>
 </html>