<?php
  // var_dump($_POST);
  require("usersession.php");
  require ("../../../config.php");
  $database = "if20_hans_li_1";
  //kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi
  
  if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  //statement valmistan ette sql käsu
  $stmt = $conn->prepare("INSERT INTO myideas(idea) VALUES(?)");
  echo $conn->error;
  //seome käsuga päris andmed
  // i- integer, d - decimal, s - string
  $stmt->bind_param("s", $_POST["ideainput"]);
  $stmt->execute();
  echo $stmt->error;
  $stmt->close();
  $conn->close();
  }
  require("header.php");
?>

<body>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>

  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="page.php">Algleht</a></li>
  </ul>
  
  <hr>
  <form method="POST">
    <label>Sisesta oma pähe tulnud mõte! </label>
    <input type ="text" name="ideainput" placeholder="Kirjuta siia mõte!">
	<input type="submit" name="ideasubmit" value="Saada mõte ära!">
  
  </form>
  
  <p>Vajuta sõnale <a href="home.php">tagasi</a>, et minna tagasi avalehele.</p>
 
</body>
</html>