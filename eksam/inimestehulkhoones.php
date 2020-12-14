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
		  echo $inimesetyyp;
		  echo $sissevalja;
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
 }
 
 
 
 
 
 ?>
 <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
   <ul>
    <li><a href="inimestehulktabel.php">Hetkel hoones!</a></li>
  </ul>
 
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