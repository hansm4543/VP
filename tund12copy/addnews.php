<?php
  require("usersession.php");
  //require("fnc_photo.php");
  require("fnc_common.php");
  require("../../../config.php");
  require("fnc_news.php");
  
  //photo jaoks vajalik
  require("../../../config_photo.php"); 
  require("fnc_photo.php");
  require("classes/Photoupload_class.php");
  
  $tolink ='<script src="javascript/checkfilesize.js" defer></script>' ."\n";
  
  $inputerror = "";
  $notice = null;
  $filetype = null;
  $filesizelimit = 2097152; //1048576 2097152
  $photouploaddir_orig = "../photoupload_orig/";
  $photouploaddir_normal = "../photoupload_normal/";
  $photouploaddir_thumb = "../photoupload_thumb/";
  $watermark = "../img/vp_logo_w100_overlay.png";
  $filenameprefix = "vp_";
  $filename = null;
  $photomaxwidth = 600;
  $photomaxheight = 400;
  $thumbsize = 100;
  $photoFileTypes = ["image/jpeg", "image/png", "image/gif"];
  //require("../../../config_photo.php");
  //require("classes/Photoupload_class.php");
  
  
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  
  
  //kuupäeva valik sünnipäeva nimedega
  $birthdate = null;
  $birthday = null;
  $birthmonth = null;
  $birthyear = null;
  
  $birthdateerror = null;
  $birthdayerror = null;
  $birthmontherror = null;
  $birthyearerror = null;
  
  
  $tolink = "\t" .'<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>' ."\n";
  $tolink .= "\t" .'<script>tinymce.init({selector:"textarea#newsinput", plugins: "link", menubar: "edit",});</script>' ."\n";
  
  $picturenotice = "";
  $pictureerror = "";
  $result = "";
  
  $inputerror = "";
  $notice = null;
  $news = null;
  $newstitle = null;
  //$vpuserid = $_SESSION["userid"];
  
  //kui klikiti submit, siis ...
  if(isset($_POST["newssubmit"])){
	if(strlen($_POST["newstitleinput"])==0){
		$inputerror = "Uudise pealkiri on puudu! ";
	}else{
		$newstitle = test_input($_POST["newstitleinput"]);
	}
	if(strlen($_POST["newsinput"])==0){
		$inputerror .= " Uudise sisu on puudu! ";
	}else{
		$news = test_input($_POST["newsinput"]);
		//htmlspecialchars teisendab html noolsulud.
		//nende tagasisaamiseks htmlspecialchars_decode(uudis)
	
	if(!empty($_POST["birthdayinput"])){
		$birthday = intval($_POST["birthdayinput"]);
	} else {
		$birthdayerror = "Palun vali kuupäev!";
	}
	if(!empty($_POST["birthmonthinput"])){
		$birthmonth = intval($_POST["birthmonthinput"]);
	} else{
		$birthmontherror = "Palun vali kuu!";
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
	  
	  
		
	}
	
	//PILDI LAADIMINE
	if(!empty($_FILES["photoinput"]["name"]) and !empty($_FILES["photoinput"]["type"]) and !empty($_FILES["photoinput"]["size"])) {
		$check = getimagesize($_FILES["photoinput"]["tmp_name"]);
		if($check !== false){
			//var_dump($check);
			if($check["mime"] == "image/jpeg"){
				$filetype = "jpg";
			}
			if($check["mime"] == "image/png"){
				$filetype = "png";
			}
			if($check["mime"] == "image/gif"){
				$filetype = "gif";
			}
		} else {
			$pictureerror = "Valitud fail ei ole pilt! ";
		}

		if(empty($pictureerror) and $_FILES["photoinput"]["size"] > $filesizelimit){
			$pictureerror = "Liiga suur fail!";
		}

		
		//loome uue failinime
		$timestamp = microtime(1) * 10000;
		$filename = $filenameprefix .$timestamp ."." .$filetype;
		
		//ega fail äkki olemas pole
		if(file_exists($photouploaddir_orig .$filename)){
			$pictureerror .= " Selle nimega fail on juba olemas!";
		}
		
		//kui vigu pole ...
		if(empty($pictureerror)){
			//võtame classi kasutusele
			$myphoto = new Photoupload($_FILES["photoinput"], $filetype);
			
			//teeme pildi väiksemaks
			$myphoto->resizePhoto($photomaxwidth, $photomaxheight, true);
			//lisame vesimärgi
			$myphoto->addWatermark($watermark);
			
			//salvestame vähendatud pildi
			
			$result = $myphoto->saveimage($photouploaddir_normal .$filename);
				if($result == 1){
					$picturenotice .= "Vähendatud pildi salvestamine õnnestus!";
				} else {
					$pictureerror .= "Vähendatud pildi salvestamisel tekkis tõrge!";
				}
			
			
			//salvestame originaalpildi
			$myphoto->moveorigimage($pictureerror, $filename, $photouploaddir_orig);
			
			//eemaldan klassi
			unset($myphoto);
			
			if(empty($pictureerror)){
				$result = storenewsPhotoData($filename);
				if($result == 1){
					$picturenotice .= " Pildi info lisati andmebaasi!";
				} else {
					$pictureerror .= "Pildi info andmebaasi salvestamisel tekkis tõrge!";
				}
			} else {
				$pictureerror .= " Tekkinud vigade tõttu pildi andmeid ei salvestatud!";
			}
			
		}
	}
		/*
		if(empty($inputerror) and empty($birthdateerror) and empty($birthyearerror) and empty ($birthmontherror) and empty($birthdateerror) and empty($pictureerror)) {
			//võtame pildi id
			$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], "if20_hans_li_1");
			$stmt = $conn->prepare("SELECT vpnewsphotos_id FROM vpnewsphotos");
			echo $conn->error;
			$stmt->bind_result($idfromdb);
			$stmt->execute();
			while($stmt->fetch()){
				$pildiid = $idfromdb;
			$stmt->close();
			$conn->close();
			
			//ühendame pildi uudisega ja salvestame uudise
			
			$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], "if20_hans_li_1");
			$stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content, expire, vpnewsphotos_id) VALUES (?, ?, ?, ?, ?)");
			echo $conn->error;
			$stmt->bind_param("isssi", $_SESSION["userid"], $newstitle, $news, $birthdate, $pildiid);
			echo $news;
			echo $_POST["newsinput"];
			if($stmt->execute()){
				$notice = "Uudis on salvestatud!";
			} else {
				$notice = "Midagi läks valesti.";
			}
			$stmt->close();
			$conn->close();
		}
	}
	*/
	
	if(empty($inputerror) and empty($birthdateerror) and empty($birthyearerror) and empty ($birthmontherror) and empty($birthdateerror) and empty($pictureerror)) {
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], "if20_hans_li_1");
		if(empty($result)) {
			$stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content, expire) VALUES (?, ?, ?, ?)");
			echo $conn->error;
			$stmt->bind_param("isss", $_SESSION["userid"], $newstitle, $news, $$birthdate);
			if($stmt->execute()){
				$notice = "Uudis on salvestatud!";
			} else {
				$notice = "Uudise salvestamisel läks midagi valesti.";
			}
			$stmt->close();
		} else {
			$stmt = $conn->prepare("SELECT MAX(vpnewsphotos_id) FROM vpnewsphotos");
			echo $conn->error;
			$stmt->bind_result($idfromdb);
			$stmt->execute();
			$stmt->fetch();
			$stmt->close();
			
			$stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content, expire, vpnewsphotos_id) VALUES (?, ?, ?, ?, ?)");
			echo $conn->error;
			$stmt->bind_param("isssi", $_SESSION["userid"], $newstitle, $news, $$birthdate, $idfromdb);
			if($stmt->execute()){
				$notice = "Uudis on salvestatud!";
			} else {
				$notice = "Uudise salvestamisel läks midagi valesti.";
			}
			$stmt->close();
		}
		$conn->close();
	}
	
	
  }
  
  require("header.php");
?>
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>See konkreetne leht on loodud veebiprogrammeerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <ul>
    <li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="home.php">Avaleht</a></li>
  </ul>
  
  <hr>
  
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <label for="newstitleinput">Sisesta uudise pealkiri</label>
	<input id="newstitleinput" name="newstitleinput" type="text" value="<?php echo $newstitle; ?>" required>
	<br>
	<label for="newsinput">Kirjuta uudis</label>
	<textarea id="newsinput" name="newsinput"><?php echo $news; ?></textarea>
	
	<br>
	<p>Aegumistähtaeg:</p>
		<label for="birthdayinput">Päev: </label>
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
	  <label for="birthmonthinput">Kuu: </label>
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
	  <label for="birthyearinput">Aasta: </label>
	  <?php
	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") + 5; $i >= date("Y") - 1; $i --){
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
	<label for="photoinput">Lisa uudisele pilt, kui soovid: </label>
	<input id="photoinput" name="photoinput" type="file">
	
	<br>
	<br>
		
	<input type="submit" id="newssubmit" name="newssubmit" value="Salvesta uudis">
  </form>
  <p id="notice">
  <?php
	echo $inputerror;
	echo $notice;
	echo $picturenotice;
	echo $pictureerror;
  ?>
  </p>
  
</body>
</html>