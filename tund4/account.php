<?php
  //var_dump($_POST);
  require("../../../config.php");
  //require("fnc_account.php");
  
  
  $username = "Hansm4543";
  
  //errorid
  $firstnameerror = "";
  $lastnameerror = "";
  $gendererror = "";
  $emailerror = "";
  $passworderror = "";
  $passwordsecondaryerror = "";
  $passwordshorterror = "";
  $passwordnotmatcherror = "";
  
  
  //Sisestuste jäädvustamine errori korral
  
  //Sisestuste jäädvustamine errori korral
  $firstname="";
  $lastname="";
  $gender="";
  $email="";
  
 
 //kui klikiti submit siis
  if(isset($_POST["accountsubmit"])){
	  
	  if (empty($_POST["firstnameinput"])){
		  $firstnameerror .= "Eesnimi on sisestamata! ";
	  }
	  if (empty($_POST["lastnameinput"])){
		$lastnameerror .= "Perekonnanimi on sisestamata!"; 
	  }
	  if (empty($_POST["genderinput"])){
		$gendererror .= "Sugu on sisestamata!"; 
	  }
	  if (empty($_POST["emailinput"])){
		$emailerror .= "Email on sisestamata!"; 
	  }
	  if (empty($_POST["passwordinput"])){
		$passworderror .= "Parool on sisestamata!"; 
	  }
	  if (empty($_POST["passwordsecondaryinput"])){
		$passwordsecondaryerror .= "Parooli kordus on sisestamata!";
	  
	  }
	  if (strlen($_POST["passwordinput"]) < 8){
		  $passwordshorterror .= "Parool on liiga lühike";
	  }
	  if (($_POST["passwordsecondaryinput"]) !== ($_POST["passwordinput"])){
		  $passwordnotmatcherror .= "Parool ei kattu";
	  }
	  if (!empty($_POST["firstnameinput"])){
		  $firstname .= $_POST["firstnameinput"];
	  }
	  
	  if (!empty($_POST["lastnameinput"])){
		  $lastname .= $_POST["lastnameinput"];
	  }
	  if (!empty($_POST["emailinput"])){
		  $email .= $_POST["emailinput"];
	  }
	  if (!empty($_POST["genderinput"])){
		  $gender .= $_POST["genderinput"];
	  }
		  
	  
	  /*<label for="gendermale">Mees</label>
	<input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo " checked";}?>>
	<span><?php echo $gendererror; ?></span>
	<br>
	<label for="genderfemale">Naine</label>
	<input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo " checked";}?>> */
	  
	  
	 /* if(empty ($firstnameerror) and empty ($lastnameerror) and empty ($gendererror) and empty ($passworderror) and empty ($passwordsecondaryerror) and empty ($passwordshorterror)and empty ($passwordnotmatcherror)){
		  saveaccount($_POST["firstnameinput"], $_POST["lastnameinput"], $_POST["genderinput"], $_POST["emailinput"], $_POST["passwordinput"], $_POST["passwordsecondaryinput"]);
	  }*/
  }
 
  
  require("header.php");
?>
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>See konkreetne leht on loodud veebiprogrammeerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <ul>
    <li><a href="home.php">Avaleht</a></li>
  </ul>
  
  <hr>
  
  
  <form method="POST">
	<label for="firstnameinput">Eesnimi</label>
	<input type="text" name="firstnameinput" id="firstnameinput" placeholder="Eesnimi" value="<?php echo $firstname; ?>">
	<span><?php echo $firstnameerror; ?></span>
	<br>
	<label for="lastnameinput">Perekonnanimi</label> 
	<input type="text" name="lastnameinput" id="lastnameinput" placeholder="Perekonnanimi" value="<?php echo $lastname; ?>">
	<span><?php echo $lastnameerror; ?></span>
	<br>
	<label for="genderinput">Sugu</label>
	<input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo " checked";}?>><label for="gendermale">Mees</label><input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo " checked";}?>><label for="genderfemale">Naine</label>
	<span><?php echo $gendererror; ?></span>
	<br>
	<label for="emailinput">Email</label> 
	<input type="email" name="emailinput" id="emailinput" placeholder="Email" value="<?php echo $email; ?>">
	<span><?php echo $firstnameerror; ?></span>
	<br>
	<label for="passwordinput">Parool</label> 
	<input type="password" name="passwordinput" id="passwordinput" placeholder="Parool">
	<span><?php echo $passworderror; ?></span>
	<span><?php echo $passwordshorterror; ?></span>
	<br>
	<label for="passwordsecondaryinput">Parooli kordus</label> 
	<input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput" placeholder="Parooli kordus">
	<span><?php echo $passwordsecondaryerror; ?></span>
	<span><?php echo $passwordnotmatcherror; ?></span>
	<br>
	<input type="submit" name="accountsubmit" value="Salvesta kasutaja info">
	
  
  
</body>
</html>
