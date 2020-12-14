<?php
 require("../../../config.php");
 require("fnc_common.php");
 
 $database = "if20_hans_li_1";


 $vastus = "";
 $inimesetyyperror = "";
 $inimesetyyp = "";
 $sissevaljaerror = "";
 $sissevalja = "";
 
 $notice = "";


 
 if(isset($_POST["siseneminevaljuminesumbit"])){

	  if (!empty($_POST["inimesetyypinput"])){
		$inimesetyyp = intval($_POST["inimesetyypinput"]);
	  } else {
		  $inimesetyyperror = "Vali inimesetüüp!";
	  }
	  
	  if(!empty($_POST["sissevaljainput"])){
		  $sissevalja = intval($_POST["sissevaljainput"]);
	  } else {
		  $sissevaljaerror = "Valige kas väljub või siseneb!";
	  }
	  if(empty($inimesetyyperror)and empty($sissevaljaerror)){
		  $notice = "";
		  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		  $stmt = $conn->prepare("INSERT INTO inimestehulkhoones (type, valjunud) VALUES(?,?)");
		  echo $conn->error;
		  $stmt->bind_param("ii", $inimesetyyp, $sissevalja);
		  if($stmt->execute()){
			  $notice = "ok";
		  } else {
			  $notice = "andmete salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		  }
		  $stmt->close();
		  $conn->close();
	  }
	  
	  
	  
	  
	  
	  
	  
	  
	  //LEIAME INIMESI HETKEL HOONES ET KOGUARVU PANNA DATABASESSE
		$notice = "<p>Inimesi hoones ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(*) FROM inimestehulkhoones WHERE valjunud = 2");
		echo $conn->error;
		$stmt->bind_result($inimestearvkoguarv);
		if($stmt->execute()){
			$notice = "";
			} else {
				$notice .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
			}
		$stmt->fetch();
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
		$inimestekoguarvpealetehet = ($inimestearvkoguarv - $inimestevaljumisarvfromdb);
		if($inimestekoguarvpealetehet < 0){
			$inimestekoguarvpealetehet = 0;
		}



		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 1 AND valjunud = 2");
		echo $conn->error;
		$stmt->bind_result($meesopetajadfromdb);
		if($stmt->execute()){
			$notice = "";
			} else {
				$notice .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
			}
		$stmt->fetch();
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
		$inimestekoguarvpealetehet1 = ($meesopetajadfromdb - $inimestevaljumisarvfromdb1);
		if($inimestekoguarvpealetehet1 < 0){
			$inimestekoguarvpealetehet1 = 0;
}



		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 2 AND valjunud = 2");
		echo $conn->error;
		$stmt->bind_result($naisopetajadfromdb);
		if($stmt->execute()){
			$notice = "";
			} else {
				$notice .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
			}
		$stmt->fetch();
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
		$inimestekoguarvpealetehet2 = ($naisopetajadfromdb - $inimestevaljumisarvfromdb2);
		if($inimestekoguarvpealetehet2 < 0){
			$inimestekoguarvpealetehet2 = 0;
		}



		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 3 AND valjunud = 2");
		echo $conn->error;
		$stmt->bind_result($meesopilasedfromdb);
		if($stmt->execute()){
			$notice = "";
			} else {
				$notice .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
			}
		$stmt->fetch();
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
		$inimestekoguarvpealetehet3 = ($meesopilasedfromdb - $inimestevaljumisarvfromdb3);
		if($inimestekoguarvpealetehet3 < 0){
			$inimestekoguarvpealetehet3 = 0;
		}


		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(type) FROM inimestehulkhoones WHERE type = 4 AND valjunud = 2");
		echo $conn->error;
		$stmt->bind_result($naisopilasedfromdb);
		if($stmt->execute()){
			$notice = "";
			} else {
				$notice .= "andmete leidmisel tekkis tehniline tõrge: " .$stmt->error;
			}
		$stmt->fetch();
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
		$inimestekoguarvpealetehet4 = ($naisopilasedfromdb - $inimestevaljumisarvfromdb4);
		if($inimestekoguarvpealetehet3 < 0){
			$inimestekoguarvpealetehet3 = 0;
		}
		 
		if(empty ($notice)){
			$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
			$stmt = $conn->prepare("INSERT INTO inimesikorragahoones (inimesikokku, meesopetajad, naisopetajad, meesopilased, naisopilased) VALUES(?,?,?,?,?)");
			echo $conn->error;
			$stmt->bind_param("iiiii", $inimestekoguarvpealetehet, $inimestekoguarvpealetehet1, $inimestekoguarvpealetehet2, $inimestekoguarvpealetehet3, $inimestekoguarvpealetehet4);
			if($stmt->execute()){
				$notice = "Hoones viibijate arv lisati andmebaasi!";
			} else {
				$notice = "Hoones viibijate hulga salvestamisel tekkis tehniline tõrge: " .$stmt->error;
			}
			$stmt->close();
			$conn->close();
			
		}

 }
 
 

 
 
 
 
 
 
 
 
 ?>

   <ul>
    <li><a href="inimestehulktabel.php">Hetkel hoones!</a></li>
  </ul>
 <h1>Hans-Märten Liiu</h1> 
 <h1>Inimeste sisenemine ja väljumine hoonest</h1>   

 <hr>
 <body>
  <p>Sisenemine</p>
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
 <label for="inimesetyypinput">Siseneva inimese tüüp:</label>
 <input type="radio" name="inimesetyypinput" id="meesopetaja" value="1" <?php if($inimesetyyp == "1"){echo " checked";}?>><label for="meesopetaja">Mees Õpetaja</label><input type="radio" name="inimesetyypinput" id="naisopetaja" value="2" <?php if($inimesetyyp == "2"){echo " checked";}?>><label for="naisopetaja">Nais Õpetaja</label><input type="radio" name="inimesetyypinput" id="meesyliopilane" value="3" <?php if($inimesetyyp == "3"){echo " checked";}?>><label for="meesyliopilane">Mees Üliõpilane</label><input type="radio" name="inimesetyypinput" id="naisyliopilane" value="4" <?php if($inimesetyyp == "4"){echo " checked";}?>><label for="naisyliopilane">Nais Üliõpilane</label>
 <br>
 <label for="sissevaljainput">Kas väljub või siseneb:</label>
 <input type="radio" name="sissevaljainput" id="jah" value="1" <?php if($sissevalja == "1"){echo " checked";}?>><label for="jah">Väljub</label><input type="radio" name="sissevaljainput" id="ei" value="2" <?php if($sissevalja == "2"){echo " checked";}?>><label for="ei">Siseneb</label>
 <br>
 <input name="siseneminevaljuminesumbit" type="submit" value="Salvesta info"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
 <span><?php echo $inimesetyyperror; ?></span>
 <span><?php echo $sissevaljaerror; ?></span>
 <br>
 </form>
 <hr>
 </html>