<?php
  require("usersession.php");
  //require("fnc_photo.php");
  require("fnc_common.php");
  require("../../../config.php");
  require("fnc_news.php");
  //require("../../../config_photo.php");
  //require("classes/Photoupload_class.php");
  
  $tolink = "\t" .'<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>' ."\n";
  $tolink .= "\t" .'<script>tinymce.init({selector:"textarea#newsinput", plugins: "link", menubar: "edit",});</script>' ."\n";
  
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
	}
	if(empty($inputerror)) {
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], "if20_hans_li_1");
		$stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content) VALUES (?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("iss", $_SESSION["userid"], $newstitle, $news);
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
		
	<input type="submit" id="newssubmit" name="newssubmit" value="Salvesta uudis">
  </form>
  <p id="notice">
  <?php
	echo $inputerror;
	echo $notice;
  ?>
  </p>
  
</body>
</html>