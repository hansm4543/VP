<?php
 require("usersession.php");
 require("../../../config.php");
 require("fnc_personmovies.php");
 require("fnc_common.php");
 $companyerror ="";
 $addresserror ="";
 $notice = "";
 $selectedcompany="";
 
 $company = "";
 $address = "";
 //$database = "if20_markus_ve_1";
 
 
 // company
 
 if(isset($_POST["companysubmit"])){
	  
	  if (!empty($_POST["companyinput"])){
		$company = test_input($_POST["companyinput"]);
	  } else {
		  $companyerror = "Sisesta stuudio!";
	  }
	  
	  if(!empty($_POST["addressinput"])){
		  $address = test_input($_POST["addressinput"]);
	  } else {
		  $addresserror = "Sisestage aadress!";
	  }
	  $selectedcompany = ($_POST["companyinput"]);
	  if(empty($companyerror)and empty($addresserror)){
		$result = savecompany($selectedcompany, $address);
		if($result == "ok"){
			$notice = "stuudio lisatud!";
			$company="";
			$address= "";
		} else {
			$notice = "Tekkis tehniline tõrge: " .$result;
		}
	  }
   }
 
 require("header.php");
 ?>
 <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 <h1>stuudio sisestamine</h1>   
 <a href="home.php">Tagasi koju</a>
 <hr>
 <body>
 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
 <label for="companyinput">stuudio:</label><br>
 <input name="companyinput" id="companyinput" type="text" value="<?php echo $company; ?>"><span><?php echo $companyerror; ?></span>
 <br>
 <label for="addressinput">stuudio address:</label>
 <br>
 <textarea rows="10" cols="80" name="addressinput" id="addressinput" placeholder="riik, linn, tänav või midaki siukest"><?php echo $address; ?></textarea><span><?php echo $addresserror; ?></span>
 <br>
 <input name="companysubmit" type="submit" value="Salvesta stuudio info"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
 </form>
 <p><a href="?logout=1">Logi välja</a>!</p>
 </html>
 
 
 

   
  