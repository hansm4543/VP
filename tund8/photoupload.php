<?php
  require("usersession.php");
  require("../../../config.php");
  
  

  
  //kui klikiti submit siis, photoupload_orig
  $inputerror = "";
  $filetype = null;
  $filesizelimit = 1048576;
  if(isset($_POST["photosubmit"])){
	//var_dump($_POST);
	//var_dump($_FILES);
	//kas on pilt ja mis tüüpi
	$check = getimagesize ($_FILES["photoinput"]["tmp_name"]);
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
	}else{
		$inputerror = "Valitud fail ei ole pilt! ";
	}
	//kas on sobiva faili suurusega
	if(empty ($inputerror) and $_FILES["photoinput"]["size"] < $filesizelimit){
		$inputerror = "Liiga suur fail! "; 
	}
	//ega fail äkki olemas pole
	if(file_exists("../photoupload_orig/" .$_FILES["photoinput"]["name"])){
		$inputerror = "Selle nimega fail on juba olemas! ";
	}
	
	
	//kui vigu pole...
	if (empty ($inputerror)){
		move_uploaded_file($_FILES["photoinput"]["tmp_name"], "../photoupload_orig/" .$_FILES["photoinput"]["name"]);
	}
	
  }
 
  
  require("header.php");
?>

<body>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>

  
  <ul>
    <li><a href="home.php">Avaleht</a></li>
	<li><a href="?logout=1">Logi Välja</a></li>
  </ul>
  
  <hr>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data"> 
	
	<label for="photoinput">Vali Pildifail</label>
	<input id="photoinput" name="photoinput" type="file" required>
	
	<br>
	<label for="altinput">Lisa pildi lühikirjeldus (alternatiivtekst)</label>
	<input id="altinput" name="altinput" type="text">
	<br>
	<label>Privaatsustase</label>
	
	<br>
	<input id="privinput1" name="privinput" type="radio" value="1">
	<label for="privinput1">Privaatne (ainult ise näen)</label>
	<input id="privinput2" name="privinput" type="radio" value="2">
	<label for="privinput2">Klubi liikmetele (sisseloginud kasutajad näevad)</label>
	<input id="privinput3" name="privinput" type="radio" value="3">
	<label for="privinput3">Avalik (kõik näevad)</label><br>
	
	<br>
	<input type="submit" name="photosubmit" value="Lae foto üles">
	
	
	
  </form>
  
  <p> <?php echo $inputerror; ?></p>
  
</body>
</html>














