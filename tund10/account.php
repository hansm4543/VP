<?php
  //var_dump($_POST);
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");
  //require("fnc_account.php");
  
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  
  
  $username = "";
  
  //errorid
  $firstnameerror = "";
  $lastnameerror = "";
  $gendererror = "";
  $emailerror = "";
  $passworderror = "";
  $passwordsecondaryerror = "";
  $passwordshorterror = "";
  $passwordnotmatcherror = "";
/*  
  	$firstname= "";
	    $lastname = "";
		$gender = "";
		$birthdate = null;
		$birthday = null;
		$birthmonth = null;
		$birthyear = null;
		$email = "";
  */
  //Sisestuste jäädvustamine errori korral
  
  //Sisestuste jäädvustamine errori korral
  $firstname="";
  $lastname="";
  $gender="";
  $email="";
  
  $notice = "";
  
  

  //sünnipäeva valik
  $birthdate = null;
  $birthday = null;
  $birthmonth = null;
  $birthyear = null;
  
  $birthdateerror = null;
  $birthdayerror = null;
  $birthmontherror = null;
  $birthyearerror = null;
  
 
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
	  if(!empty($_POST["birthdayinput"])){
		  $birthday = intval($_POST["birthdayinput"]);
	  } else {
		  $birthdayerror = "Palun vali sünnikuupäev!";
	  }
	  if(!empty($_POST["birthmonthinput"])){
		  $birthmonth = intval($_POST["birthmonthinput"]);
	  } else{
		  $birthmontherror = "Palun vali sünnikuu!";
	  }
	  if(!empty($_POST["birthyearinput"])){
		  $birthyear = intval($_POST["birthyearinput"]);
	  } else{
		  $birthyearerror = "Palun vali aasta!";
	  }
	  
	  //kontrollime kuupäeva kehtivust
	  if(!empty($birthday) and !empty($birthmonth) and !empty($birthyear)){
		  if(checkdate($birthmonth, $birthday, $birthyear)){
			  $tempdate = new DateTime($birthyear ."-" .$birthmonth ."-" .$birthday);
			  $birthdate = $tempdate->format("Y-m-d");
		  } else {
			  $birthdateerror = "Kuupäev ei ole reaalne";
		  }
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
		  $passwordshorterror .= "Parool on liiga lühike!";
	  }
	  if (($_POST["passwordsecondaryinput"]) !== ($_POST["passwordinput"])){
		  $passwordnotmatcherror .= "Parool ei kattu";
	  }
	  if (!empty($_POST["firstnameinput"])){
		  $firstname .= test_input($_POST["firstnameinput"]);
	  }
	  
	  if (!empty($_POST["lastnameinput"])){
		  $lastname .= test_input($_POST["lastnameinput"]);
	  }
	  if (!empty($_POST["emailinput"])){
		  $email .= test_input($_POST["emailinput"]);
	  }
	  if (!empty($_POST["genderinput"])){
		  $gender .= intval($_POST["genderinput"]);
	  }
		  
	  if(empty ($firstnameerror) and empty ($lastnameerror) and empty ($gendererror) and empty ($birthdayerror) and empty ($birthmontherror) and empty ($birthyearerror) and empty ($birthdateerror) and empty ($emailerror) and empty ($passworderror) and empty ($passwordsecondaryerror) and empty ($passwordshorterror)and empty ($passwordnotmatcherror)){
		$result = signup($firstname, $lastname, $email, $gender, $birthdate, $_POST["passwordinput"]);
	  
		//$notice = "Kõik korras!";
		if($result == "ok"){
			$notice = "Kõik korras, kasutaja loodud!";
			$firstname= "";
			$lastname = "";
			$gender = "";
			$birthdate = null;
			$birthday = null;
			$birthmonth = null;
			$birthyear = null;
			$email = "";
		} else {
			$notice = "Tekkis tehniline tõrge: " .$result;
		}
	  }
		//echo $firstname .$lastname ." " .$email ." " .$gender ." " .$birthdate ." " .$_POST["passwordinput"];
		
		
	  
	  
	  
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
    <li><a href="page.php">Algleht</a></li>
  </ul>
  
  <hr>
  
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="firstnameinput">Eesnimi:</label>
	<input type="text" name="firstnameinput" id="firstnameinput" placeholder="Eesnimi" value="<?php echo $firstname; ?>">
	<span><?php echo $firstnameerror; ?></span>
	<br>
	<label for="lastnameinput">Perekonnanimi:</label> 
	<input type="text" name="lastnameinput" id="lastnameinput" placeholder="Perekonnanimi" value="<?php echo $lastname; ?>">
	<span><?php echo $lastnameerror; ?></span>
	<br>
	<label for="genderinput">Sugu:</label>
	<input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo " checked";}?>><label for="gendermale">Mees</label><input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo " checked";}?>><label for="genderfemale">Naine</label>
	<span><?php echo $gendererror; ?></span>
	<br>
	<br>
	
	<label for="birthdayinput">Sünnipäev: </label>
		  <?php
			echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
			echo '<option value="" selected disabled>päev</option>' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthday){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>
	  <label for="birthmonthinput">Sünnikuu: </label>
	  <?php
	    echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
		echo '<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthnameset[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label for="birthyearinput">Sünniaasta: </label>
	  <?php
	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <br>
	  <span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
	  <br>
	  <br>
	
	
	
	
	
	
	<label for="emailinput">Email:</label> 
	<input type="email" name="emailinput" id="emailinput" placeholder="Email" value="<?php echo $email; ?>">
	<span><?php echo $emailerror; ?></span>
	<br>
	<label for="passwordinput">Parool(min 8 märki):</label> 
	<input type="password" name="passwordinput" id="passwordinput" placeholder="Parool">
	<span><?php echo $passworderror; ?></span>
	<span><?php echo $passwordshorterror; ?></span>
	<br>
	<label for="passwordsecondaryinput">Parooli kordus:</label> 
	<input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput" placeholder="Parooli kordus">
	<span><?php echo $passwordsecondaryerror; ?></span>
	<span><?php echo $passwordnotmatcherror; ?></span>
	<br>
	<input type="submit" name="accountsubmit" value="Loo kasutaja"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
	</form>
	
  
  
</body>
</html>
