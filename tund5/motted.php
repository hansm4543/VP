<?php
  // var_dump($_POST);
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
	
?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Mõttete kogum</title>
<head>
<body style="background-color:DodgerBlue;">
  <hr> 
  <p>Vajuta sõnale <a href="home.php">tagasi</a>, et minna tagasi avalehele.</p>
  <p>Siin on kirjas kõik kogutud mõtted.</p>
  
  <ul>
    <li><a href="home.php">Avaleht</a></li>
  </ul>

  <hr>
  <?php echo $ideahtml; ?>
  
</body>
</html>



