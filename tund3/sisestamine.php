<?php
  // var_dump($_POST);
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

?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Mõttete sisestamine</title>
<head>
<body style="background-color:Tomato;">
  <hr>
  <form method="POST">
    <label>Sisesta oma pähe tulnud mõte! </label>
    <input type ="text" name="ideainput" placeholder="Kirjuta siia mõte!">
	<input type="submit" name="ideasubmit" value="Saada mõte ära!">
  
  </form>
  
  <p>Vajuta sõnale <a href="home.php">tagasi</a>, et minna tagasi avalehele.</p>
 
</body>
</html>