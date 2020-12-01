<?php

  require("usersession.php");
  require ("../../../config.php");
  $database = "if20_hans_li_1";
	
	//uudise lugemine
   $newshtml = "";
   $idfromdb = "";
  $id = intval($_GET['news']);
  //$id = $_GET['id'];
  $temphtml = "";
  $newshtml = "";
   
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], "if20_hans_li_1");
	$stmt = $conn->prepare("SELECT title, content, expire, filename FROM vpnews LEFT JOIN vpnewsphotos ON vpnews.vpnewsphotos_id = vpnewsphotos.vpnewsphotos_id WHERE vpnews_id = ?");
	echo $conn->error;
	$stmt->bind_param(("i"), $id);
	$stmt->bind_result($newstitlefromdb, $newscontentfromdb, $expiredate, $filename);
	$stmt->execute();
	while($stmt->fetch()) {
		if($expiredate == null and $filename != null) {
			$newshtml .= '<img src="../photoupload_normal/' .$filename .'">' ."\n";

		} elseif($expiredate == null and $filename == null) {
			$newshtml = "";

		} elseif($expiredate != null and $filename == null) {
			$newshtml = "";

		} elseif($expiredate != null and $filename != null) {
			$newshtml .= '<img src="../photoupload_normal/' .$filename .'">' ."\n";

		}else{
			$newshtml = "";
		}
	}
	if(!empty($newshtml)) {
		$newshtml = "<div> \n" .$newshtml ."\n  </div> \n";
	} else {
		$newshtml = "<p>Kahjuks galeriipilte ei leitud sellele uudisele!</p> \n";
	}
	$stmt->close();
	$conn->close();
	
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
	
	
  require("header.php");
	
?>

<body>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>
  
  
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="home.php">Avaleht</a></li>
	<li><a href="addnews.php">Uudiste lisamine</a></li>
  </ul>
  
  
  
  
  <hr>
  <?php echo $id; ?>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <label for="newstitleinput">Sisesta uudise pealkiri</label>
	<input id="newstitleinput" name="newstitleinput" type="text" value="<?php echo $newstitlefromdb; ?>" required>
	<br>
	<label for="newsinput">Kirjuta uudis</label>
	<textarea id="newsinput" name="newsinput"><?php echo $newscontentfromdb; ?></textarea>
	
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
	<?php echo $newshtml; ?>
	<label for="photoinput">Lisa uudisele uus pilt, kui soovid: </label>
	<input id="photoinput" name="photoinput" type="file">
	
	<br>
	<br>
		
	<input type="submit" id="newssubmit" name="newssubmit" value="Salvesta uudis">
  </form>
  <p id="notice">
  <?php