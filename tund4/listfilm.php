<?php
  //var_dump($_POST);
  require("../../../config.php");
  require("fnc_films.php");
  
  
  $filmhtml = readfilms ();

  $username = "Hansm4543";
  
  /* <?php echo readfilms(); ?>  VÕIB PANNA ALLA KOODI LÕPPI FILMHTML ASEMEL*/
  
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
  <?php echo $filmhtml; ?>
  
</body>
</html>
