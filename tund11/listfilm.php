<?php
  //var_dump($_POST);
  require("usersession.php");
  require("../../../config.php");
  require("fnc_films.php");
  
  
  $filmhtml = readfilms ();

  
  /* <?php echo readfilms(); ?>  VÕIB PANNA ALLA KOODI LÕPPI FILMHTML ASEMEL*/
  
  require("header.php");
?>

<body>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>

  <hr>

  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="home.php">Avaleht</a></li>
  </ul>
  
  <hr>
  <?php echo $filmhtml; ?>
  
</body>
</html>
