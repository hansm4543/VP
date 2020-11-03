<?php
  // var_dump($_POST);
  require("usersession.php");
  require ("../../../config.php");
  $database = "if20_hans_li_1";
  //kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi

  //loen lehele kõik olemas olevad mõtteid
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  $stmt = $conn->prepare("SELECT idea FROM myideas");
  echo $conn->error;
  //seome tulemuse muutujaga
  $stmt->bind_result($ideafromdb);
  $stmt->execute();
  
  $ideahtml = "";
  while($stmt->fetch()){
	  $ideahtml .= "<p>" .$ideafromdb ."</p>";
  }
  $stmt->close();
  $conn->close();
	
  require("header.php");
?>

<body>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>

  <p> <a href="?logout=1">Logi Välja</a></p>
  <hr>
  <p>Siin on kirjas kõik kogutud mõtted.</p>
  
  <ul>
    <li><a href="home.php">Avaleht</a></li>
  </ul>

  <hr>
  <?php echo $ideahtml; ?>
  
</body>
</html>



